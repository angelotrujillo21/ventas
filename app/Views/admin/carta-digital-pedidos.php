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

                                        <div id="toolbar" class="btn-group row">
                                            <div class="col-md-6 sin-padding container-buttons-table">
                                                <button id="btnFiltros" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <button id="btnRefresh" class="btn btn-gradient-primary-table mr-1" type="button" title="Actualizar">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                                <button id="btnLimpiarFiltros" class="btn btn-gradient-primary-table mr-2" type="button" title="Limpiar filtros">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table id="tblPrincipal" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sIdPedidoCD" data-sortable="true">ID</th>
                                                            <th data-field="sCliente" data-sortable="true">Cliente</th>
                                                            <th data-field="sMesa" data-sortable="true">Mesa</th>
                                                            <th data-field="nTotal" data-sortable="true">Total</th>
                                                            <th data-field="sEstadoAprobacion" data-sortable="true">Aprobacion</th>
                                                            <th data-field="sVenta" data-sortable="true">Venta</th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha Creacion</th>
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
    <div class="modal fade modal-full-screen" id="formCERegistro" tabindex="-1" role="dialog" aria-labelledby="formCERegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCELoteLabel">Nuevo Registro</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body modal-body-scroll">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nIdCartaDigital" class="col-form-label">Carta Digital <span class="text-danger">*</span></label>
                                            <select class="form-control" name="nIdCartaDigital" id="nIdCartaDigital">
                                                <option value="0">Seleccionar</option>
                                                <?php foreach ($aryCartaDigital as $aryLoop) : ?>
                                                    <option value="<?= $aryLoop["nIdCartaDigital"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="sCliente" class="col-form-label">Cliente <span class="text-danger">*</span></label>
                                            <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCliente" id="sCliente">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nIdMesa" class="col-form-label">Mesa <span class="text-danger">*</span></label>
                                            <select class="form-control" name="nIdMesa" id="nIdMesa">
                                                <option value="0">Seleccionar</option>
                                                <?php foreach ($aryMesas as $aryLoop) : ?>
                                                    <option value="<?= $aryLoop["nIdMesa"] ?>"><?= $aryLoop["sDescripcion"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nIdEstado" class="col-form-label">Estado aprobacion <span class="text-danger">*</span></label>
                                            <select class="form-control" name="nIdEstado" id="nIdEstado">
                                                <option value="0">Seleccionar</option>
                                                <?php foreach ($aryIdEstado as $aryLoop) : ?>
                                                    <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sObservacion" class="col-form-label">Observacion</label>
                                            <textarea class="form-control" name="sObservacion" id="sObservacion" cols="30" rows="2"></textarea>
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

                            <div class="col-md-6">
                                <div class="row my-2">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-2">
                                            <div class="flex-center">
                                                <h5>Listado Productos</h5>
                                            </div>

                                            <div class="ml-auto">
                                                <button id="btnCrearItem" type="button" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-12">
                                        <table id="tblDetalle" data-toggle="table" data-unique-id="nIdRow" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="false" data-buttons-align="left" data-show-columns="true" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-sort-name="nIdRow" data-sort-order="asc">
                                            <thead>
                                                <tr>
                                                    <th data-field="sAcciones">Acciones</th>
                                                    <th data-field="nIdRow" data-visible="false">nIdRow</th>
                                                    <th data-field="sProducto" data-sortable="false">Producto</th>
                                                    <th data-field="nCantidad" data-sortable="false">Cantidad</th>
                                                    <th data-field="nPrecio" data-sortable="false">Precio</th>
                                                    <th data-field="nTotal" data-sortable="false">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="nTotal" class="col-form-label">Total</label>
                                            <input class="form-control" name="nTotal" id="nTotal" readonly disabled />
                                        </div>
                                    </div>
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

    <div class="modal fade" id="formCEDetalle" tabindex="-1" role="dialog" aria-labelledby="formCEDetalleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEDetalleLabel">Nuevo Producto</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdProductoD" class="col-form-label">Producto</label>
                                    <select class="form-control" name="nIdProductoD" id="nIdProductoD"></select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nCantidadD" class="col-form-label">Cantidad <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="nCantidadD" id="nCantidadD">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nPrecioD" class="col-form-label">Precio <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="nPrecioD" id="nPrecioD" readonly disabled>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nTotalD" class="col-form-label">Total <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="nTotalD" id="nTotalD" readonly disabled>
                                </div>
                            </div>


                            <div class="col-12 col-md-12 contentExtras my-2">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <strong>Extras</strong>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div id="contenedorFormExtras"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sObservacionD" class="col-form-label">Comentario</label>
                                    <textarea placeholder="" class="form-control" name="sObservacionD" id="sObservacionD"></textarea>
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

    <div class="modal fade" id="formFilter" tabindex="-1" role="dialog" aria-labelledby="formFilterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formFilterLabel">Filtros</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sIdsEstado" class="col-form-label">Atencion</label>
                                    <select class="form-control" name="sIdsEstado" id="sIdsEstado" multiple>
                                        <?php if (fncValidateArray($aryIdEstado)) : ?>
                                            <?php foreach ($aryIdEstado as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="dFechaInicio" class="col-form-label">Desde:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaInicio" autocomplete="off" name="dFechaInicio">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="dFechaFin" class="col-form-label">Hasta:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaFin" autocomplete="off" name="dFechaFin">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fin de modales -->
    <?php extend_view(['admin/common/footer'], $data) ?>
</body>


<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- Pedidos -->
<script>
    window.jsnDataFiltros = null;
    $(function() {

        $("#btnCrearRegistro").on('click', function() {
            fncCleanAll();
            fncOcultarAside();
            $("#formCERegistro").find(".modal-title").html('Nuevo Pedido');
            $("#formCERegistro").data("nIdRegistro", 0);
            $("#tblDetalle").data("nIdRow", 0);
            $("#nIdEstado").val('<?= $nIdEstadoPendiente ?>');
            $("#tblDetalle").bootstrapTable("load", []);
            $("#formCERegistro").modal("show");
        });

        // Submit del formulario de banco
        $("#formCERegistro").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro = $("#formCERegistro").data("nIdRegistro");
            var sCliente = $("#sCliente").val().trim().toUpperCase();
            var nIdEstado = $("#nIdEstado").val();
            var sObservacion = $("#sObservacion").val().trim();
            var nEstado = $("#nEstado").val();
            var nTotal = $("#nTotal").val();
            var nIdMesa = $("#nIdMesa").val();
            var nIdCartaDigital = $("#nIdCartaDigital").val();
            var aryDetalle = $("#tblDetalle").bootstrapTable("getData");

            if (nIdCartaDigital == '0') {
                toastr.error('Error. Debe de seleccionar una carta digial .Porfavor verifique');
                return false;
            }

            if (sCliente == '') {
                toastr.error('Error. Debe ingresar el nombre cliente .Porfavor verifique');
                return false;
            }

            if (nIdMesa == '0') {
                toastr.error('Error. Debe ingresar la mesa .Porfavor verifique');
                return false;
            }

            if (nIdEstado == '0') {
                toastr.error('Error. Debe ingresar un estado de atencion .Porfavor verifique');
                return false;
            }

            if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar al menos un producto o item. Porfavor verifique');
                return false;
            }

            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdCartaDigital', nIdCartaDigital);
            formData.append('nIdEmpresa', '<?= $user["nIdEmpresa"] ?>');
            formData.append('nIdSede', '<?= $user["nIdSede"] ?>');
            formData.append('sCliente', sCliente);
            formData.append('nIdEstado', nIdEstado);
            formData.append('sObservacion', sObservacion);
            formData.append('aryDetalle', JSON.stringify(aryDetalle));
            formData.append('nEstado', nEstado);
            formData.append('nIdMesa', nIdMesa);
            formData.append('nTotal', nTotal);

            fncGrabarRegistro(formData, function(aryData) {
                if (aryData.success) {
                    fncCleanAll();
                    $("#formCERegistro").modal("hide");
                    fncPopulate();
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

        $("#nIdCartaDigital").on("change", function() {

            // Limpiar el detalle
            $("#tblDetalle").bootstrapTable("load", []);
            $("#nIdProductoD").empty();
            fncCalcularTotales();
            if ($(this).val() == 0) {
                return;
            }

            // Pintar los productos de la carta digital
            fncDrawProductos("#nIdProductoD", {
                nIdRegistro: $(this).val()
            });
        });

    });

    function fncDrawProductos(sHtmlTag, jsnData, nIdProducto = null) {
        fncMostrarCD(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                let sOptions = ``;

                aryResponse.aryDetalle.forEach(elementSeccion => {

                    // Obtener los productos de la seccion
                    var arySD = JSON.parse(elementSeccion.aryDetalle);

                    arySD.forEach(element => {
                        sOptions += `<option data-jsnextra='${JSON.stringify(element.aryExtras)}' data-precio="${element.nPrecioProducto}" value="${element.nIdProducto}">${element.sProducto}</option>`;
                    });

                });

                $(sHtmlTag).html(sOptions);
                $(sHtmlTag).val(nIdProducto).trigger("change.select2");
                toastr.success("Mostrando productos de la carta digital...");
            } else {
                toastr.error(aryResponse.error);
            }

        });

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
                        fncPopulate();
                        toastr.success(aryData.success);
                    } else {
                        toastr.error(aryData.error);
                    }

                });


            });

    }

    function fncMostrarRegistro(nIdRegistro, sOpcion) {

        $("#formCERegistro").data("nIdRegistro", nIdRegistro);
        $("#formCERegistro").data("sOpcion", sOpcion);
        fncOcultarAside();

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistro(jsnData, function(aryResponse) {
            if (aryResponse.success) {

                var aryData = aryResponse.aryData;
                var aryDetalle = aryResponse.aryDetalle;

                $("#nIdCartaDigital").val(aryData.nIdCartaDigital);
                $("#sCliente").val(aryData.sCliente);
                $("#nIdEstado").val(aryData.nIdEstado);
                $("#sObservacion").val(aryData.sObservacion);
                $("#nIdMesa").val(aryData.nIdMesa);
                $("#nEstado").val(aryData.nEstado);

                $("#tblDetalle").bootstrapTable("load", aryDetalle);
                $("#tblDetalle").data("nIdRow", aryDetalle.length);
                fncCalcularTotales();


                if (sOpcion == 'editar') {
                    fncEditForm("#formCERegistro", "Editar Pedido");
                } else {
                    fncViewForm("#formCERegistro", "Ver Pedido");
                }

                // Pintar los productos de la carta digital
                fncDrawProductos("#nIdProductoD", {
                    nIdRegistro: aryData.nIdCartaDigital
                });

                $("#formCERegistro").modal("show");
            } else {
                toastr.error(aryData.error);
            }
        });

    }

    // Funciones Auxiliares
    function fncCleanAll() {
        fncRemoveDisabled($("#formCERegistro").find("form"));
        fncClearInputs($("#formCERegistro").find("form"));
    }

    // Llamadas al servidor
    function fncGrabarRegistro(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cartaDigital/fncGrabarPedido',
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
            url: web_root + 'cartaDigital/fncMostrarPedido',
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
            url: web_root + 'cartaDigital/fncEliminarPedido',
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

    function fncMostrarCD(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            url: web_root + 'cartaDigital/fncMostrarRegistro',
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

<!-- Detalle -->
<script>
    $(function() {

        $("#nIdProductoD").select2();
        // Formulario
        $("#btnCrearItem").on('click', function() {
            fncCleanAllD();

            if ($("#nIdCartaDigital").val() == '0') {
                toastr.error('Error. Debe de seleccionar una carta digial .Porfavor verifique');
                return false;
            }

            $("#formCEDetalle").find(".modal-title").html('Nueva Producto');
            $("#formCEDetalle").data("nIdRegistro", 0);
            $("#nIdProductoD").val(null).trigger("change.select2");
            $("#nCantidadD").val(1);
            $(".contentExtras").hide();
            $("#contenedorFormExtras").html("");
            $("#formCEDetalle").modal("show");
        });

        $("#formCEDetalle").find("form").on('submit', function(event) {
            event.preventDefault();

            var nIdRegistro = $("#formCEDetalle").data("nIdRegistro");
            var nIdProducto = $("#nIdProductoD").val();
            var nPrecio = $("#nPrecioD").val();
            var nTotal = $("#nTotalD").val();
            var sProducto = $("#nIdProductoD option:selected").text();
            var nCantidad = $("#nCantidadD").val();
            var sObservacion = $("#sObservacionD").val().trim();

            if (nIdProducto == null) {
                toastr.error('Error. Debe seleccionar el producto. Porfavor verifique');
                return;
            }

            if (nCantidad == '' || isNaN(nCantidad) || nCantidad <= 0) {
                toastr.error('Error. Debe ingresar la cantidad. Porfavor verifique');
                return;
            }

            var aryValuesExtras = [];
            var aryExtras = $("#nIdProductoD").find("option:selected").data("jsnextra");

            if (aryExtras.length > 0) {
                aryExtras.forEach(element => {

                    if (element.nTipo == 1) {
                        aryValuesExtras.push({
                            nIDCDExtra: element.nIDCDExtra,
                            nTipo: element.nTipo,
                            sNombre: element.sNombre,
                            sValores: $("#extra" + element.nIDCDExtra).val()
                        });
                    } else if (element.nTipo == 2) {

                        var aruySeleccionados = $('input[name="extra' + element.nIDCDExtra + '[]"]:checked').map(function() {
                            return this.value;
                        }).get();

                        aryValuesExtras.push({
                            nIDCDExtra: element.nIDCDExtra,
                            nTipo: element.nTipo,
                            sNombre: element.sNombre,
                            sValores: aruySeleccionados.join(",")
                        });
                    }
                });
            }

            if (nIdRegistro == 0) {

                var nIdRow = $('#tblDetalle').data("nIdRow") + 1;

                sLinkEdit = "fncEditarDetalle(" + nIdRow + " , 'editar')";
                sLinkDelete = "fncEliminarDetalle(" + nIdRow + ")";

                var sAcciones = `
                <div class="content-acciones">
                    <a onclick="${sLinkEdit}" href="javascript:;" class="text-primary" title="Editar"><i class="material-icons">edit</i></a>
                    <a onclick="${sLinkDelete}" href="javascript:;" class="text-danger" title="Eliminar"><i class="material-icons">delete</i></a>
                </div>`;

                var jsnData = {
                    nIdRegistro: nIdRegistro,
                    sAcciones: sAcciones,
                    nIdRow: nIdRow,
                    nIdDetalle: 0,
                    nIdProducto: nIdProducto,
                    nCantidad: nCantidad,
                    nPrecio: nPrecio,
                    nTotal: nTotal,
                    sProducto: sProducto,
                    sObservacion: sObservacion,
                    aryExtras: JSON.stringify(aryExtras),
                    aryValuesExtras: JSON.stringify(aryValuesExtras)
                };

                $('#tblDetalle').bootstrapTable('insertRow', {
                    index: 1,
                    row: jsnData
                });
                $('#tblDetalle').data("nIdRow", nIdRow);
            } else {

                jsnData = $('#tblDetalle').bootstrapTable('getRowByUniqueId', nIdRegistro);

                jsnData.nIdProducto = nIdProducto;
                jsnData.sProducto = sProducto;
                jsnData.nCantidad = nCantidad;
                jsnData.nPrecio = nPrecio;
                jsnData.nTotal = nTotal;
                jsnData.sObservacion = sObservacion;
                jsnData.aryExtras = JSON.stringify(aryExtras);
                jsnData.aryValuesExtras = JSON.stringify(aryValuesExtras);

                $('#tblDetalle').bootstrapTable('updateByUniqueId', {
                    nIdRow: jsnData.nIdRow,
                    row: jsnData
                });

            }

            $("#formCEDetalle").modal("hide");
            fncCalcularTotales();
        });

        $("#nIdProductoD").change(function() {
            $("#nPrecioD").val(parseFloat($(this).find("option:selected").data("precio")).toFixed(2));
            $("#nCantidadD").keyup();

            var aryExtras = $(this).find("option:selected").data("jsnextra");
            $(".contentExtras").hide();
            if (aryExtras.length > 0) {
                $(".contentExtras").show();
                fncDrawExtras(aryExtras, "#contenedorFormExtras");
            }

        });

        $("#nCantidadD").on("keyup blur", function() {
            var nCantidad = $(this).val() == '' || isNaN($(this).val()) || $(this).val() < 0 ? 0 : parseFloat($(this).val());
            var nPrecio = $("#nPrecioD").val() == '' || isNaN($("#nPrecioD").val()) || $("#nPrecioD").val() < 0 ? 0 : parseFloat($("#nPrecioD").val());
            var nTotal = nCantidad * nPrecio;
            $("#nTotalD").val(nTotal.toFixed(2));
        });
    });


    function fncDrawExtras(aryConfig, sHtmlTag, aryValues = []) {

        var sHTML = ``;

        aryConfig.forEach(element => {

            var aryOptions = element.sValores.split(",");

            if (element.nTipo == 1) {

                sHTML += `<div class="form-group mb-2"><label for="extra${element.nIDCDExtra}" class="col-form-label">${element.sNombre}</label>
                        <select class="form-control" id="extra${element.nIDCDExtra}">`;

                aryOptions.forEach(element => {
                    sHTML += `<option value="${element.trim()}">${element.trim()}</option>`
                });

                sHTML += `</select></div>`;

            } else if (element.nTipo == 2) {

                sHTML += `<div class="form-group mb-2"><label class="col-form-label">${element.sNombre}</label><div class="row">`;

                aryOptions.forEach(elementD => {
                    sHTML += `<div class="col-12">
                        <input type="checkbox" clas="form-control" name="extra${element.nIDCDExtra}[]" id="${elementD.trim()}" value="${elementD.trim()}">
                        <label for="${elementD.trim()}">${elementD.trim()}</label>
                    </div>`;
                });

                sHTML += `</div></div>`;

            }
        });

        $(sHtmlTag).html(sHTML);

        if (aryValues.length > 0) {

            setTimeout(() => {

                aryValues.forEach(element => {
                    if (element.nTipo == 1) {
                        $("#extra" + element.nIDCDExtra).val(element.sValores);
                    } else if (element.nTipo == 2) {
                        var aryValores = element.sValores.length > 0 ? element.sValores.split(',').map((valor) => valor.trim()) : "";
                        $('input[name="extra' + element.nIDCDExtra + '[]"]').val(aryValores);
                    }
                });

            }, 700);

        }

    }

    function fncEditarDetalle(nIdRow) {
        var jsnRow = $("#tblDetalle").bootstrapTable('getRowByUniqueId', nIdRow);
        $("#formCEDetalle").data("nIdRegistro", jsnRow.nIdRow);
        $("#nIdProductoD").val(jsnRow.nIdProducto).trigger("change.select2");
        $("#nCantidadD").val(jsnRow.nCantidad);
        $("#nPrecioD").val(jsnRow.nPrecio);
        $("#nTotalD").val(jsnRow.nTotal);
        $("#sObservacionD").val(jsnRow.sObservacion);

        // Extras 
        $(".contentExtras").hide();
        if (jsnRow.aryExtras.trim().length > 0) {
            var aryExtras = JSON.parse(jsnRow.aryExtras);
            var aryValuesExtras = JSON.parse(jsnRow.aryValuesExtras);

            if (aryExtras.length > 0) {
                $(".contentExtras").show();
                fncDrawExtras(aryExtras, "#contenedorFormExtras", aryValuesExtras);
            }

        }

        $("#formCEDetalle").find(".modal-title").html('Editar Item');
        $('#formCEDetalle').modal('show');
    }

    function fncEliminarDetalle(nIdRow) {
        if (confirm('Advertencia. Esta acción no se puede deshacer. ¿Continuar?')) {
            $("#tblDetalle").bootstrapTable('removeByUniqueId', nIdRow);
            fncCalcularTotales();
        }
    }

    function fncCalcularTotales() {
        var aryData = $('#tblDetalle').bootstrapTable("getData");
        var nTotal = 0;
        if (aryData.length > 0) {
            aryData.forEach(element => {
                nTotal += parseFloat(element.nTotal);
            });
        }
        $("#nTotal").val(parseFloat(nTotal).toFixed(2));
    }

    // Funciones Auxiliares
    function fncCleanAllD() {
        fncRemoveDisabled($("#formCEDetalle").find("form"));
        fncClearInputs($("#formCEDetalle").find("form"));
    }
</script>

<!-- Filtros -->
<script>
    $(function() {

        $("#sIdsEstado").select2({
            placeholder: "TODOS"
        });

        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();

            var sIdsEstado = $("#sIdsEstado :selected").map(function(nIndex, item) {
                return $(item).val();
            }).get();


            var dFechaInicio = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin = $('#dFechaFin').datepicker('getDate');

            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de inicio y fin. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }

            window.jsnDataFiltros = {
                sIdsEstado: sIdsEstado.join(","),
                dFechaInicio: $('#dFechaInicio').val(),
                dFechaFin: $('#dFechaFin').val(),
            };

            fncPopulate(window.jsnDataFiltros, "#formFilter");
        });

        $("#btnFiltros").on("click", function() {
            $("#formFilter").modal("show");
        });

        $("#btnRefresh").on("click", function() {
            fncPopulate();
        });

        $("#btnLimpiarFiltros").on("click", function() {
            window.jsnDataFiltros = null;
            fncClearFilterM();
            fncPopulate(window.jsnDataFiltros);
        });


        // Por defecto cargar las pendientes y solo el dia de hoy
        $("#sIdsEstado").val(['<?= $nIdEstadoPendiente ?>']).change();
        $("#dFechaInicio,#dFechaFin").val('<?= date("d/m/Y") ?>');
        $("#formFilter").find("form").submit();
        // setInterval(() => {
        //     fncPopulate();
        // }, 20000);

    });

    function fncPopulate(jsnData = window.jsnDataFiltros, sModal = '') {
        fncEjecutarPopulate(jsnData, function(aryData) {
            $("#tblPrincipal").bootstrapTable("load", aryData);
            if (sModal != '') {
                $(sModal).modal("hide");
            }
        });
    }

    function fncClearFilterM() {
        $("#sIdsEstado").val([]).trigger("change.select2");
        $("#dFechaInicio,#dFechaFin").val("");
    }

    // Llamadas al servidor
    function fncEjecutarPopulate(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cartaDigital/fncPopulatePedido',
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


</html>