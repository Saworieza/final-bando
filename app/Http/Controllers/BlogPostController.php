<?php
namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category', 'author')->latest()->get();
        return view('blog.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('blog.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'body' => 'required|string',
            'file' => 'nullable|mimes:pdf|max:20480', // 20MB
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('blog_pdfs', 'public');
        }

        BlogPost::create($data);

        return redirect()->route('blog.posts.index')->with('status', 'Blog post created.');
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::all();
        return view('blog.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug,' . $post->id,
            'blog_category_id' => 'required|exists:blog_categories,id',
            'body' => 'required|string',
            'file' => 'nullable|mimes:pdf|max:20480',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        if ($request->hasFile('file')) {
            if ($post->file) Storage::disk('public')->delete($post->file);
            $data['file'] = $request->file('file')->store('blog_pdfs', 'public');
        }

        $post->update($data);

        return redirect()->route('blog.posts.index')->with('status', 'Blog post updated.');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->file) Storage::disk('public')->delete($post->file);
        $post->delete();

        return redirect()->route('blog.posts.index')->with('status', 'Post deleted.');
    }

    // Public blog list
    public function publicIndex()
    {
        $posts = BlogPost::with('category', 'author')->latest()->get();
        return view('blog.public.index', compact('posts'));
    }

    // Public post details
    public function publicShow($slug)
    {
        $post = BlogPost::where('slug', $slug)->with('category', 'author')->firstOrFail();
        return view('blog.public.show', compact('post'));
    }

    // Filter blog by category
    public function byCategory($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        $posts = BlogPost::where('blog_category_id', $category->id)->latest()->get();

        return view('blog.public.index', [
            'posts' => $posts,
            'category' => $category,
        ]);
    }

}
