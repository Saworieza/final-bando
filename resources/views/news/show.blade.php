@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <article>
                <header class="mb-4">
                    <h1 class="fw-bold mb-3">{{ $news->title }}</h1>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="badge bg-primary">{{ $news->category->name }}</span>
                            <span class="text-muted ms-2">Posted by {{ $news->user->name }}</span>
                        </div>
                        <div class="text-muted">{{ $news->created_at->format('F j, Y') }}</div>
                    </div>
                </header>

                @if($news->images->count() > 0)
                <div class="mb-4">
                    <div id="newsImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($news->images as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <img src="{{ Storage::url($image->file_path) }}" class="d-block w-100 rounded" alt="News image {{ $key + 1 }}" style="max-height: 500px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        @if($news->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#newsImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#newsImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        @endif
                    </div>
                </div>
                @endif

                <div class="news-content mb-5">
                    {!! nl2br(e($news->content)) !!}
                </div>

                @if($news->files->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Attachments</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($news->files as $file)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $file->original_name }}</span>
                                <a href="{{ Storage::url($file->file_path) }}" class="btn btn-sm btn-outline-primary" download>
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <footer class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <div>
                        @can('update', $news)
                        <a href="{{ route('news.edit', $news->slug) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @endcan
                    </div>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to News
                    </a>
                </footer>
            </article>
        </div>
    </div>
</div>
@endsection