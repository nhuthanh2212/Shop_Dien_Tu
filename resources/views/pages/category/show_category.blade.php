@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <div class="fb-share-button" data-href="http://localhost:81/shopbanhang/danh-muc/3" data-layout="" data-size=""><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
    <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="" data-action="" data-size="" data-share="false"></div>
    
    @foreach($category_name as $key => $cate_name)
        <h2 class="title text-center">DANH MỤC {{$cate_name->category_name}}</h2>
    @endforeach
    @foreach($category_by_id as $key => $list_pro)
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
<div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="50"></div>
               
@endsection