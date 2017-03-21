@extends('modules.airclass.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/index.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/play.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_asks.css')}}"/>
@endsection
@section('container')
    <div class="main_body">

        <!-- video container -->
        <div class="video_container clearfix">
            <div class="video_wrapper">
                <div id="id_video_container"></div>
                <div class="shares_and_thumbs clearfix">
                    <div class="shares pull-left">
                        分享给朋友：
                        <a href="javascript:;" class="icon icon_wechat_sm"></a>
                        <a href="javascript:;" class="icon icon_tencent_sm"></a>
                        <a href="javascript:;" class="icon icon_weibo_sm"></a>
                    </div>
                    <div class="thumbs pull-right">
                        <span class="icon icon_view_count"></span>
                        666
                        <!--<span class="icon icon_thumb_down"></span>
                        0-->
                    </div>
                </div>
            </div>
            <div class="chapters">
                <a id="btnChapter" class="btn_chapter" href="javascript:;"><img
                            src="{{asset('airclass/img/icon_play_chapter.jpg')}}"/></a>
                <h4 class="title">@if($chapter) {{$chapter->sequence}} @else 课程 @endif</h4>
                <ul class="chapters_list">
                    @if($chapter_classes)
                        @foreach($chapter_classes as $chapter_class)
                            <li class="chapter">
                                {{--当前视频--}}
                                @if($current_id == $chapter_class->id)
                                    <span class="a">{{$chapter_class->title}}</span>
                                    <span class="icon icon_play_played pull-right"></span>
                                @else
                                    @if($chapter_class->curse_type == 2)
                                        {{--选修课--}}
                                        <span class="a">{{$chapter_class->title}}</span>
                                        <span class="icon icon_play_locked pull-right"></span>
                                    @else
                                        {{--必修课--}}
                                        <a href="{{url('video', ['id' => $chapter_class->id])}}"
                                           title="{{$chapter_class->title}}">{{$chapter_class->title}}</a>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="relative_info clearfix">
            <!-- asks and answers -->
            <div class="asks_and_answers">
                <div class="ask_answer_btns">
                    <a href="javascript:;" class="btn_ask">评论</a>
                    @if($questions->count())
                        <span class="devider">|</span>
                        <a href="javascript:;" id="btn_answer" class="btn_answer">答题</a>
                    @endif
                </div>
                <div class="ask_area_container">
                    <textarea class="ask_area" name=""></textarea>
                    <button type="button" class="btn btn-default pull-right btn_ask_confirm">评论</button>
                </div>
                <h3 class="asks_title">全部评论</h3>
                <div class="asks">
                    @if($comments)
                    @foreach($comments as $comment)
                        <div class="ask" data-prev_id="{{$comment['id']}}">
                            <div class="ask_info media">
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <span class="username">{{$comment['from_name']}}</span>
                                        <span class="ask_time">{{$comment['created_at']}}</span>
                                    </h4>
                                    <p class="ask_content">{{$comment['content']}}</p>
                                    <div class="ask_params pull-right">
                                        <span class="icon icon_thumb_up"></span>
                                        666
                                        <span class="icon icon_msg"></span>
                                        @if($comment['child'])
                                        {{count($comment['child'])}}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    @if($comment['child'])
                                    <div class="answer_box">
                                        @foreach($comment['child'] as $comment_child)
                                        <div class="answer" data-prev_id="{{$comment_child['id']}}" data-parent_id="{{$comment_child['parent_id']}}">
                                            <div class="answer_info media">
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        <span class="username">{{$comment_child['from_name']}}</span>
                                                        回复
                                                        <span class="username">{{$comment_child['to_name']}}</span>
                                                        <span class="ask_time">{{$comment_child['created_at']}}</span></h4>
                                                    <p class="ask_content">
                                                        {{$comment_child['content']}}
                                                    </p>
                                                    <div class="ask_params pull-right">
                                                        <span class="icon icon_thumb_up"></span>
                                                        666
                                                        <span class="icon icon_msg_sub"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="pages_new more_answers">
                                            查看更多<span class="icon icon_more_answers"></span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    <div class="pages_new more_questions">
                        查看更多<span class="icon icon_more_questions"></span>
                    </div>
                </div>
            </div>

            <!-- videos recommended	 -->
            <div class="recommended_videos lessons">
                <h4 class="title">相关推荐</h4>
                @if($recommend_classes->count())
                    @foreach($recommend_classes as $recommend_class)
                        <div class="lesson col-xs-6 col-sm-12"><a
                                    href="{{url('video', ['id' => $recommend_class->id])}}">
                                <img class="center-block" src="{{$recommend_class->logo_url}}">
                                <div class="caption">
                                    <h3 class="title">{{$recommend_class->title}}</h3>
                                    <p class="introduction">{{$recommend_class->comment}}</p>
                                    <p class="price_and_persons">
                                        <span class="price">&yen;198.00</span>
                                        <span class="persons pull-right">{{$recommend_class->play_count}}人在学</span>
                                    </p>
                                </div>
                            </a></div>
                    @endforeach
                @endif
                @if($add_recommend_classes)
                    @foreach($add_recommend_classes as $add_recommend_class)
                        <div class="lesson col-xs-6 col-sm-12"><a
                                    href="{{url('video', ['id' => $add_recommend_class->id])}}">
                                <img class="center-block" src="{{$add_recommend_class->logo_url}}">
                                <div class="caption">
                                    <h3 class="title">{{$add_recommend_class->title}}</h3>
                                    <p class="introduction">{{$add_recommend_class->comment}}</p>
                                    <p class="price_and_persons">
                                        <span class="price">&yen;198.00</span>
                                        <span class="persons pull-right">{{$add_recommend_class->play_count}}人在学</span>
                                    </p>
                                </div>
                            </a></div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

    <!-- answer area -->
    <div class="answer_area_container">
        <textarea class="answer_area" name=""></textarea>
        <div class="clearfix">
            <button type="button" class="btn btn-default pull-right btn_answer_cancel">取消</button>
            <button type="button" class="btn btn-default pull-right btn_answer_confirm">回复</button>
        </div>
    </div>

    <div class="sub_answer_area_container">
        <textarea class="answer_area" name=""></textarea>
        <div class="clearfix">
            <button type="button" class="btn btn-default pull-right btn_answer_cancel">取消</button>
            <button type="button" class="btn btn-default pull-right btn_answer_confirm">回复</button>
        </div>
    </div>


    <!-- modals -->
    <!-- questions modal -->
    <div class="questions_modal modal fade" id="questionsModal" tabindex="-1" role="dialog"
         aria-labelledby="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 class="title text-center">答题</h3>
                <form id="questionForm">
                    <ol class="questions">
                        @if($questions->count())
                            @foreach($questions as $question)
                                <li class="question_container">
                                    <span class="icon icon_success"></span>
                                    <h4 class="question">{{$question->question}}</h4>
                                    <ol class="choices">
                                        @foreach(unserialize($question->option) as $key => $val)
                                            <li class="choice">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="q_{{$question->id}}" value="{{$key}}">
                                                        <span class="radio_img"></span>
                                                        {{$val}}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                </li>
                            @endforeach
                        @endif
                    </ol>
                </form>
                <button type="button" class="btn btn-block btn_questions_modal_confirm">提交</button>
            </div>
        </div>
    </div>
    <!-- success modal -->
    <div class="success_modal modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="tips_container text-center"><span class="icon icon_success"></span><span class="tips">恭喜您，获得15积分</span>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script src="http://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js"></script>
    <script type="text/javascript">
        var question_action = '{{url('video/answer', ['id' => $class->id])}}';
        $('#btnChapter').click(function () {
            var height = $('.video_wrapper').height();
            $('.video_container').toggleClass('active').find('.chapters').height(height);
        });

        $('#btn_answer').click(function () {
            var answer_status_mag = '{{$answer_status_mag}}';
            if (answer_status_mag) {
                showAlertModal(answer_status_mag);
            } else {
                $('#questionsModal').modal('show');
            }
        });

        // 答题
        $('.btn_questions_modal_confirm').click(function () {
            var data = $('#questionForm').serialize();
            subQuestionAjax(question_action, data);
//            tipsBeansModal('hahahha');
        });

        $('#questionsModal :radio').change(function () {
            $(this).parents('.question_container').find('.icon').removeClass('icon_question').addClass('icon_success');
        });

        $(function () {
            var time = parseInt('{{config('params')['video_heartbeat_times']}}') * 1000; // 心跳时间 16s
            var heartbeat_action = '{{url('video/heartbeat')}}';
            var watch_times_action = '{{url('video/watch_times')}}';
            var num = 0; // 视频播放状态为播放的次数
            var heartbeat_data = {
                'class_id': '{{$current_id}}' // 课程id
            };
            // 腾讯视频
            var option = {
                "auto_play": "0",
                "file_id": "{{$class->qcloud_file_id}}",
                "app_id": "{{$class->qcloud_app_id}}",
                "width": 1280,
                "height": 720,
                "remember": 1,
                "stretch_patch": true,
                @if ($video_status_mag)"stop_time": 180 @endif
            };
            var listener = {
                playStatus: function (status) {
                    if (status == 'stop') {
                        showAlertModal('{{$video_status_mag}}');
                    }
                    if (status == 'playing') {
                        if (num == 0 && '{{$user['id']}}') {
                            // 重新载入播放算一次播放次数
                            video_heartbeat_ajax(watch_times_action, heartbeat_data);
                        }
                        num++;
                    }
                }
            };

            /*调用播放器进行播放*/
            var player = new qcVideo.Player("id_video_container", option, listener);
            if ('{{$user['id']}}') {
                video_heartbeat(player, time, heartbeat_action, heartbeat_data);
            }
        });

        function hideAnswerBox() {
            $('.answer_area_container').hide();
            if ($('.answer_area_container').parents('.answer_box').find('.answer').length === 0) {
                $('.answer_area_container').parents('.answer_box').hide();
            }
        }

        function renderAsk() {
            var $this = $(this);
            for (var i = 0; i < 1; i++) {
                var html = '<div class="ask">'
                        + '<div class="ask_info media">'
                        + '<div class="media-body">'
                        + '<h4 class="media-heading"><span class="username">' + questionObj.username + '</span><span class="ask_time">' + questionObj.time + '</span></h4>'
                        + '<p class="ask_content">' + questionObj.content + '</p>'
                        + '<div class="ask_params">'
                        + '<span class="icon icon_thumb_up"></span>'
                        + questionObj.upCount
                        + '<span class="icon icon_msg"></span>'
                        + questionObj.replyCount
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';
                $(html).insertBefore($this);
            }
        }
        function renderAnswer(that, obj) {
            console.log(obj);
            for (var i = 0; i < obj.length; i++) {
                var html = '<div class="answer">'
                        + '<div class="answer_info media">'
                        + '<div class="media-body">'
                        + '<h4 class="media-heading">' +
                        '<span class="username">' + obj.from_name + '</span>' +
                        '<span class="username">' + obj.to_name + '</span>' +
                        '<span class="ask_time">' + obj.created_at + '</span>' +
                        '</h4>'
                        + '<p class="ask_content">' + obj.content + '</p>'
                        + '<div class="ask_params pull-right">'
                        + '<span class="icon icon_thumb_up"></span>'
                        + '<span class="icon icon_msg_sub"></span>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';
                that.before(html);
            }
            that.hide();
        }
        $(function () {
            var get_comment_action = '{{url('video/get_more_comments')}}';
            var questionObj = {
                'username': '测试问题',
                'time': '10分钟前',
                'img': 'img/admin_ask_userimg.png',
                'content': '内容内容',
                'upCount': 11,
                'replyCount': 0
            };

            var answerObj = {
                'username': '测试回复',
                'time': '10分钟前',
                'img': 'img/admin_ask_userimg.png',
                'content': '内容内容',
                'upCount': 11,
                'replyCount': 0
            };

            $('.btn_ask').click(function() {
                $('.ask_area_container').slideToggle();
            });
            $('.asks').on('click', '.icon_msg', function () {
                hideAnswerBox();
                var $this = $(this);
                var mediaBody = $this.parents('.media-body');
                var answerBox = mediaBody.find('.answer_box');
                if ($this.hasClass('areaShown')) {
                    $('.areaShown').removeClass('areaShown');
                } else {
                    $('.areaShown').removeClass('areaShown');
                    $this.addClass('areaShown');
                    if (answerBox.length !== 0) {
                        answerBox.show();
                        $('.answer_area_container').prependTo(answerBox);
                        $('.answer_area_container').slideDown();
                    } else {
                        mediaBody.append($('<div class="answer_box"></div>'))
                                .find('.answer_box')
                                .append($('.answer_area_container'));
                        $('.answer_area_container').slideDown();
                    }
                }
            });

            $('.asks').on('click', '.icon_msg_sub', function () {
                hideAnswerBox();
                var $this = $(this);
                var mediaBody = $this.parents('.answer .media-body');
                if ($this.hasClass('areaShown')) {
                    $('.areaShown').removeClass('areaShown');
                } else {
                    $('.areaShown').removeClass('areaShown');
                    $this.addClass('areaShown');
                    $('.answer_area_container').appendTo(mediaBody);
                    $('.answer_area_container').slideDown();
                }
            });

            $('.btn_answer_cancel').click(function () {
                hideAnswerBox();
            });

            $('.asks').on('click', '.more_questions', function () {
                var render = renderAsk.bind(this);
                render();
            });

            $('.asks').on('click', '.more_answers', function () {
                var prev_dom = $(this).prev('.answer');
                var perv_id = prev_dom.data('prev_id');
                var parent_id = prev_dom.data('parent_id');
                var data = {
                    'prev_id': 0,
                    'class_id': '{{$current_id}}',
                    'parent_id': 1
                };
                $.ajax({
                    type: 'post',
                    url: get_comment_action,
                    data: data,
                    success: function(res){
                        console.log(res);
                        console.log((res.data).length);
                        if(res.code == 200){
                            var render = renderAnswer($(this), res.data);
                            render();
                        }
                    },
                    error:function (res) {

                    }
                });

            });

            var scrollTimer;
//            $(window).scroll(function () {
//                var scrollTop = $(window).scrollTop();
//                var windowHeight = $('window').height();
//                var totalHeight = parseFloat($(window).height()) + parseFloat(scrollTop);
//                clearTimeout(scrollTimer);
//                if ($('.more_questions').offset().top <= totalHeight) {
//                    scrollTimer = setTimeout(function () {
//                        $('.more_questions').click();
//                    }, 400);
//                }
//            });


        });
    </script>
@endsection