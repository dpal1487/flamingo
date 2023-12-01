<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surveys;
use App\Models\Projects;
use App\Models\Partners;
use App\Models\PartnerSurvey;
use Illuminate\Support\Str;

class SurveyInitiateController extends Controller
{
    public function start(Request $request)
    {
    	$pid=$request->pid;
    	$vid=$request->vid;
    	$toid=$request->toid;
    	$ip=$request->ip();
    	if(Projects::where(array('status'=>'open','id'=>$pid))->first())
    	{
	    	if(!PartnerSurvey::where(array('project_id'=>$pid,'toid'=>$toid))->first())
	    	{
                $uid=$this->uid();
	    		$data=array('uid'=>$uid,'project_id'=>$pid,'toid'=>$toid,'partner_id'=>$vid,'starting_ip'=>$ip);
	    		if(PartnerSurvey::create($data))
	    		{
	    			$url=Projects::where('id',$pid)->first();
                    $this->result_url=str_replace("RespondentID",$uid,$url->client_live_url);
	    			return redirect($this->result_url);
	    		}
	    	}
	    	else
	    	{
	    		echo '<script>alert("Survey already attamped.")</script>';
	    	}
    	}
    	else
    	{
    		return view('survey.close');
    	}
    }
    public function uid()
    {
    	$number = '';
    	do {
        	for ($i=1; $i--; $i>0) {
            	$number .= Str::random();
        	}
    	} while ( !empty(PartnerSurvey::where('uid', $number)->first(['uid'])) );
    	return $number;
    }
}
