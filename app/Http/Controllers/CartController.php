<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    //
    public function add(Request $request) {
    $request->validate([
        'id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1'
    ]);

    $productos = Producto::find($request->id);

    Cart::add(
        $productos->id,
        $productos->nombre,
        $request->cantidad,
        $productos->precio,
        ['imagen1' => $productos->imagen1]
    );

    return redirect()->back()->with("success", "Item agregado: " . $productos->nombre);
}

    public function checkout(){
        return view('carrito.cart');
    }

    public function removeItem(Request $request){
        Cart::remove($request->rowId);
        return redirect()->back()->with("success","Item Eliminado: ");
    }

    public function clear(){
        Cart::destroy();
        return redirect()->back()->with("success","Carrito Vacio ");
    }

    public function hacerPedido()
    {
        $productos = Cart::content();
        
        // Insertamos en la tabla pedidos y obtenemos el ID
        $pedido_id = DB::table('pedidos')->insertGetId([
            'cliente_Id' => 1,
            'fecha' => now(),
            'iva' => 0,
            'descuento' => 0,
            'total' => 0, 
            //'estado' => 'activo',
        ]);

        $total = 0;

        foreach ($productos as $producto) {
            // Acceder a los valores correctamente
            $subtotal = $producto->qty * $producto->price;

            DB::table('productos_pedido')->insert([
                'pedido_Id' => $pedido_id,
                'producto_Id' => $producto->id,
                'cantidad' => $producto->qty,
                'precio' => $producto->price,
               'subtotal' => $subtotal,
                'descuento' => 0,
            ]);

            $total += $subtotal;

            $prod = DB::table('productos')->where('id', $producto->id)->first();
            
            if ($prod && isset($prod->existencia)) {
                DB::table('productos')->where('id', $producto->id)->update([
                    'existencia' => $prod->existencia - $producto->qty, // Restamos la cantidad vendida
                ]);
            } else {
                dd("Error: Producto con ID {$producto->id} no encontrado o el campo 'existencia' no existe.");
            }
            



        }

        Cart::destroy();
                return redirect()->back()->with("success","Pedido realizado con éxito");

    }
    public function updateCantidad(Request $request)
    {
        $rowId = $request->input('rowId');
        $accion = $request->input('accion');

        $item = Cart::get($rowId);

        /*if ($accion === 'incrementar') {
            Cart::update($rowId, $item->qty + 1);
        } elseif ($accion === 'disminuir' && $item->qty > 1) {
            Cart::update($rowId, $item->qty - 1);
        }*/

        return redirect()->back();
    }
        
    
}
