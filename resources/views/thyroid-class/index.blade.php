@extends('layouts.open')

@section('title','公开课首页')

@section('page_id','open_course')

@section('css')
  <link rel="stylesheet" href="/vendor/swiper/swiper-3.3.0.min.css">
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

  <div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide" v-for="slide in swiper_pictures">
        <a href="@{{slide.href}}">
          <img :src="slide.image" alt="@{{slide.name}}">
        </a>
      </div>
    </div>
  </div>

  <br>
  <div class="row information">
    <div class="header hide-for-small-only">
      <div></div>
      <span v-for="header in main_class.header">@{{ header }}</span>
    </div>

    <div>
      <div class="medium-6 small-12 columns">
        <div id="id_video_container" style="width:100%;"></div>
      </div>
      <div class="medium-6 small-12 columns">
        <h4>@{{ main_class.body.title }}</h4>

        <p>@{{ main_class.body.paragraph }}<br><br></p>

        <div class="row align-top">
          <div class="medium-6 small-12 columns" v-for=" footer in main_class.footer">
            <p><i class="fa fa-@{{ footer.fa }}"></i>&nbsp;@{{ footer.title }}：@{{ footer.content }}</p>
          </div>
        </div>


        <div class="row">
          <div class="medium-6 small-12 columns">
            @if(\Session::has('studentId'))
              @if(\App\Models\Student::find(\Session::get('studentId'))->thyroidClassStudent)
                <a type="button" class="expanded button" href="#">
                  已注册
                </a>
              @elseif(\Session::has('replenished') && \Session::get('replenished'))
                <button @click="register_course" type="button" class="expanded button">
                课程注册
                </button>
              @else
                <a type="button" class="expanded button" href="/home/replenish/create">
                  课程注册
                </a>
              @endif
            @else
              <a type="button" class="expanded button" href="/home/login">
                课程注册
              </a>
            @endif
          </div>
          <div class="medium-6 small-12 columns">
            <p>@{{ main_class.other_information }}</p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <br>
  <div class="row collapse">
    <ul class="tabs" data-tabs id="example-tabs">
      <li class="tabs-title" v-for="tab in tabs"><a href="@{{'#panel'+$index }}">@{{ tab.name }}</a></li>
    </ul>
    <div class="tabs-content" data-tabs-content="example-tabs">
      <div class="tabs-panel is-active" id="panel0">
        <div class="row column" v-for="row in tabs[0].content">
          <div class="medium-4 small-12 columns">
            <div class="small-12">
              <img :src="row.teacher.image" alt="">
            </div>
            <div class="small-12">
              <p></p>

              <p>讲师：@{{ row.teacher.teacher_name }}</p>

              <p>课程简介：@{{{ row.teacher.brief }}}</p>
            </div>
          </div>
          <div class="medium-8 small-12 columns align-top">
            <div class="medium-4 small-6 columns" style="padding-bottom: 1rem"
                 v-for="course in row.courses">
              <div class="small-12">
                <a href="@{{ course.href }}">
                  <img :src="course.image" alt="">
                </a>
              </div>
              <div class="small-12">
                <div>@{{ course.title }}</div>
                <div class="span" v-for="span in course.information"><i
                    class="fa fa-@{{ span.fa }}"></i>&nbsp;<span>@{{ span.title }}
                    <template v-if="span.title != ''&&span.title != null">：
                    </template>@{{ span.content }}</span>&emsp;
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tabs-panel" id="panel1">
        <div class="row" v-for="teacher in tabs[1].content">
          <div class="medium-3 small-12 columns">
            <img :src="teacher.headimg" alt="">
          </div>
          <div class="medium-9 small-12 columns">
          </div>
          <div>
            <strong>@{{ teacher.name }}&emsp;@{{ teacher.title }}</strong>&emsp;<span
              class="gray">@{{ teacher.office }}</span>
          </div>
          <br>

          <div>
            <div class="gray">导师简介：</div>
            <p>@{{{ teacher.bref }}}</p>
          </div>
        </div>
      </div>
      <div class="tabs-panel" id="panel2">
        <div class="row">

          <div>
            <div class="question-title"><strong>2016甲状腺公开课是什么样的课程？</strong></div>
            <div class="question-text">
              <p>
                2016甲状腺公开课是针对甲状腺领域疾病感兴趣的医护工作者，邀请国内资深医学专家，通过免费接听语音电话或登录网络直播的形式，为甲状腺疾病相关领域的内分泌科、外科、核医学科等医生，分享最新规范化诊疗经验的系统课程。
              </p>
            </div>
          </div>
          <div>
            <div class="question-title"><strong>2016甲状腺公开课的课程安排是什么样的？</strong></div>
            <div class="question-text">
              <p>2016年4月，甲状腺公开课已正式上线，期待您的加入</p>

              <p>起止时间：2016年4月—2016年12月</p>

              <p>课程安排：总课时21期，由甲亢、甲减、妊娠甲状腺疾病、甲状腺炎和甲状腺癌五大专题组成，其中15节为理论课，6节为答疑课</p>

              <p>播出时间：每周更新一期课程内容，首播时间为周四下午16：00起</p>
            </div>
          </div>
          <div>
            <div class="question-title"><strong>2016甲状腺公开课的学习方式是怎样的？</strong></div>
            <div class="question-text">
              <p>理论课学习方式：</p>
              <br>

              <p style="margin-left:30px;">微信学习</p>

              <p style="margin-left:60px;">第一步：关注医师助手DocMate微信号</p>

              <p style="margin-left:60px;">第二步：在右上角公众号信息中点击"查看历史消息"</p>

              <p style="margin-left:60px;">第三步：找到想要学习的课程，点击学习</p>
              <br>

              <p style="margin-left:30px;">网页学习</p>

              <p style="margin-left:60px;">第一步：登录网址www.mime.org.cn</p>

              <p style="margin-left:60px;">第二步：点击公开课专题目录，学习课程</p>
              <br>

              <p>直播答疑课参与方式：</p>
              <br>

              <p style="margin-left:30px;">参与方式1：接听外呼电话</p>

              <p style="margin-left:60px;">课前外呼接听来自（归属地：北京）的外呼电话</p>

              <p style="margin-left:60px;">▲(如您接听语音电话中途掉线，可拨打：400-810-8811 参会密码课前短信通知)</p>
              <br>

              <p style="margin-left:30px;">参与方式2.登陆网络直播直播室</p>
              <br>

              <p style="margin-left:60px;">如您正在电脑前，你可以：</p>

              <p style="margin-left:60px;">打开网络直播网址：www.mime.org.cn（课前30分钟开始登陆）</p>

              <p style="margin-left:60px;">用户名：填写您的报名手机号，点击"观看"即可进入直播室</p>

              <p style="margin-left:60px;">您可以直接点上方"观看直播"按钮直接进入直播室</p>
            </div>
          </div>
          <div>
            <div class="question-title"><strong>2016甲状腺公开课如何报名？</strong></div>
            <img style="width: 150px;float: right;" src="/image/qrcode.png">
            <div class="question-text">
              <p>报名需从微信端入口报名：微信扫描右侧二维码--填写报名资料-报名成功</p>

              <p>参照报名成功页面内容：1.确保关注甲状腺公开课唯一微信公众号--医师助手DocMate</p>
            </div>
          </div>
          <div>
            <div class="question-title"><strong>2016甲状腺公开课的咨询有哪些？</strong></div>
            <div class="question-text">
              <p>咨询热线：400-864-8883</p>

              <p>课程QQ群：364666518</p>

              <p>官方微信：医师助手DocMate</p>

              <p>官方网站：www.mime.org.cn</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="footer">
    <div class="row">
      <div class="medium-8 small-12 columns">
        <dl class="">
          <dd>&emsp;</dd>
          <dd>Copyright © Medscience-tech.All rights reserved.鄂ICP备13013615号-1</dd>
          <dd>&emsp;</dd>
          <dd>所有学习视频课适用于《中华人民共和国著作权法》</dd>
          <dd>所有学习视频课经授课专家许可使用，Mime、医师助手APP经版权方可使用。</dd>
          <dd>除非另有声明，本平台其他视频作品采用知识共享署名-非商业性使用-相同方式共享2.5中国大陆许可协议进行许可</dd>
        </dl>
      </div>
      <div class="medium-4 small-12 columns">
        <img src="/image/迈德科技.png" alt="">
      </div>
    </div>
  </div>

@endsection


@section('js')
  {{--    @include('home.login-modal')--}}
  <script src="/vendor/swiper/swiper-3.3.0.min.js"></script>
  <script>
    vm = new Vue({
      el: '#open_course',
      data: {
        top_bar_left: [
          {
            name: '首页',
            href: '/'
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
            @if(\Session::has('studentId'))
            @if(\Session::has('replenished') && \Session::get('replenished'))
          {
            name: '{{\App\Models\Student::find(Session::get("studentId"))->name}}',
            href: '#'
          },
            @else
          {
            name: '{{\App\Models\Student::find(Session::get("studentId"))->phone}}',
            href: '#'
          },
            @endif
          {
            name: '退出',
            href: '/home/logout'
          },

            @else
          {
            name: '登录',
            href: '/home/login'
          },
          {
            name: '注册',
            href: '/home/register/create'
          }
          @endif
        ],

        swiper_pictures: [
          {
            name: '',
            image: '/image/轮播test.jpg',
            href: '#'
          }, {
            name: '',
            image: '/image/轮播test.jpg',
            href: '#'
          }, {
            name: '',
            image: '/image/轮播test.jpg',
            href: '#'
          }
        ],

        main_class: {
          header: ['2016年甲状腺公开课', '更新至2016-07-16期', '播放总次数：3.87万'],

          body: {
            title: '课程介绍',
            image: '/image/test.jpg',
            paragraph: '{{$thyroidClass->comment}}'
          },

          footer: [{
            title: '更新时间',
            fa: 'clock-o',
            content: '每周四下午16：00'
          }, {
            title: '开课时间',
            fa: 'video-camera',
            content: '2016年4月1日'
          }, {
            title: '学习时间',
            fa: 'calendar',
            content: '2016年4月-12月31日'
          }, {
            title: '课程进度',
            fa: 'paperclip',
            content: '已播出10期（共21期 ）'
          }],

          other_information: '已有4596人注册了甲状腺公开课'
        },

        tabs: [
          {
            name: '课程内容',
            content: [
                @foreach($thyroidClassPhases as $thyroidClassPhase)
              {
                teacher: {
                  title: '{{$thyroidClassPhase->title}}',
                  image: '{{$thyroidClassPhase->logo_url}}',
                  teacher_name: '{{$thyroidClassPhase->teacher->name}}',
                  brief: '{!!  $thyroidClassPhase->comment !!}'
                },
                courses: [
                    @foreach($thyroidClassPhase->thyroidClassCourses as $thyroidClassCourse)
                  {
                    title: '{{$thyroidClassCourse->title}}',
                    image: '{{$thyroidClassCourse->logo_url}}',
                    href: '/thyroid-class/course/view?course_id={{$thyroidClassCourse->id}}',
                    information: [
                      {
                        title: '学习',
                        fa: 'youtube-play',
                        content: '2689人'
                      }
                    ]
                  },
                  @endforeach
                ]
              },
              @endforeach
            ]
          },
          {
            name: '授课老师',
            content: [
                @foreach($teachers as $teacher)
              {
                headimg: '{{$teacher->headimgurl}}',
                name: '{{$teacher->name}}',
                title: '{{$teacher->title}}',
                office: '{{$teacher->office}}',
                bref: '{!! $teacher->introduction !!}'
              },
              @endforeach
            ]
          },
          {
            name: '常见问题',
            content: []
          }
        ]
      },
      methods: {
        register_course: function () {
          $.post('/thyroid-class/enter', '', function (data) {
            history.go(0);
          })
        }
      }
    });

    var swiper = new Swiper('.swiper-container', {
      autoHeight: true,
      fade: {
        crossFade: true
      }
    });

    $(function () {
      $('.tabs-title').eq(0).addClass('is-active');
      $('.tabs-title').eq(0).children('a').attr('aria-selected', "true");
      $('#panel0>div>div').find('.medium-4:last').addClass('end');
//            $("a[href='/home/login'],button[href='/home/login']").attr({
//                'href': '#',
//                'data-open': 'exampleModal1'
//            });

    })

  </script>
  <script src="http://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js"></script>
  <script type="text/javascript">
    (function () {
      var option = {
        "auto_play": "0",
        "file_id": "14651978969263309496",
        "app_id": "1252490301",
        "width": 1920,
        "height": 1080,
        "stretch_patch": true
      };
      /*调用播放器进行播放*/
      new qcVideo.Player(
        /*代码中的id_video_container将会作为播放器放置的容器使用,可自行替换*/
        "id_video_container",
        option
      );
    })()
  </script>
@endsection