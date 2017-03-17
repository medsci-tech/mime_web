@extends('modules.airclass.layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('airclass/css/common.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('airclass/css/index.css')}}" />
@endsection
@section('container')
    <!-- header -->
    <header class="header text-center">
        搜索结果
    </header>

    <!-- main body -->
    <div class="main_body">

        <!-- lessons -->
        <div class="lessons">
            <h3 class="title">{{ $keyword }}</h3>
            <div class="lesson_list row">
                @foreach ($units as $data)
                <div class="lesson col-xs-6 col-diy-20"><a href="javascript:void(0);">
                        <img class="center-block" src="{{ $data->logo_url  }}" alt="">
                        <div class="caption">
                            <h3 class="title">{{ $data->title }}</h3>
                            <p class="introduction">{{ str_limit($data->comment, $limit = 100, $end = '...') }}</p>
                            <p class="price_and_persons">
                                {{--<span class="price">&yen;198.00</span>--}}
                                <span class="persons pull-right">{{ $data->play_count or 0 }}人在学</span>
                            </p>
                        </div>
                    </a></div>
                @endforeach
            </div>
        </div>
        {{$units->appends(['keyword'=>$keyword])->links()}}

    </div>
@endsection

