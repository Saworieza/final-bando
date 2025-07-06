<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\NewsMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class NewsController extends Controller
{
    /**
     * Controller constructor
     */
    public function __construct()
    {
        // Apply auth middleware to all methods except index and show
        $this->middleware('auth')->except(['index', 'show']);
        
        // Authorization middleware
        $this->middleware('can:create,App\Models\News')->only(['create', 'store']);
        $this->middleware('can:update,news')->only(['edit', 'update']);
        $this->middleware('can:delete,news')->only('destroy');
    }

    /**
     * Display a listing of news articles
     */
    public function index()
    {
        try{
            $news = News::with(['category', 'user'])
                        // ->where('is_published', true)
                        ->latest()
                        ->paginate(10);

            return view('news.index', compact('news'));
        }catch (\Exception $e) {
            dd($e->getMessage()); // This will show you the exact error
        }
    }

    /**
     * Show the form for creating a new news article
     */
    public function create()
    {
        \Log::info('Categories count: ' . Category::count()); // Check categories
        $categories = Category::all();
        
        // Temporary dump (remove after debugging)
        // dd(view('news.create', compact('categories')));
        
        return view('news.create', compact('categories'));
    }

    /**
     * Store a newly created news article
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $news = News::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
        ]);

        $this->handleMediaUpload($request, $news);

        return redirect()->route('news.show', $news->slug)
            ->with('success', 'News created successfully!');
    }

    /**
     * Display the specified news article
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing a news article
     */
    public function edit(News $news)
    {
        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified news article
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'delete_media' => 'nullable|array',
            'delete_media.*' => 'exists:news_media,id',
        ]);

        $news->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
        ]);

        // Handle media deletion
        if (!empty($validated['delete_media'])) {
            $mediaToDelete = NewsMedia::whereIn('id', $validated['delete_media'])->get();
            foreach ($mediaToDelete as $media) {
                Storage::delete($media->file_path);
                $media->delete();
            }
        }

        $this->handleMediaUpload($request, $news);

        return redirect()->route('news.show', $news->slug)
            ->with('success', 'News updated successfully!');
    }

    /**
     * Remove the specified news article
     */
    public function destroy(News $news)
    {
        // Delete associated media files
        foreach ($news->media as $media) {
            Storage::delete($media->file_path);
        }

        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'News deleted successfully!');
    }

    /**
     * Handle media file uploads
     */
    protected function handleMediaUpload(Request $request, News $news)
    {
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('news/images', 'public');
                NewsMedia::create([
                    'news_id' => $news->id,
                    'file_path' => $path,
                    'file_type' => 'image',
                    'original_name' => $image->getClientOriginalName(),
                ]);
            }
        }

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('news/files', 'public');
                NewsMedia::create([
                    'news_id' => $news->id,
                    'file_path' => $path,
                    'file_type' => 'file',
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }
    }
}