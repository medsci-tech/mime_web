@extends('backend.layouts.app')

@section('title','charts')

@section('css')
  <link rel="stylesheet" href="/css/backend-charts.css">

@endsection

@section('content')
  <div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
      @include('backend.layouts.alerts')
      <h1>
        @yield('title')
      </h1>
      {{--<ol class="breadcrumb">--}}
      {{--<li><a href="#"><i class="fa fa-dashboard"></i>主页</a></li>--}}
      {{--<li class="active">列表</li>--}}
      {{--</ol>--}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">@yield('box_title')</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="overflow: auto">

                <echart></echart>

            </div><!-- /.box-body -->

          </div><!-- /.box -->
        </div><!-- /.col -->
      </div>

      <!-- Modal -->

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

@section('js')
  <script src="/js/backend-charts.js"></script>

  @yield('charts_data')

  <script>
    new Vue({
      el: 'body',
      data: {
        alert:alert
      }
    });

    {{--$("a[href$={{ \Session::get('currentUrl') }}]").parent().addClass('active');--}}
  </script>
@endsection