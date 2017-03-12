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
            <p>为提高基层医师内分泌相关疾病的诊疗技能与合理用药水平；促进糖尿病的治疗和合理用药在基层和社区医院的普及；由内分泌代谢科专家结合基层常见的内分泌疾病诊疗误区和难点，设置的系列远程教育课程-“2017空中课堂内分泌代谢系列课程班”。课程内容涵盖内分泌常见疾病糖尿病、甲状腺疾病、肾上腺疾病、多发性内分泌腺肿瘤综合征等疾病规范诊疗与合理用药。</p>
            <p>
                培训项目组织机构<br />
                主办单位：全科医学协作平台<br />
                支持单位：蓝海联盟（北京）医学研究院、诺和诺德（中国）制药有限公司等
            </p>
            <p>2017年空课项目分为必修课，答疑课和私教课。其中必修课，邀请内分泌领域国家级主委、常委专家为学员授课，授课专家包括中日友好医院的杨文英教授，中国人民解放军第306医院的许樟荣教授 ，中国人民解放军总医院的窦京涛教授和吕朝晖教授。答疑课和私教课将邀请内分泌领域区域级主委、常委专家，轮流为学员答疑。</p>
        </div>
        <div class="steps">
            <h3 class="title">流程介绍</h3>
            <img class="center-block" src="{{asset('airclass/img/private_lessons_steps.png')}}"/>
        </div>
        <div class="apply">
            <button id="btnApply" type="button" class="btn btn-block btn_apply">我要报名</button>
            <p class="numbers clearfix">
                <span class="pull-left">报名人数：{{ $count }}</span>
                <span class="pull-right">剩余名额：{{ isset($all) ? $all : '60' }}</span>
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