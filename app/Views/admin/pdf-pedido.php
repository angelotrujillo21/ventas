<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Pedido</title>
    <?php if ($nA4 == 1) : ?>
        <?php load_style(['pdf']) ?>
    <?php else : ?>
        <?php load_style(['pdf-ticket']) ?>
    <?php endif; ?>

</head>

<body>
    <?php if ($nA4 == 1) : ?>
        <header class="clearfix">
            <div id="logo">
                <img class="logo" src="<?= strlen($arySede["sImagen"]) > 0 ?  src('multi/' . $arySede["sImagen"]) : (strlen($arySede["sImagenEmpresa"]) > 0 ? src('multi/' . $arySede["sImagenEmpresa"]) : src("app/app-logo.png")) ?>">
            </div>

            <?php if ($aryPedido["nFacturado"] ==  1) : ?>

                <h1><?= strtoupper($aryFactura['sTipoComprobante']) . " ELECTRONICA  |  " .  strup($aryFactura["sSerieDocumentoComprobante"]) . "-" . $aryFactura["sNumeroDocumentoComprobante"] ?></h1>

            <?php else : ?>

                <h1><?= strtoupper($sTitulo) ?> - <?= sp($nIdPedido) ?></h1>

            <?php endif ?>

            <div class="company clearfix">
                <div><?= $arySede["sNombre"] ?></div>
                <div><?= $arySede["sDireccion"] ?></div>
                <div><?= $arySede["sTelefono"] ?></div>
            </div>


            <div class="project mr-datos-cliente">

                <div class="col left">


                    <div>
                        <h3>DATOS DEL CLIENTE</h3>
                    </div>


                    <?php if ($aryPedido["nFacturado"] == 1) : ?>

                        <?php if (fncValidateArray($aryFactura)) : ?>

                            <?php if (!empty($aryFactura["sTipoDocumento"]) && !empty($aryFactura["sNumeroDocumento"])) : ?>
                                <div><span><?= strtoupper($aryFactura['sTipoDocumento']) ?> : </span><?= $aryFactura["sNumeroDocumento"] ?></div>
                            <?php endif ?>

                            <?php if (!empty($aryFactura["sNombreoRazonSocial"])) : ?>
                                <div><span> CLIENTE : </span><?= $aryFactura["sNombreoRazonSocial"] ?></div>
                            <?php endif ?>

                            <?php if (!empty($aryFactura["sCorreo"])) : ?>
                                <div><span> CORREO : </span><?= $aryFactura["sCorreo"] ?></div>
                            <?php endif ?>

                        <?php endif ?>

                    <?php else :  ?>

                        <?php if (!empty($aryCliente["sTipoDoc"]) && !empty($aryCliente["sNumeroDocumento"])) : ?>
                            <div><span><?= strtoupper($aryCliente['sTipoDoc']) ?>: </span><?= $aryCliente["sNumeroDocumento"] ?></div>
                        <?php endif ?>

                        <?php if (!empty($aryCliente["sNombreoRazonSocial"])) : ?>
                            <div><span>CLIENTE: </span> <?= $aryCliente["sNombreoRazonSocial"] ?></div>
                        <?php endif ?>

                        <?php if (!empty($aryCliente["sCorreo"])) : ?>
                            <div><span>EMAIL: </span> <a href="mailto:<?= $aryCliente["sCorreo"] ?>"><?= $aryCliente["sCorreo"] ?></a></div>
                        <?php endif ?>

                    <?php endif ?>
                </div>

                <div class="col right">
                    <div class="project mr-datos-pedido pl-10">
                        <?php if ($aryPedido["nFacturado"] == 1) : ?>
                            <?php if (fncValidateArray($aryFactura)) : ?>

                                <div>
                                    <h3>DATOS DE LA VENTA</h3>
                                </div>

                                <?php if (!empty($aryFactura["sTipoComprobante"])) : ?>
                                    <div> <span>COD PEDIDO : </span> <?= sp($aryPedido['nIdPedido']) ?> </div>
                                <?php endif ?>

                                <div><span>E .PAGO :</span> <?= $aryPedido["sEstadoPago"] ?></div>

                                <?php if (!empty($aryFactura["dFechaEmision"])) : ?>
                                    <div><span> FECHA EMISION : </span><?= $aryFactura["dFechaEmision"] ?></div>
                                <?php endif ?>

                            <?php endif ?>
                        <?php else :  ?>

                            <div>
                                <h3>DATOS DEL PEDIDO</h3>
                            </div>
                            <div><span>COD PEDIDO : </span> <?= sp($aryPedido['nIdPedido']) ?></div>
                            <div><span>PAGO : </span> <?= $aryPedido["sEstadoPago"] ?></div>
                            <div><span>FECHA : </span> <?= $aryPedido["dFechaCreacion"] ?></div>

                        <?php endif ?>

                    </div>

                </div>

            </div>


        </header>
        <main>

            <table>
                <thead>
                    <tr>
                        <th class="service">ITEM</th>
                        <th class="desc">PRODUCTO</th>
                        <th class="text-right">CANTIDAD</th>
                        <th class="text-right">PRECIO</th>
                        <th class="text-right">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nDsctTotal = $nDsct = $nSubtotal = 0; ?>
                    <?php foreach ($aryPedidoDetalle as $nKey => $aryDetalle) : ?>
                        <?php
                        $nTotalItem  = $aryDetalle["nPrecio"] *  $aryDetalle["nCantidad"];
                        $nSubtotal  += $nTotalItem;
                        ?>
                        <tr>
                            <td class="service"><?= ($nKey + 1) ?></td>
                            <td class="desc">
                                <p class="mb-0"><?= strup($aryDetalle["sProducto"]) . " " . uc($aryDetalle["sUnidadMedidaCorto"])  ?></p>
                            </td>
                            <td><?= $aryDetalle["nCantidad"] ?></td>
                            <td><?= $arySede["sPrefijoMoneda"]  . nf($aryDetalle["nPrecio"]) ?></td>
                            <td><?= $arySede["sPrefijoMoneda"]  . nf($nTotalItem, true) ?> </td>
                        </tr>
                    <?php endforeach ?>

                    <?php

                    # Calculo Totales 

                    $nDsct      = $nSubtotal * ($aryPedido["nDescuento"] / 100);
                    $nDsctCP    = $aryPedido["nDescuentoCanje"];

                    $nDsctTotal =  $nDsct + $nDsctCP;

                    $nIgv       = $nSubtotal * (IGV / 100);
                    $nSubtotal  = $nSubtotal > $nDsctTotal ? ($nSubtotal - $nDsctTotal) - $nIgv : 0;
                    $nTotal     = $nSubtotal + $nIgv;


                    ?>


                    <tr>
                        <td colspan="4">DSCT <?= $aryPedido["nDescuento"] ?> % </td>
                        <td class="total"><?= $aryPedido["sPrefijoMoneda"]  . nf($nDsct, true) ?></td>
                    </tr>

                    <tr>
                        <td colspan="4">DSCT CANJE <?= $aryPedido["nDescuento"] ?> </td>
                        <td class="total"><?= $aryPedido["sPrefijoMoneda"]  . nf($nDsctCP, true) ?></td>
                    </tr>

                    <tr>
                        <td colspan="4">SUBTOTAL</td>
                        <td class="total"><?= $aryPedido["sPrefijoMoneda"]  . nf($nSubtotal, true) ?></td>
                    </tr>

                    <tr>
                        <td colspan="4">IGV</td>
                        <td class="total"><?= $aryPedido["sPrefijoMoneda"]  . nf($nIgv, true) ?></td>
                    </tr>

                    <tr>
                        <td colspan="4">DSCT TOTAL</td>
                        <td class="total"><?= $aryPedido["sPrefijoMoneda"]  . nf($nDsctTotal, true) ?></td>
                    </tr>

                    <tr>
                        <td colspan="4" class="grand total">TOTAL A PAGAR</td>
                        <td class="grand total"> <?= $aryPedido["sPrefijoMoneda"]  . nf($nTotal, true) ?> </td>
                    </tr>
                </tbody>
            </table>
            <div id="notices">
                <div></div>
                <div class="notice">

                    <?php if ($aryPedido["nPuntosAcumuladosItem"] > 0) : ?>
                        PUNTOS ACUMULADOS POR ESTA VENTA <?= $aryPedido["nPuntosAcumuladosItem"] ?> <br>
                    <?php endif ?>

                    <?php if ($aryPedido["nPuntosCanje"] > 0) : ?>
                        PUNTOS CANJEADOS POR ESTA VENTA <?= $aryPedido["nPuntosCanje"] ?> <br>
                    <?php endif ?>

                </div>
            </div>

        </main>
        <footer>
            <?= $arySede["sNombreEmpresa"] ?> -<?= $arySede["sNombre"] ?> - <?= date("Y") ?>
        </footer>
    <?php else : ?>

        <div style="width: 100%; margin: 0; padding: 0;">

            <div class="centrado">
                <img width="50px" height="50px" class="logo" src="<?= strlen($arySede["sImagen"]) > 0 ?  src('multi/' . $arySede["sImagen"]) : (strlen($arySede["sImagenEmpresa"]) > 0 ? src('multi/' . $arySede["sImagenEmpresa"]) : src("app/app-logo.png")) ?>">
                <h1 style="margin-top: 1px;" class="titulo"> <?= strup($arySede["sNombreEmpresa"]) . " - " . strup($arySede["sNombre"]) ?></h1>
            </div>

            <div class="content-direccion">
                <p class="direccion"><?= strup($arySede["sTipoDocEmp"]) ?> : <?= $arySede["sNumeroDocEmp"] ?> </p>
            </div>

            <div class="content-direccion">
                <p class="direccion">DIRECCION SEDE : <?= strup($arySede["sDireccion"]) ?></p>
            </div>

            <div class="content-direccion">
                <p class="direccion">TELEFONO : <?= strup($arySede["sTelefono"]) ?></p>
            </div>


            <?php if ($aryPedido["nFacturado"] == 1) : ?>

                <?php if (fncValidateArray($aryFactura)) : ?>

                    <?php if (!empty($aryFactura["sTipoComprobante"])) : ?>
                        <div style="margin-top: 4px;" class="row">
                            <div class="col-xs-12 color-plomo centrado">
                                <div class="font-10 "><span><b><?= strtoupper($aryFactura['sTipoComprobante']) . " ELECTRONICA " ?> </b> </span></div>
                                <div class="font-9">
                                    <b><?= strup($aryFactura["sSerieDocumentoComprobante"]) . "-" . $aryFactura["sNumeroDocumentoComprobante"] ?> </b>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="row" style="margin-top: 4px;">
                        <div class="col-xs-12 t-cliente"> DATOS DEL CLIENTE </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 desc-cliente">
                            <?php if (!empty($aryFactura["sTipoDocumento"]) && !empty($aryFactura["sNumeroDocumento"])) : ?>
                                <div><span><?= uc($aryFactura['sTipoDocumento']) ?> : </span><?= $aryFactura["sNumeroDocumento"] ?></div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 desc-cliente">
                            <?php if (!empty($aryFactura["sNombreoRazonSocial"])) : ?>
                                <div><span> Cliente : </span><?= uc($aryFactura["sNombreoRazonSocial"]) ?></div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 desc-cliente">
                            <?php if (!empty($aryCliente["sDireccion"])) : ?>
                                <div><span> Direccion : </span><?= uc($aryCliente["sDireccion"]) ?></div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-6 desc-cliente">
                            <?php if (!empty($aryFactura["dFechaEmision"])) : ?>
                                <div><span> Fec Emi: </span><?= uc($aryFactura["dFechaEmision"]) ?></div>
                            <?php endif ?>
                        </div>


                        <div class="col-xs-6 desc-cliente">
                            <?php if (!empty($aryPedido["sMoneda"])) : ?>
                                <div><span> T.Moneda : </span> <?= uc($aryPedido["sMoneda"]) ?></div>
                            <?php endif ?>
                        </div>


                    </div>
                <?php endif ?>

            <?php else :  ?>

                <div class="centrado">
                    <h2 class="nro-ticket">TICKET N° :<b> <?= sp($nIdPedido) ?></b></h2>
                </div>


                <div class="row">
                    <div class="col-xs-12 t-cliente"> DATOS DEL CLIENTE </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 desc-cliente">
                        <?php if (!empty($aryCliente["sTipoDoc"]) && !empty($aryCliente["sNumeroDocumento"])) : ?>
                            <div><span><?= uc($aryCliente['sTipoDoc']) ?> :</span><?= $aryCliente["sNumeroDocumento"] ?></div>
                        <?php endif ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 desc-cliente">
                        <?php if (!empty($aryCliente["sNombreoRazonSocial"])) : ?>
                            <div><span> Cliente: </span> <?= uc($aryCliente["sNombreoRazonSocial"]) ?></div>
                        <?php endif ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 desc-cliente">
                        <?php if (!empty($aryCliente["sDireccion"])) : ?>
                            <div><span>Direccion : </span> <?= uc($aryCliente["sDireccion"]) ?></div>
                        <?php endif ?>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-6 desc-cliente">
                        <div><span> Fecha : </span> <?= uc($aryPedido["dFechaCreacion"]) ?></div>
                    </div>


                    <div class="col-xs-6 desc-cliente">
                        <?php if (!empty($aryPedido["sMoneda"])) : ?>
                            <div><span> T.Moneda : </span> <?= uc($aryPedido["sMoneda"]) ?></div>
                        <?php endif ?>
                    </div>

                </div>

            <?php endif ?>

            <div class="row">

                <div class="col-xs-12">

                    <table class="mt-table w-100">
                        <thead>
                            <tr>
                                <th class="producto text-left">PRODUCTO</th>
                                <th class="text-left">CANT</th>
                                <th class="text-right ">PRE</th>
                                <th class="text-right ">TOT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nSubtotal = 0; ?>
                            <?php foreach ($aryPedidoDetalle as $nKey => $aryDetalle) : ?>
                                <?php
                                $nTotalItem  = $aryDetalle["nPrecio"] *  $aryDetalle["nCantidad"];
                                $nSubtotal  += $nTotalItem;
                                ?>
                                <tr>
                                    <td class="producto"><?= uc($aryDetalle["sProducto"])  ?></td>
                                    <td class="cantidad"><?= $aryDetalle["nCantidad"] . " - " . uc($aryDetalle["sUnidadMedidaCorto"])   ?></td>
                                    <td class="precio"><?= nf($aryDetalle["nPrecio"])  ?></td>
                                    <td class="precio"><?= nf($nTotalItem, true)  ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        <?php

                        $nDsct      = $nSubtotal * ($aryPedido["nDescuento"] / 100);
                        $nDsctCP    = $aryPedido["nDescuentoCanje"];

                        $nDsctTotal =  $nDsct + $nDsctCP;

                        $nIgv       = $nSubtotal * (IGV / 100);
                        $nSubtotal  = $nSubtotal > $nDsctTotal ? ($nSubtotal - $nDsctTotal) - $nIgv : 0;
                        $nTotal     = $nSubtotal + $nIgv;


                        ?>


                        <tr>
                            <td colspan="2" style="padding: 3px 0;" class="border-top  text-right font-9 color-footer">DSCT</td>
                            <td colspan="2" class="precio text-right  border-top font-9 color-footer"><?= $aryPedido["sPrefijoMoneda"] . nf($nDsct, true) ?></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding: 3px 0;" class="text-right font-9 color-footer">DSCT CANJE</td>
                            <td colspan="2" class="precio text-right   font-9 color-footer"><?= $aryPedido["sPrefijoMoneda"] . nf($nDsctCP, true) ?></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding: 3px 0;" class="text-right font-9 color-footer">SUBTOTAL</td>
                            <td colspan="2" class="precio text-right font-9 color-footer"><?= $aryPedido["sPrefijoMoneda"] . nf($nSubtotal, true) ?></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding: 3px 0;" class="text-right font-9 color-footer">IGV</td>
                            <td colspan="2" class="precio text-right font-9 color-footer"><?= $aryPedido["sPrefijoMoneda"] . nf($nIgv, true) ?></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding: 3px 0;" class="text-right font-9 color-footer">DSCT TOTAl</td>
                            <td colspan="2" class="precio text-right font-9 color-footer"><?= $aryPedido["sPrefijoMoneda"] . nf($nDsctTotal, true) ?></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding: 3px 0;" class="text-right font-9 color-footer">TOTAL A PAGAR</td>
                            <td colspan="2" class="precio text-right font-9 color-footer"> <?= $aryPedido["sPrefijoMoneda"] . nf($nTotal, true) ?> </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding: 3px 0;" class="font-9 color-footer"> SON : <?= convertir(nf($nTotal, true)) ?> </td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="agradecimiento font-9 color-footer">

                <div class="row">
                    <div class="col-xs-6 desc-cliente">
                        <div><span> Pedido : </span> <?= $aryPedido["sNumero"] ?></div>
                    </div>
                    <div class="col-xs-6 desc-cliente">
                        <div><span> E .Pago : </span> <?= uc($aryPedido["sEstadoPago"]) ?></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 desc-cliente">
                        <div><span> Con.Pago : </span> <?= uc($aryPedido["sMetodoPago"]) ?></div>
                    </div>

                    <div class="col-xs-6 desc-cliente">
                        <div><span> Pagaste con : </span> <?= uc($aryPedido["nEfectivo"]) ?></div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-6 desc-cliente">
                        <div><span> Vendedor : </span> <?= uc($aryPedido["sResponsable"]) ?></div>
                    </div>
                    <div class="col-xs-6 desc-cliente">
                        <div><span> Vuelto : </span> <?= uc($aryPedido["nVuelto"]) ?></div>
                    </div>
                </div>

            </div>

            <div style="margin-top: 10px;" class="row">
                <div class="col-xs-12">

                    <div style="padding:5px 0px;font-size: 9px; text-align: center;">


                        <?php if ($aryPedido["nPuntosAcumuladosItem"] > 0) : ?>
                            <?= $aryPedido["nPuntosAcumuladosItem"] ?> PUNTOS ACUMULADOS POR ESTA VENTA <br>
                        <?php endif ?>

                        <?php if ($aryPedido["nPuntosCanje"] > 0) : ?>
                            <?= $aryPedido["nPuntosCanje"] ?> PUNTOS CANJEADOS POR ESTA VENTA <br>
                        <?php endif ?>
                        <br> <br>

                    </div>

                </div>

            </div>


            <div style="margin-top: 10px;" class="row">
                <div class="col-xs-12 desc-cliente ">

                    <div style="padding:10px 0px;" style="font-size: 13px;">
                        <?= $arySede["sDescripcion"] ?>
                    </div>
                </div>
            </div>


            <div style="margin-top: 10px;" class="row">

                <div class="col-xs-12 desc-cliente">

                    <?php $sTextQR = $aryPedido["nFacturado"] == 1  ? " TICKET N° : " . sp($nIdPedido) . " \n " . strtoupper($aryFactura['sTipoComprobante']) . " ELECTRONICA "  . " \n "  . strup($aryFactura["sSerieDocumentoComprobante"]) . "-" . $aryFactura["sNumeroDocumentoComprobante"] . " \n " . "TOTAL : " . $nTotal : " TICKET N° : " . sp($nIdPedido) . " \n "  . "TOTAL : " . $nTotal ?>
                    <!--?php $sUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . $sTextQR . "&choe=UTF-8"; ?-->
                    <?php $sUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . $sTextQR . "&choe=UTF-8"; ?>
                    <div class="qr" style="text-align: center;">
                        <img width="150" height="150" src="<?= $sUrl ?>" alt="">
                    </div>

                </div>
            </div>



            <div style="margin-top: 4px;" class="row">
                <div class="col-xs-12">
                    <div style="font-size: 9px; padding: 5px 0px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <?= $aryPedido["nFacturado"] == 1  ? "REPRESENTACION IMPRESA DE LA " . strtoupper($aryFactura['sTipoComprobante']) . " ELECTRONICA "  : "REPRESENTACION IMPRESA DEL PEDIDO"  ?>
                    </div>
                </div>
            </div>


            <div class="agradecimiento font-9 color-footer centrado">
                <span style="font-weight: bold;"> GRACIAS POR SU PREFERENCIA </span>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>