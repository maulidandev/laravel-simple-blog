<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old("title", $category->title) }}">
    @error('title')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>