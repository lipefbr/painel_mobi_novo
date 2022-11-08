<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRequests;
use App\UserRequestPayment;
use App\RequestFilter;
use App\ProviderWallet;
use App\Provider;
use App\WalletRequests;
use App\Notifications;
use App\Dispute;
use App\UserRequestDispute;
use App\PushSubscription;

use Carbon\Carbon;
use Auth;
use Setting;
use App\Helpers\Helper;
use App\Http\Controllers\ProviderResources\TripController;
use App\Http\Controllers\Resource\ReferralResource;
use App\Http\Controllers\UserApiController;

class ProviderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('provider', ['except' => 'save_subscription']);
    }

   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function incoming(Request $request)
    {
        return (new TripController())->index($request);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function accept(Request $request, $id)
    {
        return (new TripController())->accept($request, $id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function reject($id)
    {
        return (new TripController())->destroy($id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        return (new TripController())->update($request, $id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function rating(Request $request, $id)
    {
        return (new TripController())->rate($request, $id);
    }


    /**
     * available.
     *
     * @return \Illuminate\Http\Response
     */
    public function available(Request $request)
    {
        (new ProviderResources\ProfileController)->available($request);
        return back();
    }


    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $this->validate($request, [
                'password' => 'required|confirmed',
                'old_password' => 'required',
            ]);

        $Provider = \Auth::user();

        if(password_verify($request->old_password, $Provider->password))
        {
            $Provider->password = bcrypt($request->password);
            $Provider->save();

            return back()->with('flash_success', trans('admin.password_update'));
        } else {
            return back()->with('flash_error', trans('admin.password_error'));
        }
    }


    /**
     * Update latitude and longitude of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location_update(Request $request)
    {
        $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

        if($Provider = \Auth::user()){

            $Provider->latitude = $request->latitude;
            $Provider->longitude = $request->longitude;
            $Provider->save();

            return back()->with(['flash_success' => trans('api.provider.location_updated')]);

        } else {
            return back()->with(['flash_error' => trans('admin.provider_msgs.provider_not_found')]);
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function cancel(Request $request) {
        try{

            (new TripController)->cancel($request);
            return back()->with(['flash_success' => trans('admin.provider_msgs.trip_cancelled')]);
        } catch (ModelNotFoundException $e) {
            return back()->with(['flash_error' => trans('admin.something_wrong')]);
        }
    }

   
    public function wallet_details(Request $request){

        try{

            $wallet_details = ProviderWallet::where('transaction_alias','LIKE', $request->alias_id)->where('provider_id',Auth::user()->id)->get();
           
            return response()->json(['data' => $wallet_details]);
          
        }catch(Exception $e){
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
        
    }


    public function requestamount(Request $request)
    {
        
        
        $send=(new TripController())->requestamount($request);
        $response=json_decode($send->getContent(),true);
        
        if(!empty($response['error']))
            $result['flash_error']=$response['error'];
        if(!empty($response['success']))
            $result['flash_success']=$response['success'];

        return redirect()->back()->with($result);
    }

    public function requestcancel(Request $request)
    {
              
        $cancel=(new TripController())->requestcancel($request);
        $response=json_decode($cancel->getContent(),true);
        
        if(!empty($response['error']))
            $result['flash_error']=$response['error'];
        if(!empty($response['success']))
            $result['flash_success']=$response['success'];

        return redirect()->back()->with($result);
    }


    public function stripe(Request $request)
    {
        return (new ProviderResources\ProfileController)->stripe($request);
    }

  
         /**
     * Dispute.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispute($id)
    {

         $dispute = UserRequestDispute::where([['request_id',$id],['dispute_type','!=','user']])
                                        ->get();
         $closedStatus = UserRequestDispute::where([['request_id',$id],['status','closed'],['dispute_type','!=','user']])
                                        ->first();
         $disputeReason = Dispute::where([['dispute_type','provider'],['status','active']])
                                        ->get();
              $sendBtn = ($closedStatus)?"yes":"no";                         
    return response()->json(['dispute' => $dispute,'sendBtn' => $sendBtn,'disputeReason'=>$disputeReason]);
    }
      /**
     * Dispute Save.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispute_store(Request $request)
    {
            try{
                $dispute = new UserRequestDispute;
                $dispute->request_id = $request->request_id;
                $dispute->user_id = Auth::user()->id;                    
                $dispute->dispute_title = $request->dispute_title;
                $dispute->dispute_name = $request->dispute_name;
                $dispute->dispute_type = 'provider';
                if($request->has('comments')) {
                    $dispute->comments = $request->comments;
                }    
    
                $dispute->save();

                    return response()->json(['message' => 'success']);
              
            } 
    
            catch (ModelNotFoundException $e) {
                return back()->with('flash_error', 'error');
            }
       
    }


    public function save_subscription($id, Request $request) {

        $user = Provider::findOrFail($id);

        $endpoint = $request->input('endpoint');
        $key = $request->input('keys.p256dh');
        $token = $request->input('keys.auth');
        $guard = 'provider';

        $subscription = PushSubscription::findByEndpoint($endpoint);

        if ($subscription && $subscription->user_id == $id) {
            $subscription->guard = $guard;
            $subscription->public_key = $key;
            $subscription->auth_token = $token;
            $subscription->save();

            return $subscription;
        }

        if ($subscription && ! $subscription->user_id == $id) {
            $subscription->delete();
        }

        $subscribe = new PushSubscription();
        $subscribe->user_id = $user->id;
        $subscribe->guard = $guard;
        $subscribe->endpoint = $endpoint;
        $subscribe->public_key = $key;
        $subscribe->auth_token = $token;
        $subscribe->save();

        return response()->json([ 'success' => true ]);
    }
   
}