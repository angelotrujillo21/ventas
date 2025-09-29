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
                                                        <button id="btnCrearCliente" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblClientes" data-url="<?= route('clientes/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
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
                                                            <th data-field="nPuntosAcumulados" data-sortable="true">Puntos Acumulados</th>
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

    <div class="modal fade" id="formCECliente" tabindex="-1" role="dialog" aria-labelledby="formCEClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEClienteLabel">Nuevo Cliente</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nTipoDocumento" class="col-form-label">Tipo Documento <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoDocumento" id="nTipoDocumento">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoDocumento)): ?>
                                            <?php foreach($aryTipoDocumento as $aryTipoDoc):?>
                                                <option value="<?= $aryTipoDoc["nIdCatalogoTabla"] ?>"><?= $aryTipoDoc["sDescripcionCortaItem"] ?></option>
                                            <?php endforeach?>
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
                                <div class="form-group">
                                    <label for="nIdCondicionComercial" class="col-form-label">C.Comercial</label>
                                    <select class="form-control" name="nIdCondicionComercial" id="nIdCondicionComercial">
                                        <option value="0">Seleccionar</option>
                                        <?php if(fncValidateArray($aryCC)): ?>
                                            <?php foreach($aryCC as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdCondicionComercial"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-3">
                                <div class="form-group"><label for="nIdDepartamento" class="col-form-label">Departamento <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdDepartamento" id="nIdDepartamento">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryDepartamentos)): ?>
                                            <?php foreach($aryDepartamentos as $aryDepartamento):?>
                                                <option value="<?= $aryDepartamento["nIdDepartamento"] ?>"><?= $aryDepartamento["sNombre"] ?></option>
                                            <?php endforeach?>
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
                                    <label for="nAcumulaPuntos" class="col-form-label">¿ Acumula Puntos ?</label>
                                    <select class="form-control" name="nAcumulaPuntos" id="nAcumulaPuntos">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
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

                            <div class="col-12 col-md-3">
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
        $("#btnCrearCliente").on('click', function() {
            fncCleanAll();
            $("#formCECliente").find(".modal-title").html('Nuevo Cliente');
            $("#formCECliente").data("nIdRegistro",0);
            $("#formCECliente").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCECliente").find("form").on('submit',function(event){
           
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
                nAcumulaPuntos           : nAcumulaPuntos.length > 0 ? nAcumulaPuntos.val() : null,

                sFacebook                : sFacebook.length > 0 ? sFacebook.val() : null,
                sWtsp                    : sWtsp.length > 0 ? sWtsp.val() : null,
                sTwiter                  : sTwiter.length > 0 ? sTwiter.val() : null,
                sOtraRedSocial           : sOtraRedSocial.length > 0 ? sOtraRedSocial.val() : null,
                
                nEstado                  : nEstado.length > 0 ? nEstado.val() : null,
                nIdCondicionComercial    : $("#nIdCondicionComercial").val()
             };

             fncGrabarCliente(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCECliente").modal("hide");
                     $("#tblClientes").bootstrapTable('refresh');
                     toastr.success(aryData.success);
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


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            $("#btnCrearCliente").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarCliente(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             

            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarCliente( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblClientes").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });
 
    }

    function fncMostrarCliente(nIdRegistro , sOpcion ) {

        $( "#formCECliente" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroCliente(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#nTipoDocumento").val(aryData.nTipoDocumento);
                    $("#sNumeroDocumento").val(aryData.sNumeroDocumento);
                    $("#sNombreoRazonSocial").val(aryData.sNombreoRazonSocial);
                    $("#sCorreo").val(aryData.sCorreo);
                    $("#sDireccion").val(aryData.sDireccion);

                    $("#nIdDepartamento").val(aryData.nIdDepartamento);

                    var jsnData = { nIdDepartamento : aryData.nIdDepartamento};
                    fncDrawProvincia( "#nIdProvincia"  , jsnData , aryData.nIdProvincia);

                    var jsnData = { nIdProvincia : aryData.nIdProvincia};
                    fncDrawDistrito(  "#nIdDistrito"   , jsnData , aryData.nIdDistrito);

                    $("#nIdRelacionamiento").val(aryData.nIdRelacionamiento);
                    $("#sTelefono").val(aryData.sTelefono);
                    $("#nAcumulaPuntos").val(aryData.nAcumulaPuntos);

                    $("#sFacebook").val(aryData.sFacebook);
                    $("#sWtsp").val(aryData.sWtsp);
                    $("#sTwiter").val(aryData.sTwiter);
                    $("#sOtraRedSocial").val(aryData.sOtraRedSocial);

                    $("#nEstado").val(aryData.nEstado);
                    $("#nIdCondicionComercial").val(aryData.nIdCondicionComercial);

                
                    if(sOpcion == 'editar'){
                        fncEditForm("#formCECliente" , "Editar Cliente");
                    } else {
                        fncViewForm("#formCECliente" , "Ver Cliente");
                    }


                    $("#formCECliente").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCECliente").find("form") );
        fncClearInputs( $("#formCECliente").find("form") );
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

    function fncBuscarRegistroCliente(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'clientes/fncMostrarRegistro',
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

    function fncEjecutarEliminarCliente( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'clientes/fncEliminarRegistro',
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