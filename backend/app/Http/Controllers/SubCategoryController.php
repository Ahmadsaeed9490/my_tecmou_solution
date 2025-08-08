<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::with(['category'])->withTrashed()->get();
        $categories = Category::all();
        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('subcategories', 'public');
        }

        SubCategory::create($validated);
        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory created successfully.');
    }

    public function edit($id)
    {
        return response()->json(SubCategory::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $subcategory = SubCategory::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $validated['image'] = $request->file('image')->store('subcategories', 'public');
        } else {
            $validated['image'] = $subcategory->image;
        }

        $subcategory->update($validated);
        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory updated successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $subcategory = SubCategory::find($request->id);
        if ($subcategory) {
            $subcategory->status = $request->status;
            $subcategory->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::withTrashed()->findOrFail($id);
        if ($subcategory->deleted_at) {
            return response()->json(['success' => false, 'message' => 'Already deleted']);
        }
        $subcategory->delete();
        return response()->json(['success' => true]);
    }
}
