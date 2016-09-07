<div v-cloak  class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">@{{ form_info.title }}</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="@{{ form_info.action }}" method="@{{ form_info.method }}">
          <div v-for="data in modal_data">
            <div v-if="data.box_type == 'input'" class="form-group">
              <label for="@{{ data.name }}" class="col-sm-2 control-label">@{{ data.title }}</label>
              <div class="col-sm-10">
                <input type="@{{ data.type }}" required class="form-control" name="@{{ data.name }}" id="@{{ data.name }}" v-model="data.value" placeholder="@{{ data.value }}">
              </div>
            </div>
            <div v-if="data.box_type == 'textarea'" class="form-group">
              <label for="@{{ data.name }}" class="col-sm-2 control-label">@{{ data.title }}</label>
              <div class="col-sm-10">
                <textarea rows="@{{ data.rows }}" required class="form-control wysihtml5-editor" name="@{{ data.name }}" id="@{{ data.name }}" v-model="data.value" placeholder="@{{ data.value }}">
                </textarea>
              </div>
            </div>
            <div v-if="data.box_type == 'select'" class="form-group">
              <label for="@{{ data.name }}" class="col-sm-2 control-label">@{{ data.title }}</label>
              <div class="col-sm-10">
                <select required class="form-control" name="@{{ data.name }}" id="@{{ data.name }}" v-model="data.value">
                  <option v-for="option in data.option" value="@{{ option }}">@{{ option }}</option>
                </select>
              </div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ȡ��</button>
        <button type="submit" class="btn btn-primary">ȷ���޸�</button>
      </div>
    </div>
  </div>
</div>

