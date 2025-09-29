<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin="<?=$nAdmin?>">

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
                                                        <button id="btnCrearEmpleado" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblEmpleados" data-url="<?= route('empleados/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sTipoDocumento" data-sortable="true">Tipo Documento</th>
                                                            <th data-field="sNumeroDocumento" data-sortable="true">N° Documento</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha creacion</th>
                                                            <th data-field="sDireccion" data-sortable="true">Direccion</th>
                                                            <th data-field="sTelefono" data-sortable="true">Telefono</th>
                                                            <th data-field="sCorreo" data-sortable="true">Correo</th>
                                                            <th data-field="sLogin" data-sortable="true">Login</th>
                                                            <th data-field="sClave" data-visible="false" data-sortable="true">Clave</th>
                                                            <th data-field="sNombreRol" data-sortable="true">Rol</th>
                                                            <th data-field="sImagen" data-sortable="true">Imagen</th>
                                                            <th data-field="sDelivery" data-sortable="true">Delivery</th>
															<th data-field="nCajaEmpleado" data-sortable="true">Caja Asignado</th>
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

    <div class="modal fade" id="formCEEmpleado" tabindex="-1" role="dialog" aria-labelledby="formCEEmpleadoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEEmpleadoLabel">Nuevo Empleado</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nTipoDocumentoEmpleado" class="col-form-label">Tipo Documento <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nTipoDocumentoEmpleado" id="nTipoDocumentoEmpleado">
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
                                    <label for="sNumeroDocumentoEmpleado" class="col-form-label">Numero de documento <span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumentoEmpleado" id="sNumeroDocumentoEmpleado">
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="sNombreEmpleado" class="col-form-label">Nombre <span class="text-danger">*</span> </label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreEmpleado" id="sNombreEmpleado">
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                     <label for="sDireccionEmpleado" class="col-form-label">Direccion</label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDireccionEmpleado" id="sDireccionEmpleado">
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                     <label for="sTelefonoEmpleado" class="col-form-label">Telefono</label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sTelefonoEmpleado" id="sTelefonoEmpleado">
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                     <label for="sCorreoEmpleado" class="col-form-label">Correo <span class="text-danger">*</span> </label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCorreoEmpleado" id="sCorreoEmpleado">
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                     <label for="sLoginEmpleado" class="col-form-label">Login <span class="text-danger">*</span> </label>
                                     <input type="text" autocomplete="off" placeholder="" class="form-control" name="sLoginEmpleado" id="sLoginEmpleado">
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <!--div class="form-group">
                                     <label for="sClaveLogin" class="col-form-label">Clave <span class="text-danger">*</span> </label>
                                     <input type="password" autocomplete="off" placeholder="" class="form-control" name="sClaveLogin" id="sClaveLogin">
                                </div-->
								
								 <div class="form-group">
								  <label for="sClaveLogin" class="col-form-label">Clave <span class="text-danger">*</span> </label>
                                    <div class="input-group content-password">
                                        <input type="password" placeholder="Clave" class="form-control input-password" name="sClaveLogin" id="sClaveLogin" aria-label="Password" required>
                                        <div data-visible="true" class="input-group-append btnToggleVisible cursor-pointer">
                                            <span class="input-group-text"> <i style="display: none;" class="far fa-eye icon-view"></i> <i class="far fa-eye-slash icon-slash"></i> </span>
                                        </div>
                                    </div>
                                </div>
								
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nIdRolEmpleado" class="col-form-label">Rol <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nIdRolEmpleado" id="nIdRolEmpleado">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryRoles)): ?>
                                            <?php foreach($aryRoles as $aryRol):?>
                                                <option value="<?= $aryRol["nIdRol"] ?>"><?= $aryRol["sNombreRol"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
  
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label">Imagen</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImagenEmpleado" accept="image/*" name="sImagenEmpleado" lang="es">
                                            <label class="custom-file-label" for="sImagenEmpleado">Selecciona un archivo</label>
                                        </div>
                                    </div>
                                    <small>Recomendado 128px x 128px</small>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nPorcentajeComision" class="col-form-label">Porcentaje comision </label>
                                    <input type="number" autocomplete="off" placeholder="" class="form-control" value="0" name="nPorcentajeComision" id="nPorcentajeComision">
                                </div>
                                
                            </div>

                            
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nDelivery" class="col-form-label">Delivery</label>
                                    <select class="form-control" name="nDelivery" id="nDelivery">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>
							
							  <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nCajaEmpleado" class="col-form-label">Asignar Caja</label>
									<select class="form-control" name="nCajaEmpleado" id="nCajaEmpleado">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nEstadoEmpleado" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoEmpleado" id="nEstadoEmpleado">
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

<!-- Empleado -->
<script>
    $(function() {

        fncValidateRol();

        // Formulario Clientes
        $("#btnCrearEmpleado").on('click', function() {
            fncCleanAll();
            $("#formCEEmpleado").find(".modal-title").html('Nuevo Empleado');
            $("#formCEEmpleado").data("nIdRegistro",0);
            $("#formCEEmpleado").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCEEmpleado").find("form").on('submit',function(event){
           
             event.preventDefault();

             var nIdRegistro            = $("#formCEEmpleado").data("nIdRegistro");
             var nTipoDocumento         = $("#nTipoDocumentoEmpleado").val()
             var sNumeroDocumento       = $("#sNumeroDocumentoEmpleado").val();
             var sNombre                = $("#sNombreEmpleado").val();
             var sCorreo                = $("#sCorreoEmpleado").val();
             var sDireccion             = $("#sDireccionEmpleado").val();
             var sTelefono              = $("#sTelefonoEmpleado").val();
             var sLogin                 = $("#sLoginEmpleado").val();
             var sClave                 = $("#sClaveLogin").val();
             var nIdRol                 = $("#nIdRolEmpleado").val();
             var sImagen                = $("#sImagenEmpleado")[0].files[0];
             var nEstado                = $("#nEstadoEmpleado").val();
             var nPorcentajeComision    = $("#nPorcentajeComision").val();
             var nDelivery              = $("#nDelivery").val();
			 var nCajaEmpleado          = $("#nCajaEmpleado").val();

             if (nTipoDocumento  == '') {
                 toastr.error('Error. Seleccione un tipo de documento. Porfavor verifique');
                 return;
             }  else if (sNumeroDocumento  == '') {
                 toastr.error('Error. Ingrese un numero de documento. Porfavor verifique');
                 return;
             }  else if (sNombre  == '') {
                 toastr.error('Error. Ingrese un nombre . Porfavor verifique');
                 return;
             }  else if (sCorreo  == '') {
                 toastr.error('Error. Ingrese un correo. Porfavor verifique');
                 return;
             }  else if (sLogin  == '') {
                 toastr.error('Error. Ingrese un login para el empleado. Porfavor verifique');
                 return;
             }  else if (sClave == '') {
                 toastr.error('Error. Ingrese una clave para el empleado. Porfavor verifique');
                 return;
             }  else if (nIdRol == '') {
                 toastr.error('Error. Seleccione un rol para el empleado. Porfavor verifique');
                 return;
             }   


             var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nTipoDocumento', nTipoDocumento);
            formData.append('sNumeroDocumento', sNumeroDocumento);
            formData.append('sNombre', sNombre);
            formData.append('sDireccion', sDireccion);
            formData.append('sTelefono', sTelefono);
            formData.append('sCorreo', sCorreo);
            formData.append('sLogin', sLogin);
            formData.append('sClave', sClave);
            formData.append('sImagen', sImagen);
            formData.append('nIdRol', nIdRol);
            formData.append('nPorcentajeComision', nPorcentajeComision);
            formData.append('nDelivery', nDelivery);
			formData.append('nCajaEmpleado', nCajaEmpleado);
            formData.append('nEstado', nEstado);

        
             fncGrabarEmpleado(formData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCEEmpleado").modal("hide");
                     $("#tblEmpleados").bootstrapTable('refresh');
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
             });

        });

        // Eventos tipo documento
        $("#nTipoDocumentoEmpleado").change(function() {
             if( $(this).val() > 0 ) {
                 fncMaxLengthTypeDocument( $(this).find('option:selected').text().trim().toUpperCase() , "#sNumeroDocumentoEmpleado" );
             }
        });
   
        $("#sNumeroDocumentoEmpleado").on('keyup change',function(){
                    
            switch( $("#nTipoDocumentoEmpleado").find("option:selected").text() ){
                        
                case 'RUC':

                            if( $("#sNumeroDocumentoEmpleado").val().length  == 11 ){
                                 
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "ruc",
                                    sNumeroDoc   : $("#sNumeroDocumentoEmpleado").val()
                                };

                                fncBuscarDocument( jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombreEmpleado").val(aryData.success.razonSocial);
                                    }
                                });

                            }

                break;
                
                case 'DNI':
                            if( $("#sNumeroDocumentoEmpleado").val().length  == 7 || $("#sNumeroDocumentoEmpleado").val().length  == 8 ){
                                
                                // Lanzamos el evento
                                var jsnData = {
                                    sTipo        : "dni",
                                    sNumeroDoc   : $("#sNumeroDocumentoEmpleado").val()
                                };

                                fncBuscarDocument(jsnData ,function(aryData){
                                    if(aryData.success){
                                        $("#sNombreEmpleado").val(aryData.success.razonSocial);
                                    }
                                });

                            }
                break;

            }
                  
                    
        });



    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarEmpleado(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
            
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarEmpleado( jsnData , function(aryData){

                if(aryData.success){
                    $("#tblEmpleados").bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            });
             
        });
    }

    function fncMostrarEmpleado(nIdRegistro , sOpcion ) {

        $( "#formCEEmpleado" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroEmpleado(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#nTipoDocumentoEmpleado").val(aryData.nTipoDocumento);
                    $("#sNumeroDocumentoEmpleado").val(aryData.sNumeroDocumento);
                    $("#sNombreEmpleado").val(aryData.sNombre);
                    $("#sCorreoEmpleado").val(aryData.sCorreo);
                    $("#sDireccionEmpleado").val(aryData.sDireccion);
                    $("#sTelefonoEmpleado").val(aryData.sTelefono);
                    $("#sLoginEmpleado").val(aryData.sLogin);
                    $("#sClaveLogin").val(aryData.sClave);
                    $("#nIdRolEmpleado").val(aryData.nIdRol);
                    $("#nPorcentajeComision").val(aryData.nPorcentajeComision);
                    $("#nDelivery").val(aryData.nDelivery);
					$("#nCajaEmpleado").val(aryData.nCajaEmpleado);
                    $("#nEstadoEmpleado").val(aryData.nEstado);

                    if(aryData.sImagen.length > 0) $("label[for='sImagenEmpleado']").html(aryData.sImagen);

                    if(sOpcion == 'editar'){
                        fncEditForm("#formCEEmpleado" , "Editar Empleado");
                    } else {
                        fncViewForm("#formCEEmpleado" , "Ver Empleado");
                    }

                    $("#formCEEmpleado").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCEEmpleado").find("form") );
        fncClearInputs( $("#formCEEmpleado").find("form") );
     }

 

    // Llamadas al servidor

    function fncValidateRol(){

        if($("body").data("nadmin") == 1){
            // Si es admin
        } else {
            $("#btnCrearEmpleado").hide();
        }
    }


    // Empleados 

    function fncGrabarEmpleado(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'empleados/fncGrabarEmpleado',
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

    function fncBuscarRegistroEmpleado(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'empleados/fncMostrarRegistro',
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

    function fncEjecutarEliminarEmpleado( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'empleados/fncEliminarRegistro',
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


    // Fin de Empleados 




</script>
<!-- Empleado -->


</html>