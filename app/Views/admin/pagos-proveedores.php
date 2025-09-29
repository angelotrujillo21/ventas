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
                                                        <button id="btnCrearPP" class="btn btn-gradient-primary btn-rounded btn-icon">
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
                                                <table data-toggle="table" id="table" data-url="<?=route("pagosProveedores/fncPopulate")?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-show-footer="true" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sProveedor" data-sortable="true">Proveedor</th>
                                                            <th data-field="sMetodoPago" data-sortable="true">Metodo de pago</th>
                                                            <th data-field="sCuentaCorriente" data-sortable="true">Cuenta corriente</th>
                                                            <th data-field="dFechaPago" data-sortable="true">Fecha pago</th>
                                                            <th data-field="dFechaRegistro" data-sortable="true">Fecha registro</th>
                                                            <th data-field="nCantidadDocs" data-sortable="true">Cantidad documentos</th>
                                                            <th data-field="nTotal" data-sortable="true">Total</th>
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

    <div class="modal fade modal-full-screen" id="formPP" tabindex="-1" role="dialog" aria-labelledby="formRDLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="formRDLabel">Nuevo pago a proveedores</h5>
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
                                            <label for="dFechaPago" class="col-form-label">Fecha de pago </label>
                                            <input type="text" name="dFechaPago" id="dFechaPago" class="form-control datepicker">
                                        </div>
                                    </div>
 
                                    <div class="col-12 col-md-4 mb-2">
                                        <div class="form-group">
                                            <label for="nEstado" class="col-form-label">Estado </label>
                                            <select name="nEstado" id="nEstado" class="form-control">
                                                <option value="1">ACTIVO</option>
                                                <option value="0">DESACTIVO</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sDescripcion" class="col-form-label">Descripcion </label>
                                            <input type="text" name="sDescripcion" id="sDescripcion" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-md-12 row">

                                    <div class="col-12 text-left mb-2">
                                        <p class="mb-0 font-18">A pagar</p>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="nIdMetodoPago" class="col-form-label">Forma de pago </label>
                                            <select name="nIdMetodoPago" id="nIdMetodoPago" class="form-control">
                                                <option value="0">Seleccionar</option>
                                                <?php if (fncValidateArray($aryMetodosPagos)) : ?>
                                                    <?php foreach ($aryMetodosPagos as $aryLoop) : ?>
                                                        <option value="<?= $aryLoop["nIdMetodoPago"] ?>"><?= strup($aryLoop["sNombrePago"]) ?> </option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="nIdCuentaCorriente" class="col-form-label">Cuenta Corriente </label>
                                            <select name="nIdCuentaCorriente" id="nIdCuentaCorriente" class="form-control">
                                                <option value="0">Seleccionar</option>
                                                
                                            </select>
                                        </div>
                                    </div>                    
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-7 my-2 px-2">
 

                            <div class="row no-gutters">

                                <div class="col-12 text-center mb-2">
                                    <h5>Detalles</h5>
                                </div>


                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="table-detalle" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Seleccionar</th>
                                                    <th>Proveedor</th>
                                                    <th>Documento</th>
                                                    <th>Fecha de vencimiento</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right" colspan="4">Total</td>
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
                    <button id="btnGuardarPP" type="button" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
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
 
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdProveedorFilter" class="col-form-label">Proveedor </label>
                                    <select name="nIdProveedorFilter" class="form-control" id="nIdProveedorFilter">
                                        <option value="0">NINGUNO</option>
                                        <?php if (fncValidateArray($aryProveedores)) : ?>
                                            <?php foreach ($aryProveedores as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdProveedor"] ?>"><?= strup($aryLoop["sNombreoRazonSocial"]) ?> </option>
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


    <!-- Fin de modales -->




    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- Registro de documentos -->
<script>
    window.bFilterTable = false;
    window.jsnDataFiltro = {};

    window.nColTotal = 4;
  
    $(function() {

        window.fncOcultarAside();
 
        fncValidarRol();

        $("#btnCrearPP").on('click', function() {

            fncOcultarAside();
            fncCleanPP();
            fncControles(false);

            $("#formPP").find(".modal-title").html('Nuevo pago a proveedores');
            $("#formPP").data("nIdRegistro", 0);
            $("#formPP").modal("show");
        });

        $('#table').on('refresh.bs.table', function(params) {
            window.bFilterTable = false;
            window.jsnDataFiltro = {};
            fncClearFilter();
        });

   
        $("#btnGuardarPP").on("click", function() {

            // Cabecera 
            var nIdRegistro           = $("#formPP").data("nIdRegistro");
            var nIdProveedor          = $("#nIdProveedorCab").val();
            var dFechaPago            = $("#dFechaPago").val();
            var nEstado               = $("#nEstado").val();

            var sDescripcion          = $("#sDescripcion").val().trim();
            var nIdMetodoPago         = $("#nIdMetodoPago").val();
            var nIdCuentaCorriente    = $("#nIdCuentaCorriente").val();

            // Documento
           
 
            var aryDetalle       = fncGetDataTableCatalogo("#table-detalle");
 
            var nTotal           = $("#table-detalle").find("tfoot").find(".total").html();
 

            if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar un documentos por lo menos para generar el pago.Porfavor verifique');
                return false;
            } else if (nIdProveedor == '') {
                toastr.error('Error. Debe ingresar un proveedor.Porfavor verifique');
                return false;
            } else if (dFechaPago == '') {
                toastr.error('Error. Debe de ingresar una fecha de pago.Porfavor verifique');
                return false;
            } else if (nIdMetodoPago == '') {
                toastr.error('Error. Debe de ingresar un metodo de pago.Porfavor verifique');
                return false;
            } else if (nIdCuentaCorriente == '') {
                toastr.error('Error. Debe de ingresar una cuenta corriente.Porfavor verifique');
                return false;
            }  


            var jsnData = {
                nIdRegistro             : nIdRegistro,
                nIdProveedor            : nIdProveedor,
                sDescripcion            : sDescripcion,
                dFechaPago              : dFechaPago,
                nEstado                 : nEstado,
                nIdMetodoPago           : nIdMetodoPago,
                nIdCuentaCorriente      : nIdCuentaCorriente,
                nTotal                  : nTotal,
                aryDetalle              : aryDetalle
            };

            console.log(jsnData);
            // return;

            fncGrabarPago(jsnData, (aryResponse) => {
                if (aryResponse.success) {

                    toastr.success(aryResponse.success);
                    $("#formPP").modal("hide");
                    fncCleanPP();
                    fncRefreshTable();

                } else {
                    toastr.error(aryResponse.error);
                }
            });

        });

        $("#nIdProveedorCab").change(function(){

            if($(this).val() == '0') {
                $("#table-detalle").find("tbody").html(``);
                fncTotales("#table-detalle");
                return;
            }

            var jsnData = {
                nIdProveedor : $(this).val(),
                nEstadoPago  : 0
            };

             fncObtenerDocumentos(jsnData,(aryResponse) => {

                var aryData     = aryResponse.aryData;
                 
                if (aryData.length > 0) {

                    aryData.forEach((aryItem, nIndex) => {
                     
                        var jsnRow = {
                            nIdDocumentosPago    : aryItem.nIdDocumentosPago,
                            sProveedor           : aryItem.sProveedor,
                            sDocumento           : aryItem.sTipoDoc + '-' + aryItem.sNumero ,
                            dVencimiento         : aryItem.dVencimiento,
                            nTotal               : aryItem.nPagoPendiente,
                            nItem                : parseInt((nIndex) + 1),
                            sTable               : "#table-detalle",
                        };

                        $("#table-detalle").find("tbody").append(fncDrawFila(jsnRow));
                    });

                }
            });
        
        });

        $("#nIdMetodoPago").on("change", function() {

            if( $("#nIdMetodoPago").val() == 0 ) {
                return;
            }

            var sMetodo       = $(this).find("option:selected").text().trim();
            var nIdMetodoPago = $(this).find("option:selected").val();

            switch(sMetodo){
                case 'EFECTIVO':

                 //  Si es efectivo van a cargar todas las cuentas corrientes
                var jsnData = {nIdMetodoPago : null};
                fncDrarwCC("#nIdCuentaCorriente", jsnData);
                break;
                default : 
             
                // cualquiera distinto de efectivo va a cargar segun el metodo de pago
                // Buscar cuentas corrientes 
                var jsnData = {nIdMetodoPago : nIdMetodoPago};
                fncDrarwCC("#nIdCuentaCorriente", jsnData);

                break;
            }
       
        });
       
    });


    window.fncCleanPP = function() {
        $("#nIdProveedorCab,#nIdMetodoPago,#nIdCuentaCorriente").val(0).trigger("change");
        $("#nEstado").val(1);
        $("#dFechaPago,#sDescripcion").val("");
        $("#table-detalle").find("tbody").html("");
        setTimeout(() => {
            fncTotales(null, "#table-detalle", null);
        }, 500);
    }

    window.fncGetDataTableCatalogo = function(sTable) {

        var aryData = [];

        $(sTable).find("tbody").find("tr").each(function() {

            var bCheck     = $(this).find("td").eq(0).find(".checkDP").prop("checked");
            
            if(bCheck){
                
                var nTotal = $(this).find("td").eq(nColTotal).find(".total").val();
                
                aryData.push({
                    nIdDocumentosPago : $(this).find("td").eq(0).find(".checkDP").val(),
                    nTotal            : nTotal
                });

            }

        });

        return aryData;
    }
 
    window.fncDrawFila = function(jsnRowFila) {
        var sHtml = ``;
        sHtml = `<tr> 
                    <td> <input type="checkbox" onchange="fncTotales('#table-detalle')" value="${jsnRowFila.nIdDocumentosPago}" class="form-control checkDP" /> </td>
                    <td><div>${jsnRowFila.sProveedor}</div></td>
                    <td><div>${jsnRowFila.sDocumento}</div></td>
                    <td><div>${jsnRowFila.dVencimiento}</div></td>
                    <td class="cont-number"><div><input style="width: 30%;" onblur="fncTotales('${jsnRowFila.sTable}',event);" onkeyup="fncTotales('${jsnRowFila.sTable}',event);" type="number" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="${jsnRowFila.nTotal}" autocomplete="off" class="form-control font-12 total"></div></td>
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

    function fncDrarwCC(sHtmlTag, jsnData, nIdCuentaCorriente = null) {

        fncGetCMMP(jsnData, function(aryData) {

            let sOptions = ``;

            if (aryData.success) {

                sOptions += `<option value="0">SELECCIONAR</option>`;

                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.nIdCuentaCorriente}">${aryElement.sPropietario + ' | ' + aryElement.sBanco + ' | ' + aryElement.sTipoCuenta + ' | ' + aryElement.sNumeroCC}</option>`;
                });

                $(sHtmlTag).html(sOptions);

                if (nIdCuentaCorriente != null) {
                    $(sHtmlTag).val(nIdCuentaCorriente);
                }
            }

        });

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

        fncCleanPP();
        fncOcultarAside();
        $("#formPP").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistro(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryPago    = aryResponse.aryPago;
                var aryDetalle = aryResponse.aryDocDetalle;

                $("#nIdProveedorCab").val(aryPago.nIdProveedor);
                $("#dFechaPago").val(aryPago.dFechaPago);
                $("#nEstado").val(aryPago.nEstado);
                $("#sDescripcion").val(aryPago.sDescripcion);

                $("#nIdMetodoPago").val(aryPago.nIdMetodoPago);
                $("#nIdCuentaCorriente").html(`<option value="${aryPago.nIdCuentaCorriente}">${aryPago.sPropietarioCC + " | " + aryPago.sBancoCC  + " | " + aryPago.sTipoCuentaCC + " | " + aryPago.sNumeroCC}</option>`);

                $("#table-detalle").find("tbody").html("");

                if (aryDetalle.length > 0) {

                    aryDetalle.forEach((aryItem, nIndex) => {


                        var jsnRow = {
                            nIdDocumentosPago    : aryItem.nIdDocumentosPago,
                            sProveedor           : aryItem.sProveedor,
                            sDocumento           : aryItem.sTipoDoc + '-' + aryItem.sNumero ,
                            dVencimiento         : aryItem.dVencimiento,
                            nTotal               : aryItem.nTotal,
                            nItem                : parseInt((nIndex) + 1),
                            sTable               : "#table-detalle",
                        };

                        $("#table-detalle").find("tbody").append(fncDrawFila(jsnRow));

                    });

                    setTimeout(() => {
                        $(".checkDP").each(function() {
                            $(this).prop("checked",true);
                            $(this).prop("disabled",true);
                            $(this).trigger("change");
                        });
                    }, 700);
                }

                if (sAccion == 'editar') {
                    $("#formPP").find(".modal-title").html("Editar Pago a proveedores");
                    fncControles(false);
                } else {
                    $("#formPP").find(".modal-title").html("Ver Pago a proveedores");
                    fncControles(true);
                }

                $("#nIdProveedorCab , #nIdMetodoPago , #nIdCuentaCorriente").prop("disabled",true);
                $("#formPP").modal("show");
            } else {
                toastr.error(aryData.error);
            }
        });
    }

     
    window.fncTotales = function( sTable, event = null) {

  
        var nTotal = 0; 
  
        if ($(sTable).find("tbody").find("tr").length > 0) {

            $(sTable).find("tbody").find("tr").each(function() {

                // Solo acumulara  los que tienen check activo
                var bIsCheck   = $(this).find("td").eq(0).find(".checkDP").prop("checked");
                var nTotalItem = $(this).find("td").eq(nColTotal).find(".total").val();
                
                if(bIsCheck){
                    nTotal += parseFloat(nTotalItem);
                }
                
            });

             
            $(sTable).find(".total").html(fncNf(nTotal));

        } else {
            $(sTable).find(".total").html(fncNf(0));
        }
    }
     
    window.fncControles = (bFlag) => {
        // bloquear
        if (bFlag) {

            $("#nIdProveedorCab,#dFechaPago,#nEstado,#sDescripcion,#nIdMetodoPago,#nIdCuentaCorriente").prop("disabled",true);
            $("#formPP").find(".modal-footer").hide();

        } else {

            $("#nIdProveedorCab,#dFechaPago,#nEstado,#sDescripcion,#nIdMetodoPago,#nIdCuentaCorriente").prop("disabled",false);
            $("#formPP").find(".modal-footer").show();
        }
    }

    // Llamadas al servidor

    function fncGrabarPago(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pagosProveedores/fncGrabarPago',
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
            url: web_root + 'pagosProveedores/fncEliminarRegistro',
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
            url: web_root + 'pagosProveedores/fncMostrarRegistro',
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

    function fncGetCMMP(jsnData , fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cuentascorrientes/fncGetCMMP',
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

    function fncObtenerDocumentos(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'documentosPagos/fncObtenerDocumentos',
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

</script>
<!-- Registro de documentos -->


<!-- Filtros -->
<script>
    $(function() {


       
        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();
 
            var nIdProveedor        = $('#nIdProveedorFilter').val();
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
                nIdProveedor        : nIdProveedor,
                dFechaInicio        : $('#dFechaInicio').val(),
                dFechaFin           : $('#dFechaFin').val(),
            };

            fncPopulate(window.jsnDataFiltro, function(aryData) {
                $('#table').bootstrapTable('load', aryData);
                $("#formFilter").modal("hide");
                bFilterTable = true;
            });

        });

        $("#btnFilter").on("click", function() {
            $("#formFilter").modal("show");
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
            url: web_root + 'pagosProveedores/fncPopulate',
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