@extends('layouts.admin')

@section('content')
    @if(!$portfolio_details->id)
        <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5">
            <div class="position-relative">
                <div class="row align-items-center justify-content-between">
                    <div class="col position-relative">
                        <h2 class="text-primary">Welcome to TrenchDevs!</h2>
                        <p class="text-gray-700">
                            Thanks for your interest in joining the team - you can start by filling up your portfolio
                            page
                        </p>
                        <a class="btn btn-teal" href="{{route('portfolio.edit')}}">Get started
                            <i class="ml-1" data-feather="arrow-right"></i>
                        </a>
                    </div>
                    <div class="col d-none d-md-block text-right pt-3">
                        <img class="img-fluid mt-n5"
                             src="admin/assets/img/drawkit/color/drawkit-content-man-alt.svg"
                             style="max-width: 25rem;"/>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-blue h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small font-weight-bold text-blue mb-1">Active Users</div>
                            <div class="h5">3</div>
{{--                            <div--}}
{{--                                class="text-xs font-weight-bold text-success d-inline-flex align-items-center">--}}
{{--                                <i class="mr-1" data-feather="trending-up"></i>12%--}}
{{--                            </div>--}}
                        </div>
                        <div class="ml-2"><i class="fas fa-users fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div
                class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-purple h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small font-weight-bold text-purple mb-1">User Logins</div>
                            <div class="h5">10</div>
{{--                            <div--}}
{{--                                class="text-xs font-weight-bold text-danger d-inline-flex align-items-center">--}}
{{--                                <i class="mr-1" data-feather="trending-down"></i>3%--}}
{{--                            </div>--}}
                        </div>
                        <div class="ml-2"><i class="fas fa-users fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-green h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small font-weight-bold text-green mb-1">Number of porfolio visitors</div>
                            <div class="h5">3</div>
{{--                            <div--}}
{{--                                class="text-xs font-weight-bold text-success d-inline-flex align-items-center">--}}
{{--                                <i class="mr-1" data-feather="trending-up"></i>12%--}}
{{--                            </div>--}}
                        </div>
                        <div class="ml-2"><i class="fas fa-mouse-pointer fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div
                class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-yellow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small font-weight-bold text-yellow mb-1">Conversion rate</div>
                            <div class="h5">1.23%</div>
                            <div
                                class="text-xs font-weight-bold text-danger d-inline-flex align-items-center">
                                <i class="mr-1" data-feather="trending-down"></i>1%
                            </div>
                        </div>
                        <div class="ml-2"><i class="fas fa-percentage fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
