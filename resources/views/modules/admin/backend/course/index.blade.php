@extends('admin::backend.layouts.app')

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
@if (Auth::guest())
@else
    @include('admin::backend.layouts.aside')
@endif
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            @include('admin::layouts.alerts')
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">课程信息</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding" style="overflow: auto">
                            <table class="table table-bordered table-hover table-striped table-responsive">
                                <thead style="word-break: keep-all">
                                <tr>
                                    <th>编号</th>
                                    <th>课程名称</th>
                                    <th>课程类别</th>
                                    <th>是否显示</th>
                                    <th>所属单元</th>
                                    <th>缩略图</th>
                                    <th>腾讯云file_id</th>
                                    <th>腾讯云app_id</th>
                                    <th>
                                        数据操作&emsp;
                                        <button class="btn btn-xs btn-success" data-btn="add" data-target="#modal-edit" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;新增</button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($lists)
                                @foreach($lists as $list)
                                <tr>
                                    <td>{{$list->sequence}}</td>
                                    <td>{{$list->title}}</td>
                                    <td>{{$list->courseClass->name}}</td>
                                    <td>{{config('params')['status_option'][$list->is_show]}}</td>
                                    <td>{{$list->thyroidClassPhase ? $list->thyroidClassPhase->title :''}}</td>
                                    <td>
                                        @if($list->logo_url)
                                        <img class="img-responsive" src="{{$list->logo_url}}">
                                            @else
                                            无
                                            @endif
                                    </td>
                                    <td>{{$list->qcloud_file_id}}</td>
                                    <td>{{$list->qcloud_app_id}}</td>
                                    <td style="white-space: nowrap">
                                        <button class="btn btn-xs btn-primary" data-btn="edit" data-target="#modal-edit" data-toggle="modal"
                                            data-id="{{$list->id}}"
                                            data-sequence="{{$list->sequence}}"
                                            data-title="{{$list->title}}"
                                            data-course_type="{{$list->course_type}}"
                                            data-thyroid_class_phase_id="{{$list->thyroid_class_phase_id}}"
                                            data-logo_url="{{$list->logo_url}}"
                                            data-qcloud_file_id="{{$list->qcloud_file_id}}"
                                            data-qcloud_app_id="{{$list->qcloud_app_id}}"
                                            data-is_show="{{$list->is_show}}"
                                            data-exercise_ids="{{$list->exercise_ids}}"
                                            data-course_class_id="{{$list->course_class_id}}"
                                            data-course_class_has_teacher="{{\App\Models\CourseClass::find($list->course_class_id)['has_teacher']}}"
                                            data-course_class_has_phase="{{\App\Models\CourseClass::find($list->course_class_id)['has_children']}}"
                                            data-teacher_id="{{$list->teacher_id}}"
                                        >修改</button>
                                        <button class="btn btn-xs btn-warning" data-btn="delete" data-id="{{$list->id}}">删除</button>
                                        <button class="btn btn-xs @if($list->recomment_time > 0) btn-warning @else btn-info @endif"
                                                @if($list->recomment_time > 0) data-btn="recommend_cancel" @else data-btn="recommend" @endif data-id="{{$list->id}}">
                                            @if($list->recomment_time > 0) 取消推荐 @else 推荐 @endif
                                        </button>
                                        {{--<button class="btn btn-xs btn-warning" data-btn="recommend_cancel" data-id="{{$list->id}}">取消推荐</button>--}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>

                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                            {{$lists->appends(['site_id' => $_GET['site_id'] ?? ''])->render()}}
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include('admin::backend.course.edit')

    <form id="delete-form" action="{{url('/course')}}?site_id={{$_GET['site_id'] ?? ''}}" method="post" style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="id">
    </form>
@endsection

@section('js')

    <script src="{{asset('vendor/layer/layer.js')}}" ></script>
<script>
    var getExerciseList = function (data) {
        $.ajax({
            type: 'post',
            url: '{{url('/exercise/get_list')}}',
            data: data,
            success: function(res){
                var html = '';
                if(res.data){
                    var parentLastNum = 0;
                    var ids_name = 'exercise_ids';
                    for(var i in res.data){
                        parentLastNum++;
                        html += '<tr data-key="' + parentLastNum + '">';
                        html += '    <td>' + parentLastNum + '</td>';
                        html += '    <td>' + res.data[i]['type'] + '<input type="hidden" name="'+ids_name+'[]" value="' + res.data[i]['id'] + '"></td>';
                        html += '    <td>' + res.data[i]['question'] + '</td>';
                        html += '    <td>' + res.data[i]['option'] + '</td>';
                        html += '    <td>' + res.data[i]['answer'] + '</td>';
                        html += '    <td>';
                        html += '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>';
                        html += '    </td>';
                        html += '</tr>';
                    }
                }
                $('#tableListBody').html(html);
            },
            error:function () {
                $('#tableListBody').html('');
            }
        });
    };
    $(function () {
        var tableListBody = $('#tableListBody');
        $('[data-btn="add"]').click(function(){
            var defaltData = '';
            $('#form-id').val(defaltData);
            $('#form-sequence').val(defaltData);
            $('#form-title').val(defaltData);
            $('#form-thyroid_class_phase_id').val(0);
            $('#form-logo_url').val(defaltData);
            $('#form-qcloud_file_id').val(defaltData);
            $('#form-qcloud_app_id').val(defaltData);
            $('#form-is_show').val(1);
            $('#form-course_class_id').val(defaltData);
            $('#form-teacher_id').val(0);
            tableListBody.html(defaltData);
        });
        $('[data-btn="edit"]').click(function () {
            var id = $(this).attr('data-id');
            var sequence = $(this).attr('data-sequence');
            var title = $(this).attr('data-title');
            var thyroid_class_phase_id = $(this).attr('data-thyroid_class_phase_id');
            var logo_url = $(this).attr('data-logo_url');
            var qcloud_file_id = $(this).attr('data-qcloud_file_id');
            var qcloud_app_id = $(this).attr('data-qcloud_app_id');
            var is_show = $(this).attr('data-is_show');
            var course_class_id = $(this).attr('data-course_class_id');
            var course_class_has_teacher = $(this).attr('data-course_class_has_teacher');
            var course_class_has_phase = $(this).attr('data-course_class_has_phase');
            var teacher_id = $(this).attr('data-teacher_id');
            var exercise_ids = $(this).attr('data-exercise_ids');
            var course_type = $(this).attr('data-course_type');
            /* 编辑初始化 */
            $('#form-id').val(id);
            $('#form-sequence').val(sequence);
            $('#form-title').val(title);
            $('#form-thyroid_class_phase_id').val(thyroid_class_phase_id);
            if(logo_url){
                $('#form-logo_url_html').html('<img class="img-responsive" src="'+logo_url+'">');
            }
            $('#form-logo_url').val(logo_url);
            $('#form-qcloud_file_id').val(qcloud_file_id);
            $('#form-qcloud_app_id').val(qcloud_app_id);
            $('#form-is_show').val(is_show);
            $('#form-course_class_id').val(course_class_id);
            $('#form-teacher_id').val(teacher_id);
            $('#form_course_type').val(course_type);

            if(course_class_has_teacher == 1){
                $('#teacher_id_parentDiv').show();
            }else {
                $('#teacher_id_parentDiv').hide();
            }
            if(course_class_has_phase == 1){
                $('#phase_id_parentDiv').show();
            }else {
                $('#phase_id_parentDiv').hide();
            }
            getExerciseList({'ids':exercise_ids});

        });

        $('[data-btn="delete"]').click(function () {
            var id = $(this).data('id');
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

        $('[data-btn="recommend"]').click(function () {
            var id = $(this).data('id');
            if(id){
                var url = '{{url('/course/status')}}';
                var data = {
                    'id': id,
                    'key': 'recommend',
                    'value' : 1
                };
                subActionAjaxForMime('post', url, data, window.location.href);
            }
        });

        $('[data-btn="recommend_cancel"]').click(function () {
            var id = $(this).data('id');
            if(id){
                var url = '{{url('/course/status')}}';
                var data = {
                    'id': id,
                    'key': 'recommend',
                    'value' : 0
                };
                subActionAjaxForMime('post', url, data, window.location.href);
            }
        });

        /*删除试题*/
        tableListBody.on('click','.delThisOption',function() {
            delThisRowOptionForMime('#tableListBody', this, 0, 'exercise_ids', 2);
        });
        /*添加试题*/
        $('#add-child').click(function() {
            layer.open({
                offset: '80px',
                type: 2,
                title: '添加试题',
                area: ['800px', '600px'],
                fix: false, //不固定
                maxmin: true,
                content: '/exercise/table?site_id={{$_GET['site_id'] ?? ''}}'
            });
        });

        /*课程类型*/
        $('#form-course_class_id').on('change', function () {
            var selected_option = this.options[this.selectedIndex];
            if(selected_option.getAttribute('data-has_teacher') == 1){
                $('#teacher_id_parentDiv').show();
            }else {
                $('#teacher_id_parentDiv').hide();
            }
            if(selected_option.getAttribute('data-has_phase') == 1){
                $('#phase_id_parentDiv').show();
            }else {
                $('#phase_id_parentDiv').hide();
            }
        });
    });
</script>
@endsection

