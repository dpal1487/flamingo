@extends('dashboard.layout')
@section('title')
User | Create
@endsection
@section('head')
<link rel="stylesheet" href="{{url('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{url('assets/bundles/select2/dist/css/select2.min.css')}}">
@endsection
@section('content')
<div class="main-content" style="min-height: 659px;">
        <section class="section">
          <div class="section-header">
            <h1>Create User</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{url('')}}">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="{{url('users')}}">User</a></div>
              <div class="breadcrumb-item"><a href="">Create</a></div>
            </div>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h4>User Form</h4>
                  </div>
                  <form action="{{url('user')}}" method="post">
                    
                  <div class="card-body">
                    @if($errors->has('error'))
                      <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                      </div>
                    @endif
                    <div class="form-group">
                      <label>Username</label>
                      {{ csrf_field() }}
                      <input type="text" name="username" class="form-control">
                    </div>
                   <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control password">
                  </div>
                    <div class="form-group">
                      <label>User Type</label>
                      <select name="type" class="form-control select2">
                        @foreach($type as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                      </select>
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
    $('.inputtags').tagsinput({
    });
    $(".select2").select2({

    });
</script>
@endsection