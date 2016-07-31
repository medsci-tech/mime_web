@extends('layouts.app')

@section('title','公开课首页')

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
  <div class="row information">
    <span><strong>2016年甲状腺公开课</strong></span>
      <span>更新至2016-07-16期</span>
      <span>播放总次数：3.87万</span>
      <span>问答</span>
    <hr>
    <div class="media-object">
      <div class="media-object-section medium-6 small-12 columns">
        <img class="thumbnail" src="/image/test.jpg" alt="">
      </div>
      <div class="media-object-section medium-6 small-12 columns">
        <h4>课程介绍</h4>
        <p>2016年甲状腺公开课由国内知名的移动医学教育平台迈德科技发起，邀请国内资深医学专家，通过免费接听语音电话或登陆网络直播的形式，为甲状腺疾病相关领域的内分泌、外科、核医学科等医生，分享最新规范化诊疗经验的系统课程。啊上课大家好请问I诶我空间啊和空间的贺卡上卡还是空间好卡的酒红色空间哈开始卡就是的好看。<br><br></p>
        <div class="medium-6 small-12 columns">
          <p><i class="fa fa-clock-o"></i>更新时间：每周四下午16：00</p>
        </div>
        <div class="medium-6 small-12 columns">
          <p><i class="fa fa-video-camera"></i>开课时间：2016年4月1日</p>
        </div>
        <div class="medium-6 small-12 columns">
          <p><i class="fa fa-calendar"></i>学习时间：2016年4月-12月31日</p>
        </div>
        <div class="medium-6 small-12 columns">
          <p><i class="fa fa-paperclip"></i>课程进度：已播出10期（共21期 ）</p>
        </div>
        <div class="medium-6 small-12 columns">
          <button type="button" class="expanded button">课程注册</button>
        </div>
        <div class="medium-6 small-12 columns">
          <p>已有4596人注册了甲状腺公开课</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row collapse">
    <ul class="tabs" data-tabs id="example-tabs">
      <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">课程内容</a></li>
      <li class="tabs-title"><a href="#panel2">授课老师</a></li>
      <li class="tabs-title"><a href="#panel3">常见内容</a></li>
    </ul>
    <div class="tabs-content" data-tabs-content="example-tabs">
      <div class="tabs-panel is-active" id="panel1">
        <div class="row">
          <div class="medium-4 small-12 columns">
            <div class="small-12">
              <img src="/image/test.jpg" alt="">
            </div>
            <div class="small-12">
              <p>讲师：施秉银</p>
              <p>课程简介：啊可是觉得哈看几乎是看，到阿克苏可千万模拟器。比我年轻比我们那边全面把握强化可惜很快就这款车I我IU去I，请和我快回去看见我会看败。</p>
            </div>
          </div>
          <div class="medium-8 small-12 columns">
            <div class="medium-4 small-6 columns">
              <div class="small-12">
                <img src="/image/test.jpg" alt="">
              </div>
              <div class="small-12">
                <p>第1期：甲亢临床治疗的回顾</p>
                <p>
                  <i class="fa fa-youtube-play"></i><span>  学习：2689人  </span>
                  <i class="fa fa-comment"></i><span>  学习：2689人  </span>
                </p>
              </div>
            </div>
            <div class="medium-4 small-6 columns">
              <div class="small-12">
                <img src="/image/test.jpg" alt="">
              </div>
              <div class="small-12">
                <p>第1期：甲亢临床治疗的回顾</p>
                <p>
                  <i class="fa fa-youtube-play"></i><span>  学习：2689人  </span>
                  <i class="fa fa-comment"></i><span>  学习：2689人  </span>
                </p>
              </div>
            </div>
            <div class="medium-4 small-6 columns">
              <div class="small-12">
                <img src="/image/test.jpg" alt="">
              </div>
              <div class="small-12">
                <p>第1期：甲亢临床治疗的回顾</p>
                <p>
                  <i class="fa fa-youtube-play"></i><span>  学习：2689人  </span>
                  <i class="fa fa-comment"></i><span>  学习：2689人  </span>
                </p>
              </div>
            </div>
            <div class="medium-4 small-6 columns">
              <div class="small-12">
                <img src="/image/test.jpg" alt="">
              </div>
              <div class="small-12">
                <p>第1期：甲亢临床治疗的回顾</p>
                <p>
                  <i class="fa fa-youtube-play"></i><span>  学习：2689人  </span>
                  <i class="fa fa-comment"></i><span>  学习：2689人  </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tabs-panel" id="panel2">
        234234
      </div>
      <div class="tabs-panel" id="panel3">
        8798
      </div>
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