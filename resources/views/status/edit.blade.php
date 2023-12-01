@extends('dashboard.layout')
@section('title')
Status | Edit
@endsection
@section('head')
<link rel="stylesheet" href="{{url('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{url('assets/bundles/select2/dist/css/select2.min.css')}}">
@endsection
@section('content')
<div class="main-content" style="min-height: 659px;">
        <section class="section">
          <div class="section-header">
            <h1>Edit User</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{url('dashobard')}}">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="{{url('dashboard/status')}}">Status</a></div>
              <div class="breadcrumb-item"><a href="#">Edit</a></div>
            </div>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h4>User Form</h4>
                  </div>
                  <form action="{{url('dashboard/status/update')}}" method="post">
                    <input type="hidden" value="{{$status->id}}" name="id">
                    <input type="hidden" value="{{$status->token}}" name="token">
                    {{csrf_field()}}
                  <div class="card-body">
                    @if($errors->has('error'))
                      <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                      </div>
                    @endif
                    <div class="form-group">
                      <label>Client Name</label>
                      <select name="client" class="form-control client">
                          <option selected disabled>Select Client Name</option>
                        @foreach($clients as $client)
                            <option value="{{$client->id}}" {{ !empty($status->client_id) && $client->id==$status->client_id ? 'selected' : '' }}>{{$client->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Project ID</label>
                      <select name="project" class="form-control projects">
                        @foreach(\App\Project::where('client_id',$status->client_id)->get() as $project)
                            <option value="{{$project->project_id}}" {{ !empty($status->project_id) && $project->id==$status->project_id ? 'selected' : '' }}>{{$project->project_id}}</option>
                        @endforeach
                      </select>
                    </div>
                  <div class="form-group">
                      <label>Strings</label>
                      <input type="text" name="strings" value="{{$status->strings}}" class="form-control col-xs-12 inputtags">
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
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
<script>
$(function(){
// turn the element to select2 select style
$('.inputtags').tagsinput({
    
});
$(".client").select2({
    placehoder:'Select client name',
}).on('change', function(e) {
    var id = $(".client option:selected").val();
    $.ajax({
        url: api+'projects/'+id,
        dataType: 'json',
        type: "POST",
        success:function(data)
        {
            var s="";
  			$.each(data, function (index, value) {
			    s+='<option value="'+value.project_id+'">'+value.project_id+'</option>';
			});
			$('.projects').html(s);
			$(".projects").select2();
  		}
    });
 });
 });
</script>
@endsection