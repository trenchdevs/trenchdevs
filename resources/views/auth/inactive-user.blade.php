@extends('layouts.sbadmin-base')

@section('body')
    <div class="error-page">
        <div id="layoutError">
            <div id="layoutError_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mt-4">
                                    <h1 class="display-1">401</h1>
                                    <p class="lead">Unauthorized</p>
                                    <p>
                                        Your account is currently inactive or awaiting confirmation please check again
                                        after 24 hours or shoot an email to site owner
                                        <a href="mailto:christopheredrian@trenchdevs.org">christopheredrian@trenchdevs.org</a>
                                    </p>
                                    <a href="/"><i class="fas fa-arrow-left mr-1"></i>Return to Homepage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutError_footer">
                <footer class="footer mt-auto footer-light">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; TrenchDevs {{date('Y')}}</div>
                            <div class="col-md-6 text-md-right small">
                                <a href="#!">Privacy Policy</a>
                                &middot;
                                <a href="#!">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endsection
