@extends("layouts.layout")

@section('content')
    <div class="float-right">
        <a href="{{ route("admin.posts.create") }}" class="btn btn-primary">Create Post</a>
    </div>
    <div class="clearfix"></div>

    <div class="card mt-2">
        <div class="card-header">
            <h2>Post</h2>
        </div>
        <div class="card-body">
            @include('layouts._alert')

            <form>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Filter</label>
                            <div class="input-group">
                                <select name="category" class="form-control">
                                    <option value="">Filter Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $category_filter ? "selected" : "" }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="offset-md-5 col-md-4">
                        <div class="form-group">
                            <label>Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ $search }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Content</th>
                    <th width="1">#</th>
                </tr>

                @php $index = $posts->firstItem() @endphp
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $index }}.</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>
                            <form action="{{ route("admin.posts.destroy", $post->id) }}" method="post" onsubmit="javascrpt:return confirm('Are you sure?');">
                                @csrf
                                <input type="hidden" value="delete" name="_method">

                                <div class="btn-group">
                                    <a href="{{ route("admin.posts.edit", $post->id) }}" class="btn btn-default">Edit</a>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>

                    @php $index++ @endphp
                @empty
                    <tr>
                        <td colspan="5">No data.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection
