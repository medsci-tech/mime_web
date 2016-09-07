@extends('backend.tables.index')

@section('title','title1')
@section('box_title','title1')


@section('tables_data')
  <script>
    var data = {
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
      }
  </script>
@endsection