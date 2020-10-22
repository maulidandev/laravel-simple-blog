<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old("title", $post->title) }}">
    @error('title')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="category-id">Category</label>
    <select id="category-id" class="form-control @error('category_id') is-invalid @enderror" name="category_id">
        <option selected disabled>-- Category --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old("category_id", $post->id > 0 ? $post->category_id : null) == $category->id ? "selected" : "" }}>{{ $category->title }}</option>
        @endforeach
    </select>
    @error('category_id')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="new_category">New Category</label>
    <input type="text" class="form-control @error('new_category') is-invalid @enderror" id="new_category" name="new_category" value="{{ old("new_category") }}">
    @error('new_category')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
    <div class="text-muted small">Wajib jika memilih "New Category"</div>
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old("content", $post->content) }}</textarea>
    @error('content')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>