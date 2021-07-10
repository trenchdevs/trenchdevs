@extends('themes.sjp.layouts.main')

@section('contents')

    <div class="row">

        <x-metrics.metric-card size="4">
            <livewire:metrics.total-users/>
        </x-metrics.metric-card>

    </div>

@endsection

