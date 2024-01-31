    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row" style="width:100%;">
                        <div class="col-sm-2">
                            <a href="{{url('project/create')}}" class="btn btn-primary">Add Project</a>
                        </div>
                        <div class="form-group col-sm-3" style="position: absolute;right:0px;">
                            <input type="search" class="form-control" wire:model.live="query" placeholder="Search" />
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th>Project ID</th>
                                    <th>Project Name</th>
                                    <th>Client Live URL</th>
                                    <th>Client Test URL</th>
                                    <th>Gender</th>
                                    <th>Min Age</th>
                                    <th>Max Age</th>
                                    <th>Count</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="project-list">
                                @if(!empty($projects) && count($projects))

                                @foreach($projects as $project)
                                <tr>
                                    <td>{{$project->project_id}}</td>
                                    <td>{{strtoupper($project->client?->name)}}_{{$project->project_name}} - ({{$project->country}})</td>
                                    <td class="td-link"><a href="{{$project->client_live_url}}">{{$project->client_live_url}}</button></td>
                                    <td class="td-link"><a href="{{$project->client_test_url}}">{{$project->client_test_url}}</button></td>
                                    <td>{{strtoupper($project->gender)}}</td>
                                    <td>{{$project->min_age}}</td>
                                    <td>{{$project->max_age}}</td>
                                    <td><input type="number" class="form-control count" style="width: 80px;" id="count" value="{{ $project->count }}" data-id="{{$project->id}}" />
                                    </td>
                                    <td>
                                        <select class="form-control status" style="width:100px" data-id="{{$project->id}}">
                                            <option value="">Select status</option>
                                            <option value="open" {{$project->status == 'open' ? 'selected' : ''}}>Open</option>
                                            <option value="close" {{$project->status == 'close' ? 'selected' : ''}}>Close</option>
                                            <option value="pause" {{$project->status == 'pause' ? 'selected' : ''}}>Pause</option>
                                            <option value="invoiced" {{$project->status == 'invoiced' ? 'selected' : ''}}>Invoiced</option>
                                            <option value="archived" {{$project->status == 'archived' ? 'selected' : ''}}>Archived</option>
                                        </select>
                                    </td>
                                    <td><a class="btn btn-primary" href="{{url('project/'.$project->id).'/edit'}}"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-info update-link" data-toggle="modal" data-target="#updateLink" data-pid="{{$project->project_id}}" data-id="{{$project->id}}" id="updateLinkBtn"><i class="fa fa-link"></i></button>
                                        <button class="btn btn-success add-link" data-toggle="modal" data-target="#addLink" data-pid="{{$project->project_id}}" data-id="{{$project->id}}" id="partnerListBtn"><i class="fa fa-plus"></i></button>
                                        <button class="btn btn-danger remove-btn" data-pid="{{$project->project_id}}" data-id="{{$project->id}}"><i class="fa fa-trash"></i></button>
                                    </td>
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