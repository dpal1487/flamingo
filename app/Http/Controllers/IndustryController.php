<?php

namespace App\Http\Controllers;

use App\Models\Industries;
use Illuminate\Http\Request;
class IndustryController extends Controller
{
    public function index(){
        $industries =Industries::orderBy('name')->paginate(10);
    	return view('industry.index',compact('industries'));
    }
    public function create()
    {
        return view('industry.create');
    }

    public function store(Request $request)
    {
        $industry =Industries::create(['name'=>$request->name,'status'=>$request->status]);
        return redirect('/industries');
    }
    public function edit($id)
    {
        $industry =Industries::where('id',$id)->orderBy('name')->first();
        return view('industry.edit',compact('industry'));
    }

    public function update(Request $request,$id)
    {
        $response=Industries::where('id',$id)->update(['name'=>$request->name,'status'=>$request->status]);
        if($response)
        {
            return redirect('/industries');
        }
        else
        {
            return redirect('/industries/edit/'.$id);
        }
    }
    public function delete($id)
    {
        $response=Industries::where('id',$id)->delete();
        if($response)
        {
            return response()->json(['success'=>true,'message'=>'Industrie deleted successfully']);
        }
              return response()->json(['success'=>false,'message'=>'Opps something wrong']);

    }
}
