@extends('layouts.app')

@section('content')
    <div class="container">
        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Student</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<form class="form-horizontal" role="form" method="POST"--}}
                              {{--action="{{ url('/admin/excel/student') }}"--}}
                              {{--enctype="multipart/form-data">--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="email" class="col-md-4 control-label">Excel</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input type="file" name="excel" class="form-control" required>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<button type="submit" class="btn btn-primary">--}}
                                        {{--<i class="fa fa-btn fa-sign-in"></i> Submit--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Play Log</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<form class="form-horizontal" role="form" method="POST"--}}
                              {{--action="{{ url('/admin/excel/play-log') }}"--}}
                              {{--enctype="multipart/form-data">--}}
                            {{--{{ csrf_field() }}--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="email" class="col-md-4 control-label">Excel</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input type="file" name="excel" class="form-control" required>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<button type="submit" class="btn btn-primary">--}}
                                        {{--<i class="fa fa-btn fa-sign-in"></i> Submit--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Play Log Detail</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<form class="form-horizontal" role="form" method="POST"--}}
                              {{--action="{{ url('/admin/excel/play-log-detail') }}"--}}
                              {{--enctype="multipart/form-data">--}}
                            {{--{{ csrf_field() }}--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="email" class="col-md-4 control-label">Excel</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input type="file" name="excel" class="form-control" required>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<button type="submit" class="btn btn-primary">--}}
                                        {{--<i class="fa fa-btn fa-sign-in"></i> Submit--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">查询</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="get" action="{{ url('/admin/student-logs') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="phone" class="col-md-4 control-label">phone</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="phone" value="{{ old('phone') }}">

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
