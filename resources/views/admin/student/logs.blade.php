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
                        <div class="panel-heading">{{$playLog->course->sequence.$playLog->course->title}}</div>
                        <div class="panel-body">
                            @foreach($playLog->details as $key => $value)
                                <div class="form-group">
                                    <label for="entered_at" class="col-md-4 control-label">观看时间：{{$key}}</label>

                                    <div class="col-md-6">
                                        <input type="text" name="excel" class="form-control" value='"观看时长：{{gmstrftime('%H小时%M分%秒',$value)}}'
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
            </div>
        @endforeach
    </div>
@endsection
