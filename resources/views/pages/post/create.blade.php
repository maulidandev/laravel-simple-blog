@extends("layouts.layout")

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Create Post</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route("posts.store") }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old("title") }}">
                            @error('title')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category-id">Category</label>
                            <select id="category-id" class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option selected disabled>-- Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old("category_id", 0) == $category->id ? "selected" : "" }}>{{ $category->title }}</option>    
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old("content") }}</textarea>
                            @error('content')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection