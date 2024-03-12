<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Feeship;
use App\Models\Customer;
use App\Models\Coupon;
use PDF;

class OrderController extends Controller
{

    //In hóa đơn Đơn hàng bằng PDF
    public function print_order($checkout_code){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        return $pdf->stream();
    }

    public function print_order_convert($checkout_code){
        $order_detail = OrderDetails::where('order_code',$checkout_code)->get();

        $order = Order::where('order_code',$checkout_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $order_detail_product = OrderDetails::with('product')->where('order_code',$checkout_code)->get();

        foreach($order_detail_product as $key => $order_de){
            $product_coupon = $order_de->product_coupon;
            

        }
        if($product_coupon != 'no'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();

            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
            if($coupon_condition==1){
                $coupon_echo = $coupon_number.'%';
            }elseif($coupon_condition==2){
                $coupon_echo = number_format($coupon_number,0,",",".").'<sup>đ</sup>';
            }
        }
        else{
            $coupon_condition = 2;
            $coupon_number = 0;
            $coupon_echo = 0;
        }

        $output = '';
        $output.='
        <style>
            body{
                font-family: DejaVu Sans;
            }
            .table-styling{
                border: 1px solid #000;
            }
            .table-styling th{
                border: 1px solid #000;
            }
            .table-styling td{
                border: 1px solid #000;
            }
        </style>
        <h3><center> CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </center></h3>
        <h3><center> Độc Lập - Tự Do - Hạnh Phúc </center></h3>
        <h5><center> Công Ty TNHH Một Thành Viên Cung Cấp Đồ Điện Tử </center></h5> 
        <p>THÔNG TIN KHÁCH HÀNG.</p>
        <table class="table-styling">
            <thead>
                <tr>
                    <th>Tên Khách Hàng</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    
                </tr>
            </thead>
            <tbody>';
           
            $output.='
                <tr>
                    <td>'.$customer->customer_name.'</td>
                    <td>'.$customer->customer_phone.'</td>
                    <td>'.$customer->customer_email.'</td>
                    
                </tr>';
            
        $output.='
            </tbody>

         </table>

        <p>THÔNG TIN GIAO HÀNG. </p>
        <table class="table-styling">
            <thead>
                <tr>
                    <th>Tên Người Nhận</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>Dịa Chỉ</th>
                    <th>Ghi Chú</th>
                    
                </tr>
            </thead>
            <tbody>';
           
            $output.='
                <tr>
                    <td>'.$shipping->shipping_name.'</td>
                    <td>'.$shipping->shipping_phone.'</td>
                    <td>'.$shipping->shipping_email.'</td>
                    <td>'.$shipping->shipping_address.'</td>
                    <td>'.$shipping->shipping_notes.'</td>
                    
                </tr>';
            
        $output.='
            </tbody>

         </table>

         <p>Đơn Hàng. </p>
        <table class="table-styling">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Mã Giảm Giá</th>
                    <th>Phí Ship</th>
                    <th>Số Lượng</th>
                    <th>Giá Sản Phẩm</th>
                    <th>Thành Tiền</th>
                </tr>
            </thead>
            <tbody>';

            
            $total = 0;

                foreach($order_detail_product as $key => $product){
                    $subtotal = $product->product_price * $product->product_sales_quantity ;
                    $total += $subtotal;
                    if($product->product_coupon != 'no'){
                        $product_coupon = $product->product_coupon;
                    }else{
                        $product_coupon = "Không Tồn Tại.";
                    }

            $output.='
                <tr>
                    <td>'.$product->product_name.'</td>
                    <td>'.$product_coupon.'</td>
                    <td>'.number_format($product->product_feeship,0,",",".").'<sup>đ</sup></td>
                    <td>'.$product->product_sales_quantity.'</td>
                    <td>'.number_format($product->product_price,0,",",".").'<sup>đ</sup></td>
                    <td>'.number_format($subtotal,0,",",".").'<sup>đ</sup></td>
                    
                </tr>';
            }

            if($coupon_condition==1){
                $total_after_coupon = ($total * $coupon_number) / 100;
                
                $total_coupon = $total - $total_after_coupon + $product->product_feeshi;
            }else
            {
                
                $total_coupon = $total - $coupon_number + $product->product_feeship;
            }

        $output.='<tr>
            <td colspan="6">
                <p>Tổng Tiền: '.number_format($total,0,",",".").'<sup>đ</sup></p>
            </td>

        </tr>';

        $output.='<tr>
            <td colspan="6">
                <p>Phí Ship: '.number_format($product->product_feeship,0,",",".").'<sup>đ</sup></p>
            </td>

        </tr>';

        $output.='<tr>
            <td colspan="6">
                <p>Giảm: '.$coupon_echo.'</p>
            </td>

        </tr>';

        $output.='<tr>
            <td colspan="6">
                <p>Thanh Toán: '.number_format($total_coupon,0,",",".").'<sup>đ</sup></p>
            </td>

        </tr>';

        $output.='
            </tbody>

         </table>



         ';
        $output.='
            </tbody>

         </table>

        <p>Ký Tên. </p>
        <table >
            <thead>
                <tr>
                    <th width="300px">Cửa Hàng Điện Tử</th>
                    <th width="400px">Người Nhận</th>
                    
                    
                </tr>
            </thead>
            <tbody>';
           
            
            
        $output.='
            </tbody>

         </table>';

         return $output;
    }


    public function manage_order(){
        $order = Order::orderBy('created_at','DESC')->get();
        return view('admin.order.manage_order')->with(compact('order'));
    }


    public function view_order(string $order_code){
        $order_detail = OrderDetails::where('order_code',$order_code)->get();

        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $order_detail_product = OrderDetails::with('product')->where('order_code',$order_code)->get();
        foreach($order_detail_product as $key => $order_de){
            $product_coupon = $order_de->product_coupon;
            

        }
        if($product_coupon != 'no'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }
        else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }
        
        
        return view('admin.order.information_detail_order')->with(compact('order','customer','shipping','order_detail','coupon_condition', 'coupon_number','order_status'));

    }
}
