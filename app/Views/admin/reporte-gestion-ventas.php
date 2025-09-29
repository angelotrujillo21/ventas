<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body  
    data-nadmin="<?=$nAdmin?>"
    
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

                                        <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="r-general-tab" data-toggle="tab" href="#r-general" role="tab" aria-controls="r-general" aria-selected="true">Reporte General</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="r-detallado-tab" data-toggle="tab" href="#r-detallado" role="tab" aria-controls="r-detallado" aria-selected="false">Reporte Detallado</a>
                                            </li>
                                        </ul>

                                        
                                        <div class="tab-content" id="myTabContent">
                                            
                                            <div class="tab-pane fade show active" id="r-general" role="tabpanel" aria-labelledby="r-general-tab">

                                                    
                                                <!-- Fila Cabecera -->
                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center p-2">

                                                            <div class="flex-center">
                                                                <h5>Reporte General</h5>
                                                            </div>

                                                            <div class="ml-auto">
                                                            
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin de Fila Cabecera -->


                                                <div id="toolbar" class="btn-group row">
                                                    <div class="col-md-6 sin-padding container-buttons-table">
                                                        
                                                        <button id="btnFilterG" class="btn btn-gradient-primary-table" type="button" title="Filtros">
                                                            <i class="fas fa-filter"></i>
                                                        </button>

                                                        <button id="btnExportExcelRG" class="btn btn-gradient-primary-table" type="button" title="Exportar a excel">
                                                            <i class="fas fa-file-excel"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                             

                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <table data-toggle="table" id="tableGeneral" data-show-export="true" data-export-footer="true" data-show-footer="true" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                            <thead>
                                                                <tr> 
                                                                    <th class="text-center" colspan="12"> <span  id="sTituloG"></span> </th>
                                                                </tr>
                                                                <tr>
                                                                    <th data-field="nIdPedido" data-sortable="true" data-visible="false">Cod. Pedido Interno</th>
                                                                    <th data-field="sNumero" data-sortable="true" data-visible="true">Cod. Pedido </th>
                                                                    <th data-field="sResponsable" data-sortable="true">Empleado</th>
                                                                    <th data-field="sCliente" data-sortable="true">Cliente</th>
                                                                    <th data-field="dFechaCreacion" data-sortable="true">Fecha Creacion</th>
                                                                    <th data-field="sFacturado" data-sortable="true">Facturado</th>
                                                                    <th data-field="sDetalle" class="text-center" data-sortable="true">Detalle<br><span class="font-13">Producto | Precio x Cantidad</span></th>
                                                                    <th data-field="nTotalBruto" data-sortable="true">Total Bruto</th>
                                                                    <th data-field="nDsctTotal" data-sortable="true">Dsct Total</th>
                                                                    <th data-field="nSubtotal" data-sortable="true">Subtotal</th>
                                                                    <th data-field="nIgv" data-footer-formatter="fncLabelFooter" data-sortable="true">Igv</th>
                                                                    <th data-field="nTotal" data-footer-formatter="fncTotalFooter" data-sortable="true">Total</th>
                                                                </tr> 
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="tab-pane fade" id="r-detallado" role="tabpanel" aria-labelledby="r-detallado-tab">

                                                 <!-- Fila Cabecera -->
                                                 <div class="row my-2">
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center p-2">

                                                            <div class="flex-center">
                                                                <h5>Reporte Detallado</h5>
                                                            </div>

                                                            <div class="ml-auto">
                                                            
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin de Fila Cabecera -->


                                                <div id="toolbarD" class="btn-group row">
                                                    <div class="col-md-6 sin-padding container-buttons-table">

                                                    
                                                        <button id="btnFilterD" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                            <i class="fas fa-filter"></i>
                                                        </button>

                                                         <button id="btnExportExcelD" class="btn btn-gradient-primary-table" type="button" title="Exportar a excel">
                                                            <i class="fas fa-file-excel"></i>
                                                        </button>
                                                    
                                                    </div>
                                                </div>

                                           

                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <table data-toggle="table" id="tableDetalle" data-show-export="true" data-export-footer="true" data-show-footer="true" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbarD" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                            <thead>
                                                                <tr> 
                                                                    <th class="text-center" colspan="6"> <span  id="sTituloD"></span> </th>
                                                                </tr>
                                                                <tr>
                                                                    <th data-field="nItem" data-sortable="true">Item</th>
                                                                    <th data-field="sProducto" data-sortable="true">Producto</th>
                                                                    <th data-field="nPrecio" data-sortable="true">Precio</th>
                                                                    <th data-field="nCantidad" data-sortable="true">Cantidad</th>
                                                                    <th data-field="dFechaCreacion"  data-sortable="true">Fecha creacion</th>
                                                                    <th data-field="nTotal"          data-sortable="true">Total</th>
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
                    </div>


                </div>

                <?php extend_view(['admin/common/descripcion-empresa'], $data) ?>
            </main>
        </div>
    </div>



    <!-- Modales -->

    <!--Filtro para el reporte General -->
    <div class="modal fade" id="formFilterG" tabindex="-1" role="dialog" aria-labelledby="formFilterGLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formFilterGLabel">Filtros</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryIdPedido" class="col-form-label">Cod.Pedido</label>
                                    <select class="form-control" name="aryIdPedido" id="aryIdPedido" multiple>
                                        <option value="">TODOS</option>
                                        <?php if (fncValidateArray($aryPedidos)) : ?>
                                            <?php foreach ($aryPedidos as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdPedido"] ?>"><?=  $aryLoop["sNumero"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryClientes" class="col-form-label">Clientes</label>
                                    <select class="form-control" name="aryClientes" id="aryClientes" multiple>
                                        <option value="">TODOS</option>
                                        <?php if (fncValidateArray($aryClientes)) : ?>
                                            <?php foreach ($aryClientes as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdCliente"] ?>"><?= strup($aryLoop["sNombreoRazonSocial"])  ?></option>
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

    <!--Filtro para el reporte Detallado -->
    <div class="modal fade" id="formFilterD" tabindex="-1" role="dialog" aria-labelledby="formFilterDLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formFilterDLabel">Filtros</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryIdPedidoD" class="col-form-label">Cod.Pedido</label>
                                    <select class="form-control" name="aryIdPedidoD" id="aryIdPedidoD" multiple>
                                        <option value="">TODOS</option>
                                        <?php if (fncValidateArray($aryPedidos)) : ?>
                                            <?php foreach ($aryPedidos as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdPedido"] ?>"><?=  $aryLoop["sNumero"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryClientesD" class="col-form-label">Clientes</label>
                                    <select class="form-control" name="aryClientesD" id="aryClientesD" multiple>
                                        <option value="">TODOS</option>
                                        <?php if (fncValidateArray($aryClientes)) : ?>
                                            <?php foreach ($aryClientes as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdCliente"] ?>"><?= strup($aryLoop["sNombreoRazonSocial"])  ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="aryProductosD" class="col-form-label">Productos</label>
                                    <select class="form-control" name="aryProductosD" id="aryProductosD" multiple>
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
                                   <label for="dFechaInicioD" class="col-form-label">Desde:</label>
                                   <input type="text" class="form-control datepicker" id="dFechaInicioD" autocomplete="off" name="dFechaInicioD">
                               </div>
                           </div>


                           <div class="col-12 col-md-6">
                               <div class="form-group">
                                   <label for="dFechaFinD" class="col-form-label">Hasta:</label>
                                   <input type="text" class="form-control datepicker" id="dFechaFinD" autocomplete="off" name="dFechaFinD">
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

 

<!-- R.General -->
<script>

   window.jsnDataRG = null ;

    $(function() {

        // fncOcultarAside();
        // fncValidarRol();


        $("#aryIdPedido,#aryProductos,#aryClientes,#aryMetodoPago,#aryEstadoPago,#aryMetodoEnvio,#aryEstadoEnvio").select2({
            placeholder: "TODOS"
        });

        $("#formFilterG").find("form").on('submit', function(event) {
            event.preventDefault();

            var aryIdPedido    = $("#aryIdPedido :selected").map(function(nIndex, item) {return $(item).val();}).get();
            var aryProductos   = $("#aryProductos :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var aryClientes    = $("#aryClientes :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var dFechaInicio   = $('#dFechaInicio').val();
            var dFechaFin      = $('#dFechaFin').val();

            var aryMetodoPago   = $("#aryMetodoPago :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var aryEstadoPago   = $("#aryEstadoPago :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var aryMetodoEnvio  = $("#aryMetodoEnvio :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var aryEstadoEnvio  = $("#aryEstadoEnvio :selected").map(function(nIndex, item) { return $(item).val();}).get();

            window.jsnDataRG  = {
                nTipoReporte    : 1 , // General
                aryIdPedido     : aryIdPedido,
                aryProductos    : aryProductos,
                aryClientes     : aryClientes,
                dFechaInicio    : dFechaInicio,
                dFechaFin       : dFechaFin,
                aryMetodoPago   : aryMetodoPago,
                aryEstadoPago   : aryEstadoPago,
                aryMetodoEnvio  : aryMetodoEnvio,
                aryEstadoEnvio  : aryEstadoEnvio,
            };

            // console.log(jsnData);
            // return;

            fncPopulate(window.jsnDataRG , function(aryData) {
                bFilterTable  = true;
                
                $("#sTituloG").html(aryData.sTitulo);
                $("#tableGeneral").bootstrapTable("load",aryData.aryRowForDT);
                $("#formFilterG").modal("hide");
            });

        });

        $("#r-general-tab").on("click",function(){
            $("#dFechaInicio").val(  moment().format("DD/MM/YYYY") );
            $("#dFechaFin").val( moment().format("DD/MM/YYYY") );
            $("#formFilterG").find("form").trigger("submit");
        });

        $("#btnExportExcelRG").click(function(){
            if( $("#tableGeneral").bootstrapTable("getData").length > 0 ){
                fncExportarExcel( window.jsnDataRG , (aryData) => {

                    if(aryData.success){

                        Object.assign(document.createElement('a'), { target: '_blank', href: aryData.sUrl }).click();

                        toastr.success(aryData.success);
                    
                    } else {
                        toastr.error(aryData.error);
                    }
                    
                });
            } else {
                toastr.info("No existe data para poder exportar");
            }
        });

        $("#r-general-tab").trigger("click");

        $("#btnFilterG").on("click",function(){
            fncClearFilterM();
            $("#formFilterG").modal("show");
        });


    });

    function fncLabelFooter() {
        return 'Total Ventas';
    }

    function fncTotalFooter(data) {
    
        var nTotal = 0; 
         if(data.length  > 0 ){
            data.forEach(element => {
               nTotal += parseFloat (element.nTotal);
            });
        }

        return nTotal.toFixed(2);
    }


    window.fncClearFilterM = () => {
        
        $("#aryIdPedido,#aryProductos,#aryClientes").val([]).trigger("change");
        $("#nFacturado").val("");
        $("#dFechaInicio,#dFechaFin").val("");
 
    }

    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            // no es admin
        }
    }


    // Llamadas al servidor
    function fncPopulate(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncObtenerDataReporte',
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

    function fncExportarExcel(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncExportarExcel',
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
<!-- R.General -->


 

<!-- R.Detalle -->
<script>

    window.jsnDataD = null;
  
    $(function() {


        $("#aryIdPedidoD,#aryProductosD,#aryClientesD").select2({
            placeholder: "TODOS"
        });

        $("#formFilterD").find("form").on('submit', function(event) {
            event.preventDefault();

            var aryIdPedido    = $("#aryIdPedidoD :selected").map(function(nIndex, item) {return $(item).val();}).get();
            var aryProductos   = $("#aryProductosD :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var aryClientes    = $("#aryClientes :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var dFechaInicio   = $('#dFechaInicioD').val();
            var dFechaFin      = $('#dFechaFinD').val();
         
            window.jsnDataD = {
                nTipoReporte    : 2 , // Detalle
                aryIdPedido     : aryIdPedido,
                aryProductos    : aryProductos,
                aryClientes     : aryClientes,
                dFechaInicio    : dFechaInicio,
                dFechaFin       : dFechaFin
            };

            fncPopulate( window.jsnDataD , function(aryData) {          
                $("#sTituloD").html(aryData.sTitulo);
                $("#tableDetalle").bootstrapTable("load",aryData.aryData);
                $("#formFilterD").modal("hide"); 
            });

        });

        $("#r-detallado-tab").on("click",function(){
            $('#dFechaInicioD').val( moment().format("DD/MM/YYYY") );
            $('#dFechaFinD').val( moment().format("DD/MM/YYYY") );
            $("#formFilterD").find("form").trigger("submit");
        });

 
        $("#btnExportExcelD").click(function(){
            if( $("#tableDetalle").bootstrapTable("getData").length > 0 ){
                fncExportarExcel( window.jsnDataD , (aryData) => {

                    if(aryData.success){

                        Object.assign(document.createElement('a'), { target: '_blank', href: aryData.sUrl }).click();

                        toastr.success(aryData.success);
                    
                    } else {
                        toastr.error(aryData.error);
                    }
                    
                });
            } else {
                toastr.info("No existe data para poder exportar");
            }
        });

        $("#btnFilterD").on("click",function(){
            $("#formFilterD").modal("show");
            fncClearFilterD();
        });

    });

    window.fncClearFilterD = () => {
        
        $("#aryIdPedidoD,#aryProductosD,#aryClientesD").val([]).trigger("change");
        $("#dFechaInicioD,#dFechaFinD").val("");

    }
</script>
<!-- R.Detalle -->


</html>