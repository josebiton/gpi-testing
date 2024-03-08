var tabla_doc_identidad;
function init(){
  listar_tabla();
	$("#guardar_registro_doc_identidad").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-doc-identidad").submit(); } });
}

function listar_tabla(){
  tabla_doc_identidad = $('#tabla-doc-identidad').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla) { tabla.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [1,2,3,4,5,6], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
    "ajax":	{
			url: '../ajax/documento_de_identidad.php?op=listar_tabla',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			},
      complete: function () {
        $(".buttons-reload").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Recargar');
        $(".buttons-copy").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Copiar');
        $(".buttons-excel").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Excel');
        $(".buttons-pdf").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'PDF');
        $(".buttons-colvis").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Columnas');
        $('[data-bs-toggle="tooltip"]').tooltip();
      },
      dataSrc: function (e) {
				if (e.status != true) {  ver_errores(e); }  return e.aaData;
			},
		},
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "asc"]]
  }).DataTable();
  
}

function guardar_editar(e){
  var formData = new FormData($("#formulario-doc-identidad")[0]);
  $.ajax({
    url: "../ajax/documento_de_identidad.php?op=guardar_editar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false, 

    success: function (e) {
      try {
        e = JSON.parse(e);
        if (e.status == 'registrado') {
          sw_success("Excelente", "Doc. de Identidad Registrado", 3000);
          tabla_doc_identidad.ajax.reload(null, false);
          $('#modal-doc-identidad').modal('hide');
          
        } else if (e.status == 'modificado') {
          sw_success("Excelente", "Doc. de Identidad Actualizado", 3000);
          tabla_doc_identidad.ajax.reload(null, false);
          $('#modal-doc-identidad').modal('hide');
        } 
        
        else { ver_errores(e); }
      } catch (err) { console.log("Error: ", err.message); toastr.error('<h5 class="font-size-16px">Error temporal!!</h5> puede intentalo mas tarde, o comuniquese con <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>'); }

    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

function limpiar_form() {
  $("#guardar_registro_doc_identidad").html('Guardar Cambios').removeClass('disabled');
  //Mostramos los Materiales
  $("#idsunat_doc_identidad").val("");
  $("#nombre").val("");
  $("#abrt").val("");
  $("#codg").val("");
  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

function mostrar_doc_didentidad(idsunat_doc_identidad){
  $(".tooltip").remove();
  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();
  
  limpiar_form();

  $("#modal-doc-identidad").modal("show");

  $.post("../ajax/documento_de_identidad.php?op=mostrar_doc_didentidad", { idsunat_doc_identidad: idsunat_doc_identidad }, function (e, status) {
    e = JSON.parse(e); 
    if (e.status) {
      $("#idsunat_doc_identidad").val(e.data.idsunat_doc_identidad);
      $("#nombre").val(e.data.nombre);        
      $("#abrt").val(e.data.abreviatura);    
      $("#codg").val(e.data.code_sunat);    

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();
    } else { ver_errores(e); }
    
  }).fail( function(e) { ver_errores(e); } );
}

function eliminar_papelera_doc_didentidad(idsunat_doc_identidad, nombre){
  crud_eliminar_papelera(
    "../ajax/documento_de_identidad.php?op=desactivar",
    "../ajax/documento_de_identidad.php?op=eliminar", 
    idsunat_doc_identidad, 
    "!Elija una opción¡", 
    `<b class="text-danger"><del>${nombre}</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`, 
    function(){ sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado." ) }, 
    function(){ sw_success('Eliminado!', 'Tu registro ha sido Eliminado.' ) }, 
    function(){ tabla_doc_identidad.ajax.reload(null, false); },
    false, 
    false, 
    false,
    false
  );
}

function mayus(e) {
  e.value = e.value.toUpperCase();
}

init();

$(function () {

  $("#formulario-doc-identidad").validate({
    rules: {
      nombre: { required: true, minlength: 2, maxlength: 100} ,
      abrt: { required: true} ,
      codg: { required: true} ,
    },
    messages: {
      nombre: {  required: "Campo requerido.", },
      abrt: {  required: "Campo requerido.", },
      codg: {  required: "Campo requerido.", },
    },
        
    errorElement: "span",

    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },

    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },

    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid").addClass("is-valid");   
    },
    submitHandler: function (e) { 
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      guardar_editar(e);      
    },

  });
});