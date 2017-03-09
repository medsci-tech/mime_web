@extends('layouts.app')

@section('title','修改密码')

@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{url('/home')}}">Mime管理后台</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">修改密码</p>
            <form action="{{ url('/password/reset') }}" method="post" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback{{ $errors->has('email')? 'has-error' : '' }}">
                    <input type="email" name="email" disabled class="form-control" value="{{ $email or old('email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('password')? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="请输入密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('password_confirmation')? 'has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="确认密码">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">确&emsp;认</button>
                    </div><!-- /.col -->
                </div>
            </form>

        </div><!-- /.form-box -->
    </div><!-- /.register-box -->
@endsection
