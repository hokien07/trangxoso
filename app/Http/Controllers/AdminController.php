<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;
use \Crypt;
use App\Http\Controllers\GetdataController as getdata;
use App\Classes\Crawller;

use App\Model\User;

class AdminController extends Controller
{
    public function login() {

        $get_data = new getdata();
        $crawler = new Crawller();
        $ten_tinhs = $get_data->get_ten_tinh();
        $ngay = $crawler->lay_ngay_thang();
        $tin_moi = $get_data->get_news();

        return view('admin-dang-nhap',compact('ten_tinhs', 'ngay', 'tin_moi'));
    }


    public function post_dang_nhap(Request $req) {
        $validator = Validator::make(
            [
                'username' => $req->username,
                'password' => $req->password
            ],
            [
                'username' => 'required',
                'password' => 'required|min:6'
            ]
        );

        if ($validator->fails())
        {
            return back()->with('error', 'vui lòng nhập đủ tài khoản và mật khẩu.');
        }



        
           
        $user_name = $req->username;
        $user_pass = Crypt::encrypt($req->password);

        //check tài khoản không tồn tại

        $user = DB::table('users')
            ->select('*')
            ->where('name', '=', $user_name)
            ->orwhere('email', '=', $user_name)
            ->first();

        if ($user === null) {
            return back()->with('error', 'tài khoản không tồn tại!!!');
        }

        //check trùng mật khẩu.

        $pass = DB::table('users')
            ->select('password')
            ->where('name', '=', $user_name)
            ->orwhere('email', '=', $user_name)
            ->first();

        if ($pass === null) {
            return back()->with('error', 'mật không đúng!!!');
        }

        $req->session()->push('dang-nhap', $user_name);


        $tin_tuc = DB::table('tin_tuc')->select('*')->get();


        return view('admin',compact('tin_tuc'));

    }


    public function get_dang_ky() {
        
        $get_data = new getdata();
        $crawler = new Crawller();
        $ten_tinhs = $get_data->get_ten_tinh();
        $ngay = $crawler->lay_ngay_thang();
        $tin_moi = $get_data->get_news();

        return view('admin-dang-ky', compact('ten_tinhs', 'ngay', 'tin_moi'));
    }



    public function post_dang_ky(Request $req) {

        $validator = Validator::make(
            [
                'username' => $req->username,
                'password' => $req->password,
                'password_confirm' => $req->password_confirm,
                'email' => $req->email,
            ],
            [
                'username' => 'required',
                'password' => 'required|min:6',
                'password_confirm' => 'required|same:password',
                'email' => 'required|email|unique:users'
            ]
        );

        if ($validator->fails())
        {
            return back()->with('error', 'có lỗi xảy ra, vui lòng kiểm tra lại!!!!');
        }



        
           
        $user_name = $req->username;
        $user_email = $req->email;
        $user_pass = Crypt::encrypt($req->password) ;
        $user_re_pass =  Crypt::encrypt($req->password_confirm);

        $token = $req->_token;

        $user= User::updateOrCreate(
            ['email' => $user_email],
           ['name'=>$user_name, 'password'=>$user_pass, 'remember_token'=>$token]
       );



        return back()->with(['mes'=>'đăng ký thành công!!!']);
    }
}
