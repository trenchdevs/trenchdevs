@extends('layouts.admin')


@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Products - Bulk Upload
        </div>

        <div class="card-body p-5">

            <div class="content d-flex justify-content-center m-10">
                <form method="POST" action="{{route('shop.bulk-upload')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="bulkUpload">Product Bulk Upload</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="bulkUpload"
                            accept=".csv"
                            name="student_data"
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

