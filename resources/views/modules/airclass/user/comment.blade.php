@extends('modules.airclass.user.user_common')

@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_asks.css')}}" />
    @endsection

    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">我的提问</h3>
            <div class="asks">
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
                        <div class="media-body">
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
                    </div>
                </div>
            </div>
        </div>

@endsection