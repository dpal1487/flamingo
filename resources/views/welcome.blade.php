@extends('layouts.app')
@section('title')
Dashboard
@endsection
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-xl-4 col-lg-6">
        <div class="card">
          <div class="card-body card-type-3">
            <div class="row">
              <div class="col">
                <h6 class="text-muted mb-0">Total Project</h6>
                <span class="font-weight-bold mb-0">0</span>
              </div>
              <div class="col-auto">
                <div class="card-circle l-bg-orange text-white">
                  <i class="fas fa-book-open"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
              <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 10%</span>
              <span class="text-nowrap">Since last month</span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6">
        <div class="card">
          <div class="card-body card-type-3">
            <div class="row">
              <div class="col">
                <h6 class="text-muted mb-0">Industries</h6>
                <span class="font-weight-bold mb-0">0</span>
              </div>
              <div class="col-auto">
                <div class="card-circle l-bg-cyan text-white">
                  <i class="fas fa-briefcase"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
              <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 7.8%</span>
              <span class="text-nowrap">Since last month</span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6">
        <div class="card">
          <div class="card-body card-type-3">
            <div class="row">
              <div class="col">
                <h6 class="text-muted mb-0">Patners</h6>
                <span class="font-weight-bold mb-0">0</span>
              </div>
              <div class="col-auto">
                <div class="card-circle l-bg-green text-white">
                  <i class="fas fa-phone"></i>
                </div>
              </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
              <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 15%</span>
              <span class="text-nowrap">Since last month</span>
            </p>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-12 col-sm-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Project Details</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive table-invoice">
              <table class="table table-striped">
                <thead>

                  <tr>
                    <th>Project</th>
                    <th>Industry</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="project-list">
                  @foreach($projects as $project)

                  <tr>
                    <td><a href="#">{{$project->project_id}} 1</a></td>
                    <td class="font-weight-600">{{$project->industry?->name}}</td>

                    <td>
                      @if ($project->status == 'pause')
                      <div class="badge badge-warning">{{$project->status}}</div>
                      @elseif($project->status == 'open')
                      <div class="badge badge-success">{{$project->status}}</div>
                      @endif
                    </td>

                    <td>
                      <a href="project/{{$project->id}}" class="btn btn-primary">Detail</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>
@endsection