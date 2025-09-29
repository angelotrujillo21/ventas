<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Cotizacion</title>
    <?php load_style(['pdf-ctz']) ?>
</head>

<body>

    <header class="clearfix">

        <div class="row">
            <div class="col-xs-9">
                <p>
                    <?= nl2br($arySede["sDescripcion1Ctz"]) ?>
                </p>

                <div class="row">
                    <div class="col-xs-4">
                        <img src="<?= strlen($arySede["sImagen"]) > 0 ?  src('multi/' . $arySede["sImagen"]) : (strlen($arySede["sImagenEmpresa"]) > 0 ? src('multi/' . $arySede["sImagenEmpresa"]) : src("app/app-logo.png")) ?>">
                    </div>
                    <div class="col-xs-8">
                        <?= nl2br($arySede["sDescripcion2Ctz"]) ?>

                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div style="margin-top: 20%; border: 1px solid #c1ced9; font-weight: bold; font-size: 18px; text-align: center; padding: 5px; border-radius: 10px;">
                    <strong>COTIZACION</strong>
                    <p><?= $aryHeader["sNumero"] ?></p>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <?= nl2br($arySede["sDescripcion3Ctz"]) ?>
            </div>
        </div>


        <br>

        <div class="row">
            <div class="col-xs-12">
                <p> <strong>Estimados Señores:</strong> <br>
                    Por medio de la presente, y de acuerdo a su solicitud, sometemos a su consideración nuestra mejor oferta por el
                    siguiente servicio/Producto:
                </p>
            </div>
        </div>

        <table>
            <tr>
                <td><strong>SEÑOR(ES): </strong> <?= $aryHeader["sCliente"] ?></td>
                <td><strong>FECHA: </strong><?= $aryHeader["dFechaCotizacion"] ?></td>
            </tr>
            <tr>
                <td><strong>DIRECCION: </strong><?= $aryHeader["sDireccionCliente"] ?></td>
                <td><strong>CON.PAGO: </strong><?= $aryHeader["nIdFormaPago"] == 1 ? 'CONTADO' : 'CREDITO' ?></td>
            </tr>
            <tr>
                <td><strong><?= $aryHeader["sTipoDocCliente"] ?>: </strong><?= $aryHeader["sNumeroDocumentoCliente"] ?></td>
                <td></td>
            </tr>
        </table>

    </header>
    <main>

        <table class="tbl-estilos">
            <thead>
                <tr>
                    <th class="service"> <strong>CODIGO</strong></th>
                    <th class="desc"><strong>DESCRIPCION</strong></th>
                    <th class="text-right"><strong>CANTIDAD</strong></th>
                    <th class="text-right"><strong>PRECIO</strong></th>
                    <th class="text-right"><strong>%DSCT</strong></th>
                    <th class="text-right"><strong>TOTAL</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aryDetalle as $nKey => $aryLoop) : ?>
                    <tr>
                        <td><?= $aryLoop["sCodigoInternoProducto"] ?></td>
                        <td>
                            <p class="mb-0"><?= strup($aryLoop["sProducto"]) . " " . uc($aryLoop["sUnidadMedidaCorto"])  ?></p>
                        </td>
                        <td class="text-right"><?= $aryLoop["nCantidad"] ?></td>
                        <td class="text-right"><?= $arySede["sPrefijoMoneda"]  . nf($aryLoop["nPrecio"]) ?></td>
                        <td class="text-right"><?= $aryLoop["nPorcentajeDsct"] ?></td>
                        <td class="text-right"><?= $arySede["sPrefijoMoneda"]  . nf($aryLoop["nTotal"], true) ?> </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-xs-12">

                <div style="width: 20%; float: right; padding: 10px;border: 1px solid #c1ced9;border-radius: 10px;">
                    <div>
                        <div class="text-right"> <b>SUBTOTAL: </b> <?= $arySede["sPrefijoMoneda"]  . nf($aryHeader["nBaseImponible"], true) ?> </div>
                    </div>

                    <div>
                        <div class="text-right"><b>DCTO: </b><?= $arySede["sPrefijoMoneda"]  . nf($aryHeader["nDescuento"], true) ?></div>
                    </div>

                    <div>
                        <div class="text-right"> <b>IGV: </b><?= $arySede["sPrefijoMoneda"]  . nf($aryHeader["nImpuesto"], true) ?></div>
                    </div>
                    <div>
                        <div class="text-right"><b>TOTAL: </b><?= $arySede["sPrefijoMoneda"]  . nf($aryHeader["nTotal"], true) ?> </div>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <table class="tbl-estilos">
            <tr>
                <td colspan="2" class="text-center">
                    <strong>
                        CONDICIONES COMERCIALES
                    </strong>
                </td>
            </tr>
            <tr>
                <td><strong>TIEMPO DE ENTREGA:</strong></td>
                <td><?= $aryHeader["sTiempoEntregaCC"] ?></td>
            </tr>
            <tr>
                <td><strong>FORMA DE PAGO:</strong></td>
                <td><?= $aryHeader["sFormaPagoCC"] ?></td>
            </tr>
            <tr>
                <td><strong>LUGAR DE ENTREGA:</strong></td>
                <td><?= $aryHeader["sLugarEntregaCC"] ?></td>
            </tr>
            <tr>
                <td><strong>GARANTIA:</strong></td>
                <td><?= $aryHeader["sGarantiaCC"] ?></td>
            </tr>
            <tr>
                <td><strong>VALIDEZ DE LA OFERTA:</strong></td>
                <td><?= $aryHeader["sValidezOfertaCC"] ?></td>
            </tr>
        </table>

        <table class="tbl-estilos">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">
                        <strong>CUENTAS BANCARIAS: <?= $arySede["sNombreEmpresa"] ?></strong>
                    </th>
                </tr>
                <tr>
                    <th class="font-bold"><strong>Tipo de cuenta</strong></th>
                    <th class="font-bold"><strong>N° de cuenta</strong></th>
                    <th class="font-bold"><strong>Código cuenta interbancario</strong></th>
                    <th class="font-bold"><strong>Banco</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aryCuentasCorrientes as $nKey => $aryLoop) : ?>
                    <tr>
                        <td class="text-center"><?= $aryLoop["sTipoCuenta"] ?></td>
                        <td class="text-center"><?= $aryLoop["sNumero"] ?></td>
                        <td class="text-center"><?= " " ?></td>
                        <td class="text-center"><?= $aryLoop["sBanco"] ?></td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>

        <p>
            Sin otro particular y en espera de su aceptación a la presente, quedamos a su disposición para cualquier consulta que ustedes estimen conveniente.
        </p>

    </main>
    <footer>
        <?= $arySede["sNombreEmpresa"] ?> -<?= $arySede["sNombre"] ?> - <?= date("Y") ?>
    </footer>

</body>

</html>