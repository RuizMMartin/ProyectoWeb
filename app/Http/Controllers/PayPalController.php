<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class PayPalController extends Controller
{
    public function payment()
    {
        // Verificar si el carrito está vacío
        if (Cart::session($this->getSessionId())->isEmpty()) {
            return redirect()->route('carrito')->with('error', 'Tu carrito está vacío');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        try {
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            // Obtener el total del carrito con formato correcto para PayPal
            $total = Cart::session($this->getSessionId())->getTotal();
            $formattedTotal = number_format($total, 2, '.', '');

            // Crear la orden en PayPal
            $order = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.success'),
                    "cancel_url" => route('paypal.cancel'),
                    "brand_name" => env('APP_NAME', 'Tu Tienda'),
                    "user_action" => "PAY_NOW",
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => config('paypal.currency', 'USD'),
                            "value" => $formattedTotal,
                            "breakdown" => [
                                "item_total" => [
                                    "currency_code" => config('paypal.currency', 'USD'),
                                    "value" => $formattedTotal
                                ]
                            ]
                        ],
                        "description" => "Compra en " . env('APP_NAME', 'Tu Tienda'),
                        "items" => $this->getCartItems()
                    ]
                ]
            ]);

            // Redirigir a PayPal
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }

        } catch (\Exception $e) {
            return redirect()->route('carrito')
                ->with('error', 'Error al conectar con PayPal: '.$e->getMessage());
        }

        return redirect()->route('carrito')
            ->with('error', 'No se pudo crear la orden de PayPal');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        try {
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $response = $provider->capturePaymentOrder($request->token);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Aquí deberías:
                // 1. Guardar la orden en tu base de datos
                // 2. Registrar los detalles de la transacción
                // 3. Vaciar el carrito
                // 4. Enviar confirmación al cliente

                Cart::session($this->getSessionId())->clear();

                return redirect()->route('home')
                    ->with('success', '¡Pago completado con éxito! Número de transacción: '.$response['id']);
            }

        } catch (\Exception $e) {
            // Registrar el error y notificar al administrador
            return redirect()->route('carrito')
                ->with('error', 'Error al procesar el pago: '.$e->getMessage());
        }

        return redirect()->route('carrito')
            ->with('error', 'El pago no se completó correctamente');
    }

    public function cancel()
    {
        return redirect()->route('carrito')
            ->with('warning', 'Has cancelado el proceso de pago. Puedes volver a intentarlo.');
    }

    /**
     * Obtiene los items del carrito formateados para PayPal
     */
    protected function getCartItems()
    {
        $cartItems = Cart::session($this->getSessionId())->getContent();
        $items = [];

        foreach ($cartItems as $item) {
            $items[] = [
                "name" => $item->name,
                "unit_amount" => [
                    "currency_code" => config('paypal.currency', 'USD'),
                    "value" => number_format($item->price, 2, '.', '')
                ],
                "quantity" => $item->quantity,
                "sku" => $item->id // o $item->sku si tienes ese campo
            ];
        }

        return $items;
    }

    /**
     * Obtiene el ID de sesión para el carrito
     */
    protected function getSessionId()
    {
        return Auth::check() ? Auth::id() : session()->getId();
    }
}