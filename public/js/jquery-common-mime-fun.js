/**
 * 基于jQuery的方法
 * author zhaiyu
 * startDate 20160511
 * updateDate 20160511
 */
console.log('jq-common-mime');
/**
 * 试题管理-题库添加试题-初始化选项-默认四个选项
 * @param element string | eg:'#div'
 * @param option_name string | eg:'option'
 * @param answer_name string | eg:'answer'
 */
var exerciseInitForMime = function (element, option_name, answer_name) {
    var html = ''
        + '<tr data-key="1">'
        + '    <td>A</td>'
        + '    <td><input type="text" class="form-control" name="' + option_name + '[A]" value=""></td>'
        + '    <td><input type="radio" class="checkValue" name="' + answer_name + '[]" value="A"></td>'
        + '    <td>'
        + '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>'
        + '    </td>'
        + '</tr>'
        + '<tr data-key="2">'
        + '    <td>B</td>'
        + '    <td><input type="text" class="form-control" name="' + option_name + '[B]" value=""></td>'
        + '    <td><input type="radio" class="checkValue" name="' + answer_name + '[]" value="B"></td>'
        + '    <td>'
        + '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>'
        + '    </td>'
        + '</tr>'
        + '<tr data-key="3">'
        + '    <td>C</td>'
        + '    <td><input type="text" class="form-control" name="' + option_name + '[C]" value=""></td>'
        + '    <td><input type="radio" class="checkValue" name="' + answer_name + '[]" value="C"></td>'
        + '    <td>'
        + '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>'
        + '    </td>'
        + '</tr>'
        + '<tr data-key="4">'
        + '    <td>D</td>'
        + '    <td><input type="text" class="form-control" name="' + option_name + '[D]" value=""></td>'
        + '    <td><input type="radio" class="checkValue" name="' + answer_name + '[]" value="D"></td>'
        + '    <td>'
        + '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>'
        + '        <a href="javascript:void(0);" class="addNextOption"><span class="glyphicon glyphicon-plus-sign"></span></a>'
        + '    </td>'
        + '</tr>';
    $(element).html(html);
};
/**
 * 试题管理-题库编辑试题-初始化选项
 * @param element string | eq:'#div'
 * @param option json | eq:{A: "1", B: "2", C: "4"}
 * @param answer string | eq:'A,B,C'
 * @param checkType string | eq:'radio'
 * @param option_name string
 * @param answer_name string
 */
var exerciseEditForMime = function (element, option, answer, checkType ,option_name ,answer_name) {
    var html = '';
    var i = 0;
    var optionLength = Object.keys(option).length;
    if(optionLength > 0){
        for(var key in option){
            html += '<tr data-key="' + ( i + 1 ) + '">';
            html += '    <td>' +key+ '</td>';
            html += '    <td><input type="text" class="form-control" name="' + option_name + '[' +key+ ']" value="' + option[key] + '"></td>';
            html += '    <td><input type="' + checkType + '" ';
            if(answer.match(key)){
                html += 'checked="checked" ';
            }
            html += ' class="checkValue" name="' + answer_name + '[]" value="' +key+ '"></td>';
            html += '    <td>';
            html += '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>';
            if(i == optionLength - 1){
                html += '        <a href="javascript:void(0);" class="addNextOption"><span class="glyphicon glyphicon-plus-sign"></span></a>';
            }
            html += '    </td>';
            html += '</tr>';
            i++;
        }
        $(element).html(html);
    }else {
        exerciseInitForMime(element, option_name, answer_name);
    }
};

/**
 * 删除所在的行(tr)-仅适用于table
 * @param element string | eg:'#div'
 * @param asThis
 * @param retainNum int 保留项数
 * @param type int 1,字母序号 2，数字序号 3，无序号
 * @param option_name
 */
var delThisRowOptionForMime = function (element, asThis, retainNum, option_name, type) {
    if(undefined == retainNum){
        retainNum = 0;
    }
    if(undefined == type){
        type = 1;
    }
    if($(element).find('tr').length > retainNum){
        var parentTr = $(asThis).parent().parent();
        var addHtmlLength = $(asThis).next('a').length;
        if(addHtmlLength){
            var addHtml = ' <a href="javascript:void(0);" class="addNextOption"><span class="glyphicon glyphicon-plus-sign"></span></a>';
            parentTr.prev('tr').find('td').last().append(addHtml);
        }
        for (var i = 0; i < parentTr.nextAll('tr').length; i++){
            var thisTr = $(parentTr.nextAll('tr')[i]);
            var thisTd = thisTr.find('td');
            var dataKey = parseInt(thisTr.attr('data-key'));
            var order;
            if(1 == type){
                order = String.fromCharCode(63 + dataKey);
                thisTd.find('.checkValue').val(order);
                thisTd.eq(0).text(order);
                thisTd.eq(1).find('input').attr('name',option_name + '[' + order + ']');
            }else if(2 == type){
                thisTd.eq(0).text(dataKey - 1);
                thisTd.eq(1).find('input').attr('name',option_name + '[' + dataKey - 1 + ']');
            }
            thisTr.attr('data-key',dataKey - 1);
        }
        parentTr.remove();
    }
};

/**
 * 禁用启用等按钮的提交操作
 * @param element string | eg:'#div'
 * @param val
 */
var subActionForMime = function (element,val) {
    $(element).val(val);
    $(element).submit();
};

/**
 * 判断多选框是否有勾选，有勾选返回true，没有则弹窗提示并返回false
 * @param check array
 * @returns {boolean}
 */
var verifyCheckedForMime = function (check) {
    var checked = 0;
    for(var i =0; i < check.length; i++){
        if(check[i].checked == true){
            checked++;
        }
    }
    if(0 == checked){
        swal('未选择','请勾选需要操作的信息');
        return false;
    }else {
        return true;
    }
};

/**
 * ajax提交请求
 * @param type
 * @param url
 * @param data
 * @param location
 */
var subActionAjaxForMime = function (type, url, data, location) {
    $.ajax({
        type: type,
        url: url,
        data: data,
        success: function(res){
            if(res.code == 200){
                swal({
                    title: "成功",
                    type: "success",
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: "确定",
                    closeOnConfirm: false
                }, function () {
                    window.location.href = location;
                });
            }else {
                swal({
                    title: "失败",
                    text: res.msg,
                    type: "warning",
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: "确定",
                    closeOnConfirm: false
                });
            }
        }
    });
};

/**
 *  获取dom列表的值
 * @param dataList
 * @returns {Array}
 */
var getDataListForMime = function(dataList) {
    var list = [];var j = 0;
    for(var i = 0; i < dataList.length; i++){
        var child = dataList[i];
        if(('radio' == child.type || 'checkbox' == child.type)){
            if(true == child.checked){
                list[j] = $(child).val();
                j++;
            }
        }else {
            list[i] = $(child).val();
        }
    }
    return list;
};
