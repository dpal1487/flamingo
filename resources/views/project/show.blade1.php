@extends('layouts.app')
@section('title')
Surveys
@endsection
@section('head')
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
            <h1>Surveys</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Surveys</a></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">

                @foreach($surveys as $survey)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-1">
                                <div class="text-gray-800 fs-6 fw-bold">
                                    {{$survey->project->project_id}}
                                </div>
                            </div>
                            <div class="flex-1 fw-bold">
                                <span>${{$survey->project?->cost}}/-CPI</span>
                            </div>
                            <div class="flex-1 fw-bold">
                                <span>{{$survey->project?->number_of_complete}}Min/LOI</span>
                            </div>
                            <div class="flex-1 fw-bold">
                                <span>{{$survey->project?->incedance_rate}}%/IR</span>
                            </div>

                            <div class="flex-1 fw-bold">
                                <span>{{$survey->project?->country}}</span>
                            </div>
                            <div class="flex-1 fw-bold">
                                <button class="btn btn-primary copyButton" data-val="{{$survey->project?->client_live_url}}">Live Link</button>
                            </div>
                            <div class="flex-1 fw-bold">
                                <button class="btn btn-primary copyButton" data-val="{{$survey->project?->client_test_url}}">Test Link</button>
                            </div>

                            <div class="flex-1 fw-bold">
                                @if ($survey->project?->admin)
                                <span> {{$survey->project?->admin->first_name}} {{$survey->project?->admin?->last_name}}</span>
                                @else
                                <span><i class="bi bi-people me-2"></i>Admin</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>

    </section>
</div>

@endsection
@section('js')
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
        $("body").on('keyup', '.search-input', function() {
            $.ajax({
                url: '/projects',
                method: 'GET',
                data: {
                    keyword: $(this).val()
                },
                success: function(data) {
                    $(".project-list").html(data.projects);
                    $(".paginate-main").html(data.paginate);
                }
            });
        });
        $(".copyButton").click(function() {
            // Get the data-val attribute value
            var textToCopy = $(this).data("val");

            // Create a temporary textarea to hold the text
            var tempTextarea = $("<textarea>");
            $("body").append(tempTextarea);

            // Set the textarea value to the text you want to copy
            tempTextarea.val(textToCopy);

            // Select the text in the textarea
            tempTextarea.select();

            // Copy the selected text to the clipboard
            document.execCommand("copy");

            // Remove the temporary textarea
            tempTextarea.remove();

            // You can also provide some feedback to the user
            swal({
                icon: 'success',
                title: 'Text copied to clipboard',
                text: textToCopy,
            });
            // alert("Text copied to clipboard: " + textToCopy);
        });
    });
</script>
@endsection
