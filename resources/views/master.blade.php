<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>App name -- @yield('title')</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @section('sidebar-left')

            @show
        </div>


        <div class="col-md-6">
            @yield('content')

        </div>

        <div class="col-md-3">

            @section('sidebar-right')

            @show
        </div>

    </div>
</div>





</body>
</html>