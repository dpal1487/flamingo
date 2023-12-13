@extends('layouts.app')
@section('title')
Create | Industry
@endsection
@section('content')
<div class="main-content" style="min-height: 659px;">
  <section class="section">
    <div class="section-header">
      <h1>Industry Edit</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="/">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="/industry">Industry</a></div>
        <div class="breadcrumb-item"><a href="#">Create</a></div>
      </div>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-8 col-lg-8">
          <div class="card">
            <div class="card-header">
              <h4>Industry Form</h4>
            </div>
            <form>
              <div class="card-body m-0">
                <div class="alert alert-danger print-error-msg" style="display:none">
                  <ul></ul>
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="name">Industry Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter industry name" required />
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" name="status" id="status" required>
                    <option value="1">Published</option>
                    <option value="0">Unpublished</option>
                  </select>
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary mr-1 btn-submit" type="submit">Submit</button>
                <a href="/industries" class="btn btn-info mr-1">Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection
  @section('js')
  <script src="{{url('assets/bundles/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{url('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
    $('.inputtags').tagsinput({});
    $(".select2").select2({

    });
  </script>

  <script type="text/javascript">
    $(".btn-submit").click(function(e) {

      e.preventDefault();

      var name = $("#name").val();
      var status = $("#status").val();

      $.ajax({
        type: 'POST',
        url: "{{ url('industry/create') }}",
        data: {
          name: name,
          status: status
        },
        success: function(data) {
          if ($.isEmptyObject(data.error)) {
            swal(data.success, {
              icon: "success",
            }).then((value) => {
              window.location.assign("/industries")
            });
            return;
            // locatio?n.reload();
          } else {
            printErrorMsg(data.error);
          }
        }
      });

    });

    function printErrorMsg(msg) {
      $(".print-error-msg").find("ul").html('');
      $(".print-error-msg").css('display', 'block');
      $.each(msg, function(key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
      });
    }
  </script>
  @endsection