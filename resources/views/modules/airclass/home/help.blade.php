@extends('modules.airclass.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/help.css')}}" />
    @endsection
    @section('container')
<!-- header -->
<header class="header text-center">
    帮助
</header>

<!-- main body -->
<div class="main_body container-fluid">
    <div id="helpNav">


        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#helpNav-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="javascript:void(0);">
                        目录
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="helpNav-collapse">
                    <ul class="nav nav-stacked help_nav">
                        <li class="active"><a href="#helpIntro">课程介绍</a></li>
                        <li><a href="#helpSpecialist">授课专家</a></li>
                        <li><a href="#helpLessons">课程表</a></li>
                        <li><a href="#helpLearn">学习方式</a></li>
                        <li><a href="#helpApply">报名方式</a></li>
                        <li><a href="#helpPoints">积分规则</a></li>
                        <li><a href="#helpContact">联系我们</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

    </div>
    <div class="help_content" data-spy="scroll" data-target="#helpNav">
        <div class="isolate_module">
            <h4 id="helpIntro">课程介绍</h4>
            <p>总课时：87节。由糖尿病基础知识、糖尿病的药物治疗、糖尿病管理、糖尿病并发症管理、特殊类型/人群糖尿病和其他内分泌疾病6大专题组成，其中公开课：37节；答疑课：20节；私教课：30节</p>
        </div>
        <div class="isolate_module">
            <h4 id="helpSpecialist">授课专家</h4>
            <div class="row specialists">
                <div class="col-sm-3 specialist text-center">
                    <img src="{{asset('airclass/img/help_teacher_1.jpg')}}"/>
                    <p class="name">杨文英 教授</p>
                    <p class="hospital">中日友好医院</p>
                    <p class="title">内分泌代谢中心主任</p>
                </div>
                <div class="col-sm-3 specialist text-center">
                    <img src="{{asset('airclass/img/help_teacher_2.jpg')}}"/>
                    <p class="name">许樟荣 教授</p>
                    <p class="hospital">解放军306医院</p>
                    <p class="title">全军糖尿病诊治中心主任</p>
                </div>
                <div class="col-sm-3 specialist text-center">
                    <img src="{{asset('airclass/img/help_teacher_3.jpg')}}"/>
                    <p class="name">窦京涛 教授</p>
                    <p class="hospital">解放军总医院</p>
                    <p class="title">内分泌科副主任</p>
                </div>
                <div class="col-sm-3 specialist text-center">
                    <img src="{{asset('airclass/img/help_teacher_4.jpg')}}"/>
                    <p class="name">吕朝晖 教授</p>
                    <p class="hospital">解放军总医院</p>
                    <p class="title">内分泌科副主任</p>
                </div>
            </div>
        </div>
        <div class="isolate_module">
            <h4 id="helpLessons">课程表</h4>
            <img class="center-block help_lessons" src="{{asset('airclass/img/help_lessons.jpg')}}"/>
        </div>
        <div class="isolate_module">
            <h4 id="helpLearn">学习方式</h4>
            <p>微信学习</p>
            <p>第一步：关注“空中课堂云课堂”微信号</p>
            <p>第二步：在右上角公众号信息中点击"查看历史消息"</p>
            <p>第三步：找到想要学习的课程，点击学习</p>
            <p class="margin_top_40">网页学习</p>
            <p>第一步：登陆网址：http://mime.org.cn/airclass</p>
            <p>第二步：点击公开课专题目录，学习课程</p>
            <p>电话学习</p>
            <p>接听010-56161166的来电，或自行拨打400-680-8263，输入密码6688入会。（凡自行拨打电话接入的学员都由自己承担电话费用）</p>
        </div>
        <div class="isolate_module">
            <h4 id="helpApply">报名方式</h4>
            <p>方式一：报名需从微信端入口报名：微信扫描空课志愿者专属二维码--填写报名资料-报名成功</p>
            <p>方式二：空课网站注册—手机号验证--微信扫描空课志愿者专属二维码--填写报名资料--报名成功</p>
        </div>
        <div class="isolate_module">
            <h4 id="helpPoints">积分规则</h4>
            <p>1.参与活动即可获得积分，越参与积分越高；积分越高，奖励越丰厚。咨询电话：400-864-8883</p>
            <p>2.积分使用</p>
            <p>a.所有报名学员在线学习均可获得积分奖励； b.积分可在“积分商城”兑换礼品</p>
            <p>3.学员积分指标及分值表</p>
            <div class="points_imgs clearfix">
                <img class="detail" src="{{asset('airclass/img/help_points.jpg')}}"/>
                <img class="qrcode" src="{{asset('airclass/img/help_qrcode.png')}}"/>
            </div>
        </div>
        <div class="isolate_module help_contact">
            <h4 id="helpContact">联系我们</h4>
            <p>咨询热线：400-864-8883</p>
            <p>课程QQ群：364666518</p>
            <p>官方微信：空中课堂云课堂</p>
            <p>官方网站：<a href="http://airclass.mime.org.cn">airclass.mime.org.cn</a></p>
        </div>
    </div>
</div>


@endsection