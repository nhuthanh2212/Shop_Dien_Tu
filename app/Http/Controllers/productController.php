<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashboard');
        }
        else
        {
            return Redirect::to('admin')->send();
        }
    }
     public function index()
    {
        $this->AuthLogin();
        $list = DB::table('tbl_product')->join('tbl_category','tbl_category.category_id','=','tbl_product.category_id')->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')->orderby('tbl_product.product_id','desc')->get();
        $manager_product = view('admin.product.list_product')->with('list',$list);
        return view('admin_layout')->with('admin.product.list_product',$manager_product);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->AuthLogin();
        $cate = DB::table('tbl_category')->orderby('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        return view('admin.product.add_product')->with('cate',$cate)->with('brand',$brand);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $request->product_price;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm Sản Phẩm Thành Công');
            return Redirect::to('list-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message','Thêm Sản Phẩm Thành Công');
        return Redirect::to('list-product');

    }

    public function unactive($id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$id)->update(['product_status' => 1]);
        Session::put('message','Hiển Thị Sản Phẩm Thành Công');
         return Redirect::to('list-product');
    }
     public function active($id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$id)->update(['product_status' => 0]);
        Session::put('message','Ẩn Sản Phẩm Thành Công');
         return Redirect::to('list-product');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->AuthLogin();
        $cate = DB::table('tbl_category')->orderby('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        $edit = DB::table('tbl_product')->where('product_id',$id)->get();
        $manager_product = view('admin.product.edit_product')->with('edit',$edit)->with('cate',$cate)->with('brand',$brand);
        return view('admin_layout')->with('admin.product.edit_product',$manager_product);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $request->product_price;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id',$id)->update($data);
            Session::put('message','Cập Nhât Sản Phẩm Thành Công');
            return Redirect::to('list-product');
        }
        
        DB::table('tbl_product')->where('product_id',$id)->update($data);
        Session::put('message','Cập Nhật Sản Phẩm Thành Công');
        return Redirect::to('list-product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->AuthLogin();
         DB::table('tbl_product')->where('product_id',$id)->delete();
        Session::put('message','Xóa Sản Phẩm Thành Công');
        return Redirect::to('list-product');
    }
}
