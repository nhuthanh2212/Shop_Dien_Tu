<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Banner;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //slider
        $slider = Banner::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //seo

        $meta_desc = "Chuyên Bán Đồ Điện Tử Cao Cấp Đẹp Mắt, Chất Lượng và Chính Hãng";

        $meta_keywords ="Đồ Điện Tử, Điện Thoại, Lap Top, Tủ Lạnh, Máy Tính";
        $meta_title = "Shop Điện Tử Chính Hãng, Cao Cấp và Chất Lượng";
        $url_canonical = $request->url();


        //end seo
        $cate = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        // $list = DB::table('tbl_product')->join('tbl_category','tbl_category.category_id','=','tbl_product.category_id')->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')->orderby('tbl_product.product_id','desc')->get();
        $list_product = DB::table('tbl_product')->where('product_status','1')->orderby('brand_id','desc')->limit(4)->get();
        // return view('pages.home')->with('cate',$cate)->with('brand',$brand)->with('list_product',$list_product);
        return view('pages.home')->with(compact('cate', 'brand', 'list_product','meta_desc','meta_title','meta_keywords','url_canonical','slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        //slider
        $slider = Banner::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $keywords = $request->keywords_submit;
        $cate = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();


        $meta_desc='';
        $meta_keywords = '';
        $meta_title = '';
        $url_canonical = '';
        foreach($search_product as $key => $seo){
            $meta_desc = $seo->product_desc;

            $meta_keywords = $seo->product_name;
            $meta_title = $seo->product_name;
            $url_canonical = $request->url();
        }

        return view('pages.product.search')->with(compact('cate', 'brand','search_product','meta_desc','meta_title','meta_keywords','url_canonical','slider'));
        // return view('pages.product.search')->with('cate',$cate)->with('brand',$brand)->with('search_product',$search_product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {
         //slider
        $slider = Banner::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        
        $cate = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $category_by_id = DB::table('tbl_product')->join('tbl_category','tbl_product.category_id','=','tbl_category.category_id')->where('tbl_product.category_id',$id)->get();

        $category_name = DB::table('tbl_category')->where('tbl_category.category_id',$id)->limit(1)->get();
        // $meta_desc='';
        // $meta_keywords = '';
        // $meta_title = '';
        // $url_canonical = '';
        foreach($category_name as $key => $seo){
            $meta_desc = $seo->category_desc;

            $meta_keywords = $seo->category_keyword;
            $meta_title = $seo->category_name;
            $url_canonical = $request->url();
        }

        



        return view('pages.category.show_category')->with(compact('cate', 'brand', 'category_by_id', 'category_name', 'meta_desc', 'meta_title', 'meta_keywords', 'url_canonical', 'slider'));

        // return view('pages.category.show_category')->with('cate',$cate)->with('brand',$brand)->with('category_by_id',$category_by_id)->with('category_name',$category_name)->with('meta_title',$meta_title)->with('meta_keywords',$meta_keywords)->with('meta_desc',$meta_desc)->with('url_canonical',$url_canonical);
    }

    public function show_brand(Request $request,string $id)
    {
        //slider
        $slider = Banner::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$id)->get();
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id',$id)->limit(1)->get();
        // $meta_desc='';
        // $meta_keywords = '';
        // $meta_title = '';
        // $url_canonical = '';
        foreach($brand_name as $key => $seo){
            $meta_desc = $seo->brand_desc;

            $meta_keywords = $seo->brand_keyword;
            $meta_title = $seo->brand_name;
            $url_canonical = $request->url();
        }

        

         return view('pages.brand.show_brand')->with(compact('cate', 'brand', 'brand_by_id','brand_name','meta_desc','meta_title','meta_keywords','url_canonical','slider'));

        // return view('pages.brand.show_brand')->with('cate',$cate)->with('brand',$brand)->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name);
    }

    public function show_details_product(Request $request,string $id){
        //slider
        $slider = Banner::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $details_product = DB::table('tbl_product')->join('tbl_category','tbl_category.category_id','=','tbl_product.category_id')->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')->where('tbl_product.product_id',$id)->get();

        foreach($details_product as $key => $seo){
            $meta_desc = $seo->category_desc;

            $meta_keywords = $seo->category_keyword;
            $meta_title = $seo->category_name;
            $url_canonical = $request->url();

            $category_id = $seo->category_id;
        }

        // foreach($details_product as $key => $value){
        //     $category_id = $value->category_id;
        // }
        $related_product = DB::table('tbl_product')->join('tbl_category','tbl_category.category_id','=','tbl_product.category_id')->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')->where('tbl_category.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$id])->get();


        // return view('pages.product.show_details')->with('cate',$cate)->with('brand',$brand)->with('product_details',$details_product)->with('related_product',$related_product);

        return view('pages.product.show_details')->with(compact('cate', 'brand','details_product','related_product','meta_desc','meta_title','meta_keywords','url_canonical','slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //send emali
    public function send_email(){
        $name = 'John Doe';
        $body = 'Welcome to our website!';
        

       
        Mail::send('pages.send_email',compact('name','body'), function($email){
            $email->to('trannhuthanh221202@gmail.com','Tran Nhu Thanh');
        });
    }
}
