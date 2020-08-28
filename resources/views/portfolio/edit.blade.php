@extends('layouts.admin')

@section('page-header', 'Account')

@section('content')


    @include('portfolio.shared.sub-nav')

    @include('admin.shared.errors')

    <div class="card mb-4">
        <div class="card-header">
            Basic
        </div>
        <div class="card-body p-5">

            <div class="row">

                <div class="col-md-md-3">
                    <p>{{$user->username ?: 'N/A'}}</p>
                    <img class="img-fluid img-thumbnail rounded-circle" src="{{$user->avatar_url}}" alt="Avatar">
                </div>

                <div class="col-md-md-9">

                    <form action="{{route('portfolio.avatar')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="username">
                                Username <br>
                                <small>This will be used as the subdomain for your portfolio (eg. myusername.trenchdevs.org)</small>
                            </label>
                            <input type="text" name="username" class="form-control"
                                   value="{{old('username', $user->username)}}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="avatar_url">Upload Avatar</label>
                            <input name="avatar_url" class="form-control mt-2 pb-5 pt-3 pl-5" type="file"
                                   value="{{old('avatar_url', $user->avatar_url)}}">
                        </div>
                        <input class="float-right btn btn-success" type="submit" name="submit" value="Save">
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Profile Details
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col">
                    <form action="{{route('portfolio.update')}}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="primary_phone">Primary Phone Number</label>
                                    <input class="form-control" type="text" id="primary_phone" name="primary_phone"
                                           value="{{old('primary_phone', $portfolio_detail->primary_phone)}}"
                                           placeholder="0915777XXXX"
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="github_url">Github URL</label>
                                    <input class="form-control" type="text" id="github_url" name="github_url"
                                           value="{{old('github_url', $portfolio_detail->github_url)}}"
                                           placeholder="github.com/<<username>>"
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin_url">Linkedin URL</label>
                                    <input class="form-control" type="text" id="linkedin_url" name="linkedin_url"
                                           value="{{old('linkedin_url', $portfolio_detail->linkedin_url)}}"
                                           placeholder="linkedin.com/in/<<username>>"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="resume_url">Resume URL <small>(e.g. Public Google Drive
                                            URL)</small></label>
                                    <input class="form-control" type="text" id="resume_url" name="resume_url"
                                           value="{{old('resume_url', $portfolio_detail->resume_url)}}"
                                           placeholder="myresumelink.example.com/myresume"
                                    >

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="tagline">Tagline <small>(Shown below your name on your
                                            portfolio)</small></label>
                                    <textarea class="form-control" name="tagline" id="" cols="30"
                                              rows="5">{{old('tagline',$portfolio_detail->tagline )}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="tagline">
                                        Personal Interests
                                        <small>(Shown as a section on portfolio)</small>
                                    </label>
                                    <textarea class="form-control" name="interests" id="" cols="30"
                                              rows="5">{{old('interests',$portfolio_detail->interests )}}</textarea>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success float-right">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Background Cover
        </div>
        <div class="card-body p-5">

            <div class="row">
                <div class="col-md-8">

                    <div class="row">
                        <div class="col">
                            <form action="{{route('portfolio.background')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div>
                                        <p>Upload Background Cover </p>
                                        <ul>
                                            <li>This will show on your portfolio
                                                page
                                            </li>
                                            <li>
                                                Recommended size is 1600x1200.
                                            </li>
                                        </ul>
                                    </div>
                                    <input name="background_cover_url" class="form-control mt-2 pb-5 pt-3 pl-5"
                                           type="file">
                                </div>
                                <input class="float-right btn btn-success" type="submit" name="submit" value="Save">
                            </form>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col">
                            <p>Background Cover Image</p>
                            <img class="img-fluid"
                                 src="{{empty($portfolio_detail->background_cover_url) ? 'https://source.unsplash.com/6dW3xyQvcYE/1600x1200' : $portfolio_detail->background_cover_url}}"
                                 alt="Background Cover">
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



@endsection
