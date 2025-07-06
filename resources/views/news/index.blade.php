@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="fw-bold">Latest News</h1>
                @can('create', App\Models\News::class)
                <a href="{{ route('news.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Create News
                </a>
                @endcan
            </div>

            @forelse($news as $item)
            <div class="card mb-4 shadow-sm">
                @if($item->images->count() > 0)
                <img src="{{ Storage::url($item->images->first()->file_path) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 300px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary">{{ $item->category->name }}</span>
                        <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                    </div>
                    <h2 class="card-title fw-bold">
                        <a href="{{ route('news.show', $item->slug) }}" class="text-decoration-none text-dark">{{ $item->title }}</a>
                    </h2>
                    <p class="card-text">{{ Str::limit(strip_tags($item->content), 200) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('news.show', $item->slug) }}" class="btn btn-outline-primary">Read More</a>
                        <small class="text-muted">By {{ $item->user->name }}</small>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
                No news articles found.
            </div>
            @endforelse

            <div class="d-flex justify-content-center mt-4">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</div>
@endsection