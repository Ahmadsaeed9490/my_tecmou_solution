<?php

namespace App\Http\Controllers;

use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function index()
    {
        $productPrices = ProductPrice::all();
        return view('admin.product-prices.index', compact('productPrices'));
    }

    public function store(Request $request)
{
    $request->validate([
        'min_price' => 'required|numeric|min:0',
        'max_price' => 'required|numeric|gte:min_price',
        'discount_percent' => 'required|numeric|min:0|max:100',
        'final_price' => 'required|numeric|min:0',
        'currency' => 'required|string|max:10',
    ]);

    ProductPrice::create($request->all());

    // Corrected route name
    return redirect()->route('admin.product-prices.index')->with('success', 'Price added successfully.');
}

public function update(Request $request, $id)
{
   $request->validate([
    'min_price' => 'required|numeric|min:0',
    'max_price' => 'required|numeric|gte:min_price',
    'discount_percent' => 'required|numeric|min:0|max:100',
    'final_price' => 'required|numeric|min:0',
    'currency' => 'required|string|max:10',
], [
    'max_price.gte' => 'Max price must be greater than or equal to Min price.',
    'currency.max' => 'Currency must be less than or equal to 10 characters.',
]);

    $price = ProductPrice::findOrFail($id);
    $price->update($request->all());

    // Corrected route name
    return redirect()->route('admin.product-prices.index')->with('success', 'Price updated successfully.');
}


    public function edit($id)
    {
        $price = ProductPrice::findOrFail($id);
        return response()->json($price);
    }

    
    public function destroy($id)
    {
        $price = ProductPrice::findOrFail($id);
        $price->delete();

        return response()->json(['success' => true]);
    }
}

