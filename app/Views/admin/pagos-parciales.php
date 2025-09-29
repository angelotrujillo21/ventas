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
                                                        
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->


                                        <div id="toolbar" class="btn-group row">
                                            <div class="col-md-6 sin-padding container-buttons-table">

                                                <button id="btnFiltrarPedido" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('pedidos/fncPopulatePagosParciales') ?>" data-export-footer="true" data-show-footer="true" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="nIdPedido" data-sortable="true" data-visible="false">Cod. Venta Interno</th>
                                                            <th data-field="sNumero" data-sortable="true">Cod. Venta </th>
                                                            <th data-field="sResponsable" data-sortable="true" data-visible="false">Empleado</th>
                                                            <th data-field="sCliente" data-sortable="true">Cliente</th>
                                                            <th data-field="sMetodoEnvio" data-sortable="true" data-visible="false">M.Envio</th>
                                                            <th data-field="sMetodoPago" data-sortable="true" data-visible="false">M.Pago</th>
                                                            <th data-field="sEstadoPago" data-sortable="true">E.Pago</th>
                                                            <th data-field="sEstadoEnvio" data-sortable="true">E.Envio</th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha Creacion</th>
                                                            <th data-field="sDespachado" data-sortable="true">Despachado</th>
                                                            <th data-field="sFacturado" data-sortable="true">Facturado</th>
                                                            <th data-field="sDetalle" class="text-center" data-sortable="true">Detalle<br><span class="font-13">Producto | Precio x Cantidad</span></th>

                                                            <th data-field="nTotalBruto" data-sortable="true">Total Bruto</th>
                                                            <th data-field="nDsct" data-sortable="true">Descuento Simple</th>
                                                            <th data-field="nDsctCP" data-sortable="true">Descuento por Canje</th>
                                                            <th data-field="nDsctTotal" data-sortable="true">Total Dsct</th>

                                                            <th data-field="nSubtotal" data-sortable="true">Subtotal</th>
                                                            <th data-field="nIgv" data-sortable="true">Igv</th>
                                                            <th data-field="nTotal" data-sortable="true">Total a Pagar</th>
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
                                    <label for="aryIdPedido" class="col-form-label">Cod.Venta</label>
                                    <select class="form-control" name="aryIdPedido" id="aryIdPedido" multiple>
                                        <option value="">TODOS</option>
                                        <?php if (fncValidateArray($aryPedidos)) : ?>
                                            <?php foreach ($aryPedidos as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdPedido"] ?>"><?= sp($aryLoop["sNumero"]) ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nFacturado" class="col-form-label">Facturado</label>
                                    <select class="form-control" name="nFacturado" id="nFacturado">
                                        <option value="">TODOS</option>
                                        <option value="1">FACTURADOS</option>
                                        <option value="0">SIN FACTURAR</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="aryProductos" class="col-form-label">Productos</label>
                                    <select class="form-control" name="aryProductos" id="aryProductos" multiple>
                                        <option value="">TODOS</option>
                                        <?php if (fncValidateArray($aryProductos)) : ?>
                                            <?php foreach ($aryProductos as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdProducto"] ?>"><?= strup($aryLoop["sDescripcion"])  ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryMetodoPago" class="col-form-label">Metodo de pago </label>
                                    <select class="form-control" name="aryMetodoPago" id="aryMetodoPago" multiple>
                                        <?php if (fncValidateArray($aryMetodosPagos)) : ?>
                                            <?php foreach ($aryMetodosPagos as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdMetodoPago"] ?>"><?= strup($aryLoop["sNombrePago"]) ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryEstadoPago" class="col-form-label">Estado de pago</label>
                                    <select class="form-control" name="aryEstadoPago" id="aryEstadoPago" multiple>
                                        <?php if (fncValidateArray($aryEstadoPago)) : ?>
                                            <?php foreach ($aryEstadoPago as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= strup($aryLoop["sDescripcionLargaItem"]) ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryMetodoEnvio" class="col-form-label">Metodo de envio </label>
                                    <select class="form-control" name="aryMetodoEnvio" id="aryMetodoEnvio" multiple>
                                        <?php if (fncValidateArray($aryMetodosEnvio)) : ?>
                                            <?php foreach ($aryMetodosEnvio as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdMetodoEnvio"] ?>"><?= strup($aryLoop["sNombreEnvio"]) ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryEstadoEnvio" class="col-form-label">Estado de envio</label>
                                    <select class="form-control" name="aryEstadoEnvio" id="aryEstadoEnvio" multiple>
                                        <?php if (fncValidateArray($aryEstadoEnvio)) : ?>
                                            <?php foreach ($aryEstadoEnvio as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= strup($aryLoop["sDescripcionLargaItem"]) ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
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


    <div class="modal fade" id="formCECuotas" tabindex="-1" role="dialog" aria-labelledby="formCECuotasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCECuotasLabel">Configurar Cuotas</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nTotalVenta" class="col-form-label">Total de venta</label>
                                    <input type="number" id="nTotalVenta" name="nTotalVenta" class="form-control" min="0" value=""  readonly disabled />
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nMontoAdelanto" class="col-form-label">Adelanto</label>
                                    <input type="number"  id="nMontoAdelanto" name="nMontoAdelanto" class="form-control" min="0" value="" />
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nMontoPendiente" class="col-form-label">Pendiente</label>
                                    <input type="number" id="nMontoPendiente" name="nMontoPendiente" class="form-control" min="0" value="" readonly disabled />
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nCuotas" class="col-form-label">N° Cuotas</label>
                                    <input type="number" id="nCuotas" name="nCuotas" class="form-control" min="0" value="">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="" class="col-form-label d-none d-md-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <button id="btnProcesarCuotas" type="button" class="btn btn-gradient-primary btn-fw">Procesar</button>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group mb-0">
                                    <h6 class="mb-0">Agregar Cuota</h6>
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nMontoC" class="col-form-label">Monto</label>
                                    <input type="number" class="form-control" min="0" name="nMontoC" id="nMontoC" value="">
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nIdMetodoPagoC" class="col-form-label">Met de pago <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdMetodoPagoC" id="nIdMetodoPagoC">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if (fncValidateArray($aryMetodosPagos)) : ?>
                                            <?php foreach ($aryMetodosPagos as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdMetodoPago"] ?>"><?= strup($aryLoop["sNombrePago"]) ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nEstadoPagoC" class="col-form-label">Est de pago <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nEstadoPagoC" id="nEstadoPagoC">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if (fncValidateArray($aryEstadoPago)) : ?>
                                            <?php foreach ($aryEstadoPago as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= strup($aryLoop["sDescripcionLargaItem"]) ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="dFechaVencimientoC" class="col-form-label">Fecha Venc</label>
                                    <input type="text" autocomplete="off" value="<?= date("d/m/Y") ?>" placeholder="" class="form-control datepicker" name="dFechaVencimientoC" id="dFechaVencimientoC">
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="dFechaPagoC" class="col-form-label">Fec Pago</label>
                                    <input type="text" autocomplete="off" value="<?= date("d/m/Y") ?>" placeholder="" class="form-control datepicker" name="dFechaPagoC" id="dFechaPagoC">
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="" class="col-form-label d-none d-md-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <button id="btnAgregarCuota" type="button" class="btn btn-gradient-primary btn-rounded btn-icon"><i class="fas fa-plus-circle"></i></button>
                                </div>
                            </div>



                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="table-detalle" class="table">
                                        <thead>
                                            <tr>
                                                <th>Acciones</th>
                                                <th>Item</th>
                                                <th>M.Pago</th>
                                                <th>E.Pago</th>
                                                <th>F.Vec</th>
                                                <th>F.Pago</th>
                                                <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">TOTAL CUOTAS</td>
                                                <td id="nTotalCuotas">0.00</td>
                                            </tr>
                                        </tfoot>

                                    </table>
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




    <!-- Fin de modales -->


    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>




<!-- Filtros Mantenimiento -->
<script>
    $(function() {

        $("#aryIdPedido,#aryProductos,#aryMetodoPago,#aryEstadoPago,#aryMetodoEnvio,#aryEstadoEnvio").select2({
            placeholder: "TODOS"
        });

        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();

            var aryIdPedido = $("#aryIdPedido :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();
            var aryProductos = $("#aryProductos :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();
            var nFacturado = $("#nFacturado").find("option:selected").val();
            var dFechaInicio = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin = $('#dFechaFin').datepicker('getDate');

            var aryMetodoPago = $("#aryMetodoPago :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();
            var aryEstadoPago = $("#aryEstadoPago :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();
            var aryMetodoEnvio = $("#aryMetodoEnvio :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();
            var aryEstadoEnvio = $("#aryEstadoEnvio :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();


            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de inicio y fin. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }

            var jsnData = {
                aryIdPedido: aryIdPedido,
                aryProductos: aryProductos,
                nFacturado: nFacturado == "" ? null : nFacturado,
                dFechaInicio: $('#dFechaInicio').val(),
                dFechaFin: $('#dFechaFin').val(),
                aryMetodoPago: aryMetodoPago,
                aryEstadoPago: aryEstadoPago,
                aryMetodoEnvio: aryMetodoEnvio,
                aryEstadoEnvio: aryEstadoEnvio,
            };

            fncPopulate(jsnData, function(aryData) {
                bFilterTable = true;
                $("#formFilter").modal("hide");
                $("#table").bootstrapTable("load", aryData);
            });

        });

        $("#btnFiltrarPedido").on("click", function() {
            $("#formFilter").modal("show");
        });


    });

    window.fncClearFilterM = () => {

        $("#aryIdPedido,#aryProductos,#aryMetodoPago,#aryEstadoPago,#aryMetodoEnvio,#aryEstadoEnvio").val([]).trigger("change");
        $("#nFacturado").val("");
        $("#dFechaInicio,#dFechaFin").val("");

    }

    // Llamadas al servidor
    function fncPopulate(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncPopulate',
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
<!-- Filtros Mantenimiento -->




<!--  Cuotas -->
<script>
    $(function() {


        $("#formCECuotas").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro           =  $("#formCECuotas").data("nIdRegistro");
            var nIdPedido             =  $("#formCECuotas").data("nIdPedido");

            var nMontoAdelanto        = $("#nMontoAdelanto").val();
            var nCuotas               = $("#nCuotas").val();
            var aryDetalle            = fncGetDataTableCatalogo("#table-detalle");


            if ( nCuotas == 0 ) {
                toastr.error('Error. Debe ingresar la cantidad de cuotas. Por favor verificar.');
                return;
            } else if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar el detalle de las cuotas. Por favor verificar.');
                return;
            } else if (nMontoAdelanto == '') {
                toastr.error('Error. No ha ingresado de forma correcta el monto de adelanto . Por favor verificar.');
                return;
            } 

            

            var jsnData = {
                nIdRegistro     : nIdRegistro,
                nIdPedido       : nIdPedido,
                nCuotas         : nCuotas,
                nAdelanto       :  nMontoAdelanto,
                aryDetalle      : aryDetalle,
                nEstado         : 1
            };

         
            fncGrabarCuotasPedido(jsnData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formCECuotas").modal("hide");
                    $('#table').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });  

        });

        $("#nMontoAdelanto").on("keyup blur keydown",function(event){

            if( event.type == 'blur' && ($("#nMontoAdelanto").val() == '' || $("#nMontoAdelanto").val() < 0) ){
                $("#nMontoAdelanto").val(0);
            }

            if ( event.type == 'blur' ||  event.type == 'keyup' || ( event.type == 'keydown' && ( event.keyCode || event.which === 13 ) ) ) {

                var nTotalVenta =  parseFloat( $("#nTotalVenta").val() ) ;
                var nMontoAdelanto =  parseFloat( $("#nMontoAdelanto").val() ) ;
                var nMontoPendiente = nTotalVenta - nMontoAdelanto;

                $("#nMontoPendiente").val(nMontoPendiente);
            }



        });

        $("#btnProcesarCuotas").on("click",function(){

            var nCuotas         = $("#nCuotas").val();
            var nMontoPendiente = $("#nMontoPendiente").val();
            var nCantidadCuotas = $("#table-detalle").find("tbody").find("tr").length;

            if(nCuotas == '' || nCuotas <= 0){
                toastr.error('Error. Debe de ingresar la cantidad de cuotas , Por favor verificar.');
                return;
            } else if(nMontoPendiente == '' || nMontoPendiente <= 0){
                toastr.error('Error. Debe de haber un monto pendiente  a pagar , Por favor verificar o solicite asistencia.');
                return;
            }


            if( nCantidadCuotas > 0 ){

                if (confirm("Advertencia. Esta accion reemplazara alas cuotas actuales ¿Desea Continuar?")) {

                    fncBuildCuotas();

                }

            } else {

                fncBuildCuotas();

            }


        });

        $("#btnAgregarCuota").on("click",function(){

            var nMonto              = $("#nMontoC").val();
            var nIdMetodoPago       = $("#nIdMetodoPagoC").val();
            var nEstadoPago         = $("#nEstadoPagoC").val();
            var dFechaVencimiento   = $("#dFechaVencimientoC").val();
            var dFechaPago          = $("#dFechaPagoC").val();


            if(nMonto == '' || nMonto <= 0){
                toastr.error('Error. Debe de ingresar el monto de la cuotas , Por favor verificar.');
                return;
            } else if(nIdMetodoPago == '' || nIdMetodoPago == 0){
                toastr.error('Error. Debe de seleccionar un metodo de pago, Por favor verificar o solicite asistencia.');
                return;
            }  else if(nEstadoPago == '' || nEstadoPago == 0){
                toastr.error('Error. Debe de seleccionar un estado de pago, Por favor verificar o solicite asistencia.');
                return;
            }  else if(dFechaVencimiento == '' ){
                toastr.error('Error. Debe de ingresar una fecha de vencimiento, Por favor verificar o solicite asistencia.');
                return;
            }

            
            var jsnData = {
                nIdPedidoCuotaDetalle  : 0,
                nItem                  : $("#table-detalle").find("tbody").find("tr").length,
                nIdMetodoPago          : nIdMetodoPago,
                nEstadoPago            : nEstadoPago ,
                dFechaVencimiento      : dFechaVencimiento ,
                dFechaPago             : dFechaPago ,
                nMonto                 : nMonto,
                sTable                 : '#table-detalle' 
            };

            fncAgregarFila(jsnData , "#table-detalle");
            fncClearAgregarCuota();

        });

    });

    function fncCleanAll(){

        fncClearAgregarCuota();
        $("#table-detalle").find("tbody").html("");
        $("#nTotalVenta,#nMontoAdelanto,#nMontoPendiente,#nCuotas").val(0);

    }

    function fncClearAgregarCuota(){
        $("#nMontoC").val(0);
        $("#nIdMetodoPagoC").val(0);
        $("#nEstadoPagoC").val(0);
        $("#dFechaVencimientoC").val('');
        $("#dFechaPagoC").val('');
    }

    function fncBuildCuotas(){

        $( "#table-detalle").find("tbody").html("");

        var nCuotas         = $("#nCuotas").val();
        var nMontoPendiente = $("#nMontoPendiente").val();
        var nCuotaIten      = nMontoPendiente / nCuotas;

        var sHtml = ``;

        for (let nIndex = 1; nIndex <= nCuotas; nIndex++) {

            var jsnData = {
                nIdPedidoCuotaDetalle  : 0,
                nItem                  : nIndex,
                nIdMetodoPago          : 0 ,
                nEstadoPago            : 0 ,
                dFechaVencimiento      : '' ,
                dFechaPago             : '' ,
                nMonto                 : nCuotaIten,
                sTable                 : '#table-detalle' 
            };

            fncAgregarFila(jsnData , "#table-detalle");
        }

       
    }


    window.fncGetDataTableCatalogo = function(sTable) {
        
        var aryData = [];

        $(sTable).find("tbody").find("tr").each(function() {

            var nItem                 = $(this).find("td").eq(1).html();
            var nIdMetodoPago         = $(this).find("td").eq(2).find("select").find("option:selected").val();
            var nEstadoPago           = $(this).find("td").eq(3).find("select").find("option:selected").val();
            var dFechaVencimiento     = $(this).find("td").eq(4).find("input").val();
            var dFechaPago            = $(this).find("td").eq(5).find("input").val();
            var nMonto                = $(this).find("td").eq(6).find("input").val();

            aryData.push({
                nItem               : nItem,
                nIdMetodoPago       : nIdMetodoPago,
                nEstadoPago         : nEstadoPago,
                dFechaVencimiento   : dFechaVencimiento ,
                dFechaPago          : dFechaPago ,
                nMontoCuota         : nMonto,
                nEstado             : 1
            });

        });

        return aryData;
    }


    window.fncAgregarFila = function(jsnRow, sHtmlTag) {

        $(sHtmlTag).find("tbody").append(fncDrawFilaProducto(jsnRow));

        setTimeout(() => {
            fncTotales( "#table-detalle", null);
            $(".datepicker").datepicker();
        }, 500);

    }

    window.fncTotales = function( sTable, event = null) {

        var nTotal = 0;
         
        if ($(sTable).find("tbody").find("tr").length > 0) {
            
            $(sTable).find("tbody").find("tr").each(function(nIndex,aryItem) {

                // Resscribri el item 
                $(this).find("td").eq(1).html(nIndex + 1);

                // Obtener el item
                var nMontoItem =  parseFloat($(this).find("td").eq(6).find("input").val());

                // Obtener el estado de pago 
                var sEstadoPago =  $(this).find("td").eq(3).find("select option:selected").text().trim().toUpperCase();
                
                if(sEstadoPago == 'PAGADO'){
                    $(this).find("td").eq(5).find("input").val(moment().format('DD/MM/YYYY'));
                }

                // Acumular el monto de item 
                nTotal += nMontoItem;

            });
 
            $("#nTotalCuotas").html(fncNf(nTotal));
            $("#nCuotas").val(  $(sTable).find("tbody").find("tr").length );

        } else {
    
            $("#nTotalCuotas").html(fncNf(0));
            
        }

    }

    window.fncDrawFilaProducto = function(jsnData) {

        var sHtml = ``;
 
        var sMetodoPago = ``;
        var sOptions    = ``;
    
        $("#nIdMetodoPagoC option").each(function(){
            sOptions += `<option ${ $(this).val() == jsnData.nIdMetodoPago ? 'selected' : '' } value="${$(this).val()}">${$(this).text()}</option>`;
        });

        sMetodoPago = `<select class="form-control">${sOptions}</select>`;
    

        var sEstadoPago = ``;
        var sOptions    = ``;
    
        $("#nEstadoPagoC option").each(function(){
            sOptions += `<option ${ $(this).val() == jsnData.nEstadoPago ? 'selected' : '' } value="${$(this).val()}">${$(this).text()}</option>`;
        });

        sEstadoPago       =  `<select onchange="fncTotales( '#table-detalle', null);" class="form-control">${sOptions}</select>`;

        sFechaVencimiento = `<input type="text" autocomplete="off" value="${jsnData.dFechaVencimiento}" placeholder="" class="form-control datepicker">`;
        sFechaPago        = `<input type="text" autocomplete="off" value="${jsnData.dFechaPago}" placeholder="" class="form-control datepicker">`;
        sMonto            = `<input type="number" onblur="fncTotales('${jsnData.sTable}',event);" onkeyup="fncTotales('${jsnData.sTable}',event);" min="0" autocomplete="off" value="${jsnData.nMonto}" placeholder="" class="form-control">`;


        sHtml = `<tr data-id="${jsnData.nIdPedidoCuotaDetalle}">
                    <td>
                        <div>
                            <a href="javascript:;" class="text-danger font-18" onclick="fncEliminarItem(this);" title="Eliminar"><i class="material-icons">delete</i></a>
                        </div>
                    </td>
                    <td><div>${jsnData.nItem}</div></td>
                    <td><div>${sMetodoPago}</div></td>                
                    <td><div>${sEstadoPago}</div></td>
                    <td><div>${sFechaVencimiento}</div></td>
                    <td><div>${sFechaPago}</div></td>
                    <td><div>${sMonto}</div></td>
                </tr>`;
        return sHtml;
    }


    window.fncEliminarItem = function(element) {

        if (confirm("¿Estas seguro de eliminar este item?")) {

            $(element).parent().parent().parent().remove();
            fncTotales( "#table-detalle", null);
        }
    }

    window.fncConfigPagosParciales = (nIdPedido, nIdPedidoCuota , nTotal ) => {

        fncClearCuotas();

        if( nIdPedidoCuota == 0){
            
            // Nueva configuracion
            $("#formCECuotas").data("nIdRegistro" , nIdPedidoCuota );
            $("#formCECuotas").data("nIdPedido" , nIdPedido);
            $("#nTotalVenta").val(nTotal);
            $("#nCuotas").val(0);
            $("#nMontoAdelanto").val(0);
            $("#nMontoAdelanto").trigger("keyup");
            $("#formCECuotas").modal("show");

        } else {
            
            // Actualizar configuracion
            $("#formCECuotas").data("nIdRegistro" , nIdPedidoCuota );
            $("#formCECuotas").data("nIdPedido" , nIdPedido);
            $("#nTotalVenta").val(nTotal);
            
            var jsnData ={nIdRegistro : nIdPedidoCuota}; 

            fncMostrarPedidoCuota(jsnData , (aryResponse)=> {

                if(aryResponse.success){
                
                    var aryPedidoCuota        = aryResponse.aryPedidoCuota;
                    var aryPedidoCuotaDetalle = aryResponse.aryPedidoCuotaDetalle;

                    $("#nCuotas").val(aryPedidoCuota.nCuotas);
                    $("#nMontoAdelanto").val(aryPedidoCuota.nAdelanto);
                    $("#nMontoAdelanto").trigger("keyup");

                    if(aryPedidoCuotaDetalle.length){
                        aryPedidoCuotaDetalle.forEach(element => {
                            var jsnData = {
                                nIdPedidoCuotaDetalle  : element.nIdPedidoCuotaDetalle,
                                nItem                  : element.nNumeroCuota,
                                nIdMetodoPago          : element.nIdMetodoPago,
                                nEstadoPago            : element.nEstadoPago ,
                                dFechaVencimiento      : element.dFechaVencimiento ,
                                dFechaPago             : element.dFechaPago ,
                                nMonto                 : element.nMontoCuota,
                                sTable                 : '#table-detalle' 
                            };

                            fncAgregarFila(jsnData , "#table-detalle");
                        });
                    }


                    $("#formCECuotas").modal("show");

                } else {
                    toastr.error(aryResponse.error);
                }
                
            });
            

        }



    }

    window.fncClearCuotas = () => {

         $("#nTotalVenta,#nMontoAdelanto,#nMontoPendiente,#nCuotas").val("");

        // Formulario de cuota
        $("#nMontoC#dFechaVencimientoC,#dFechaPagoC").val("");
        $("#nIdMetodoPagoC,#nEstadoPagoC").val(0);
        $("#table-detalle").find("tbody").html("");

    }

    // Llamadas al servidor
    function fncGrabarCuotasPedido(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncGrabarCuotasPedido',
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

    function fncMostrarPedidoCuota(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncMostrarPedidoCuota',
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
<!--  Cuotas -->


</html>