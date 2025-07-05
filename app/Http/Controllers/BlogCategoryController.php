<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::withCount('posts')->orderBy('name')->get();
        return view('admin.blog.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        BlogCategory::create($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('status', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $category)
    {
        $category->loadCount('posts');
        return view('admin.blog.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $category)
    {
        return view('admin.blog.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug,' . $category->id,
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $category->update($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('status', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $category)
    {
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return redirect()->route('admin.blog.categories.index')
                ->with('error', 'Cannot delete category with existing posts.');
        }

        $category->delete();

        return redirect()->route('admin.blog.categories.index')
            ->with('status', 'Category deleted successfully.');
    }
}