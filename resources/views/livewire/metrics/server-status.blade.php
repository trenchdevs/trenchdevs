<div class="d-flex align-items-center">
    <div class="flex-grow-1">
        <div class="small font-weight-bold text-blue mb-1">Server Status ({{$host}})</div>
        <div class="h5">
            @if ($status == "Online")
                <span class="badge-pill badge-success">{{$status}}</span>
            @else
                <span class="badge-pill badge-warning">{{$status}}</span>
            @endif
        </div>

    </div>
    <div class="ml-2"><i class="fas fa-users fa-2x text-gray-200"></i></div>
    @if ($message)
        <div class="alert alert-warning">
            {{$message}}
        </div>
    @endif
    <button wire:click="checkStatus" class="btn btn-success btn-sm">
        Refresh
    </button>

</div>
