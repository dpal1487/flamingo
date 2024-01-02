@extends('layouts.app')
@section('title')
Industries
@endsection
@section('head')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Industries</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{url('')}}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Industries</a></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a href="/industry/create" class="btn btn-primary">Add Industry</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Industry</th>
                                        <th>Status</th>
                                        <th>Create At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($industries as $industry)
                                    <tr>
                                        <td>{{$industry->id}}</td>
                                        <td>{{$industry->name}}</td>
                                        <td>
                                            @if ($industry->status == 0)
                                            <div class="badge badge-warning">Unpublished</div>
                                            @elseif($industry->status == 1)
                                            <div class="badge badge-success">Published</div>
                                            @endif
                                        </td>
                                        <td>{{$industry->created_at}}</td>
                                        <td>
                                            <a href="{{url('industry/edit/'.$industry->id)}}" class="btn btn-primary">Edit</a>
                                            <button class="btn btn-danger remove-btn" data-id="{{$industry->id}}">Delete</button>

                                            {{-- <button data-url="{{url('industry/delete/'.$industry->id)}}" class="btn btn-danger remove-btn">Delete</button> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        {!! $industries->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(function() {
        $(".remove-btn").click(function() {
            var id = $(this).attr('data-id');
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "/industry/delete/" + id,
                            method: "post",
                            success: function(data) {
                                if (data.success) {
                                    swal(data.message, {
                                        icon: "success",
                                    }).then((value) => {
                                        window.location.reload();
                                    });
                                    return;
                                }
                                swal(data.message);
                            }
                        })

                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });
        });
    })
</script>
@endsection