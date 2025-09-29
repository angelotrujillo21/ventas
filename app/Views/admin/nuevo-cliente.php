<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>
 
</head>

<body data-nidempresa="<?=$nIdEmpresa?>">
    <div class="page-loader">
        <div class="loader-dual-ring"></div>
    </div>

    <div class="container-fluid">

        <div class="row">

 
            <main class="main-content col-lg-12 col-md-12 col-sm-12 p-0">

 
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

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <form id="formCECliente">
                                                    <div class="row">

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="nTipoDocumento" class="col-form-label">Tipo Documento <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="nTipoDocumento" id="nTipoDocumento">
                                                                    <option value="0">SELECCIONAR</option>
                                                                    <?php if (fncValidateArray($aryTipoDocumento)) : ?>
                                                                        <?php foreach ($aryTipoDocumento as $aryTipoDoc) : ?>
                                                                            <option value="<?= $aryTipoDoc["nIdCatalogoTabla"] ?>"><?= $aryTipoDoc["sDescripcionCortaItem"] ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sNumeroDocumento" class="col-form-label">Numero de documento <span class="text-danger">*</span></label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumento" id="sNumeroDocumento">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sNombreoRazonSocial" class="col-form-label">Nombre o Razon Social <span class="text-danger">*</span></label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreoRazonSocial" id="sNombreoRazonSocial">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sCorreo" class="col-form-label">Correo</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCorreo" id="sCorreo">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group"><label for="nIdDepartamento" class="col-form-label">Departamento <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="nIdDepartamento" id="nIdDepartamento">
                                                                    <option value="0">SELECCIONAR</option>
                                                                    <?php if (fncValidateArray($aryDepartamentos)) : ?>
                                                                        <?php foreach ($aryDepartamentos as $aryDepartamento) : ?>
                                                                            <option value="<?= $aryDepartamento["nIdDepartamento"] ?>"><?= $aryDepartamento["sNombre"] ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="nIdProvincia" class="col-form-label">Provincia <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="nIdProvincia" id="nIdProvincia">
                                                                    <option value="0">SELECCIONAR</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="nIdDistrito" class="col-form-label">Distrito <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="nIdDistrito" id="nIdDistrito">
                                                                    <option value="0">SELECCIONAR</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sDireccion" class="col-form-label">Direccion </label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDireccion" id="sDireccion">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sTelefono" class="col-form-label">Telefono </label>
                                                                <input type="tel" autocomplete="off" placeholder="" class="form-control" name="sTelefono" id="sTelefono">
                                                            </div>
                                                        </div>


                                                                                    
                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sFacebook" class="col-form-label">Facebook</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sFacebook" id="sFacebook">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sWtsp" class="col-form-label">Whatsapp</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sWtsp" id="sWtsp">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sTwiter" class="col-form-label">Twiter</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sTwiter" id="sTwiter">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-3">
                                                            <div class="form-group">
                                                                <label for="sOtraRedSocial" class="col-form-label">Otra red social</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sOtraRedSocial" id="sOtraRedSocial">
                                                            </div>
                                                        </div>
 
 

                                                        <div class="col-12 col-md-12 text-right">
                                                            <button type="submit"  class="btn btn-gradient-primary" >
                                                                Registrar
                                                            </button>
                                                         </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </main>
        </div>
    </div>



    <!-- Modales -->




    <!-- Fin de modales -->





    <?php extend_view(['admin/common/footer'], $data) ?>

</body>


<?php extend_view(['admin/common/scripts'], $data) ?>

<script>
    $(function() {



        // Submit del formulario de Cliente
        $("#formCECliente").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro            = $("#formCECliente").data("nIdRegistro");
             var nTipoDocumento         = $("#nTipoDocumento")
             var sNumeroDocumento       = $("#sNumeroDocumento");
             var sNombreoRazonSocial    = $("#sNombreoRazonSocial");
             var sCorreo                = $("#sCorreo");
             var nIdDepartamento        = $("#nIdDepartamento");
             var nIdProvincia           = $("#nIdProvincia");
             var nIdDistrito            = $("#nIdDistrito");
             var nIdRelacionamiento     = $("#nIdRelacionamiento");
             var sTelefono              = $("#sTelefono");
             var sDireccion             = $("#sDireccion");
             var nAcumulaPuntos         = $("#nAcumulaPuntos");
             var sFacebook              = $("#sFacebook");
             var sWtsp                  = $("#sWtsp");
             var sTwiter                = $("#sTwiter");
             var sOtraRedSocial         = $("#sOtraRedSocial");

             var nEstado                = $("#nEstado");

             
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
                nIdRegistro              : 0,
                nTipoDocumento           : nTipoDocumento.length > 0 ? nTipoDocumento.val() : null,
                sNumeroDocumento         : sNumeroDocumento.length > 0 ? sNumeroDocumento.val() : null,
                sNombreoRazonSocial      : sNombreoRazonSocial.length > 0 ? sNombreoRazonSocial.val() : null,
                sCorreo                  : sCorreo.length > 0 ? sCorreo.val() : null,
                nIdDepartamento          : nIdDepartamento.length > 0 ? nIdDepartamento.val() : null,
                nIdProvincia             : nIdProvincia.length > 0 ? nIdProvincia.val() : null,
                nIdDistrito              : nIdDistrito.length > 0 ? nIdDistrito.val() : null,
                sTelefono                : sTelefono.length > 0 ? sTelefono.val() : null,
                sDireccion               : sDireccion.length > 0 ? sDireccion.val() : null,
                nAcumulaPuntos           : 0,
                
                sFacebook                : sFacebook.length > 0 ? sFacebook.val() : null,
                sWtsp                    : sWtsp.length > 0 ? sWtsp.val() : null,
                sTwiter                  : sTwiter.length > 0 ? sTwiter.val() : null,
                sOtraRedSocial           : sOtraRedSocial.length > 0 ? sOtraRedSocial.val() : null,
                nEstado                  : 1,
                nIdEmpresa               : $("body").data("nidempresa")
             };

             fncGrabarCliente(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCECliente").modal("hide");
                     $("#tblClientes").bootstrapTable('refresh');
                     fncMsg(3, aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
             });

        });

        // Evento Dtp
        $("#nIdDepartamento").on('change',function(){
          var jsnData = {
              nIdDepartamento : $(this).val()
          };

          fncDrawProvincia("#nIdProvincia" , jsnData , null);
        });

        $("#nIdProvincia").on('change',function(){
             var jsnData = {
                 nIdProvincia : $(this).val()
             };
             fncDrawDistrito("#nIdDistrito" , jsnData , null);
        });

        $("#nTipoDocumento").change(function() {
             if( $(this).val() > 0 ) {
                 fncMaxLengthTypeDocument( $(this).find('option:selected').text().trim().toUpperCase() , "#sNumeroDocumento" );
             }
        });

        $("#sNumeroDocumento").on('keyup change',function(){
                    
            switch( $("#nTipoDocumento").find("option:selected").text() ){
                        
                case 'RUC':

                            if( $("#sNumeroDocumento").val().length  == 11 ){
                                 
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "ruc",
                                    sNumeroDoc   : $("#sNumeroDocumento").val()
                                };

                                fncBuscarDocument( jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombreoRazonSocial").val(aryData.success.razonSocial);
                                    }
                                });

                            }

                break;
                
                case 'DNI':
                            if( $("#sNumeroDocumento").val().length  == 7 || $("#sNumeroDocumento").val().length  == 8 ){
                                
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "dni",
                                    sNumeroDoc   : $("#sNumeroDocumento").val()
                                };

                                fncBuscarDocument(jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombreoRazonSocial").val(aryData.success.razonSocial);
                                    }
                                });

                            }
                break;

            }
                  
                    
        });



    });

 
 
 
 

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCECliente" ) );
        fncClearInputs( $("#formCECliente")  );
        $("#nIdProvincia,#nIdDistrito").html(`<option value="0">SELECCIONAR</option>`);
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


    // Cliente 

    function fncGrabarCliente(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'clientes/fncGrabarCliente',
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