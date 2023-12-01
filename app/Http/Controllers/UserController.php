<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
    	$data['users']=User::with('role')->paginate(10);

        // return $data;
    	return view('user.index',$data);
    }
    public function create()
    {
    	$data['roles']=Role::get();
    	return view('user.create',$data);
    }
    public function store(Request $request)
    {
        $validator=$this->validation($request);
        if ($validator->fails()) {
                return redirect()->back()->withErrors(array('error'=>$validator->messages()->first()));
        }
    	$user=new User;
        $user->first_name=$request->first_name;
    	$user->last_name=$request->last_name;
    	$user->email=$request->email;
    	$user->username=$request->username;
        $user->ip_address=$request->ip();
    	$user->password=bcrypt($request->password);
    	$user->token=$request->_token;
    	if($user->save())
    	{
            $role=UserRole::create(['user_id'=>$user->id,'role_id'=>$request->role]);
	        return redirect('users');
    	}
    }
    public function edit($id)
    {
    	$data['user']=User::where('id',$id)->first();
    	$data['roles']=Role::get();
    	return view('user.edit',$data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
         'username'=>'required',
         'password'=>'',
         'role'=>'required|numeric'
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors(array('error'=>$validator->messages()->first()));

        }

        $result=User::where("id",$request->get('id'))
        ->update(["username"=>$request->get('username'),
            "password"=>bcrypt($request->get('password'))
        ]);
        $id=User::where('id',$request->get('id'))->first();
        $role=UserRole::where(['user_id'=>$id->id])->update(['role_id'=>$request->get('role')]);
        if ($role) {
            return redirect('users')->with('success','your segment successfully updated!');
        }
        else
        {
            return response()->json(["error"=>true,"message"=>"Sorry, someting went wrong."]);
        }
    }
     public function delete(Request $request)
    {

            $user = User::find($request->id);
            if($user->delete())
            {
                return response()->json([
                    'success' => true,
                    "message"=>"Your segment has been deleted successfully!"
                ]);
            }
            else
            {
                return response()->json(["type"=>'error',"message"=>"Sorry, someting went wrong."]);
            }


    }
    public function validation($request)
    {
        $validator = Validator::make($request->all(),[
         'username'=>'required|unique:users',
         'password'=>'required|min:8',
         'type'=>'numeric'
        ]);
        return $validator;
    }
}
