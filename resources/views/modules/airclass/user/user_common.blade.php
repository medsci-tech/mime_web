@extends('modules.airclass.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin.css')}}" />
    @endsection

    @section('container')

        <header class="header">
            <div class="admin_user clearfix">
                <div class="user_img pull-left"><img src="{{asset('airclass/img/admin_user_img.png')}}"/></div>
                <div class="user_info">
                    <p><span class="name">{{ Session::get('user_login_session_key')['name'] }}</span><span class="phone">{{ Session::get('user_login_session_key')['phone'] }}</span></p>
                    <!--<p class="level">学员等级：<img src="{{asset('airclass/img/admin_user_level.png')}}" /></p>-->
                    <div class="level clearfix">
                        <div class="level_title pull-left">学员等级：</div>
                        <div class="level_progress pull-left">
                            <div class="level_progress_bg"></div>
                            <div class="level_progress_bar" style="width: {{ round(Session::get('user_login_session_key')['rank']/3, 2)*100  }}%;"></div>
                            <span class="icon icon_level icon_level_one @if (Session::get('user_login_session_key')['rank'] >= 1) active @endif"></span>
                            <span class="icon icon_level icon_level_two @if (Session::get('user_login_session_key')['rank'] >= 2) active @endif"></span>
                            <span class="icon icon_level icon_level_three @if (Session::get('user_login_session_key')['rank'] >= 3) active @endif"></span>
                        </div>
                    </div>
                    <p>
                        <span class="location">{{ Session::get('user_login_session_key')['province'] }}{{ Session::get('user_login_session_key')['city'] }}{{ Session::get('user_login_session_key')['area'] }}</span>
                        <span class="hospital">{{ Session::get('user_login_session_key')['hospital_name'] }}</span>
                        <span class="department">{{ Session::get('user_login_session_key')['office'] }}</span>
                        <span class="title">{{ Session::get('user_login_session_key')['title'] }}</span>
                        <span class="beans pull-right"><i class="icon icon_beans"></i>迈豆：{{ Redis::get('user:'.Session::get('user_login_session_key')['id'].':bean') }}</span>
                    </p>
                </div>
            </div>
        </header>

        <!-- main body -->
        <div class="main_body">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#adminNav-collapse" aria-expanded="false">
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
                    <div class="collapse navbar-collapse" id="adminNav-collapse">
                        <ul class="nav nav-stacked nav-pills admin_nav">
                            <li @if($current_active == 'study') class="active" @endif ><a href="{{url('user')}}">学习情况</a></li>
                            <li @if($current_active == 'msg') class="active" @endif ><a href="{{url('user/msg')}}">我的消息</a></li>
                            <li @if($current_active == 'comment') class="active" @endif ><a href="{{url('user/comment')}}">我的提问</a></li>
                            <li @if($current_active == 'info_edit') class="active" @endif ><a href="{{url('user/info_edit')}}">资料修改</a></li>
                            <li @if($current_active == 'pwd_edit') class="active" @endif ><a href="{{url('user/pwd_edit')}}">修改密码</a></li>
                            <li @if($current_active == 'private_class') class="active" @endif ><a href="{{url('user/private_class')}}">私教课</a></li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>

            @yield('user_container')

        </div>

@endsection

