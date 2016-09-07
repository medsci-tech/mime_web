@extends('backend.tables.index')

@section('title','单元管理')
@section('box_title','单元列表')


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
        table_head: ['id', '单元名称', '授课老师', '简介'],
        table_data: [
          @foreach($phases as $phase)
            ['{{$phase->id}}', '{{$phase->title}}', '{{$phase->teacher->name}}', '{{$phase->comment}}'],
          @endforeach
        ],
        pagination: '{{$phases->render() }}',
        modal_data: [
          {
            box_type: 'input',
            name: 'id',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'title',
            type: 'text'
          },
          {
            box_type: 'select',
            name: 'main_teacher_id',
            option: {
              @foreach($teachers as $teacher)
              '{{$teacher->name}}': '{{$teacher->id}}',
              @endforeach
            }
          },
          {
            box_type: 'textarea',
            name: 'comment',
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
          tables.form_info.action = '/admin/teacher/'+ e[0];
          var l = tables.table_head.length;
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
          var l = tables.table_head.length;
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