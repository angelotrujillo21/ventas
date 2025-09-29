<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Application\Libs\Session;
use Application\Models\Sedes;
use Application\Models\Clientes;
use Application\Models\Categorias;
use Application\Models\Cotizacion;
use Application\Models\SerieNumeros;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\CondicionComercial;
use Application\Models\CuentasCorrientes;

class CotizacionController extends Controller
{
    //model principal
    public $cotizacion; // Es mi modelo
    public $session;
    public $categorias;
    public $catalogoTabla;
    public $seriesNumeros;
    public $sTipoComprobante = "COTIZACION";
    public $clientes;
    public $sedes;
    public $cuentascorrientes;
    public $condicionComercial;

    public function __construct()
    {
        parent::__construct();
        $this->session             = new Session();
        $this->cotizacion          = new Cotizacion();
        $this->categorias          = new Categorias();
        $this->catalogoTabla       = new CatalogoTabla();
        $this->seriesNumeros       = new SerieNumeros();
        $this->clientes            = new Clientes();
        $this->sedes               = new Sedes();
        $this->cuentascorrientes   = new CuentasCorrientes();
        $this->condicionComercial  = new CondicionComercial();
        $this->session->init();
    }

    public function cotizacion()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/cotizacion', [
                'sTitulo'      => 'Mantenimientos de cotizaciones',
                'user'         => $this->session->get('user'),
                'bShowMenu'    => true,
                "nAdmin"       => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                'aryClientes'  => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'aryProductos' => (new ProductosController())->fncObtenerProductoVentas(),
                'aryCC'        => $this->condicionComercial->fncObtenerRegistros(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryMoneda'    => $this->catalogoTabla->fncListado("TIPO_MONEDA"),
                'nIdMonedaSoles' => $this->fncGetVarConfig("nIdMonedaSoles")
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

            $aryData = $this->cotizacion->fncObtenerCotizacion([
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
                    $sActionEdit      =  $aryLoop["nVendido"] == 0  ? "fncMostrarRegistro(" . $aryLoop['nIdCotizacion'] . ", 'editar' );" : "";
                    $sActionEliminar  =  $aryLoop["nVendido"] == 0  ? "fncEliminarRegistro(" . $aryLoop['nIdCotizacion'] . ");" : "";

                    $sIconEdit =  $aryLoop["nVendido"] == 0 ? "edit" : "block";
                    $sIconDelete =  $aryLoop["nVendido"] == 0 ? "delete" : "block";

                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">' . $sIconEdit . '</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">' . $sIconDelete . '</i> </a>'  : '';
                    $sLinkPDF          = '<a target="_blank" href="' . route('cotizacion/fncPDF/' . $aryLoop['nIdCotizacion']) . '"   title="Ver PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkPDF . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"          => $sAcciones,
                        "nIdCotizacion"      => $aryLoop["nIdCotizacion"],
                        "sNumero"            => $aryLoop["sNumero"],
                        "sCliente"           => $aryLoop["sCliente"],
                        "dFechaCotizacion"   => $aryLoop["dFechaCotizacion"],
                        "nBaseImponible"     => $aryLoop["nBaseImponible"],
                        "nDescuento"         => $aryLoop["nDescuento"],
                        "nNeto"              => $aryLoop["nNeto"],
                        "nImpuesto"          => $aryLoop["nImpuesto"],
                        "nTotal"             => $aryLoop["nTotal"],
                        "sCondicionComercial"=> $aryLoop["sCondicionComercial"],
                        "sFormaPago"         => $aryLoop["nIdFormaPago"] == 1 ? 'CONTADO' : 'CREDITO',
                        "dFechaCreacion"     => $aryLoop["dFechaCreacion"],
                        "dFechaEdicion"      => $aryLoop["dFechaEdicion"],
                        "sMoneda"            => $aryLoop["sMoneda"],
                        "sVenta"             => $aryLoop["nVendido"] == 1 ? "COMPLETADO" : "SIN VENDER",
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
        $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $nIdCliente             = isset($_POST['nIdCliente']) ? $_POST['nIdCliente'] : null;
        $dFechaCotizacion       = isset($_POST['dFechaCotizacion']) ? $_POST['dFechaCotizacion'] : null;
        $nFlagIGV               = isset($_POST['nFlagIGV']) ? $_POST['nFlagIGV'] : null;
        $nBaseImponible         = isset($_POST['nBaseImponible']) ? $_POST['nBaseImponible'] : null;
        $nDescuento             = isset($_POST['nDescuento']) ? $_POST['nDescuento'] : null;
        $nNeto                  = isset($_POST['nNeto']) ? $_POST['nNeto'] : null;
        $nImpuesto              = isset($_POST['nImpuesto']) ? $_POST['nImpuesto'] : null;
        $nTotal                 = isset($_POST['nTotal']) ? $_POST['nTotal'] : null;
        $nIdFormaPago           = isset($_POST['nIdFormaPago']) ? $_POST['nIdFormaPago'] : null;
        $nIdCondicionComercial  = isset($_POST['nIdCondicionComercial']) ? $_POST['nIdCondicionComercial'] : null;
        $nEstado                = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
        $nIdMoneda              = isset($_POST['nIdMoneda']) ? $_POST['nIdMoneda'] : null;
        $nCotizacion            = isset($_POST['nCotizacion']) ? $_POST['nCotizacion'] : null;
        $sObservacion           = isset($_POST['sObservacion']) ? $_POST['sObservacion'] : null;
        $aryDetalle             = isset($_POST['aryDetalle']) ? json_decode($_POST['aryDetalle'], true) : null;

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

                $nIdNewRegistro = $this->cotizacion->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $aryDataSerieNumero["sPrefijo"],
                    $aryDataSerieNumero["sValor"],
                    $sNumero,
                    $nIdCliente,
                    $dFechaCotizacion,
                    $nFlagIGV,
                    $nBaseImponible,
                    $nDescuento,
                    $nNeto,
                    $nImpuesto,
                    $nTotal,
                    $nIdFormaPago,
                    $nIdMoneda,
                    $sObservacion,
                    $nEstado,
                    $nIdCondicionComercial,
                    $nCotizacion
                );

                $this->seriesNumeros->fncActualizarValorSerieByNomSerie($user["nIdSede"], sp($aryDataSerieNumero["sValor"]), $this->sTipoComprobante);
            } else {
                //Actualizar
                $this->cotizacion->fncActualizarRegistro(
                    $nIdRegistro,
                    $nIdCliente,
                    $dFechaCotizacion,
                    $nFlagIGV,
                    $nBaseImponible,
                    $nDescuento,
                    $nNeto,
                    $nImpuesto,
                    $nTotal,
                    $nIdFormaPago,
                    $nEstado,
                    $nIdMoneda,
                    $sObservacion,
                    $nIdCondicionComercial,
                    $nCotizacion
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
                $this->cotizacion->fncEliminarItemsDetalle($nIdRegistro, $sIdLIst);
            }

            # Id Registro Current
            $nIdRegistroCurrent = $nIdRegistro == 0 ? $nIdNewRegistro : $nIdRegistro;

            foreach ($aryDetalle as $nKey => $aryLoop) {
                # Insertar detalle
                if ($aryLoop["nIdDetalle"] == 0) {

                    # Obtener el ultimo registro de la tabla detalle
                    $this->cotizacion->fncGrabarDetalle(
                        $nIdRegistroCurrent,
                        $aryLoop["nIdProducto"],
                        $aryLoop["nIdUnidadMedida"],
                        $aryLoop["nCantidad"],
                        $aryLoop["nPrecio"],
                        $aryLoop["nSubTotal"],
                        $aryLoop["nPorcentajeDsct"],
                        $aryLoop["nDescuento"],
                        $aryLoop["nTotal"],
                        $aryLoop["sObservacion"]
                    );
                } else {

                    # Actualizar detalle
                    $this->cotizacion->fncActualizarDetalle(
                        $aryLoop["nIdDetalle"],
                        $aryLoop["nIdProducto"],
                        $aryLoop["nIdUnidadMedida"],
                        $aryLoop["nCantidad"],
                        $aryLoop["nPrecio"],
                        $aryLoop["nSubTotal"],
                        $aryLoop["nPorcentajeDsct"],
                        $aryLoop["nDescuento"],
                        $aryLoop["nTotal"],
                        $aryLoop["sObservacion"]
                    );
                }
            }

            $sSuccess = $nIdRegistro == 0 ? 'Cotizacion registrado exitosamente...' : 'Cotizacion actualizado exitosamente...';
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

            $aryData = $this->cotizacion->fncObtenerCotizacion(["nIdCotizacion" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];

            $aryDetalle = [];
            $aryDetalleDB = $this->cotizacion->fncObtenerDetalle(["nIdCotizacion" => $nIdRegistro]);

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

            $this->cotizacion->fncEliminarCotizacion($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

 
    public function fncPDF($nIdRegistro)
    {
        try {

            $aryData = $this->cotizacion->fncObtenerCotizacion(["nIdCotizacion" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];
            $aryDetalleDB = $this->cotizacion->fncObtenerDetalle(["nIdCotizacion" => $nIdRegistro]);


            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryHeader["nIdSede"]]);

            if (!fncValidateArray($arySede)) {
                $this->exception("Error. No se encontro datos de la sede problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryCuentasCorrientes = $this->cuentascorrientes->fncGetCuentasCorrientes(["nIdEmpresa" => $aryHeader["nIdEmpresa"], "nIdSede" => $aryHeader["nIdSede"], "nEstado" => 1]);


            // var_dump($arySede);
            // exit;
            ob_start();
            $this->view("admin/pdf-cotizacion", [
                "aryHeader"  => $aryHeader,
                "aryDetalle" => $aryDetalleDB,
                "arySede"    => $arySede[0],
                "aryCuentasCorrientes" => $aryCuentasCorrientes
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
