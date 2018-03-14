@extends('master')

@section('title', 'xoso.me')
@section('date', '')

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
    
{!!$tin_content->tin_noi_dung!!}



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

