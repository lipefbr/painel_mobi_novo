<?php
//TODO ALLAN - Alterações e correções no sistema de pesquisa

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use Setting;
use Auth;
use Exception;
use Carbon\Carbon;
use App\Helpers\Helper;
use DB;
use App\User;
use App\Fleet;
use App\Dispatcher;
use App\Provider;
use App\UserRequests;
use App\RequestFilter;
use App\ProviderService;
use App\AdminFleet;
use App\Services\ServiceTypes;
use App\ServiceType;


class DispatcherController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        if(Auth::guard('admin')->user()){
            $this->middleware('permission:dispatcher-panel', ['only' => ['index']]);
            $this->middleware('permission:dispatcher-panel-add', ['only' => ['store']]);
        }    
    }

    
    /**
     * Dispatcher Panel.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()){
            return view('admin.dispatcher');
        }

        return redirect()->back();
    }

    /**
     * Display a listing of the active trips in the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function trips(Request $request)
    {
        $user = Auth::user();
        
        $serviceTypesAdminFleets = [];
        $Trips;
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            $Trips = UserRequests::with('user', 'provider')
                    ->orderBy('id','desc');
        } else {
            if ($user->isFleetManage()) {
                $serviceTypesAdminFleets = ServiceType::whereIn('fleet_id', Fleet::where('admin_id', $user->id)->pluck('id'))->pluck('id');
            } else {
                $serviceTypesAdminFleets = ServiceType::whereIn('fleet_id', AdminFleet::where('admin_id', $user->id)->pluck('fleet_id'))->pluck('id');
            }

            $Trips = UserRequests::whereIn('service_type_id', $serviceTypesAdminFleets)->with('user', 'provider')
                    ->orderBy('id','desc');
        }


        if($request->type == "SEARCHING"){
            $Trips = $Trips->where('status',$request->type);
        }else if($request->type == "CANCELLED"){
            $Trips = $Trips->where('status',$request->type);
        }else if($request->type == "ASSIGNED"){
            $Trips = $Trips->whereNotIn('status',['SEARCHING','SCHEDULED','CANCELLED','COMPLETED']);
        }
        
        $Trips =  $Trips->paginate(10);

        foreach ($Trips as $key => $trip) {
          $Trips[$key]['updated_at_pt_br'] = date('d/m/Y H:i:s' , strtotime($trip->updated_at));
        }

        return $Trips;
    }

    /**
     * Display a listing of the users in the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $Users = new User;

        if($request->has('mobile')) {
            $Users->where('mobile', 'like', $request->mobile."%");
        }

        if($request->has('first_name')) {
            $Users->where('first_name', 'like', $request->first_name."%");
        }

        if($request->has('last_name')) {
            $Users->where('last_name', 'like', $request->last_name."%");
        }

        if($request->has('email')) {
            $Users->where('email', 'like', $request->email."%");
        }

        return $Users->paginate(25);
    }

    /**
     * Display a listing of the active trips in the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function providers(Request $request)
    {
        $Providers = new Provider;

        if($request->has('latitude') && $request->has('longitude')) {
            $ActiveProviders = ProviderService::AvailableServiceProvider($request->service_type)
                    ->get()
                    ->pluck('provider_id');

            $distance =  setting('provider_search_radius', config('constants.provider_search_radius', '10'));
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $Providers = Provider::whereIn('id', $ActiveProviders)
                ->where('status', 'approved')
                ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                ->with('service', 'service.service_type')
                ->get();

            return $Providers;
        }

        return $Providers;
    }

    /**
     * Create manual request.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign($request_id, $provider_id)
    {
        try {
            $Request = UserRequests::findOrFail($request_id);
            $Provider = Provider::findOrFail($provider_id);

            $Request->status = 'SEARCHING';
            $Request->current_provider_id = $Provider->id;
            $Request->assigned_at = Carbon::now();
            $Request->save();

            ProviderService::where('provider_id',$Request->provider_id)->update(['status' =>'riding']);

            (new SendPushNotification)->IncomingRequest($Request->current_provider_id);

            try {
                RequestFilter::where('request_id', $Request->id)
                    ->where('provider_id', $Provider->id)
                    ->firstOrFail();
            } catch (Exception $e) {
                $Filter = new RequestFilter;
                $Filter->request_id = $Request->id;
                $Filter->provider_id = $Provider->id; 
                $Filter->status = 0;
                $Filter->save();
            }

            if(Auth::guard('admin')->user()){
                return redirect()
                        ->route('admin.dispatcher.index')
                        ->with('flash_success', trans('admin.dispatcher_msgs.request_assigned'));

            }

        } catch (Exception $e) {
            if(Auth::guard('admin')->user()){
                return redirect()->route('admin.dispatcher.index')->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }


    /**
     * Create manual request.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {

        $this->validate($request, [
                's_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                //'payment_mode' => 'required|numeric|exists:payment_mode,id',
                'distance' => 'required|numeric',
            ]);

        try {
            $User = User::where('mobile', $request->mobile)->firstOrFail();
        } catch (Exception $e) {
            try {
                $User = User::where('email', $request->email)->firstOrFail();
            } catch (Exception $e) {

                if ($request->email == null ||  $request->email == '' ||  strlen($request->email) < 5 ) {
                    $latestUser = User::orderBy('id', 'desc')->first();

                    $User = User::create([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' =>   ($latestUser != null) ? $latestUser->id . "_dispatcheruser@instant.com" : "1_dispatcheruser@instant.com",
                        'mobile' => $request->mobile,
                        'password' => bcrypt($request->mobile),
                        'payment_mode' => 'CASH',
                        'user_type' => 'DISPATCHER',
                    ]);
                } else {
                    $User = User::create([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'password' => bcrypt($request->mobile),
                        'payment_mode' => 'CASH'
                    ]);  
                }

                
            }
        }

        if($request->has('schedule_time')){
            try {
                $CheckScheduling = UserRequests::where('status', 'SCHEDULED')
                        ->where('user_id', $User->id)
                        ->where('schedule_at', '>', strtotime($request->schedule_time." - 1 hour"))
                        ->where('schedule_at', '<', strtotime($request->schedule_time." + 1 hour"))
                        ->firstOrFail();
                
                if($request->ajax() || $request->resend) {
                    return response()->json(['error' => trans('api.ride.request_scheduled')], 500);
                } else {
                    return redirect('dashboard')->with('flash_error', trans('api.ride.request_scheduled'));
                }

            } catch (Exception $e) {
                // Do Nothing
            }
        }

        try{
            
            //TODO ALLAN - Alterações débito na máquina e voucher
            //Verifica se os tipos de pagamentos estão disponíveis
            if( setting('voucher', config('constants.voucher', 1)) != 'on'&& $request->payment_mode == 'VOUCHER'){
                return response()->json(['message' => "Pagamento com Voucher desativado! Vá até a configuração de pagamento para ativar."]);
            }elseif( setting('cash', config('constants.cash', 1)) != 'on' && $request->payment_mode == 'CASH'){
                return response()->json(['message' => "Pagamento em Dinheiro desativado! Vá até a configuração de pagamento para ativar."]);
            }elseif( setting('debit_machine', config('constants.debit_machine', 1)) != 'on' && $request->payment_mode == 'DEBIT_MACHINE'){
                return response()->json(['message' => "Pagamento com Débito na Máquina desativado! Vá até a configuração de pagamento para ativar."]);
            }elseif( setting('cartao_credito', config('constants.cartao_credito', 1)) != 'on' && $request->payment_mode == 'CARTAO_CREDITO'){
                return response()->json(['message' => "Pagamento com Cartão de crédito! Vá até a configuração de pagamento para ativar."]);
            }elseif( setting('card', config('constants.card', 1)) != 'on' && $request->payment_mode == 'CARD'){
                return response()->json(['message' => "Pagamento com Cartão de crédito! Vá até a configuração de pagamento para ativar."]);
            }
            
            $ActiveProviders = ProviderService::AvailableServiceProvider($request->service_type)
                    ->get()
                    ->pluck('provider_id');

            $distance = setting('provider_search_radius', config('constants.provider_search_radius', '10'));
            $latitude = $request->s_latitude;
            $longitude = $request->s_longitude;
            $service_type = $request->service_type;

            $Providers = Provider::with('service')
            ->select(DB::Raw("round((6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),3) AS distance"), 'id')
            ->where('status', 'approved')
            ->whereRaw("round((6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),3) <= $distance")
            ->whereHas('service', function($query) use ($service_type) {
                $query->where('status', 'active');
                $query->where('service_type_id', $service_type);
            })
            ->orderBy('distance', 'asc')
            ->get();

            // List Providers who are currently busy and add them to the filter list.

            if(count($Providers) == 0) {
                if($request->ajax() || $request->resend) {
                    // Push Notification to User
                    return response()->json(['message' => trans('api.ride.no_providers_found')]); 
                } else {
                    return back()->with('flash_success', trans('api.ride.no_providers_found'));
                }
            }

            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".setting('map_key', config('constants.map_key'));

            $json = curl($details);

            $details = json_decode($json, TRUE);

            $route_key = $details['routes'][0]['overview_polyline']['points'];

            $UserRequest = new UserRequests;
            $UserRequest->booking_id = Helper::generate_booking_id();
            $UserRequest->user_id = $User->id;
            $UserRequest->current_provider_id = 0;
            $UserRequest->service_type_id = $request->service_type;
            $UserRequest->payment_mode = 'CASH';//$request->payment_mode;
            $UserRequest->promocode_id = 0;
            $UserRequest->status = 'SEARCHING';
            
            //TODO ALLAN - Alterações débito na máquina e voucher
            //$UserRequest->os_id = ( $request->os_id ? $request->os_id : null );
            //$UserRequest->comments = ( $request->comments ? $request->comments : null );
            
            //Calcula valor estimado da tarifa
            try {
                $response = new ServiceTypes();

                $responsedata = $response->calculateFare($request->all(), 1);

                $UserRequest->estimated_fare = $responsedata['data']['estimated_fare'];
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            $UserRequest->s_address = $request->s_address ? : "";
            $UserRequest->s_latitude = $request->s_latitude;
            $UserRequest->s_longitude = $request->s_longitude;

            $UserRequest->d_address = $request->d_address ? : "";
            $UserRequest->d_latitude = $request->d_latitude;
            $UserRequest->d_longitude = $request->d_longitude;
            $UserRequest->route_key = $route_key;

            $UserRequest->distance = round($request->distance);

            if($request->has('provider_auto_assign')) {
                $UserRequest->assigned_at = Carbon::now();
            }

            $UserRequest->use_wallet = 0;
            $UserRequest->surge = 0;        // Surge is not necessary while adding a manual dispatch

            if($request->has('schedule_time')) {
                $UserRequest->schedule_at = Carbon::parse($request->schedule_time);
            }

            $UserRequest->save();

            if($request->has('provider_auto_assign')) {
//                $Providers[0]->service()->update(['status' => 'riding']);
                
                if ((setting('broadcast_request', config('constants.broadcast_request', 0)) != 'on')) {
                    $UserRequest->current_provider_id = $Providers[0]->id;
                } else {
                    $UserRequest->current_provider_id = 0;
                }

                $UserRequest->save();

                Log::info('New Dispatch : ' . $UserRequest->id);
                Log::info('Assigned Provider : ' . $UserRequest->current_provider_id);

                foreach ($Providers as $key => $Provider) {

                    if (setting('broadcast_request', config('constants.broadcast_request', 0)) == 'on') {
                        (new SendPushNotification)->IncomingRequest($Provider->id);
                    }

                    $Filter = new RequestFilter;
                    // Send push notifications to the first provider
                    // incoming request push to provider

                    $Filter->request_id = $UserRequest->id;
                    $Filter->provider_id = $Provider->id;
                    $Filter->save();
                }

                $UserRequest->provider_auto_assign = true;
            }

            return $UserRequest;

        } catch (Exception $e) {
            if($request->ajax() || $request->resend) {
                return response()->json(['error' => trans('api.something_went_wrong'), 'message' => $e], 500);
            }else{
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancel(Request $request) {

        $this->validate($request, [
            'request_id' => 'required|numeric|exists:user_requests,id',
        ]);

        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);

            if($UserRequest->status == 'CANCELLED')
            {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_cancelled')], 500); 
                }else{
                    return back()->with('flash_error', trans('api.ride.already_cancelled'));
                }
            }

            if(in_array($UserRequest->status, ['SEARCHING','STARTED','ARRIVED','SCHEDULED'])) {
                
                $UserRequest->status = 'CANCELLED';
                $UserRequest->cancel_reason = "Cancelado pelo administrador";
                $UserRequest->cancelled_by = 'NONE';
                $UserRequest->save();

                RequestFilter::where('request_id', $UserRequest->id)->delete();

                if($UserRequest->status != 'SCHEDULED'){

                    if($UserRequest->provider_id != 0){

                        ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' => 'active']);

                    }
                }

                 // Send Push Notification to User
                (new SendPushNotification)->UserCancellRide($UserRequest);
                (new SendPushNotification)->ProviderCancellRide($UserRequest);

                if($request->ajax()) {
                    return response()->json(['message' => trans('api.ride.ride_cancelled')]); 
                }else{
                    return back()->with('flash_success', trans('api.ride.ride_cancelled'));
                }

            } else {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_onride')], 500); 
                }else{
                    return back()->with('flash_error', trans('api.ride.already_onride'));
                }
            }
        }

        catch (ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }else{
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }

    }


    public function resend(Request $request){


        $UserRequest = UserRequests::findOrFail($request->request_id);
        $request = new Request([
            's_latitude'            => $UserRequest->s_latitude,
            's_longitude'           => $UserRequest->s_longitude,
            'd_latitude'            => $UserRequest->d_latitude,
            'd_longitude'           => $UserRequest->d_longitude,
            's_address'             => $UserRequest->s_address,
            'd_address'             => $UserRequest->d_address,
            'service_type'          => $UserRequest->service_type_id,
            'email'                 => $UserRequest->user->email,
            'provider_auto_assign'  => true,
            'distance'              => $UserRequest->distance,
            'resend'                => true
        ]);

        return $this->store($request);

    }
}
