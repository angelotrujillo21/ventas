<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body  
    data-nadmin="<?=$nAdmin?>"
    data-nidestadopagopagado="<?= $nIdEstadoPagoPagado ?>"
    data-ntipomoneda= "<?=$arySede["nTipoMoneda"]?>"
    data-ntipocomprofactura ="<?=$nTipoComproFactura?>"
    data-ntipocomproboleta  ="<?=$nTipoComproBoleta ?>"
    data-ntipocomproordencompra  ="<?=$nTipoComproOrdenCompra ?>"
    data-ntipodocdni="<?=$nTipoDocDNI?>"
    data-ntipodocruc="<?=$nTipoDocRUC?>"
    data-nidmetodoenviort="<?=$nIdMetodoEnvioRT?>"
    data-nestadoenvioentregado="<?=$nEstadoEnvioEntregado?>"
    >

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

                                           
                                            </div>
                                        </div>
 

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('documentos/fncPopulateDocumentosParaAnulaciones') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="nIdDocumento" data-sortable="true">Cod. Doc</th>
                                                            <th data-field="sNumero" data-sortable="true">Cod. Pedido</th>
                                                            <th data-field="sResponsable" data-sortable="true">Empleado</th>
                                                            <th data-field="sCliente" data-sortable="true">Cliente</th>
                                                            <th data-field="sFacturado" data-sortable="true">Facturado</th>
                                                            <th data-field="sDetalle" class="text-center" data-sortable="true">Detalle<br><span class="font-13">Producto | Precio x Cantidad</span></th>
                                                            <th data-field="nSubtotal" data-sortable="true">Subtotal</th>
                                                            <th data-field="nIgv" data-sortable="true">Igv</th>
                                                            <th data-field="nTotal" data-sortable="true">Total</th>
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

   
    <div class="modal fade" id="formFacturacion" tabindex="-1" role="dialog" aria-labelledby="formFacturacionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formFacturacionLabel">Realizar Facturacion</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-12"> 
                                <div class="form-group"> 
                                    <label for="nIdPedidoF" class="col-form-label">Cod.Pedido<span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="nIdPedidoF" id="nIdPedidoF" readonly>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoComprobanteF" class="col-form-label">Tipo Comprobante<span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoComprobanteF" id="nTipoComprobanteF">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoComprobante)): ?>
                                            <?php foreach($aryTipoComprobante as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoDocumentoF" class="col-form-label">Tipo Documento <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoDocumentoF" id="nTipoDocumentoF">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoDocumento)): ?>
                                            <?php foreach($aryTipoDocumento as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionCortaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="sNumeroDocumentoF" class="col-form-label">Numero de documento <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumentoF" id="sNumeroDocumentoF">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNombreoRazonSocialF" class="col-form-label">Nombre o Razon Social <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreoRazonSocialF" id="sNombreoRazonSocialF">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="sCorreoF" class="col-form-label">Correo</label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCorreoF" id="sCorreoF">
                                </div>
                            </div> 

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="dFechaEmisionF" class="col-form-label">Fecha Emision <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" value="<?=date("d/m/Y")?>"  placeholder="" class="form-control datepicker" name="dFechaEmisionF" id="dFechaEmisionF">
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


<!-- Anulacion -->
<script>

    window.bFilterTable = false;
    
    $(function() {

        fncOcultarAside();
        //$("#btn-toogle-desktop").trigger("click");
       
    
        // Formulario Agregrar producto

    
 


    });

    
    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            $("#btnCrearPedido").hide();
        }
    }


    // Funciones de la tabla 

    window.fncCambiarEstadoAnulacion = function(nIdDocumento,nIdPedido,nEstado){

        var sMensaje = nEstado == 1 ? "¿Estas seguro de anular el documento?" : "¿Estas seguro de quitar la anulacion al documento ?";

        fncMsg(1, sMensaje , 
        function(){
             
            var jsnData = {
                nIdRegistro : nIdDocumento,
                nIdPedido   : nIdPedido,
                nEstado     : nEstado
            };

            fncAnularDocumentoPedido(jsnData , (aryData) => {

                if(aryData.success){
                    
                    fncRefreshTable();

                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });
    }
 

    window.fncEliminarDOC = function(nIdRegistro) {
 


        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
            
            var nFlagEliminarPedido = 0 ;

            if (confirm('Se eliminara el documento y los movimientos. ¿Desea tambien que se elimine el pedido?')) {
            
                nFlagEliminarPedido = 1;
            }

            var jsnData = {
                nIdRegistro         : nIdRegistro,
                nFlagEliminarPedido : nFlagEliminarPedido
            };

            fncEjecutarEliminarDoc(jsnData, function(aryData) {

                if (aryData.success) {
                    fncRefreshTable();
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }

            });


        });





    }
 
    // Funciones Auxiliares
 

    window.fncCleanAll = () => {
        fncClearInputs($("#form-add-producto"));
        fncClearInputs($("#formCECliente").find("form"));
        $("#nPrecio").val("0.00");
        $("#nIdProducto").val(0).trigger("change");
        $("#nIdProvincia,#nIdDistrito").html(`<option value="0">SELECCIONAR</option>`);

    }
 
    

    window.fncRefreshTable = function(){
        if(bFilterTable){
            $("#formFilter").trigger("submit");
        } else {
            $("#table").bootstrapTable('refresh');
        }
    }
    

    // Llamadas al servidor

 
    function fncEjecutarEliminarDoc(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'documentos/fncEliminarRegistro',
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
 
    function fncAnularDocumentoPedido(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'documentos/fncAnularDocumentoPedido',
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
<!-- Anulacion -->

 
<!-- Realizar Facturacion -->
<script>
    $(function() {

    
        $("#formFacturacion").find("form").on("submit", function(event) {

            event.preventDefault();
            
            var nIdRegistro         = $("#formFacturacion").data("nIdRegistro");
            var nIdPedido           = $("#nIdPedidoF").data("nIdPedido");
            var nTipoComprobante    = $("#nTipoComprobanteF").find("option:selected").val();
            var sTipoComprobante    = $("#nTipoComprobanteF").find("option:selected").text().trim();
            var nTipoDocumento      = $("#nTipoDocumentoF").find("option:selected").val();
            var sNumeroDocumento    = $("#sNumeroDocumentoF").val();
            var sCorreo             = $("#sCorreoF").val();
            var sNombreoRazonSocial = $("#sNombreoRazonSocialF").val();
            var dFechaEmision       = $("#dFechaEmisionF").val();

            if (nIdPedido == '') {
                toastr.error('Error. No existe un pedido para facturar .Porfavor verifique o solicite asistencia.');
                return false;
            }  else if (nTipoComprobante == '0') {
                toastr.error('Error. Debe seleccionar un tipo de comprobante . Porfavor verifique');
                return false;
            } else if (nTipoDocumento == '0') {
                toastr.error('Error. Debe seleccionar un tipo de documento. Porfavor verifique');
                return false;
            } else if (sNumeroDocumento == '') {
                toastr.error('Error. Debe seleccionar un numero de documento para el pedido. Porfavor verifique');
                return false;
            }  else if (sNombreoRazonSocial == '') {
                toastr.error('Error. Debe de ingresar un nombre o razon social. Porfavor verifique');
                return false;
            }  else if (dFechaEmision == '') {
                toastr.error('Error. Debe de ingresar una fecha de emision. Porfavor verifique');
                return false;
            } 



            var jsnData = {
                nIdRegistro             : nIdRegistro,
                nIdPedido               : nIdPedido,
                nTipoComprobante        : nTipoComprobante,
                sTipoComprobante        : sTipoComprobante,
                nTipoDocumento          : nTipoDocumento,
                sNumeroDocumento        : sNumeroDocumento,
                sNombreoRazonSocial     : sNombreoRazonSocial,
                dFechaEmision           : dFechaEmision,
                sCorreo                 : sCorreo,
                nAnulado                : nIdRegistro == 0 ? 0 : $("#formFacturacion").data("nAnulado"),
                nEstado                 : nIdRegistro == 0 ? 0 : $("#formFacturacion").data("nEstado"),
            };

 
            fncGrabarDocumento(jsnData, (aryResponse) => {
                if (aryResponse.success) {
                    
                    fncCleanAllF();
                    
                    fncRefreshTable();
                    
                    $("#formFacturacion").modal("hide");
                    
                    toastr.success(aryResponse.success);
                    
                    if (confirm("¿Desea imprimir?")) {
                        window.open(web_root + 'pedidos/fncPedidoPdf/' + nIdPedido , "_blank", "toolbar=1, scrollbars=1, resizable=1, width=" + 800 + ", height=" + 800);
                    }

                } else {
                    toastr.error(aryResponse.error);
                }
            });


        });

        $("#nTipoComprobanteF").change(function(){

            switch(parseInt($(this).val())){

                case $("body").data("ntipocomprofactura") : 
                    $("#nTipoDocumentoF").val($("body").data("ntipodocruc"));
                break;
                
                case $("body").data("ntipocomproboleta") : 
                case $("body").data("ntipocomproordencompra") : 
                    $("#nTipoDocumentoF").val($("body").data("ntipodocdni"));
                break;

            }

           

      
           

        });


    });


    window.fncMostrarDocPedido = function(nIdRegistro, sPedidoFormat,sOpcion) {
        
        fncCleanAllF();
        
        $("#formFacturacion").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarDocumento(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData  = aryResponse.aryData;

                $("#nIdPedidoF").val(sPedidoFormat);
                $("#nIdPedidoF").data("nIdPedido",aryData.nIdPedido);
                $("#nTipoComprobanteF").val(aryData.nTipoComprobante);
                $("#nTipoDocumentoF").val(aryData.nTipoDocumento);
                $("#sNumeroDocumentoF").val(aryData.sNumeroDocumento);
                $("#sNombreoRazonSocialF").val(aryData.sNombreoRazonSocial);
                $("#sCorreoF").val(aryData.sCorreo);
                $("#dFechaEmisionF").val(aryData.dFechaEmision);
                $("#formFacturacion").data("nAnulado",aryData.nAnulado);
                $("#formFacturacion").data("nEstado",aryData.nEstado);

                if(sOpcion == 'editar'){
                    fncEditForm("#formFacturacion" , "Editar Facturacion");
                } else {
                    fncViewForm("#formFacturacion" , "Ver Facturacion");
                }

                $("#formFacturacion").modal("show");
            } else {
                toastr.error(aryData.error);
            }
        });

    }

  

    // Funciones Auxiliares
    window.fncCleanAllF = () => {
        $("#nIdPedidoF").data("nIdPedido",null);
        $("#nIdPedidoF").val("");

        $("#nIdPedidoF").data("sNombreoRazonCliente",null);
        $("#nIdPedidoF").data("nTipoDocCliente",null);
        $("#nIdPedidoF").data("sNumeroDocCliente",null);
        fncClearInputs($("#formFacturacion"));

    }

    

    // Llamadas al servidor

    function fncGrabarDocumento(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'documentos/fncGrabarDocumento',
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

    
    function fncBuscarDocumento(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'documentos/fncMostrarRegistro',
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
<!-- Realizar Facturacion -->


</html>