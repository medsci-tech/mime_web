@extends('backend/layouts/app')

@section('title','tables')

@section('css')
  <link rel="stylesheet" href="/css/backend-tables.css">
  <style>
    .table .success td, .table .success th {
      background-color: #dff0d8 !important;
    }

    table.dataTable.display tbody tr.success > .sorting_1,
    table.dataTable.order-column.stripe tbody tr.success > .sorting_1 {
      background-color: #d9ead4 !important;
    }
  </style>
@endsection

@section('content')
  <div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
      @include('backend.layouts.alerts')
      <h1>
        @yield('title')
      </h1>
      {{--<ol class="breadcrumb">--}}
      {{--<li><a href="#"><i class="fa fa-dashboard"></i>主页</a></li>--}}
      {{--<li class="active">列表</li>--}}
      {{--</ol>--}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">@yield('box_title')</h3>
              <div class="box-tools">
                <div class="input-group" style="width: 150px;">
                  <input name="table_search" class="form-control input-sm pull-right" disabled placeholder="搜索暂不可用"
                         type="text">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-default" disabled><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body no-padding" v-cloak>
              <table class="table table-bordered table-hover table-striped table-responsive">
                <thead style="word-break: keep-all">
                <tr role="row">
                  <th v-for="head in table_head" rowspan="1" colspan="1" style="white-space: nowrap">@{{ head }}</th>
                  <th rowspan="1" colspan="1" style="white-space: nowrap">
                    数据操作&emsp;
                    <button class="btn btn-xs btn-success" @click='add()'><i class="fa fa-plus"></i>&nbsp;新增</button>
                  </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="data in table_data" @click="set_editor(data)">
                <td v-for="data in data">@{{ data }}
                  {{--<div v-if="is_img(data)">--}}
                    {{--<img class="img-responsive" src="../image/test.jpg" alt="">--}}
                  {{--</div>--}}
                </td>
                <td style="white-space: nowrap">
                  <button class="btn btn-xs btn-primary" @click="editor(data)">修改</button>
                  <button class="btn btn-xs btn-warning" @click="pre_delete($event)">删除</button>
                  <div class="fade inline"
                       style="padding: 5px 5px 8px 5px; background-color: #aaa; border-radius: 5px;">
                    <button class="btn btn-xs btn-primary" @click="cancel_delete($event)">取消</button>
                    <button class="btn btn-xs btn-danger" @click="confirm_delete(data)">确认删除</button>
                  </div>
                </td>
                </tr>
                </tbody>
              </table>

            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              @{{{ pagination }}}
            </div>
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div>

      <!-- Modal -->
      @include('backend.tables.edit')
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

@section('js')
  <script src="/js/backend-tables.js"></script>
  @yield('tables_data')

  <script>
    //单击加颜色,双击事件
    $(function () {
      $('tbody tr').click(function () {
        $(this).siblings().removeClass('success');
        $(this).addClass('success');
      });
      $('tbody tr').dblclick(function () {
        $('#modal-edit').modal('show');
      });


      var i = 0;
      $('tbody tr')[0].addEventListener("touchstart", function () {
        i++;
        setTimeout(function () {
          i = 0;
        }, 200);
        if (i > 1) {
          $('#modalView').modal('show');
          i = 0;
        }
      }, false);
    });
  </script>

  {{--<script src="{{asset('vendor')}}/vuejs/vue.js"></script>--}}
  {{--<script>--}}
  {{--new Vue({});--}}
  {{--</script>--}}

@endsection