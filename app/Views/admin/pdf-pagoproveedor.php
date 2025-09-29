<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>PAGO A PROVEEDORES</title>
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
                <div class="h1-mov text-center"><?= $sTitulo ?></div>
            </div>

            <div class="col-xs-4">
                <div class="cod-mov text-right "> FECHA : <?=date("d/m/Y H:i:s")?></div>
            </div>

        </div>
    </header>
    <main>


        <div class="row">

            <div class="col-xs-12">
                <span class="span-content-mov">
                    <b> FORMA DE PAGO : </b>
                    <?= strup($aryPagoProveedor["sMetodoPago"])  ?>
                </span>
            </div>

            <div class="col-xs-12">
                <span class="span-content-mov">
                    <b> BANCO : </b>
                    <?= strup($aryPagoProveedor["sBancoCC"])  ?>
                </span>
            </div>

            <div class="col-xs-12">
                <span class="span-content-mov">
                    <b> NUMERO DE CUENTA : </b>
                    <?= strup($aryPagoProveedor["sNumeroCC"])  ?>
                </span>
            </div>

            <div class="col-xs-12">
                <span class="span-content-mov">
                    <b> FECHA PAGO : </b>
                    <?= strup($aryPagoProveedor["dFechaPago"]) ?>
                </span>
            </div>

            <div class="col-xs-12">
                <span class="span-content-mov">
                    <b> IMPORTE TOTAL : </b>
                    <?= strup($aryPagoProveedor["nTotal"]) ?>
                </span>
            </div>

            
            <div class="col-xs-12">
                <span class="span-content-mov">
                    <b> PROVEEDOR : </b>
                    <?= strup($aryPagoProveedor["sProveedor"]) ?>
                </span>
            </div>


        </div>

        <br>



        <table>
            <thead>
                <tr>
                    <th class="service">ITEM</th>
                    <th class="service">TIPO DOCUMENTO</th>
                    <th class="desc">NRO DOCUMENTO</th>
                    <th class="text-right">F.VENC</th>
                    <th class="text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($aryDetalle as $nKey => $aryLoop) : ?>
                    <tr>
                        <td class="service"><?= ($nKey + 1) ?></td>
                        <td style="text-align: left;"><?= $aryLoop["sTipoDoc"] ?></td>
                        <td style="text-align: left;"><?= $aryLoop["sNumero"] ?></td>
                        <td><?= $aryLoop["dVencimiento"] ?></td>
                        <td><?= $aryLoop["nTotal"] ?></td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
        <div id="notices">
            <div></div>
            <div class="notice"></div>
        </div>

        <br>
        <br>
        <br>
        <br>

        <table style="border: 1px solid #5d6975;">
            <tr>
                <td style="background-color: white; border: 1px solid #5d6975;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="background-color: white; border: 1px solid #5d6975;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="background-color: white; border: 1px solid #5d6975;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: white; text-align: center; border: 1px solid #5d6975;" >REVISADO</td>
                <td style="background-color: white; text-align: center; border: 1px solid #5d6975;" >AUTORIZADO</td>
                <td style="background-color: white; text-align: center; border: 1px solid #5d6975;" >RECIBI CONFORME</td>
            </tr>
        </table>

    </main>
    <footer>
        <?= $arySede["sNombreEmpresa"] ?> -<?= $arySede["sNombre"] ?> - <?= date("Y") ?>
    </footer>

</body>

</html>