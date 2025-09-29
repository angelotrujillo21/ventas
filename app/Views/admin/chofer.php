<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>
    <?php load_script_plugin(['qrious/dist/qrious.min']) ?>
</head>

<body data-nadmin="<?= $nAdmin ?>">

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
                                                        <button id="btnCrearRegistro" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->



                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="tblPrincipal" data-url="<?= route('choferes/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sDocumento" data-sortable="true">Documento</th>
                                                            <th data-field="sNombres" data-sortable="true">Nombre Completo</th>
                                                            <th data-field="sLicencia" data-sortable="true">Licencia</th>
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
    <div class="modal fade" id="formCEBRegistro" tabindex="-1" role="dialog" aria-labelledby="formCELoteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCELoteLabel">Nuevo Banco</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdTipoDocumento" class="col-form-label">Tipo Documento <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdTipoDocumento" id="nIdTipoDocumento">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if (fncValidateArray($aryTipoDocumento)) : ?>
                                            <?php foreach ($aryTipoDocumento as $aryTipoDoc) : ?>
                                                <option value="<?= $aryTipoDoc["nIdCatalogoTabla"] ?>"><?= $aryTipoDoc["sDescripcionCortaItem"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNumeroDocumento" class="col-form-label">Numero de documento <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumento" id="sNumeroDocumento">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNombres" class="col-form-label">Nombres <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombres" id="sNombres">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sApellidos" class="col-form-label">Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sApellidos" id="sApellidos">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdVehiculo" class="col-form-label">Vehiculo <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdVehiculo" id="nIdVehiculo">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if (fncValidateArray($aryVehiculo)) : ?>
                                            <?php foreach ($aryVehiculo as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdVehiculo"] ?>"><?= $aryLoop["sPlaca"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sLicencia" class="col-form-label">Licencia <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sLicencia" id="sLicencia">
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
        $("#btnCrearRegistro").on('click', function() {
            fncCleanAll();
            $("#formCEBRegistro").find(".modal-title").html('Nuevo Chofer');
            $("#formCEBRegistro").data("nIdRegistro", 0);
            $("#formCEBRegistro").modal("show");
        });

        // Submit del formulario de banco
        $("#formCEBRegistro").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro = $("#formCEBRegistro").data("nIdRegistro");
            var nIdTipoDocumento = $("#nIdTipoDocumento").val();
            var sNumeroDocumento = $("#sNumeroDocumento").val();
            var sNombres = $("#sNombres").val();
            var sApellidos = $("#sApellidos").val();
            var nIdVehiculo = $("#nIdVehiculo").val();
            var sLicencia = $("#sLicencia").val();
            var nEstado = $("#nEstado").val();


            if (nIdTipoDocumento == '0') {
                toastr.error('Error. Debe de seleccionar un tipo de documento. Porfavor verifique');
                return false;
            }

            if (sNumeroDocumento == '') {
                toastr.error('Error. No ha ingresado el numero de documento. Porfavor verifique');
                return false;
            }

            if (sNombres == '') {
                toastr.error('Error. No ha ingresado el nombre. Porfavor verifique');
                return false;
            }

            if (sApellidos == '') {
                toastr.error('Error. No ha ingresado el nombre. Porfavor verifique');
                return false;
            }

            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdTipoDocumento', nIdTipoDocumento);
            formData.append('sNumeroDocumento', sNumeroDocumento);
            formData.append('sNombres', sNombres);
            formData.append('sApellidos', sApellidos);
            formData.append('nIdVehiculo', nIdVehiculo);
            formData.append('sLicencia', sLicencia);
            formData.append('nEstado', nEstado);

            fncGrabarRegistro(formData, function(aryData) {
                if (aryData.success) {
                    fncCleanAll();
                    $("#formCEBRegistro").modal("hide");
                    $('#tblPrincipal').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

       

    });


    function fncValidarRol() {
        if ($("body").data("nadmin") == 1) {
            // es admin
        } else {
            $("#btnCrearRegistro").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarRegistro(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?',
            function() {

                var jsnData = {
                    nIdRegistro: nIdRegistro
                };

                fncEjecutarEliminarRegistro(jsnData, function(aryData) {

                    if (aryData.success) {
                        $("#tblPrincipal").bootstrapTable('refresh');
                        toastr.success(aryData.success);
                    } else {
                        toastr.error(aryData.error);
                    }

                });


            });

    }

    function fncMostrarRegistro(nIdRegistro, sOpcion) {

        $("#formCEBRegistro").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistro(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData = aryResponse.aryData;

                $("#nIdTipoDocumento").val(aryData.nIdTipoDocumento);
                $("#sNumeroDocumento").val(aryData.sNumeroDocumento);
                $("#sNombres").val(aryData.sNombres);
                $("#sApellidos").val(aryData.sApellidos);
                $("#nIdVehiculo").val(aryData.nIdVehiculo);
                $("#sLicencia").val(aryData.sLicencia);
                $("#nEstado").val(aryData.nEstado);

                if (sOpcion == 'editar') {
                    fncEditForm("#formCEBRegistro", "Editar Chofer");
                } else {
                    fncViewForm("#formCEBRegistro", "Ver Chofer");
                }

                $("#formCEBRegistro").modal("show");
            } else {
                toastr.error(aryData.error);
            }
        });

    }

     

    // Funciones Auxiliares
    function fncCleanAll() {
        fncRemoveDisabled($("#formCEBRegistro").find("form"));
        fncClearInputs($("#formCEBRegistro").find("form"));
    }


    // Llamadas al servidor
    function fncGrabarRegistro(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'choferes/fncGrabarRegistro',
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

    function fncBuscarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'choferes/fncMostrarRegistro',
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

    function fncEjecutarEliminarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'choferes/fncEliminarRegistro',
            data: jsnData,
            dataType: 'json',
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

</html>