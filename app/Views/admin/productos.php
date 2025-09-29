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
                                                        <button id="btnCrearProducto" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->


                                        
                                        <div id="toolbarPrincipal" class="btn-group row">
                                            <div class="col-md-12 sin-padding container-buttons-table">
                                                <button id="btnFilter" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('productos/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbarPrincipal" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sCategoria" data-sortable="true">Categoria</th>
                                                            <th data-field="sCodigoInterno" data-sortable="true">Cod.Producto</th>
                                                            <th data-field="sCodigoBarras" data-sortable="true">Cod.Barra</th>
                                                            <th data-field="sDescripcion" data-sortable="true">Producto</th>
                                                            <th data-field="sUnidadMedida" data-sortable="true">Unidad Medida</th>
                                                            <th data-field="sTipoProducto" data-sortable="true">Tipo Producto</th>
                                                            <th data-field="sTipoPrecio" data-sortable="true">Tipo Precio</th>
                                                            <th data-field="nPrecioCompra" data-sortable="true">P.Compra</th>
                                                            <th data-field="nPrecioVenta" data-sortable="true">P.Venta</th>
                                                            <th data-field="nStockActual" data-sortable="true">Stock Actual</th>
                                                            <th data-field="sVenderStock" data-sortable="true">¿Vender con stock?</th>
                                                            <th data-field="sAcumulaPuntos" data-sortable="true">¿Acumula Puntos?</th>
                                                            <th data-field="sEquivalencia" data-sortable="true">Equivalencia</th>
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

                <?php extend_view(['admin/common/descripcion-empresa'], $data) ?>
            </main>
        </div>
    </div>



    <!-- Modales -->

    <div class="modal fade" id="formProducto" tabindex="-1" role="dialog" aria-labelledby="formProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formProductoLabel">Nuevo Producto</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">

                    
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="sCodigoBarras" class="col-form-label">Codigo Barras:  </label>
                                    <input type="text" class="form-control" id="sCodigoBarras" autocomplete="off" name="sCodigoBarras">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="sCodigoInterno" class="col-form-label">
                                        Codigo Interno: 
                                        <a id="btnActualizarCodInterno" title="Generar nuevo codigo interno" href="javascript:;">
                                            <span class="material-icons font-18">refresh</span>
                                        </a>  
                                    </label>
                                    <input type="text" class="form-control" id="sCodigoInterno" autocomplete="off" name="sCodigoInterno">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="sDescripcion" class="col-form-label">Descripcion: <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="sDescripcion" autocomplete="off" name="sDescripcion">
                                </div>
                            </div>

                            

                        
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nIdCategoria" class="col-form-label">Categoria: <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nIdCategoria" id="nIdCategoria">
                                        <?php if(fncValidateArray($aryCategorias)): ?>
                                            <?php foreach($aryCategorias as $aryCategoria):?>
                                                <option value="<?= $aryCategoria["nIdCategoria"] ?>"><?= $aryCategoria["sNombre"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                                                  
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nIdUnidadMedida" class="col-form-label">Unidad de medida: <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdUnidadMedida" id="nIdUnidadMedida">
                                        <?php if(fncValidateArray($aryUnidadMedida)): ?>
                                            <?php foreach($aryUnidadMedida as $aryUnidadMed):?>
                                                <option value="<?= $aryUnidadMed["nIdUnidadMedida"] ?>"><?= $aryUnidadMed["sNombreLargo"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nIdTipo" class="col-form-label">Tipo Producto: <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdTipo" id="nIdTipo">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoProducto)): ?>
                                            <?php foreach($aryTipoProducto as $aryTipoProd):?>
                                                <option value="<?= $aryTipoProd["nIdCatalogoTabla"] ?>"><?= $aryTipoProd["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            
                            <div id="content-tipo-precio" class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nTipoPrecio" class="col-form-label">Tipo Precio: <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nTipoPrecio" id="nTipoPrecio">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryTipoPrecio)): ?>
                                            <?php foreach($aryTipoPrecio as $aryTipoPre):?>
                                                <option value="<?= $aryTipoPre["nIdCatalogoTabla"] ?>"><?= $aryTipoPre["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div id="content-precio-compra" class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nPrecioCompra" class="col-form-label">Precio Compra:</label>
                                    <input type="number" class="form-control" id="nPrecioCompra"  min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="0.00" autocomplete="off" name="nPrecioCompra">
                                </div>
                            </div>
                            
                            <div id="content-precio-venta" class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nPrecioVenta" class="col-form-label">Precio Venta:</label>
                                    <input type="number" class="form-control" id="nPrecioVenta"  min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="0.00" autocomplete="off" name="nPrecioVenta">
                                </div>
                            </div>

                            
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nVenderStock" class="col-form-label">¿Vender con stock?</label>
                                    <select class="form-control" name="nVenderStock" id="nVenderStock">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-4 col-12 content-stock">
                                <div class="form-group">
                                    <label for="nStockMinimo" class="col-form-label">Stock Minimo:</label>
                                    <input type="number" class="form-control" name="nStockMinimo" id="nStockMinimo" min="0.00" max="99999.99"  lang="en" step="0.01" value="1" autocomplete="off" >
                                </div>
                            </div>

                            
                            <div class="col-md-4 col-12 content-stock">
                                <div class="form-group">
                                    <label for="nStockMaximo" class="col-form-label">Stock Maximo:</label>
                                    <input type="number" class="form-control" name="nStockMaximo" id="nStockMaximo" min="0.00" max="99999.99"  lang="en" step="0.01" value="1" autocomplete="off" >
                                </div>
                            </div>

                            
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nEquivalencia" class="col-form-label">¿El producto tiene equivalencia?</label>
                                    <select class="form-control" name="nEquivalencia" id="nEquivalencia">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4 col-12 content-equivalencia">
                                <div class="form-group">
                                    <label for="nIdProductoHijo" class="col-form-label">Producto equivalente:</label>
                                    <select class="form-control" name="nIdProductoHijo" id="nIdProductoHijo">
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-4 col-12 content-equivalencia">
                                <div class="form-group">
                                    <label for="nIdUnidadMedidaHijo" class="col-form-label">Unidad Medida equivalente:</label>
                                    <select class="form-control" name="nIdUnidadMedidaHijo" id="nIdUnidadMedidaHijo">
                                        <?php if(fncValidateArray($aryUnidadMedida)): ?>
                                            <?php foreach($aryUnidadMedida as $aryUnidadMed):?>
                                                <option value="<?= $aryUnidadMed["nIdUnidadMedida"] ?>"><?= $aryUnidadMed["sNombreLargo"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 content-equivalencia">
                                <div class="form-group">
                                    <label for="nCantidadHijo" class="col-form-label">Cantidad equivalencia:</label>
                                    <input type="number" class="form-control" id="nCantidadHijo"   min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="1" autocomplete="off" name="nCantidadHijo">
                                </div>
                            </div>

                       
                            <div class="col-md-4 col-12">
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

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nIdLote" class="col-form-label">Lote:</label>
                                    <select class="form-control" name="nIdLote" id="nIdLote">
                                        <?php if(fncValidateArray($aryLotes)): ?>
                                            <?php foreach($aryLotes as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdLote"] ?>"><?= $aryLoop["sNombre"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nIdUbicacionAlmacen" class="col-form-label">Ubicacion Almacen:</label>
                                    <select class="form-control" name="nIdUbicacionAlmacen" id="nIdUbicacionAlmacen">
                                        <?php if(fncValidateArray($aryUbicacionAlmacen)): ?>
                                            <?php foreach($aryUbicacionAlmacen as $aryLoop):?>
                                                <option value="<?= $aryLoop["nIdUbicacionAlmacen"] ?>"><?= $aryLoop["sNombre"]  ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="dFechaVencimiento" class="col-form-label">Fecha Vencimiento:</label>
                                    <input type="text" class="form-control datepicker" name="dFechaVencimiento" id="dFechaVencimiento"  >
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nAcumulaPuntos" class="col-form-label">¿Acumula Puntos?:</label>
                                    <select class="form-control" name="nAcumulaPuntos" id="nAcumulaPuntos">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nEstado" class="col-form-label">Estado:</label>
                                    <select class="form-control" name="nEstado" id="nEstado">
                                        <option value="1">Activo</option>
                                        <option value="0">Desactivo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="nPorcentajeComision" class="col-form-label">Porcentaje comision:  </label>
                                    <input type="number" class="form-control" id="nPorcentajeComision" autocomplete="off" name="nPorcentajeComision">
                                </div>
                            </div>
                        
                                  
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="sDetalle" class="col-form-label">Detalle:  </label>
                                    <textarea type="text" class="form-control" id="sDetalle" autocomplete="off" name="sDetalle"></textarea>
                                </div>
                            </div>

                            <div class="col-12 content-equivalencia">
                                <p class="font-weight-bold" id="sTextEquivalencia"></p>
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


    <div class="modal fade modal-full-screen" id="formListaPrecio" tabindex="-1" role="dialog" aria-labelledby="formListaPreciooLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="formListaPrecioLabel">Lista Precios</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                </div>
                <div class="modal-body modal-body-scroll">
                    
                           <!-- Fila Cabecera -->
                           <div class="row my-2">
                                <div class="col-12">
                                    <div class="d-flex align-items-center p-2">

                                        <div class="flex-center">
                                            <h5 class="title-table">Precios</h5>
                                        </div>

                                        <div class="ml-auto">
                                            <button id="btnCrearListaPrecio" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Fin de Fila Cabecera -->

                            <div class="row my-2">
                                <div class="col-12">
                                    <table data-toggle="table" id="tableListaPrecio" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                        <thead>
                                            <tr>
                                                <th data-field="sAcciones">Acciones</th>
                                                <th data-field="nOrden" data-sortable="true">Item</th>
                                                <th data-field="sProducto" data-sortable="true">Producto</th>
                                                <th data-field="nPrecio" data-sortable="true">Precio</th>
                                                <th data-field="sIndefinido" data-sortable="true">Fec. Indefinida</th>
                                                <th data-field="dFechaAlta" data-sortable="true">Fecha Alta</th>
                                                <th data-field="dFechaFin" data-sortable="true">Fecha Fin</th>
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
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="formCEListaPrecio" tabindex="-1" role="dialog" aria-labelledby="formCEListaPrecioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form >
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEListaPrecioLabel">Agregar Precio</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">
                        
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="nIdProductoLP" class="col-form-label">Producto:</label>
                                    <select class="form-control" name="nIdProductoLP" id="nIdProductoLP" disabled="disabled" >
                                        <option value="0">SELECCIONAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nPrecioLP" class="col-form-label">Precio:</label>
                                    <input type="number"  min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="0.00" class="form-control" id="nPrecioLP" autocomplete="off" name="nPrecioLP">
                                </div>
                            </div>

                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIndefinidoLP" class="col-form-label">Indefinido:</label>
                                    <select class="form-control" name="nIndefinidoLP" id="nIndefinidoLP">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12 content-fechas-lp">
                                <div class="form-group">
                                    <label for="dFechaAlta" class="col-form-label">Fecha alta:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaAlta" autocomplete="off" name="dFechaAlta">
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-12 content-fechas-lp">
                                <div class="form-group">
                                    <label for="dFechaFin" class="col-form-label">Fecha Fin:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaFin" autocomplete="off" name="dFechaFin">
                                </div>
                            </div>
                        
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nEstadoLP" class="col-form-label">Estado:</label>
                                    <select class="form-control" name="nEstadoLP" id="nEstadoLP">
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


    <!-- Modal para Filtros -->
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

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdCategoriaF" class="col-form-label">Categoria: </label>
                                    <select class="form-control" name="nIdCategoriaF" id="nIdCategoriaF" multiple>
                                        <?php if(fncValidateArray($aryCategorias)): ?>
                                            <?php foreach($aryCategorias as $aryCategoria):?>
                                                <option value="<?= $aryCategoria["nIdCategoria"] ?>"><?= $aryCategoria["sNombre"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                               
                           
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdTipoF" class="col-form-label">Tipo Producto:</label>
                                    <select class="form-control" name="nIdTipoF" id="nIdTipoF" multiple>
                                        <?php if(fncValidateArray($aryTipoProducto)): ?>
                                            <?php foreach($aryTipoProducto as $aryTipoProd):?>
                                                <option value="<?= $aryTipoProd["nIdCatalogoTabla"] ?>"><?= $aryTipoProd["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoPrecioF" class="col-form-label">Tipo Precio: </label>
                                    <select class="form-control" name="nTipoPrecioF" id="nTipoPrecioF" multiple>
                                        <?php if(fncValidateArray($aryTipoPrecio)): ?>
                                            <?php foreach($aryTipoPrecio as $aryTipoPre):?>
                                                <option value="<?= $aryTipoPre["nIdCatalogoTabla"] ?>"><?= $aryTipoPre["sDescripcionLargaItem"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nVenderStockF" class="col-form-label">¿Vender con stock?</label>
                                    <select class="form-control" name="nVenderStockF" id="nVenderStockF">
                                        <option value="">TODOS</option>
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>

                            


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nAcumulaPuntosF" class="col-form-label">¿Acumula Puntos?:</label>
                                    <select class="form-control" name="nAcumulaPuntosF" id="nAcumulaPuntosF">
                                        <option value="">TODOS</option>
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
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

<!-- Productos -->
<script>
    $(function() {
        fncOcultarAside();
        fncValidarRol();

        $("#nIdCategoria,#nIdUnidadMedida,#nIdUnidadMedidaHijo,#nIdLote,#nIdUbicacionAlmacen").select2({
            placeholder : "SELECCIONAR"
        });

        //fncDrawProducto();
        
        // Formulario Categorias
        $("#btnCrearProducto").on('click', function() {
            
            fncCleanAll();
            

            $("#formProducto").find(".modal-title").html('Nuevo Producto');
            
            $("#formProducto").data("nIdRegistro",0);

            $("#sCodigoInterno").val((new Date().getTime()).toString(36).toUpperCase());
        
            $("#formProducto").modal("show");

        });

        $("#btnActualizarCodInterno").click(function(){
            $("#sCodigoInterno").val((new Date().getTime()).toString(36).toUpperCase());
        });


        $("#formProducto").find('form').on('submit', function(event) {
            
            event.preventDefault();

            var nIdRegistro      = $("#formProducto").data("nIdRegistro");
            var nIdCategoria     = $("#nIdCategoria").val();
            var sDescripcion     = $("#sDescripcion").val().trim();
            var nIdUnidadMedida  = $("#nIdUnidadMedida").val();
            var nIdTipo          = $("#nIdTipo").val();
            var nTipoPrecio      = $("#nTipoPrecio").val();
            var sTipoProducto    = $("#nIdTipo").find("option:selected").text().trim();
            var sTipoPrecio      = $("#nTipoPrecio").find("option:selected").text().trim();
            var nPrecioCompra    = $("#nPrecioCompra").val();
            var nPrecioVenta     = $("#nPrecioVenta").val();

            var nVenderStock     = $("#nVenderStock").val();
            var nEquivalencia    = $("#nEquivalencia").val();


            var nIdProductoHijo          = $("#nIdProductoHijo").val();
            var nIdUnidadMedidaHijo      = $("#nIdUnidadMedidaHijo").val();
            var nCantidadHijo            = $("#nCantidadHijo").val();

            var nIdLote               = $("#nIdLote").val();
            var nIdUbicacionAlmacen   = $("#nIdUbicacionAlmacen").val();

            var dFechaVencimiento = $("#dFechaVencimiento").val();
            var nStockMinimo      = $("#nStockMinimo").val();
            var nStockMaximo      = $("#nStockMaximo").val();
            var nAcumulaPuntos    = $("#nAcumulaPuntos").val();

            var sImagen          = $("#sImagen")[0].files[0];
            var nEstado          = $("#nEstado").val();

            var sCodigoInterno = $("#sCodigoInterno").val();
            var sCodigoBarras  = $("#sCodigoBarras").val();
            var sDetalle       = $("#sDetalle").val();
            var nPorcentajeComision = $("#nPorcentajeComision").val();

            if(sDescripcion == ''){
                toastr.error('Error. Debe ingresar una descripcion para el producto.');
                return false;
            } else if(nIdCategoria == '0' || !nIdCategoria  ){
                toastr.error('Error. Debe seleccionar una categoria para el producto.');
                return false;
            } else if(nIdUnidadMedida == '0' || !nIdUnidadMedida ){
                toastr.error('Error. Debe seleccionar una unidad de medida para el producto.');
                return false;
            } else if(nIdTipo == '0'){
                toastr.error('Error. Debe seleccionar un tipo de producto.');
                return false;
            } else if (nTipoPrecio == '0'){
                toastr.error('Error. Debe seleccionar un tipo de precio para el de producto.');
                return false;
            }

            if(sTipoPrecio != "VARIABLE"){
                if(sTipoProducto == 'COMPRA'){
                    
                    if(nPrecioCompra == '' || parseFloat(nPrecioCompra) <= 0.00){
                        toastr.error('Error. Debe ingresar un precio de compra para el producto . Porfavor verifique');
                        return false;
                    }

                } else if (sTipoProducto == 'VENTA'){
                    
                    if(nPrecioVenta == '' || parseFloat(nPrecioVenta) <= 0.00){
                        toastr.error('Error. Debe ingresar un precio de venta para el producto . Porfavor verifique');
                        return false;
                    }

                }  else if (sTipoProducto == 'COMPRA Y VENTA'){

                    if(nPrecioCompra == '' || parseFloat(nPrecioCompra) <= 0.00){
                        toastr.error('Error. Debe ingresar un precio de compra para el producto . Porfavor verifique');
                        return false;
                    } else if(nPrecioVenta == '' || parseFloat(nPrecioVenta) <= 0.00){
                        toastr.error('Error. Debe ingresar un precio de venta para el producto . Porfavor verifique');
                        return false;
                    }

                }
            }

            if(nEquivalencia  == 1){
                if (nIdProductoHijo == '0') {
                    toastr.error('Error. Debe de selecccionar un producto equivalente para la equivalencia . Porfavor verifique');
                    return false;
                } else if(nIdUnidadMedidaHijo == '0'){
                    toastr.error('Error. Debe selecccionar una unidad de medida del producto equivalente . Porfavor verifique');
                    return false;
                } else if(nCantidadHijo == '' || nCantidadHijo <= 0.00 ){
                    toastr.error('Error. Debe de una cantidad para la equivalencia . Porfavor verifique');
                    return false;
                }
            }

            if(nVenderStock == 1){
                if (nStockMinimo == '' || parseFloat(nStockMinimo) < 0){
                    toastr.error('Error. Debe ingresar un stock minimo para el producto. Por default utilize 0');
                    return false;
                } else  if (nStockMaximo == '' || parseFloat(nStockMaximo) < 0){
                    toastr.error('Error. Debe ingresar un stock maximo para el producto. Por default utilize 0');
                    return false;
                }
            }
 

            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdCategoria', nIdCategoria);
            formData.append('sDescripcion',sDescripcion);
            formData.append('nIdUnidadMedida',nIdUnidadMedida);
            formData.append('nIdTipo',nIdTipo);
            formData.append('nTipoPrecio',nTipoPrecio);
            formData.append('nVenderStock',nVenderStock);            
            formData.append('nEstado', nEstado );
            formData.append('nEquivalencia', nEquivalencia );


            if(nEquivalencia  == 1){
                formData.append('nIdProductoHijo',nIdProductoHijo);
                formData.append('nIdUnidadMedidaHijo',nIdUnidadMedidaHijo);
                formData.append('nCantidadPadre',1);
                formData.append('nCantidadHijo',nCantidadHijo);
            }
 
            if(sTipoPrecio == "FIJO"){
                formData.append('nPrecioCompra',nPrecioCompra);
                formData.append('nPrecioVenta',nPrecioVenta);
            } else{
                formData.append('nPrecioCompra',0.00);
                formData.append('nPrecioVenta',0.00);
            }

            
            if(nIdLote  != null) formData.append('nIdLote', nIdLote);
            if(nIdUbicacionAlmacen  != null ) formData.append('nIdUbicacionAlmacen', nIdUbicacionAlmacen);

            formData.append('dFechaVencimiento', dFechaVencimiento);
            formData.append('nStockMinimo', nStockMinimo);
            formData.append('nStockMaximo',nStockMaximo);
            formData.append('nAcumulaPuntos',nAcumulaPuntos);

            formData.append('sCodigoInterno',sCodigoInterno);
            formData.append('sCodigoBarras',sCodigoBarras);
            formData.append('sDetalle',sDetalle);
            formData.append('nPorcentajeComision',nPorcentajeComision);


            if(typeof sImagen  !== "undefined") formData.append('sImagen', sImagen );


            fncGrabarProducto(formData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formProducto").modal("hide");
                    $('#table').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });    
        });

        $("#nIdTipo").on("change",function(){

            var nIdTipo         = $("#nIdTipo").find("option:selected").val();
            var sTipoProducto   = $("#nIdTipo").find("option:selected").text().trim();

            if(nIdTipo == 0) {return false;}

            switch(sTipoProducto){
                case 'COMPRA' : 
                    $("#content-precio-compra").show();
                    $("#content-precio-venta").hide();
                break;
                case 'VENTA' : 
                    $("#content-precio-compra").hide();
                    $("#content-precio-venta").show();
                break;
                case 'COMPRA Y VENTA' : 
                    $("#content-precio-compra").show();
                    $("#content-precio-venta").show();
                break;
            }

            setTimeout(() => {
                $("#nTipoPrecio").trigger("change");
            }, 700);

        });

        $("#nTipoPrecio").on("change",function(){

            var nIdTipo      = $("#nIdTipo").find("option:selected").val();
            var sTipo        = $("#nIdTipo").find("option:selected").text().trim(); // TIPO PRODUCTO

            var nTipoPrecio = $("#nTipoPrecio").find("option:selected").val();
            var sTipoPrecio = $("#nTipoPrecio").find("option:selected").text().trim();

            if(nTipoPrecio == 0) {return false;}

            if( sTipo == 'COMPRA' && sTipoPrecio == 'FIJO' ){
                $("#content-precio-compra").show();
                $("#nPrecioVenta").val(0);
            } else if(sTipo == 'COMPRA' && sTipoPrecio == 'VARIABLE' ){
                $("#content-precio-compra").hide();
                $("#nPrecioVenta").val(0);
                $("#nPrecioCompra").val(0);
            } else if( sTipo == 'VENTA' && sTipoPrecio == 'FIJO' ){
                $("#content-precio-venta").show();
                $("#nPrecioCompra").val(0);
            } else if( sTipo == 'VENTA' && sTipoPrecio == 'VARIABLE' ){
                $("#content-precio-venta").hide();
                $("#nPrecioVenta").val(0);
                $("#nPrecioCompra").val(0);
            } else if( sTipo == 'COMPRA Y VENTA' && sTipoPrecio == 'FIJO' ){
                $("#content-precio-venta").show();
                $("#content-precio-compra").show();
            } else if( sTipo == 'COMPRA Y VENTA' && sTipoPrecio == 'VARIABLE' ){
                $("#content-precio-venta").hide();
                $("#content-precio-compra").hide();
                $("#nPrecioVenta").val(0);
                $("#nPrecioCompra").val(0);
            }
        });

        $("#nEquivalencia").on("change",function(){

            $("#nIdUnidadMedidaHijo").val("0");
            $("#nCantidadHijo").val("1");

            if($(this).find("option:selected").val() == "1"){

                // // Solo cuando se este agregando un nuevo producto
                // if($("#formProducto").data("nIdRegistro") == 0){

                //     fncDrawProducto("#nIdProductoHijo",null,false,true,(bStatus)=>{
                //         if(bStatus){
                //             $(".content-equivalencia").show();
                //         }
                //     });

                // } else {
                //     $(".content-equivalencia").show();
                // }

 
                fncDrawProducto("#nIdProductoHijo",null,false,true,(bStatus)=>{
                    if(bStatus){
                        $(".content-equivalencia").show();
                    }
                });
                
                $(".content-equivalencia").show();
 
            } else {
                $(".content-equivalencia").hide();
            }

        });

        $("#nIdProductoHijo").on("change",function(){
         
            if($(this).val() == 0) return false;
            var nIdUnidadMedida = $(this).find("option:selected").data("nidunidadmedida");
            $("#nIdUnidadMedidaHijo").val(nIdUnidadMedida).trigger("change");
            $("#nCantidadHijo").trigger("keyup");
        });

        $("#nCantidadHijo").on("focus keyup",function(){
          
            $("#sTextEquivalencia").html("");

            var sDescripcion  = $("#sDescripcion").val();

            var nCantidadHijo = $("#nCantidadHijo").val();

            var nIdUnidadMedidaPadre = $("#nIdUnidadMedida").find("option:selected").val();
            var sUnidadMedidaPadre   = $("#nIdUnidadMedida").find("option:selected").text().trim();

            var nIdProductoHijo  = $("#nIdProductoHijo").find("option:selected").val();
            var sProductoHijo    = $("#nIdProductoHijo").find("option:selected").text().trim();

            var nIdUnidadMedidaHijo   = $("#nIdUnidadMedidaHijo").find("option:selected").val();
            var sUnidadMedidaHijo     = $("#nIdUnidadMedidaHijo").find("option:selected").text().trim();

            if(sDescripcion == ''){
                toastr.error("Error .Debe de ingresar el nombre o descripcion del producto.Porfavor verifique");
                return;
            } else if(nIdUnidadMedidaPadre == 0){
                toastr.error("Error .Debe de seleccionar una unidad de medida para el producto padre.Porfavor verifique");
                return;
            } else if(nIdProductoHijo == 0){
                toastr.error("Error .Debe de seleccionar un producto equivalente.Porfavor verifique");
                return;
            } else if(nIdUnidadMedidaHijo == 0){
                toastr.error("Error .Debe de seleccionar una unidad de medida para el producto equivalente.Porfavor verifique");
                return;
            }

            var sTexto = " 1 "+ sUnidadMedidaPadre + " de " + sDescripcion + " equivale  a " + nCantidadHijo +  " " + sUnidadMedidaHijo  + " de " + sProductoHijo;

            $("#sTextEquivalencia").html(sTexto.toUpperCase());
            
        });

        $("#nVenderStock").on("change",function(){
         
            if($(this).val() == 1){
                $(".content-stock").show();
            } else { 
                $(".content-stock").hide();
            }
        
        });

        $('#table').on('refresh.bs.table', function (params) {
            window.bFilterTable = false;
            fncClearFilterM();
        });

    });

    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            $("#btnCrearListaPrecio").hide();
            $("#btnCrearProducto").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarProducto(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){

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
             
        });
    }

    function fncMostrarProducto(nIdRegistro,sOpcion) {
        
        fncCleanAll();

        $("#formProducto").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarRegistro(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData                     = aryResponse.aryData;
                    var aryDataProductoEquivalencia = aryResponse.aryDataProductoEquivalencia;

                    var nPrecioCompra = aryResponse.nPrecioCompra;
                    var nPrecioVenta  = aryResponse.nPrecioVenta;


                    $("#nIdCategoria").val(aryData.nIdCategoria).trigger("change");
                    $("#sDescripcion").val(aryData.sDescripcion);
                    $("#nIdUnidadMedida").val(aryData.nIdUnidadMedida).trigger("change");
                    $("#nIdTipo").val(aryData.nIdTipo).trigger("change");
                    $("#nTipoPrecio").val(aryData.nTipoPrecio).trigger("change");
                    
                    $("#nPrecioCompra").val(nPrecioCompra);
                    $("#nPrecioVenta").val(nPrecioVenta);

                    $("#nPorcentajeComision").val(aryData.nPorcentajeComision);

                    

                    $("#nVenderStock").val(aryData.nVenderStock).trigger("change");
                    $("#nEquivalencia").val(aryData.nEquivalencia).trigger("change");
                    
                    if(aryDataProductoEquivalencia !== null){

                        fncDrawProducto("#nIdProductoHijo" , "" , false ,true, (bStatus)=>{
                            if(bStatus){
                                setTimeout(() => {
                                    console.log(aryDataProductoEquivalencia);
                                    $("#nIdProductoHijo").val(aryDataProductoEquivalencia.nIdProductoHijo).trigger("change");
                                    $("#nIdUnidadMedidaHijo").val(aryDataProductoEquivalencia.nIdUnidadMedidaHijo).trigger("change");
                                    $("#nCantidadHijo").val(aryDataProductoEquivalencia.nCantidadHijo).trigger("keyup");
                                }, 1000);
                            }
                        });

                    }

                    if(aryData.nIdLote != 0)   $("#nIdLote").val(aryData.nIdLote).trigger("change");
                    if(aryData.nIdUbicacionAlmacen != 0)  $("#nIdUbicacionAlmacen").val(aryData.nIdUbicacionAlmacen).trigger("change");

                    $("#dFechaVencimiento").val(aryData.dFechaVencimiento);
                    $("#nStockMinimo").val(aryData.nStockMinimo);
                    $("#nStockMaximo").val(aryData.nStockMaximo);
                    $("#nAcumulaPuntos").val(aryData.nAcumulaPuntos);


                    $("#sCodigoInterno").val(aryData.sCodigoInterno);
                    $("#sCodigoBarras").val(aryData.sCodigoBarras);
                    $("#sDetalle").val(aryData.sDetalle);


                    $("#nEstado").val(aryData.nEstado);
                    
                    if(aryData.sImagen.length > 0) $("#sImagen").parent().find(".custom-file-label").html(aryData.sImagen) ;

                    if(sOpcion == 'editar'){
                        fncEditForm("#formProducto" , "Editar Producto");
                    } else {
                        fncViewForm("#formProducto" , "Ver Producto");
                    }

                    $("#formProducto").modal("show");
                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    function fncMostrarContentLista(nIdRegistro, nIdTipo ,sTipoProducto) {
    
        fncOcultarAside();
        var jsnData = {
            nIdRegistro : nIdRegistro,
            nIdTipo     : nIdTipo
        };

        $("#formCEListaPrecio").data("nIdProducto",nIdRegistro);
        $("#formCEListaPrecio").data("nIdTipo",nIdTipo);

        fncPopulateListaPrecio(jsnData, function(aryResponse){
            
                if (aryResponse.success) {
                    var aryData     = aryResponse.aryData;
                    var aryProducto = aryResponse.aryProducto;
                    $('#tableListaPrecio').bootstrapTable('load', aryData);
                    $("#formListaPrecio").find(".modal-title").html( sTipoProducto == 'COMPRA' ? 'Lista de precios de compra' : 'Lista de precios de venta');
                    $("#formListaPrecio").find(".title-table").html( aryProducto.sDescripcion);
                    $("#formListaPrecio").modal("show");
                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    // Funciones Auxiliares
    window.fncCleanAll = () => {
        $("#nIdCategoria,#nIdUnidadMedida,#nIdUnidadMedidaHijo,#nIdLote,#nIdUbicacionAlmacen").val("").trigger("change");
        $("#nEquivalencia,#nVenderStock").val(0).trigger("change");
        
        fncRemoveDisabled( $("#formProducto").find("form") );
        fncRemoveDisabled( $("#formCEListaPrecio").find("form") );

        fncClearInputs( $("#formProducto").find("form") );
        fncClearInputs( $("#formCEListaPrecio").find("form") );
    }

    // Llamadas al servidor

    function fncGrabarProducto(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'productos/fncGrabarProducto',
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
            url: web_root + 'productos/fncEliminarProducto',
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
            url: web_root +  'productos/fncMostrarProducto',
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

    function fncPopulateListaPrecio(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'productos/fncPopulateListaPrecio',
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

    function fncObtenerProductos(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'productos/fncObtenerProductos',
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
<!-- Productos -->



<!-- Lista Precios -->
<script>
    $(function() {

        // Formulario Categorias
        $("#btnCrearListaPrecio").on('click', function() {
            fncCleanAll();
            fncDrawProducto( "#nIdProductoLP" , $("#formCEListaPrecio").data("nIdProducto") , true );
            $("#nIndefinidoLP").val(0).trigger("change");
            $("#formCEListaPrecio").find(".modal-title").html('Nuevo Precio');
            $("#formCEListaPrecio").data("nIdRegistro",0);
            $("#formCEListaPrecio").modal("show");
        });

        $("#formCEListaPrecio").find('form').on('submit', function(event) {
            
            event.preventDefault();

            var nIdRegistro      = $("#formCEListaPrecio").data("nIdRegistro");
            var nIdProducto      = $("#formCEListaPrecio").data("nIdProducto");
            var nIdTipo          = $("#formCEListaPrecio").data("nIdTipo");
            var nIndefinido      = $("#nIndefinidoLP").val();

            var nPrecio          = $("#nPrecioLP").val();
            var dFechaAlta       = $('#dFechaAlta').datepicker('getDate');
            var dFechaFin        = $('#dFechaFin').datepicker('getDate');
            var nEstado          = $("#nEstadoLP").val();

            if(nPrecio <= 0.00){
                toastr.error('Error. Debe especificar una precio para el producto.');
                return false;
            } 

            if(nIndefinido == 0){
                
                if ((dFechaAlta != null && dFechaFin == null) || (dFechaAlta == null && dFechaFin != null)) {
                    toastr.error('Error. Si va a especificar fechas, debe ingresar la de alta y final. Por favor verificar.');
                    return;
                }

                if (dFechaFin < dFechaAlta) {
                    toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de alta. Por favor verificar.');
                    return;
                } else if($('#dFechaAlta').val()  == ''){
                    toastr.error('Error. Debe especificar una fecha de alta.');
                    return false;
                } else if($('#dFechaFin').val()  == ''){
                    toastr.error('Error. Debe especificar una fecha de fin.');
                    return false;
                }

            }
    
        

           

            var jsnData = {
                nIdRegistro : nIdRegistro,
                nIdTipo     : nIdTipo,
                nIndefinido : nIndefinido,
                nIdProducto : nIdProducto,
                nPrecio     : nPrecio,
                dFechaAlta  : nIndefinido == 1 ? null : $('#dFechaAlta').val(),
                dFechaFin   : nIndefinido == 1 ? null : $('#dFechaFin').val(),
                nEstado     : nEstado
            };
          
            fncGrabarProductoListaPrecio(jsnData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formCEListaPrecio").modal("hide");
                    fncDrawTableListaPrecio(nIdProducto, nIdTipo , '#tableListaPrecio');
                    toastr.success(aryData.success);
                }else{
                    toastr.error(aryData.error);
                }
            });    
        });

        $('#formListaPrecio').on('hidden.bs.modal', function () {
            $("#table").bootstrapTable("refresh");
        });

        $("#nIndefinidoLP").on("change",function(){

            if( $(this).val() == 0 ){
                $(".content-fechas-lp").show();
            } else {
                $("#dFechaAlta").val("");
                $("#dFechaFin").val("");
                $(".content-fechas-lp").hide();
            }

        });


    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarListaPrecio(nIdRegistro , nIdTipo) {


        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             

            var jsnData = {
                nIdRegistro : nIdRegistro,
             };

            fncEjecutarEliminarProductoListaPrecio( jsnData , function(aryData){

                if(aryData.success){

                    fncDrawTableListaPrecio($("#formCEListaPrecio").data("nIdProducto"), nIdTipo ,"#tableListaPrecio");
                    
                    toastr.success( aryData.success );

                } else {
                    
                    toastr.error( aryData.error );
                
                }

            }); 

        });
    }

    function fncMostrarListaPrecio(nIdRegistro,sOpcion) {
        
        fncCleanAll();
        
        $("#formCEListaPrecio").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarListaPrecio(jsnData, function(aryResponse){
            
                if (aryResponse.success) {
                 
                    var aryData = aryResponse.aryData;
                 
                    fncDrawProducto("#nIdProductoLP",aryData.nIdProducto , true);
                    $("#nIndefinidoLP").val(aryData.nIndefinido).trigger("change");

                    $("#nPrecioLP").val(aryData.nPrecio);
                    $("#dFechaAlta").val(aryData.dFechaAlta);
                    $("#dFechaFin").val(aryData.dFechaFin);
                    $("#nEstadoLP").val(aryData.nEstado);
                
                    if(sOpcion == 'editar'){
                        fncEditForm("#formCEListaPrecio" , "Editar Precio");
                    } else {
                        fncViewForm("#formCEListaPrecio" , "Ver Precio");
                    }

                    $("#formCEListaPrecio").modal("show");
                } else {
                    toastr.error(aryData.error);
                }
        });

    }



    // Funciones Auxiliares 
    
    function fncDrawProducto(sHtmlTag , nIdProducto = null , bDisabled = false ,bIsSelect2  = false, fncCallback = null){
        
        fncObtenerProductos(null,function(aryData){
            
            let sOptions = ``;
            
            if(aryData.success){
                
                if(bIsSelect2 === false){
                    sOptions += `<option value="0">SELECCIONAR</option>`;
                } 
                
                if( aryData.aryData.length > 0){
                    aryData.aryData.forEach(aryElement => {
                        sOptions += `<option data-nidunidadmedida="${aryElement.nIdUnidadMedida}" value="${aryElement.nIdProducto}">${aryElement.sDescripcion.toUpperCase()} - ${aryElement.sUnidadMedidaCorto}</option>`;
                    });
                }

                $(sHtmlTag).html(sOptions);

                if(nIdProducto != null){
                    $(sHtmlTag).val(nIdProducto);
                }

                if(bDisabled != false){
                    $(sHtmlTag).attr("disabled","disabled");
                }

                if(bIsSelect2 != false){
                    $(sHtmlTag).select2({
                        placeholder : "SELECCIONAR"
                    });
                    setTimeout(() => {
                        $(sHtmlTag).val("").trigger("change"); 
                    }, 200);
                }

                if(fncCallback != null){
                    fncCallback(true);
                }

            }

        });

    }

    function fncDrawTableListaPrecio(nIdRegistro,nIdTipo,sHtmlTag){

        var jsnData = {
            nIdRegistro : nIdRegistro,
            nIdTipo     : nIdTipo
        };
        
        fncPopulateListaPrecio(jsnData, function(aryResponse){
            
            if (aryResponse.success) {
             
                var aryData     = aryResponse.aryData;
                var aryProducto = aryResponse.aryProducto;
             
                $(sHtmlTag).bootstrapTable('load', aryData);
            } else {
                toastr.error(aryData.error);
            }

        });
    }


    // Llamadas al servidor

    function fncGrabarProductoListaPrecio(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'productos/fncGrabarProductoListaPrecio',
            data: formData,
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

    function fncEjecutarEliminarProductoListaPrecio(jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'productos/fncEliminarProductoListaPrecio',
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

    function fncBuscarListaPrecio(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'productos/fncMostrarProductoListaPrecio',
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
<!-- Lista Precios -->


 
 

<!-- Filtros Mantenimiento -->
<script>
    $(function() {

        $("#nIdCategoriaF,#nIdTipoF,#nTipoPrecioF").select2({
            placeholder: "TODOS"
        });

        $("#formFilter").find("form").on('submit', function(event) {
            event.preventDefault();

            var aryCategoria        = $("#nIdCategoriaF :selected").map(function(nIndex, item) {return $(item).val();}).get();
            var aryIdTipo           = $("#nIdTipoF :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var aryTipoPrecio       = $("#nTipoPrecioF :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var nVenderStock        = $("#nVenderStockF").val();
            var nAcumulaPuntos      = $("#nAcumulaPuntosF").val();


            var jsnData = {
                aryCategoria        : aryCategoria,
                aryIdTipo           : aryIdTipo,
                aryTipoPrecio       : aryTipoPrecio,
                nVenderStock        : nVenderStock,
                nAcumulaPuntos      : nAcumulaPuntos
            };

            fncPopulate(jsnData, function(aryData) {
                bFilterTable  = true;
                $("#table").bootstrapTable("load", aryData);
                $("#formFilter").modal("hide");
            });

        });

        $("#btnFilter").on("click",function(){
            $("#formFilter").modal("show");
        });
    });

    window.fncClearFilterM = () => {
        
        $("#nIdCategoriaF,#nIdTipoF,#nTipoPrecioF").val([]).trigger("change");
  
    }

    // Llamadas al servidor
    function fncPopulate(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'productos/fncPopulate',
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
<!-- Filtros Mantenimiento -->




</html>