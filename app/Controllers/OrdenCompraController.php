<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Matrix\Functions;
use Application\Libs\Session;

use Application\Models\Productos;
use Application\Models\OrdenCompra;
use Application\Models\Proveedores;
use Application\Models\CatalogoTabla;
use Application\Models\UnidadMedidas;
use Application\Core\Controller as Controller;
use Application\Libs\Excel;
use Application\Models\Empresas;
use Application\Models\Sedes;
use Mpdf\Tag\Em;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;
use \PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;

class OrdenCompraController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $productos;
    public $ordenCompra;
    public $catalogotabla;
    public $unidadMedidas;
    public $proveedores;
    public $sedes;
    public $empresas;

    public $sUrlOrdenCompra = "orden-compra";
    public $sUrlReporteGestionCompra = "reporte-gestion-de-compras";

    public $sUrlGastos = "gastos";
    public $sUrlReporteGastos = "reporte-gastos";


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogotabla    = new CatalogoTabla();
        $this->productos        = new Productos();
        $this->ordenCompra      = new OrdenCompra();
        $this->unidadMedidas    = new UnidadMedidas();
        $this->proveedores      = new Proveedores();
        $this->sedes            = new Sedes();
        $this->empresas         = new Empresas();
        $this->session->init();
    }

    public function ordenCompra()
    {
        $this->authAdmin($this->session);
        $user = $this->session->get('user');
        $productosController = new ProductosController();
        try {
            $nTipoOrdenCompra = $this->fncGetVarConfig("nTipoOrdenCompra");

            $nIdResponsable   = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlOrdenCompra)) ? null : $user["nIdEmpleado"];

            $aryOrdenCompra = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"], "nTipo" => $nTipoOrdenCompra, "nIdResponsable" => $nIdResponsable]);

            $aryIdOC        = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/orden-compra', [
                'sTitulo'          => 'Orden de compra',
                'user'             => $user,
                'aryIdOC'          => $aryIdOC,
                'arySede'          => $arySede,
                'aryProductos'     => $productosController->fncObtenerProductoCompras(),
                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryProveedores'   => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlOrdenCompra) ? 1 : 0,
                "nTipoOrdenCompra" => $nTipoOrdenCompra
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function gastos()
    {
        $this->authAdmin($this->session);
        $user = $this->session->get('user');
        $productosController = new ProductosController();
        try {
            $nTipoGasto = $this->fncGetVarConfig("nTipoGasto");

            $nIdResponsable   = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlGastos)) ? null : $user["nIdEmpleado"];

            $aryOrdenCompra = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"], "nTipo" => $nTipoGasto, "nIdResponsable" => $nIdResponsable]);

            $aryIdOC        = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/gastos', [
                'sTitulo'          => 'Gastos',
                'user'             => $user,
                'aryIdOC'          => $aryIdOC,
                'arySede'          => $arySede,
                'aryProductos'     => $productosController->fncObtenerProductoCompras(),
                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryProveedores'   => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlGastos) ? 1 : 0,
                "nTipoGasto"       => $nTipoGasto
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function printOrdenCompraGasto()
    {
        $this->authAdmin($this->session);

        $user = $this->session->get('user');

        try {

            # Obtiene todas las ordenes de compra
            $nTipoOrdenCompra = $this->fncGetVarConfig("nTipoOrdenCompra");
            $aryOrdenCompra   = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"], "nTipo" => $nTipoOrdenCompra, "nEjecutado" => 0]);
            $aryIdOC          = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];

            # Obtiene todos los gastos
            $nTipoGasto        = $this->fncGetVarConfig("nTipoGasto");
            $aryOrdenCompra    = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"], "nTipo" => $nTipoGasto, "nEjecutado" => 0]);
            $aryIdGasto        = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];


            $this->view('admin/print-oc-gastos', [
                'sTitulo'          => 'Imprimir orden de compra y gastos',
                'user'             => $user,
                'aryIdOC'          => $aryIdOC,
                'aryIdGasto'       => $aryIdGasto,
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlOrdenCompra) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function reporteGestionCompras()
    {
        $this->authAdmin($this->session);
        $user = $this->session->get('user');
        $productosController = new ProductosController();
        try {
            $nTipoOrdenCompra = $this->fncGetVarConfig("nTipoOrdenCompra");
            $nIdResponsable   = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionCompra)) ? null : $user["nIdEmpleado"];

            $aryOrdenCompra = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"],  "nTipo" => $nTipoOrdenCompra, "nIdResponsable" => $nIdResponsable]);
            $aryIdOC        = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/reporte-gestion-compras', [
                'sTitulo'          => 'Reporte gestion de compras',
                'user'             => $user,
                'arySede'          => $arySede,
                'aryIdOC'          => $aryIdOC,
                'aryProductos'     => $productosController->fncObtenerProductoCompras(),
                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryProveedores'   => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionCompra) ? 1 : 0,
                "nTipoOrdenCompra" => $nTipoOrdenCompra

            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function movimientosCompras()
    {
        $this->authAdmin($this->session);

        $user = $this->session->get('user');

        $productosController = new ProductosController();

        try {

            $nTipoOrdenCompra = $this->fncGetVarConfig("nTipoOrdenCompra");
            $nIdResponsable   = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->fncGetVista())) ? null : $user["nIdEmpleado"];

            $aryOrdenCompra = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"],  "nTipo" => $nTipoOrdenCompra, "nIdResponsable" => $nIdResponsable]);
            $aryIdOC        = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/movimientos-compras', [
                'sTitulo'          => 'Reporte Movimientos compras',
                'user'             => $user,
                'arySede'          => $arySede,
                'aryIdOC'          => $aryIdOC,
                'aryProductos'     => $productosController->fncObtenerProductoCompras(),
                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryProveedores'   => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "nTipoOrdenCompra" => $nTipoOrdenCompra
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function movimientosGastos()
    {
        $this->authAdmin($this->session);

        $user = $this->session->get('user');

        $productosController = new ProductosController();

        try {

            $nTipoGasto       = $this->fncGetVarConfig("nTipoGasto");
            $nIdResponsable   = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->fncGetVista())) ? null : $user["nIdEmpleado"];

            $aryOrdenCompra = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"],  "nTipo" => $nTipoGasto, "nIdResponsable" => $nIdResponsable]);
            $aryIdOC        = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/movimientos-gastos', [
                'sTitulo'          => 'Reporte Movimientos Gastos',
                'user'             => $user,
                'arySede'          => $arySede,
                'aryIdOC'          => $aryIdOC,
                'aryProductos'     => $productosController->fncObtenerProductoCompras(),
                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryProveedores'   => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "nTipoGasto"       => $nTipoGasto,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteGastos()
    {
        $this->authAdmin($this->session);
        $user = $this->session->get('user');
        $productosController = new ProductosController();
        try {
            $nTipoGasto       = $this->fncGetVarConfig("nTipoGasto");

            $nIdResponsable   = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGastos)) ? null : $user["nIdEmpleado"];

            $aryOrdenCompra = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"],  "nTipo" => $nTipoGasto, "nIdResponsable" => $nIdResponsable]);

            $aryIdOC        = fncValidateArray($aryOrdenCompra) ? array_column($aryOrdenCompra, "nIdOrdenCompra") : [];

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/reporte-gastos', [
                'sTitulo'          => 'Reporte Gastos',
                'user'             => $user,
                'arySede'          => $arySede,
                'aryIdOC'          => $aryIdOC,
                'aryProductos'     => $productosController->fncObtenerProductoCompras(),
                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
                'aryProveedores'   => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGastos) ? 1 : 0,
                "nTipoGasto"       => $nTipoGasto
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateMovientosComprasGastos()
    {
        try {

            // Valida valores del formulario

            $aryProductos     = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $aryIdsOC         = isset($_POST['aryIdsOC']) ? $_POST['aryIdsOC'] : null;
            $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $nProcesado       = isset($_POST['nProcesado']) ? $_POST['nProcesado'] : null;
            $nEjecutado       = isset($_POST['nEjecutado']) ? $_POST['nEjecutado'] : null;
            $nTipo            = isset($_REQUEST['nTipo']) ? $_REQUEST['nTipo'] : null;


            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            if (is_null($nTipo) || $nTipo == '') {
                $this->exception("Error. No se espefico un tipo .Porfavor verifique o solicite asistencia");
            }


            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->fncGetVista())) ? null : $user["nIdEmpleado"];


            $aryData  = $this->ordenCompra->fncObtenerOrdenCompra([
                "nIdResponsable"  => $nIdResponsable,
                "nIdSede"         => $user["nIdSede"],
                "aryIdsOC"        => $aryIdsOC,
                "aryProductos"    => $aryProductos,
                "dFechaInicio"    => $dFechaInicio,
                "dFechaFin"       => $dFechaFin,
                "nProcesado"      => $nProcesado,
                "nTipo"           => $nTipo,
                "nEjecutado"      => $nEjecutado
            ]);


            $nTipoOrdenCompra    = $this->fncGetVarConfig("nTipoOrdenCompra");
            $nTipoGasto          = $this->fncGetVarConfig("nTipoGasto");

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $nKey => $aryLoop) {


                    $aryDetalle   = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $aryLoop['nIdOrdenCompra']]);

                    if (fncValidateArray($aryDetalle)) {
                        foreach ($aryDetalle as $nKey => $aryDet) {


                            $aryRows[] = [
                                "nItem"                   => sp($nKey + 1, 4),
                                "nIdOrdenCompraFormat"    => sp($aryLoop["nIdOrdenCompra"]),
                                "sProducto"               => $aryDet["sProducto"] . (strlen($aryDet["sProducto"]) > 0 ? " - " . $aryDet["sProducto"] : ""),
                                "sUnidadMedida"           => $aryDet["sUnidadMedida"],
                                "dFechaCreacion"          => $aryLoop["dFechaCreacion"],
                                "sResponsable"            => strup($aryLoop["sResponsable"]),
                                "sProcesado"              => $aryLoop["nProcesado"] == 1 ? "SI" : "NO",
                                "sEstado"                 => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                                "sEjecutado"              => ($aryLoop["nEjecutado"] == 1 ? "EJECUTADO" : "PLANIFICADO"),
                                "nCantidad"               => $aryDet["nCantidad"],

                            ];
                        }
                    }
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulate()
    {
        try {

            // Valida valores del formulario

            $aryProductos     = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $aryIdsOC         = isset($_POST['aryIdsOC']) ? $_POST['aryIdsOC'] : null;
            $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $nProcesado       = isset($_POST['nProcesado']) ? $_POST['nProcesado'] : null;
            $nEjecutado       = isset($_POST['nEjecutado']) ? $_POST['nEjecutado'] : null;
            $nTipo            = isset($_REQUEST['nTipo']) ? $_REQUEST['nTipo'] : null;


            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            if (is_null($nTipo)) {
                $this->exception("Error. No se espefico un tipo .Porfavor verifique o solicite asistencia");
            }


            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlOrdenCompra)) ? null : $user["nIdEmpleado"];

            if (is_null($aryProductos)  && is_null($dFechaInicio) && is_null($dFechaFin)  && is_null($aryIdsOC)  && is_null($nProcesado) && is_null($nEjecutado)) {
                $aryData  = $this->ordenCompra->fncObtenerOrdenCompra([
                    "nIdResponsable"    => $nIdResponsable,
                    "nIdSede"           => $user["nIdSede"],
                    "dFechaCreacion"    => date("d/m/Y"),
                    "nTipo"             => $nTipo
                ]);
            } else {
                $aryData  = $this->ordenCompra->fncObtenerOrdenCompra([
                    "nIdResponsable"  => $nIdResponsable,
                    "nIdSede"         => $user["nIdSede"],
                    "aryIdsOC"        => $aryIdsOC,
                    "aryProductos"    => $aryProductos,
                    "dFechaInicio"    => $dFechaInicio,
                    "dFechaFin"       => $dFechaFin,
                    "nProcesado"      => $nProcesado,
                    "nTipo"           => $nTipo,
                    "nEjecutado"      => $nEjecutado
                ]);
            }


            $nTipoOrdenCompra    = $this->fncGetVarConfig("nTipoOrdenCompra");
            $nTipoGasto          = $this->fncGetVarConfig("nTipoGasto");

            //$bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlOrdenCompra);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $nKey => $aryLoop) {

                    $nNewStateEjecutado = $aryLoop["nEjecutado"] == 1  ? 0 : 1;
                    $sIconEJ            = $aryLoop["nEjecutado"] == 1  ? 'pending_actions' : 'done';
                    $sTitleCEJ          = $aryLoop["nEjecutado"] == 1  ? 'Cambiar a planificado' : 'Cambiar a ejecutado';
                    $sActionEstadoEJ    = "fncCambiarEstadoEJOC(" . $aryLoop['nIdOrdenCompra'] . " , " . $nNewStateEjecutado . ");"; // Camviar estado ejecutado de la orden de compra

                    $sActionShow       = "fncMostrarOC(" . $aryLoop['nIdOrdenCompra'] . ", 'ver' );";
                    $sActionEdit       = "fncMostrarOC(" . $aryLoop['nIdOrdenCompra'] . ", 'editar' );";
                    $sActionEliminar   = "fncEliminarOC(" . $aryLoop['nIdOrdenCompra'] . ");";


                    $sLinkPDF    = '<a target="_blank" href="' . route('ordenCompra/fncOcPdf/' . $aryLoop['nIdOrdenCompra']) . '"   title="Ver PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';
                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';

                    $sLinkCambiarEJ   = '<a onclick="' . $sActionEstadoEJ . '" href="javascript:;"   title="' . $sTitleCEJ . '" class="text-primary font-22 px-1"><i class="material-icons">' . $sIconEJ . '</i> </a>';


                    # Voy a editar  o eliminar siempre y cuando sea Orden de compra y procesado se 0 o sea un gasto y sea pendiente 

                    if (($aryLoop["nTipo"] == $nTipoOrdenCompra && $aryLoop["nProcesado"] == 0) || ($aryLoop["nTipo"] == $nTipoGasto && $aryLoop["nEjecutado"] == 0)) {

                        $sLinkEdit    = '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>';
                        $sLinkDelete  = '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>';
                    } else {
                        $sLinkEdit    = '';
                        $sLinkDelete  = '';
                    }

 
                    $aryDetalle      = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $aryLoop['nIdOrdenCompra']]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;


                    $nTotalItem = 0;

                    if (fncValidateArray($aryDetalle)) {
                        foreach ($aryDetalle as $nKey => $aryDet) {
                            $nTotalItem     += $aryDet["nPrecio"] * $aryDet["nCantidad"];
                            $nTotalCantidad += $aryDet["nCantidad"];
                            $sDetalle       .= $aryDet["sProducto"] . " |  " . nf($aryDet["nPrecio"]) . " x " . $aryDet["nCantidad"] . "<br>";
                        }
                    }

                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkPDF . '
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"              => $sAcciones,
                        "nItem"                  => sp($nKey + 1, 4),
                        "sCaja"                  => strup($aryLoop["sCaja"]),
                        "nIdOrdenCompraFormat"   => sp($aryLoop["nIdOrdenCompra"]),
                        "sDescripcion"           => $aryLoop["sDescripcion"],
                        "dFechaCreacion"         => $aryLoop["dFechaCreacion"],
                        "sDetalle"               => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                        "sResponsable"           => strup($aryLoop["sResponsable"]),
                        "nTotal"                 => nf($nTotalItem, true),
                        "sProcesado"             => $aryLoop["nProcesado"] == 1 ? "SI" : "NO",
                        "sEstado"                => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sEjecutado"             => ($aryLoop["nEjecutado"] == 1 ? "EJECUTADO" : "PLANIFICADO") . $sLinkCambiarEJ,
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarOrdenCompra()
    {
        try {
            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdCaja            = isset($_POST['nIdCaja']) ? $_POST['nIdCaja'] : null;

            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $dFechaOrdenCompra  = isset($_POST['dFechaOrdenCompra']) ? $_POST['dFechaOrdenCompra'] : null;
            $nIdProveedor       = isset($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : null;  

            $nProcesado         = isset($_POST['nProcesado']) ? $_POST['nProcesado'] : null; # Sirve como flag para validar si esque la orden de compra ha ingresado al Almacen
            $aryDetalle         = isset($_POST['aryDetalle']) ? $_POST['aryDetalle'] : null;
            $nTipoMoneda        = isset($_POST['nTipoMoneda']) ? $_POST['nTipoMoneda'] : null;
            $nTipo              = isset($_POST['nTipo']) ? $_POST['nTipo'] : null;
            $nEjecutado         = isset($_POST['nEjecutado']) ? $_POST['nEjecutado'] : null;  # Sirve como flag para validar la orden a sido ejecutada o planificada
            $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            $nSubTotal          = isset($_POST['nSubTotal']) ? $_POST['nSubTotal'] : 0;
            $nIgv               = isset($_POST['nIgv']) ? $_POST['nIgv'] : 0;
            $nTotal             = isset($_POST['nTotal']) ? $_POST['nTotal'] : 0;


            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nTipo) || is_null($nEjecutado)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $nIdOrdenCompraNew = null;

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdResponsable = $user["nIdRol"] == $this->fncGetVarConfig("nIdRolAdmin") ? $user["nIdUsuario"] : $user["nIdEmpleado"];


            // Crear
            if ($nIdRegistro == 0) {
                $nIdOrdenCompraNew = $this->ordenCompra->fncGrabarOrdenCompra(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCaja,
                    $nIdResponsable,
                    $sDescripcion,
                    $dFechaOrdenCompra,
                    $nProcesado,
                    $nTipoMoneda,
                    $nTipo,
                    $nEjecutado,
                    $nSubTotal,
                    $nIgv,
                    $nTotal,
                    $nIdProveedor,
                    $nEstado
                );

                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {
                        $this->ordenCompra->fncGrabarOrdenCompraDetalle(
                            $nIdOrdenCompraNew,
                            $aryLoop["nIdProducto"],
                            ($aryLoop["nIdProveedor"] == 0 ? null : $aryLoop["nIdProveedor"]),
                            $aryLoop["nCantidad"],
                            $aryLoop["nPrecio"],
                            $aryLoop["nIdUnidadMedida"],
                            $nEstado
                        );
                    }
                }
            } else {

                //Actualizar
                $this->ordenCompra->fncActualizarOrdenCompra(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCaja,
                    $nIdResponsable,
                    $sDescripcion,
                    $dFechaOrdenCompra,
                    $nProcesado,
                    $nTipoMoneda,
                    $nTipo,
                    $nEjecutado,
                    $nSubTotal,
                    $nIgv,
                    $nTotal,
                    $nIdProveedor,
                    $nEstado
                );

                $this->ordenCompra->fncEliminarOrdenCompraDetalleByIdOrdenCompra($nIdRegistro);

                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {
                        $this->ordenCompra->fncGrabarOrdenCompraDetalle(
                            $nIdRegistro,
                            $aryLoop["nIdProducto"],
                            ($aryLoop["nIdProveedor"] == 0 ? null : $aryLoop["nIdProveedor"]),
                            $aryLoop["nCantidad"],
                            $aryLoop["nPrecio"],
                            $aryLoop["nIdUnidadMedida"],
                            $nEstado
                        );
                    }
                }
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Orden de compra exitosamente...' : 'Orden de compra exitosamente...';

            $this->json(array("success" => $sSuccess,  "nIdOrdenCompraNew" => $nIdOrdenCompraNew));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarOrdenCompra()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData    = $this->ordenCompra->fncObtenerOrdenCompra(["nIdOrdenCompra" => $nIdRegistro]);
            $aryDetalle = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $nIdRegistro]);

            $this->json(array(
                "success"    => true,
                "aryData"    => fncValidateArray($aryData) ? $aryData[0] : null,
                "aryDetalle" => $aryDetalle
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarOrdenCompra()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $this->ordenCompra->fncEliminarOrdenCompra($nIdRegistro);
            $this->json(array("success" => 'Orden de compra eliminada exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncObtenerOC()
    {
        try {
            $nProcesado                     = isset($_POST['nProcesado']) ? $_POST['nProcesado'] : null;
            $nTipo                          = isset($_POST['nTipo']) ? $_POST['nTipo'] : null;
            $nEstadoRegistroDocumentos      = isset($_POST['nEstadoRegistroDocumentos']) ? $_POST['nEstadoRegistroDocumentos'] : null;

            
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            if (is_null($nTipo)) {
                $this->exception('Error. No se enviado el tipo de registro una orden de compra o un gasto. Por favor verifique o solicite asistencia.');
            }

            // Valida valores del formulario
            $aryData = $this->ordenCompra->fncObtenerOrdenCompra(["nIdSede" => $user["nIdSede"], "nTipo" => $nTipo, "nProcesado" => $nProcesado , "nEstadoRegistroDocumentos" => $nEstadoRegistroDocumentos]);
            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncOcPdf($nIdOrdenCompra)
    {
        try {
            $aryOc   = $this->ordenCompra->fncObtenerOrdenCompra(["nIdOrdenCompra" => $nIdOrdenCompra]);

            if (!fncValidateArray($aryOc)) {
                $this->exception("Error. No se encontro datos sobre la orden de compra quizas se se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryOc        = $aryOc[0];

            $aryOcDetalle = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $nIdOrdenCompra]);

            if (!fncValidateArray($aryOcDetalle)) {
                $this->exception("Error. No se encontro datos sobre el detalle de la orden de compra problablemente se haya eliminado o no exista. Porfavor verifique.");
            }


            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryOc["nIdSede"]]);

            if (!fncValidateArray($arySede)) {
                $this->exception("Error. No se encontro datos de la sede problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $arySede    = $arySede[0];

            ob_start();

            $nTipoOrdenCompra = $this->fncGetVarConfig("nTipoOrdenCompra");

            $this->view("admin/pdf-ordencompra", [
                "sTitulo"           => $aryOc["nTipo"] == $nTipoOrdenCompra ? "ORDEN DE COMPRA" : "GASTO",
                "aryOc"             => $aryOc,
                "aryOcDetalle"      => $aryOcDetalle,
                "arySede"           => $arySede,
            ]);

            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new Mpdf([]);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncObtenerDataReporte()
    {
        try {

            // Valida valores del formulario

            $aryProductos     = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $aryIdsOC         = isset($_POST['aryIdsOC']) ? $_POST['aryIdsOC'] : null;
            $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $nProcesado       = isset($_POST['nProcesado']) ? $_POST['nProcesado'] : null;
            $nTipo            = isset($_POST['nTipo']) ? $_POST['nTipo'] : null;
            $nEjecutado       = isset($_POST['nEjecutado']) ? $_POST['nEjecutado'] : null;

            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            if (is_null($nTipo)) {
                $this->exception("Error.No existe un tipo.Porfavor verifique o solicite asistencia");
            }


            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionCompra)) ? null : $user["nIdEmpleado"];

            $nTipoOrdenCompra = $this->fncGetVarConfig("nTipoOrdenCompra");
            $sNombreReporte = "";

            if ($nTipo  ==  $nTipoOrdenCompra) {
                $sNombreReporte = "REPORTE ORDEN DE COMPRA ";
            } else {
                $sNombreReporte = "REPORTE GASTOS ";
            }

            $aryData  = $this->ordenCompra->fncObtenerOrdenCompra([
                "nIdSede"         => $user["nIdSede"],
                "nIdResponsable"  => $nIdResponsable,
                "aryIdsOC"        => $aryIdsOC,
                "aryProductos"    => $aryProductos,
                "dFechaInicio"    => $dFechaInicio,
                "dFechaFin"       => $dFechaFin,
                "nProcesado"      => $nProcesado,
                "nTipo"           => $nTipo,
                "nEjecutado"      => $nEjecutado
            ]);

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionCompra);

            if (strlen($dFechaInicio) > 0 &&  strlen($dFechaFin) > 0) {
                if ($dFechaInicio == $dFechaFin) {
                    $sTitulo = $sNombreReporte . ' DEL: ' . $dFechaInicio;
                } else {
                    $sTitulo = $sNombreReporte . ' DEL:   ' . $dFechaInicio . ' AL ' . $dFechaFin;
                }
            } else {
                $sTitulo =  $sNombreReporte;
            }

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $nKey => $aryLoop) {
                    $sLinkPDF        = '<a target="_blank" href="' . route('ordenCompra/fncOcPdf/' . $aryLoop['nIdOrdenCompra']) . '"   title="Ver PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';
                    $aryDetalle      = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $aryLoop['nIdOrdenCompra']]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;


                    $nTotalItem = 0;

                    if (fncValidateArray($aryDetalle)) {
                        foreach ($aryDetalle as $nKey => $aryDet) {
                            $nTotalItem     += $aryDet["nPrecio"] * $aryDet["nCantidad"];
                            $nTotalCantidad += $aryDet["nCantidad"];
                            $sDetalle       .= strup($aryDet["sProducto"]) . " |  " . nf($aryDet["nPrecio"]) . " x " . $aryDet["nCantidad"] . "<br>";
                        }
                    }

                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                    $sAcciones = '<div class="content-acciones">
                                      ' . $sLinkPDF . '                            
                                  </div>';

                    $aryRows[] = [
                        "sAcciones"              => $sAcciones,
                        "nItem"                  => sp($nKey + 1, 4),
                        "nIdOrdenCompraFormat"   => sp($aryLoop["nIdOrdenCompra"]),
                        "sDescripcion"           => $aryLoop["sDescripcion"],
                        "dFechaCreacion"         => $aryLoop["dFechaCreacion"],
                        "sDetalle"               => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                        "sResponsable"           => strup($aryLoop["sResponsable"]),
                        "nTotal"                 => nf($nTotalItem),
                        "sProcesado"             => $aryLoop["nProcesado"] == 1 ? "SI" : "NO",
                        "sEjecutadoTexto"        => $aryLoop["nEjecutado"] == 1 ? "EJECUTADO" : "PLANIFICAR",
                        "sEstado"                => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json(["success" => true, "sTitulo" => $sTitulo, "aryData" => $aryRows]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncExportarExcel()
    {
        try {
            $aryProductos     = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $aryIdsOC         = isset($_POST['aryIdsOC']) ? $_POST['aryIdsOC'] : null;
            $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $nProcesado       = isset($_POST['nProcesado']) ? $_POST['nProcesado'] : null;
            $nTipo            = isset($_POST['nTipo']) ? $_POST['nTipo'] : null;


            //$nIdEmpleado   = $this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"] ? null : $user["nIdEmpleado"];
            $user            = $this->session->get("user");
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionCompra)) ? null : $user["nIdEmpleado"];

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            if (is_null($nTipo)) {
                $this->exception("Error.No existe un tipo.Porfavor verifique o solicite asistencia");
            }

            $aryData  = $this->ordenCompra->fncObtenerOrdenCompra([
                "nIdResponsable"  => $nIdResponsable,
                "nIdSede"         => $user["nIdSede"],
                "aryIdsOC"        => $aryIdsOC,
                "aryProductos"    => $aryProductos,
                "dFechaInicio"    => $dFechaInicio,
                "dFechaFin"       => $dFechaFin,
                "nProcesado"      => $nProcesado,
                "nTipo"           => $nTipo
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlOrdenCompra);

            $nTipoOrdenCompra = $this->fncGetVarConfig("nTipoOrdenCompra");
            $sNombreReporte = "";

            if ($nTipo  ==  $nTipoOrdenCompra) {
                $sNombreLink = "ReporteCompras";
                $sNombreReporte = "REPORTE ORDEN DE COMPRA ";
            } else {
                $sNombreLink = "ReporteGastos";
                $sNombreReporte = "REPORTE GASTOS ";
            }


            if (strlen($dFechaInicio) > 0 &&  strlen($dFechaFin) > 0) {
                if ($dFechaInicio == $dFechaFin) {
                    $sTitulo =  $sNombreReporte . 'DEL: ' . $dFechaInicio;
                } else {
                    $sTitulo = $sNombreReporte .  '   DEL:   ' . $dFechaInicio . ' AL ' . $dFechaFin;
                }
            } else {
                $sTitulo =  $sNombreReporte;
            }


            $objExcel = new Excel();

            $nRow = 1;

            $objExcel->sheet->mergeCells('A' . $nRow . ':H' . $nRow);
            $objExcel->sheet->setCellValue('A' . $nRow, "FECHA : " . date("d/m/Y") . " - HORA : " . date("H:i:s"));
            $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

            $nRow++;

            $objExcel->sheet->mergeCells('A' . $nRow . ':H' . $nRow);
            $objExcel->sheet->setCellValue('A' . $nRow, $sTitulo);
            $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

            $nRow++;

            $nTotalOC  = 0;
            if (fncValidateArray($aryData)) {
                $aryHeader  = ['Item', 'Descripcion', 'Unidad de medida', 'Proveedor', 'Fecha', 'Precio', 'Cantidad', 'Total'];
                $aryCols    = ['nItem',  'sProducto', 'sUnidadMedida', 'sProveedor', 'dFechaCreacion', 'nPrecio', 'nCantidad', 'nTotal'];

                foreach ($aryData as $nKey => $aryLoop) {

                    // Header

                    $nRow++;
                    $nRow++;

                    $sTitulo = " ORDEN DE COMPRA N° " .  sp($aryLoop["nIdOrdenCompra"]) . " - DESCRIP :  " . $aryLoop["sDescripcion"];
                    $objExcel->sheet->mergeCells('A' . $nRow . ':H' . $nRow);
                    $objExcel->sheet->setCellValue('A' . $nRow, $sTitulo);
                    $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader);


                    $nRow++;

                    foreach ($aryHeader as $nKeyLetra => $sValor) {
                        $objExcel->sheet->setCellValue($objExcel->aryL[$nKeyLetra] . $nRow, $sValor);
                        $objExcel->sheet->getStyle($objExcel->aryL[$nKeyLetra] . $nRow)->applyFromArray($objExcel->styleArrayRows);
                        $objExcel->sheet->getStyle($objExcel->aryL[$nKeyLetra] . $nRow)->getFont()->setBold(true);;
                    }

                    // Fin de header


                    $aryDataDetalle = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $aryLoop["nIdOrdenCompra"]]);

                    // Cuerpo
                    $nRow++;

                    $nSubtotalItem = 0;

                    if (fncValidateArray($aryDataDetalle)) {
                        foreach ($aryDataDetalle as $keyLoop => $aryDetalle) {
                            foreach ($aryCols as $nKeyCol => $sCol) {
                                switch ($sCol) {
                                    case 'nItem':
                                        $objExcel->sheet->setCellValue($objExcel->aryL[$nKeyCol] . $nRow, sp($keyLoop + 1, 4));
                                        break;
                                    case 'nTotal':
                                        $nTotalItem      = $aryDetalle["nPrecio"] * $aryDetalle["nCantidad"];
                                        $nSubtotalItem   += $nTotalItem;
                                        $objExcel->sheet->setCellValue($objExcel->aryL[$nKeyCol] . $nRow, nf($nTotalItem, true));
                                        break;
                                    default:
                                        $objExcel->sheet->setCellValue($objExcel->aryL[$nKeyCol] . $nRow, $aryDetalle[$sCol]);
                                        break;
                                }
                                $objExcel->sheet->getStyle($objExcel->aryL[$nKeyCol] . $nRow)->applyFromArray($objExcel->styleArrayRows);
                            }
                            $nRow++;
                        }
                    }
                    // Fin de cuerpo

                    // Footer


                    $nIgvItem      = $nSubtotalItem * (IGV / 100);
                    $nSubtotalItem = $nSubtotalItem - $nIgvItem;
                    $nTotalItem    = $nSubtotalItem + $nIgvItem;


                    $objExcel->sheet->mergeCells('A' . $nRow . ':G' . $nRow);
                    $objExcel->sheet->setCellValue('A' . $nRow, ' SUBTOTAL ');
                    $objExcel->sheet->setCellValue('H' . $nRow, nf($nSubtotalItem, true));
                    $objExcel->sheet->getStyle('A' . $nRow . ':H' . $nRow)->applyFromArray($objExcel->styleArrayRows);

                    $nRow++;

                    $objExcel->sheet->mergeCells('A' . $nRow . ':G' . $nRow);
                    $objExcel->sheet->setCellValue('A' . $nRow, ' IGV ');
                    $objExcel->sheet->setCellValue('H' . $nRow, nf($nIgvItem, 2));
                    $objExcel->sheet->getStyle('A' . $nRow . ':H' . $nRow)->applyFromArray($objExcel->styleArrayRows);

                    $nRow++;

                    $objExcel->sheet->mergeCells('A' . $nRow . ':G' . $nRow);
                    $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL ');
                    $objExcel->sheet->setCellValue('H' . $nRow, nf($nTotalItem, true));
                    $objExcel->sheet->getStyle('A' . $nRow . ':H' . $nRow)->applyFromArray($objExcel->styleArrayRows);

                    $nTotalOC += $nTotalItem;
                }

                $nRow++;
                $nRow++;
                $objExcel->sheet->mergeCells('A' . $nRow . ':G' . $nRow);
                $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL GENERAL ');
                $objExcel->sheet->setCellValue('H' . $nRow, nf($nTotalOC, true));
                $objExcel->sheet->getStyle('A' . $nRow . ':H' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

                foreach (range('A', 'H') as $columnID) {
                    $objExcel->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Fin de footer
                $sLink  =  $sNombreLink . date("d-m-Y_H_i_s") . ".xlsx";
                $writer = new Xlsx($objExcel->spreadsheet);
                $writer->save((ROOTPATHRESOURCE . "/docs/" . $sLink));

                $this->json(array("success" => true, "sUrl" => routeDoc($sLink)));
            } else {
                $this->exception("Error no se encontro data alguna . Porfavor verifique");
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }



    public function fncImprimirOrdenAndGasto($nIdOrdenCompra, $nIdGasto)
    {

        try {

            # Valida los datos
            if (is_null($nIdOrdenCompra) || is_null($nIdGasto)) {
                $this->exception("Error. Existen valores nulos. Porfavor verifique.");
            }


            # Obtiene datos de la Orden de compra

            $aryOc   = $this->ordenCompra->fncObtenerOrdenCompra(["nIdOrdenCompra" => $nIdOrdenCompra]);

            if (!fncValidateArray($aryOc)) {
                $this->exception("Error. No se encontro datos sobre la orden de compra quizas se se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryOc  = $aryOc[0];

            $aryOcDetalle = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $nIdOrdenCompra]);

            if (!fncValidateArray($aryOcDetalle)) {
                $this->exception("Error. No se encontro datos sobre el detalle de la orden de compra problablemente se haya eliminado o no exista. Porfavor verifique.");
            }


            # Obtiene la sede 

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryOc["nIdSede"]]);

            if (!fncValidateArray($arySede)) {
                $this->exception("Error. No se encontro datos de la sede problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $arySede    = $arySede[0];

            # Obtiene Gastos


            $aryGasto   = $this->ordenCompra->fncObtenerOrdenCompra(["nIdOrdenCompra" => $nIdGasto]);

            if (!fncValidateArray($aryOc)) {
                $this->exception("Error. No se encontro datos sobre el gasto quizas se se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryGasto  = $aryGasto[0];

            $aryGastoDetalle = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $nIdGasto]);

            if (!fncValidateArray($aryGastoDetalle)) {
                $this->exception("Error. No se encontro datos sobre el detalle del gasto problablemente se haya eliminado o no exista. Porfavor verifique.");
            }


            ob_start();

            $this->view("admin/pdf-ordencompra-gasto", [
                "sTitulo"           => "ORDEN DE COMPRA Y GASTO",
                "arySede"           => $arySede,
                "aryOc"             => $aryOc,
                "aryOcDetalle"      => $aryOcDetalle,
                "aryGasto"          => $aryGasto,
                "aryGastoDetalle"   => $aryGastoDetalle,
            ]);

            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new Mpdf([]);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    // public function fncGetTotalesCompras($aryProductos = null, $dFechaInicio = null, $dFechaFin = null)
    // {
    //     try {


    //         $user            = $this->session->get("user");
    //         $nIdEmpleado     = $this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"] ? null : $user["nIdEmpleado"];


    //         if (is_null($user)) {
    //             $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
    //         }


    //         if (is_null($aryProductos)  && is_null($dFechaInicio) && is_null($dFechaFin)) {

    //             $aryData  = $this->ordenCompra->fncObtenerCompras([
    //                 "nIdEmpleado"    => $nIdEmpleado,
    //                 "nIdSede"        => $user["nIdSede"],
    //                 "dFechaCreacion" => date("d/m/Y")
    //             ]);
    //         } else {

    //             $aryData  = $this->ordenCompra->fncObtenerCompras([
    //                 "nIdEmpleado"     => $nIdEmpleado,
    //                 "nIdSede"         => $user["nIdSede"],
    //                 "aryProductos"    => $aryProductos,
    //                 "dFechaInicio"    => $dFechaInicio,
    //                 "dFechaFin"       => $dFechaFin
    //             ]);
    //         }


    //         if (fncValidateArray($aryData)) {

    //             $nTotal   = 0;

    //             foreach ($aryData as $keyLoop => $aryLoop) {
    //                 $nTotalItem  = $aryLoop["nPrecio"] * $aryLoop["nCantidad"];
    //                 $nTotal      += $nTotalItem;
    //             }

    //             return $nTotal;
    //         } else {
    //             return 0;
    //         }
    //     } catch (Exception $ex) {
    //         echo $ex->getMessage();
    //     }
    // }

    public function fncGetTotalesPedidosCompras()
    {
        try {
            $aryProductos     = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $user             = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            $aryData  = $this->ordenCompra->fncObtenerOrdenCompra([
                "nIdSede"         => $user["nIdSede"],
                "dFechaInicio"    => $dFechaInicio,
                "dFechaFin"       => $dFechaFin
            ]);


            $pedidosController  = new PedidosController();
            $nTotalPedidos      = $pedidosController->fncGetTotalesPedidos($aryProductos, $dFechaInicio, $dFechaFin);
            $nTotal             = 0;
            $sTitulo            = "";

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $keyLoop => $aryLoop) {
                    $nTotalItem = $aryLoop["nPrecio"] * $aryLoop["nCantidad"];
                    $nTotal     += $nTotalItem;
                }


                $sTitulo  = !is_null($dFechaInicio) && !is_null($dFechaFin) ? " COMPARATIVOS " . date("d/m/Y", strtotime($dFechaInicio)) . " AL " . $dFechaFin  : " COMPARATIVO DEL " . date("d/m/Y");
            }

            $aryIndicativos = [
                "sTitulo"           => $sTitulo,
                "nTotalGastos"      => nf($nTotal),
                "nTotalPedidos"     => nf($nTotalPedidos),
                "nDiferencia"       => $nTotalPedidos > 0 ? nf($nTotalPedidos - $nTotal) : nf(0),
            ];

            $this->json(array("success" => true, "aryIndicativos" => $aryIndicativos));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncCambiarEstadoEjecutado()
    {
        try {

            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nNuevoEstado       = isset($_POST['nNuevoEstado']) ? $_POST['nNuevoEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nNuevoEstado)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $this->ordenCompra->fncActualizarEjecutado($nIdRegistro, $nNuevoEstado);

            $sSuccess =  'Cambio de estado ejecutado exitosamente....';

            $this->json(array("success" => $sSuccess));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
