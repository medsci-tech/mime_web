<div class="modal" id="modal-edit" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">试题管理</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="{{url('newback/exercise')}}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" id="form-id" value="">
          <div class="form-group">
            <label class="col-sm-2 control-label">所属课程</label>
            <div class="col-sm-10">
              <select class="form-control" name="check_type" id="form-check_type">
                @foreach(config('params')['exercise']['check_type'] as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">类型</label>
            <div class="col-sm-10">
              <select class="form-control" name="type" id="form-type">
                @foreach(config('params')['exercise']['type'] as $key => $val)
                  <option value="{{$key}}">{{$val}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">问题</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="question" id="form-question" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">选项答案</label>
            <div class="col-sm-10">
              <table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>选项</th>
                  <th>答案</th>
                  <th>是否正确</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody id="optionListBody">
                <tr data-key="1">
                  <td>A</td>
                  <td><input type="text" class="form-control" name="option[A]" value=""></td>
                  <td><input type="radio" class="checkValue" name="answer[]" value="A"></td>
                  <td>
                    <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>
                  </td>
                </tr>
                <tr data-key="2">
                  <td>B</td>
                  <td><input type="text" class="form-control" name="option[B]" value=""></td>
                  <td><input type="radio" class="checkValue" name="answer[]" value="B"></td>
                  <td>
                    <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>
                  </td>
                </tr>
                <tr data-key="3">
                  <td>C</td>
                  <td><input type="text" class="form-control" name="option[C]" value=""></td>
                  <td><input type="radio" class="checkValue" name="answer[]" value="C"></td>
                  <td>
                    <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>
                  </td>
                </tr>
                <tr data-key="4">
                  <td>D</td>
                  <td><input type="text" class="form-control" name="option[D]" value=""></td>
                  <td><input type="radio" class="checkValue" name="answer[]" value="D"></td>
                  <td>
                    <a href="javascript:void(0);" class="delThisOption"><span class="glyphicon glyphicon-minus-sign"></span></a>
                    <a href="javascript:void(0);" class="addNextOption"><span class="glyphicon glyphicon-plus-sign"></span></a>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">解析</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="resolve" id="form-resolve"  style="resize:vertical"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">状态</label>
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

