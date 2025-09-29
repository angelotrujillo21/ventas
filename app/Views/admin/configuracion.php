<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

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

                                        <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="metodo-pago-tab" data-toggle="tab" href="#metodo-pago" role="tab" aria-controls="metodo-pago" aria-selected="true">Metodos de pagos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="metodo-envio-tab" data-toggle="tab" href="#metodo-envio" role="tab" aria-controls="metodo-envio" aria-selected="false">Metodos de envio</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="unidad-medida-tab" data-toggle="tab" href="#unidad-medida" role="tab" aria-controls="unidad-medida" aria-selected="false">Unidad de medidas</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="serie-numeros-tab" data-toggle="tab" href="#serie-numeros" role="tab" aria-controls="serie-numeros" aria-selected="false">Serie Correlativo</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="metodo-pago" role="tabpanel" aria-labelledby="metodo-pago-tab">


                                                <!-- Fila Cabecera -->
                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center p-2">

                                                            <div class="flex-center">
                                                                <h5>Metodos de pagos</h5>
                                                            </div>

                                                            <div class="ml-auto">
                                                                <button id="btnCrearMetodoPago" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin de Fila Cabecera -->

                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <table data-toggle="table" id="tblMetodosPagos" data-url="<?= route('metodosPago/fncPopulateSedeMetodoPago') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="sAcciones">Acciones</th>
                                                                    <th data-field="sNombrePago" data-sortable="true">Tipo de pago</th>
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
                                            <div class="tab-pane fade" id="metodo-envio" role="tabpanel" aria-labelledby="metodo-envio-tab">
                                            
                                             
                                                 <!-- Fila Cabecera -->
                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center p-2">

                                                            <div class="flex-center">
                                                                <h5>Metodos de envio</h5>
                                                            </div>

                                                            <div class="ml-auto">
                                                                <button id="btnCrearMetodoEnvio" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin de Fila Cabecera -->

                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <table data-toggle="table" id="tblMetodosEnvios" data-url="<?= route('metodosEnvio/fncPopulateSedeMetodoEnvio') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="sAcciones">Acciones</th>
                                                                    <th data-field="sNombreEnvio" data-sortable="true">Tipo de envio</th>
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
                                            <div class="tab-pane fade" id="unidad-medida" role="tabpanel" aria-labelledby="unidad-medida-tab">
                                            
                                            
                                                <!-- Fila Cabecera -->
                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center p-2">

                                                            <div class="flex-center">
                                                                <h5>Unidad de medida</h5>
                                                            </div>

                                                            <div class="ml-auto">
                                                                <button id="btnCrearUnidadMedida" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin de Fila Cabecera -->

                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <table data-toggle="table" id="tblUnidadesMedidas"  data-url="<?= route('unidadesMedida/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="sAcciones">Acciones</th>
                                                                    <th data-field="sNombreCorto" data-sortable="true">Descripcion corta</th>
                                                                    <th data-field="sNombreLargo" data-sortable="true">Descripcion larga</th>
                                                                    <th data-field="sEstado" data-sortable="true">Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            </div>
                                            <div class="tab-pane fade" id="serie-numeros" role="tabpanel" aria-labelledby="serie-numeros-tab">
                                            
                                            
                                                <!-- Fila Cabecera -->
                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center p-2">

                                                            <div class="flex-center">
                                                                <h5>Serie Correlativo</h5>
                                                            </div>

                                                            <div class="ml-auto">
                                                                <button id="btnCrearSN" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin de Fila Cabecera -->

                                                <div class="row my-2">
                                                    <div class="col-12">
                                                        <table data-toggle="table" id="tblSerieNumeros"  data-url="<?= route('serieNumeros/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="sAcciones">Acciones</th>
                                                                    <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                                    <th data-field="sPrefijo" data-sortable="true">Serie</th>
                                                                    <th data-field="sValor" data-sortable="true">Correlativo</th>
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
                    </div>


                </div>

                <?php extend_view(['admin/common/descripcion-empresa'], $data) ?>
            </main>
        </div>
    </div>



    <!-- Modales -->

    <div class="modal fade" id="formCEMetodoPago" tabindex="-1" role="dialog" aria-labelledby="formCEMetodoPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEMetodoPagoLabel">Nuevo Metodo de Pago</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdMetodoPago" class="col-form-label">Tipo de pago <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nIdMetodoPago" id="nIdMetodoPago">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if (fncValidateArray($aryTipoPago)) : ?>
                                            <?php foreach ($aryTipoPago as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdMetodoPago"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sDetalleMP" class="col-form-label">Detalle </label>
                                    <textarea class="form-control" name="sDetalleMP" id="sDetalleMP"></textarea>
                                </div>
                            </div>

                            

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Imagen</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImagenMP" accept="image/*" name="sImagenMP" lang="es">
                                            <label class="custom-file-label" for="sImagenMP">Selecciona un archivo</label>
                                        </div>
                                    </div>
                                    <small>Recomendado 128px x 128px</small>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstadoMP" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoMP" id="nEstadoMP">
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

    <div class="modal fade" id="formCEMetodoEnvio" tabindex="-1" role="dialog" aria-labelledby="formCEMetodoEnvioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEMetodoEnvioLabel">Nuevo Metodo de Envio</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdMetodoEnvio" class="col-form-label">Tipo de envio <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nIdMetodoEnvio" id="nIdMetodoEnvio">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if (fncValidateArray($aryTipoEnvio)) : ?>
                                            <?php foreach ($aryTipoEnvio as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdMetodoEnvio"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sDetalleME" class="col-form-label">Detalle </label>
                                    <textarea class="form-control" name="sDetalleME" id="sDetalleME"></textarea>
                                </div>
                            </div>

                            

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Imagen</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImagenME" accept="image/*" name="sImagenME" lang="es">
                                            <label class="custom-file-label" for="sImagenME">Selecciona un archivo</label>
                                        </div>
                                    </div>
                                    <small>Recomendado 128px x 128px</small>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstadoMP" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoME" id="nEstadoME">
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

    <div class="modal fade" id="formCEUM" tabindex="-1" role="dialog" aria-labelledby="formCEUMaLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEUMaLabel">Nueva Unidad de medida</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

           
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sNombreLargoUM" class="col-form-label">Descripcion Larga </label>
                                    <input type="text" name="sNombreLargoUM" id="sNombreLargoUM" class="form-control">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNombreCortoUM" class="col-form-label">Descripcion Corta </label>
                                    <input type="text" name="sNombreCortoUM" id="sNombreCortoUM" class="form-control">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstadoUM" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoUM" id="nEstadoUM">
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

    <div class="modal fade" id="formSN" tabindex="-1" role="dialog" aria-labelledby="formSNLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formSNLabel">Nuevo Serie Numero</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
           
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sNombreSN" class="col-form-label">Nombre</label>
                                    <input type="text" name="sNombreSN" id="sNombreSN" class="form-control">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sPrefijoSN" class="col-form-label">Serie</label>
                                    <input type="text" name="sPrefijoSN" id="sPrefijoSN" class="form-control" >
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sValorSN" class="col-form-label">Correlativo</label>
                                    <input type="text" name="sValorSN" id="sValorSN" class="form-control">
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


<!-- Configuracion General de la vista --> 
<script>

    $(document).ready(function(){

        fncValidarRol();

    });

    function fncValidarRol(){

        if($("body").data("nadmin") == 1){
            // es admin 
        } else {
            $("#btnCrearMetodoPago").hide();
            $("#btnCrearMetodoEnvio").hide();
            $("#btnCrearUnidadMedida").hide();

        }
    }

</script>
<!-- Configuracion -->


<!-- Metodos de pago -->
<script>
    $(function() {

        $('#sDetalleMP').summernote({
            tabsize: 2,
            height: 100,
            minHeight: null, 
            maxHeight: null,  
            toolbar: [
                ['style', ['bold', 'italic', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['view', [ 'codeview' ]],
            ]
        });

        // Formulario Clientes
        $("#btnCrearMetodoPago").on('click', function() {
            fncCleanAllMP();
            $("#formCEMetodoPago").find(".modal-title").html('Nuevo Tipo de pago');
            $("#formCEMetodoPago").data("nIdRegistro", 0);
            $("#formCEMetodoPago").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCEMetodoPago").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro = $("#formCEMetodoPago").data("nIdRegistro");
          
            var nIdMetodoPago = $("#nIdMetodoPago").val();
            var sDetalle      = $('#sDetalleMP').summernote('code');
            var sImagen       = $("#sImagenMP")[0].files[0];
            var nEstado       = $("#nEstadoMP").val();

            if (nIdMetodoPago == '0') {
                toastr.error('Error. Seleccione un tipo de metodo de pago. Porfavor verifique');
                return;
            } 

            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdMetodoPago', nIdMetodoPago);
            formData.append('sDetalle', sDetalle);
            formData.append('sImagen', sImagen);
            formData.append('nEstado', nEstado);


            fncGrabarSedeMetodoPago(formData, function(aryData) {
                if (aryData.success) {
                    fncCleanAllMP();
                    $("#formCEMetodoPago").modal("hide");
                    $("#tblMetodosPagos").bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarSedeMetodoPago(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
            var jsnData = {
                nIdRegistro: nIdRegistro
            };

            fncEjecutarEliminarSedeMetodoPago(jsnData, function(aryData) {

                if (aryData.success) {
                    $("#tblMetodosPagos").bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }

            });

        });
    }

    function fncMostrarSedeMetodoPago(nIdRegistro, sOpcion) {

        $("#formCEMetodoPago").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroSedeMetodoPago(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData = aryResponse.aryData;

                $("#nIdMetodoPago").val(aryData.nIdMetodoPago);
                $("#nEstadoMP").val(aryData.nEstado);


                $("#sDetalleMP").summernote('code', aryData.sDetalle ); 
                if (aryData.sImagen.length > 0) $("label[for='sImagenMP']").html(aryData.sImagen);

                if (sOpcion == 'editar') {
                    $('#sDetalleMP').summernote('enable');
                    fncEditForm("#formCEMetodoPago", "Editar Metodo de pago por sede");
                } else {
                    $('#sDetalleMP').summernote('disable');
                    fncViewForm("#formCEMetodoPago", "Ver Metodo de pago por sede");
                }

                $("#formCEMetodoPago").modal("show");

            } else {
                toastr.error(aryData.error);
            }
        });

    }

    // Funciones Auxiliares
    function fncCleanAllMP() {
        fncRemoveDisabled($("#formCEMetodoPago").find("form"));
        fncClearInputs($("#formCEMetodoPago").find("form"));
        $('#sDetalleMP').summernote('enable');
        $('#sDetalleMP').summernote('code','');
    }



    // Llamadas al servidor
 

    // MP 

    function fncGrabarSedeMetodoPago(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'metodosPago/fncGrabarSedeMetodoPago',
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

    function fncBuscarRegistroSedeMetodoPago(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'metodosPago/fncMostrarSedeMetodoPago',
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

    function fncEjecutarEliminarSedeMetodoPago(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'metodosPago/fncEliminarSedeMetodoPago',
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
<!-- Metodos de pago -->




<!-- Metodos de envio -->
<script>
    $(function() {

        $('#sDetalleME').summernote({
            tabsize: 2,
            height: 100,
            minHeight: null, 
            maxHeight: null,  
            toolbar: [
                ['style', ['bold', 'italic', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['view', [ 'codeview' ]],
            ]
        });

        // Formulario Clientes
        $("#btnCrearMetodoEnvio").on('click', function() {
            fncCleanAllME();
            $("#formCEMetodoEnvio").find(".modal-title").html('Nuevo Tipo de envios');
            $("#formCEMetodoEnvio").data("nIdRegistro", 0);
            $("#formCEMetodoEnvio").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCEMetodoEnvio").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro     = $("#formCEMetodoEnvio").data("nIdRegistro");
            var nIdMetodoEnvio  = $("#nIdMetodoEnvio").val();
            var sDetalle        = $('#sDetalleME').summernote('code');
            var sImagen         = $("#sImagenME")[0].files[0];
            var nEstado         = $("#nEstadoME").val();

            if (nIdMetodoEnvio == '0') {
                toastr.error('Error. Seleccione un tipo de metodo de envio. Porfavor verifique');
                return;
            } 

            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdMetodoEnvio', nIdMetodoEnvio);
            formData.append('sDetalle', sDetalle);
            formData.append('sImagen', sImagen);
            formData.append('nEstado', nEstado);


            fncGrabarSedeMetodoEnvio(formData, function(aryData) {
                if (aryData.success) {
                    fncCleanAllME();
                    $("#formCEMetodoEnvio").modal("hide");
                    $("#tblMetodosEnvios").bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

       



    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarSedeMetodoEnvio(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){

            var jsnData = {
                nIdRegistro: nIdRegistro
            };

            fncEjecutarEliminarSedeMetodoEnvio(jsnData, function(aryData) {

                if (aryData.success) {
                    $("#tblMetodosEnvios").bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }

            });
             
        });
    }

    function fncMostrarSedeMetodoEnvio(nIdRegistro, sOpcion) {

        $("#formCEMetodoEnvio").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroSedeMetodoEnvio(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData = aryResponse.aryData;

                $("#nIdMetodoEnvio").val(aryData.nIdMetodoEnvio);
                $("#nEstadoME").val(aryData.nEstado);


                $("#sDetalleME").summernote('code', aryData.sDetalle ); 
                if (aryData.sImagen.length > 0) $("label[for='sImagenME']").html(aryData.sImagen);

                if (sOpcion == 'editar') {
                    $('#sDetalleME').summernote('enable');
                    fncEditForm("#formCEMetodoEnvio", "Editar Metodo de envio por sede");
                } else {
                    $('#sDetalleME').summernote('disable');
                    fncViewForm("#formCEMetodoEnvio", "Ver Metodo de envio por sede");
                }

                $("#formCEMetodoEnvio").modal("show");

            } else {
                toastr.error(aryData.error);
            }
        });

    }

    // Funciones Auxiliares
    function fncCleanAllME() {
        fncRemoveDisabled($("#formCEMetodoEnvio").find("form"));
        fncClearInputs($("#formCEMetodoEnvio").find("form"));
        $('#sDetalleME').summernote('enable');
        $('#sDetalleME').summernote('code','');
    }



    // Llamadas al servidor
 

    // MP 

    function fncGrabarSedeMetodoEnvio(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'metodosEnvio/fncGrabarSedeMetodoEnvio',
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

    function fncBuscarRegistroSedeMetodoEnvio(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'metodosEnvio/fncMostrarSedeMetodoEnvio',
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

    function fncEjecutarEliminarSedeMetodoEnvio(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'metodosEnvio/fncEliminarSedeMetodoEnvio',
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
<!-- Metodos de envio -->


<!-- Unidades de medida -->
<script>
    $(function() {

        $("#unidad-medida-tab").on('click',function(){

            var aryData = $("#tblUnidadesMedidas").bootstrapTable("getData");

            if(aryData.length == 0){
                if(confirm("¿Deseas importar las unidades de medida por default?")){
                    fncImportarUnidadesMedidasPorDefault(null,(aryData)=>{

                        if(aryData.success){

                            $("#tblUnidadesMedidas").bootstrapTable("refresh");

                            toastr.success(aryData.success);

                        }else{
                            toastr.error(aryData.error);
                        }

                    });

                }
            }
        });

        // Formulario UM
        $("#btnCrearUnidadMedida").on('click', function() {
            fncCleanAllUM();
            $("#formCEUM").find(".modal-title").html('Nueva Unidad de Medida');
            $("#formCEUM").data("nIdRegistro", 0);
            $("#formCEUM").modal("show");
        });

        // Submit del formulario 
        $("#formCEUM").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro         = $("#formCEUM").data("nIdRegistro");
            var sNombreLargo        = $('#sNombreLargoUM').val();
            var sNombreCorto        = $('#sNombreCortoUM').val();
            var nEstado             = $("#nEstadoUM").val();

            if (sNombreCorto == '') {
                toastr.error('Error. Ingrese una descripcion corta . Porfavor verifique');
                return;
            } else if (sNombreLargo == ''){
                toastr.error('Error. Ingrese una descripcion larga . Porfavor verifique');
                return;
            }


            var jsnData = {
                nIdRegistro      : nIdRegistro,
                sNombreLargo     : sNombreLargo,
                sNombreCorto     : sNombreCorto,
                nEstado          : nEstado,
            };
 

            fncGrabarUnidadMedida(jsnData, function(aryData) {
                if (aryData.success) {
                    
                    fncCleanAllUM();

                    $("#tblUnidadesMedidas").bootstrapTable("refresh");
                    $("#formCEUM").modal("hide");
    
                    toastr.success(aryData.success);
                    
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

    });

 

    // Funciones de la tabla o layout Principal 

    function fncEliminarUM(nIdRegistro) {


        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){

            // Succes Function

            var jsnData = {
                nIdRegistro: nIdRegistro
            };

            fncEjecutarEliminarUM(jsnData, function(aryData) {

                if (aryData.success) {
                    $("#tblUnidadesMedidas").bootstrapTable("refresh");
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }

            });
             
        });
        
    }

    function fncMostrarUM(nIdRegistro, sOpcion) {

        $("#formCEUM").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarUM(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData = aryResponse.aryData;

                $("#sNombreLargoUM").val(aryData.sNombreLargo);
                $("#sNombreCortoUM").val(aryData.sNombreCorto);
                $("#nEstadoUM").val(aryData.nEstado);

            
                if (sOpcion == 'editar') {
                    fncEditForm("#formCEUM", "Editar Unidad de medida");
                } else {
                    fncViewForm("#formCEUM", "Ver Unidad de medida");
                }

                $("#formCEUM").modal("show");

            } else {
                toastr.error(aryData.error);
            }
        });

    }

    // Funciones Auxiliares
    function fncCleanAllUM() {
        fncRemoveDisabled($("#formCEUM").find("form"));
        fncClearInputs($("#formCEUM").find("form"));
    }



    // Llamadas al servidor

    function fncGrabarUnidadMedida(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'unidadesMedida/fncGrabarUnidadMedida',
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

    function fncBuscarUM(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'unidadesMedida/fncMostrarRegistro',
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

    function fncEjecutarEliminarUM(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'unidadesMedida/fncEliminarRegistro',
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

    function fncImportarUnidadesMedidasPorDefault(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'unidadesMedida/fncImportarUnidadesMedidasPorDefault',
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
<!--  Unidades de medida -->


<!-- Series Numeros -->
<script>
    $(function() {

        $("#btnCrearSN").on("click",function(){
            
            fncCleanAllSN();
            $("#sValorSN").val("000000000");
            $("#formSN").find(".modal-title").html('Nuevo Serie y correlativo');
            $("#formSN").data("nIdRegistro", 0);
            $("#formSN").modal("show");

        });
       
        // Submit del formulario de Cliente
        $("#formSN").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro    = $("#formSN").data("nIdRegistro");
            var sNombre        = $("#sNombreSN").val();
            var sPrefijo       = $("#sPrefijoSN").val();
            var sValor         = $("#sValorSN").val();
 
 
            if (sNombre == '') {
                toastr.error('Error. Debe de ingresar un nombre . Porfavor verifique');
                return;
            } else if (sPrefijo == '') {
                toastr.error('Error. Debe de ingresar una serie . Porfavor verifique');
                return;
            } else if (sValor == '') {
                toastr.error('Error. Debe de ingresar un correlativo . Porfavor verifique');
                return;
            } 

            var jsnData = {
                nIdRegistro : nIdRegistro,
                sNombre     : sNombre,
                sPrefijo    : sPrefijo,
                sValor      : sValor,
            };

            fncGrabarSerieNumero(jsnData, function(aryData) {
                if (aryData.success) {
                    fncCleanAllSN();
                    $("#formSN").modal("hide");
                    $("#tblSerieNumeros").bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

       
    });

    // Funciones de la tabla o layout Principal 

 

    function fncMostrarSN(nIdRegistro, sOpcion) {

        $("#formSN").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroSN(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData = aryResponse.aryData;

                $("#sNombreSN").val(aryData.sNombre);
                $("#sPrefijoSN").val(aryData.sPrefijo);
                $("#sValorSN").val(aryData.sValor);

                if (sOpcion == 'editar') {
                    fncEditForm("#formSN", "Editar Serie y Correlativo");
                } else {
                    fncViewForm("#formSN", "Ver Serie y Correlativo");
                }

                $("#formSN").modal("show");

            } else {
                toastr.error(aryData.error);
            }
        });

    }

    function fncEliminarSN (nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){

            var jsnData = {
                nIdRegistro: nIdRegistro
            };

            fncEjecutarEliminarSN(jsnData, function(aryData) {

                if (aryData.success) {
                    $("#tblSerieNumeros").bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }

            });
             
        });
    }

    // Funciones Auxiliares
    function fncCleanAllSN() {
        fncRemoveDisabled($("#formSN").find("form"));
        fncClearInputs($("#formSN").find("form"));
    }



    // Llamadas al servidor
 

 
    function fncGrabarSerieNumero(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'serieNumeros/fncGrabarSerieNumero',
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

    function fncBuscarRegistroSN(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'serieNumeros/fncMostrarRegistro',
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

    function fncEjecutarEliminarSN(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'serieNumeros/fncEliminarRegistro',
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
    
</script>
<!-- Series Numeros -->






</html>