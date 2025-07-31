<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller

{
    public function create()
{
    $brand = new Brand(); // empty instance
    return view('admin.brands.create', compact('brand'));
}

    
    public function index()
{
    $brands = Brand::all();
    $brand = new Brand(); // Empty instance for the create modal
    return view('admin.brands.index', compact('brands', 'brand'));
}


public function edit($id)
{
    $brand = Brand::findOrFail($id);
    $brand->logo_url = $brand->logo ? asset('storage/' . $brand->logo) : null;

    return response()->json($brand);
}




   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'status' => 'required|boolean',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $brand = new Brand();
    $brand->name = $request->input('name');
    $brand->slug = $request->input('slug');
    $brand->description = $request->input('description');
    $brand->website = $request->input('website');
    $brand->status = $request->input('status');
    $brand->sort_order = $request->input('sort_order');

    if ($request->hasFile('logo')) {
        // Set destination to public/storage/brands
        $file = $request->file('logo');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('storage/brands');

        // Create the folder if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Move file to public/storage/brands
        $file->move($destinationPath, $filename);

        // Save relative path to database
        $brand->logo = 'brands/' . $filename;
    }

    $brand->save();

    return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
}


   

public function toggleStatus(Request $request)
{
    $brand = brand::find($request->id);

    if ($brand) {
        $brand->status = $request->status;
        $brand->save();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
}

    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully!');
    }
}