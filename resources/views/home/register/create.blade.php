@extends('layouts.app')

@section('title','注册')

@section('page_id','sign_up')

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
            <form method="post" action="/home/register/store">
                <div class="row column log-in-form">
                    <h4 class="text-center">Mime账号注册</h4>
                    <label>手机号
                        <input type="text" placeholder="请输入您的手机号" name="phone">
                    </label>
                    <label>验证码
                        <div class="input-group">
                            <input  class="input-group-field" type="text" placeholder="请输入验证码" name="auth_code">
                            <div class="input-group-button">
                                <button type="button" class="button">获取验证码</button>
                            </div>
                        </div>
                    </label>
                    <label>密码
                        <input type="text" placeholder="请输入密码" name="password">
                    </label>
                    <br>
                    <p><a type="submit" class="button expanded">注&emsp;册</a></p>
                    <p class="text-center"><a href="/home/login">已有账号?点击登录</a></p>
                </div>
            </form>

        </div>
    </div>
@endsection


@section('js')
    <script>
        vm = new Vue({
            el: '#sign_up',
            data: {}
        });
    </script>
@endsection