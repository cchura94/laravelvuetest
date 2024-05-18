<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::orderBy('id', 'desc')->with('cliente', 'user', 'productos')->paginate(10);

        return response()->json($pedidos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "cliente_id" => "required"
        ]);

        // cliente_id
        $pedido = new Pedido();
        // fecha pedido
        $pedido->fecha_pedido = date('Y-m-d H:i:s');
        $pedido->cliente_id = $request->cliente_id;
        $pedido->user_id = Auth::id();
        $pedido->save();

        // asignar productos al pedido
        $productos = $request->productos;
        foreach ($productos as $prod) {
            $producto_id = $prod["producto_id"];
            $cantidad = $prod["cantidad"];

            $pedido->productos()->attach($producto_id, ["cantidad" => $cantidad]);
        }

        // actualizar pedido
        $pedido->estado = 3;
        $pedido->update();

        return response()->json(["message" => "Pedido registrado"], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
