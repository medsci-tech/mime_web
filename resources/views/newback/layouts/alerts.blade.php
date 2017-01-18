@if(Session::has('alert'))
    <div class="alert alert-{{Session::get("alert")['type']}} alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i>{{ Session::get("alert")['title']}}</h4>
        @if(Session::has('alert')['message'])
        {{ Session::get("alert")['message']}}
        @endif
  </div>
@endif