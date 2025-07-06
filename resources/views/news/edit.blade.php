@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h2 class="h5 mb-0 fw-bold">Edit News Article</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('news.update', $news->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('news._form')
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('news.show', $news->slug) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update News</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple confirmation before deleting media
    document.querySelectorAll('[name="delete_media[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                if (!confirm('Are you sure you want to delete this media?')) {
                    this.checked = false;
                }
            }
        });
    });
</script>
@endsection