@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_user_info.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">资料修改</h3>

            <form class="user_info form-horizontal" role="form">
                <div class="form-group">
                    <label for="userName" class="col-sm-2 control-label"><span class="necessary">＊</span>姓名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="userName" name="userName" placeholder="请输入姓名">
                    </div>
                    <div class="tips col-sm-4">请填写姓名</div>
                </div>
                <div class="form-group">
                    <label for="userPhone" class="col-sm-2 control-label"><span class="necessary">＊</span>手机号</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="userPhone" name="userPhone" placeholder="请输入手机号">
                    </div>
                    <div class="tips col-sm-4">请输入正确手机号</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>性别</label>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" name="locationProvince">
                                    <option value="" selected="selected" hidden="hidden">省</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="locationCity">
                                    <option value="" selected="selected" hidden="hidden">市</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="locationDistrict">
                                    <option value="" selected="selected" hidden="hidden">县／区</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tips col-sm-4">请选择省市区</div>
                </div>
                <div class="form-group">
                    <label for="userHospital" class="col-sm-2 control-label"><span class="necessary">＊</span>医院名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="userHospital" name="userHospital" placeholder="请输入医院名称">
                    </div>
                    <div class="tips col-sm-4">请填写医院名称</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>医院等级</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="hospitalLevel">
                            <option value="" selected="selected" hidden="hidden">请选择医院等级</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="tips col-sm-4">请选择医院级别</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>科室</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="department">
                            <option value="" selected="selected" hidden="hidden">请选择科室</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="tips col-sm-4">请选择科室</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>职称</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="doctorTitle">
                            <option value="" selected="selected" hidden="hidden">请选择职称</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="tips col-sm-4">请选择职称</div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label"><span class="necessary">＊</span>邮箱</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="email" name="email" placeholder="请输入邮箱">
                    </div>
                    <div class="tips col-sm-4">请输入邮箱</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-2 btn_confirm_wrapper">
                        <button type="button" id="btnConfirm" class="btn btn-block">确认修改</button>
                    </div>
                </div>
            </form>
        </div>

@endsection

@section('js')
<script>
    $(function () {
        $('#btnConfirm').click(function() {
            $('.tips').hide();
            if ($('#userName').val() === '') {
                showTips($('#userName'));
                return;
            }
            if (!checkPhone($('#userPhone').val())) {
                showTips($('#userPhone'));
                return;
            }
            if ($('select[name="locationProvince"]').val() === '' || $('select[name="locationCity"]').val() === '' || $('select[name="locationDistrict"]').val() === '') {
                showTips($('select[name="locationProvince"]'));
                return;
            }
            if ($('#userHospital').val() === '') {
                showTips($('#userHospital'));
                return;
            }
            if ($('select[name="hospitalLevel"]').val() === '') {
                showTips($('select[name="hospitalLevel"]'));
                return;
            }
            if ($('select[name="department"]').val() === '') {
                showTips($('select[name="department"]'));
                return;
            }
            if ($('select[name="doctorTitle"]').val() === '') {
                showTips($('select[name="doctorTitle"]'));
                return;
            }
            if (!checkEmail($('#email').val())) {
                showTips($('#email'));
                return;
            }
            // ajax
        });
    });
</script>
    @endsection