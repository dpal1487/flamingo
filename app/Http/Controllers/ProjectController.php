<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerSurveyResources;
use App\Models\Project;
use App\Models\Partner;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Country;
use App\Models\Industry;
use App\Models\PartnerSurvey;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
  private $data;
  public function __construct()
  {
    $this->data['countries'] = Country::orderBy('name', 'asc')->get();
  }
  public function index(Request $request)
  {
    $this->data['partners'] = Partner::orderBy('id', 'desc')->get();
    if ($request->ajax()) {
      return $this->projectFilter($request);
    } else {
      if (!empty($request->keyword)) {
        $this->data['projects'] = Project::where('project_name', 'like', '%' . $request->keyword . '%')->orWhere('project_id', 'like', '%' . $request->keyword . '%')->orderBy('id', 'desc')->paginate(15);
      } else {
        $this->data['projects'] = Project::orderBy('id', 'desc')->paginate(15);
      }
    }
    return view('project.index', $this->data);
  }
  public function create()
  {
    $this->data['partners'] = Partner::orderBy('id', 'DESC')->get();
    $this->data['industries'] = Industry::orderBy('name', 'asc')->get();
    return view('project.create', $this->data);
  }
  public function store(Request $request)
  {
    $id = IdGenerator::generate(['table' => 'projects', 'field' => 'project_id', 'length' => 10, 'prefix' => 'FLNG' . date('ym')]);
    $data = array(
      'project_id' => $id,
      'project_name' => $request->name,
      'industry_id' => $request->industry,
      'client' => $request->client,
      'client_live_url' => $request->client_live_url,
      'client_test_url' => $request->client_test_url,
      'country' => $request->country,
      'cost' => $request->cost,
      'time' => $request->time_period,
      'incedance_rate' => $request->ir,
      'number_of_complete' => $request->num_of_complete,
      'end_date' => $request->end_date,
      'remarks' => $request->remarks,
      'status' => $request->status
    );
    if (Project::create($data)) {
      return redirect('projects');
    }
  }
  public function addLinks(Request $request)
  {

    if ($pro = Project::where('id', $request->id)->first()) {
      $data = array(
        'project_id' => $pro->project_id,
        'project_name' => $pro->project_name,
        'client' => $pro->client,
        'client_live_url' => $request->client_live_url,
        'client_test_url' => $request->client_test_url,
        'country' => $request->country,
        'cost' => $request->cost,
        'number_of_complete' => $request->num_of_complete,
        'end_date' => $pro->end_date,
        'incedance_rate' => $request->ir,
        'time' => $pro->time,
        'remarks' => $pro->remarks,
        'status' => $request->status
      );
      if (Project::create($data)) {
        return response()->json(['success' => true, 'message' => 'Project added successfully.']);
      }
    } else {
      return response()->json(['success' => false, 'message' => 'Project Already Exists']);
    }
  }
  public function updateLinks(Request $request)
  {
    if (Project::where('id', $request->id)->first()) {
      $data = array(
        'client_live_url' => $request->client_live_url,
        'client_test_url' => $request->client_test_url,
        'status' => $request->status
      );
      if (Project::where(['id' => $request->id])->update($data)) {
        return response()->json(['success' => true, 'message' => 'Project update successfully.']);
      } else {
        return response()->json(['success' => false, 'message' => 'Project Already Exists']);
      }
    }
  }

  public function show($id)
  {

    $surveys = PartnerSurvey::where('project_id', $id)->get();

    $surveys = PartnerSurveyResources::collection($surveys);

    // foreach ($surveys as $value) {
    //   return $value;
    // }

    if (count($surveys) > 0) {
      return view('project.show', compact('surveys'));
    } else {
      return redirect()->back();
    }
  }


  public function edit($id)
  {
    $this->data['partners'] = Partner::orderBy('id', 'DESC')->get();
    $this->data['project'] = Project::where('id', $id)->first();
    $this->data['industries'] = Industry::orderBy('name', 'asc')->get();
    if ($this->data['project']) {
      return view('project.edit', $this->data);
    } else {
      return redirect('projects');
    }
  }


  public function update(Request $request)
  {
    $data = array(
      'project_name' => $request->name,
      'client' => $request->client,
      'industry_id' => $request->industry,
      'client_live_url' => $request->client_live_url,
      'client_test_url' => $request->client_test_url,
      'country' => $request->country,
      'cost' => $request->cost,
      'time' => $request->time_period,
      'incedance_rate' => $request->ir,
      'number_of_complete' => $request->num_of_complete,
      'end_date' => $request->end_date,
      'remarks' => $request->remarks,
      'status' => $request->status
    );
    if (Project::where('id', $request->id)->update($data)) {
      return redirect('projects');
    } else {
    }
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (Project::where('id', $id)->delete()) {
      return response()->json(['success' => true, 'message' => 'Project deleted successfully']);
    }
    return response()->json(['success' => false, 'message' => 'Opps something wrong']);
  }
  public function projectId()
  {
    do {
      $id = str::random(20);
    } while (Project::where('id', $id)->exists());
    return $id;
  }
  public function projectFilter($request)
  {
    $keyword = $request->keyword;
    $data = "";
    if (!empty($keyword)) {
      $projects = Project::where('project_name', 'like', '%' . $keyword . '%')->orWhere('project_id', 'like', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate(15);
    } else {
      $projects = Project::orderBy('id', 'desc')->paginate(15);
    }
    if (!empty($projects) && count($projects)) {
      foreach ($projects as $project) {
        $open = $project->status == "open" ? "selected" : "";
        $close = $project->status == "close" ? "selected" : "";
        $pause = $project->status == "pause" ? "selected" : "";
        $invoiced = $project->status == "invoiced" ? "selected" : "";
        $archived = $project->status == "archived" ? "selected" : "";
        $data .= '<tr>
          <td>' . $project->project_id . '</td>
          <td>' . strtoupper($project->client) . '_' . $project->project_name . ' - (' . $project->country . ')</td>
          <td class="td-link"><a href="' . $project->client_live_url . '">' . $project->client_live_url . '</button></td>
            <td class="td-link"><a href="' . $project->client_test_url . '">' . $project->client_test_url . '</button></td>
          <td>' . $project->time_preiod . '</td>
          <!-- <td>' . $project->end_date . '</td> -->
          <td>
            <select class="form-control status" data-id="' . $project->id . '">
              <option value="">Select status</option>
              <option value="open" ' . $open . '>Open</option>
              <option value="close" ' . $close . '>Close</option>
              <option value="pause" ' . $pause . '>Pause</option>
              <option value="invoiced" ' . $invoiced . '>Invoiced</option>
              <option value="archived" ' . $archived . '>Archived</option>
            </select>
          </td>
          <td><a class="btn btn-primary" href="' . url('project/' . $project->id) . '"><i class="fa fa-edit"></i></a>
          <button class="btn btn-info update-link" data-toggle="modal" data-target="#updateLink" data-pid="' . $project->project_id . '" data-id="' . $project->id . '" id="updateLinkBtn"><i class="fa fa-link"></i></button>
          <button class="btn btn-success add-link" data-toggle="modal" data-target="#addLink" data-pid="' . $project->project_id . '" data-id="' . $project->id . '" id="partnerListBtn"><i class="fa fa-plus"></i></button>
          <button class="btn btn-danger remove-btn"data-pid="' . $project->project_id . '" data-id="' . $project->id . '"><i class="fa fa-trash"></i></button></td>
        </tr>';
      }
      return array('projects' => $data, 'paginate' => (string)$projects->links());
    } else {
    }
  }
  public function updateStatus($id, Request $request)
  {
    if (Project::where('id', $id)->update(['status' => $request->status])) {
      return response()->json(['success' => true, 'message' => 'Project updated successfully']);
    }
    return response()->json(['success' => false, 'message' => 'Opps something wrong']);
  }
}
