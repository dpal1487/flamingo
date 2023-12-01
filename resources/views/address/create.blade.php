@extends('layouts.app')

@section('title')

Address

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

                          <label for="terminate_url">TerminateUrl</label>

                          <input type="text" class="form-control" id="terminate_url" name="terminate_url" required placeholder="Enter terminate url"/>

                        </div>

                        <div class="form-group col-sm-6">

                          <label for="complete_url">Complete URL</label>

                          <input type="text" class="form-control" id="complete_url" name="complete_url" required placeholder="Enter complete url"/>

                        </div>

                        <div class="form-group col-sm-6">

                          <label for="quotafull_url">Quotafull URL</label>

                          <input type="text" class="form-control" id="quotafull_url" name="quotafull_url" required placeholder="Enter quotafull url"/>

                        </div>

                        <div class="form-group col-sm-6">

                          <label for="complete">Complete URL</label>

                          <input type="text" class="form-control" id="complete" name="complete" required placeholder="No of complete"/>

                        </div>

                      </div>

                    </div>

                    <div class="card-footer">

                      <button type="submit" class="btn btn-primary">Submit</button>

                      <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>

                    </div>

                    </form>

                </div>

              </div>

          </div>

        </section>

      </div>  

@endsection