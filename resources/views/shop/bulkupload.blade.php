@extends('layouts.admin')


@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Products - Bulk Upload
        </div>


        <div class="card-body p-3">

            @if(session()->has('errors'))
                <div class="alert alert-danger p-2 pb-0">
                    {{ session()->get('errors')  }}
                </div>
            @elseif(session()->has('success'))
                <div class="alert alert-success p-2 pb-0">
                    {{ session()->get('success') }}
                </div>
            @elseif(session()->has('success w/ errors'))
                <div class="alert alert-warning p-2 pb-0">
                    {{ session()->get('success w/ errors') }}
                </div>
            @endif

            <div class="content d-flex justify-content-center p-4">
                <form method="POST" action="{{route('shop.bulk-upload')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="bulkUpload">Product Bulk Upload</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="bulkUpload"
                            accept=".csv"
                            name="product_data"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-md" style="cursor: pointer;">
                        Upload
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

