@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_lessons.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">学习情况</h3>
            <div class="lessons">
                <div class="lesson clearfix">
                    <img class="lesson_img" src="{{asset('airclass/img/admin_lesson_img.jpg')}}"/>
                    <div class="lesson_info">
                        <h4 class="lesson_title">名师直播公开课</h4>
                        <p class="lesson_introduction">前端极速入门-名师直播公开课【课工场出品】</p>
                        <p class="lesson_data"><span class="icon icon_percentage"></span>已学30%<span class="icon icon_time"></span>用时30分钟</p>
                    </div>
                    <span class="lesson_date">2017/01/02</span>
                    <a class="btn_outline" href="#">继续学习</a>
                </div>
                <div class="lesson clearfix">
                    <img class="lesson_img" src="{{asset('airclass/img/admin_lesson_img.jpg')}}"/>
                    <div class="lesson_info">
                        <h4 class="lesson_title">名师直播公开课</h4>
                        <p class="lesson_introduction">前端极速入门-名师直播公开课【课工场出品】</p>
                        <p class="lesson_data"><span class="icon icon_percentage"></span>已学30%<span class="icon icon_time"></span>用时30分钟</p>
                    </div>
                    <span class="lesson_date">2017/01/02</span>
                    <a class="btn_outline" href="#">继续学习</a>
                </div>
                <div class="lesson clearfix">
                    <img class="lesson_img" src="{{asset('airclass/img/admin_lesson_img.jpg')}}"/>
                    <div class="lesson_info">
                        <h4 class="lesson_title">名师直播公开课</h4>
                        <p class="lesson_introduction">前端极速入门-名师直播公开课【课工场出品】</p>
                        <p class="lesson_data"><span class="icon icon_percentage"></span>已学30%<span class="icon icon_time"></span>用时30分钟</p>
                    </div>
                    <span class="lesson_date">2017/01/02</span>
                    <a class="btn_outline" href="#">继续学习</a>
                </div>
            </div>
        </div>

@endsection