<?php
namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::latest()->get();
        return view('blog.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('blog.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        BlogCategory::create($data);

        return redirect()->route('blog.categories.index')->with('status', 'Category created.');
    }

    public function edit(BlogCategory $category)
    {
        return view('blog.categories.edit', compact('category'));
    }

    public function update(Request $request, BlogCategory $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug,' . $category->id,
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $category->update($data);

        return redirect()->route('blog.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(BlogCategory $category)
    {
        $category->delete();
        return redirect()->route('blog.categories.index')->with('status', 'Category deleted.');
    }
}
