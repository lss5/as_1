@if (session('success'))
<div class="alert alert-success my-2" role="alert">
    {{ session('success')}}
</div>
@endif
@if (session('danger'))
<div class="alert alert-danger my-2" role="alert">
    {{ session('danger')}}
</div>
@endif
@if (session('warning'))
<div class="alert alert-warning my-2" role="alert">
    {{ session('warning')}}
</div>
@endif
@if (session('info'))
<div class="alert alert-info my-2" role="alert">
    {{ session('info')}}
</div>
@endif