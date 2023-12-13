<?php

namespace App\Http\Controllers;

use App\Exports\ExportsProjectDownload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Exports\SurveyExport;
use App\Models\PartnerProject;
use App\Models\PartnerSurvey;
use Maatwebsite\Excel\Facades\Excel;

class RespondentController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $q = $request->q;
        $status = $request->status;

        $partnerSurvey = PartnerSurvey::find($request->uid);

        if (!empty($type) && !empty($q) && !empty($status)) {
            $data['surveys'] = Survey::select('pid')->where($type, 'like', '%' . $q . '%')->where('status', $status)->orderBy('id', 'desc')->distinct('pid')->paginate(20);
        } else {
            $data['surveys'] = Survey::select('pid')->orderBy('id', 'desc')->distinct('pid')->paginate(20);
        }
        return view('respondents', $data);
    }
    public function redirect(Request $request)
    {
        $status = $request->status;
        $uid = $request->uid;

        $partnerSurvey = PartnerSurvey::find($uid);
        $partnerProject = PartnerProject::where(['partner_id' => $partnerSurvey->partner_id, 'project_id' => $partnerSurvey->project_id])->first();
        $url = str_replace("RespondentID", $partnerSurvey->uid, $partnerProject->complete_url);
        return $url;
        if (!empty($type) && !empty($q) && !empty($status)) {
            $data['surveys'] = Survey::select('pid')->where($type, 'like', '%' . $q . '%')->where('status', $status)->orderBy('id', 'desc')->distinct('pid')->paginate(20);
        } else {
            $data['surveys'] = Survey::select('pid')->orderBy('id', 'desc')->distinct('pid')->paginate(20);
        }
        return view('respondents', $data);
    }

    public function status($id)
    {
        $completes = PartnerProject::where(array('pid' => $id, 'status' => 'complete'))->get();
        $terminates = Survey::where(array('pid' => $id, 'status' => 'terminate'))->get();
        $quotafull = Survey::where(array('pid' => $id, 'status' => 'quotafull'))->get();
        $incidence = count($completes) / count($terminates) * 100;
        $data = '
        <td>PS - ' . $id . '</td>
        <td>' . count($completes) . '</td>
        <td>' . count($terminates) . '</td>
        <td>' . count($quotafull) . '</td>
        <td>' . intval($incidence) . '%</td>
        <td><a class="btn btn-primary" target="_blank" href="/respondents/export/' . $id . '"><i class="fa fa-download"></i></a>
        <a class="btn btn-primary" target="_blank" href="/respondents/results/' . $id . '"><i class="fa fa-eye"></i></a></td>
        ';
        return $data;
    }
    public function results(Request $request)
    {
        $status = $request->status;
        if (!empty($status)) {
            $data['surveys'] = Survey::orderBy('id', 'desc')->where(array('pid' => $request->segment(3), 'status' => $status))->paginate(20);
        } else {
            $data['surveys'] = Survey::orderBy('id', 'desc')->where(array('pid' => $request->segment(3)))->paginate(20);
        }
        return view('results', $data);
    }
    public function export($id)
    {
        return Excel::download(new SurveyExport($id), $id . '.xlsx');
    }
    public function projectDownload(Request $request)
    {
        return Excel::download(new ExportsProjectDownload($request->start_date, $request->end_date), strtotime($request->start_date) . '.xlsx');
    }
}
