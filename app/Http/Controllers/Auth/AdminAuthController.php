<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    protected function credentials($request)
    {
    if(is_numeric($request->get('username'))){
        return ['username'=>$request->get('username'),'password'=>$request->get('password')];
    }
        return ['username' => $request->get('username'), 'password'=>$request->get('password')];
    }
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(),[
         'username'=>'required',
         'password'=>'required:min:8'
        ]);
       if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
       }
       else
       {
        if (Auth::guard('admin')->attempt($this->credentials($request))) {
         	    return redirect()->intended('/');
        }
        else
        {
          $error=array('invalid'=>'Invalid email address or password');
            return redirect()->back()->withErrors($error);
        }
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to('/admin/login');
    }
}
