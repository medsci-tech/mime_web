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
    @include('admin::backend.layouts.site_aside')
@endif
@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            @include('admin::backend.layouts.alerts')
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">站点管理</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding" style="overflow: auto">
                            <table class="table table-bordered table-hover table-striped table-responsive">
                                <thead style="word-break: keep-all">
                                <tr>
                                    <th>站点ID</th>
                                    <th>站点名称</th>
                                    <th>站点状态</th>
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
                                            <td>{{$list->id}}</td>
                                            <td><a href="/admin/thyroid?site_id={{$list->id}}">{{$list->name}}</a></td>
                                            <td>{{config('params')['status_option'][$list->status]}}</td>
                                            <td style="white-space: nowrap">
                                                <button class="btn btn-xs btn-primary" data-btn="edit" data-target="#modal-edit" data-toggle="modal"
                                                        data-id="{{$list->id}}"
                                                        data-name="{{$list->name}}"
                                                        data-status="{{$list->status}}"
                                                >修改</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>

                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                            {{$lists->render()}}
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include('admin::backend.site.edit')

@endsection

@section('js')

    <script>

        $(function () {
            var tableListBody = $('#tableListBody');
            $('[data-btn="add"]').click(function(){
                var defaltData = '';
                $('#form-id').val(defaltData);
                $('#form-name').val(defaltData);
                $('#form-status').val(1);
            });
            $('[data-btn="edit"]').click(function () {
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var status = $(this).attr('data-status');
                /* 编辑初始化 */
                $('#form-id').val(id);
                $('#form-name').val(name);
                $('#form-status').val(status);

            });

        });
    </script>
@endsection

