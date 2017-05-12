@extends('modules.airclass.user.user_common')
@section('css_child')
    <link rel="stylesheet" type="text/css" href="{{asset('airclass/css/admin_private.css')}}" />
@endsection

@section('user_container')
    <div class="admin_content">
        <h3 class="admin_title">私教课</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>预约讲师</th>
                <th>预约时间</th>
                <th>病例</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $list)
            <tr>
                <td>{{$list->teacher->name}}</td>
                <td>{{$list->bespoke_at}}</td>
                <td><a data-toggle="modal" data-target="#myModal" href="javascript:;"
                       data-file_name="{{$list->upload->old_name}}"
                       data-file_url="{{$list->upload->path}}"
                       data-id="{{$list->id}}"
                    >{{$list->upload->old_name}}</a></td>
                <td>{{config('params')['private_class_status_option'][$list->status]}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">病例</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body clearfix" id="file_download">
                    <label class="col-xs-6">hello</label>
                    <a href="javascript:;" class="btn btn-primary pull-right">下载</a>
                </div>
                <div class="modal-footer clearfix" id="file_upload">
                    <form enctype="multipart/form-data">
                        <input type="hidden" name="id">
                        <input class="col-xs-6 text-left file-input" id="file-input" type="button" value="未选择文件">
                        <input class="hidden" type="file" name="file"><!--文件上传-->
                    </form>
                    <button type="button" class="btn btn-primary pull-right" id="submit">上传</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="levelModal" tabindex="-1" role="dialog" aria-labelledby="levelModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body clearfix">
                    <div class="tips_container text-center"><span class="tips">success</span></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function () {
            var file_download = $('#file_download');
            $('[data-toggle="modal"]').click(function () {
                var file_name = $(this).data('file_name');
                var file_url = $(this).data('file_url');
                var id = $(this).data('id');
                file_download.find('label').text(file_name);
                file_download.find('a').attr('href',file_url + '?attname=' + file_name);
                $('input[name="id"]').val(id);
            });
            // 上传操作
            var input_file = $('input[name="file"]');
            var input_file_btn = $('#file-input');
            input_file_btn.click(function () {
                input_file.click();
            });
            input_file.change(function() {
                var val = $(this).val();
                var val_last = val.split('\\').pop();
                if(val){
                    input_file_btn.val(val_last);
                }else {
                    input_file_btn.val('未选择文件');
                }
            });
            // 提交操作
            $('#submit').click(function () {
                var formData = new FormData();
                formData.append('file', input_file[0].files[0]);
                formData.append('id', $('input[name="id"]').val());
                $.ajax({
                    url: '{{url('user/private_class/save')}}',
                    type: 'post',
                    cache: false,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res){
                        if(res.code == 200){
                            $('#myModal').modal('hide');
                            $('#levelModal').modal('show').find('.tips').text(res.msg);
                            setTimeout(function () {
                                window.location.reload();
                            },1000);
                        }else {
                            $('#myModal').modal('hide');
                            $('#levelModal').modal('show').find('.tips').text(res.msg);
                        }
                    },
                    error:function (res) {
                        console.log(res);
                    }
                });
            });
        });
    </script>
@endsection