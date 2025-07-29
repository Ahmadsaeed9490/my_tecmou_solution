<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
         return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Set destination to public/storage/categories
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('storage/categories');

            // Create the folder if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move file to public/storage/categories
            $file->move($destinationPath, $filename);

            // Save relative path
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
        'sort_order' => 'nullable|integer',
        'parent_id' => 'nullable|exists:categories,id',
        'image' => 'nullable|image|max:2048',
    ]);

    $category = Category::findOrFail($id);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('categories', 'public');
    }

    $category->update($validated);

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
}


 public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
}
}
