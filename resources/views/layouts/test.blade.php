@extends('layouts.app')

@section('title','test')

@section('page_id','test')

@section('content')
<div class="container">
  <table class="table table-striped">
    <tr>
      <th>网页</th>
    </tr>
    <tr>
      <td><a href="/activity">活动申请</a></td>
    </tr>
    <tr>
      <td><a href="/coach/list">教练列表</a></td>
    </tr>
    <tr>
      <td><a href="/coach/detail">教练信息</a></td>
    </tr>
    <tr>
      <td><a href="/coach/order">教练预约</a></td>
    </tr>
    <tr>
      <td><a href="/personal/information">个人信息</a></td>
    </tr>
    <tr>
      <td><a href="/personal/order-detail">预约详情</a></td>
    </tr>
    <tr>
      <td><a href="/personal/order-list">预约列表</a></td>
    </tr>
    <tr>
      <td><a href="/stadium/list">场馆列表</a></td>
    </tr>
    <tr>
      <td><a href="/stadium/detail">场馆信息</a></td>
    </tr>
    <tr>
      <td><a href="/stadium/order">场馆预约</a></td>
    </tr>
  </table>
</div>
@endsection


@section('js')
  <script>

  </script>
@endsection