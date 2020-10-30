<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old("name", $user->name) }}">
    @error('name')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old("email", $user->email) }}">
    @error('email')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="email_confirmation">Email Confirmation</label>
    <input type="text" class="form-control @error('email_confirmation') is-invalid @enderror" id="email_confirmation" name="email_confirmation" value="{{ old("email_confirmation", $user->email) }}">
    @error('email_confirmation')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old("password") }}">
    @error('password')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="password_confirmation">Password Confirmation</label>
    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="{{ old("password_confirmation") }}">
    @error('password_confirmation')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
        <option selected disabled>-- Role --</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old("role", $user->role_id) == $role->id ? "selected" : "" }}>{{ $role->name }}</option>
        @endforeach
    </select>
    @error('role')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>