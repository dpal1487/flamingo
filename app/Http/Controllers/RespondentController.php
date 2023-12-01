<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Surveys;
use App\Exports\Survey;
use App\Exports\ProjectDownload;
use Excel;
class RespondentController extends Controller
{
    public function index(Request $request)
    {
        $type=$request->type;
        $q=$request->q;
        $status=$request->status;
        if(!empty($type) && !empty($q) && !empty($status))
        {
            $data['surveys']=Surveys::select('pid')->where($type, 'like', '%' . $q . '%')->where('status',$status)->orderBy('id','desc')->distinct('pid')->paginate(20);
        }
        else
        {
            $data['surveys']=Surveys::select('pid')->orderBy('id','desc')->distinct('pid')->paginate(20);
        }
        return view('respondents',$data);
    }
    public function status($id)
    {
        $completes=Surveys::where(array('pid'=>$id,'status'=>'complete'))->get();        
        $terminates=Surveys::where(array('pid'=>$id,'status'=>'terminate'))->get();        
        $quotafull=Surveys::where(array('pid'=>$id,'status'=>'quotafull'))->get();    
        $incidence=count($completes)/count($terminates)*100;   
        $data='
        <td>PS - '.$id.'</td>
        <td>'.count($completes).'</td>
        <td>'.count($terminates).'</td>
        <td>'.count($quotafull).'</td>
        <td>'.intval($incidence).'%</td>
        <td><a class="btn btn-primary" target="_blank" href="/respondents/export/'.$id.'"><i class="fa fa-download"></i></a>
        <a class="btn btn-primary" target="_blank" href="/respondents/results/'.$id.'"><i class="fa fa-eye"></i></a></td>
        ';
        return $data;   
    }
    public function results(Request $request)
    {
        $status=$request->status;
        if(!empty($status))
        {
            $data['surveys']=Surveys::orderBy('id','desc')->where(array('pid'=>$request->segment(3),'status'=>$status))->paginate(20);
        }
        else
        {
            $data['surveys']=Surveys::orderBy('id','desc')->where(array('pid'=>$request->segment(3)))->paginate(20);
        }
        return view('results',$data);
    }
    public function export($id) 
    {
        return Excel::download(new Survey($id), $id.'.xlsx');
    }
    public function projectDownload(Request $request)
    {
        return Excel::download(new ProjectDownload($request->start_date,$request->end_date), strtotime($request->start_date).'.xlsx');
    }
}
