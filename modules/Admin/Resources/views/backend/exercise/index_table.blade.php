<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Backend</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="shortcut icon" href="favicon.ico">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="/css/backend.css">
    <link href="{{asset('vendor/sweetalert/sweetalert.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="/css/backend-tables.css">
    <link rel="stylesheet" href="/vendor/bootstrap-wysihtml/bootstrap3-wysihtml5.css">
    <style>

        body {
            font-family: "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
        }

        h1,h2,h3,h4,h5 {
            font-family: "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
        }

    </style>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition sidebar-mini skin-blue-light">
<div class="wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">列表</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding" style="overflow: auto">
                            <table class="table table-bordered table-hover table-striped table-responsive">
                                <thead style="word-break: keep-all">
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>问题类型</th>
                                    <th>选择类型</th>
                                    <th>问题</th>
                                    <th>选项数</th>
                                    <th>答案</th>
                                    <th>解析</th>
                                </tr>
                                </thead>

                                <tbody id="layerCtrlTableList">
                                @if($lists)
                                    @foreach($lists as $list)
                                        <tr>
                                            <td>
                                                <input data-form="check-model" type="checkbox" name="selection[]" value="{{ $list->id }}"/>
                                            </td>
                                            <td>{{$list->type($list->type)}}</td>
                                            <td>{{$list->check_type($list->check_type)}}</td>
                                            <td>{{$list->question}}</td>
                                            <td>{{count(unserialize($list->option))}}</td>
                                            <td>@if($list->type != 2){{$list->answer}}@endif</td>
                                            <td>{{$list->resolve}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <button class="btn btn-sm btn-default" data-btn="layerCtrlParentCancel">取消</button>
                            <button class="btn btn-sm btn-info" data-btn="layerCtrlParent">添加</button>
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>

        </section><!-- /.content -->
</div><!-- ./wrapper -->

<script src="/js/backend.js"></script>
<script src="{{asset('vendor/sweetalert/sweetalert.min.js')}}" ></script>
<script src="{{asset('vendor/layer/layer.js')}}" ></script>
<script src="{{asset('js/jquery-common-mime-fun.js')}}"></script>
<script>
    $(function () {
        var ids_name = 'exercise_ids';
        /*题库添加试题，完成后关闭窗口*/
        $('[data-btn="layerCtrlParent"]').on('click',function() {
            var check = $('#layerCtrlTableList').find('input[name="selection[]"]');
            var parentHtml = parent.$('#tableListBody');
            var parentLastNum = $(parentHtml.html()).length;
            if('' == parentHtml || undefined == parentHtml){
                parentLastNum = 0;
            }
            var html = '';
            for(var i =0; i < check.length; i++){
                if(check[i].checked == true){
                    parentLastNum++;
                    var tdHtml = $(check[i]).parent().next();
                    html += '<tr data-key="' + parentLastNum + '">';
                    html += '    <td>' + parentLastNum + '</td>';
                    html += '    <td>' + tdHtml.html() + '<input type="hidden" name="'+ids_name+'[]" value="' + $(check[i]).val() + '"></td>';
                    html += '    <td>' + tdHtml.next().next().html() + '</td>';
                    html += '    <td>' + tdHtml.next().next().next().html() + '</td>';
                    html += '    <td>' + tdHtml.next().next().next().next().html() + '</td>';
                    html += '    <td>';
                    html += '        <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>';
                    html += '    </td>';
                    html += '</tr>';
                }
            }
            if('' == html){
                swal('未选择','请勾选需要操作的信息');
                return false;
            }
            parentHtml.append(html);
            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
            parent.layer.close(index);
        });

        /*题库取消添加试题，关闭窗口*/
        $('[data-btn="layerCtrlParentCancel"]').on('click',function() {
            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
            parent.layer.close(index);
        });
    });
</script>
</body>
</html>


