@extends('layouts.open')

@section('title','课程点播')

@section('page_id','open_course')

@section('css')
    <link rel="stylesheet" href="/vendor/swiper/swiper-3.3.0.min.css">
    <link rel="stylesheet" href="/css/thyroid-class.css">
@endsection

@section('content')

    @include('layouts.header')

    <div style="background-color: #25562c;">
        <div class="row">
            <img src="http://obdm9m6gj.bkt.clouddn.com/%E6%92%AD%E6%94%BE%E9%A1%B5banner.jpg" alt="">
        </div>   
    </div>

<div style="background-color: #555;">
    <div class="row video">

        <div class="medium-8 small-12 columns">
            <div id="id_video_container" style="width:100%;"></div>
        </div>
        <div class="medium-4 small-12 columns video-list">
            <h5>&nbsp;课程列表</h5>
            <ul class="vertical menu" data-accordion-menu id="video-accordion">
                <li v-for="subject in course_list">
                    <a id="video_@{{$index+1}}" href="#">@{{ subject.sequence }}&nbsp;<abbr class="over-hide" title="@{{ subject.subject }}">@{{ subject.subject }}</abbr></a>
                    <ul class="menu vertical nested">
                        <li v-for="course in subject.courses" :class="(course.id == currentCourse)?'active':''">
                            <a href="@{{ course.href }}">@{{ course.sequence }}&nbsp;<abbr class="over-hide" title="@{{ course.name }}">@{{ course.name }}</abbr></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>


    @include('layouts.footer')


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
                        @foreach($banners as $banner)
                        {
                        name: '',
                        image: '{{$banner->image_url}}',
                        href: '{{$banner->href_url}}'
                    },
                    @endforeach
                ],

                course_list: [
                    @foreach($thyroidClassPhases as $thyroidClassPhase)
                    {
                        subject: '{{$thyroidClassPhase->title}}',
                        sequence: '{{$thyroidClassPhase->sequence}}',
                        courses: [
                            @foreach($thyroidClassPhase->thyroidClassCourses as $thyroidClassCourse)
                            {
                                name: '{{$thyroidClassCourse->title}}',
                                sequence: '{{$thyroidClassCourse->sequence}}',
                                href: '/thyroid-class/course/view?course_id={{$thyroidClassCourse->id}}',
                                id: '{{$thyroidClassCourse->id}}'
                            },
                            @endforeach
                        ]
                    },
                    @endforeach
                ],
                currentPhase: '{{$course->thyroidClassPhase->id}}',
                currentCourse: '{{$course->id}}'
            },
            computed: {
                active: function () {

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
    <script src="http://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js"></script>
    <script type="text/javascript"> (function () {

            var interval;

            var option = {
                "auto_play": "0",
                "file_id": "{{$course->qcloud_file_id}}",
                "app_id": "{{$course->qcloud_app_id}}",
                "width": 1920,
                "height": 1080,
                "date": "{{$date}}",
                "course_id": "{{$course->id}}",
            };
            /*调用播放器进行播放*/
            var func = {
                'playStatus': function (status) {

                    function timer() {

                        $.post('/thyroid-class/course/timer', {course_id: option.course_id, date:option.date}, function (data) {
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

//        $('.video-list').css('height', $('.video-list').prev().height());

    </script>
    <script>
        $(document).foundation();

        $('#video_'+vm.currentPhase).trigger('click');

    </script>
@endsection