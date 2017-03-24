@extends('modules.airclass.user.user_common')

@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_asks.css')}}" />
    @endsection

    @section('user_container')

        <div class="admin_content asks_and_answers">
            <h3 class="admin_title">我的提问</h3>
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
                            <p class="ask_content"><a href="{{url('video', ['id' => $comment['class_id']])}}">{{$comment['content']}}</a></p>
                            <div class="ask_params pull-right">
                                <span class="icon icon_thumb_up"></span>
                                <span class="icon icon_msg" data-id="{{$comment['id']}}" data-to_id="{{$comment['from_id']}}" data-to_name="{{$comment['from_name']}}"></span>
                                @if($comment['child'])
                                    {{count($comment['child'])}}
                                @endif
                            </div>

                            @if($comment['child'])
                                @foreach($comment['child'] as $comment_child)
                            <div class="answer" data-prev_id="{{$comment_child['id']}}" data-parent_id="{{$comment_child['parent_id']}}">
                                <div class="answer_info media">
                                    <div class="media-left">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <span class="username">{{$comment_child['from_name']}}</span>
                                            <span class="reply"> 回复 </span>
                                            <span class="username">{{$comment_child['to_name']}}</span>
                                            <span class="ask_time">{{$comment_child['created_at']}}</span></h4>
                                        </h4>
                                        <p class="ask_content">{{$comment_child['content']}}</p>
                                        <div class="ask_params pull-right">
                                            <span class="icon icon_thumb_up"></span>
                                            <span class="icon icon_msg_sub" data-id="{{$comment['id']}}" data-to_id="{{$comment_child['from_id']}}" data-to_name="{{$comment_child['from_name']}}"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endforeach
                            @endif
                            <div class="pages_new more_answers" @if(count($comment['child']) < 10) style="display:none;" @endif>
                                查看更多
                            </div>
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

@endsection

@section('js')
    <script>
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
                            html += '                    <div class="answer_info media"><div class="media-left">&nbsp;&nbsp;&nbsp;&nbsp;</div>';
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
                            + '<div class="answer_info media"><div class="media-left">&nbsp;&nbsp;&nbsp;&nbsp;</div>'
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


        // 评论
        $(function () {
            var get_comment_action = '{{url('user/get_more_comments')}}';
            var get_comment_num = parseInt('{{$get_comment_num}}');

            $('.asks').on('click', '.more_questions', function () {
                var prev_dom = $(this).prev('.ask');
                var perv_id = prev_dom.data('prev_id');
                var data = {
                    'prev_id': perv_id,
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
        });
    </script>
    @endsection