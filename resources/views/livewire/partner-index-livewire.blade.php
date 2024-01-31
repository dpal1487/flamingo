 <div class="row">

     <div class="col-12 col-md-12 col-lg-12">

         <div class="card">

             <div class="card-header">
                 <form action="{{url('/')}}" style="width:100%;">
                     <div class="row">
                         <div class="form-group col-sm-2 mb-0">
                             <select name="status" class="form-control" wire:model.live="status">
                                 <option value="" selected>Select Status</option>
                                 <option value="open">Open</option>
                                 <option value="close">Close</option>
                                 <option value="invoiced">Invoiced</option>
                                 <option value="archived">Archived</option>
                             </select>
                         </div>
                         <div class="form-group col-sm-3" style="position: absolute;right:0px;">
                             <input type="search" class="form-control" wire:model.live="query" placeholder="Search" />
                         </div>
                     </div>
                 </form>
             </div>
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-bordered table-md">
                         <thead>
                             <tr>
                                 <th>S.NO</th>
                                 <th>Survey ID</th>
                                 <th>Survey Name</th>
                                 <th>Comp</th>
                                 <th>InComp</th>
                                 <th>SC</th>
                                 <th>QF</th>
                                 <th>IR</th>
                                 <th>LOI</th>
                                 <th>Cost Ratio</th>
                                 <th>Status</th>
                                 <th>Add</th>
                                 <th>List</th>
                                 <th>Download</th>
                             </tr>
                         </thead>
                         <tbody class="project-list">
                             @if(!empty($projects) && count($projects))

                             @foreach($projects as $index => $project)

                             <tr>

                                 <td>{{$index+1}}</td>
                                 <td>{{$project->project_id}}</td>

                                 <td class="no-wrap">{{$project->project_name}} - {{$project->country}}</td>

                                 <td>{{count(\App\Models\PartnerSurvey::where(array('project_id'=>$project->id,'status'=>'complete'))->get())}}</td>

                                 <td>{{count(\App\Models\PartnerSurvey::where(array('project_id'=>$project->id,'status'=>'terminate'))->get())}}</td>
                                 <td>{{count(\App\Models\PartnerSurvey::where(array('project_id'=>$project->id,'status'=>''))->get())}}</td>

                                 <td>{{count(\App\Models\PartnerSurvey::where(array('project_id'=>$project->id,'status'=>'quotafull'))->get())}}</td>

                                 <td>{{$project->incedance_rate}}</td>

                                 <td>{{$project->time}}</td>
                                 <td>{{$project->cost}}</td>


                                 <td>{{strtoupper($project->status)}}</td>
                                 <th><button class="btn btn-outline-success" data-toggle="modal" data-target="#partnerModal" data-action="/survey/partner/store" data-name="{{$project->project_name}} - {{$project->country}} ({{$project->project_id}})" data-val="{{$project->id}}" id="partner-modal-btn" data-cpi="{{$project->cost}}">Add Partner</button></th>

                                 <th><button class="btn btn-outline-info" data-toggle="modal" data-target="#partnerList" data-val="{{$project->id}}" id="partnerListBtn">List Partner</button></th>
                                 <th><a href="{{url('survey/export/'.$project->id.'/'.$project->project_id)}}" class="btn btn-info">Download</a></th>

                             </tr>

                             @endforeach
                             @else
                             <td colspan="14">
                                 <h2 class="text-center mx-10 align-items-center">
                                     No Project Found</h2>
                             </td>
                             @endif

                         </tbody>

                     </table>

                 </div>

             </div>

             <div class="card-footer text-right">
                 <div class="row">
                     <div class="col-sm-12 d-flex align-items-center justify-content-between">
                         <span class="fw-bold text-gray-700">
                             Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }}
                             of {{ $projects->total() }} entries
                         </span>
                         {{ $projects->links() }}
                     </div>
                 </div>
             </div>
         </div>

     </div>

 </div>

 </div>