@extends('layouts.app')

@section('title')

Add Project

@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">

@endsection

@section('content')

<div class="main-content">

    <section class="section">

        <div class="section-header">

            <h1>Project</h1>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>

                <div class="breadcrumb-item"><a href="/projects">Projects</a></div>


            </div>

        </div>

        <div class="row">

            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">

                    <div class="card-header">

                        <h4>Add Project</h4>

                    </div>

                    <div class="card-body">

                        <form action="{{url('/project/store')}}" method="post">


                            {{csrf_field()}}

                            <div class="row">

                                <div class="form-group col-sm-6">

                                    <label for="name">Project ID</label>

                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Enter project name" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="client">Client Name</label>
                                    <select class="form-control" id="multiSelect" placeholder="Select Client Name" name="client_id">
                                        <option value="">--Select Client--</option>
                                        @foreach($partners as $partner)
                                        <option value="{{$partner->id}}">{{$partner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="client_live_url">Client Live URL</label>

                                    <input type="text" class="form-control" id="client_live_url" name="client_live_url" required placeholder="Client live url" />

                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="client_test_url">Client Test URL</label>
                                    <input type="text" class="form-control" id="client_test_url" name="client_test_url" required placeholder="Client test url" />

                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Select Device Type</label>
                                    <select class="form-control" id="multiSelect" placeholder="Select device type" name="device_type[]" multiple>
                                        <option value="desktop">Desktop/Laptop</option>
                                        <option value="mobile">Mobile</option>
                                        <option value="tablet">Tablet</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender" id="multiSelect">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="min_age">Min Age</label>

                                    <input type="text" class="form-control" id="min_age" name="min_age" required placeholder="Min Age" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="max_age">Max Age</label>

                                    <input type="text" class="form-control" id="max_age" name="max_age" required placeholder="Max Age" />

                                </div>
                                <div class="form-group col-sm-6">

                                    <label for="country">Country</label>

                                    <select class="form-control" name="country" id="multiSelect">
                                        <option value="">--Select Country--</option>
                                        @foreach($countries as $country)

                                        <option value="{{$country->iso2}}">{{$country->name}}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="cost">Cost/Interview</label>

                                    <input type="text" class="form-control" id="quotafull_url" name="cost" required placeholder="Cost per interview" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="time_period">Time Period (In Minutes)</label>

                                    <input type="text" class="form-control" id="time_period" name="time_period" required placeholder="Time Period (In Minutes)" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="ir">Incedance Rate</label>

                                    <input type="text" class="form-control" id="ir" name="ir" required placeholder="Incedance Rate" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="num_of_complete">Number Of Completes</label>

                                    <input type="text" class="form-control" id="num_of_complete" name="num_of_complete" required placeholder="Number of complete" />

                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="num_of_complete">Select Industry</label>

                                    <select class="form-control" name="industry" id="multiSelect">
                                        <option value="">--Select Industry--</option>

                                        @foreach($industries as $industry)

                                        <option value="{{$industry->id}}">{{$industry->name}}</option>

                                        @endforeach

                                    </select>
                                </div>


                                <div class="form-group col-sm-6">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="multiSelect">
                                        <option value="">--Select Status--</option>
                                        <option value="open">Open</option>
                                        <option value="close">Close</option>
                                        <option value="tablet">Invoiced</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="end_time">Remarks</label>

                                    <textarea class="form-control" name="remarks" required placeholder="Remarks">None</textarea>

                                </div>

                            </div>


                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>

                        <a href="{{url('projects')}}" class="btn btn-info">Back</a>

                    </div>

                    </form>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

<script>
    $(document).ready(function() {
        var multipleCancelButton = new Choices('#multiSelect', {
            removeItemButton: false,
            maxItemCount: 15,
            searchResultLimit: 5,
            renderChoiceLimit: 25,
            placeholder: true,
        });


    });
</script>

@endsection
