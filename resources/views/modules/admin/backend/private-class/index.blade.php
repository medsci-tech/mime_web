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
                            <h3 class="box-title">私教课</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding" style="overflow: auto">
                            <table class="table table-bordered table-hover table-striped table-responsive">
                                <thead style="word-break: keep-all">
                                <tr>
                                    <th>ID</th>
                                    <th>期数</th>
                                    <th>医生</th>
                                    <th>讲师</th>
                                    <th>病例</th>
                                    <th>预约时间</th>
                                    <th>状态</th>
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
                                            <td>{{$list->term}}</td>
                                            <td>{{$list->doctor->name}}</td>
                                            <td>{{$list->teacher->name}}</td>
                                            <td>{{$list->upload->old_name}}</td>
                                            <td>{{$list->bespoke_at}}</td>
                                            <td>{{config('params')['private_class_status_option'][$list->status]}}</td>
                                            <td style="white-space: nowrap">
                                                <button class="btn btn-xs btn-primary" data-btn="edit" data-target="#modal-edit" data-toggle="modal"
                                                        data-id="{{$list->id}}"
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
                            {{$lists->appends(['site_id' => $_GET['site_id'] ?? ''])->render()}}
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include('admin::backend.private-class.edit')

@endsection

@section('js')

    <script>

        $(function () {
            $('[data-btn="add"]').click(function(){
                var defaltData = '';
                $('#form-id').val(defaltData);
                $('#form-name').val(defaltData);
                $('#form-banner_url').val(defaltData);
                $('#form-description').val(defaltData);
                $('#form-status').val(1);
            });
            $('[data-btn="edit"]').click(function () {
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var banner_url = $(this).attr('data-banner_url');
                var description = $(this).attr('data-description');
                var status = $(this).attr('data-status');
                /* 编辑初始化 */
                $('#form-id').val(id);
                $('#form-name').val(name);
                if(banner_url){
                    $('#form-img_url_html').html('<img class="img-responsive" src="'+banner_url+'">');
                }
                $('#form-banner_url').val(banner_url);
                $('#form-description').val(description);
                $('#form-status').val(status);

            });

        });
    </script>
@endsection

