@extends('layouts.app')

@section('title','登录')

@section('page_id','login')

@section('css')
  <style>
    .log-in-form {
      border: 1px solid #cacaca;
      padding: 1rem 1rem!important;
      border-radius: 3px;
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="medium-6 medium-centered large-4 large-centered columns">
      <br>
      <form>
        <div class="row column log-in-form">
          <h4 class="text-center">Mime账号登录</h4>
          <label>手机号
            <input type="text" placeholder="请输入您的手机号">
          </label>
          <label>密码
            <input type="text" placeholder="请输入密码">
          </label>
          <input id="remember-me" type="checkbox"><label for="remember-me">记住我</label>
          <p><a type="submit" class="button expanded">登&emsp;录</a></p>
          <p class="text-center"><a href="#">忘记密码?</a></p>
        </div>
      </form>

    </div>
  </div>
@endsection


@section('js')
  <script>
    vm = new Vue({
      el: '#login',
      data: {}
    });
  </script>
@endsection