@extends('backend.tables.index')

@section('title','单元管理')
@section('box_title','单元列表')


@section('tables_data')
  <script>
    var data = {
      table_head: ['id', '单元名称', '授课老师', '简介'],
      table_data: [
          @foreach($phases as $phase)
        ['{{$phase->id}}', '{{$phase->title}}', '{{$phase->teacher ?$phase->teacher->name :''}}', '{{$phase->comment}}'],
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
          rows: 8
        }
      ],

      update_info: {
        title: '编辑',
        action: '/admin/phase',
        method: 'put'
      },
      add_info: {
        title: '添加',
        action: '/admin/phase',
        method: 'post'
      },
      delete_info: {
        url: '/admin/phase',
        method: 'delete',
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