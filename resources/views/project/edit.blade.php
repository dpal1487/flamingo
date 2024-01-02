@extends('layouts.app')

@section('title')

{{$project->project_name}} | Project

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

                        <h4>Edit Project</h4>

                    </div>

                    <div class="card-body">

                        <form action="{{url('project/update')}}" method="post">


                            {{csrf_field()}}

                            <div class="row">

                                <div class="form-group col-sm-6">

                                    <label for="name">Project Name</label>

                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Enter project name" value="{{$project->project_name}}" />

                                </div>


                                <div class="form-group col-sm-6">

                                    <label for="client">Client Name</label>
                                    <select class="form-control" id="client_id" name="client_id">
                                        @foreach($partners as $partner)
                                        <option value="{{$partner->id}}" {{$project->client?->id==$partner->id ? 'selected' : ''}}>{{$partner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="id" value="{{$project->id}}" />

                                <div class="form-group col-sm-6">

                                    <label for="client_live_url">Client Live URL</label>

                                    <input type="text" class="form-control" id="client_live_url" name="client_live_url" required placeholder="Client live url" value="{{$project->client_live_url}}" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="client_test_url">Client Test URL</label>

                                    <input type="text" class="form-control" id="client_test_url" name="client_test_url" required placeholder="Client test url" value="{{$project->client_test_url}}" />

                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Select Device Type</label>

                                    <select class="form-control" id="multiSelect" placeholder="Select device type" name="device_type[]" multiple>
                                        <option value="desktop" data-value="desktop">Desktop/Laptop</option>
                                        <option value="mobile" data-value="mobile">Mobile</option>
                                        <option value="tablet" data-value="tablet">Tablet</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="male" {{$project->gender=='male' ? 'selected' : ''}}>Male</option>
                                        <option value="female" {{$project->gender=='female' ? 'selected' : ''}}>Female</option>
                                    </select>

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="min_age">Min Age</label>

                                    <input type="text" class="form-control" id="min_age" name="min_age" required placeholder="Min Age" value="{{$project->min_age}}" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="max_age">Max Age</label>

                                    <input type="text" class="form-control" id="max_age" name="max_age" required placeholder="Max Age" value="{{$project->max_age}}" />

                                </div>


                                <div class="form-group col-sm-6">

                                    <label for="country">Country</label>

                                    <select class="form-control" name="country" id="country">
                                        <option value="">--Select Country--</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->iso2}}" {{$country->iso2==$project->country ? 'selected' : ''}}>{{$country->name}}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="cost">Cost/Interview</label>

                                    <input type="text" class="form-control" id="cost" name="cost" required placeholder="Cost per interview" value="{{$project->cost}}" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="time_period">Time Period (In Minutes)</label>

                                    <input type="text" class="form-control" id="time_period" name="time_period" required placeholder="Time Period (In Minutes)" value="{{$project->time}}" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="ir">Incedance Rate</label>

                                    <input type="text" class="form-control" id="ir" name="ir" required placeholder="Incedance Rate" value="{{$project->incedance_rate}}" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="num_of_complete">Number Of Completes</label>

                                    <input type="text" class="form-control" id="num_of_complete" name="num_of_complete" required placeholder="Number of complete" value="{{$project->number_of_complete}}" />

                                </div>

                                <div class="form-group col-sm-6">

                                    <label for="country">Industry</label>

                                    <select class="form-control" name="industry" id="industry">
                                        <option value="">--Select Industry--</option>

                                        @foreach($industries as $industry)
                                        <option value="{{$industry->id}}" {{$industry->id==$project->industry_id ? 'selected' : ''}}>{{$industry->name}}</option>

                                        @endforeach

                                    </select>

                                </div>



                                <div class="form-group col-sm-6">

                                    <label for="status">Status</label>

                                    <select class="form-control" name="status">

                                        <option value="open" {{$project->status=='open' ? 'selected' : ''}}>Open</option>

                                        <option value="close" {{$project->status=='close' ? 'selected' : ''}}>Close</option>
                                        <option value="invoiced" {{$project->status == 'invoiced' ? 'selected' : ''}}>Invoiced</option>
                                        <option value="archived" {{$project->status == 'archived' ? 'selected' : ''}}>Archived</option>

                                    </select>

                                </div>
                                <div class="form-group col-sm-6">

                                    <label for="end_time">Remarks</label>

                                    <textarea class="form-control" name="remarks" required placeholder="Remarks">{{$project->remarks}}</textarea>

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
        var selectedValues = @json($project->device_type); // Convert comma-separated string to array
        var multipleCancelButton = new Choices('#multiSelect', {
            removeItemButton: true,
            maxItemCount: 5,
            searchResultLimit: 5,
            renderChoiceLimit: 5,
            choices: [{
                    value: 'desktop',
                    label: 'Desktop/Laptop',
                    selected: selectedValues.includes('desktop')
                },
                {
                    value: 'mobile',
                    label: 'Mobile',
                    selected: selectedValues.includes('mobile')
                },
                {
                    value: 'tablet',
                    label: 'Tablet',
                    selected: selectedValues.includes('tablet')
                }
                // Add more choices as needed
            ]
        });


    });
</script>
@endsection
