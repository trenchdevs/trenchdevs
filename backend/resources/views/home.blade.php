@extends('layouts.admin')

@section('scripts')
    <script data-search-pseudo-elements defer
            src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
@endsection

@section('content')

    @php
        /** @var \App\Domains\TrenchDevs\Repositories\AdminDashboardMetrics $dashboard_metrics */
    @endphp


    @if(!$portfolio_details->id && site()->theme === 'trenchdevs')
        <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5">
            <div class="position-relative">
                <div class="row align-items-center justify-content-between">
                    <div class="col position-relative">
                        <h2 class="text-primary">Welcome to TrenchDevs!</h2>
                        <p class="text-gray-700">
                            Thanks for your interest in joining the team - you can start by filling up your portfolio
                            page
                        </p>
                        @if(route_has_all('portfolio.edit'))
                            <a class="btn btn-teal" href="{{route('portfolio.edit')}}">Get started
                                <i class="ml-1" data-feather="arrow-right"></i>
                            </a>
                        @endif
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
                            <div class="small font-weight-bold text-blue mb-1">TrenchDevs Users</div>
                            <div class="h5">{{$dashboard_metrics->getActiveTrenchDevUsers()}}</div>
                            <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                <i class="mr-1" data-feather="info"></i>Active
                            </div>
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
                            <div class="h5">
                                {{$dashboard_metrics->getUserLoginsPastMonth()}}
                            </div>
                            <div
                                class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                <i class="mr-1" data-feather="calendar"></i>Past month
                            </div>
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
                            <div class="small font-weight-bold text-green mb-1">TrenchDevs Visitors</div>
                            <div class="h5">
                                {{$dashboard_metrics->getPageVisitors() }} visits
                            </div>
                            <div
                                class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                <i class="mr-1" data-feather="calendar"></i>Past Month
                            </div>
                        </div>
                        <div class="ml-2"><i class="fas fa-home fa-2x text-gray-200"></i></div>
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
                            <div class="small font-weight-bold text-yellow mb-1">My Portfolio Visits</div>
                            <div class="h5">{{$dashboard_metrics->getMyPortfolioVisits()}} visits</div>
                            <div
                                class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                <i class="mr-1" data-feather="calendar"></i> Overall
                            </div>
                        </div>
                        <div class="ml-2"><i class="fas fa-mouse-pointer fa-2x text-gray-200"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
