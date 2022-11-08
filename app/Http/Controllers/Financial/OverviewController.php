<?php

namespace App\Http\Controllers\Financial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\WalletRequests;
use App\AdminWallet;
use App\UserRequestPayment;
use App\ProviderWallet;
use App\FleetWallet;
use App\Fleet;
use Auth;

class OverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	
    	$wallterRequests = WalletRequests::where('status', 0)->get();

        $fleetWallet = FleetWallet::sum('amount');

        $totalTransferAcount = AdminWallet::where('type', 'D')->where('form_of_payment', 2)->where('is_real', false)->sum('amount');

        $user = Auth::user();

        $totalAcount = 0;
        $totalComissions = 0;
        $totalDriver = 0;
        $wallterRequestsPending = 0;

        $totalDriver = 0;

        if($user && ($user->isSuperAdmin() || $user->isAdmin())) { 
            $totalAcount = AdminWallet::sum('amount') + abs($totalTransferAcount);
            $totalComissions = UserRequestPayment::sum('commision');
            $wallterRequestsPending = WalletRequests::where('status', 0)->sum('amount');
            $totalDriver = ProviderWallet::sum('amount');
        } else {
            $totalAcount =   $fleetWallet;
            $totalComissions = UserRequestPayment::sum('fleet');
            $wallterRequestsPending = WalletRequests::where('status', 0)->sum('amount');
            $totalDriver = ProviderWallet::join('providers', 'provider_wallet.provider_id',  '=', 'providers.id')
                    ->whereIn('providers.fleet', Fleet::where('admin_id', $user->id)->pluck('id'))
                    ->sum('amount');
        }



        $period = 7;

        if($request->period == 'month') {
             $period = 30;
        }

        $dateNow =  \Date("Y-m-d");

        $dateStart = date('Y-m-d', strtotime($dateNow. ' - '.($period - 1).' days'));

        $arrRecipes['amount'] = UserRequestPayment::where('updated_at', '>=', $dateStart)->sum('total');
        

        for ($i=0; $i < $period; $i++) { 
                $arrRecipes['data'][] = array('date' =>  date('Y-m-d', strtotime($dateNow . ' - '. (($period - 1) - $i).' days')) , 'recipe' => 0.00,'comission' => 0.00);
        }

        $userRequests =  UserRequestPayment::where('updated_at', '>=', $dateStart)
        ->groupBy(\DB::raw("DATE_FORMAT(updated_at, '%Y-%m-%d')"))
        ->selectRaw("sum(total) as recipe, sum(commision) as comission, DATE_FORMAT(updated_at, '%Y-%m-%d') as updated_at_f ")
        ->get();

        foreach ($userRequests as $value) {
            foreach ($arrRecipes['data'] as $key => $arrRecipe) {
                if ( $value->updated_at_f == $arrRecipe['date']) {
                    $arrRecipes['data'][$key]['recipe'] = $value->recipe;
                    $arrRecipes['data'][$key]['comission'] = $value->comission;

                    break;
                }
            }
            
        }
    	
 		return view('admin.financial.index', compact('wallterRequests', 'totalAcount', 'totalComissions', 'totalDriver', 'wallterRequestsPending', 'arrRecipes', 'totalTransferAcount'));
    }
}