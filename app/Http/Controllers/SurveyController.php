<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Partner;
use App\Models\PartnerProject;
use App\Exports\PartnerSurveysExport;
use App\Models\PartnerSurvey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SurveyController extends Controller
{
    private $data;
    public function index()
    {
        $this->data['partners'] = Partner::orderBy('id', 'desc')->get();
        return view('survey.index', $this->data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vid' => 'required',
            'pid' => 'required',
            'name' => 'required',
            'cost' => 'required|integer',
            'terminate_url' => 'required',
            'quotafull_url' => 'required',
            'complete_url' => 'required',
            'number_of_completes' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(),
            ]);
        }
        $host = Str::random();
        $data = array(
            'partner_id' => $request->vid,
            'project_id' => $request->pid,
            'partner_name' => $request->name,
            'survey_name' => $request->survey_name,
            'survey_link' => 'https://dashboard.flamingoinsights.com/surveyInitiate?pid=' . $request->pid . '&uid=' . $request->vid . '&toid=XXXXXX',
            'cost' => $request->cost,
            'number_of_completes' => $request->number_of_completes,
            'message' => $request->message,
            'remarks' => $request->remarks,
            'complete_url' => $request->complete_url,
            'terminate_url' => $request->terminate_url,
            'quotafull_url' => $request->quotafull_url,
            'status' => $request->status
        );
        if (!PartnerProject::where(array('project_id' => $request->pid, 'partner_id' => $request->vid))->first()) {
            if (PartnerProject::create($data)) {
                return response()->json(['success' => true, 'message' => 'Partner Added Successfully']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Partners Already Added']);
        }
    }
    public function partnerProjectList($pid)
    {
        $partners = PartnerProject::where('project_id', $pid)->get();
        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $project = Project::where('id', $pid)->first();
                $this->data .= '<tr>
                <td>PS - ' . $partner->id . '</td>
                <td>' . $partner->partner_name . '</td>
                <td>' . $project->project_name . ' - ' . $project->country . '</td>
                <td>' . $partner->created_at . '</td>
                <td><a href="' . $partner->survey_link . '">Click Here</a></td>
                <td>' . ucfirst($partner->status) . '</td>
                <td><button class="btn btn-primary edit-partner-btn" data-action="/survey/partner/update" data-ptid="' . $partner->project_id . '" data-pid="' . $partner->partner_id . '" data-toggle="modal" data-target="#partnerModal" data-id="' . $partner->id . '"><i class="fa fa-edit"></i></button>
                <button class="btn btn-info view-status-btn" data-pid="' . $partner->project_id . '" data-vid="' . $partner->partner_id . '" data-toggle="modal" data-target="#viewModal" data-id="' . $project->id . '"><i class="fa fa-eye"></i></button>
                <button class="btn btn-danger remove-btn" data-toggle="modal" data-id="' . $partner->id . '"><i class="fa fa-trash"></i></button></td>
                <td></td>
                </tr>';
            }
            return $this->data;
        } else {
            return '<tr>
            <td style="text-align:center;padding:20px;" colspan="8"><h3>No Results Found</h3></td><
            /tr>';
        }
    }
    public function partnerEdit($id)
    {
        $partner = PartnerProject::where('id', $id)->with('project')->first();
        return response()->json(['success' => true, 'partner' => $partner]);
    }
    public function updatePartnerSurvey(Request $request)
    {
        $this->data = array(
            'partner_id' => $request->vid,
            'project_id' => $request->pid,
            'partner_name' => $request->name,
            'survey_link' => 'https://dashboard.flamingoinsights.com/surveyInitiate?pid=' . $request->pid . '&uid=' . $request->vid . '&toid=XXXXXX',
            'cost' => $request->cost,
            'number_of_completes' => $request->number_of_completes,
            'message' => $request->message,
            'remarks' => $request->remarks,
            'complete_url' => $request->complete_url,
            'terminate_url' => $request->terminate_url,
            'quotafull_url' => $request->quotafull_url,
            'status' => $request->status
        );
        if (PartnerProject::where(['partner_id' => $request->vid, 'project_id' => $request->pid])->update($this->data)) {
            return response()->json(['success' => true, 'message' => 'Partner Update Successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Partners Already Added']);
        }
    }
    public function partner($id)
    {
        $partner = Partner::where('id', $id)->first();
        if ($partner) {
            return response()->json(['success' => true, 'partner' => $partner]);
        }
        return response()->json(['success' => false]);
    }
    public function surveyStatus(Request $request)
    {
        $project = Project::where(['id' => $request->pid])->first();
        if (!empty($project)) {
            return '<tr>
                <td>' . $project->project_id . '</td>
                <td class="no-wrap">' . $project->project_name . ' - ' . $project->country . '</td>
              <td>' . count(PartnerSurvey::where(array('project_id' => $request->pid, 'partner_id' => $request->vid, 'status' => 'complete'))->get()) . '</td>
              <td>' . count(PartnerSurvey::where(array('project_id' => $request->pid, 'partner_id' => $request->vid, 'status' => 'terminate'))->get()) . '</td>
              <td>' . count(PartnerSurvey::where(array('project_id' => $request->pid, 'partner_id' => $request->vid, 'status' => ''))->get()) . '</td>
              <td>' . count(PartnerSurvey::where(array('project_id' => $request->pid, 'partner_id' => $request->vid, 'status' => 'quotafull'))->get()) . '</td>
              <td>' . $project->incedance_rate . '</td>
              <td>' . $project->time . '</td>
              <td></td>
              <td><button class="btn btn-primary"><a class="text-white" target="_blank" href="survey/export/' . $request->pid . '/' . $request->vid . '"><i class="fa fa-download"></i></a></button></td>
            </tr>';
        }
    }
    public function destroy($id)
    {
        if (PartnerProject::where('id', $id)->delete()) {
            return response()->json(['success' => true, 'message' => 'Partner deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something wrong']);
    }
    public function export($pid, $ptid)
    {
        if (!empty($pid) && !empty($ptid)) {
            $array = array('pid' => $pid, 'ptid' => $ptid);
            $project_id = Project::where('id', $pid)->first()->project_id;
            $name = strtoupper(Partner::where('id', $ptid)->first()?->name);
            return Excel::download(new PartnerSurveysExport($array), $name . '_' . $project_id . '.xlsx');
        } else {
            return redirect()->back();
            // return Redirect::to('https://dashboard.flamingoinsights.com/');
        }
    }
}
