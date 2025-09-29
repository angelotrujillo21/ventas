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
                                                        <button id="btnCrearRD" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div id="toolbar" class="btn-group row">
                                            <div class="col-md-12 sin-padding container-buttons-table">
                                                <button id="btnFilter" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route("documentosPagos/fncPopulate") ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-show-footer="true" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sProveedor" data-sortable="true">Proveedor</th>
                                                            <th data-field="sOrdenCompra" data-sortable="true">O.Compra</th>
                                                            <th data-field="sDocumento" data-sortable="true">Documento</th>
                                                            <th data-field="dFecha" data-sortable="true">Fecha</th>
                                                            <th data-field="dVencimiento" data-sortable="true">Fecha Vencimiento</th>
                                                            <th data-field="sCondicionPago" data-sortable="true">Condicion Pago</th>
                                                            <th data-field="nSubtotal" data-sortable="true">Subtotal</th>
                                                            <th data-field="nTotalDsct" data-sortable="true">Dsct</th>
                                                            <th data-field="nIgv" data-sortable="true">IGV</th>
                                                            <th data-field="nTotal" data-sortable="true">Total</th>
                                                            <th data-field="sEstadoPago" data-sortable="true">Estado Pago</th>
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

    <div class="modal fade modal-full-screen" id="formRD" tabindex="-1" role="dialog" aria-labelledby="formRDLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="formRDLabel">Nueva Registro de documento</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modal-body-scroll">

                    <div class="row">

                        <div class="col-12 col-md-5 border-right-add-prod">

                            <div class="row">


                                <div class="col-12 col-md-12 row">

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nIdProveedorCab" class="col-form-label">Proveedor </label>
                                            <select name="nIdProveedorCab" class="form-control" id="nIdProveedorCab">
                                                <option value="0">NINGUNO</option>
                                                <?php if (fncValidateArray($aryProveedores)) : ?>
                                                    <?php foreach ($aryProveedores as $aryLoop) : ?>
                                                        <option value="<?= $aryLoop["nIdProveedor"] ?>"><?= strup($aryLoop["sNombreoRazonSocial"]) ?> </option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nIdOrdenCompra" class="col-form-label">Orden de compra </label>
                                            <select name="nIdOrdenCompra" class="form-control" id="nIdOrdenCompra">
                                                <option value="0">NINGUNO</option>
                                            
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4 mb-2">
                                        <div class="form-group">
                                            <label for="nEstadoRD" class="col-form-label">Estado </label>
                                            <select name="nEstadoRD" id="nEstadoRD" class="form-control">
                                                <option value="1">ACTIVO</option>
                                                <option value="0">DESACTIVO</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sComentarioRD" class="col-form-label">Comentario </label>
                                            <input type="text" name="sComentarioRD" id="sComentarioRD" class="form-control">
                                        </div>
                                    </div>

                                    


                                </div>

                                <div class="col-12 col-md-12 row">

                                    <div class="col-12 text-left mb-2">
                                        <p class="mb-0 font-18">Documento</p>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="nIdTipoDocumento" class="col-form-label">Tipo Documento </label>
                                            <select name="nIdTipoDocumento" id="nIdTipoDocumento" class="form-control">
                                                <option value="0">Seleccionar</option>
                                                <?php if(fncValidateArray($aryTipoDocumentos)): ?>
                                                    <?php foreach ($aryTipoDocumentos as $key => $aryLoop) :?>
                                                        <option value="<?=$aryLoop["nIdCatalogoTabla"]?>"><?=$aryLoop["sDescripcionLargaItem"]?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="sNumero" class="col-form-label">Numero </label>
                                            <input type="text" name="sNumero" id="sNumero" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="dFecha" class="col-form-label">Fecha </label>
                                            <input type="text" name="dFecha" id="dFecha" class="form-control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="dVencimiento" class="col-form-label">Vencimiento </label>
                                            <input type="text" name="dVencimiento" id="dVencimiento" class="form-control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="dPeriodo" class="col-form-label">Periodo </label>
                                            <input type="text" name="dPeriodo" id="dPeriodo" class="form-control datepicker">
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="nCondicionPago" class="col-form-label">Condicion de pago </label>
                                            <select name="nCondicionPago" id="nCondicionPago" class="form-control">
                                                <option value="1">CONTADO</option>
                                                <option value="2">PARCIAL</option>
                                            </select>
                                        </div>
                                    </div>

                                                        
                                </div>

                         

                            </div>

                        </div>

                        <div class="col-12 col-md-7 my-2 px-2">

                            
                            <form class="col-12 w-100 row" id="form-add-producto">

                                    <div class="col-12 text-left mb-2">
                                        <p class="mb-0 font-18">Agregar Producto</p>
                                    </div>

                                    <div class="col-12 col-md mb-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">Producto :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <select name="nIdProducto" class="form-control" id="nIdProducto">
                                                    <?php if (fncValidateArray($aryProductos)) : ?>
                                                        <?php foreach ($aryProductos as $aryProducto) : ?>
                                                            <option data-nidunidadmedida="<?= $aryProducto["nIdUnidadMedida"] ?>" data-simagen="<?= $aryProducto["sImagen"] ?>" data-nprecio="<?= $aryProducto["nPrecio"] ?>" value="<?= $aryProducto["nIdProducto"] ?>">

                                                                <?= strup($aryProducto["sDescripcion"]) . " - " . $aryProducto["sUnidadMedidaCorto"] ?>

                                                            </option>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md mb-2 pr-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">U.Medida :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <select name="nIdUnidadMedida" class="form-control" id="nIdUnidadMedida">
                                                    <?php if (fncValidateArray($aryUnidadMedida)) : ?>
                                                        <?php foreach ($aryUnidadMedida as $aryLoop) : ?>
                                                            <option value="<?= $aryLoop["nIdUnidadMedida"] ?>"><?= strup($aryLoop["sNombreLargo"]) ?> </option>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md mb-2 pr-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">Precio :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <input type="number" class="form-control" id="nPrecio" min="0.00" max="9999999.999999" lang="en" step="0.000001" value="0.00" autocomplete="off" name="nPrecio">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md mb-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">Cantidad :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <input type="number" class="form-control" id="nCantidad" min="0" max="9999999.999999" lang="en" step="0.000001" value="1" autocomplete="off" name="nCantidad">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 text-right">
                                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Agregar</button>
                                    </div>

                            </form>

                            <div class="row no-gutters">

                                <div class="col-12 text-center mb-2">
                                    <h5>Detalles</h5>
                                </div>


                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="table-detalle" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Acciones</th>
                                                    <th>Item</th>
                                                    <th>Producto</th>
                                                    <th>U.Medida</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right" colspan="6">Dscto</td>
                                                    <td class="">
                                                        <span class="d-inline-block" id="sDsct">0.00</span>
                                                        <input type="number" style="width: 30%; text-align: center;" class="form-control nDsct d-inline-block" name="nDsct" id="nDsct" min="0" max="100" value="0">
                                                    </td> 
                                                </tr>

                                                <tr>
                                                    <td class="text-right" colspan="6">Subtotal</td>
                                                    <td class="subtotal">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right" colspan="6">Igv</td>
                                                    <td class="igv">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right" colspan="6">Total</td>
                                                    <td class="total">0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button id="btnGuardarRD" type="button" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
                </div>

            </div>
        </div>
    </div>



    <!-- Modal para Filtros -->
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
 
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdTipoDocumentoFilter" class="col-form-label">Tipo Documento:</label>
                                    <select class="form-control" name="nIdTipoDocumentoFilter" id="nIdTipoDocumentoFilter">
                                        <option value="0">Seleccionar</option>
                                        <?php if(fncValidateArray($aryTipoDocumentos)): ?>
                                           <?php foreach ($aryTipoDocumentos as $key => $aryLoop) :?>
                                               <option value="<?=$aryLoop["nIdCatalogoTabla"]?>"><?=$aryLoop["sDescripcionLargaItem"]?></option>
                                           <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNumeroFilter" class="col-form-label">Numero:</label>
                                    <input type="text" class="form-control" id="sNumeroFilter" autocomplete="off" name="sNumeroFilter">
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdEstadoPagoFilter" class="col-form-label">Estado Pago:</label>
                                    <select class="form-control" name="nIdEstadoPagoFilter" id="nIdEstadoPagoFilter">
                                        <option value="0">PENDIENTE</option>
                                        <option value="1">PAGADO</option>
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


    <!-- Fin de modales -->




    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- Registro de documentos -->
<script>
    window.bFilterTable = false;
    window.jsnDataFiltro = {};

    window.nColIdProducto = 0;
    window.nColUnidadMedida = 4;
    window.nColPrecio = 5;
    window.nColCantidad = 6;
    window.nColTotal = 7;

    $(function() {

        window.fncOcultarAside();

        $("#nIdProducto,#nIdUnidadMedida").select2({
            placeholder: "Seleccionar"
        });

        $("#nIdProducto,#nIdUnidadMedida").val("").trigger("change");

        fncValidarRol();

        $("#btnCrearRD").on('click', function() {
            fncOcultarAside();
            fncCleanRD();
            fncControles(false);

            $("#nIdProducto,#nIdUnidadMedida").val("").trigger("change");
            $("#formRD").find(".modal-title").html('Nuevo registro de Documentos');
            $("#formRD").data("nIdRegistro", 0);
            $("#formRD").modal("show");
            
        });

        $("#nIdProducto").on("change", function() {

            var nIdProducto = $(this).find("option:selected").val();

            if (nIdProducto == 0) {
                $("#nPrecio").val(0);
                $("#nIdUnidadMedida").val(0);
                return false;
            }

            var nPrecio = $(this).find("option:selected").data("nprecio");
            var nIdUnidadMedida = $(this).find("option:selected").data("nidunidadmedida");

            $("#nPrecio").val(nPrecio);
            $("#nIdUnidadMedida").val(nIdUnidadMedida).trigger("change");

        });

        $('#table').on('refresh.bs.table', function(params) {
            window.bFilterTable = false;
            window.jsnDataFiltro = {};
            fncClearFilter();
        });

        $("#form-add-producto").on('submit', function(event) {

            event.preventDefault();

            var nIdProducto = $("#nIdProducto").find("option:selected").val();
            var sProducto = $("#nIdProducto").find("option:selected").text().trim();
            var nIdUnidadMedida = $("#nIdUnidadMedida").find("option:selected").val();
            var sUnidadMedida = $("#nIdUnidadMedida").find("option:selected").text().trim();


            var nCantidad = $("#nCantidad").val();
            var nPrecio = $("#nPrecio").val();


            if (nIdProducto == '0' || !nIdProducto) {
                toastr.error('Error. Debe seleccionar una producto.');
                return false;
            } else if (nIdUnidadMedida == '0' || !nIdUnidadMedida) {
                toastr.error('Error. Debe seleccionar una unidad de medida .');
                return false;
            } else if (nCantidad == '' || parseFloat(nCantidad) <= 0.00) {
                toastr.error('Error. Debe ingresar una cantidad.');
                return false;
            } else if (nPrecio == '' || parseFloat(nPrecio) <= 0.00) {
                toastr.error('Error. Debe ingresar un monto.');
                return false;
            }

            var jsnRow = {
                nIdProducto: nIdProducto,
                sProducto: sProducto,
                nCantidad: parseFloat(nCantidad),
                nPrecio: parseFloat(nPrecio),
                nIdUnidadMedida: nIdUnidadMedida,
                sUnidadMedida: sUnidadMedida,
                sTable: "#table-detalle",
                nItem: parseInt(($("#table-detalle").find("tbody").find("tr").length) + 1),
                nTotal: (parseFloat(nCantidad) * parseFloat(nPrecio)).toFixed(2)
            };

            fncAgregarFila(jsnRow, "#table-detalle");

            fncCleanAll();
        });

        $("#btnGuardarRD").on("click", function() {

            // Cabecera 
            var nIdRegistro     = $("#formRD").data("nIdRegistro");
            var nIdProveedor    = $("#nIdProveedorCab").val();
            var nIdOrdenCompra  = $("#nIdOrdenCompra").val();
            var nEstado         = $("#nEstadoRD").val();
            var sComentario     = $("#sComentarioRD").val().trim();

            // Documento
            var nIdTipoDocumento = $("#nIdTipoDocumento").val();
            var sNumero          = $("#sNumero").val();
            var dFecha           = $("#dFecha").val();
            var dVencimiento     = $("#dVencimiento").val();
            var dPeriodo         = $("#dPeriodo").val();
            var nCondicionPago   = $("#nCondicionPago").val();
 
            var aryDetalle       = fncGetDataTableCatalogo("#table-detalle");

            var nTotalDsct       = $("#sDsct").html() == '' ? 0 :  $("#sDsct").html() ;
            var nPorcentajeDsct  = $("#nDsct").val() == '' || $("#nDsct").val() <= 0  ? 0 :  $("#nDsct").val() ;
            var nSubTotal        = $("#table-detalle").find("tfoot").find(".subtotal").html();
            var nTotalIGV        = $("#table-detalle").find("tfoot").find(".igv").html();
            var nTotal           = $("#table-detalle").find("tfoot").find(".total").html();
            var nTipoMoneda      = '<?=$arySede["nTipoMoneda"]?>';


            if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar un producto por lo menos para generar un documento.Porfavor verifique');
                return false;
            } else if (nIdProveedor == '') {
                toastr.error('Error. Debe ingresar un proveedor.Porfavor verifique');
                return false;
            } else if (nIdTipoDocumento == '0') {
                toastr.error('Error. Debe de seleccionar un documento.Porfavor verifique');
                return false;
            } else if (sNumero == '') {
                toastr.error('Error. Debe de ingresar un documento.Porfavor verifique');
                return false;
            } else if (dFecha == '') {
                toastr.error('Error. Debe de ingresar una fecha.Porfavor verifique');
                return false;
            } else if (dVencimiento == '') {
                toastr.error('Error. Debe de ingresar una fecha de vencimiento.Porfavor verifique');
                return false;
            }


            var jsnData = {
                nIdRegistro           : nIdRegistro,
                nIdProveedor          : nIdProveedor,
                nIdOrdenCompra        : nIdOrdenCompra,
                nEstado               : nEstado,
                sComentario           : sComentario,
                nIdTipoDocumento      : nIdTipoDocumento,
                sNumero               : sNumero ,
                dFecha                : dFecha,
                dVencimiento          : dVencimiento,
                dPeriodo              : dPeriodo,
                nCondicionPago        : nCondicionPago,
                aryDetalle            : aryDetalle,
                nTotalDsct            : nTotalDsct,
                nPorcentajeDsct       : nPorcentajeDsct,
                nSubTotal             : nSubTotal,
                nIgv                  : nTotalIGV,
                nTotal                : nTotal,
                nTipoMoneda           : nTipoMoneda,
                nPorcentajeIGV        : nIgv, // VIENE DE LAS VARIBLAES GLOBALES
                nEstadoPago           : nIdRegistro == 0 ? 0 : $("#formRD").data("nEstadoPago")
             };

            console.log(jsnData);
            // return;

            fncGrabarDocumento(jsnData, (aryResponse) => {
                if (aryResponse.success) {

                    toastr.success(aryResponse.success);
                    $("#formRD").modal("hide");
                    fncCleanRD();
                    fncRefreshTable();

                } else {
                    toastr.error(aryResponse.error);
                }
            });


        });

        $("#nIdProveedorCab").change(function(){

            if($(this).val() == '0') {
                $("#nIdOrdenCompra").html(`<option value="0">NINGUNO</option>`);
                return;
            }
            
            // Buscar orden de compras pendientes 
            var jsnData = {nIdProveedor : $(this).val()  , nEstadoRegistroDocumentos: 0  , nTipo : 1};
            fncDrawOC(jsnData , "#nIdOrdenCompra");
        });

        $("#nIdOrdenCompra").on("change",function(){
 
            var jsnData = {
                nIdRegistro: $(this).val()
            };

            $("#table-detalle").find("tbody").html("");
     
            fncBuscarOC(jsnData,(aryResponse) => {

                var aryData     = aryResponse.aryData;
                var aryDetalle  = aryResponse.aryDetalle;
                
                if (aryDetalle.length > 0) {

                    aryDetalle.forEach((aryItem, nIndex) => {
                     
                        var jsnRow = {
                            nIdProducto             : aryItem.nIdProducto,
                            sProducto               : aryItem.sProducto + '-' + aryItem.sUnidadMedida ,
                            nCantidad               : parseFloat(aryItem.nCantidad),
                            nPrecio                 : parseFloat(aryItem.nPrecio),
                            sTable                  : "#table-detalle",
                            nIdUnidadMedida         : aryItem.nIdUnidadMedida,
                            sUnidadMedida           : aryItem.sUnidadMedida,
                            sUbicacionAlmacen       : aryItem.sNombreUbicacionAlmacen + ' - ' + aryItem.sCodigoUbicacionAlmacen, 
                            nItem                   : parseInt((nIndex) + 1),
                            nTotal                  : (parseFloat(aryItem.nCantidad) * parseFloat(aryItem.nPrecio)).toFixed(2)
                        };

                        fncAgregarFila(jsnRow, "#table-detalle");

                    });

                }

            });
        });

        $("#nDsct").on("keyup blur keydown",function(event){

            if( event.type == 'blur' && $("#nDsct").val() == '' ){
                $("#nDsct").val(0);
            }
           
            if ( event.type == 'blur' ||  event.type == 'keyup' || ( event.type == 'keydown' && ( event.keyCode || event.which === 13 ) ) ) {
                fncTotales(null, "#table-detalle");
            }

          

        });


    });


    window.fncCleanRD = function() {
        fncClearInputs($("#form-add-producto"));
        $("#nIdProveedorCab,#nIdTipoDocumento").val(0).trigger("change");
        $("#nEstadoRD").val(1);
        $("#sComentarioRD,#sNumero,#dFecha,#dVencimiento,#dPeriodo").val("");
        $("#table-detalle").find("tbody").html("");
        $("#nIdProducto,#nIdUnidadMedida").val("").trigger("change");
        setTimeout(() => {
            fncTotales(null, "#table-detalle", null);
        }, 500);
    }

    window.fncGetDataTableCatalogo = function(sTable) {

        var aryData = [];

        $(sTable).find("tbody").find("tr").each(function() {

            var nIdProducto = $(this).find("td").eq(nColIdProducto).html();
            var nIdUnidadMedida = $(this).find("td").eq(nColUnidadMedida).data("nidunidadmedida");
            var nIdProveedor = 0;

            var nPrecio = $(this).find("td").eq(nColPrecio).find(".precio").val();
            var nCantidad = $(this).find("td").eq(nColCantidad).find(".cantidad").val();

            aryData.push({
                nIdProducto: nIdProducto,
                nIdUnidadMedida: nIdUnidadMedida,
                nIdProveedor: nIdProveedor,
                nPrecio: nPrecio,
                nCantidad: nCantidad
            });

        });

        return aryData;
    }

    window.fncAgregarFila = function(jsnRow, sHtmlTag) {

        if ($(sHtmlTag).find("tbody").find("tr").length > 0) {

            var bExist = false;

            $(sHtmlTag).find("tbody").find("tr").each(function() {

                var nIdProducto = $(this).find("td").eq(nColIdProducto).html();

                var nIdUnidadMedida = $(this).find("td").eq(4).data("nidunidadmedida");

                var nPrecioItem = parseFloat($(this).find("td").eq(nColPrecio).find(".precio").val());
                var nCantidadItem = parseFloat($(this).find("td").eq(nColCantidad).find(".cantidad").val());

                if (
                    jsnRow.nIdProducto == nIdProducto &&
                    nPrecioItem == jsnRow.nPrecio &&
                    nIdUnidadMedida == jsnRow.nIdUnidadMedida
                ) {

                    bExist = true;

                    var nCantidadNew = nCantidadItem + jsnRow.nCantidad;
                    var nTotalNew = nCantidadNew * nPrecioItem;

                    $(this).find("td").eq(nColCantidad).find(".cantidad").val(nCantidadNew);
                    $(this).find("td").eq(nColTotal).find("div").html(nTotalNew.toFixed(2));

                }
            });

            if (bExist === false) {
                $(sHtmlTag).find("tbody").append(fncDrawFilaProducto(jsnRow));
            }

        } else {

            $(sHtmlTag).find("tbody").append(fncDrawFilaProducto(jsnRow));

        }

        setTimeout(() => {
            fncTotales(null, "#table-detalle", null);
        }, 500);

    }

    window.fncEliminarItem = function(nIdProducto, sTable, element) {

        fncMsg(1, "¿Estas seguro de eliminar este item?",
            function() {

                $(element).parent().parent().parent().remove();

                setTimeout(() => {
                    fncTotales(null, sTable, null);
                }, 500);

            });

    }

    window.fncDrawFilaProducto = function(jsnData) {
        var sHtml = ``;
        sHtml = `<tr> 
                    <td class="d-none">${jsnData.nIdProducto}</td>
                    <td><div><a href="javascript:;" class="text-danger font-18" onclick="fncEliminarItem(${jsnData.nIdProducto},'${jsnData.sTable}',this);" title="Eliminar"><i class="material-icons">delete</i></a></div></td>
                    <td><div>${jsnData.nItem}</div></td>
                    <td><div>${jsnData.sProducto}</div></td>
                    <td data-nidunidadmedida="${jsnData.nIdUnidadMedida}">${jsnData.sUnidadMedida}</td>
                    <td class="cont-number"><div><input onblur="fncTotales(${jsnData.nIdProducto},'${jsnData.sTable}',event);" onkeyup="fncTotales('${jsnData.sTable}',event);" type="number" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="${jsnData.nPrecio}" autocomplete="off" class="form-control font-12 precio"></div></td>
                    <td class="cont-number"><div><input onblur="fncTotales(${jsnData.nIdProducto},'${jsnData.sTable}',event);" onkeyup="fncTotales('${jsnData.sTable}',event);" type="number" value="${jsnData.nCantidad}" min="1" max="9999999" step="1" autocomplete="off" class="form-control font-12 cantidad"></div></td>
                    <td><div>${fncNf(jsnData.nTotal)}</div></td>
                </tr>`;
        return sHtml;
    }


    window.fncRefreshTable = function() {
        if (bFilterTable) {
            $("#formFilter").trigger("submit");
        } else {
            $("#table").bootstrapTable('refresh');
        }
    }


    function fncValidarRol() {
        if ($("body").data("nadmin") == 1) {
            // es admin
        } else {
            //$("#btnCrearCompra").hide();
        }
    }

    // Funciones de la tabla o layout Principal 
    function fncEliminarRegistro(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?',
            function() {

                var jsnData = {
                    nIdRegistro: nIdRegistro
                };

                fncEjecutarEliminarRegistro(jsnData, function(aryData) {

                    if (aryData.success) {
                        fncRefreshTable();
                        toastr.success(aryData.success);
                    } else {
                        toastr.error(aryData.error);
                    }

                });


            });


    }

    function fncMostrarRegistro(nIdRegistro, sAccion) {

        fncCleanAll();
        fncOcultarAside();
        $("#formRD").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistro(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryDocumento = aryResponse.aryDocumento;
                var aryDetalle = aryResponse.aryDocDetalle;

                $("#nIdProveedorCab").val(aryDocumento.nIdProveedor);

                if(aryDocumento.nIdOrdenCompra != "" && aryDocumento.nIdOrdenCompra > 0 ){
                    $("#nIdOrdenCompra").html(`<option value="${aryDocumento.nIdOrdenCompra}">${aryDocumento.nIdOrdenCompra.padStart(8, "0")}</option>`);
                } else {
                    $("#nIdOrdenCompra").html(`<option value="0">NINGUNO</option>`);
                }
                 
                $("#nEstadoRD").val(aryDocumento.nEstado);
                $("#sComentarioRD").val(aryDocumento.sComentario);
                $("#formRD").data("nEstadoPago", aryDocumento.nEstadoPago);

                $("#nDsct").val(parseFloat(aryDocumento.nPorcentajeDsct)).trigger("keyup");

                $("#nIdTipoDocumento").val(aryDocumento.nIdTipoDocumento);
                $("#sNumero").val(aryDocumento.sNumero);
                $("#dFecha").val(aryDocumento.dFecha);
                $("#dVencimiento").val(aryDocumento.dVencimiento);
                $("#dPeriodo").val(aryDocumento.dPeriodo);
                $("#nCondicionPago").val(aryDocumento.nCondicionPago);

                $("#table-detalle").find("tbody").html("");

                if (aryDetalle.length > 0) {

                    aryDetalle.forEach((aryItem, nIndex) => {


                        var jsnRow = {
                            nIdProducto: aryItem.nIdProducto,
                            sProducto: aryItem.sProducto,
                            nIdUnidadMedida: aryItem.nIdUnidadMedida,
                            sUnidadMedida: aryItem.sUnidadMedida,
                            nCantidad: parseFloat(aryItem.nCantidad),
                            nPrecio: parseFloat(aryItem.nPrecio),
                            sTable: "#table-detalle",
                            nItem: parseInt((nIndex) + 1),
                            nTotal: (parseFloat(aryItem.nCantidad) * parseFloat(aryItem.nPrecio)).toFixed(2)
                        };


                        fncAgregarFila(jsnRow, "#table-detalle");

                    });

                }

                if (sAccion == 'editar') {
                    $("#formRD").find(".modal-title").html("Editar Documento");
                    fncControles(false);
                } else {
                    $("#formRD").find(".modal-title").html("Ver Documento");
                    fncControles(true);
                }

                $("#nIdProveedorCab").prop("disabled",true);
                $("#nIdOrdenCompra").prop("disabled",true);
                $("#formRD").modal("show");

            } else {
                toastr.error(aryData.error);
            }
        });
    }

    function fncBuscarOC(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'ordenCompra/fncMostrarOrdenCompra',
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


    window.fncTotales = function(nIdProducto = null, sTable, event = null) {

        var nSubtotal = 0;
        var nCantidadTotal = 0;
        var nTotalIgv = 0;
        var nTotal = nTotalBruto = 0;
        var nPorcentajeDescuento  = parseFloat( $("#nDsct").val() < 0 ? 0 : $("#nDsct").val() );
 
        if ($(sTable).find("tbody").find("tr").length > 0) {

            $(sTable).find("tbody").find("tr").each(function() {

                var nPrecioItem = $(this).find("td").eq(nColPrecio).find(".precio").val();
                var nCantidad = $(this).find("td").eq(nColCantidad).find(".cantidad").val();
                var nTotalItem = parseFloat(nPrecioItem) * parseFloat(nCantidad);

                $(this).find("td").eq(nColTotal).find("div").html(fncNf(nTotalItem));

                nSubtotal += nTotalItem;
                nCantidadTotal += parseInt(nCantidad);
            });

            nTotalBruto = nSubtotal;
            nTotalIgv   = (nSubtotal * parseFloat(nIgv / 100));
            nDsct       = nSubtotal  * (nPorcentajeDescuento /100);

            // Descuento de canje y porcentaje
            nDsctTotal      = nDsct ;
            nSubtotal       = nSubtotal > nDsctTotal ? (nSubtotal - nDsctTotal) - nTotalIgv : 0;
            nTotal          = nSubtotal + nTotalIgv;


            $("#sDsct").html( fncNf(nDsctTotal) );
            $(sTable).find(".subtotal").html(fncNf(nSubtotal));
            $(sTable).find(".igv").html(fncNf(nTotalIgv));
            $(sTable).find(".total").html(fncNf(nTotal));

        } else {
            $("#sDsct").html( fncNf(0) );
            $(sTable).find(".subtotal").html(fncNf(0));
            $(sTable).find(".igv").html(fncNf(0));
            $(sTable).find(".total").html(fncNf(0));
        }
    }


     
    window.fncControles = (bFlag) => {
        // bloquear
        if (bFlag) {

            $("#sComentarioRD").attr("disabled", "disabled");
            $("#nProcesadoOC").attr("disabled", "disabled");
            $("#nEjecutadoOC").attr("disabled", "disabled");
            $("#nEstadoRD").attr("disabled", "disabled");
            $("#nIdProveedorCab").attr("disabled", "disabled");
            $("#dFechaOC").attr("disabled", "disabled");
            $("#nIdTipoDocumento,#sNumero,#dFecha,#dVencimiento,#dPeriodo,#nCondicionPago").prop("disabled",true);

            $("#form-add-producto").hide();
            $("#formRD").find(".modal-footer").hide();

        } else {

            $("#sComentarioRD").removeAttr("disabled");
            $("#nProcesadoOC").removeAttr("disabled");
            $("#nEjecutadoOC").removeAttr("disabled");
            $("#nEstadoRD").removeAttr("disabled");
            $("#nIdProveedorCab").removeAttr("disabled");
            $("#dFechaOC").removeAttr("disabled");

            $("#nIdTipoDocumento,#sNumero,#dFecha,#dVencimiento,#dPeriodo,#nCondicionPago").prop("disabled",false);

            $("#form-add-producto").show();
            $("#formRD").find(".modal-footer").show();
        }
    }


    // Funciones Auxiliares
    window.fncCleanAll = () => {
        fncClearInputs($("#form-add-producto"));
        $("#nPrecio").val("0.00");
        $("#nIdProducto").val("").trigger("change");
        $("#nIdProveedor").val("0").trigger("change");
    }

    window.fncDrawOC = function(jsnData,sHtmlTag,nIdOrdenCompra){
        
        fncObtenerOC(jsnData, function(aryData) {

            let sOptions = ``;

            if (aryData.success) {

                sOptions += `<option value="0">NINGUNO</option>`;

                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.nIdOrdenCompra}">${aryElement.nIdOrdenCompra.padStart(8, "0")}</option>`;
                });

                $(sHtmlTag).html(sOptions);

                if (nIdOrdenCompra != null) {
                    $(sHtmlTag).val(nIdOrdenCompra);
                }
            }

        });
    }

    // Llamadas al servidor

    function fncGrabarDocumento(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'documentosPagos/fncGrabarDocumento',
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

    function fncEjecutarEliminarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'documentosPagos/fncEliminarRegistro',
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

    function fncBuscarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'documentosPagos/fncMostrarRegistro',
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

    function fncObtenerOC(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ordenCompra/fncObtenerOC',
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
<!-- Registro de documentos -->


<!-- Filtros -->
<script>
    $(function() {


       
        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();
 
            var nIdTipoDocumento    = $('#nIdTipoDocumentoFilter').val();
            var sNumero             = $('#sNumeroFilter').val();
            var nIdEstadoPago       = $('#nIdEstadoPagoFilter').val();
            var dFechaInicio        = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin           = $('#dFechaFin').datepicker('getDate');
    

            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de alta y inicio. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }

            window.jsnDataFiltro = {
                nIdTipoDocumento    : nIdTipoDocumento,
                sNumero             : sNumero,
                dFechaInicio        : $('#dFechaInicio').val(),
                dFechaFin           : $('#dFechaFin').val(),
                nIdEstadoPago       : nIdEstadoPago,
            };

            fncPopulate(window.jsnDataFiltro, function(aryData) {
                $('#table').bootstrapTable('load', aryData);
                $("#formFilter").modal("hide");
                bFilterTable = true;
            });

        });

        $("#btnFilter").on("click", function() {
            $("#formFilter").modal("show");
            $("#nIdEstadoPagoFilter").val(0);
        });

    });

    function fncClearFilter() {
        fncClearInputs($("#formFilter").find("form"));
    }

    // Llamadas al servidor
    function fncPopulate(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'documentosPagos/fncPopulate',
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
<!-- Filtros -->




</html>