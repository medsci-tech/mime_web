<div class="modal" id="modal-edit" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">编辑</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="{{url('/private-class/save')}}?site_id={{$_GET['site_id'] ?? ''}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" id="form-id" value="">
          <div class="form-group">
            <label class="col-sm-2 control-label">期数</label>
            <div class="col-sm-10">
              <input class="form-control" disabled id="form-term">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">医生</label>
            <div class="col-sm-10">
              <input class="form-control" disabled id="form-doctor">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">讲师</label>
            <div class="col-sm-10">
              <input class="form-control" disabled id="form-teacher">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">预约时间</label>
            <div class="col-sm-10">
              <input class="form-control" id="form-bespoke_at" type="date" name="bespoke_at">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
              <select class="form-control" name="status" id="form-status">
                @foreach(config('params')['private_class_status_option'] as $key => $val)
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

