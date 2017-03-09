@extends('layouts.app')

@section('title','重置密码')

@section('content')

  <div class="login-box">
    <div class="login-logo">
      <a href="#">Mime管理后台</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">重置密码</p>

      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      <form action="{{url('/password/email')}}" method="post" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback{{ $errors->has('email')? 'has-error' : '' }}">
          <input type="email" class="form-control" placeholder="请输入邮箱" value="{{ old('email') }}">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">发送邮件</button>
          </div><!-- /.col -->
        </div>
      </form>

    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->
@endsection
