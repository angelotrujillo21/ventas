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
                                                        <button id="btnCrearCaja" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblPrincipal" data-url="<?= route('cajas/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sEmpleado" data-sortable="true">Empleado</th>
                                                            <th data-field="sDescripcion" data-sortable="true">Descripcion</th>
                                                            <th data-field="sDetalle" data-sortable="true">Detalle</th>
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

    <div class="modal fade" id="formCECaja" tabindex="-1" role="dialog" aria-labelledby="formCELoteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCELoteLabel">Nuevo Caja</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                             

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="sDescripcion" class="col-form-label">Descripcion <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDescripcion" id="sDescripcion">
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="nIdEmpleado" class="col-form-label">Empleado <span class="text-danger">*</span></label>
                                     <select class="form-control" name="nIdEmpleado" id="nIdEmpleado">
                                        <option value="0">Seleccionar</option>
                                        <?php if(fncValidateArray($aryEmpleados)) : ?>
                                            <?php foreach ($aryEmpleados as $nKey => $aryItem) : ?>
                                                <option value="<?=$aryItem["nIdEmpleado"]?>"><?=$aryItem["sNombre"]?></option>
                                            <?php endforeach  ?>
                                        <?php  endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sDetalle" class="col-form-label">Detalle </label>
                                    <textarea autocomplete="off" placeholder="" class="form-control" name="sDetalle" id="sDetalle"></textarea>
                                </div>
                            </div>

                         
            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstado" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstado" id="nEstado">
                                        <option value="1">ACTIVO</option>
                                        <option value="0">DESACTIVO</option>
                                    </select>
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

<script>
    $(function() {

        fncValidarRol();

        // Formulario Clientes
        $("#btnCrearCaja").on('click', function() {
            fncCleanAll();
            $("#formCECaja").find(".modal-title").html('Nueva Caja');
            $("#formCECaja").data("nIdRegistro",0);
            $("#formCECaja").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCECaja").find("form").on('submit',function(event){
           
             event.preventDefault();

            var nIdRegistro        = $("#formCECaja").data("nIdRegistro");
            var sDescripcion       = $("#sDescripcion").val();
            var nIdEmpleado        = $("#nIdEmpleado").val();
            var sDetalle           = $("#sDetalle").val();
            var nEstado           = $("#nEstado").val();

             
            if (sDescripcion == '') {
                toastr.error('Error. Ingrese una descripcion para la caja . Porfavor verifique');
                return;
            } else if (nIdEmpleado == '0') {
                toastr.error('Error.Seleccione un empleado. Porfavor verifique');
                return;
            } 

             var jsnData = {
                 nIdRegistro        : nIdRegistro,
                 sDescripcion       : sDescripcion,
                 nIdEmpleado        : nIdEmpleado,
                 sDetalle           : sDetalle,
                 nEstado            : nEstado ,
             };

             fncGrabarCaja(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCECaja").modal("hide");
                     $("#tblPrincipal").bootstrapTable('refresh');
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
             });

        });
    });


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            $("#btnCrearCaja").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarCaja(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             

            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarCaja( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblPrincipal").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });
 
    }

    function fncMostrarCaja(nIdRegistro , sOpcion ) {

        $( "#formCECaja" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroCaja(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#sDescripcion").val(aryData.sDescripcion);
                    $("#nIdEmpleado").val(aryData.nIdEmpleado);
                    $("#sDetalle").val(aryData.sDetalle);
                    $("#nEstado").val(aryData.nEstado);


                    if(sOpcion == 'editar'){
                        fncEditForm("#formCECaja" , "Editar Caja");
                    } else {
                        fncViewForm("#formCECaja" , "Ver Caja");
                    }


                    $("#formCECaja").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCECaja").find("form") );
        fncClearInputs( $("#formCECaja").find("form") );
     }

   

    // Llamadas al servidor


    // Cliente 

    function fncGrabarCaja(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cajas/fncGrabarRegistro',
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

    function fncBuscarRegistroCaja(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'cajas/fncMostrarRegistro',
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

    function fncEjecutarEliminarCaja( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'cajas/fncEliminarRegistro',
            data: jsnData,
            dataType: 'json',
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function( data ) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }

        });
    }
</script>


</html>