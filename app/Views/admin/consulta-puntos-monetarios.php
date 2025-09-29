<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin = "<?=$nAdmin?>">

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
                                            </div> 
                                        </div>

                        
                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('canjepuntos/fncPopulatePuntosMontarios') ?>" data-show-export="true" data-export-footer="true"  data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-show-footer="true"  data-sort-order="asc">
                                                    <thead>
                                                       
                                                        <tr>
                                                            <th data-field="sCliente" data-sortable="true">Cliente</th>
                                                            <th data-field="nCantidadVentas" data-sortable="true" title="Cantidad de ventas que se canjearon los puntos">Cantidad de ventas</th>
                                                            <th data-field="nPuntosCanje" data-sortable="true">Puntos Canjeados</th>
                                                            <th data-field="nDescuentoCanje" data-sortable="true">Valor Monetario</th>
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
                                    <label for="nIdClienteFilter" class="col-form-label">Clientes:</label>
                                    <select class="form-control" name="nIdClienteFilter[]" id="nIdClienteFilter" multiple>
                                        <?php if(fncValidateArray($aryClientes)): ?>
                                            <?php foreach($aryClientes as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdCliente"] ?>"><?= sp( $aryLoop["sNombreoRazonSocial"] ) ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                                            
                           

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTienePuntosCanje" class="col-form-label">¿Solo con Puntos Monetarios?</label>
                                    <select class="form-control" name="nTienePuntosCanje" id="nTienePuntosCanje">
                                        <option value="1">Si </option>
                                        <option value="0">No</option>
                                    </select>
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

<!-- Compras -->
<script>
    window.bFilterTable  = false;
    window.jsnDataFiltro = {};
    
    $(function() {


  
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


 <!--  Filtros --> 
<script>

    $(function() {
        
 
        $("#nIdClienteFilter").select2({
            placeholder:"TODOS"
        });

     

        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();
            
            var aryClientes             = $("#nIdClienteFilter :selected").map(function(nIndex, item) { return $(item).val(); }).get();
            var nTienePuntosCanje       = $('#nTienePuntosCanje').val();

        
            window.jsnDataFiltro  = {
                aryClientes              : aryClientes,
                nTienePuntosCanje   : nTienePuntosCanje
            };


            fncPopulatePuntosMontarios( window.jsnDataFiltro ,function(aryData){
               
              $('#table').bootstrapTable('load',aryData);
              $("#formFilter").modal("hide");
              bFilterTable = true;
            });    

        });

  
        $("#btnFilter").on("click",function(){
            $("#formFilter").modal("show");
        });

    });

    function fncClearFilter(){
        fncClearInputs($("#formFilter").find("form"));
        $("#nIdClienteFilter").val([]).trigger("change");
    }


  

    // Llamadas al servidor
    function fncPopulatePuntosMontarios(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'canjepuntos/fncPopulatePuntosMontarios',
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