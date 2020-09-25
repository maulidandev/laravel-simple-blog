@extends("layouts.layout")

@section('content')
    <div class="float-right">
        <a href="{{ route("categories.create") }}" class="btn btn-primary">Create Category</a>
    </div>
    <div class="clearfix"></div>

    <div class="card mt-2">
        <div class="card-header">
            <h2>Category</h2>
        </div>
        <div class="card-body">
            @include('layouts._alert')

            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>#</th>
                </tr>
                @php $index = $categories->firstItem() @endphp
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $index }}.</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <form action="{{ route("categories.destroy", $category->id) }}" method="post" onsubmit="javascript:return confirm('Are you sure?');">
                                @csrf
                                <input type="hidden" value="delete" name="_method">

                                <div class="btn-group">
                                    <a href="{{ route("categories.edit", $category->id) }}" class="btn btn-default border">Edit</a>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>

                    @php $index++ @endphp
                @empty
                    <tr><td colspan="4" class="text-center">No data.</td></tr>
                @endforelse
            </table>
        </div>
    </div>
@endsection