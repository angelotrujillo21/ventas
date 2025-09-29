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
                                                        <button id="btnCrearFAP" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblPrincipal" data-url="<?= route('fap/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sDescripcion" data-sortable="true">Descripcion</th>
                                                            <th data-field="nValorInicial" data-sortable="true">Valor Inicial</th>
                                                            <th data-field="nValorFinal" data-sortable="true">Valor Final</th>
                                                            <th data-field="nPorcentaje" data-sortable="true">Porcentaje</th>
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

    <div class="modal fade" id="formCEFAP" tabindex="-1" role="dialog" aria-labelledby="formCEFAPLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEFAPLabel">Nuevo Item</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                              

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                     <label for="sDescripcion" class="col-form-label">Descripcion</label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDescripcion" id="sDescripcion">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="nValorInicial" class="col-form-label">Valor inicial</label>
                                     <input type="number" autocomplete="off" placeholder="" min="0.00" max="9999999.999999"  lang="en" step="0.000001" class="form-control" name="nValorInicial" id="nValorInicial">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="nValorFinal" class="col-form-label">Valor final</label>
                                     <input type="number" autocomplete="off" placeholder="" min="0.00" max="9999999.999999"  lang="en" step="0.000001" class="form-control" name="nValorFinal" id="nValorFinal">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="nPorcentaje" class="col-form-label">Porcentaje</label>
                                     <input type="number" autocomplete="off" placeholder="" min="0.00" max="9999999.999999"  lang="en" step="0.000001" class="form-control" name="nPorcentaje" id="nPorcentaje">
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
        $("#btnCrearFAP").on('click', function() {
            fncCleanAll();
            $("#formCEFAP").find(".modal-title").html('Nuevo Item');
            $("#formCEFAP").data("nIdRegistro",0);
            $("#formCEFAP").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCEFAP").find("form").on('submit',function(event){
           
             event.preventDefault();

            var nIdRegistro        = $("#formCEFAP").data("nIdRegistro");
            var sDescripcion       = $("#sDescripcion").val();
            var nValorInicial      = $("#nValorInicial").val();
            var nValorFinal        = $("#nValorFinal").val();
            var nPorcentaje        = $("#nPorcentaje").val();
            var nEstado            = $("#nEstado").val();

             
            if(nValorInicial == '' || parseFloat(nValorInicial) <= 0.00){
                toastr.error('Error. Ingrese un valor inicial para el item. Porfavor verifique');
                return;
            } 

            if(nValorFinal == '' || parseFloat(nValorFinal) <= 0.00){
                toastr.error('Error. Ingrese un valor final para el item. Porfavor verifique');
                return;
            } 

            if(nPorcentaje == '' || parseFloat(nPorcentaje) <= 0.00){
                toastr.error('Error. Ingrese un porcentaje para el item. Porfavor verifique');
                return;
            } 

            if( parseFloat(nValorInicial) >= parseFloat(nValorFinal) ){

                toastr.error('Error. El valor inicial no puede ser mayor o igual al valor inicial. Porfavor verifique');
                return;
            }

             var jsnData = {
                nIdRegistro     :  nIdRegistro,
                sDescripcion    :  sDescripcion,
                nValorInicial   :  nValorInicial,
                nValorFinal     :  nValorFinal,
                nPorcentaje     :  nPorcentaje,
                nEstado         :  nEstado,
             };

             fncGrabarFAP(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCEFAP").modal("hide");
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
            $("#btnCrearFAP").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarFAP(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             

            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarFAP( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblPrincipal").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });
 
    }

    function fncMostrarFAP(nIdRegistro , sOpcion ) {

        $( "#formCEFAP" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroFAP(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#sDescripcion").val(aryData.sDescripcion);
                    $("#nValorInicial").val(aryData.nValorInicial);
                    $("#nValorFinal").val(aryData.nValorFinal);
                    $("#nPorcentaje").val(aryData.nPorcentaje);
                    $("#nEstado").val(aryData.nEstado);

                    if(sOpcion == 'editar'){
                        fncEditForm("#formCEFAP" , "Editar Item");
                    } else {
                        fncViewForm("#formCEFAP" , "Ver Item");
                    }


                    $("#formCEFAP").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCEFAP").find("form") );
        fncClearInputs( $("#formCEFAP").find("form") );
     }

   

    // Llamadas al servidor


    // Cliente 

    function fncGrabarFAP(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'fap/fncGrabarFAP',
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

    function fncBuscarRegistroFAP(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'fap/fncMostrarRegistro',
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

    function fncEjecutarEliminarFAP( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'fap/fncEliminarRegistro',
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