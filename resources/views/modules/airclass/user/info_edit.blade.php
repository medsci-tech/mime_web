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
                        <input type="text" class="form-control" id="userName" name="name" placeholder="请输入姓名">
                    </div>
                    <div class="tips col-sm-4">请填写姓名</div>
                </div>
                <div class="form-group">
                    <label for="userPhone" class="col-sm-2 control-label"><span class="necessary">＊</span>手机号</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="userPhone" name="userPhone" placeholder="请输入手机号" value="{{ Session::get('user_login_session_key')['phone'] }}" readonly>
                    </div>
                    <div class="tips col-sm-4">请输入正确手机号</div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span class="necessary">＊</span>地区</label>
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
                    <label for="userHospital" class="col-sm-2 control-label"><span class="necessary">＊</span>医院名称</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="userHospital" name="hospital_name" placeholder="请输入医院名称">
                    </div>
                    <div class="tips col-sm-4">请填写医院名称</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>医院等级</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="hospitalLevel">
                            <option value="" selected="selected" hidden="hidden">请选择医院等级</option>
                            @foreach(config('params')['hospital_level'] as $ol)
                                <option value="{{$ol}}">{{$ol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tips col-sm-4">请选择医院级别</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>科室</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="office_id" id="office_id">
                            <option value="" selected="selected" hidden="hidden">请选择科室</option>
                            @foreach($offices as $office)
                                <option value="{{$office->office_id}}">{{$office->office_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tips col-sm-4">请选择科室</div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="necessary">＊</span>职称</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="doctorTitle">
                            <option value="" selected="selected" hidden="hidden">请选择职称</option>
                            @foreach(config('params')['doctor_title'] as $k => $v)
                                <option value="{{$k}}">{{$v}}</option>
                            @endforeach
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
<script type="text/javascript" src="{{asset('airclass/plugin/area-select/jquery.area.js')}}"></script>
<script>
    $(function () {
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
            if ($('select[name="province"]').val() === '' || $('select[name="city"]').val() === '') {
                showTips($('select[name="province"]'));
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
            if ($('select[name="office_id"]').val() === '') {
                showTips($('select[name="office_id"]'));
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
            // ajax请求
            var data = {
                'hospital_name': $('#userHospital').val(),
                'name': $('#userName').val(),
                'province': $('select[name="province"]').val(),
                'city': $('select[name="city"]').val(),
                'area': $('select[name="area"]').val(),
                'hospital_level': $('select[name="hospitalLevel"]').val(), //等级
                'office': $('select[name="office_id"]').val(), //科室
                'title': $('select[name="doctorTitle"]').val(), //职称
                'email': $('#email').val(),
            };
            $.ajax({
                type: 'post',
                url: '/user/save_info',
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