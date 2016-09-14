@extends('backend.tables.index_student')

@section('title', '学生信息')
@section('box_title','学生列表')


@section('tables_data')
  <script>
    var data = {
      table_head: ['id', '姓名', '宣传照', '科室', '职称', '介绍'],
      log_head: ['id', '姓名', '宣传照', '科室', '职称', '介绍'],
      data: [{
        table_data: [1, 2, 3, 4, 5, 6],
        log_data: [
          [1, 2, 3, 4, 5, 6],
          [1, 2, 3, 4, 5, 6]
        ]
      }, {
        table_data: [1, 2, 3, 4, 5, 6],
        log_data: [
          [1, 2, 3, 4, 5, 6],
          [1, 2, 3, 4, 5, 6]
        ]
      }],
      modal_data: '',
      alert: alert
    }

  </script>
@endsection