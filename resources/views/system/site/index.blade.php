@extends('system.site.table')

@section('title', '系统配置-站点管理')
@section('box_title','列表')

@section('tables_data')
    <script>
        var data = {
            table_head: [
                'id',
                '名称',
                '链接',
                '状态'
            ],
            table_data: [
                @foreach($lists as $list)
                [
                    '{{$list->id}}',
                    '{{$list->name}}',
                    '{{$list->link}}',
                    '{{$list->status}}'
                ],
                @endforeach
            ],
            pagination: '{{$lists->render()}}',
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
                    name: 'link',
                    type: 'text'
                },
                {
                    box_type: 'select',
                    name: 'status',
                    option: {
                        1:'启用',
                        0:'禁用'
                    }
                }
            ],

            update_info: {
                title: '编辑',
                action: '{{route('system.site.index')}}',
                method: 'put'
            },
            add_info: {
                title: '添加',
                action: '{{route('system.site.index')}}',
                method: 'post'
            },
            delete_info: {
                url: '{{route('system.site.index')}}',
                method: 'delete'
            },

            form_info: {
                title: '编辑',
                action: '',
                method: 'post'
            },
            alert:alert
        }

    </script>
@endsection