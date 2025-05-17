<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function verPedidosCliente($cliente_id)
    {
        $pedidos = Pedido::where('cliente_id', $cliente_id)
            ->with(['productos.producto'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('pedidos.listaPedidos', compact('pedidos', 'cliente_id'));
    }

    public function hacerPedido()
    {
        $cart = Cart::session($this->getSessionId());
        $carrito = $cart->getContent();
        $total = $cart->getTotal();

        return view('pedidos.listaPedidos', compact('carrito', 'total'));
    }

    public function finalizarPedido()
    {
        $cart = Cart::session($this->getSessionId());
        $carrito = $cart->getContent();

        foreach ($carrito as $item) {
            Pedido::create([
                'producto_id' => $item->id,
                'cantidad' => $item->quantity,
                'precio' => $item->price,
                'cliente_id' => Auth::id(),
                'fecha' => now(),
                'total' => $item->price * $item->quantity
            ]);

            // Actualizar existencias del producto
            $producto = Producto::find($item->id);
            if ($producto) {
                $producto->decrement('existencia', $item->quantity);
            }
        }

        $cart->clear();

        return redirect()->route('home')
            ->with('success', 'Pedido realizado con éxito');
    }

    protected function getSessionId()
    {
        return Auth::check() ? Auth::id() : session()->getId();
    }
}