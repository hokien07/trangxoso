@extends('master')

@section('title', 'xoso.me')
@section('date', 'xoso.me')

@section('sidebar-left')
    @parent
        <div class="block-xoso">
            <h2 class="xoso-title">XỔ SỐ MIỀN BẮC</h2>
            <ul class="list-group">

                @foreach($ten_tinhs[0] as $key=>$ten_tinh)
                    <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i> {{$ten_tinh->ten_tinh}}</a>
                @endforeach
            </ul>
        </div>

        <div class="block-xoso">
            <h2 class="xoso-title">XỔ SỐ ĐIỆN TOÁN</h2>
            <ul class="list-group">
                @foreach($ten_tinhs[1] as $ten_tinh)
                    <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i> {{$ten_tinh->ten_tinh}}</a>
                @endforeach
            </ul>
        </div>

        <div class="block-xoso">
            <h2 class="xoso-title">XỔ SỐ MIỀN NAM</h2>
            <ul class="list-group">
                @foreach($ten_tinhs[3] as $ten_tinh)
                    <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i>  {{$ten_tinh->ten_tinh}}</a>
                @endforeach
            </ul>
        </div>


        <div class="block-xoso">
            <h2 class="xoso-title">XỔ SỐ MIỀN TRUNG</h2>
            <ul class="list-group">
                @foreach($ten_tinhs[2] as $ten_tinh)
                    <a href="{{route('ket-qua', [$ten_tinh->id_tinh, $ten_tinh->tinh_vung])}}" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i> {{$ten_tinh->ten_tinh}}</a>
                @endforeach
            </ul>
        </div>

@endsection

@section('content')
    <div id="content">
        <div class="border check-ngay">
            <p class="text-center">{{$ngay}}</p>
        </div>
        <div class="link-ads">
            <a href="">
                <span>
                    <img src="{{asset('images/hot.gif')}}" alt="soi cau chuan">
                </span>
                <b></b>
            </a>
        </div>
        {{--end link ads--}}

        <div class="box open-day-gif">
            <h2 class="title-box">Các tỉnh mở thưởng hôm nay</h2>
            <table class="table">
                <tbody>
                <tr>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div>
        {{--end open-day-gif--}}

        <div class="box">
            <h2 class="title-box">Xổ số miền Bắc  ngày: {{ date("d-m-Y", strtotime($kq->ngay_mo_thuong))}}</h2>
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <td class="txt-giai dac-biet">Đặc biệt</td>
                    <td colspan="12" class="number dac-biet">{{$kq->dac_biet}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">Giải nhất</td>
                    <td colspan="12" class="number">{{$kq->giai_nhat}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">Giải nhì</td>
                    @if($kq->giai_nhi != '')
                        @foreach(explode(',', $kq->giai_nhi) as $giai_nhi)
                            <td colspan="6" class="number">{{ $giai_nhi}}</td>
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td rowspan="2" class="txt-giai">Giải ba</td>
                    @if($kq->giai_ba != '')
                        @foreach(explode(',', $kq->giai_ba) as $key =>$giai_ba)
                            @if( $key < 3)
                                <td colspan="4" class="number">{{ $giai_ba}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    @if($kq->giai_ba != '')
                        @foreach(explode(',', $kq->giai_ba) as $key =>$giai_ba)
                            @if( $key >= 3)
                                <td colspan="4" class="number">{{ $giai_ba}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td class="txt-giai">Giải tư</td>
                    @if($kq->giai_bon != '')
                        @foreach(explode(',', $kq->giai_bon) as $giai_bon)
                            <td colspan="3" class="number">{{ $giai_bon}}</td>
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td rowspan="2" class="txt-giai">Giải năm</td>
                    @if($kq->giai_nam != '')
                        @foreach(explode(',', $kq->giai_nam) as $key =>$giai_nam)
                            @if( $key < 3)
                                <td colspan="4" class="number">{{ $giai_nam}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    @if($kq->giai_nam != '')
                        @foreach(explode(',', $kq->giai_nam) as $key =>$giai_nam)
                            @if( $key >= 3)
                                <td colspan="4" class="number">{{ $giai_nam}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td class="txt-giai">Giải sáu</td>
                    @if($kq->giai_sau != '')
                        @foreach(explode(',', $kq->giai_sau) as $giai_sau)
                            <td colspan="4" class="number">{{ $giai_sau}}</td>
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td class="txt-giai">Giải bảy</td>
                    @if($kq->giai_bay != '')
                        @foreach(explode(',', $kq->giai_bay) as $giai_bay)
                            <td colspan="3" class="number">{{ $giai_bay}}</td>
                        @endforeach
                    @endif
                </tr>

                </tbody>
            </table>
        </div>


        <div class="box">
            <h2 class="title-box">XSMN » XSMN thứ 6 » XSMN 23-02-2018 - Xổ số miền Nam</h2>
            <table class="table">
                <tbody>
                <tr>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div> <div class="box">
            <h2 class="title-box">XSMT » XSMT thứ 6 » XSMT 23-02-2018 - Xổ số miền Trung</h2>
            <table class="table">
                <tbody>
                <tr>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr> <tr>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('sidebar-right')
    @@parent
    <div class="block-xoso">
        <h2 class="xoso-title">TIN MỚI NHẤT</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <img src="..." alt="" class="rounded float-left" width="60px" height="60px">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
            </li> <li class="list-group-item">
                <img src="..." alt="" class="rounded float-left" width="60px" height="60px">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
            </li> <li class="list-group-item">
                <img src="..." alt="" class="rounded float-left" width="60px" height="60px">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
            </li> <li class="list-group-item">
                <img src="..." alt="" class="rounded float-left" width="60px" height="60px">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
            </li> <li class="list-group-item">
                <img src="..." alt="" class="rounded float-left" width="60px" height="60px">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
            </li> <li class="list-group-item">
                <img src="..." alt="" class="rounded float-left" width="60px" height="60px">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
            </li>
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

