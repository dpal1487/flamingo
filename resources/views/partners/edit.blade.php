@extends('layouts.app')

@section('title')

Partner - {{$partner->name}}

@endsection

@section('content')

<div class="main-content">

        <section class="section">

          <div class="section-header">

            <h1>Partner</h1>

            <div class="section-header-breadcrumb">

              <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>

              <div class="breadcrumb-item"><a href="/partners">Partners</a></div>

            </div>

          </div>

          <div class="row">

            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">

                  <div class="card-header">

                    <h4>Add Partner</h4>

                  </div>

                  <div class="card-body">

                    <form action="{{url('partner/'.$partner->id)}}" method="post">

                    <div class="modal-body">

                      {{csrf_field()}}

                      <div class="row">

                        <div class="form-group col-sm-6">

                          <label for="name">Partner Name</label>

                          <input type="text" class="form-control" id="name" name="name" value="{{$partner->name}}" required placeholder="Enter partner name"/>

                        </div>

                        <div class="form-group col-sm-6">

                          <label for="latter">Partner Sort Name</label>

                          <input type="text" class="form-control" id="latter" name="latter" required value="{{$partner->latter}}" placeholder="Enter partner sort name"/>

                        </div>

                        <div class="form-group col-sm-6">

                          <label for="complete_url">Completes</label>

                          <input type="text" class="form-control" id="complete_url" name="complete_url" value="{{$partner->complete_url}}" required placeholder="Enter complete"/>

                        </div>

                        <div class="form-group col-sm-6">

                          <label for="terminate_url">TerminateUrl</label>

                          <input type="text" class="form-control" id="terminate_url" name="terminate_url" value="{{$partner->terminate_url}}" required placeholder="Enter terminate url"/>

                        </div>

                        <div class="form-group col-sm-6">

                          <label for="quotafull_url">Quotafull URL</label>

                          <input type="text" class="form-control" id="quotafull_url" name="quotafull_url" value="{{$partner->quotafull_url}}" required placeholder="Enter quotafull url"/>

                        </div>
                        <div class="form-group col-sm-6">
                          <label for="gst_number">GST Number</label>
                          <input type="text" class="form-control" id="gst_number" name="gst_number" placeholder="GST Number" value="{{$partner->quotafull_url}}"/>
                        </div>

                      </div>
                      <hr>
                      <h4>Address</h4>
                      <div class="row">
                        <div class="form-group col-sm-6">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address" name="address" required placeholder="Enter Address"  value="{{!empty($address->address) ? $address->address : '' }}"/>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="state">State</label>
                          <input type="text" class="form-control" id="state" name="state" required placeholder="Enter State" value="{{!empty($address->state) ? $address->state : ''}}"/>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="country">Country</label>

                            <select class="form-control" name="country" id="country">
                              <option value="">--Select Country--</option>
                              @foreach($countries as $country)
                              <option value="{{$country->id}}" {{$country->id==$address->country_id ? 'selected' : ''}}>{{$country->name}}</option>

                              @endforeach

                            </select>

                          </div>
                        <div class="form-group col-sm-6">
                          <label for="city">City</label>
                          <input type="text" class="form-control" id="city" name="city" required placeholder="Enter City" value="{{!empty($address->city) ? $address->city : '' }}"/>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="pincode">Pincode</label>
                          <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" value="{{!empty($address->pincode) ? $address->pincode : '' }}"/>
                        </div>
                      </div>

                    </div>

                    <div class="card-footer">

                      <button type="submit" class="btn btn-primary">Submit</button>

                      <a href="/partners" class="btn btn-info">Close</a>

                    </div>

                    </form>

                </div>

              </div>

          </div>

        </section>

      </div>

@endsection
