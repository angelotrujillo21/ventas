<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
</head>

<body>

 

    <div class="page-loader">
        <div class="loader-dual-ring"></div>
    </div>

    <div class="container-fluid">

        <div class="row">

            <?php extend_view(['admin/common/aside'], $data) ?>

            <main class="main-content col-lg-12 col-md-12 col-sm-12 p-0">

                <?php extend_view(['admin/common/navbar'], $data) ?>

                <div class="main-content-container container-fluid px-2">


                    <div class="container-fluid">
                        <div class="page-header row no-gutters py-4">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                                <div class="card card-small">
                                    <div class="card-body pt-1 pb-5">

                                        <!-- Fila Cabecera -->
                                        <div class="row my-2">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center p-2">

                                                    <div class="flex-center">
                                                        <h5><?= $sTitulo ?></h5>
                                                    </div>

                                                    <div class="ml-auto">
                                                        <button id="btnCrearEmpresa" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblEmpresas" data-url="<?= route('empresas/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sTipoDocumento" data-sortable="true">Tipo Documento</th>
                                                            <th data-field="sNumeroDocumento" data-sortable="true">Numero de documento</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                            <th data-field="sDireccion" data-sortable="true">Direccion</th>
                                                            <th data-field="sCorreo" data-sortable="true">Correo</th>
                                                            <th data-field="sTelefono" data-sortable="true">Telefono</th>
                                                            <th data-field="sImagen" data-sortable="true">Imagen</th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha Creacion</th>
                                                            <th data-field="sEstado" data-sortable="true">Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </main>
        </div>
    </div>



    <!-- Modales -->

    <div class="modal fade" id="formCEEmpresa" tabindex="-1" role="dialog" aria-labelledby="formCEEmpresaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form  enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEEmpresaLabel">Nueva Empresa</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoDocumento" class="col-form-label">Tipo Documento <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoDocumento" id="nTipoDocumento">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoDocumento)): ?>
                                            <?php foreach($aryTipoDocumento as $aryTipoDoc):?>
                                                <option value="<?= $aryTipoDoc["nIdCatalogoTabla"] ?>"><?= $aryTipoDoc["sDescripcionCortaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="sNumeroDocumento" class="col-form-label">Numero de documento <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumento" id="sNumeroDocumento">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNombre" class="col-form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombre" id="sNombre">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="sDireccion" class="col-form-label">Direccion <span class="text-danger">*</span></label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDireccion" id="sDireccion">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="sCorreo" class="col-form-label">Correo <span class="text-danger">*</span></label>
                                     <input type="email" autocomplete="off" placeholder="" class="form-control" name="sCorreo" id="sCorreo">
                                </div>
                            </div>
 

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sTelefono" class="col-form-label">Telefono <span class="text-danger">*</span></label>
                                    <input type="tel" autocomplete="off" placeholder="" class="form-control" name="sTelefono" id="sTelefono">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sImagen" class="col-form-label">Imagen  <img class="img-referencial" alt=""></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImagen" accept="image/*" name="sImagen" lang="es">
                                            <label class="custom-file-label" for="sImagen">Selecciona un archivo</label>
                                        </div>
                                    </div>
                                    <small>Recomendado 128px x 128px</small>
                                </div>
                            </div>



                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sImagenFondoLoginEmpresa" class="col-form-label">Imagen Fondo Login <img src="" class="img-referencial" alt=""></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImagenFondoLoginEmpresa" accept="image/*" name="sImagenFondoLoginEmpresa" lang="es">
                                            <label class="custom-file-label" for="sImagenFondoLoginEmpresa">Selecciona un archivo</label>
                                        </div>
                                    </div>
                                    <small>Recomendado 128px x 128px</small>
                                </div>
                            </div>


                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sDescripcion1Ctz" class="col-form-label">Descripcion 1 Cotizacion <span class="text-danger">*</span></label>
                                    <textarea autocomplete="off" placeholder="" class="form-control" name="sDescripcion1Ctz" id="sDescripcion1Ctz"></textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sDescripcion2Ctz" class="col-form-label">Descripcion 2 Cotizacion <span class="text-danger">*</span></label>
                                    <textarea autocomplete="off" placeholder="" class="form-control" name="sDescripcion2Ctz" id="sDescripcion2Ctz"></textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sDescripcion3Ctz" class="col-form-label">Descripcion 3 Cotizacion <span class="text-danger">*</span></label>
                                    <textarea autocomplete="off" placeholder="" class="form-control" name="sDescripcion3Ctz" id="sDescripcion3Ctz"></textarea>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstado" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstado" id="nEstado">
                                        <option value="1">ACTIVO</option>
                                        <option value="0">DESACTIVO</option>
                                    </select>
                                </div>
                            </div>

                        </div>  
                    </div>                       
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-full-screen" id="formSedes" tabindex="-1" role="dialog" aria-labelledby="formSedesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
                    <div class="modal-header">
                        <h5 class="modal-title" id="formSedesLabel">Sedes</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body modal-body-scroll ">

                            <!-- Fila Cabecera -->
                            <div class="row my-2">
                                    <div class="col-12">
                                     <div class="d-flex align-items-center p-2">

                                         <div class="flex-center">
                                             <h5>Lista de sedes</h5>
                                         </div>

                                         <div class="ml-auto">
                                             <button id="btnCrearSede" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                 <i class="fas fa-plus-circle"></i>
                                             </button>
                                         </div>

                                     </div>
                                    </div>
                            </div>
                            <!-- Fin de Fila Cabecera -->

                            <div class="row my-2 modal-body-scroll">
                                <div class="col-12">
                                    <table data-toggle="table" id="tblSedes"  data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                        <thead>
                                            <tr>
                                                <th data-field="sAcciones">Acciones</th>
                                                <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                <th data-field="sDireccion" data-sortable="true">Direccion</th>
                                                <th data-field="sEncargado" data-sortable="true">Encargado</th>
                                                <th data-field="sTipoMoneda" data-sortable="true">Tipo Moneda</th>
                                                <th data-field="sTipoTicket" data-sortable="true">Tipo Ticket</th>
                                                <th data-field="sImagen" data-sortable="true">Imagen</th>
                                                <th data-field="sDescripcion" data-sortable="true">Descipcion</th>
                                                <th data-field="sEstado" data-sortable="true">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                      
                    </div>                       
                   
               
            </div>
        </div>
    </div>

    <div class="modal fade" id="formCESede" tabindex="-1" role="dialog" aria-labelledby="formCESedeLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form  enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCESedeLabel">Nueva Sede</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                       

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNombreSede" class="col-form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreSede" id="sNombreSede">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="sDireccionSede" class="col-form-label">Direccion <span class="text-danger">*</span></label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDireccionSede" id="sDireccionSede">
                                </div>
                            </div>

                        
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sTelefonoSede" class="col-form-label">Telefono <span class="text-danger">*</span></label>
                                    <input type="tel" autocomplete="off" placeholder="" class="form-control" name="sTelefonoSede" id="sTelefonoSede">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sEncargadoSede" class="col-form-label">Encargado <span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sEncargadoSede" id="sEncargadoSede">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoMonedaSede" class="col-form-label">Tipo Moneda <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoMonedaSede" id="nTipoMonedaSede">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoMoneda)): ?>
                                            <?php foreach($aryTipoMoneda as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoTicketSede" class="col-form-label">Tipo Ticket <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoTicketSede" id="nTipoTicketSede">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoTicket)): ?>
                                            <?php foreach($aryTipoTicket as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sDescripcionSede" class="col-form-label">Descripcion</label>
                                    <textarea class="form-control" name="sDescripcionSede" id="sDescripcionSede"> </textarea>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Imagen</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImagenSede" accept="image/*" name="sImagenSede" lang="es">
                                            <label class="custom-file-label" for="sImagenSede">Selecciona un archivo</label>
                                        </div>
                                    </div>
                                    <small>Recomendado 128px x 128px</small>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstadoSede" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoSede" id="nEstadoSede">
                                        <option value="1">ACTIVO</option>
                                        <option value="0">DESACTIVO</option>
                                    </select>
                                </div>
                            </div>

                        </div>  
                    </div>                       
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade modal-full-screen" id="formDashboard" tabindex="-1" role="dialog" aria-labelledby="formDashboardLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formDashboardLabel">Dashboard</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modal-body-scroll ">

                    <div class="row">
                        <div class="col-12 py-4">
                            <form id="formFilterDashboard">
                                <div class="row border-alll-light">
                                    
                                
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="aryIdSede" class="col-form-label">Sedes:</label>
                                            <select class="form-control" name="aryIdSede" id="aryIdSede" multiple>
                                                <option>TODOS</option>
                                            </select>
                                        </div>
                                    </div>
                                     
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="dRangoFechas" class="col-form-label">Rango de fechas:</label>
                                            <input type="text" class="form-control daterange" id="dRangoFechas" autocomplete="off" name="dRangoFechas">
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-1">
                                        <div class="form-group">
                                            <label for="" class="col-form-label d-none d-md-block">&nbsp;</label>
                                            <button class="btn btn-gradient-primary-table" type="submit" title="Filtrar">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>


                    <div class="row">
                         
                        <div class="col-lg col-md-6 col-sm-6 mb-4">
                             <div class="stats-small stats-small--1 card card-small">
                                 <div class="card-body p-0 d-flex">

                                     <div class="d-flex flex-column m-auto">
                                         <div class="stats-small__data text-center">
                                             <span class="stats-small__label text-uppercase" id="sTitleC1">NUEVOS CLIENTES</span>
                                             <h6 class="stats-small__value count my-3" id="sValorC1">0.00</h6>
                                         </div>
                                         <div class="stats-small__data">
                                             <span id="sValorSubC1" class="stats-small__percentage stats-small__percentage--increase"></span>
                                         </div>
                                     </div>
                                     <canvas height="64" class="blog-overview-stats-small-1 chartjs-render-monitor" width="160"></canvas>
                                 </div>
                             </div>
                        </div>

                        <div class="col-lg col-md-6 col-sm-6 mb-4">
                            <div class="stats-small stats-small--1 card card-small">
                                <div class="card-body p-0 d-flex">

                                    <div class="d-flex flex-column m-auto">
                                        <div class="stats-small__data text-center">
                                            <span class="stats-small__label text-uppercase" id="sTitleC2">CANTIDAD VENTAS</span>
                                            <h6 class="stats-small__value count my-3" id="sValorC2"> 0.00</h6>
                                        </div>
                                        <!-- <div class="stats-small__data">
                                            <span class="stats-small__percentage stats-small__percentage--increase"></span>
                                        </div> -->
                                    </div>
                                    <canvas height="64" class="blog-overview-stats-small-2 chartjs-render-monitor" width="160"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg col-md-4 col-sm-6 mb-4">
                            <div class="stats-small stats-small--1 card card-small">
                                <div class="card-body p-0 d-flex">

                                    <div class="d-flex flex-column m-auto">
                                        <div class="stats-small__data text-center">
                                            <span class="stats-small__label text-uppercase" id="sTitleC3">TOTAL VENTAS (MONTO)</span>
                                            <h6 class="stats-small__value count my-3" id="sValorC3"> S./ 0.00</h6>
                                        </div>
                                        <!-- <div class="stats-small__data">
                                            <span class="stats-small__percentage stats-small__percentage--increase"></span>
                                        </div> -->
                                    </div>
                                    <canvas height="64" class="blog-overview-stats-small-3 chartjs-render-monitor" width="160"></canvas>
                                </div>
                            </div>
                        </div>
                                                
                        <div class="col-lg col-md-4 col-sm-6 mb-4">
                             <div class="stats-small stats-small--1 card card-small">
                                 <div class="card-body p-0 d-flex">

                                     <div class="d-flex flex-column m-auto">
                                         <div class="stats-small__data text-center">
                                             <span class="stats-small__label text-uppercase" id="sTitleC4">TOTAL ORD.COMPRAS (MONTO)</span>
                                             <h6 class="stats-small__value count my-3" id="sValorC4"> S./ 0.00</h6>
                                         </div>
                                         <!-- <div class="stats-small__data">
                                             <span class="stats-small__percentage stats-small__percentage--increase"></span>
                                         </div> -->
                                     </div>
                                     <canvas height="64" class="blog-overview-stats-small-4 chartjs-render-monitor" width="160"></canvas>
                                 </div>
                             </div>
                        </div>


                                                 
                        <div class="col-lg col-md-4 col-sm-6 mb-4">
                             <div class="stats-small stats-small--1 card card-small">
                                 <div class="card-body p-0 d-flex">

                                     <div class="d-flex flex-column m-auto">
                                         <div class="stats-small__data text-center">
                                             <span class="stats-small__label text-uppercase" id="sTitleC5">TOTAL GASTOS</span>
                                             <h6 class="stats-small__value count my-3" id="sValorC5"> S./ 0.00</h6>
                                         </div>
                                         <!-- <div class="stats-small__data">
                                             <span class="stats-small__percentage stats-small__percentage--increase"></span>
                                         </div> -->
                                     </div>
                                     <canvas height="64" class="blog-overview-stats-small-4 chartjs-render-monitor" width="160"></canvas>
                                 </div>
                             </div>
                        </div>

                        <div class="col-lg col-md-4 col-sm-12 mb-4">
                            <div class="stats-small stats-small--1 card card-small">
                                <div class="card-body p-0 d-flex">

                                    <div class="d-flex flex-column m-auto">
                                        <div class="stats-small__data text-center">
                                            <span class="stats-small__label text-uppercase" id="sTitleC6">DIFERENCIA (MONTO)</span>
                                            <h6 class="stats-small__value count my-3" id="sValorC6">0.00</h6>
                                        </div>
                                        <!-- <div class="stats-small__data">
                                            <span class="stats-small__percentage stats-small__percentage--increase"></span>
                                        </div> -->
                                    </div>
                                    <canvas height="64" class="blog-overview-stats-small-5 chartjs-render-monitor" width="160"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 col-md-6 mb-4">

                            <div class="card card-small">
                                 <div class="card-header border-bottom">
                                     <h6 class="m-0">Venta Mensual</h6>
                                 </div>
                                 <div class="card-body pt-0">
                                     <div class="chartjs-size-monitor">
                                         <div class="chartjs-size-monitor-expand">
                                             <div class=""></div>
                                         </div>
                                         <div class="chartjs-size-monitor-shrink">
                                             <div class=""></div>
                                         </div>
                                     </div>

                                     <canvas id="chartMensual" class="chartjs-render-monitor"></canvas>

                                     <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">

                                     </div>

                                 </div>
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                            <div class="card card-small">
                                <div class="card-header border-bottom">
                                    <h6 class="m-0">Categorias</h6>
                                </div>
                                <div class="card-body pt-2">

                                    <canvas height="130" style="max-width: 100% !important;" id="chartCategorias"></canvas>

                                    <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                            <div class="card card-small">
                                <div class="card-header border-bottom">
                                    <h6 class="m-0">Productos</h6>
                                </div>
                                <div class="card-body pt-2">

                                    <canvas height="130" style="max-width: 100% !important;" id="chartProductos"></canvas>

                                    <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                            <div class="card card-small">
                                <div class="card-header border-bottom">
                                    <h6 class="m-0">Clientes</h6>
                                </div>
                                <div class="card-body pt-2">

                                    <canvas height="130" style="max-width: 100% !important;" id="chartClientes"></canvas>

                                    <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>                
            </div>
        </div>
    </div>


    <!-- Fin de modales -->





    <?php extend_view(['admin/common/footer'], $data) ?>

</body>


<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- Empresas -->
<script>
    $(function() {

        fncCleanAll();
        $("#li-noti").hide();

        // Formulario Clientes
        $("#btnCrearEmpresa").on('click', function() {
            fncCleanAll();
            $("#formCEEmpresa").find(".modal-title").html('Nueva Empresa');
            $("#formCEEmpresa").data("nIdRegistro",0);
            $("#formCEEmpresa").modal("show");
        });

        // Submit del formulario de Empreesa
        $("#formCEEmpresa").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro            = $("#formCEEmpresa").data("nIdRegistro");
             var nTipoDocumento         = $("#nTipoDocumento").val();
             var sNumeroDocumento       = $("#sNumeroDocumento").val();
             var sNombre                = $("#sNombre").val();
             var sDireccion             = $("#sDireccion").val();
             var sCorreo                = $("#sCorreo").val();
             var sTelefono              = $("#sTelefono").val();
             var sImagen                = $("#sImagen")[0].files[0];
             var sImagenFondoLogin      = $("#sImagenFondoLoginEmpresa")[0].files[0];
             var nEstado                = $("#nEstado").val();
             var sDescripcion1Ctz       = $("#sDescripcion1Ctz").val();
             var sDescripcion2Ctz       = $("#sDescripcion2Ctz").val();
             var sDescripcion3Ctz       = $("#sDescripcion3Ctz").val();

             
             if (nTipoDocumento == '') {
                 toastr.error('Error. Seleccione un tipo de documento. Porfavor verifique');
                 return;
             } else if (sNumeroDocumento == '') {
                 toastr.error('Error. Ingrese un numero de documento. Porfavor verifique');
                 return;
             } else if (sNombre == '') {
                 toastr.error('Error. Ingrese un nombre o razon social. Porfavor verifique');
                 return;
             } else if (sDireccion == '') {
                 toastr.error('Error. Ingrese una direccion. Porfavor verifique');
                 return;
             } else if (sCorreo == '') {
                 toastr.error('Error. Ingrese un correo. Porfavor verifique');
                 return;
             } else if (sTelefono == '') {
                 toastr.error('Error. Ingrese un telefono. Porfavor verifique');
                 return;
             }  


             var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nTipoDocumento', nTipoDocumento);
            formData.append('sNumeroDocumento', sNumeroDocumento);
            formData.append('sNombre', sNombre);
            formData.append('sDireccion', sDireccion);
            formData.append('sCorreo', sCorreo);
            formData.append('sTelefono', sTelefono);
            formData.append('sImagen', sImagen);
            formData.append('sImagenFondoLogin', sImagenFondoLogin);
            formData.append('nEstado', nEstado);

            formData.append('sDescripcion1Ctz', sDescripcion1Ctz);
            formData.append('sDescripcion2Ctz', sDescripcion2Ctz);
            formData.append('sDescripcion3Ctz', sDescripcion3Ctz);

            fncGrabarEmpresa(formData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCEEmpresa").modal("hide");
                     $("#tblEmpresas").bootstrapTable('refresh');
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
             });

        });

        $("#sNumeroDocumento").on('keyup change',function(){
                    
            switch( $("#nTipoDocumento").find("option:selected").text() ){
                        
                case 'RUC':

                            if( $("#sNumeroDocumento").val().length  == 11 ){
                                 
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "ruc",
                                    sNumeroDoc   : $("#sNumeroDocumento").val()
                                };

                                fncBuscarDocument( jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombre").val(aryData.success.razonSocial);
                                    }
                                });

                            }

                break;
                
                case 'DNI':
                            if( $("#sNumeroDocumento").val().length  == 7 || $("#sNumeroDocumento").val().length  == 8 ){
                                
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "dni",
                                    sNumeroDoc   : $("#sNumeroDocumento").val()
                                };

                                fncBuscarDocument(jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombre").val(aryData.success.razonSocial);
                                        
                                    }
                                });

                            }
                break;

            }
                  
                    
        });

        $("#nTipoDocumento").change(function() {
             if( $(this).val() > 0 ) {
                 fncMaxLengthTypeDocument( $(this).find('option:selected').text().trim().toUpperCase() , "#sNumeroDocumento" );
             }
        });




    });

    // Funciones de la tabla o layout Principal

    function fncMostrarMantenimientoSedes(nIdEmpresa){

        var jsnData = {
            nIdEmpresa : nIdEmpresa
        };

        fncPopulateSedes(jsnData,(aryData)=>{

            $("#tblSedes").bootstrapTable("load",aryData);
            $("#formSedes").data("nIdEmpresa",nIdEmpresa);
            $("#formSedes").modal("show");

        });
    }

    function fncEliminarEmpresa(nIdRegistro) {
        if(confirm('Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?')){
            
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarEmpresas( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblEmpresas").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 
        }
    }

    function fncMostrarEmpresa(nIdRegistro , sOpcion ) {

        $( "#formCEEmpresa" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroEmpresa(jsnData, function(aryResponse){
            
                if (aryResponse.success) {


                    var aryData = aryResponse.aryData;

                    $("#nTipoDocumento").val(aryData.nTipoDocumento);
                    $("#sNumeroDocumento").val(aryData.sNumeroDocumento);
                    $("#sNombre").val(aryData.sNombre);
                    $("#sDireccion").val(aryData.sDireccion);
                    $("#sCorreo").val(aryData.sCorreo);
                    $("#sTelefono").val(aryData.sTelefono);
                    $("#nEstado").val(aryData.nEstado);

                    if(aryData.sImagen.length > 0) {
                        $("label[for='sImagen']").eq(0).find("img").show();
                        $("label[for='sImagen']").eq(0).find("img").attr("src",  src('multi/' + aryData.sImagen ) );
                        $("label[for='sImagen']").eq(1).html(aryData.sImagenLogoGeneral);
                    }

                    if(aryData.sImagenFondoLogin.length > 0) {
                        $("label[for='sImagenFondoLoginEmpresa']").eq(0).find("img").show();
                        $("label[for='sImagenFondoLoginEmpresa']").eq(0).find("img").attr("src",  src('multi/' + aryData.sImagenFondoLogin ) );
                        $("label[for='sImagenFondoLoginEmpresa']").eq(1).html(aryData.sImagenFondoLogin);
                    }


                    $("#sDescripcion1Ctz").val(aryData.sDescripcion1Ctz);
                    $("#sDescripcion2Ctz").val(aryData.sDescripcion2Ctz);
                    $("#sDescripcion3Ctz").val(aryData.sDescripcion3Ctz);


                    if(sOpcion == 'editar'){
                        fncEditForm("#formCEEmpresa" , "Editar Empresa");
                    } else {
                        fncViewForm("#formCEEmpresa" , "Ver Empresa");
                    }

                    $("#formCEEmpresa").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    function fncMostrarReportSedes(nIdRegistro, sNombreEmpresa){

        var jsnData = {
            nIdEmpresa : nIdRegistro
        };

        fncCleanControls();
        
        fncDrawSedes(jsnData , "#aryIdSede");
        $("#formDashboard").find(".modal-title").html( " DASHBOARD - " + sNombreEmpresa);
        $("#formDashboard").data("nIdEmpresa", nIdRegistro);
        $("#formDashboard").modal("show");
    }

    // Funciones Auxiliares
    function fncCleanAll(){
        $(".img-referencial").hide();
        fncRemoveDisabled( $("#formCESede").find("form") );
        fncClearInputs( $("#formCESede").find("form") );
        fncRemoveDisabled( $("#formCEEmpresa").find("form") );
        fncClearInputs( $("#formCEEmpresa").find("form") );
    }

    function fncDrawSedes(jsnData,sHtmlTag){
        
        // if( typeof $(sHtmlTag).select2('destroy') != "undefined" ){
        //     $(sHtmlTag).select2('destroy'); 
        // }

        fncGetSedes(jsnData,(aryData)=>{

                if(aryData.success){

                    var aryData = aryData.aryData;
                    
                    if(aryData.length>0){

                        var sHtml = ``;

                        aryData.forEach(aryElement => {
                            sHtml += `<option ${ aryData.length == 1 ? `selected="selected"` : `` } value="${aryElement.nIdSede}">${aryElement.sNombre}</option>`;
                        });

                        $(sHtmlTag).html(sHtml);

                    }

                    if(aryData.length == 1){
                        $(sHtmlTag).trigger("change");
                    }

                    $(sHtmlTag).select2({
                        placeholder : "TODOS"
                    }); 

                } else {

                    toastr.error(aryData.error);

                }
        });

    }

    function fncCopyLinkEmpresa(nIdEmpresa , sURL){

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(sURL);
        toastr.success("Se copio el link de forma correcta");
    }

 
    // Llamadas al servidor


    // Empresas 

    function fncGrabarEmpresa(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'empresas/fncGrabarEmpresa',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }

    function fncBuscarRegistroEmpresa(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'empresas/fncMostrarRegistro',
            data: jsnData ,
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }
        });
    }

    function fncEjecutarEliminarEmpresas( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'empresas/fncEliminarRegistro',
            data: jsnData,
            dataType: 'json',
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function( data ) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }

        });
    }

    function fncPopulateSedes( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'sedes/fncPopulate',
            data: jsnData,
            dataType: 'json',
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function( data ) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }

        });
    }

    function fncBuscarDocument(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'api/'+ jsnData.sTipo +'/' + jsnData.sNumeroDoc ,
            beforeSend: function () {
              //  fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
             // fncOcultarLoader();
            }
        });
    }

    function fncGetSedes(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'sedes/fncGetSedes',
            data: formData,
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }


</script>
<!-- Empresas -->


<!-- Sedes  -->
<script>
    $(function() {

        // Formulario Clientes
        $("#btnCrearSede").on('click', function() {
            fncCleanAll();
            $("#formCESede").find(".modal-title").html('Nueva Sede');
            $("#formCESede").data("nIdRegistro",0);
            $("#formCESede").modal("show");
        });

        // Submit del formulario de Empreesa
        $("#formCESede").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro    = $("#formCESede").data("nIdRegistro");
             var nIdEmpresa     = $("#formSedes").data("nIdEmpresa");
 
             var sNombre        = $("#sNombreSede").val();
             var sDireccion     = $("#sDireccionSede").val();
             var sTelefono      = $("#sTelefonoSede").val();
             var sEncargado     = $("#sEncargadoSede").val();

             var nTipoMoneda    = $("#nTipoMonedaSede").val();
             var nTipoTicket    = $("#nTipoTicketSede").val();

             var sImagen        = $("#sImagenSede")[0].files[0];
             var sDescripcion   = $("#sDescripcionSede").val();

             var nEstado        = $("#nEstadoSede").val();

             if (typeof nIdEmpresa === 'undefined') {
                 toastr.error('Error. No se encontro el codigo de empresa . Porfavor verifique o solicite asistencia');
                 return;
             } else if (sNombre == '') {
                 toastr.error('Error. Ingrese un nombre o razon social. Porfavor verifique');
                 return;
             } else if (sDireccion == '') {
                 toastr.error('Error. Ingrese una direccion. Porfavor verifique');
                 return;
             } else if (sTelefono == '') {
                 toastr.error('Error. Ingrese un telefono. Porfavor verifique');
                 return;
             } else if (sEncargado == '') {
                 toastr.error('Error. Ingrese un encargado. Porfavor verifique');
                 return;
             } else if (nTipoMoneda == '0') {
                 toastr.error('Error. Seleccione un tipo de moneda. Porfavor verifique');
                 return;
             } else if (nTipoTicket == '0') {
                 toastr.error('Error. Seleccione un tipo de ticket. Porfavor verifique');
                 return;
             } 
 

             var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdEmpresa', nIdEmpresa);
            formData.append('sNombre', sNombre);
            formData.append('sDireccion', sDireccion);
            formData.append('sEncargado', sEncargado);
            formData.append('nTipoMoneda', nTipoMoneda);
            formData.append('nTipoTicket', nTipoTicket);
            formData.append('sTelefono', sTelefono);
            formData.append('sImagen', sImagen);
            formData.append('sDescripcion', sDescripcion);
            formData.append('nEstado', nEstado);

            fncGrabarSede(formData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     fncMostrarMantenimientoSedes(nIdEmpresa);
                     $("#formCESede").modal("hide");
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
             });

        });
 




    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarSede(nIdRegistro) {
        if(confirm('Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?')){
            
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarSede( jsnData , function(aryData){

                if(aryData.success){
                    fncMostrarMantenimientoSedes($("#formSedes").data("nIdEmpresa"));
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 
        }
    }

    function fncMostrarSede(nIdRegistro , sOpcion ) {

        $( "#formCESede" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroSede(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

               
                    $("#sNombreSede").val(aryData.sNombre);
                    $("#sDireccionSede").val(aryData.sDireccion);
                    $("#sEncargadoSede").val(aryData.sEncargado);
                    $("#sTelefonoSede").val(aryData.sTelefono);
                    $("#nTipoMonedaSede").val(aryData.nTipoMoneda);
                    $("#nTipoTicketSede").val(aryData.nTipoTicket);
                    $("#nEstadoSede").val(aryData.nEstado);
                    $("#sDescripcionSede").val(aryData.sDescripcion);

                    if(aryData.sImagen.length > 0) $("label[for='sImagenSede']").html(aryData.sImagen);
                    
                    if(sOpcion == 'editar'){
                        fncEditForm("#formCESede" , "Editar Sede");
                    } else {
                        fncViewForm("#formCESede" , "Ver Sede");
                    }

                    $("#formCESede").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Llamadas al servidor


    // Empresas 

    function fncGrabarSede(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'sedes/fncGrabarSede',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }

    function fncBuscarRegistroSede(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'sedes/fncMostrarRegistro',
            data: jsnData ,
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }
        });
    }

    function fncEjecutarEliminarSede( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'sedes/fncEliminarRegistro',
            data: jsnData,
            dataType: 'json',
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function( data ) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }

        });
    }

 

</script>
<!-- Sedes -->




<!-- Dashboard --> 
<script>

    window.jsnData = null ;
    window.nMinIdColor = 0;
    window.nMaxIdColor = 14;
    window.aryColors = ["#B5E9F2", "#6ADFB5", "#FEE29F", "#FFA1B5", "#96C8FD" , "#c7f2b5" , "#e7b5f2","#f2b5e2" ,"#f2d3b5","#b5f2bb" ,"#bdb5f2" ,"#f2b5ba" ,"#ff5765" ,"#ffe845" ,"#4572ff" , "#ff4594"];
    
    var chart1,chart2,chart3,chart4;

    $(document).ready(function(){
        fncCleanControls();
 

        $("#formFilterDashboard").on('submit', function(event) {

            event.preventDefault();

            var aryIdSede      = $("#aryIdSede :selected").map(function(nIndex, item) {return $(item).val();}).get();
            var nIdEmpresa     = $("#formDashboard").data("nIdEmpresa");
            var dFechaInicio   = $('#dRangoFechas').val() == '' ? null : $('#dRangoFechas').data('daterangepicker').startDate.format('DD/MM/YYYY');
            var dFechaFin      = $('#dRangoFechas').val() == '' ? null : $('#dRangoFechas').data('daterangepicker').endDate.format('DD/MM/YYYY');

            window.jsnData  = {          
                nIdEmpresa      : nIdEmpresa,
                aryIdSede       : aryIdSede,
                dFechaInicio    : dFechaInicio,
                dFechaFin       : dFechaFin,
            };

            fncPopulateDashboard(window.jsnData , function(aryData) {

                if(aryData.success){

                    fncCleanControls();

                    toastr.success(aryData.success);

                    var aryData          = aryData.aryData;

                    var aryDataMeses     = aryData.aryDataMeses;
                    var aryDataCategoria = aryData.aryDataCategoria;
                    var aryDataProducto  = aryData.aryDataProducto;
                    var aryDataCliente   = aryData.aryDataCliente;

                    $("#sValorC1").html(aryData.nTotalNuevosClientes);
                    $("#sValorC2").html(aryData.nCantidadPedidos);
                    $("#sValorC3").html(aryData.nTotalPedidos);
                    $("#sValorC4").html(aryData.nTotalOrdenCompra);
                    $("#sValorC5").html(aryData.nTotalGastos);
                    $("#sValorC6").html(aryData.nDiferencia);

                    $("#sValorSubC1").html(" TOTAL CLIENTES : " + aryData.nTotalClientes);

                    // Venta Mensual 

                    var aryLabel      = [];
                    var aryValores    = [];
                    var aryBackground = [];

                    if(aryDataMeses.length > 0){

                        aryDataMeses.forEach(function (aryItem) {
                            aryLabel.push(fncGetNameMesById(aryItem.sNumeroMes) + ' ' + aryItem.sAnio);
                            aryValores.push(pf(aryItem.nTotal));
                            aryBackground.push(fncGetColor());
                        });

                    }

                    var jsnData = {
                        label       : aryLabel,
                        valores     : aryValores,
                        background  : aryBackground,
                    };

                    fncDrawChart1("chartMensual", "bar", jsnData, "Venta Menual");
                        
                    // Fin de venta Mensual 

                    // Categorias 
                    
                    aryLabel      = [];
                    aryValores    = [];
                    aryBackground = [];

                    if(aryDataCategoria.length > 0){

                        aryDataCategoria.forEach(function (aryItem) {
                            aryLabel.push(aryItem.sCategoria);
                            aryValores.push(pf(aryItem.nTotal));
                            aryBackground.push(fncGetColor());
                        });

                    }

                    var jsnData = {
                        label       : aryLabel,
                        valores     : aryValores,
                        background  : aryBackground,
                    };

                    fncDrawChart2( "chartCategorias", "horizontalBar", jsnData , "Categorias" );

                    // Fin de categorias

                    // Productos 
                       
                    aryLabel      = [];
                    aryValores    = [];
                    aryBackground = [];

                    if(aryDataProducto.length > 0){

                        aryDataProducto.forEach(function (aryItem) {
                            aryLabel.push(aryItem.sProducto);
                            aryValores.push(pf(aryItem.nTotal));
                            aryBackground.push(fncGetColor());
                        });

                    }

                    var jsnData = {
                        label       : aryLabel,
                        valores     : aryValores,
                        background  : aryBackground,
                    };

                    fncDrawChart3( "chartProductos", "horizontalBar", jsnData , " Productos " );

                    // Fin de productos 


                    // Clientes 
                       
                    aryLabel      = [];
                    aryValores    = [];
                    aryBackground = [];

                    if(aryDataCliente.length > 0){

                        aryDataCliente.forEach(function (aryItem) {
                            aryLabel.push(aryItem.sCliente);
                            aryValores.push(pf(aryItem.nTotal));
                            aryBackground.push(fncGetColor());
                        });

                    }

                    var jsnData = {
                        label       : aryLabel,
                        valores     : aryValores,
                        background  : aryBackground,
                    };

                    fncDrawChart4( "chartClientes", "pie", jsnData , "Clientes" );

                    // Fin de Clientes 
 
 

                } else {
                    toastr.error(aryData.error);
                }
            });

        });



    });



    // Funciones Auxiliares

 


    function fncCleanControls() {
    
        $("#sValorC1").html("0.00");
        $("#sValorC2").html("0.00");
        $("#sValorC3").html("0.00");
        $("#sValorC4").html("0.00");
        
        if (chart1 != undefined) chart1.destroy();
        if (chart2 != undefined) chart2.destroy();
        if (chart3 != undefined) chart3.destroy();
        if (chart4 != undefined) chart4.destroy();
    
    }


    // Dibujar los graficos ...
    function fncDrawChart1(id, type, info, titleGrafic) {
        var config = {
            // The type of chart we want to create
            type: type,
            // The data for our dataset
            data: {
            labels: info.label,
            datasets: [
                {
                label: titleGrafic,
                backgroundColor: info.background,
                borderColor: info.background,
                data: info.valores,
                fill: false,
                },
            ],
            },
            options: {
            legend: {
                display: true,
            },
            },
        };

        var ctx = document.getElementById(id).getContext("2d");

        if (chart1 != undefined) chart1.destroy();

        chart1 = new Chart(ctx, config);
    }

    function fncDrawChart2(id, type, info, titleGrafic) {
        var config = {
            // The type of chart we want to create
            type: type,
            // The data for our dataset
            data: {
            labels: info.label,
            datasets: [
                {
                label: titleGrafic,
                backgroundColor: info.background,
                borderColor: info.background,
                data: info.valores,
                fill: false,
                },
            ],
            },
            options: {
            legend: {
                display: true,
            },
            },
        };

        var ctx = document.getElementById(id).getContext("2d");

        if (chart2 != undefined) chart2.destroy();

        chart2 = new Chart(ctx, config);
    }

    function fncDrawChart3(id, type, info, titleGrafic) {
        var config = {
            // The type of chart we want to create
            type: type,
            // The data for our dataset
            data: {
            labels: info.label,
            datasets: [
                {
                label: titleGrafic,
                backgroundColor: info.background,
                borderColor: info.background,
                data: info.valores,
                fill: false,
                },
            ],
            },
            options: {
            legend: {
                display: true,
            },
            },
        };

        var ctx = document.getElementById(id).getContext("2d");

        if (chart3 != undefined) chart3.destroy();

        chart3 = new Chart(ctx, config);
    }

    function fncDrawChart4(id, type, info, titleGrafic) {
        var config = {
            // The type of chart we want to create
            type: type,
            // The data for our dataset
            data: {
            labels: info.label,
            datasets: [
                {
                label: titleGrafic,
                backgroundColor: info.background,
                borderColor: info.background,
                data: info.valores,
                fill: false,
                },
            ],
            },
            options: {
            legend: {
                display: true,
            },
            },
        };

        var ctx = document.getElementById(id).getContext("2d");

        if (chart4 != undefined) chart4.destroy();

        chart4 = new Chart(ctx, config);
    }

    function fncGetRandomInt(min, max) {
         return Math.floor(Math.random() * (max - min)) + min;
    }

    function fncGetColor(){ 


        
        return "hsl(" + 360 * Math.random() + ',' +
                    (25 + 70 * Math.random()) + '%,' + 
                    (85 + 10 * Math.random()) + '%)';

      
    }


    // Llamadas al servidor 
    
    function fncPopulateDashboard(formData, fncCallback) {
        $.ajax({
                type: 'post',
                dataType: 'json',
                url: web_root + 'dashboard/fncPopulateDashboard',
                data: formData,
                beforeSend: function() {
                    fncMostrarLoader();
                },
                success: function(data) {
                    fncCallback(data);
                },
                complete: function() {
                    fncOcultarLoader();
                }
        });
    }



</script>
<!-- Dashboard --> 




</html>