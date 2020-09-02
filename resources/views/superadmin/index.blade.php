@extends('layouts.admin')

@section('content')

    <h2 class="border-bottom mb-3">Available Commands</h2>

    <div class="mb-3">
        <div class="row">
            <div class="col-md-12 mb-3">
                <form id="commands-form" class="form-inline" method="post" action="{{route('superadmin.command')}}">
                    @csrf
                    <div class="btn-group" role="group" aria-label="Commands">
                        @foreach($commands as $key => $commandConfig)
                            <button class="btn {{$commandConfig['btn-class'] ?? ''}}" type="submit" name="command"
                                    value="{{$key}}">
                                <i data-feather="{{$commandConfig['icon']}}"></i>
                                <span class="ml-2">{{$commandConfig['label'] ?? $key}}</span>
                            </button>
                        @endforeach
                    </div>
                </form>
            </div>


        </div>
    </div>

    <div>
        <pre class="language-shell"
             style="min-height: 300px;"><code>@if(!empty($lines)){{implode(PHP_EOL, $lines)}} @endif</code></pre>
    </div>

@endsection


@section('styles')
    <link href="/blog/prism/prism.css" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="/blog/prism/prism.js"></script>
    <script>
        (function () {
            var $commandForm = $('#commands-form');
            $commandForm.submit(function () {
                return confirm("Are you sure you want to run this command");
            });

        })();
    </script>
@endsection
