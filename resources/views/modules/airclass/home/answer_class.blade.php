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

        <!-- lessons -->
        <div class="lessons">
            <h3 class="title"></h3>
            <div class="lesson_list row">
                @foreach ($units as $data)
                <div class="lesson col-xs-6 col-diy-20" style="margin-top: 20px"><a class="a_list" href="{{ url('video/'.$data->id) }}">
                        <img class="center-block" src="{{ $data->logo_url  }}" alt="">
                        <div class="caption">
                            <h3 class="title">{{ $data->title }}</h3>
                            <p class="introduction">{{ str_limit($data->comment, $limit = 100, $end = '...') }}</p>
                            <p class="price_and_persons">
                                {{--<span class="price">&yen;198.00</span>--}}
                                @if($data->course_type == 2)<span class="class_list_lock_icon pull-right"></span>@endif
                                <span class="persons pull-right">{{ $data->play_count }}人在学</span>
                            </p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>


    </div>

@endsection