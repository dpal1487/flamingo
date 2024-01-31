    @extends('layouts.app')

    @section('title')

    Partner Surveys

    @endsection

    @section('head')
    @livewireStyles
    @endsection

    @section('content')

    <div class="main-content">

        <section class="section">

            <div class="section-header">

                <h1>Partner Surveys</h1>

                <div class="section-header-breadcrumb">

                    <div class="breadcrumb-item active"><a href="{{url('/')}}">Dashboard</a></div>

                    <div class="breadcrumb-item"><a href="#">Surveys</a></div>

                </div>

            </div>

            @livewire('partner-index-livewire')

        </section>

    </div>

    <!-- Vendor Partner Modal -->



    <!-- Vendor List Modal -->

    <div id="partnerList" class="modal fade" role="dialog">

        <div class="modal-dialog modal-xl">

            <!-- Modal content-->

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Partner Survey List</h5>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-md">

                            <thead>

                                <tr>

                                    <td>Partner Survey ID</td>

                                    <td>Partner Name</td>

                                    <td>Survey Name</td>

                                    <td>Allotment Time</td>

                                    <td>Live URL</td>

                                    <td>Status</td>

                                    <td>Action</td>

                                </tr>

                            </thead>

                            <tbody>


                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Vendor Edit Modal -->

    <div id="viewModal" class="modal fade" role="dialog">

        <div class="modal-dialog modal-xl">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Partner Survey Complete Details</h5>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <table class="table table-bordered table-md">

                        <thead>

                            <tr>

                                <th>Survey ID</th>

                                <th>Survey Name</th>

                                <th>Comp</th>

                                <th>InComp</th>

                                <th>SC</th>

                                <th>QF</th>

                                <th>IR</th>

                                <th>LOI</th>

                                <th>Cost Ratio</th>

                                <th>Download</th>

                            </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

    <div id="partnerModal" class="modal fade" role="dialog">

        <div class="modal-dialog modal-lg">

            <!-- Modal content-->

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Partner Survey Complete Details</h5>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <form id="partnerForm" method="post">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="form-group col-sm-6">

                                <label for="name">Partner List</label>

                                <select class="form-control" name="vid" required id="partner_list">

                                    <option value="">Select Partner Name</option>

                                    @foreach($partners as $partner)

                                    <option value="{{$partner->id}}">{{$partner->name}}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="name">Partner Name</label>

                                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter partner name" readonly />

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="pid">Survey Name | ID</label>

                                <input type="text" class="form-control" id="pid" required readonly />
                                <input type="hidden" class="form-control" id="hidden-pid" name="pid" required readonly />
                                <input type="hidden" class="form-control" id="hidden-id" name="id" required readonly />

                                {{csrf_field()}}

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="cost">Cost/Interview <b>(CPI $<span class="actual-cpi"></span>)</b></label>

                                <input type="text" class="form-control" id="cost" name="cost" required placeholder="Cost Per Interview" />

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="terminate_url">TerminateUrl</label>

                                <input type="text" class="form-control" id="terminate_url" name="terminate_url" required placeholder="Enter terminate url" />

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="quotafull_url">Quotafull URL</label>

                                <input type="text" class="form-control" id="quotafull_url" name="quotafull_url" required placeholder="Enter quotafull url" />

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="complete_url">Complete URL</label>

                                <input type="text" class="form-control" id="complete_url" name="complete_url" required placeholder="Enter complete url" />

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="number_of_completes">Number Of Completes Allocated</label>

                                <input type="text" class="form-control" id="number_of_completes" name="number_of_completes" required placeholder="Enter complete" />

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="message">Message</label>

                                <textarea class="form-control" id="message" name="message"></textarea>

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="republic_url">Republic URL</label>

                                <textarea class="form-control" id="republic_url" name="republic_url"></textarea>

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="remarks">Remarks</label>

                                <textarea class="form-control" id="remarks" name="remarks">None</textarea>

                            </div>

                            <div class="form-group col-sm-6">

                                <label for="status"></label>

                                <select class="form-control" required id="status" name="status">

                                    <option value="open" selected>Open</option>

                                    <option value="close">Close</option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" id="submit" class="btn btn-primary" style="width: 80px;">
                            Submit
                        </button>

                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @endsection

    @section('js')
    @livewireScripts

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var action, modal;
            $('body').on('change', '#partner_list', function() {
                $.ajax({
                    url: 'survey/partner/show/' + $(this).val(),
                    data: {
                        _token: '{{csrf_token()}}'
                    },
                    method: 'POST',
                    success: function(data) {
                        if (data.success) {
                            $("#name").val(data.partner.name);
                            $("#vid").val(data.partner.id);
                            $("#terminate_url").val(data.partner.terminate_url);
                            $("#complete_url").val(data.partner.complete_url);
                            $("#quotafull_url").val(data.partner.quotafull_url);
                        }
                    }
                });
            });
            $("body").on('click', "#partner-modal-btn,#partnerListBtn", function() {
                $('#hidden-pid').val($(this).attr('data-val'));
                $('#pid').val($(this).attr('data-name'));
                $(".actual-cpi").text($(this).attr('data-cpi'));
                $("#partnerForm").attr("action", '/survey/partner/store');
            });
            $('#partnerForm').validate({ // initialize the plugin
                rules: {
                    name: {
                        required: true
                    },
                    survey_name: {
                        required: true
                    },
                    cost: {
                        required: true
                    },
                    terminate_url: {
                        required: true
                    },
                    quotafull_url: {
                        required: true
                    },
                    complete_url: {
                        required: true
                    },
                    number_of_completes: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    // <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    const submitBtn = document.getElementById("submit");
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm align-middle ms-2"></span>`;

                    $.ajax({
                        type: "POST",
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        success: function(data) {
                            if (data.success) {
                                swal("Success", data.message, "success");
                                $("#partnerModal").modal('hide');
                            } else {
                                printErrorMsg(data.errors);
                                console.log("Error form", data.errors, "error");
                                // swal("Error", data.errors, "error");
                            }
                        },
                        complete: () => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = "Submit";
                        }
                    });
                    return false; // required to block normal submit since you used ajax
                }


            });

            function printErrorMsg(msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }
            $("body").on("click", "#partnerListBtn", function() {
                $("#partnerList tbody").html(`<tr> <td colspan = "7" style="height: 120px; vertical-align: middle; text-align: center;"><span class = "spinner-border spinner-border-sm align-middle ms-2" style="height:30px;width:30px;" > </span> </td> </tr>`);
                var pid = $(this).attr('data-val');
                $.ajax({
                    type: "POST",
                    url: "/survey/partner/projects/" + pid,
                    success: function(data) {
                        if (data) {
                            $("#partnerList tbody").html(data);
                        } else {
                            swal("Error", data.message, "error");
                        }
                    }
                });
            });
            $("body").on("click", ".edit-partner-btn", function() {
                var id = $(this).attr("data-id");
                $('#hidden-id').val(id);
                $("#partnerForm").attr("action", '/survey/partner/update');
                $.ajax({
                    type: "POST",
                    url: "survey/partner/edit/" + id,
                    success: function(data) {
                        if (data.success) {
                            $("#partnerModal #partner_list").val(data.partner.partner_id).attr("selected", "selected");
                            $("#partnerModal #name").val(data.partner.partner_name);
                            $("#partnerModal #pid").val(data.partner.project.project_name + " - " + data.partner.project.country + " (" + data.partner.project.project_id + ")");
                            $("#partnerModal #cost").val(data.partner.cost);
                            $("#partnerModal #terminate_url").val(data.partner.terminate_url);
                            $("#partnerModal #quotafull_url").val(data.partner.quotafull_url);
                            $("#partnerModal #complete_url").val(data.partner.complete_url);
                            $("#partnerModal #number_of_completes").val(data.partner.number_of_completes);
                            $("#partnerModal #message").val(data.partner.message);
                            $("#partnerModal #republic_url").val(data.partner.survey_link);
                            $("#partnerModal #remarks").val(data.partner.remarks);
                            $("#partnerModal #id").val(data.partner.id);
                            $("#partnerModal #status").val(data.partner.status).attr("selected", "selected");
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });
            $('body').on('click', '.view-status-btn', function() {
                var pid = $(this).attr('data-pid');
                var vid = $(this).attr("data-vid");
                $("#viewModal tbody").html('`<tr> <td colspan = "10" style="height: 180px; vertical-align: middle; text-align: center;"><span class = "spinner-border spinner-border-sm align-middle ms-2" style="height:30px;width:30px;" > </span> </td> </tr>`');
                $.ajax({
                    type: "POST",
                    url: "/survey/partner/status",
                    data: {
                        vid: vid,
                        pid: pid
                    },
                    success: function(data) {
                        if (data != "") {
                            $("#viewModal tbody").html(data);
                        } else {
                            swal("Error", data.message, "error");
                        }
                    }
                });
            });
            $("body").on('click', '.remove-btn', function() {
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
                                url: "/survey/partner/remove/" + id,
                                method: "post",
                                success: function(data) {
                                    if (data.success) {
                                        swal(data.message, {
                                            icon: "success",
                                        }).then((value) => {
                                            $("#partnerList").modal('hide');
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