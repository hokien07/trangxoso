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