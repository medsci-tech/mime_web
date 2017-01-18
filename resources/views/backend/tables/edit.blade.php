<div v-cloak class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">@{{ form_info.title }}</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="@{{ form_info.action }}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input v-if=" form_info.method == 'put' " type="hidden" name="_method" value="put"/>
          <div v-for="data in modal_data">
            <div v-if="data.box_type == 'input' && data.name != 'id'" class="form-group">
              <label for="@{{ data.name }}" class="col-sm-2 control-label">@{{ data.title }}</label>
              <div class="col-sm-10">
                <input type="@{{ data.type }}" required class="form-control" name="@{{ data.name }}" id="@{{ data.name }}" v-model="data.value" placeholder="@{{ data.value }}">
                <div v-if="is_img(data.value)">
                  <img class="img-responsive" :src="data.value" alt="">
                </div>
              </div>
            </div>
            <div v-if="data.box_type == 'textarea'" class="form-group">
              <label for="@{{ data.name }}" class="col-sm-2 control-label">@{{ data.title }}</label>
              <div class="col-sm-10">
                <textarea style="resize: none;min-height: 160px" required class="form-control wysihtml5-editor" name="@{{ data.name }}" id="@{{ data.name }}">@{{ data.value }}</textarea>
              </div>
            </div>
            <div v-if="data.box_type == 'select'" class="form-group">
              <label for="@{{ data.name }}" class="col-sm-2 control-label">@{{ data.title }}</label>
              <div class="col-sm-10">
                <select required class="form-control" name="@{{ data.name }}" id="@{{ data.name }}" v-model="data.value">
                  <option v-for="(key, value) in data.option" value="@{{ value }}">@{{ key }}</option>
                </select>
              </div>
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

