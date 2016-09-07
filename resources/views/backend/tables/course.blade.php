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
        table_head: ['id', '编号', '课程名称', '所属单元', '缩略图', '腾讯云file_id', '腾讯云app_id'],
        table_data: [
          @foreach($courses as $course)
            ['{{$course->id}}', '{{$course->sequence}}', '{{$course->title}}', '{{$course->thyroidClassPhase->title}}', '{{$course->logo_url}}', '{{$course->qcloud_file_id}}', '{{$course->qcloud_app_id}}'],
          @endforeach
        ],
        pagination: '{{$courses->render() }}',
        modal_data: [
          {
            box_type: 'input',
            name: 'id',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'sequence',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'title',
            type: 'text'
          },
          {
            box_type: 'select',
            name: 'thyroid_class_phase_id',
            option: {
              @foreach($phases as $phase)
              '{{$phase->title}}': '{{$phase->id}}',
              @endforeach
            }
          },
          {
            box_type: 'input',
            name: 'qcloud_file_id',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'qcloud_app_id',
            type: 'text'
          }
        ],

        update_info: {
          title: '编辑',
          action: '',
          method: 'post'
        },
        add_info: {
          title: '添加',
          action: '',
          method: 'post'
        },
        delete_info: {
          url: ''
        },

        form_info: {
          title: '编辑',
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
        },
        is_img: function (e) {
          var reg=/.(jpg|png)$/;
          return reg.test(e);
        }
      }
    });

  </script>
@endsection