@extends("layouts.layout")

@section('content')
    <div class="float-right">
        <a href="{{ route("admin.users.create") }}" class="btn btn-primary">Create User</a>
    </div>
    <div class="clearfix"></div>

    <div class="card mt-2">
        <div class="card-header">
            <h2>User Management</h2>
        </div>
        <div class="card-body">
            @include('layouts._alert')

            <form>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Filter</label>
                            <div class="input-group">
                                <select name="role" class="form-control">
                                    <option value="">Filter Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $role_filter ? "selected" : "" }}>{{ $role->name }}</option>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 236px;">#</th>
                </tr>
                @php $index = $users->firstItem() @endphp
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $index }}.</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <form class="float-left" action="{{ route("admin.users.destroy", $user->id) }}" method="post" onsubmit="javascript:return confirm('Are you sure?');">
                                @csrf
                                <input type="hidden" value="delete" name="_method">
{{--                                @if(!CategoryHelper::isUncategorize($user->id))--}}
                                    <div class="btn-group">
                                        <a href="{{ route("admin.users.edit", $user->id) }}" class="btn btn-default border">Edit</a>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        &nbsp;
                                    </div>
{{--                                @endif--}}
                            </form>
                            <form class="float-left" action="{{ route("admin.users.block", $user->id) }}" method="post" onsubmit="javascript:return confirm('Are you sure?');">
                                @csrf

                                @if(!$user->is_block)
                                    <button type="submit" class="btn btn-primary">Block</button>
                                @else
                                    <button type="submit" class="btn border">UnBlock</button>
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
