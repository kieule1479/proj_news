@if (session('zvn_notify'))
    <div class="alert alert-success">
        {{ session('zvn_notify') }}
    </div>
@endif
