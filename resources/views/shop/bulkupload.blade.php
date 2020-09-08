@extends('layouts.admin')


@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Products - Bulk Upload
        </div>

        <div class="card-body p-5">
{{--            <form action="upload.php" method="post" enctype="multipart/form-data">--}}
{{--                Select image to upload:--}}
{{--                <input type="file" name="fileToUpload" id="fileToUpload">--}}
{{--                <input type="submit" value="Upload Image" name="submit">--}}
{{--            </form>--}}

            <div class="content d-flex justify-content-center m-10">
                <form method="POST" action="/shop/products/upload" enctype="multipart/form-data">
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

