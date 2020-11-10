@extends("layouts.layout")

@section('content')
    <div class="float-right">
        <a href="{{ route("admin.categories.create") }}" class="btn btn-primary">Create Category</a>
    </div>
    <div class="clearfix"></div>

    <div class="card mt-2">
        <div class="card-header">
            <h2>Category</h2>
        </div>
        <div class="card-body">
            @include('layouts._alert')

            <form>
                <div class="row mb-2">
                    <div class="offset-md-8 col-md-4">
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
                    <th>Slug</th>
                    <th width="1">#</th>
                </tr>
                @php $index = $categories->firstItem() @endphp
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $index }}.</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <form action="{{ route("admin.categories.destroy", $category->id) }}" method="post" onsubmit="javascript:return confirm('Are you sure?');">
                                @csrf
                                <input type="hidden" value="delete" name="_method">

                                @if(!CategoryHelper::isUncategorize($category->id))
                                    <div class="btn-group">
                                        <a href="{{ route("admin.categories.edit", $category->id) }}" class="btn btn-default border">Edit</a>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                @endif
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
