<?php
//Activamos el almacenamiento en el buffer
ob_start();
require "../config/funcion_general.php";
session_start();
if (!isset($_SESSION["user_nombre"])) {
  header("Location: index.php?file=" . basename($_SERVER['PHP_SELF']));
} else {

?>
  <!DOCTYPE html>
  <html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

  <head>
    <?php $title_page = "Servicios";
    include("template/head.php"); ?>
  </head>

  <body id="body-servicios">
    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>

      <!-- Start::app-content -->
      <div class="main-content app-content">
        <div class="container-fluid">

          <!-- Start::page-header -->
          <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
              <div class="d-md-flex d-block align-items-center ">
                <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" onclick="show_hide_form(2);  limpiar_form_servicio(); "  > <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                <button type="button" class="btn btn-danger btn-cancelar m-r-10px" onclick="show_hide_form(1);" style="display: none;"><i class="ri-arrow-left-line"></i></button>
                <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"  > <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
                <div>
                  <p class="fw-semibold fs-18 mb-0">Servicios</p>
                  <span class="fs-semibold text-muted">Administra los servicios.</span>
                </div>
              </div>
            </div>
            <div class="btn-list mt-md-0 mt-2">
              <nav>
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Servicios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Articulos</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- End::page-header -->

          <!-- Start::row-1 -->
          <div class="row">
            <div class="col-xxl-12 col-xl-12">
              <div>
                <div class="card custom-card">
                  <div class="card-body">
                    <!-- ------------ Tabla de Servicios ------------- -->
                    <div class="table-responsive" id="div-tabla">
                      <table class="table table-bordered w-100" style="width: 100%;" id="tabla-servicios">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Acciones</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio Venta</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                          <tr>
                          <th class="text-center">#</th>
                            <th class="text-center">Acciones</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio Venta</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                          </tr>
                        </tfoot>

                      </table>

                    </div>
                    <!-- ------------ Formulario de Servicio ------------ -->
                    <div class="div-form" style="display: none;">
                      <form name="form-agregar-servicio" id="form-agregar-servicio" method="POST" class="needs-validation" novalidate>
                        <div class="row gy-2" id="cargando-1-formulario">
                          <!-- ID -->
                          <input type="hidden" name="idproducto" id="idproducto"/>
                          <input type="hidden" name="idmarca" id="idmarca" value="1"/>           <!--  idmarca = 1 | nombre = NINGUNO -->
                          <input type="hidden" name="idsunat_unidad_medida" id="idsunat_unidad_medida" value="1"/> <!--  idsunat_unidad_medida = 1 | nombre = NINGUNO -->


                          <!-- ----------------- CODIGO --------------- -->
                          <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                              <label for="codigo" class="form-label">Código(*)</label>
                              <input type="text" class="form-control" name="codigo" id="codigo" onkeyup="mayus(this);" placeholder="ejemp: 0001" />
                            </div>
                          </div>
                          <!-- ----------------- Categoria --------------- -->
                          <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                            <div class="form-group">
                              <label for="categoria" class="form-label"> Categoría </label>
                              
                              <select class="form-comtrol" name="idcategoria" id="idcategoria">
                                <option value="1">NINGUNO</option>
                                <option value="2">SERVICIO</option>
                              </select>
                            </div>
                          </div>

                          <!-- --------- NOMBRE ------ -->
                          <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                            <div class="form-group">
                              <label for="nombre" class="form-label">Nombre(*)</label>
                              <textarea class="form-control" name="nombre" id="nombre" rows="1"></textarea>
                            </div>
                          </div>

                          <!-- ----------------- PRECIO VENTA --------------- -->
                          <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                            <div class="form-group">
                              <label for="precio_v" class="form-label">Precio Venta(*)</label>
                              <input type="number" class="form-control" name="precio_v" id="precio_v" />
                            </div>
                          </div>

                          <!-- --------- DESCRIPCION ------ -->
                          <div class="col-md-6 col-lg-6 col-xl-9 col-xxl-9 mt-3">
                            <div class="form-group">
                              <label for="descripcion" class="form-label">Descrición(*)</label>
                              <textarea class="form-control" name="descripcion" id="descripcion" rows="1"></textarea>
                            </div>
                          </div>


                          <!-- Imgen -->
                          <div class="col-md-4 col-lg-4 mt-4">
                            <span class="" > <b>Imagen Servicio</b> </span>
                            <div class="mb-4 mt-2 d-sm-flex align-items-center">
                              <div class="mb-0 me-5">
                                <span class="avatar avatar-xxl avatar-rounded">
                                  <img src="../assets/modulo/servicios/no-servicio.png" alt="" id="imagenmuestra" onerror="this.src='../assets/modulo/servicios/no-servicio.png';">
                                  <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge cursor-pointer">
                                    <input type="file" class="position-absolute w-100 h-100 op-0" name="imagen" id="imagen" accept="image/*">
                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <i class="fe fe-camera  "></i>
                                  </a>
                                </span>
                              </div>
                              <div class="btn-group">
                                <a class="btn btn-primary" onclick="cambiarImagen()"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</a>
                                <a class="btn btn-light" onclick="removerImagen()"><i class="bi bi-trash fs-6"></i> Remover</a>
                              </div>
                            </div>
                          </div> 

                        </div>
                        <div class="row" id="cargando-2-fomulario" style="display: none;" >
                          <div class="col-lg-12 text-center">                         
                            <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                            <h4 class="bx-flashing">Cargando...</h4>
                          </div>
                        </div>
                        <!-- Chargue -->
                        <div class="p-l-25px col-lg-12" id="barra_progress_servicio_div" style="display: none;" >
                          <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                            <div id="barra_progress_servicio" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                          </div>
                        </div>
                        <!-- Submit -->
                        <button type="submit" style="display: none;" id="submit-form-servicio">Submit</button>
                        
                      </form>
                    </div>
                  </div>
                  <div class="card-footer border-top-0">
                    <button type="button" class="btn btn-danger btn-cancelar" onclick="show_hide_form(1);" style="display: none;"><i class="las la-times fs-lg"></i> Cancelar</button>
                    <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"  > <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
                  </div> 
                </div>
              </div>
            </div>
          </div>
          <!-- End::row-1 -->




        </div>
      </div>
      <!-- End::app-content -->

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>
    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>

    <!-- Select2 Cdn -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="scripts/servicio.js"></script>
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