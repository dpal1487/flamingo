@extends('layouts.app')
@section('title')
Projects
@endsection
@section('head')
<style>
  .td-link {
    max-width: 150px;
  }

  .td-link a {
    display: inline-block;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    padding: 0;
    width: 100%;
  }
</style>
@endsection
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Projects</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Projects</a></div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row" style="width:100%;">
              <div class="col-sm-2">
                <a href="{{url('project/create')}}" class="btn btn-primary">Add Project</a>
              </div><!--
                          <div class="col-sm-2">
                            <select class="form-control search_status">
                              <option value="">Select status</option>
                              <option value="open">Open</option>
                              <option value="close">Close</option>
                              <option value="pause">Pause</option>
                              <option value="invoiced">Invoiced</option>
                              <option value="archived">Archived</option>
                            </select>
                          </div> -->
              <div class="form-group col-sm-3" style="position: absolute;right:0px;">
                <input type="search" class="form-control search-input" placeholder="Search" />
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md">
                @if(count($projects)>0)
                <thead>
                  <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Client Live URL</th>
                    <th>Client Test URL</th>
                    <th>Count</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="project-list">
                  @foreach($projects as $project)
                  <tr>
                    <td>{{$project->project_id}}</td>
                    <td>{{strtoupper($project->client)}}_{{$project->project_name}} - ({{$project->country}})</td>
                    <td class="td-link"><a href="{{$project->client_live_url}}">{{$project->client_live_url}}</button></td>
                    <td class="td-link"><a href="{{$project->client_test_url}}">{{$project->client_test_url}}</button></td>
                    <td><input type="number" class="form-control" style="width: 80px;" id="count" value="{{ $project->count }}" data-id="{{$project->id}}" />
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
                </tbody>
                @else
                <h2 class="text-center">No Project Found</h2>
                @endif
              </table>
            </div>
          </div>
          <div class="card-footer text-right paginate-main">
            {!! $projects->links('pagination::bootstrap-5') !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Vendor List Modal -->
<div id="addLink" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Link</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{url('project/new-link')}}" id="addLinkForm" method="post">
        <div class="modal-body">
          {{csrf_field()}}
          <div class="row">
            <div class="form-group col-sm-6">
              <input type="hidden" name="id" class="pid" />
              <label for="client_live_url">Client Live URL</label>
              <input type="text" class="form-control" id="client_live_url" name="client_live_url" required placeholder="Client live url" />
            </div>
            <div class="form-group col-sm-6">
              <label for="client_test_url">Client Test URL</label>
              <input type="text" class="form-control" id="client_test_url" name="client_test_url" required placeholder="Client test url" />
            </div>
            <div class="form-group col-sm-6">
              <label for="country">Country</label>
              <select class="form-control" name="country" id="country">
                <option value="">--Select Country--</option>
                @foreach($countries as $country)
                <option value="{{$country->iso2}}">{{$country->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-sm-6">
              <label for="cost">Cost/Interview</label>
              <input type="text" class="form-control" id="cost" name="cost" required placeholder="Cost per interview" />
            </div>
            <div class="form-group col-sm-6">
              <label for="time_period">Time Period (In Minutes)</label>
              <input type="text" class="form-control" id="time_period" name="time_period" required placeholder="Time Period (In Minutes)" />
            </div>
            <div class="form-group col-sm-6">
              <label for="ir">Incedance Rate</label>
              <input type="text" class="form-control" id="ir" name="ir" required placeholder="Incedance Rate" />
            </div>
            <div class="form-group col-sm-6">
              <label for="num_of_complete">Number Of Completes</label>
              <input type="text" class="form-control" id="num_of_complete" name="num_of_complete" required placeholder="Number of complete" />
            </div>
            <div class="form-group col-sm-6">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="open">Open</option>
                <option value="close">Close</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button data-dismiss="modal" class="btn btn-info">Back</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Update Link Modal -->
<div id="updateLink" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Link</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{url('project/update-link')}}" id="updateLinkForm" method="post">
        <div class="modal-body">
          {{csrf_field()}}
          <div class="row">
            <div class="form-group col-sm-12">
              <input type="hidden" name="id" class="pid" />
              <label for="client_live_url">Client Live URL</label>
              <input type="text" class="form-control" id="client_live_url" name="client_live_url" required placeholder="Client live url" />
            </div>
            <div class="form-group col-sm-12">
              <label for="client_test_url">Client Test URL</label>
              <input type="text" class="form-control" id="client_test_url" name="client_test_url" required placeholder="Client test url" />
            </div>
            <div class="form-group col-sm-12">
              <label for="status">Status</label>
              <select class="form-control" name="status">
                <option value="open">Open</option>
                <option value="close">Close</option>
                <option value="pause">Pause</option>
                <option value="invoiced">Invoiced</option>
                <option value="archived">Archived</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button data-dismiss="modal" class="btn btn-info">Back</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  $(function() {
    $('#addLinkForm').validate({
      rules: {
        "client_live_url": {
          required: true
        },
        "country": {
          required: true
        },
        "cost": {
          required: true
        },
        "time_period": {
          required: true
        },
        "ir": {
          required: true
        },
        "num_of_complete": {
          required: true
        }
      },
      submitHandler: function(form) {
        $.ajax({
          url: form.action,
          type: form.method,
          data: $(form).serialize(),
          success: function(data) {
            if (data.success) {
              swal(data.message, {
                icon: "success",
              }).then((value) => {
                window.location.reload();
              });
              return;
            } else {
              alert(response.message);
            }
          }
        });
        return false;
      }
    });
    $('#updateLinkForm').validate({
      rules: {
        "client_live_url": {
          required: true
        },
        "client_live_url": {
          required: true
        }
      },
      submitHandler: function(form) {
        $.ajax({
          url: form.action,
          type: form.method,
          data: $(form).serialize(),
          success: function(data) {
            if (data.success) {
              swal(data.message, {
                icon: "success",
              }).then((value) => {
                window.location.reload();
              });
              return;
            } else {
              alert(response.message);
            }
          }
        });
        return false;
      }
    });
    $("body").on('click', '#partnerListBtn,#updateLinkBtn', function() {
      $('.pid').val($(this).attr('data-id'));
    });
    $(".remove-btn").click(function() {
      var id = $(this).attr('data-id');
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this imaginary file!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "/project/remove/" + id,
              method: "post",
              success: function(data) {
                if (data.success) {
                  swal(data.message, {
                    icon: "success",
                  }).then((value) => {
                    window.location.reload();
                  });
                  return;
                }
                swal(data.message);
              }
            })

          } else {
            swal("Your imaginary file is safe!");
          }
        });
    });
    $('body').on('change', '.status', function() {
      var id = $(this).attr('data-id');
      $.ajax({
        url: "/project/update/status/" + id,
        method: "post",
        data: {
          status: $(this).val()
        },
        success: function(data) {
          if (data.success) {
            swal(data.message, {
              icon: "success",
            });
            return;
          }
          swal(data.message);
        }
      });
    });
    $("body").on('keyup', '.search-input', function() {
      $.ajax({
        url: '/projects',
        method: 'GET',
        data: {
          keyword: $(this).val()
        },
        success: function(data) {
          $(".project-list").html(data.projects);
        }
      });
    })
  });
</script>
@endsection