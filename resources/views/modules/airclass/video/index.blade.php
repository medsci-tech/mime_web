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
                        {{--666--}}
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
                    <form id="form-ask_container">
                        <input type="hidden" name="parant_id" value="0">
                        <textarea class="ask_area" name="content" rows="3" placeholder="最多可输入1000个字"></textarea>
                        <button id="btn_ask_confirm" type="button" class="btn btn-default pull-right btn_ask_confirm">评论</button>
                    </form>
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
                                        <span class="icon icon_msg" data-id="{{$comment['id']}}" data-to_id="{{$comment['from_id']}}" data-to_name="{{$comment['from_name']}}"></span>
                                        @if($comment['child'])
                                        {{count($comment['child'])}}
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
                                                        <span class="reply"> 回复 </span>
                                                        <span class="username">{{$comment_child['to_name']}}</span>
                                                        <span class="ask_time">{{$comment_child['created_at']}}</span></h4>
                                                    <p class="ask_content">
                                                        {{$comment_child['content']}}
                                                    </p>
                                                    <div class="ask_params pull-right">
                                                        <span class="icon icon_thumb_up"></span>
                                                        <span class="icon icon_msg_sub" data-id="{{$comment['id']}}" data-to_id="{{$comment_child['from_id']}}" data-to_name="{{$comment_child['from_name']}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="pages_new more_answers" @if(count($comment['child']) < 10) style="display:none;" @endif>
                                                查看更多
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    <div class="pages_new more_questions" @if(count($comments) < $get_comment_num) style="display:none;" @endif>
                        查看更多
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
        <form id="form-answer_container">
            <input type="hidden" name="parent_id">
            <input type="hidden" name="to_id">
            <input type="hidden" name="to_name">
            <textarea class="answer_area" name="content" rows="3" placeholder="最多可输入1000个字"></textarea>
            <div class="clearfix">
                <button type="button" class="btn btn-default pull-right btn_answer_cancel">取消</button>
                <button type="button" class="btn btn-default pull-right btn_answer_confirm" id="btn_answer_confirm">回复</button>
            </div>
        </form>
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
        // 答题
        $(function () {
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
        });
        // 视频播放
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
            var box = $('.answer_area_container');
            box.find('textarea').val('');
            box.hide();
            if (box.parents('.answer_box').find('.answer').length === 0) {
                box.parents('.answer_box').hide();
            }
        }
        function successAnswerBox() {
            var box = $('.answer_area_container');
            box.find('textarea').val('');
            box.hide();
            if (box.parents('.answer_box').find('.answer').length === 0) {
                box.parents('.answer_box').hide();
                window.location.reload(); // todo 多页刷新会怪怪的
            }
        }
        function hideAskBox() {
            var box = $('.ask_area_container');
            box.find('textarea').val('');
            box.hide();
        }
        function renderAsk(that, obj) {
            var obj_length = obj.length;
            var get_comment_num = parseInt('{{$get_comment_num}}');
            if(obj_length > 0){
                for (var i = 0; i < obj_length; i++) {
                    var child_obj = obj[i]['child'];
                    var child_length = child_obj.length;
                    var html = '';
                    html += '<div class="ask" data-prev_id="' + obj[i]['id'] + '">';
                    html += '    <div class="ask_info media">';
                    html += '        <div class="media-body">';
                    html += '            <h4 class="media-heading">';
                    html += '                <span class="username">' + obj[i]['from_name'] + '</span>';
                    html += '                <span class="ask_time">' + obj[i]['created_at'] + '</span>';
                    html += '            </h4>';
                    html += '            <p class="ask_content">' + obj[i]['content'] + '</p>';
                    html += '            <div class="ask_params pull-right">';
                    html += '                <span class="icon icon_thumb_up"></span>';
                    html += '                <span class="icon icon_msg" data-id="' + obj[i]['id'] + '" data-to_id="' + obj[i]['from_id'] + '" data-to_name="' + obj[i]['from_name'] + '"></span>';
                    html += child_length;
                    html += '            </div>';
                    if(child_length > 0){
                        html += '            <div class="answer_box">';
                        for(var j = 0; j < child_length; j++){
                            html += '                <div class="answer" data-prev_id="' + child_obj[j]['id'] + '" data-parent_id="' + child_obj[j]['parent_id'] + '">';
                            html += '                    <div class="answer_info media">';
                            html += '                        <div class="media-body">';
                            html += '                            <h4 class="media-heading">';
                            html += '                                <span class="username">' + child_obj[j]['from_name'] + '</span>';
                            html += '                                <span class="reply"> 回复 </span> ';
                            html += '                                <span class="username">' + child_obj[j]['to_name'] + '</span>';
                            html += '                                <span class="ask_time">' + child_obj[j]['created_at'] + '</span></h4>';
                            html += '                            <p class="ask_content">' + child_obj[j]['content'] + '</p>';
                            html += '                            <div class="ask_params pull-right">';
                            html += '                                <span class="icon icon_thumb_up"></span>';
                            html += '                                <span class="icon icon_msg_sub" data-id="' + obj[i]['id'] + '" data-to_id="' + child_obj[j]['from_id'] + '" data-to_name="' + child_obj[j]['from_name'] + '"></span>';
                            html += '                            </div>';
                            html += '                        </div>';
                            html += '                    </div>';
                            html += '                </div>';
                        }
                        html += '                <div class="pages_new more_answers" ';
                        if(child_length < get_comment_num){
                            html += ' style="display:none;" ';
                        }
                        html +=    '>查看更多';
                        html += '                </div>';
                        html += '            </div>';
                    }
                    html += '        </div>';
                    html += '    </div>';
                    html += '</div>';
                    that.after(html);
                }
            }
        }
        function renderAnswer(that, obj) {
            var obj_length = obj.length;
            if(obj_length > 0){
                for (var i = 0; i < obj_length; i++) {
                    var html = '<div class="answer" data-prev_id="' + obj[i]['id'] + '" data-parent_id="' + obj[i]['parent_id'] + '">'
                        + '<div class="answer_info media">'
                        + '<div class="media-body">'
                        + '<h4 class="media-heading">' +
                        '<span class="username">' + obj[i]['from_name'] + '</span>' +
                                '<span class="reply"> 回复 </span>' +
                        '<span class="username">' + obj[i]['to_name'] + '</span>' +
                        '<span class="ask_time">' + obj[i]['created_at'] + '</span>' +
                        '</h4>'
                        + '<p class="ask_content">' + obj[i]['content'] + '</p>'
                        + '<div class="ask_params pull-right">'
                        + '<span class="icon icon_thumb_up"></span>'
                        + '<span class="icon icon_msg_sub" data-id="' + obj[i]['parent_id'] + '" data-to_id="' + obj[i]['from_id'] + '" data-to_name="' + obj[i]['from_name'] + '"></span>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';
                    that.after(html);
                }
            }
        }

        var subCommentAjax = function (action, data, show_dom) {
            $.ajax({
                type: 'post',
                url: action,
                data: data,
                success: function(res){
                    if(res.code == 200){
                        successAnswerBox();
                        hideAskBox();
                        show_dom.show();
                    }
                    showAlertModal(res.msg);
                },
                error:function (res) {
                    showAlertModal('服务器错误');
                }
            });
        };
        // 评论
        $(function () {
            var get_comment_action = '{{url('video/get_more_comments')}}';
            var create_comment_action = '{{url('video/comment', ['id' => $current_id])}}';
            var get_comment_num = parseInt('{{$get_comment_num}}');
            // 一级评论
            $('.btn_ask').on('click', function() {
                $('.ask_area_container').slideToggle();
            });
            $('#btn_ask_confirm').on('click', function () {
                var form_data = $('#form-ask_container').serialize();
                var show_dom = $('.more_questions');
                subCommentAjax(create_comment_action,form_data, show_dom);
            });
            // 二级评论
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
                var parent_id = $(this).data('id');
                var to_id = $(this).data('to_id');
                var to_name = $(this).data('to_name');

                var form_dom = $('#form-answer_container');
                form_dom.find('[name="parent_id"]').val(parent_id);
                form_dom.find('[name="to_id"]').val(to_id);
                form_dom.find('[name="to_name"]').val(to_name);
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

                var parent_id = $(this).data('id');
                var to_id = $(this).data('to_id');
                var to_name = $(this).data('to_name');

                var form_dom = $('#form-answer_container');
                form_dom.find('[name="parent_id"]').val(parent_id);
                form_dom.find('[name="to_id"]').val(to_id);
                form_dom.find('[name="to_name"]').val(to_name);
            });

            $('.btn_answer_cancel').click(function () {
                hideAnswerBox();
            });


            $('#btn_answer_confirm').on('click', function () {
                var form_data = $('#form-answer_container').serialize();
                var show_dom = $(this).parents('.answer_box').find('.more_answers');
                subCommentAjax(create_comment_action,form_data, show_dom);
            });

            $('.asks').on('click', '.more_questions', function () {
                var prev_dom = $(this).prev('.ask');
                var perv_id = prev_dom.data('prev_id');
                var data = {
                    'prev_id': perv_id,
                    'class_id': '{{$current_id}}',
                    'parent_id': 0
                };
                $.ajax({
                    type: 'post',
                    url: get_comment_action,
                    data: data,
                    success: function(res){
                        if(res.code == 200){
                            if(res.data.length < get_comment_num){
                                prev_dom.next('.more_questions').hide();
                            }else {
                                prev_dom.next('.more_questions').show();
                            }
                            renderAsk(prev_dom, res.data);
                        }else {
                            prev_dom.next('.more_questions').hide();
                        }
                    },
                    error:function (res) {
                        prev_dom.next('.more_questions').hide();
                    }
                });
            });

            $('.asks').on('click', '.more_answers', function () {
                var prev_dom = $(this).prev('.answer');
                var perv_id = prev_dom.data('prev_id');
                var parent_id = prev_dom.data('parent_id');
                var data = {
                    'prev_id': perv_id,
                    'class_id': '{{$current_id}}',
                    'parent_id': parent_id
                };
                $.ajax({
                    type: 'post',
                    url: get_comment_action,
                    data: data,
                    success: function(res){
                        if(res.code == 200){
                            if(res.data.length < get_comment_num){
                                prev_dom.next('.more_answers').hide();
                            }else {
                                prev_dom.next('.more_answers').show();
                            }
                            renderAnswer(prev_dom, res.data);
                        }else {
                            prev_dom.next('.more_answers').hide();
                        }
                    },
                    error:function (res) {
                        prev_dom.next('.more_answers').hide();
                    }
                });

            });

            // 滚动加载
//            var scrollTimer;
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