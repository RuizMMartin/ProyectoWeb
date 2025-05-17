<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected function getCartInstance()
    {
        return Cart::session($this->getSessionId());
    }

    protected function getSessionId()
    {
        return Auth::check() ? Auth::id() : session()->getId();
    }

    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::find($request->id);

        $this->getCartInstance()->add([
            'id' => $producto->id,
            'name' => $producto->nombre,
            'price' => $producto->precio,
            'quantity' => $request->cantidad,
            'attributes' => [
                'imagen1' => $producto->imagen1,
                'subtotal' => $producto->precio * $request->cantidad
            ]
        ]);

        return redirect()->back()->with("success", "Item agregado: " . $producto->nombre);
    }

    public function checkout()
    {
        $cartItems = $this->getCartInstance()->getContent();
        return view('carrito.cart', compact('cartItems'));
    }

    public function removeItem(Request $request)
    {
        $this->getCartInstance()->remove($request->id);
        return redirect()->back()->with("success", "Item Eliminado");
    }

    public function clear()
    {
        $this->getCartInstance()->clear();
        return redirect()->back()->with("success", "Carrito Vacío");
    }

    public function hacerPedido()
    {
        $cart = $this->getCartInstance();
        $productos = $cart->getContent();
        
        $pedido_id = DB::table('pedidos')->insertGetId([
            'cliente_Id' => Auth::id() ?? 1,
            'fecha' => now(),
            'iva' => 0,
            'descuento' => 0,
            'total' => $cart->getTotal(),
        ]);

        foreach ($productos as $producto) {
            DB::table('productos_pedido')->insert([
                'pedido_Id' => $pedido_id,
                'producto_Id' => $producto->id,
                'cantidad' => $producto->quantity,
                'precio' => $producto->price,
                'subtotal' => $producto->price * $producto->quantity,
                'descuento' => 0,
            ]);

            $prod = Producto::find($producto->id);
            if ($prod) {
                $prod->decrement('existencia', $producto->quantity);
            }
        }

        $cart->clear();
        return redirect()->back()->with("success", "Pedido realizado con éxito");
    }

    public function updateCantidad(Request $request)
    {
        $cart = $this->getCartInstance();
        $productId = $request->input('id');
        $accion = $request->input('accion');

        $item = $cart->get($productId);

        if ($item) {
            $newQty = $accion === 'incrementar' 
                ? $item->quantity + 1 
                : max(1, $item->quantity - 1);

            $cart->update($productId, [
                'quantity' => [
                    'relative' => false,
                    'value' => $newQty
                ],
                'attributes' => [
                    'subtotal' => $item->price * $newQty
                ]
            ]);
        }

        return redirect()->back();
    }
}