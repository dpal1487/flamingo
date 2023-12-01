@extends('dashboard.layout')
@section('title')
Status
@endsection
@section('head')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<style>
.bootstrap-tagsinput
{
    height: 100%;
    display: table-cell;
}
.bootstrap-tagsinput .tag
{
    color:#fff;
    margin-top:5px;
    display:inline-block;
}
.no-wrap
{
    white-space:nowrap;
}
</style>
@endsection
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Status</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Status</a></div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                   <form action="/dashboard/status" class="w-100">
                        <div class="row">
                        <div class="form-group col-sm-3">
                        <select name="client" class="form-control">
                            @foreach($clients as $client)
                                <option value="{{$client->id}}" {{Request::get('client')==$client->id ? 'selected' : '' }}>{{$client->name}}</option>
                            @endforeach
                        </select>
                    </div>
                        <div class="form-group col-sm-3">
                        <input type="text" placeholder="PID" value="{{Request::get('q')}}" name="q" id="q" class="form-control">
                        </div>
                        <div class="col-sm-3">
                        <input type="submit" class="btn btn-primary" value="submit">
                        </div>
                        </div>
                    </form>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md">
                        <tbody><tr>
                          <th>S.NO</th>
                          <th class="no-wrap">Project ID</th>
                          <th>Strings</th>
                          <th>Count</th>
                          <th>Create At</th>
                          <th>Action</th>
                        </tr>
                        @foreach($status as $s)
                        <tr>
                          <td>{{$s->id}}</td>
                          <td class="no-wrap">{{\App\Client::where('id',$s->client_id)->first()->name.$s->project_id}}</td>
                          <td class="bootstrap-tagsinput">@foreach(explode(",",$s->strings) as $string)
                            <span class="tag label label-info">{{$string}}</span>
                            @endforeach
                          </td>
                          <td>{{$s->count}}</td>
                          <td class="no-wrap">{{$s->created_at}}</td>
                          <td class="no-wrap">
                            <a href="{{url('dashboard/status').'/'.$s->id}}" class="btn btn-primary">Edit</a>
                            <a href="javascript:void(0)" id="del-btn" data-id="{{$s->id}}" class="btn btn-danger">Delete</a>
                          </td>
                        </tr> 
                        @endforeach
                      </tbody></table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block">
                      <ul class="pagination mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
          </div>
        </section>
      </div>  
@endsection
@section('js')
<script type="text/javascript">
$(function()
  {
  $('#del-btn').click(function()
  {
    confirmDelete($(this).attr('data-id'));
  })
});
function confirmDelete(id)
{
Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'

}).then((result) => {
  if (result.value) {
  $.ajax({
      url: "{{url('user/delete')}}",
      type: "POST",
      data: {id: id,_token:'<?php echo csrf_token()?>'},
      dataType: "html",
      success: function (data) {
        var result=JSON.parse(data);
          Swal.fire("Done!",result.message,result.type);
          if(result.type=='success')
          {
            location.reload();
          }
        }
  });
}
})
}
</script>
@endsection