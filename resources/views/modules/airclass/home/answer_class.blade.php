@extends('modules.airclass.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/index.css')}}" />
    @endsection
    @section('container')

    <header class="header text-center">
        答疑课
    </header>

    <!-- main body -->
    <div class="main_body">
    @foreach ($units as $data)
        @if (count($data['course_list']) > 0)
        <!-- lessons -->
        <div class="lessons">
            <h3 class="title">{{ $data['teacher_name'] }}</h3>
            <div class="lesson_list row">
                @foreach($data['course_list'] as $val)
                <div class="lesson col-xs-6 col-diy-20"><a href="{{ URL('video/'.$val->id) }}"">
                        <img class="center-block" src="{{ $val->logo_url  }}" alt="">
                        <div class="caption">
                            <h3 class="title">{{ $val->title }}</h3>
                            <p class="introduction">{{ str_limit($val->comment, $limit = 100, $end = '...') }}</p>
                            <p class="price_and_persons">
                                {{--<span class="price">&yen;198.00</span>--}}
                                <span class="persons pull-right">{{ $val->play_count }}人在学</span>
                            </p>
                        </div>
                    </a></div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

    </div>

@endsection