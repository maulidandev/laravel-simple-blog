@extends("layouts.layout")

@section('content')
    <div class="float-right">
        <a href="{{ route("posts.create") }}" class="btn btn-primary">Create Post</a>
    </div>
    <div class="clearfix"></div>

    <div class="card mt-2">
        <div class="card-header">
            <h2>Post</h2>
        </div>
        <div class="card-body">
            @include('layouts._alert')

            <div class="mb-2">
                <div class="float-right">
                    <form>
                        Search : <input type="text" name="search" class="form-control" value="{!! $search !!}">
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>

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
                            <form action="{{ route("posts.destroy", $post->id) }}" method="post" onsubmit="javascrpt:return confirm('Are you sure?');">
                                @csrf
                                <input type="hidden" value="delete" name="_method">

                                <div class="btn-group">
                                    <a href="{{ route("posts.edit", $post->id) }}" class="btn btn-default">Edit</a>
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