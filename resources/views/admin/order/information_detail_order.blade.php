@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông Tin Khách Hàng Đăng Nhập
    </div>
    
    <div class="table-responsive">
        <?php
            $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>' ;
                        Session::put('message',null);
                }
                    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên Khách Hàng</th>
            <th>Email</th>
            
            <th>Số Diện Thoại</th>
           
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            
          <tr>
           
            <td>{{ $customer->customer_name }}</td>
            <td>{{ $customer->customer_email }}</td>
            <td>{{ $customer->customer_phone }}</td>
            
          
          </tr>
          
        </tbody>
      </table>
    </div>
    
  </div>
</div>
<br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông Tin Vận Chuyển Hàng 
    </div>
    
    <div class="table-responsive">
        <?php
            $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>' ;
                        Session::put('message',null);
                }
                    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên Người Vận Chuyển</th>
            <th>Email</th>
            <th>Số Diện Thoại</th>
            <th>Địa Chỉ</th>
            
            <th>Ghi Chú</th>
            <th>Hình Thức Thanh Toán</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            
          <tr>
           
            <td>{{ $shipping->shipping_name }}</td>
            <td>{{ $shipping->shipping_email }}</td>
            <td>{{ $shipping->shipping_phone }}</td>
            <td>{{ $shipping->shipping_address }}</td>
            
            <td>{{ $shipping->shipping_notes }}</td>
            <td>
              @if($shipping->shipping_method == 1)
                Thanh Toán Thẻ ATM
              @elseif($shipping->shipping_method == 2)
                Thanh Toán Bằng Tiền Mặt
              @else
                Thành Toán Bằng Ví Điện Tử
              @endif
            </td>
            
          
          </tr>
          
        </tbody>
      </table>
    </div>
    
  </div>
</div>  
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt Kê Chi Tiết Đơn Hàng
    </div>
   
    <div class="table-responsive">
        <?php
            $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>' ;
                        Session::put('message',null);
                }
                    ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <i>STT</i>
              
            </th>
            <th>Tên Sản Phẩm</th>
            <th>Mã Giảm Giá</th>
            <th>Phí Ship</th>
            <th>Số Lượng</th>
            
            <th>Giá Sản Phẩm </th>
           
            <th>Tổng Tiền</th>
           
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 0;
            $total = 0;
          ?>
            @foreach($order_detail as $key => $details)
            <?php
              $i++;
              $subtotal = $details->product_price*$details->product_sales_quantity ;
              $total += $subtotal;
             ?>
          <tr>
            <td><i>{{$i}}</i></td>
            <td>{{ $details->product_name }}</td>
            <td>
              @if($details->product_coupon != 'no')
                {{ $details->product_coupon }}
              @else
                Không Có Mã
              @endif
            </td>
            <td>{{  number_format($details->product_feeship,0,',','.') }}<sup>đ</sup></td>
            <td>{{ $details->product_sales_quantity }}</td>
            <td>{{ number_format($details->product_price,0,',','.') }}<sup>đ</sup></td>

            <td>
               {{ number_format($subtotal,0,',','.') }}<sup>đ</sup>
            </td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3">
              Tổng Tiền: {{ number_format($total,0,',','.') }}<sup>đ</sup>
            </td>
          </tr>
          <tr>
            <td colspan="3"> 
              <?php
                $total_coupon = 0;
              ?>
               
               @if($coupon_condition == 1)
                <?php
                  $total_after_coupon = ($total * $coupon_number) / 100;
                  echo 'Giảm: '.number_format($total_after_coupon,0,',','.').'<sup>đ</sup';
                  $total_coupon = $total - $total_after_coupon + $details->product_feeshi;
                ?>
               @else
                <?php
                echo 'Giảm: '.number_format($coupon_number,0,',','.').'<sup>đ</sup';
                  $total_coupon = $total - $coupon_number + $details->product_feeship;
                  
                ?>
               @endif
               
            </td>
          </tr>
          <tr>
            <td colspan="3">
              Phí Ship: {{ number_format($details->product_feeship,0,',','.') }}<sup>đ</sup>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              Tổng Tiền Còn: {{ number_format($total_coupon,0,',','.') }}<sup>đ</sup>
            </td>
          </tr>
        </tbody>
      </table>
      <a target="_blank" href="{{url('/print-order/'.$details->order_code)}}" class="btn btn-primary">In Dơn Hàng</a>


    </div>
    
  </div>
</div> 
@endsection
