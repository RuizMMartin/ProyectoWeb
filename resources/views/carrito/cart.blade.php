@extends('plantilla/layout')

@section('titulo', 'Carrito de Compras')

@section('contenido')
@php use Darryldecode\Cart\Facades\CartFacade as Cart; @endphp
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Tu Carrito de Compras</h2>

                @if (Cart::count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach (Cart::content() as $item)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <img src="{{ $item->options->imagen1 ?? '#' }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded">
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500">${{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-4 text-sm text-gray-500">{{ $item->qty }}</td>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">${{ number_format($item->price * $item->qty, 2) }}</td>
                                <td class="px-4 py-4 text-right text-sm font-medium">
                                    <form action="{{ route('removeItem') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <div class="flex justify-between">
                        <span class="text-base font-medium text-gray-900">Subtotal:</span>
                        <span class="text-base font-medium text-gray-900">${{ Cart::subtotal() }}</span>
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-base font-medium text-gray-900">Impuestos:</span>
                        <span class="text-base font-medium text-gray-900">${{ Cart::tax() }}</span>
                    </div>
                    <div class="flex justify-between mt-4 border-t border-gray-200 pt-4">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span class="text-lg font-bold text-gray-900">${{ Cart::total() }}</span>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row justify-between gap-4">
                    <a href="{{ route('clear') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors text-center">
                      Vaciar Carrito
                    </a>
                    <a href="{{ route('hacerPedido') }}" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-center">
                        Finalizar Compra
                    </a>
                    <a href="{{ route('paypal.payment') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-center">
                        Pagar con PayPal
                    </a>
                </div>
                @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Tu carrito está vacío</h3>
                    <p class="mt-1 text-gray-500">Agrega productos para comenzar</p>
                    <div class="mt-6">
                        <a href="/catalogoProductos" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors inline-block">
                            Ver Catálogo
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
