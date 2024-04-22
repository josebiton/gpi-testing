<?php
//Activamos el almacenamiento en el buffer
ob_start();
date_default_timezone_set('America/Lima'); require "../config/funcion_general.php";
session_start();
if (!isset($_SESSION["user_nombre"])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {

?>
  <!DOCTYPE html>
  <html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-bg-img="bgimg4" data-menu-styles="dark" data-toggled="icon-overlay-close">

  <head>
    <?php $title_page = "Anticipo Cliente";
    include("template/head.php"); ?>
  </head>

  <body id="body-anticipos">
    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>
      <?php if($_SESSION['cliente']==1) { ?> <!-- .:::: PERMISO DE MODULO ::::. -->

      <!-- Start::app-content -->
      <div class="main-content app-content">
        <div class="container-fluid">

          <!-- Start::page-header -->
          <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
              <div class="d-md-flex d-block align-items-center ">
                <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" data-bs-toggle="modal" data-bs-target="#modal_agregar_anticipo" onclick="limpiar_form_anticipo(); selectSerie();"> <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                <div>
                  <p class="fw-semibold fs-18 mb-0">Anticipo</p>
                  <span class="fs-semibold text-muted">Administra los anticipos del cliente.</span>
                </div>
              </div>
            </div>
            <div class="btn-list mt-md-0 mt-2">
              <nav>
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Anticipo</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Realizar venta</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- End::page-header -->

          <!-- Start::row-1 -->
          <div class="row">
            <div class="col-xxl-5 col-xl-5">
              <div>
                <div class="card custom-card">
                  <div class="card-body">
                    <!-- ------------ Tabla de Servicios ------------- -->
                    <div class="table-responsive" id="div-tabla">
                      <table class="table table-bordered w-100" style="width: 100%;" id="tabla-clientes">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Cliente</th>
                            <th>Saldo Disponible</th>
                            <th>Anticipos</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                          <tr>
                          <th class="text-center">#</th>
                            <th>Cliente</th>
                            <th>Saldo Disponible</th>
                            <th>Anticipos</th>
                          </tr>
                        </tfoot>

                      </table>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xxl-7 col-xl-7">
              <div id="select-user">
                <div class="alert alert-solid-warning alert-dismissible fade show">
                  <h6 class="text-center">POR FAVOR SELECCIONE UN CLIENTE !!!</h6>
                </div>
              </div>
              <div id="tbl-anticipo" style="display: none;">
                <div class="alert alert-solid-info alert-dismissible fade show">
                  <h6  class="text-center"><b id="nomb_cliente"></b></h6>
                </div>
                <div class="card custom-card">
                  <div class="card-body">
                    <!-- ------------ Tabla de Servicios ------------- -->
                    <div class="table-responsive" id="div-tabla">
                      <table class="table table-bordered w-100" style="width: 100%;" id="tabla-anticipos">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Acciones</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Serie Anticipo</th>
                            <th>Descripción</th>
                            <th>Venta</th>
                            <th>Monto</th>
                            <th>Cliente</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                          <tr>
                          <th class="text-center">#</th>
                            <th>Acciones</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Serie Anticipo</th>
                            <th>Descripción</th>
                            <th>Venta</th>
                            <th>Monto</th>
                            <th>Cliente</th>
                          </tr>
                        </tfoot>

                      </table>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End::row-1 -->

          <!-- Start::modal-agregar_anticipo -->
          <div class="modal fade" id="modal_agregar_anticipo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_agregar_anticipoLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h3 class="modal-title" id="modal_agregar_anticipoLabel">Nuevo Anticipo</h3>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form name="form-agregar-anticipo" id="form-agregar-anticipo" method="POST" class="needs-validation" novalidate>
                          <div class="row" id="cargando-1-formulario">

                            <!-- --------------ID------------------ -->
                            <input type="hidden" name="idanticipo_cliente" id="idanticipo_cliente" /> 
                            <input type="hidden" name="tipo_comprobante" id="tipo_comprobante" value="102" />

                            <!-- --------------CLIENTE------------- -->
                            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12">
                              <label for="cliente" class="form-label">Cliente</label>
                              <select name="cliente" id="cliente" class="form-select" required></select>
                            </div>

                            <!-- --------------MONTO---------------- -->
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                              <label for="monto" class="form-label">Monto</label>
                              <input type="number" name="monto" id="monto" class="form-control"/>
                            </div>

                            <!-- --------------DESCRIPCION--------- -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
                              <label for="descrip" class="form-label">Descripción</label>
                              <textarea class="form-control" name="descrip" id="descrip" rows="1"></textarea>
                            </div>

                            <!-- --------------SERIE--------------- -->
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3">
                              <label for="serie_ac" class="form-label">Serie <span class="charge-serie text-danger"><i class="fas fa-spinner fa-pulse"></i></span></label>
                              <select class="form-control" name="serie_ac" id="serie_ac" onchange="actualizar_numeracion()"></select>
                              <input type="hidden" name="idnumeracion" id="idnumeracion">
                              <input type="hidden" name="SerieReal" id="SerieReal">
                            </div>

                            <!-- --------------NUMERO--------------- -->
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3">
                              <label for="numero_ac" class="form-label">Número <span class="charge-numero text-danger"><i class="fas fa-spinner fa-pulse"></i></span></label>
                              <input type="number" name="numero_ac" id="numero_ac" class="form-control" required="true" readonly/>
                            </div>

                            <!-- --------------TIPO----------------- -->
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3">
                              <label for="tipo_ac" class="form-label">Tipo Anticipo</label>
                              <input type="text" name="tipo_ac" id="tipo_ac" class="form-control" value="INGRESO" readonly/>
                            </div>
                            
                            <!-- --------------FECHA--------------- -->
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3">
                              <label for="fecha" class="form-label">Fecha</label>
                              <input type="date" name="fecha" id="fecha" class="form-control"/>
                            </div>
                          </div>
                          <div class="row" id="cargando-2-fomulario" style="display: none;" >
                            <div class="col-lg-12 text-center">                         
                              <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                              <h4 class="bx-flashing">Cargando...</h4>
                            </div>
                          </div>
                          <!-- Chargue -->
                          <div class="p-l-25px col-lg-12" id="barra_progress_anticipo_div" style="display: none;" >
                            <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                              <div id="barra_progress_anticipo" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                            </div>
                          </div>
                          <!-- Submit -->
                          <button type="submit" style="display: none;" id="submit-form-anticipo">Submit</button>
                        </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" id="guardar_registro_anticipo"><i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
                      </div>
                  </div>
              </div>
          </div>
          <!-- End::modal-agregar_anticipo -->

          <!-- Start::modal-imprimir_ticket -->
          <div class="modal fade" id="modalPreviewticket" tabindex="-1" aria-labelledby="modalPreviewticketLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" style="max-width: 24% !important;">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalPreviewticketLabel">Ticket de venta</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="imp1">
                  <div>
                    <iframe name="modalAntcticket" id="modalAntcticket" frameborder="0" width="100%"
                      style="height: 800px;" marginwidth="1" src="">
                    </iframe>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End::modal-imprimir_ticket -->
          




        </div>
      </div>
      <!-- End::app-content -->
      <?php } else { $title_submodulo ='Servicio'; $descripcion ='Lista de Servicio del sistema!'; $title_modulo = 'Articulos'; include("403_error.php"); }?>   

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>
    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>

    <!-- Select2 Cdn -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <script src="scripts/anticipo_cliente.js"></script>
    <script>
      $(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>


  </body>



  </html>
<?php
}
ob_end_flush();
?>