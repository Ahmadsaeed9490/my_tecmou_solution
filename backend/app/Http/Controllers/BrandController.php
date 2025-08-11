<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with(['category'])->withTrashed()->get();
        $brand = new Brand();

        // ✅ Sirf active aur non-deleted categories
        $categories = Category::where('status', 1)
                              ->whereNull('deleted_at')
                              ->get();

        return view('admin.brands.index', compact('brands', 'brand', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)
                              ->whereNull('deleted_at')
                              ->get();

        return view('admin.brands.create', compact('categories'));
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        $categories = Category::where('status', 1)
                              ->whereNull('deleted_at')
                              ->get();

        return view('admin.brands.edit', compact('brand', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->category_id = $request->input('category_id');
        $brand->description = $request->input('description');
        $brand->website = $request->input('website');
        $brand->status = $request->input('status');

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('storage/brands');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $brand->logo = 'brands/' . $filename;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
    }

    // ✅ JSON edit data (for Ajax modal)
    public function editAjax($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->logo_url = $brand->logo ? asset('storage/' . $brand->logo) : null;

        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Brand::findOrFail($id);

        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->category_id = $request->input('category_id');
        $brand->description = $request->input('description');
        $brand->website = $request->input('website');
        $brand->status = $request->input('status');

        if ($request->hasFile('logo')) {
            if ($brand->logo && file_exists(public_path('storage/' . $brand->logo))) {
                unlink(public_path('storage/' . $brand->logo));
            }

            $file = $request->file('logo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('storage/brands');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $brand->logo = 'brands/' . $filename;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
    }

    public function toggleStatus(Request $request)
    {
        Log::info('Toggle Status Request:', $request->all());
        $brand = Brand::find($request->id);

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
