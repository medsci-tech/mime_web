@extends('/layouts/app')

@section('title','503 Be right back')

@section('content-header')
  <h1>
    503 Be right back
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">503 error</li>
  </ol>
@endsection

@section('content')
  <div class="error-page">
    <h2 class="headline text-aqua">503</h2>
    <div class="error-content">
      <h3><i class="fa fa-warning text-aqua"></i> Oops! Be right back.</h3>
      <p>
        We will be right back.
        Meanwhile, you may <a href="{{url('/')}}">return to dashboard</a> or try using the search form.
      </p>
      <form class="search-form">
        <div class="input-group">
          <input type="text" disabled name="search" class="form-control" placeholder="Search">
          <div class="input-group-btn">
            <button type="submit" name="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
          </div>
        </div><!-- /.input-group -->
      </form>
    </div>
  </div><!-- /.error-page -->

@endsection
