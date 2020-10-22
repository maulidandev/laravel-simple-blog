@extends("layouts.layout")

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Create Category</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route("categories.store") }}" method="post">
                        @csrf

                        @include("pages.category._form")

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection