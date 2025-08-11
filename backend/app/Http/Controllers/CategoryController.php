<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
    use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    public function index()

    {
        $categories = Category::where('status', 1)
    ->whereNull('deleted_at')
    ->get();
        $categories = Category::withTrashed()->get();
         return view('admin.categories.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'parent_id' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);
            $validated['parent_id'] = $request->input('parent_id') ?: 0;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('storage/categories');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'categories/' . $filename;
        }
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category); // This sends category data as JSON
    }
   public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|boolean',
        'parent_id' => 'nullable|exists:categories,id',
        'image' => 'nullable|image|max:2048',
    ]);

    $category = Category::findOrFail($id);

    // ✅ Handle image upload
    if ($request->hasFile('image')) {
        // Optional: delete old image
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        // Store new image in storage/app/public/categories
        $validated['image'] = $request->file('image')->store('categories', 'public');
    } else {
        // Keep old image if no new file uploaded
        $validated['image'] = $category->image;
    }

    // ✅ Set default parent_id to 0 if null
    $validated['parent_id'] = $request->input('parent_id') ?: 0;

    // ✅ Update the category
    $category->update($validated);

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
}

    public function toggleStatus(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->status = $request->status;
            $category->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function getSubcategories($id)
    {
        try {
            $subcategories = SubCategory::where('category_id', $id)->get();
            Log::info('Subcategories for category ' . $id . ': ' . $subcategories->count());
            return response()->json($subcategories);
        } catch (\Exception $e) {
            Log::error('Error getting subcategories: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch subcategories'], 500);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

}
