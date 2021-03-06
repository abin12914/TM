$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*swal({
        title: 'Success...',
        type: 'success',
        text: 'Everything is ok!',
        timer: 5000,
        allowOutsideClick : false,
        showConfirmButton : false,
    });*/

    //hide flash messages
    dismissAlert();

    //Initialize Select2 Element for account type select box
    initializeSelect2();

    //datepicker for general datepickers
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

    //Date picker for registrations
    $('.datepicker_reg').datepicker({
        todayHighlight: true,
        endDate: '+1d',
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

    if(defaultDate) {
        //setting user setting date as selected
        $('.datepicker_reg').datepicker('setDate', defaultDate);

    } else {
        //setting current date as selected
        $('.datepicker_reg').datepicker('setDate', 'now');
    }

    //default value setting in account registering
    $('body').on("change", "#financial_status", function () {
        financialStatus = this.value;
        if(financialStatus == 0) {
            $('#opening_balance').val('0');
            $('#opening_balance').prop("readonly",true);
        } else {
            $('#opening_balance').val('');
            $('#opening_balance').prop("readonly",false);
        }
    });

    //prevent user from entering data
    $('body').on("keydown", ".prevent-edit", function (evt) {
        return false;
    });
    
    // for checking if the pressed key is a number
    $('body').on("keypress", ".number_only", function (evt) {
        var fieldValue  = $(this).val();
        var elementId   = $(this).attr("id");
        var charCode = (evt.which) ? evt.which : event.keyCode;

        if(fieldValue.length == 1 && fieldValue == 0) {
            if(charCode != 46) {
                $(this).val('');
            }
        }

        if(elementId == 'phone') {
            if(fieldValue.length == 0 && charCode == 43) {
                return true;
            }
            if(fieldValue.length >= 13) {
                evt.preventDefault();
                $("#phone").data("title", "Phone number must be between 10 and 13 digits!").tooltip("show");
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            evt.preventDefault();
            $(this).data("title", "Only numbers are allowed!").tooltip("show");
            return false;
        }
        
        $(this).data("title", "");
        return true;
    });

    // for checking if the pressed key is a number or decimal
    $('body').on("keypress", ".decimal_number_only", function (evt) {
        var original = $(this).val();
        // attaching 1 to the end for number like 1.0
        var fieldValue = $(this).val() + '1';
        var charCode = (evt.which) ? evt.which : event.keyCode;

        if(original.length == 1 && original == 0) {
            if(charCode != 46) {
                $(this).val('');
            }
        }
        
        if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57))) {
            evt.preventDefault();
            $(this).data("title", "Only numbers are allowed!").tooltip("show");
            return false;
        }
        if(charCode == 46 && (fieldValue % 1 != 0)) {
            evt.preventDefault();
            $(this).data("title", "Only numbers and decimal point are allowed!").tooltip("show");
            return false;
        }

        $(this).data("title", "");
        return true;
    });

    // for checking if the pressed key is a alphabet
    $('body').on("keypress", ".alpha_only", function (evt) {
        var fieldValue = $(this).val();
        var charCode = (evt.which) ? evt.which : event.keyCode;

        if (!((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122))) {
            evt.preventDefault();
            $(this).data("title", "Only alphabets are allowed!").tooltip("show");
            return false;
        }
        $(this).data("title", "");
        return true;
    });

    // for disabling submit button to prevent multiple submition
    $('body').on("click", ".submit-button", function () {
        $('.submit-button').prop('disabled', true);
        $(this).parents('form:first').submit();
    });

    // for confirming delete
    $('body').on("click", ".update_button", function () {
        swal({
              title: 'Are you sure to update the record?',
              type: 'warning',
              showCancelButton: true,
              focusCancel : true,
              confirmButtonColor: '#d33',
              confirmButtonText: 'Yes, update it!'
            }).then((result) => {
              if (result.value) {
                //submit delete form on confirmation
                $(this).parents('form:first').submit();
              }
            })
        });

    // for confirming delete
    $('body').on("click", ".delete_button", function () {
        swal({
              title: 'Are you sure to delete?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              focusCancel : true,
              confirmButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                //submit delete form on confirmation
                $(this).parents('form:first').submit();
              }
            })
    });

    // right sidebar menu track certificate click event
    $('body').on("change", "#rsb_track_certificate", function () {
        var value = $(this).is(':checked') ? 1 : 0;

        if(value == 1 || value == 0) {
            $.ajax({
                url: "/settings/1",
                method: "post",
                data:{
                    '_method' : 'PATCH',
                    'track_certificate' : value,
                    'settings_flag' : 1,
                },
                success: function(result) {
                    if(result && result.flag) {
                        console.log("settings/track certificate : Success");
                    }
                },
                error: function(error) {
                    console.log("settings/track certificate : Error");
                }
            });
        }
    });

    // right sidebar menu track certificate click event
    $('body').on("change", "#rsb_default_date", function () {
        var value = $(this).val();

        $.ajax({
            url: "/settings/1",
            method: "post",
            data:{
                '_method' : 'PATCH',
                'default_date' : value,
                'settings_flag' : 2,
            },
            success: function(result) {
                if(result && result.flag) {
                    console.log("settings/default date : Success");
                }
            },
            error: function(error) {
                console.log("settings/default date : Error");
            }
        });
    });
});

//method for automatic disappearing of message boxes
function dismissAlert() {
    $("#alert-message").fadeTo(8000, 500).slideUp(1000, function(){
        $("#alert-message").slideUp(500);
    });
}

//method for initializing select2
function initializeSelect2() {
    $(".select2").select2({
        minimumResultsForSearch: 5,
    });
}