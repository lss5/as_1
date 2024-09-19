@if (session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session('success')}}
    </div>
@endif

@if (session('info'))
<div class="col-md-12">
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if (session('warning'))
<div class="col-md-12">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if ($errors->success->any())
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            @foreach ($errors->success->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif


@if ($errors->info->any())
    <div class="col-md-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            @foreach ($errors->info->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if ($errors->warning->any())
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            @foreach ($errors->warning->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if ($errors->danger->any())
    <div class="col-md-12">
        @foreach ($errors->danger->all() as $error)
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Danger!</h5>
                {{ $error }}
            </div>
        @endforeach
    </div>
@endif