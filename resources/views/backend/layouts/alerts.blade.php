<div v-cloak>
  <div v-show="alert.type == 'danger'" class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i>@{{ alert.title }}</h4>
    @{{ alert.message }}
  </div>
  <div v-show="alert.type == 'info'" class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i>@{{ alert.title }}</h4>
    @{{ alert.message }}
  </div>
  <div v-show="alert.type == 'warning'" class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i>@{{ alert.title }}</h4>
    @{{ alert.message }}
  </div>
  <div v-show="alert.type == 'success'" class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i>@{{ alert.title }}</h4>
    @{{ alert.message }}
  </div>
</div>