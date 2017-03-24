@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_lessons.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">学习情况</h3>
            <div class="lessons">
                @foreach ($units as $data)
                <div class="lesson clearfix">
                    <img class="lesson_img" src="{{ $data->logo_url  }}"/>
                    <div class="lesson_info">
                        <h4 class="lesson_title">{{ $data->title }}</h4>
                        <p class="lesson_introduction">{{ str_limit($data->comment, $limit = 100, $end = '...') }}</p>
                        <p class="lesson_data"><span class="icon icon_percentage"></span>已学{{ isset($data->percent) ? $data->percent*100 : 0 }}%<span class="icon icon_time"></span>用时{{ ceil($data->duration_count/60) }}分钟</p>
                    </div>
                    <span class="lesson_date">{{ $data->date_time  }}</span>
                    <a class="btn_outline" href="{{ URL('video/'.$data->id) }}" target="_blank">继续学习</a>
                </div>
                @endforeach
            </div>
        </div>

@endsection