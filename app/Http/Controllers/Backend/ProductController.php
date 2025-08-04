<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand')->orderBy('id', 'desc')->get();
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }



    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:products,slug',
                'sku' => 'nullable|string|max:255',
                'model' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'specifications' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'discount' => 'nullable|numeric|min:0|max:100',
                'stock_quantity' => 'nullable|integer|min:0',
                'warranty' => 'nullable|string|max:255',
                'status' => 'required|in:1,0',
                'is_featured' => 'nullable|boolean',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'gallery_images' => 'nullable|array',
                'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
            ]);

            // Collect data
            $data = $request->except(['thumbnail', 'gallery_images']);

            // Generate slug if not provided
            $data['slug'] = $request->slug ?: Str::slug($request->name);

            // Ensure boolean value
            $data['is_featured'] = $request->boolean('is_featured');

            // Upload thumbnail
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
            }

            // Upload gallery images
            if ($request->hasFile('gallery_images')) {
                $images = [];
                foreach ($request->file('gallery_images') as $image) {
                    $images[] = $image->store('products/gallery', 'public');
                }
                $data['gallery_images'] = json_encode($images);
            }

            // Create product
            Product::create($data);

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors below.');

        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create product. Please try again. Error: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        try {
            $product = Product::with(['category', 'brand'])->findOrFail($id);
            return response()->json($product);
        } catch (\Exception $e) {
            Log::error('Product edit failed: ' . $e->getMessage());
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:products,slug,' . $id,
                'sku' => 'nullable|string|max:255',
                'model' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'specifications' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'discount' => 'nullable|numeric|min:0|max:100',
                'stock_quantity' => 'nullable|integer|min:0',
                'warranty' => 'nullable|string|max:255',
                'status' => 'required|in:1,0',
                'is_featured' => 'nullable|boolean',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'gallery_images' => 'nullable|array',
                'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
            ]);

            $data = $request->except(['thumbnail', 'gallery_images']);
            $data['slug'] = $request->slug ?: Str::slug($request->name);
            $data['is_featured'] = $request->boolean('is_featured');

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
            }

            if ($request->hasFile('gallery_images')) {
                $images = [];
                foreach ($request->file('gallery_images') as $image) {
                    $images[] = $image->store('products/gallery', 'public');
                }
                $data['gallery_images'] = json_encode($images);
            }

            $product = Product::findOrFail($id);
            $product->update($data);

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors below.');
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update product. Please try again.');
        }
    }

 public function toggleStatus(Request $request)
{
    $product = Product::find($request->id);

    if ($product) {
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete thumbnail
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }

            // Delete gallery images
            if ($product->gallery_images) {
                $images = json_decode($product->gallery_images, true);
                if (is_array($images)) {
                    foreach ($images as $img) {
                        if (Storage::disk('public')->exists($img)) {
                            Storage::disk('public')->delete($img);
                        }
                    }
                }
            }

            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage(), [
                'product_id' => $id,
                'exception' => $e
            ]);

            return redirect()->back()->with('error', 'Failed to delete product. Please try again.');
        }
    }
}