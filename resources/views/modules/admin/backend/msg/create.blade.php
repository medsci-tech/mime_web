<div class="modal" id="modal-edit" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">站内消息</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="form-validate-submit" action="{{url('/msg/set_all')}}" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label class="col-sm-2 control-label">消息类型</label>
            <div class="col-sm-10">
              <select class="form-control" id="form-type" name="msg_type">
                <option>-请选择-</option>
                @foreach(config('params')['msg_type_option'] as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group" id="form-site" style="display: none;">
            <label class="col-sm-2 control-label">站点</label>
            <div class="col-sm-10">
              <select class="form-control" name="site_id">
                @foreach($sites as $site)
                  <option value="{{$site->id}}">{{$site->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group" id="form-phone" style="display: none;">
            <label class="col-sm-2 control-label">手机号</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="phones" placeholder="多个请用,分隔">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">内容</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="content" required style="resize:vertical"></textarea>
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

