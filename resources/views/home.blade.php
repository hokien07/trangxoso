@include('header')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="block-xoso">
                <h2 class="xoso-title">XỔ SỐ MIỀN BẮC</h2>
                <ul class="list-group">
                    @foreach($mien_bac as $value)
                        <a href="#" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i> {{$value}}</a>
                    @endforeach
                </ul>
            </div>

            <div class="block-xoso">
                <h2 class="xoso-title">XỔ SỐ ĐIỆN TOÁN</h2>
                <ul class="list-group">
                    @foreach($dien_toan as $value)
                        <a href="#" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i> {{$value}}</a>
                    @endforeach
                </ul>
            </div>

            <div class="block-xoso">
                <h2 class="xoso-title">XỔ SỐ MIỀN NAM</h2>
                <ul class="list-group">
                    @foreach($mien_nam  as $value)
                        <a href="#" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i> {{$value}}</a>
                    @endforeach
                </ul>
            </div>


            <div class="block-xoso">
                <h2 class="xoso-title">XỔ SỐ MIỀN TRUNG</h2>
                <ul class="list-group">
                    @foreach($mien_trung as $value)
                        <a href="#" class="list-group-item list-group-item-action "><i class="fa fa-angle-double-right"></i> {{$value}}</a>
                    @endforeach
                </ul>
            </div>
        </div>

        {{--content--}}

        <div id="content" class="col-md-6">
            <div class="border check-ngay">
                <p class="text-center">{{$ngay_thang}}</p>
            </div>
            <div class="link-ads">
                @foreach($quang_caos  as $quang_cao)
                    <a href="{{$quang_cao->link_quang_cao}}">
                <span>
                    <img src="{{asset('images/hot.gif')}}" alt="soi cau chuan">
                </span>
                        <b>{{$quang_cao->ten_quang_cao}}</b>
                    </a>
                @endforeach
            </div>
            {{--end link ads--}}

            <div class="box open-day-gif">
                <h2 class="title-box">Các tỉnh mở thưởng hôm nay</h2>
                <table class="table">
                    <tbody>
                    @foreach($ten_tinh as $tung_tinh)
                        @if($tung_tinh->mo_thuong == 1)
                    <tr>
                        @for($i = 0; $i < 3; $i++)
                        <td>{{$tung_tinh->ten_tinh}}</td>
                        @endfor
                    </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--end open-day-gif--}}

            <div class="box">
                <h2 class="title-box">Xổ số miền Bắc ngày {{$ngay_thang}}</h2>
                <table class="table table-bordered">
                    <tbody>
                    <tr class="giai dac-biet">
                        <td class="ten-giai">ĐẶC BIỆT</td>
                        <td colspan="12" class="ket-qua">{{$ket_qua_mien_bac->mien_bac_dac_biet}}</td>
                    </tr>
                    <tr class="giai giai-nhat">
                        <td class="ten-giai">Giải nhất</td>
                        <td colspan="12" class="ket-qua">{{$ket_qua_mien_bac->mien_bac_giai_nhat}}</td>
                    </tr>
                    <tr class="giai giai-nhi">
                        @php($giai_nhi = explode(',', $ket_qua_mien_bac->mien_bac_giai_nhi))
                        <td class="ten-giai">Giải nhì</td>
                        <td colspan="6" class="ket-qua">{{$giai_nhi[0]}}</td>
                        <td colspan="6" class="ket-qua">{{$giai_nhi[1]}}</td>
                    </tr>
                    <tr class="giai giai-ba">
                        <td rowspan="2" class="ten-giai">Giải ba</td>
                        @php($giai_ba = explode(',', $ket_qua_mien_bac->mien_bac_giai_ba))
                        <td colspan="4" class="ket-qua">{{$giai_ba[0]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_ba[1]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_ba[2]}}</td>
                    </tr>
                    <tr class="giai giai-ba">
                        <td colspan="4" class="ket-qua">{{$giai_ba[3]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_ba[4]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_ba[5]}}</td>
                    </tr>
                    <tr class="giai giai-tu">
                        <td class="ten-giai">Giải tư</td>
                        @php($giai_tu = explode(',', $ket_qua_mien_bac->mien_bac_giai_bon))
                        <td colspan="3" class="ket-qua">{{$giai_tu[0]}}</td>
                        <td colspan="3" class="ket-qua">{{$giai_tu[1]}}</td>
                        <td colspan="3" class="ket-qua">{{$giai_tu[2]}}</td>
                        <td colspan="3" class="ket-qua">{{$giai_tu[3]}}</td>
                    </tr>
                    <tr class="giai giai-nam">
                        <td rowspan="2" class="ten-giai">Giải năm</td>
                        @php($giai_nam = explode(',', $ket_qua_mien_bac->mien_bac_giai_nam))
                        <td colspan="4" class="ket-qua">{{$giai_nam[0]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_nam[1]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_nam[2]}}</td>
                    </tr>
                    <tr class="giai giai-ba">
                        <td colspan="4" class="ket-qua">{{$giai_nam[3]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_nam[4]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_nam[5]}}</td>
                    </tr>
                    <tr class="giai giai-sau">
                        <td class="ten-giai">Giải sáu</td>
                        @php($giai_sau = explode(',', $ket_qua_mien_bac->mien_bac_giai_sau))
                        <td colspan="4" class="ket-qua">{{$giai_sau[0]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_sau[1]}}</td>
                        <td colspan="4" class="ket-qua">{{$giai_sau[2]}}</td>
                    </tr>

                    <tr class="giai giai-bay">
                        <td class="ten-giai">Giải bảy</td>
                        @php($giai_bay = explode(',', $ket_qua_mien_bac->mien_bac_giai_bay))
                        <td colspan="3" class="ket-qua">{{$giai_bay[0]}}</td>
                        <td colspan="3" class="ket-qua">{{$giai_bay[1]}}</td>
                        <td colspan="3" class="ket-qua">{{$giai_bay[2]}}</td>
                        <td colspan="3" class="ket-qua">{{$giai_bay[3]}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="box">
                <h2 class="title-box">XSMN {{$ngay_thang}} - Xổ số miền Nam</h2>
                <table class="table table-bordered">
                    <thead>
                    <tr class="ten-tinh-mien-nam-mo-thuong">
                        <th></th>
                        <th>
                            {{$ket_qua_mien_nam[0]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[0]->ngay_mo_thuong}}</span>
                        </th>
                        <th>
                            {{$ket_qua_mien_nam[1]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[1]->ngay_mo_thuong}}</span>
                        </th>

                        <th>
                            {{$ket_qua_mien_nam[2]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[2]->ngay_mo_thuong}}</span>
                        </th>

                        <th>
                            {{$ket_qua_mien_nam[3]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[3]->ngay_mo_thuong}}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="giai giai-tam">
                        <td class="ten-giai">G8</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_tam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_tam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_tam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_tam}}</td>
                    </tr>
                    <tr class="giai giai-bay">
                        <td class="ten-giai">G7</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_bay}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_bay}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_bay}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_bay}}</td>
                    </tr>
                    <tr class="giai giai-sau">
                        <td class="ten-giai">G6</td>
                        @php($giai_sau_1 = explode(',', $ket_qua_mien_nam[0]->giai_sau))
                        @php($giai_sau_2 = explode(',', $ket_qua_mien_nam[1]->giai_sau))
                        @php($giai_sau_3 = explode(',', $ket_qua_mien_nam[2]->giai_sau))
                        @php($giai_sau_4 = explode(',', $ket_qua_mien_nam[3]->giai_sau))
                        <td class="ket-qua">{{$giai_sau_1[0]}} <br/> {{$giai_sau_1[1]}} <br/> {{$giai_sau_1[2]}}</td>
                        <td class="ket-qua">{{$giai_sau_2[0]}} <br/> {{$giai_sau_2[1]}} <br/> {{$giai_sau_2[2]}}</td>
                        <td class="ket-qua">{{$giai_sau_3[0]}} <br/> {{$giai_sau_3[1]}} <br/> {{$giai_sau_3[2]}}</td>
                        <td class="ket-qua">{{$giai_sau_4[0]}} <br/> {{$giai_sau_4[1]}} <br/> {{$giai_sau_4[2]}}</td>
                    </tr>
                    <tr class="giai giai-nam">
                        <td class="ten-giai">G5</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_nam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_nam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_nam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_nam}}</td>
                    </tr>
                    <tr class="giai giai-bon">
                        <td class="ten-giai">G4</td>
                        @php($giai_bon_1 = explode(',', $ket_qua_mien_nam[0]->giai_bon))
                        @php($giai_bon_2 = explode(',', $ket_qua_mien_nam[1]->giai_bon))
                        @php($giai_bon_3 = explode(',', $ket_qua_mien_nam[2]->giai_bon))
                        @php($giai_bon_4 = explode(',', $ket_qua_mien_nam[3]->giai_bon))
                        <td class="ket-qua">
                            {{$giai_bon_1[0]}} <br/>
                            {{$giai_bon_1[1]}} <br/>
                            {{$giai_bon_1[2]}} <br/>
                            {{$giai_bon_1[3]}} <br/>
                            {{$giai_bon_1[4]}} <br/>
                            {{$giai_bon_1[5]}} <br/>
                            {{$giai_bon_1[6]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_bon_2[0]}} <br/>
                            {{$giai_bon_2[1]}} <br/>
                            {{$giai_bon_2[2]}} <br/>
                            {{$giai_bon_2[3]}} <br/>
                            {{$giai_bon_2[4]}} <br/>
                            {{$giai_bon_2[5]}} <br/>
                            {{$giai_bon_2[6]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_bon_3[0]}} <br/>
                            {{$giai_bon_3[1]}} <br/>
                            {{$giai_bon_3[2]}} <br/>
                            {{$giai_bon_3[3]}} <br/>
                            {{$giai_bon_3[4]}} <br/>
                            {{$giai_bon_3[5]}} <br/>
                            {{$giai_bon_3[6]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_bon_4[0]}} <br/>
                            {{$giai_bon_4[1]}} <br/>
                            {{$giai_bon_4[2]}} <br/>
                            {{$giai_bon_4[3]}} <br/>
                            {{$giai_bon_4[4]}} <br/>
                            {{$giai_bon_4[5]}} <br/>
                            {{$giai_bon_4[6]}} <br/>
                        </td>
                    </tr>
                    <tr class="giai giai-ba">
                        <td class="ten-giai">G3</td>
                        @php($giai_ba_1 = explode(',', $ket_qua_mien_nam[0]->giai_ba))
                        @php($giai_ba_2 = explode(',', $ket_qua_mien_nam[1]->giai_ba))
                        @php($giai_ba_3 = explode(',', $ket_qua_mien_nam[2]->giai_ba))
                        @php($giai_ba_4 = explode(',', $ket_qua_mien_nam[3]->giai_ba))
                        <td class="ket-qua">
                            {{$giai_ba_1[0]}} <br/>
                            {{$giai_ba_1[1]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_ba_2[0]}} <br/>
                            {{$giai_ba_2[1]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_ba_3[0]}} <br/>
                            {{$giai_ba_3[1]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_ba_4[0]}} <br/>
                            {{$giai_ba_4[1]}} <br/>
                        </td>

                    </tr>
                    <tr class="giai giai-nhi">
                        <td class="ten-giai">G2</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_nhi}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_nhi}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_nhi}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_nhi}}</td>
                    </tr>

                    <tr class="giai giai-nhat">
                        <td class="ten-giai">G1</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_nhat}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_nhat}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_nhat}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_nhat}}</td>
                    </tr>

                    <tr class="giai dac-biet">
                        <td class="ten-giai">ĐB</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->dac_biet}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->dac_biet}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->dac_biet}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->dac_biet}}</td>
                    </tr>
                    </tbody>
                </table>
            </div> <div class="box">
                <h2 class="title-box"> {{$ngay_thang}} - Xổ số miền Trung</h2>
                <table class="table table-bordered">
                    <thead>
                    <tr class="ten-tinh-mien-nam-mo-thuong">
                        <th></th>
                        <th>
                            {{$ket_qua_mien_nam[0]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[0]->ngay_mo_thuong}}</span>
                        </th>
                        <th>
                            {{$ket_qua_mien_nam[1]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[1]->ngay_mo_thuong}}</span>
                        </th>

                        <th>
                            {{$ket_qua_mien_nam[2]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[2]->ngay_mo_thuong}}</span>
                        </th>

                        <th>
                            {{$ket_qua_mien_nam[3]->ten_tinh}} <br/>
                            <span class="ngay-mo-thuong">{{$ket_qua_mien_nam[3]->ngay_mo_thuong}}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="giai giai-tam">
                        <td class="ten-giai">G8</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_tam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_tam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_tam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_tam}}</td>
                    </tr>
                    <tr class="giai giai-bay">
                        <td class="ten-giai">G7</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_bay}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_bay}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_bay}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_bay}}</td>
                    </tr>
                    <tr class="giai giai-sau">
                        <td class="ten-giai">G6</td>
                        @php($giai_sau_1 = explode(',', $ket_qua_mien_nam[0]->giai_sau))
                        @php($giai_sau_2 = explode(',', $ket_qua_mien_nam[1]->giai_sau))
                        @php($giai_sau_3 = explode(',', $ket_qua_mien_nam[2]->giai_sau))
                        @php($giai_sau_4 = explode(',', $ket_qua_mien_nam[3]->giai_sau))
                        <td class="ket-qua">{{$giai_sau_1[0]}} <br/> {{$giai_sau_1[1]}} <br/> {{$giai_sau_1[2]}}</td>
                        <td class="ket-qua">{{$giai_sau_2[0]}} <br/> {{$giai_sau_2[1]}} <br/> {{$giai_sau_2[2]}}</td>
                        <td class="ket-qua">{{$giai_sau_3[0]}} <br/> {{$giai_sau_3[1]}} <br/> {{$giai_sau_3[2]}}</td>
                        <td class="ket-qua">{{$giai_sau_4[0]}} <br/> {{$giai_sau_4[1]}} <br/> {{$giai_sau_4[2]}}</td>
                    </tr>
                    <tr class="giai giai-nam">
                        <td class="ten-giai">G5</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_nam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_nam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_nam}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_nam}}</td>
                    </tr>
                    <tr class="giai giai-bon">
                        <td class="ten-giai">G4</td>
                        @php($giai_bon_1 = explode(',', $ket_qua_mien_nam[0]->giai_bon))
                        @php($giai_bon_2 = explode(',', $ket_qua_mien_nam[1]->giai_bon))
                        @php($giai_bon_3 = explode(',', $ket_qua_mien_nam[2]->giai_bon))
                        @php($giai_bon_4 = explode(',', $ket_qua_mien_nam[3]->giai_bon))
                        <td class="ket-qua">
                            {{$giai_bon_1[0]}} <br/>
                            {{$giai_bon_1[1]}} <br/>
                            {{$giai_bon_1[2]}} <br/>
                            {{$giai_bon_1[3]}} <br/>
                            {{$giai_bon_1[4]}} <br/>
                            {{$giai_bon_1[5]}} <br/>
                            {{$giai_bon_1[6]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_bon_2[0]}} <br/>
                            {{$giai_bon_2[1]}} <br/>
                            {{$giai_bon_2[2]}} <br/>
                            {{$giai_bon_2[3]}} <br/>
                            {{$giai_bon_2[4]}} <br/>
                            {{$giai_bon_2[5]}} <br/>
                            {{$giai_bon_2[6]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_bon_3[0]}} <br/>
                            {{$giai_bon_3[1]}} <br/>
                            {{$giai_bon_3[2]}} <br/>
                            {{$giai_bon_3[3]}} <br/>
                            {{$giai_bon_3[4]}} <br/>
                            {{$giai_bon_3[5]}} <br/>
                            {{$giai_bon_3[6]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_bon_4[0]}} <br/>
                            {{$giai_bon_4[1]}} <br/>
                            {{$giai_bon_4[2]}} <br/>
                            {{$giai_bon_4[3]}} <br/>
                            {{$giai_bon_4[4]}} <br/>
                            {{$giai_bon_4[5]}} <br/>
                            {{$giai_bon_4[6]}} <br/>
                        </td>
                    </tr>
                    <tr class="giai giai-ba">
                        <td class="ten-giai">G3</td>
                        @php($giai_ba_1 = explode(',', $ket_qua_mien_nam[0]->giai_ba))
                        @php($giai_ba_2 = explode(',', $ket_qua_mien_nam[1]->giai_ba))
                        @php($giai_ba_3 = explode(',', $ket_qua_mien_nam[2]->giai_ba))
                        @php($giai_ba_4 = explode(',', $ket_qua_mien_nam[3]->giai_ba))
                        <td class="ket-qua">
                            {{$giai_ba_1[0]}} <br/>
                            {{$giai_ba_1[1]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_ba_2[0]}} <br/>
                            {{$giai_ba_2[1]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_ba_3[0]}} <br/>
                            {{$giai_ba_3[1]}} <br/>
                        </td>

                        <td class="ket-qua">
                            {{$giai_ba_4[0]}} <br/>
                            {{$giai_ba_4[1]}} <br/>
                        </td>

                    </tr>
                    <tr class="giai giai-nhi">
                        <td class="ten-giai">G2</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_nhi}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_nhi}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_nhi}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_nhi}}</td>
                    </tr>

                    <tr class="giai giai-nhat">
                        <td class="ten-giai">G1</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->giai_nhat}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->giai_nhat}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->giai_nhat}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->giai_nhat}}</td>
                    </tr>

                    <tr class="giai dac-biet">
                        <td class="ten-giai">ĐB</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[0]->dac_biet}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[1]->dac_biet}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[2]->dac_biet}}</td>
                        <td class="ket-qua">{{$ket_qua_mien_nam[3]->dac_biet}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        {{--sidebar righr--}}
        <div class="col-md-3">
            <div class="block-xoso">
                <h2 class="xoso-title">TIN MỚI NHẤT</h2>
                <ul class="list-group">
                    @foreach($all_tin as $tin)
                        <li class="list-group-item">
                            <img src="{{$tin->tin_hinh_anh}}" alt="{{$tin->tin_tieu_de}}" class="rounded float-left" width="60px" height="60px">
                            <p>{{$tin->tin_tieu_de}}</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="block-xoso">
                <h2 class="xoso-title">THỐNG KÊ KẾT QUẢ XỔ SỐ</h2>
                <ul class="list-group">
                    @foreach($thong_ke as $value)
                        <li class="list-group-item"><i class="fa fa-angle-double-right"></i> {{$value}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@include('footer')
