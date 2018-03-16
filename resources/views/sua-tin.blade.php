<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/css/fontawesome-all.min.css')}}">
    {{--  <link rel="stylesheet" href="{{asset('plugin/css/ckeditor.css')}}">  --}}
    
</head>
<body>
    <div class="container">
        <form action="">
            <input type="text" name="tin-tieu-de" class="form-control" value="{{$tin->tin_tieu_de}}">
            <textarea name="tin-noi-dung" id="tin-noi-dung" rows="10" cols="400">{{$tin->tin_noi_dung}}</textarea>
        </form>
    </div>



    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('plugin/js/fontawesome-all.min.js')}}"></script>
    <script src="{{asset('plugin/ckeditor/ckeditor.js')}}"></script>
    
    <script>
        CKEDITOR.replace( 'tin-noi-dung' );
    </script>
    
</body>
</html>