@extends('modules.airclass.layouts.app')

    @section('container')

        <!-- header -->
        <header class="header text-center">
            注册账号
        </header>

        <!-- main body -->
        <div class="main_body">
            <form class="form-horizontal" role="form" id="signUpForm">
                <div class="form-group">
                    <label for="inputPhone" class="col-sm-4 control-label"><span class="necessary">＊</span>手机号</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputPhone" placeholder="请输入手机号">
                    </div>
                    <p class="col-sm-2 tips">手机号格式不正确</p>
                </div>
                <div class="form-group">
                    <label for="inputCode" class="col-sm-4 control-label"><span class="necessary">＊</span>验证码</label>
                    <div class="col-sm-6">
                        <div class="row group_code">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCode" placeholder="请输入验证码">
                            </div>
                            <button type="button" class="btn col-sm-4 btnGetCode">获取验证码</button>
                        </div>
                    </div>
                    <p class="col-sm-2 tips">请输入验证码</p>
                </div>
                <div class="form-group">
                    <label for="inputPwd" class="col-sm-4 control-label"><span class="necessary">＊</span>设置密码</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputPwd" placeholder="设置密码">
                    </div>
                    <p class="col-sm-2 tips">请输入密码</p>
                </div>
                <div class="form-group">
                    <label for="inputPwdConfirm" class="col-sm-4 control-label"><span class="necessary">＊</span>确认密码</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputPwdConfirm" placeholder="确认密码">
                    </div>
                    <p class="col-sm-2 tips">密码不一致</p>
                </div>
                <div class="form-group checkbox_group">
                    <div class="col-sm-offset-4 col-sm-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked>
                                <span class="checkbox_img"></span>
                            </label>
                            <a href="./agreement.html" target="_blank">同意用户协议</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="button" id="btnSignup" class="btn btn-block">注册</button>
                    </div>
                </div>
                <p class="tips_login text-right col-sm-10">已有账号？ <a class="btn_login" href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">马上登录</a></p>
            </form>
        </div>



    @endsection

@section('js')
    <script type="text/javascript">

    </script>
    @endsection