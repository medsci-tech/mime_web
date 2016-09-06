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
        老师信息
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
              <h3 class="box-title">tables</h3>
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
              <table class="table table-bordered table-hover table-striped">
                <thead style="word-break: keep-all">
                <tr role="row">
                  <th v-for="head in table_head" rowspan="1" colspan="1">@{{ head }}</th>
                  <th rowspan="1" colspan="1">
                    数据操作&emsp;
                    <button class="btn btn-xs btn-success" @click='add()'><i class="fa fa-plus"></i>&nbsp;新增</button>
                  </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="data in table_data" @click="set_editor(data)">
                <td v-for="data in data">@{{ data }}</td>
                <td>
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
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
              </ul>
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
  <script>
    var tables = new Vue({
      el: 'body',
      data: {
        table_head: ['a', 'b', 'c', 'd', 'e'],
        table_data: [
          ['1', '2', '3', '4', '5'],
          ['6', '7', '8', '9', '10']
        ],
        modal_data: [
          //一般input类型
          {
            box_type: 'input',
            name: 'a',
            type: 'text'
          },
          //一般input类型
          {
            box_type: 'input',
            name: 'b',
            type: 'text'
          },
          //一般input类型
          {
            box_type: 'input',
            name: 'c',
            type: 'text'
          },
          //select类型
          {
            box_type: 'select',
            name: 'd',
            option: ['1', '2', '3', '4']
          },
          //textarea类型
          {
            box_type: 'textarea',
            name: 'e',
            rows: 3
          }
        ],

        update_info: {
          tilte: '编辑',
          action: '',
          method: 'post'
        },
        add_info: {
          tilte: '添加',
          action: '',
          method: 'post'
        },
        delete_info: {
          url: ''
        },

        form_info: {
          tilte: '编辑',
          action: '',
          method: 'post'
        },
        alert: {
          type: '',
          title: '',
          message: ''
        }
      },
      compiled: function () {
        var l = this.table_head.length;
        for (var i = 0; i < l; i++) {
          Vue.set(this.modal_data[i], 'title', this.table_head[i]);
        }
      },
      methods: {
        set_editor: function (e) {
          tables.form_info = tables.update_info;
          var l = e.length;
          for (var i = 0; i < l; i++) {
            Vue.set(this.modal_data[i], 'value', e[i]);
          }
        },
        editor: function (e) {
          tables.set_editor(e);
          $('#modal-edit').modal('show');
        },
        add: function () {
          tables.form_info = tables.add_info;
          var l = e.length;
          for (var i = 0; i < l; i++) {
            Vue.set(this.modal_data[i], 'value', '');
          }
        },
        confirm_delete: function (e) {
          $.post(this.delete_info.url, e, function (data) {
            if(data.success){
              history.go(0);
            }else{
              tables.alert = data.alert;
            }
          })
        },
        pre_delete: function (event) {
          $(event.target).next().removeClass('fade');
        },
        cancel_delete: function (event) {
          $(event.target).parent().addClass('fade');
        }
      }
    });

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