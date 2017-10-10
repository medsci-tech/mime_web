@extends('admin::backend.tables.index_student')

@section('box_title','学生信息')

@if (Auth::guest())
@else
  @include('admin::backend.layouts.aside')
@endif
@section('tables_data')
  <script>
    var data = {
      table_head: ['id', '手机号', '邮箱', '姓名', '省', '市', '区', '医院', '科室', '职称', '注册时间'],
      log_head: ['课程名称', '点击次数', '观看时长'],
      data: [
        @foreach($students as $student)
        {
          table_data: ['{{$student->id}}', '{{$student->phone}}', '{{$student->email}}','{{$student->name}}', '{{$student->province}}', '{{$student->city}}', '{{$student->country}}', '{{$student->hospital}}', '{{$student->office}}', '{{$student->title}}', '{{$student->created_at}}']
        },
        @endforeach
      ],
      modal_data: '',
      alert: alert,
      @if(isset($search))
        pagination: '{{$students->appends(['search' => $search, 'site_id' => $_GET['site_id'] ?: ''])->render() }}',
      @else
        pagination: '{{$students->appends(['site_id' => $_GET['site_id'] ?: ''])->render()}}',
      @endif

    }
  </script>
@endsection