$(".table").DataTable({
    
    "ordering": false,

    "language": {
      
      "sSearch": "Buscar:",
      "sEmptyTable": "No hay datos en la Tabla",
      "sZeroRecords": "No se encontraron resultados",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total _TOTAL_",
      "SInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrando de un total de _MAX_ registros)",
      "oPaginate": {

        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"

      },

      "sLoadingRecords": "Cargando...",
      "sLengthMenu": "Mostrar _MENU_ registros"
    

    }

  });

  // Edit Branch
  $(".table").on('click', '.btnEditBranch', function(){
    var branchId = $(this).attr('branchId');
    //var urlGet = '{{ route('antivirus.antivirus', 'IDANTIVIRUS' )}}';
    var urlGet = 'editar-sucursal/BRANCHID';
    urlGet = urlGet.replace('BRANCHID', branchId);

    $.ajax({
      url: urlGet,
      method: 'GET',
      dataType: 'JSON',
      beforeSend: function(e){
          
      }
    }).done(function (response){
      $('#editName').val(response.branch.name);
      $('#idEdit').val(response.branch.id);
    });

});