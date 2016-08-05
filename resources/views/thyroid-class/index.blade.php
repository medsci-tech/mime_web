@extends('layouts.app')

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

    <div class="row">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="slide in swiper_pictures">
                    <a href="@{{slide.href}}">
                        <img :src="slide.image" alt="@{{slide.name}}">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row information">
        <div class="header hide-for-small-only">
            <div></div>
            <span v-for="header in main_class.header">@{{ header }}</span>
        </div>

        <div class="media-object">
            <div class="media-object-section medium-6 small-12 columns">
                <img class="thumbnail" :src="main_class.body.image" alt="@{{ main_class.body.title }}">
            </div>
            <div class="media-object-section medium-6 small-12 columns">
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
                        <div class="medium-4 small-6 columns" style="padding-bottom: 1rem" v-for="course in row.courses">
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
              <div class="row">
                <div class="medium-3 small-12 columns">
                  <img src="/image/test.jpg" alt="">
                </div>
                <div class="medium-9 small-12 columns">
                </div>
                <div>
                  <strong>施秉银  教授</strong>&emsp;<span class="gray">西安交通大学医学院第一附属医院院长，博士研究生导师</span>
                </div>
                <br>
                <div>
                  <div class="gray">导师简介：</div>
                  <p>现为中华医学会内分泌学分会常委暨甲状腺专业学组副组长
                    中国医师协会内分泌代谢分会常委
                    美国《Thyroid》杂志及《中华内科杂志》、《中华内分泌代谢杂志》、《中华糖尿病杂志》、《中国糖尿病杂志》、《中国实用内科杂志》、《国际内分泌代谢杂志》编委</p>
                </div>
              </div>
            </div>
            <div class="tabs-panel" id="panel2">

            </div>
        </div>
    </div>

    <div class="footer">
        <div class="row">
            <div class="medium-8 small-12 columns">
                <dl class="">
                    <dd>&emsp;</dd>
                    <dd>关于我们丨全科医学协作平台简介丨联系方式丨相关法律</dd>
                    <dd>&emsp;</dd>
                    <dd>Copyright © 2016 Phoenix New Media Limited All Rights Reserved.</dd>
                    <dd>空中课堂所有学习视频课适用于《中华人民共和国著作权法》</dd>
                    <dd>空中课堂所有学习视频课经授课专家许可使用，Mime、Itangyi、空课APP经版权方可使用。</dd>
                    <dd>除非另有声明，本平台其他视频作品采用知识共享署名-非商业性使用-相同方式共享。</dd>
                </dl>
            </div>
            <div class="medium-4 small-12 columns">
                <img src="/image/全科医学协作平台.jpg" alt="">
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
                    header: ['2016年甲状腺公开课', '更新至2016-07-16期', '播放总次数：3.87万', ' 问答:156条'],

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
                                            }, {
                                                title: '',
                                                fa: 'comment',
                                                content: '4条问题'
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
                        name: '213123'
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
@endsection