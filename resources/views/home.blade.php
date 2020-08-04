@extends('layouts.admin')

@section('content')
    <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5">
        <div class="position-relative">
            <div class="row align-items-center justify-content-between">
                <div class="col position-relative">
                    <h2 class="text-primary">TEST Welcome back, your dashboard is ready!</h2>
                    <p class="text-gray-700">Great job, your affiliate dashboard is ready to go! You can
                        view sales, generate links, prepare coupons, and download affiliate reports using
                        this dashboard.</p>
                    <a class="btn btn-teal" href="#!">Get started<i class="ml-1"
                                                                    data-feather="arrow-right"></i></a>
                </div>
                <div class="col d-none d-md-block text-right pt-3"><img class="img-fluid mt-n5"
                                                                        src="admin/assets/img/drawkit/color/drawkit-content-man-alt.svg"
                                                                        style="max-width: 25rem;"/></div>
            </div>
        </div>
    </div>
@endsection
