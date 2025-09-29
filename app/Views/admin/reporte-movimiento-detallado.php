<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin="<?=$nAdmin?>" 
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
                                            <div class="col-md-12 sin-padding container-buttons-table">
                                                <button id="btnFilter" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-export-footer="true" data-show-footer="true" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="false" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="1000" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                        
                                                            <th data-field="dFecha" data-sortable="true">Fecha</th>
                                                            <th data-field="sCodigoInterno" data-sortable="true">Codgo</th>
                                                            <th data-field="sProducto" data-sortable="true">Producto</th>
                                                            <th data-field="nEntradas" data-sortable="true">Entrada</th>
                                                            <th data-field="nSalidas" data-sortable="true">Salida</th>
                                                            <th data-field="sUnidadMedida" data-sortable="true">Unidad Medida</th>
                                                            <th data-field="sUbicacion"  data-sortable="true">Ubicacion </th>
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3"> <span> TOTAL MOVIMIENTOS </span></td>
                                                            <td> <span id="sEntradas"></span> </td>
                                                            <td> <span id="sSalidas"></span> </td>
                                                            <td colspan="2">  </td>
                                                        </tr>
                                                     
                                                    </tfoot>
                                                </table>
                                            </div>

                                            <div class="col-12" style="font-size: 13px; font-weight: bold;">
                                                <span style="padding-left: 7px;">  STOCK  </span>  <span id="sStockActual"></span>
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
                                   <label for="nIdProducto" class="col-form-label">Productos</label>
                                   <select class="form-control" name="nIdProducto" id="nIdProducto">
                                       <option value="">TODOS</option>
                                       <?php if (fncValidateArray($aryProductosFilter)) : ?>
                                           <?php foreach ($aryProductosFilter as $aryLoop) : ?>
                                               <option value="<?= $aryLoop["nIdProducto"] ?>"><?= strup($aryLoop["sDescripcion"]) . "-" . $aryLoop["sUnidadMedidaCorto"]  ?></option>
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


 
 

<!-- Filtros  -->
<script>
    $(function() {

        $("#nIdProducto").select2({
            placeholder: "SELECCIONAR"
        });

        $("#formFilter").find("form").on('submit', function(event) {
            event.preventDefault();

            var nIdProducto        = $("#nIdProducto").val();
            var dFechaInicio       = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin          = $('#dFechaFin').datepicker('getDate');

            if(nIdProducto == "" || nIdProducto == 0){
                toastr.error('Error.Debe de seleccionar un producto. Por favor verificar.');
                return;
            }
            
            if ($('#dFechaInicio').val() == "") {
                toastr.error('Error.Debe de ingresar una fecha de inicio. Por favor verificar.');
                return;
            }

            
            if ($('#dFechaFin').val()  == "") {
                toastr.error('Error.Debe de ingresar una fecha de fin. Por favor verificar.');
                return;
            }

            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de inicio y fin. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }

            var jsnData = {
                nIdProducto     : nIdProducto,
                dFechaInicio    : $('#dFechaInicio').val(),
                dFechaFin       : $('#dFechaFin').val(),
            };

            fncPopulateReporteMovimientosDetallado(jsnData, function(aryData) {
                bFilterTable  = true;
                $("#table").bootstrapTable("load", aryData.aryRows);

                $("#sEntradas").html(aryData.aryTotales.nTotalEntradas);
                $("#sSalidas").html(aryData.aryTotales.nTotalSalidas);
                $("#sStockActual").html(aryData.aryTotales.nStockActual);

                $("#formFilter").modal("hide");
            });

        });

        $('#table').on('refresh.bs.table', function (params) {
            
            window.bFilterTable = false;

            fncClearFilterM();
            fncLoadFilterDefault();
         

        });

        $("#btnFilter").on("click",function(){
            $("#formFilter").modal("show");
        });

        fncLoadFilterDefault();
    });


 

    window.fncClearFilterM = () => {
        
        $("#nIdProducto").val([]).trigger("change");
        $("#dFechaInicio,#dFechaFin").val("");
 
    }

    window.fncLoadFilterDefault = () => {
        
   
    }


    // Llamadas al servidor
    function fncPopulateReporteMovimientosDetallado(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'movimientos/fncPopulateReporteMovimientosDetallado',
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
<!-- Filtros -->


 
</html>