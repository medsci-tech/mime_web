<div v-cloak class="modal" id="modal-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">@{{   }}</h4>
      </div>
      <div class="modal-body no-padding">
        <table class="table table-bordered table-hover table-striped table-responsive" style="margin-bottom: 0;">
          <thead style="word-break: keep-all">
          <tr role="row">
            <th v-for="head in log_head" rowspan="1" colspan="1" style="white-space: nowrap">{{ head }}</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="data in modal_data">
          <td v-for="item in data" track-by="$index">
            <div v-else>
              @{{ item }}
            </div>
          </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
      </div>
    </div>
  </div>
</div>

