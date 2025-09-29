<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin = "<?=$nAdmin?>"
      data-ntipoordencompra ="<?=$nTipoOrdenCompra?>"    
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
                                                <button id="btnFilter" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <button id="btnExportarExcel" class="btn btn-gradient-primary-table" type="button" title="Exportar Excel">
                                                    <i class="fas fa-file-excel"></i>
                                                </button>
                                            </div> 
                                        </div>

                                   
                                        
                                         
                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-show-export="true" data-export-footer="true"  data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-show-footer="true"  data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="8"> <div class="text-center" id="sTitulo"></div> </th>
                                                        </tr>
                                                        <tr>
                                                            <th data-field="sAcciones" data-sortable="true">Acciones</th>
                                                            <th data-field="nIdOrdenCompraFormat" data-sortable="true">Cod.Orden Compra</th>
                                                            <th data-field="sResponsable" data-sortable="true">Empleado</th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha</th>
                                                            <th data-field="sDescripcion" data-sortable="true">Descripcion</th>
                                                            <th data-field="sDetalle" data-sortable="true">Detalle</th>
                                                            <th data-field="sProcesado" data-footer-formatter="fncLabelFooter" data-sortable="true">Procesado</th>
                                                            <th data-field="nTotal" data-footer-formatter="fncTotalFooter" data-sortable="true">Total</th>
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
 
    <!-- Fin de modales -->




    <?php extend_view(['admin/common/footer'], $data) ?>

    
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

                           <div class="col-12 col-md-6">
                               <div class="form-group">
                                   <label for="nIdOrdenCompraFilter" class="col-form-label">Cod.Orden Compra:</label>
                                   <select class="form-control" name="nIdOrdenCompraFilter[]" id="nIdOrdenCompraFilter" multiple>
                                       <?php if(fncValidateArray($aryIdOC)): ?>
                                           <?php foreach($aryIdOC as $aryLoop):?>
                                               <option value="<?= $aryLoop ?>"><?= sp( $aryLoop ) ?></option>
                                           <?php endforeach?>
                                       <?php endif ?>
                                   </select>
                               </div>
                           </div>
                        
                           <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEjecutadoFilter" class="col-form-label">Ejecutado / Planificado</label>
                                    <select class="form-control" name="nEjecutadoFilter" id="nEjecutadoFilter">
                                        <option value="">TODOS</option>
                                        <option value="1">EJECUTADO</option>
                                        <option value="0">PLANIFICADO</option>
                                    </select>
                                </div>
                            </div>

                            
                           <div class="col-12 col-md-12">
                               <div class="form-group">
                                   <label for="nIdProductoFilter" class="col-form-label">Producto:</label>
                                   <select class="form-control" name="nIdProductoFilter[]" id="nIdProductoFilter" multiple>
                                       <?php if(fncValidateArray($aryProductos)): ?>
                                           <?php foreach($aryProductos as $aryProducto):?>
                                               <option value="<?= $aryProducto["nIdProducto"] ?>"><?= strup( $aryProducto["sDescripcion"] ) ?></option>
                                           <?php endforeach?>
                                       <?php endif ?>
                                   </select>
                               </div>
                           </div>



                           <div class="col-12 col-md-12">
                               <div class="form-group">
                                   <label for="nProcesadoFilter" class="col-form-label">Procesados</label>
                                   <select class="form-control" name="nProcesadoFilter" id="nProcesadoFilter">
                                       <option value="">TODOS</option>
                                       <option value="1">PROCESADOS</option>
                                       <option value="0">SIN PROCESAR</option>
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

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- Compras -->
<script>
    window.bFilterTable  = false;
    window.jsnDataFiltro = {};
    
    $(function() {


        window.fncOcultarAside();
 
        $('#table').on('refresh.bs.table', function (params) {
            window.bFilterTable = false;
            window.jsnDataFiltro = {};
            fncClearFilter();
        });


    
    });


     


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            $("#btnCrearCompra").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

  
 
    

</script>
<!-- Compras -->


<!-- Filtros -->
<script>
    $(function() {
        
 
        $("#nIdProductoFilter,#nIdOrdenCompraFilter").select2({
            placeholder:"TODOS"
        });

       
        $("#btnExportarExcel").on('click', function() {

            if($("#table").bootstrapTable("getData").length > 0 ){

                fncExportarExcel(window.jsnDataFiltro,function(aryData){
                    if(aryData.success){
                        Object.assign(document.createElement('a'), { target: '_blank', href: aryData.sUrl }).click();
                    } else {
                        toastr.error(aryData.error);
                    }
                });

            }
        });

        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();
            
            var aryProductos     = $("#nIdProductoFilter :selected").map(function(nIndex, item) { return $(item).val(); }).get();
            var aryIdsOC         = $("#nIdOrdenCompraFilter :selected").map(function(nIndex, item) { return $(item).val(); }).get();
            var dFechaInicio     = $('#dFechaInicio').val() ;
            var dFechaFin        = $('#dFechaFin').val() ;
            var nProcesado       = $('#nProcesadoFilter').val();
            var nEjecutado       = $('#nEjecutadoFilter').val();

            
            window.jsnDataFiltro  = {
                aryProductos     : aryProductos,
                aryIdsOC         : aryIdsOC,
                dFechaInicio     : dFechaInicio,
                dFechaFin        : dFechaFin,
                nProcesado       : nProcesado,
                nTipo            : $("body").data("ntipoordencompra"),
                nEjecutado       : nEjecutado
            };

            console.log(jsnDataFiltro);



            fncObtenerDataReporte( window.jsnDataFiltro ,function(aryData){
              $('#sTitulo').html(aryData.sTitulo);
              $('#table').bootstrapTable('load',aryData.aryData);
              $("#formFilter").modal("hide");
              bFilterTable = true;
            });    

        });
           
        $("#btnFilter").on("click",function(){
            fncClearFilter();
            $("#formFilter").modal("show");
        });


        fncPopulateFilter();

    });

    function fncPopulateFilter (){
        //  Cargar por default las oc de hoy 
        $( "#dFechaInicio" ).val(  moment().format("DD/MM/YYYY")  );
        $( "#dFechaFin" ).val(  moment().format("DD/MM/YYYY")  );
        $("#formFilter").find("form").trigger("submit");
    }

    function fncClearFilter(){
        fncClearInputs($("#formFilter").find("form"));
        $("#nIdProductoFilter").val([]).trigger("change");
        $("#nIdOrdenCompraFilter").val([]).trigger("change");
        $('#nProcesadoFilter').val("");
    }


    function fncLabelFooter() {
        return 'Total Orden de compra';
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

    // Llamadas al servidor
    function fncObtenerDataReporte(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ordenCompra/fncObtenerDataReporte',
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

    function fncExportarExcel(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ordenCompra/fncExportarExcel',
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