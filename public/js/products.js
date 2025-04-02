$(".table").on('click', '.btnEditCategory', function(){
    var categoryId = $(this).attr('categoryId');
    var urlGet = 'editar-categoria/CATEGORYID';
    urlGet = urlGet.replace('CATEGORYID', categoryId);

    $.ajax({
      url: urlGet,
      headers: { 
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
    },
      method: 'GET',
      dataType: 'JSON',
      beforeSend: function(e){
          
      }
    }).done(function (response){
      $('#editName').val(response.category.name);
      $('#idEdit').val(response.category.id);
    });

});

$('.table').on('click', '.btnDeleteCategory', function(){
    var categoryId = $(this).attr('categoryId');
    var categoryName = $(this).attr('categoryName');

    Swal.fire({
        title: '¿Seguro qué quiere eleiminar la Categoría: ' + categoryName + '?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confrimButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'eliminar-categoria/' + categoryId;
        } else {
            
        }
    });
});

$('#category_id').change(function(){
    var categoryId = $(this).val();
    var categoryName = $(this).find('option:selected').text();

    var urlGet = 'generar/codigo/producto/CATEGORYID';
    urlGet = urlGet.replace('CATEGORYID', categoryId);
    //var data = $('#frm_edit_user').serialize();
    $('.alert').remove();
    $.ajax({
        url: urlGet,
        //headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'Get',
        dataType: 'JSON',
        beforeSend: function(e){
            
        }
    }).done(function (response){
        //location.reload();
        //$('#modal_edit_network').modal('hide');
        //console.log(response);
        let newCode = "";
        if (!response.product || Object.keys(response.product).length === 0) {
            newCode = generateCode(categoryName, categoryId);
        } else {
            
            newCode = incrementCode(response.product.code);
        }
        $("#productCode").val(newCode);
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown);
    });
});

$('.modal#modalEditProduct').on('show.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_edit_product')[0].reset();
    $('#editPercentageValue').val(40);
    $("#editSellingPrice").prop("readonly", true);
});
$('.modal#modalEditProduct').on('hidden.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_edit_product')[0].reset();
    $('#editPercentageValue').val(40);
    $("#editSellingPrice").prop("readonly", true);
});
function generateCode(product, lastNumber) {
    let midName = product.replace(/\s+/g, '').substring(0, 3).toUpperCase();
    
    let numberTwo = String(lastNumber + 1).padStart(3, '0');

    return `${midName}-${numberTwo}`;
}
function incrementCode(code) {
    // Verify the correct format (ej: "COM-01")
    if (!code || typeof code !== 'string' || !code.includes('-')) {
        console.error("Formato de código inválido:", code);
        return code; // Returns the original if it doesn't comply with the format
    }

    // Separate the prefix (ej: "COM") and the number (ej: "01")
    const parts = code.split('-');
    const prefix = parts[0]; // "COM"
    const numberStr = parts[1]; // "01"

    // convert number to integer
    const number = parseInt(numberStr, 10) + 1;

    // Left zeros (ej: 2 → "02")
    const paddedNumber = number.toString().padStart(numberStr.length, '0');

    // Returns the new code (ej: "COM-02")
    return `${prefix}-${paddedNumber}`;
}
$("input[type='checkbox'].minimal").iCheck({
    checkboxClass: 'icheckbox_minimal-blue'
});

$("#purchasePrice").change(function(){
    
    if ($(".percentage").prop("checked")) {

        let percentageValue = $("#percentageValue").val();

        let percentage = Number(($("#purchasePrice").val() * percentageValue / 100)) + Number($("#purchasePrice").val());

        $("#sellingPrice").val(percentage);
        $("#sellingPrice").prop("readonly", true);

    } else {
        
    }
});

$("#percentageValue").change(function(){
    if ($(".percentage").prop("checked")) {

        let percentageValue = $("#percentageValue").val();

        let percentage = Number(($("#purchasePrice").val() * percentageValue / 100)) + Number($("#purchasePrice").val());

        $("#sellingPrice").val(percentage);
        $("#sellingPrice").prop("readonly", true);

    }
});

$(".percentage").on("ifUnchecked", function(){
    $("#sellingPrice").prop("readonly", false);
});

$(".percentage").on("ifChecked", function(){
    let percentageValue = $("#percentageValue").val();

    let percentage = Number(($("#purchasePrice").val() * percentageValue / 100)) + Number($("#purchasePrice").val());

    $("#sellingPrice").val(percentage);
    $("#sellingPrice").prop("readonly", true);
});

$('.table').on('click', '.btnEditProduct', function(){
    var productId = $(this).attr('productId');

    var urlGet = 'editar/producto/PRODUCTID';
    urlGet = urlGet.replace('PRODUCTID', productId);
    
    $.ajax({
        url: urlGet,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(e){
            
        }
    }).done(function (response){
        //console.log(response.product);
        $('#idEdit').val(response.product.id);
        $('#editName').val(response.product.name);
        $('#editCategoryId').val(response.product.category_id);
        $('#editProductCode').val(response.product.code);
        $('#editDescription').val(response.product.description);
        $('#editStock').val(response.product.stock);
        $('#editPurchasePrice').val(response.product.purchase_price);
        $('#editSellingPrice').val(response.product.selling_price);

        if (response.product.image != '') {
            $('#editImage').attr('src', 'storage/' + response.product.image);
        } else {
            $('#editImage').attr('src', 'storage/products/default.png');
        }
        
    }.bind(this));
});

$('#editCategoryId').change(function(){
    var categoryId = $(this).val();
    var categoryName = $(this).find('option:selected').text();

    var urlGet = 'generar/codigo/producto/CATEGORYID';
    urlGet = urlGet.replace('CATEGORYID', categoryId);

    $('.alert').remove();
    $.ajax({
        url: urlGet,
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'Get',
        dataType: 'JSON',
        beforeSend: function(e){
            
        }
    }).done(function (response){
        let newCode = "";
        if (!response.product || Object.keys(response.product).length === 0) {
            newCode = generateCode(categoryName, categoryId);
        } else {
            newCode = incrementCode(response.product.code);
        }
        $("#editProductCode").val(newCode);
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown);
    });
});

$("#editPurchasePrice").change(function(){
    
    if ($(".editPercentage").prop("checked")) {

        let editPercentageValue = $("#editPercentageValue").val();

        let editPercentage = Number(($("#editPurchasePrice").val() * editPercentageValue / 100)) + Number($("#editPurchasePrice").val());

        $("#editSellingPrice").val(editPercentage);
        $("#editSellingPrice").prop("readonly", true);

    } else {
        
    }
});

$("#editPercentageValue").change(function(){
    if ($(".editPercentage").prop("checked")) {

        let editPercentageValue = $("#editPercentageValue").val();
        
        let editPercentage = Number(($("#editPurchasePrice").val() * editPercentageValue / 100)) + Number($("#editPurchasePrice").val());

        $("#editSellingPrice").val(editPercentage);
        $("#editSellingPrice").prop("readonly", true);

    }
});

$(".editPercentage").on("ifUnchecked", function(){
    $("#editSellingPrice").prop("readonly", false);
});

$(".editPercentage").on("ifChecked", function(){
    let editPercentageValue = $("#editPercentageValue").val();

    let editPercentage = Number(($("#editPurchasePrice").val() * editPercentageValue / 100)) + Number($("#editPurchasePrice").val());

    $("#editSellingPrice").val(editPercentage);
    $("#editSellingPrice").prop("readonly", true);
});