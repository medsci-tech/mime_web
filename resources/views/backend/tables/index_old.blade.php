@extends('backend.layouts.app')

@section('title','tables')

@section('css')
  <link rel="stylesheet" href="/css/backend-tables.css">
  <style>
    .table .success td, .table .success th {
      background-color: #dff0d8 !important;
    }

    table.dataTable.display tbody tr.success > .sorting_1,
    table.dataTable.order-column.stripe tbody tr.success   > .sorting_1 {
      background-color: #d9ead4 !important;
    }
  </style>
@endsection

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        列表
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>主页</a></li>
        <li class="active">列表</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            {{--<div class="box-header">--}}
            {{--<h3 class="box-title">文章列表</h3>--}}
            {{--</div><!-- /.box-header -->--}}
            <div class="box-body">
              <div id="articleList_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="articleList" class="table table-bordered table-hover dataTable nowrap display"
                           role="grid"
                           aria-describedby="articleList_info">
                      <thead style="word-break: keep-all">
                      <tr role="row">
                        <th rowspan="1" colspan="1">文章标题</th>
                        <th rowspan="1" colspan="1">内容简介</th>
                        <th rowspan="1" colspan="1">新增时间</th>
                        <th rowspan="1" colspan="1">更新时间</th>
                        <th rowspan="1" colspan="1">发布人</th>
                      </tr>
                      </thead>
                      <tfoot style="word-break: keep-all">
                      <tr>
                        <th rowspan="1" colspan="1">文章标题</th>
                        <th rowspan="1" colspan="1">内容简介</th>
                        <th rowspan="1" colspan="1">新增时间</th>
                        <th rowspan="1" colspan="1">更新时间</th>
                        <th rowspan="1" colspan="1">发布人</th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div>

      <!-- Modal -->
      <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

@section('js')
  <script src="/js/backend-tables.js"></script>
  <script>
    $(function () {
      $("#articleList").DataTable({
        "oLanguage": {
          "sLengthMenu": "每页显示 _MENU_ 条记录",
          "sZeroRecords": "抱歉， 没有找到",
          "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
          "sInfoEmpty": "没有数据",
          "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
          "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "前一页",
            "sNext": "后一页",
            "sLast": "尾页"
          }
        },
        "bStateSave": true,
        "responsive": true,
        {{--"serverSide": true,--}}
          {{--"ajax": "{{url('test/article/list')}}",--}}
        "data": [
          [
            "标题",
            "简介",
            "2015-08-05 11:11:49",
            "2015-12-08 11:13:07",
            "admin"
          ],
          [
            "标题",
            "简介",
            "2015-08-05 11:11:49",
            "2015-12-08 11:13:07",
            "admin"
          ]
        ]
      });
      $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
      });


    });
    $(function () {
      $('#articleList_filter').prepend(
        "<div class='inline'>" +
        "<a href='{{ url('/article/create') }}' class='btn btn-flat btn-success'>添加</a>" + "&nbsp;" +
        "<button class='btn btn-flat btn-warning' disabled>编辑</button>" + "&nbsp;" +
        "<button class='btn btn-flat btn-danger' disabled>删除</button>" + "&nbsp;" +
        "</div>"
      );
      $('#articleList_filter label').css('margin-bottom', '10px');
      $('#articleList tbody tr').click(function () {
        $(this).siblings().removeClass('success');
        $(this).addClass('success');
      });
      $('#articleList tbody tr').dblclick(function () {
        $('#modalView').modal('show');
      });


      var i = 0;
      $('#articleList tbody tr')[0].addEventListener("touchstart", function () {
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