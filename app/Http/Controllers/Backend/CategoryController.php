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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    // use Illuminate\Http\Request;

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
  public function destroy($id)
{
    $category = Category::withTrashed()->findOrFail($id);

    // Skip if already soft deleted
    if ($category->deleted_at) {
        return response()->json(['success' => false, 'message' => 'Already deleted']);
    }

    // Soft delete, but set deleted_at = created_at
    $category->deleted_at = $category->created_at;
    $category->save();

    return response()->json(['success' => true]);
}

}
