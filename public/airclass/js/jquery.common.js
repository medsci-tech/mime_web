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
});

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
    if(phone.length === 11 || /^1[345789]\d{9}$/.test(phone)) {
        return true;
    }
    return false;
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
            }
        }
    });
};
