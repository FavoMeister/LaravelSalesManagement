// Add Products
$('.table').on('click', '.addProduct', function(){
    let productId = $(this).attr('productId');
    let saleId = $('#saleId').val();
    let url = $('#url').val();

    $(this).removeClass('btn-primary addProduct');
    $(this).addClass('btn-default');

    $.ajax({
        url: url + '/agregar-producto-venta',
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'POST',
        dataType: 'JSON',
        data: {productId: productId, saleId: saleId},
        beforeSend: function(e){
            
        }
    }).done(function (response){
        //location.reload();
        if (response.success) {
            let description = response.product.description;
            if(description === null){
                description = '';
            }
            $(".saleProducts").append(
                '<div class="row product-item" id="prod-' + response.product.id + '" style="padding: 5px 15px;">' +
                    '<div class="col-xs-6" style="padding-right: 0px;">' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon">' +
                                '<button class="btn btn-danger btn-xs deleteProduct" productId="' + response.product.id + '"><i class="fa fa-times"></i></button>' +
                            '</span>' +
                            '<input type="text" name="" id="" class="form-control" readonly value="' + response.product.name + ' ' + description + '">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-xs-3">' +
                        '<input type="number" class="form-control newProductQuantity" productId="' + response.product.id + '" stock="' + response.product.stock + '" min="1" name="" id="" value="1">' +
                    '</div>' +
                    '<div class="col-xs-3" style="padding-left: 0px;">' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                            '<input type="text" name="" class="form-control newProductPrice" id="price-p-' + response.product.id + '" realPrice="' + response.product.selling_price + '" readonly value="' + response.product.selling_price + '">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-xs-12" id="p-quantity-' + response.product.id + '" style="display: none;">' +
                        '<p class="alert alert-danger">La cantidad supera al stock disponible</p>' +
                    '</div>' +
                '</div>'
            );
            salePrice();
            //$('input[name^="document"]').parent().after('<div class="alert alert-success alert-dismissible" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        } else {

        }
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown, jqXHR);
    });
});

function loadProductSale(){
    let saleId = $('#saleId').val();
    let url = $('#url').val();
    let saleStatus = $('#status').val();

    $.ajax({
        url: url + '/cargar-productos-venta/' + saleId,
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'Get',
        dataType: 'JSON',
        beforeSend: function(e){
            
        }
    }).done(function (response){

        let products = response.sale.products;
        products.forEach(function(product){

            if (saleStatus == 'Finalizada') {
                var readonly = 'readonly';
                var cancelButton = '';
            } else {
                var readonly = "";
                var cancelButton = '<span class="input-group-addon">' +
                                '<button class="btn btn-danger btn-xs deleteProduct" productId="' + product.id + '"><i class="fa fa-times"></i></button>' +
                            '</span>';
            }
            let description = product.description;
            if(description === null){
                description = '';
            }
            $(".saleProducts").append(
                '<div class="row product-item" id="prod-' + product.id + '" style="padding: 5px 15px;">' +
                    '<div class="col-xs-6" style="padding-right: 0px;">' +
                        '<div class="input-group">' +
                        cancelButton +
                            '<input type="text" name="" id="" class="form-control" readonly value="' + product.name + ' ' + description + '">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-xs-3">' +
                        '<input type="number" class="form-control newProductQuantity" productId="' + product.id + '" stock="' + product.stock + '" min="1" name="" id="" value="1" ' + readonly + '>' +
                    '</div>' +
                    '<div class="col-xs-3" style="padding-left: 0px;">' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                            '<input type="text" name="" class="form-control newProductPrice" id="price-p-' + product.id + '" realPrice="' + product.selling_price + '" readonly value="' + product.selling_price + '">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-xs-12" id="p-quantity-' + product.id + '" style="display: none;">' +
                        '<p class="alert alert-danger">La cantidad supera al stock disponible</p>' +
                    '</div>' +
                '</div>'
            );
            salePrice();
        });

    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown);
    });
}

loadProductSale();

// Delete Products
$(".saleProducts").on('click', '.deleteProduct', function(){
    let saleId = $('#saleId').val();
    let url = $('#url').val();
    let productId = $(this).attr('productId');

    $.ajax({
        url: url + '/quitar-producto-venta',
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'POST',
        dataType: 'JSON',
        data: {productId: productId, saleId: saleId},
        beforeSend: function(e){
            
        }
    }).done(function (response){
        
        $('#product-' + productId).addClass('btn-primary addProduct').removeClass('btn-default disabled');
        $('#modalProduct-' + productId).addClass('btn-primary addProduct').removeClass('btn-default disabled');
        $('#prod-' + productId).hide().removeAttr(id);
        $('#price-p-' + productId).removeClass('newProductPrice');

    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown, jqXHR);
    });
    salePrice();
});

$('.saleProducts').on('change', '.newProductQuantity', function(){
    let productId = $(this).attr('productId');
    let stock = parseInt($(this).attr('stock'));
    let quantity = parseInt($(this).val());
    let price = $('#price-p-' + productId).attr('realPrice');
    let finalPrice = price * quantity;
    //console.log(productId, quantity, price, finalPrice);
    
    salePrice();
    if (quantity > stock) {
        $(this).val(stock);
        $('#price-p-' + productId).val(stock * price);
        $('#p-quantity-' + productId).show();
        salePrice();
    } else {
        $('#price-p-' + productId).val(finalPrice);
        $('#p-quantity-' + productId).hide();
    }

});

$('.saleProducts').on('keyup', '.newProductQuantity', function(){
    let productId = $(this).attr('productId');
    let stock = parseInt($(this).attr('stock'));
    let quantity = parseInt($(this).val());
    let price = $('#price-p-' + productId).attr('realPrice');
    let finalPrice = price * quantity;
    //console.log(productId, quantity, price, finalPrice);
    salePrice();

    if (quantity > stock) {
        $(this).val(stock);
        $('#price-p-' + productId).val(stock * price);
        $('#p-quantity-' + productId).show();
        salePrice();
    } else {
        $('#price-p-' + productId).val(finalPrice);
        $('#p-quantity-' + productId).hide();
    }

});

$('#newTaxSale').on('change', salePrice);

function salePrice() {
    const productsPrice = document.querySelectorAll('.newProductPrice');
    
    let totalSum = 0;

    productsPrice.forEach(price => {
        const valueNum =  parseFloat(price.value) || 0;
        totalSum += valueNum;
    });

    $('#newNetPrice').val(totalSum);

    var tax = $('#newTaxSale').val();
    
    if (tax == 0) {
        $('#newTotalPrice').val(totalSum);
    }else {
        var taxPrice = Number(totalSum * tax/100);
        taxWitTotal = Number(taxPrice) + Number(totalSum);
        $('#newTotalPrice').val(totalSum);
    }
}

$('#newPaymentMethod').on('change', function () {
    var method = $(this).val();

    if (method != "") {
        $("#btnEndSale").show();
        if (method == 'cash') {
            $(this).parent().parent().removeClass('col-xs-6').addClass('col-xs-4');
            $(this).parent().parent().parent().children('.paymentMethodBoxes').html(
                '<div class="col-xs-4"> ' +
                    '<div class="input-group">' +
                        '<spna class="input-group-addon"><i class="ion ion-social-usd"></i></spna>' +
                        '<input type="text" class="form-control" name="" id="newCashValue" placeholder="0000">' +
                    '</div>' +
                '</div>' +
                '<div class="col-xs-4" id="getCashChange" style="padding-left: 0px;">' +
                    '<div class="input-group">' +
                        '<spna class="input-group-addon"><i class="ion ion-social-usd"></i></spna>' +
                        '<input type="text" class="form-control" name="" id="newCashChange" placeholder="0000">' +
                    '</div>' +
                '</div>' 
            );
        }else {
            $(this).parent().parent().removeClass('col-xs-6').addClass('col-xs-4');
            $(this).parent().parent().parent().children('.paymentMethodBoxes').html(
                '<div class="col-xs-6" style="padding-left: 0px;"> ' +
                    '<div class="input-group">' +
                        '<input type="number" class="form-control" name="" id="newTransactionCode" placeholder="Código de transacción">' +
                        '<spna class="input-group-addon"><i class="fa fa-lock"></i></spna>' +

                    '</div>' +
                '</div>'
            );
        }
    } else{
        $("#btnEndSale").hide();

        $(this).parent().parent().removeClass('col-xs-4').addClass('col-xs-6');
        $(this).parent().parent().parent().children('.paymentMethodBoxes').html('');
    }
});

$(document).on('keyup', '#newCashValue', function(){
    var cashVal = $(this).val();
    var totalSale = $("#newTotalPrice").val();
    
    var changeVar = cashVal - totalSale;

    if (changeVar >= 0) {
        $("#newCashChange").val(changeVar);
    } else {
        $("#newCashChange").val(0);
    }
});

$(document).on('change', '#newCashValue', function(){
    var cashVal = $(this).val();
    var totalSale = $("#newTotalPrice").val();

    var changeVar = cashVal - totalSale;

    if (changeVar >= 0) {
        $("#newCashChange").val(changeVar);
    } else {
        $("#newCashChange").val(0);
    }
});

// 

$("#btnEndSale").on('click', function(){
    var saleId = $("#saleId").val();
    var url = $("#url").val();

    var products = [];

    $(".product-item").each(function(){
        var productId = $(this).find(".newProductQuantity").attr("productId");
        var quantity = parseInt($(this).find(".newProductQuantity").val());
        var price = parseFloat($(this).find(".newProductPrice").val());
        
        products.push({
            id: productId,
            quantity: quantity,
            price: price
        });
    });

    var tax = $("#newTaxSale").val();
    var net = $("#newNetPrice").val();
    var total = $("#newTotalPrice").val();
    var method = $("#newPaymentMethod").val();

    if (method != "cash") {
        var paymentMethod = method + "-" + $("#newTransactionCode").val();
    } else {
        var paymentMethod = method;
    }

    var payment = [];
    payment.push({
        tax: tax,
        net_tax: net,
        total: total,
        payment_method: paymentMethod
    });

    $.ajax({
        url: url + '/finalizar-venta',
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'POST',
        dataType: 'JSON',
        data: {
            saleId: saleId,
            products: products,
            payments: payment
        },
        beforeSend: function(e){
            
        }
    }).done(function (response){
        location.reload();
        if (response.success) {
            let description = response.product.description;
            if(description === null){
                description = '';
            }
            $(".saleProducts").append(
                '<div class="row product-item" id="prod-' + response.product.id + '" style="padding: 5px 15px;">' +
                    '<div class="col-xs-6" style="padding-right: 0px;">' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon">' +
                                '<button class="btn btn-danger btn-xs deleteProduct" productId="' + response.product.id + '"><i class="fa fa-times"></i></button>' +
                            '</span>' +
                            '<input type="text" name="" id="" class="form-control" readonly value="' + response.product.name + ' ' + description + '">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-xs-3">' +
                        '<input type="number" class="form-control newProductQuantity" productId="' + response.product.id + '" stock="' + response.product.stock + '" min="1" name="" id="" value="1">' +
                    '</div>' +
                    '<div class="col-xs-3" style="padding-left: 0px;">' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                            '<input type="text" name="" class="form-control newProductPrice" id="price-p-' + response.product.id + '" realPrice="' + response.product.selling_price + '" readonly value="' + response.product.selling_price + '">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-xs-12" id="p-quantity-' + response.product.id + '" style="display: none;">' +
                        '<p class="alert alert-danger">La cantidad supera al stock disponible</p>' +
                    '</div>' +
                '</div>'
            );
            salePrice();
            
        } else {

        }
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown, jqXHR);
    });
});

// Delete Sale
$('.table').on('click', '.btnDeleteSale', function(){
    var saleId = $(this).attr('saleId');
    var saleCode = $(this).attr('saleCode');

    Swal.fire({
        title: '¿Seguro qué quiere eliminar la venta: ' + saleCode + '?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confrimButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'eliminar/venta/' + saleId;
        } else {
            
        }
    });
});