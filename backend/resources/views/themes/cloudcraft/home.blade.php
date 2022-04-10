@extends('themes.cloudcraft.layouts.main')

@section('contents')

    <div class="row">
        <x-metrics.metric-card size="4">
            <livewire:metrics.server-status/>
        </x-metrics.metric-card>
        <x-metrics.metric-card size="4">
            <livewire:metrics.total-users/>
        </x-metrics.metric-card>

        <x-metrics.metric-card size="4">
            <livewire:metrics.total-users-online/>
        </x-metrics.metric-card>
    </div>

    <div class="row">
        <div class="col">
            <div class="alert alert-primary border-0 mb-4 mt-5 px-md-5">
                <div class="position-relative">
                    <div class="row align-items-center justify-content-between">
                        <div class="col position-relative">
                            <h2 class="text-primary">Welcome to CloudCraft!</h2>
                            <p class="text-gray-700">
                                Thanks for your interest in joining the server
                            </p>
                            <a class="btn btn-teal" href="/">Get started
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
        </div>
    </div>
@endsection

