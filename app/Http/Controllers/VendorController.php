<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Projects;
use App\PartnerProjects;
class VendorController extends Controller
{
    private $data;
    public function index()
    {
        $this->data['projects']=Projects::orderBy('project_id','asc')->/*where('status','close')->or*/Where('status','invoiced')->paginate(15);
        return view('vendor.index',$this->data);
    }

    public function partnerProjectList($pid)
    {
        $partners=PartnerProjects::where('project_id',$pid)->get();
        if(count($partners)>0)
        {
            foreach($partners as $partner)
            {
                $project=Projects::where('id', $pid)->first();
                $this->data.='<tr>
                <td>PS - '.$partner->id.'</td>
                <td>'.$partner->partner_name.'</td>
                <td>'.$project->project_id.'</td>
                <td>'.$project->project_name.' - '.$project->country.'</td>
                <td>&#36; '.$partner->cost.'</td>
                <td><textarea class="form-control">';

                $this->data.='</textarea></td>
                </tr>';
            }
            return $this->data;
        }
        else
        {
            return '<tr>
            <td style="text-align:center;padding:20px;" colspan="8"><h3>No Results Found</h3></td><
            /tr>';
        }   
    }
}
