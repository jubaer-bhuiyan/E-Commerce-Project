<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index(): View
    {
        return view('admin.category.index');
    }

    function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
        ]);

        $data['position'] = Category::where('parent_id', $data['parent_id'] ?? null)->max('position') + 1;

        $category = Category::create($data);

        return response()->json(['success' => true, 'message' => 'Category created successfully', 'category' => $category]);
    }
}
