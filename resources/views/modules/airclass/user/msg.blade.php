@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_msgs.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">我的消息</h3>
            <div class="msgs">
                <div class="msg clearfix">
                    <h4 class="msg_title">系统消息</h4>
                    <p class="msg_content"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At earum odio ullam odit deleniti error vel temporibus modi eveniet non. Quos inventore eaque voluptatum suscipit dignissimos eveniet dolores et sapiente?</span>
                        <span>Eveniet perferendis necessitatibus minima quidem sapiente voluptate blanditiis alias tenetur atque porro adipisci expedita provident omnis autem dolores ipsum odit dolorum laborum doloribus asperiores distinctio hic deleniti inventore. Vitae cupiditate.</span></p>
                    <span class="msg_date">2017/01/02</span>
                </div>
                <div class="msg clearfix">
                    <h4 class="msg_title">系统消息</h4>
                    <p class="msg_content"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At earum odio ullam odit deleniti error vel temporibus modi eveniet non. Quos inventore eaque voluptatum suscipit dignissimos eveniet dolores et sapiente?</span>
                        <span>Eveniet perferendis necessitatibus minima quidem sapiente voluptate blanditiis alias tenetur atque porro adipisci expedita provident omnis autem dolores ipsum odit dolorum laborum doloribus asperiores distinctio hic deleniti inventore. Vitae cupiditate.</span></p>
                    <span class="msg_date">2017/01/02</span>
                </div>
                <div class="msg clearfix">
                    <h4 class="msg_title">系统消息</h4>
                    <p class="msg_content"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At earum odio ullam odit deleniti error vel temporibus modi eveniet non. Quos inventore eaque voluptatum suscipit dignissimos eveniet dolores et sapiente?</span>
                        <span>Eveniet perferendis necessitatibus minima quidem sapiente voluptate blanditiis alias tenetur atque porro adipisci expedita provident omnis autem dolores ipsum odit dolorum laborum doloribus asperiores distinctio hic deleniti inventore. Vitae cupiditate.</span></p>
                    <span class="msg_date">2017/01/02</span>
                </div>
            </div>
        </div>

@endsection