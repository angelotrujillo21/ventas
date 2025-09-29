<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Movimiento</title>
    <?php load_style(['pdf']) ?>
</head>

<body>

    <header class="clearfix">

        <div class="row">

            <div class="col-xs-4">
                <div class="logo-mov">
                    <img class="logo-mov" src="<?= strlen($arySede["sImagen"]) > 0 ?  src('multi/' . $arySede["sImagen"]) : (strlen($arySede["sImagenEmpresa"]) > 0 ? src('multi/' . $arySede["sImagenEmpresa"]) : src("app/app-logo.png")) ?>">
                </div>
            </div>

            <div class="col-xs-4">
                <div class="h1-mov text-center">ORDEN DE COMPRA</div>
            </div>

            <div class="col-xs-4">
                <div class="cod-mov text-right "> N° : <?= sp($aryOc["nIdOrdenCompra"]) ?></div>
            </div>

        </div>
    </header>
    <main>


        <div class="row">

            <div class="col-xs-3">
                <span class="span-content-mov">
                    <b> DESCRIPCION : </b>
                    <?= strup($aryOc["sDescripcion"]) ?>
                </span>
            </div>

            <div class="col-xs-3">
                <span class="span-content-mov">
                    <b> FECHA : </b>
                    <?= strup($aryOc["dFechaOrdenCompra"]) ?>
                </span>
            </div>

            <div class="col-xs-3">
                <span class="span-content-mov">
                    <b> ESTADO : </b>
                    <?= strup($aryOc["nEjecutado"] == 1  ? "EJECUTADO" : "PLANIFICADO") ?>
                </span>
            </div>

        </div>

        <br>



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
                <?php $nSubtotal = 0; ?>
                <?php foreach ($aryOcDetalle as $nKey => $aryDetalle) : ?>
                    <?php
                    $nTotalItem  = $aryDetalle["nPrecio"] *  $aryDetalle["nCantidad"];
                    $nSubtotal  += $nTotalItem;
                    ?>
                    <tr>
                        <td class="service"><?= ($nKey + 1) ?></td>
                        <td class="desc">
                            <p class="mb-0"><?= strup($aryDetalle["sProducto"]) ?></p>
                        </td>
                        <td><?= $aryDetalle["nCantidad"] ?></td>
                        <td><?= $arySede["sPrefijoMoneda"]  . nf($aryDetalle["nPrecio"]) ?></td>
                        <td><?= $arySede["sPrefijoMoneda"]  . nf($nTotalItem, true) ?> </td>
                    </tr>
                <?php endforeach ?>

                <?php

                $nIgv       = $nSubtotal * (IGV / 100);
                $nSubtotal  = $nSubtotal - $nIgv;
                $nTotal     = $nSubtotal + $nIgv;

                ?>

                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total"><?= $arySede["sPrefijoMoneda"]  . nf($nSubtotal, true) ?></td>
                </tr>

                <tr>
                    <td colspan="4">IGV</td>
                    <td class="total"><?= $arySede["sPrefijoMoneda"]  . nf($nIgv, true) ?></td>
                </tr>

                <tr>
                    <td colspan="4" class="grand total">TOTAL</td>
                    <td class="grand total"> <?= $arySede["sPrefijoMoneda"]  . nf($nTotal, true) ?> </td>
                </tr>
            </tbody>
        </table>
        <div id="notices">
            <div></div>
            <div class="notice"></div>
        </div>

    </main>
    
 
    <header class="clearfix">

        <div class="row">

        
            <div class="col-xs-9">
                <div class="h1-mov text-left">GASTO</div>
            </div>

            <div class="col-xs-3">
                <div class="cod-mov text-right "> N° : <?= sp($aryGasto["nIdOrdenCompra"]) ?></div>
            </div>

        </div>
    </header>
    <main>


        <div class="row">

            <div class="col-xs-3">
                <span class="span-content-mov">
                    <b> DESCRIPCION : </b>
                    <?= strup($aryGasto["sDescripcion"]) ?>
                </span>
            </div>

            <div class="col-xs-3">
                <span class="span-content-mov">
                    <b> FECHA : </b>
                    <?= strup($aryGasto["dFechaOrdenCompra"]) ?>
                </span>
            </div>

            <div class="col-xs-3">
                <span class="span-content-mov">
                    <b> ESTADO : </b>
                    <?= strup($aryGasto["nEjecutado"] == 1  ? "EJECUTADO" : "PLANIFICADO") ?>
                </span>
            </div>

        </div>

        <br>



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
                <?php $nSubtotal = 0; ?>
                <?php foreach ($aryGastoDetalle as $nKey => $aryDetalle) : ?>
                    <?php
                    $nTotalItem  = $aryDetalle["nPrecio"] *  $aryDetalle["nCantidad"];
                    $nSubtotal  += $nTotalItem;
                    ?>
                    <tr>
                        <td class="service"><?= ($nKey + 1) ?></td>
                        <td class="desc">
                            <p class="mb-0"><?= strup($aryDetalle["sProducto"]) ?></p>
                        </td>
                        <td><?= $aryDetalle["nCantidad"] ?></td>
                        <td><?= $arySede["sPrefijoMoneda"]  . nf($aryDetalle["nPrecio"]) ?></td>
                        <td><?= $arySede["sPrefijoMoneda"]  . nf($nTotalItem, true) ?> </td>
                    </tr>
                <?php endforeach ?>

                <?php

                $nIgv       = $nSubtotal * (IGV / 100);
                $nSubtotal  = $nSubtotal - $nIgv;
                $nTotal     = $nSubtotal + $nIgv;

                ?>

                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total"><?= $arySede["sPrefijoMoneda"]  . nf($nSubtotal, true) ?></td>
                </tr>

                <tr>
                    <td colspan="4">IGV</td>
                    <td class="total"><?= $arySede["sPrefijoMoneda"]  . nf($nIgv, true) ?></td>
                </tr>

                <tr>
                    <td colspan="4" class="grand total">TOTAL</td>
                    <td class="grand total"> <?= $arySede["sPrefijoMoneda"]  . nf($nTotal, true) ?> </td>
                </tr>
            </tbody>
        </table>
        <div id="notices">
            <div></div>
            <div class="notice"></div>
        </div>

    </main>
    <footer>
        <?= $arySede["sNombreEmpresa"] ?> -<?= $arySede["sNombre"] ?> - <?= date("Y") ?>
    </footer>

</body>

</html>