@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_user_info.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">修改密码</h3>

            <form class="user_info step_one form-horizontal" role="form" id="pwdForm">
                <div class="form-group">
                    <label for="userPhone" class="col-sm-2 control-label"><span class="necessary">＊</span>手机号</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="userPhone" name="userPhone" placeholder="请输入手机号" value="15927086090">
                    </div>
                    <div class="tips col-sm-4">请输入正确手机号</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>验证码</label>
                    <div class="col-sm-5">
                        <div class="row group_code">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCode" placeholder="请输入验证码">
                            </div>
                            <button type="button" class="btn col-sm-4" id="btnGetCode">获取验证码</button>
                        </div>
                    </div>
                    <div class="tips col-sm-4">验证码错误</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-2 btn_next_wrapper">
                        <button type="button" id="btnNext" class="btn btn-block">下一步</button>
                    </div>
                </div>
            </form>

            <form class="user_info step_two form-horizontal " role="form">
                <div class="form-group">
                    <label for="pwdOld" class="col-sm-2 control-label"><span class="necessary">＊</span>新密码</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="pwdOld" name="pwd" placeholder="请输入新密码">
                    </div>
                    <div class="tips col-sm-4">请输入新密码</div>
                </div>
                <div class="form-group">
                    <label for="pwdNew" class="col-sm-2 control-label"><span class="necessary">＊</span>确认密码</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="pwdNew" name="pwd2" placeholder="请输入确认密码">
                    </div>
                    <div class="tips col-sm-4">请输入确认密码</div>
                    <div class="tips col-sm-4" id="tipCon">两次输入的密码不一致</div>

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-2 btn_confirm_wrapper">
                        <button type="button" id="btnConfirm" class="btn btn-block">提交</button>
                    </div>
                </div>
            </form>
        </div>

@endsection
<script src="/vendor/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" href="/vendor/sweetalert/sweetalert.css">
@section('js_child')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var code_url = '{{url('user/send')}}';
        $(function () {
            $('#btnGetCode').click(function() {
                $('.tips').hide();
                var phone = $('#userPhone').val();
                if (!checkPhone(phone)) {
                    showTips($('#userPhone'));
                    return;
                }
                // ajax获取验证码
                var data = {
                    'phone': phone,
                    'exist': '-1'
                };
                subSmsAjax(code_url,data, phone);
            });

            $('#btnNext').click(function() {
                $('.tips').hide();
                if (!checkPhone($('#userPhone').val())) {
                    showTips($('#userPhone'));
                    return;
                }
                if ($('#inputCode').val() === '') {
                    showTips($('#inputCode'));
                    return;
                }
                // ajax请求

                // success 后跳转到下一步
                $('.step_one').hide();
                $('.step_two').show();
            });

            $('#btnConfirm').click(function() {
                $('.tips').hide();
                $('#tipCon').hide();
                if ($('#pwdOld').val() === '') {
                    showTips($('#pwdOld'));
                    return;
                }
                if ($('#pwdNew').val() === '') {
                    showTips($('#pwdNew'));
                    return;
                }
                if ($('#pwdNew').val() != $('#pwdOld').val()) {
                    $('#tipCon').show();
                    return;
                }
                // ajax请求
                var data = {
                    'phone': $('#userPhone').val(),
                    'password': $('#pwdOld').val(),
                    'password_confirmation': $('#pwdNew').val(),
                    'code': $('#inputCode').val(),
                };
                $.ajax({
                    type: 'post',
                    url: '/user/pwd_reset',
                    data: data,
                    success: function(res){
                        if(res.code != 200){
                            sweetAlert("修改失败!", res.msg, "error");
                        }
                        else
                            sweetAlert("修改成功!")
                    },
                    error:function (res) {
                        sweetAlert("Hello world!")
                    }
                });


            });
        });
    </script>
@endsection