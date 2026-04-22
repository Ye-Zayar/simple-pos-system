
$(document).ready(function () {
    alertify.set('notifier', 'position', 'top-right');
    $(document).on('click', '.increment', function () {
        let quantityInput = $(this).closest('.qtyBox').find('.qty');
        let productId = $(this).closest('.qtyBox').find('.productId').val();

        let currentValue = parseInt(quantityInput.val())
        if (!isNaN(currentValue)) {
            let qtyValue = currentValue + 1;
            quantityInput.val(qtyValue);
            quantityIncDec(productId, qtyValue);
        }
    });

    $(document).on('click', '.decrement', function () {
        let quantityInput = $(this).closest('.qtyBox').find('.qty');
        let productId = $(this).closest('.qtyBox').find('.productId').val();

        let currentValue = parseInt(quantityInput.val())
        if (!isNaN(currentValue) && currentValue > 1) {
            let qtyValue = currentValue - 1;
            quantityInput.val(qtyValue);
            quantityIncDec(productId, qtyValue);
        }
    });

    function quantityIncDec(productId, qty) {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'productIncDec': true,
                'product_id': productId,
                'quantity': qty,
            },
            success: function (response) {
                let res = JSON.parse(response);
                if (res.status == 200) {
                    //window.location.reload();
                    $('#productArea').load(' #productContent');
                    alertify.success(res.message);
                } else {
                    $('#productArea').load(' #productContent');
                    alertify.error(res.message);
                }
            }
        });
    }

    // focus close button in modal
    $('#addCustomerModal').on('hidden.bs.modal', function () {
        $('.proceedToPlace').focus();
    });

    // proceed to place order button click
    $(document).on('click', '.proceedToPlace', function () {

        let cphone = $('#cphone').val();
        let payment_mode = $('#payment_mode').val();
        if (payment_mode == '') {
            swal("Select Payment Mode", "Select your payment mode", "warning")
            return false;
        }

        if (cphone == '' && !$.isNumeric(cphone)) {
            swal("Enter Phone Number", "Enter Valid Phone Number", "warning")
            return false;
        }

        let data = {
            'proceedToPlaceBtn': true,
            'cphone': cphone,
            'payment_mode': payment_mode
        };
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function (response) {
                let res = JSON.parse(response);
                if (res.status == 200) {
                    window.location.href = "order-summary.php";
                } else if (res.status == 404) {
                    swal(res.message, res.message, res.status_type, {
                        buttons: {
                            catch: {
                                text: "Add customer",
                                value: "catch"
                            },
                            cancel: "Cancel"
                        }
                    })
                        .then((value) => {
                            switch (value) {
                                case "catch":
                                    $('#c_phone').val(cphone);
                                    $('#addCustomerModal').modal('show');
                                    break;
                                default:
                            }
                        });
                } else {
                    swal(res.message, res.message, res.status_type);
                }
            }
        })

    });

    // Add customer to customers table
    $(document).on('click', '.saveCustomer', function () {
        let c_name = $('#c_name').val();
        let c_phone = $('#c_phone').val();
        let c_email = $('#c_email').val();

        if (c_name != '' && c_phone != '') {
            if ($.isNumeric(c_phone)) {
                let data = {
                    'saveCustomerBtn': true,
                    'c_name': c_name,
                    'c_phone': c_phone,
                    'c_email': c_email
                };

                $.ajax({
                    type: "POST",
                    url: "orders-code.php",
                    data: data,
                    success: function (response) {
                        let res = JSON.parse(response);
                        if (res.status == 200) {
                            swal(res.message, res.message, res.status_type);
                            $('#addCustomerModal').modal('hide');
                        } else if (res.status == 422) {
                            swal(res.message, res.message, res.status_type);
                        } else {
                            swal(res.message, res.message, res.status_type);
                        }
                    }
                });
            } else {
                swal("Enter valid Phone Number", "", "warning");
            }
        } else {
            swal("Please fill required fields", "", "warning");
        }

    });

    // Save customer order
    $(document).on('click', '#saveOrder', function() {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'saveOrder': true
            },
            success: function(response) {
                let res = JSON.parse(response);
                if(res.status == 200) {
                    swal(res.message, res.message, res.status_type);
                    $('#orderPlaceSuccessMessage').text(res.message);
                    $('#orderSuccessModal').modal('show');
                }else {
                    swal(res.message, res.message, res.status_type);
                }
            }
        });
    });

});

function printMyBillingArea(){
    let divContents = document.getElementById('myBillingArea').innerHTML;
    let a = window.open('','');
    a.document.write('<html><title>POS System</title>')
    a.document.write('<body style="font-family: fangsong;">');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print()
}


function downloadPDF(invoiceNumber){
    const { jsPDF } = window.jspdf;
    const docPDF = new jsPDF();

    let elementHtml = document.querySelector("#myBillingArea");
     docPDF.html(elementHtml, {
        callback: function() {
            docPDF.save(invoiceNumber + '.pdf');
        }, 
        x: 15,
        y: 15,
        width: 170,
        windowWidth: 650
    })

}
