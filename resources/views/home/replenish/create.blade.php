@extends('layouts.app')

@section('title','完善个人信息')

@section('page_id','personal')

@section('css')
  <style>
    .log-in-form {
      border: 1px solid #cacaca;
      padding: 1rem 1rem!important;
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
      <form action="" method="post">
        <div class="row column log-in-form">
          <h4 class="text-center">个人信息完善</h4>

          <label>姓名
            <input v-model="phone" type="text" placeholder="请输入" name="phone">
          </label>
          <p id="error_phone" class="help-text hide">请输入</p>

          <label>昵称
            <input v-model="nickname" type="text" placeholder="请输入" name="nickname">
          </label>
          <p id="error_nickname" class="help-text hide">请输入</p>

          <div style="font-size: .875rem">
            <div class="small-2 columns" style="padding-left: 0;">性别</div>
            <label class="small-5 columns">
              <input v-model="sex" type="radio" value="male" name="sex">男
            </label>
            <label class="small-5 columns">
              <input v-model="sex" type="radio" value="female" name=sex">女
            </label>
          </div>
          <p id="error_phone" class="help-text hide">请输入</p>

          <label>地区
            <input v-model="phone" type="number" placeholder="请输入" name="phone">
          </label>
          <p id="error_phone" class="help-text hide">请输入</p>

          <label>医院
            <input v-model="phone" type="number" placeholder="请输入" name="phone">
          </label>
          <p id="error_phone" class="help-text hide">请输入</p>

          <label>科室
            <input v-model="phone" type="number" placeholder="请输入" name="phone">
          </label>
          <p id="error_phone" class="help-text hide">请输入</p>

          <label>职称
            <input v-model="phone" type="number" placeholder="请输入" name="phone">
          </label>
          <p id="error_phone" class="help-text hide">请输入</p>

          <label>邮箱
            <input v-model="email" type="number" placeholder="请输入" name="email">
          </label>
          <p id="error_email" class="help-text hide">请输入</p>

          <p><a type="submit" class="button expanded">确&emsp;认</a></p>
        </div>
      </form>
    </div>
  </div>
@endsection


@section('js')
  <script>
    vm = new Vue({
      el: '#personal',
      data: {}
    });
  </script>
@endsection