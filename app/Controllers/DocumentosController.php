<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Application\Libs\Session;
use Application\Models\Pedidos;
use Application\Models\Clientes;
use Application\Models\Productos;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\Documentos;
use Application\Models\Empleados;
use Application\Models\Empresas;
use Application\Models\Movimientos;
use Application\Models\Sedes;
use Application\Models\SerieNumeros;

class DocumentosController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $catalogotabla;
    public $clientes;
    public $pedidos;
    public $sedes;
    public $empresas;
    public $empleados;
    public $documentos;
    public $seriesNumeros;
    public $movimientos;
    public $productos;

    public $sUrlAnulaciones = "anulaciones";

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogotabla    = new CatalogoTabla();
        $this->clientes         = new Clientes();
        $this->pedidos          = new Pedidos();
        $this->sedes            = new Sedes();
        $this->empresas         = new Empresas();
        $this->empleados        = new Empleados();
        $this->documentos       = new Documentos();
        $this->seriesNumeros    = new SerieNumeros();
        $this->movimientos      = new Movimientos();
        $this->productos        = new Productos();
        $this->session->init();
    }

    public function anulaciones()
    {
        try {
            $this->authAdmin($this->session);

            $user    = $this->session->get('user');
            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/anulaciones', [
                'sTitulo'                    => 'Anulacion de documentos o Comprobantes',
                'user'                       => $user,
                'bShowMenu'                  => true,
                'aryClientes'                => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'aryProductos'               => (new ProductosController())->fncObtenerProductoVentas(),
                'aryTipoDocumento'           => $this->catalogotabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'nIdEstadoPagoPagado'        => $this->fncGetVarConfig("nIdEstadoPagoPagado"),
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->sUrlAnulaciones) ? 1 : 0,
                'aryTipoComprobante'         => $this->catalogotabla->fncListado("TIPO_COMPROBANTE"),
                "arySede"                    => $arySede,
                "nTipoComproFactura"         => $this->fncGetVarConfig("nTipoComproFactura"),
                "nTipoComproBoleta"          => $this->fncGetVarConfig("nTipoComproBoleta"),
                "nTipoComproOrdenCompra"     => $this->fncGetVarConfig("nTipoComproOrdenCompra"),
                "nTipoDocDNI"                => $this->fncGetVarConfig("nTipoDocDNI"),
                "nTipoDocRUC"                => $this->fncGetVarConfig("nTipoDocRUC"),
                "nIdMetodoEnvioRT"           => $this->fncGetVarConfig("nIdMetodoEnvioRT"),
                "nEstadoEnvioEntregado"      => $this->fncGetVarConfig("nEstadoEnvioEntregado"),
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateDocumentosParaAnulaciones()
    {
        try {

            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            $aryData  = $this->documentos->fncObtenerDocumentos([
                "nIdSede"   => $user["nIdSede"],
            ]);

            # $pedidosController = new PedidosController();

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $aryPedido = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $aryLoop["nIdPedido"]]);
                    $aryPedido = fncValidateArray($aryPedido) ? $aryPedido[0] : [];

                    $sNewState         = $aryLoop['nAnulado'] == '1' ? '0' : '1';
                    $sActionState      = 'fncCambiarEstadoAnulacion( ' . "'" . $aryLoop['nIdDocumento'] . "'," . "'" . $aryLoop['nIdPedido'] . "', " . $sNewState . ' )';
                    $sActionEliminar   = 'fncEliminarDOC(' . $aryLoop['nIdDocumento'] . ')';

                    $sIconState     = $aryLoop['nAnulado'] == '1' ? 'power_settings_new' : 'check';
                    $sTitleState    = $aryLoop['nAnulado'] == '1' ? 'Remover anulacion' : 'Anular comprobante';

                    $sActionEditarDoc  = "fncMostrarDocPedido(" . $aryPedido['nIdDocumento'] . " , '" . sp($aryPedido['sNumero']) . "' , 'editar' );";
                    $sActionVerDoc     = "fncMostrarDocPedido(" . $aryPedido['nIdDocumento'] . " , '" . sp($aryPedido['sNumero']) . "' , 'ver' );";

                    $sLinkPDF         = '<a target="_blank" href="' . route('pedidos/fncPedidoPdf/' . $aryLoop['nIdPedido']) . '"   title="Visualizar PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';
                    $sLinkEdit        = $bIsAdmin ? '<a onclick="' . $sActionEditarDoc . '" href="javascript:;"  title="Editar comprobante" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete      = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar Comprobante" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';
                    $sLinkChangeState = $bIsAdmin ? '<a href="javascript:;" onclick="' . $sActionState . '" class="text-primary" data-toggle="tooltip" data-placement="bottom" title="' . $sTitleState . '"><i class="material-icons">' . $sIconState . '</i></a></a>' : '';
                    $sLinkVerFact     = $aryPedido["nFacturado"] == 1 ? '<a onclick="' . $sActionVerDoc . '" href="javascript:;"   title="Ver" class="text-white"><i class="material-icons">remove_red_eye</i> </a>'  : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkPDF . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkChangeState . '
                                    ' . $sLinkDelete . '
                                </div>';

                    # $aryDataTotales =  $pedidosController->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);

                    $aryDataDetalles = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop['nIdPedido']]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {
                            $nTotalCantidad += $aryDet["nCantidad"];
                            $sDetalle       .= $aryDet["sProducto"] . " |  " . $aryDet["nPrecio"] . " x " . $aryDet["nCantidad"] . "<br>";
                        }
                    }

                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                    $aryRows[] = [
                        "sAcciones"        => $sAcciones,
                        "nIdDocumento"     => sp($aryLoop["nIdDocumento"]),
                        "nIdPedido"        => sp($aryPedido["nIdPedido"]),
                        "sNumero"          => sp($aryPedido["sNumero"]),
                        "sCliente"         => strup($aryPedido["sCliente"]),
                        "sResponsable"     => strup($aryPedido["sResponsable"]),
                        "dFechaCreacion"   => $aryPedido["dFechaCreacion"],
                        "sFacturado"       => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryPedido["nFacturado"] == 1 ? '<div class="div-verde">FACTURADO ' . $sLinkVerFact . '</div>' : '<div class="div-rojo">SIN FACTURAR</div>'),
                        "sDetalle"         => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                        
                        "nSubtotal"        => nf($aryPedido["nSubTotal"],true),
                        "nIgv"             => nf($aryPedido["nIgv"],true),
                        "nTotal"           => nf($aryPedido["nTotal"],true),
                        
                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sDespachado"      => $aryPedido["nDespachado"] == 1 ? "DESPACHADO" : "SIN DESPACHAR",

                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncAnularDocumentoPedido()
    {
        try {
            $nIdRegistro   = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdPedido     = isset($_POST['nIdPedido']) ? $_POST['nIdPedido'] : null;
            $nEstado       = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nIdPedido) || is_null($nEstado)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            // Anular
            $movimientosController = new MovimientosController();

            if ($nEstado  == 1) {

                // Quitamos el flag de facturado a el pedido
                $this->pedidos->fncActualizarFacturado($nIdPedido, 0);
                $this->pedidos->fncActualizarDespachado($nIdPedido, 0);
                $this->documentos->fncActualizarEstado($nIdRegistro, 0);
                $this->documentos->fncActualizarAnulado($nIdRegistro, 1);

                $aryData = $this->movimientos->fncGetMovimientos(["nIdDocumento" => $nIdRegistro]);

                if (fncValidateArray($aryData)) {
                    foreach ($aryData as $key => $aryLoop) {
                        // Desactivamos todos los movimientos y sus detalle
                        $this->movimientos->fncActualizarEstado($aryLoop["nIdMovimiento"], 0);
                        $this->movimientos->fncActualizarEstadoDetalleByIdMov($aryLoop["nIdMovimiento"], 0);

                        $aryDetalle =  $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimiento"]]);
                        if (fncValidateArray($aryDetalle)) {
                            foreach ($aryDetalle as $aryLoopDet) {
                                $movimientosController->fncActualizarStockActual($aryLoopDet["nIdProducto"]);
                            }
                        }
                    }
                }
            } else {

                // Quitar anulacion
                // Restablecer el flag de facturado a el pedido

                $aryDataDet = $this->movimientos->fncGetMovimientosDetalle(["nIdDocumento" => $nIdRegistro]);

                // var_dump($aryDataDet);
                // exit;

                if (fncValidateArray($aryDataDet)) {
                    foreach ($aryDataDet as $nKey => $aryData) {
                        // Vender con stock activo
                        $aryProducto = $this->productos->fncGetProductos(["nIdProducto" => $aryData["nIdProducto"]]);

                        if (fncValidateArray($aryProducto)) {
                            $aryProducto = $aryProducto[0];

                            // Verificar si tiene descompocision el producto
                            $aryDescomp = $this->productos->fncGetProductosDescompDet(["nIdProductoHijo" => $aryProducto["nIdProducto"]]);
                            if (fncValidateArray($aryDescomp)) {

                                // Si es un producto de descompocision

                                $aryDescomp  = $aryDescomp[0];

                                $aryProductoPadre = $this->productos->fncGetProductos(["nIdProducto" =>  $aryDescomp["nIdProductoPadre"]])[0];
                                $nDiferencia      = $aryProductoPadre["nStockActual"] - ($aryData["nCantidad"] * $aryDescomp["nDescomp"]);

                                if ($nDiferencia < 0) {
                                    $this->exception("Error . No se puede abastecer el producto " . strup($aryProducto["sDescripcion"]) . " . Stock Actual : " . $aryProductoPadre["nStockActual"] .  " - Cantidad Requerida : " .  ($aryData["nCantidad"] * $aryDescomp["nDescomp"]) . " . Porfavor verifique");
                                    break;
                                }
                            } else {
                                if ($aryProducto["nVenderStock"] == 1) {
                                    $nDiferencia = $aryProducto["nStockActual"] - $aryData["nCantidad"];

                                    if ($nDiferencia < 0) {
                                        $this->exception("Error . No se puede abastecer el producto " . strup($aryProducto["sDescripcion"]) . " . Stock Actual : " . $aryProducto["nStockActual"] .  " - Cantidad Requerida : " . $aryData["nCantidad"] . " . Porfavor verifique");
                                        break;
                                    }
                                }
                            }
                        } else {
                            $this->exception("Error.No se encontro el producto quizas se haya eliminado o no exista.Porfavor verifique");
                            break;
                        }
                    }
                }


                // Actualizamos el pedidocono facturado el flag

                $this->pedidos->fncActualizarFacturado($nIdPedido, 1);
                $this->pedidos->fncActualizarDespachado($nIdPedido, 1);

                // Quitamos el flag de anulado para el documento y el estado lo activamos
                $this->documentos->fncActualizarAnulado($nIdRegistro, 0);
                $this->documentos->fncActualizarEstado($nIdRegistro, 1);

                $aryData = $this->movimientos->fncGetMovimientos(["nIdDocumento" => $nIdRegistro]);

                // Activamos la cabecera y los detalles del movimiento
                if (fncValidateArray($aryData)) {
                    foreach ($aryData as $key => $aryLoop) {
                        $this->movimientos->fncActualizarEstado($aryLoop["nIdMovimiento"], 1);
                        $this->movimientos->fncActualizarEstadoDetalleByIdMov($aryLoop["nIdMovimiento"], 1);

                        $aryDetalle =  $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimiento"]]);
                        if (fncValidateArray($aryDetalle)) {
                            foreach ($aryDetalle as $aryLoopDet) {
                                $movimientosController->fncActualizarStockActual($aryLoopDet["nIdProducto"]);
                            }
                        }
                    }
                }
            }

            $sSuccess = $nEstado == 1 ? 'Se anulo el documento correctamente' : 'Se quito la anulacion correctamente';
            $this->json(array("success" =>  $sSuccess));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncGrabarDocumento()
    {
        try {
            $nIdRegistro                    = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nTipoComprobante               = isset($_POST['nTipoComprobante']) ? $_POST['nTipoComprobante'] : null;
            $sTipoComprobante               = isset($_POST['sTipoComprobante']) ? $_POST['sTipoComprobante'] : null;
            $nTipoDocumento                 = isset($_POST['nTipoDocumento']) ? $_POST['nTipoDocumento'] : null;
            $sNumeroDocumento               = isset($_POST['sNumeroDocumento']) ? $_POST['sNumeroDocumento'] : null;
            $sNombreoRazonSocial            = isset($_POST['sNombreoRazonSocial']) ? $_POST['sNombreoRazonSocial'] : null;
            $nIdPedido                      = isset($_POST['nIdPedido']) ? $_POST['nIdPedido'] : null;
            $dFechaEmision                  = isset($_POST['dFechaEmision']) ? $_POST['dFechaEmision'] : null;
            $sCorreo                        = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : null;
            $nAnulado                       = isset($_POST['nAnulado']) ? $_POST['nAnulado'] : null;
            $nEstado                        = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nIdPedido) || is_null($nTipoComprobante)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdFacturaNew = null;

            $nIdEmpleado        = $user["nIdRol"] == $this->fncGetVarConfig("nIdRolAdmin") ? null : $user["nIdEmpleado"];
            $aryDataSerieNumero = $this->seriesNumeros->fncGetSerieNumerosByNomSerie($sTipoComprobante, $user["nIdEmpresa"], $user["nIdSede"]);

            if (!fncValidateArray($aryDataSerieNumero)) {
                $this->exception('Error. No se encontro una serie y numero para el documento ' . $sTipoComprobante . '. Por favor verifique.');
            }


            // var_dump($aryDataSerieNumero);
            // exit;
            $movimientosController = new MovimientosController();
            $pedidosController     = new PedidosController();
            $canjePuntosController = new CanjePuntosController();

            // Crear
            if ($nIdRegistro == 0) {

                # Graba la factura 

                $nIdFacturaNew = $this->documentos->fncGrabarDocumento(
                    $nTipoComprobante,
                    $aryDataSerieNumero["sPrefijo"],
                    sp($aryDataSerieNumero["sValor"]),
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombreoRazonSocial,
                    $nIdPedido,
                    $dFechaEmision,
                    $nIdEmpleado,
                    $sCorreo,
                    $nAnulado,
                    $nEstado
                );

                # Obtiene el pedido

                $aryPedido = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdPedido])[0];

                # Obtiene el detalle del pedido 

                $aryDetallePedido = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $nIdPedido]);

                // Solo si falta despachar se despacha es decir se descuenta del stock
                if ($aryPedido["nDespachado"] == 0) {

                    # Valida el stock
                    if (fncValidateArray($aryDetallePedido)) {
                        foreach ($aryDetallePedido as $nKey => $aryData) {

                            // Vender con stock activo
                            $aryProducto = $this->productos->fncGetProductos(["nIdProducto" => $aryData["nIdProducto"]]);

                            if (fncValidateArray($aryProducto)) {
                                $aryProducto = $aryProducto[0];
                                // Verificar si tiene descompocision el producto

                                $aryDescomp = $this->productos->fncGetProductosDescompDet(["nIdProductoHijo" => $aryProducto["nIdProducto"]]);
                                if (fncValidateArray($aryDescomp)) {

                                    // Si es un producto de descompocision

                                    $aryDescomp  = $aryDescomp[0];

                                    $aryProductoPadre = $this->productos->fncGetProductos(["nIdProducto" =>  $aryDescomp["nIdProductoPadre"]])[0];
                                    $nDiferencia      = $aryProductoPadre["nStockActual"] - ($aryData["nCantidad"] * $aryDescomp["nDescomp"]);

                                    if ($nDiferencia < 0) {
                                        $this->exception("Error . No se puede abastecer el producto " . strup($aryProducto["sDescripcion"]) . " . Stock Actual : " . $aryProductoPadre["nStockActual"] .  " - Cantidad Requerida : " .  ($aryData["nCantidad"] * $aryDescomp["nDescomp"]) . " . Porfavor verifique");
                                        break;
                                    }
                                } else {
                                    if ($aryProducto["nVenderStock"] == 1) {
                                        $nDiferencia = $aryProducto["nStockActual"] - $aryData["nCantidad"];

                                        if ($nDiferencia < 0) {
                                            $this->exception("Error . No se puede abastecer el producto " . strup($aryProducto["sDescripcion"]) . " . Stock Actual : " . $aryProducto["nStockActual"] .  " - Cantidad Requerida : " . $aryData["nCantidad"] . " . Porfavor verifique");
                                            break;
                                        }
                                    }
                                }
                            } else {
                                $this->exception("Error.No se encontro el producto quizas se  haya eliminado o no exista.Porfavor verifique");
                                break;
                            }
                        }
                    }

                    $nSalida = $this->fncGetVarConfig("nSalida");

                    $nIdResponsable = $user["nIdRol"] == $this->fncGetVarConfig("nIdRolAdmin") ? $user["nIdUsuario"] : $user["nIdEmpleado"];

                    $nIdMovimientoNew =  $this->movimientos->fncGrabarMovimiento(
                        $user["nIdEmpresa"],
                        $user["nIdSede"],
                        null,
                        $nIdResponsable,
                        "Facturacion del pedido" . $nIdPedido,
                        $nSalida,
                        null,
                        $nIdFacturaNew,
                        null,
                        $aryPedido["nTipoMoneda"],
                        1,
                        $nEstado
                    );

                    if (fncValidateArray($aryDetallePedido)) {
                        foreach ($aryDetallePedido as $aryLoop) {
                            $aryDescomp = $this->productos->fncGetProductosDescompDet(["nIdProductoHijo" => $aryLoop["nIdProducto"]]);

                            if (fncValidateArray($aryDescomp)) {

                                // Si es un producto de descompocision

                                $aryDescomp  = $aryDescomp[0];

                                $aryProductoPadre = $this->productos->fncGetProductos(["nIdProducto" =>  $aryDescomp["nIdProductoPadre"]])[0];
                                $nCantidadPadre   = ($aryLoop["nCantidad"] * $aryDescomp["nDescomp"]);

                                $this->movimientos->fncGrabarMovimientoDetalle(
                                    $nIdMovimientoNew,
                                    $aryDescomp["nIdProductoPadre"],
                                    $nCantidadPadre,
                                    $aryLoop["nPrecio"],
                                    0,
                                    0,
                                    $nEstado
                                );

                                $movimientosController->fncActualizarStockActual($aryDescomp["nIdProductoPadre"]);
                            } else {
                                $this->movimientos->fncGrabarMovimientoDetalle(
                                    $nIdMovimientoNew,
                                    $aryLoop["nIdProducto"],
                                    $aryLoop["nCantidad"],
                                    $aryLoop["nPrecio"],
                                    0,
                                    0,
                                    $nEstado
                                );
                                $movimientosController->fncActualizarStockActual($aryLoop["nIdProducto"]);
                            }
                        }
                    }


                    # Actualizamos el flag de desapachado del pedido
                    $this->pedidos->fncActualizarDespachado($nIdPedido, 1);

                    # Actualizamos el movimiento que se hizo para el descuento de stock
                    $this->pedidos->fncActualizarMovimiento($nIdPedido, $nIdMovimientoNew);

                    # Obtener flag para verificar si el cliente puede acumular puntos o no 
                    $aryCliente = $this->clientes->fncObtenerFlagAcumulaPuntos($aryPedido["nIdCliente"])[0];

                    if ($aryCliente["nAcumulaPuntos"] == '1') {

                        # Restar puntos que ha canjeado el cliente
                        $this->clientes->fncRestarPuntos($aryPedido["nIdCliente"], $aryPedido["nPuntosCanje"]);

                        # Actualiza los puntos de canje
                        # Suma el total de productos que acumulan puntos y los actualiza
                        $aryDataCP = $canjePuntosController->fncCanjearPuntosByPedido($nIdPedido);

                        if ($aryDataCP["success"]) {
                            $this->pedidos->fncActualizarPuntosAcumulados($nIdPedido, $aryDataCP["nPuntos"]);
                        }
                    }
                    
                } else {

                    # Si ya se realizo el movimiento  del stock entonces actualizamos la factura o boleta en el movimiento ya creado 
                    $this->movimientos->fncActualizarDocumento(
                        $aryPedido["nIdMovimiento"],
                        $nIdFacturaNew
                    );
                }


                # Actualizar el pedido a pagado 
                $nIdEstadoPagoPagado = $this->fncGetVarConfig("nIdEstadoPagoPagado");
                $this->pedidos->fncActualizarEstadoPago($nIdPedido , $nIdEstadoPagoPagado);
                


            } else {

                //Actualizar
                $this->documentos->fncActualizarDocumento(
                    $nIdRegistro,
                    $nTipoComprobante,
                    $aryDataSerieNumero["sPrefijo"],
                    sp($aryDataSerieNumero["sValor"]),
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombreoRazonSocial,
                    $nIdPedido,
                    $dFechaEmision,
                    $nIdEmpleado,
                    $sCorreo,
                    $nAnulado,
                    $nEstado
                );
            }

            $this->pedidos->fncActualizarFacturado($nIdPedido, 1);

            $sSuccess =  $nIdRegistro == 0 ? 'Factura registrado exitosamente...' : 'Factura actualizado exitosamente...';
            $this->seriesNumeros->fncActualizarValorSerieByNomSerie($user["nIdSede"], sp($aryDataSerieNumero["sValor"]), $sTipoComprobante);
            $this->json(array("success" => $sSuccess, "nIdFacturaNew" => $nIdFacturaNew));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarRegistro()
    {
        $nIdRegistro  = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $nIdPedido    = isset($_POST['nIdPedido']) ? $_POST['nIdPedido'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData  = $this->documentos->fncObtenerDocumentos(["nIdDocumento" => $nIdRegistro, "nIdPedido" => $nIdPedido]);

            $this->json(array(
                "success"    => true,
                "aryData"   => fncValidateArray($aryData) ? $aryData[0] : null,
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarRegistro()
    {
        // Recibe valores del formulario
        $nIdRegistro         = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $nFlagEliminarPedido = isset($_POST['nFlagEliminarPedido']) ? $_POST['nFlagEliminarPedido'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryDetalle  = [];

            $movimientosController = new MovimientosController();

            $aryData = $this->movimientos->fncGetMovimientos(["nIdDocumento" => $nIdRegistro]);

            // var_dump($aryData);
            // exit;

            $aryDocumento  = [];

            if (fncValidateArray($aryData)) {
                $aryData        = $aryData[0];
                $aryDocumento   = $this->documentos->fncObtenerDocumentos(["nIdDocumento" => $aryData["nIdDocumento"]]);
                $aryDocumento   = $aryDocumento[0];
                $aryDetalle     = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryData["nIdMovimiento"]]);
                $this->pedidos->fncActualizarFacturado($aryDocumento["nIdPedido"], 0);
                $this->movimientos->fncEliminarMovimiento($aryData["nIdMovimiento"]);
            }

            $this->documentos->fncEliminarRegistro($nIdRegistro);

            if (fncValidateArray($aryData)) {
                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $aryLoopDet) {
                        $movimientosController->fncActualizarStockActual($aryLoopDet["nIdProducto"]);
                    }
                }
            }

            $sMensaje = "Documento y movimientos eliminados exitosamente.";

            if ($nFlagEliminarPedido == 1) {
                if (fncValidateArray($aryDocumento)) {
                    $sMensaje = "Documento y movimientos y pedido eliminados exitosamente. ";
                    $this->pedidos->fncEliminarPedido($aryDocumento["nIdPedido"]);
                }
            }

            $this->json(array("success" => $sMensaje));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
