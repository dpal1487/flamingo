@extends('layouts.app')
@section('title')
    Users
@endsection
@section('head')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Users</a></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header text-right">
                            <a href="{{ url('user/create') }}" class="btn btn-primary float-right">Add User</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th>Create At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    <?php
                                                    $role = DB::table('roles')
                                                        ->where('id', $user->role->role_id)
                                                        ->first();
                                                    print_r($role?->name);
                                                    ?>
                                                </td>
                                                <td>{{ $user->updated_at }}</td>
                                                <td>
                                                    <a href="{{ url('user/edit') . '/' . $user->id }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <button class="btn btn-danger remove-btn"
                                                        data-id="{{ $user->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                        </div>
                        <div class="card-footer text-right">
                            {!! $users->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
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
                                url: "/user/delete/" + id,
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
        });
    </script>
@endsection
