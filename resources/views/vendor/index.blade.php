@extends('layouts.app')
@section('title')
Vendors
@endsection
@section('content')
<style>
  table th,table td
  {
    white-space: nowrap;
  }
</style>
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Vendors</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>
				<div class="breadcrumb-item"><a href="#">Vendors</a></div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
                  <div class="card-header">
                        <div class="row" style="width:100%;">
                          <div class="form-group col-sm-3 mb-1">
                            <input type="search" class="form-control search-input" placeholder="Search"/>
                          </div>
                        </div>
                  </div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-md">
							<thead>
								<th><input type="checkbox" class="checkbox-inline"/></th>
								<th>Vendor Project ID</th>
								<th>Project ID</th>
                				<th>Final ID Status</th>
								<th>Project Status</th>
								<th>Vendor List</th>
							</thead>
							<tbody>
                        	<?php $i=1;?>
							@foreach($projects as $project)
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$project->project_id}}</td>
                          <td>{{strtoupper($project->client)}}_{{$project->project_name}} - ({{$project->country}})</td>
                          <td>
                            <select class="form-control status" data-id="{{$project->id}}">
                              <option value="">Select status</option>
                              <option value="send">Send</option>
                              <option value="unsend">Unsend</option>
                              <option value="pending">Pending</option>
                            </select>
                          </td>
                          <td>
                          	{{strtoupper($project->status)}}
                          </td>
                          <td>
                          	<button class="btn btn-outline-info" data-toggle="modal" data-target="#partnerList" data-val="{{$project->id}}" id="partnerListBtn">List Partner</button>
                          </td>
                        </tr>
                        @endforeach
							</tbody>
						</table>
					</div>
				</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div id="partnerList" class="modal fade" role="dialog">

  <div class="modal-dialog modal-xl">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title">Partner Survey Complete Details</h5>

        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>

      <div class="modal-body">

        <table class="table table-bordered table-md">

          <thead>

            <tr>

              <th>Survey ID</th>

              <th>Vendor Name</th>
              <th>Vendor Project ID</th>

              <th>Project ID</th>

              <th>CPI</th>

              <th>Final ID's</th>

            </tr>

          </thead>
          <tbody>

          </tbody>
        </table>

      </div>

    </div>

  </div>

</div>
@endsection
@section('js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
$(function () {
  var action,modal;
  $('body').on('change','#partner_list', function() {
	  $.ajax({
	  	url:'survey/partner/show/'+$(this).val(),
	  	data:{_token:'{{csrf_token()}}'},
	  	method:'POST',
    	success: function(data)
	  	{
	  		if(data.success)
	  		{
  				$("#name").val(data.partner.name);
          $("#vid").val(data.partner.id);
  				$("#terminate_url").val(data.partner.terminate_url);
  				$("#complete_url").val(data.partner.complete_url);
  				$("#quotafull_url").val(data.partner.quotafull_url);
	  		}
	  	}
	  });
	});
  $("body").on('click',"#partner-modal-btn,#partnerListBtn",function(){
    $('#hidden-pid').val($(this).attr('data-val'));
    $('#pid').val($(this).attr('data-name'));
    $(".actual-cpi").text($(this).attr('data-cpi'));
    $("#partnerForm").attr("action",'/survey/partner/store');
  });
  $('#partnerForm').validate({ // initialize the plugin
    rules: {
      name: {
        required: true
        },
      survey_name: {
        required: true
        },
      cost:{
        required: true
        },
      terminate_url:{
        required: true
        },
      quotafull_url:{
        required: true
        },
      complete_url:{
        required: true
        },
      number_of_completes:{
        required: true
        },
      status:{
        required: true
        }
      },
    submitHandler: function (form) {
      $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data: $(form).serialize(),
        success: function (data) {
        if(data.success)
          {
            swal("Success", data.message, "success");
            $("#partnerModal").modal('hide');
          }
        else
          {
            swal("Error", data.message, "error");
          }
        }
      });
    return false; // required to block normal submit since you used ajax
    }
  });
  $("body").on("click","#partnerListBtn",function()
    {
      $("#partnerList tbody").html('');
      var pid=$(this).attr('data-val');
      $.ajax({
         type: "POST",
         url: "/vendor/partner/projects/"+pid,
         success: function (data) {
          if(data)
          {
            $("#partnerList tbody").html(data);
          }
          else
          {
            swal("Error", data.message, "error");
          }
         }
      });
    });
    $("body").on("click",".edit-partner-btn",function()
    {
      var id=$(this).attr("data-id");
      $('#hidden-id').val(id);
      $("#partnerForm").attr("action",'/survey/partner/update');
      $.ajax({
         type: "POST",
         url: "survey/partner/edit/"+id,
         success: function (data) {
          if(data.success)
          {
            $("#partnerModal #partner_list").val(data.partner.partner_id).attr("selected","selected");
            $("#partnerModal #name").val(data.partner.partner_name);
            $("#partnerModal #pid").val(data.partner.project.project_name +" - "+ data.partner.project.country +" ("+data.partner.project.project_id+")");
            $("#partnerModal #cost").val(data.partner.cost);
            $("#partnerModal #terminate_url").val(data.partner.terminate_url);
            $("#partnerModal #quotafull_url").val(data.partner.quotafull_url);
            $("#partnerModal #complete_url").val(data.partner.complete_url);
            $("#partnerModal #number_of_completes").val(data.partner.number_of_completes);
            $("#partnerModal #message").val(data.partner.message);
            $("#partnerModal #republic_url").val(data.partner.survey_link);
            $("#partnerModal #remarks").val(data.partner.remarks);
            $("#partnerModal #id").val(data.partner.id);
            $("#partnerModal #status").val(data.partner.status).attr("selected","selected");
          }
          else
          {
            alert(data.message);
          }
         }
      });
      });
      $('body').on('click','.view-status-btn',function()
      {
      var pid=$(this).attr('data-pid');
      var vid=$(this).attr("data-vid");
      $("#partnerList tbody").html('');
      $.ajax({
         type: "POST",
         url: "/survey/partner/status",
         data:{vid:vid,pid:pid},
         success: function (data) {
          if(data!="")
          {
            $("#partnerList tbody").html(data);
          }
          else
          {
            swal("Error", data.message, "error");
          }
         }
      });
    });

	/*$('.status').on('change', function() {
		var status = $(this).val();
		$.ajax({
			url:'projects/status/'+status,
			method: 'POST',
			success:function(data)
			{
				$(".project-list").html(data);
			}
		})
  });*/

  $("body").on('click','.remove-btn',function()
  {
    var id=$(this).attr('data-id');
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
        url: "/survey/partner/remove/"+id,
        method: "post",
        success: function(data)
        {
          if(data.success)
          {
            swal(data.message, {
              icon: "success",
            }).then((value)=>{
              $("#partnerList").modal('hide');
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
  $("body").on('keyup','.search-input',function()
  {
      $.ajax({
        url:'/surveys',
        method: 'GET',
        data:{keyword:$(this).val()},
        success:function(data)
        {
          $(".project-list").html(data.projects);
          $(".paginate-main").html(data.paginate);
        }
      }) ;
    })
	});
</script>

@endsection
