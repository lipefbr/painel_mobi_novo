<?php

namespace App\Http\Controllers\Financial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;


use App\PaymentCategory as Category;

use App\UserRequestPayment;
use App\UserRequests;

use App\AdminWallet;
use App\ProviderWallet;
use App\FleetWallet;
use App\UserWallet;
use Auth;
use App\User;
use App\Provider;
use App\Fleet;

class ReleasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	
    	//return DB::table('user_request_payments')->with('user_wallet')->get();

    	$releases;
    	$typeList = "requests";

        
        $releaseTotal = UserRequestPayment::sum('total');
        $releaseRecipe = UserRequestPayment::sum('provider_pay');
        $releasesCanceled = UserRequests::where('status', 'CANCELLED')->sum('estimated_fare');

        $releasesCanceled = 0;

        $user = Auth::user();

        if($user && ($user->isSuperAdmin() || $user->isAdmin())) {
            $releasesCanceled = UserRequests::where('status', 'CANCELLED')->sum('estimated_fare');
        } else {
            $releasesCanceled = UserRequests::join('providers', 'user_requests.provider_id',  '=', 'providers.id')
            ->whereIn('providers.fleet', Fleet::where('admin_id', $user->id)->pluck('id'))
            /*
            ->where(function ($q) use ($user) {
                if($user && !$user->isSuperAdmin() && !$user->isAdmin()) {
                    $q->whereIn('providers.fleet', Fleet::where('admin_id', $user->id)->pluck('id'));
                }
            })*/
            ->where('user_requests.status', 'CANCELLED')
            ->select('first_name',
                'user_requests.id', 'user_id', 'provider_id', 'current_provider_id', 'service_type_id', 'promocode_id', 'rental_hours', 'user_requests.status', 'cancelled_by', 'cancel_reason', 'payment_mode', 'paid', 'distance', 'travel_time', 'unit', 's_address', 's_latitude', 's_longitude', 'd_address', 'd_latitude', 'd_longitude', 'track_distance', 'track_latitude', 'track_longitude', 'destination_log', 'is_drop_location', 'is_instant_ride', 'is_dispute', 'assigned_at', 'schedule_at', 'started_at', 'finished_at', 'is_scheduled', 'user_rated', 'provider_rated', 'use_wallet', 'surge',  'nonce', 'user_requests.created_at', 'user_requests.updated_at', 'estimated_fare'

            )->sum('estimated_fare');
        }
        
        
        //Se for admin somar td. se for franquia somar somente a parte
        $releaseAdminComission = UserRequestPayment::sum('commision');
        $releaseFleetComission = UserRequestPayment::sum('fleet');

        $releaseComission = $releaseAdminComission + $releaseFleetComission;


        $drivers  = Provider::select(\DB::raw("CONCAT(first_name, ' ',last_name, ' - ', email) AS display_name"), 'id')->pluck('display_name','id');

    	if($request->type == "admin") {

    		$typeList = "admin";

    		$releases = AdminWallet::orderby('updated_at', 'desc')->where('commission', 0)->paginate(50);

    	} else if ($request->type == 'drivers') {

    		$typeList = "drivers";

    	} else {
            if($user && ($user->isSuperAdmin() || $user->isAdmin())) {
    		  $releases = UserRequests::where('status', 'CANCELLED')->orWhere('status', 'COMPLETED')->orderby('updated_at', 'desc')->paginate(50);
            } else {
                $releases = UserRequests::join('providers', 'user_requests.provider_id',  '=', 'providers.id')
                            ->whereIn('providers.fleet', Fleet::where('admin_id', $user->id)->pluck('id'))
                            ->where(function ($q) {
                                $q->where('user_requests.status', 'CANCELLED')->orWhere('user_requests.status', 'COMPLETED');
                            
                            })
                            ->select('first_name', 'user_requests.id', 'user_id', 'provider_id', 'current_provider_id', 'service_type_id', 'promocode_id', 'rental_hours', 'user_requests.status', 'cancelled_by', 'cancel_reason', 'payment_mode', 'paid', 'distance', 'travel_time', 'unit', 's_address', 's_latitude', 's_longitude', 'd_address', 'd_latitude', 'd_longitude', 'track_distance', 'track_latitude', 'track_longitude', 'destination_log', 'is_drop_location', 'is_instant_ride', 'is_dispute', 'assigned_at', 'schedule_at', 'started_at', 'finished_at', 'is_scheduled', 'user_rated', 'provider_rated', 'use_wallet', 'surge',  'nonce', 'user_requests.created_at', 'user_requests.updated_at', 'estimated_fare')
                            ->orderby('updated_at', 'desc')->paginate(50);
            }
    	}

        $categories_expense = Category::where('type', 1)->orWhere('type', 0)->select('id', 'color', 'name', 'type')->get();
        $categories_recipe = Category::where('type', 2)->orWhere('type', 0)->select('id', 'color', 'name', 'type')->get();

 		return view('admin.financial.releases.index', compact('releaseTotal', 'releaseRecipe', 'releasesCanceled', 'releaseComission', 'releases', 'typeList', 'categories_expense', 'categories_recipe'));
    }


    public function payments(Request $request)
    {
        $inputs = $request->all();

        if ( null === $request->status ) 
            $inputs["status"] = 0;

        $inputs["amount"] = str_replace(",", ".", str_replace(".", "", $inputs["value"] ) );

        
        if($inputs['payment_type'] == 2){
            //Receita
            $inputs['type'] = 'C';
        
        } else if($inputs['payment_type'] == 1) {
            //Despesa
            $inputs['type'] = 'D';

        }

        $inputs['editable'] = true;
        
        
        if ( isset( $inputs["payment_date"] ) && $inputs["payment_date"] != "" ) {
            $inputs["payment_date"] = date("Y-m-d", strtotime( str_replace("/", "-", $inputs["payment_date"] ) ) );
            $inputs["status"] = 1;
        }else{
            $inputs["payment_date"] = null;
            $inputs["status"] = 0;
        }

        

        AdminWallet::create($inputs);


        return  redirect()->back();
    }

    public function paymentTransfer(Request $request)
    {
        $inputs = $request->all();

       switch ($request->payment_by_type) {
           case 'driver':
            
                $provider = Provider::findOrFail($request['provider']);

                $providerWallet = new ProviderWallet();
                $providerWallet->provider_id = $provider->id;

                $providerWallet->form_of_payment = 2;

                $providerWallet->transaction_desc = $inputs->transaction_desc;

                $providerWallet->type = 'C';
                $providerWallet->amount = str_replace(",", ".", str_replace(".", "", $inputs["value"] ) );

                $providerWallet->save();

                $provider->wallet_balance = $provider->wallet_balance + (str_replace(",", ".", str_replace(".", "", $inputs["value"] ) ));
                $provider->save();
              
            break;

            case 'fleet':
                $fleet = Fleet::findOrFail($request['fleet']);

                $fleetWallet = new FleetWallet();
                $fleetWallet->fleet_id = $fleet->id;

                $fleetWallet->form_of_payment = 2;

                $fleetWallet->transaction_desc = $inputs->transaction_desc;

                $fleetWallet->type = 'C';
                $fleetWallet->amount = str_replace(",", ".", str_replace(".", "", $inputs["value"] ) );

                $fleetWallet->is_real = true;
                $fleetWallet->save();

                $fleet->wallet_balance = $fleet->wallet_balance + (str_replace(",", ".", str_replace(".", "", $inputs["value"] ) ));
                $fleet->save();
               
               break;
           

           case 'user':

                $user = User::findOrFail($request['user']);

                $userWallet = new UserWallet();
                $userWallet->user_id = $user->id;

                $userWallet->form_of_payment = 2;

                $userWallet->transaction_desc = $inputs->transaction_desc;

                $userWallet->type = 'C';
                $userWallet->amount = str_replace(",", ".", str_replace(".", "", $inputs["value"] ) );

                $userWallet->save();

                $user->wallet_balance = $user->wallet_balance + (str_replace(",", ".", str_replace(".", "", $inputs["value"] ) ));
                $user->save();
               
               break;
           
           default:
               
               return redirect()->back()->with('flash_error', 'Falha ao realizar transferência!');

               break;
       }


        $inputs["amount"] =  (-1 * abs(str_replace(",", ".", str_replace(".", "", $inputs["value"] ) )));
        
        $inputs['type']              = 'D';
        $inputs['form_of_payment']   = 2;
        $inputs['is_real']           = true;
        $inputs['transaction_alias'] = $inputs->transaction_desc;
        $inputs['category_id'] = 55;
        
        if ( isset( $inputs["payment_date"] ) && $inputs["payment_date"] != "" ) {
            $inputs["payment_date"] = date("Y-m-d", strtotime( str_replace("/", "-", $inputs["payment_date"] ) ) );
            $inputs["status"] = 1;
        }else{
            $inputs["payment_date"] = null;
            $inputs["status"] = 0;
        }

        AdminWallet::create($inputs);

        return  redirect()->back()->with('flash_success', 'Transferência realizada com sucesso!');
    }




    public function getPaymentDestination(Request $request)
    {

        if( !$request->ajax() )
           return 'false';

       $result;

       switch ($request->destination) {
           case 'driver':

               $result = Provider::select(\DB::raw("CONCAT(first_name, ' ',last_name, ' - ', email) AS text"), 'id')
                                    ->where('email', 'like', "%". $request->q . "%")
                                    //->whereNull('deleted_at')
                                    ->orderBy('email')->get();

               break;

            case 'fleet':

               $result = Fleet::select(\DB::raw("name AS text"), 'id')
                                    ->where('name', 'like', "%". $request->q . "%")
                                    //->whereNull('deleted_at')
                                    ->orderBy('name')->get();

               break;
           

           case 'user':

               $result = User::select(\DB::raw("CONCAT(first_name, ' ',last_name, ' - ', email) AS text"), 'id')
                                    ->where('email', 'like', "%". $request->q . "%")
                                    //->whereNull('deleted_at')
                                    ->orderBy('email')->get();

               break;
           
           default:
               $result = Provider::select(\DB::raw("CONCAT(first_name, ' ',last_name, ' - ', email) AS text"), 'id')
                                    ->where('email', 'like', "%". $request->q . "%")
                                    //->whereNull('deleted_at')
                                    ->orderBy('email')->get();
               break;
       }


        if( count($result) > 0)
            return $result;

        return 'false';
    }



     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePayment(Request $request)
    {


        $inputs = $request->all();
        $payment = AdminWallet::find($inputs["payment_id"]); 

        if ($payment->editable == 0) {
           return  redirect()->back()->with('flash_error', 'Esse lançamento não pode ser editado!');
        }

        $inputs["amount"] = str_replace(",", ".", str_replace(".", "", $inputs["value"] ) );
        
        
        if ( isset( $inputs["payment_date"] ) && $inputs["payment_date"] != "" ) {
            $inputs["payment_date"] = date("Y-m-d", strtotime( str_replace("/", "-", $inputs["payment_date"] ) ) );
            $inputs["status"] = 1;
        }else{
            $inputs["payment_date"] = null;
            $inputs["status"] = 0;
        }

        $payment->update($inputs);

        return  redirect()->back()->with('flash_success', 'Laçamento atualizado com sucesso!');
    }





  /**
     * Remove the specified resource from delete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPayment($id)
    {
        
       $payment = AdminWallet::withTrashed()->find($id);
 

       if(is_null($payment->deleted_at)){
            $payment->delete();
            return redirect()->back()->with('flash_success', 'Exclusão realizada com sucesso!');
       }else{
            
            $payment->forceDelete();
            return redirect()->back()->with('flash_success', 'Exclusão realizada com sucesso!');
       }    

       return 404;
    }




}