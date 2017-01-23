@extends('backend.tables.index')

@section('title', 'Banner')
@section('box_title','banner列表')

@if (Auth::guest())
@else
    @include('backend.layouts.aside')
@endif
@section('tables_data')
  <script>
    var data = {
        table_head: ['id', '图片地址', '跳转链接', '状态', '所属页面', '权重'],
        table_data: [
          @foreach($banners as $banner)
            ['{{$banner->id}}', '{{$banner->image_url}}', '{{$banner->href_url}}', '{{$banner->status ?'显示' :'不显示'}}', '{{$banner->page}}', '{{$banner->weight}}'],
          @endforeach
        ],
        pagination: '{{$banners->render()}}',
        modal_data: [
          {
            box_type: 'input',
            name: 'id',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'image_url',
            type: 'text'
          },
          {
            box_type: 'input',
            name: 'href_url',
            type: 'text'
          },
          {
            box_type: 'select',
            name: 'status',
            option: {
              '显示': '1',
              '不显示': '0'
            }
          },
          {
            box_type: 'select',
            name: 'page',
            option: {
              'index': 'index',
              'view': 'view'
            }
          },
          {
            box_type: 'input',
            name: 'weight',
            type: 'text'
          }
        ],

        update_info: {
          title: '编辑',
          action: '/admin/banner',
          method: 'put'
        },
        add_info: {
          title: '添加',
          action: '/admin/banner',
          method: 'post'
        },
        delete_info: {
          url: '/admin/banner',
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