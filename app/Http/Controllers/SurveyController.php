<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\Partners;
use App\Models\PartnerProjects;
use App\Exports\PartnerSurveys;
use App\Exports\PartnerSurveysExport;
use App\Models\PartnerSurvey;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SurveyController extends Controller
{
    private $data;
    public function index(Request $request)
    {
        $data['partners'] = Partners::orderBy('id', 'desc')->get();
        if ($request->ajax()) {
            return $this->projectFilter($request);
        } else {
            if (!empty($request->keyword)) {
                $data['projects'] = Projects::where('project_name', 'like', '%' . $request->keyword . '%')->orWhere('project_id', 'like', '%' . $request->keyword . '%')->orderBy('id', 'desc')->paginate(40);
            } else {
                $data['projects'] = Projects::orderBy('id', 'desc')->paginate(40);
            }
        }
        return view('survey.index', $data);
    }
    public function store(Request $request)
    {
        $host = Str::random();
        $data = array(
            'partner_id' => $request->vid,
            'project_id' => $request->pid,
            'partner_name' => $request->name,
            'survey_name' => $request->survey_name,
            'survey_link' => 'https://dashboard.flamingoinsights.com/surveyInitiate?vid=' . $request->vid . '&pid=' . $request->pid . '&toid=XXXXXX',
            'cost' => $request->cost,
            'number_of_completes' => $request->number_of_completes,
            'message' => $request->message,
            'remarks' => $request->remarks,
            'complete_url' => $request->complete_url,
            'terminate_url' => $request->terminate_url,
            'quotafull_url' => $request->quotafull_url,
            'status' => $request->status
        );
        if (!PartnerProjects::where(array('project_id' => $request->pid, 'partner_id' => $request->vid))->first()) {
            if (PartnerProjects::create($data)) {
                return response()->json(['success' => true, 'message' => 'Partner Added Successfully']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Partners Already Added']);
        }
    }
    public function partnerProjectList($pid)
    {
        $partners = PartnerProjects::where('project_id', $pid)->get();
        if (count($partners) > 0) {
            foreach ($partners as $partner) {
                $project = Projects::where('id', $pid)->first();
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
        $partner = PartnerProjects::where('id', $id)->with('project')->first();
        return response()->json(['success' => true, 'partner' => $partner]);
    }
    public function updatePartnerSurvey(Request $request)
    {
        $this->data = array(
            'partner_id' => $request->vid,
            'project_id' => $request->pid,
            'partner_name' => $request->name,
            'survey_link' => 'https://dashboard.flamingoinsights.com/surveyInitiate?pid=' . $request->pid . '&vid=' . $request->vid . '&toid=XXXXXX',
            'cost' => $request->cost,
            'number_of_completes' => $request->number_of_completes,
            'message' => $request->message,
            'remarks' => $request->remarks,
            'complete_url' => $request->complete_url,
            'terminate_url' => $request->terminate_url,
            'quotafull_url' => $request->quotafull_url,
            'status' => $request->status
        );
        if (PartnerProjects::where(['partner_id' => $request->vid, 'project_id' => $request->pid])->update($this->data)) {
            return response()->json(['success' => true, 'message' => 'Partner Update Successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Partners Already Added']);
        }
    }
    public function partner($id)
    {
        $partner = Partners::where('id', $id)->first();
        if ($partner) {
            return response()->json(['success' => true, 'partner' => $partner]);
        }
        return response()->json(['success' => false]);
    }
    public function surveyStatus(Request $request)
    {
        //return $request->all();
        $project = Projects::where(['id' => $request->pid])->first();
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
    public function projectFilter($request)
    {
        $keyword = $request->keyword;
        $projects = "";
        if (!empty($keyword)) {
            $projects = Projects::where('project_name', 'like', '%' . $keyword . '%')->orWhere('project_id', 'like', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate(15);
        } else {
            $projects = Projects::orderBy('id', 'desc')->paginate(15);
        }
        if (!empty($projects) && count($projects)) {
            foreach ($projects as $project) {
                $this->data .= '<tr>
            <td>' . $project->id . '</td>
            <td>' . $project->project_id . '</td>
            <td class="no-wrap">' . $project->project_name . '-' . $project->country . '</td>
            <td>' . count(PartnerSurvey::where(array('project_id' => $project->id, 'status' => 'complete'))->get()) . '</td>
            <td>' . count(PartnerSurvey::where(array('project_id' => $project->id, 'status' => 'terminate'))->get()) . '</td>
            <td>' . count(PartnerSurvey::where(array('project_id' => $project->id, 'status' => ''))->get()) . '</td>
            <td>' . count(PartnerSurvey::where(array('project_id' => $project->id, 'status' => 'quotafull'))->get()) . '</td>
            <td>' . $project->incedance_rate . '</td>
            <td>' . $project->time . '</td>
            <td></td>
            <td>' . strtoupper($project->status) . '</td>
            <th><button class="btn btn-outline-success" data-toggle="modal" data-target="#partnerModal" data-action="/survey/partner/store" data-name="' . $project->project_name . ' - ' . $project->country . ' (' . $project->project_id . ')" data-val="' . $project->id . '" id="partner-modal-btn" data-cpi="' . $project->cost . '">Add Partner</button></th>
            <th><button class="btn btn-outline-info" data-toggle="modal" data-target="#partnerList" data-val="' . $project->id . '" id="partnerListBtn">List Partner</button></th>
            </tr>';
            }
            return array('projects' => $this->data, 'paginate' => (string)$projects->links());
        } else {
        }
    }
    public function destroy($id)
    {
        if (PartnerProjects::where('id', $id)->delete()) {
            return response()->json(['success' => true, 'message' => 'Partner deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something wrong']);
    }
    public function export($pid, $ptid)
    {
        //return $pid;
        //return $ptid;
        if (!empty($pid) && !empty($ptid)) {
            $array = array('pid' => $pid, 'ptid' => $ptid);
            $project_id = Projects::where('id', $pid)->first()->project_id;
            $name = strtoupper(Partners::where('id', $ptid)->first()?->name);

            // return $name;
            return Excel::download(new PartnerSurveysExport($array), $name . '_' . $project_id . '.xlsx');
        } else {
            return redirect()->back();
            // return Redirect::to('https://dashboard.flamingoinsights.com/');
        }
    }
}
