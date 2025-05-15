<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class PayPalController extends Controller
{
public function payment()
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $token = $provider->getAccessToken();
    $provider->setAccessToken($token);

    $currency = env('PAYPAL_CURRENCY', 'USD');

    $items = [];
    foreach (Cart::content() as $item) {
        $items[] = [
            'name' => $item->name,
            'quantity' => $item->qty,
            'unit_amount' => [
                'currency_code' => $currency,
                'value' => number_format($item->price, 2, '.', ''),
            ],
        ];
    }

    $order = $provider->createOrder([
        'intent' => 'CAPTURE',
        'purchase_units' => [[
            'amount' => [
                'currency_code' => $currency,
                'value' => number_format(Cart::total(), 2, '.', ''),
                'breakdown' => [
                    'item_total' => [
                        'currency_code' => $currency,
                        'value' => number_format(Cart::total(), 2, '.', ''),
                    ],
                ],
            ],
            'items' => $items,
        ]],
        'application_context' => [
            'cancel_url' => route('paypal.cancel'),
            'return_url' => route('paypal.success'),
        ],
    ]);

    if (isset($order['status']) && $order['status'] === 'CREATED') {
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->away($link['href']);
            }
        }
    }

    return redirect()->route('carrito')->with('error', 'Error al crear la orden en PayPal.');
}



    public function success(Request $request)
    {
        $provider = new PayPalClient;
       $provider->setApiCredentials(config('paypal')); // ✅ Le pasas la configuración
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $result = $provider->capturePaymentOrder($request->token);

        if (isset($result['status']) && $result['status'] === 'COMPLETED') {
            Cart::destroy();
            return redirect('/')->with('success', '¡Pago exitoso con PayPal!');
        }

        return redirect()->route('carrito')->with('error', 'Error al procesar el pago.');
    }

    public function cancel()
    {
        return redirect()->route('carrito')->with('error', 'Pago cancelado.');
    }
}
