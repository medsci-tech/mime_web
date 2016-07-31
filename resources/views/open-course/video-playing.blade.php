@extends('layouts.app')

@section('title','课程点播')

@section('page_id','open_course')

@section('css')
  <link rel="stylesheet" href="/vendor/foundation-6.2.3-complete/css/foundation.min.css">
  <link rel="stylesheet" href="/vendor/font-awesome-4.6.2/css/font-awesome.min.css">
  <link rel="stylesheet" href="/vendor/swiper/swiper-3.3.0.min.css">
  <style>
    .swiper-slide img {
      width: 100%;
    }
    .media-object img {
      width: 100%;
    }
    .media-object>div>p {
      border-bottom: 1px dashed #000;
    }
    .information span {
      padding-right: 30px;
    }
  </style>
@endsection

@section('content')
  <div class="top-bar hide-for-small-only">
    <div>
      <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
          <li class="menu-text">mime</li>
          <li v-for="(name,href) in top_bar_right"><a href="@{{href}}">@{{name}}</a></li>
        </ul>
      </div>
      <div class="top-bar-right">
        <ul class="dropdown menu" data-dropdown-menu>
          <li v-for="(name,href) in top_bar_left"><a href="@{{href}}">@{{name}}</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide" v-for="(name,href) in swiper_pictures">
          <a href="@{{href[0]}}">
            <img :src="href[1]" alt="@{{name}}">
          </a>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="media-7 small-12 columns">

    </div>
  </div>

@endsection


@section('js')
  <script src="/vendor/swiper/swiper-3.3.0.min.js"></script>
  <script>
    vm = new Vue({
      el: '#open_course',
      data: {
        top_bar_right: {
          '首页': 'index',
          '课程': '#',
          '讲座': '#',
          '病例讲座': '#',
          '直播': '#'
        },top_bar_left: {
          '登录': 'index',
          '注册': '#',
        },
        swiper_pictures: {
          '轮播图1': ['#', '/image/轮播test.jpg'],
          '轮播图2': ['#', '/image/轮播test.jpg'],
          '轮播图3': ['#', '/image/轮播test.jpg']
        }
      }
    });

    var swiper = new Swiper('.swiper-container', {
      autoHeight: true,
      fade: {
        crossFade: true
      }
    });

  </script>
@endsection