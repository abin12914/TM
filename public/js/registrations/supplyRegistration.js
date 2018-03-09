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

    //setting measurement of purchase at source site
    $('body').on("change", "#supplier_account_id", function() {
        purchaseDetailsByCombo();
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

    //setting measurement of sale at destination site
    $('body').on("change", "#customer_account_id", function() {
        saleDetailsByCombo();
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

function purchaseDetailsByCombo() {
    var truckId             = $('#truck_id').val();
    var sourceId            = $('#source_id').val();
    var materialId          = $('#material_id').val();
    var supplierAccountId   = $('#supplier_account_id').val();

    if(truckId && sourceId && materialId && supplierAccountId) {
        $.ajax({
            url: purchaseDetailsUrl,//"/purchase/details/",
            method: "get",
            data: {
                type                : 'purchaseDetailsByCombo',
                truck_id            : truckId,
                source_id           : sourceId,
                material_id         : materialId,
                supplier_account_id : supplierAccountId,
            },
            success: function(result) {
                if(result && result.flag) {
                    var purhaseMeasureType  = result.measureType;
                    var purchaseQuantity    = result.purchaseQuantity;
                    var purchaseRate        = result.purchaseRate;
                    
                    $('#purchase_measure_type').val(purhaseMeasureType);
                    $('#purchase_measure_type').trigger('change');
                    $('#purchase_quantity').val(purchaseQuantity);
                    $('#purchase_quantity').trigger('change');
                    $('#purchase_rate').val(purchaseRate);
                    $('#purchase_rate').trigger('change');
                } else {
                    $('#purchase_measure_type').val('');
                    $('#purchase_measure_type').trigger('change');
                    $('#purchase_quantity').val('');
                    $('#purchase_quantity').trigger('change');
                    $('#purchase_rate').val('');
                    $('#purchase_rate').trigger('change');
                }
            },
            error: function () {
                $('#purchase_measure_type').val('');
                $('#purchase_measure_type').trigger('change');
                $('#purchase_quantity').val('');
                $('#purchase_quantity').trigger('change');
                $('#purchase_rate').val('');
                $('#purchase_rate').trigger('change');
            }
        });
    }
}

function saleDetailsByCombo() {
    var truckId             = $('#truck_id').val();
    var destinationId       = $('#destination_id').val();
    var materialId          = $('#material_id').val();
    var customerAccountId   = $('#customer_account_id').val();

    if(truckId && destinationId && materialId && customerAccountId) {
        $.ajax({
            url: saleDetailsUrl, //"/sale/details/",
            method: "get",
            data: {
                type                : 'saleDetailsByCombo',
                truck_id            : truckId,
                destination_id      : destinationId,
                material_id         : materialId,
                customer_account_id : customerAccountId,
            },
            success: function(result) {
                if(result && result.flag) {
                    var saleMeasureType  = result.measureType;
                    var saleQuantity    = result.saleQuantity;
                    var saleRate        = result.saleRate;
                    
                    $('#sale_measure_type').val(saleMeasureType);
                    $('#sale_measure_type').trigger('change');
                    $('#sale_quantity').val(saleQuantity);
                    $('#sale_quantity').trigger('change');
                    $('#sale_rate').val(saleRate);
                    $('#sale_rate').trigger('change');
                } else {
                    $('#sale_measure_type').val('');
                    $('#sale_measure_type').trigger('change');
                    $('#sale_quantity').val('');
                    $('#sale_quantity').trigger('change');
                    $('#sale_rate').val('');
                    $('#sale_rate').trigger('change');
                }
            },
            error: function () {
                $('#sale_measure_type').val('');
                $('#sale_measure_type').trigger('change');
                $('#sale_quantity').val('');
                $('#sale_quantity').trigger('change');
                $('#sale_rate').val('');
                $('#sale_rate').trigger('change');
            }
        });
    }
}