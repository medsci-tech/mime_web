@extends('backend/layouts/app')

@section('title','tables')

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
                <form action="/admin/student" method="get">
                <div class="input-group" style="width: 150px;">
                  <input name="search" class="form-control input-sm pull-right"  placeholder="手机号、姓名、医院、城市、科室或职称"
                       type="text" value="{{isset($search) ?$search :''}}">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
                  </div>
                </div>
                </form>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body no-padding" style="overflow: auto" v-cloak>
              <table class="table table-bordered table-hover table-striped table-responsive">
                <thead style="word-break: keep-all">
                <tr role="row">
                  <th v-for="head in table_head" rowspan="1" colspan="1" style="white-space: nowrap">@{{ head }}</th>
                  <th rowspan="1" colspan="1" style="white-space: nowrap">
                    查看LOG
                  </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="data in data" @click="set(data);">
                <td v-for="item in data.table_data" track-by="$index">
                  <div v-else>
                    @{{ item }}
                  </div>
                </td>
                <td style="white-space: nowrap">
                  <button class="btn btn-xs btn-primary" @click="show(data)">查看</button>
                </td>
                </tr>
                </tbody>
              </table>

            </div><!-- /.box-body -->
            <div v-cloak class="box-footer clearfix">
              @{{{ pagination }}}
            </div>
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div>

      <!-- Modal -->
      @include('backend.tables.list')
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

@section('js')
  <script src="/js/backend-tables.js"></script>
  <script src="/vendor/bootstrap-wysihtml/bootstrap3-wysihtml5.all.min.js"></script>
  @yield('tables_data')
  <script>

    var tables = new Vue({
      el: 'body',
      data: data,
      methods: {
        set: function (data) {
          tables.modal_data = data.log_data;
        },
        show: function (e) {
          $('#modal-list').modal('show');
        }
      }
    });


  </script>
  <script>

    $(function () {

      //单击加颜色,双击事件
      $('tbody tr').click(function () {
        $(this).siblings().removeClass('success');
        $(this).addClass('success');
      });

      $('tbody tr').dblclick(function () {
        $('#modal-list').modal('show');
      });
      //$("a[href$={{ \Session::get('currentUrl') }}]").parent().addClass('active');
    });
  </script>

@endsection