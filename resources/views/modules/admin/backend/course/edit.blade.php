<div class="modal" id="modal-edit" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">课程管理</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="{{url('/course')}}?site_id={{$_GET['site_id'] ?? ''}}" method="post">
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
            <label class="col-sm-2 control-label">课程类别</label>
            <div class="col-sm-10">
              <select class="form-control" name="course_class_id" id="form-course_class_id">
                <option value="0">请选择课程类别</option>
                @foreach($course_classes as $course_class)
                  <option value="{{$course_class->id}}" data-has_teacher="{{$course_class->has_teacher}}" data-has_phase="{{$course_class->has_children}}">{{$course_class->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group" id="teacher_id_parentDiv">
            <label class="col-sm-2 control-label">讲师</label>
            <div class="col-sm-10">
              <select class="form-control" name="teacher_id" id="form-teacher_id">
                <option value="0">-请选择-</option>
                @foreach($teachers as $teacher)
                  <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group" id="phase_id_parentDiv">
            <label class="col-sm-2 control-label">所属单元</label>
            <div class="col-sm-10">
              <select class="form-control" name="thyroid_class_phase_id" id="form-thyroid_class_phase_id">
                <option value="0">-请选择-</option>
                @foreach($phases as $phase)
                  <option value="{{$phase->id}}">{{$phase->title}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group" id="course_type_parentDiv">
            <label class="col-sm-2 control-label">课程类型</label>
            <div class="col-sm-10">
              <select class="form-control" name="course_type" id="form_course_type">
                <option value="0">请选择课程类型</option>
                @foreach(config('params')['curse_type'] as $k => $v)
                <option value="{{$k}}">{{$v}}</option>
                @endforeach
              </select>
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
            <label class="col-sm-2 control-label">关键词</label>
            <div class="col-sm-10">
              <select class="form-control" name="keyword_id[]" id="form-keyword_id" multiple="multiple" data-placeholder="请选择关键词">
                @foreach($keywords as $keyword)
                  <option value="{{$keyword['id']}}">{{$keyword['name']}}</option>
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
            <label class="col-sm-2 control-label">缩略图</label>
            <div class="col-sm-10">
              <input type="text" required class="form-control" name="logo_url" id="form-logo_url" placeholder="">
              <div id="form-logo_url_html"></div>
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
          <div class="form-group">
            <label class="col-sm-2 control-label">描述</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="comment" id="form-comment"  style="resize:vertical"></textarea>
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

