@extends('backend.tables.index')

@section('title','课程信息')
@section('box_title','课程信息列表')


@section('tables_data')
  <script>
    var data = {
        table_head: ['id', '编号', '课程名称', '是否显示','所属单元', '缩略图', '腾讯云file_id', '腾讯云app_id'],
        table_data: [
          @foreach($courses as $course)
            ['{{$course->id}}', '{{$course->sequence}}', '{{$course->title}}', '{{$course->is_show ?'显示' :'不显示'}}', '{{$course->thyroidClassPhase ?$course->thyroidClassPhase->title :''}}', '{{$course->logo_url}}', '{{$course->qcloud_file_id}}', '{{$course->qcloud_app_id}}'],
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
            name: 'is_show',
            option: {
              '显示': '1',
              '不显示': '0'
            }
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
            name: 'logo_url',
            type: 'text'
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
          action: '/admin/course',
          method: 'put'
        },
        add_info: {
          title: '添加',
          action: '/admin/course',
          method: 'post'
        },
        delete_info: {
          url: '/admin/course',
          method: 'delete'
        },

        form_info: {
          title: '编辑',
          action: '',
          method: 'post'
        },
        alert: alert,
      }
  </script>
@endsection