<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Login;
use App\Models\Social;
use Socialite;
use Illuminate\Support\Facades\Redirect;
session_start();
use Illuminate\Support\Facades\Hash;
use App\Rules\Captch;
use Validator;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AuthLogin(){
        // if(session::get('login_normal')){
        //     $admin_id = session::get('admin_id');
        //     if($admin_id){
        //        return Redirect::to('dashboard');
        //     }
        //     else
        //     {
        //         return Redirect::to('admin')->send();
        //     }
        // }
        $admin_id = session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashboard');
        }
        else
        {
            return Redirect::to('admin')->send();
        }
    }
    public function login()
    {
        return view('admin_login');
    }
    public function index()
    {
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login vao trang admin
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
            
        }
        else{
            $admin_login = new Social([
                'provider_user_id' => $provider->getId(),
                'provider'=>'facebook'
            ]);
            $orang = Login::where('admin_email',$provider->getEmail())->first();
            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => '',
                ]);
            }
            $admin_login->login()->associate($orang);
            $admin_login->save();

            $account_name = Login::where('admin_id',$admin_login->user)->first();
            Session::put('admin_name',$admin_login->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$admin_login->admin_id);
           
        }
         return redirect('/dashboard')->with('message','Đăng Nhập Admin Thành Công');
    }

    public function dashboard(Request $request)
    {
        // $admin_email = $request->admin_email;
        // $admin_password = md5($request->admin_password);

        // $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        // if($result){
        //     Session::put('admin_name',$result->admin_name);
        //     Session::put('admin_id',$result->admin_id);
        //     return Redirect::to('/dashboard');
        // }else
        // {
        //     Session::put('message','Email Hoặc Password Bị Sai. Vui Lòng Nhập Lại');
        //     return Redirect::to('/admin');
        // }
        // $data = $request->all();

        $data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
            // 'g-recaptcha-response' => 'required',
        ],
        [
            
            'admin_email.required' => 'Vui Lòng Điền Email',
            
            'admin_password.required' => 'Vui Lòng Điền Password',
            // 'g-recaptcha-response.required' => 'Vui Lòng Chọn Captcha',
            
        ]);
        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        
        if($login){
            $login_count = $login->count();
            if($login_count>0){
                Session::put('admin_name',$login->admin_name);
                Session::put('admin_id',$login->admin_id);
                return Redirect::to('/dashboard');
            }
        }else
            {
                Session::put('message','Email Hoặc Password Bị Sai. Vui Lòng Nhập Lại');
                return Redirect::to('/admin');
            }
     
    }

     public function logout(Request $request)
    {
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
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
}
