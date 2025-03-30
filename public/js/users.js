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