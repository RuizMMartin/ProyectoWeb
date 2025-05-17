@extends('plantilla/layout')

@section('titulo', 'Resumen del Pedido')

@section('contenido')
@php 
use Darryldecode\Cart\Facades\CartFacade as Cart;
$cart = Cart::session(auth()->check() ? auth()->id() : session()->getId());
$carrito = $cart->getContent();
@endphp

<div class="container mx-auto max-w-4xl px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Resumen del Pedido</h1>

    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="w-full text-sm text-left text-gray-600 bg-white border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Producto</th>
                    <th class="px-6 py-4">Precio</th>
                    <th class="px-6 py-4">Cantidad</th>
                    <th class="px-6 py-4">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $item)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                        <td class="px-6 py-4">${{ number_format($item->price, 2) }}</td>
                        <td class="px-6 py-4">{{ $item->quantity }}</td>
                        <td class="px-6 py-4">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
        <div class="flex justify-between py-2 text-base">
            <span class="text-gray-700 font-medium">Subtotal:</span>
            <span class="text-gray-900">${{ number_format($cart->getSubTotal(), 2) }}</span>
        </div>
        <div class="flex justify-between py-2 text-base">
            <span class="text-gray-700 font-medium">Impuestos:</span>
            <span class="text-gray-900">$0.00</span> {{-- Calcula manualmente si necesitas impuestos --}}
        </div>
        <div class="flex justify-between py-4 text-lg font-bold border-t border-gray-300 mt-4">
            <span>Total:</span>
            <span>${{ number_format($cart->getTotal(), 2) }}</span>
        </div>
    </div>

    <form action="{{ route('finalizarPedido') }}" method="POST" class="mt-8 text-center mb-4">
        @csrf
        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-center">
            Finalizar Pedido
        </button>
    </form>

    <div class="text-center">
        <a href="{{ route('paypal.payment') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors inline-block">
            Pagar con PayPal
        </a>
    </div>

    <div class="container mx-auto max-w-4xl px-4 py-10">
        <img src="/imagenes/metodoPago.png" alt="" class="mx-auto max-w-xs">
    </div>

    <div class="container mx-auto max-w-4xl px-4 py-10">
        <h3 class="px-6 py-4 font-medium text-gray-900 text-center">El costo por envío se mostrará al llegar a la página de confirmación del pedido.</h3>
        <h3 class="px-6 py-4 font-medium text-gray-900 text-center">Recuerda que cuentas con 30 días para realizar la devolución de tu pedido. Lee más al respecto en nuestra página de <a href="">Devolución y Reembolso.</a></h3>
        <h3 class="px-6 py-4 font-medium text-gray-900 text-center">¿Necesitas ayuda? Ponte en contacto con <a href="">Asistencia al Cliente.</a> </h3>
    </div>
</div>
@endsection
