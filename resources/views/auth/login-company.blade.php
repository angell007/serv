@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('Login')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container card py-5">

            <div id="employer" class="formpanel tab-pane active ">
                <div class="row d-flex justify-content-center">
                    <div class="col-6">

                        <div class="userbtns text-center">
                            <ul class="nav nav-tabs">
                                <li class="nav-item bg-success "><a class=" text-white bg-secondary nav-link " href="#"
                                        aria-expanded="true">{{ __('Employer') }}</a></li>
                            </ul>
                        </div>

                        <form class="form-horizontal" method="POST" action="{{ route('company.login') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="candidate_or_employer" value="employer" />
                            <div class="formpanel">
                                <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required autofocus
                                        placeholder="{{ __('Email Address') }}">
                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" type="password" class="form-control" name="password"
                                        value="" required placeholder="{{ __('Password') }}">
                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="formrow{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <input type="submit" class="btn" value="{{ __('Login') }}">
                            </div>

                        </form>


                        <div class="newuser"><i class="fa fa-video-camera" aria-hidden="true"></i>
                            <a style="color:#333; text-decoration: underline white; cursor:pointer "
                                href="https://youtu.be/02Slo5k58sw" target="_blank"> Guía rapida </a>
                        </div>

                        <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> {{ __('New User') }}? <a
                                href="{{ route('register') }}">{{ __('Register Here') }}</a></div>


                        <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i>
                            {{ __('Forgot Your Password') }}? <a
                                href="{{ route('company.password.request') }}">{{ __('Click here') }}</a></div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('includes.footer')
@endsection
