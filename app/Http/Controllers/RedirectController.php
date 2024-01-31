<?php

namespace App\Http\Controllers;

use App\Models\PartnerProject;
use App\Models\PartnerSurvey;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public $status, $partnerSurvey, $project, $data, $url;
    public function __construct()
    {
        $this->status = ['complete', 'terminate', 'quotafull', 'security-terminate'];
    }
    public function surveyEnd(Request $request)
    {
        return $request;
        if (in_array($request->status, $this->status)) {
            if ($this->partnerSurvey = PartnerSurvey::where(['id' => $request->uid])->first()) {
                if (PartnerSurvey::where(['id' => $request->uid, 'status' => null])->first()) {
                    PartnerSurvey::where(['id' => $request->uid])->update(['status' => $request->status, 'end_ip' => $request->ip()]);
                }
                if ($this->project = PartnerProject::where(['id' => $this->partnerSurvey->partner_id])->first()) {
                    if ($request->status == 'complete') {
                        $this->data = array(
                            'headTitle' => 'Completed',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Completed'),
                            'message' => "Congratulations! You have successfully completed the survey.",
                            'redirect' => $this->project->complete_url
                        );
                        $this->url = str_replace('ProjectID', $this->project->project->project_id, $this->project->complete_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->uid, $this->url);
                    }
                    if ($request->status == 'terminate') {
                        $this->data = array(
                            'headTitle' => 'Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                        $this->url = str_replace('ProjectID', $this->project->project->project_id, $this->project->terminate_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->uid, $this->url);
                    }
                    if ($request->status == 'quotafull') {
                        $this->data = array(
                            'headTitle' => 'Quotafull',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Quotafull'),
                            'message' => "Thank you very much for your participation. Unfortunately, the quota was reached for your demographic group.",
                        );
                        $this->url = str_replace('ProjectID', $this->project->project->project_id, $this->project->quotafull_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->user_id, $this->url);
                    }
                    if ($request->status == 'security-terminate') {
                        $this->data = array(
                            'headTitle' => 'Security Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                        $this->url = str_replace('ProjectID', $this->project->project->project_id, $this->project->security_terminate_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->user_id, $this->url);
                    }
                    return redirect($this->url);
                }
            } else {
                return '<script>alert("Respondent Not Found.")</script>';
            }
        }
        return redirect(env('APP_URL'));
    }
}
