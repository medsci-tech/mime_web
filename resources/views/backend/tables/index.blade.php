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
              <div id="articleList_wrapper" class="form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="articleList" class="table table-bordered table-hover"
                           role="grid"
                           aria-describedby="articleList_info">
                      <thead style="word-break: keep-all">
                      <tr role="row">
                        <th v-for="head in table_head" rowspan="1" colspan="1">@{{ head }}</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr v-for="data in table_data" click="set_editor(data)">
                        <td v-for="data in data">@{{ data }}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
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
  <script>
    var tables = new Vue({
      el: 'body',
      data: {
        table_head: ['a', 'b', 'c', 'd', 'e'],
        table_data: [
          ['1', '2', '3', '4', '5'],
          ['1', '2', '3', '4', '5']
        ],
        modal_data: [
          //一般input类型
          {
            box_type: 'input',
            type: 'text'
          },
          //一般input类型
          {
            box_type: 'input',
            type: 'text'
          },
          //一般input类型
          {
            box_type: 'input',
            type: 'text'
          },
          //select类型
          {
            box_type: 'select',
            option: ['option1', 'option2', 'option3']
          },
          //textarea类型
          {
            box_type: 'textarea',
            rows: 3,
            type: 'text'
          }
        ]
      },
      computed: {
        initialize_editor: function () {
          var l = this.table_head.length;
          for (var i = 0; i < l; i++) {
            this.modal_data[i].name = this.table_head[i];
          }
        }
      },
      methods: {
        set_editor: function (e) {
          var l = e.length;
          for (var i = 0; i < l; i++) {
            this.modal_data[i].value = e[i];
          }
        }
      }
    });

    $(function () {
      $('#articleList tbody tr').click(function () {
        $(this).siblings().removeClass('success');
        $(this).addClass('success');
      });
      $('#articleList tbody tr').dblclick(function () {
        $('#modal-edit').modal('show');
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