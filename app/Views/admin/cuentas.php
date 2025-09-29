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
                                                        <button id="btnCrearUsuario" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">

                                                <div id="toolbar" class="btn-group ">
                                                    <div class="col-md-6 sin-padding container-buttons-table">
                                                        <button class="btn btn-gradient-primary-table" type="button" title="Imprimir" onclick="window.print();" id="btnprint">
                                                            <i class="fas fa-print"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <table data-toggle="table" id="table" data-url="<?= route('usuarios/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                            <th data-field="sApellidos" data-sortable="true">Apellidos</th>
                                                            <th data-field="sLogin" data-sortable="true">Login</th>
                                                            <th data-field="sClave" data-sortable="true">Clave</th>
                                                            <th data-field="sNombreRol" data-sortable="true">Rol</th>
                                                            <th data-field="sImagen" data-sortable="true">Imagen</th>
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

            </main>
        </div>
    </div>



    <!-- Modales -->

    <div class="modal fade" id="formUsuario" tabindex="-1" role="dialog" aria-labelledby="formUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formUsuarioLabel">Nuevo Usuario</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                            <div class="row">

                              
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="sNombre" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="sNombre" autocomplete="off" name="sNombre">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="sApellidos" class="col-form-label">Apellidos:</label>
                                        <input type="text" class="form-control" id="sApellidos" autocomplete="off" name="sApellidos">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="sLogin" class="col-form-label">Login:</label>
                                        <input type="text" class="form-control" id="sLogin" autocomplete="off" name="sLogin">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="sClave" class="col-form-label">Clave:</label>
                                        <input type="text" class="form-control" id="sClave" autocomplete="off" name="sClave">
                                    </div>
                                </div>



                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="sImagen" class="col-form-label">Imagen:</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="sImagen" accept="image/*" lang="es" name="sImagen">
                                                <label class="custom-file-label" for="sImagen">Elija el
                                                    archivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nIdRol" class="col-form-label">Rol:</label>
                                        <select class="form-control" name="nIdRol" id="nIdRol">
                                            <option value="0">Seleccionar</option>
                                            <?php if(fncValidateArray($aryRoles)): ?>
                                                <?php foreach($aryRoles as $aryRol): ?>
                                                    <option value="<?=$aryRol["nIdRol"]?>"><?=$aryRol["sNombreRol"]?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nEstado" class="col-form-label">Estado:</label>
                                        <select class="form-control" name="nEstado" id="nEstado">
                                            <option value="1">Activo</option>
                                            <option value="0">Desactivo</option>
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





 
</body>



<?php extend_view(['admin/common/scripts'], $data) ?>


<script>
    $(function() {

        // Formulario Usuarios 


        $("#btnCrearUsuario").on('click', function() {
            fncCleanAll();
            $("#formUsuario").find(".modal-title").html('Nuevo Usuario');
            $("#formUsuario").data("nIdRegistro",0);
            $("#formUsuario").modal("show");
        });

        $("#formUsuario").find('form').on('submit', function(event) {
            
            event.preventDefault();

            var nIdRegistro  = $("#formUsuario").data("nIdRegistro");
            var sNombre      = $("#sNombre").val().trim();
            var sApellidos   = $("#sApellidos").val().trim();
            var sLogin       = $("#sLogin").val().trim();
            var sClave       = $("#sClave").val().trim();
            var sImagen      = $("#sImagen")[0].files[0];
            var nIdRol       = $("#nIdRol").find("option:selected").val();
            var nEstado      = $("#nEstado").find("option:selected").val();


            if(sNombre == ''){
                toastr.error('Error. Debe ingresar el nombre del usuario.');
                return false;
            } else if(sApellidos == ''){
                toastr.error('Error. Debe ingresar los apellidos del usuario.');
                return false;
            } else if(sLogin == ''){
                toastr.error('Error. Debe ingresar el nombre de login del usuario.');
                return false;
            } else if(sClave == ''){
                toastr.error('Error. Debe ingresar la clave del usuario.');
                return false;
            } else if(nIdRol == '0'){
                toastr.error('Error. Debe seleccionar el rol del usuario.');
                return false;
            } 

           
            var formData = new FormData();

            formData.append('nIdRegistro', nIdRegistro);
            formData.append('sNombre', sNombre);
            formData.append('sApellidos',sApellidos);
            formData.append('sLogin', sLogin);
            formData.append('sClave',sClave);
            formData.append('sImagen',sImagen);
            formData.append('nIdRol' , nIdRol);
            formData.append('nEstado', parseInt( nEstado ));


            fncGrabarUsuario(formData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formUsuario").modal("hide");
                    $('#table').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                }else{
                    toastr.error(aryData.error);
                }
            });

            
        });

        // Fin de Formulario Negocios 

    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarRegistro ( nIdRegistro ) {
        if(confirm('Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?')){
            
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarRegistro( jsnData , function(aryData){

                if(aryData.success){
                    $('#table').bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 
        }
    }

    function fncMostrarRegistro(nIdRegistro) {

        $("#formUsuario").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarRegistro(jsnData, function(aryResponse){
            
                if (aryResponse.success) {
                    var aryData = aryResponse.aryData;

                    $("#sNombre").val(aryData.sNombre);
                    $("#sApellidos").val(aryData.sApellidos);
                    $("#sLogin").val(aryData.sLogin);
                    $("#sClave").val(aryData.sClave);
                    $("#sImagen").parent().find(".custom-file-label").html(aryData.sImagen);
                    $("#nIdRol").val(aryData.nIdRol);
                    $("#nEstado").val(aryData.nestado);


                    $("#formUsuario").find(".modal-title").html('Editar Usuario');
                    $("#formUsuario").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncClearInputs( $("#formUsuario").find("form") );
    }

    // Llamadas al servidor

    function fncGrabarUsuario(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'usuarios/fncGrabarUsuario',
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

    function fncEjecutarEliminarRegistro ( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'usuarios/fncEliminarUsuario',
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

    function fncBuscarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'usuarios/fncMostrarUsuario',
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




</script>
</html>