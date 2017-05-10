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
                                        数据操作
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
                                            <td><a href="{{$list->upload->path}}?attname={{$list->upload->old_name}}" >{{$list->upload->old_name}}</a></td>
                                            <td>{{$list->bespoke_at}}</td>
                                             <td>{{config('params')['private_class_status_option'][$list->status]}}</td>
                                            <td style="white-space: nowrap">
                                                <button class="btn btn-xs btn-primary" data-btn="edit" data-target="#modal-edit" data-toggle="modal"
                                                        data-id="{{$list->id}}"
                                                        data-term="{{$list->term}}"
                                                        data-doctor="{{$list->doctor->name}}"
                                                        data-teacher="{{$list->teacher->name}}"
                                                        data-bespoke_at="{{$list->bespoke_at}}"
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
            $('[data-btn="edit"]').click(function () {
                var id = $(this).attr('data-id');
                var term = $(this).attr('data-term');
                var doctor = $(this).attr('data-doctor');
                var teacher = $(this).attr('data-teacher');
                var bespoke_at = $(this).attr('data-bespoke_at');
                var status = $(this).attr('data-status');
                /* 编辑初始化 */
                $('#form-id').val(id);
                $('#form-term').val(term);
                $('#form-doctor').val(doctor);
                $('#form-teacher').val(teacher);
                $('#form-bespoke_at').val(bespoke_at);
                $('#form-status').val(status);

            });

        });
    </script>
@endsection

