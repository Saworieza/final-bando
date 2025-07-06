<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $news->title ?? '') }}" required>
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Category</label>
    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
        <option value="">Select Category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ (old('category_id', $news->category_id ?? '') == $category->id ? 'selected' : '') }}>
            {{ $category->name }}
        </option>
        @endforeach
    </select>
    @error('category_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="content" class="form-label">Content</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $news->content ?? '') }}</textarea>
    @error('content')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label">Images</label>
    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
    <small class="text-muted">Upload multiple images (JPEG, PNG, JPG, GIF - max 2MB each)</small>
    
    @if(isset($news) && $news->images->count() > 0)
    <div class="mt-3">
        <h6>Current Images</h6>
        <div class="row">
            @foreach($news->images as $image)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="{{ Storage::url($image->file_path) }}" class="card-img-top" alt="News image">
                    <div class="card-body p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="delete_media[]" value="{{ $image->id }}" id="delete_image_{{ $image->id }}">
                            <label class="form-check-label text-danger" for="delete_image_{{ $image->id }}">
                                Delete
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<div class="mb-4">
    <label class="form-label">Files</label>
    <input type="file" class="form-control" id="files" name="files[]" multiple>
    <small class="text-muted">Upload multiple files (PDF, DOC, DOCX - max 5MB each)</small>
    
    @if(isset($news) && $news->files->count() > 0)
    <div class="mt-3">
        <h6>Current Files</h6>
        <ul class="list-group">
            @foreach($news->files as $file)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $file->original_name }}</span>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="delete_media[]" value="{{ $file->id }}" id="delete_file_{{ $file->id }}">
                    <label class="form-check-label text-danger" for="delete_file_{{ $file->id }}">
                        Delete
                    </label>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>