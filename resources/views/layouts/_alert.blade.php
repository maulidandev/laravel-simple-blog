@if($message = session("success"))
    <div class="alert alert-success">
        <span class="font-weight-bold">Success!</span> {{ $message }}
    </div>
@endif