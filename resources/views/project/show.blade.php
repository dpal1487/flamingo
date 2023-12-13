@extends('layouts.app')
@section('title')
Surveys
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
      <h1>Surveys</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Surveys</a></div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="row mb-5" style="width:100%; ">

              <div class="form-group col-sm-3" style="position: absolute;right:0px;">
                <input type="search" class="form-control search-input" placeholder="Search" />
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md">
                @if($surveys)
                <thead>
                  <tr>
                    <th>Survey ID</th>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Startting IP</th>
                    <th>End IP</th>
                    <th>Duration</th>
                    <th>Date/Time</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody class="project-list">
                  @foreach($surveys as $survey)
                  <tr>
                    <td>{{$survey->id}}</td>
                    <td>{{$survey->project->project_id}}</td>
                    <td>{{$survey->project->project_name}}</td>
                    <td>{{$survey->starting_ip}}</td>
                    <td>{{$survey->end_ip}}</td>
                    <td>{{$survey->duration}}</td>
                    <td>{{$survey->date}}</td>
                    <td>
                      @if ($survey->status == '')
                      <div class="badge badge-light">Incomplete</div>
                      @elseif ($survey->status == 'complete')
                      <div class="badge badge-success">{{$survey->status}}</div>
                      @elseif($survey->status == 'quotafull')
                      <div class="badge badge-info">{{$survey->status}}</div>
                      @elseif($survey->status == 'terminate')
                      <div class="badge badge-danger">{{$survey->status}}</div>
                      @elseif($survey->status == 'security-terminate')
                      <div class="badge badge-warning">{{$survey->status}}</div>
                      @endif
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
          </div>
        </div>
      </div>
    </div>
  </section>
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
          $(".paginate-main").html(data.paginate);
        }
      });
    })
  });
</script>
@endsection