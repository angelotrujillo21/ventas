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
                                                        <button id="btnCrearCC" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblPrincipal" data-url="<?= route('cuentascorrientes/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sPropietario" data-sortable="true">Propietario</th>
                                                            <th data-field="sBanco" data-sortable="true">Banco</th>
                                                            <th data-field="sTipoCuenta" data-sortable="true">Tipo Cuenta</th>
                                                            <th data-field="sNumero" data-sortable="true">Numero</th>
                                                            <th data-field="nSaldoActual" data-sortable="true">Saldo Actual</th>
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

    <div class="modal fade" id="formCECC" tabindex="-1" role="dialog" aria-labelledby="formCELCCLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCELCCLabel">Nuevo Cuebta Corriente</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                        
                            <div class="col-12 col-md-12"> 
                                <div class="form-group"> 
                                    <label for="sPropietario" class="col-form-label">Propietario <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sPropietario" id="sPropietario">
                                </div>
                            </div>

                             
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdBanco" class="col-form-label">Banco <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdBanco" id="nIdBanco">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryBancos)): ?>
                                            <?php foreach($aryBancos as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdBanco"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                     </select>
                                </div>
                            </div>

                              
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdTipoCuenta" class="col-form-label">Tipo de cuenta <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nIdTipoCuenta" id="nIdTipoCuenta">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoCuentas)): ?>
                                            <?php foreach($aryTipoCuentas as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdTipoCuenta"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                     </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="sNumero" class="col-form-label">Numero <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="XXXX-XXXXX-XXXX-XXXX" class="form-control" name="sNumero" id="sNumero">
                                </div>
                            </div>

                            
                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="nSaldoActual" class="col-form-label">Saldo Actual <span class="text-danger">*</span></label>
                                    <input type="number" min="0.00" max="9999999.99" step="0.01" value="0.00" autocomplete="off" class="form-control" name="nSaldoActual" id="nSaldoActual">
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
        $("#btnCrearCC").on('click', function() {
            fncCleanAll();
            $("#nSaldoActual").prop("readonly",false);
            $("#formCECC").find(".modal-title").html('Nueva cuenta corriente');
            $("#formCECC").data("nIdRegistro",0);
            $("#sPropietario").val('<?=$arySede["sNombreEmpresa"]?>');
            $("#formCECC").modal("show");
        });

        // Submit del formulario de banco
        $("#formCECC").find("form").on('submit',function(event){
           
            event.preventDefault();
            
            var nIdRegistro      = $("#formCECC").data("nIdRegistro");
            var sPropietario     = $("#sPropietario").val();
            var nIdBanco         = $("#nIdBanco").val();
            var nIdTipoCuenta    = $("#nIdTipoCuenta").val();
            var sNumero          = $("#sNumero").val().trim().toUpperCase();
            var nSaldoActual     = $("#nSaldoActual").val();
            var nEstado          = $("#nEstado").val();

            if(sPropietario == ''){
                toastr.error('Error. Debe de ingresar un nombre del propietario de la cuenta.Porfavor verifique');
                return false;
            }

            if(nIdBanco == '0'){
                toastr.error('Error. Debe de seleccionar un banco.Porfavor verifique');
                return false;
            }

            if(nIdTipoCuenta == '0'){
                toastr.error('Error. Debe de seleccionar un tipo de cuenta.Porfavor verifique');
                return false;
            } 

            if(sNumero == ''){
                toastr.error('Error. Debe de ingresar un numero de cuenta corriente.Porfavor verifique');
                return false;
            }

            if( isNaN(nSaldoActual) || nSaldoActual < 0 ){
                toastr.error('Error. El saldo actual debe ser ingresado correctamente o mayor a cero .Porfavor verifique');
                return false;
            }
            
            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdBanco', nIdBanco);
            formData.append('sPropietario', sPropietario);
            formData.append('nIdTipoCuenta',nIdTipoCuenta);
            formData.append('sNumero',sNumero);
            formData.append('nSaldoActual',nSaldoActual);
            formData.append('nEstado', nEstado );
 
            fncGrabarCC(formData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formCECC").modal("hide");
                    $('#tblPrincipal').bootstrapTable('refresh');
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
            $("#btnCrearCC").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarCC(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarCC( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblPrincipal").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });
 
    }

    function fncMostrarCC(nIdRegistro , sOpcion ) {

        $( "#formCECC" ).data("nIdRegistro",nIdRegistro);
        $("#nSaldoActual").prop("readonly",true);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroCC(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;
                    
                    $("#sPropietario").val(aryData.sPropietario);
                    $("#nIdBanco").val(aryData.nIdBanco);
                    $("#nIdTipoCuenta").val(aryData.nIdTipoCuenta);
                    $("#sNumero").val(aryData.sNumero);
                    $("#nSaldoActual").val(aryData.nSaldoActual);
                    $("#nEstado").val(aryData.nEstado);


                    if(sOpcion == 'editar'){
                        fncEditForm("#formCECC" , "Editar Cuenta corriente");
                    } else {
                        fncViewForm("#formCECC" , "Ver Cuenta corriente");
                    }


                    $("#formCECC").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCECC").find("form") );
        fncClearInputs( $("#formCECC").find("form") );
    }

   

    
    // Llamadas al servidor
    function fncGrabarCC(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cuentascorrientes/fncGrabarCC',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
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

    function fncBuscarRegistroCC(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'cuentascorrientes/fncMostrarRegistro',
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

    function fncEjecutarEliminarCC( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'cuentascorrientes/fncEliminarRegistro',
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