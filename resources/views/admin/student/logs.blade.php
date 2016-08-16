@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">学生信息</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">报名时间</label>

                            <div class="col-md-6">
                                <input type="text" name="excel" class="form-control" value="{{$student->entered_at}}"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">姓名-电话</label>

                            <div class="col-md-6">
                                <input type="text" name="excel" class="form-control"
                                       value="{{$student->name}}-{{$student->phone}}"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">医院 - 科室 - 职称</label>

                            <div class="col-md-6">
                                <input type="text" name="excel" class="form-control"
                                       value="{{$student->hospital_name}}-{{$student->office}}-{{$student->title}}"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">地区</label>

                            <div class="col-md-6">
                                <input type="text" name="excel" class="form-control"
                                       value="{{$student->province}}-{{$student->city}}-{{$student->area}}"
                                       readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($playLogs as $playLog)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{$playLog->course->title}}</div>
                        <div class="panel-body">
                            @foreach($playLog->details as $key => $value)
                                <div class="form-group">
                                    <label for="entered_at" class="col-md-4 control-label">观看时间：{{$key}}</label>

                                    <div class="col-md-6">
                                        <input type="text" name="excel" class="form-control" value="观看时长：{{$value}}"
                                               readonly>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <a class="btn btn-link" href="">观看次数：{{$playLog->play_times}}</a>
                                    <a class="btn btn-link" href="">观看时长：{{$playLog->play_duration}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">查询</div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST"
                                      action="{{ url('/admin/student-logs') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="phone" class="col-md-4 control-label">phone</label>

                                        <div class="col-md-6">
                                            <input id="email" type="text" class="form-control" name="phone"
                                                   value="{{ old('phone') }}">

                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{--<div class="form-group{{ $errors->has('course_id') ? ' has-error' : '' }}">--}}
                                    {{--<label for="course_id" class="col-md-4 control-label">Password</label>--}}

                                    {{--<div class="col-md-6">--}}
                                    {{--<input id="course_id" type="text" class="form-control" name="course_id">--}}

                                    {{--@if ($errors->has('course_id'))--}}
                                    {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('course_id') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-sign-in"></i> Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
@endsection
