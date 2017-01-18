@extends('/layouts/app')

@section('title','404 Page not found')

@section('content-header')
      <h1>
        404 Error Page
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>主页</a></li>
        <li class="active">404 error</li>
      </ol>
@endsection

@section('content')
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a
              href="{{url('/')}}">return to dashboard</a> or try using the search form.
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" disabled name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div><!-- /.input-group -->
          </form>
        </div><!-- /.error-content -->
      </div><!-- /.error-page -->
@endsection
