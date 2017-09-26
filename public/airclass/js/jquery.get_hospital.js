
var action= '/hospital/get_lists';
var get_hospital = function (data) {
    if(data.area){
        $.ajax({
            type: 'post',
            url: action,
            data: data,
            success: function(res){
                console.log(res.data);
                if(res.code == 200){
                    show_hospital_list(res.data);
                }
            }
        });
    }
};

var show_hospital_list = function (list) {
    var html = '';
    for(var i in list){
        if(list[i]['hospital']){
            html += '<li onclick="select_hospital('+'\''+list[i]['hospital']+'\',\''+list[i]['hospital_level']+'\''+')"><a href="javascript:;">'+list[i]['hospital']+'</a></li>'
        }
    }
    if(html == ''){
        html += '<li><a href="javascript:;">请手动添加</a></li>'
    }
    console.log(html);
    $('.dropdown-menu').html(html);
    clear_hospital();
};

var select_hospital = function (hospital, hospital_level) {
    $('#hospital').val(hospital);
    if (hospital_level!='null') {
        $('#hospital_level').val(hospital_level);
    }
    
};
var clear_hospital = function () {
    var n = '';
    $('#hospital').val(n);
    $('#hospital_level').val(n);
};

$(function () {
    // 医院
    var hospital_dom = $('#hospital');
    var bind_name = 'input';
    if (navigator.userAgent.indexOf("MSIE") != -1){
        bind_name = 'propertychange';
    }
    hospital_dom.bind(bind_name, function(){
        var hospital = $(this).val();
        var data = {name:hospital};
        get_hospital(data);
    });

    hospital_dom.focus( function() {
        var hospital = hospital_dom.val();
        var data = {name:hospital};
        get_hospital({});
    });
    $('#query-select-bg').click( function() {
        close_hospiatal_list();
    });
});

