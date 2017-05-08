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
          <li><a href="{{ url('/site') }}"><i class="fa fa-circle-o"></i>站点管理</a></li>
        </ul>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/msg/all') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>站点消息</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-dashboard"></i>
          <span>课程管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/thyroid') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>课程介绍</a></li>
          <li><a href="{{ url('/course-class') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>分类信息</a></li>
          <li><a href="{{ url('/phase') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>单元信息</a></li>
          <li><a href="{{ url('/course') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>课程信息</a></li>
          <li><a href="{{ url('/banner') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>Banner</a></li>
          <li><a href="{{ url('/private-class') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>私教课</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-book"></i>
          <span>试题管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/exercise') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>试题信息</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-book"></i>
          <span>讲师管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/teacher') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>讲师信息</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-book"></i>
          <span>学生管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/student') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>学生信息</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-pie-chart"></i>
          <span>学员统计</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/statistic/area-map') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>用户分布</a></li>
          <li><a href="{{ url('/statistic/province-map') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>地区分布</a></li>
          <li><a href="{{ url('/statistic/register-bar') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>注册统计</a></li>
          <li><a href="{{ url('/report') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>报表导出</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-pie-chart"></i>
          <span>课程统计</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/statistic/class-pie') }}?site_id={{$_GET['site_id'] ?? ''}}"><i class="fa fa-circle-o"></i>课程统计</a></li>
        </ul>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>