@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
                        <h2 class="title text-center">SẢN PHẨM MỚI</h2>
                        @foreach($list_product as $key => $list_pro)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                        <div class="productinfo text-center">
                                                <form>
                                                    @csrf
                                                    <input type="hidden"  value="{{$list_pro->product_id}}" class="cart_product_id_{{$list_pro->product_id}}">
                                                    <input type="hidden"  value="{{$list_pro->product_name}}" class="cart_product_name_{{$list_pro->product_id}}">
                                                    <input type="hidden"  value="{{$list_pro->product_image}}" class="cart_product_image_{{$list_pro->product_id}}">
                                                    <input type="hidden"  value="{{$list_pro->product_price}}" class="cart_product_price_{{$list_pro->product_id}}">
                                                    <input type="hidden"  value="1" class="cart_product_qry_{{$list_pro->product_id}}">
                                                <a href="{{URL::to('/chi-tiet/'.$list_pro->product_id)}}">
                                                <img src="{{URL::to('public/uploads/product/'.$list_pro->product_image)}}" alt="" />
                                                <h2>{{number_format($list_pro->product_price).' '.'VND'}}</h2>
                                                <p>{{$list_pro->product_name}}</p>
                                                
                                                    </a>
                                                    <button type="button" class="btn btn-default add-to-cart" data-id="{{$list_pro->product_id}}" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Giỏ Hàng</button>
                                                </form>
                                                
                                        </div>
                                       <!--  <div class="product-overlay">
                                            <div class="overlay-content">

                                                <form>
                                                    @csrf
                                                    <input type="hidden" name="" value="{{$list_pro->product_id}}" class="cart_product_id_{{$list_pro->product_id}}">
                                                    <input type="hidden" name="" value="{{$list_pro->product_name}}" class="cart_product_name_{{$list_pro->product_id}}">
                                                    <input type="hidden" name="" value="{{$list_pro->product_image}}" class="cart_product_image_{{$list_pro->product_id}}">
                                                    <input type="hidden" name="" value="{{$list_pro->product_price}}" class="cart_product_price_{{$list_pro->product_id}}">
                                                    <input type="hidden" name="" value="1" class="cart_product_qry_{{$list_pro->product_id}}">
                                                    <h2>{{number_format($list_pro->product_price).' '.'VND'}}</h2>
                                                    <p>{{$list_pro->product_name}}</p>
                                                    <a href="{{URL::to('/chi-tiet/'.$list_pro->product_id)}}" class="btn btn-default add-to-cart">Chi Tiết</a>
                                                    <button type="button" class="btn btn-default" data-id="{{$list_pro->product_id}}" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Giỏ Hàng</button>
                                                </form>
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
                        @endforeach
                </div><!--features_items-->
               
@endsection