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
                                                <table data-toggle="table" id="table" data-export-footer="true" data-show-footer="true" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sEmpleado" data-sortable="true">Empleado </th>
                                                            <th data-field="dFechaInicio" data-sortable="true">Fecha inicio </th>
                                                            <th data-field="dFechaFin" data-sortable="true">Fecha fin </th>
                                                            <th data-field="nTotalVenta" data-sortable="true">Total de venta </th>
                                                            <th data-field="nPorcentajeComision" data-sortable="true">Comision % </th>
                                                            <th data-field="nComision" data-sortable="true">Importe </th>
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

                               <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="aryIdEmpleado" class="col-form-label">Empleado</label>
                                        <select class="form-control" name="aryIdEmpleado" id="aryIdEmpleado" multiple>
                                            <?php if (fncValidateArray($aryEmpleados)) : ?>
                                                <?php foreach ($aryEmpleados as $aryLoop) : ?>
                                                    <option value="<?= $aryLoop["nIdEmpleado"] ?>"><?= $aryLoop["sNombre"] ?></option>
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
 

 


<!-- Filtros Mantenimiento -->
<script>
    $(function() {

        $("#aryIdEmpleado").select2({
            placeholder: "TODOS"
        });

        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();

            var aryIdEmpleado    = $("#aryIdEmpleado").val().length > 0 ? $("#aryIdEmpleado :selected").map(function(nIndex, item) {return $(item).val();}).get() : $("#aryIdEmpleado option").map(function(nIndex, item) {return $(item).val();}).get();
            var dFechaInicio     = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin        = $('#dFechaFin').datepicker('getDate');
 

            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de inicio y fin. Por favor verificar.');
                return;
            }

            if( $("#dFechaInicio").val() == ''){
                toastr.error('Error.Debe de ingresar una fecha de inicio. Por favor verificar.');
                return;
            }

            if( $("#dFechaFin").val() == ''){
                toastr.error('Error.Debe de ingresar una fecha fin. Por favor verificar.');
                return;
            }


            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }

            var jsnData = {
                aryIdEmpleado   : aryIdEmpleado,
                dFechaInicio    : $('#dFechaInicio').val(),
                dFechaFin       : $('#dFechaFin').val(),
            };

            fncPopulateReporteComision(jsnData, function(aryData) {
                bFilterTable  = true;
                $("#formFilter").modal("hide");
                $("#table").bootstrapTable("load", aryData);
            });

        });

        $("#btnFiltrarPedido").on("click",function(){
            $("#formFilter").modal("show");
        });


    });

    window.fncClearFilterM = () => {
        
        $("#aryIdEmpleado").val([]).trigger("change");
        $("#dFechaInicio,#dFechaFin").val("");
 
    }

    // Llamadas al servidor
    function fncPopulateReporteComision(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncPopulateReporteComision',
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


 
</html>