@extends('backend.tables.index')

@section('title','title1')
@section('box_title','title1')


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
          //textarea类型
          {
            box_type: 'textarea',
            name: 'introduction',
            rows: 3
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