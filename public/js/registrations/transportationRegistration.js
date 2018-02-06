$(function () {

    //rent type chane event actions
    $('body').on("change", "#rent_type", function (evt) {
        var rentType = $('#rent_type').val();

        //disable and assign value if fixed rent
        if(rentType && rentType == 3) {
            $('#rent_measurement').prop("readonly",true);
            $('#rent_measurement').val(1);
        } else {
            $('#rent_measurement').prop("readonly",false);
            $('#rent_measurement').val('');
        }

        //calculate total rent
        calculateTotalRent();
    });

    //action on rent measurement keyup
    $('body').on("keyup", "#rent_measurement", function (evt) {
        //calculate total rent
        calculateTotalRent();
    });

    //action on rent rate keyup
    $('body').on("keyup", "#rent_rate", function (evt) {
        //calculate total rent
        calculateTotalRent();
    });

    //action on rent rate keyup
    $('body').on("change", "#employee_id", function (evt) {
        //calculate total rent
        calculateTotalRent();
    });

    //disabiling same value selection in 2 sites
    $('body').on("change", "#source_id", function() {
        var fieldValue = $(this).val();

        $('#destination_id')
            .children('option[value=' + fieldValue + ']')
            .prop('disabled', true)
            .siblings().prop('disabled', false);

        initializeSelect2();
    });

    //disabiling same value selection in 2 sites
    $('body').on("change", "#destination_id", function() {
        var fieldValue = $(this).val();

        $('#source_id')
            .children('option[value=' + fieldValue + ']')
            .prop('disabled', true)
            .siblings().prop('disabled', false);

        initializeSelect2();
    });

    //submit transportation form
    $('body').on("click", "#save_button", function (e) {
        e.preventDefault();
        $("#save_button").prop("disabled", true);
        $(this).parents('form:first').submit();
        $("#wait_modal").modal("show");
        changeMessage();
    });
});

//method for total rent calculation and driver wage calculation
function calculateTotalRent() {
    var quantity    = ($('#rent_measurement').val() > 0 ? $('#rent_measurement').val() : 0 );
    var rate        = ($('#rent_rate').val() > 0 ? $('#rent_rate').val() : 0 );
    var totalRent   = 0;
    var wageAmount  = 0;
    //driver wage calculation
    var employeeWageType    = $('#employee_id').find(':selected').data('wage-type');
    var employeeWageAmount  = $('#employee_id').find(':selected').data('wage-amount');

    totalRent  = quantity * rate;
    if(totalRent > 0) {
        $('#total_rent').val(totalRent);

        if(employeeWageType == 3 && employeeWageAmount > 0) {
            wageAmount = totalRent * (employeeWageAmount/100);
            
            $('#employee_wage').val(wageAmount);
        } else {
            $('#employee_wage').val('');
        }
    } else {
        $('#total_rent').val(0);
        $('#employee_wage').val(0);
    }
}

//function to show messages one by one in modal
function changeMessage() {
    var countFlag = 1;
    setInterval(function() {
        if(countFlag == 1) {
            $("#wait_modal_message_1").hide();
            $("#wait_modal_message_2").show();
            $("#wait_modal_message_3").hide();
            countFlag = 2;
        } else if(countFlag == 2) {
            $("#wait_modal_message_1").hide();
            $("#wait_modal_message_2").hide();
            $("#wait_modal_message_3").show();
            countFlag = 3;
        } else {
            $("#wait_modal_message_1").show();
            $("#wait_modal_message_2").hide();
            $("#wait_modal_message_3").hide();
            countFlag = 1;
        }
    }, 4000 );
}