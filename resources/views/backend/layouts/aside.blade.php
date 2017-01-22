<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">mime</li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-dashboard"></i>
          <span>系统配置</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/newback/site') }}"><i class="fa fa-circle-o"></i>站点管理</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-dashboard"></i>
          <span>公开课管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/admin/thyroid') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>公课信息</a></li>
          <li><a href="{{ url('/admin/teacher') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>老师信息</a></li>
          <li><a href="{{ url('/admin/phase') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>单元信息</a></li>
          <li><a href="{{ url('/admin/course') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>课程信息</a></li>
          <li><a href="{{ url('/admin/banner') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>Banner</a></li>
          <li><a href="{{ url('/newback/exercise') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>试题管理</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-book"></i>
          <span>学生管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/admin/student') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>学生信息</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-pie-chart"></i>
          <span>学员统计</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/admin/statistic/area-map') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>用户分布</a></li>
          <li><a href="{{ url('/admin/statistic/province-map') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>地区分布</a></li>
          <li><a href="{{ url('/admin/statistic/register-bar') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>注册统计</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-pie-chart"></i>
          <span>课程统计</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/admin/statistic/class-pie') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>课程统计</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>