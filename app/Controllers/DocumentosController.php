<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Application\Libs\Mail;
use Application\Libs\Session;
use Application\Models\Sedes;
use Application\Models\Pedidos;
use Application\Models\Clientes;
use Application\Models\Empresas;
use Application\Models\Empleados;
use Application\Models\Productos;
use Application\Models\Documentos;
use Application\Models\Movimientos;
use Application\Models\SerieNumeros;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;

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

    private $sTextFactura = "FACTURA";
    private $sTextBoleta = "BOLETA";

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

    public function documentos()
    {
        try {
            $this->authAdmin($this->session);

            $user    = $this->session->get('user');
            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/documentos-electronicos', [
                'sTitulo'                    => 'Comprobantes Electronicos',
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
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulate()
    {
        try {

            $nIdTipoComprobante = isset($_POST['nIdTipoComprobante']) ? $_POST['nIdTipoComprobante'] : null;
            $dFechaInicio       = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin          = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
            $sEstatusXML        = isset($_POST['sEstatusXML']) ? $_POST['sEstatusXML'] : null;


            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }



            $aryData  = $this->documentos->fncObtenerDocumentos([
                "nIdTipoComprobante"    => $nIdTipoComprobante,
                "dFechaInicio"          => $dFechaInicio,
                "dFechaFin"             => $dFechaFin,
                "nEstado"               => $nEstado,
                "sEstatusXML"           => $sEstatusXML,
                "nIdSede"               => $user["nIdSede"],
            ]);

            # $pedidosController = new PedidosController();

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    /*
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

                 */

                    # Anulacion documento
                    $sNewState           = $aryLoop['nAnulado'] == '1' ? '0' : '1';
                    $sActionState        = $aryLoop['nAnulado'] == '0' ? 'fncCambiarEstadoAnulacion( ' . "'" . $aryLoop['nIdDocumento'] . "'," . "'" . $aryLoop['nIdPedido'] . "', " . $sNewState . ' )' : '';
                    $sIconState          = $aryLoop['nAnulado'] == '0' ? 'power_settings_new' : 'block';
                    $sTitleState         = $aryLoop['nAnulado'] == '0' ? 'Anular Comprobante' : 'El comprobante ya fue anulado.';
                    $sLinkState          = '<a href="javascript:;" onclick="' . $sActionState . '" class="text-primary" data-toggle="tooltip" data-placement="bottom" title="' . $sTitleState . '"><i class="material-icons">' . $sIconState . '</i></a>';


                    # Editar o ver documento
                    $sActionEditarDoc  = "fncMostrarDocPedido(" . $aryLoop['nIdDocumento'] . " , '" . sp($aryLoop['sNumeroPedido']) . "' , 'editar' );";
                    $sActionVerDoc     = "fncMostrarDocPedido(" . $aryLoop['nIdDocumento'] . " , '" . sp($aryLoop['sNumeroPedido']) . "' , 'ver' );";

                    #$sLinkEdit         = $bIsAdmin ? '<a onclick="' . $sActionEditarDoc . '" href="javascript:;"  title="Editar comprobante" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkVerFact      = $aryLoop["nFacturadoPedido"] == 1 ? '<a onclick="' . $sActionVerDoc . '" href="javascript:;"   title="Ver" class="text-white"><i class="material-icons">remove_red_eye</i> </a>'  : '';

                    # Link PDF Pedido
                    $sLinkPDF       = '<a target="_blank" href="' . route('pedidos/fncPedidoPdf/' . $aryLoop['nIdPedido']) . '"  title="Visualizar PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';


                    # link enviar a SUNAT 
                    $sActionEnviarSUNAT  = $aryLoop["statusXML"] == "SIGNED" || $aryLoop["statusXML"] == "REFUSED" ? "" : "fncEnviarSUNAT(" . $aryLoop['nIdDocumento'] . ");";
                    $sIconES             = $aryLoop["statusXML"] == "SIGNED" || $aryLoop["statusXML"] == "REFUSED" ? "block" : "cloud_upload";
                    $sTitleES            = $aryLoop["statusXML"] == "SIGNED" || $aryLoop["statusXML"] == "REFUSED" ? "Opcion no disponible" : "Enviar a comprobante a SUNAT";
                    $sLinkES             = '<a onclick="' . $sActionEnviarSUNAT . '" href="javascript:;" title="' . $sTitleES . '" class="text-primary" style="color:#ad0c41 !important;"><i class="material-icons">' . $sIconES . '</i></a>';


                    # link NubeFact 
                    $sLinkNB                = !empty($aryLoop['enlace']) ? '<a target="_blank" href="' . $aryLoop['enlace'] . '" title="Ir al link de NubeFact" class="text-primary"><i class="material-icons">link</i> </a>' : '';

                    $sActionEnviarCustom     = trim($aryLoop["enlace"]) == "" ? "" : "fncEnviarCorreoCustomizado(" . $aryLoop['nIdDocumento'] . ");";
                    $sIconReenviarCustom     = trim($aryLoop["enlace"]) == "" ? "block" : "email";
                    $sLinkCorreoCustom       = '<a onclick="' . $sActionEnviarCustom . '" href="javascript:;"  title="Enviar correo customizado" class="text-info"><i class="material-icons">' . $sIconReenviarCustom . '</i> </a>';

                    # Las acciones solo de sunat solo estaran disponiles para boletas y facturas 
                    if ($aryLoop["sTipoComprobante"]  == "BOLETA" || $aryLoop["sTipoComprobante"]  == "FACTURA") {

                        $sAcciones =
                            '<div class="content-acciones">
                            ' . $sLinkPDF . '
                            ' . $sLinkNB . '
                            ' . $sLinkES . '
                            ' . $sLinkCorreoCustom . '
                            ' . $sLinkState . '
                          </div>';
                    } else {

                        # En caso de tickets no tendran la opcion de enviar a sunar solo a Anular.
                        $sAcciones =
                            '<div class="content-acciones">
                                ' . $sLinkPDF . '
                                ' . $sLinkCorreoCustom . '
                                ' . $sLinkState . '
                        </div>';
                    }



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

                        "nIdPedido"        => sp($aryLoop["nIdPedido"]),
                        "sNumero"          => sp($aryLoop["sNumeroPedido"]),
                        "sCliente"         => strup($aryLoop["sCliente"]),
                        "sResponsable"     => strup($aryLoop["sResponsable"]),

                        "dFechaCreacion"   => $aryLoop["dFechaCreacion"],

                        "sFacturado"       => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryLoop["nFacturadoPedido"] == 1 ? '<div class="div-verde">FACTURADO ' . $sLinkVerFact . '</div>' : '<div class="div-rojo">SIN FACTURAR</div>'),
                        "sDetalle"         => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",

                        "nSubtotal"        => nf($aryLoop["nSubTotalPedido"], true),
                        "nIgv"             => nf($aryLoop["nIgvPedido"], true),
                        "nTotal"           => nf($aryLoop["nTotalPedido"], true),

                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sDespachado"      => $aryLoop["nDespachadoPedido"] == 1 ? "DESPACHADO" : "SIN DESPACHAR",

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

            # Obtiene los datos del documento
            $aryDocumento = $this->documentos->fncObtenerDocumentos(["nIdDocumento" => $nIdRegistro]);
            $aryDocumento = $aryDocumento[0];

            // Anular
            $movimientosController = new MovimientosController();

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

            # Si el documento tiene statusXML entonces anulamos el documento en sunat
            if (!empty($aryDocumento["statusXML"])) {
                $this->fncAnularDocumentoSunat($aryDocumento["nIdDocumento"]);
            }

            $sSuccess = 'Se anulo el documento correctamente';
            $this->json(array("success" =>  $sSuccess));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }




    /*
    public function fncQuitarAnulacionDocumentoPedido()
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
    */

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
                $this->pedidos->fncActualizarEstadoPago($nIdPedido, $nIdEstadoPagoPagado);
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

    public function fncProcesarEnvio($nIdRegistro)
    {

        $aryDocumentos  = $this->documentos->fncObtenerDocumentos(["nIdDocumento" => $nIdRegistro]);

        if (!fncValidateArray($aryDocumentos)) {
            $this->exception("Error. No se encontro datos sobre el documento se haya eliminado o no exista. Porfavor verifique.");
        }
        $aryDocumento = $aryDocumentos[0];

        # Obtener datos de la empresa y sede
        $aryEmpresa = $this->empresas->fncGetEmpresas(["nIdEmpresa" => $aryDocumento["nIdEmpresa"]]);
        if (!fncValidateArray($aryEmpresa)) {
            $this->exception("Error. No se encontro datos sobre la empresa se haya eliminado o no exista. Porfavor verifique.");
        }
        $aryEmpresa = $aryEmpresa[0];

        # Obtener la sede
        $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryDocumento["nIdSede"]]);
        if (!fncValidateArray($arySede)) {
            $this->exception("Error. No se encontro datos sobre la sede se haya eliminado o no exista. Porfavor verifique.");
        }
        $arySede = $arySede[0];

        # Obtener datos del pedido
        $aryPedido = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $aryDocumento["nIdPedido"]]);
        if (!fncValidateArray($aryPedido)) {
            $this->exception("Error. No se encontro datos sobre el pedido se haya eliminado o no exista. Porfavor verifique.");
        }
        $aryPedido = $aryPedido[0];

        # Obtener el detalle del pedido 
        $aryPedidoDetalle = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryDocumento["nIdPedido"]]);
        if (!fncValidateArray($aryPedidoDetalle)) {
            $this->exception("Error. No se encontro datos sobre el detalle del pedido se haya eliminado o no exista. Porfavor verifique.");
        }

        # validar la ruta y token de la sede para produccion o beta
        if ($arySede["nProduccionSUNAT"] == 1) {
            $ruta = $arySede["sRutaProdSUNAT"];
            $token = $arySede["sTokenProdSUNAT"];
        } else {
            $ruta = $arySede["sRutaBetaSUNAT"];
            $token = $arySede["sTokenBetaSUNAT"];
        }
        if (empty($ruta) || empty($token)) {
            $this->exception("Error. No se encontro datos sobre la ruta o token de la sede se haya eliminado o no exista. Porfavor verifique.");
        }


        $items = [];

        foreach ($aryPedidoDetalle  as $key => $aryLoop) {
            $subtotal = $aryLoop["nPrecio"] * $aryLoop["nCantidad"];
            $igvitem = ($subtotal * ($aryPedido["nPorcentajeIGV"] / 100));

            $total_item = $subtotal + $igvitem;
            // var_dump($subtotal,$igvitem,$total_item);
            // var_dump($subtotal,round($igvitem,2),round($total_item,2));


            $items[] =  array(
                "unidad_de_medida"          => "NIU",
                "codigo"                    => ($key + 1),
                "descripcion"               => $aryLoop["sProducto"],
                "cantidad"                  => $aryLoop["nCantidad"],
                "valor_unitario"            => $aryLoop["nPrecio"],
                "precio_unitario"           => round(($aryLoop["nPrecio"] * (1 + ($aryPedido["nPorcentajeIGV"] / 100))), 2),
                "descuento"                 => "",
                "subtotal"                  => round($subtotal, 2),
                "tipo_de_igv"               => "1",
                "igv"                       => round($igvitem, 2),
                "total"                     => round($total_item, 2),
                "anticipo_regularizacion"   => "false",
                "anticipo_documento_serie"  => "",
                "anticipo_documento_numero" => ""
            );
        }

        $tipo_comprobante = "";

        if ($aryDocumento["sTipoComprobante"] ==  $this->sTextFactura) {
            $tipo_comprobante = "1";
        } else if ($aryDocumento["sTipoComprobante"] ==  $this->sTextBoleta) {
            $tipo_comprobante = "2";
        }

        if ($tipo_comprobante == "") {
            $this->exception("Error, no se especifico el tipo de comprobante. Contacte con soporte");
        }

        $data = array(
            "operacion"                         => "generar_comprobante",
            "tipo_de_comprobante"               => $tipo_comprobante,
            "serie"                             => $aryDocumento["sSerieDocumentoComprobante"],
            "numero"                            =>  intval($aryDocumento["sNumeroDocumentoComprobante"]),
            "sunat_transaction"                 => "1",
            "cliente_tipo_de_documento"         => $aryPedido["sCodigoDocumentoCliente"],
            "cliente_numero_de_documento"       => $aryPedido["sNumeroDocumentoCliente"],
            "cliente_denominacion"              => $aryPedido["sCliente"],
            "cliente_direccion"                 => $aryPedido["sDireccionCliente"],
            "cliente_email"                     => "",
            "cliente_email_1"                   => "",
            "cliente_email_2"                   => "",
            "fecha_de_emision"                  => date('d-m-Y'),
            "fecha_de_vencimiento"              => "",
            "moneda"                            => "1",
            "tipo_de_cambio"                    => "",
            "porcentaje_de_igv"                 => $aryPedido["nPorcentajeIGV"],
            "descuento_global"                  => "",
            "total_descuento"                   => "",
            "total_anticipo"                    => "",
            "total_gravada"                     => $aryPedido["nSubTotal"],
            "total_inafecta"                    => "",
            "total_exonerada"                   => "",
            "total_igv"                         => $aryPedido["nIgv"],
            "total_gratuita"                    => "",
            "total_otros_cargos"                => "",
            "total"                             => $aryPedido["nTotal"],
            "percepcion_tipo"                   => "",
            "percepcion_base_imponible"         => "",
            "total_percepcion"                  => "",
            "total_incluido_percepcion"         => "",
            "detraccion"                        => "false",
            "observaciones"                     => "",
            "documento_que_se_modifica_tipo"    => "",
            "documento_que_se_modifica_serie"   => "",
            "documento_que_se_modifica_numero"  => "",
            "tipo_de_nota_de_credito"           => "",
            "tipo_de_nota_de_debito"            => "",
            "enviar_automaticamente_a_la_sunat" => "true",
            "enviar_automaticamente_al_cliente" => "false",
            "codigo_unico"                      => "",
            "condiciones_de_pago"               => "",
            "medio_de_pago"                     => "",
            "placa_vehiculo"                    => "",
            "orden_compra_servicio"             => "",
            "tabla_personalizada_codigo"        => "",
            "formato_de_pdf"                    => "",
            "items"                             => $items
        );

        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization: Token token="' . $token . '"',
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        /*
        #########################################################
        #### PASO 4: LEER RESPUESTA DE NUBEFACT ####
        +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        # Recibirás una respuesta de NUBEFACT inmediatamente lo cual se debe leer, verificando que no haya errores.
        # Debes guardar en la base de datos la respuesta que te devolveremos.
        # Escríbenos a soporte@nubefact.com o llámanos al teléfono: 01 468 3535 (opción 2) o celular (WhatsApp) 955 598762
        # Puedes imprimir el PDF que nosotros generamos como también generar tu propia representación impresa previa coordinación con nosotros.
        # La impresión del documento seguirá haciéndose desde tu sistema. Enviaremos el documento por email a tu cliente si así lo indicas en el archivo JSON o TXT.
        +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        */

        $leer_respuesta = json_decode($respuesta, true);
        if (isset($leer_respuesta['errors'])) {
            //Mostramos los errores si los hay
            # Guardar en NBF
            $this->documentos->fncActualizarErrorNBFACT($aryDocumento["nIdDocumento"], $leer_respuesta['errors']);
            $this->exception("Error " . $leer_respuesta['errors']);
        }


        $statusXML = strlen($leer_respuesta["enlace"]) > 0 ? "SIGNED" : "REFUSED";

        $this->documentos->fncActualizarDatosCPE2(
            $aryDocumento["nIdDocumento"],
            $statusXML,
            $leer_respuesta["enlace"],
            $leer_respuesta["aceptada_por_sunat"],
            $leer_respuesta["sunat_description"],
            $leer_respuesta["sunat_note"],
            $leer_respuesta["sunat_responsecode"],
            $leer_respuesta["cadena_para_codigo_qr"],
            $leer_respuesta["codigo_hash"]
        );

        return $aryDocumento["sSerieDocumentoComprobante"] . "-" . $aryDocumento["sNumeroDocumentoComprobante"];
    }

    public function fncAnularDocumentoSunat($nIdDocumento)
    {


        # Valida valores del formulario
        if (is_null($nIdDocumento)) {
            $this->exception('Error. El id del documento es incorrecto. Por favor verificar.');
        }

        # Obtiene los datos del documento
        $aryDocumento = $this->documentos->fncObtenerDocumentos(["nIdDocumento" => $nIdDocumento]);
        $aryDocumento = $aryDocumento[0];


        # obtener datos de la sede y validar la ruta y token
        $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryDocumento["nIdSede"]]);
        $arySede = $arySede[0];

        # validar la ruta y token de la sede para produccion o beta
        if ($arySede["nProduccionSUNAT"] == 1) {
            $ruta = $arySede["sRutaProdSUNAT"];
            $token = $arySede["sTokenProdSUNAT"];
        } else {
            $ruta = $arySede["sRutaBetaSUNAT"];
            $token = $arySede["sTokenBetaSUNAT"];
        }
        if (empty($ruta) || empty($token)) {
            $this->exception("Error. No se encontro datos sobre la ruta o token de la sede se haya eliminado o no exista. Porfavor verifique.");
        }


        $tipo_comprobante = "";

        if ($aryDocumento["sTipoComprobante"] == $this->sTextFactura) {
            $tipo_comprobante = "1";
        } else if ($aryDocumento["sTipoComprobante"] == $this->sTextBoleta) {
            $tipo_comprobante = "2";
        }

        $data = array(
            "operacion"            => "generar_anulacion",
            "tipo_de_comprobante"  => $tipo_comprobante,
            "serie"                => $aryDocumento["sSerieDocumentoComprobante"],
            "numero"               => intval($aryDocumento["sNumeroDocumentoComprobante"]),
            "motivo"               => "ERROR DEL SISTEMA",
            "codigo_unico"         => ""
        );

        // var_dump($data);
        // exit;
        $data_json = json_encode($data);

        // echo ($data_json);
        // exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization: Token token="' . $token . '"',
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        /*
        #########################################################
        #### PASO 4: LEER RESPUESTA DE NUBEFACT ####
        +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        # Recibirás una respuesta de NUBEFACT inmediatamente lo cual se debe leer, verificando que no haya errores.
        # Debes guardar en la base de datos la respuesta que te devolveremos.
        # Escríbenos a soporte@nubefact.com o llámanos al teléfono: 01 468 3535 (opción 2) o celular (WhatsApp) 955 598762
        # Puedes imprimir el PDF que nosotros generamos como también generar tu propia representación impresa previa coordinación con nosotros.
        # La impresión del documento seguirá haciéndose desde tu sistema. Enviaremos el documento por email a tu cliente si así lo indicas en el archivo JSON o TXT.
        +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        */

        $leer_respuesta = json_decode($respuesta, true);
        if (isset($leer_respuesta['errors'])) {
            //Mostramos los errores si los hay
            # Guardar en NBF
            $this->documentos->fncActualizarErrorNBFACT($aryDocumento["nIdDocumento"], $leer_respuesta['errors']);
            $this->exception("Error " . $leer_respuesta['errors']);
        }


        $statusXML = strlen($leer_respuesta["enlace"]) > 0 ? "SIGNED" : "REFUSED";

        $this->documentos->fncActualizarDatosCPE2(
            $aryDocumento["nIdDocumento"],
            $statusXML,
            $leer_respuesta["enlace"],
            $leer_respuesta["aceptada_por_sunat"],
            $leer_respuesta["sunat_ticket_numero"],
            $leer_respuesta["sunat_note"],
            $leer_respuesta["sunat_responsecode"],
            $leer_respuesta["cadena_para_codigo_qr"],
            $leer_respuesta["codigo_hash"]
        );

        return true;
    }

    public function fncEnviarXMLCPE()
    {
        try {
            $nIdRegistro      = isset($_POST["nIdRegistro"]) ? $_POST["nIdRegistro"] : null;
            if (is_null($nIdRegistro)) {
                $this->exception("Error. El id enviado es nulo. Porfavor verifique.");
            }
            $sNumero = $this->fncProcesarEnvio($nIdRegistro);
            $this->json(array("success" => "Genial se envio el comprobante " . $sNumero . " a SUNAT de forma exitosa..."));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEnviarMultipleXMLCPE()
    {
        try {
            $aryData  = isset($_POST["aryData"]) ? $_POST["aryData"] : null;

            if (is_null($aryData) || !is_array($aryData) || count($aryData) == 0) {
                $this->exception("Error.La data enviada es nula. Porfavor verifique.");
            }

            foreach ($aryData as $nIdRegistro) {
                $this->fncProcesarEnvio($nIdRegistro);
            }

            $this->json(array("success" => "Se proceso los comprobantes de forma exitosa..."));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function fncEnviarComprobanteCustom()
    {

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $sAsunto     = isset($_POST['sAsunto']) ? $_POST['sAsunto'] : null;
        $sMensaje    = isset($_POST['sMensaje']) ? $_POST['sMensaje'] : null;
        $sCorreo     = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : null;

        try {
            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            # Obtener el documento 
            // Obtener el documento
            $aryDocumento = $this->documentos->fncObtenerDocumentos(["nIdDocumento" => $nIdRegistro]);
            if (!fncValidateArray($aryDocumento)) {
                $this->exception('Error. No se encontró el documento solicitado. Por favor verifique.');
            }

            $aryDocumento  = $aryDocumento[0];

            $mail = new Mail();
            $html = $sMensaje;

            if (!filter_var($sCorreo, FILTER_VALIDATE_EMAIL)) {
                $this->exception('El correo ' . $sCorreo . ' no tiene un formato valido . Porfavor verifique');
            }

            $sSubjet = $sAsunto;
            $sFrom   = $aryDocumento["sEmpresa"];

            if(!empty($aryDocumento["enlace"])){
                $html    .= " <br> Para descargar el PDF porfavor ingresa al siguiente enlace <a href='" . $aryDocumento["enlace"] . "'>" . $aryDocumento["enlace"] . "</a>";
            }

            $sMsg  = "";
            if ($mail->send([
                'sFrom'        => $sFrom,
                'subject'      => $sSubjet,
                'body'         => $html,
                'sCorreo'      => $sCorreo,
                'sNombre'      => $aryDocumento["sEmpresa"],
            ])) {
                $bSend = true;
                $sMsg = "Genial se envio el mensaje de forma existosa";
            } else {
                $sMsg = "Upds.. no se pudo enviar el mensaje  por medio del correo , por favor vuelve a intentarlo en unos momentos.";
                $bSend = false;
            }

            $this->json(array("success" => $sMsg, "bSend" => $bSend));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
