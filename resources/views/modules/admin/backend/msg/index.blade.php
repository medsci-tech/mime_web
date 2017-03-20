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
                            <h3 class="box-title">消息管理</h3>
                            <button class="btn btn-xs btn-success pull-right" data-btn="add" data-target="#modal-edit" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;新增</button>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding" style="overflow: auto">
                            <table class="table table-bordered table-hover table-striped table-responsive">
                                <thead style="word-break: keep-all">
                                <tr>
                                    <th>序号</th>
                                    <th>内容</th>
                                    @if($list_row)
                                        <th>{{$list_row['th']}}</th>
                                        @endif
                                    <th>时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($lists)
                                    @foreach($lists as $ol => $list)
                                        <tr>
                                            <td>{{$ol+1}}</td>
                                            <td>{{$list['content']}}</td>
                                            @if($list_row)
                                                <td>
                                                    @if($list_row['td'] == 'site_id')
                                                        {{\Modules\Admin\Entities\Site::find($list[$list_row['td']])['name']}}
                                                        @else
                                                        {{$list[$list_row['td']]}}
                                                        @endif
                                                </td>
                                            @endif
                                            <td>{{$list['created_at']}}</td>
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
    @include('admin::backend.msg.create')

@endsection

@section('js')

    <script>

        $(function () {
            var form = $('#form-validate-submit');
            $('#form-type').on('change', function(){
                var this_value = this.value;
                var siteDom = $('#form-site');
                var phoneDom = $('#form-phone');
                if(this_value == 1){
                    // 平台消息
                    siteDom.hide();
                    phoneDom.hide();
                    form.attr('action','{{url('/msg/set_all')}}');
                }else if(this_value == 2){
                    // 站点消息
                    siteDom.show();
                    phoneDom.hide();
                    //form.attr('action','{{url('/msg/set_site')}}');
                }else if(this_value == 3){
                    // 个人消息
                    siteDom.hide();
                    phoneDom.show();
                    //form.attr('action','{{url('/msg/set_user')}}');
                }
            });
        });
    </script>
@endsection

