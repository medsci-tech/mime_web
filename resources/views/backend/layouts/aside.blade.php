<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">mime</li>
      <li class="active treeview">
        <a href="{{url('/article')}}">
          <i class="fa fa-dashboard"></i>
          <span>公开课</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li><a href="{{ url('/admin/thyroid') }}"><i class="fa fa-circle-o"></i>公课信息</a></li>
          <li><a href="{{ url('/admin/teacher') }}"><i class="fa fa-circle-o"></i>老师信息</a></li>
          <li><a href="{{ url('/admin/phase') }}"><i class="fa fa-circle-o"></i>单元信息</a></li>
          <li><a href="{{ url('/admin/course') }}"><i class="fa fa-circle-o"></i>课程信息</a></li>
          <li><a href="{{ url('/admin/banner') }}"><i class="fa fa-circle-o"></i>Banner</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>