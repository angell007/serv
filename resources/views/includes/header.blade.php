<div class="header" style="    background-color: #e8e8e8;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 ">

                <a href="{{ url('/') }}" class="logo">
                    <img class="responsive-image" src="{{ url('/images/bannerescuelatecnologicav2.jpg') }}"
                        alt="{{ $siteSetting->site_name }}" />
                </a>

                <div class="navbar-header navbar-light">
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                        data-target="#nav-main" aria-controls="nav-main" aria-expanded="false"
                        aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">

                
                <!-- Nav start -->
                <nav class="navbar navbar-expand-lg navbar-light" >

                    {{-- <div class="accessibility-buttons"> --}}
                        <button id="reset-font-size" class="btn btn-light btn-sm ">A</button>
                        <button id="increase-font-size" class="btn btn-light btn-sm  ">A+</button>
                        <button id="decrease-font-size" class="btn btn-light btn-sm ">A-</button>
                        <button onclick="toggleDarkMode()" class="btn btn-light btn-sm ">DM</button>
                    {{-- </div> --}}
    

                    <div class="navbar-collapse collapse" id="nav-main">
                        <ul class="navbar-nav ml-auto">


                            <li class="nav-item {{ Request::url() == route('index') ? 'active' : '' }}"><a
                                    href="{{ url('/') }}" class="nav-link">Inicio</a> </li>


                            @if (Auth::guard('company')->check())
                                <!-- <li class="nav-item"><a href="{{ url('/job-seekers') }}" class="nav-link">{{ __('Seekers') }}</a> </li> -->
                            @else
                                <li class="nav-item {{ Request::url() == url('/jobs') ? 'active' : '' }}"><a
                                        href="{{ url('/jobs') }}" class="nav-link">{{ __('Jobs') }}</a>
                                </li>
                            @endif

                            <li class="nav-item {{ Request::url() == url('/companies') ? 'active' : '' }}"><a
                                    href="{{ url('/companies') }}" class="nav-link">Empresas</a> </li>
                            @foreach ($show_in_top_menu as $top_menu)
                                @php $cmsContent = App\CmsContent::getContentBySlug($top_menu->page_slug); @endphp
                                <!--   <li class="nav-item {{ Request::url() == route('cms', $top_menu->page_slug) ? 'active' : '' }}"><a href="{{ route('cms', $top_menu->page_slug) }}" class="nav-link">{{ $cmsContent->page_title }}</a> </li>
                           -->
                            @endforeach
                            <!--<li class="nav-item {{ Request::url() == route('blogs') ? 'active' : '' }}"><a href="{{ route('blogs') }}" class="nav-link">{{ __('Blog') }}</a> </li>-->
                            <li class="nav-item {{ Request::url() == route('contact.us') ? 'active' : '' }}"><a
                                    href="https://siac.itc.edu.co" class="nav-link">PQRSD</a> </li>
                            @if (Auth::check())
                                <li class="nav-item dropdown userbtn"><a
                                        href="">{{ Auth::user()->printUserImage() }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link"><i
                                                    class="fa fa-tachometer" aria-hidden="true"></i>
                                                {{ __('Dashboard') }}</a> </li>
                                        <li class="nav-item"><a href="{{ route('my.profile') }}" class="nav-link"><i
                                                    class="fa fa-user" aria-hidden="true"></i>
                                                {{ __('My Profile') }}</a> </li>
                                        <li class="nav-item"><a
                                                href="{{ route('view.public.profile', Auth::user()->id) }}"
                                                class="nav-link"><i class="fa fa-eye" aria-hidden="true"></i>
                                                {{ __('View Public Profile') }}</a> </li>
                                        <li><a href="{{ route('my.job.applications') }}" class="nav-link"><i
                                                    class="fa fa-desktop" aria-hidden="true"></i>
                                                {{ __('My Job Applications') }}</a> </li>
                                        <li class="nav-item"><a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();"
                                                class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                                {{ __('Logout') }}</a> </li>
                                        <form id="logout-form-header" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </ul>
                                </li>
                            @endif
                            @if (Auth::guard('company')->check())
                                <li class="nav-item postjob"><a href="{{ route('post.job') }}"
                                        class="nav-link register">{{ __('Crear Oferta') }}</a> </li>
                                <li class="nav-item dropdown userbtn"><a
                                        href="">{{ Auth::guard('company')->user()->printCompanyImage() }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a href="{{ route('company.home') }}" class="nav-link"><i
                                                    class="fa fa-tachometer" aria-hidden="true"></i>
                                                {{ __('Dashboard') }}</a> </li>
                                        <li class="nav-item"><a href="{{ route('company.profile') }}"
                                                class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
                                                {{ __('Company Profile') }}</a></li>
                                        <li class="nav-item"><a href="{{ route('post.job') }}" class="nav-link"><i
                                                    class="fa fa-desktop" aria-hidden="true"></i>
                                                {{ __('Post Job') }}</a></li>
                                        <li class="nav-item"><a href="{{ route('company.messages') }}"
                                                class="nav-link"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                {{ __('Company Messages') }}</a></li>
                                        <li class="nav-item"><a href="{{ route('company.logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form-header1').submit();"
                                                class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                                {{ __('Logout') }}</a> </li>
                                        <form id="logout-form-header1" action="{{ route('company.logout') }}"
                                            method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </ul>
                                </li>
                            @endif
                            @if (!Auth::user() && !Auth::guard('company')->user())
                                <li class="nav-item {{ Request::url() == route('login') ? 'active' : '' }}"><a
                                        href="{{ route('login') }}" class="nav-link">{{ __('Ingreso') }}</a> </li>
                                <li class="nav-item"><a href="{{ route('register') }}"
                                        class="nav-link register">{{ __('Register') }}</a> </li>
                            @endif

                            <!-- Nav collapes end -->

                    </div>
                    <div class="clearfix"></div>
                </nav>

                <!-- Nav end -->

             

            </div>
        </div>

        <!-- row end -->

    </div>

    <!-- Header container end -->

</div>

<?php
/*?>
?>
?>
@if (!Auth::user() && !Auth::guard('company')->user())
    <div class="">my dive 2</div>
@endif<?php */
?>
