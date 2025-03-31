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