@extends('backend.tables.index')

@section('title', '讲师信息')
@section('box_title','讲师列表')


@section('tables_data')
  <script>
    var data = {
        table_head: ['id', '姓名', '宣传照', '科室', '职称', '介绍'],
        table_data: [
          @foreach($teachers as $teacher)
            ['{{$teacher->id}}', '{{$teacher->name}}', '{{$teacher->photo_url}}', '{{$teacher->office}}', '{{$teacher->title}}', '{{$teacher->introduction}}'],
          @endforeach
        ],
        pagination: '{{$teachers->render()}}',
        modal_data: [
          {
            box_type: 'input',
            name: 'id',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'name',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'photo_url',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'office',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'title',
            type: 'text'
          },
          {
            box_type: 'textarea',
            name: 'introduction',
            rows: 8
          }
        ],

        update_info: {
          title: '编辑',
          action: '/admin/teacher',
          method: 'put'
        },
        add_info: {
          title: '添加',
          action: '/admin/teacher',
          method: 'post'
        },
        delete_info: {
          url: '/admin/teacher',
          method: 'delete'
        },

        form_info: {
          title: '编辑',
          action: '',
          method: 'post'
        },
        @if(Session::has('alert'))
            alert: {
              type: '{{Session::get("alert")['type']}}',
              title: '{{Session::get("alert")['title']}}',
              message: '{{Session::get("alert")['message']}}'
            }
        @else
            alert: {
                type: '',
                title: '',
                message: ''
            }
        @endif
      }

  </script>
@endsection