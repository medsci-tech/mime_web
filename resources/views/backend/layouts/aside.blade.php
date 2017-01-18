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
          <li><a href="{{ url('/system/site') }}"><i class="fa fa-circle-o"></i>站点管理</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-dashboard"></i>
          <span>公开课管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/admin/thyroid') }}"><i class="fa fa-circle-o"></i>公课信息</a></li>
          <li><a href="{{ url('/admin/teacher') }}"><i class="fa fa-circle-o"></i>老师信息</a></li>
          <li><a href="{{ url('/admin/phase') }}"><i class="fa fa-circle-o"></i>单元信息</a></li>
          <li><a href="{{ url('/admin/course') }}"><i class="fa fa-circle-o"></i>课程信息</a></li>
          <li><a href="{{ url('/admin/banner') }}"><i class="fa fa-circle-o"></i>Banner</a></li>
          <li><a href="{{ url('/newback/exercise') }}"><i class="fa fa-circle-o"></i>试题管理</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-book"></i>
          <span>学生管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/admin/student') }}"><i class="fa fa-circle-o"></i>学生信息</a></li>
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-pie-chart"></i>
          <span>学员统计</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/admin/statistic/area-map') }}"><i class="fa fa-circle-o"></i>用户分布</a></li>
          <li><a href="{{ url('/admin/statistic/province-map') }}"><i class="fa fa-circle-o"></i>地区分布</a></li>
          <li><a href="{{ url('/admin/statistic/register-bar') }}"><i class="fa fa-circle-o"></i>注册统计</a></li>
          {{--<li><a href="{{ url('/charts/map') }}"><i class="fa fa-circle-o"></i>地图</a></li>--}}
          {{--<li><a href="{{ url('/charts/map2') }}"><i class="fa fa-circle-o"></i>地图2</a></li>--}}
          {{--<li><a href="{{ url('/charts/pie') }}"><i class="fa fa-circle-o"></i>饼图</a></li>--}}
          {{--<li><a href="{{ url('/charts/polar') }}"><i class="fa fa-circle-o"></i>极坐标图</a></li>--}}
        </ul>
      </li>
      <li class="active treeview">
        <a href="{{url('#')}}">
          <i class="fa fa-pie-chart"></i>
          <span>课程统计</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open">
          <li><a href="{{ url('/admin/statistic/class-pie') }}"><i class="fa fa-circle-o"></i>课程统计</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>