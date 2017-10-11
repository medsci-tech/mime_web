@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_lessons.css')}}" />
@endsection
    @section('user_container')

        <div class="admin_content">
            <h3 class="admin_title">我推荐的人</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>手机号</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>{{ $doctor->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
            {!! $doctors->render() !!}
        </div>

@endsection