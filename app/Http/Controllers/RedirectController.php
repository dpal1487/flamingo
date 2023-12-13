<?php

namespace App\Http\Controllers;

use App\Models\PartnerProject;
use App\Models\PartnerSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RedirectController extends Controller
{
    public $status, $partnerSurvey, $project, $data, $url;
    public function __construct()
    {
        $this->status = ['complete', 'terminate', 'quotafull', 'security-terminate'];
    }
    public function surveyEnd(Request $request)
    {
        if (in_array($request->segment(2), $this->status)) {
            if ($this->partnerSurvey = PartnerSurvey::where(['id' => $request->uid])->first()) {
                if (PartnerSurvey::where(['id' => $request->uid, 'status' => null])->first()) {
                    PartnerSurvey::where(['id' => $request->uid])->update(['status' => $request->segment(2), 'end_ip' => $request->ip()]);
                }
                if ($this->project = PartnerProject::where(['id' => $this->partnerSurvey->supplier_project_id])->first()) {
                    if ($request->segment(2) == 'complete') {
                        $this->data = array(
                            'headTitle' => 'Completed',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Completed'),
                            'message' => "Congratulations! You have successfully completed the survey.",
                            'redirect' => $this->project
                        );
                        $this->url = str_replace('ProjectID', $this->project->project_link->project->project_id, $this->project->complete_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->user_id, $this->url);
                    }
                    if ($request->segment(2) == 'terminate') {
                        $this->data = array(
                            'headTitle' => 'Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                        $this->url = str_replace('ProjectID', $this->project->project_link->project->project_id, $this->project->terminate_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->user_id, $this->url);
                    }
                    if ($request->segment(2) == 'quotafull') {
                        $this->data = array(
                            'headTitle' => 'Quotafull',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Quotafull'),
                            'message' => "Thank you very much for your participation. Unfortunately, the quota was reached for your demographic group.",
                        );
                        $this->url = str_replace('ProjectID', $this->project->project_link->project->project_id, $this->project->quotafull_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->user_id, $this->url);
                    }
                    if ($request->segment(2) == 'security-terminate') {
                        $this->data = array(
                            'headTitle' => 'Security Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                        $this->url = str_replace('ProjectID', $this->project->project_link->project->project_id, $this->project->security_terminate_url);
                        $this->url = str_replace('RespondentID', $this->partnerSurvey->user_id, $this->url);
                    }
                } else {
                    if ($request->segment(2) == 'complete') {
                        $this->data = array(
                            'headTitle' => 'Completed',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Completed'),
                            'message' => "Congratulations! You have successfully completed the survey.",
                            'redirect' => $this->project
                        );
                    }
                    if ($request->segment(2) == 'terminate') {
                        $this->data = array(
                            'headTitle' => 'Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                    }
                    if ($request->segment(2) == 'quotafull') {
                        $this->data = array(
                            'headTitle' => 'Quotafull',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Quotafull'),
                            'message' => "Thank you very much for your participation. Unfortunately, the quota was reached for your demographic group.",
                        );
                    }
                    if ($request->segment(2) == 'security-terminate') {
                        $this->data = array(
                            'headTitle' => 'Security Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                    }
                }
            } else {

                if (!PartnerSurvey::where(['user_id' => $request->uid, 'status' => $request->segment(2), 'project_id' => $request->pid])->first()) {
                    PartnerSurvey::create(['user_id' => $request->uid, 'status' => $request->segment(2), 'project_id' => $request->pid, 'end_ip' => $request->ip()]);
                    if ($request->segment(2) == 'complete') {
                        $this->data = array(
                            'headTitle' => 'Completed',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Completed'),
                            'message' => "Congratulations! You have successfully completed the survey.",
                            'redirect' => $this->project
                        );
                    }
                    if ($request->segment(2) == 'terminate') {
                        $this->data = array(
                            'headTitle' => 'Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                    }
                    if ($request->segment(2) == 'quotafull') {
                        $this->data = array(
                            'headTitle' => 'Quotafull',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Quotafull'),
                            'message' => "Thank you very much for your participation. Unfortunately, the quota was reached for your demographic group.",
                        );
                    }
                    if ($request->segment(2) == 'security-terminate') {
                        $this->data = array(
                            'headTitle' => 'Security Terminated',
                            'success' => true,
                            'title' => strtoupper('Your survey has been Terminated'),
                            'message' => "Thank you very much for your participation. Unfortunately, at the moment we are looking for a diffrent profile to match survey's conditions.",
                        );
                    }
                } else {
                    $this->data = array(
                        'headTitle' => 'Already Completed',
                        'success' => true,
                        'title' => strtoupper('You have already completed the survey.'),
                        'message' => "Thank you very much for your participation. you have already completed the survey..",
                    );
                }
            }
            return view('respondents', compact($this->data, $this->url));

            // return Inertia::render('Survey/Redirect', [
            //     'data' => $this->data,
            //     'redirect' => $this->url
            // ]);
        }
        return Redirect::to(env('APP_URL'));
    }
}
