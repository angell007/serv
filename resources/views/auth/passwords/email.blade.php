@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>'Reset Password'])
<!-- Inner Page Title end -->


<div class="container mt-5 p-5">
    <div class="row card">
        
                @if (session('status'))
                <div class="alert alert-success mt-5">
                    {{ session('status') }}
                </div>
                @endif
                
                
                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        
                        {{ csrf_field() }}
                        
                      <div class="form-row align-items-center mt-5 mb-2">
                        
                        <div class="col-md-6 offset-2">
                          <label class="sr-only" for="inlineFormInputGroup">Email</label>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">@</div>
                            </div>
                            <input type="text" id="email" class="form-control" id="inlineFormInputGroup" name="email" value="{{ old('email') }}" required placeholder="Email">
                            
                             @if ($errors->has('email'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                          </div>
                        </div>
                        
                        <div class="col-auto">
                          <button type="submit" class="btn btn-primary mb-2">Reset!</button>
                        </div>
                      </div>
                    </form>
                    
                    <div class="newuser mb-5"><i class="fa fa-user mx-2" aria-hidden="true"></i><a class="mb-5" href="{{route('login')}}">Login</a></div>
                    
                    <div class="row">
                        
                    </div>
        </div>
                    
</div>

@include('includes.footer')
@endsection