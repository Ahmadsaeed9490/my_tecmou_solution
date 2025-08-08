<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // ✅ You missed this
use App\Models\ProductPrice;
use App\Models\Product; // ✅ Needed for products dropdown
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
   public function index()
{
    $productPrices = ProductPrice::withTrashed()->with('product')->get();
    $products = Product::all();

    return view('admin.product-prices.index', compact('productPrices', 'products'));
}

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // ✅ Required to link price to product
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'final_price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
        ]);

        ProductPrice::create($request->all());

        return redirect()->route('admin.product-prices.index')->with('success', 'Price added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // ✅ include this in update too
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'final_price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
        ]);

        $price = ProductPrice::findOrFail($id);
        $price->update($request->all());

        return redirect()->route('admin.product-prices.index')->with('success', 'Price updated successfully.');
    }

public function edit($id)
{
    $price = ProductPrice::with('product')->findOrFail($id);

    return response()->json([
        'id' => $price->id,
        'product_id' => $price->product_id,
        'min_price' => $price->min_price,
        'max_price' => $price->max_price,
        'discount_percent' => $price->discount_percent,
        'final_price' => $price->final_price,
        'currency' => $price->currency,
        'product_name' => $price->product->name ?? '',
    ]);
}


    public function destroy($id)
    {
        $price = ProductPrice::findOrFail($id);
        $price->delete();

        return redirect()->back()->with('success', 'Product price soft deleted successfully.');
    }
}
