<?php

namespace App\Http\Controllers\ProviderResources;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Controllers\Controller;

use Auth;
use Setting;
use Storage;
use Exception;
use QrCode;
use App\Helpers\Helper;

use Carbon\Carbon;

use App\Provider;

use App\ProviderProfile;
use App\UserRequests;
use App\ProviderService;
use App\Fleet;
use App\FleetCities;
use App\RequestFilter;
use App\Document;
use App\Reason;
use App\Http\Controllers\SendPushNotification;
use App\Http\Controllers\ProviderResources\DocumentController;
use App\Http\Controllers\Resource\ReferralResource;

class ProfileController extends Controller
{
    /**
     * Create a new user instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('provider.api', ['except' => ['show', 'store', 'available', 'location_edit', 'location_update','stripe', 'verifyCredentials']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {



            Auth::user()->service = ProviderService::where('provider_id',Auth::user()->id)
                                            ->with('service_type')
                                            ->first();
            Auth::user()->fleet = Fleet::find(Auth::user()->fleet);
            Auth::user()->currency = setting('currency', config('constants.currency', '$'));
            Auth::user()->sos = setting('sos_number', config('constants.sos_number', '911'));
            Auth::user()->measurement = setting('distance', config('constants.distance', 'Kms'));
            Auth::user()->profile = ProviderProfile::where('provider_id',Auth::user()->id)
                                            ->first();

            $align = '';

            if(Auth::user()->profile != null) {
                app()->setLocale(Auth::user()->profile->language);
                $align = (Auth::user()->profile->language == 'ar') ? 'text-align: right' : '';
            }

            Auth::user()->cash =(int) setting('cash', config('constants.cash')) == 'on' ? 1 : 0;
            Auth::user()->card =(int) setting('card', config('constants.card')) == 'on' ? 1 : 0;
            
            //TODO ALLAN - Altera????es d??bito na m??quina e voucher
            Auth::user()->debit_machine =(int) setting('debit_machine', config('constants.debit_machine')) == 'on' ? 1 : 0;
            Auth::user()->voucher =(int) setting('voucher', config('constants.voucher')) == 'on' ? 1 : 0;

            Auth::user()->stripe_secret_key =  setting('stripe_secret_key', config('constants.stripe_secret_key'));
            Auth::user()->stripe_publishable_key =  setting('stripe_publishable_key', config('constants.stripe_publishable_key'));
            Auth::user()->stripe_currency =  setting('stripe_currency', config('constants.stripe_currency'));


            Auth::user()->referral_count = setting('referral_count', config('constants.referral_count', '0'));
            Auth::user()->referral_amount = setting('referral_amount', config('constants.referral_amount', '0'));
            Auth::user()->referral_text = trans('api.provider.invite_friends');
            Auth::user()->referral_total_count = (new ReferralResource)->get_referral('provider', Auth::user()->id)[0]->total_count;
            Auth::user()->referral_total_amount = (new ReferralResource)->get_referral('provider', Auth::user()->id)[0]->total_amount;
            Auth::user()->referral_total_text = "<p style='font-size:16px; color: #000; $align'>".trans('api.provider.referral_amount').": ".(new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_amount."<br>".trans('api.provider.referral_count').": ".(new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_count."</p>";
            Auth::user()->ride_otp =(int)config('constants.ride_otp');
            //(new ReferralResource)->get_referral('provider', Auth::user()->id)
            return Auth::user();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'cpf' => 'max:255',
                'cnh' => 'max:255',
                'avatar' => 'mimes:jpeg,bmp,png',
                'language' => 'max:255',
                'address' => 'max:255',
                'address_secondary' => 'max:255',
                'city' => 'max:255',
                'country' => 'max:255',
                'postal_code' => 'max:255',
            ]);

        try {

            $Provider = Auth::user();

            if($request->has('first_name'))
                $Provider->first_name = $request->first_name;

            if($request->has('last_name'))
                $Provider->last_name = $request->last_name;

            if($request->has('cpf'))
                $Provider->cpf = $request->cpf;
            
            if($request->has('cnh'))
                $Provider->cnh = $request->cnh;

            if ($request->has('mobile'))
            {
                $Provider->mobile = $request->mobile;
                $Provider->country_code = $request->country_code;
                 // QrCode generator
                 $file=QrCode::format('png')->size(500)->margin(10)->generate('{
					"country_code":'.'"'.$request->country_code.'"'.',
					"phone_number":'.'"'.$request->mobile.'"'.'
					}');
                // $file=QrCode::format('png')->size(200)->margin(20)->phoneNumber($request->country_code.$request->mobile);
                 
                //Registra motorista na franquia se existir na cidade informada
                $FleetCities = FleetCities::where('city_id', $Provider->city_id)->first();
                if($FleetCities->city_id){
                   $Provider->fleet = $FleetCities->fleet_id;
                }
                 
                $fileName = Helper::upload_qrCode($request->mobile,$file);
                $Provider->qrcode_url = $fileName;
            }
            if ($request->hasFile('avatar')) {
                Storage::delete($Provider->avatar);
                $Provider->avatar = $request->avatar->store('provider/profile');
            }

            if($request->has('service_type')) {
                if($Provider->service) {
                    if($Provider->service->service_type_id != $request->service_type) {
                        $Provider->status = 'banned';
                    }
                    //$ProviderService = ProviderService::where('provider_id',Auth::user()->id);
                    $Provider->service->service_type_id = $request->service_type;
                    $Provider->service->service_number = $request->service_number;
                    $Provider->service->service_model = $request->service_model;
                    $Provider->service->save();

                } else {
                    ProviderService::create([
                        'provider_id' => $Provider->id,
                        'service_type_id' => $request->service_type,
                        'service_number' => $request->service_number,
                        'service_model' => $request->service_model,
                    ]);
                    $Provider->status = 'banned';
                }
            }

            if($Provider->profile) {
                $Provider->profile->update([
                        'language' => $request->language ? : $Provider->profile->language,
                        'address' => $request->address ? : $Provider->profile->address,
                        'address_secondary' => $request->address_secondary ? : $Provider->profile->address_secondary,
                        'city' => $request->city ? : $Provider->profile->city,
                        'country' => $request->country ? : $Provider->profile->country,
                        'postal_code' => $request->postal_code ? : $Provider->profile->postal_code,
                    ]);
            } else {
                ProviderProfile::create([
                        'provider_id' => $Provider->id,
                        'language' => $request->language,
                        'address' => $request->address,
                        'address_secondary' => $request->address_secondary,
                        'city' => $request->city,
                        'country' => $request->country,
                        'postal_code' => $request->postal_code,
                    ]);
            }


            $Provider->save();
            return redirect(route('provider.profile.index'))->with('flash_success', trans('api.user.profile_updated'));
        }

        catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.provider.provider_not_found')], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('provider.profile.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'cpf' => 'max:255',
                'cnh' => 'max:255',
                'avatar' => 'mimes:jpeg,bmp,png',
                'language' => 'max:255',
                'address' => 'max:255',
                'address_secondary' => 'max:255',
                'city' => 'max:255',
                'country' => 'max:255',
                'postal_code' => 'max:255',
            ]);

        try {

            $Provider = Auth::user();

            if($request->has('first_name'))
                $Provider->first_name = $request->first_name;

            if($request->has('last_name'))
                $Provider->last_name = $request->last_name;

            if($request->has('cpf'))
                $Provider->cpf = $request->cpf;
            
            if($request->has('cnh'))
                $Provider->cnh = $request->cnh;

            if ($request->has('mobile') && $request->mobile != null)
                $Provider->mobile = $request->mobile;

            if ($request->hasFile('avatar')) {
                Storage::delete($Provider->avatar);
                $Provider->avatar = $request->avatar->store('provider/profile');
            }



            if($Provider->profile) {
                $Provider->profile->update([
                        'language' => $request->language ? : $Provider->profile->language,
                        'address' => $request->address ? : $Provider->profile->address,
                        'address_secondary' => $request->address_secondary ? : $Provider->profile->address_secondary,
                        'city' => $request->city ? : $Provider->profile->city,
                        'country' => $request->country ? : $Provider->profile->country,
                        'postal_code' => $request->postal_code ? : $Provider->profile->postal_code,
                    ]);
            } else {
                ProviderProfile::create([
                        'provider_id' => $Provider->id,
                        'language' => $request->language,
                        'address' => $request->address,
                        'address_secondary' => $request->address_secondary,
                        'city' => $request->city,
                        'country' => $request->country,
                        'postal_code' => $request->postal_code,
                    ]);
            }


            $Provider->save();
            $align = '';
            if(isset($Provider->profile->languag) && $Provider->profile->language != null) {
                app()->setLocale($Provider->profile->language);
            }
            if(isset($Provider->profile->languag)){
            $align = ($Provider->profile->language == 'ar') ? 'text-align: right' : '';
            }

            $Provider->service = ProviderService::where('provider_id', $Provider->id)
                                            ->with('service_type')
                                            ->first();

            $Provider->referral_count = setting('referral_count', config('constants.referral_count', '0'));
            $Provider->referral_amount = setting('referral_amount', config('constants.referral_amount', '0'));
            $Provider->referral_text = trans('api.provider.invite_friends');
            $Provider->referral_total_count = (new ReferralResource)->get_referral('provider', Auth::user()->id)[0]->total_count;
            $Provider->referral_total_amount = (new ReferralResource)->get_referral('provider', Auth::user()->id)[0]->total_amount;
            $Provider->referral_total_text = "<p style='font-size:16px; color: #000; $align'>"
                                            .trans('api.provider.referral_amount')
                                            .": "
                                            .(new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_amount
                                            ."<br>".trans('api.provider.referral_count')
                                            .": "
                                            .(new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_count
                                            ."</p>";

            return $Provider;
        }

        catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.provider.provider_not_found')], 404);
        }
    }

    public function update_details(Request $request)
    {
        if ($request->has('callid')) {
            if(is_null(Auth::user()->callid) || empty(Auth::user()->callid)){
                $user = Provider::find(Auth::user()->id);
                $user->callid = $request->get('callid');
                $user->save();
            }else if(Auth::user()->callid != $request->get('callid')){
                $user = Provider::find(Auth::user()->id);
                $user->callid = $request->get('callid');
                $user->save();
            }
        }
    }

    /**
     * Update latitude and longitude of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location(Request $request)
    {
        $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

        if($Provider = Auth::user()){

            $Provider->latitude = $request->latitude;
            $Provider->longitude = $request->longitude;
            $Provider->save();

            return response()->json(['message' => trans('api.provider.location_updated')]);

        } else {
            return response()->json(['error' => trans('api.provider.provider_not_found')]);
        }
    }

    public function update_language(Request $request)
    {
        $this->validate($request, [
               'language' => 'required',
            ]);

        try {

            $Provider = Auth::user();

            if($Provider->profile) {
                $Provider->profile->update([
                        'language' => $request->language ? : $Provider->profile->language
                    ]);
            } else {
                ProviderProfile::create([
                        'provider_id' => $Provider->id,
                        'language' => $request->language,
                    ]);
            }

            return response()->json(['message' => trans('api.provider.language_updated'),'language'=>$request->language]);
        }

        catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.provider.provider_not_found')], 404);
        }
    }

    /**
     * Toggle service availability of the provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function available(Request $request)
    {
        $this->validate($request, [
                'service_status' => 'required|in:active,offline',
            ]);

        $Provider = Auth::user();
        if($Provider->service) {

            $provider = $Provider->id;
            $OfflineOpenRequest = RequestFilter::with(['request.provider','request'])
                ->where('provider_id', $provider)
                ->whereHas('request', function($query) use ($provider){
                    $query->where('status','SEARCHING');
                    $query->where('current_provider_id','<>',$provider);
                    $query->orWhereNull('current_provider_id');
                    })->pluck('id');

            if(count($OfflineOpenRequest)>0) {
                RequestFilter::whereIn('id',$OfflineOpenRequest)->delete();
            }
            if($Provider->status == 'approved')
                $Provider->service->update(['status' => $request->service_status]);
        } else {
            return response()->json(['error' => trans('api.provider.not_approved')]);
        }

        return $Provider;
    }

    /**
     * Update password of the provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $this->validate($request, [
                'password' => 'required|confirmed',
                'password_old' => 'required',
            ]);

        $Provider = Auth::user();

        if(password_verify($request->password_old, $Provider->password))
        {
            $Provider->password = bcrypt($request->password);
            $Provider->save();

            return response()->json(['message' => trans('api.provider.password_updated')]);
        } else {
            return response()->json(['error' => trans('api.provider.change_password')], 422);
        }
    }

    /**
     * Show providers daily target.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function target(Request $request)
    {
        try {

            $Rides = UserRequests::where('provider_id', Auth::user()->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', Carbon::today())
                    ->with('payment', 'service_type')
                    ->get();

            //\Log::info($Rides);

            return response()->json([
                    'rides' => $Rides,
                    'rides_count' => $Rides->count(),
                    'target' => setting('daily_target', config('constants.daily_target','0'))
                ]);

        } catch(Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    public function chatPush(Request $request){

        $this->validate($request,[
                'user_id' => 'required|numeric',
                'message' => 'required',
            ]);

        try{

            $user_id=$request->user_id;
            $message=$request->message;

            $message = \PushNotification::Message($message,array(
            'badge' => 1,
            'sound' => 'default',
            'custom' => array('type' => 'chat')
            ));

            (new SendPushNotification)->sendPushToUser($user_id, $message);
            //(new SendPushNotification)->sendPushToProvider($user_id, $message);

            return response()->json(['success' => 'true']);

        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    //provider document list
    public function documents(Request $request)
    {
        try {

            $provider = Auth::user();
            $provider_id= $provider->id;

            $Documents=Document::select('id','name','type')
                        ->with(['providerdocuments' => function ($query) use ($provider_id) {
                        $query->where('provider_id', $provider_id);
                        }])
                        ->where(function ($q) use ($provider) {
                            $q->where('fleet_id', 0)->orWhere('fleet_id', $provider->fleet);
                        })
                        ->get();

            return response()->json(['documents' => $Documents]);

        } catch(Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    //provider document list
    public function documentstore(Request $request)
    {
        $this->validate($request, [
            'document' => 'required',
            'document.*' => 'mimes:jpg,jpeg,png|max:2048'
        ]);
        try {

            //\Log::info($request->all());

            if ($request->hasFile('document')) {

                foreach($request->file('document') as $ikey=> $image)
                {
                    $ids=$request->input('id');
                    $doc_id=$ids[$ikey];
                    $provider_id=Auth::user()->id;
                    (new DocumentController)->documentupdate($image, $doc_id,$provider_id);
                }

                if(config('constants.card', 0) == 1) {
                    Provider::where('id', Auth::user()->id)->where('status','document')->update(['status'=>'onboarding']);
                }
                else{
                    if(Setting::get('demo_mode', 0) == 1) {
                        Provider::where('id', Auth::user()->id)->where('status','document')->update(['status'=>'approved']);
                    }
                    else{
                        Provider::where('id', Auth::user()->id)->where('status','document')->update(['status'=>'onboarding']);
                    }
                }

                return $this->documents($request);
            }

        } catch(Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 422);
        }
    }

    public function stripe(Request $request)
    {
        if(isset($request->code)){
            $post = [
                'client_secret' => setting('stripe_secret_key', config('constants.stripe_secret_key')),
                'code' => $request->code,
                'grant_type' => 'authorization_code'
            ];
            $curl = curl_init("https://connect.stripe.com/oauth/token");
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            $curl_error = curl_error($curl);
            curl_close($curl);
            $stripe = json_decode($result);

            if($stripe->stripe_user_id){
                $provider = Provider::where('id', Auth::user()->id)->first();
                $provider->stripe_acc_id = $stripe->stripe_user_id;
                $provider->save();

                if($request->ajax()){
                    return response()->json(['message' => 'Your stripe account connected successfully']);
                }else{
                    return redirect('/provider')->with('flash_success', 'Your stripe account connected successfully');
                }
            }else{
                if($request->ajax()){
                    return response()->json(['message' => $curl_error]);
                }else{
                    return redirect('/provider')->with('flash_error', $curl_error);
                }
            }

        }else{
            if($request->ajax()){
                return response()->json(['message' => $request->error_description]);
            }else{
                return redirect('/provider')->with('flash_error', $request->error_description);
            }
        }
    }

    public function reasons(Request $request)
    {
        $reason = Reason::where('type', 'PROVIDER')->where('status', 1)->get();

        return $reason;

    }

    public function verifyCredentials(Request $request)
    {

        if($request->has("mobile")) {
            $Provider = Provider::where([['country_code',$request->input("country_code")],['mobile', $request->input("mobile")]])
                                  ->first();
            if($Provider != null) {
                return response()->json(['message' => trans('api.mobile_exist')], 422);
            }
        }

        if($request->has("email")) {
            $Provider = Provider::where('email', $request->input("email"))->first();
            if($Provider != null) {
                return response()->json(['message' => trans('api.email_exist')], 422);
            }
        }

        return response()->json(['message' => trans('api.available')]);

    }
}
