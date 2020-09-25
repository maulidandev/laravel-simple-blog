@if($message = session("success"))
    <div class="alert alert-success">
        <span class="font-weight-bold">Berhasil!</span> {{ $message }}
    </div>
@endif