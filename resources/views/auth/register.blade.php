@extends('admin.layouts.login')

{{-- Web site Title --}}
@section('title') {{{ trans('register.register_title') }}} :: @parent @stop

@section('content')
    <form class="register1-form" role="form" method="POST" action="{!! URL::to('/auth/register') !!}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-title">
            <span class="form-title">{{{ trans('register.welcome') }}}</span>
        </div>

        <?php if($errors->first('name')) { ?>
        <div class="alert alert-danger">
            <button data-close="alert" class="close"></button>
            <span>
			{{ $errors->first('name', ':message') }}</span>
        </div>
        <?php } ?>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('register.name') }}}</label>

            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix"  autocomplete="off"
                       placeholder="{{{ trans('register.name') }}}" name="name" value="{{ old('name', $name) }}" />
            </div>
        </div>

        <?php if($errors->first('email')) { ?>
        <div class="alert alert-danger">
            <button data-close="alert" class="close"></button>
            <span>
			{{ $errors->first('email', ':message') }}</span>
        </div>
        <?php } ?>
        <input type="hidden" name="selectType" value="{{$selectType}}" />
        <input type="hidden" name="invitationID" value="{{$id}}" />
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('login.username') }}}</label>

            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" autocomplete="off"
                       placeholder="{{{ trans('login.email') }}}" name="email" value="{{ old('email', $email) }}" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('login.password') }}}</label>

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                       placeholder="{{{ trans('login.password') }}}" name="password" id="password"/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('register.confirm_password') }}}</label>

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                       placeholder="{{{ trans('register.password_confirmation ') }}}" name="password_confirmation"/>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block uppercase margin-bottom-s">
                {{{ trans('register.register') }}} <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
@endsection

{{--@extends('app')--}}

{{-- Web site Title --}}
{{--@section('title') {{{ trans('site/user.register') }}} :: @parent @stop--}}

{{-- Content --}}
{{--@section('content')--}}
    {{--<div class="row">--}}
        {{--<div class="page-header">--}}
            {{--<h2>{{{ trans('site/user.register') }}}</h2>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="container-fluid">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
            {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">Register</div>--}}
            {{--<div class="panel-body">--}}

            {{--@include('errors.list')--}}

            {{--<form class="form-horizontal" role="form" method="POST" action="{!! URL::to('/auth/register') !!}">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

                {{--<div class="form-group">--}}
                    {{--<label class="col-md-4 control-label">{{{ trans('site/user.name') }}}</label>--}}

                    {{--<div class="col-md-6">--}}
                        {{--<input type="text" class="form-control" name="name" value="{{ old('name') }}">--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<label class="col-md-4 control-label">Username</label>--}}

                    {{--<div class="col-md-6">--}}
                        {{--<input type="text" class="form-control" name="username"--}}
                               {{--value="{{ old('username') }}">--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<label class="col-md-4 control-label">{{{ trans('site/user.e_mail') }}}</label>--}}

                    {{--<div class="col-md-6">--}}
                        {{--<input type="email" class="form-control" name="email" value="{{ old('email') }}">--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<label class="col-md-4 control-label">Password</label>--}}

                    {{--<div class="col-md-6">--}}
                        {{--<input type="password" class="form-control" name="password">--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<label class="col-md-4 control-label">Confirm Password</label>--}}

                    {{--<div class="col-md-6">--}}
                        {{--<input type="password" class="form-control" name="password_confirmation">--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<div class="col-md-6 col-md-offset-4">--}}
                        {{--<button type="submit" class="btn btn-signup">--}}
                            {{--Register--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}
