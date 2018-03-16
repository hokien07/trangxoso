@extends('master')

@section('title', 'xoso.me')
@section('date', 'xoso.me')

@section('sidebar-left')
    @parent
    <div class="block-xoso">
        <h2 class="xoso-title">XỔ SỐ MIỀN BẮC</h2>
        <ul class="list-group">

            @foreach($ten_tinhs[0] as $key=>$ten_tinh)
                <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}"
                   class="list-group-item list-group-item-action "><i
                            class="fa fa-angle-double-right"></i> {{$ten_tinh->ten_tinh}}</a>
            @endforeach
        </ul>
    </div>

    <div class="block-xoso">
        <h2 class="xoso-title">XỔ SỐ ĐIỆN TOÁN</h2>
        <ul class="list-group">
            @foreach($ten_tinhs[1] as $ten_tinh)
                <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}"
                   class="list-group-item list-group-item-action "><i
                            class="fa fa-angle-double-right"></i> {{$ten_tinh->ten_tinh}}</a>
            @endforeach
        </ul>
    </div>

    <div class="block-xoso">
        <h2 class="xoso-title">XỔ SỐ MIỀN NAM</h2>
        <ul class="list-group">
            @foreach($ten_tinhs[3] as $ten_tinh)
                <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}"
                   class="list-group-item list-group-item-action "><i
                            class="fa fa-angle-double-right"></i> {{$ten_tinh->ten_tinh}}</a>
            @endforeach
        </ul>
    </div>


    <div class="block-xoso">
        <h2 class="xoso-title">XỔ SỐ MIỀN TRUNG</h2>
        <ul class="list-group">
            @foreach($ten_tinhs[2] as $ten_tinh)
                <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}"
                   class="list-group-item list-group-item-action "><i
                            class="fa fa-angle-double-right"></i> {{$ten_tinh->ten_tinh}}</a>
            @endforeach
        </ul>
    </div>

@endsection

@section('content')

    <div class="container">
        <form class="form-horizontal" action="{{route('dang-nhap')}}" method="POST">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <fieldset>
                <div id="legend">
                    <legend class="">Đăng nhập vào Admin page.</legend>
                    @if (\Session::has('error'))
                        <div class="alert alert-danger">
                            {!! \Session::get('error') !!}                        
                        </div>
                    @endif

                    @if (\Session::has('mes'))
                        <div class="alert alert-success">
                            {!! \Session::get('mes') !!}                        
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="control-group">
                            <!-- Username -->
                            <label class="control-label" for="username">tên đăng nhập</label>
                            <div class="controls">
                                <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                                <p class="help-block">Tên đăng nhập</p>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6">
                        <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Mật khẩu</label>
                            <div class="controls">
                                <input type="password" id="password" name="password" placeholder=""
                                       class="input-xlarge">
                                <p class="help-block">Mật khẩu phải lớn hơn 6 ký tự</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{route('dang-ky')}}">Tạo tài khoản.</a>


                    <div class="col-md-12">
                        <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                                <button class="btn btn-success">Đăng nhập</button>
                            </div>
                        </div>
                    </div>
                </div>


            </fieldset>
        </form>
    </div>


@endsection

@section('sidebar-right')
    @parent
    <div class="block-xoso">
        <h2 class="xoso-title">TIN MỚI NHẤT</h2>
        <ul class="list-group">
            @foreach ($tin_moi as $tin)
                <li class="list-group-item">
                    <a href="{{route('xem-tin', $tin->id_tin)}}">
                        <img src="{{$tin->link_hinh_anh}}" alt="" class="rounded float-left" width="60px" height="60px">
                    </a>
                    <p>{{$tin->tin_tieu_de}}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="block-xoso">
        <h2 class="xoso-title">THỐNG KÊ KẾT QUẢ XỔ SỐ</h2>
        <ul class="list-group">
            <li class="list-group-item"><i class="fa fa-angle-double-right"></i> Cras justo odio</li>
            <li class="list-group-item"><i class="fa fa-angle-double-right"></i> Cras justo odio</li>
            <li class="list-group-item"><i class="fa fa-angle-double-right"></i> Cras justo odio</li>
            <li class="list-group-item"><i class="fa fa-angle-double-right"></i> Cras justo odio</li>
            <li class="list-group-item"><i class="fa fa-angle-double-right"></i> Cras justo odio</li>
        </ul>
    </div>

@endsection

