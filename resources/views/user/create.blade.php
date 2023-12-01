@extends('layouts.app')
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
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>User Form</h4>
                  </div>
                  <form action="{{url('user/create')}}" method="post">

                  <div class="card-body">
                    @if($errors->has('error'))
                      <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                      </div>
                    @endif
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="row">
                          <div class="form-group col-sm-6">
                            <label for="name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required placeholder="Enter first name"/>
                          </div>
                        <div class="form-group col-sm-6">
                          <label for="last_name">Last Name</label>
                          <input type="text" class="form-control" id="last_name" name="last_name" required placeholder="Enter last name"/>
                        </div>

                        <div class="form-group col-sm-6">
                          <label for="email">Email</label>
                          <input type="text" class="form-control" id="email" name="email" required placeholder="abc@gmail.com"/>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>User Type</label>
                            <select name="role" class="form-control">
                              @foreach($roles as $role)
                              <option value="{{$role->id}}">{{$role->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    <div class="form-group col-sm-6">
                      <label>Username</label>
                      <input type="text" name="username" class="form-control" placeholder="User name">
                    </div>
                   <div class="form-group col-sm-6">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control password" placeholder="###">
                  </div>
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
