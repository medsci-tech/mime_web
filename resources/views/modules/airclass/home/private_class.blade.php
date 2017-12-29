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
            <div class="form-group col-xs-7">
                <button id="sign_btn" class="btn btn-primary form-control" disabled>我要报名</button>
            </div>
            <div class="form-group col-xs-5">
                <a href="{{url('private_class/default')}}" class="btn btn-default form-control">下载病例模板</a>
            </div>

            <div class="checkbox" style="padding: 0 15px;position: static">
                <label>
                    <input type="checkbox" checked id="agreement">
                    <span class="checkbox_img"></span>
                </label>
                <a href="javascript:;" target="_blank">同意用户协议</a>
            </div>
            <p class="numbers clearfix">
                <span>报名人数：{{$sign_count}}</span><br>
                <span>剩余名额：{{$count - $sign_count}}</span>
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

@endsection

@section('js')
    <script type="text/javascript">
        $(function () {
            var sign_check_status = '{{$sign_check['status']}}';
            var sign_check_msg = '{{$sign_check['msg']}}';
            //报名跳转
            $('#sign_btn').click(function(){
                if(sign_check_status){
                    window.location.href = '{{url('private_class/index')}}';
                }else {
                    $('#levelModal').modal('show').find('.tips').text(sign_check_msg);
                }
            });
            $('#agreement').change(function () {
                var check = $(this)[0].checked;
                var sign_btn = $('#sign_btn');
                if(check){
                    sign_btn.attr('disabled',false);
                }else {
                    sign_btn.attr('disabled',true);
                }
            });
        });
    </script>
@endsection