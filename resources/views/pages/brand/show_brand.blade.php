@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    @foreach($brand_name as $key => $bran_name)
        <h2 class="title text-center">THƯƠNG HIỆU {{$bran_name->brand_name}}</h2>
    @endforeach
    @foreach($brand_by_id as $key => $list_pro)
        <a href="{{URL::to('/chi-tiet/'.$list_pro->product_id)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$list_pro->product_image)}}" alt="" />
                        <h2>{{number_format($list_pro->product_price).' '.'VND'}}</h2>
                        <p>{{$list_pro->product_name}}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Giỏ Hàng</a>
                    </div>
                                        <!-- <div class="product-overlay">
                                            <div class="overlay-content">
                                                <h2>{{number_format($list_pro->product_price).' '.'VND'}}</h2>
                                                <p>{{$list_pro->product_name}}</p>
                                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Giỏ Hàng</a>
                                            </div>
                                        </div> -->
                </div>               
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Thêm Yêu Thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So Sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>
        </a>
    @endforeach
</div><!--features_items-->
               
@endsection