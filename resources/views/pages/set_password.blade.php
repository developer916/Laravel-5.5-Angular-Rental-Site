@extends('admin.layouts.login')

{{-- Web site Title --}}
@section('title') {{{ trans('register.password_set_page') }}} :: @parent @stop

{{-- Content --}}
@section('content')
    @if($set_password == 1)
        <form class="password1-form" role="form" method="POST" action="{!! URL::to('/confirm/password/'. $id. '/'. $type) !!}">
    @else
    <form class="password-form" role="form" method="POST" action="{!! URL::to('/confirm/password/'. $id. '/'. $type) !!}">
    @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="setID" value="{{$id}}">
        <input type="hidden" name="slug" value="{{$type}}">
        <input type="hidden" name="set_password" value="{{$set_password}}">
        <div class="form-title">
            <span class="form-title">{{{ trans('register.welcome') }}}</span>
            <span class="form-subtitle">{{{ trans('register.to_set_password') }}}</span>
        </div>

        {{--<div class="alert alert-danger display-hide">--}}
            {{--<button class="close" data-close="alert"></button>--}}
            {{--<span>--}}
			{{--{{{ trans('register.need_info_password') }}}</span>--}}
        {{--</div>--}}
        @if (session('status'))
            <div class="alert alert-danger">
                <span> {{ session('status') }}</span>
            </div>
        @endif
        @if (session('password_wrong'))
            <div class="alert alert-danger">
                <span> {{ session('password_wrong') }}</span>
            </div>
        @endif

        <?php if($errors->first('email')) { ?>
        <div class="alert alert-danger">
            <span>
			{{ $errors->first('email', ':message') }}</span>
        </div>
        <?php } ?>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('login.username') }}}</label>

            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" autocomplete="off"  placeholder="{{{ trans('login.email') }}}" name="email" value="{{ old('email') }}"/>
            </div>
        </div>
        @if($set_password == 1)

            <?php if($errors->first('current_password')) { ?>
                <div class="alert alert-danger">
                <span>{{ $errors->first('current_password', ':message') }}</span>
                </div>
            <?php } ?>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">{{{ trans('login.current_password') }}}</label>

                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{{ trans('login.current_password') }}}" name="current_password"/>
                </div>
            </div>
        @endif

        <?php if($errors->first('password')) { ?>
        <div class="alert alert-danger">
            <span>
			{{ $errors->first('password', ':message') }}</span>
        </div>
        <?php } ?>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('login.password') }}}</label>

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{{ trans('login.password') }}}" name="password" id="password"/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{{ trans('register.confirm_password') }}}</label>

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{{ trans('register.password_confirmation ') }}}" name="password_confirmation"/>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block uppercase margin-bottom-s">
                {{{ trans('register.set_password') }}} <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
@endsection