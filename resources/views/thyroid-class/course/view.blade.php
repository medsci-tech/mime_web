@extends('layouts.app')

@section('title','课程点播')

@section('page_id','open_course')

@section('css')
  <link rel="stylesheet" href="/css/thyroid-class.css">
@endsection

@section('content')
  <div class="row">
    <div class="top-bar">
      <div>
        <div class="top-bar-left">
          <ul class="dropdown menu" data-dropdown-menu>
            <li><img src="/image/logo.jpg" alt=""></li>
            <li v-for="left in top_bar_left"><a href="@{{left.href}}">@{{left.name}}</a></li>
          </ul>
        </div>
        <div class="top-bar-right">
          <ul class="dropdown menu" data-dropdown-menu>
            <li v-for="right in top_bar_right"><a href="@{{right.href}}">@{{right.name}}</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="small-12">
      <img src="/image/test.jpg" style="width: 100%;height: 200px" alt="">
    </div>
  </div>
  <br>

  <div class="row" style="background-color: #555; padding-top: 1rem; padding-bottom: 1rem;">

    <div class=" medium-7 small-12 columns">
      <div id="id_video_container" style="width:100%;height:400px;"></div>
    </div>
    <div class="medium-5 small-12 columns">

    </div>
  </div>



@endsection


@section('js')
  <script src="/vendor/swiper/swiper-3.3.0.min.js"></script>
  <script>
    vm = new Vue({
      el: '#open_course',
      data: {
        top_bar_left: [
          {
            name: '首页',
            href: 'index'
          }, {
            name: '课程',
            href: '#'
          }, {
            name: '讲座',
            href: '#'
          }, {
            name: '病例讲座',
            href: '#'
          }, {
            name: '直播',
            href: '#'
          }
        ],

        top_bar_right: [
          {
            name: '登录',
            href: '#'
          }, {
            name: '注册',
            href: '#'
          }
        ],

      }
    });

    var swiper = new Swiper('.swiper-container', {
      autoHeight: true,
      fade: {
        crossFade: true
      }
    });

  </script>
  <script src="http://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js"></script>
  <script type="text/javascript"> (function () {
      var option = {
        "auto_play": "0",
        "file_id": "14651978969263009936",
        "app_id": "1252201500",
        "width": 640,
        "height": 400
      };
      /*调用播放器进行播放*/
      new qcVideo.Player(/*代码中的id_video_container将会作为播放器放置的容器使用,可自行替换*/ "id_video_container", option);
    })()
  </script>
@endsection