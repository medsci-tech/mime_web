@extends('backend.tables.index')

@section('title','title1')
@section('box_title','title1')


@section('tables_data')
  <script>
    var tables = new Vue({
      el: 'body',
      compiled: function () {
        var l = this.table_head.length;
        for (var i = 0; i < l; i++) {
          Vue.set(this.modal_data[i], 'title', this.table_head[i]);
        }
      },
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
          $('#modal-edit').modal('show');
        },
        confirm_delete: function (e) {
          $.post(this.delete_info.url, e, function (data) {
            if (data.success) {
              history.go(0);
            } else {
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

  </script>
@endsection