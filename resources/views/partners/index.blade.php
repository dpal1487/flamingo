@extends('layouts.app')

@section('title')

Partners

@endsection

@section('content')

<div class="main-content">

        <section class="section">

          <div class="section-header">

            <h1>Partners</h1>

            <div class="section-header-breadcrumb">

              <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>

              <div class="breadcrumb-item"><a href="#">Partners</a></div>

            </div>

          </div>

          <div class="row">

            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">

                  <div class="card-header text-right">

                    <a href="{{url('partner/create')}}" class="btn btn-primary float-right">Add Partner</a>

                  </div>

                  <div class="card-body">

                    <div class="table-responsive">

                      <table class="table table-bordered table-md">

                        <tbody><tr>

                          <th>Partner ID</th>

                          <th>Partner Name</th>

                          <th>CompleteUrl</th>

                          <th>TerminateUrl</th>

                          <th>QuotafullUrl</th>


                          <th>Action</th>

                        </tr>

                        @foreach($partners as $partner)

                        <tr>

                          <td>{{$partner->id}}</td>

                          <td class="no-wrap">{{$partner->name}}</td>

                          <td class="no-wrap"><button class="btn btn-secondary " data-val="{{$partner->complete_url}}">Click Here</button></td>

                          <td class="no-wrap"><button class="btn btn-secondary" data-val="{{$partner->terminate_url}}">Click Here</button></td>

                          <td class="no-wrap"><button class="btn btn-secondary" data-val="{{$partner->quotafull_url}}">Click Here</button></td>


                          <td class="no-wrap">

                            <a class="btn btn-primary" href="{{url('partner/'.$partner->id)}}"><i class="fa fa-edit"></i></a>

                            <button class="btn btn-danger remove-btn" data-id="{{$partner->id}}"><i class="fa fa-trash"></i></a>

                          </td>

                        </tr>

                        @endforeach

                      </tbody>



                      </table>

                    </div>

                  </div>

                  <div class="card-footer text-right">

                    {!! $partners->links('pagination::bootstrap-5') !!}


                  </div>

                </div>

              </div>

          </div>

        </section>

      </div>

      <!-- Modal -->

<div id="adModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Add Partner</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>

      <form id="addForm" action="{{url('/dashboard/partner/store')}}" method="post">

      <div class="modal-body">

        <div class="row">

          <div class="form-group col-sm-6">

            <label for="name">Partner Name</label>

            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter partner name"/>

          </div>

          <div class="form-group col-sm-6">

            <label for="terminate_url">TerminateUrl</label>

            <input type="text" class="form-control" id="terminate_url" name="terminate_url" required placeholder="Enter terminate url"/>

          </div>

          <div class="form-group col-sm-6">

            <label for="complete_url">Completes</label>

            <input type="text" class="form-control" id="complete_url" name="complete_url" required placeholder="Enter complete"/>

          </div>

          <div class="form-group col-sm-6">

            <label for="quotafull_url">Quotafull URL</label>

            <input type="text" class="form-control" id="quotafull_url" name="quotafull_url" required placeholder="Enter quotafull url"/>

          </div>

          <div class="form-group col-sm-6">

            <label for="complete">Complete URL</label>

            <input type="text" class="form-control" id="complete" name="complete" required placeholder="Enter complete url"/>

          </div>

        </div>

      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Submit</button>

        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>

      </div>

      </form>

    </div>



  </div>

</div>

@endsection

@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

  $(function () {

    $("#addForm").submit(function(){

      $.ajax({

        method: "POST",

        action: $(this).attr("action"),

        data: $(this).serialize(),

        success: function(data)

        {

          alert(data);

        }

      });

      return false;

    });
    $(".remove-btn").click(function()
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
        url: "/partner/remove/"+id,
        method: "post",
        success: function(data)
        {
          if(data.success)
          {
            swal(data.message, {
              icon: "success",
            }).then((value)=>{
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

  })

</script>

@endsection
