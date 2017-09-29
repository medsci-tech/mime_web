@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_lessons.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">个人二维码</h3>
            <div class="lessons">
                <img src="{{ asset($img)  }}" style="max-width: 100%"/>
            </div>
        </div>

@endsection