<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Status;
use App\Project;
use App\Client;
use Auth;
use Illuminate\Support\Str;
class StatusController extends Controller
{
    public function index(Request $request)
    {
        $where=array();
        if($request->q)
        {
            $where['project_id']=$request->q;
        }
        $where['user_id']=Auth::id();
        $data['clients']=Client::all();
        $data['status']=Status::orderBy('id','desc')->where($where)->get();
    	return view('dashboard.status.index',$data);
    }
    public function edit()
    {
        $data['status']=Status::where('user_id',Auth::id())->first();
        $data['projects']=Project::all();
        $data['clients']=Client::all();
    	return view('dashboard.status.edit',$data);
    }
    public function update(Request $request)
    {
        $where=array('user_id'=>Auth::id(),'id'=>$request->id,'token'=>$request->token);
        $data=array('project_id'=>$request->project,'client_id'=>$request->client,'strings'=>$request->strings,'count'=>count(explode(",",$request->strings)),'token'=>bcrypt(Str::random(40)));
        if(Status::where($where)->update($data))
        {
            return redirect('dashboard/status');
        }
    }
}
