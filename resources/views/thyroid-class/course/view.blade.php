@extends('layouts.app')

@section('title','课程点播')

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

    <div class="row video">

        <div class="medium-8 small-12 columns">
            <div id="id_video_container" style="width:100%;"></div>
        </div>
        <div class="medium-4 small-12 columns video-list">
            <h5>&nbsp;课程列表</h5>
            <ul class="vertical menu" data-accordion-menu>
                <li v-for="subject in course_list">
                    <a href="#">@{{ subject.subject }}</a>
                    <ul class="menu vertical nested">
                        <li v-for="course in subject.courses"><a href="@{{ course.href }}">@{{ course.name }}</a></li>
                    </ul>
                </li>
            </ul>
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
                    {
                        name: '{{\App\Models\Student::find(Session::get("studentId"))->name}}',
                        href: '#'
                    },
                    {
                        name: '退出',
                        href: '/home/logout'
                    }
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

                course_list: [
                    @foreach($thyroidClassPhases as $thyroidClassPhase)
                    {
                        subject: '{{$thyroidClassPhase->title}}',
                        courses: [
                            @foreach($thyroidClassPhase->thyroidClassCourses as $thyroidClassCourse)
                            {
                                name: '{{$thyroidClassCourse->title}}',
                                href: '/thyroid-class/course/view?course_id={{$thyroidClassCourse->id}}'
                            },
                            @endforeach
                        ]
                    },
                    @endforeach
                ]

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

            var interval;

            var option = {
                "auto_play": "0",
                "file_id": "{{$course->qcloud_file_id}}",
                "app_id": "{{$course->qcloud_app_id}}",
                "width": 960,
                "height": 600
            };
            /*调用播放器进行播放*/
            var func = {
                'playStatus': function (status) {

                    function timer() {

                        $.post('/thyroid-class/course/timer', '', function (data) {
                            if (data) {
                                console.log('OK');
                            } else {
                                $.post('/thyroid-class/course/timer', '', function (data) {
                                    if (data) {
                                        console.log('OK');
                                    } else {
                                        console.log('not OK');
                                    }
                                });
                            }
                        });

                    }

                    if (status == 'playing') {
                        interval = setInterval(timer, 30000);
                    }

                    if (status == 'suspended' || status == 'playEnd' || status == 'stop') {
                        clearInterval(interval);
                    }

                }
            };
            new qcVideo.Player(/*代码中的id_video_container将会作为播放器放置的容器使用,可自行替换*/ "id_video_container", option, func);
        })();

        $('.video-list').css('height', $('.video-list').prev().height());
    </script>
@endsection