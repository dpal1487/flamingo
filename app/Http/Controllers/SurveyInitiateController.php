<?php

namespace App\Http\Controllers;

use App\Models\PartnerProject;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\PartnerSurvey;
use Illuminate\Support\Str;

class SurveyInitiateController extends Controller
{
    public function start(Request $request)
    {
        $pid = $request->pid;
        $uid = $request->uid;
        $ip = $request->ip();

        $partnerProject = PartnerProject::where(array('project_id' => $pid))->first();
        if ($partnerProject) {
            if ($project = Project::where(array('status' => 'open', 'id' => $partnerProject->project_id))->first()) {
                if (!PartnerSurvey::where(['project_id' => $project->id, 'partner_id' => $partnerProject->partner_id, 'uid' => $uid])->first()) {
                    $data = array('project_id' => $project->id, 'uid' => $uid, 'partner_id' => $partnerProject->partner_id, 'starting_ip' => $ip);
                    if ($id = PartnerSurvey::create($data)) {
                        $project = Project::where('id', $pid)->first();
                        $url = str_replace("toid", $id->id, $project->client_live_url);
                        return redirect($url);
                    }
                } else {
                    echo '<script>alert("Survey already attamped.")</script>';
                }
            } else {
                echo  '<script>alert("Not Live \n\n Project is not live please try again later.")</script>';
            }
        }
        echo '<script>alert("Project not found.")</script>';
    }

    public function uid()
    {
        $number = '';
        do {
            for ($i = 1; $i--; $i > 0) {
                $number .= Str::random();
            }
        } while (!empty(PartnerSurvey::where('uid', $number)->first(['uid'])));
        return $number;
    }
}
