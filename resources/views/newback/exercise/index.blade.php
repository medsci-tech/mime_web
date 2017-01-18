@extends('newback.layouts.app')

@section('title','试题管理')

@section('css')
    <link rel="stylesheet" href="/css/backend-tables.css">
    <link rel="stylesheet" href="/vendor/bootstrap-wysihtml/bootstrap3-wysihtml5.css">
    <style>
        .table .success td, .table .success th {
            background-color: #dff0d8 !important;
        }

        table.dataTable.display tbody tr.success > .sorting_1,
        table.dataTable.order-column.stripe tbody tr.success > .sorting_1 {
            background-color: #d9ead4 !important;
        }

        @media (max-width: 767px) {
            .fixed .content-wrapper, .fixed .right-side {
                padding-top: 50px;
            }
        }
        .table tr th{
            white-space: nowrap;
        }

    </style>
@endsection
@include('backend.layouts.aside')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            @include('newback.layouts.alerts')
            <h1>
                @yield('title')
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">列表</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding" style="overflow: auto">
                            <table class="table table-bordered table-hover table-striped table-responsive">
                                <thead style="word-break: keep-all">
                                <tr>
                                    <th>问题类型</th>
                                    <th>选择类型</th>
                                    <th>问题</th>
                                    <th>选项数</th>
                                    <th>答案</th>
                                    <th>解析</th>
                                    <th>状态</th>
                                    <th>
                                        数据操作&emsp;
                                        <button class="btn btn-xs btn-success" data-btn="add" data-target="#modal-edit" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;新增</button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lists as $list)
                                <tr>
                                    <td>{{config('params')['exercise']['type'][$list->type]}}</td>
                                    <td>{{config('params')['exercise']['check_type'][$list->check_type]}}</td>
                                    <td>{{$list->question}}</td>
                                    <td>{{count(unserialize($list->option))}}</td>
                                    <td>@if($list->type != 2){{$list->answer}}@endif</td>
                                    <td>{{$list->resolve}}</td>
                                    <td>{{config('params')['status_option'][$list->status]}}</td>
                                    <td style="white-space: nowrap">
                                        <button class="btn btn-xs btn-primary" data-btn="edit" data-target="#modal-edit" data-toggle="modal"
                                            data-id="{{$list->id}}"
                                            data-check_type="{{$list->check_type}}"
                                            data-type="{{$list->type}}"
                                            data-question="{{$list->question}}"
                                            data-option="{{json_encode(unserialize($list->option))}}"
                                            data-answer="{{$list->answer}}"
                                            data-resolve="{{$list->resolve}}"
                                            data-status="{{$list->status}}"
                                        >修改</button>
                                        <button class="btn btn-xs btn-warning" data-btn="delete" data-id="{{$list->id}}">删除</button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">

                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include('newback.exercise.edit')

    <form id="delete-form" action="{{url('newback/exercise')}}" method="post" style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="id">
    </form>
@endsection

@section('js')
    <script>

        $(function () {
            var answer_name = 'answer';
            var option_name = 'option';

            var optionListBody = $('#optionListBody');
            /*删除题库选项*/
            optionListBody.on('click','.delThisOption',function() {
                delThisRowOptionForMime('#optionListBody', this, 1, option_name);
            });
            /*添加题库选项*/
            optionListBody.on('click','.addNextOption',function() {
                var thisTr = $(this).parent().parent();
                var datakey = parseInt(thisTr.attr('data-key'));
                var thisLatter = String.fromCharCode(65 + datakey);
                var checkValue = $('#exercise-type').val();
                var checkType = 'radio';
                if(checkValue == 2){
                    checkType = 'checkbox';
                }
                var trHtml = ''
                        + '<tr data-key="' + ( datakey + 1 ) + '">'
                        + '    <td>' +thisLatter+ '</td>'
                        + '    <td><input type="text" class="form-control" name="' + option_name + '[' +thisLatter+ ']"></td>'
                        + '    <td><input type="' + checkType + '" class="checkValue" name="' + answer_name + '[]" value="' +thisLatter+ '"></td>'
                        + '    <td>'
                        + '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>'
                        + '        <a href="javascript:void(0);" class="addNextOption"><span class="glyphicon glyphicon-plus-sign"></span></a>'
                        + '    </td>'
                        + '</tr>';
                thisTr.after(trHtml);
                $(this).remove();
            });

            /*题目单选多选切换*/
            $('#form-check_type').change(function() {
                var checkValue = optionListBody.find('.checkValue');
                if(1 == $(this).val()){
                    checkValue.attr('type','radio');
                }else {
                    checkValue.attr('type','checkbox');
                }
            });
            /*题目类型切换*/
            $('#form-type').change(function() {
                var checkValue = optionListBody.find('.checkValue');
                if(1 == $(this).val()){
                    checkValue.show();
                }else {
                    checkValue.hide();
                }
            });

            $('[data-btn="add"]').click(function(){
                var defaltData = '';
                $('#form-id').val(defaltData);
                $('#form-type').val(1);
                $('#form-check_type').val(1);
                $('#form-question').val(defaltData);
                $('#form-resolve').val(defaltData);
                $('#form-status').val(1);
                exerciseInitForMime('#optionListBody', option_name, answer_name);
            });
            $('[data-btn="edit"]').click(function () {
                var id = $(this).attr('data-id');
                var type = $(this).attr('data-type');
                var check_type = $(this).attr('data-check_type');
                var question = $(this).attr('data-question');
                var option = JSON.parse($(this).attr('data-option'));
                var answer = $(this).attr('data-answer');
                var resolve = $(this).attr('data-resolve');
                var status = $(this).attr('data-status');
                /* 编辑初始化 */

                $('#form-id').val(id);
                $('#form-type').val(type);
                $('#form-check_type').val(check_type);
                $('#form-question').val(question);
                $('#form-resolve').val(resolve);
                $('#form-status').val(status);

                var type1 = 'radio';
                var type2 = '';
                if(check_type == 2){
                    type1 = 'checkbox';
                }
                if(type == 2){
                    type2 = 'none';
                }
                exerciseEditForMime('#optionListBody', option, answer, type1, type2, option_name, answer_name);
            });
            
            $('[data-btn="delete"]').click(function () {
                var id = $(this).data('id');
                console.log(id);
                if(id){
                    var delete_form =  $('#delete-form');
                    delete_form.find('input[name="id"]').val(id);
                    swal({
                        title: "您确定要删除吗",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: '取消',
                        confirmButtonColor: "#f8ac59",
                        confirmButtonText: "确定",
                        closeOnConfirm: false
                    }, function () {
                        delete_form.submit();
                    });
                }
            });
        })
    </script>
    @endsection

