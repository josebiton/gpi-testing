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
  <html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="icon-overlay-close">

  <head>
    <?php $title_page = "Compras";
    include("template/head.php"); ?>
  </head>

  <body id="body-compras">
    <?php include("template/switcher.php"); ?>
    <?php include("template/loader.php"); ?>

    <div class="page">
      <?php include("template/header.php") ?>
      <?php include("template/sidebar.php") ?>
      <?php if($_SESSION['lista_de_compras']==1) { ?>
      <!-- Start::app-content -->
      <div class="main-content app-content">
        <div class="container-fluid">

          <!-- Start::page-header -->
          <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
              <div class="d-md-flex d-block align-items-center ">
                <button class="btn-modal-effect btn btn-primary label-btn btn-agregar m-r-10px" onclick="show_hide_form(2);  limpiar_form_compra(); "  > <i class="ri-user-add-line label-btn-icon me-2"></i>Agregar </button>
                <button type="button" class="btn btn-danger btn-cancelar m-r-10px" onclick="show_hide_form(1);" style="display: none;"><i class="ri-arrow-left-line"></i></button>
                <button class="btn-modal-effect btn btn-success label-btn btn-guardar m-r-10px" style="display: none;"  > <i class="ri-save-2-line label-btn-icon me-2" ></i> Guardar </button>
                <div>
                  <p class="fw-semibold fs-18 mb-0">Facturación</p>
                  <span class="fs-semibold text-muted">Administra tus comprobantes de pago.</span>
                </div>
              </div>
            </div>
            <div class="btn-list mt-md-0 mt-2">
              <nav>
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Lista de comprobantes</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Facturación</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- End::page-header -->

          <!-- Start::row-1 -->
          <div class="row">     

            <!-- TABLA - FACTURA -->
            <div class="col-xl-9" id="div-tabla">
              <div class="card custom-card">
                <div class="card-header justify-content-between">
                  <div class="card-title">
                    Manage Invoices
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-sm btn-primary btn-wave waves-light"><i class="ri-add-line fw-semibold align-middle me-1"></i> Create Invoice</button>
                    <div class="dropdown ms-2">
                      <button class="btn btn-icon btn-secondary-light btn-sm btn-wave waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:void(0);">All Invoices</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Paid Invoices</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Pending Invoices</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Overdue Invoices</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered w-100" style="width: 100%;" id="tabla-compras">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">OP</th>
                          <th>Fecha</th>
                          <th>Proveedor</th>
                          <th>Tipo y Serie Comprob</th>
                          <th>Total</th> 
                          <th>Descripción</th>
                          <th>CFDI</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                      <tfoot>
                        <tr>
                        <th class="text-center">#</th>
                          <th class="text-center">OP</th>
                          <th>Fecha</th>
                          <th>Proveedor</th>
                          <th>Tipo y Serie Comprob</th>
                          <th>Total</th>
                          <th>Descripción</th>
                          <th>CFDI</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>                
              </div>
            </div>

            <!-- REPORTE- MINI -->
            <div class="col-xl-3" id="div-mini-reporte">
              <div class="card custom-card">
                <div class="card-body p-0">
                  <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-top">
                    <div class="svg-icon-background bg-primary-transparent me-4">
                      <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" class="svg-primary">
                        <path d="M13,16H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2ZM9,10h2a1,1,0,0,0,0-2H9a1,1,0,0,0,0,2Zm12,2H18V3a1,1,0,0,0-.5-.87,1,1,0,0,0-1,0l-3,1.72-3-1.72a1,1,0,0,0-1,0l-3,1.72-3-1.72a1,1,0,0,0-1,0A1,1,0,0,0,2,3V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM5,20a1,1,0,0,1-1-1V4.73L6,5.87a1.08,1.08,0,0,0,1,0l3-1.72,3,1.72a1.08,1.08,0,0,0,1,0l2-1.14V19a3,3,0,0,0,.18,1Zm15-1a1,1,0,0,1-2,0V14h2Zm-7-7H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Total Invoices Amount
                        <span class="badge bg-primary fw-semibold float-end">
                          12,345
                        </span>
                      </h6>
                      <div class="pb-0 mt-0">
                        <div>
                          <h4 class="fs-18 fw-semibold mb-2">$<span class="count-up" data-count="192">192</span>.87K</h4>
                          <p class="text-muted fs-11 mb-0 lh-1">
                            <span class="text-success me-1 fw-semibold">
                              <i class="ri-arrow-up-s-line me-1 align-middle"></i>3.25%
                            </span>
                            <span>this month</span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-top">
                    <div class="svg-icon-background bg-success-transparent me-4">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="svg-success">
                        <path d="M11.5,20h-6a1,1,0,0,1-1-1V5a1,1,0,0,1,1-1h5V7a3,3,0,0,0,3,3h3v5a1,1,0,0,0,2,0V9s0,0,0-.06a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.29.29,0,0,0-.1,0A1.1,1.1,0,0,0,11.56,2H5.5a3,3,0,0,0-3,3V19a3,3,0,0,0,3,3h6a1,1,0,0,0,0-2Zm1-14.59L15.09,8H13.5a1,1,0,0,1-1-1ZM7.5,14h6a1,1,0,0,0,0-2h-6a1,1,0,0,0,0,2Zm4,2h-4a1,1,0,0,0,0,2h4a1,1,0,0,0,0-2Zm-4-6h1a1,1,0,0,0,0-2h-1a1,1,0,0,0,0,2Zm13.71,6.29a1,1,0,0,0-1.42,0l-3.29,3.3-1.29-1.3a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,21.21,16.29Z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Total Paid Invoices
                        <span class="badge bg-success fw-semibold float-end">
                          4,176
                        </span>
                      </h6>
                      <div>
                        <h4 class="fs-18 fw-semibold mb-2">$<span class="count-up" data-count="68.83">68.83</span>K</h4>
                        <p class="text-muted fs-11 mb-0 lh-1">
                          <span class="text-danger me-1 fw-semibold">
                            <i class="ri-arrow-down-s-line me-1 align-middle"></i>1.16%
                          </span>
                          <span>this month</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex align-items-top p-4 border-bottom border-block-end-dashed">
                    <div class="svg-icon-background bg-warning-transparent me-4">
                      <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" class="svg-warning">
                        <path d="M19,12h-7V5c0-0.6-0.4-1-1-1c-5,0-9,4-9,9s4,9,9,9s9-4,9-9C20,12.4,19.6,12,19,12z M12,19.9c-3.8,0.6-7.4-2.1-7.9-5.9C3.5,10.2,6.2,6.6,10,6.1V13c0,0.6,0.4,1,1,1h6.9C17.5,17.1,15.1,19.5,12,19.9z M15,2c-0.6,0-1,0.4-1,1v6c0,0.6,0.4,1,1,1h6c0.6,0,1-0.4,1-1C22,5.1,18.9,2,15,2z M16,8V4.1C18,4.5,19.5,6,19.9,8H16z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Pending Invoices
                        <span class="badge bg-warning fw-semibold float-end">
                          7,064
                        </span>
                      </h6>
                      <div>
                        <h4 class="fs-18 fw-semibold mb-2">$<span class="count-up" data-count="81.57">81.57</span>K</h4>
                        <p class="text-muted fs-11 mb-0 lh-1">
                          <span class="text-success me-1 fw-semibold">
                            <i class="ri-arrow-up-s-line me-1 align-middle"></i>0.25%
                          </span>
                          <span>this month</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex align-items-top p-4 border-bottom border-block-end-dashed">
                    <div class="svg-icon-background bg-light me-4">
                      <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" class="svg-dark">
                        <path d="M19,12h-7V5c0-0.6-0.4-1-1-1c-5,0-9,4-9,9s4,9,9,9s9-4,9-9C20,12.4,19.6,12,19,12z M12,19.9c-3.8,0.6-7.4-2.1-7.9-5.9C3.5,10.2,6.2,6.6,10,6.1V13c0,0.6,0.4,1,1,1h6.9C17.5,17.1,15.1,19.5,12,19.9z M15,2c-0.6,0-1,0.4-1,1v6c0,0.6,0.4,1,1,1h6c0.6,0,1-0.4,1-1C22,5.1,18.9,2,15,2z M16,8V4.1C18,4.5,19.5,6,19.9,8H16z" />
                      </svg>
                    </div>
                    <div class="flex-fill">
                      <h6 class="mb-2 fs-12">Overdue Invoices
                        <span class="badge bg-light text-default fw-semibold float-end">
                          1,105
                        </span>
                      </h6>
                      <div>
                        <h4 class="fs-18 fw-semibold mb-2">$<span class="count-up" data-count="32.47">32.47</span>K</h4>
                        <p class="text-muted fs-11 mb-0 lh-1">
                          <span class="text-success me-1 fw-semibFold">
                            <i class="ri-arrow-down-s-line me-1 align-middle"></i>0.46%
                          </span>
                          <span>this month</span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="p-4">
                    <p class="fs-15 fw-semibold">Invoice Status <span class="text-muted fw-normal">(Last 6 months) :</span></p>
                    <div id="invoice-list-stats"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- FORMULARIO -->
            <div class="col-xxl-12 col-xl-12" id="div-formulario"  style="display: none;">              
              <div class="card custom-card">
                <div class="card-body">                    
                  
                  <!-- FORM - COMPROBANTE -->                    
                  <form name="form-agregar-compra" id="form-agregar-compra" method="POST" class="needs-validation" novalidate>
                    <div class="row" id="cargando-1-formulario">

                      <!-- IMPUESTO -->
                      <input type="hidden" name="idcompra" id="idcompra" />
                      <!-- IMPUESTO -->
                      <input type="hidden" class="form-control" name="impuesto" id="impuesto" value="">                      

                      <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="row gy-3">
                          <!--  TIPO COMPROBANTE  -->
                          <div class="col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                            <div class="mb-sm-0 mb-2">
                              <p class="fs-14 mb-2 fw-semibold">Tipo de comprobante</p>
                              <div class="mb-0 authentication-btn-group">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                  <input type="radio" class="btn-check" name="tipo_comprobante" id="tipo_comprobante1" checked="" onchange="modificarSubtotales();">
                                  <label class="btn btn-outline-primary" for="tipo_comprobante1"><i class="ri-article-line me-1 align-middle d-inline-block"></i>Boleta</label>
                                  <input type="radio" class="btn-check" name="tipo_comprobante" id="tipo_comprobante2" onchange="modificarSubtotales();">
                                  <label class="btn btn-outline-primary" for="tipo_comprobante2"><i class="ri-article-line me-1 align-middle d-inline-block"></i> Factura</label>
                                  <input type="radio" class="btn-check" name="tipo_comprobante" id="tipo_comprobante3" onchange="modificarSubtotales();">
                                  <label class="btn btn-outline-primary" for="tipo_comprobante3"><i class='bx bx-file-blank me-1 align-middle d-inline-block'></i> Ticket</label>
                                </div>
                              </div>
                            </div>                            
                          </div>    
                          
                          <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                            <div class="form-group">
                              <label for="fecha_compra" class="form-label">Serie comprobante</label>
                              <select class="form-control" name="serie_comprobante" id="serie_comprobante"></select>
                            </div>
                          </div>

                          <!--  PROVEEDOR  -->
                          <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="form-group">
                              <label for="idproveedor" class="form-label">
                                <!-- <span class="badge bg-success m-r-4px cursor-pointer" onclick=" modal_add_trabajador(); limpiar_proveedor();" data-bs-toggle="tooltip" title="Agregar"><i class="las la-plus"></i></span> -->
                                <span class="badge bg-info m-r-4px cursor-pointer" onclick="reload_idproveedor();" data-bs-toggle="tooltip" title="Actualizar"><i class="las la-sync-alt"></i></span>
                                Cliente
                                <span class="charge_idproveedor"></span>
                              </label>
                              <select class="form-control" name="idproveedor" id="idproveedor"></select>
                            </div>
                          </div>     
                          
                          <!-- FECHA EMISION -->
                          <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                            <div class="form-group">
                              <label for="fecha_compra" class="form-label">Es cobro?</label>
                              <div class="toggle toggle-secondary on mb-3">  <span></span>   </div>
                            </div>
                          </div>  

                          <!-- FECHA EMISION -->
                          <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                            <div class="form-group">
                              <label for="fecha_compra" class="form-label">Periodo Pago</label>
                              <input type="month" class="form-control" name="fecha_compra" id="fecha_compra"  max="<?php echo date('Y-m-d'); ?>">
                            </div>
                          </div>                          

                          <!-- DESCRIPCION -->
                          <div class="col-md-6 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="form-group">
                              <label for="descripcion" class="form-label">Observacion</label>
                              <textarea name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="ejemp: Cobro de servicio de internet."></textarea>
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                        <div class="row">
                          <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                            <button class="btn btn-info label-btn m-r-10px" type="button" onclick="listar_tabla_producto('PR');"  >
                              <i class="ri-add-circle-line label-btn-icon me-2"></i> Productos 
                            </button>
                          </div>
                          <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-2">
                            <button class="btn btn-primary label-btn m-r-10px" type="button"  onclick="listar_tabla_producto('SR');"  >
                            <i class="ri-add-fill label-btn-icon me-2"></i> 
                              Servicio
                            </button>
                          </div>  

                          <div class="col-lg-5 col-xl-5 col-xxl-5">
                            <div class="input-group">                              
                              <button type="button" class="input-group-text buscar_x_code" onclick="listar_producto_x_codigo();"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Buscar por codigo de producto."><i class='bx bx-search-alt'></i></button>
                              <input type="text" name="codigob" id="codigob" class="form-control" onkeyup="mayus(this);" placeholder="Digite el código de producto." >
                            </div>
                          </div>                                              

                          <!-- ------- TABLA PRODUCTOS SELECCIONADOS ------ --> 
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive pt-3">
                            <table id="tabla-productos-seleccionados" class="table table-striped table-bordered table-condensed table-hover">
                              <thead class="bg-color-dark text-white">
                                <th class="fs-11 py-1" data-toggle="tooltip" data-original-title="Opciones">Op.</th>
                                <th class="fs-11 py-1">Cod</th> 
                                <th class="fs-11 py-1">Producto</th>
                                <th class="fs-11 py-1">Unidad</th>
                                <th class="fs-11 py-1">Cantidad</th>                                        
                                <th class="fs-11 py-1" data-toggle="tooltip" data-original-title="Precio Unitario">P/U</th>
                                <th class="fs-11 py-1">Descuento</th>
                                <th class="fs-11 py-1">Subtotal</th>
                                <th class="fs-11 py-1 text-center" ><i class='bx bx-cog fs-4'></i></th>
                              </thead>
                              <tbody ></tbody>
                              <tfoot>
                                <td colspan="6"></td>

                                <th class="text-right">
                                  <h6 class="fs-11 tipo_gravada">SUBTOTAL</h6>
                                  <h6 class="fs-11 ">DESCUENTO</h6>
                                  <h6 class="fs-11 val_igv">IGV (18%)</h6>
                                  <h5 class="fs-13 font-weight-bold">TOTAL</h5>
                                </th>
                                <th class="text-right"> 
                                  <h6 class="fs-11 font-weight-bold d-flex justify-content-between subtotal_compra"> <span>S/</span>  0.00</h6>
                                  <input type="hidden" name="subtotal_compra" id="subtotal_compra" />
                                  <input type="hidden" name="tipo_gravada" id="tipo_gravada" />

                                  <h6 class="fs-11 font-weight-bold d-flex justify-content-between descuento_compra"><span>S/</span> 0.00</h6>
                                  <input type="hidden" name="descuento_compra" id="descuento_compra" />

                                  <h6 class="fs-11 font-weight-bold d-flex justify-content-between igv_compra"><span>S/</span> 0.00</h6>
                                  <input type="hidden" name="igv_compra" id="igv_compra" />
                                  
                                  <h5 class="fs-13 font-weight-bold d-flex justify-content-between total_compra"><span>S/</span> 0.00</h5>
                                  <input type="hidden" name="total_compra" id="total_compra" />
                                  
                                </th>
                                <th></th>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>

                    </div>  
                    
                    <!-- ::::::::::: CARGANDO ... :::::::: -->
                    <div class="row" id="cargando-2-fomulario" style="display: none;" >
                      <div class="col-lg-12 mt-5 text-center">                         
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>

                    <!-- Chargue -->
                    <div class="p-l-25px col-lg-12" id="barra_progress_compra_div" style="display: none;" >
                      <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                        <div id="barra_progress_compra" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                      </div>
                    </div>
                    <!-- Submit -->
                    <button type="submit" style="display: none;" id="submit-form-compra">Submit</button>
                  </form>                                  

                </div>
                <div class="card-footer border-top-0">
                  <button type="button" class="btn btn-danger btn-cancelar" onclick="show_hide_form(1); limpiar_form_compra();" style="display: none;"><i class="las la-times fs-lg"></i> Cancelar</button>
                  <button type="button" class="btn btn-success btn-guardar" id="guardar_registro_compra" style="display: none;"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                </div>
              </div>              
            </div>

          </div>
          <!-- End::row-1 -->

          <!-- MODAL - VER COMPROBANTE COMPRA -->
          <div class="modal fade modal-effect" id="modal-ver-comprobante1" tabindex="-1" aria-labelledby="modal-ver-comprobante1Label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title title-modal-comprobante1" id="modal-ver-comprobante1Label1">COMPROBANTE</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div id="comprobante-container1" class="text-center"> <!-- archivo --> 
                    <div class="row" >
                      <div class="col-lg-12 text-center"> <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div> <h4 class="bx-flashing">Cargando...</h4></div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-danger py-1" data-bs-dismiss="modal" ><i class="las la-times"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div> 
          <!-- End::Modal-Ver-Comprobante compra -->

          <!-- MODAL - VER FOTO PROVEEDOR -->
          <div class="modal fade modal-effect" id="modal-ver-foto-proveedor" tabindex="-1" aria-labelledby="modal-ver-foto-proveedor" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title title-foto-proveedor" id="modal-ver-foto-proveedorLabel1">Imagen</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body html_ver_foto_proveedor">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" ><i class="las la-times fs-lg"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div> 
          <!-- End::Modal - Ver foto proveedor -->

          <!-- MODAL - SELECIONAR PRODUCTO -->
          <div class="modal fade modal-effect" id="modal-producto" tabindex="-1" aria-labelledby="title-modal-producto-label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="title-modal-producto-label">Seleccionar Producto</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                  <table id="tabla-productos" class="table table-bordered w-100">
                    <thead>
                      <th>Op.</th>
                      <th>Code</th>
                      <th>Nombre Producto</th>                              
                      <th>P/U.</th>
                      <th>Descripción</th>
                    </thead>
                    <tbody></tbody>
                  </table>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" ><i class="las la-times"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div>
          <!-- End::Modal-Producto -->

          <!-- MODAL - DETALLE COMPRA -->
          <div class="modal fade modal-effect" id="modal-detalle-compra" tabindex="-1" aria-labelledby="modal-detalle-compraLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-detalle-compraLabel1">Detalle - Compra</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                      <ul class="nav nav-tabs" id="custom-tab" role="tablist">
                        <!-- DATOS VENTA -->
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="rol-compra" data-bs-toggle="tab" data-bs-target="#rol-compra-pane" type="button" role="tab" aria-selected="true">COMPRA</button>
                        </li>
                        <!-- DATOS TOURS -->
                        <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rol-detalle" data-bs-toggle="tab" data-bs-target="#rol-detalle-pane" type="button" role="tab" aria-selected="true">PRODUCTOS</button>
                        </li>
                        
                      </ul>
                      <div class="tab-content" id="custom-tabContent">                                
                        <!-- /.tab-panel --> 
                      </div> 

                    <div class="row" id="cargando-4-fomulario" style="display: none;">
                      <div class="col-lg-12 text-center">
                        <i class="fas fa-spinner fa-pulse fa-6x"></i><br />
                        <br />
                        <h4>Cargando...</h4>
                      </div>
                    </div>
                    
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-danger py-1" data-bs-dismiss="modal" ><i class="las la-times"></i> Close</button>                  
                </div>
              </div>
            </div>
          </div> 
          <!-- End::Modal-Detalle-Compra -->

          <!-- MODAL - AGREGAR PROVEEDOR - charge 3,4 -->
          <div class="modal fade modal-effect" id="modal-agregar-proveedor" tabindex="-1" aria-labelledby="Modal-agregar-proveedorLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title title-modal-img" id="Modal-agregar-proveedorLabel1">Agregar Proveedor</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                                      
                    <form name="form-agregar-proveedor" id="form-agregar-proveedor" method="POST" class="needs-validation" novalidate>
                            
                      <div class="row" id="cargando-3-fomulario">
                        <!-- idpersona -->
                        <input type="hidden" name="idpersona" id="idpersona" />   
                        <input type="hidden" name="tipo_persona_sunat" id="tipo_persona_sunat" value="NATURAL" />   
                        <input type="hidden" name="idtipo_persona" id="idtipo_persona" value="4" />   

                        <div class="col-lg-12 col-xl-12 col-xxl-6">
                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                              <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b class="mx-2" >DATOS GENERALES</b></label></div>
                            </div>
                          </div> <!-- /.row -->
                          <div class="card-body p-3" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                            <div class="row">

                              <!-- Tipo documento -->
                              <div class="mb-1 col-md-3 col-lg-3 col-xl-3 col-xxl-6">
                                <div class="form-group">
                                  <label for="tipo_documento" class="form-label">Tipo documento:  </label>
                                  <select name="tipo_documento" id="tipo_documento" class="form-select" required>                                      
                                  </select>
                                </div>                                         
                              </div>
                              
                              <!--  Numero Documento -->
                              <div class="mb-1 col-md-3 col-lg-3 col-xl-3 col-xxl-6">
                                <div class="form-group">
                                  <label for="numero_documento" class="form-label">Numero Documento:</label>
                                  <div class="input-group">                            
                                    <input type="number" class="form-control" name="numero_documento" id="numero_documento" placeholder="" aria-describedby="icon-view-password">
                                    <button class="btn btn-primary" type="button" onclick="buscar_sunat_reniec('_t', '#tipo_documento', '#numero_documento', '#nombre_razonsocial', '#apellidos_nombrecomercial', '#direccion', '#distrito', '#titular_cuenta' );" >
                                      <i class='bx bx-search-alt' id="search_t"></i>
                                      <div class="spinner-border spinner-border-sm" role="status" id="charge_t" style="display: none;"></div>
                                    </button>
                                  </div>
                                </div>                        
                              </div>         
                            
                              <!-- Nombres -->
                              <div class="mb-1 col-md-6 col-lg-6 col-xl-4 col-xxl-6">
                                <div class="form-group">
                                  <label for="nombre_razonsocial" class="form-label label-nom-raz">Nombres:  </label></label>
                                  <input type="text" class="form-control" name="nombre_razonsocial" id="nombre_razonsocial" >
                                </div>                                         
                              </div>

                              <!-- Apellidos -->
                              <div class="mb-1 col-md-6 col-lg-6 col-xl-4 col-xxl-6 ">
                                <div class="form-group">
                                  <label for="apellidos_nombrecomercial" class="form-label label-ape-come">Apellidos:  </label></label>
                                  <input type="text" class="form-control" name="apellidos_nombrecomercial" id="apellidos_nombrecomercial" >
                                </div>                                         
                              </div>

                              <!-- Correo -->
                              <div class="mb-1 col-md-6 col-lg-4 col-xl-4 col-xxl-6">
                                <div class="form-group">
                                  <label for="correo" class="form-label">Correo:</label>
                                  <input type="email" class="form-control" name="correo" id="correo">
                                </div>                                         
                              </div>

                              <!-- Celular -->
                              <div class="col-md-6 col-lg-3 col-xl-4 col-xxl-6">
                                <div class="form-group">
                                  <label for="celular" class="form-label">Celular:</label>
                                  <input type="tel" class="form-control" name="celular" id="celular" >
                                </div>                                         
                              </div>                                   

                            </div> <!-- /.row -->
                          </div> <!-- /.card-body -->
                        </div> <!-- /.col-lg-12 -->

                        <div class="col-lg-12 col-xl-12 col-xxl-6">
                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                              <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b class="mx-2" >UBICACIÓN</b></label></div>
                            </div>
                          </div> <!-- /.row -->
                          <div class="card-body p-3" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                            <div class="row">

                              <!-- Direccion -->
                              <div class="mb-1 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mt-3">
                                <div class="form-group">
                                  <label for="direccion" class="form-label">Direccion:</label>
                                  <input type="text" class="form-control" name="direccion" id="direccion">
                                </div>                                         
                              </div>
                              <!-- Distrito -->
                              <div class="mb-1 col-md-3 col-lg-6 col-xl-6 col-xxl-6 mt-3">
                                <div class="form-group">
                                  <label for="distrito" class="form-label">Distrito: </label>
                                  <select name="distrito" id="distrito" class="form-select" onchange="llenar_dep_prov_ubig(this);" >
                                    
                                  </select>
                                </div>                                         
                              </div>
                              <!-- Departamento -->
                              <div class="mb-1 col-md-3 col-lg-3 col-xl-4 col-xxl-4">
                                <div class="form-group">
                                  <label for="departamento" class="form-label">Departamento: <span class="chargue-pro"></span></label>
                                  <input type="text" class="form-control" name="departamento" id="departamento">
                                </div>                                         
                              </div>
                              <!-- Provincia -->
                              <div class="mb-1 col-md-3 col-lg-3 col-xl-4 col-xxl-4">
                                <div class="form-group">
                                  <label for="provincia" class="form-label">Provincia: <span class="chargue-dep"></span></label>
                                  <input type="text" class="form-control" name="provincia" id="provincia">
                                </div>                                         
                              </div>
                              <!-- Ubigeo -->
                              <div class="mb-1 col-md-3 col-lg-3 col-xl-4 col-xxl-4">
                                <div class="form-group">
                                  <label for="ubigeo" class="form-label">Ubigeo: <span class="chargue-ubi"></span></label>
                                  <input type="text" class="form-control" name="ubigeo" id="ubigeo">
                                </div>                                         
                              </div>
                            </div> <!-- /.row -->
                          </div> <!-- /.card-body -->
                        </div> <!-- /.col-lg-12 -->

                        <div class="mt-3 col-lg-12 col-xl-12 col-xxl-12">
                          <div class="row">
                            <!-- Grupo -->
                            <div class="col-12 pl-0">
                              <div class="text-primary p-l-10px" style="position: relative; top: 10px;"><label class="bg-white" for=""><b class="mx-2" >BANCO</b></label></div>
                            </div>
                          </div> <!-- /.row -->
                          <div class="card-body p-3" style="border-radius: 5px; box-shadow: 0 0 2px rgb(0 0 0), 0 1px 5px 4px rgb(255 255 255 / 60%);">
                            <div class="row">

                              <!-- Banco -->
                              <div class="mb-1 col-md-3 col-lg-6 col-xl-6 col-xxl-4 mt-3">
                                <div class="form-group">
                                  <label for="idbanco" class="form-label">Entidad Financiera:  </label>
                                  <select name="idbanco" id="idbanco" class="form-select" required>                                       
                                  </select>
                                </div>                                         
                              </div>

                              <!-- Cuenta Bancaria -->
                              <div class="mb-1 col-md-6 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                                <div class="form-group">
                                  <label for="cuenta_bancaria" class="form-label">Cuenta Bancaria:</label>
                                  <input type="text" class="form-control" name="cuenta_bancaria" id="cuenta_bancaria" >
                                </div>                                         
                              </div>

                              <!-- CCI -->
                              <div class="mb-1 col-md-6 col-lg-3 col-xl-4 col-xxl-4 mt-3">
                                <div class="form-group">
                                  <label for="cci" class="form-label">CCI:</label>
                                  <input type="text" class="form-control" name="cci" id="cci" >
                                </div>                                         
                              </div>

                            </div> <!-- /.row -->
                          </div> <!-- /.card-body -->
                        </div> <!-- /.col-lg-12 -->

                        <!-- Imgen -->
                        <div class="col-md-4 col-lg-4 mt-4">
                          <span class="" > <b>Logo Proveedor</b> </span>
                          <div class="mb-4 mt-2 d-sm-flex align-items-center">
                            <div class="mb-0 me-5">
                              <span class="avatar avatar-xxl avatar-rounded">
                                <img src="../assets/images/default/default_proveedor.png" alt="" id="imagenmuestra" onerror="this.src='../assets/images/default/default_proveedor.png';">
                                <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge cursor-pointer">
                                  <input type="file" class="position-absolute w-100 h-100 op-0" name="imagen" id="imagen" accept="image/*">
                                  <input type="hidden" name="imagenactual" id="imagenactual">
                                  <i class="fe fe-camera  "></i>
                                </a>
                              </span>
                            </div>
                            <div class="btn-group">
                              <a class="btn btn-primary" onclick="cambiarImagenProveedor()"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</a>
                              <a class="btn btn-light" onclick="removerImagenProveedor()"><i class="bi bi-trash fs-6"></i> Remover</a>
                            </div>
                          </div>
                        </div> 

                      </div> <!-- /.row -->

                      <div class="row" id="cargando-4-fomulario" style="display: none;" >
                        <div class="col-lg-12 text-center">                         
                          <div class="spinner-border me-4" style="width: 3rem; height: 3rem;"role="status"></div>
                          <h4 class="bx-flashing">Cargando...</h4>
                        </div>
                      </div>  <!-- /.row -->                                   
                      
                      <!-- Chargue -->
                      <div class="p-l-25px col-lg-12" id="barra_progress_proveedor_div" style="display: none;" >
                        <div  class="progress progress-lg custom-progress-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> 
                          <div id="barra_progress_proveedor" class="progress-bar" style="width: 0%"> <div class="progress-bar-value">0%</div> </div> 
                        </div>
                      </div>
                      <!-- Submit -->
                      <button type="submit" style="display: none;" id="submit-form-proveedor">Submit</button>
                    </form>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-danger"  data-bs-dismiss="modal" ><i class="las la-times"></i> Close</button>                  
                  <button type="button" class="btn btn-sm btn-success label-btn" id="guardar_registro_proveedor"><i class="bx bx-save bx-tada"></i> Guardar</button>
                </div>
              </div>
            </div>
          </div> 
          <!-- End::Modal-Agregar-Proveedor -->
          
          <!-- MODAL - AGREGAR PRODUCTO - charge p1 -->
          <div class="modal fade modal-effect" id="modal-agregar-producto" role="dialog" tabindex="-1" aria-labelledby="modal-agregar-productoLabel">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-agregar-productoLabel1">Registrar Producto</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form name="form-agregar-producto" id="form-agregar-producto" method="POST" class="row needs-validation" novalidate >
                    <div class="row gy-2" id="cargando-P1-formulario">
                      <!-- ----------------------- ID ------------- -->
                      <input type="hidden" id="idproducto" name="idproducto">

                      <!-- ----------------- Categoria --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                          <label for="categoria" class="form-label">Categoría</label>
                          <select class="form-control" name="categoria" id="categoria">
                            <!-- lista de categorias -->
                          </select>
                        </div>
                      </div>

                      <!-- ----------------- Unidad Medida --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                          <label for="u_medida" class="form-label">U. Medida</label>
                          <select class="form-control" name="u_medida" id="u_medida">
                            <!-- lista de u medidas -->
                          </select>
                        </div>
                      </div>

                      <!-- ----------------- Marca --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="form-group">
                          <label for="marca" class="form-label">Marca</label>
                          <select class="form-control" name="marca" id="marca">
                            <!-- lista de marcas -->
                          </select>
                        </div>
                      </div>
                      <!-- --------- NOMBRE ------ -->
                      <div class="col-md-4 col-lg-4 col-xl-6 col-xxl-6 mt-3">
                        <div class="form-group">
                          <label for="nombre" class="form-label">Nombre(*)</label>
                          <textarea class="form-control" name="nombre" id="nombre" rows="1"></textarea>
                        </div>
                      </div>

                      <!-- --------- DESCRIPCION ------ -->
                      <div class="col-md-4 col-lg-4 col-xl-6 col-xxl-6 mt-3">
                        <div class="form-group">
                          <label for="descripcion" class="form-label">Descrición(*)</label>
                          <textarea class="form-control" name="descripcion" id="descripcion" rows="1"></textarea>
                        </div>
                      </div>

                      <!-- ----------------- STOCK --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="stock" class="form-label">Stock(*)</label>
                          <input type="number" class="form-control" name="stock" id="stock" />
                        </div>
                      </div>

                      <!-- ----------------- STOCK MININO --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="stock_min" class="form-label">Stock Minimo(*)</label>
                          <input type="number" class="form-control" name="stock_min" id="stock_min" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO VENTA --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="precio_v" class="form-label">Precio Venta(*)</label>
                          <input type="number" class="form-control" name="precio_v" id="precio_v" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO COMPRA --------------- -->
                      <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mt-3">
                        <div class="form-group">
                          <label for="precio_c" class="form-label">Precio Compra(*)</label>
                          <input type="number" class="form-control" name="precio_c" id="precio_c" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO X MAYOR --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                        <div class="form-group">
                          <label for="precio_x_mayor" class="form-label">Precio por Mayor</label>
                          <input type="text" class="form-control" name="precio_x_mayor" id="precio_x_mayor" placeholder="precioB" />
                        </div>
                      </div>

                      <!-- ----------------- PRECIO DISTRIBUIDOR --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                        <div class="form-group">
                          <label for="precio_dist" class="form-label">Precio Distribuidor</label>
                          <input type="text" class="form-control" name="precio_dist" id="precio_dist" placeholder="precioC"/>
                        </div>
                      </div>

                      <!-- ----------------- PRECIO ESPECIAL --------------- -->
                      <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 mt-3">
                        <div class="form-group">
                          <label for="precio_esp" class="form-label">Precio Especial</label>
                          <input type="text" class="form-control" name="precio_esp" id="precio_esp" placeholder="precioD"/>
                        </div>
                      </div>

                      <!-- Imgen -->
                      <div class="col-md-6 col-lg-6 mt-4">
                        <span class="" > <b>Imagen Prducto</b> </span>
                        <div class="mb-4 mt-2 d-sm-flex align-items-center">
                          <div class="mb-0 me-5">
                            <span class="avatar avatar-xxl avatar-rounded">
                              <img src="../assets/modulo/productos/no-producto.png" alt="" id="imagenmuestraProducto" onerror="this.src='../assets/modulo/productos/no-producto.png';">
                              <a href="javascript:void(0);" class="badge rounded-pill bg-primary avatar-badge cursor-pointer">
                                <input type="file" class="position-absolute w-100 h-100 op-0" name="imagenProducto" id="imagenProducto" accept="image/*">
                                <input type="hidden" name="imagenactualProducto" id="imagenactualProducto">
                                <i class="fe fe-camera  "></i>
                              </a>
                            </span>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-primary" onclick="cambiarImagenProducto()"><i class='bx bx-cloud-upload bx-tada fs-5'></i> Subir</a>
                            <a class="btn btn-light" onclick="removerImagenProducto()"><i class="bi bi-trash fs-6"></i> Remover</a>
                          </div>
                        </div>
                      </div> 

                    </div>
                    <div class="row" id="cargando-P2-fomulario" style="display: none;">
                      <div class="col-lg-12 text-center">
                        <div class="spinner-border me-4" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h4 class="bx-flashing">Cargando...</h4>
                      </div>
                    </div>
                    <button type="submit" style="display: none;" id="submit-form-producto">Submit</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limpiar_form_producto();"><i class="las la-times fs-lg"></i> Close</button>
                  <button type="button" class="btn btn-primary" id="guardar_registro_producto"><i class="bx bx-save bx-tada fs-lg"></i> Guardar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End::Modal-Agregar-Producto -->

        </div>
      </div>
      <!-- End::app-content -->
      <?php } else { $title_submodulo ='Compra'; $descripcion ='Lista de Compras del sistema!'; $title_modulo = 'Compras'; include("403_error.php"); }?>   

      <?php include("template/search_modal.php"); ?>
      <?php include("template/footer.php"); ?>
    </div>

    <?php include("template/scripts.php"); ?>
    <?php include("template/custom_switcherjs.php"); ?>   

    <!-- Apex Charts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>
    
    <script src="scripts/facturacion.js"></script>
    <script src="scripts/js_facturacion.js"></script>
    <script>
      $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
      });
    </script>


  </body>



  </html>
<?php
}
ob_end_flush();
?>