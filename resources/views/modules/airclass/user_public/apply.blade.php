<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>甲状腺私教课</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- 引入 WeUI -->
    <link href="{{asset('airclass/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('airclass/css/weui.min.css') }}">
</head>
<body ontouchstart>
<div id="container"><div class="register">
        <form id="registerForm">

            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">用户名</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" id="name" name="name" placeholder="请输入用户名"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="tel" id="phone" name="phone" placeholder="请输入手机号"/>
                    </div>
                </div>
                <div class="weui-cell weui-cell_vcode">
                    <div class="weui-cell__hd">
                        <label class="weui-label">验证码</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="tel" id="code" name="code" placeholder="请输入验证码"/>
                    </div>
                    <div class="weui-cell__ft">
                        <button class="weui-btn weui-btn_plain-primary" id="btnDetCodeOfRegister">获取验证码</button>
                    </div>
                </div>

               {{-- <div class="weui-cells__title">选择所在地区</div>
                <div class="weui-cell weui-cell_select weui-cell_select-after">
                    <div class="weui-cell__hd" id="city-select" style="width: 100%;">
                        <select class="weui-select" name="province">
                            <option value="" >-选择省/市-</option>
                        </select>

                        <select class="weui-select" name="city">
                            <option value="" selected="selected">-选择市-</option>
                        </select>
                        <select class="weui-select" name="area">
                            <option value="" selected="selected">-选择区-</option>
                        </select>
                        <!--省市区-->
                        <input id="save-province" type="hidden"  name="save-province">
                        <input id="save-city" type="hidden" name="save-city">
                        <input id="save-area" type="hidden" name="save-area">
                    </div>
                </div>--}}


                <div class="weui-cell">
                    <div class="weui-cell__hd"><label for="" class="weui-label">医院</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" id="hospital" name="hospital_name" placeholder="请输入医院名称"/>
                        {{--<ul class="dropdown-menu" aria-labelledby="hospital">
                            <li><a href="javascript:;">请先填完地区</a></li>
                        </ul>--}}
                    </div>
                </div>
                <div class="weui-cell">

                    <div class="weui-cell__hd">
                        <label for="" class="weui-label">科室</label>
                    </div>
                    {{--<div class="weui-cell__bd">
                        <select class="weui-select" id="office" name="office">
                            <option value="">请选择科室</option>
                            @foreach($offices as $ol)
                                <option value="{{$ol->office_name}}">{{$ol->office_name}}</option>
                            @endforeach
                        </select>
                    </div>--}}
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" id="office" name="office" placeholder="请输入科室名称"/>
                    </div>

                </div>
                <div class="weui-cell weui-cell_select weui-cell_select-after">

                    <div class="weui-cell__hd">
                        <label for="" class="weui-label">职称</label>
                    </div>
                    <div class="weui-cell__bd">
                        <select class="weui-select" id="title" name="title">
                            <option value="">请选择职称</option>
                            @foreach(config('params')['doctor_title'] as $ol)
                                <option value="{{$ol}}">{{$ol}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">邮箱</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="email" id="email" name="email" placeholder="请输入邮箱"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"></label></div>
                    <div class="weui-cell__bd" style="font-size:14px;color:#999">
                        *病历模板将发送至此邮箱</div>
                </div>

                <div class="weui-footer weui-footer_fixed-bottom">
                    <span type="submit" class="weui-btn weui-btn_primary" id="btnSignup" style="cursor: pointer;">点击提交</span></div>
            </div>
        </form></div></div>
</body>


<div class="js_dialog" id="iosDialog" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__bd" id="dialog_msg"></div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
        </div>
    </div>
</div>
<div id="mask" style="width: 100%;height: 100%;position: absolute;left: 0;top: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.5);z-index: 3;display: none;"></div>
<div id="loadingToast" style="display:none;z-index: 10;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-loading weui-icon_toast"></i>
        <p class="weui-toast__content">数据提交中...</p>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('airclass/js/jquery-1.11.1.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('airclass/js/bootstrap.min.js')}}"></script>
<script src="{{asset('airclass/js/jquery.common.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('airclass/plugin/area-select/jquery.area.js')}}"></script>
<script type="text/javascript" src="{{asset('airclass/js/jquery.get_hospital.js')}}"></script>--}}

<div id="page" style="position: absolute;width: 100%;height: 100%;left: 0;right: 0;top: 0;bottom: 0;background-color:#ffffff;z-index: 100;display: none;">
    <div class="weui-msg" style="margin-top: 50%;">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">恭喜您，报名成功！</h2>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {

        var code_url = "{{url('sms/code')}}";
        var register_url = "{{url('/apply')}}";
        var phone_dom = $('#phone');
        var code_dom = $('#code');
        var name_dom = $('#name');
        var hospital_dom = $('#hospital');
        //var hospital_level_dom = $('#hospital_level');
        var office_dom = $('#office');
        var title_dom = $('#title');
        var email_dom = $('#email');

        /*$('#city-select').citys({
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
        });*/

        // 点击获取验证码
        $('#btnDetCodeOfRegister').click(function(e) {
            e.preventDefault();
            //$(this).parent().parent().next().hide();
            var phone_val = phone_dom.val();
            var button_code = $(this);
            if(!phone_val){
                showdialog('请输入手机号');
                return false;
            }
            if (checkPhone(phone_val)) {
                // ajax获取验证码
                var data = {
                    'phone': phone_val,
                    'exist': '-2',
                    'title':'私教课'
                };
                //设置定时器
                $.ajax({
                    type: 'post',
                    url: code_url,
                    data: data,
                    success: function(res){
                        if(res.code != 200){
                            showdialog(res.msg);
                        }else{
                            time($('#btnDetCodeOfRegister'),60);
                        }
                    },
                    error:function (res) {
                        showdialog('短信发送失败');
                    }
                });

            } else {
                showdialog('手机号格式错误');
            }
        });


        // 点击注册按钮
        $('#btnSignup').on('click',function() {
            //$('.tips').hide();
            if(vali_req(name_dom,'请输入姓名') && vali_req(phone_dom,'请输入手机号') && vali_req(code_dom,'请输入验证码') && vali_req(hospital_dom,'请输入医院名称') && vali_req(office_dom,'请输入科室名称') && vali_req(title_dom,'请选择职称') && vali_req(email_dom,'请输入邮箱')){
                if (!checkPhone(phone_dom.val())) {
                    showdialog('请输入正确的手机号');
                    return false;
                }
                if (!checkEmail(email_dom.val())) {
                    showdialog('请输入正确的邮箱');
                    return false;
                }
                // ajax请求
                var data = $('#registerForm').serialize();
                console.log(data);
                $.ajax({
                    type: 'post',
                    url: register_url,
                    data: data,
                    beforeSend: function(){
                        $('#mask').fadeIn(10);
                        $('#loadingToast').fadeIn(10);
                    },
                    success: function(res){
                        $('#loadingToast').fadeOut(10);
                        $('#mask').fadeOut(10);
                        if(res.code == 200){
                            location.href = "{{ url('/apply_success') }}"+'?phone='+phone_dom.val();

                            /*$('#page').fadeIn(10);
                            setTimeout(function(){
                                location.href = "{{ url('/apply_success') }}"+'?phone='+phone_dom.val();
                            },2000)*/
                        }else{
                            showAlertModal(res.msg);
                            return false;
                        }
                    },error:function () {
                        $('#loadingToast').fadeOut(10);
                        $('#mask').fadeOut(10);
                        showAlertModal('注册失败');
                        return false;
                    }
                });
            }else{
                showAlertModal('');
                return false;
            }
        });

        function showdialog(msg){
            $('#dialog_msg').text(msg);
            $('#iosDialog').fadeIn(10);
        }

        function vali_req(dom,title) {
            if(dom.val() == ''){
                showdialog(title);
                return false;
            }else{
                return true;
            }
        }

        $('#iosDialog').on('click', '.weui-dialog__btn', function(){
            $(this).parents('.js_dialog').fadeOut(10);
        });
    })
</script>
</html>
