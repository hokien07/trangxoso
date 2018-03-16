<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/css/sb-admin-2.min.css')}}">

    <!-- MetisMenu CSS -->
    <link href="{{asset('plugin/css/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugin/css/dataTables.r    esponsive.css')}}" rel="stylesheet">
    <link href="{{asset('plugin/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">

</head>

<body>


        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
               
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <li><a href="#"> thoát </a></li>
                
            </ul>
    
        </nav>
<div class="container">
     
        <div class="panel panel-default">
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Rút gọn</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($tin_tuc as $tin)
                        <tr class="tin-{{$tin->id_tin}}">
                            <td><a href="{{route('xem-tin', $tin->id_tin)}}"><img src="{{$tin->link_hinh_anh}}" alt="" width="100" height="100"></a></td>
                            <td>{{$tin->tin_tieu_de}}</td>
                            <td>{{$tin->tin_rut_gon}}</td>
                            <td style="width: 150px;">
                                <a style="width: 50%; float:left;" class="btn btn-primary" href="{{route('sua-tin', $tin->id_tin)}}">sửa</a> 
                                <form action="{{route('xoa-tin', $tin->id_tin)}}" method="POST"> 
                                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                    <button class="btn btn-warning" style="width: 48%; float:right;">xóa</button>
                                </form>
                            </td>
                        </tr>

                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
               
                


    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('plugin/js/fontawesome-all.min.js')}}"></script>
    <script src="{{asset('plugin/js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset('plugin/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('plugin/js/dataTables.bootstrap.min.js')}}"></script>

</body>

</html>
