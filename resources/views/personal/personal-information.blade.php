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
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="medium-6 medium-centered large-4 large-centered columns">
      <br>
      <form action="" method="post">
        <div class="row column log-in-form">
          <h4 class="text-center">个人信息完善</h4>
          <div class="small-3 columns">
            <label for="middle-label" class="text-right middle">姓名</label>
          </div>
          <div class="small-9 columns">
            <input type="text" id="middle-label" placeholder="请输入姓名">
          </div>
          <br>
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