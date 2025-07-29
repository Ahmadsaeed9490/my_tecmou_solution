<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller

{
    
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->description = $request->input('description');
        $brand->website = $request->input('website');
        $brand->status = $request->input('status');
        $brand->sort_order = $request->input('sort_order');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            Storage::disk('public')->put('brands/' . $filename, file_get_contents($logo));
            $brand->logo = 'brands/' . $filename;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Brand::find($id);
        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->description = $request->input('description');
        $brand->website = $request->input('website');
        $brand->status = $request->input('status');
        $brand->sort_order = $request->input('sort_order');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            Storage::disk('public')->put('brands/' . $filename, file_get_contents($logo));
            $brand->logo = 'brands/' . $filename;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully!');
    }
}