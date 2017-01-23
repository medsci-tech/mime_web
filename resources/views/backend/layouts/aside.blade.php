<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">mime</li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-dashboard"></i>
          <span>公共管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/newback/site') }}"><i class="fa fa-circle-o"></i>站点管理</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-dashboard"></i>
          <span>课程管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/admin/thyroid') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>课程介绍</a></li>
          <li><a href="{{ url('/admin/phase') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>单元信息</a></li>
          <li><a href="{{ url('/admin/course') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>课程信息</a></li>
          <li><a href="{{ url('/admin/banner') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>Banner</a></li>
        </ul>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>