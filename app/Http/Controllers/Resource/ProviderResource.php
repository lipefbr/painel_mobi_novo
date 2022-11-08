<?php
//TODO ALLAN - Alterações débito na máquina e voucher

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Exception;
use Setting;
use Storage;
use QrCode;
use \Carbon\Carbon;
use App\Provider;
use App\User;
use App\Fleet;
use App\FleetCities;
use App\UserRequestPayment;
use App\UserRequests;
use App\Helpers\Helper;
use App\Document;
use App\Http\Controllers\SendPushNotification;
use App\WalletRequests;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\ProviderWallet;

use App\ServiceType;
use App\ProviderService;
use App\ProviderDocument;
use App\UserRequestRating;

class ProviderResource extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy', 'disapprove']]);
        $this->middleware('permission:provider-list', ['only' => ['index']]);
        $this->middleware('permission:provider-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:provider-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:provider-delete', ['only' => ['destroy']]);
        $this->middleware('permission:provider-status', ['only' => ['approve', 'disapprove']]);
        $this->middleware('permission:provider-history', ['only' => ['request']]);
        $this->middleware('permission:provider-statements', ['only' => ['statement']]);
        $this->perpage = config('constants.per_page', '10');
    }

    public function ajax(DataTables $dataTables)
    {
        $providers = Provider::with('service', 'accepted', 'cancelled')->newQuery();
        $total_documents = Document::count();

        return $dataTables->eloquent($providers)
            ->editColumn('name', function ($provider) {
                return $provider->full_name;
            })
            ->addColumn('requests', function ($provider) {
                return $provider->total_requests();
            })
            ->addColumn('accepteds', function ($provider) {
                return $provider->accepted_requests();
            })
            ->addColumn('total', function ($provider) {
                return $provider->total_requests();
            })
            ->addColumn('service_type', function ($provider) use ($total_documents) {
                if ($provider->active_documents() == $total_documents && $provider->service != null) {
                    return "<a class='btn btn-success btn-block' href='" . route('admin.provider.document.index', $provider->id) . "'>Verificado</a>";
                } else {
                    return "<a class='btn btn-danger btn-block label-right' href='" . route('admin.provider.document.index', $provider->id) . "'>Pendente <span class='btn-label'>" . $provider->pending_documents() . "</span></a>";
                }
            })
            ->addColumn('action', function ($user) {
                return "<a href='" . route('admin.users.show', ['id' => $user->id]) . "' class='btn-mini btn-primary' data-toggle='tooltip' data-trigger='hover' data-placement='top' title='Visualizar'><i class='fa fa-address-card'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = \App\Admin::find(\Auth::id());

        if (!empty($request->page) && $request->page == 'all') {
            $AllProviders = Provider::with('service', 'accepted', 'cancelled')
                ->orderBy('id', 'asc');
            if (request()->has('fleet')) {
                $providers = $AllProviders->where('fleet', $request->fleet)->get();
            } else {
                $providers = $AllProviders->get();
            }
            return response()->json(array('success' => true, 'data' => $providers));
        } else {
            if ($request->has('name') || $request->has('status')) {
                $AllProviders = Provider::with('service', 'accepted', 'cancelled', 'documents');

                if (!empty($request->get('name'))) {
                    $AllProviders->where('first_name', 'like', '%' . $request->get('name') . '%')
                        ->orWhere('last_name', 'like', '%' . $request->get('name') . '%')
                        ->orWhere('mobile', '=', $request->get('name'))
                        ->orWhere('email', 'like', '%' . $request->get('name') . '%');
                }

                if (!empty($request->get('status'))) {
                    $status = $request->get('status');
                    if ($status == "A"){
                        $AllProviders->where('status','=','approved');
                    }else if($status == "P"){
                        //$AllProviders->join('provider_documents','providers.id','=','provider_documents.provider_id');
                        //$AllProviders->where('status','document')
                        $AllProviders->whereHas('documents', function ($query){
                            $query->where('status','=','ASSESSING');
                        })->orderBy('id','desc');
                        //$AllProviders->where('provider_documents.status','ASSESSING')->orderBy('providers.id', 'DESC');
                        //$AllProviders->where('providers.status','document');
                    }else{
                        $AllProviders->where('status','document')->orderBy('id','desc');
                    }
                        //$AllProviders->orderBy('id', 'DESC');
                }

                if (request()->has('fleet')) {
                    $providers = $AllProviders->where('fleet', $request->fleet)->paginate($this->perpage)->appends(['fleet' => $request->get('fleet')]);

                } else {

                    if($request->has('name')){

                        $providers = $AllProviders->paginate($this->perpage)->appends(['name' => $request->get('name'), 'status' => $request->get('status')]);
                    }else{
                        $providers = $AllProviders->paginate($this->perpage);
                    }
                }

                $total_documents = Document::count();

                $pagination = (new Helper)->formatPagination($providers);

                $url = $providers->url($providers->currentPage());

                $request->session()->put('providerpage', $url);

                return view('admin.providers.index', compact('providers', 'pagination', 'total_documents', 'user'));

            } else {
                $AllProviders = Provider::with('service', 'accepted', 'cancelled')
                    ->orderBy('id', 'DESC');
                if (request()->has('fleet')) {
                    $providers = $AllProviders->where('fleet', $request->fleet)->paginate($this->perpage)->appends(['fleet' => $request->get('fleet')]);

                } else {
                    $providers = $AllProviders->paginate($this->perpage);
                }

                $total_documents = Document::count();

                $pagination = (new Helper)->formatPagination($providers);

                $url = $providers->url($providers->currentPage());

                $request->session()->put('providerpage', $url);

                return view('admin.providers.index', compact('providers', 'pagination', 'total_documents', 'user'));
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        try {
            $fleets = Fleet::with('city')->orderBy('created_at' , 'desc')->get();

            $states = State::with('cities')->get();
            $stateId = State::whereHas('cities')->get()->first();
            return view('admin.providers.create', compact('states', 'stateId', 'fleets'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'cpf' => 'required|max:255',
            //'cnh' => 'required|max:255',
            'country_code' => 'required|max:25',
            'email' => 'required|unique:providers,email|email|max:255',
            //'mobile' => 'digits_between:6,13',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $provider = $request->all();

            $provider['password'] = bcrypt($request->password);
            if ($request->hasFile('avatar')) {
                $provider['avatar'] = $request->avatar->store('provider/profile');
            }
            // QrCode generator
            $file = QrCode::format('png')->size(500)->margin(10)->generate('{
                "country_code":' . '"' . $request->country_code . '"' . ',
                "phone_number":' . '"' . $request->mobile . '"' . '
                }');
            // $file=QrCode::format('png')->size(200)->margin(20)->phoneNumber($request->country_code.$request->mobile);
            
            $provider->debit_machine = $request->debit_machine  == 'on' ? 1 : 0;
            $provider->debit_machine_fleet = $request->debit_machine_fleet  == 'on' ? 1 : 0;

            //Registra motorista na franquia se existir na cidade informada
            $FleetCities = FleetCities::where('city_id', $provider['city_id'])->first();
            if($FleetCities->city_id){
               $provider['fleet'] = $FleetCities->fleet_id;
            }
            
            $provider['qrcode_url'] = Helper::upload_qrCode($request->mobile, $file);
            $provider = Provider::create($provider);
            
            return redirect()->route('admin.provider.index')->with('flash_success', 'Motorista cadastrado com sucesso!');

        } catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $provider = Provider::findOrFail($id);

            $amount = ProviderWallet::where('provider_id', $id)->sum('amount');

            $total_documents = Document::where('fleet_id', 0)->orWhere('fleet_id', $provider->fleet)->count();

            $documents_required = Document::select('id','name','type')
                        ->with(['providerdocuments' => function ($query) use ($id, $provider ) {
                            $query->where('provider_id', $id);
                        }])
                        ->where(function ($q) use ($provider) {
                            $q->where('fleet_id', 0)->orWhere('fleet_id', $provider->fleet);
                        })
                        ->get();

            $releases = UserRequests::where('provider_id', $id)
                    ->where(function ($q) {
                        $q->where('status', 'CANCELLED')->orWhere('status', 'COMPLETED');
                    })
                    ->orderby('updated_at', 'desc')
                    ->get();
            
            $releaseTotal = UserRequestPayment::where('provider_id', $id)->sum('total');
            $releaseRecipe = UserRequestPayment::where('provider_id', $id)->sum('provider_pay');
            $releasesCanceled = UserRequests::where('status', 'CANCELLED')->where('provider_id', $id)->sum('estimated_fare');
            
            //Se for admin somar td. se for franquia somar somente a parte
            $releaseAdminComission = UserRequestPayment::where('provider_id', $id)->sum('commision');
            $releaseFleetComission = UserRequestPayment::where('provider_id', $id)->sum('fleet');

            $releaseComission = $releaseAdminComission + $releaseFleetComission;

            $providerService = ProviderService::where('provider_id', $id)->with('service_type')->get();
            $providerFleet = Fleet::where("city_id", $provider->city_id)->first();
            $serviceTypes = ServiceType::where('fleet_id', $provider->fleet)->get();

            $wallterRequests = WalletRequests::where('request_from', 'provider')->where('from_id',  $id)->orderby('id', 'desc')->take(10)->get();

            $reviews = UserRequestRating::where('provider_id', $id)->where('user_id', '!=', 0)->with('user', 'provider')->paginate(15);

            $approved =  UserRequests::where('provider_id', $id)->where('status', 'CANCELLED')->count();
            $canceled =  UserRequests::where('provider_id', $id)->where('status', 'COMPLETED')->count();

            return view('admin.providers.provider-details', compact('provider', 'amount', 'total_documents', 'releases', 'providerService', 'providerFleet', 'serviceTypes', 'wallterRequests', 'reviews', 'approved', 'canceled', 'releaseTotal',  'releaseRecipe', 'releasesCanceled', 'releaseComission', 'documents_required'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $states = State::with('cities')->get();
            $provider = Provider::findOrFail($id);

            $fleets = Fleet::with('city')->orderBy('name' , 'asc')->pluck('fleets.name', 'fleets.id');

            $stateId = State::whereHas('cities', function ($query) use ($provider) {
                $query->where('id', $provider->city_id);
            })->get()->first();
            return view('admin.providers.edit', compact('provider', 'states', 'stateId', 'fleets'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'city_id' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            //'country_code' => 'required|max:25',
            //'mobile' => 'digits_between:6,13',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try {
            $fleet = Fleet::where('city_id','=',$request->city_id)->get()->first();

            $provider = Provider::findOrFail($id);

            if(!is_null($fleet->id) && !empty($fleet)){
                $provider->fleet = $fleet->id;
            }

            if ($request->has('fleet_id')) {
                 $provider->fleet = $request->fleet_id;
            }

            if ($request->hasFile('avatar')) {
                if ($provider->avatar) {
                    Storage::delete($provider->avatar);
                }
                $provider->avatar = $request->avatar->store('provider/profile');
            }
            // QrCode generator
            $file = QrCode::format('png')->size(500)->margin(10)->generate('{
                "country_code":' . '"' . $request->country_code . '"' . ',
                "phone_number":' . '"' . $request->mobile . '"' . '
                }');
            // $file=QrCode::format('png')->size(200)->margin(20)->phoneNumber($request->country_code.$request->mobile);
            $provider->qrcode_url = Helper::upload_qrCode($request->mobile, $file);

            $provider->city_id = $request->city_id;
            $provider->first_name = $request->first_name;
            $provider->last_name = $request->last_name;
            $provider->cpf = $request->cpf;
            //$provider->cnh = $request->cnh;
            $provider->country_code = $request->country_code;
            $provider->mobile = $request->mobile;

            $provider->debit_machine = $request->debit_machine  == 'on' ? 1 : 0;
            $provider->debit_machine_fleet = $request->debit_machine_fleet  == 'on' ? 1 : 0;

            if($request->password && !$request->password_confirm){
                return back()->with('flash_error', 'Por favor, informe a senha de confirmação!');
            }elseif($request->password && $request->password_confirm){
                if($request->password == $request->password_confirm){
                    $provider->password = bcrypt($request->password);
                }else{
                    return back()->with('flash_error', 'As senhas não conferem!');
                }
            }
            $provider->save();

             return back()->with('flash_success', trans('admin.provider_msgs.provider_update'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.provider_msgs.provider_not_found'));
        }
    }

    public function addDocumentManualy(Request $request) {
        $document = Document::find($request->document_id);
        $filename=str_replace(" ","",$document->name);
        $ext = $request->file('document')->guessExtension();
        $path = $request->file('document')->storeAs(
            "provider/documents/". $request->provider_id, $filename.'.'.$ext
        );
        ProviderDocument::create([
                'url' => $path,
                'provider_id' => $request->provider_id,
                'document_id' => $document->id,
                'status' => 'ACTIVE',
            ]);

        return back()->with('flash_success', "Documento adicionado com sucesso!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {

            $provider_request = WalletRequests::where('request_from', 'provider')->where('from_id', $id)->count();

            if ($provider_request > 0) {
                return back()->with('flash_error', trans('admin.provider_msgs.provider_settlement'));
            }

            Provider::find($id)->delete();

            return redirect()->route('admin.provider.index')->with('message', trans('admin.provider_msgs.provider_delete'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('admin.provider_msgs.provider_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        try {
            $Provider = Provider::findOrFail($id);
            $total_documents = Document::where('fleet_id', 0)->orWhere('fleet_id', $Provider->fleet)->count();
            if ($Provider->active_documents() == $total_documents && $Provider->service) {
                if ($Provider->status == 'onboarding') {
                    // Sending push to the provider
                    (new SendPushNotification)->DocumentsVerfied($id);
                }
                $Provider->update(['status' => 'approved']);
                $url = $request->session()->pull('providerpage');
                return redirect()->to($url)->with('flash_success', trans('admin.provider_msgs.provider_approve'));
            } else {
                if ($Provider->active_documents() != $total_documents) {
                    $msg = trans('admin.provider_msgs.document_pending');
                }
                if (!$Provider->service) {
                    $msg = trans('admin.provider_msgs.service_type_pending');
                }

                if (!$Provider->service && $Provider->active_documents() != $total_documents) {
                    $msg = trans('admin.provider_msgs.provider_pending');
                }
                return redirect()->route('admin.provider.show', $id)->with('flash_error', $msg);
            }
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('admin.provider_msgs.provider_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {

        Provider::where('id', $id)->update(['status' => 'banned']);
        return back()->with('flash_success', trans('admin.provider_msgs.provider_disapprove'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function request($id)
    {

        try {

            $requests = UserRequests::where('user_requests.provider_id', $id)
                ->RequestHistory()
                ->paginate($this->perpage);

            $pagination = (new Helper)->formatPagination($requests);

            return view('admin.request.index', compact('requests', 'pagination'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('admin.something_wrong'));
        }
    }

    /**
     * account statements.
     *
     * @param  \App\Provider $provider
     * @return \Illuminate\Http\Response
     */
    public function statement($id)
    {
        


        try {
            $listname = '';
            $statement_for = "provider";
            $requests = UserRequests::where('provider_id', $id)
                ->where('status', 'COMPLETED')
                ->with('payment')
                ->get();

            $rides = UserRequests::where('provider_id', $id)->with('payment')->orderBy('id', 'desc')->paginate($this->perpage);
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('provider_id', $id)->count();
            $Provider = Provider::find($id);

            $revenue = UserRequestPayment::whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id);
            })->select(\DB::raw(
                'SUM(provider_pay) as overall, SUM(commision) as commission'
            ))->get();

            

            $Joined = $Provider->created_at ? '- Cadastrado ' . $Provider->created_at->diffForHumans() : '';

            $pagination = (new Helper)->formatPagination($rides);


            $dates['yesterday'] = Carbon::yesterday()->format('Y-m-d');
            $dates['today'] = Carbon::today()->format('Y-m-d');
            $dates['pre_week_start'] = Carbon::today()->subWeek()->format('Y-m-d');
            $dates['pre_week_end'] = Carbon::parse('last sunday of this month')->format('Y-m-d');
            $dates['cur_week_start'] = Carbon::today()->startOfWeek()->format('Y-m-d');
            $dates['cur_week_end'] = Carbon::today()->endOfWeek()->format('Y-m-d');
            $dates['pre_month_start'] = Carbon::parse('first day of last month')->format('Y-m-d');
            $dates['pre_month_end'] = Carbon::parse('last day of last month')->format('Y-m-d');
            $dates['cur_month_start'] = Carbon::parse('first day of this month')->format('Y-m-d');
            $dates['cur_month_end'] = Carbon::parse('last day of this month')->format('Y-m-d');
            $dates['pre_year_start'] = Carbon::parse('first day of last year')->format('Y-m-d');
            $dates['pre_year_end'] = Carbon::parse('last day of last year')->format('Y-m-d');
            $dates['cur_year_start'] = Carbon::parse('first day of this year')->format('Y-m-d');
            $dates['cur_year_end'] = Carbon::parse('last day of this year')->format('Y-m-d');
            $dates['nextWeek'] = Carbon::today()->addWeek()->format('Y-m-d');

            return view('admin.providers.statement', compact('rides', 'cancel_rides', 'Provider', 'revenue', 'pagination', 'dates', 'id', 'statement_for'))
                ->with('page', "Receita de " . $Provider->first_name . " " . $Joined)->with('listname', $listname);

        } catch (Exception $e) {
            return back()->with('flash_error', trans('admin.something_wrong'));
        }
    }

    /**
     * account statements.
     *
     * @param  \App\User $User
     * @return \Illuminate\Http\Response
     */
    public function statementUser($id)
    {

        try {
            $listname = '';
            $statement_for = "user";
            $requests = UserRequests::where('user_id', $id)
                ->where('status', 'COMPLETED')
                ->with('payment')
                ->get();

            $rides = UserRequests::where('user_id', $id)->with('payment')->orderBy('id', 'desc')->paginate($this->perpage);
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('user_id', $id)->count();
            $user = User::find($id);
            $revenue = UserRequestPayment::whereHas('request', function ($query) use ($id) {
                $query->where('user_id', $id);
            })->select(\DB::raw(
                'SUM(total) as overall,  SUM(commision) as commission'
            ))->get();


            $Joined = $user->created_at ? '- Cadastrado ' . $user->created_at->diffForHumans() : '';

            $pagination = (new Helper)->formatPagination($rides);


            $dates['yesterday'] = Carbon::yesterday()->format('Y-m-d');
            $dates['today'] = Carbon::today()->format('Y-m-d');
            $dates['pre_week_start'] = Carbon::today()->subWeek()->format('Y-m-d');
            $dates['pre_week_end'] = Carbon::parse('last sunday of this month')->format('Y-m-d');
            $dates['cur_week_start'] = Carbon::today()->startOfWeek()->format('Y-m-d');
            $dates['cur_week_end'] = Carbon::today()->endOfWeek()->format('Y-m-d');
            $dates['pre_month_start'] = Carbon::parse('first day of last month')->format('Y-m-d');
            $dates['pre_month_end'] = Carbon::parse('last day of last month')->format('Y-m-d');
            $dates['cur_month_start'] = Carbon::parse('first day of this month')->format('Y-m-d');
            $dates['cur_month_end'] = Carbon::parse('last day of this month')->format('Y-m-d');
            $dates['pre_year_start'] = Carbon::parse('first day of last year')->format('Y-m-d');
            $dates['pre_year_end'] = Carbon::parse('last day of last year')->format('Y-m-d');
            $dates['cur_year_start'] = Carbon::parse('first day of this year')->format('Y-m-d');
            $dates['cur_year_end'] = Carbon::parse('last day of this year')->format('Y-m-d');
            $dates['nextWeek'] = Carbon::today()->addWeek()->format('Y-m-d');

            return view('admin.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'pagination', 'dates', 'id', 'statement_for'))
                ->with('page', "Receita " . $user->first_name . " " . $Joined)->with('listname', $listname);

        } catch (Exception $e) {
            return back()->with('flash_error', trans('admin.something_wrong'));
        }
    }

    /**
     * account statements.
     *
     * @param  \App\fleet $fleet
     * @return \Illuminate\Http\Response
     */
    public function statementFleet($id)
    {

        try {

            $listname = '';
            $statement_for = "fleet";
            
            $Fleet = Fleet::where('id', $id)->first();
            
            $rides = UserRequests::whereHas('user', function ($query) use ($Fleet) {
                $query->where('city_id', $Fleet->city_id);
            })->orderBy('id', 'desc')->paginate($this->perpage);
            
            $cancel_rides = UserRequests::whereHas('user', function ($query) use ($Fleet) {
                $query->where('city_id', $Fleet->city_id);
            })->where('status', 'CANCELLED')->count();
            
            $fleet = Fleet::find($id);
            
            $revenue = UserRequestPayment::where('fleet_id', $id)
                ->select(\DB::raw(
                    'SUM(total) as overall, SUM(provider_pay) as commission'
                ))->get();
                                    
            $Joined = $fleet->created_at ? '- Cadastrado ' . $fleet->created_at->diffForHumans() : '';

            $pagination = (new Helper)->formatPagination($rides);

            $dates['yesterday'] = Carbon::yesterday()->format('Y-m-d');
            $dates['today'] = Carbon::today()->format('Y-m-d');
            $dates['pre_week_start'] = Carbon::today()->subWeek()->format('Y-m-d');
            $dates['pre_week_end'] = Carbon::parse('last sunday of this month')->format('Y-m-d');
            $dates['cur_week_start'] = Carbon::today()->startOfWeek()->format('Y-m-d');
            $dates['cur_week_end'] = Carbon::today()->endOfWeek()->format('Y-m-d');
            $dates['pre_month_start'] = Carbon::parse('first day of last month')->format('Y-m-d');
            $dates['pre_month_end'] = Carbon::parse('last day of last month')->format('Y-m-d');
            $dates['cur_month_start'] = Carbon::parse('first day of this month')->format('Y-m-d');
            $dates['cur_month_end'] = Carbon::parse('last day of this month')->format('Y-m-d');
            $dates['pre_year_start'] = Carbon::parse('first day of last year')->format('Y-m-d');
            $dates['pre_year_end'] = Carbon::parse('last day of last year')->format('Y-m-d');
            $dates['cur_year_start'] = Carbon::parse('first day of this year')->format('Y-m-d');
            $dates['cur_year_end'] = Carbon::parse('last day of this year')->format('Y-m-d');
            $dates['nextWeek'] = Carbon::today()->addWeek()->format('Y-m-d');

            return view('admin.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'pagination', 'dates', 'id', 'statement_for'))
                ->with('page', "Receita de " . $fleet->name . " " . $Joined)->with('listname', $listname);

        } catch (Exception $e) {
            return back()->with('flash_error', trans('admin.something_wrong'));
        }
    }

    public function Accountstatement($id)
    {

        try {

            $listname = '';

            $requests = UserRequests::where('provider_id', $id)
                ->where('status', 'COMPLETED')
                ->with('payment')
                ->get();

            $rides = UserRequests::where('provider_id', $id)->with('payment')->orderBy('id', 'desc')->paginate($this->perpage);
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('provider_id', $id)->count();
            $Provider = Provider::find($id);
            $revenue = UserRequestPayment::whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id);
            })->select(\DB::raw(
                'SUM(fixed) + distance) as overall, SUM(commision) as commission'
            ))->get();


            $Joined = $Provider->created_at ? '- Cadastrado ' . $Provider->created_at->diffForHumans() : '';

            $pagination = (new Helper)->formatPagination($rides);

            $dates['yesterday'] = Carbon::yesterday()->format('Y-m-d');
            $dates['today'] = Carbon::today()->format('Y-m-d');
            $dates['pre_week_start'] = Carbon::today()->subWeek()->format('Y-m-d');
            $dates['pre_week_end'] = Carbon::parse('last sunday of this month')->format('Y-m-d');
            $dates['cur_week_start'] = Carbon::today()->startOfWeek()->format('Y-m-d');
            $dates['cur_week_end'] = Carbon::today()->endOfWeek()->format('Y-m-d');
            $dates['pre_month_start'] = Carbon::parse('first day of last month')->format('Y-m-d');
            $dates['pre_month_end'] = Carbon::parse('last day of last month')->format('Y-m-d');
            $dates['cur_month_start'] = Carbon::parse('first day of this month')->format('Y-m-d');
            $dates['cur_month_end'] = Carbon::parse('last day of this month')->format('Y-m-d');
            $dates['pre_year_start'] = Carbon::parse('first day of last year')->format('Y-m-d');
            $dates['pre_year_end'] = Carbon::parse('last day of last year')->format('Y-m-d');
            $dates['cur_year_start'] = Carbon::parse('first day of this year')->format('Y-m-d');
            $dates['cur_year_end'] = Carbon::parse('last day of this year')->format('Y-m-d');
            $dates['nextWeek'] = Carbon::today()->addWeek()->format('Y-m-d');

            return view('account.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'pagination', 'dates'))
                ->with('page', "Receita de " . $Provider->first_name . " " . $Joined)->with('listname', $listname);

        } catch (Exception $e) {
            return back()->with('flash_error', trans('admin.something_wrong'));
        }
    }

    public function get_password($id)
    {

        $provider = Provider::findOrFail($id);
        return view('admin.providers.password', compact('provider'));
    }

    public function update_password(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed'
        ]);

        $provider = Provider::findOrFail($id);

        $provider->update(['password' => bcrypt($request->get('password'))]);

        return redirect()->route('admin.provider.index')->with('flash_success', 'Senha atualizada com sucesso');
    }
}
