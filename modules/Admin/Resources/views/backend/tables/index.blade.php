@extends('admin::backend.layouts.app')

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
      @include('admin::backend.layouts.alerts')
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
            <div class="box-body no-padding" style="overflow: auto" v-cloak>
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
                <tr v-for="data in table_data">
                <td v-for="item in data" track-by="$index">
                  <div v-if="is_img(item)">
                    <img class="img-responsive" :src="item" alt="">
                  </div>
                  <div v-else>
                    @{{ item | text }}
                  </div>
                </td>
                <td style="white-space: nowrap">
                  <button class="btn btn-xs btn-primary" @click="editor(data)">修改</button>
                  <button class="btn btn-xs btn-warning" @click="pre_delete($event)">删除</button>
                  <div class="fade inline"
                       style="padding: 5px 5px 8px 5px; background-color: #aaa; border-radius: 5px;">
                    <button class="btn btn-xs btn-primary" @click="cancel_delete($event)">取消</button>
                    <button class="btn btn-xs btn-danger" @click="confirm_delete(data, $event)">确认删除</button>
                  </div>
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
      @include('admin::backend.tables.edit')
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

@section('js')
  <script src="/js/backend-tables.js"></script>
  <script src="/vendor/bootstrap-wysihtml/bootstrap3-wysihtml5.all.min.js"></script>
  @yield('tables_data')
  <script>

    Vue.filter('text', function (value) {
      return value.replace(/<\/?[^>]*>/g,'');
    });

    var tables = new Vue({
      el: 'body',
      compiled: function () {
        var l = this.table_head.length;
        for (var i = 0; i < l; i++) {
          Vue.set(this.modal_data[i], 'title', this.table_head[i]);
        }
      },
      data: data,
      methods: {
        set_editor: function (e) {
          Vue.set(this.form_info, 'title', this.update_info.title);
          Vue.set(this.form_info, 'action', this.update_info.action + '/' + e[0]);
          Vue.set(this.form_info, 'method', this.update_info.method);
          var l = tables.table_head.length;
          for (var i = 0; i < l; i++) {
            Vue.set(this.modal_data[i], 'value', e[i]);
            if (this.modal_data[i].box_type == 'select') {
              Vue.set(this.modal_data[i], 'value', this.modal_data[i].option[e[i]]);
            }
            if (this.modal_data[i].box_type === 'textarea') {
              $('.wysihtml5-sandbox'). contents().find('body').html(tables.modal_data[i].value);
            }
          }
        },
        editor: function (e) {
          tables.set_editor(e);
          $('#modal-edit').modal('show');
        },
        add: function () {
          tables.form_info = tables.add_info;
          var l = tables.table_head.length;
          for (var i = 0; i < l; i++) {
            Vue.set(this.modal_data[i], 'value', '');
            if (this.modal_data[i].box_type === 'textarea') {
              $('.wysihtml5-sandbox'). contents().find('body').html(tables.modal_data[i].value);
            }
          }
          $('#modal-edit').modal('show');
        },
        confirm_delete: function (e, event) {
          var url = this.delete_info.url + '/' + e[0];
          $(event.target).attr('disabled', 'disabled');
          $(event.target).prev().attr('disabled', 'disabled');
          $.ajax({
            url: url,
            type: this.delete_info.method,
            success: function (data) {
              if (data.success) {
                location.reload();
              } else {
                tables.alert = data;
                $(event.target).removeAttr('disabled', 'disabled');
                $(event.target).prev().removeAttr('disabled', 'disabled');
              }
            },
            error: function (XMLResponse) {
              alert(XMLResponse.responseText);
              $(event.target).removeAttr('disabled', 'disabled');
              $(event.target).prev().removeAttr('disabled', 'disabled');
            }
          })
        },
        pre_delete: function (event) {
          $(event.target).next().removeClass('fade');
        },
        cancel_delete: function (event) {
          $(event.target).parent().addClass('fade');
        },
        is_img: function (e) {
          var reg = /.(jpg|png)$/;
          return reg.test(e);
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

      $('textarea').wysihtml5({
        toolbar: {
          "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
          "emphasis": true, //Italics, bold, etc. Default true
          "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
          "html": true, //Button which allows you to edit the generated HTML. Default false
          "link": false, //Button to insert a link. Default true
          "image": false, //Button to insert an image. Default true,
          "color": false, //Button to change color of font
          "blockquote": false, //Blockquote
          "size": 'xs' //default: none, other options are xs, sm, lg
        }
      });
      $("a[href$={{ \Session::get('currentUrl') }}]").parent().addClass('active');
    });
  </script>

@endsection