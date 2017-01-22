<div class="modal" id="modal-edit" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">试题管理</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="{{url('/newback/site')}}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" id="form-id" value="">
          <div class="form-group">
            <label class="col-sm-2 control-label">站点名称</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="name" id="form-name" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">站点状态</label>
            <div class="col-sm-10">
              <select class="form-control" name="status" id="form-status">
                @foreach(config('params')['status_option'] as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                @endforeach
              </select>
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

