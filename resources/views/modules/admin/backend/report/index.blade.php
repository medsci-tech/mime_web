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
            @include('admin::backend.layouts.alerts')
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">报表管理</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <img src="{{asset('admin/images/report-icon2.png')}}" alt="...">
                                        <div class="caption">
                                            <h3 class="text-center">按省份</h3>
                                            <p>统计学员情况</p>
                                            <p>
                                                <a href="{{url('report/byProvince')}}" class="btn btn-default" role="button">导出</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
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

