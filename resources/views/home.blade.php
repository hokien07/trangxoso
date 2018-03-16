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
    <div id="content">
        <div class="border check-ngay">
            <p class="text-center">{{$ngay}}</p>
        </div>
        <div class="link-ads">
            <a href="#">
                <span>
                    <img src="{{asset('images/hot.gif')}}" alt="soi cau chuan">
                </span>
                <b>Lô tô cao cấp</b>
            </a>

            <a href="#">
                <span>
                    <img src="{{asset('images/hot.gif')}}" alt="soi cau chuan">
                </span>
                <b>Soi cầu miền bắc</b>
            </a>

            <a href="#">
                <span>
                    <img src="{{asset('images/hot.gif')}}" alt="soi cau chuan">
                </span>
                <b>Độc thủ lô</b>
            </a>

            <a href="#">
                <span>
                    <img src="{{asset('images/hot.gif')}}" alt="soi cau chuan">
                </span>
                <b>Soi cầu chuẩn</b>
            </a>
        </div>
        {{--end link ads--}}


        <div class="box">
            <h2 class="title-box">Xổ số miền Bắc ngày: {{ date("d-m-Y", strtotime($kq->ngay_mo_thuong))}}</h2>
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
            <div class="control-panel">
                <form action="">
                    <label class="radio" data-value="0">
                        <input type="radio" name="show-digits" value="0">
                    </label>

                    <label class="radio" data-value="2">
                        <input type="radio" name="show-digits" value="2">
                    </label>

                    <label class="radio" data-value="3">
                        <input type="radio" name="show-digits" value="3">
                    </label>
                </form>
            </div>
        </div>


        <div class="box">
            <h2 class="title-box">xổ số miền nam
                ngày: {{ date("d-m-Y", strtotime($mien_nam_first->ngay_mo_thuong))}}</h2>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th scope="col" class="tinh-mien-nam-mo-thuong">{{$mien_nam_first->ten_tinh}}
                        <br/> {{$mien_nam_first->ngay_mo_thuong}}</th>
                    <th scope="col" class="tinh-mien-nam-mo-thuong">{{$mien_nam_second->ten_tinh}}
                        <br/> {{$mien_nam_second->ngay_mo_thuong}}</th>
                    <th scope="col" class="tinh-mien-nam-mo-thuong">{{$mien_nam_there->ten_tinh}}
                        <br/> {{$mien_nam_there->ngay_mo_thuong}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="txt-giai">G8</td>
                    <td class="number">{{$mien_nam_first->giai_tam}}</td>
                    <td class="number">{{$mien_nam_second->giai_tam}}</td>
                    <td class="number">{{$mien_nam_there->giai_tam}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">G7</td>
                    <td class="number">{{$mien_nam_first->giai_bay}}</td>
                    <td class="number">{{$mien_nam_second->giai_bay}}</td>
                    <td class="number">{{$mien_nam_there->giai_bay}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">G6</td>
                    <td class="number">
                        @if($mien_nam_first->giai_sau != '')
                            @foreach(explode(',', $mien_nam_first->giai_sau) as $giai_sau)
                                {{ $giai_sau}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_nam_second->giai_sau != '')
                            @foreach(explode(',', $mien_nam_second->giai_sau) as $giai_sau)
                                {{ $giai_sau}} <br/>
                            @endforeach
                        @endif</td>
                    <td class="number">
                        @if($mien_nam_there->giai_sau != '')
                            @foreach(explode(',', $mien_nam_there->giai_sau) as $giai_sau)
                                {{ $giai_sau}} <br/>
                            @endforeach
                        @endif</td>
                </tr>
                <tr>
                    <td class="txt-giai">G5</td>
                    <td class="number">{{$mien_nam_first->giai_nam}}</td>
                    <td class="number">{{$mien_nam_second->giai_nam}}</td>
                    <td class="number">{{$mien_nam_there->giai_nam}}</td>
                </tr>

                <tr>
                    <td class="txt-giai">G4</td>
                    <td class="number">
                        @if($mien_nam_first->giai_bon != '')
                            @foreach(explode(',', $mien_nam_first->giai_bon) as $giai_bon)
                                {{ $giai_bon}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_nam_second->giai_bon != '')
                            @foreach(explode(',', $mien_nam_first->giai_bon) as $giai_bon)
                                {{ $giai_bon}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_nam_there->giai_bon != '')
                            @foreach(explode(',', $mien_nam_first->giai_bon) as $giai_bon)
                                {{ $giai_bon}} <br/>
                            @endforeach
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="txt-giai">G3</td>
                    <td class="number">
                        @if($mien_nam_first->giai_ba != '')
                            @foreach(explode(',', $mien_nam_first->giai_ba) as $giai_ba)
                                {{ $giai_ba}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_nam_second->giai_ba != '')
                            @foreach(explode(',', $mien_nam_first->giai_ba) as $giai_ba)
                                {{ $giai_ba}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_nam_there->giai_ba != '')
                            @foreach(explode(',', $mien_nam_first->giai_ba) as $giai_ba)
                                {{ $giai_ba}} <br/>
                            @endforeach
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="txt-giai">G2</td>
                    <td class="number">{{$mien_nam_first->giai_nhi}}</td>
                    <td class="number">{{$mien_nam_second->giai_nhi}}</td>
                    <td class="number">{{$mien_nam_there->giai_nhi}}</td>
                </tr>

                <tr>
                    <td class="txt-giai">G1</td>
                    <td class="number">{{$mien_nam_first->giai_nhat}}</td>
                    <td class="number">{{$mien_nam_second->giai_nhat}}</td>
                    <td class="number">{{$mien_nam_there->giai_nhat}}</td>
                </tr>

                <tr>
                    <td class="txt-giai dac-biet">ĐB</td>
                    <td class="number dac-biet">{{$mien_nam_first->dac_biet}}</td>
                    <td class="number dac-biet">{{$mien_nam_second->dac_biet}}</td>
                    <td class="number dac-biet">{{$mien_nam_there->dac_biet}}</td>
                </tr>
                </tbody>
            </table>
        </div>


        <div class="box">
            <h2 class="title-box">xổ số miền trung
                ngày: {{ date("d-m-Y", strtotime($mien_trung_first->ngay_mo_thuong))}}</h2>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th scope="col" class="tinh-mien-nam-mo-thuong">{{$mien_trung_first->ten_tinh}}
                        <br/> {{$mien_trung_first->ngay_mo_thuong}}</th>
                    <th scope="col" class="tinh-mien-nam-mo-thuong">{{$mien_trung_second->ten_tinh}}
                        <br/> {{$mien_trung_second->ngay_mo_thuong}}</th>
                    <th scope="col" class="tinh-mien-nam-mo-thuong">{{$mien_trung_there->ten_tinh}}
                        <br/> {{$mien_trung_there->ngay_mo_thuong}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="txt-giai">G8</td>
                    <td class="number">{{$mien_trung_first->giai_tam}}</td>
                    <td class="number">{{$mien_trung_second->giai_tam}}</td>
                    <td class="number">{{$mien_trung_there->giai_tam}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">G7</td>
                    <td class="number">{{$mien_trung_first->giai_bay}}</td>
                    <td class="number">{{$mien_trung_second->giai_bay}}</td>
                    <td class="number">{{$mien_trung_there->giai_bay}}</td>
                </tr>
                <tr>
                    <td class="txt-giai">G6</td>
                    <td class="number">
                        @if($mien_trung_first->giai_sau != '')
                            @foreach(explode(',', $mien_trung_first->giai_sau) as $giai_sau)
                                {{ $giai_sau}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_trung_second->giai_sau != '')
                            @foreach(explode(',', $mien_trung_second->giai_sau) as $giai_sau)
                                {{ $giai_sau}} <br/>
                            @endforeach
                        @endif</td>
                    <td class="number">
                        @if($mien_trung_there->giai_sau != '')
                            @foreach(explode(',', $mien_trung_there->giai_sau) as $giai_sau)
                                {{ $giai_sau}} <br/>
                            @endforeach
                        @endif</td>
                </tr>
                <tr>
                    <td class="txt-giai">G5</td>
                    <td class="number">{{$mien_trung_first->giai_nam}}</td>
                    <td class="number">{{$mien_trung_second->giai_nam}}</td>
                    <td class="number">{{$mien_trung_there->giai_nam}}</td>
                </tr>

                <tr>
                    <td class="txt-giai">G4</td>
                    <td class="number">
                        @if($mien_trung_first->giai_bon != '')
                            @foreach(explode(',', $mien_trung_first->giai_bon) as $giai_bon)
                                {{ $giai_bon}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_trung_second->giai_bon != '')
                            @foreach(explode(',', $mien_trung_first->giai_bon) as $giai_bon)
                                {{ $giai_bon}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_trung_there->giai_bon != '')
                            @foreach(explode(',', $mien_trung_first->giai_bon) as $giai_bon)
                                {{ $giai_bon}} <br/>
                            @endforeach
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="txt-giai">G3</td>
                    <td class="number">
                        @if($mien_trung_first->giai_ba != '')
                            @foreach(explode(',', $mien_trung_first->giai_ba) as $giai_ba)
                                {{ $giai_ba}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_trung_second->giai_ba != '')
                            @foreach(explode(',', $mien_trung_first->giai_ba) as $giai_ba)
                                {{ $giai_ba}} <br/>
                            @endforeach
                        @endif
                    </td>
                    <td class="number">
                        @if($mien_trung_there->giai_ba != '')
                            @foreach(explode(',', $mien_trung_first->giai_ba) as $giai_ba)
                                {{ $giai_ba}} <br/>
                            @endforeach
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="txt-giai">G2</td>
                    <td class="number">{{$mien_trung_first->giai_nhi}}</td>
                    <td class="number">{{$mien_trung_second->giai_nhi}}</td>
                    <td class="number">{{$mien_trung_there->giai_nhi}}</td>
                </tr>

                <tr>
                    <td class="txt-giai">G1</td>
                    <td class="number">{{$mien_trung_first->giai_nhat}}</td>
                    <td class="number">{{$mien_trung_second->giai_nhat}}</td>
                    <td class="number">{{$mien_trung_there->giai_nhat}}</td>
                </tr>

                <tr>
                    <td class="txt-giai dac-biet">ĐB</td>
                    <td class="number dac-biet">{{$mien_trung_first->dac_biet}}</td>
                    <td class="number dac-biet">{{$mien_trung_second->dac_biet}}</td>
                    <td class="number dac-biet">{{$mien_trung_there->dac_biet}}</td>
                </tr>
                </tbody>
            </table>
        </div>
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

