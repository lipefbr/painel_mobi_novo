<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Card;
use Exception;
use Auth;
use Setting;

class CardResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $cards = Card::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
            return $cards; 

        } catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $this->validate($request,[
                'stripe_token' => 'required'
            ]);

        try{

                $customer_id = $this->customer_id();
                $this->set_stripe();
                $customer = \Stripe\Customer::retrieve($customer_id);

                $card = shell_exec('curl https://api.stripe.com/v1/customers/' . $customer_id .'/sources \
                        -u '. setting('stripe_secret_key', config('constants.stripe_secret_key')) . ': \
                        -d source='. $request->stripe_token);

                //\Log::info('CURL  JSON' . json_encode($card));
                //\Log::info('CURL ' . collect(json_decode($card))->get('id'));

                $card = collect(json_decode($card)); //$customer->sources->create(["source" => $request->stripe_token]);

                $exist = Card::where('user_id',Auth::user()->id)
                                ->where('last_four', $card->get('last4'))
                                ->where('brand',$card->get('brand'))
                                ->count();

                if($exist == 0){

                    $create_card = new Card;
                    $create_card->user_id = Auth::user()->id;
                    $create_card->card_id = $card->get('id');
                    $create_card->last_four = $card->get('last4');
                    $create_card->brand = $card->get('brand');
                    $create_card->save();

                }else{
                    if($request->ajax()){
                        return response()->json(['message' => trans('api.card_already')]);
                    }else{
                        return back()->with('flash_error',trans('api.card_already'));
                    }     
                }

            if($request->ajax()){
                return response()->json(['message' => trans('api.card_added')]); 
            }else{
                return back()->with('flash_success',trans('api.card_added'));
            }

        } catch(Exception $e){
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }else{
                return back()->with('flash_error',$e->getMessage());
            }
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $this->validate($request,[
                'card_id' => 'required|exists:cards,card_id,user_id,'.Auth::user()->id,
            ]);

        try{


            //$this->set_stripe();

            //$customer = \Stripe\Customer::retrieve(Auth::user()->stripe_cust_id);
            //$customer->sources->retrieve($request->card_id)->delete();

            $card = shell_exec('curl https://api.stripe.com/v1/customers/' . Auth::user()->stripe_cust_id . '/sources/'. $request->card_id .' \
            -u '. setting('stripe_secret_key', config('constants.stripe_secret_key')) . ': \
            -X DELETE');

            //\Log::info(json_encode($card));

            Card::where('card_id',$request->card_id)->delete();

            if($request->ajax()){
                return response()->json(['message' => trans('api.card_deleted')]); 
            }else{
                return back()->with('flash_success',trans('api.card_deleted'));
            }

        } catch(Exception $e){
            if($request->ajax()){
                return response()->json(['error' => $e->getMessage()], 500);
            }else{
                return back()->with('flash_error',$e->getMessage());
            }
        }
    }

    /**
     * setting stripe.
     *
     * @return \Illuminate\Http\Response
     */
    public function set_stripe(){
        return \Stripe\Stripe::setApiKey(setting('stripe_secret_key', config('constants.stripe_secret_key')));
    }

    /**
     * Get a stripe customer id.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_id()
    {
        if(Auth::user()->stripe_cust_id != null){

            return Auth::user()->stripe_cust_id;

        }else{

            try{

                $stripe = $this->set_stripe();

                $customer = \Stripe\Customer::create([
                    'email' => Auth::user()->email,
                ]);

                User::where('id',Auth::user()->id)->update(['stripe_cust_id' => $customer['id']]);
                return $customer['id'];

            } catch(Exception $e){
                return $e;
            }
        }
    }

}
