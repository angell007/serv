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
            <div class=" justify-content-center text-center ">

                <h3> Soy : </h3>

                <div class="userbtns">

                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link "  href="./candidato-login" aria-expanded="true">{{__('Candidate')}}</a></li>
                        <li class="nav-item"><a class="nav-link "  href="./company-login" aria-expanded="false">{{__('Employer')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
