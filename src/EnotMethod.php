<?php

namespace Azuriom\Plugin\Enot;

use Azuriom\Models\User;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Payment;
use Azuriom\Plugin\Shop\Payment\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnotMethod extends PaymentMethod
{
    /**
     * The payment method id name.
     *
     * @var string
     */
    protected $id = 'enot';

    /**
     * The payment method display name.
     *
     * @var string
     */
    protected $name = 'Enot';

    public function startPayment(Cart $cart, float $amount, string $currency)
    {
        $payment = $this->createPayment($cart, $amount, $currency);

        $project_id = $this->gateway->data['project-id'];
        $pay_id = $payment->id;
        $desc = $this->gateway->data['desc'];
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'x-api-key' => $this->gateway->data['private-key']
        ])->post('https://api.enot.io/invoice/create', [
            'amount' => $amount,
            'order_id' => strval($pay_id),
            'currency' => $currency,
            'comment' => $desc,
            'shop_id' => $project_id
        ]);

        if($response->json('data') == null){
            return response($response->json('error'), $response->json('status'));
        }

        return redirect()->away($response->json('data.url'));
    }

    public function notification(Request $request, ?string $paymentId)
    {

        //Проверка на успех
        if("success" != $request->input('status')){
            return response()->json(['status' => 'this payment is failed.']);
        }
        
        /***    Проверка подписи     ***/
        $sign_header = $request->header('x-api-sha256-signature');

        $sign = $request->all();

        ksort($sign);
        $sign = json_encode($sign);
        $secret_key = $this->gateway->data['private-key-2'];
        $calculated_signature = hash_hmac('sha256', $sign, $secret_key);

        if (!hash_equals($sign_header, $calculated_signature)) {
            return response()->json(['status' => 'invalid sign.']);
        }
        /***                         ***/

        $payment = Payment::findOrFail($request->input('order_id'));
        

        return $this->processPayment($payment, $request->input('invoice_id'));

    }

   public function success(Request $request)
    {
        return redirect()->route('shop.home')->with('success', trans('messages.status.success'));
    }

    public function view()
    {
        return 'enot::admin.enot';
    }

    public function rules()
    {
        return [
            'private-key' => ['required', 'string'],
            'private-key-2' => ['required', 'string'],
            'project-id' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'color' => ['required', 'int'],
        ];
    }

    public function image()
    {
        if(!isset($this->gateway->data['color'])) {
            return asset('plugins/enot/img/enot-black.svg');
        }

        if($this->gateway->data['color'] == 1){
            return asset('plugins/enot/img/enot-white.svg');
        } else {
            return asset('plugins/enot/img/enot-black.svg');
        }
    }

}
