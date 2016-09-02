@extends('/layouts/app')

@section('title','新闻信息表')

@section('css')
  <link rel="stylesheet" href="{{asset('vendor')}}/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet"
        href="{{asset('vendor')}}/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css">
  <link rel="stylesheet" href="{{asset('vendor')}}/plugins/umeditor/themes/default/css/umeditor.css">
@endsection

@section('js')
  <script src="{{asset('vendor')}}/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="{{asset('vendor')}}/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="{{asset('vendor')}}/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
  <script src="{{asset('vendor')}}/plugins/umeditor/umeditor.config.js"></script>
  <script src="{{asset('vendor')}}/plugins/umeditor/umeditor.js"></script>
  <script type="{{asset('vendor')}}/plugins/umeditor/lang/zh-cn/zh-cn.js"></script>
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
          ]
        ]
      });
      $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
      });

      var create = UM.getEditor('create', {
        initialFrameWidth: '100%',
        autoHeightEnabled: false,
        scaleEnabled: true
      });
      var edit = UM.getEditor('edit');
    });
    $(function () {
      $('#articleList_filter').prepend(
        "<div class='inline'>" +
        "<a href='{{ url('/article/create') }}' class='btn btn-flat btn-success'>添加</a>" + "&nbsp;" +
        "<button class='btn btn-flat btn-warning' disabled>编辑</button>" + "&nbsp;" +
        "<button class='btn btn-flat btn-danger' disabled>删除</button>" + "&nbsp;" +
        "</div>"
      );
      $('#articleList_filter label').css('margin-top', '5px');
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

  {{--<script src="{{asset('vendor')}}/plugins/vuejs/vue.js"></script>--}}
  {{--<script>--}}
  {{--new Vue({});--}}
  {{--</script>--}}

@endsection

@section('content-header')
  <h1>
    文章列表
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>主页</a></li>
    <li>新闻信息表</li>
    <li class="active">文章列表</li>
  </ol>
@endsection

@section('content')
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
                <table id="articleList" class="table table-bordered table-hover dataTable" role="grid"
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
@endsection
