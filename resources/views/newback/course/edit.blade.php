<div class="modal" id="modal-edit" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">试题管理</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="{{url('/admin/course')}}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" id="form-id" value="">
          <div class="form-group">
            <label class="col-sm-2 control-label">编号</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="sequence" id="form-sequence" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">课程名称</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="title" id="form-title" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">是否显示</label>
            <div class="col-sm-10">
              <select class="form-control" name="is_show" id="form-is_show">
                @foreach(config('params')['status_option'] as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">试题</label>
            <div class="col-sm-10">
              <table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>序号</th>
                  <th>问题类型</th>
                  <th>问题</th>
                  <th>选项数</th>
                  <th>答案</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody id="tableListBody">
                </tbody>
              </table>
              <button id="add-child" type="button" class="btn btn-info btn-sm">添加</button>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">所属单元</label>
            <div class="col-sm-10">
              <select class="form-control" name="thyroid_class_phase_id" id="form-thyroid_class_phase_id">
                <option value="">-请选择-</option>
                @foreach($phases as $phase)
                  <option value="{{$phase->id}}">{{$phase->title}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">缩略图</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="logo_url" id="form-logo_url" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">腾讯云file_id</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="qcloud_file_id" id="form-qcloud_file_id" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">腾讯云app_id</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="qcloud_app_id" id="form-qcloud_app_id" placeholder="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">确认</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

