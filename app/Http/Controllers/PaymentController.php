<?php

namespace App\Http\Controllers;

use App\AdminWallet;
use App\Card;
use App\Fleet;
use App\Helpers\PaytmLibrary;
use App\Http\Controllers\ProviderResources\TripController;
use App\Http\Controllers\SendPushNotification;
use App\Provider;
use App\PaymentLog;
use App\ProviderCard;
use App\ProviderWallet;
use App\Services\PaymentGateway;
use App\User;
use App\UserRequestPayment;
use App\UserRequests;
use App\UserWallet;
use App\WalletRequests;
use Auth;
use Exception;
use Illuminate\Http\Request;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Stripe\Stripe;
use Tzsk\Payu\Facade\Payment as PayuPayment;

class PaymentController extends Controller
{
    /**
     * payment for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {

        $this->validate($request, [
        'request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,'.Auth::user()->id
        ]);

        $UserRequest = UserRequests::find($request->request_id);

        $paymentMode = $request->has('payment_mode') ? strtoupper($request->payment_mode) : $UserRequest->payment_mode;

        $tip_amount = 0;

        $random =  setting('booking_prefix', config('constants.booking_prefix')).mt_rand(100000, 999999);
        
        //Pagamentos Por Cartao De Credito
        if ($paymentMode != 'CASH' && $paymentMode != 'VOUCHER' && $paymentMode != 'DEBIT_MACHINE') {

            $RequestPayment = UserRequestPayment::where('request_id', $request->request_id)->first();

            if (isset($request->tips) && !empty($request->tips)) {
                $tip_amount = round($request->tips, 2);
            }

            $totalAmount = $RequestPayment->payable + $tip_amount;

            if ($totalAmount == 0) {

                $UserRequest->payment_mode = 'CARD';
                $RequestPayment->card = $RequestPayment->payable;
                $RequestPayment->payable = 0;
                $RequestPayment->tips = $tip_amount;
                $RequestPayment->provider_pay = $RequestPayment->provider_pay + $tip_amount;
                $RequestPayment->save();

                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();

                //for create the transaction
                (new TripController)->callTransaction($request->request_id);

                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.paid')]);
                } else {
                    return redirect('dashboard')->with('flash_success', trans('api.paid'));
                }

            } else {

                $log = new PaymentLog();
                $log->user_type = 'user';
                $log->transaction_code = $random;
                $log->amount = $totalAmount;
                $log->transaction_id = $UserRequest->id;
                $log->payment_mode = $paymentMode;
                $log->user_id = \Auth::user()->id;
                $log->save();

                switch ($paymentMode) {
                  case 'BRAINTREE':

                    $gateway = new PaymentGateway('braintree');

                    return $gateway->process([
                        'amount' => $totalAmount,
                        'nonce' => $UserRequest->braintree_nonce,
                        'order' => $random,
                    ]);

                    break;

                  case 'CARD':

                    $Card = Card::where('user_id', Auth::user()->id)->where('is_default', 1)->first();



                    if($Card == null)  $Card = Card::where('user_id', Auth::user()->id)->first();

                    $gateway = new PaymentGateway('stripe');
                    return $gateway->process([
                        'order' => $random,
                        "amount" => $totalAmount,
                        "currency" => setting('stripe_currency', config('constants.stripe_currency')),
                        "customer" => Auth::user()->stripe_cust_id,
                        "card" => $Card->card_id,
                        "description" => "Pagamento de viagem " . Auth::user()->email,
                        "receipt_email" => Auth::user()->email,
                    ]);

                    break;

                  case 'PAYPAL':

                    $gateway = new PaymentGateway('paypal');
                    return $gateway->process([
                        'order' => $random,
                        'item_name' => $random,
                        'item_currency' => config('constants.paypal_currency'),
                        'item_quantity' => 1,
                        'amount' => $totalAmount,
                        'description' => 'Test',
                    ]);

                    break;

                  case 'PAYPAL-ADAPTIVE':

                    $gateway = new PaymentGateway('paypal-adaptive');

                    $provider = Provider::find($UserRequest->provider_id);

                    $provider_amount = 10;

                    if ($provider->paypal_email != null) {

                        $primary_email = config('constants.paypal_email', '');
                        $secondary_email[] = ['secondary_email' => $provider->paypal_email, 'amount' => $provider_amount];

                        return $gateway->process([
                            'order' => $random,
                            'primary_email' => $primary_email,
                            'secondary_email' => $secondary_email,
                            'amount' => $totalAmount,
                            'payer' => "EACHRECEIVER",
                        ]);

                    } else {
                        return redirect('dashboard')->with('flash_error', 'Please choose another payment method!');
                    }

                    break;

                }

            }

        }
    }

    /**
     * add wallet money for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_money(Request $request)
    {
        $random = setting('booking_prefix', config('constants.booking_prefix')).mt_rand(100000, 999999);

        $user_type = $request->user_type;

        $log = new PaymentLog();
        $log->user_type = $user_type;
        $log->is_wallet = '1';
        $log->amount = $request->amount;
        $log->transaction_code = $random;
        $log->payment_mode = strtoupper($request->payment_mode);
        $log->user_id = \Auth::user()->id;
        $log->save();

        switch (strtoupper($request->payment_mode)) {

          case 'BRAINTREE':

           $gateway = new PaymentGateway('braintree');
            return $gateway->process([
                'amount' => $request->amount,
                'nonce' => $request->braintree_nonce,
                'order' => $random,
            ]);

            break;

          case 'CARD':

            if ($user_type == 'provider') {

                //$Card = ProviderCard::where('user_id', $request->card_id)->first();

                ProviderCard::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
                ProviderCard::where('card_id', $request->card_id)->update(['is_default' => 1]);

            } else {

                //$Card = Card::where('user_id', $request->card_id)->first();

                Card::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
                Card::where('card_id', $request->card_id)->update(['is_default' => 1]);

            }

            $gateway = new PaymentGateway('stripe');
            return $gateway->process([
                "order" => $random,
                "amount" => $request->amount,
                "currency" => setting('stripe_currency', config('constants.stripe_currency')),
                "customer" => Auth::user()->stripe_cust_id,
                "card" => $request->card_id,
                "description" => "Dinheido Adicionado para " . Auth::user()->email,
                "receipt_email" => Auth::user()->email,
                "type" => '',
//                "type" => ($user_type == 'provider') ? 'connected_account' : '',
            ]);

            break;


          case 'PAYPAL':

            $gateway = new PaymentGateway('paypal');
            return $gateway->process([
                'order' => $random,
                'item_name' => 'Item',
                'item_currency' => setting('paypal_currency', config('constants.paypal_currency')),
                'item_quantity' => 1,
                'amount' => $request->amount,
                'description' => 'Wallet Money added',
            ]);

            break;
        }

    }

    /**
     * send money to provider or fleet.
     *
     * @return \Illuminate\Http\Response
     */
    public function send_money(Request $request, $id)
    {

        try {

            $Requests = WalletRequests::where('id', $id)->first();

            if ($Requests->request_from == 'provider') {
                $provider = Provider::find($Requests->from_id);
                $stripe_cust_id = $provider->stripe_cust_id;
                $email = $provider->email;
            } else {
                $fleet = Fleet::find($Requests->from_id);
                $stripe_cust_id = $fleet->stripe_cust_id;
                $email = $fleet->email;
            }

            if (empty($stripe_cust_id)) {
                throw new Exception(trans('admin.payment_msgs.account_not_found'));
            }

            $StripeCharge = $Requests->amount;

            \Stripe\Stripe::setApiKey(setting('stripe_secret_key', config('constants.stripe_secret_key')));

            $tranfer = \Stripe\Transfer::create(array(
                "amount" => $StripeCharge,
                "currency" => "brl",
                "destination" => $stripe_cust_id,
                "description" => "Liquidação de pagamento para " . $email
            ));

            //create the settlement transactions
            (new TripController)->settlements($id);

            $response = array();
            $response['success'] = trans('admin.payment_msgs.amount_send');

        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    public function response(Request $request)
    {

        $log = PaymentLog::where('transaction_code', $request->order)->first();

        if($log->is_wallet == 1) {

            if ($log->user_type == "user") {
                $user = \App\User::find($log->user_id);
                $wallet = (new TripController)->userCreditDebit($log->amount, $user->id, 1);
                (new SendPushNotification)->WalletMoney($user->id, currency($log->amount));
            } else if ($log->user_type == "provider") {
                $user = \App\Provider::find($log->user_id);
                $wallet = (new TripController)->providerCreditDebit($log->amount, $user->id, 1);
                (new SendPushNotification)->ProviderWalletMoney($user->id, currency($log->amount));
            }

            $wallet_balance = $user->wallet_balance+$log->amount;

            //Reativa o motorista
            if($log->user_type == "provider" && $wallet_balance > (float) setting('minimum_negative_balance', config('constants.minimum_negative_balance'))) {
                Provider::where('id', $log->user_id)->update(['status' => 'approved']);
            }

            if ($request->ajax()) {
                return response()->json(['success' => currency($log->amount) . " " . trans('api.added_to_your_wallet'), 'message' => currency($log->amount) . " " . trans('api.added_to_your_wallet'), 'wallet_balance' => $wallet_balance]);
            } else {
                if ($log->user_type == "provider") {
                    return redirect('/provider/wallet_transation')->with('flash_success', currency($log->amount) . trans('admin.payment_msgs.amount_added'));
                } else {
                    return redirect('wallet')->with('flash_success', currency($log->amount) . trans('admin.payment_msgs.amount_added'));
                }

            }

        }


        $payment_id = $request->has('pay') ? $request->pay : null;

        switch ($log->payment_mode) {

          case 'BRAINTREE':
            # code...
            break;
          case 'CARD':
            //Envia notificação de recebimento na carteira para os motoristas
            if(!is_null($log->transaction_id)){
                $RequestPayment = UserRequestPayment::where('request_id', $log->transaction_id)->first();
                //(new SendPushNotification)->sendPushToProvider($RequestPayment->provider_id, "Você recebeu R$". $RequestPayment->provider_pay . " na sua carteira!" );
                (new SendPushNotification)->sendPushToUser($RequestPayment->user_id, "Debitamos do seu cartão o valor de R$". $RequestPayment->payable . "!" );
            }
            break;

          case 'PAYPAL-ADAPTIVE':

            break;


          case 'PAYPAL':

            $paypal_conf = \Config::get('paypal');
            $api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
            );
            $api_context->setConfig($paypal_conf['settings']);

            $payment = Payment::get($request->paymentId, $api_context);

            $execution = new PaymentExecution();
            $execution->setPayerId($request->PayerID);

            //Execute the payment
            $result = $payment->execute($execution, $api_context);
            $log->response = $result;
            $log->save();

            if ($result->getState() == 'approved') {
                $payment_id = $request->PayerID;
            }

            break;
        }

        $UserRequest = UserRequests::find($log->transaction_id);

        $RequestPayment = UserRequestPayment::where('request_id', $UserRequest->id)->first();
        $RequestPayment->payment_id = $payment_id;
        $RequestPayment->payment_mode = $UserRequest->payment_mode;
        $RequestPayment->card = $RequestPayment->payable;
        $RequestPayment->save();

        $UserRequest->paid = 1;
        $UserRequest->status = 'COMPLETED';
        $UserRequest->save();

        //for create the transaction
        (new TripController)->callTransaction($UserRequest->id);

        if ($request->ajax()) {
            return response()->json(['message' => trans('api.paid')]);
        } else {
            return redirect('dashboard')->with('flash_success', trans('api.paid'));
        }

    }

    public function failure(Request $request)
    {
        $log = PaymentLog::where('transaction_code', $request->order)->first();

        if($log->is_wallet == 1) {

            if ($request->ajax()) {
                return response()->json(['success' => 'false', 'message' => 'Transaction Failed']);
            } else {
                if ($request->type == "provider") {
                    return redirect('/provider/wallet_transation')->with('flash_error', 'Transaction Failed');
                } else {
                    return redirect('wallet')->with('flash_error', 'Transaction Failed');
                }
            }

        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Transaction Failed']);
        } else {
            if ($request->type == "provider") {
                return redirect('/')->with('flash_success', 'Transaction Failed');
            } else {
                return redirect('dashboard')->with('flash_success', 'Transaction Failed');
            }

        }

    }

    public function payu_response(Request $request)
    {
        $log = PaymentLog::where('transaction_code', $request['txnid'])->first();
        $log->response = json_encode($request->all());
        $log->save();

        $provider_url = $log->user_type == 'provider' ? '/provider' : '' ;

        return redirect($provider_url . '/payment/response?order='. $request['txnid']. '&pay=' . $request->payuMoneyId );

    }

    public function payu_error(Request $request)
    {

        $log = PaymentLog::where('transaction_code', $request)->first();
        $log->response = json_encode($request);
        $log->save();

        $provider_url = $log->user_type == 'provider' ? '/provider' : '' ;

        return redirect($provider_url . '/payment/failure?order='. $request['txnid'] );
    }

}
