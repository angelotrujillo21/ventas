<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>
</head>

<body data-nadmin="<?= $nAdmin ?>">

    <div class="page-loader">
        <div class="loader-dual-ring"></div>
    </div>

    <div class="container-fluid">

        <div class="row">

            <?php extend_view(['admin/common/aside'], $data) ?>

            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">

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
                                                        <button id="btnCrearRegistro" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div id="toolbar" class="btn-group row">
                                            <div class="col-md-6 sin-padding container-buttons-table">
                                                <button id="btnFiltros" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <button id="btnRefresh" class="btn btn-gradient-primary-table mr-1" type="button" title="Actualizar">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                                <button id="btnLimpiarFiltros" class="btn btn-gradient-primary-table mr-2" type="button" title="Limpiar filtros">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table id="tblPrincipal" data-url="<?= route("guias/fncPopulate") ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNumero" data-sortable="true">Numero</th>
                                                            <th data-field="dFechaguias" data-sortable="true">F.Guia</th>
                                                            <th data-field="sCliente" data-sortable="true">Cliente</th>
                                                            <th data-field="sChofer" data-sortable="true">Chofer</th>
                                                            <th data-field="sVehiculo" data-sortable="true">Vehiculo</th>

                                                    
                                                            
                                                            <th data-field="dFechaCreacion" data-sortable="true">F.Creacion</th>
                                                            <th data-field="dFechaEdicion" data-sortable="true">F.Edicion</th>
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

                <?php extend_view(['admin/common/descripcion-empresa'], $data) ?>
            </main>
        </div>
    </div>

    <!-- Modales -->
    <div class="modal fade" id="formCERegistro" tabindex="-1" role="dialog" aria-labelledby="formCERegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCELoteLabel">Nuevo Registro</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body modal-body-scroll">

                        <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="datos-tab" data-toggle="tab" href="#datos" role="tab" aria-controls="datos" aria-selected="true">Datos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="direcciones-tab" data-toggle="tab" href="#direcciones" role="tab" aria-controls="direcciones" aria-selected="false">Direcciones</a>
                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">

                                <div class="row my-1">
                                    <div class="col-md-12">
                                        <div class="row">


                                            <div class="col-12 col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <fieldset>
                                                            <legend>Guia</legend>
                                                            <div class="form-group">
                                                                <label for="dFechaGuia" class="col-form-label">Fecha Guia <span class="text-danger">*</span></label>
                                                                <input type="date" autocomplete="off" placeholder="" class="form-control" name="dFechaGuia" id="dFechaGuia">
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">
                                                        <fieldset>
                                                            <legend>Pedido</legend>

                                                            <div class="form-group mb-1">
                                                                <select class="form-control" name="nIdPedido" id="nIdPedido">
                                                                    <option value="0">SELECCIONAR</option>
                                                                    <?php foreach ($aryPedidos as $aryLoop) : ?>
                                                                        <option value="<?= $aryLoop["nIdPedido"] ?>"><?= $aryLoop["sNumero"] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group mb-0">
                                                                <label for="nTipoDespacho1" class="col-form-label">Despacho total</label>
                                                                <input type="radio" name="nTipoDespacho" id="nTipoDespacho1" value="1">
                                                            </div>

                                                            <div class="form-group mb-0">
                                                                <label for="nTipoDespacho2" class="col-form-label">Despacho parcial</label>
                                                                <input type="radio" name="nTipoDespacho" id="nTipoDespacho2" value="2">
                                                            </div>
                                                        </fieldset>

                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <fieldset>
                                                        <legend>Cliente</legend>
                                                        <div class="input-group mb-1">
                                                            <input type="text" class="form-control" placeholder="Cliente" id="sCliente" name="sCliente" readonly style="background-color: #fff !important;">
                                                            <div class="input-group-append">
                                                                <button type="button" id="btnBuscarCliente" class="btn-prepend">Buscar</button>
                                                            </div>
                                                        </div>

                                                        <div class="form-inline w-100">
                                                            <div class="form-group mb-1 w-100">
                                                                <label for="sNumeroDocumentoCliente" class="col-form-label mx-2">RUC</label>
                                                                <input type="text" name="sNumeroDocumentoCliente" id="sNumeroDocumentoCliente" class="form-control" value="" style="width: 87%;" readonly>
                                                            </div>
                                                            <div class="form-group mb-0 w-100">
                                                                <label for="sDireccionCliente" class="col-form-label mx-2">Direccion</label>
                                                                <input type="text" name="sDireccionCliente" id="sDireccionCliente" class="form-control" value="" style="width: 78%;" readonly>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <fieldset>
                                                        <legend>Entrega</legend>

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="nIdChofer" class="col-form-label">Chofer <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="nIdChofer" id="nIdChofer">
                                                                        <option value="0">SELECCIONAR</option>
                                                                        <?php foreach ($aryChoferes as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["nIdChofer"] ?>" data-idvehiculo="<?= $aryLoop["nIdVehiculo"] ?>"><?= $aryLoop["sNombreCompleto"] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="nIdVehiculo" class="col-form-label">Vehiculo <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="nIdVehiculo" id="nIdVehiculo">
                                                                        <option value="0">SELECCIONAR</option>
                                                                        <?php foreach ($aryVehiculos as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["nIdVehiculo"] ?>"><?= $aryLoop["sPlaca"] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <fieldset>
                                                        <legend>Tipo Movimiento</legend>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-inline" style="gap: 10px;">

                                                                    <div class="form-group mb-0">
                                                                        <input type="radio" name="nIdTipoMovimiento" id="nIdTipoMovimient1" value="1">
                                                                        <label for="nIdTipoMovimient1" class="col-form-label mx-2">Venta</label>
                                                                    </div>

                                                                    <div class="form-group mb-0">
                                                                        <input type="radio" name="nIdTipoMovimiento" id="nIdTipoMovimiento2" value="2">
                                                                        <label for="nIdTipoMovimiento2" class="col-form-label mx-2">Muestra</label>
                                                                    </div>

                                                                    <div class="form-group mb-0">
                                                                        <input type="radio" name="nIdTipoMovimiento" id="nIdTipoMovimiento3" value="3">
                                                                        <label for="nIdTipoMovimiento3" class="col-form-label mx-2">Bonificacion</label>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-12">

                                                                <div class="form-group">
                                                                    <label for="nIdAlmacen" class="col-form-label">Almacen <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="nIdAlmacen" id="nIdAlmacen">
                                                                        <option value="0">SELECCIONAR</option>
                                                                    </select>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>






                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <div class="row my-2">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center p-2">
                                                    <div class="flex-center">
                                                        <h5>Listado Productos</h5>
                                                    </div>

                                                    <div class="ml-auto">
                                                        <button id="btnCrearItem" type="button" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table id="tblDetalle" data-toggle="table" data-unique-id="nIdRow" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="false" data-buttons-align="left" data-show-columns="true" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-sort-name="nIdRow" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="nIdRow" data-visible="false">nIdRow</th>
                                                            <th data-field="sProducto" data-sortable="false">Producto</th>
                                                            <th data-field="nTotalPedido" data-sortable="false">Total pedido</th>
                                                            <th data-field="nDespachado" data-sortable="false">Despachado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sObservacion" class="col-form-label">Observacion</label>
                                            <textarea class="form-control" name="sObservacion" id="sObservacion" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>


                                </div>




                            </div>
                            <div class="tab-pane fade" id="direcciones" role="tabpanel" aria-labelledby="direcciones-tab">


                                <div class="row my-1">
                                    <div class="col-12 col-md-6">

                                        <div class="row">
                                            <div class="col-12">

                                                <fieldset>
                                                    <legend>
                                                        <span>Direccion Partida</span>
                                                        <div class="d-inline-block" style="margin-left: 94px;">
                                                            <input type="checkbox" name="nDFiscal" id="nDFiscal" class="d-inline-block">
                                                            <label class="d-inline-block" for="nDFiscal" style="font-weight: 300 !important;">Direccion Fiscal</label>
                                                        </div>
                                                    </legend>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group mb-1">
                                                                <label for="sTipoViaRmt" class="col-form-label">Tipo Via <span class="text-danger">*</span></label>
                                                                <input type="text" name="sTipoViaRmt" id="sTipoViaRmt" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sNroRmt" class="col-form-label">Nro <span class="text-danger">*</span></label>
                                                                <input type="text" name="sNroRmt" id="sNroRmt" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sZonaRmt" class="col-form-label">Zona <span class="text-danger">*</span></label>
                                                                <input type="text" name="sZonaRmt" id="sZonaRmt" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sProvinciaRmt" class="col-form-label">Prov. <span class="text-danger">*</span></label>
                                                                <input type="text" name="sProvinciaRmt" id="sProvinciaRmt" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group mb-1">
                                                                <label for="sViaNombreRmt" class="col-form-label">Via Nombre <span class="text-danger">*</span></label>
                                                                <input type="text" name="sViaNombreRmt" id="sViaNombreRmt" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sInteriorRmt" class="col-form-label">Interior <span class="text-danger">*</span></label>
                                                                <input type="text" name="sInteriorRmt" id="sInteriorRmt" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sDistritoRmt" class="col-form-label">Distrito <span class="text-danger">*</span></label>
                                                                <input type="text" name="sDistritoRmt" id="sDistritoRmt" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sDptRmt" class="col-form-label">Dpt. <span class="text-danger">*</span></label>
                                                                <input type="text" name="sDptRmt" id="sDptRmt" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                            </div>
                                            <div class="col-12">
                                                <fieldset>
                                                    <legend>Remitente</legend>
                                                    <div class="form-group mb-1">
                                                        <label for="sRemitente" class="col-form-label"> Remitente <span class="text-danger">*</span></label>
                                                        <input type="text" name="sRemitente" id="sRemitente" class="form-control">
                                                    </div>
                                                    <div class="form-group mb-1">
                                                        <label for="sNumeroDocRmt" class="col-form-label">Documento <span class="text-danger">*</span></label>
                                                        <input type="text" name="sNumeroDocRmt" id="sNumeroDocRmt" class="form-control">
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="row">
                                            <div class="col-12">

                                                <fieldset>
                                                    <legend>Direccion LLegada</legend>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group mb-1">
                                                                <label for="sTipoViaDest" class="col-form-label">Tipo Via <span class="text-danger">*</span></label>
                                                                <input type="text" name="sTipoViaDest" id="sTipoViaDest" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sNroDest" class="col-form-label">Nro <span class="text-danger">*</span></label>
                                                                <input type="text" name="sNroDest" id="sNroDest" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sZonaDest" class="col-form-label">Zona <span class="text-danger">*</span></label>
                                                                <input type="text" name="sZonaDest" id="sZonaDest" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sProvinciaDest" class="col-form-label">Prov. <span class="text-danger">*</span></label>
                                                                <input type="text" name="sProvinciaDest" id="sProvinciaDest" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group mb-1">
                                                                <label for="sViaNombreDest" class="col-form-label">Via Nombre <span class="text-danger">*</span></label>
                                                                <input type="text" name="sViaNombreDest" id="sViaNombreDest" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sInteriorDest" class="col-form-label">Interior <span class="text-danger">*</span></label>
                                                                <input type="text" name="sInteriorDest" id="sInteriorDest" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sDistritoDest" class="col-form-label">Distrito <span class="text-danger">*</span></label>
                                                                <input type="text" name="sDistritoDest" id="sDistritoDest" class="form-control">
                                                            </div>
                                                            <div class="form-group mb-1">
                                                                <label for="sDptDest" class="col-form-label">Dpt. <span class="text-danger">*</span></label>
                                                                <input type="text" name="sDptDest" id="sDptDest" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                            </div>
                                            <div class="col-12">
                                                <fieldset>
                                                    <legend>Destinatario</legend>
                                                    <div class="form-group mb-1">
                                                        <label for="sDestinatario" class="col-form-label"> Destinatario <span class="text-danger">*</span></label>
                                                        <input type="text" name="sDestinatario" id="sDestinatario" class="form-control">
                                                    </div>
                                                    <div class="form-group mb-1">
                                                        <label for="sNumeroDocDest" class="col-form-label">Documento <span class="text-danger">*</span></label>
                                                        <input type="text" name="sNumeroDocDest" id="sNumeroDocDest" class="form-control">
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                    </div>
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

    <div class="modal fade" id="formCEDetalle" tabindex="-1" role="dialog" aria-labelledby="formCEDetalleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEDetalleLabel">Nuevo Producto</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdProductoD" class="col-form-label">Producto</label>
                                    <select class="form-control" name="nIdProductoD" id="nIdProductoD">
                                        <?php foreach ($aryProductos as $aryLoop) : ?>
                                            <option data-idum="<?= $aryLoop["nIdUnidadMedida"] ?>" data-precio="<?= $aryLoop["nPrecio"] ?>" value="<?= $aryLoop["nIdProducto"] ?>"><?= $aryLoop["sDescripcionText"] . " - " . $aryLoop["sUnidadMedidaCorto"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTotalPedidoD" class="col-form-label">Total Pedido</label>
                                    <input type="number" autocomplete="off" placeholder="" class="form-control" name="nTotalPedidoD" id="nTotalPedidoD" readonly>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nCantidadD" class="col-form-label">Despachado</label>
                                    <input type="number" autocomplete="off" placeholder="" class="form-control" name="nCantidadD" id="nCantidadD">
                                </div>
                            </div>

                        
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sObservacionD" class="col-form-label">Comentario</label>
                                    <textarea placeholder="" class="form-control" name="sObservacionD" id="sObservacionD"></textarea>
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

    <div class="modal fade" id="formFilter" tabindex="-1" role="dialog" aria-labelledby="formFilterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formFilterLabel">Filtros</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sIdsCliente" class="col-form-label">Cliente</label>
                                    <select class="form-control" name="sIdsCliente" id="sIdsCliente" multiple>
                                        <?php foreach ($aryClientes as $aryLoop) : ?>
                                            <option value="<?= $aryLoop["nIdCliente"] ?>"><?= $aryLoop["sNombreoRazonSocial"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="dFechaInicio" class="col-form-label">Desde:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaInicio" autocomplete="off" name="dFechaInicio">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="dFechaFin" class="col-form-label">Hasta:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaFin" autocomplete="off" name="dFechaFin">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formCEBuscarCliente" tabindex="-1" role="dialog" aria-labelledby="formCEBuscarCliente" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCEBuscarCliente">Buscar cliente</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modal-body-scroll">

                    <div class="row">
                        <!-- <div class="col-12">
                            <input type="text" class="form-control" placeholder="Buscar" name="customSearch" id="customSearch">
                        </div> -->

                        <div class="col-md-12">
                            <div id="toolBarBuscadorClientes"></div>
                            <table id="tblBuscarClientes" data-toggle="table" data-search="true" data-search-selector="#customSearch" data-click-to-select="true" data-url="<?= route("clientes/fncPopulate?nEstado=1") ?>" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolBarBuscadorClientes" data-buttons-align="left" data-show-columns="false" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="7" data-sort-name="" data-sort-order="asc">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-radio="true"></th>
                                        <th data-field="nTipoDocumento" data-sortable="true">Tipo Documento</th>
                                        <th data-field="sNumeroDocumento" data-sortable="true">Numero de documento</th>
                                        <th data-field="sNombreoRazonSocial" data-sortable="true">Nombre o Razon Social</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnSeleccionarCliente" type="button" class="btn btn-gradient-primary btn-fw btn-submit">Seleccionar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fin de modales -->
    <?php extend_view(['admin/common/footer'], $data) ?>
</body>


<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- Guia -->
<script>
    window.jsnDataFiltros = null;
    $(function() {

        $("#btnCrearRegistro").on('click', function() {
            fncCleanAll();
            fncOcultarAside();
            $("#formCERegistro").find(".modal-title").html('Nueva Guia');
            $("#formCERegistro").data("nIdRegistro", 0);
            $("#tblDetalle").data("nIdRow", 0);
            $("#tblDetalle").bootstrapTable("load", []);
            $("#dFechaGuia").val('<?= date("Y-m-d") ?>');
            $("#formCERegistro").modal("show");
        });

        // Submit del formulario de banco
        $("#formCERegistro").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro = $("#formCERegistro").data("nIdRegistro");
            var nIdCliente = $("#sCliente").data("nIdCliente");
            var dFechaguias = $("#dFechaguias").val();
            var nFlagIGV = $("#nFlagIGV").prop("checked") == true ? 1 : 0; // SIN IGV
            var nguias = $("#nguias").prop("checked") == true ? 1 : 0; // SIN IGV
            var nIdFormaPago = $("#nIdFormaPago").val();
            var sObservacion = $("#sObservacion").val().trim();
            var nEstado = $("#nEstado").val();
            var nIdCondicionComercial = $("#nIdCondicionComercial").val();
            var nBaseImponible = $("#nBaseImponible").val();
            var nDescuento = $("#nDescuento").val();
            var nNeto = $("#nNeto").val();
            var nImpuesto = $("#nImpuesto").val();
            var nTotal = $("#nTotal").val();
            var aryDetalle = $("#tblDetalle").bootstrapTable("getData");
            var nIdMoneda = $("#nIdMoneda").val();

            if (nIdCliente == "0") {
                toastr.error('Error. Debe de seleccionar una cliente .Porfavor verifique');
                return false;
            }

            if (dFechaguias == '') {
                toastr.error('Error. Debe ingresar la fecha de la guias .Porfavor verifique');
                return false;
            }

            if (nIdFormaPago == '0') {
                toastr.error('Error. Debe ingresar seleccionar una forma de pago .Porfavor verifique');
                return false;
            }


            if (nIdCondicionComercial == '0') {
                toastr.error('Error. Debe seleccionar la condicion comercial .Porfavor verifique');
                return false;
            }


            if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar al menos un producto o item. Porfavor verifique');
                return false;
            }

            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdCliente', nIdCliente);
            formData.append('dFechaguias', dFechaguias);
            formData.append('nFlagIGV', nFlagIGV);
            formData.append('nguias', nguias);
            formData.append('nIdFormaPago', nIdFormaPago);
            formData.append('sObservacion', sObservacion);
            formData.append('nEstado', nEstado);
            formData.append('nIdCondicionComercial', nIdCondicionComercial);
            formData.append('nBaseImponible', nBaseImponible);
            formData.append('nDescuento', nDescuento);
            formData.append('nNeto', nNeto);
            formData.append('nImpuesto', nImpuesto);
            formData.append('nTotal', nTotal);
            formData.append('aryDetalle', JSON.stringify(aryDetalle));
            formData.append('nIdMoneda', nIdMoneda);



            fncGrabarRegistro(formData, function(aryData) {
                if (aryData.success) {
                    fncCleanAll();
                    $("#formCERegistro").modal("hide");
                    fncPopulate();
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

        $("#nIdChofer").change(function() {
            if ($(this).val() == '0') {
                return;
            }

            $("#nIdVehiculo").val($(this).find("option:selected").data("idvehiculo"));

        });



    });



    // Funciones de la tabla o layout Principal 
    function fncEliminarRegistro(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?',
            function() {

                var jsnData = {
                    nIdRegistro: nIdRegistro
                };

                fncEjecutarEliminarRegistro(jsnData, function(aryData) {

                    if (aryData.success) {
                        fncPopulate();
                        toastr.success(aryData.success);
                    } else {
                        toastr.error(aryData.error);
                    }

                });


            });

    }

    function fncMostrarRegistro(nIdRegistro, sOpcion) {

        $("#formCERegistro").data("nIdRegistro", nIdRegistro);
        $("#formCERegistro").data("sOpcion", sOpcion);
        fncOcultarAside();

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistro(jsnData, function(aryResponse) {
            if (aryResponse.success) {

                var aryData = aryResponse.aryData;
                var aryDetalle = aryResponse.aryDetalle;

                $("#sCliente").data("nIdCliente", aryData.nIdCliente);
                $("#sCliente").val(aryData.sCliente);
                $("#dFechaguias").val(aryData.dFechaguiasDate);
                $("#nIdFormaPago").val(aryData.nIdFormaPago);
                $("#sObservacion").val(aryData.sObservacion);
                $("#nEstado").val(aryData.nEstado);
                $("#sObservacion").val(aryData.sObservacion);
                $("#nIdCondicionComercial").val(aryData.nIdCondicionComercial);
                $("#nBaseImponible").val(aryData.nBaseImponible);
                $("#nDescuento").val(aryData.nDescuento);
                $("#nNeto").val(aryData.nNeto);
                $("#nImpuesto").val(aryData.nImpuesto);
                $("#nTotal").val(aryData.nTotal);
                $("#nIdMoneda").val(aryData.nIdMoneda);

                $("#nFlagIGV").prop("checked", aryData.nFlagIGV == 1 ? true : false);
                $("#nguias").prop("checked", aryData.nguias == 1 ? true : false);

                $("#tblDetalle").bootstrapTable("load", aryDetalle);
                $("#tblDetalle").data("nIdRow", aryDetalle.length);
                fncCalcularTotales();

                if (sOpcion == 'editar') {
                    fncEditForm("#formCERegistro", "Editar guias");
                } else {
                    fncViewForm("#formCERegistro", "Ver guias");
                }

                $("#formCERegistro").modal("show");
            } else {
                toastr.error(aryData.error);
            }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll() {
        $("#sCliente").data("nIdCliente", 0);
        fncRemoveDisabled($("#formCERegistro").find("form"));
        fncClearInputs($("#formCERegistro").find("form"));
    }

    // Llamadas al servidor
    function fncGrabarRegistro(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'guias/fncGrabarRegistro',
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

    function fncBuscarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'guias/fncMostrarRegistro',
            data: jsnData,
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

    function fncEjecutarEliminarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'guias/fncEliminarRegistro',
            data: jsnData,
            dataType: 'json',
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

<!-- Buscar Cliente -->
<script>
    $(function() {

        $("#btnBuscarCliente").on("click", function() {
            $("#formCEBuscarCliente").modal("show");
        });

        $("#btnSeleccionarCliente").on('click', function(event) {
            event.preventDefault();

            var arySelection = $("#tblBuscarClientes").bootstrapTable("getSelections");

            if (arySelection.length == 0) {
                toastr.error("Error. Selecciona un cliente .Porfavor verifique");
                return;
            }

            var arySelection = arySelection[0];
            $("#sCliente").val(arySelection.sNombreoRazonSocial);
            $("#sCliente").data("nIdCliente", arySelection.nIdCliente);
            $("#sNumeroDocumentoCliente").val(  arySelection.sNumeroDocumento);
            $("#sDireccionCliente").val(  arySelection.sDireccion);

            $("#formCEBuscarCliente").modal("hide");
        });

    });
</script>

<!-- Detalle -->
<script>
    $(function() {

        $("#nIdProductoD").select2();
        // Formulario
        $("#btnCrearItem").on('click', function() {
            fncCleanAllD();

            $("#formCEDetalle").find(".modal-title").html('Nueva Producto');
            $("#formCEDetalle").data("nIdRegistro", 0);
            $("#nIdProductoD").val(null).trigger("change.select2");
            $("#nCantidadD").val(1);
            $("#formCEDetalle").modal("show");
        });

        $("#formCEDetalle").find("form").on('submit', function(event) {
            event.preventDefault();

            var nIdRegistro = $("#formCEDetalle").data("nIdRegistro");
            var nIdProducto = $("#nIdProductoD").val();
            var nCantidad = $("#nCantidadD").val();
            var nPrecio = $("#nPrecioD").val();
            var nSubTotal = $("#nSubTotalD").val();
            var nPorcentajeDsct = $("#nPorcentajeDsctD").val();
            var nDescuento = $("#nDescuentoD").val();
            var nTotal = $("#nTotalD").val();
            var sProducto = $("#nIdProductoD option:selected").text();
            var sObservacion = $("#sObservacionD").val().trim();

            if (nIdProducto == null) {
                toastr.error('Error. Debe seleccionar el producto. Porfavor verifique');
                return;
            }

            if (nCantidad == '' || isNaN(nCantidad) || nCantidad <= 0) {
                toastr.error('Error. Debe ingresar la cantidad. Porfavor verifique');
                return;
            }


            if (nIdRegistro == 0) {

                var nIdRow = $('#tblDetalle').data("nIdRow") + 1;

                sLinkEdit = "fncEditarDetalle(" + nIdRow + " , 'editar')";
                sLinkDelete = "fncEliminarDetalle(" + nIdRow + ")";

                var sAcciones = `
                <div class="content-acciones">
                    <a onclick="${sLinkEdit}" href="javascript:;" class="text-primary" title="Editar"><i class="material-icons">edit</i></a>
                    <a onclick="${sLinkDelete}" href="javascript:;" class="text-danger" title="Eliminar"><i class="material-icons">delete</i></a>
                </div>`;

                var jsnData = {
                    nIdRegistro: nIdRegistro,
                    sAcciones: sAcciones,
                    nIdRow: nIdRow,
                    nIdDetalle: 0,
                    nIdProducto: nIdProducto,
                    nCantidad: nCantidad,
                    nPrecio: nPrecio,
                    nSubTotal: nSubTotal,
                    nPorcentajeDsct: nPorcentajeDsct,
                    nDescuento: nDescuento,
                    nTotal: nTotal,
                    sProducto: sProducto,
                    nIdUnidadMedida: $("#nIdProductoD option:selected").data("idum"),
                    sObservacion: sObservacion,
                };

                $('#tblDetalle').bootstrapTable('insertRow', {
                    index: 1,
                    row: jsnData
                });
                $('#tblDetalle').data("nIdRow", nIdRow);
            } else {

                jsnData = $('#tblDetalle').bootstrapTable('getRowByUniqueId', nIdRegistro);

                jsnData.nIdProducto = nIdProducto;
                jsnData.sProducto = sProducto;
                jsnData.nCantidad = nCantidad;
                jsnData.nPrecio = nPrecio;
                jsnData.nSubTotal = nSubTotal;
                jsnData.nPorcentajeDsct = nPorcentajeDsct;
                jsnData.nDescuento = nDescuento;
                jsnData.nTotal = nTotal;
                jsnData.sObservacion = sObservacion;
                jsnData.nIdUnidadMedida = $("#nIdProductoD option:selected").data("idum");

                $('#tblDetalle').bootstrapTable('updateByUniqueId', {
                    nIdRow: jsnData.nIdRow,
                    row: jsnData
                });

            }

            $("#formCEDetalle").modal("hide");
            fncCalcularTotales();
        });

        $("#nIdProductoD").change(function() {
            $("#nPrecioD").val(parseFloat($(this).find("option:selected").data("precio")).toFixed(2));
            $("#nCantidadD").keyup();
        });

         
    });

    function fncEditarDetalle(nIdRow) {
        var jsnRow = $("#tblDetalle").bootstrapTable('getRowByUniqueId', nIdRow);
        $("#formCEDetalle").data("nIdRegistro", jsnRow.nIdRow);
        $("#nIdProductoD").val(jsnRow.nIdProducto).trigger("change.select2");
        $("#nCantidadD").val(jsnRow.nCantidad);
        $("#nPrecioD").val(jsnRow.nPrecio);
        $("#nSubTotalD").val(jsnRow.nSubTotal);
        $("#nPorcentajeDsctD").val(jsnRow.nPorcentajeDsct);
        $("#nDescuentoD").val(jsnRow.nDescuento);
        $("#nTotalD").val(jsnRow.nTotal);
        $("#sObservacionD").val(jsnRow.sObservacion);
        $("#formCEDetalle").find(".modal-title").html('Editar Item');
        $('#formCEDetalle').modal('show');
    }

    function fncEliminarDetalle(nIdRow) {
        if (confirm('Advertencia. Esta acción no se puede deshacer. ¿Continuar?')) {
            $("#tblDetalle").bootstrapTable('removeByUniqueId', nIdRow);
            fncCalcularTotales();
        }
    }

    function fncCalcularTotales() {
        var aryData = $('#tblDetalle').bootstrapTable("getData");
        var nBaseImponibleT = 0;
        var nDescuentoT = 0;

        if (aryData.length > 0) {
            aryData.forEach(element => {
                nBaseImponibleT += parseFloat(element.nSubTotal);
                nDescuentoT += parseFloat(element.nDescuento);
            });
        }

        var nNeto = nBaseImponibleT - nDescuentoT;
        var nImpuesto = 0;
        var nTotal = nNeto + nImpuesto;

        if ($("#nFlagIGV").prop("checked") == false) {
            nImpuesto = nNeto * (<?= IGV ?> / 100);
        }

        $("#nBaseImponible").val(parseFloat(nBaseImponibleT).toFixed(2));
        $("#nDescuento").val(parseFloat(nDescuentoT).toFixed(2));
        $("#nNeto").val(parseFloat(nNeto).toFixed(2));
        $("#nImpuesto").val(parseFloat(nImpuesto).toFixed(2));
        $("#nTotal").val(parseFloat(nTotal).toFixed(2));
    }

    // Funciones Auxiliares
    function fncCleanAllD() {
        fncRemoveDisabled($("#formCEDetalle").find("form"));
        fncClearInputs($("#formCEDetalle").find("form"));
    }
</script>

<!-- Filtros -->
<script>
    $(function() {

        $("#sIdsCliente").select2({
            placeholder: "TODOS"
        });

        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();

            var sIdsCliente = $("#sIdsCliente :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();


            var dFechaInicio = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin = $('#dFechaFin').datepicker('getDate');

            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de inicio y fin. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }

            window.jsnDataFiltros = {
                sIdsCliente: sIdsCliente.join(","),
                dFechaInicio: $('#dFechaInicio').val(),
                dFechaFin: $('#dFechaFin').val(),
            };

            fncPopulate(window.jsnDataFiltros, "#formFilter");
        });

        $("#btnFiltros").on("click", function() {
            $("#formFilter").modal("show");
        });

        $("#btnRefresh").on("click", function() {
            fncPopulate();
        });

        $("#btnLimpiarFiltros").on("click", function() {
            window.jsnDataFiltros = null;
            fncClearFilterM();
            fncPopulate(window.jsnDataFiltros);
        });



    });

    function fncPopulate(jsnData = window.jsnDataFiltros, sModal = '') {
        fncEjecutarPopulate(jsnData, function(aryData) {
            $("#tblPrincipal").bootstrapTable("load", aryData);
            if (sModal != '') {
                $(sModal).modal("hide");
            }
        });
    }

    function fncClearFilterM() {
        $("#sIdsCliente").val([]).trigger("change.select2");
        $("#dFechaInicio,#dFechaFin").val("");
    }

    // Llamadas al servidor
    function fncEjecutarPopulate(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'guias/fncPopulate',
            data: jsnData,
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


</html>