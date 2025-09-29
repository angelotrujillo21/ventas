<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Application\Libs\Session;
use Application\Models\Sedes;
use Application\Models\Clientes;
use Application\Models\Categorias;
use Application\Models\SerieNumeros;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\Choferes;
use Application\Models\Guia;
use Application\Models\Pedidos;
use Application\Models\Vehiculo;

class GuiaController extends Controller
{
    //model principal
    public $guia; // Es mi modelo
    public $session;
    public $catalogoTabla;
    public $seriesNumeros;
    public $clientes;
    public $sTipoComprobante = "GUIA";
    public $choferes;
    public $vehiculos;
    public $pedidos;

    public function __construct()
    {
        parent::__construct();
        $this->session             = new Session();
        $this->guia                = new Guia();
        $this->catalogoTabla       = new CatalogoTabla();
        $this->seriesNumeros       = new SerieNumeros();
        $this->clientes            = new Clientes();
        $this->choferes            = new Choferes();
        $this->vehiculos           = new Vehiculo();
        $this->pedidos             = new Pedidos();
        $this->session->init();
    }

    public function guia()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/guia', [
                'sTitulo'         => 'Mantenimientos de Guia',
                'user'            => $this->session->get('user'),
                'bShowMenu'       => true,
                "nAdmin"          => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                'aryProductos'    => (new ProductosController())->fncObtenerProductoVentas(),
                'aryChoferes'     => $this->choferes->fncObtenerChoferes(["nEstado" => 1]),
                'aryVehiculos'    => $this->vehiculos->fncObtenerRegistros(["nEstado" => 1]),
                'aryPedidos'      => $this->pedidos->fncObtenerPedidos(["nDespachado" => 0])
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulate()
    {


        $sIdsCliente    = isset($_POST["sIdsCliente"]) ? $_POST["sIdsCliente"] : null;
        $dFechaInicio   = isset($_POST["dFechaInicio"]) ? $_POST["dFechaInicio"] : null;
        $dFechaFin      = isset($_POST["dFechaFin"]) ? $_POST["dFechaFin"] : null;
        $nVendido       = isset($_POST["nVendido"]) ? $_POST["nVendido"] : null;
        $nEstado        = isset($_POST["nEstado"]) ? $_POST["nEstado"] : null;

        try {


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows = [];

            $aryData = $this->guia->fncObtenerRegistros([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nIdSede"       => $user["nIdSede"],
                "dFechaInicio"  => $dFechaInicio,
                "dFechaFin"     => $dFechaFin,
                "sIdsCliente"   => $sIdsCliente,
                "nVendido"      => $nVendido,
                "nEstado"       => $nEstado
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionEdit      =  $aryLoop["nVendido"] == 0  ? "fncMostrarRegistro(" . $aryLoop['nIdGuia'] . ", 'editar' );" : "";
                    $sActionEliminar  =  $aryLoop["nVendido"] == 0  ? "fncEliminarRegistro(" . $aryLoop['nIdGuia'] . ");" : "";

                    $sIconEdit =  $aryLoop["nVendido"] == 0 ? "edit" : "block";
                    $sIconDelete =  $aryLoop["nVendido"] == 0 ? "delete" : "block";

                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">' . $sIconEdit . '</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">' . $sIconDelete . '</i> </a>'  : '';
                    $sLinkPDF          = '<a target="_blank" href="' . route('cotizacion/fncPDF/' . $aryLoop['nIdGuia']) . '"   title="Ver PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkPDF . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"          => $sAcciones,
                        "nIdGuia"      => $aryLoop["nIdGuia"],
                        "sNumero"            => $aryLoop["sNumero"],
                        "sCliente"           => $aryLoop["sCliente"],
                        "sFechaGuia"   => $aryLoop["sFechaGuia"],
                        "sChofer"           => $aryLoop["sChofer"],
                        "sVehiculo"          => $aryLoop["sVehiculo"],

                        "dFechaCreacion"     => $aryLoop["dFechaCreacion"],
                        "dFechaEdicion"      => $aryLoop["dFechaEdicion"],
                        //  "sVenta"             => $aryLoop["nVendido"] == 1 ? "COMPLETADO" : "SIN VENDER",
                        "sEstado"            => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarRegistro()
    {
        $nIdRegistro         = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $dFechaGuia          = isset($_POST['dFechaGuia']) ? $_POST['dFechaGuia'] : null;
        $nIdPedido           = isset($_POST['nIdPedido']) ? $_POST['nIdPedido'] : null;
        $nTipoDespacho       = isset($_POST['nTipoDespacho']) ? $_POST['nTipoDespacho'] : null;
        $nIdCliente          = isset($_POST['nIdCliente']) ? $_POST['nIdCliente'] : null;
        $nIdChofer           = isset($_POST['nIdChofer']) ? $_POST['nIdChofer'] : null;
        $nIdVehiculo         = isset($_POST['nIdVehiculo']) ? $_POST['nIdVehiculo'] : null;
        $nIdTipoMovimiento   = isset($_POST['nIdTipoMovimiento']) ? $_POST['nIdTipoMovimiento'] : null;
        $sTipoViaRmt         = isset($_POST['sTipoViaRmt']) ? $_POST['sTipoViaRmt'] : null;
        $sNroRmt             = isset($_POST['sNroRmt']) ? $_POST['sNroRmt'] : null;
        $sZonaRmt            = isset($_POST['sZonaRmt']) ? $_POST['sZonaRmt'] : null;
        $sProvinciaRmt       = isset($_POST['sProvinciaRmt']) ? $_POST['sProvinciaRmt'] : null;
        $sViaNombreRmt       = isset($_POST['sViaNombreRmt']) ? $_POST['sViaNombreRmt'] : null;
        $sInteriorRmt        = isset($_POST['sInteriorRmt']) ? $_POST['sInteriorRmt'] : null;
        $sDistritoRmt        = isset($_POST['sDistritoRmt']) ? $_POST['sDistritoRmt'] : null;
        $sDptRmt             = isset($_POST['sDptRmt']) ? $_POST['sDptRmt'] : null;
        $sRemitente          = isset($_POST['sRemitente']) ? $_POST['sRemitente'] : null;
        $sNumeroDocRmt       = isset($_POST['sNumeroDocRmt']) ? $_POST['sNumeroDocRmt'] : null;
        $sTipoViaDest        = isset($_POST['sTipoViaDest']) ? $_POST['sTipoViaDest'] : null;
        $sNroDest            = isset($_POST['sNroDest']) ? $_POST['sNroDest'] : null;
        $sZonaDest           = isset($_POST['sZonaDest']) ? $_POST['sZonaDest'] : null;
        $sProvinciaDest      = isset($_POST['sProvinciaDest']) ? $_POST['sProvinciaDest'] : null;
        $sViaNombreDest      = isset($_POST['sViaNombreDest']) ? $_POST['sViaNombreDest'] : null;
        $sInteriorDest       = isset($_POST['sInteriorDest']) ? $_POST['sInteriorDest'] : null;
        $sDistritoDest       = isset($_POST['sDistritoDest']) ? $_POST['sDistritoDest'] : null;
        $sDptDest            = isset($_POST['sDptDest']) ? $_POST['sDptDest'] : null;
        $sDestinatario       = isset($_POST['sDestinatario']) ? $_POST['sDestinatario'] : null;
        $sNumeroDocDest      = isset($_POST['sNumeroDocDest']) ? $_POST['sNumeroDocDest'] : null;
        $sComentario         = isset($_POST['sComentario']) ? $_POST['sComentario'] : null;
        $nEstado             = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
        $aryDetalle          = isset($_POST['aryDetalle']) ? json_decode($_POST['aryDetalle'], true) : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdNewRegistro = null;
            // Crear
            if ($nIdRegistro == 0) {

                $aryDataSerieNumero = $this->seriesNumeros->fncGetSerieNumerosByNomSerie($this->sTipoComprobante, $user["nIdEmpresa"], $user["nIdSede"]);

                if (!fncValidateArray($aryDataSerieNumero)) {
                    $this->exception('Error. No se encontro una serie y numero para el documento ' . $this->sTipoComprobante . '. Por favor verifique.');
                }

                $sNumero = $aryDataSerieNumero["sPrefijo"] . "-" . sp($aryDataSerieNumero["sValor"]);

                $nIdNewRegistro = $this->guia->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNumero,
                    $dFechaGuia,
                    $nIdPedido,
                    $nTipoDespacho,
                    $nIdCliente,
                    $nIdChofer,
                    $nIdVehiculo,
                    $nIdTipoMovimiento,
                    $sTipoViaRmt,
                    $sNroRmt,
                    $sZonaRmt,
                    $sProvinciaRmt,
                    $sViaNombreRmt,
                    $sInteriorRmt,
                    $sDistritoRmt,
                    $sDptRmt,
                    $sRemitente,
                    $sNumeroDocRmt,
                    $sTipoViaDest,
                    $sNroDest,
                    $sZonaDest,
                    $sProvinciaDest,
                    $sViaNombreDest,
                    $sInteriorDest,
                    $sDistritoDest,
                    $sDptDest,
                    $sDestinatario,
                    $sNumeroDocDest,
                    $sComentario,
                    $nEstado
                );

                $this->seriesNumeros->fncActualizarValorSerieByNomSerie($user["nIdSede"], sp($aryDataSerieNumero["sValor"]), $this->sTipoComprobante);
            } else {
                //Actualizar
                $this->guia->fncActualizarRegistro(
                    $nIdRegistro,
                    $dFechaGuia,
                    $nIdPedido,
                    $nTipoDespacho,
                    $nIdCliente,
                    $nIdChofer,
                    $nIdVehiculo,
                    $nIdTipoMovimiento,
                    $sTipoViaRmt,
                    $sNroRmt,
                    $sZonaRmt,
                    $sProvinciaRmt,
                    $sViaNombreRmt,
                    $sInteriorRmt,
                    $sDistritoRmt,
                    $sDptRmt,
                    $sRemitente,
                    $sNumeroDocRmt,
                    $sTipoViaDest,
                    $sNroDest,
                    $sZonaDest,
                    $sProvinciaDest,
                    $sViaNombreDest,
                    $sInteriorDest,
                    $sDistritoDest,
                    $sDptDest,
                    $sDestinatario,
                    $sNumeroDocDest,
                    $sComentario,
                    $nEstado
                );
            }


            # Construye el array de IDS para obtener los registros que se han eliminado en la vista
            # luego elimina los hijos del detalle
            # Luego Elimina el detalle
            if ($nIdRegistro != 0) {
                $aryIds = [];
                foreach ($aryDetalle as $aryLoop) {
                    if ($aryLoop["nIdDetalle"] != 0) {
                        array_push($aryIds, $aryLoop["nIdDetalle"]);
                    }
                }

                $sIdLIst = implode(",", $aryIds);

                # Eliminar los registros del detalle
                $this->guia->fncEliminarItemsDetalle($nIdRegistro, $sIdLIst);
            }

            # Id Registro Current
            $nIdRegistroCurrent = $nIdRegistro == 0 ? $nIdNewRegistro : $nIdRegistro;

            foreach ($aryDetalle as $nKey => $aryLoop) {
                # Insertar detalle
                if ($aryLoop["nIdDetalle"] == 0) {

                    # Obtener el ultimo registro de la tabla detalle
                    $this->guia->fncGrabarDetalle(
                        $nIdRegistroCurrent,
                        $aryLoop["nIdProducto"],
                        $aryLoop["nTotalPedido"],
                        $aryLoop["nDespachado"]
                    );
                } else {

                    # Actualizar detalle
                    $this->guia->fncActualizarDetalle(
                        $aryLoop["nIdDetalle"],
                        $aryLoop["nIdProducto"],
                        $aryLoop["nTotalPedido"],
                        $aryLoop["nDespachado"]
                    );
                }
            }

            $sSuccess = $nIdRegistro == 0 ? 'Guia registrada exitosamente...' : 'Guia actualizada exitosamente...';
            $this->json(array("success" => $sSuccess, "nIdNewRegistro" => $nIdNewRegistro));
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

            $aryData = $this->guia->fncObtenerRegistros(["nIdGuia" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];

            $aryDetalle = [];
            $aryDetalleDB = $this->guia->fncObtenerDetalle(["nIdGuia" => $nIdRegistro]);

            $nIdRowD = 0;
            foreach ($aryDetalleDB as $key => $aryLoopD) {
                $nIdRowD++;

                $sActionEdit      = "fncEditarDetalle(" . $nIdRowD . ", 'editar' );";
                $sActionEliminar  = "fncEliminarDetalle(" . $nIdRowD . ");";

                $sLinkEdit   = '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>';
                $sLinkDelete = '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i></a>';

                $sAcciones = '<div class="content-acciones">
                                ' . $sLinkEdit . '
                                ' . $sLinkDelete . '
                            </div>';

                $aryDetalle[] = [
                    "sAcciones"         => $sAcciones,
                    "nIdRow"            => $nIdRowD,
                    "nIdDetalle"        => $aryLoopD["nIdDetalle"],
                    "nIdProducto"       => $aryLoopD["nIdProducto"],
                    "nIdUnidadMedida"   => $aryLoopD["nIdUnidadMedida"],
                    "nCantidad"         => $aryLoopD["nCantidad"],
                    "nPrecio"           => $aryLoopD["nPrecio"],
                    "nPorcentajeDsct"   => $aryLoopD["nPorcentajeDsct"],
                    "nDescuento"        => $aryLoopD["nDescuento"],
                    "sObservacion"      => $aryLoopD["sObservacion"],
                    "nTotal"            => $aryLoopD["nTotal"],
                    "sProducto"         => $aryLoopD["sProducto"] . " - " . $aryLoopD["sUnidadMedidaCorto"],
                    "sUnidadMedida"     => $aryLoopD["sUnidadMedida"],
                    "nSubTotal"         => $aryLoopD["nSubTotal"],
                    "sImagenProducto"   => $aryLoopD["sImagenProducto"]
                ];
            }

            $this->json(array("success" => true, "aryData" => $aryHeader, "aryDetalle" => $aryDetalle));
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
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $this->guia->fncEliminarGuia($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPDF($nIdRegistro)
    {
        try {

            $aryData = $this->guia->fncObtenerRegistros(["nIdGuia" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];
            $aryDetalleDB = $this->guia->fncObtenerDetalle(["nIdGuia" => $nIdRegistro]);


            // $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryHeader["nIdSede"]]);

            // if (!fncValidateArray($arySede)) {
            //     $this->exception("Error. No se encontro datos de la sede problablemente se haya eliminado o no exista. Porfavor verifique.");
            // }

            // var_dump($arySede);
            // exit;
            ob_start();
            $this->view("admin/pdf-guia", [
                "aryHeader"  => $aryHeader,
                "aryDetalle" => $aryDetalleDB,
                // "arySede"    => $arySede[0],
            ]);
            $html = ob_get_contents();
            ob_end_clean();

            $aryConfig = [];

            $mpdf = new Mpdf($aryConfig);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
