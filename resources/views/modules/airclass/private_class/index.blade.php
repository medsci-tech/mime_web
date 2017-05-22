@extends('modules.airclass.layouts.app')
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/lessons_private.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/lessons_private_step.css')}}" />
        @endsection
@section('container')

    <div class="main_body">
        <div class="row private_head">
            <div class="private_head_li col-xs-4 active">
                <div class="private_num">1</div>
                <div class="private_title">选择讲师</div>
            </div>
            <div class="private_head_li col-xs-4">
                <div class="private_num">2</div>
                <div class="private_title">上传病例</div>
            </div>
            <div class="private_head_li col-xs-4">
                <div class="private_num">3</div>
                <div class="private_title">申请确认</div>
            </div>
        </div>
        <div class="private_content">
            <form enctype="multipart/form-data">
                <div class="sign_step">
                    <div class="slide clearfix" id="slide">
                        <div class="prev"><img width="100%" src="{{asset('airclass/img/private_list_pre.png')}}"></div>
                        <div class="next"><img width="100%" src="{{asset('airclass/img/private_list_next.png')}}"></div>
                        <div class="content">
                            <ul class="teacher_list clearfix" id="teacher_list">
                                @foreach($teachers as $teacher)
                                <li data-teacher_id="{{$teacher->id}}">
                                    <div class="teacher_pic"><img width="100%" height="100%" src="{{$teacher->photo_url}}"></div>
                                    <h5>{{$teacher->name}}{{$teacher->教授}}</h5>
                                    <p>{!! $teacher->introduction !!}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="btn-list">
                        <a href="{{url('private_class')}}" class="btn btn-default">取消申请</a>
                        <a href="javascript:sign_step_show(2, true);" class="btn btn-primary" disabled id="step_to2">下一步</a>
                    </div>
                </div>
                <div class="sign_step">
                    <div class="upload_file">
                        <div class="row">
                            <label class="col-xs-4 text-right">上传病例</label>
                            <input class="col-xs-6 text-left file-input" id="file-input" type="button" value="未选择文件">
                            <input class="hidden" type="file" name="file"><!--文件上传-->
                        </div>
                        <div class="row">
                            <label class="col-xs-4 text-right">预约时间</label>
                            <input class="col-xs-6 date-input" type="text" name="date" id="date_input" readOnly="readOnly" placeholder="年／月／日"><!--预约时间-->
                        </div>

                        <div class="row">
                            <p>
                                我们会尽量协调您的预约时间，若有调整，会提前与您联系！
                            </p>
                        </div>
                    </div>
                    <div class="btn-list">
                        <a href="{{url('private_class')}}" class="btn btn-default">取消申请</a>
                        <a href="javascript:sign_step_show(1, false);" class="btn btn-default">上一步</a>
                        <a href="javascript:sign_step_show(3, true);" class="btn btn-primary" disabled id="step_to3">下一步</a>
                    </div>
                </div>
                <div class="sign_step">
                    <div class="upload_file">
                        <div class="row">
                            <label class="col-xs-5 text-right">选择讲师</label>
                            <label class="col-xs-5 text-primary overflow" id="teacher_show">杨文英</label>
                            <input type="hidden" name="teacher"><!--选择讲师-->
                        </div>
                        <div class="row">
                            <label class="col-xs-5 text-right">病例上传</label>
                            <label class="col-xs-5 text-primary overflow" id="file_show">糖尿病的优化治疗.ppt</label>
                        </div>
                        <div class="row">
                            <label class="col-xs-5 text-right">预约时间</label>
                            <label class="col-xs-5 text-primary overflow" id="date_show">2017-11-23</label>
                        </div>
                        <div class="row">
                            <p>
                                * 请您确认申请信息，若有误可点击“上一步”进行修改
                            </p>
                        </div>
                    </div>
                    <div class="btn-list">
                        <a href="{{url('private_class')}}" class="btn btn-default">取消申请</a>
                        <a href="javascript:sign_step_show(2, false);" class="btn btn-default">上一步</a>
                        <a href="javascript:void(0);" class="btn btn-primary" id="private-submit">提交申请</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="level_modal modal fade" id="levelModal" tabindex="-1" role="dialog" aria-labelledby="levelModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="tips_container text-center"><span class="tips">达到第三等级方可报名</span></div>
            </div>
        </div>
    </div>

    <!-- success modal -->
    <div class="success_modal modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="tips_container text-center"><span class="icon icon_success"></span><span class="tips">申请成功，我们将会在两个工作日内与您进行联系，并安排课程</span></div>
                <a href="{{url('private_class')}}" class="btn btn-block btn_index">返回私教课首页</a>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('airclass/plugin/laydate/laydate.js')}}"></script>
    <script type="text/javascript">
        var teacher_list = $('#teacher_list');
        var slide = $('#slide');
        var teacher_li_width = 166;
        var input_teacher = $('input[name="teacher"]');
        var input_file = $('input[name="file"]');
        var input_date = $('input[name="date"]');
        var input_file_exist = 0;
        var private_head_li = $('.private_head_li');

        var get_list_left = function () {
            return parseInt(teacher_list.css('left').slice(0,-2));
        };

        var sign_step_show = function (step, check) {
            private_head_li.removeClass('active');
            for(var i = 0; i < step; i++){
                private_head_li.eq(i).addClass('active');
            }
            $('.sign_step').hide().eq(step-1).show();
        };

        $(function() {
            sign_step_show(1);
            var teacher_count = teacher_list.find('li').length;
            var teacher_width = teacher_li_width * teacher_count;
            var teacher_parent = teacher_list.parent('.content');
            teacher_list.width(teacher_width).css({left:0});
            teacher_list.find('li').on('click', function () {
                $(this).addClass('active').siblings().removeClass('active');
                // 选择讲师操作
                var teacher = $(this).find('h5').text();
                $('#teacher_show').html(teacher);
                input_teacher.val($(this).data('teacher_id'));
                $('#step_to2').attr('disabled',false);
            });
            slide.find('.prev').on('click', function () {
                var left = get_list_left();
                if(left < 0){
                    if(left < -teacher_li_width){
                        teacher_list.animate({left: '+='+teacher_li_width});
                    }else {
                        teacher_list.animate({left: 0});
                    }
                }
            });
            slide.find('.next').on('click', function () {
                var left = get_list_left();
                var slide_content_width = slide.find('.content').width();
                if(left > slide_content_width - teacher_width){
                    if(left > slide_content_width - teacher_width + teacher_li_width){
                        teacher_list.animate({left: '-='+teacher_li_width});
                    }else {
                        teacher_list.animate({left:slide_content_width-teacher_width});
                    }
                }
            });
            if(teacher_width < teacher_parent.width()){
                teacher_parent.width(teacher_width).css({float: 'none', margin: '0 auto'});
            }
            // 上传操作
            var input_file_btn = $('#file-input');
            input_file_btn.click(function () {
                input_file.click();
            });
            input_file.change(function() {
                var val = $(this).val();
                var val_last = val.split('\\').pop();
                if(val){
                    input_file_btn.val(val_last);
                    $('#file_show').html(val_last);
                    input_file_exist = 1;
                    if(input_date.val()){
                        $('#step_to3').attr('disabled', false);
                    }
                }else {
                    input_file_btn.val('未选择文件');
                    $('#file_show').html('未选择文件');
                    input_file_exist = 0;
                    $('#step_to3').attr('disabled', true);
                }
            });

            // 预约时间操作
            laydate({
                elem: '#date_input',
                format: 'YYYY/MM/DD', // 分隔符可以任意定义，该例子表示只显示年月
                min: laydate.now(+5),
                festival: true, //显示节日
                isclear: false,
                choose: function(datas){ //选择日期完毕的回调
                    console.log(datas);
                    if(datas){
                        $('#date_show').html(datas);
                        if(input_file_exist){
                            $('#step_to3').attr('disabled', false);
                        }
                    }else {
                        $('#step_to3').attr('disabled', true);
                    }
                }
            });

            // 提交操作
            $('#private-submit').click(function () {
                var formData = new FormData();
                formData.append('file', input_file[0].files[0]);
                formData.append('teacher_id', input_teacher.val());
                formData.append('bespoke_at', input_date.val());
                $.ajax({
                    url: '{{url('private_class/sign')}}',
                    type: 'post',
                    cache: false,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res){
                        if(res.code == 200){
                            $('#successModal').modal('show').find('.tips').text(res.msg);
                        }else {
                            $('#levelModal').modal('show').find('.tips').text(res.msg);
                        }
                    },
                    error:function (res) {
                        $('#levelModal').modal('show').find('.tips').text('私教课报名失败');
                    }
                });
            });

        });
    </script>
@endsection