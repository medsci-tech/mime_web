

/**
 *
 * @param email
 * @returns {boolean}
 */
var checkEmail = function(email) {
    var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    return reg.test(email);
};
/**
 *
 * @param phone
 * @returns {boolean}
 */
var checkPhone = function(phone) {
    if(phone.length == 11 || /^1[345789]\d{9}$/.test(phone)) {
        return true;
    }
    return false;
};
var checkPwd = function(password) {
    if(/^[\w\.-]{6,22}$/.test(password)) {
        return true;
    }
    return false;
};

var showTips = function(dom) {
    $(dom).parents('.form-group').find('.tips').show();
    $(dom).focus();
};

var validate_required = function(dom) {
    if (dom.val() == '') {
        showTips(dom);
        return false;
    }else {
        return true;
    }
};

/**
 *
 * @param dom
 * @param msg
 */
var validateTips = function(dom, msg) {
    dom.parents('.form-group').find('.tips').text(msg);
    dom.parents('.form-group').find('.tips').show();
    dom.focus();
};


var showAlertModal = function(msg) {
    $('#alertModal').find('.modal-content').text(msg);
    $('#alertModal').modal('show');
    setTimeout(function() {
        $('#alertModal').modal('hide');
    }, 1500);
};
var showAlertModal2 = function(msg,time) {
    $('#alertModal').find('.modal-content').text(msg);
    $('#alertModal').modal('show');
    if(time){
        setTimeout(function() {
            $('#alertModal').modal('hide');
        }, time);
    }
};

/**
 * 短信ajax提交
 * @param action
 * @param data
 * @param tipDom
 */
var subSmsAjax = function (action, data, tipDom) {
    $.ajax({
        type: 'post',
        url: action,
        data: data,
        success: function(res){
            if(res.code != 200){
                validateTips(tipDom, res.msg);
            }
        },
        error:function (res) {
            validateTips(tipDom, 'error');
        }
    });
};

var subActionAjax = function (action, data, tipDom) {
    $.ajax({
        type: 'post',
        url: action,
        data: data,
        success: function(res){
            if(res.code == 200){
                $('#successModal').modal('show');
            }else if(res.code == 444) {
                for(var i in res.msg){
                    validateTips($('#' + i), res.msg[i][0]);
                }
            }else if(res.code == 422) {
                for(var i in res.msg){
                    validateTips($('#' + i), res.msg[i]);
                }
            }else {
                showAlertModal(res.msg);
            }
        },error:function () {
            showAlertModal('注册失败');
        }
    });
};


var subMsgAjax2 = function (action, data) {
    $.ajax({
        type: 'post',
        url: action,
        data: data,
        success: function(res){
            if(res.code == 200){
                showAlertModal(res.msg);
            }else if(res.code == 444) {
                showAlertModal(res.msg['phone'][0]);
            }else {
                showAlertModal(res.msg);
            }
        },
        error:function (res) {
            showAlertModal('服务器错误');
        }
    });
};

var subLoginAjax = function (action, data) {
    $.ajax({
        type: 'post',
        url: action,
        data: data,
        success: function(res){
            if(res.code == 200){
                window.location.reload();
            }else if(res.code == 444) {
                showAlertModal(res.msg['phone'][0]);
            }else {
                showAlertModal(res.msg);
            }
        },
        error:function (res) {
            showAlertModal('服务器错误');
        }
    });
};

var subMsgAjax3 = function (action, data) {
    $.ajax({
        type: 'post',
        url: action,
        data: data,
        success: function(res){
            if(res.code == 200){
                showAlertModal(res.msg);
                setTimeout(function() {
                    $('.login_modal').modal('hide');
                    $('#loginModal').modal('show');
                }, 1500);
            }else if(res.code == 444) {
                showAlertModal(res.msg['phone'][0]);
            }else {
                showAlertModal(res.msg);
            }
        },
        error:function (res) {
            showAlertModal('服务器错误');
        }
    });
};

// 加积分提示
var tipsBeansModal = function (msg) {
    var dom = $('#successModal');
    dom.find('.tips').text(msg);
    dom.modal('show');
    setTimeout(function() {
        dom.modal('hide');
    }, 1500);
};

var subQuestionAjax = function (action, data) {
    $.ajax({
        type: 'post',
        url: action,
        data: data,
        success: function(res){
            if(res.code == 200){
                $('#questionsModal').modal('hide');
            }else if(res.code == 555) {
                $('#questionsModal').modal('hide');
            }
            showAlertModal(res.msg);
        },
        error:function (res) {
            showAlertModal('服务器错误');
        },
        complete:function () {
            window.location.reload();
        }
    });
};

/**
 * 视频心跳请求
 * @param player
 * @param time
 * @param action
 * @param data
 */
var video_heartbeat = function (player, time, action, data) {
    var heartbeat_times = 1; // 心跳次数，可根据心跳次数计算观看时长
    setInterval(function () {
        var total_time = player.getDuration(); // 视频总时长
        var progress = player.getCurrentTime(); // 视频进度
        var play_status = player.isPlaying();
        // 播放的时候才进行心跳统计
        if(play_status == true){
            data.progress = progress;
            data.times = heartbeat_times;
            data.video_duration = total_time;
            video_heartbeat_ajax(action, data);
            heartbeat_times++;
        }
    }, time);
};
var video_heartbeat_ajax = function (action, data) {
    $.ajax({
        type: 'post',
        url: action,
        data: data
    });
};

/**
 * functions
 */
$(function () {
    // ajax 添加csrf
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal').on('show.bs.modal', function (e) {
        $('#id_video_container').attr('hidden','true');
        console.log('show');
    });

    $('.modal').on('hide.bs.modal', function (e) {
        $('#id_video_container').removeAttr('hidden');
        console.log('hide');
    });
});