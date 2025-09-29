<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body>

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
                                                <table data-toggle="table" id="table" data-url="<?= route('pedidos/fncPopulateAnulaciones') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNumero" data-sortable="true">Cod. Pedido</th>
                                                            <th data-field="sDespachado" data-sortable="true">Despachado</th>
                                                            <th data-field="sResponsable" data-sortable="true">Empleado</th>
                                                            <th data-field="sCliente" data-sortable="true">Cliente</th>
                                                            <th data-field="sFacturado" data-sortable="true">Facturado</th>
                                                            <th data-field="sDetalle" class="text-center" data-sortable="true">Detalle<br><span class="font-13">Producto | Precio x Cantidad</span></th>
                                                            <th data-field="nSubtotal" data-sortable="true">Subtotal</th>
                                                            <th data-field="nIgv" data-sortable="true">Igv</th>
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

   
 


    <!-- Fin de modales -->


    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>


<!-- Anulacion -->
<script>

    window.bFilterTable = false;
    
    $(function() {

 
    });

    
    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
        }
    }


    // Funciones de la tabla 

    window.fncCambiarEstado = function(nIdPedido,nNuevoEstado){

        var sMensaje = nNuevoEstado == 1 ? "¿Estas seguro de activar el pedido?" : "¿Estas seguro de anular el pedido ?";

        fncMsg(1,  sMensaje, 
        function(){
            var jsnData = {
                nIdRegistro  : nIdPedido,
                nEstado      : nNuevoEstado
            };

            fncEjecutarCambiarEstado(jsnData , (aryData) => {

                if(aryData.success){
                    
                    fncRefreshTable();

                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });
    }
 

  
 
    // Funciones Auxiliares

    window.fncRefreshTable = function(){
        if(bFilterTable){
            $("#formFilter").trigger("submit");
        } else {
            $("#table").bootstrapTable('refresh');
        }
    }
    

    // Llamadas al servidor
    function fncEjecutarCambiarEstado(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncPopulateReporteMotorizado',
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
<!-- Anulacion -->

 
 

</html>