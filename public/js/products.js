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
        if (response.product.length == 0) {
            newCode = generateCode("categoryName", categoryId);
        } else {
            newCode = Number(response.product.code, response.product.code);
        }
        $("#productCode").val(newCode);
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown);
    });
});

$('.modal#modalEditUser').on('show.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_edit_user')[0].reset();
});
$('.modal#modalEditUser').on('hidden.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_edit_user')[0].reset();
});
function generateCode(product, lastNumber) {
    let midName = product.replace(/\s+/g, '').substring(0, 3).toUpperCase();
    
    let numberTwo = String(lastNumber + 1).padStart(3, '0');

    return `${midName}-${numberTwo}`;
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