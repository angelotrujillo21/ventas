<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <meta charset="uft-8">
    <meta name="author" content="MM">
    <link rel="shortcut icon" href="<?= isset($user["sImagenEmpresa"]) && strlen($user["sImagenEmpresa"]) > 0 ? src("multi/" . $user["sImagenEmpresa"])  : (isset($user["sImagenSede"]) && strlen($user["sImagenSede"]) > 0 ? src("multi/" . $user["sImagenSede"]) :  src('app/shards-dashboards-logo.svg')) ?>" />
    <title><?= isset($sTitulo) && !empty($sTitulo) ? $sTitulo : NOMBRE_SITIO ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <?php
    load_style(['bootstrap', 'jquery-ui']);

    load_style_plugin([
        'toast/toastr.min',
        'bootstrap-table/bootstrap-table',
    ]);
    ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            /* Color de fondo para la cabecera de la carta en caso no quieras utilizar un fondo dejarlo como transaparent*/
            --bg-carta-header: <?= $aryHeader["sColor1"]  ?>;
            /* Color de texto para la cabecera de la carta */
            --text-color-carta-header: <?= $aryHeader["sColor2"] ?>;

            /* Color de fondo para los botones */
            --bg-carta-botones: <?= $aryHeader["sColor3"] ?>;
            /* Color de texto para los botones */
            --text-color-botones: <?= $aryHeader["sColor4"] ?>;

            /* Color fondo para cada seccion en caso no lo requiera colocar none */
            --bg-carta-seccion: <?= $aryHeader["sColor5"] ?>;
            /* Color de texto para cada seccion */
            --text-color-carta-seccion: <?= $aryHeader["sColor6"] ?>;

            /* Color de texto para el titulo del producto */
            --text-color-carta-titulo: <?= $aryHeader["sColor7"] ?>;
            /* Color de texto para el detalle del producto */
            --text-color-carta-detalle: <?= $aryHeader["sColor8"] ?>;
            /* Color de texto para el precio */
            --text-color-carta-precio: <?= $aryHeader["sColor9"] ?>;

            /* Color de texto para el separador */
            --text-color-separador: <?= $aryHeader["sColor10"] ?>;

            /* Color de texto para el boton de editar en la ventana ver pedido */
            --text-color-boton-editar: <?= $aryHeader["sColor11"] ?>;
            /* Color de texto para el boton de eliminar en la ventana ver pedido */
            --text-color-boton-eliminar: <?= $aryHeader["sColor12"] ?>;
            /* Color de fondo para la mascara de la carta para la capa superior del fondo principal */
            --bg-mascara-carta: <?= $aryHeader["sColor13"] ?>;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .color-plomo {
            color: #888080 !important;
        }

        .color-black {
            color: #000 !important;
        }

        .color-precio {
            color: #7BCF6B !important;
        }


        body {
            font-family: 'Montserrat', serif !important;
            font-size: 0.9125rem !important;
            -webkit-overflow-scrolling: touch;
            overflow-x: hidden !important;
        }

        .page-loader {
            position: fixed;
            width: 100%;
            height: 100%;
            margin: 0 auto !important;
            background-color: #000000a3 !important;
            transition: background-color ease 2s 1s;
            z-index: 999999;
        }

        .loader-dual-ring {
            display: inline-block;
            width: 64px;
            height: 64px;
        }

        .loader-dual-ring {
            margin: 0;
            margin-right: 0px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);
        }

        .loader-dual-ring::after {
            content: " ";
            display: block;
            width: 3rem;
            height: 3rem;
            margin: 1px;
            border-radius: 50%;
            border: 0.3rem solid #ffff;
            border-color: #ffff transparent #ffff transparent;
            animation: loader-dual-ring 1.1s ease infinite;
        }

        @keyframes loader-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }


        .carta-header h4,
        .carta-header small {
            color: var(--text-color-carta-header) !important;
        }

        .carta-header h4 {
            font-size: 1.9rem;
            font-weight: 700;
        }

        .icon-cart-carta {
            border-radius: 5px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            font-size: 1.3rem;
            justify-content: center;
            background: var(--bg-carta-botones);
            border: 1px solid var(--text-color-botones);
        }

        .icon-cart-carta a {
            color: var(--text-color-botones) !important;
        }

        .carta-seccion {
            background-color: var(--bg-carta-seccion);
            color: var(--text-color-carta-seccion);
            text-align: center;
        }


        .carta-seccion h6 {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .carta-item .detalle {
            font-size: 11px;
            color: var(--text-color-carta-detalle);
            font-weight: 400;
        }

        .carta-item .titulo {
            font-size: 14px;
            color: var(--text-color-carta-titulo);

        }

        .font-weight-700 {
            font-weight: 700;
        }

        .carta-item .img-item {
            height: 90px;
            object-fit: cover;
            width: auto;
            border-radius: 13px;
            padding: 3px;
        }

        .carta-item .precio {
            color: var(--text-color-carta-precio);
            font-weight: bold;
            font-size: 18px;
        }

        .btn-agregar {
            background: var(--bg-carta-botones);
            color: var(--text-color-botones);
        }

        .btn-agregar:hover {
            background: var(--bg-carta-botones) !important;
            color: var(--text-color-botones) !important;
            font-weight: bold;
        }

        .separador {
            border-bottom: 0.5px solid var(--text-color-separador);
        }

        .btn-comprar {
            background-color: var(--bg-carta-botones);
            color: var(--text-color-botones);
        }

        .btn-comprar:hover {
            background-color: var(--bg-carta-botones);
            color: var(--text-color-botones);
        }

        .content-acciones {
            margin: 3px 0px;
        }

        .btn-editar {
            color: var(--text-color-boton-editar);
            text-decoration: none;
            cursor: pointer;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 10px;
            border: 1px solid;
        }

        .btn-eliminar {
            color: var(--text-color-boton-eliminar);
            text-decoration: none;
            cursor: pointer;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 10px;
            border: 1px solid;
        }

        .btn-editar:hover {
            color: var(--text-color-boton-editar) !important;
            font-weight: bold !important;
            text-decoration: none;
        }

        .btn-eliminar:hover {
            color: var(--text-color-boton-eliminar) !important;
            font-weight: bold !important;
            text-decoration: none;
        }

        .sTotalPedido {
            text-align: right;
            font-size: 22px;
        }

        .sTotalPedido #sTotalPagar {
            color: var(--text-color-carta-precio);
            font-weight: bold;
        }

        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            background: var(--bg-carta-botones) !important;
        }

        .bg-mascara {
            background: var(--bg-mascara-carta);
        }

        .w-80 {
            width: 80%;
        }
    </style>

    <?php if (!empty($aryHeader["sImagenHeader"])) : ?>
        <style>
            .carta-header {
                background-image: url('<?= src("multi/" . $aryHeader["sImagenHeader"]) ?>');
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
                background-position: center;
            }

            .bg-mascara-header {
                background-color: var(--bg-carta-header);
            }
        </style>
    <?php else : ?>
        <style>
            .carta-header {
                background-color: var(--bg-carta-header) !important;
            }
        </style>
    <?php endif ?>

    <?php if (!empty($aryHeader["sImagen"])) : ?>
        <style>
            main {
                background-image: url('<?= src("multi/" . $aryHeader["sImagen"]) ?>');
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
                background-position: center;
            }
        </style>
    <?php endif ?>

</head>

<body class="h-100">


    <main class="container-fluid mx-0 px-0 h-100">
        <div class="page-loader" style="display: none;">
            <div class="loader-dual-ring"></div>
        </div>
        <div class="row h-100">
            <main class="main-content col-lg-12 col-md-12 col-sm-12 p-0 ">
                <div class="main-content-container container-fluid px-0 bg-mascara h-100">
                    <div class="container-fluid mx-0">
                        <div id="carta" class="page-header row no-gutters">
                            <div class="col-12 col-sm-12 mb-2">
                                <div class=" carta-header">
                                    <div class="d-flex justify-content-between align-items-center bg-mascara-header py-4 px-4">
                                        <div></div>
                                        <div class="text-center ml-5">
                                            <h4 class="mb-0"><?= $aryHeader["sNombre"] ?></h4>
                                            <?php if (!is_null($aryMesa)) : ?>
                                                <small><?= $aryMesa["sDescripcion"] ?></small>
                                            <?php endif ?>
                                        </div>
                                        <div>
                                            <div class="icon-cart-carta">
                                                <a id="btnTerminarPedidoTop" href="javascript:;" title="Ver Carrito">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="accordion" class="row no-gutters w-100">
                                <?php foreach ($aryDetalle as $key => $aryLoop) : ?>
                                    <div class="col-12 col-md-4 p-0 p-md-2">
                                        <div class="row">
                                            <!-- Seccion -->
                                            <div id="heading<?= $aryLoop["nIdCartaDigitalSeccion"] ?>" class="col-12 mb-2 cursor-pointer" data-toggle="collapse" data-target="#collapse<?= $aryLoop["nIdCartaDigitalSeccion"] ?>" aria-expanded="true" aria-controls="collapse<?= $aryLoop["nIdCartaDigitalSeccion"] ?>">
                                                <div class="py-3 px-2 carta-seccion">
                                                    <h6 class="mb-0 "><?= $aryLoop["sNombre"] ?></h6>
                                                </div>
                                            </div>

                                            <!-- Listado productos -->
                                            <div id="collapse<?= $aryLoop["nIdCartaDigitalSeccion"] ?>" class="row no-no-gutters collapse p-2 <?= $bIsMovil ? "" : "show" ?>" aria-labelledby="heading<?= $aryLoop["nIdCartaDigitalSeccion"] ?>" data-parent="#accordion">
                                                <?php foreach ($aryLoop["aryDetalle"] as $nKeySB => $aryLoopSD) : ?>
                                                    <!-- Producto -->
                                                    <div class="col-12">
                                                        <div id="cardProducto<?= $aryLoopSD['nIdProducto'] ?>" data-precio="<?= $aryLoopSD["nPrecioProducto"] ?>" data-json-extras='<?= json_encode($aryLoopSD["aryExtras"]) ?>' class="py-2 px-2 carta-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <?php if (!empty($aryLoopSD["sImagenProducto"])) : ?>
                                                                    <img class="img-item" src="<?= src("multi/" . $aryLoopSD["sImagenProducto"]) ?>" alt="Imagen">
                                                                <?php else : ?>
                                                                    <img class="img-item" src="<?= src("app/sin-imagen.jpg") ?>" alt="Sin Imagen">
                                                                <?php endif ?>
                                                            </div>
                                                            <div class="w-80 p-2">
                                                                <div class="mb-1 titulo font-weight-700"><?= strtoupper($aryLoopSD["sProducto"]) ?></div>
                                                                <p class="detalle mb-1">
                                                                    <?= nl2br($aryLoopSD["sDetalleProducto"]) ?>
                                                                    <?php if (strlen($aryLoopSD["sExtra"]) > 0) : ?>
                                                                        <strong>Extras: </strong>
                                                                        <?= str_replace(",", " , ", $aryLoopSD["sExtra"]) ?>
                                                                    <?php endif ?>
                                                                </p>
                                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                                    <div>
                                                                        <p class="precio mb-1">S/. <?= nf($aryLoopSD["nPrecioProducto"], true) ?></p>
                                                                    </div>
                                                                    <div class="mr-1">
                                                                        <?php if (floatval($aryLoopSD["nPrecioProducto"]) > 0) : ?>
                                                                            <button onclick="fncVerProducto(<?= $aryLoopSD['nIdProducto'] ?>);" class="btn btn-agregar">Pedir</button>
                                                                        <?php endif ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 separador mx-0 my-2"></div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>

            </main>

        </div>
    </main>

    <!-- Modales -->
    <!-- Modal -->
    <div class="modal fade" id="modalVerProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="carritoVerProducto" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carritoVerProducto">Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Producto -->
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="py-2 px-2 carta-item d-flex justify-content-between align-items-center">
                                <div style="width: 80%;">
                                    <div id="sTituloVP" class="mb-1 titulo color-black"></div>
                                    <p id="sDetalleVP" class="detalle mb-1 color-plomo"></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p id="sPrecioVP" class="precio mb-1 color-precio">S./ 100.00</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <img id="sImagenVP" class="img-item" alt="Imagen">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-12 mb-2">
                            <strong>Cantidad</strong>
                        </div>
                        <div class="col-12">
                            <input type="number" class="form-control" placeholder="Cantidad" name="nCantidad" id="nCantidad" step="1" min="1" max="100">
                        </div>
                    </div>

                    <div class="row contentExtras my-2">
                        <div class="col-12">
                            <strong>Extras</strong>
                        </div>
                        <div class="col-12 mb-2">
                            <div id="contenedorFormExtras"></div>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-12">
                            <textarea class="form-control" placeholder="Comentario ..." name="sObservacion" id="sObservacion" cols="30" rows="2"></textarea>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn color-black" data-dismiss="modal">Cerrar</button>
                    <button id="btnAgregar" type="button" class="btn btn-comprar">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCarrito" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="CarritoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content modal-body-scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="CarritoLabel">Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <table id="tblCarrito" data-toggle="table" data-unique-id="nIdRow" data-show-columns="false" data-search="false" data-show-refresh="false" data-pagination="false" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="true" data-sort-name="nIdRow" data-sort-order="asc">
                                <thead>
                                    <tr>
                                        <th data-field="nIdRow" data-visible="false">nIdRow</th>
                                        <th data-field="sProducto" data-sortable="false">Producto</th>
                                        <th data-field="nCantidad" data-sortable="false">Cantidad</th>
                                        <th data-field="nPrecio" data-sortable="false">Precio</th>
                                        <th data-field="nTotal" data-sortable="false">Total</th>
                                        <th data-field="sAcciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 my-1">
                            <input type="text" class="form-control" name="sNombreClienteP" id="sNombreClienteP" placeholder="Ingrese su nombre">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 my-1">
                            <textarea class="form-control" name="sComentarioP" id="sComentarioP" placeholder="Ingrese un comentario para el pedido" cols="30" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-12">
                            <h6 class="sTotalPedido">Total a pagar <span id="sTotalPagar" class="color-precio"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn color-black" data-dismiss="modal">Seguir comprando</button>
                    <button id="btnGrabarPedido" type="button" class="btn btn-comprar">Terminar Pedido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de modales -->
    <?php extend_view(['admin/common/footer'], $data) ?>
</body>


<script>
    const web_root = '<?= WEB_ROOT ?>';
    const web_root_resource = '<?= WEB_ROOT_RESOURCE ?>';
    const simbolo_moneda = '<?= SIMBOLO_MONEDA ?>';
    const nIgv = '<?= IGV ?>';
</script>

<?php

load_script([
    'jquery',
    'jquery-ui',
    'popper',
    'bootstrap',
    'moment',

]);

load_script_plugin(
    [
        'toast/toastr.min',
        'bootstrap-table/bootstrap-table',
        'bootstrap-table/bootstrap-table-es-ES',

    ]
);

?>


<script>
    $("body").data("zindex", 0);
    $(document).on("show.bs.modal", ".modal", function(event) {
        var zIndex = $("body").data("zindex") == 0 ? 1075 + 10 * $(".modal:visible").length : $("body").data("zindex") + 10;

        $("body").data("zindex", zIndex);
        $(this).css("z-index", zIndex);

        setTimeout(function() {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack");
        }, 0);
    });
    // Para que ningun modal se pueda cerrar tiene que darle click en la X
    $(document)
        .find(".modal")
        .each(function() {
            $(this).attr("data-backdrop", "static");
            $(this).attr("data-keyboard", "false");
        });
</script>

<!--Carta digital -->
<script>
    $(function() {

        $("#btnTerminarPedidoBottom,#btnTerminarPedidoTop").click(function() {
            if ($("#tblCarrito").bootstrapTable("getData").length == 0) {
                toastr.error("Error. Todavia no tienes ningun item en el carrito. Agrega uno por lo menos");
                return;
            }
            $("#modalCarrito").modal("show");
        });

        $("#nCantidad").on("keyup blur", function() {
            var nCantidad = $(this).val() == '' || isNaN($(this).val()) || $(this).val() < 0 ? 1 : parseFloat($(this).val());
            var nPrecio = parseFloat($("#sTituloVP").data("nPrecio"));
            var nTotal = nCantidad * nPrecio;
            $("#sTituloVP").data("nTotal", nTotal);
            $("#btnAgregar").html("Agregar S./ " + nTotal.toFixed(2));
        });

        $('#tblCarrito').data("nIdRow", 0);

        $("#btnGrabarPedido").on("click", function() {
            var sCliente = $("#sNombreClienteP").val().trim();
            var sObservacion = $("#sComentarioP").val().trim();
            var aryDetalle = $("#tblCarrito").bootstrapTable("getData");

            if (sCliente == '') {
                toastr.error('Error. Debe ingresar el nombre del cliente. Porfavor verifique');
                return;
            }

            if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar al menos un producto. Porfavor verifique');
                return;
            }

            var jsnData = {
                nIdRegistro: 0,
                nIdEmpresa: '<?= $aryHeader["nIdEmpresa"] ?>',
                nIdSede: '<?= $aryHeader["nIdSede"] ?>',
                sCliente: sCliente,
                sObservacion: sObservacion,
                nIdEstado: '<?= $nIdEstadoPendiente ?>',
                nIdCartaDigital: '<?= $nIdCartaDigital ?>',
                nIdMesa: '<?= $nIdMesa ?>',
                nTotal: $("#sTotalPagar").data("nTotal"),
                nEstado: 1,
                aryDetalle: JSON.stringify(aryDetalle)
            };

            fncGrabarPedido(jsnData, (aryResponse) => {
                if (aryResponse.success) {

                    Swal.fire({
                        icon: 'success',
                        title: "Genial se registro el pedido de forma exitosa...<br>Nro de pedido: " + aryResponse.sIdNewRegistro,
                        showConfirmButton: true,
                    });

                    $("input").val("");
                    $("textarea").val("");
                    $('#tblCarrito').bootstrapTable("load", []);
                    $('#tblCarrito').data("nIdRow", 0);
                    $("#modalCarrito").modal("hide");
                    fncCalcularTotales();
                } else {
                    toastr.error(aryResponse.error);
                }
            });


        });
    });


    function fncVerProducto(nIdProducto) {
        var objContenedorProducto = $("#cardProducto" + nIdProducto);
        $("#modalVerProducto").data("nIdRegistro", 0);
        $("#sTituloVP").data("nIdProducto", nIdProducto);
        $("#sTituloVP").data("nPrecio", objContenedorProducto.data("precio"));
        $("#sTituloVP").data("sProducto", objContenedorProducto.find(".titulo").html().trim());
        $("#sTituloVP").data("jsnExtras", objContenedorProducto.data("json-extras"));
        $("#sTituloVP").html(objContenedorProducto.find(".titulo").html().trim());
        $("#sDetalleVP").html(objContenedorProducto.find(".detalle").html().trim());
        $("#sPrecioVP").html(objContenedorProducto.find(".precio").html().trim());
        $("#sImagenVP").attr("src", objContenedorProducto.find(".img-item").attr("src"));
        $("#nCantidad").val(1).keyup();
        $("#sObservacion").val("");

        var aryExtras = objContenedorProducto.data("json-extras");
        $(".contentExtras").hide();
        if (aryExtras.length > 0) {
            $(".contentExtras").show();
            fncDrawExtras(aryExtras, "#contenedorFormExtras");
        }

        $("#modalVerProducto").find(".modal-title").html('Agregar Producto');
        $("#modalVerProducto").modal("show");
    }

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


    // Llamadas al servidor
    function fncGrabarPedido(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cartaDigital/fncGrabarPedido',
            data: jsnData,
            beforeSend: function() {
                $(".page-loader").show();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                $(".page-loader").hide();
            }
        });
    }
</script>


<!-- Agregar Carrito-->
<script>
    $(function() {
        // Submit del formulario de Cliente
        $("#btnAgregar").on('click', function(event) {

            event.preventDefault();

            var nIdRegistro = $("#modalVerProducto").data("nIdRegistro");
            var nIdProducto = $("#sTituloVP").data("nIdProducto");
            var nPrecio = $("#sTituloVP").data("nPrecio");
            var nTotal = $("#sTituloVP").data("nTotal");
            var sProducto = $("#sTituloVP").data("sProducto");
            var nCantidad = $("#nCantidad").val();
            var sObservacion = $("#sObservacion").val().trim();
            var aryExtras = $("#sTituloVP").data("jsnExtras");

            if (nCantidad == '' || isNaN(nCantidad) || nCantidad <= 0) {
                toastr.error('Error. Debe ingresar la cantidad. Porfavor verifique');
                return;
            }


            var aryValuesExtras = [];

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

                var nIdRow = $('#tblCarrito').data("nIdRow") + 1;
                sLinkEdit = "fncEditarDetalle(" + nIdRow + ")";
                sLinkDelete = "fncEliminarDetalle(" + nIdRow + ")";

                var sAcciones = `
                <div class="content-acciones">
                    <a onclick="${sLinkEdit}" href="javascript:;" class="btn-editar" title="Editar">Editar</a>
                    <a onclick="${sLinkDelete}" href="javascript:;" class="btn-eliminar" title="Eliminar">Eliminar</a>
                </div>`;

                var jsnData = {
                    nIdRow: nIdRow,
                    nIdDetalle: 0,
                    sAcciones: sAcciones,
                    nIdProducto: nIdProducto,
                    sProducto: sProducto,
                    nPrecio: parseFloat(nPrecio).toFixed(2),
                    nCantidad: nCantidad,
                    nTotal: parseFloat(nTotal).toFixed(2),
                    sObservacion: sObservacion,
                    aryExtras: JSON.stringify(aryExtras),
                    aryValuesExtras: JSON.stringify(aryValuesExtras)
                };

                $('#tblCarrito').bootstrapTable('insertRow', {
                    index: 1,
                    row: jsnData
                });

                $('#tblCarrito').data("nIdRow", nIdRow);
                $("#modalVerProducto").modal("hide");

                setTimeout(() => {
                    fncAnimateAgregarProducto(nIdProducto);

                    setTimeout(() => {
                        $("#modalCarrito").modal("show");
                    }, 2000);
                }, 200);


            } else {

                jsnData = $('#tblCarrito').bootstrapTable('getRowByUniqueId', nIdRegistro);

                jsnData.nPrecio = parseFloat(nPrecio).toFixed(2);
                jsnData.nCantidad = nCantidad;
                jsnData.nTotal = parseFloat(nTotal).toFixed(2);
                jsnData.sObservacion = sObservacion;
                jsnData.aryExtras = JSON.stringify(aryExtras);
                jsnData.aryValuesExtras = JSON.stringify(aryValuesExtras);

                $('#tblCarrito').bootstrapTable('updateByUniqueId', {
                    nIdRow: jsnData.nIdRow,
                    row: jsnData
                });

                $("#modalVerProducto").modal("hide");
                $("#modalCarrito").modal("show");
            }

            fncCalcularTotales();
        });
    });

    function fncAnimateAgregarProducto(nIdProcuto) {
        var cart = $('#btnTerminarPedidoTop');
        var imgtodrag = $("#cardProducto" + nIdProcuto).find('.img-item');
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                    top: imgtodrag.offset().top,
                    left: imgtodrag.offset().left
                })
                .css({
                    'opacity': '0.8',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
                })
                .appendTo($('body'))
                .animate({
                    'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
                }, 1000, 'easeInOutExpo');

            setTimeout(function() {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function() {
                $(this).detach()
            });
        }
    }

    function fncEditarDetalle(nIdRow) {
        var jsnRow = $("#tblCarrito").bootstrapTable('getRowByUniqueId', nIdRow);

        var objContenedorProducto = $("#cardProducto" + jsnRow.nIdProducto);
        $("#modalVerProducto").data("nIdRegistro", nIdRow);
        $("#sTituloVP").data("nIdProducto", jsnRow.nIdProducto);
        $("#sTituloVP").data("nPrecio", objContenedorProducto.data("precio"));
        $("#sTituloVP").data("sProducto", objContenedorProducto.find(".titulo").html().trim());
        $("#sTituloVP").html(objContenedorProducto.find(".titulo").html().trim());
        $("#sDetalleVP").html(objContenedorProducto.find(".detalle").html().trim());
        $("#sPrecioVP").html(objContenedorProducto.find(".precio").html().trim());
        $("#sImagenVP").attr("src", objContenedorProducto.find(".img-item").attr("src"));

        $("#nCantidad").val(jsnRow.nCantidad).keyup();
        $("#sObservacion").val(jsnRow.sObservacion);

        // Extras 
        var aryExtras = JSON.parse(jsnRow.aryExtras);
        var aryValuesExtras = JSON.parse(jsnRow.aryValuesExtras);

        $(".contentExtras").hide();
        if (aryExtras.length > 0) {
            $(".contentExtras").show();
            fncDrawExtras(aryExtras, "#contenedorFormExtras", aryValuesExtras);
        }

        $("#modalVerProducto").find(".modal-title").html('Editar Producto');
        $("#modalVerProducto").modal("show");
    }

    function fncEliminarDetalle(nIdRow) {
        if (confirm('Advertencia. Esta acción no se puede deshacer. ¿Continuar?')) {
            $("#tblCarrito").bootstrapTable('removeByUniqueId', nIdRow);
            fncCalcularTotales();
        }
    }

    function fncCalcularTotales() {

        var aryData = $('#tblCarrito').bootstrapTable("getData");
        var nTotal = 0;
        if (aryData.length > 0) {
            aryData.forEach(element => {
                nTotal += parseFloat(element.nTotal);
            });
        }

        $("#sTotalPagar").data("nTotal", nTotal);
        $("#sTotalPagar").html("S./ " + parseFloat(nTotal).toFixed(2));
    }
</script>



</html>