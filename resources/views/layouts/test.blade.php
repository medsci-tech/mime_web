@extends('layouts.app')

@section('title','test')

@section('page_id','test')

@section('css')
  <style></style>
@endsection

@section('content')
  <table class="hover">
    <tr>
      <th>网页</th>
    </tr>
    <tr v-for="(title,href) in pages">
      <td><a href="@{{ href }}">@{{ title }}</a></td>
    </tr>
  </table>
@endsection


@section('js')
  <script>
    vm = new Vue({
      el: '#test',
      data: {
        pages: {
          '公开课': '/open-course/index',
          '课程点播': '/open-course/video-playing',
          '登录': '/login/login',
          '注册': '/login/sign-up'
        }
      }
    });
  </script>
@endsection