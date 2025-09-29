<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>
    <link href="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css" rel="stylesheet">
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
                                                <table id="tblPrincipal" data-url="<?= route('cartaDigital/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
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
    <div class="modal fade" id="formCERegistro" tabindex="-1" role="dialog" aria-labelledby="formCERegistroLabel" aria-hidden="true">
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
                            <div class="col-md-12">
                                <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="datos-cd-tab" data-toggle="tab" href="#datos-cd" role="tab" aria-controls="datos-cd" aria-selected="true">Datos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="estilos-cd-tab" data-toggle="tab" href="#estilos-cd" role="tab" aria-controls="estilos-cd" aria-selected="false">Estilos</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="datos-cd" role="tabpanel" aria-labelledby="datos-cd-tab">
                                        <div class="row">

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="sNombre" class="col-form-label">Nombre <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombre" id="sNombre">
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

                                            <div class="col-12 my-2">
                                                <div class="d-flex align-items-center p-2">

                                                    <div class="flex-center">
                                                        <h5>Listado Secciones</h5>
                                                    </div>

                                                    <div class="ml-auto">
                                                        <button id="btnCrearSeccion" type="button" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <table id="tblDetalle" data-toggle="table" data-use-row-attr-func="true" data-reorderable-rows="true" data-unique-id="nIdRow" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="false" data-buttons-align="left" data-show-columns="true" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-sort-name="nOrden" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="nIdRow" data-visible="false">nIdRow</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                            <th data-field="nOrden" data-sortable="true">Orden</th>
                                                            <th data-field="nCantidadItems" data-sortable="true">Items</th>
                                                            <th data-field="sEstado" data-sortable="true">Estado</th>
                                                            <th data-field="aryDetalle" data-visible="false" data-sortable="true">aryDetalle</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="estilos-cd" role="tabpanel" aria-labelledby="estilos-cd-tab">


                                        <div class="row">

                                            <div class="col-12 mt-2">
                                                <h6 class="mb-0">Colores</h6>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor1" class="col-form-label">Color 1 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor1" id="sColor1">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor2" class="col-form-label">Color 2 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor2" id="sColor2">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor3" class="col-form-label">Color 3 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor3" id="sColor3">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor4" class="col-form-label">Color 4 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor4" id="sColor4">
                                                </div>
                                            </div>


                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor5" class="col-form-label">Color 5 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor5" id="sColor5">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor6" class="col-form-label">Color 6 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor6" id="sColor6">
                                                </div>
                                            </div>


                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor7" class="col-form-label">Color 7 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor7" id="sColor7">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor8" class="col-form-label">Color 8 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor8" id="sColor8">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor9" class="col-form-label">Color 9 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor9" id="sColor9">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor10" class="col-form-label">Color 10<span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor10" id="sColor10">
                                                </div>
                                            </div>


                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor11" class="col-form-label">Color 11 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor11" id="sColor11">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor12" class="col-form-label">Color 12 <span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor12" id="sColor12">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="sColor13" class="col-form-label">Color 13<span class="text-info">(i)</span> <span class="text-danger">*</span></label>
                                                    <input type="text" autocomplete="off" placeholder="Color" class="form-control" name="sColor13" id="sColor13">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <h6 class="mb-0">Imagen de fondo</h6>
                                            </div>

                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="sImagen" class="col-form-label">Fondo principal</label>
                                                    <input type="file" autocomplete="off" placeholder="Color" class="form-control" name="sImagen" id="sImagen">
                                                    <img id="sImagenFP" width="100" src="" alt="Imagen">
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <h6 class="mb-0">Imagen de cabecera</h6>
                                            </div>

                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="sImagenHeader" class="col-form-label">Fondo de la cabecera</label>
                                                    <input type="file" autocomplete="off" placeholder="Color" class="form-control" name="sImagenHeader" id="sImagenHeader">
                                                    <img id="sImagenH" width="100" src="" alt="Imagen">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <h6 class="mb-0">Leyenda</h6>
                                                <ul>
                                                    <li>
                                                        <strong>Color 1:</strong>
                                                        <span id="sDetalleC1">
                                                            Color de fondo para la cabecera de la carta en caso no quieras utilizar un fondo dejarlo con valor none, en caso tengas una imagen como fondo para la cabecera este color tambien lo puedes utilizar como mascara
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 2:</strong>
                                                        <span id="sDetalleC2">
                                                            Color de texto para la cabecera de la carta
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 3:</strong>
                                                        <span id="sDetalleC3">
                                                            Color de fondo para los botones
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 4:</strong>
                                                        <span id="sDetalleC4">
                                                            Color de texto para los botones
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 5:</strong>
                                                        <span id="sDetalleC5">
                                                            Color fondo para cada seccion
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 6:</strong>
                                                        <span id="sDetalleC6">
                                                            Color de texto para cada seccion
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 7:</strong>
                                                        <span id="sDetalleC7">
                                                            Color de texto para el titulo del producto
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 8:</strong>
                                                        <span id="sDetalleC8">
                                                            Color de texto para el detalle del producto
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 9:</strong>
                                                        <span id="sDetalleC9">
                                                            Color de texto para el precio
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 10:</strong>
                                                        <span id="sDetalleC10">
                                                            Color de texto para el separador
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 11:</strong>
                                                        <span id="sDetalleC11">
                                                            Color de texto para el boton de editar en la ventana ver pedido
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 12:</strong>
                                                        <span id="sDetalleC12">
                                                            Color de texto para el boton de eliminar en la ventana ver pedido
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <strong>Color 13:</strong>
                                                        <span id="sDetalleC13">
                                                            Color de fondo para la mascara de la carta para la capa superior del fondo principal
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>


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

    <div class="modal fade" id="formCENS" tabindex="-1" role="dialog" aria-labelledby="formCENSLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCENSLabel">Nueva Seccion</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body modal-body-scroll">

                        <div class="row">

                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label for="sNombreS" class="col-form-label">Nombre Seccion <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreS" id="sNombreS">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nEstadoS" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoS" id="nEstadoS">
                                        <option value="1">ACTIVO</option>
                                        <option value="0">DESACTIVO</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row my-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center p-2">

                                    <div class="flex-center">
                                        <h5>Listado Productos</h5>
                                    </div>

                                    <div class="ml-auto">
                                        <button id="btnCrearPS" type="button" class="btn btn-gradient-primary btn-rounded btn-icon">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <table id="tblListadoPS" data-toggle="table" data-unique-id="nIdRow" data-use-row-attr-func="true" data-reorderable-rows="true" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="false" data-buttons-align="left" data-show-columns="true" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-sort-name="nOrden" data-sort-order="asc">
                                    <thead>
                                        <tr>
                                            <th data-field="sAcciones">Acciones</th>
                                            <th data-field="nIdRow" data-visible="false">nIdRow</th>
                                            <th data-field="sCategoria" data-sortable="true">Categoria</th>
                                            <th data-field="sProducto" data-sortable="true">Producto</th>
                                            <th data-field="nOrden" data-sortable="true">Orden</th>
                                            <th data-field="sExtra" data-sortable="true">Extra(s)</th>
                                            <th data-field="sEstado" data-sortable="true">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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

    <div class="modal fade" id="formCESP" tabindex="-1" role="dialog" aria-labelledby="formCESPLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCESPLabel">Nuevo Producto</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdCategoriaCESP" class="col-form-label">Categoria</label>
                                    <select class="form-control" name="nIdCategoriaCESP" id="nIdCategoriaCESP">
                                        <?php foreach ($aryCategorias as $aryCategoria) : ?>
                                            <option value="<?= $aryCategoria["nIdCategoria"] ?>"><?= $aryCategoria["sNombre"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdProductoCESP" class="col-form-label">Producto</label>
                                    <select class="form-control" name="nIdProductoCESP" id="nIdProductoCESP"></select>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="sIdsExtraCESP" class="col-form-label">Extras</label>
                                    <select class="form-control" name="sIdsExtraCESP" id="sIdsExtraCESP" multiple>
                                        <?php foreach ($aryExtras as $aryLoop) : ?>
                                            <option value="<?= $aryLoop["nIDCDExtra"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nEstadoCESP" class="col-form-label">Estado</label>
                                    <select class="form-control" name="nEstadoCESP" id="nEstadoCESP">
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

    <div class="modal fade" id="formCEQR" tabindex="-1" role="dialog" aria-labelledby="formCEQRLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEQRLabel">Ver QR</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="imagenQRDW" class="content-descargar-qr">
                                    <div class="contenido">
                                        <div class="my-2">
                                            <span id="tituloQRC" class="titulo"> <strong>!La carta</strong> porfavor!</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <canvas id="qr-code"></canvas>
                                        </div>
                                        <div class="detalle d-flex justify-content-center">
                                            <p>Escanea el QR con tu cámara y <br>
                                                mira <strong> la carta en tu celular </strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">
                                    <a id="download-link" href="#">Descargar QR</a>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-12">
                                <input id="sURLCD" type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fin de modales -->
    <?php extend_view(['admin/common/footer'], $data) ?>
</body>


<?php extend_view(['admin/common/scripts'], $data) ?>
<script src="https://cdn.jsdelivr.net/npm/tablednd@1.0.5/dist/jquery.tablednd.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<!-- Carta Digital -->
<script>
    $(function() {

        fncValidarRol();

        // Formulario Clientes
        $("#btnCrearRegistro").on('click', function() {
            fncCleanAll();
            fncOcultarAside();
            $("#formCERegistro").find(".modal-title").html('Nueva Carta digital');
            $("#formCERegistro").data("nIdRegistro", 0);
            $("#tblDetalle").data("nIdRow", 0);
            $("#tblDetalle").bootstrapTable("load", []);
            $("#formCERegistro").modal("show");
        });

        // Submit del formulario de banco
        $("#formCERegistro").find("form").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro = $("#formCERegistro").data("nIdRegistro");
            var sNombre = $("#sNombre").val().trim();
            var aryDetalle = $("#tblDetalle").bootstrapTable("getData");
            var nEstado = $("#nEstado").val();

            var sImagen = $("#sImagen")[0].files[0];

            var sColor1 = $("#sColor1").val();
            var sColor2 = $("#sColor2").val();
            var sColor3 = $("#sColor3").val();
            var sColor4 = $("#sColor4").val();
            var sColor5 = $("#sColor5").val();
            var sColor6 = $("#sColor6").val();
            var sColor7 = $("#sColor7").val();
            var sColor8 = $("#sColor8").val();
            var sColor9 = $("#sColor9").val();
            var sColor10 = $("#sColor10").val();
            var sColor11 = $("#sColor11").val();
            var sColor12 = $("#sColor12").val();
            var sColor13 = $("#sColor13").val();

            var sImagenHeader = $("#sImagenHeader")[0].files[0];


            if (sNombre == '') {
                toastr.error('Error. Debe ingresar un nombre para la carta digital.Porfavor verifique');
                return false;
            }

            if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar al menos una seccion.Porfavor verifique');
                return false;
            }


            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('sNombre', sNombre);
            formData.append('aryDetalle', JSON.stringify(aryDetalle));
            formData.append('sImagen', sImagen);
            formData.append('nEstado', nEstado);
            formData.append('sColor1', sColor1);
            formData.append('sColor2', sColor2);
            formData.append('sColor3', sColor3);
            formData.append('sColor4', sColor4);
            formData.append('sColor5', sColor5);
            formData.append('sColor6', sColor6);
            formData.append('sColor7', sColor7);
            formData.append('sColor8', sColor8);
            formData.append('sColor9', sColor9);
            formData.append('sColor10', sColor10);
            formData.append('sColor11', sColor11);
            formData.append('sColor12', sColor12);
            formData.append('sColor13', sColor13);
            formData.append('sImagenHeader', sImagenHeader);


            fncGrabarRegistro(formData, function(aryData) {
                if (aryData.success) {
                    fncCleanAll();
                    $("#formCERegistro").modal("hide");
                    $('#tblPrincipal').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

        $('#download-link').on('click', function() {
            // Selecciona el div que deseas capturar
            const divCapturar = $('#imagenQRDW')[0];

            // Usa html2canvas para capturar el contenido del div como una imagen
            html2canvas(divCapturar).then(function(canvas) {
                // Crea una URL de datos de la imagen capturada
                const imgURL = canvas.toDataURL('image/png');

                // Crea un enlace de descarga
                const linkDescarga = $('<a>')
                    .attr('href', imgURL)
                    .attr('download', 'QR.png');

                // Simula un clic en el enlace de descarga para iniciar la descarga
                linkDescarga[0].click();
            });
        });

        // // Agrega el evento click al enlace de descarga
        // $("#download-link").click(function() {
        //     var canvas = document.getElementById('qr-code');
        //     // Genera la URL de la imagen en base64 a partir del contenido del canvas
        //     var imageUrl = canvas.toDataURL('image/png');
        //     // Asigna la URL generada como href del enlace de descarga
        //     $(this).attr('href', imageUrl);
        // });
        fncColocarTitulosColores();
    });

    function fncColocarTitulosColores() {
        for (let index = 1; index <= 13; index++) {
            console.log($("label[for=sColor" + index + "]"));
            $("label[for=sColor" + index + "]").prop("title", $("#sDetalleC" + index).html().trim());
        }

    }


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

        $("#formCERegistro").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistro(jsnData, function(aryResponse) {
            if (aryResponse.success) {

                var aryData = aryResponse.aryData;
                var aryDetalle = aryResponse.aryDetalle;

                $("#sNombre").val(aryData.sNombre);
                $("#nEstado").val(aryData.nEstado);
                $("#tblDetalle").bootstrapTable("load", aryDetalle);
                $("#tblDetalle").data("nIdRow", aryDetalle.length);


                $("#sColor1").val(aryData.sColor1);
                $("#sColor2").val(aryData.sColor2);
                $("#sColor3").val(aryData.sColor3);
                $("#sColor4").val(aryData.sColor4);
                $("#sColor5").val(aryData.sColor5);
                $("#sColor6").val(aryData.sColor6);
                $("#sColor7").val(aryData.sColor7);
                $("#sColor8").val(aryData.sColor8);
                $("#sColor9").val(aryData.sColor9);
                $("#sColor10").val(aryData.sColor10);
                $("#sColor11").val(aryData.sColor11);
                $("#sColor12").val(aryData.sColor12);
                $("#sColor13").val(aryData.sColor13);

                $("#sImagenFP").hide();
                if (aryData.sImagen.length > 0) {
                    $("#sImagenFP").prop("src", src("multi/" + aryData.sImagen));
                    $("#sImagenFP").show();
                }

                $("#sImagenH").hide();
                if (aryData.sImagenHeader.length > 0) {
                    $("#sImagenH").prop("src", src("multi/" + aryData.sImagenHeader));
                    $("#sImagenH").show();
                }

                if (sOpcion == 'editar') {
                    fncEditForm("#formCERegistro", "Editar Carta Digital");
                } else {
                    fncViewForm("#formCERegistro", "Ver Carta digital");
                }

                $("#formCERegistro").modal("show");
            } else {
                toastr.error(aryData.error);
            }
        });

    }

    function fncMostrarQR(sURL, sColorFondo, sColorTexto) {
        // Obtén una referencia al elemento canvas y al enlace de descarga
        var canvas = document.getElementById('qr-code');

        // Crea una instancia de la biblioteca QRious
        const qr = new QRious({
            element: canvas,
            value: sURL, // Cambia esto por la URL o contenido que desees codificar en el QR
            size: 200, // Cambia esto para ajustar el tamaño del código QR
        });

        $("#imagenQRDW").css('--bg-cirulo-qr', sColorFondo);
        $("#tituloQRC").css('--text-color-qr', sColorTexto);

        $("#sURLCD").val(sURL);
        $("#formCEQR").modal("show");
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
            url: web_root + 'cartaDigital/fncGrabarRegistro',
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
            url: web_root + 'cartaDigital/fncMostrarRegistro',
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
            url: web_root + 'cartaDigital/fncEliminarRegistro',
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

<!-- Seccion -->
<script>
    $(function() {
        // Formulario
        $("#btnCrearSeccion").on('click', function() {
            fncCleanAllD();
            $("#formCENS").find(".modal-title").html('Nueva Seccion');
            $("#formCENS").data("nIdRegistro", 0);
            $('#tblListadoPS').data("nIdRow", 0);
            $('#tblListadoPS').bootstrapTable("load", []);
            $("#formCENS").modal("show");
        });

        $("#formCENS").find("form").on('submit', function(event) {
            event.preventDefault();

            var nIdRegistro = $("#formCENS").data("nIdRegistro");
            var sNombre = $("#sNombreS").val();
            var nEstado = $("#nEstadoS").val();
            var aryDetalle = $("#tblListadoPS").bootstrapTable("getData");

            if (sNombre == "") {
                toastr.error('Error. No ha ingresado un nombre. Porfavor verifique');
                return false;
            }

            if (aryDetalle.length == 0) {
                toastr.error('Error. No ha ingresado el detalle de la seccion. Porfavor verifique');
                return false;
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
                    nIdRow: nIdRow,
                    nIdCartaDigitalSeccion: 0,
                    nOrden: $('#tblDetalle').bootstrapTable("getData").length + 1,
                    sAcciones: sAcciones,
                    sNombre: sNombre,
                    nEstado: nEstado,
                    sEstado: $("#nEstadoS option:selected").text(),
                    nCantidadItems: aryDetalle.length,
                    aryDetalle: JSON.stringify(aryDetalle)
                };

                $('#tblDetalle').bootstrapTable('insertRow', {
                    index: 1,
                    row: jsnData
                });
                $('#tblDetalle').data("nIdRow", nIdRow);
            } else {

                jsnData = $('#tblDetalle').bootstrapTable('getRowByUniqueId', nIdRegistro);

                jsnData.sNombre = sNombre;
                jsnData.nEstado = nEstado;
                jsnData.aryDetalle = JSON.stringify(aryDetalle);
                jsnData.nCantidadItems = aryDetalle.length;

                $('#tblDetalle').bootstrapTable('updateByUniqueId', {
                    nIdRow: jsnData.nIdRow,
                    row: jsnData
                });

            }

            fncReorderTableD();
            $("#formCENS").modal("hide");
        });

        $('#tblDetalle').on('reorder-row.bs.table', function(jsnDetail, aryData) {
            aryData.forEach(function(element, nIndex) {
                $("#tblDetalle").bootstrapTable('updateCellByUniqueId', {
                    id: element.nIdRow,
                    field: "nOrden",
                    value: (nIndex + 1)
                });
            });
        });
    });

    function fncReorderTableD() {

        var aryData = $("#tblDetalle").bootstrapTable("getData");

        aryData.forEach(function(element, nIndex) {

            $("#tblDetalle").bootstrapTable('updateCellByUniqueId', {
                id: element.nIdRow,
                field: "nOrden",
                value: (nIndex + 1)
            });
        });
    }

    function fncEditarDetalle(nIdRow) {
        var jsnRow = $("#tblDetalle").bootstrapTable('getRowByUniqueId', nIdRow);
        $("#formCENS").data("nIdRegistro", jsnRow.nIdRow);
        $("#sNombreS").val(jsnRow.sNombre);
        $("#nEstadoS").val(jsnRow.nEstado);
        $("#tblListadoPS").bootstrapTable("load", JSON.parse(jsnRow.aryDetalle));
        $("#tblListadoPS").data("nIdRow", JSON.parse(jsnRow.aryDetalle).length);
        $("#formCENS").find(".modal-title").html('Editar Seccion');
        $('#formCENS').modal('show');
    }

    function fncEliminarDetalle(nIdRow) {
        if (confirm('Advertencia. Esta acción no se puede deshacer. ¿Continuar?')) {
            $("#tblDetalle").bootstrapTable('removeByUniqueId', nIdRow);
            fncReorderTableD();
        }
    }

    // Funciones Auxiliares
    function fncCleanAllD() {
        fncRemoveDisabled($("#formCENS").find("form"));
        fncClearInputs($("#formCENS").find("form"));
    }
</script>

<!-- Seccion productos -->
<script>
    $(function() {

        $("#nIdCategoriaCESP").select2({
            placeholder: "SELECCIONAR",
            dropdownParent: "#formCESP"
        });

        $("#nIdProductoCESP").select2({
            placeholder: "SELECCIONAR",
            dropdownParent: "#formCESP"
        });

        $("#sIdsExtraCESP").select2({
            placeholder: "SELECCIONAR",
            dropdownParent: "#formCESP"
        });

        // Formulario
        $("#btnCrearPS").on('click', function() {
            fncCleanAllSD();
            $("#formCESP").find(".modal-title").html('Agregar Producto');
            $("#formCESP").data("nIdRegistro", 0);
            $("#formCESP").modal("show");
        });

        // Submit del formulario de banco
        $("#formCESP").find("form").on('submit', function(event) {
            event.preventDefault();

            var nIdRegistro = $("#formCESP").data("nIdRegistro");
            var nIdCategoria = $("#nIdCategoriaCESP").val();
            var nIdProducto = $("#nIdProductoCESP").val();
            var nEstado = $("#nEstadoCESP").val();
            var sIdsExtra = $("#sIdsExtraCESP").val();
            var sExtra = $("#sIdsExtraCESP :selected").map(function(nIndex, item) {
                return $(item).text().trim();
            }).get();

            if (nIdCategoria == null) {
                toastr.error('Error. No ha seleccionado la categoria .Porfavor verifique');
                return false;
            } else if (nIdProducto == null) {
                toastr.error('Error. No ha seleccionado el producto .Porfavor verifique');
                return false;
            }

            if (nIdRegistro == 0) {

                var nIdRow = $('#tblListadoPS').data("nIdRow") + 1;

                sLinkEdit = "fncEditarSD(" + nIdRow + ")";
                sLinkDelete = "fncEliminarSD(" + nIdRow + ")";

                var sAcciones = `
                <div class="content-acciones">
                    <a onclick="${sLinkEdit}" href="javascript:;" class="text-primary" title="Editar"><i class="material-icons">edit</i></a>
                    <a onclick="${sLinkDelete}" href="javascript:;" class="text-danger" title="Eliminar"><i class="material-icons">delete</i></a>
                </div>`;

                var jsnData = {
                    nIdRegistro: nIdRegistro,
                    nIdRow: nIdRow,
                    nIdCDProductos: 0,
                    sAcciones: sAcciones,
                    nIdCategoria: nIdCategoria,
                    nIdProducto: nIdProducto,
                    nEstado: nEstado,
                    nOrden: $('#tblListadoPS').bootstrapTable("getData").length + 1,
                    sCategoria: $("#nIdCategoriaCESP").find("option:selected").text(),
                    sProducto: $("#nIdProductoCESP").find("option:selected").text(),
                    sEstado: $("#nEstadoCESP").find("option:selected").text(),
                    sIdsExtra: sIdsExtra.join(","),
                    sExtra: sExtra.join(",")
                };

                $('#tblListadoPS').bootstrapTable('insertRow', {
                    index: 1,
                    row: jsnData
                });
                $('#tblListadoPS').data("nIdRow", nIdRow);
            } else {

                jsnData = $('#tblListadoPS').bootstrapTable('getRowByUniqueId', nIdRegistro);

                jsnData.nIdCategoria = nIdCategoria;
                jsnData.nIdProducto = nIdProducto;
                jsnData.nEstado = nEstado;
                jsnData.sCategoria = $("#nIdCategoriaCESP").find("option:selected").text();
                jsnData.sProducto = $("#nIdProductoCESP").find("option:selected").text();
                jsnData.sEstado = $("#nEstadoCESP").find("option:selected").text();
                jsnData.sIdsExtra = sIdsExtra.join(",");
                jsnData.sExtra = sExtra.join(",");

                $('#tblListadoPS').bootstrapTable('updateByUniqueId', {
                    nIdRow: jsnData.nIdRow,
                    row: jsnData
                });
            }
            fncReorderTableSD();
            $("#formCESP").modal("hide");
        });

        $("#nIdCategoriaCESP").on('change', function() {

            if ($(this).val() == null) {
                return;
            }

            fncDrawProductos({
                nIdCategoria: $(this).val()
            }, "#nIdProductoCESP", null);

        });

        $('#tblListadoPS').on('reorder-row.bs.table', function(jsnDetail, aryData) {
            aryData.forEach(function(element, nIndex) {
                $("#tblListadoPS").bootstrapTable('updateCellByUniqueId', {
                    id: element.nIdRow,
                    field: "nOrden",
                    value: (nIndex + 1)
                });
            });
        });

    });


    function fncReorderTableSD() {

        var aryData = $("#tblListadoPS").bootstrapTable("getData");

        aryData.forEach(function(element, nIndex) {

            $("#tblListadoPS").bootstrapTable('updateCellByUniqueId', {
                id: element.nIdRow,
                field: "nOrden",
                value: (nIndex + 1)
            });
        });
    }

    function fncDrawProductos(jsnData, sHtmlTag, nIdProducto = null) {
        fncObtenerProductoVentasAjax(jsnData, (aryResponse) => {

            if (aryResponse.success) {

                var sHTML = ``;
                aryResponse.aryData.forEach(element => {
                    sHTML += `<option value="${element.nIdProducto}">${element.sDescripcionText}</option>`;
                });

                $(sHtmlTag).html(sHTML);
                $(sHtmlTag).val(nIdProducto).trigger("change.select2");
            } else {
                toastr.error(aryResponse.error);
            }

        });

    }

    function fncEliminarSD(nIdRow) {
        if (confirm('Advertencia. Esta acción no se puede deshacer. ¿Continuar?')) {
            $("#tblListadoPS").bootstrapTable('removeByUniqueId', nIdRow);
            fncReorderTableSD();
        }
    }

    function fncEditarSD(nIdRow) {
        var jsnRow = $("#tblListadoPS").bootstrapTable('getRowByUniqueId', nIdRow);

        $("#formCESP").data("nIdRegistro", jsnRow.nIdRow);
        $("#nIdCategoriaCESP").val(jsnRow.nIdCategoria).trigger("change.select2");
        fncDrawProductos({
            nIdCategoria: jsnRow.nIdCategoria
        }, "#nIdProductoCESP", jsnRow.nIdProducto);

        if (jsnRow.sIdsExtra.length > 0) {
            $("#sIdsExtraCESP").val(jsnRow.sIdsExtra.split(",")).trigger("change.select2");
        } else {
            $("#sIdsExtraCESP").val(null).trigger("change.select2");
        }

        $("#nEstadoCESP").val(jsnRow.nEstado);
        $("#formCESP").find(".modal-title").html('Editar Producto');
        $('#formCESP').modal('show');
    }

    // Funciones Auxiliares
    function fncCleanAllSD() {
        fncRemoveDisabled($("#formCESP").find("form"));
        fncClearInputs($("#formCESP").find("form"));
        $("#nIdCategoriaCESP,#nIdProductoCESP,#sIdsExtraCESP").val(null).trigger("change");
    }

    function fncObtenerProductoVentasAjax(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'productos/fncObtenerProductoVentasAjax',
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