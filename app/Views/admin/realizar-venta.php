<!DOCTYPE html>

<html class="no-js h-100" lang="es">



<head>

    <?php extend_view(['admin/common/head'], $data) ?>



</head>





<body data-nidestadopagopagado="<?= $nIdEstadoPagoPagado ?>" data-ntipomoneda="<?= $arySede["nTipoMoneda"] ?>" data-ntipocomprofactura="<?= $nTipoComproFactura ?>" data-ntipocomproboleta="<?= $nTipoComproBoleta ?>" data-ntipocomproordencompra="<?= $nTipoComproOrdenCompra ?>" data-ntipodocdni="<?= $nTipoDocDNI ?>" data-ntipodocruc="<?= $nTipoDocRUC ?>" data-nidmetodoenviort="<?= $nIdMetodoEnvioRT ?>" data-nestadoenvioentregado="<?= $nEstadoEnvioEntregado ?>">





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

                        <div class="page-header row no-gutters py-4 mb-4">



                            <div class="col-12 col-lg-4 col-md-4 col-sm-4 pr-0 pr-md-4 ">

                                <div class="card card-small">

                                    <div class="card-body pt-1 pb-5">

                                        <div class="row no-gutters py-3">

                                            <div class="col-12 text-center mb-2">

                                                <h5>Realizar Venta</h5>

                                            </div>

                                            <div class="col-12 col-md-12 mb-2">

                                                <div class="row no-gutters">

                                                    <?php if ($nRegistroCotizacion == 0) : ?>
                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center">

                                                                <div class="flex-grow-1 bd-highlight">

                                                                    <p class="m-0 font-16">Caja : <span class="text-danger">*</span> </p>

                                                                </div>

                                                            </div>

                                                        </div>


                                                        <div class="col-12 my-2">

                                                            <select name="nIdCaja" class="form-control" id="nIdCaja">

                                                                <option value="0">Seleccionar</option>

                                                                <?php if (fncValidateArray($aryCajas)) : ?>

                                                                    <?php foreach ($aryCajas as $aryLoop) : ?>

                                                                        <option <?= count($aryCajas) === 1 ? "selected" : "" ?> value="<?= $aryLoop["nIdCaja"] ?>"><?= strup($aryLoop["sCaja"]) ?></option>

                                                                    <?php endforeach ?>

                                                                <?php endif ?>

                                                            </select>

                                                        </div>

                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center">

                                                                <div class="flex-grow-1 bd-highlight">

                                                                    <p class="m-0 font-16">Pedido carta digital : </p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-12 my-2">
                                                            <select name="nIdPedidoCD" class="form-control" id="nIdPedidoCD">
                                                            </select>
                                                        </div>

                                                    <?php else : ?>

                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center">

                                                                <div class="flex-grow-1 bd-highlight">

                                                                    <p class="m-0 font-16">Cotizacion : </p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-12 my-2">
                                                            <select name="nIdCotizacion" class="form-control" id="nIdCotizacion">
                                                            </select>
                                                        </div>


                                                    <?php endif ?>


                                                    <div class="col-12">

                                                        <div class="d-flex align-items-center">

                                                            <div class="flex-grow-1 bd-highlight">

                                                                <p class="m-0 font-16">Cliente : <span class="text-danger">*</span> </p>

                                                            </div>

                                                            <div class="bd-highlight">

                                                                <button type="button" id="btnCrearCliente" class="btn btn-gradient-primary btn-rounded btn-icon">

                                                                    <i class="fas fa-plus-circle"></i>

                                                                </button>

                                                            </div>

                                                        </div>

                                                    </div>





                                                    <div class="col-12 my-2">

                                                        <select name="nIdCliente" class="form-control" id="nIdCliente">



                                                        </select>

                                                    </div>

                                                </div>



                                                <hr>

                                            </div>









                                            <form class="col-12 w-100 row no-gutters" id="form-add-producto">



                                                <div class="col-12 col-md-12 mb-2">

                                                    <div class="row no-gutters">

                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center">

                                                                <div class="flex-grow-1 bd-highlight">

                                                                    <p class="m-0 font-16">Producto : <a id="btnBuscarProducto" style="vertical-align: middle;" href="javascript:;"><span class="material-icons font-18">search</span></a></p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-12 my-2">

                                                            <select name="nIdProducto" class="form-control" id="nIdProducto">

                                                                <?php if (fncValidateArray($aryProductos)) : ?>

                                                                    <?php foreach ($aryProductos as $aryProducto) : ?>

                                                                        <option data-sdetalle="<?= $aryProducto["sDetalle"] ?>" data-simagen="<?= $aryProducto["sImagen"] ?>" data-nprecio="<?= $aryProducto["nPrecio"] ?>" value="<?= $aryProducto["nIdProducto"] ?>">

                                                                            <?= $aryProducto["sDescripcion"] . " - " . $aryProducto["sUnidadMedidaCorto"]  . (strlen($aryProducto["sNombreUbicacionAlmacen"]) > 0 ?  " - " . $aryProducto["sNombreUbicacionAlmacen"] : '') ?>

                                                                        </option>

                                                                    <?php endforeach ?>

                                                                <?php endif ?>

                                                            </select>

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-12 col-md-6 mb-2 pr-2">

                                                    <div class="row no-gutters">

                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center">

                                                                <div class="flex-grow-1 bd-highlight">

                                                                    <p class="m-0 font-16">Precio :</p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-12 my-2">

                                                            <input type="number" class="form-control" id="nPrecio" min="0.00" max="9999999.999999" lang="en" step="0.000001" value="0.00" autocomplete="off" name="nPrecio">

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-12 col-md-6 mb-2">

                                                    <div class="row no-gutters">

                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center">

                                                                <div class="flex-grow-1 bd-highlight">

                                                                    <p class="m-0 font-16">Cantidad :</p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-12 my-2">

                                                            <input type="number" class="form-control" id="nCantidad" min="0" max="9999999.999999" lang="en" step="0.000001" value="1" autocomplete="off" name="nCantidad">

                                                        </div>

                                                    </div>

                                                </div>





                                                <div class="col-12 col-md-12 mb-2">

                                                    <div class="row no-gutters">

                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center">

                                                                <div class="flex-grow-1 bd-highlight">

                                                                    <p class="m-0 font-16">Detalle :</p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-12 my-2">

                                                            <textarea type="text" class="form-control" id="sDetalle" name="sDetalle" cols="1" rows="1"></textarea>

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-12 my-2 text-center">

                                                    <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Agregar</button>

                                                </div>



                                            </form>



                                        </div>



                                    </div>

                                </div>

                            </div>



                            <div class="col-12 col-lg-8 col-md-8 col-sm-8 my-md-0 my-3">

                                <div class="card card-small">

                                    <div class="card-body pt-1 pb-5">



                                        <div class="row no-gutters py-3">



                                            <div class="col-12 text-center mb-2">

                                                <h5>Detalle de Venta</h5>

                                            </div>



                                            <div class="col-12">

                                                <div class="table-responsive">

                                                    <table id="table-detalle" class="table">

                                                        <thead>

                                                            <tr>

                                                                <th class="d-none">IdProducto</th>

                                                                <th>Acciones</th>

                                                                <th>Item</th>

                                                                <th>Imagen</th>

                                                                <th>Producto</th>

                                                                <th>Precio</th>

                                                                <th>Cantidad</th>

                                                                <th>Total</th>

                                                                <th>Detalle</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>



                                                        </tbody>



                                                    </table>

                                                </div>

                                            </div>



                                            <div class="col-12 row content-totales">



                                                <div class="col-md-6 col-12">

                                                    <div class="form-group">

                                                        <label class="col-form-label">

                                                            Dsct

                                                            <span id="sMontoDsct"></span>

                                                        </label>



                                                        <div class="input-group mb-3">

                                                            <input type="text" class="form-control" name="nDsct" id="nDsct">

                                                            <div class="input-group-append">

                                                                <span class="input-group-text">%</span>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-md-6 col-12">

                                                    <div class="form-group">



                                                        <label class="col-form-label">

                                                            Canjear Puntos

                                                            <span id="sMontoCanjePuntos"></span>

                                                        </label>



                                                        <div class="input-group">

                                                            <input type="text" class="form-control" name="nCanjePuntos" id="nCanjePuntos">

                                                            <div class="input-group-append">

                                                                <span id="btnBuscarPuntos" class="input-group-text color-azul cursor-pointer">

                                                                    <span class="material-icons font-18">search</span>

                                                                </span>

                                                                <span id="btnClearPuntos" class="input-group-text color-azul cursor-pointer">

                                                                    <span class="material-icons  font-18">clear</span>

                                                                </span>

                                                            </div>

                                                        </div>



                                                    </div>

                                                </div>



                                                <div class="col-md-2 col-12">

                                                    <div class="form-group">

                                                        <label class="col-form-label">

                                                            Total Bruto

                                                        </label>

                                                        <input type="number" class="form-control d-inline nTotales" name="nTotalBrutoT" id="nTotalBrutoT" readonly disabled>

                                                    </div>

                                                </div>





                                                <div class="col-md-2 col-12">

                                                    <div class="form-group">

                                                        <label class="col-form-label">

                                                            Total Dsct

                                                            <span id="sMontoDsct"></span>

                                                        </label>

                                                        <input type="number" class="form-control d-inline nTotales" name="nTotalDsctT" id="nTotalDsctT" readonly disabled>

                                                    </div>

                                                </div>





                                                <div class="col-md-2 col-12">

                                                    <div class="form-group">

                                                        <label class="col-form-label">Subtotal</label>

                                                        <input type="number" class="form-control d-inline nTotales" name="nSubtotalT" id="nSubtotalT" readonly disabled>

                                                    </div>

                                                </div>





                                                <div class="col-md-2 col-12">

                                                    <div class="form-group">

                                                        <label class="col-form-label">IGV</label>

                                                        <input type="number" class="form-control d-inline nTotales" name="nIGVT" id="nIGVT" readonly disabled>

                                                    </div>

                                                </div>



                                                <div class="col-md-4 col-12">

                                                    <div class="form-group">

                                                        <label class="col-form-label">Total a Pagar</label>

                                                        <input type="number" class="form-control d-inline nTotales" name="nTotalPagar" id="nTotalPagar" readonly disabled>

                                                    </div>

                                                </div>



                                            </div>





                                            <div class="col-12 row">



                                                <div class="col-md-3 col-12">

                                                    <div class="form-group">

                                                        <label for="nCondicionPago" class="col-form-label">Condicion de pago <span class="text-danger">*</span></label>

                                                        <select class="form-control" name="nCondicionPago" id="nCondicionPago">

                                                            <option value="0">SELECCIONAR</option>

                                                            <option value="1">CONTADO</option>

                                                            <option value="2">PARCIAL</option>

                                                        </select>

                                                    </div>

                                                </div>





                                                <div class="col-md-3 col-12">

                                                    <div class="form-group">

                                                        <label for="nIdMetodoPago" class="col-form-label">Metodo de pago <span class="text-danger">*</span></label>

                                                        <select class="form-control" name="nIdMetodoPago" id="nIdMetodoPago">

                                                            <option value="0">SELECCIONAR</option>

                                                            <?php if (fncValidateArray($aryMetodosPagos)) : ?>

                                                                <?php foreach ($aryMetodosPagos as $aryLoop) : ?>

                                                                    <option value="<?= $aryLoop["nIdMetodoPago"] ?>"><?= strup($aryLoop["sNombrePago"]) ?></option>

                                                                <?php endforeach ?>

                                                            <?php endif ?>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="col-md-3 col-12">

                                                    <div class="form-group">

                                                        <label for="nEstadoPago" class="col-form-label">Estado de pago <span class="text-danger">*</span></label>

                                                        <select class="form-control" name="nEstadoPago" id="nEstadoPago">

                                                            <option value="0">SELECCIONAR</option>

                                                            <?php if (fncValidateArray($aryEstadoPago)) : ?>

                                                                <?php foreach ($aryEstadoPago as $aryLoop) : ?>

                                                                    <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= strup($aryLoop["sDescripcionLargaItem"]) ?></option>

                                                                <?php endforeach ?>

                                                            <?php endif ?>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="col-md-3 col-12">

                                                    <div class="form-group">

                                                        <label for="nIdMetodoEnvio" class="col-form-label">Metodo de envio <span class="text-danger">*</span></label>

                                                        <select class="form-control" name="nIdMetodoEnvio" id="nIdMetodoEnvio">

                                                            <option value="0">SELECCIONAR</option>

                                                            <?php if (fncValidateArray($aryMetodosEnvio)) : ?>

                                                                <?php foreach ($aryMetodosEnvio as $aryLoop) : ?>

                                                                    <option value="<?= $aryLoop["nIdMetodoEnvio"] ?>"><?= strup($aryLoop["sNombreEnvio"]) ?></option>

                                                                <?php endforeach ?>

                                                            <?php endif ?>

                                                        </select>

                                                    </div>

                                                </div>



                                            </div>



                                            <div class="col-12 row">



                                                <div class="col-md-4 col-12">

                                                    <div class="form-group">

                                                        <label for="nEstadoEnvio" class="col-form-label">Estado de envio <span class="text-danger">*</span></label>

                                                        <select class="form-control" name="nEstadoEnvio" id="nEstadoEnvio">

                                                            <option value="0">SELECCIONAR</option>

                                                            <?php if (fncValidateArray($aryEstadoEnvio)) : ?>

                                                                <?php foreach ($aryEstadoEnvio as $aryLoop) : ?>

                                                                    <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= strup($aryLoop["sDescripcionLargaItem"]) ?></option>

                                                                <?php endforeach ?>

                                                            <?php endif ?>

                                                        </select>

                                                    </div>

                                                </div>



                                                <div class="col-md-4 col-12">

                                                    <div class="form-group">

                                                        <label for="nIdResponsableDelivery" class="col-form-label">R.Delivery</label>

                                                        <select class="form-control" name="nIdResponsableDelivery" id="nIdResponsableDelivery">

                                                            <option value="0">SELECCIONAR</option>

                                                            <?php if (fncValidateArray($aryResponsableDelivery)) : ?>

                                                                <?php foreach ($aryResponsableDelivery as $aryLoop) : ?>

                                                                    <option value="<?= $aryLoop["nIdEmpleado"] ?>"><?= $aryLoop["sNombre"] ?></option>

                                                                <?php endforeach ?>

                                                            <?php endif ?>

                                                        </select>

                                                    </div>

                                                </div>



                                                <div id="content-cuenta-corriente" class="col-md-4 col-12">

                                                    <div class="form-group">

                                                        <label for="nIdCuentaCorriente" class="col-form-label">Cuenta Corriente</label>

                                                        <select class="form-control" name="nIdCuentaCorriente" id="nIdCuentaCorriente">

                                                            <option value="0">SELECCIONAR</option>

                                                        </select>

                                                    </div>

                                                </div>



                                            </div>





                                            <div class="col-12 mb-2 my-md-0 my-2 row">



                                                <div class="col-md-3 col-12">

                                                    <div class="form-group">

                                                        <label for="dFechaCreacion" class="col-form-label">Fecha <span class="text-danger">*</span></label>

                                                        <input type="text" autocomplete="off" value="<?= date("d/m/Y") ?>" placeholder="" class="form-control datepicker" name="dFechaCreacion" id="dFechaCreacion">

                                                    </div>

                                                </div>



                                                <div id="content-vuelto" class="col-12 col-md">

                                                    <label class="col-form-label d-md-block d-none">&nbsp;</label>

                                                    <div class="input-group">

                                                        <div class="input-group-prepend">

                                                            <span class="input-group-text bg-pagara">¿Con cuanto pagara?</span>

                                                        </div>

                                                        <input name="nEfectivo" id="nEfectivo" type="number" placeholder="Efectivo" class="form-control">

                                                        <input name="nVuelto" id="nVuelto" type="text" placeholder="Vuelto" class="form-control" readonly>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-12 mb-2 my-md-0 my-2 row">

                                                <div class="col-12 col-md-12">

                                                    <label for="sDescripcionPedido" class="col-form-label">Descripcion</label>

                                                    <textarea name="sDescripcionPedido" id="sDescripcionPedido" class="form-control" placeholder="Ingresa alguna descripcion"></textarea>

                                                </div>

                                            </div>



                                            <div class="col-12 my-2 text-right">

                                                <button id="btnGuardarPedido" type="button" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>

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

                                    <label for="nAcumulaPuntos" class="col-form-label">¿Acumula Puntos?</label>

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



    <div class="modal fade" id="formFacturacion" tabindex="-1" role="dialog" aria-labelledby="formFacturacionLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <form>

                    <div class="modal-header">

                        <h5 class="modal-title" id="formFacturacionLabel">Generar Comprobante</h5>

                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                    <div class="modal-body">



                        <div class="row">



                            <div class="col-12 col-md-12">

                                <div class="form-group">

                                    <label for="nIdPedidoF" class="col-form-label">Cod.Pedido<span class="text-danger">*</span></label>

                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="nIdPedidoF" id="nIdPedidoF" readonly>

                                </div>

                            </div>





                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="nTipoComprobanteF" class="col-form-label">Tipo Comprobante<span class="text-danger">*</span></label>

                                    <select class="form-control" name="nTipoComprobanteF" id="nTipoComprobanteF">

                                        <option value="0">SELECCIONAR</option>

                                        <?php if (fncValidateArray($aryTipoComprobante)) : ?>

                                            <?php foreach ($aryTipoComprobante as $aryLoop) : ?>

                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>

                                            <?php endforeach ?>

                                        <?php endif ?>

                                    </select>

                                </div>

                            </div>



                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="nTipoDocumentoF" class="col-form-label">Tipo Documento <span class="text-danger">*</span></label>

                                    <select class="form-control" name="nTipoDocumentoF" id="nTipoDocumentoF">

                                        <option value="0">SELECCIONAR</option>

                                        <?php if (fncValidateArray($aryTipoDocumento)) : ?>

                                            <?php foreach ($aryTipoDocumento as $aryLoop) : ?>

                                                <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionCortaItem"] ?></option>

                                            <?php endforeach ?>

                                        <?php endif ?>

                                    </select>

                                </div>

                            </div>



                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="sNumeroDocumentoF" class="col-form-label">Numero de documento <span class="text-danger">*</span></label>

                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumentoF" id="sNumeroDocumentoF">

                                </div>

                            </div>



                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="sNombreoRazonSocialF" class="col-form-label">Nombre o Razon Social <span class="text-danger">*</span></label>

                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreoRazonSocialF" id="sNombreoRazonSocialF">

                                </div>

                            </div>



                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="sCorreoF" class="col-form-label">Correo</label>

                                    <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCorreoF" id="sCorreoF">

                                </div>

                            </div>



                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="dFechaEmisionF" class="col-form-label">Fecha Emision <span class="text-danger">*</span></label>

                                    <input type="text" autocomplete="off" value="<?= date("d/m/Y") ?>" placeholder="" class="form-control datepicker" name="dFechaEmisionF" id="dFechaEmisionF">

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



    <div class="modal fade" id="formCEBuscarProducto" tabindex="-1" role="dialog" aria-labelledby="formCEBuscarProducto" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <form>

                    <div class="modal-header">

                        <h5 class="modal-title" id="formCEClienteLabel">Buscar Producto</h5>

                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                    <div class="modal-body ">


                        <div class="row my-2">

                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Buscar" name="sBuscadorProductos" id="sBuscadorProductos">
                            </div>

                            <div class="col-12">

                                <table data-toggle="table" id="tblProductosBuscar" data-click-to-select="true" data-search-selector="#sBuscadorProductos" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="7" data-sort-name="" data-sort-order="asc">

                                    <thead>

                                        <tr>

                                            <th data-field="state" data-radio="true"></th>

                                            <th data-field="sDescripcion">Nombre</th>

                                            <th data-field="nPrecio">Precio</th>

                                            <th data-field="sUnidadMedidaCorto">Uni Medida</th>

                                            <th data-field="sNombreUbicacionAlmacen">Ubicacion</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                            </div>

                        </div>



                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Seleccionar</button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    <div class="modal fade" id="formCEEditarDetalle" tabindex="-1" role="dialog" aria-labelledby="formCEEditarDetalleLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <form>

                    <div class="modal-header">

                        <h5 class="modal-title" id="formCEEditarDetalleLabel">Editar Comentario</h5>

                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                    <div class="modal-body ">



                        <div class="row my-2">

                            <div class="col-12 col-md-12 mb-2">

                                <div class="row no-gutters">

                                    <div class="col-12">

                                        <div class="d-flex align-items-center">

                                            <div class="flex-grow-1 bd-highlight">

                                                <p class="m-0 font-16">Detalle :</p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-12 my-2">

                                        <textarea type="text" class="form-control" id="sDetalleEdit" name="sDetalleEdit"></textarea>

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



    <!-- Fin de modales -->









    <?php extend_view(['admin/common/footer'], $data) ?>





</body>







<?php extend_view(['admin/common/scripts'], $data) ?>



<!-- Realizar pedido -->

<script>
    $(function() {



        $("#nCanjePuntos").data("nPuntosDsct", 0);

        $("#nCanjePuntos").data("nMontoDsct", 0);

        $("#nIdMetodoEnvio").val($("body").data("nidmetodoenviort"));

        $("#nEstadoEnvio").val($("body").data("nestadoenvioentregado"));



        $("#nIdProducto").select2({

            templateResult: function(elementProducto) {

                //console.log(elementProducto);

                var option = $(elementProducto.element)[0];

                if (typeof option !== "undefined") {

                    var sImagen = option.dataset.simagen;

                    var $span = $(`<span>${sImagen.length>0 ? `<img width="20px" height="20px" src='${src('multi/'+sImagen)}'/>` : ``} ${elementProducto.text.trim()} </span>`);

                    return $span;

                }



            },

            templateSelection: function(elementProducto) {

                var option = $(elementProducto.element)[0];

                var sImagen = option.dataset.simagen;

                var $span = $(`<span>${sImagen.length>0 ? `<img width="20px" height="20px" src='${src('multi/'+sImagen)}'/>` : ``} ${elementProducto.text.trim()} </span>`);

                return $span;



            }

        });



        $("#nIdProducto").val(0).trigger("change");



        // Formulario Agregrar producto



        $("#form-add-producto").on('submit', function(event) {



            event.preventDefault();



            var nIdProducto = $("#nIdProducto").find("option:selected").val();

            var sImagen = $("#nIdProducto").find("option:selected").data("simagen");

            var sProducto = $("#nIdProducto").find("option:selected").text().trim();

            var nCantidad = $("#nCantidad").val();

            var nPrecio = $("#nPrecio").val();

            var sDetalle = $("#sDetalle").val();



            if (nIdProducto == '0') {

                toastr.error('Error. Debe seleccionar una producto para la venta.');

                return false;

            } else if (nCantidad == '' || parseFloat(nCantidad) <= 0.00) {

                toastr.error('Error. Debe ingresar una cantidad.');

                return false;

            } else if (nPrecio == '' || parseFloat(nPrecio) <= 0.00) {

                toastr.error('Error. Debe ingresar un monto.');

                return false;

            }



            var jsnRow = {

                nIdProducto: nIdProducto,

                sProducto: sProducto,

                nCantidad: parseFloat(nCantidad),

                nPrecio: parseFloat(nPrecio),

                sImagen: sImagen,

                sTable: "#table-detalle",

                nItem: parseInt(($("#table-detalle").find("tbody").find("tr").length) + 1),

                nTotal: (parseFloat(nCantidad) * parseFloat(nPrecio)).toFixed(2),

                sDetalle: sDetalle

            };

            fncAgregarFila(jsnRow, "#table-detalle");

            fncCleanAll();

        });





        $("#btnGuardarPedido").on("click", function() {



            var nIdRegistro = 0;

            var nIdCliente = $("#nIdCliente").find("option:selected").val();

            var nIdCaja = <?= $nRegistroCotizacion ?> == 0 ? $("#nIdCaja").find("option:selected").val() : 0;

            var sNombreoRazonCliente = $("#nIdCliente").find("option:selected").text();

            var nTipoDocCliente = $("#nIdCliente").find("option:selected").data("ntipodocumento");

            var sNumeroDocCliente = $("#nIdCliente").find("option:selected").data("snumerodocumento");



            var nIdEstadoPago = $("body").data("nidestadopagopagado");

            var aryDataProd = fncGetDataTableCatalogo("#table-detalle");



            var nIdMetodoPago = $("#nIdMetodoPago").find("option:selected").val();

            var sMetodoPago = $("#nIdMetodoPago").find("option:selected").text().trim();



            var nEstadoPago = $("#nEstadoPago").find("option:selected").val();

            var nIdMetodoEnvio = $("#nIdMetodoEnvio").find("option:selected").val();



            var nEstadoEnvio = $("#nEstadoEnvio").find("option:selected").val();

            var sEstadoEnvio = $("#nEstadoEnvio").find("option:selected").text().trim().toUpperCase();

            var dFechaCreacion = $("#dFechaCreacion").val();

            var nIdCuentaCorriente = $("#nIdCuentaCorriente").val();



            var nEfectivo = $("#nEfectivo").val() == '' ? 0 : $("#nEfectivo").val();

            var nVuelto = $("#nVuelto").val() == '' ? 0 : $("#nVuelto").val();



            // Descuentos



            var nDescuento = $("#nDsct").val() == '' ? 0 : $("#nDsct").val();

            var nPuntosCanje = $("#nCanjePuntos").data("nPuntosDsct");

            var nDescuentoCanje = $("#nCanjePuntos").data("nMontoDsct");

            var sDescripcion = $("#sDescripcionPedido").val().trim();

            var nCondicionPago = $("#nCondicionPago").val().trim();

            var sCondicionPago = $("#nCondicionPago").find("option:selected").text().trim();

            var nIdResponsableDelivery = $("#nIdResponsableDelivery").val();





            /* Totales  */

            var nTotalBruto = $("#nTotalBrutoT").val() < 0 || $("#nTotalBrutoT").val() == '' ? 0 : $("#nTotalBrutoT").val();

            var nTotalDsctSimple = $("#sMontoDsct").html() < 0 || $("#sMontoDsct").html() == '' ? 0 : $("#sMontoDsct").html();

            var nTotalDescuentoCanje = $("#sMontoCanjePuntos").html() < 0 || $("#sMontoCanjePuntos").html() == '' ? 0 : $("#sMontoCanjePuntos").html();

            var nSubTotal = $("#nSubtotalT").val() < 0 || $("#nSubtotalT").val() == '' ? 0 : $("#nSubtotalT").val();

            var nIGVMonto = $("#nIGVT").val() < 0 || $("#nIGVT").val() == '' ? 0 : $("#nIGVT").val();

            var nTotal = $("#nTotalPagar").val() < 0 || $("#nTotalPagar").val() == '' ? 0 : $("#nTotalPagar").val();

            var nIdPedidoCD = $("#nIdPedidoCD").val();
            var nIdCotizacion = $("#nIdCotizacion").val();


            var bFilterCP = false;

            if (sCondicionPago == 'PARCIAL' || sCondicionPago == 'EN CUOTAS') {



                if (confirm('¿Estas seguro de que la venta sera con pago parcial?')) {

                    bFilterCP = true;

                }



                if (!bFilterCP) {

                    return;

                }

            }





            if ('<?= $nRegistroCotizacion ?>' == 0 && nIdCaja == '0') {

                toastr.error('Error. Debe seleccionar una caja o aperturar una caja para realizar el pedido.');

                return false;

            } else if (nIdCliente == '0' || !nIdCliente) {

                toastr.error('Error. Debe seleccionar un cliente para el pedido.');

                return false;

            } else if (aryDataProd.length == 0) {

                toastr.error('Error. Debe ingresar un producto por lo menos para generar un pedido.');

                return false;

            } else if (nIdMetodoPago == '0') {

                toastr.error('Error. Debe seleccionar un metodo de pago para el pedido.');

                return false;

            } else if (nEstadoPago == '0') {

                toastr.error('Error. Debe seleccionar un estado de pago para el pedido.');

                return false;

            } else if (nIdMetodoEnvio == '0') {

                toastr.error('Error. Debe seleccionar un metodo de envio para el pedido.');

                return false;

            } else if (nEstadoEnvio == '0') {

                toastr.error('Error. Debe seleccionar un estado de envio para el pedido.');

                return false;

            } else if (dFechaCreacion == '') {

                toastr.error('Error. Debe seleccionar un fecha de creacion para el pedido.');

                return false;

            } else if (nDescuento < 0) {

                toastr.error('Error. El descuento no puede ser negativo.');

                return false;

            } else if (nCondicionPago == 0) {

                toastr.error('Error. Debe de seleccionar una condicion de pago.');

                return false;

            } else if (sMetodoPago != 'EFECTIVO') {



                // Si el monto es diferente e efectivo va a validar que ingrese una cuenta corriente 

                if (nIdCuentaCorriente == 0) {

                    toastr.error('Error. Debe de seleccionar una cuenta corriente.Porfavor verifique');

                    return false;

                }



            }



            var jsnData = {

                nIdRegistro: nIdRegistro,

                nIdCaja: nIdCaja,

                nIdCliente: nIdCliente,

                nIdEstadoPago: nIdEstadoPago,

                aryDataProd: aryDataProd,

                nIdMetodoPago: nIdMetodoPago,

                nIdMetodoEnvio: nIdMetodoEnvio,

                nEstadoEnvio: nEstadoEnvio,

                sEstadoEnvio: sEstadoEnvio,

                nEstadoPago: nEstadoPago,

                dFechaCreacion: dFechaCreacion,

                nEfectivo: nEfectivo,

                nVuelto: nVuelto,

                nTipoMoneda: $("body").data("ntipomoneda"),

                nDespachado: 0,

                nEstado: 1,

                nDescuento: nDescuento,

                nPuntosCanje: nPuntosCanje,

                nDescuentoCanje: nDescuentoCanje,

                sDescripcion: sDescripcion,

                nCondicionPago: nCondicionPago,

                // Totales 

                nPorcentajeIGV: nIgv,

                nTotalBruto: nTotalBruto,

                nTotalDsctSimple: nTotalDsctSimple,

                nTotalDescuentoCanje: nTotalDescuentoCanje,

                nTotalDsct: (parseFloat(nTotalDsctSimple) + parseFloat(nTotalDescuentoCanje)),

                nSubTotal: nSubTotal,

                nIgv: nIGVMonto,

                nTotal: nTotal,
                nIdCuentaCorriente: nIdCuentaCorriente,
                nIdResponsableDelivery: nIdResponsableDelivery,
                nIdPedidoCD: '<?= $nRegistroCotizacion ?>' == '0' ? (nIdPedidoCD == 0 ? null : nIdPedidoCD) : null,
                nIdCotizacion: '<?= $nRegistroCotizacion ?>' == '1' ? (nIdCotizacion == 0 ? null : nIdCotizacion) : null
            };



            fncGrabarPedido(jsnData, (aryResponse) => {

                if (aryResponse.success) {



                    toastr.success(aryResponse.success);



                    if (jsnData.nEstadoPago == $("body").data("nidestadopagopagado")) {



                        fncMsg(1, '¿Deseas emitir comprobante?',



                            function() {



                                $("#nIdPedidoF").data("nIdPedido", aryResponse.nIdPedidoNew); // Id del pedido

                                $("#nIdPedidoF").val(aryResponse.sValor); // Correlativo 

                                $("#dFechaEmisionF").val(moment().format('DD/MM/YYYY'));





                                // $("#nIdPedidoF").data("sNombreoRazonCliente",sNombreoRazonCliente);

                                // $("#nIdPedidoF").data("nTipoDocCliente",nTipoDocCliente);

                                // $("#nIdPedidoF").data("sNumeroDocCliente",sNumeroDocCliente);



                                $("#nTipoDocumentoF").val(nTipoDocCliente);

                                $("#sNombreoRazonSocialF").val(sNombreoRazonCliente);

                                $("#sNumeroDocumentoF").val(sNumeroDocCliente);

                                $("#formFacturacion").modal("show");



                            },
                            function() {



                                fncMsg(1, '¿Desea imprimir?', () => {

                                    window.open(web_root + 'pedidos/fncPedidoPdf/' + aryResponse.nIdPedidoNew, "_blank", "toolbar=1, scrollbars=1, resizable=1, width=" + 800 + ", height=" + 800);

                                });





                            });



                    } else {



                        fncMsg(1, '¿Desea imprimir?', () => {

                            window.open(web_root + 'pedidos/fncPedidoPdf/' + aryResponse.nIdPedidoNew, "_blank", "toolbar=1, scrollbars=1, resizable=1, width=" + 800 + ", height=" + 800);

                        });

                    }





                    fncCleanVenta();



                } else {

                    toastr.error(aryResponse.error);

                }

            });

        });





        $("#nIdProducto").on("change", function() {



            var nPrecio = $(this).find("option:selected").data("nprecio");

            var sDetalle = $(this).find("option:selected").data("sdetalle");



            $("#nPrecio").val(nPrecio);

            $("#sDetalle").val(sDetalle);



            setTimeout(() => {

                $("#nCantidad").focus();

            }, 500);

        });



        $("#nEfectivo").on("keyup blur", function(event) {



            var nTotal = parseFloat($("#nTotalPagar").val());

            var nEfectivo = parseFloat($(this).val());



            if (nTotal > 0) {



                var nVuelto = nEfectivo - nTotal;



                if (event.type == 'blur' && nVuelto < 0) {

                    $("#nVuelto").val("");

                    toastr.error("Error.El monto en efectivo debe de ser mayor o igual que el monto total de la venta. Porfavor verifique");

                    return;

                }



                if (nVuelto >= 0) {

                    $("#nVuelto").val(nVuelto.toFixed(2));

                }



            }



        });



        $("#nIdMetodoPago").on("change", function() {



            var sMetodo = $(this).find("option:selected").text().trim();

            var nIdMetodoPago = $(this).find("option:selected").val();



            switch (sMetodo) {

                case 'EFECTIVO':



                    $("#nEstadoPago").val($("body").data("nidestadopagopagado"));

                    $("#content-cuenta-corriente").hide();

                    $("#content-vuelto").show();

                    break;

                default:

                    $("#content-vuelto").hide();

                    $("#content-cuenta-corriente").show();

                    $("#nEstadoPago").val(0);



                    // Buscar cuentas corrientes 

                    var jsnData = {
                        nIdMetodoPago: nIdMetodoPago
                    };

                    fncDrarwCC("#nIdCuentaCorriente", jsnData);



                    break;

            }



        });



        $("#nDsct").on("keyup blur keydown", function(event) {



            if (event.type == 'blur' && $("#nDsct").val() == '') {

                $("#nDsct").val(0);

            }



            if (event.type == 'blur' || event.type == 'keyup' || (event.type == 'keydown' && (event.keyCode || event.which === 13))) {

                fncTotales(null, "#table-detalle");

            }







        });



        $("#btnBuscarPuntos").on("click", function(event) {



            fncVerificarDsctCanjePuntos();



        });



        $("#btnClearPuntos").on("click", function(event) {



            $("#nCanjePuntos").val(0);

            $("#nCanjePuntos").data("nPuntosDsct", 0);

            $("#nCanjePuntos").data("nMontoDsct", 0);

            $("#sMontoCanjePuntos").html("");

            fncTotales(null, "#table-detalle", null);



        });



        $('#nCanjePuntos').keypress(function(event) {

            var keycode = (event.keyCode ? event.keyCode : event.which);

            if (keycode == '13') {

                $("#btnBuscarPuntos").trigger('click');

            }

        });





        $("#btnBuscarProducto").on("click", function(event) {

            $("#sBuscadorProductos").val("");

            fncObtenerProductoVentasAjax(null, (aryResponse) => {



                if (aryResponse.success) {

                    $("#tblProductosBuscar").bootstrapTable('load', aryResponse.aryData);

                    $("#formCEBuscarProducto").modal("show");

                } else {

                    toastr.error(aryResponse.error);

                }



            });
        });


        $('#sBuscadorProductos').on('input', function() {
            clearTimeout(this.delay);
            this.delay = setTimeout(function() {

                var jsnData = {
                    sSearch: this.value
                };

                fncObtenerProductoVentasAjax(jsnData, (aryResponse) => {

                    if (aryResponse.success) {

                        $("#tblProductosBuscar").bootstrapTable('load', aryResponse.aryData);

                    } else {

                        toastr.error(aryResponse.error);

                    }
                });

            }.bind(this), 800);
        });




        // Formulario para busca producto 

        $("#formCEBuscarProducto").on("submit", function(event) {



            event.preventDefault();



            fncSeleccionarProducto();



        });



        // Cuando hace doble click en la fila muestra el tab con el item seleccionado para el ingreso de otros datos

        $('#tblProductosBuscar').on('dbl-click-row.bs.table', function(row, $element, field) {



            fncSeleccionarProducto();



        });



        // Guardar y actualizar la edicion del detallle 

        $("#formCEEditarDetalle").find("form").on('submit', function(event) {



            event.preventDefault();



            var sDetalle = $("#sDetalleEdit").val();

            var element = $("#sDetalleEdit").data("element");



            $(element).attr("data-sdetalle", fncCleanQuotes(sDetalle));

            $("#formCEEditarDetalle").modal("hide");

        });



        // Cofiguracion combo Cliente

        $("#nIdCliente").select2({

            minimumInputLength: 0,

            tags: false,

            ajax: {

                url: web_root + 'clientes/fncGetClientes',

                dataType: 'json',

                type: "post",

                quietMillis: 50,

                data: function(term) {

                    return {

                        term: term

                    };

                },

                processResults: function(data) {

                    return {

                        results: $.map(data.aryData, function(item) {

                            return {

                                text: item.sNombreoRazonSocial,

                                id: item.nIdCliente,

                                nTipoDocumento: item.nTipoDocumento,

                                sNumeroDocumento: item.sNumeroDocumento,

                            }

                        })

                    };

                },



            }

        });



        $('#nIdCliente').on('select2:select', function(e) {

            var data = e.params.data;

            $("#nIdCliente option[value=" + data.id + "]").data('ntipodocumento', data.nTipoDocumento);

            $("#nIdCliente option[value=" + data.id + "]").data('snumerodocumento', data.sNumeroDocumento);

            $("#nIdCliente").trigger('change');

        });


        if ('<?= $nRegistroCotizacion ?>' == '0') {
            fncDrawPedidoCD("#nIdPedidoCD", {
                sIdsEstado: '<?= $nIdEstadoAprobadoCD ?>',
                nVendido: 0
            }, 0);


            $('#nIdPedidoCD').on('change', function(e) {
                $("#nIdCotizacion").val(0);

                if ($(this).val() == '0') {
                    return;
                }

                fncMostrarPedidoCD({
                    nIdRegistro: $(this).val()
                }, (aryResponse) => {
                    if (aryResponse.success) {

                        $("#table-detalle").find("tbody").html("");

                        setTimeout(() => {
                            fncTotales(null, "#table-detalle", null);

                            aryResponse.aryDetalle.forEach(element => {

                                var sExtra = "";
                                if (element.aryValuesExtras.length > 0) {
                                    aryValuesExtras = JSON.parse(element.aryValuesExtras);
                                    aryValuesExtras.forEach(elementExtra => {
                                        sExtra += elementExtra.sNombre + " => " + elementExtra.sValores + "\n";
                                    });

                                    element.sObservacion = element.sObservacion + "\n" + "EXTRAS" + "\n" + sExtra;
                                }

                                var jsnRow = {
                                    nIdProducto: element.nIdProducto,
                                    sProducto: element.sProducto,
                                    nCantidad: parseFloat(element.nCantidad),
                                    nPrecio: parseFloat(element.nPrecio),
                                    sImagen: element.sImagenProducto,
                                    sTable: "#table-detalle",
                                    nItem: parseInt(($("#table-detalle").find("tbody").find("tr").length) + 1),
                                    nTotal: (parseFloat(element.nCantidad) * parseFloat(element.nPrecio)).toFixed(2),
                                    sDetalle: element.sObservacion.trim()
                                };


                                fncAgregarFila(jsnRow, "#table-detalle");
                                $("#nDsct").val(0).keyup();
                            });

                        }, 200);

                        $("#nCondicionPago").val(1).change();
                        $("#nIdMetodoPago").val(3).change();
                        $("#sDescripcionPedido").val("PEDIDO REALIZO DESDE LA CARTA DIGITAL \n" + aryResponse.aryData.sCliente + "\n" + aryResponse.aryData.sObservacion);

                        toastr.success('Mostrando pedido');
                    } else {
                        toastr.error(aryResponse.error);
                    }

                });


            });
        } else {

            $('#nIdCotizacion').on('change', function(e) {
                if ($(this).val() == '0') {
                    return;
                }

                fncMostrarCotizacion({
                    nIdRegistro: $(this).val()
                }, (aryResponse) => {
                    if (aryResponse.success) {

                        $("#table-detalle").find("tbody").html("");
                        $("#nIdPedidoCD").val(0);

                        setTimeout(() => {
                            fncTotales(null, "#table-detalle", null);

                            var nTotalDsct = 0;
                            aryResponse.aryDetalle.forEach(element => {


                                var jsnRow = {
                                    nIdProducto: element.nIdProducto,
                                    sProducto: element.sProducto,
                                    nCantidad: parseFloat(element.nCantidad),
                                    nPrecio: parseFloat(element.nPrecio),
                                    sImagen: element.sImagenProducto,
                                    sTable: "#table-detalle",
                                    nItem: parseInt(($("#table-detalle").find("tbody").find("tr").length) + 1),
                                    nTotal: (parseFloat(element.nCantidad) * parseFloat(element.nPrecio)).toFixed(2),
                                    sDetalle: element.sObservacion.trim()
                                };

                                nTotalDsct += parseFloat(element.nDescuento);

                                fncAgregarFila(jsnRow, "#table-detalle");
                            });

                            // Obtiene el porcentaje total para la venta .. 
                            var nPrtajeDst = (nTotalDsct / parseFloat(aryResponse.aryData.nBaseImponible)) * 100;
                            $("#nDsct").val(nPrtajeDst.toFixed(2)).keyup();

                        }, 200);

                        fncDrawCliente("#nIdCliente", aryResponse.aryData.nIdCliente);
                        $("#nCondicionPago").val(aryResponse.aryData.nIdFormaPago).change();
                        // $("#nIdMetodoPago").val(3).change();
                        $("#sDescripcionPedido").val("PEDIDO REALIZO DESDE LA COTIZACION \n" + aryResponse.aryData.sObservacion);
                        toastr.success('Mostrando cotizacion');
                    } else {
                        toastr.error(aryResponse.error);
                    }

                });


            });

            fncDrawCotizacion("#nIdCotizacion", {
                nVendido: 0,
                nEstado: 1
            }, 0);

        }



    });



    window.fncSeleccionarProducto = function() {



        var arySelection = $("#tblProductosBuscar").bootstrapTable("getSelections");



        if (arySelection.length == 0) {

            toastr.error("Error. Selecciona un producto.Porfavor verifique");

            return;

        }



        var arySelection = arySelection[0];



        $("#nIdProducto").val(arySelection.nIdProducto).trigger("change");



        $("#formCEBuscarProducto").modal("hide");



    }



    window.fncVerificarDsctCanjePuntos = function() {



        var nIdCliente = $("#nIdCliente").find("option:selected").val();

        var nCanjePuntos = $("#nCanjePuntos").val();



        if (!nIdCliente) {

            toastr.error("Error. Para poder canjear los puntos primero debe de seleccionar un cliente . Porfavor verifique");

            return;

        }



        if (nCanjePuntos == '' || nCanjePuntos <= 0) {

            toastr.error("Error. Para poder canjear puntos debe ingresar una cantidad mayor a 0 . Porfavor verifique");

            return;

        }



        var jsnData = {
            nIdCliente: nIdCliente,
            nPuntos: nCanjePuntos
        };



        fncValidarPuntosCliente(jsnData, (aryResponse) => {



            if (aryResponse.success) {



                toastr.success(aryResponse.success);

                $("#nCanjePuntos").data("nPuntosDsct", nCanjePuntos);

                $("#nCanjePuntos").data("nMontoDsct", aryResponse.nDsct);

                $("#sMontoCanjePuntos").html(aryResponse.nDsct);





                fncTotales(null, "#table-detalle", null);



            } else {

                toastr.error(aryResponse.error);

            }

        });

    }



    window.fncGetDataTableCatalogo = function(sTable) {



        var aryData = [];



        $(sTable).find("tbody").find("tr").each(function() {



            var nIdProducto = $(this).find("td").eq(0).html();

            var sDetalle = $(this).find("td").eq(1).find("a.icon-detalle").attr("data-sdetalle");

            var nPrecio = $(this).find("td").eq(5).find(".precio").val();

            var nCantidad = $(this).find("td").eq(6).find(".cantidad").val();



            aryData.push({

                nIdProducto: nIdProducto,

                nPrecio: nPrecio,

                nCantidad: nCantidad,

                sDetalle: sDetalle

            });



        });



        return aryData;

    }



    // Funciones Auxiliares

    window.fncCleanAll = () => {



        fncClearInputs($("#form-add-producto"));

        fncClearInputs($("#formCECliente").find("form"));



        $("#nIdMetodoEnvio").val($("body").data("nidmetodoenviort"));

        $("#nEstadoEnvio").val($("body").data("nestadoenvioentregado"));

        $("#nPrecio").val("0.00");

        $("#nIdProducto").val(0).trigger("change");

        $("#nIdProvincia,#nIdDistrito").html(`<option value="0">SELECCIONAR</option>`);



        $("#nCanjePuntos").data("nPuntosDsct", 0);

        $("#nCanjePuntos").data("nMontoDsct", 0);

        $("#nTotalBrutoT").val(0);

        $("#nDsct,#nCanjePuntos").val(0);

        $("#nCondicionPago").val(0);

        $("#nIdResponsableDelivery").val(0);

        $("#sMontoDsct,#sMontoCanjePuntos,#totalDsct").html("");

        $("#sDescripcionPedido,#sDetalle").val("");



    }



    window.fncCleanVenta = () => {



        fncClearInputs($("#form-add-producto"));

        $("#nTotalBrutoT").val(0);



        $("#nIdMetodoEnvio").val($("body").data("nidmetodoenviort"));

        $("#nEstadoEnvio").val($("body").data("nestadoenvioentregado"));

        $("#nIdMetodoEnvio").val($("body").data("nidmetodoenviort"));

        $("#nEstadoEnvio").val($("body").data("nestadoenvioentregado"));

        $("#dFechaCreacion").val(moment().format('DD/MM/YYYY'));

        $("#nPrecio").val("0.00");

        $("#nIdProducto").val(0).trigger("change");

        $("#nIdCliente").val(0).trigger("change");

        $("#table-detalle").find("tbody").html("");

        $("#nEfectivo,#nVuelto").val("");

        $("#nIdMetodoPago,#nEstadoPago,#nIdMetodoEnvio,#nEstadoEnvio").val(0).trigger("change");

        $("#nIdResponsableDelivery").val(0);



        $("#nCanjePuntos").data("nPuntosDsct", 0);

        $("#nCanjePuntos").data("nMontoDsct", 0);

        $("#nDsct,#nCanjePuntos").val(0);

        $("#sMontoDsct,#sMontoCanjePuntos,#totalDsct").html("");

        $("#sDescripcionPedido,#sDetalle").val("");

        $("#nCondicionPago").val(0);

        setTimeout(() => {

            fncTotales(null, "#table-detalle", null);
            fncDrawPedidoCD("#nIdPedidoCD", {
                sIdsEstado: '<?= $nIdEstadoAprobadoCD ?>',
                nVendido: 0
            }, 0);

            fncDrawCotizacion("#nIdCotizacion", {
                nVendido: 0,
                nEstado: 1
            }, 0);

        }, 500);

    }



    window.fncAgregarFila = function(jsnRow, sHtmlTag) {



        if ($(sHtmlTag).find("tbody").find("tr").length > 0) {



            var bExist = false;



            $(sHtmlTag).find("tbody").find("tr").each(function() {



                var nIdProducto = $(this).find("td").eq(0).html();



                var nPrecioItem = parseFloat($(this).find("td").eq(5).find(".precio").val());

                var nCantidadItem = parseFloat($(this).find("td").eq(6).find(".cantidad").val());



                if (jsnRow.nIdProducto == nIdProducto && nPrecioItem == jsnRow.nPrecio) {



                    bExist = true;



                    var nCantidadNew = nCantidadItem + jsnRow.nCantidad;

                    var nTotalNew = nCantidadNew * nPrecioItem;



                    $(this).find("td").eq(6).find(".cantidad").val(nCantidadNew);

                    $(this).find("td").eq(7).find("div").html(nTotalNew.toFixed(2));



                }

            });



            if (bExist === false) {

                $(sHtmlTag).find("tbody").append(fncDrawFilaProducto(jsnRow));

            }



        } else {



            $(sHtmlTag).find("tbody").append(fncDrawFilaProducto(jsnRow));



        }



        setTimeout(() => {

            fncTotales(null, "#table-detalle", null);

        }, 500);



    }



    window.fncEliminarItem = function(nIdProducto, sTable, element) {



        if (confirm("¿Estas seguro de eliminar este item?")) {



            $(element).parent().parent().parent().remove();



            setTimeout(() => {

                fncTotales(null, sTable, null);

            }, 500);

        }

    }



    window.fncEditarDetalle = function(nIdProducto, sTable, element) {



        var sDetalle = $(element).attr("data-sdetalle");



        $("#sDetalleEdit").val(sDetalle);

        $("#sDetalleEdit").data("element", element);

        $("#formCEEditarDetalle").modal("show");

    }


    window.fncTotales = function(nIdProducto = null, sTable, event = null) {



        var nSubtotal = 0;

        var nCantidadTotal = 0;

        var nTotalIgv = 0;

        var nTotal = 0;



        var nDsct, nTotalBruto, nDsctTotal = 0;

        var nPorcentajeDescuento = parseFloat($("#nDsct").val() < 0 ? 0 : $("#nDsct").val());

        var nMontoDsctCanjePuntos = parseFloat($("#nCanjePuntos").data("nMontoDsct"));





        if ($(sTable).find("tbody").find("tr").length > 0) {



            $(sTable).find("tbody").find("tr").each(function() {



                var nPrecioItem = $(this).find("td").eq(5).find(".precio").val();

                var nCantidad = $(this).find("td").eq(6).find(".cantidad").val();

                var nTotalItem = parseFloat(nPrecioItem) * parseFloat(nCantidad);



                $(this).find("td").eq(7).find("div").html(fncNf(nTotalItem));



                // if(event != null && event.type == "blur"){

                //     $(this).find("td").eq(4).find(".precio").val( fncNf(nPrecioItem) );

                // }



                nSubtotal += nTotalItem;

                nCantidadTotal += parseInt(nCantidad);



            });



            nTotalBruto = nSubtotal;

            nTotalIgv = (nSubtotal * parseFloat(nIgv / 100));

            nDsct = nSubtotal * (nPorcentajeDescuento / 100);



            // Descuento de canje y porcentaje

            nDsctTotal = nDsct + nMontoDsctCanjePuntos;

            nSubtotal = nSubtotal > nDsctTotal ? (nSubtotal - nDsctTotal) - nTotalIgv : 0;

            nTotal = nSubtotal + nTotalIgv;



            $("#nTotalBrutoT").val(fncNf(nTotalBruto));

            $("#sMontoDsct").html(fncNf(nDsct));

            $("#nTotalDsctT").val(fncNf(nDsctTotal));

            $("#nSubtotalT").val(fncNf(nSubtotal));

            $("#nIGVT").val(fncNf(nTotalIgv));

            $("#nTotalPagar").val(fncNf(nTotal));



            setTimeout(() => {

                $("#nEfectivo").trigger("blur");

            }, 1000);



        } else {



            $("#sMontoDsct,#sMontoCanjePuntos").html("");

            $("#nTotalBrutoT").val(fncNf(0));

            $("#nTotalDsctT").val(fncNf(0));

            $("#nSubtotalT").val(fncNf(0));

            $("#nIGVT").val(fncNf(0));

            $("#nTotalPagar").val(fncNf(0));



        }



    }


    window.fncDrawFilaProducto = function(jsnData) {

        var sHtml = ``;

        sHtml = `<tr> 

                    <td class="d-none">${jsnData.nIdProducto}</td>

                    <td>

                        <div>

                            <a href="javascript:;" class="text-danger font-18" onclick="fncEliminarItem(${jsnData.nIdProducto},'${jsnData.sTable}',this);" title="Eliminar"><i class="material-icons">delete</i></a>

                            <a href="javascript:;" data-sdetalle="${fncCleanQuotes(jsnData.sDetalle)}" class="text-primary font-18 icon-detalle" onclick="fncEditarDetalle(${jsnData.nIdProducto},'${jsnData.sTable}',this);" title="Editar Detalle"><i class="material-icons">chat</i></a>

                        </div>

                    </td>

                    <td><div>${jsnData.nItem}</div></td>

                    <td><div>${jsnData.sImagen.length >0 ? `<img class="user-avatar rounded-circle mr-2 img-prod" src="${src( 'multi/' + jsnData.sImagen )}" alt="${jsnData.sImagen}">` : `` }</div></td>

                    <td><div>${jsnData.sProducto}</div></td>

                    <td class="cont-number"><div><input onblur="fncTotales(${jsnData.nIdProducto},'${jsnData.sTable}',event);" onkeyup="fncTotales('${jsnData.sTable}',event);" type="number" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="${jsnData.nPrecio}" autocomplete="off" class="form-control font-12 precio"></div></td>

                    <td class="cont-number"><div><input onblur="fncTotales(${jsnData.nIdProducto},'${jsnData.sTable}',event);" onkeyup="fncTotales('${jsnData.sTable}',event);" type="number" value="${jsnData.nCantidad}" min="1" max="9999999" step="1" autocomplete="off" class="form-control font-12 cantidad"></div></td>

                    <td><div>${fncNf(jsnData.nTotal)}</div></td>
                    <td><div>${nl2br(jsnData.sDetalle)}</div></td>
                </tr>`;

        return sHtml;

    }

    function nl2br(str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }


    function fncDrarwCC(sHtmlTag, jsnData, nIdCuentaCorriente = null) {



        fncGetCMMP(jsnData, function(aryData) {



            let sOptions = ``;



            if (aryData.success) {



                sOptions += `<option value="0">SELECCIONAR</option>`;



                aryData.aryData.forEach(aryElement => {

                    sOptions += `<option ${aryData.aryData.length == 1 ? "selected" : "" } value="${aryElement.nIdCuentaCorriente}">${aryElement.sBanco + ' | ' + aryElement.sTipoCuenta + ' | ' + aryElement.sNumeroCC}</option>`;

                });



                $(sHtmlTag).html(sOptions);



                if (nIdCuentaCorriente != null) {

                    $(sHtmlTag).val(nIdCuentaCorriente);

                }

            }



        });



    }

    function fncDrawPedidoCD(sHtmlTag, jsnData, nIdPedidoCD = null) {


        fncGetCDPedido(jsnData, function(aryData) {

            let sOptions = ``;

            sOptions += `<option value="0">SELECCIONAR</option>`;

            aryData.forEach(aryElement => {
                sOptions += `<option value="${aryElement.nIdPedidoCD}">${sp(aryElement.sIdPedidoCD)}</option>`;
            });

            $(sHtmlTag).html(sOptions);

            if (nIdPedidoCD != null) {

                $(sHtmlTag).val(nIdPedidoCD);

            }



        });



    }

    function fncDrawCotizacion(sHtmlTag, jsnData, nIdCotizacion = null) {


        fncGetCotizacion(jsnData, function(aryData) {

            let sOptions = ``;

            sOptions += `<option value="0">SELECCIONAR</option>`;

            aryData.forEach(aryElement => {
                sOptions += `<option value="${aryElement.nIdCotizacion}">${sp(aryElement.sNumero)}</option>`;
            });

            $(sHtmlTag).html(sOptions);

            if (nIdCotizacion != null) {

                $(sHtmlTag).val(nIdCotizacion);

            }


        });

    }

    function fncDrawCliente(sHtmlTag, nIdCliente = null) {

        fncGetClientes(null, function(aryData) {

            let sOptions = ``;

            if (aryData.success) {

                sOptions += `<option value="0">SELECCIONAR</option>`;

                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option data-ntipodocumento="${aryElement.nTipoDocumento}" data-snumerodocumento="${aryElement.sNumeroDocumento}" value="${aryElement.nIdCliente}">${aryElement.sNombreoRazonSocial}</option>`;
                });

                $(sHtmlTag).html(sOptions);

                if (nIdCliente != null) {
                    $(sHtmlTag).val(nIdCliente);
                }
            }

        });

    }



    // Llamadas al servidor
    function fncGrabarPedido(formData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'pedidos/fncGrabarPedido',

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

    function fncValidarPuntosCliente(formData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'canjepuntos/fncValidarPuntosCliente',

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

    function fncGetCMMP(jsnData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'cuentascorrientes/fncGetCMMP',

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

    function fncGetCDPedido(jsnData, fncCallback) {

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

    function fncMostrarPedidoCD(jsnData, fncCallback) {

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

    function fncMostrarCotizacion(jsnData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'cotizacion/fncMostrarRegistro',

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

    function fncGetCotizacion(jsnData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'cotizacion/fncPopulate',

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

    function fncGetClientes(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'clientes/fncGetClientes',
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

<!-- Realizar pedido -->





<!-- Clientes -->
<script>
    $(function() {



        // Formulario Clientes

        $("#btnCrearCliente").on('click', function() {

            fncCleanAll();

            $("#formCECliente").find(".modal-title").html('Nuevo Cliente');

            $("#formCECliente").data("nIdRegistro", 0);

            $("#formCECliente").modal("show");

        });



        // Submit del formulario de Cliente

        $("#formCECliente").find("form").on('submit', function(event) {



            event.preventDefault();



            var nIdRegistro = $("#formCECliente").data("nIdRegistro");

            var nTipoDocumento = $("#nTipoDocumento")

            var sNumeroDocumento = $("#sNumeroDocumento");

            var sNombreoRazonSocial = $("#sNombreoRazonSocial");

            var sCorreo = $("#sCorreo");

            var nIdDepartamento = $("#nIdDepartamento");

            var nIdProvincia = $("#nIdProvincia");

            var nIdDistrito = $("#nIdDistrito");

            var nIdRelacionamiento = $("#nIdRelacionamiento");

            var sTelefono = $("#sTelefono");

            var sDireccion = $("#sDireccion");

            var nAcumulaPuntos = $("#nAcumulaPuntos");



            var sFacebook = $("#sFacebook");

            var sWtsp = $("#sWtsp");

            var sTwiter = $("#sTwiter");

            var sOtraRedSocial = $("#sOtraRedSocial");



            var nEstado = $("#nEstado");





            if (nTipoDocumento.length > 0 && nTipoDocumento.val() == '') {

                toastr.error('Error. Seleccione un tipo de documento. Porfavor verifique');

                return;

            } else if (sNumeroDocumento.length > 0 && sNumeroDocumento.val() == '') {

                toastr.error('Error. Ingrese un numero de documento. Porfavor verifique');

                return;

            } else if (sNombreoRazonSocial.length > 0 && sNombreoRazonSocial.val() == '') {

                toastr.error('Error. Ingrese un nombre o razon social. Porfavor verifique');

                return;

            }
            /*else if (sCorreo.length > 0 && sCorreo.val() == '') {

                         toastr.error('Error. Ingrese un correo. Porfavor verifique');

                         return;

                     }*/
            else if (nIdDepartamento.length > 0 && nIdDepartamento.val() == '0') {

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

                nIdRegistro: nIdRegistro,

                nTipoDocumento: nTipoDocumento.length > 0 ? nTipoDocumento.val() : null,

                sNumeroDocumento: sNumeroDocumento.length > 0 ? sNumeroDocumento.val() : null,

                sNombreoRazonSocial: sNombreoRazonSocial.length > 0 ? sNombreoRazonSocial.val() : null,

                sCorreo: sCorreo.length > 0 ? sCorreo.val() : null,

                nIdDepartamento: nIdDepartamento.length > 0 ? nIdDepartamento.val() : null,

                nIdProvincia: nIdProvincia.length > 0 ? nIdProvincia.val() : null,

                nIdDistrito: nIdDistrito.length > 0 ? nIdDistrito.val() : null,

                sTelefono: sTelefono.length > 0 ? sTelefono.val() : null,

                sDireccion: sDireccion.length > 0 ? sDireccion.val() : null,

                nAcumulaPuntos: nAcumulaPuntos.length > 0 ? nAcumulaPuntos.val() : null,

                sFacebook: sFacebook.length > 0 ? sFacebook.val() : null,

                sWtsp: sWtsp.length > 0 ? sWtsp.val() : null,

                sTwiter: sTwiter.length > 0 ? sTwiter.val() : null,

                sOtraRedSocial: sOtraRedSocial.length > 0 ? sOtraRedSocial.val() : null,

                nEstado: nEstado.length > 0 ? nEstado.val() : null,

            };



            fncGrabarCliente(jsnData, function(aryData) {

                if (aryData.success) {

                    fncCleanAll();

                    $("#formCECliente").modal("hide");

                    toastr.success(aryData.success);

                } else {

                    toastr.error(aryData.error);

                }

            });



        });





        // Evento Dtp

        $("#nIdDepartamento").on('change', function() {

            var jsnData = {

                nIdDepartamento: $(this).val()

            };



            fncDrawProvincia("#nIdProvincia", jsnData, null);

        });



        $("#nIdProvincia").on('change', function() {

            var jsnData = {

                nIdProvincia: $(this).val()

            };

            fncDrawDistrito("#nIdDistrito", jsnData, null);

        });



        $("#nTipoDocumento").change(function() {

            if ($(this).val() > 0) {

                fncMaxLengthTypeDocument($(this).find('option:selected').text().trim().toUpperCase(), "#sNumeroDocumento");

            }

        });



        $("#sNumeroDocumento").on('keyup change', function() {



            switch ($("#nTipoDocumento").find("option:selected").text()) {



                case 'RUC':



                    if ($("#sNumeroDocumento").val().length == 11) {



                        // Lanzamos el evento

                        var jsnData = {

                            sTipo: "ruc",

                            sNumeroDoc: $("#sNumeroDocumento").val()

                        };



                        fncBuscarDocument(jsnData, function(aryData) {

                            if (aryData.success) {

                                $("#sNombreoRazonSocial").val(aryData.success.razonSocial);

                            }

                        });



                    }



                    break;



                case 'DNI':

                    if ($("#sNumeroDocumento").val().length == 7 || $("#sNumeroDocumento").val().length == 8) {



                        // Lanzamos el evento

                        var jsnData = {

                            sTipo: "dni",

                            sNumeroDoc: $("#sNumeroDocumento").val()

                        };



                        fncBuscarDocument(jsnData, function(aryData) {

                            if (aryData.success) {

                                $("#sNombreoRazonSocial").val(aryData.success.razonSocial);

                            }

                        });



                    }

                    break;



            }





        });







    });









    function fncDrawProvincia(sHtmlTag, jsnData, nIdProvincia = null) {



        fncObtenerProvincias(jsnData, function(aryData) {



            let sOptions = ``;



            if (aryData.success) {



                sOptions += `<option value="0">SELECCIONAR</option>`;



                aryData.aryData.forEach(aryElement => {

                    sOptions += `<option value="${aryElement.nIdProvincia}">${aryElement.sNombre}</option>`;

                });



                $(sHtmlTag).html(sOptions);



                if (nIdProvincia != null) {

                    $(sHtmlTag).val(nIdProvincia);

                }

            }



        });



    }



    function fncDrawDistrito(sHtmlTag, jsnData, nIdDistrito = null) {



        fncObtenerDistrito(jsnData, function(aryData) {



            let sOptions = ``;



            if (aryData.success) {



                sOptions += `<option value="0">SELECCIONAR</option>`;



                aryData.aryData.forEach(aryElement => {

                    sOptions += `<option value="${aryElement.nIdDistrito}">${aryElement.sNombre}</option>`;

                });



                $(sHtmlTag).html(sOptions);



                if (nIdDistrito != null) {

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

            url: web_root + 'api/' + jsnData.sTipo + '/' + jsnData.sNumeroDoc,

            beforeSend: function() {

                //  fncMostrarLoader();

            },

            success: function(data) {

                fncCallback(data);

            },

            complete: function() {

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
<!-- Clientes -->





<!-- Realizar Facturacion o Emitir comprobante -->
<script>
    $(function() {


        $("#formFacturacion").find("form").on("submit", function(event) {

            event.preventDefault();


            var nIdRegistro = 0;

            var nIdPedido = $("#nIdPedidoF").data("nIdPedido");

            var nTipoComprobante = $("#nTipoComprobanteF").find("option:selected").val();

            var sTipoComprobante = $("#nTipoComprobanteF").find("option:selected").text().trim();

            var nTipoDocumento = $("#nTipoDocumentoF").find("option:selected").val();

            var sNumeroDocumento = $("#sNumeroDocumentoF").val();

            var sCorreo = $("#sCorreoF").val();

            var sNombreoRazonSocial = $("#sNombreoRazonSocialF").val();

            var dFechaEmision = $("#dFechaEmisionF").val();



            if (nIdPedido == '') {

                toastr.error('Error. No existe un pedido para facturar .Porfavor verifique o solicite asistencia.');

                return false;

            } else if (nTipoComprobante == '0') {

                toastr.error('Error. Debe seleccionar un tipo de comprobante . Porfavor verifique');

                return false;

            } else if (nTipoDocumento == '0') {

                toastr.error('Error. Debe seleccionar un tipo de documento. Porfavor verifique');

                return false;

            } else if (sNumeroDocumento == '') {

                toastr.error('Error. Debe seleccionar un numero de documento para el pedido. Porfavor verifique');

                return false;

            } else if (sNombreoRazonSocial == '') {

                toastr.error('Error. Debe de ingresar un nombre o razon social. Porfavor verifique');

                return false;

            } else if (dFechaEmision == '') {

                toastr.error('Error. Debe de ingresar una fecha de emision. Porfavor verifique');

                return false;

            }



            var jsnData = {

                nIdRegistro: nIdRegistro,

                nIdPedido: nIdPedido,

                nTipoComprobante: nTipoComprobante,

                sTipoComprobante: sTipoComprobante,

                nTipoDocumento: nTipoDocumento,

                sNumeroDocumento: sNumeroDocumento,

                sNombreoRazonSocial: sNombreoRazonSocial,

                dFechaEmision: dFechaEmision,

                sCorreo: sCorreo,

                nAnulado: 0,

                nEstado: 1

            };



            fncGrabarDocumento(jsnData, (aryResponse) => {

                if (aryResponse.success) {



                    fncCleanAllF();



                    $("#formFacturacion").modal("hide");



                    toastr.success(aryResponse.success);



                    fncMsg(1, '¿Desea imprimir?',

                        function() {

                            window.open(web_root + 'pedidos/fncPedidoPdf/' + nIdPedido, "_blank", "toolbar=1, scrollbars=1, resizable=1, width=" + 800 + ", height=" + 800);



                        });



                } else {

                    toastr.error(aryResponse.error);

                }

            });





        });



        $("#nTipoComprobanteF").change(function() {



            switch (parseInt($(this).val())) {



                case $("body").data("ntipocomprofactura"):

                    $("#nTipoDocumentoF").val($("body").data("ntipodocruc"));

                    break;



                case $("body").data("ntipocomproboleta"):

                case $("body").data("ntipocomproordencompra"):

                    $("#nTipoDocumentoF").val($("body").data("ntipodocdni"));

                    break;



            }



        });



    });



    // Funciones Auxiliares

    window.fncCleanAllF = () => {

        $("#nIdPedidoF").data("nIdPedido", null);

        $("#nIdPedidoF").val("");



        $("#nIdPedidoF").data("sNombreoRazonCliente", null);

        $("#nIdPedidoF").data("nTipoDocCliente", null);

        $("#nIdPedidoF").data("sNumeroDocCliente", null);

        fncClearInputs($("#formFacturacion"));



    }





    // Llamadas al servidor

    function fncGrabarDocumento(jsnData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'documentos/fncGrabarDocumento',

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

<!-- Realizar Facturacion o Emitir comprobante -->



</html>