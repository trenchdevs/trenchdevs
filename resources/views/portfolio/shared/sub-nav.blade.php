<nav class="my-5 p-2">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-2">
                <a href="{{route('portfolio.edit')}}" type="button" class="btn btn-success btn-circle text-white">1</a>
                <p>
                    <small>Profile</small>
                </p>
            </div>
            <div class="stepwizard-step col-xs-2">
                <a href="{{route('portfolio.experiences')}}" type="button"
                   class="btn btn-primary btn-circle text-white">2</a>
                <p>
                    <small>Experiences</small>
                </p>
            </div>

            <div class="stepwizard-step col-xs-2">
                <a href="{{route('portfolio.degrees')}}" type="button" class="btn btn-red btn-circle text-white"
                   disabled="disabled">3</a>
                <p>
                    <small>Degrees</small>
                </p>
            </div>
            <div class="stepwizard-step col-xs-2">
                <a href="{{route('portfolio.skills')}}" type="button" class="btn btn-warning btn-circle text-white"
                   disabled="disabled">4</a>
                <p>
                    <small>Skills</small>
                </p>
            </div>
            <div class="stepwizard-step col-xs-2">
                <a href="{{route('portfolio.certifications')}}" type="button" class="btn btn-orange btn-circle text-white"
                   disabled="disabled">5</a>
                <p>
                    <small>Certifications</small>
                </p>
            </div>
        </div>
    </div>


@section('styles')
    <style>
        body {
            margin-top: 30px;
        }

        .stepwizard-step p {
            margin-top: 0px;
            color: #666;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            /*opacity: 1 !important;
            filter: alpha(opacity=100) !important;*/
        }

        .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
            opacity: 1 !important;
            color: #bbb;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-index: 0;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
    </style>
@endsection
