@extends('layouts.app')

@section('content')
    <!-- Header start -->

    @include('includes.header')

    <!-- Header end -->

    <!-- Inner Page Title start -->

    @include('includes.inner_page_title', ['page_title' => __('Register')])

    <!-- Inner Page Title end -->

    <div class="listpgWraper">

        <div class="container">

            @include('flash::message')

            <div class="useraccountwrap">

                <div class="userccount">

                    <div id="employer" class="formpanel tab-pane ">

                        <div class="userbtns text-center">
                            <ul class="nav nav-tabs">
                                <li class="nav-item bg-success "><a class=" text-white bg-secondary nav-link " href="#"
                                        aria-expanded="true">{{ __('Employer') }}</a></li>
                            </ul>
                        </div>


                        <form class="form-horizontal" method="POST" action="{{ route('company.register') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="candidate_or_employer" value="employer" />

                            <div class="formrow{{ $errors->has('name') ? ' has-error' : '' }}">

                                <input type="text" name="name" class="form-control" required="required"
                                    placeholder="Nombre de empresa" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block text-danger"> <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">

                                <input type="email" name="email" class="form-control" required="required"
                                    placeholder="{{ __('Email') }}" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block text-danger"> <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">

                                <input type="password" name="password" class="form-control" required="required"
                                    placeholder="{{ __('Password') }}" value="">

                                @if ($errors->has('password'))
                                    <span class="help-block text-danger"> <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="formrow{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                <input type="password" name="password_confirmation" class="form-control" required="required"
                                    placeholder="{{ __('Password Confirmation') }}" value="">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="formrow{{ $errors->has('is_subscribed') ? ' has-error' : '' }}">

                                <?php
                                
                                $is_checked = '';
                                
                                if (old('is_subscribed', 1)) {
                                    $is_checked = 'checked="checked"';
                                }
                                
                                ?>

                                <input type="checkbox" value="1" name="is_subscribed"
                                    {{ $is_checked }} />{{ __('Suscríbete al boletín de noticias') }}

                                @if ($errors->has('is_subscribed'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('is_subscribed') }}</strong> </span>
                                @endif
                            </div>

                            <div class="formrow{{ $errors->has('terms_of_use') ? ' has-error' : '' }}">

                                <input type="checkbox" value="1" name="terms_of_use" />

                                <a href="https://bolsadeempleo.itc.edu.co/POL%C3%8DTICAS%20DE%20SEGURIDAD%20DE%20LA%20INFORMACI%C3%93N%20Y%20PROTECCI%C3%93N%20DE%20DATOS%20PERSONALES.pdf"
                                    target="_blank">{{ __('I accept Terms of Use') }}</a>



                                @if ($errors->has('terms_of_use'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('terms_of_use') }}</strong> </span>
                                @endif
                            </div>



                            <input type="submit" class="btn" value="{{ __('Register') }}">

                        </form>

                        <div class="newuser"><i class="fa fa-video-camera" aria-hidden="true"></i>
                            <a style="color:#333; text-decoration: underline white; cursor:pointer "
                                href="https://youtu.be/02Slo5k58sw" target="_blank"> Guía rapida </a>
                        </div>


                    </div>

                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> Ya estas registrado?
                        <a href="{{ route('login') }}"> Ingresar </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer')
@endsection
