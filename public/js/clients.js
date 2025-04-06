$('[data-mask]').inputmask();
$('#datemask').inputmask('yyyy/mm/dd', {'placeholder': 'yyyy/mm/dd'});

$('#document').change(function(){
    let doc = $(this).val();
    var urlPost = 'verificar/doc';
    //var data = $('#frm_edit_user').serialize();
    $('.alert').remove();
    $.ajax({
        url: urlPost,
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'POST',
        dataType: 'JSON',
        data: {document: doc},
        beforeSend: function(e){
            
        }
    }).done(function (response){
        //location.reload();
        //$('#modal_edit_network').modal('hide');
        if (response.isValid) {
            $('input[name^="document"]').parent().after('<div class="alert alert-success alert-dismissible" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        } else {
            $('input[name^="document"]').parent().after('<div class="alert alert-danger alert-dismissible" role="alert">' + response.message + '</div>');
            $('input[name^="document"]').val('');
        }
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown, jqXHR);
        /*if(response.responseJSON['ip']){
            $('#frm-edit_network .wrapper-ip').addClass('has-error');
            $('#frm-edit_network .wrapper-ip .help-block>strong').html(response.responseJSON['ip']);
        }else{
            $('#frm-edit_network .wrapper-ip').removeClass('has-error');
            $('#frm-edit_network .wrapper-ip .help-block>strong').html('');
        }*/
    });
});
$('.modal#modalCreateClient').on('show.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_create_client')[0].reset();
    $('#document').val('');
});
$('.modal#modalCreateClient').on('hidden.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_create_client')[0].reset();
    $('#document').val('');
});
$(".table").on('click', '.btnEditClient', function(){
    var clientId = $(this).attr('clientId');
    var urlGet = 'editar-cliente/CLIENTID';
    urlGet = urlGet.replace('CLIENTID', clientId);

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
      $('#editName').val(response.client.name);
      $('#editDocument').val(response.client.document);
      $('#editEmail').val(response.client.email);
      $('#editPhone').val(response.client.phone);
      $('#editDirection').val(response.client.direction);
      $('#editBirthDate').val(response.client.birth_date);
      $('#idEdit').val(response.client.id);
    });
});

$('#editDocument').change(function(){
    let doc = $(this).val();
    var clientId = $('#idEdit').val();
    var urlPost = 'verificar/doc';

    $('.alert').remove();
    $.ajax({
        url: urlPost,
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        dataType: 'JSON',
        data: {document: doc, client_id: clientId},
        beforeSend: function(e){
            
        }
    }).done(function (response){
        
        if (!response.isValid) {
            $('input[name^="document"]').parent().after('<div class="alert alert-danger alert-dismissible" role="alert">' + response.message + '</div>');
            $('input[name^="document"]').val('');            
        } else {
            $('input[name^="document"]').parent().after('<div class="alert alert-success alert-dismissible" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        }
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown, jqXHR);
    });
});

$('.modal#modalEditClient').on('show.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_edit_client')[0].reset();
    $('#document').val('');
});
$('.modal#modalEditClient').on('hidden.bs.modal', function(e){
    $('.alert').remove();
    $('#frm_edit_client')[0].reset();
    $('#document').val('');
});

// Delete
$('.table').on('click', '.btnDeleteClient', function(){
    var clientId = $(this).attr('clientId');
    var clientName = $(this).attr('clientName');

    Swal.fire({
        title: '¿Seguro qué quiere eliminar el cliente: ' + clientName + '?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confrimButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'eliminar/cliente/' + clientId;
        } else {
            
        }
    });
});