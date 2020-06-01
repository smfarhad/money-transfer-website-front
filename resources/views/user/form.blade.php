@extends('layouts.master')
@section('content')
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> {{$title}}
        </div>
        <div class="tools">
            <a href="" class="collapse"> </a> 
            <a href="#portlet-config" data-toggle="modal" class="config"> </a> 
            <a href="" class="reload"> </a> <a href="" class="remove"> </a>
        </div>
    </div>
    <div class="portlet-body form">
<br>
@if(Session::has('success'))
<div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <strong>Success!</strong> New User Added Successfully
            </div>
        </div>
        <div class="col-md-2"></div>
</div>   
@endif
       

        <form role="form" action="{{route('new-user')}}" class="form-horizontal" method="post">
            {{ csrf_field() }}       
            <div class="form-body">
                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">First Name</label>
                    <div class="col-md-6">
                        <div class="input-icon right">
                            <input name="first_name" value="{{ old('first_name') }}"  class="form-control placeholder-no-fix" type="text" placeholder="First Name" /> 
                        </div>
                        @if ($errors->has('first_name'))
                        <span id="name-error" class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Last Name</label>
                    <div class="col-md-6">
                        <div class="input-icon right">
                            <input name="last_name" value="{{ old('last_name') }}"  class="form-control placeholder-no-fix" type="text" placeholder="Last Name" /> 
                        </div>
                        @if ($errors->has('last_name'))
                        <span id="name-error" class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>                    

                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-6">
                        <span id="name-error" class="help-block">
                            <strong>Enter your account details below </strong>
                        </span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Email</label>
                    <div class="col-md-6">
                        <div class="input-icon right">
                            <input name="email" value="{{ old('email') }}"  class="form-control placeholder-no-fix" type="text" placeholder="Email" /> 
                        </div>
                        @if ($errors->has('email'))
                        <span id="name-error" class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <div class="input-icon right">
                            <input name="password" value="{{ old('password') }}"  class="form-control placeholder-no-fix" type="password" placeholder="Password" /> 
                        </div>
                        @if ($errors->has('password'))
                        <span id="name-error" class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div> 
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Re-type Your Password</label>
                    <div class="col-md-6">
                        <div class="input-icon right">
                            <input name="password_confirmation" value="{{ old('password_confirmation') }}"  class="form-control placeholder-no-fix" type="password" placeholder="Re-type Your Password" /> 
                        </div>
                        @if ($errors->has('rpassword'))
                        <span id="password_confirmation-error" class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button type="submit" class="btn blue">ADD</button>
                        <!--<button type="button" class="btn default">Cancel</button>-->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection