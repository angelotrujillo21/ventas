<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Application\Libs\Session;
use Application\Models\DocumentoPago;
use Application\Core\Controller as Controller;
use Application\Models\CatalogoTabla;
use Application\Models\OrdenCompra;
use Application\Models\Proveedores;
use Application\Models\Sedes;
use Application\Models\UnidadMedidas;

class DocumentosPagoController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $documentosPagos;
    public $unidadMedidas;
    public $proveedores;
    public $catalogoTabla;
    public $ordenCompra;
    public $sedes;

    public function __construct()
    {
        parent::__construct();
        $this->session              = new Session();
        $this->documentosPagos      = new DocumentoPago();
        $this->unidadMedidas        = new UnidadMedidas();
        $this->proveedores          = new Proveedores();
        $this->catalogoTabla        = new CatalogoTabla();
        $this->sedes                = new Sedes();
        $this->ordenCompra          = new OrdenCompra();

        $this->session->init();
    }


    public function registroDocumento()
    {
        try {
            $this->authAdmin($this->session);
            $productosController = new ProductosController();
            $user = $this->session->get('user');
            $this->view('admin/registro-documentos', [
                'sTitulo'           => 'Registro documento',
                'user'              => $user,
                'aryProductos'      => $productosController->fncObtenerProductoCompras(),
                'aryUnidadMedida'   => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryProveedores'    => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'aryTipoDocumentos' => $this->catalogoTabla->fncListado("TIPO_COMPROBANTE"),
                'arySede'           => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
                'bShowMenu'         => true,
                "nAdmin"            => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }




    public function fncPopulate()
    {
        try {

            $nIdTipoDocumento   = isset($_POST["nIdTipoDocumento"]) ? $_POST["nIdTipoDocumento"] : null;
            $sNumero            = isset($_POST["sNumero"]) ? $_POST["sNumero"] : null;
            $nIdEstadoPago      = isset($_POST["nIdEstadoPago"]) ? $_POST["nIdEstadoPago"] : null;
            $dFechaInicio       = isset($_POST["dFechaInicio"]) ? $_POST["dFechaInicio"] : null;
            $dFechaFin          = isset($_POST["dFechaFin"]) ? $_POST["dFechaFin"] : null;


            // Valida valores del formulario
            $aryRows        = [];
            $user           = $this->session->get("user");

            $aryData  = $this->documentosPagos->fncObtenerDocumentosPagos([
                "nIdSede"           => $user["nIdSede"],
                "nIdTipoDocumento"  => $nIdTipoDocumento,
                "sNumero"           => $sNumero,
                "nIdEstadoPago"     => $nIdEstadoPago,
                "dFechaInicio"      => $dFechaInicio,
                "dFechaFin"         => $dFechaFin,
            ]);

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {

                foreach ($aryData as $aryLoop) {

                    $sActionShow       = "fncMostrarRegistro(" . $aryLoop['nIdDocumentosPago'] . ", 'ver' );";
                    $sActionEdit       = "fncMostrarRegistro(" . $aryLoop['nIdDocumentosPago'] . ", 'editar' );";
                    $sActionEliminar   = "fncEliminarRegistro(" . $aryLoop['nIdDocumentosPago'] . ");";

                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin && $aryLoop["nEstadoPago"] == 0 ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin && $aryLoop["nEstadoPago"] == 0 ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"          => $sAcciones,
                        "sProveedor"         => $aryLoop["sProveedor"],
                        "sOrdenCompra"       => $aryLoop["nIdOrdenCompra"] > 0  ? sp($aryLoop["nIdOrdenCompra"]) : "",
                        "sDocumento"         => $aryLoop["sTipoDoc"] . " " . $aryLoop["sNumero"],
                        "dFecha"             => $aryLoop["dFecha"],
                        "dVencimiento"       => $aryLoop["dVencimiento"],
                        "dPeriodo"           => $aryLoop["dPeriodo"],
                        "sCondicionPago"     => $aryLoop["nCondicionPago"],
                        "sCondicionPago"     => $aryLoop["sCondicionPago"],
                        "nTotalDsct"         => nf($aryLoop["nTotalDsct"], true),
                        "nSubtotal"          => nf($aryLoop["nSubTotal"], true),
                        "nIgv"               => nf($aryLoop["nIgv"], true),
                        "nTotal"             => nf($aryLoop["nTotal"], true),
                        "sEstadoPago"        => $aryLoop["nEstadoPago"] == 1 ? "PAGADO" : "PENDIENTE",
                        "sEstado"            => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncGrabarDocumento()
    {
        $nIdRegistro       = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $nIdProveedor      = isset($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : null;
        $nIdOrdenCompra    = isset($_POST['nIdOrdenCompra']) ? $_POST['nIdOrdenCompra'] : null;
        $nIdTipoDocumento  = isset($_POST['nIdTipoDocumento']) ? $_POST['nIdTipoDocumento'] : null;
        $sNumero           = isset($_POST['sNumero']) ? $_POST['sNumero'] : null;
        $dFecha            = isset($_POST['dFecha']) ? $_POST['dFecha'] : null;
        $dVencimiento      = isset($_POST['dVencimiento']) ? $_POST['dVencimiento'] : null;
        $dPeriodo          = isset($_POST['dPeriodo']) ? $_POST['dPeriodo'] : null;
        $nCondicionPago    = isset($_POST['nCondicionPago']) ? $_POST['nCondicionPago'] : null;
        $nPorcentajeIGV    = isset($_POST['nPorcentajeIGV']) ? $_POST['nPorcentajeIGV'] : null;
        $nPorcentajeDsct   = isset($_POST['nPorcentajeDsct']) ? $_POST['nPorcentajeDsct'] : null;
        $nSubTotal         = isset($_POST['nSubTotal']) ? $_POST['nSubTotal'] : null;
        $nTotalDsct        = isset($_POST['nTotalDsct']) ? $_POST['nTotalDsct'] : null;
        $nIgv              = isset($_POST['nIgv']) ? $_POST['nIgv'] : null;
        $nTotal            = isset($_POST['nTotal']) ? $_POST['nTotal'] : null;
        $nEstadoPago       = isset($_POST['nEstadoPago']) ? $_POST['nEstadoPago'] : null;
        $sComentario       = isset($_POST['sComentario']) ? $_POST['sComentario'] : null;
        $nEstado           = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
        $nTipoMoneda       = isset($_POST['nTipoMoneda']) ? $_POST['nTipoMoneda'] : null;

        $aryDetalle        = isset($_POST['aryDetalle']) ? $_POST['aryDetalle'] : null;


        try {



            // Valida valores del formulario
            if (is_null($nIdRegistro)  || is_null($nIdProveedor) || is_null($nIdOrdenCompra)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdNewRegistro = null;

            // Crear
            if ($nIdRegistro == 0) {

                # Graba el pedido
                $nIdNewRegistro = $this->documentosPagos->fncGrabarRegistro(
                    $nIdProveedor,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdOrdenCompra,
                    $nIdTipoDocumento,
                    $sNumero,
                    $dFecha,
                    $dVencimiento,
                    $dPeriodo,
                    $nCondicionPago,
                    $nPorcentajeIGV,
                    $nPorcentajeDsct,
                    $nTotalDsct,
                    $nSubTotal,
                    $nIgv,
                    $nTotal,
                    $nTotal,
                    $nEstadoPago,
                    $sComentario,
                    $nTipoMoneda,
                    $nEstado
                );

                # Graba el detalle del pedido
                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {
                        $this->documentosPagos->fncGrabarRegistroDetalle(
                            $nIdNewRegistro,
                            $aryLoop["nIdProducto"],
                            $aryLoop["nPrecio"],
                            $aryLoop["nCantidad"]
                        );
                    }
                }

                # Actualizar el estado de registro de documento de la orden de compra
                if (!is_null($nIdOrdenCompra) && $nIdOrdenCompra > 0) {
                    $this->ordenCompra->fncActualizarEstadpRegistroDocumento($nIdOrdenCompra, 0);
                }
            } else {

                // Actualizar

                # Actualiza la cabecera del pedido
                $this->documentosPagos->fncActualizarRegistro(
                    $nIdRegistro,
                    $nIdProveedor,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdOrdenCompra,
                    $nIdTipoDocumento,
                    $sNumero,
                    $dFecha,
                    $dVencimiento,
                    $dPeriodo,
                    $nCondicionPago,
                    $nPorcentajeIGV,
                    $nPorcentajeDsct,
                    $nTotalDsct,
                    $nSubTotal,
                    $nIgv,
                    $nTotal,
                    $nTotal,
                    $nEstadoPago,
                    $sComentario,
                    $nTipoMoneda,
                    $nEstado
                );

                # Elimino el detalle del pedido
                $this->documentosPagos->fncEliminarRegistroDetalleByIdDocumentoPago($nIdRegistro);

                # Inserto el detalle del pedido
                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {
                        $this->documentosPagos->fncGrabarRegistroDetalle(
                            $nIdRegistro,
                            $aryLoop["nIdProducto"],
                            $aryLoop["nPrecio"],
                            $aryLoop["nCantidad"]
                        );
                    }
                }
            }


            $sSuccess = $nIdRegistro == 0 ? 'Documento registrado exitosamente...' : 'Documento actualizado exitosamente...';
            $this->json(array(
                "success"            => $sSuccess,
                "nIdNewRegistro"     => $nIdNewRegistro,
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarRegistro()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->documentosPagos->fncObtenerDocumentosPagos(["nIdDocumentosPago" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception("Error.No se pudo encontrar el pedido o se haya eliminado.Porfavor verifique");
            }

            $aryData = $aryData[0];

            # Actualizamos el estado de  pago de la orden de compra 
            if ($aryData["nIdOrdenCompra"] != "" && $aryData["nIdOrdenCompra"] > 0) {
                $this->ordenCompra->fncActualizarEstadpRegistroDocumento(
                    $aryData["nIdOrdenCompra"],
                    0
                );
            }

            $this->documentosPagos->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Documento eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarRegistro()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryDocumento   = $this->documentosPagos->fncObtenerDocumentosPagos(["nIdDocumentosPago" => $nIdRegistro]);
            $aryDocDetalle  = $this->documentosPagos->fncObtenerDocumentosPagosDetalle(["nIdDocumentosPago" => $nIdRegistro]);

            $this->json(array(
                "success"           => true,
                "aryDocumento"      => fncValidateArray($aryDocumento) ? $aryDocumento[0] : null,
                "aryDocDetalle"     => $aryDocDetalle
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncObtenerDocumentos()
    {
        try {
            $nIdProveedor       = isset($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : null;
            $nEstadoPago        = isset($_POST['nEstadoPago']) ? $_POST['nEstadoPago'] : null;


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            // Valida valores del formulario
            $aryData = $this->documentosPagos->fncObtenerDocumentosPagos([
                "nIdSede"      => $user["nIdSede"],
                "nIdProveedor" => $nIdProveedor,
                "nEstadoPago"  => $nEstadoPago
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
