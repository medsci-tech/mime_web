<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
  <title>@yield('title')</title>

  <link rel="stylesheet" href="/vendor/foundation-6.2.3-complete/css/foundation.min.css">
  <link rel="stylesheet" href="/vendor/font-awesome-4.6.2/css/font-awesome.min.css">
  <link rel="icon" href="/favicon.ico">

  @yield('css')
  <link rel="stylesheet" href="/css/main.css">

</head>

<body id="@yield('page_id')" v-cloak>

@yield('content')

<script src="/vendor/jQuery/jQuery-2.1.4.min.js"></script>
<script src="/vendor/foundation-6.2.3-complete/js/vendor/foundation.min.js"></script>

<script src="/vendor/vuejs/vue.js"></script>

@yield('js')
<script>
  $(document).foundation();
</script>
</body>
</html>