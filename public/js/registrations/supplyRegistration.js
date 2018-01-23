$(function () {

    //handle link to tabs
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs-custom a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs-custom a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });

    //action on rent measurement click
    $('body').on("click", ".arrows", function () {
        var link = $(this).attr("href");
        $('li a[href="'+ link +'"]').trigger('click');
    });

    //measure type change event actions
    $('body').on("change", "#purchase_measure_type", function (evt) {
        var measureType = $('#purchase_measure_type').val();

        //disable and assign value if fixed rent
        if(measureType && measureType == 3) {
            $('#purchase_quantity').prop("readonly",true);
            $('#purchase_quantity').val(1);
        } else {
            $('#purchase_quantity').prop("readonly",false);
            $('#purchase_quantity').val('');
        }

        //calculate total rent
        calculateTotalPurchaseBill();
    });

    //measure type change event actions
    $('body').on("change", "#sale_measure_type", function (evt) {
        var measureType = $('#sale_measure_type').val();

        //disable and assign value if fixed rent
        if(measureType && measureType == 3) {
            $('#sale_quantity').prop("readonly",true);
            $('#sale_quantity').val(1);
        } else {
            $('#sale_quantity').prop("readonly",false);
            $('#sale_quantity').val('');
        }

        //calculate total rent
        calculateTotalPurchaseBill();
    });

    //purchase quantity event actions
    $('body').on("change keyup", "#purchase_quantity", function (evt) {
        //calculate total purchase bill
        calculateTotalPurchaseBill();
    });

    //purchase rate event actions
    $('body').on("change keyup", "#purchase_rate", function (evt) {
        //calculate total purchase bill
        calculateTotalPurchaseBill();
    });

    //purchase rate event actions
    $('body').on("change keyup", "#purchase_discount", function (evt) {
        //calculate total purchase bill
        calculateTotalPurchaseBill();
    });

    //sale quantity event actions
    $('body').on("change keyup", "#sale_quantity", function (evt) {
        //calculate total sale bill
        calculateTotalSaleBill();
    });

    //sale rate event actions
    $('body').on("change keyup", "#sale_rate", function (evt) {
        //calculate total sale bill
        calculateTotalSaleBill();
    });

    //sale rate event actions
    $('body').on("change keyup", "#sale_discount", function (evt) {
        //calculate total sale bill
        calculateTotalSaleBill();
    });
});

//method for total bill calculation of purchase
function calculateTotalPurchaseBill() {
    var quantity    = ($('#purchase_quantity').val() > 0 ? $('#purchase_quantity').val() : 0 );
    var rate        = ($('#purchase_rate').val() > 0 ? $('#purchase_rate').val() : 0 );
    var discount    = ($('#purchase_discount').val() > 0 ? $('#purchase_discount').val() : 0 );
    var bill        = 0;
    var totalBill   = 0;
    
    bill  = quantity * rate;
    if(bill > 0) {
        $('#purchase_bill').val(bill);
        if((bill - discount) > 0) {
            totalBill = bill - discount;
            $('#purchase_total_bill').val(totalBill);
        } else {
            $('#purchase_discount').val(0);
            $('#purchase_total_bill').val(bill);
        }

    } else {
        $('#purchase_bill').val(0);
        $('#purchase_discount').val(0);
        $('#purchase_total_bill').val(0);
    }
}

//method for total bill calculation of sale
function calculateTotalSaleBill() {
    var quantity    = ($('#sale_quantity').val() > 0 ? $('#sale_quantity').val() : 0 );
    var rate        = ($('#sale_rate').val() > 0 ? $('#sale_rate').val() : 0 );
    var discount    = ($('#sale_discount').val() > 0 ? $('#sale_discount').val() : 0 );
    var bill        = 0;
    var totalBill   = 0;
    
    bill  = quantity * rate;
    if(bill > 0) {
        $('#sale_bill').val(bill);
        if((bill - discount) > 0) {
            totalBill = bill - discount;
            $('#sale_total_bill').val(totalBill);
        } else {
            $('#sale_discount').val(0);
            $('#sale_total_bill').val(bill);
        }

    } else {
        $('#sale_bill').val(0);
        $('#sale_discount').val(0);
        $('#sale_total_bill').val(0);
    }
}