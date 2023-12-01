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
        <div class="breadcrumb-item"><a href="#">Add Partner</a></div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Add Partner</h4>
          </div>
          <div class="card-body">
            <form action="{{url('/partner/store')}}" method="post">
              <div class="modal-body">
                {{csrf_field()}}
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="name">Partner Name</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Enter partner name"/>
                  </div>
                <div class="form-group col-sm-6">
                  <label for="latter">Partner Sort Name</label>
                  <input type="text" class="form-control" id="latter" name="latter" required placeholder="Enter partner sort name"/>
                </div>
                <div class="form-group col-sm-6">
                  <label for="latter">Patner Type</label>
                  <select class="form-control" >
                      <option>Select Partner Type</option>
                      <option value="vendor">Vendor</option>
                      <option value="client">Client</option>
                  </select>
                </div>
                <div class="form-group col-sm-6">
                  <label for="complete_url">Complete URL</label>
                  <input type="text" class="form-control" id="complete_url" name="complete_url" required placeholder="Enter complete url"/>
                </div>
                <div class="form-group col-sm-6">
                  <label for="terminate_url">TerminateUrl</label>
                    <input type="text" class="form-control" id="terminate_url" name="terminate_url" required placeholder="Enter terminate url"/>
                </div>
                <div class="form-group col-sm-6">
                  <label for="quotafull_url">Quotafull URL</label>
                  <input type="text" class="form-control" id="quotafull_url" name="quotafull_url" required placeholder="Enter quotafull url"/>
                </div>
                <div class="form-group col-sm-6">
                  <label for="gst_number">GST Number</label>
                  <input type="text" class="form-control" id="gst_number" name="gst_number" placeholder="GST Number"/>
                </div>
              </div>
              <hr>
              <h4>Address</h4>
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address" name="address" required placeholder="Enter Address"/>
                </div>
                <div class="form-group col-sm-6">
                  <label for="state">State</label>
                  <input type="text" class="form-control" id="state" name="state" required placeholder="Enter State"/>
                </div>
                <div class="form-group col-sm-6">
                    <label for="country">Country</label>
                    <select class="form-control" name="country" id="country">
                      <option value="">--Select Country--</option>
                      @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                      @endforeach
                    </select>
                  </div>
                <div class="form-group col-sm-6">
                  <label for="city">City</label>
                  <input type="text" class="form-control" id="city" name="city" required placeholder="Enter City"/>
                </div>
                <div class="form-group col-sm-6">
                  <label for="pincode">Pincode</label>
                  <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode"/>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-info" href="{{url('/partners')}}">Close</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
