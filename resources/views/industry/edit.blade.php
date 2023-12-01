@extends('layouts.app')
@section('title')
{{$industry->name}} | Industry
@endsection
@section('content')
<div class="main-content" style="min-height: 659px;">
        <section class="section">
          <div class="section-header">
            <h1>Industry Edit</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="/">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="/industry">Industry</a></div>
              <div class="breadcrumb-item"><a href="#">Edit</a></div>
            </div>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Industry Form</h4>
                  </div>
                  <form action="{{url('industry/update/'.$industry->id)}}" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="name">Industry Name</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{$industry->name}}" placeholder="Enter industry name"/>
                    </div>
                    <!--<div class="form-group">-->
                    <!--  <label for="image">Industry Image</label>-->
                    <!--  <input type="file" class="form-control" name="image" id="image"/>-->
                    <!--</div>-->
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select class="form-control" name="status" id="status">
                        <option value="1" {{$industry->status==1 ? 'selected' : ''}}>Published</option>
                        <option value="0" {{$industry->status==0 ? 'selected' : ''}}>Unpublished</option>
                      </select>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <a href="{{url('industries')}}" class="btn btn-info mr-1" >Back</a>
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
    $('.inputtags').tagsinput({
    });
    $(".select2").select2({

    });
</script>
@endsection