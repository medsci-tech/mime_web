@extends('modules.airclass.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/lessons_private.css')}}" />
@endsection
@section('container')
     <!-- header -->
    <header class="header text-center">
        私教课
    </header>
    <!-- main body -->
    <div class="main_body">
        <div class="introduction">
            <h3 class="title">私教课课程介绍</h3>
            <p>{{ $class_info->description }}</p>
            <p>
                培训项目组织机构<br />
                主办单位：全科医学协作平台<br />
                支持单位：蓝海联盟（北京）医学研究院、诺和诺德（中国）制药有限公司等
            </p>
        </div>
        <div class="steps">
            <h3 class="title">流程介绍</h3>
            <img class="center-block" src="{{asset('airclass/img/private_lessons_steps.png')}}"/>
        </div>
        <div class="apply">
            <button id="btnApply" type="button" class="btn btn-block btn_apply">我要报名</button>
            <p class="numbers clearfix">
                <span class="pull-left">报名人数：{{ $sign_count }}</span>
                <span class="pull-right">剩余名额：{{ $count - $sign_count }}</span>
            </p>
        </div>
    </div>

    <!-- Modal -->
    <!-- level below 3 modal -->
    <div class="level_modal modal fade" id="levelModal" tabindex="-1" role="dialog" aria-labelledby="levelModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="tips_container text-center"><span class="icon icon_warn"></span><span class="tips">达到第三等级方可报名</span></div>
            </div>
        </div>
    </div>


    <!-- choose teacher modal -->
    <div class="choose_teacher_modal modal fade" id="chooseTeacherModal" tabindex="-1" role="dialog" aria-labelledby="chooseTeacherModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="title text-center">上传病例</h3>
                <form method="post" enctype="multipart/form-data" action="/file/upload">
                    <input type="file" name="file">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-block btn_submit">提交</button>
                </form>
            </div>
        </div>
    </div>

    <!-- success modal -->
    <div class="success_modal modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="tips_container text-center"><span class="icon icon_success"></span><span class="tips">申请成功，我们将会在两个工作日内与您进行联系，并安排课程</span></div>
                <button type="button" class="btn btn-block btn_index">返回私教课首页</button>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(function() {
            $('#btnApply').click(function() {
//					$('#levelModal').modal('show');
                $('#chooseTeacherModal').modal('show');
            });

            $('#chooseTeacherModal .teacher').click(function() {
                $('#chooseTeacherModal .teacher').removeClass('active');
                $(this).addClass('active');
            });

            $('#chooseTeacherModal .btn_submit').clickx(function() {
                $('#chooseTeacherModal').modal('hide');
                $('#successModal').modal('show');
            });
        })
    </script>
@endsection