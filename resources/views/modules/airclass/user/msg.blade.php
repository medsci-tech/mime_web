@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_msgs.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">我的消息</h3>
            <div class="msgs">
                @foreach ($lists as $data)
                <div class="msg clearfix">
                    <h4 class="msg_title">系统消息</h4>
                    <p class="msg_content">
                        <span>{{ $data->content  }}</span></p>
                    <span class="msg_date">{{ date("Y/m/d",strtotime($data->created_at)) }}</span>
                </div>
                @endforeach
            </div>
            {{$lists->links()}}
        </div>

@endsection