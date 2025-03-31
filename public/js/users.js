$(".selectRole").change(function(){
    var role = $(this).val();

    if (role != 'Administrator') {
        $(".selectBranch").show();
    } else {
        $(".selectBranch").hide();
    }
});

$('.table').on('click', '.btnUserStatus', function(){
    var uid = $(this).attr('uid');

    var urlGet = 'cambiar-estado/UID';
    urlGet = urlGet.replace('UID', uid);

    $.ajax({
        url: urlGet,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(e){
            
        }
    }).done(function (response){
        //console.log(response.user.status);
        if (response.user.status) {
            $(this).removeClass('btn-danger').addClass('btn-success').text('Activo');
        } else {
            $(this).removeClass('btn-success').addClass('btn-danger').text('Inactivo');
        }
        //$('#editName').val(response.branch.name);
        //$('#idEdit').val(response.branch.id);
    }.bind(this));
});

$('.table').on('click', '.btnEditUser', function(){
    var userId = $(this).attr('userId');

    var urlGet = 'editar-usuario/USERID';
    urlGet = urlGet.replace('USERID', userId);
    
    $.ajax({
        url: urlGet,
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(e){
            
        }
    }).done(function (response){
        //console.log(response.user);
        $('#idEdit').val(response.user.id);
        $('#editName').val(response.user.name);
        $('#editEmail').val(response.user.email);
        $('#editRole').val(response.user.role);
        if (response.user.role != "Administrator") {
            $('#editBranchId').val(response.user.branch_id);
            $('.selectBranch').show();
        } else {
            $('#editBranchId').val("");
            $('.selectBranch').hide();
        }
        
        //$('#email').val(response.user.email);
    }.bind(this));
});

$('#editEmail').change(function(){
    var verifyEmail = $(this).val();
    var userId = $('#idEdit').val();

    var urlPost = 'verificar-email';
    //var data = $('#frm_edit_user').serialize();
    $('.alert').remove();
    $.ajax({
        url: urlPost,
        //headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token dinámico
        },
        method: 'POST',
        dataType: 'JSON',
        data: {email: verifyEmail, id: userId},
        beforeSend: function(e){
            
        }
    }).done(function (response){
        //location.reload();
        //$('#modal_edit_network').modal('hide');
        if (response.verification) {
            $('#editEmail').parent().after('<div class="alert alert-danger">Este email ya se encuentra registrado.</div>');
            $('#editEmail').val("");
        } else {
            //$('#editEmail').val();
        }
    }).fail(function (jqXHR, textStatus, errorThrown){
        console.error("Error en AJAX:", textStatus, errorThrown);
        /*if(response.responseJSON['ip']){
            $('#frm-edit_network .wrapper-ip').addClass('has-error');
            $('#frm-edit_network .wrapper-ip .help-block>strong').html(response.responseJSON['ip']);
        }else{
            $('#frm-edit_network .wrapper-ip').removeClass('has-error');
            $('#frm-edit_network .wrapper-ip .help-block>strong').html('');
        }*/
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

$('.table').on('click', '.btnDeleteUser', function(){
    var userId = $(this).attr('userId');

    Swal.fire({
        title: '¿Seguro qué quiere eleiminar el Usuario?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        confrimButtonText: 'Eliminar',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'eliminar-usuario/' + userId;
        } else {
            
        }
    });
});