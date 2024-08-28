<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\QuickOrder;
use Illuminate\Http\Request;

class QuickOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * CREATE QUICK ORDER
     *
     * @unauthenticated
     *
     * @bodyParam customer_name string required The customer name. Example: Cristiano Ronaldo
     * @bodyParam phone_number numeric required The user's phone. Example:+38087659800
     * @bodyParam product_id numeric required The product's id. Example:2
     * @bodyParam quantity numeric required The quantity. Example:5
     * @bodyParam delivery_address string required Delivery address. Example: city London. st Bray ton beach 27
     *
     * @response {
     *   "message": "Quick order successfully received."
     *  }
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'delivery_address' => 'required|string',
        ]);

        $quickOrder =new QuickOrder();
        $quickOrder->customer_name=$request->customer_name;
        $quickOrder->phone_number=$request->phone_number;
        $quickOrder->product_id=$request->product_id;
        $quickOrder->quantity=$request->quantity;
        $quickOrder->delivery_address=$request->delivery_address;
        $quickOrder->save();

       return response()->json(['message' => 'Quick order successfully added']);

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
