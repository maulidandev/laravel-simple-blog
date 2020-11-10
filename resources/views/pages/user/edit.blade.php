@extends("layouts.layout")

@section("content")
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit User</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route("users.update", $user->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="put">

                        @include("pages.user._form")

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
