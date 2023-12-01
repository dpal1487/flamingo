<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
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
        if (Auth::attempt($this->credentials($request))) {
         	    return redirect()->intended('/');
        }
        else
        {
          $error=array('invalid'=>'Invalid email address or password');
            return redirect()->back()->withErrors($error);
        }
        }
    }
    protected function credentials($request)
    {
    if(is_numeric($request->get('username'))){
        return ['username'=>$request->get('username'),'password'=>$request->get('password')];
    }
        return ['username' => $request->get('username'), 'password'=>$request->get('password')];
    }
    public function logout(Request $request) {
      Auth::logout();
      return redirect('auth/login');
    }
    public function doLogout()
    {
        Auth::logout();
        return redirect()->to('/');
    }
}
