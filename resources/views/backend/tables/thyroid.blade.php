@extends('backend.tables.index')

@section('title','公开课')
@section('box_title','公开课列表')


@section('tables_data')
  <script>
    var data = {
      table_head: ['id', '名称', 'banner滚动时间（单位/毫秒）', '最新更新时间', '介绍', '视频 app id', '视频 file id'],
      table_data: [
          @foreach($thyroids as $thyroid)
        ['{{$thyroid->id}}', '{{$thyroid->title}}', '{{$thyroid->banner_autopaly}}', '{{$thyroid->latest_update_at}}', '{{$thyroid->comment}}', {{$thyroid->qcloud_app_id}}, {{$thyroid->qcloud_file_id}}],
        @endforeach
      ],
      pagination: '{{$thyroids->render() }}',
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
          box_type: 'input',
          name: 'banner_autopaly',
          type: 'text'
        },
        {
          box_type: 'input',
          name: 'latest_update_at',
          type: 'text'
        },
        {
          box_type: 'textarea',
          name: 'comment',
          rows: 8
        },
        {
          box_type: 'input',
          name: 'qcloud_app_id',
          type: 'text'
        },
        {
          box_type: 'input',
          name: 'qcloud_file_id',
          type: 'text'
        }
      ],

      update_info: {
        title: '编辑',
        action: '/admin/thyroid',
        method: 'put'
      },
      add_info: {
        title: '添加',
        action: '/admin/thyroid',
        method: 'post'
      },
      delete_info: {
        url: '/admin/thyroid',
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