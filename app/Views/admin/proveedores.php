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
                                                        <button id="btnCrearProveedor" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblProveedores" data-url="<?= route('proveedores/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="nTipoDocumento" data-sortable="true">Tipo Documento</th>
                                                            <th data-field="sNumeroDocumento" data-sortable="true">Numero de documento</th>
                                                            <th data-field="sNombreoRazonSocial" data-sortable="true">Nombre o Razon Social</th>
                                                            <th data-field="sCorreo" data-sortable="true">Correo</th>
                                                            <th data-field="nIdDepartamento" data-sortable="true">Departamento</th>
                                                            <th data-field="nIdProvincia" data-sortable="true">Provincia</th>
                                                            <th data-field="nIdDistrito" data-sortable="true">Distrito</th>
                                                            <th data-field="sDireccion" data-sortable="true">Direccion</th>
                                                            <th data-field="sTelefono" data-sortable="true">Telefono</th>
                                                            <th data-field="nEstado" data-sortable="true">Estado</th>
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

    <div class="modal fade" id="formCEProveedor" tabindex="-1" role="dialog" aria-labelledby="formCEProveedorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEProveedorLabel">Nuevo Proveedor</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoDocumentoProve" class="col-form-label">Tipo Documento <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoDocumentoProve" id="nTipoDocumentoProve">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoDocumento)): ?>
                                            <?php foreach($aryTipoDocumento as $aryTipoDoc):?>
                                                <option value="<?= $aryTipoDoc["nIdCatalogoTabla"] ?>"><?= $aryTipoDoc["sDescripcionCortaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6"> 
                                <div class="form-group"> 
                                    <label for="sNumeroDocumentoProve" class="col-form-label">Numero de documento <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumentoProve" id="sNumeroDocumentoProve">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNombreoRazonSocialProve" class="col-form-label">Nombre o Razon Social <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreoRazonSocialProve" id="sNombreoRazonSocialProve">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="sCorreoProve" class="col-form-label">Correo</label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCorreoProve" id="sCorreoProve">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group"><label for="nIdDepartamentoProve" class="col-form-label">Departamento <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdDepartamentoProve" id="nIdDepartamentoProve">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryDepartamentos)): ?>
                                            <?php foreach($aryDepartamentos as $aryDepartamento):?>
                                                <option value="<?= $aryDepartamento["nIdDepartamento"] ?>"><?= $aryDepartamento["sNombre"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nIdProvinciaProve" class="col-form-label">Provincia <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdProvinciaProve" id="nIdProvinciaProve">
                                        <option value="0">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nIdDistritoProve" class="col-form-label">Distrito <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdDistritoProve" id="nIdDistritoProve">
                                        <option value="0">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sDireccionProve" class="col-form-label">Direccion </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDireccionProve" id="sDireccionProve">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sTelefonoProve" class="col-form-label">Telefono </label>
                                    <input type="tel" autocomplete="off" placeholder="" class="form-control" name="sTelefonoProve" id="sTelefonoProve">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstadoProve" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoProve" id="nEstadoProve">
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
        $("#btnCrearProveedor").on('click', function() {
            fncCleanAll();
            $("#formCEProveedor").find(".modal-title").html('Nuevo Proveedor');
            $("#formCEProveedor").data("nIdRegistro",0);
            $("#formCEProveedor").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCEProveedor").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro            = $("#formCEProveedor").data("nIdRegistro");
             var nTipoDocumento         = $("#nTipoDocumentoProve")
             var sNumeroDocumento       = $("#sNumeroDocumentoProve");
             var sNombreoRazonSocial    = $("#sNombreoRazonSocialProve");
             var sCorreo                = $("#sCorreoProve");
             var nIdDepartamento        = $("#nIdDepartamentoProve");
             var nIdProvincia           = $("#nIdProvinciaProve");
             var nIdDistrito            = $("#nIdDistritoProve");
             var nIdRelacionamiento     = $("#nIdRelacionamientoProve");
             var sTelefono              = $("#sTelefonoProve");
             var sDireccion             = $("#sDireccionProve");
             var nEstado                = $("#nEstadoProve");

             
             if (nTipoDocumento.length > 0 && nTipoDocumento.val() == '') {
                 toastr.error('Error. Seleccione un tipo de documento. Porfavor verifique');
                 return;
             } else if (sNumeroDocumento.length > 0 && sNumeroDocumento.val() == '') {
                 toastr.error('Error. Ingrese un numero de documento. Porfavor verifique');
                 return;
             } else if (sNombreoRazonSocial.length > 0 && sNombreoRazonSocial.val() == '') {
                 toastr.error('Error. Ingrese un nombre o razon social. Porfavor verifique');
                 return;
             }  /*else if (sCorreo.length > 0 && sCorreo.val() == '') {
                 toastr.error('Error. Ingrese un correo. Porfavor verifique');
                 return;
             }*/ else if (nIdDepartamento.length > 0 && nIdDepartamento.val() == '0') {
                 toastr.error('Error. Seleccione un departamento. Porfavor verifique');
                 return;
             } else if (nIdProvincia.length > 0 && nIdProvincia.val() == '0') {
                 toastr.error('Error. Seleccione una provincia. Porfavor verifique');
                 return;
             } else if (nIdDistrito.length > 0 && nIdDistrito.val() == '0') {
                 toastr.error('Error. Seleccione un distrito. Porfavor verifique');
                 return;
             }  

             var jsnData = {
                 nIdRegistro              : nIdRegistro,
                 nTipoDocumento           : nTipoDocumento.length > 0 ? nTipoDocumento.val() : null,
                 sNumeroDocumento         : sNumeroDocumento.length > 0 ? sNumeroDocumento.val() : null,
                 sNombreoRazonSocial      : sNombreoRazonSocial.length > 0 ? sNombreoRazonSocial.val() : null,
                 sCorreo                  : sCorreo.length > 0 ? sCorreo.val() : null,
                 nIdDepartamento          : nIdDepartamento.length > 0 ? nIdDepartamento.val() : null,
                 nIdProvincia             : nIdProvincia.length > 0 ? nIdProvincia.val() : null,
                 nIdDistrito              : nIdDistrito.length > 0 ? nIdDistrito.val() : null,
                 sTelefono                : sTelefono.length > 0 ? sTelefono.val() : null,
                 sDireccion               : sDireccion.length > 0 ? sDireccion.val() : null,
                 nEstado                  : nEstado.length > 0 ? nEstado.val() : null,
             };

             fncGrabarProveedor(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCEProveedor").modal("hide");
                     $("#tblProveedores").bootstrapTable('refresh');
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
             });

        });

        // Evento Dtp
        $("#nIdDepartamentoProve").on('change',function(){
          var jsnData = {
              nIdDepartamento : $(this).val()
          };

          fncDrawProvincia("#nIdProvinciaProve" , jsnData , null);
        });

        $("#nIdProvinciaProve").on('change',function(){
             var jsnData = {
                 nIdProvincia : $(this).val()
             };
             fncDrawDistrito("#nIdDistritoProve" , jsnData , null);
        });

        $("#nTipoDocumentoProve").change(function() {
             if( $(this).val() > 0 ) {
                 fncMaxLengthTypeDocument( $(this).find('option:selected').text().trim().toUpperCase() , "#sNumeroDocumentoProve" );
             }
        });

        $("#sNumeroDocumentoProve").on('keyup change',function(){
                    
            switch( $("#nTipoDocumentoProve").find("option:selected").text() ){
                        
                case 'RUC':

                            if( $("#sNumeroDocumentoProve").val().length  == 11 ){
                                 
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "ruc",
                                    sNumeroDoc   : $("#sNumeroDocumentoProve").val()
                                };

                                fncBuscarDocument( jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombreoRazonSocialProve").val(aryData.success.razonSocial);
                                    }
                                });

                            }

                break;
                
                case 'DNI':
                            if( $("#sNumeroDocumentoProve").val().length  == 7 || $("#sNumeroDocumentoProve").val().length  == 8 ){
                                
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "dni",
                                    sNumeroDoc   : $("#sNumeroDocumentoProve").val()
                                };

                                fncBuscarDocument(jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombreoRazonSocialProve").val(aryData.success.razonSocial);
                                    }
                                });

                            }
                break;

            }
                  
                    
        });



    });


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            $("#btnCrearProveedor").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarProveedor(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){

            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarProveedor( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblProveedores").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 
             
        });
    }

    function fncMostrarProveedor(nIdRegistro , sOpcion ) {

        $( "#formCEProveedor" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroProveedor(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#nTipoDocumentoProve").val(aryData.nTipoDocumento);
                    $("#sNumeroDocumentoProve").val(aryData.sNumeroDocumento);
                    $("#sNombreoRazonSocialProve").val(aryData.sNombreoRazonSocial);
                    $("#sCorreoProve").val(aryData.sCorreo);
                    $("#sDireccionProve").val(aryData.sDireccion);

                    $("#nIdDepartamentoProve").val(aryData.nIdDepartamento);

                    var jsnData = { nIdDepartamento : aryData.nIdDepartamento};
                    fncDrawProvincia( "#nIdProvinciaProve"  , jsnData , aryData.nIdProvincia);

                    var jsnData = { nIdProvincia : aryData.nIdProvincia};
                    fncDrawDistrito(  "#nIdDistritoProve"   , jsnData , aryData.nIdDistrito);

                    $("#nIdRelacionamientoProve").val(aryData.nIdRelacionamiento);
                    $("#sTelefonoProve").val(aryData.sTelefono);
                    $("#nEstadoProve").val(aryData.nEstado);


                    if(sOpcion == 'editar'){
                        fncEditForm("#formCEProveedor" , "Editar Proveedor");
                    } else {
                        fncViewForm("#formCEProveedor" , "Ver Proveedor");
                    }


                    $("#formCEProveedor").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCEProveedor").find("form") );
        fncClearInputs( $("#formCEProveedor").find("form") );
        $("#nIdProvinciaProve,#nIdDistritoProve").html(`<option value="0">SELECCIONAR</option>`);
    }

    function fncDrawProvincia(sHtmlTag , jsnData , nIdProvincia = null){
        
        fncObtenerProvincias(jsnData,function(aryData){

            let sOptions = ``;
            
            if(aryData.success){
                
                sOptions += `<option value="0">SELECCIONAR</option>`;
                
                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.nIdProvincia}">${aryElement.sNombre}</option>`;
                });
            
                $(sHtmlTag).html(sOptions);

                if(nIdProvincia != null){
                    $(sHtmlTag).val(nIdProvincia);
                }
            }

        });

    }

    function fncDrawDistrito(sHtmlTag , jsnData , nIdDistrito = null){
        
        fncObtenerDistrito(jsnData,function(aryData){
            
            let sOptions = ``;
            
            if(aryData.success){
                
                sOptions += `<option value="0">SELECCIONAR</option>`;
                
                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.nIdDistrito}">${aryElement.sNombre}</option>`;
                });
            
                $(sHtmlTag).html(sOptions);

                if(nIdDistrito != null){
                    $(sHtmlTag).val(nIdDistrito);
                }
            }

        });

    }

    // Llamadas al servidor


    function fncGrabarProveedor(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'proveedores/fncGrabarProveedor',
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

    function fncBuscarRegistroProveedor(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'proveedores/fncMostrarRegistro',
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

    function fncEjecutarEliminarProveedor( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'proveedores/fncEliminarRegistro',
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

    function fncBuscarDocument(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'api/'+ jsnData.sTipo +'/' + jsnData.sNumeroDoc ,
            beforeSend: function () {
              //  fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
             // fncOcultarLoader();
            }
        });
    }

    function fncObtenerProvincias(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ubigeo/fncObtenerProvincias',
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

    function fncObtenerDistrito(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ubigeo/fncObtenerDistrito',
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


    // Fin de cliente 




</script>


</html>