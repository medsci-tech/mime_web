@extends('/layouts/app')

@section('title','500 Error')

@section('content-header')
  <h1>
    500 Error Page
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>主页</a></li>
    <li class="active">500 error</li>
  </ol>
@endsection

@section('content')
  <div class="error-page">
    <h2 class="headline text-red">500</h2>
    <div class="error-content">
      <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
      <p>
        We will work on fixing that {{url('/')}}">return to dashboard</a> or try using the search form.
      </p>
      <form class="search-form">
        <div class="input-group">
          <input type="text" disabled name="search" class="form-control" placeholder="Search">
          <div class="input-group-btn">
            <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
          </div>
        </div><!-- /.input-group -->
      </form>
    </div>
  </div><!-- /.error-page -->
@endsection