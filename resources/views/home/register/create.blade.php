@extends('layouts.app')

@section('title','注册')

@section('page_id','sign_up')

@section('css')
  <style>
    .log-in-form {
      border: 1px solid #cacaca;
      padding: 1rem 1rem !important;
      border-radius: 3px;
    }

    .help-text {
      color: #ec5840;
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
            <input v-model="phone" type="number" placeholder="请输入您的手机号" name="phone">
          </label>
          <p id="error_phone" class="help-text hide">您输入的手机号码有误</p>
          <label>验证码
            <div class="input-group">
              <input v-model="sms" class="input-group-field" type="text" placeholder="请输入验证码" name="auth_code">
              <div class="input-group-button">
                <button @click="get_auth_code" type="button" class="button">获取验证码</button>
              </div>
            </div>
          </label>
          <p id="error_sms" class="help-text hide">您输入的验证码有误</p>
          <label>密码
            <input v-model="password" type="text" placeholder="请输入密码" name="password">
          </label>
          <label>确认密码
            <input v-model="password2" type="text" placeholder="请再次输入密码" name="password2">
          </label>
          <p id="error_passord" class="help-text hide">两次输入的密码不一致</p>
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
      data: {
        phone: '',
        sms: '',
        password: '',
        password2: ''
      },
      methods: {
        get_auth_code: function () {

          $('error_phone').addClass('hide');
          $('.input-group-button button').attr("disabled","disabled");

          var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
          if (myreg.test(vm.phone)) {
            $.post('/home/register/sms', vm.phone, function (data) {
                if (data.success) {
                } else {
                  $('#error_phone').text('手机号已被注册');
                  $('#error_phone').removeClass('hide')
                }
              }
            );
          } else {
            $('error_phone').removeClass('hide')
          }


          var i = 61;
          timer();
          function timer() {
            i--;
            $('.input-group-button button').text(i + '秒后重发');
            if (i == 0) {
              clearTimeout(timer);
              $('.input-group-button button').removeAttr("disabled");
              $('.input-group-button button').text('重新发送');
            } else {
              setTimeout(timer, 1000);
            }
          }
        }
      }
    });
  </script>
@endsection