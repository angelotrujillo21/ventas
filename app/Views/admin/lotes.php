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
                                                        <button id="btnCrearLote" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblPrincipal" data-url="<?= route('lotes/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                            <th data-field="sCodigo" data-sortable="true">Codigo</th>
                                                            <th data-field="sDescripcion" data-sortable="true">Descripcion</th>
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

    <div class="modal fade" id="formCELote" tabindex="-1" role="dialog" aria-labelledby="formCELoteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCELoteLabel">Nuevo Lote</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                             

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="sNombre" class="col-form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombre" id="sNombre">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sCodigo" class="col-form-label">Codigo  </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCodigo" id="sCodigo">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="sDescripcion" class="col-form-label">Descripcion</label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDescripcion" id="sDescripcion">
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
        $("#btnCrearLote").on('click', function() {
            fncCleanAll();
            $("#formCELote").find(".modal-title").html('Nuevo Lote');
            $("#formCELote").data("nIdRegistro",0);
            $("#formCELote").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCELote").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro        = $("#formCELote").data("nIdRegistro");
             var sNombre            = $("#sNombre").val();
             var sDescripcion       = $("#sDescripcion").val();
             var sCodigo            = $("#sCodigo").val();
             var nEstado            = $("#nEstado").val();

             
             if (sNombre== '') {
                 toastr.error('Error. Ingrese un nombre para el lote. Porfavor verifique');
                 return;
             } 

             var jsnData = {
                 nIdRegistro        : nIdRegistro,
                 sNombre            : sNombre,
                 sDescripcion       : sDescripcion,
                 sCodigo            : sCodigo,
                 nEstado            : nEstado ,
             };

             fncGrabarLote(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCELote").modal("hide");
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
            $("#btnCrearLote").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarLote(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             

            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarLote( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblPrincipal").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });
 
    }

    function fncMostrarLote(nIdRegistro , sOpcion ) {

        $( "#formCELote" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroLote(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#sNombre").val(aryData.sNombre);
                    $("#sDescripcion").val(aryData.sDescripcion);
                    $("#sCodigo").val(aryData.sCodigo);
                    $("#nEstado").val(aryData.nEstado);


                    if(sOpcion == 'editar'){
                        fncEditForm("#formCELote" , "Editar Lote");
                    } else {
                        fncViewForm("#formCELote" , "Ver Lote");
                    }


                    $("#formCELote").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCELote").find("form") );
        fncClearInputs( $("#formCELote").find("form") );
     }

   

    // Llamadas al servidor


    // Cliente 

    function fncGrabarLote(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'lotes/fncGrabarLote',
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

    function fncBuscarRegistroLote(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'lotes/fncMostrarRegistro',
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

    function fncEjecutarEliminarLote( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'lotes/fncEliminarRegistro',
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