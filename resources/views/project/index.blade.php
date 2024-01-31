@extends('layouts.app')
@section('title')
Projects
@endsection
@section('head')
@livewireStyles
<style>
    .td-link {
        max-width: 150px;
    }

    .td-link a {
        display: inline-block;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        padding: 0;
        width: 100%;
    }
</style>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Projects</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Projects</a></div>
            </div>
        </div>
        @livewire('project-index-livewire')
    </section>
</div>
<!-- Vendor List Modal -->
<div id="addLink" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Link</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('project/new-link')}}" id="addLinkForm" method="post">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <input type="hidden" name="id" class="pid" />
                            <label for="client_live_url">Client Live URL</label>
                            <input type="text" class="form-control" id="client_live_url" name="client_live_url" required placeholder="Client live url" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="client_test_url">Client Test URL</label>
                            <input type="text" class="form-control" id="client_test_url" name="client_test_url" required placeholder="Client test url" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="country">Country</label>
                            <select class="form-control" name="country" id="country">
                                <option value="">--Select Country--</option>
                                @foreach($countries as $country)
                                <option value="{{$country->iso2}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="cost">Cost/Interview</label>
                            <input type="text" class="form-control" id="cost" name="cost" required placeholder="Cost per interview" />
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
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
                                <option value="open">Open</option>
                                <option value="close">Close</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button data-dismiss="modal" class="btn btn-info">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Update Link Modal -->
<div id="updateLink" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Link</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('project/update-link')}}" id="updateLinkForm" method="post">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <input type="hidden" name="id" class="pid" />
                            <label for="client_live_url">Client Live URL</label>
                            <input type="text" class="form-control" id="client_live_url" name="client_live_url" required placeholder="Client live url" />
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="client_test_url">Client Test URL</label>
                            <input type="text" class="form-control" id="client_test_url" name="client_test_url" required placeholder="Client test url" />
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
                                <option value="open">Open</option>
                                <option value="close">Close</option>
                                <option value="pause">Pause</option>
                                <option value="invoiced">Invoiced</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button data-dismiss="modal" class="btn btn-info">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(function() {
        $('#addLinkForm').validate({
            rules: {
                "client_live_url": {
                    required: true
                },
                "country": {
                    required: true
                },
                "cost": {
                    required: true
                },
                "time_period": {
                    required: true
                },
                "ir": {
                    required: true
                },
                "num_of_complete": {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.success) {
                            swal(data.message, {
                                icon: "success",
                            }).then((value) => {
                                window.location.reload();
                            });
                            return;
                        } else {
                            alert(response.message);
                        }
                    }
                });
                return false;
            }
        });
        $('#updateLinkForm').validate({
            rules: {
                "client_live_url": {
                    required: true
                },
                "client_live_url": {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.success) {
                            swal(data.message, {
                                icon: "success",
                            }).then((value) => {
                                window.location.reload();
                            });
                            return;
                        } else {
                            alert(response.message);
                        }
                    }
                });
                return false;
            }
        });
        $("body").on('click', '#partnerListBtn,#updateLinkBtn', function() {
            $('.pid').val($(this).attr('data-id'));
        });
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
                            url: "/project/remove/" + id,
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
        $('body').on('change', '.status', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/project/update/status/" + id,
                method: "post",
                data: {
                    status: $(this).val()
                },
                success: function(data) {
                    if (data.success) {
                        swal(data.message, {
                            icon: "success",
                        });
                        return;
                    }
                    swal(data.message);
                }
            });
        });
        $('body').on('change', '.count', function() {

            var id = $(this).attr('data-id');
            $.ajax({
                url: "/project/update/count/" + id,
                method: "post",
                data: {
                    count: $(this).val()
                },
                success: function(data) {
                    if (data.success) {
                        swal(data.message, {
                            icon: "success",
                        });
                        return;
                    }
                    swal(data.message);
                }
            });
        });
    });
</script>
@endsection