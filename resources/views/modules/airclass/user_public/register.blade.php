@extends('modules.airclass.layouts.app')

    @section('container')

        <!-- header -->
        <header class="header text-center">
            注册账号
        </header>

        <!-- main body -->
        <div class="main_body singn_main_body">
            <form class="form-horizontal" role="form" id="signUpForm">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>手机号</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputPhone" name="phone" placeholder="请输入手机号">
                    </div>
                    <p class="col-sm-2 tips"></p>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>验证码</label>
                    <div class="col-sm-7">
                        <div class="row group_code">
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="inputCode" name="code" placeholder="请输入验证码">
                            </div>
                            <button type="button" class="btn col-sm-3 btnGetCode">获取验证码</button>
                        </div>
                    </div>
                    <p class="col-sm-2 tips">请输入验证码</p>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>设置密码</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputPwd" name="password" placeholder="设置密码">
                    </div>
                    <p class="col-sm-2 tips">请输入密码</p>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>确认密码</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputPwdConfirm" name="re_password"  placeholder="确认密码">
                    </div>
                    <p class="col-sm-2 tips">密码不一致</p>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>地区</label>
                    <div class="col-sm-7">
                        <div class="row" id="city-select">
                            <div class="col-sm-4">
                                <select class="form-control" name="province">
                                    <option value="" selected="selected">-选择省-</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="city">
                                    <option value="" selected="selected">-选择市-</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="area">
                                    <option value="" selected="selected">-选择区-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tips col-sm-2">请选择省市区</div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>医院</label>
                    <div class="col-sm-7">
                        <div class="dropup">
                            <input type="text" data-toggle="dropdown" class="form-control" id="hospital" name="hospital_name" placeholder="请输入医院">
                            <ul class="dropdown-menu" aria-labelledby="hospital">
                                <li>请先填完地区</li>
                            </ul>
                        </div>
                    </div>
                    <p class="col-sm-2 tips"></p>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>科室</label>
                    <div class="col-sm-7">
                        <select class="form-control" id="office" name="office">
                            <option value="0">请选择等级</option>
                            @foreach(config('params')['doctor_office'] as $ol)
                                <option value="{{$ol}}">{{$ol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="col-sm-2 tips">请输入科室</p>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><span class="necessary">＊</span>职称</label>
                    <div class="col-sm-7">
                        <select class="form-control" id="title" name="title">
                            <option value="0">请选择等级</option>
                            @foreach(config('params')['doctor_title'] as $ol)
                                <option value="{{$ol}}">{{$ol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="col-sm-2 tips">请输入职称</p>
                </div>
                <div class="form-group checkbox_group">
                    <div class="col-sm-offset-3 col-sm-7">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked>
                                <span class="checkbox_img"></span>
                            </label>
                            <a href="#" target="_blank">同意用户协议</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-7">
                        <button type="button" id="btnSignup" class="btn btn-block">注册</button>
                    </div>
                </div>
                <p class="tips_login text-right col-sm-10">已有账号？ <a class="btn_login" href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">马上登录</a></p>
                <!--省市区-->
                <input id="save-province" type="hidden"  name="save-province">
                <input id="save-city" type="hidden" name="save-city">
                <input id="save-area" type="hidden" name="save-area">
            </form>
        </div>

    <!-- login success modal -->
    <div class="success_modal modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="tips_container text-center"><span class="icon icon_success"></span><span class="tips">注册成功</span></div>
                <button type="button" class="btn btn-block btn_index">确定</button>
            </div>
        </div>
    </div>

    @endsection

@section('js')
    <script type="text/javascript" src="{{asset('airclass/plugin/area-select/jquery.area.js')}}"></script>
    <script type="text/javascript" src="{{asset('airclass/js/jquery.get_hospital.js')}}"></script>
    <script type="text/javascript">
    $(function () {
        var code_url = '{{url('sms/code')}}';
        var register_url = '{{url('register/post')}}';

        $('#city-select').citys({
            required:false,
            nodata:'',
            onChange:function(data){
                var lists = {};
                if(data['direct']){
                    lists.province = data.province;
                    lists.city = data.province;
                    lists.area = data.city;
                }else {
                    lists.province = data.province;
                    lists.city = data.city;
                    lists.area = data.area;
                }
                $('#save-province').val(lists.province);
                $('#save-city').val(lists.city);
                $('#save-area').val(lists.area);
                get_hospital(lists);
            }
        });
        // 注册表单
        // 点击获取验证码
        $('#signUpForm .btnGetCode').click(function() {
            $('#signUpForm .tips').hide();
            var phone = $('#signUpForm #inputPhone');
            var phone_val = phone.val();
            if (checkPhone(phone_val)) {
                // ajax获取验证码
                var data = {
                    'phone': phone_val,
                    'exist': '-1'
                };
                subSmsAjax(code_url,data, phone);
            } else {
                validateTips(phone, '手机号格式不正确');
            }
        });
        // 点击注册按钮
        $('#signUpForm #btnSignup').click(function() {
            $('#signUpForm .tips').hide();
            if (!checkPhone($('#signUpForm #inputPhone').val())) {
                showTips($('#signUpForm #inputPhone'));
                return;
            }
            if ($('#signUpForm #inputCode').val() == '') {
//						alert('请输入验证码');
                showTips($('#signUpForm #inputCode'));
                return;
            }
            if ($('#signUpForm #inputPwd').val() == '') {
//						alert('请输入密码');
                showTips($('#signUpForm #inputPwd'));
                return;
            }
            if ($('#signUpForm #inputPwd').val() !== $('#signUpForm #inputPwdConfirm').val()) {
//						alert('请确认两次输入密码一致');
                showTips($('#signUpForm #inputPwdConfirm'));
                return;
            }
            // ajax请求
            var data = $('#signUpForm').serialize();
            console.log(data);
            subActionAjax(register_url,data);
        });
    })
    </script>
    @endsection