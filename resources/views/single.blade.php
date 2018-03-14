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
    @switch($ket_qua[0]->tinh_vung)
        @case(0)


        @foreach($ket_qua as $key=>$kq)
            <h1 class="title-box"> xổ số miền bắc - ngày: {{ date("d-m-Y", strtotime($kq->ngay_mo_thuong))}}</h1>

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

        @endforeach

        @break

        @case(1)
        @foreach($ket_qua as $key=>$kq)
            <h1 class="title-box"> Kết quả điện toán - ngày: {{ date("d-m-Y", strtotime($kq->ngay_mo_thuong))}}</h1>
            <div class="ket-qua-dien-toan">
                @if($kq->dac_biet != '')
                    @foreach(explode(',', $kq->dac_biet) as $dac_biet)
                        <span>{{ $dac_biet}}</span>
                    @endforeach
                @endif
            </div>
        @endforeach
        @break

        @case(2)

        @foreach($ket_qua as $key=>$kq)
            <h1 class="title-box"> Xổ số miền trung - nngày: {{ date("d-m-Y", strtotime($kq->ngay_mo_thuong))}}</h1>

            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <td class="txt-giai">giải tám</td>
                    <td colspan="12" class="number">{{$kq->giai_tam}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">Giải bảy</td>
                    <td colspan="12" class="number">{{$kq->giai_bay }}</td>
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
                    <td class="txt-giai">Giải năm</td>
                    <td colspan="12" class="number">{{$kq->giai_nam }}</td>
                </tr>

                <tr>
                    <td rowspan="2" class="txt-giai">Giải bốn</td>
                    @if($kq->giai_bon != '')
                        @foreach(explode(',', $kq->giai_bon) as $key =>$giai_bon)
                            @if( $key < 4)
                                <td colspan="3" class="number">{{ $giai_bon}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    @if($kq->giai_bon != '')
                        @foreach(explode(',', $kq->giai_bon) as $key =>$giai_bon)
                            @if( $key >= 4)
                                <td colspan="4" class="number">{{ $giai_bon}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td class="txt-giai">Giải ba</td>
                    @if($kq->giai_ba != '')
                        @foreach(explode(',', $kq->giai_ba) as $giai_ba)
                            <td colspan="6" class="number">{{ $giai_ba}}</td>
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td class="txt-giai">Giải nhì</td>
                    <td colspan="12" class="number">{{$kq->giai_nhi }}</td>
                </tr>


                <tr>
                    <td class="txt-giai">Giải nhất</td>
                    <td colspan="12" class="number">{{$kq->giai_nhat}}</td>
                </tr>


                <tr>
                    <td class="txt-giai dac-biet">Đặc biệt</td>
                    <td colspan="12" class="number dac-biet">{{$kq->dac_biet }}</td>
                </tr>
                </tbody>
            </table>

        @endforeach
        @break
        @case(3)
        @foreach($ket_qua as $key=>$kq)
            <h1 class="title-box"> Xổ số miền nam - ngày: {{ date("d-m-Y", strtotime($kq->ngay_mo_thuong))}}</h1>

            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <td class="txt-giai">giải tám</td>
                    <td colspan="12" class="number">{{$kq->giai_tam}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">Giải bảy</td>
                    <td colspan="12" class="number">{{$kq->giai_bay }}</td>
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
                    <td class="txt-giai">Giải năm</td>
                    <td colspan="12" class="number">{{$kq->giai_nam }}</td>
                </tr>

                <tr>
                    <td rowspan="2" class="txt-giai">Giải bốn</td>
                    @if($kq->giai_bon != '')
                        @foreach(explode(',', $kq->giai_bon) as $key =>$giai_bon)
                            @if( $key < 4)
                                <td colspan="3" class="number">{{ $giai_bon}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    @if($kq->giai_bon != '')
                        @foreach(explode(',', $kq->giai_bon) as $key =>$giai_bon)
                            @if( $key >= 4)
                                <td colspan="4" class="number">{{ $giai_bon}}</td>
                            @endif
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td class="txt-giai">Giải ba</td>
                    @if($kq->giai_ba != '')
                        @foreach(explode(',', $kq->giai_ba) as $giai_ba)
                            <td colspan="6" class="number">{{ $giai_ba}}</td>
                        @endforeach
                    @endif
                </tr>

                <tr>
                    <td class="txt-giai">Giải nhì</td>
                    <td colspan="12" class="number">{{$kq->giai_nhi }}</td>
                </tr>


                <tr>
                    <td class="txt-giai">Giải nhất</td>
                    <td colspan="12" class="number">{{$kq->giai_nhat}}</td>
                </tr>


                <tr>
                    <td class="txt-giai dac-biet">Đặc biệt</td>
                    <td colspan="12" class="number dac-biet">{{$kq->dac_biet }}</td>
                </tr>
                </tbody>
            </table>

        @endforeach
        @break
    @endswitch



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

