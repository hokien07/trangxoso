@include('header')
<div class="container">
    <div class="row">
        <div class="col-md-3">
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
        </div>

        {{--content--}}

        <div id="content" class="col-md-6">
            <div class="border check-ngay">
                <p class="text-center">Thứ sáu - 23/02/2018</p>
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
                <h2 class="title-box">XS MB » XSMB thứ 6 » Xổ số miền Bắc ngày 23-02-2018 thứ 6</h2>
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


        {{--sidebar righr--}}
        <div class="col-md-3">
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
        </div>
    </div>
</div>
@include('footer')
