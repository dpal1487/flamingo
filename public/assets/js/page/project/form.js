
"use strict";

// Class definition
var KTSigninGeneral = function () {
    // Elements
    var form = document.getElementById('project_form');
    var submitButton = document.getElementById('submit');

    submitButton.addEventListener('click', function (e) {
        // Prevent button default action

        e.preventDefault();


        // Show loading indication

        // Disable button to avoid multiple click
        submitButton.disabled = true;
        console.log("sds", submitButton)
        submitButton.setAttribute('data-kt-indicator', 'off');
        axios.post(form.getAttribute("action"), new FormData(form)).then((response) => {
            Swal.fire({
                text: response.data.message,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    window.location.assign('/category');
                }
            })
        }).catch((error) => {
            if (error.response.status == 400) {
                toastr.error(error.response.data.message);
            }
        }).finally(() => {
            submitButton.disabled = false
            submitButton.setAttribute('data-kt-indicator', 'off');

        })

    });

    // Public functions
    return {
        // Initialization
        init: function () {
            form = document.querySelector('#project_form');
            submitButton = document.querySelector('#submit');

            handleForm();
        }
    };
}();


function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}
