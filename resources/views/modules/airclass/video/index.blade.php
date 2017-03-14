@extends('modules.airclass.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/index.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/play.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_asks.css')}}" />
@endsection
@section('container')
    <div class="main_body">

        <!-- video container -->
        <div class="video_container active clearfix">
            <div class="video_wrapper">
                <div id="id_video_container" style="width: 100%;"></div>
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
                <a id="btnChapter" class="btn_chapter" href="javascript:;"><img src="{{asset('airclass/img/icon_play_chapter.jpg')}}"/></a>
                <h4 class="title">课程表</h4>
                <ul class="chapters_list">
                    @foreach($chapter_classes as $chapter_class)
                    <li class="chapter"><a href="{{url('video', ['id' => $chapter_class->id])}}">{{$chapter_class->title}}</a></li>

                    @endforeach

                        <li class="chapter">认识糖尿病<span class="icon icon_play_played pull-right"></span></li>
                </ul>
            </div>
        </div>

        <div class="relative_info clearfix">
            <!-- asks and answers -->
            <div class="asks_and_answers">
                <div class="ask_answer_btns">
                    <a href="javascript:;" class="btn_ask">提问</a>
                    <span class="devider">|</span>
                    <a href="javascript:;" class="btn_answer">答题／解析</a>
                </div>
                <div class="ask_area_container">
                    <textarea class="ask_area" name=""></textarea>
                    <button type="button" class="btn btn-default pull-right btn_ask_confirm">提问</button>
                </div>

                <h3 class="asks_title">全部问题</h3>
                <div class="asks">
                    <div class="pages clearfix">
                        <span class="page_info pull-left">第1页／共5页</span>
                        <div class="pull-right">
                            <a href="javascript:;" class="page active">1</a>
                            <a href="javascript:;" class="page">2</a>
                            <a href="javascript:;" class="page">3</a>
                            <a href="javascript:;" class="page">4</a>
                            <a href="javascript:;" class="page">5</a>
                            <a href="javascript:;" class="page_prev">上一页</a>
                            <a href="javascript:;" class="page_next">下一页</a>
                        </div>
                    </div>
                    <div class="ask">
                        <div class="ask_info media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="{{asset('airclass/img/admin_ask_userimg.png')}}" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><span class="username">CC果冻嘻嘻</span><span class="ask_time">刚刚</span></h4>
                                <p class="ask_content">互联网金融适合用第三方数据平台吗？担心数据泄露问题？</p>
                                <div class="ask_params pull-right">
                                    <span class="icon icon_thumb_up"></span>
                                    666
                                    <!--<span class="icon icon_thumb_down"></span>
                                    0-->
                                    <span class="icon icon_msg"></span>
                                    0
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ask">
                        <div class="ask_info media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="{{asset('airclass/img/admin_ask_userimg.png')}}" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><span class="username">CC果冻嘻嘻</span><span class="ask_time">40分钟前</span></h4>
                                <p class="ask_content">互联网金融适合用第三方数据平台吗？担心数据泄露问题？</p>
                                <div class="ask_params">
                                    <span class="icon icon_thumb_up"></span>
                                    666
                                    <!--<span class="icon icon_thumb_down"></span>
                                    0-->
                                    <span class="icon icon_msg"></span>
                                    0
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ask">
                        <div class="ask_info media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="{{asset('airclass/img/admin_ask_userimg.png')}}" alt="">
                                </a>
                            </div>
                            <div class="media-body" id="a">
                                <h4 class="media-heading"><span class="username">CC果冻嘻嘻</span><span class="ask_time">2017-02-12 12:16</span></h4>
                                <p class="ask_content">互联网金融适合用第三方数据平台吗？担心数据泄露问题？</p>
                                <div class="ask_params pull-right">
                                    <span class="icon icon_thumb_up"></span>
                                    666
                                    <!--<span class="icon icon_thumb_down"></span>
                                    0-->
                                    <span class="icon icon_msg"></span>
                                    1
                                </div>

                                <div class="answer_box">
                                    <div class="answer">
                                        <div class="answer_info media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object" src="{{asset('airclass/img/admin_ask_userimg.png')}}" alt="">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading"><span class="username">杨文英教授</span><span class="ask_time">2017-02-12 12:16</span></h4>
                                                <p class="ask_content">据我所知，有技巧的公司會避免直接把核心数据导入第三方，可能先将数据自行处理一下（例如放一些错误数据混淆视听，也可以拿来钓鱼）。利用三方工具无非是要得到一个结果呈现，只要本身计算过程能够提供这种结果就没问题。可能先将数据自行处理一下（例如放一些错误数据混淆视听，也可以拿来钓鱼）。利用三方工具无非是要得到一个结果呈现，只要本身计算过程能够提供这种结果就没问题。</p>
                                                <div class="ask_params pull-right">
                                                    <span class="icon icon_thumb_up"></span>
                                                    666
                                                    <!--<span class="icon icon_thumb_down"></span>
                                                    0-->
                                                    <span class="icon icon_msg"></span>
                                                    1
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pages clearfix">
                                        <span class="page_info pull-left">第1页／共5页</span>
                                        <div class="pull-right">
                                            <a href="javascript:;" class="page active">1</a>
                                            <a href="javascript:;" class="page">2</a>
                                            <a href="javascript:;" class="page">3</a>
                                            <a href="javascript:;" class="page">4</a>
                                            <a href="javascript:;" class="page">5</a>
                                            <a href="javascript:;" class="page_prev">上一页</a>
                                            <a href="javascript:;" class="page_next">下一页</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pages clearfix">
                        <span class="page_info pull-left">第1页／共5页</span>
                        <div class="pull-right">
                            <a href="javascript:;" class="page active">1</a>
                            <a href="javascript:;" class="page">2</a>
                            <a href="javascript:;" class="page">3</a>
                            <a href="javascript:;" class="page">4</a>
                            <a href="javascript:;" class="page">5</a>
                            <a href="javascript:;" class="page_prev">上一页</a>
                            <a href="javascript:;" class="page_next">下一页</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- videos recommended	 -->
            <div class="recommended_videos lessons">
                <h4 class="title">相关推荐</h4>
                <div class="lesson col-xs-6 col-sm-12"><a href="javascript:void(0);">
                        <img class="center-block" src="{{asset('airclass/img/lesson_1.jpg')}}" alt="">
                        <div class="caption">
                            <h3 class="title">名师直播公开课</h3>
                            <p class="introduction">前端极速入门-名师直播公开课【课工场出品】</p>
                            <p class="price_and_persons">
                                <span class="price">&yen;198.00</span>
                                <span class="persons pull-right">2123人在学</span>
                            </p>
                        </div>
                    </a></div>
                <div class="lesson col-xs-6 col-sm-12"><a href="javascript:void(0);">
                        <img class="center-block" src="{{asset('airclass/img/lesson_1.jpg')}}" alt="">
                        <div class="caption">
                            <h3 class="title">名师直播公开课</h3>
                            <p class="introduction">前端极速入门-名师直播公开课【课工场出品】</p>
                            <p class="price_and_persons">
                                <span class="price">&yen;198.00</span>
                                <span class="persons pull-right">2123人在学</span>
                            </p>
                        </div>
                    </a></div>
                <div class="lesson col-xs-6 col-sm-12"><a href="javascript:void(0);">
                        <img class="center-block" src="{{asset('airclass/img/lesson_1.jpg')}}" alt="">
                        <div class="caption">
                            <h3 class="title">名师直播公开课</h3>
                            <p class="introduction">前端极速入门-名师直播公开课【课工场出品】</p>
                            <p class="price_and_persons">
                                <span class="price">&yen;198.00</span>
                                <span class="persons pull-right">2123人在学</span>
                            </p>
                        </div>
                    </a></div>
                <div class="lesson col-xs-6 col-sm-12"><a href="javascript:void(0);">
                        <img class="center-block" src="{{asset('airclass/img/lesson_1.jpg')}}" alt="">
                        <div class="caption">
                            <h3 class="title">名师直播公开课</h3>
                            <p class="introduction">前端极速入门-名师直播公开课【课工场出品】</p>
                            <p class="price_and_persons">
                                <span class="price">&yen;198.00</span>
                                <span class="persons pull-right">2123人在学</span>
                            </p>
                        </div>
                    </a></div>
            </div>
        </div>


        <div class="test_btns" style="width: 200px; margin: 60px auto;">
            <h4>modal测试用按钮</h4>
            <button class="test_answer">答题</button>
            <button class="test_success">加分提醒</button>
        </div>


    </div>

    <!-- answer area -->
    <div class="answer_area_container">
        <h4 class="username">CC果冻嘻嘻</h4>
        <textarea class="answer_area" name=""></textarea>
        <div class="clearfix">
            <button type="button" class="btn btn-default pull-right btn_answer_cancel">取消</button>
            <button type="button" class="btn btn-default pull-right btn_answer_confirm">回复</button>
        </div>
    </div>


    <!-- modals -->
    <!-- questions modal -->
    <div class="questions_modal modal fade" id="questionsModal" tabindex="-1" role="dialog" aria-labelledby="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="title text-center">答题</h3>
                <ol class="questions">

                    <li class="question_container">
                        <span class="icon icon_success"></span>
                        <h4 class="question">2007年7月，日本研究人员在染色体中发现了一种使姐妹染色单体连接成十字形的关键蛋白质，并将其命名为“ASURA”。据此判断下列叙述不正确的是？ </h4>
                        <ol class="choices">
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_one" checked>
                                        <span class="radio_img"></span>
                                        ASURA合成的场所是细胞质中的核糖体
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_one">
                                        <span class="radio_img"></span>
                                        在减数第一次分裂和第二次分裂之前都有ASURA的大量合成
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_one">
                                        <span class="radio_img"></span>
                                        缺少ASURA的细胞，染色体数目可能会发生异常
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_one">
                                        <span class="radio_img"></span>
                                        细胞有丝分裂后期的变化与ASURA密切相关
                                    </label>
                                </div>
                            </li>
                        </ol>
                    </li>

                    <li class="question_container">
                        <span class="icon icon_question"></span>
                        <h4 class="question">2007年7月，日本研究人员在染色体中发现了一种使姐妹染色单体连接成十字形的关键蛋白质，并将其命名为“ASURA”。据此判断下列叙述不正确的是？ </h4>
                        <ol class="choices">
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_two">
                                        <span class="radio_img"></span>
                                        ASURA合成的场所是细胞质中的核糖体
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_two">
                                        <span class="radio_img"></span>
                                        在减数第一次分裂和第二次分裂之前都有ASURA的大量合成
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_two">
                                        <span class="radio_img"></span>
                                        缺少ASURA的细胞，染色体数目可能会发生异常
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_two">
                                        <span class="radio_img"></span>
                                        细胞有丝分裂后期的变化与ASURA密切相关
                                    </label>
                                </div>
                            </li>
                        </ol>
                    </li>


                    <li class="question_container">
                        <span class="icon icon_question"></span>
                        <h4 class="question">2007年7月，日本研究人员在染色体中发现了一种使姐妹染色单体连接成十字形的关键蛋白质，并将其命名为“ASURA”。据此判断下列叙述不正确的是？ </h4>
                        <ol class="choices horizontal_list clearfix">
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_three">
                                        <span class="radio_img"></span>
                                        1分
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_three">
                                        <span class="radio_img"></span>
                                        2分
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_three">
                                        <span class="radio_img"></span>
                                        3分
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_three">
                                        <span class="radio_img"></span>
                                        4分
                                    </label>
                                </div>
                            </li>
                            <li class="choice">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="question_three">
                                        <span class="radio_img"></span>
                                        5分
                                    </label>
                                </div>
                            </li>
                        </ol>
                    </li>
                </ol>

                <button type="button" class="btn btn-block btn_questions_modal_confirm">提交</button>
            </div>
        </div>
    </div>
    <!-- success modal -->
    <div class="success_modal modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="tips_container text-center"><span class="icon icon_success"></span><span class="tips">恭喜您，获得15积分</span></div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script src="http://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js"></script>
    <script type="text/javascript">
        $('#btnChapter').click(function() {
            $('.video_container').toggleClass('active');
        });

        $('.test_answer').click(function() {
            $('#questionsModal').modal('show');
        });

        $('.btn_questions_modal_confirm, .test_success').click(function() {
            $('#questionsModal').modal('hide');
            $('#successModal').modal('show');
            setTimeout(function() {
                $('#successModal').modal('hide');
            }, 1500);
        });

        $('#questionsModal :radio').change(function() {
            $(this).parents('.question_container').find('.icon').removeClass('icon_question').addClass('icon_success');
        });

        $('.btn_ask').click(function() {
            $('.ask_area_container').slideToggle();
        });

        $('.icon_msg').click(function() {
            hideAnswerBox();
            var mediaBody = $(this).parents('.media-body');
            var answerBox = mediaBody.find('.answer_box');
            console.log(answerBox.length);
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
        });

        $('.btn_answer_cancel').click(function() {
            hideAnswerBox();
        });

        function hideAnswerBox() {
            $('.answer_area_container').slideUp();
            if ($('.answer_area_container').parents('.answer_box').find('.answer').length === 0) {
                $('.answer_area_container').parents('.answer_box').slideUp();
            }
        }

        $(function () {
            var option = {
                "auto_play": "0",
                "file_id": "{{$class->qcloud_file_id}}",
                "app_id": "{{$class->qcloud_app_id}}",
                "width": 1280,
                "height": 720
            };
            /*调用播放器进行播放*/
            new qcVideo.Player(
                    /*代码中的id_video_container将会作为播放器放置的容器使用,可自行替换*/
                    "id_video_container",
                    option
            );
        });
    </script>
    @endsection