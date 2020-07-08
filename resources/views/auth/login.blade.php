<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; BlumPackage v.2</title>

    <!-- General CSS Files -->
    {!! Html::style('assets/vendors/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assets/vendors/fontawesome/css/all.min.css') !!}
    <!-- Template CSS -->
    {!! Html::style('assets/css/style.css') !!}
    {!! Html::style('assets/css/components.css') !!}
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-4 m-3">
                        {{-- <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="80"
                            class="shadow-light rounded-circle mb-5 mt-2">--}}
                        <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">MOPKES</span>
                        </h4>
                        <p class="text-muted">Before you get started, you must login first.</p>
                        {!! Form::open(['route' => 'admin.login','class'=>'needs-validation','novalidate'=>'']) !!}
                        @if(Session::has('message'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ Session::get('message') }}</strong>
                            </div>
                        @endif
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
                                    </div>
                                    <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                                </div>
                                <div class="invalid-feedback">
                                    Please fill in your <b>Username</b>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                </div>
                                <div class="invalid-feedback">
                                    please fill in your <b>Password</b>
                                </div>
                            </div>

                            @if(env('GOOGLE_RECAPTCHA_KEY'))
                            <div class="form-group">
                                <div class="g-recaptcha"
                                    data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                </div>
                            </div>
                            @endif

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                                    Login
                                </button>
                            </div>

                            <div class="mt-5 text-center">
                                Don't have an account? <br>
                                Please contact Administrator to get an Account.
                            </div>
                        {!! Form::close() !!}

                        <div class="text-center mt-5 text-small">
                            Copyright &copy; Blumpack.
                            <div class="mt-2">
                                Dev. by Blumpack
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
                    data-background="{{ asset('assets/img/unsplash/login-01.jpg') }}">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            Photo by <a class="text-light bb" target="_blank"
                                href="https://unsplash.com/@thomasble">Thomas Le</a> on <a
                                class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    {!! Html::script('assets/vendors/jquery/dist/jquery.min.js') !!}
    {!! Html::script('assets/vendors/popper.js/popper.min.js') !!}
    {!! Html::script('assets/vendors/bootstrap/js/bootstrap.min.js') !!}
    {!! Html::script('assets/vendors/jquery.nicescroll/jquery.nicescroll.min.js') !!}
    {!! Html::script('https://www.google.com/recaptcha/api.js') !!}
    {!! Html::script('assets/js/stisla.js') !!}
    {!! Html::script('assets/js/scripts.js') !!}
</body>

</html>
