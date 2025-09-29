<?php

namespace Application\Controllers;

use DateTime;
use Exception;
use Mpdf\Mpdf;
use DatePeriod;
use DateInterval;
use Application\Libs\Session;
use Application\Models\Sedes;
use Application\Models\Ubigeo;
use Application\Models\Pedidos;
use Application\Models\Clientes;
use Application\Models\Empresas;
use Application\Models\Empleados;
use Application\Models\Productos;
use Application\Models\Categorias;
use Application\Models\Movimientos;
use Application\Models\OrdenCompra;
use Application\Models\MetodosPagos;
use Application\Models\CatalogoTabla;
use Application\Models\MetodosEnvios;
use Application\Models\UnidadMedidas;
use Application\Models\UbicacionAlmacen;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Application\Core\Controller as Controller;

class MovimientosController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $catalogotabla;
    public $categorias;
    public $productos;
    public $movimientos;
    public $sedes;
    public $empresas;
    public $pedidos;

    public $ordenCompra;
    public $sUrlNotaIngreso  = "nota-ingreso";
    public $sUrlNotaSalida   = "nota-salida";
    public $sUrlEquivalencia = "equivalencia";


    public $sReporteMovimientoIngreso   = "reporte-movimiento-ingreso";
    public $sReporteMovimientoSalida    = "reporte-movimiento-salida";
    public $sReporteMovimientos         = "reporte-movimientos";


    public $unidadMedidas;
    public $ubicacionAlmacen;


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogotabla    = new CatalogoTabla();
        $this->categorias       = new Categorias();
        $this->productos        = new Productos();
        $this->movimientos      = new Movimientos();
        $this->sedes            = new Sedes();
        $this->ordenCompra      = new OrdenCompra();
        $this->empresas         = new Empresas();
        $this->unidadMedidas    = new UnidadMedidas();
        $this->pedidos          = new Pedidos();
        $this->ubicacionAlmacen = new UbicacionAlmacen();

        $this->session->init();
    }


    public function notaIngreso()
    {
        try {

            $this->authAdmin($this->session);
            $user           = $this->session->get('user');
            $nEntrada       = $this->fncGetVarConfig("nEntrada");
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlNotaIngreso)) ? null : $user["nIdEmpleado"];

            // Ids Filtros
            $aryMov = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nEntrada,
                "nIdResponsable"      => $nIdResponsable,
                "nMovimientoInterno"  => "0"
            ]);

            $aryIdFilter = fncValidateArray($aryMov) ? array_unique(array_column($aryMov, "nIdMovimiento")) : [];


            // Ids Filtros

            $aryDetalleMov = $this->movimientos->fncGetMovimientosDetalle([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nEntrada,
                "nMovimientoInterno"  => "0"
            ]);


            $aryIdProductosFilter = fncValidateArray($aryDetalleMov) ? array_unique(array_column($aryDetalleMov, "nIdProducto")) : [];

            $aryProductosFilter   = fncValidateArray($aryIdProductosFilter) ? $this->productos->fncGetProductos(["aryProductos" => $aryIdProductosFilter]) : [];

            // var_dump($aryProductosFilter);
            // exit;
            $aryProductos = $this->productos->fncGetProductos([
                "nIdSede" => $user["nIdSede"],
                "nEstado" => 1
            ]);

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];


            $this->view('admin/nota-ingreso', [
                'sTitulo'                    => 'Nota de ingreso',
                'user'                       => $user,
                'arySede'                    => $arySede,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->sUrlNotaIngreso) ? 1 : 0,
                "aryProductos"               => $aryProductos,
                "aryProductosFilter"         => $aryProductosFilter,
                "aryIdFilter"                => $aryIdFilter,
                "aryUbicacionAlmacen"        => $this->ubicacionAlmacen->fncGetUA(["nIdSede" => $user["nIdSede"]]),
                'aryTipoMovimiento'          => $this->catalogotabla->fncListado("TIPO_MOVIMIENTO"),
                'nEntrada'                   => $nEntrada,
                'nTipoOrdenCompra'           => $this->fncGetVarConfig("nTipoOrdenCompra")
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function notaSalida()
    {
        try {
            $this->authAdmin($this->session);

            $user           = $this->session->get('user');
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlNotaSalida)) ? null : $user["nIdEmpleado"];
            $nSalida        = $this->fncGetVarConfig("nSalida");


            // Ids Filtros
            $aryMov = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nSalida,
                "nIdResponsable"      => $nIdResponsable,
                "nMovimientoInterno"  => "0"
            ]);

            $aryIdFilter = fncValidateArray($aryMov) ? array_unique(array_column($aryMov, "nIdMovimiento")) : [];


            // Ids Filtros

            $aryDetalleMov = $this->movimientos->fncGetMovimientosDetalle([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nSalida,
                "nMovimientoInterno"  => "0"

            ]);


            $aryIdProductosFilter = fncValidateArray($aryDetalleMov) ? array_unique(array_column($aryDetalleMov, "nIdProducto")) : [];

            $aryProductosFilter   = fncValidateArray($aryIdProductosFilter) ? $this->productos->fncGetProductos(["aryProductos" => $aryIdProductosFilter]) : [];

            // var_dump($aryProductosFilter);
            // exit;
            $aryProductos = $this->productos->fncGetProductos([
                "nIdSede" => $user["nIdSede"],
                "nEstado" => 1
            ]);

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/nota-salida', [
                'sTitulo'                    => 'Nota de de salida',
                'user'                       => $user,
                'arySede'                    => $arySede,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->sUrlNotaSalida) ? 1 : 0,
                "aryProductos"               => $aryProductos,
                "aryProductosFilter"         => $aryProductosFilter,
                "aryIdFilter"                => $aryIdFilter,
                'aryTipoMovimiento'          => $this->catalogotabla->fncListado("TIPO_MOVIMIENTO"),
                'nSalida'                    => $nSalida
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function equivalencia()
    {
        $this->authAdmin($this->session);

        $user = $this->session->get('user');

        try {
            $this->view('admin/equivalencia', [
                'sTitulo'          => 'Equivalencia',
                'user'             => $user,
                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdSede" => $user["nIdSede"]]),
                'bShowMenu'        => true,
                'aryProductosEQ'   => $this->productos->fncGetProductos(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"], 'nEquivalencia' => 1, 'nStockActual' => ' > 0 ']),
                'aryProductos'     => $this->productos->fncGetProductos(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlEquivalencia) ? 1 : 0
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }



    public function fncPopulate()
    {
        try {
            $aryIdMovimiento   = isset($_POST['aryIdMovimiento']) ? $_POST['aryIdMovimiento'] : null;
            $aryProductos      = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $dFechaInicio      = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin         = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $nEntradaSalida    = isset($_REQUEST['nEntradaSalida']) ? $_REQUEST['nEntradaSalida'] : null;

            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            if (is_null($nEntradaSalida)) {
                $this->exception("Error. No se especifico un tipo de movimiento .Porfavor verifique o solicite asistencia");
            }

            // Estos movimientos no tiene porque verlo el usuario son uso del sistema interno
            // $aryEntradaEquivalencia  = $this->productos->fncGetHistorialEquivalencia(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            // $aryIdMovimientoNot      = fncValidateArray($aryEntradaEquivalencia) ?  array_unique(array_column($aryEntradaEquivalencia, "nIdMovimientoEntrada")) : null;


            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlNotaIngreso)) ? null : $user["nIdEmpleado"];

            if (is_null($aryIdMovimiento) && is_null($aryProductos)  && is_null($dFechaInicio) && is_null($dFechaFin)) {
                $aryData  = $this->movimientos->fncGetMovimientos([
                    "nIdSede"             => $user["nIdSede"],
                    "nEntradaSalida"      => $nEntradaSalida,
                    "nIdResponsable"      => $nIdResponsable,
                    "nMovimientoInterno"  => "0",
                ]);
            } else {
                $aryData  = $this->movimientos->fncGetMovimientos([
                    "nIdSede"             => $user["nIdSede"],
                    "nEntradaSalida"      => $nEntradaSalida,
                    "aryIdMovimiento"     => $aryIdMovimiento,
                    "aryProductos"        => $aryProductos,
                    "dFechaInicio"        => $dFechaInicio,
                    "dFechaFin"           => $dFechaFin,
                    "nIdResponsable"      => $nIdResponsable,
                    "nMovimientoInterno"  => "0",
                ]);
            }



            $bIsAdmin   = $this->fncIsAdmin($user["nIdRol"], $this->sUrlNotaIngreso);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {


                    # Este flag sive para validar si esque algun producto del moviemiento se ha vendido 
                    $aryDataExisteMovimientoPedido = $this->movimientos->fncVerificarMovimientoPedido($aryLoop['nIdMovimiento']);
                    $bExisteMovPed                 = fncValidateArray($aryDataExisteMovimientoPedido);

                    $sLinkPDF          = '<a target="_blank" href="' . route('movimientos/fncMovimientoPdf/' . $aryLoop['nIdMovimiento']) . '"   title="Ver pdf" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';
                    $sActionShow       = "fncMostrarMov(" . $aryLoop['nIdMovimiento'] . ", 'ver' );";
                    $sActionEdit       = "fncMostrarMov(" . $aryLoop['nIdMovimiento'] . ", 'editar' );";
                    $sActionEliminar   = "fncEliminarMov(" . $aryLoop['nIdMovimiento'] . ");";

                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = !$bExisteMovPed ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>' : '';
                    $sLinkDelete = !$bExisteMovPed ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>' : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkPDF . '
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';


                    $aryDataDetalles = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop['nIdMovimiento']]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {
                            $nTotalCantidad +=  $aryDet["nCantidad"];
                            $sDetalle       .= $aryDet["sProducto"] . " |  " . nf($aryDet["nPrecio"]) . " | " . $aryDet["nCantidad"] . "<br>";
                        }
                    }

                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                    $aryRows[] = [
                        "sAcciones"        => $sAcciones,
                        "nIdMovimiento"    => sp($aryLoop["nIdMovimiento"]),
                        "sDescripcion"     => strup($aryLoop["sDescripcion"]),
                        "sResponsable"     => strup($aryLoop["sResponsable"]),
                        "sEntradaSalida"   => $aryLoop["nEntradaSalida"] == 1  ? "ENTRADA" : "SALIDA",
                        "sTipoMovimiento"  => strup($aryLoop["sTipoMovimiento"]),
                        "dFechaCreacion"   => $aryLoop["dFechaCreacion"],
                        "sDetalle"         => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateReporteEntrada()
    {
        try {
            $aryIdMovimiento   = isset($_POST['aryIdMovimiento']) ? $_POST['aryIdMovimiento'] : null;
            $aryProductos      = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $dFechaInicio      = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin         = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");
            $nEntrada     = $this->fncGetVarConfig("nEntrada");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            $aryData  = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nEntrada,
                "aryIdMovimiento"     => $aryIdMovimiento,
                "aryProductos"        => $aryProductos,
                "dFechaInicio"        => $dFechaInicio,
                "dFechaFin"           => $dFechaFin,
                # "nMovimientoInterno"  => "0",
            ]);

            $bIsAdmin = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {


                    $aryDataDetalles = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop['nIdMovimiento'], 'aryProductos' => $aryProductos]);

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {

                            $aryRows[] = [
                                "nIdMovimiento"     => sp($aryLoop["nIdMovimiento"]),
                                "sLoginResponsable" => $aryLoop["sLoginResponsable"],
                                "sProducto"         => strup($aryDet["sProducto"] . (strlen($aryDet["sCodigoInternoProducto"]) > 0 ? " - " . $aryDet["sCodigoInternoProducto"] : "")),
                                "nCantidad"         => $aryDet["nCantidad"],
                                "sUbicacionAlmacen" => $aryDet["sNombreUbicacionAlmacen"] . (strlen($aryDet["sCodigoUbicacionAlmacen"]) > 0 ? " - " . $aryDet["sCodigoUbicacionAlmacen"] : ""),
                                "sEntradaSalida"    => $aryLoop["nEntradaSalida"] == 1  ? "ENTRADA" : "SALIDA",
                                "dFechaCreacion"    => $aryLoop["dFechaCreacion"],
                                "sUnidadMedida"     => $aryDet["sUnidadMedida"]
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


    public function fncPopulateReporteSalida()
    {
        try {
            $aryIdMovimiento   = isset($_POST['aryIdMovimiento']) ? $_POST['aryIdMovimiento'] : null;
            $aryProductos      = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $dFechaInicio      = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin         = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");
            $nSalida      = $this->fncGetVarConfig("nSalida");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            $aryData  = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nSalida,
                "aryIdMovimiento"     => $aryIdMovimiento,
                "aryProductos"        => $aryProductos,
                "dFechaInicio"        => $dFechaInicio,
                "dFechaFin"           => $dFechaFin,
                # "nMovimientoInterno"  => "0",
            ]);

            $bIsAdmin = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {


                    $aryDataDetalles = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop['nIdMovimiento'], "aryProductos" => $aryProductos]);

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {

                            $aryRows[] = [
                                "nIdMovimiento"     => sp($aryLoop["nIdMovimiento"]),
                                "sLoginResponsable" => $aryLoop["sLoginResponsable"],
                                "sProducto"         => strup($aryDet["sProducto"]),
                                "nCantidad"         => $aryDet["nCantidad"],
                                "sUbicacionAlmacen" => $aryDet["sNombreUbicacionAlmacen"] . (strlen($aryDet["sCodigoUbicacionAlmacen"]) > 0 ? " - " . $aryDet["sCodigoUbicacionAlmacen"] : ""),
                                "sEntradaSalida"    => $aryLoop["nEntradaSalida"] == 1  ? "ENTRADA" : "SALIDA",
                                "dFechaCreacion"    => $aryLoop["dFechaCreacion"],
                                "sUnidadMedida"     => $aryDet["sUnidadMedida"],
                                "sNombreUbicacionAlmacen" => $aryDet["sNombreUbicacionAlmacen"]
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


    public function fncPopulateReporteMovimientos()
    {
        try {

            $aryProductos      = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $dFechaInicio      = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin         = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user) || is_null($aryProductos) || count($aryProductos) == 0) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            $nEntrada = $this->fncGetVarConfig("nEntrada");
            $nSalida  = $this->fncGetVarConfig("nSalida");

            foreach ($aryProductos as $nKey => $nIdProducto) {

                if ($nIdProducto !== '') {

                    $aryProducto = $this->productos->fncGetProductosDatosBasicos(["nIdProducto" => $nIdProducto])[0];

                    # Obtener todas las entradas del productos en los movimientos segun el rango de fechas 
                    $nEntradas = 0;

                    $aryDataEntrada = $this->movimientos->fncGetMovimientosDetalle([
                        "nIdProducto"         => $nIdProducto,
                        "dFechaInicio"        => $dFechaInicio,
                        "nEntradaSalida"      => $nEntrada,
                        "dFechaFin"           => $dFechaFin,
                    ]);

                    if (fncValidateArray($aryDataEntrada)) {
                        foreach ($aryDataEntrada as $nKeyEntrada => $aryItemEntrada) {
                            $nEntradas += $aryItemEntrada["nCantidad"];
                        }
                    }

                    # Obtener todas las salidas del productos en los movimientos segun el rango de fechas 

                    # Verificamos si el producto a verificar sus salidas es para descomposiion por ejemplo 1 pollo entero tiene descomposoiona 1/4 , 1/2
                    # Entoces sumariamos las salidas de los productos hijos y no del padre como tal 
                    // $aryDescomp = $this->productos->fncGetProductosDescompDet(["nIdProductoPadre" => $aryProducto["nIdProducto"]]);
                    $nSalidas   = 0;


                    // if (fncValidateArray($aryDescomp)) {

                    //     # Obtenemos todos los hijos de ese producto de descompocision
                    //     $aryIdProductoHijo = [];
                    //     foreach ($aryDescomp as $key => $aryD) {
                    //         $aryIdProductoHijo[] = $aryD["nIdProductoHijo"];
                    //     }
                    //     # var_dump($aryIdProductoHijo);

                    //     # Obtenemos todos los movimientos de detalle de esos hijos segun el rando de fechas

                    //     $aryDataSalida = $this->movimientos->fncGetMovimientosDetalle([
                    //         "aryProductos"        => $aryIdProductoHijo,
                    //         "dFechaInicio"        => $dFechaInicio,
                    //         "nEntradaSalida"      => $nSalida,
                    //         "dFechaFin"           => $dFechaFin,
                    //         #"nMovimientoInterno"  => "0",
                    //     ]);

                    //     if (fncValidateArray($aryDataSalida)) {
                    //         foreach ($aryDataSalida as $nKeySalida => $aryItemSalida) {
                    //             $nSalidas += $aryItemSalida["nCantidad"];
                    //         }
                    //     }
                    // } else {
                    // }

                    $aryDataSalida = $this->movimientos->fncGetMovimientosDetalle([
                        "nIdProducto"         => $nIdProducto,
                        "dFechaInicio"        => $dFechaInicio,
                        "nEntradaSalida"      => $nSalida,
                        "dFechaFin"           => $dFechaFin,
                    ]);

                    if (fncValidateArray($aryDataSalida)) {
                        foreach ($aryDataSalida as $nKeySalida => $aryItemSalida) {
                            $nSalidas += $aryItemSalida["nCantidad"];
                        }
                    }




                    $aryRows[] = [
                        "nIdProducto"           => $nIdProducto,
                        "sProducto"             => strup($aryProducto["sDescripcion"] . " - " . $aryProducto["sUnidadMedidaCorto"] . (strlen($aryProducto["sCodigoInterno"]) > 0 ? " - " . $aryProducto["sCodigoInterno"] : "")),
                        "sUnidadMedida"         => $aryProducto["sUnidadMedida"],
                        "sUbicacionAlmacen"     => $aryProducto["sNombreUbicacionAlmacen"],
                        "nEntradas"             => $nEntradas,
                        "nSalidas"              => $nSalidas,
                        "nStockActual"          => $aryProducto["nStockActual"],

                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateReporteMovimientosDetallado()
    {
        try {

            $nIdProducto       = isset($_POST['nIdProducto']) ? $_POST['nIdProducto'] : null;
            $dFechaInicio      = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin         = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            if (is_null($dFechaInicio) ||  is_null($dFechaFin) ||  is_null($nIdProducto)) {
                $this->exception("Error. Se estan enviando valores vacios.Porfavor verifique o solicite asistencia");
            }

            $dFechaInicio = DateTime::createFromFormat('d/m/Y', $dFechaInicio);
            $dFechaFin    = DateTime::createFromFormat('d/m/Y', $dFechaFin);
            $dFechaFin->modify('+1 day');

            $nEntrada = $this->fncGetVarConfig("nEntrada");
            $nSalida  = $this->fncGetVarConfig("nSalida");


            $intervalo = DateInterval::createFromDateString('1 day');
            $periodo = new DatePeriod($dFechaInicio, $intervalo, $dFechaFin);
            $aryProducto = $this->productos->fncGetProductosDatosBasicos(["nIdProducto" => $nIdProducto])[0];

            $nTotalEntradas = 0;
            $nTotalSalidas  = 0;

            foreach ($periodo as $dt) {


                # Obtener todas las entradas del productos en los movimientos segun el rango de fechas 
                $nEntradas = 0;

                $aryDataEntrada = $this->movimientos->fncGetMovimientosDetalle([
                    "nIdProducto"         => $nIdProducto,
                    "dFechaInicio"        => $dt->format("d/m/Y"),
                    "dFechaFin"           => $dt->format("d/m/Y"),
                    "nEntradaSalida"      => $nEntrada,
                ]);

                if (fncValidateArray($aryDataEntrada)) {
                    foreach ($aryDataEntrada as $nKeyEntrada => $aryItemEntrada) {
                        $nEntradas += $aryItemEntrada["nCantidad"];
                    }
                }

                $nTotalEntradas += $nEntradas;

                # Obtener todas las salidas del productos en los movimientos segun el rango de fechas 
                $nSalidas   = 0;

                $aryDataSalida = $this->movimientos->fncGetMovimientosDetalle([
                    "nIdProducto"         => $nIdProducto,
                    "dFechaInicio"        => $dt->format("d/m/Y"),
                    "dFechaFin"           => $dt->format("d/m/Y"),
                    "nEntradaSalida"      => $nSalida,

                ]);

                if (fncValidateArray($aryDataSalida)) {
                    foreach ($aryDataSalida as $nKeySalida => $aryItemSalida) {
                        $nSalidas += $aryItemSalida["nCantidad"];
                    }
                }

                $nTotalSalidas += $nSalidas;

                if($nEntradas > 0 || $nSalidas > 0){
  $aryRows[] = [
                    "nIdProducto"           => $nIdProducto,
                    "dFecha"                => $dt->format("d/m/Y"),
                    "sProducto"             => strup($aryProducto["sDescripcion"]),
                    "sCodigoInterno"        => $aryProducto["sCodigoInterno"],
                    "nEntradas"             => $nEntradas,
                    "nSalidas"              => $nSalidas,
                    "sUnidadMedida"         => $aryProducto["sUnidadMedida"],
                    "sUbicacion"            => $aryProducto["sNombreUbicacionAlmacen"],
                ];
                }

              
            }

            $aryTotales = [
                "nTotalEntradas" => $nTotalEntradas,
                "nTotalSalidas"  => $nTotalSalidas,
                "nStockActual"   => $nTotalEntradas - $nTotalSalidas,
            ];



            $this->json(["success" => true, "aryRows" => $aryRows , "aryTotales" => $aryTotales]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }





    public function reporteMovimientoIngreso()
    {
        try {

            $this->authAdmin($this->session);
            $user           = $this->session->get('user');
            $nEntrada       = $this->fncGetVarConfig("nEntrada");
            //$nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"],   $this->fncGetVista() )) ? null : $user["nIdEmpleado"];

            // Ids Filtros
            $aryMov = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nEntrada,
                //"nIdResponsable"      => $nIdResponsable,
                //   "nMovimientoInterno"  => "0"
            ]);

            $aryIdFilter = fncValidateArray($aryMov) ? array_unique(array_column($aryMov, "nIdMovimiento")) : [];


            // Ids Filtros

            $aryDetalleMov = $this->movimientos->fncGetMovimientosDetalle([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nEntrada,
                // "nMovimientoInterno"  => "0"
            ]);


            $aryIdProductosFilter = fncValidateArray($aryDetalleMov) ? array_unique(array_column($aryDetalleMov, "nIdProducto")) : [];

            $aryProductosFilter   = fncValidateArray($aryIdProductosFilter) ? $this->productos->fncGetProductos(["aryProductos" => $aryIdProductosFilter]) : [];

            // var_dump($aryProductosFilter);
            // exit;
            $aryProductos = $this->productos->fncGetProductos([
                "nIdSede" => $user["nIdSede"],
                "nEstado" => 1
            ]);

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/reporte-movimiento-ingreso', [
                'sTitulo'                    => 'Reporte Movimiento Ingreso',
                'user'                       => $user,
                'arySede'                    => $arySede,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "aryProductos"               => $aryProductos,
                "aryProductosFilter"         => $aryProductosFilter,
                "aryIdFilter"                => $aryIdFilter,
                "aryUbicacionAlmacen"        => $this->ubicacionAlmacen->fncGetUA(["nIdSede" => $user["nIdSede"]]),
                'aryTipoMovimiento'          => $this->catalogotabla->fncListado("TIPO_MOVIMIENTO"),
                'nEntrada'                   => $nEntrada,
                'nTipoOrdenCompra'           => $this->fncGetVarConfig("nTipoOrdenCompra")
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteMovimientoSalida()
    {
        try {

            $this->authAdmin($this->session);
            $user           = $this->session->get('user');
            $nSalida       = $this->fncGetVarConfig("nSalida");
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->fncGetVista())) ? null : $user["nIdEmpleado"];

            // Ids Filtros
            $aryMov = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nSalida,
                # "nMovimientoInterno"  => "0"
            ]);

            $aryIdFilter = fncValidateArray($aryMov) ? array_unique(array_column($aryMov, "nIdMovimiento")) : [];


            // Ids Filtros

            $aryDetalleMov = $this->movimientos->fncGetMovimientosDetalle([
                "nIdSede"             => $user["nIdSede"],
                "nEntradaSalida"      => $nSalida,
                # "nMovimientoInterno"  => "0"
            ]);


            $aryIdProductosFilter = fncValidateArray($aryDetalleMov) ? array_unique(array_column($aryDetalleMov, "nIdProducto")) : [];

            $aryProductosFilter   = fncValidateArray($aryIdProductosFilter) ? $this->productos->fncGetProductos(["aryProductos" => $aryIdProductosFilter]) : [];

            // var_dump($aryProductosFilter);
            // exit;
            $aryProductos = $this->productos->fncGetProductos([
                "nIdSede" => $user["nIdSede"],
                "nEstado" => 1
            ]);

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/reporte-movimiento-salida', [
                'sTitulo'                    => 'Reporte Movimiento Salida',
                'user'                       => $user,
                'arySede'                    => $arySede,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "aryProductos"               => $aryProductos,
                "aryProductosFilter"         => $aryProductosFilter,
                "aryIdFilter"                => $aryIdFilter,
                'nSalida'                    => $nSalida,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteMovimientos()
    {
        try {

            $this->authAdmin($this->session);
            $user           = $this->session->get('user');
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->fncGetVista())) ? null : $user["nIdEmpleado"];

            // Ids Filtros
            $aryMov = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nMovimientoInterno"  => "0"
            ]);

            $aryIdFilter = fncValidateArray($aryMov) ? array_unique(array_column($aryMov, "nIdMovimiento")) : [];


            // Ids Filtros

            $aryDetalleMov = $this->movimientos->fncGetMovimientosDetalle([
                "nIdSede"             => $user["nIdSede"],
                #"nMovimientoInterno"  => "0"
            ]);


            $aryIdProductosFilter = fncValidateArray($aryDetalleMov) ? array_unique(array_column($aryDetalleMov, "nIdProducto")) : [];

            $aryProductosFilter   = fncValidateArray($aryIdProductosFilter) ? $this->productos->fncGetProductos(["aryProductos" => $aryIdProductosFilter]) : [];

            // var_dump($aryProductosFilter);
            // exit;
            $aryProductos = $this->productos->fncGetProductos([
                "nIdSede" => $user["nIdSede"],
                "nEstado" => 1
            ]);

            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/reporte-movimientos', [
                'sTitulo'                    => 'Reporte Movimientos',
                'user'                       => $user,
                'arySede'                    => $arySede,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "aryProductos"               => $aryProductos,
                "aryProductosFilter"         => $aryProductosFilter,
                "aryIdFilter"                => $aryIdFilter,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteMovimientosDetallado()
    {
        try {

            $this->authAdmin($this->session);
            $user           = $this->session->get('user');

            // Ids Filtros
            $aryMov = $this->movimientos->fncGetMovimientos([
                "nIdSede"             => $user["nIdSede"],
                "nMovimientoInterno"  => "0"
            ]);

            $aryIdFilter = fncValidateArray($aryMov) ? array_unique(array_column($aryMov, "nIdMovimiento")) : [];


            // Ids Filtros

            $aryDetalleMov = $this->movimientos->fncGetMovimientosDetalle([
                "nIdSede"             => $user["nIdSede"],
            ]);


            $aryIdProductosFilter = fncValidateArray($aryDetalleMov) ? array_unique(array_column($aryDetalleMov, "nIdProducto")) : [];

            $aryProductosFilter   = fncValidateArray($aryIdProductosFilter) ? $this->productos->fncGetProductos(["aryProductos" => $aryIdProductosFilter]) : [];



            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/reporte-movimiento-detallado', [
                'sTitulo'                    => 'Reporte Movimientos Detallado',
                'user'                       => $user,
                'arySede'                    => $arySede,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "aryProductosFilter"         => $aryProductosFilter,
                "aryIdFilter"                => $aryIdFilter,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }



    // Con este metodo se grabalas entradas
    public function fncGrabarMovimiento()
    {
        try {

            $nIdRegistro       = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sDescripcion      = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $nTipoMovimiento   = isset($_POST['nTipoMovimiento']) ? $_POST['nTipoMovimiento'] : null;
            $nIdOrdenCompra    = isset($_POST['nIdOrdenCompra']) ? $_POST['nIdOrdenCompra'] : null;

            $nIdDocumento      = isset($_POST['nIdDocumento']) ? $_POST['nIdDocumento'] : null;
            $dFechaMovimiento  = isset($_POST['dFechaMovimiento']) ? $_POST['dFechaMovimiento'] : null;

            $nEntradaSalida    = isset($_POST['nEntradaSalida']) ? $_POST['nEntradaSalida'] : null;

            $nTipoMoneda       = isset($_POST['nTipoMoneda']) ? $_POST['nTipoMoneda'] : null;
            $aryDataDetalle    = isset($_POST['aryDataDetalle']) ? $_POST['aryDataDetalle'] : null;
            $nEstado           = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;



            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nEntradaSalida)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            // var_dump($aryDataDetalle);
            // exit;


            $nIdMovimientoNew = null;
            $nEntrada = $this->fncGetVarConfig("nEntrada");
            $nSalida  = $this->fncGetVarConfig("nSalida");

            $nIdOrdenCompra   = $nIdOrdenCompra == 0 ? null : $nIdOrdenCompra;

            $nIdResponsable   = $user["nIdRol"] == $this->fncGetVarConfig("nIdRolAdmin") ? $user["nIdUsuario"] : $user["nIdEmpleado"];

            // Crear
            if ($nIdRegistro == 0) {

                $nIdMovimientoNew = $this->movimientos->fncGrabarMovimiento(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdOrdenCompra,
                    $nIdResponsable,
                    $sDescripcion,
                    $nEntradaSalida,
                    $nTipoMovimiento,
                    $nIdDocumento,
                    $dFechaMovimiento,
                    $nTipoMoneda,
                    0,
                    $nEstado
                );

                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $nKey => $aryData) {
                        $this->movimientos->fncGrabarMovimientoDetalle(
                            $nIdMovimientoNew,
                            $aryData["nIdProducto"],
                            $aryData["nCantidad"],
                            $aryData["nPrecio"],
                            $aryData["nConvertir"],
                            $aryData["nIdUbicacionAlmacen"],
                            $nEstado
                        );

                        $this->fncActualizarStockActual($aryData["nIdProducto"]);
                    }
                }

                if (!is_null($nIdOrdenCompra) && $nIdOrdenCompra > 0) {
                    $this->ordenCompra->fncActualizarProcesado($nIdOrdenCompra, 1);
                    $this->ordenCompra->fncActualizarEjecutado($nIdOrdenCompra, 1);
                }


                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $nKey => $aryData) {
                        if ($aryData["nConvertir"] > 0) {

                            // Vealidar si existe stock para poder realizar la conversion
                            $aryProductoP = $this->productos->fncGetProductos(["nIdProducto" => $aryData["nIdProducto"]]);

                            if (fncValidateArray($aryProductoP)) {
                                $aryProductoP = $aryProductoP[0];
                                if ($aryProductoP["nVenderStock"] == 1) {
                                    $nDiferencia = $aryProductoP["nStockActual"] - $aryData["nConvertir"];

                                    if ($nDiferencia < 0) {
                                        $this->exception("Error . No se puede realizar la conversion de el producto " . strup($aryProductoP["sDescripcion"]) . " . Stock Actual : " . $aryProductoP["nStockActual"] .  " - Cantidad Requerida : " . $aryData["nConvertir"] . " . Porfavor verifique");
                                        break;
                                    }
                                }
                            } else {
                                $this->exception("Error.No se encontro el producto quizas se haya eliminado o no exista.Porfavor verifique");
                                break;
                            }

                            // Si existe stock realizar la conversion
                            $aryProductoEquivalencia = $this->productos->fncGetProductoEquivalencia(["nIdProductoPadre" => $aryData["nIdProducto"]]);

                            if (fncValidateArray($aryProductoEquivalencia)) {
                                // Si existe la equivalencia
                                $aryProductoEquivalencia = $aryProductoEquivalencia[0];

                                // Creamos las salidas del producto padre

                                $nIdMovimientoSalidaEq = $this->movimientos->fncGrabarMovimiento(
                                    $user["nIdEmpresa"],
                                    $user["nIdSede"],
                                    null,
                                    $nIdResponsable,
                                    "CONVERSION DEL PRODUCTO SALIDA" . $aryData["nIdProducto"],
                                    $nSalida,
                                    null,
                                    null,
                                    $dFechaMovimiento,
                                    $nTipoMoneda,
                                    1,
                                    $nEstado
                                );

                                $this->movimientos->fncGrabarMovimientoDetalle(
                                    $nIdMovimientoSalidaEq,
                                    $aryData["nIdProducto"],
                                    $aryData["nConvertir"],
                                    $aryData["nPrecio"],
                                    0,
                                    0,
                                    $nEstado
                                );

                                // Creamos la entrada del hijo
                                $nCantidadEntradaHijo = $aryProductoEquivalencia["nCantidadPadre"] * $aryData["nConvertir"] * $aryProductoEquivalencia["nCantidadHijo"];

                                $nIdMovimientoEntradaEq = $this->movimientos->fncGrabarMovimiento(
                                    $user["nIdEmpresa"],
                                    $user["nIdSede"],
                                    null,
                                    $nIdResponsable,
                                    "CONVERSION DEL PRODUCTO ENTRADA" . $aryProductoEquivalencia["nIdProductoHijo"],
                                    $nEntrada,
                                    null,
                                    null,
                                    $dFechaMovimiento,
                                    $nTipoMoneda,
                                    1,
                                    $nEstado
                                );

                                $aryProducto = $this->productos->fncGetProductos(["nIdProducto" =>  $aryProductoEquivalencia["nIdProductoHijo"]])[0];

                                $this->movimientos->fncGrabarMovimientoDetalle(
                                    $nIdMovimientoEntradaEq,
                                    $aryProductoEquivalencia["nIdProductoHijo"],
                                    $nCantidadEntradaHijo,
                                    $aryProducto["nPrecioCompra"],
                                    0,
                                    0,
                                    $nEstado
                                );

                                $this->fncActualizarStockActual($aryData["nIdProducto"]);
                                $this->fncActualizarStockActual($aryProductoEquivalencia["nIdProductoHijo"]);

                                $this->productos->fncGrabarHistorialEquivalencia(
                                    $user["nIdEmpresa"],
                                    $user["nIdSede"],
                                    $nIdMovimientoNew,
                                    $nIdMovimientoEntradaEq,
                                    $nIdMovimientoSalidaEq,
                                    $nEstado
                                );
                            }
                        }
                    }
                }
            } else {

                //Actualizar
                $this->movimientos->fncActualizarMovimiento(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdOrdenCompra,
                    $nIdResponsable,
                    $sDescripcion,
                    $nEntradaSalida,
                    $nTipoMovimiento,
                    $nIdDocumento,
                    $dFechaMovimiento,
                    $nTipoMoneda,
                    0,
                    $nEstado
                );

                // Obtenemos los detallesde la db
                $aryDetalleDB = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $nIdRegistro]);

                $this->movimientos->fncEliminarDetalleByIdMovimiento($nIdRegistro);

                if (fncValidateArray($aryDetalleDB)) {
                    foreach ($aryDetalleDB as $nKey => $aryData) {
                        $this->fncActualizarStockActual($aryData["nIdProducto"]);
                    }
                }

                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $nKey => $aryData) {
                        $this->movimientos->fncGrabarMovimientoDetalle(
                            $nIdRegistro,
                            $aryData["nIdProducto"],
                            $aryData["nCantidad"],
                            $aryData["nPrecio"],
                            $aryData["nConvertir"],
                            $aryData["nIdUbicacionAlmacen"],
                            $nEstado
                        );

                        $this->fncActualizarStockActual($aryData["nIdProducto"]);
                    }
                }



                // Verificar Historial de movimientos equivalentes
                $aryHistorialEquivalentes = $this->productos->fncGetHistorialEquivalencia(["nIdMovimientoGeneral" => $nIdRegistro]);

                if (fncValidateArray($aryHistorialEquivalentes)) {
                    foreach ($aryHistorialEquivalentes as $key => $aryHistorialEquivalente) {
                        $aryDetalleSalida  = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryHistorialEquivalente["nIdMovimientoSalida"]]);
                        $aryDetalleEntrada = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryHistorialEquivalente["nIdMovimientoEntrada"]]);


                        $this->movimientos->fncEliminarMovimiento($aryHistorialEquivalente["nIdMovimientoSalida"]);
                        $this->movimientos->fncEliminarMovimiento($aryHistorialEquivalente["nIdMovimientoEntrada"]);

                        $this->movimientos->fncEliminarDetalleByIdMovimiento($aryHistorialEquivalente["nIdMovimientoSalida"]);
                        $this->movimientos->fncEliminarDetalleByIdMovimiento($aryHistorialEquivalente["nIdMovimientoEntrada"]);

                        if (fncValidateArray($aryDetalleSalida)) {
                            foreach ($aryDetalleSalida  as $key => $aryLoop) {
                                $this->fncActualizarStockActual($aryLoop["nIdProducto"]);
                            }
                        }

                        if (fncValidateArray($aryDetalleEntrada)) {
                            foreach ($aryDetalleEntrada  as $key => $aryLoop) {
                                $this->fncActualizarStockActual($aryLoop["nIdProducto"]);
                            }
                        }
                    }
                }


                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $nKey => $aryData) {
                        $this->fncActualizarStockActual($aryData["nIdProducto"]);
                    }
                }


                if (fncValidateArray($aryHistorialEquivalentes)) {
                    foreach ($aryHistorialEquivalentes as $key => $aryHistorialEquivalente) {
                        $this->productos->fncEliminarHistorialEquivalencia($aryHistorialEquivalente["nIdHistorialEquivalencia"]);
                    }
                }


                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $nKey => $aryData) {
                        if ($aryData["nConvertir"] > 0) {

                            // Vealidar si existe stock para poder realizar la conversion
                            $aryProductoP = $this->productos->fncGetProductos(["nIdProducto" => $aryData["nIdProducto"]]);

                            if (fncValidateArray($aryProductoP)) {
                                $aryProductoP = $aryProductoP[0];
                                if ($aryProductoP["nVenderStock"] == 1) {
                                    $nDiferencia = $aryProductoP["nStockActual"] - $aryData["nConvertir"];

                                    if ($nDiferencia < 0) {
                                        $this->exception("Error . No se puede realizar la conversion de el producto " . strup($aryProductoP["sDescripcion"]) . " . Stock Actual : " . $aryProductoP["nStockActual"] .  " - Cantidad Requerida : " . $aryData["nConvertir"] . " . Porfavor verifique");
                                        break;
                                    }
                                }
                            } else {
                                $this->exception("Error.No se encontro el producto quizas se haya eliminado o no exista.Porfavor verifique");
                                break;
                            }

                            // Si existe stock realizar la conversion
                            $aryProductoEquivalencia = $this->productos->fncGetProductoEquivalencia(["nIdProductoPadre" => $aryData["nIdProducto"]]);

                            if (fncValidateArray($aryProductoEquivalencia)) {
                                // Si existe la equivalencia
                                $aryProductoEquivalencia = $aryProductoEquivalencia[0];

                                // Creamos las salidas del producto padre

                                $nIdMovimientoSalidaEq = $this->movimientos->fncGrabarMovimiento(
                                    $user["nIdEmpresa"],
                                    $user["nIdSede"],
                                    null,
                                    $nIdResponsable,
                                    "CONVERSION DEL PRODUCTO SALIDA" . $aryData["nIdProducto"],
                                    $nSalida,
                                    null,
                                    null,
                                    $dFechaMovimiento,
                                    $nTipoMoneda,
                                    1,
                                    $nEstado
                                );

                                $this->movimientos->fncGrabarMovimientoDetalle(
                                    $nIdMovimientoSalidaEq,
                                    $aryData["nIdProducto"],
                                    $aryData["nConvertir"],
                                    $aryData["nPrecio"],
                                    0,
                                    0,
                                    $nEstado
                                );

                                // Creamos la entrada del hijo
                                $nCantidadEntradaHijo = $aryProductoEquivalencia["nCantidadPadre"] * $aryData["nConvertir"] * $aryProductoEquivalencia["nCantidadHijo"];

                                $nIdMovimientoEntradaEq = $this->movimientos->fncGrabarMovimiento(
                                    $user["nIdEmpresa"],
                                    $user["nIdSede"],
                                    null,
                                    $nIdResponsable,
                                    "CONVERSION DEL PRODUCTO ENTRADA" . $aryProductoEquivalencia["nIdProductoHijo"],
                                    $nEntrada,
                                    null,
                                    null,
                                    $dFechaMovimiento,
                                    $nTipoMoneda,
                                    1,
                                    $nEstado
                                );

                                $aryProducto = $this->productos->fncGetProductos(["nIdProducto" =>  $aryProductoEquivalencia["nIdProductoHijo"]])[0];

                                $this->movimientos->fncGrabarMovimientoDetalle(
                                    $nIdMovimientoEntradaEq,
                                    $aryProductoEquivalencia["nIdProductoHijo"],
                                    $nCantidadEntradaHijo,
                                    $aryProducto["nPrecioCompra"],
                                    0,
                                    0,
                                    $nEstado
                                );

                                $this->fncActualizarStockActual($aryData["nIdProducto"]);
                                $this->fncActualizarStockActual($aryProductoEquivalencia["nIdProductoHijo"]);

                                $this->productos->fncGrabarHistorialEquivalencia(
                                    $user["nIdEmpresa"],
                                    $user["nIdSede"],
                                    $nIdRegistro,
                                    $nIdMovimientoEntradaEq,
                                    $nIdMovimientoSalidaEq,
                                    $nEstado
                                );
                            }
                        }
                    }
                }
            }



            $sSuccess =  $nIdRegistro == 0 ? 'Movimiento registrado exitosamente...' : 'Movimiento actualizado exitosamente...';

            $this->json(array(
                "success"            => $sSuccess,
                "nIdMovimientoNew"   => $nIdMovimientoNew,
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    // Metodo para crear movimientos de salida

    public function fncGrabarMovimientoSalida()
    {

        $nIdRegistro       = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $sDescripcion      = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
        $nTipoMovimiento   = isset($_POST['nTipoMovimiento']) ? $_POST['nTipoMovimiento'] : null;
        $nIdOrdenCompra    = null;

        $nIdDocumento      = isset($_POST['nIdDocumento']) ? $_POST['nIdDocumento'] : null;
        $dFechaMovimiento  = isset($_POST['dFechaMovimiento']) ? $_POST['dFechaMovimiento'] : null;

        $nEntradaSalida    = isset($_POST['nEntradaSalida']) ? $_POST['nEntradaSalida'] : null;

        $nTipoMoneda       = isset($_POST['nTipoMoneda']) ? $_POST['nTipoMoneda'] : null;
        $aryDataDetalle    = isset($_POST['aryDataDetalle']) ? $_POST['aryDataDetalle'] : null;
        $nEstado           = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


        try {


            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nEntradaSalida)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdMovimientoNew = null;
            $nIdResponsable   = $user["nIdRol"] == $this->fncGetVarConfig("nIdRolAdmin") ? $user["nIdUsuario"] : $user["nIdEmpleado"];

            // Crear
            if ($nIdRegistro == 0) {


                # Valida que existan los productos en stock
                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $nKey => $aryData) {

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
                            $this->exception("Error.No se encontro el producto quizas se  haya eliminado o no exista.Porfavor verif ique");
                            break;
                        }
                    }
                }

                # Crea la cabecera del movimiento
                $nIdMovimientoNew = $this->movimientos->fncGrabarMovimiento(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdOrdenCompra,
                    $nIdResponsable,
                    $sDescripcion,
                    $nEntradaSalida,
                    $nTipoMovimiento,
                    $nIdDocumento,
                    $dFechaMovimiento,
                    $nTipoMoneda,
                    0,
                    $nEstado
                );

                // Registra el detalle del movimiento 
                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $aryLoop) {

                        // Obtenemos data de la descompocicion por el proudcto hijo 

                        $aryDescomp = $this->productos->fncGetProductosDescompDet(["nIdProductoHijo" => $aryProducto["nIdProducto"]]);

                        if (fncValidateArray($aryDescomp)) {

                            // Si es un producto de descompocision

                            $aryDescomp  = $aryDescomp[0];

                            $aryProductoPadre = $this->productos->fncGetProductos(["nIdProducto" =>  $aryDescomp["nIdProductoPadre"]])[0];
                            $nCantidadPadre   = ($aryData["nCantidad"] * $aryDescomp["nDescomp"]);

                            $this->movimientos->fncGrabarMovimientoDetalle(
                                $nIdMovimientoNew,
                                $aryDescomp["nIdProductoPadre"],
                                $nCantidadPadre,
                                $aryLoop["nPrecio"],
                                0,
                                0,
                                $nEstado
                            );

                            $this->fncActualizarStockActual($aryDescomp["nIdProductoPadre"]);
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

                            $this->fncActualizarStockActual($aryLoop["nIdProducto"]);
                        }
                    }
                }
            } else {

                //Actualizar

                # Actualiza la cabecera 
                $this->movimientos->fncActualizarMovimiento(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdOrdenCompra,
                    $nIdResponsable,
                    $sDescripcion,
                    $nEntradaSalida,
                    $nTipoMovimiento,
                    $nIdDocumento,
                    $dFechaMovimiento,
                    $nTipoMoneda,
                    0,
                    $nEstado
                );

                // Obtenemos los detalles desde la DB
                $aryDetalleDB = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $nIdRegistro]);

                # Eliminamos el detalle del movimiento
                $this->movimientos->fncEliminarDetalleByIdMovimiento($nIdRegistro);

                # Actualizamos los stock
                if (fncValidateArray($aryDetalleDB)) {
                    foreach ($aryDetalleDB as $nKey => $aryData) {
                        $this->fncActualizarStockActual($aryData["nIdProducto"]);
                    }
                }

                # Valida que existan los productos en stock
                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $nKey => $aryData) {

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
                            $this->exception("Error.No se encontro el producto quizas se  haya eliminado o no exista.Porfavor verif ique");
                            break;
                        }
                    }
                }

                // Registra el detalle del movimiento 
                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $aryLoop) {

                        // Obtenemos data de la descompocicion por el proudcto hijo 

                        $aryDescomp = $this->productos->fncGetProductosDescompDet(["nIdProductoHijo" => $aryProducto["nIdProducto"]]);

                        if (fncValidateArray($aryDescomp)) {

                            // Si es un producto de descompocision

                            $aryDescomp  = $aryDescomp[0];

                            $aryProductoPadre = $this->productos->fncGetProductos(["nIdProducto" =>  $aryDescomp["nIdProductoPadre"]])[0];
                            $nCantidadPadre   = ($aryData["nCantidad"] * $aryDescomp["nDescomp"]);

                            $this->movimientos->fncGrabarMovimientoDetalle(
                                $nIdRegistro,
                                $aryDescomp["nIdProductoPadre"],
                                $nCantidadPadre,
                                $aryLoop["nPrecio"],
                                0,
                                0,
                                $nEstado
                            );

                            $this->fncActualizarStockActual($aryDescomp["nIdProductoPadre"]);
                        } else {
                            $this->movimientos->fncGrabarMovimientoDetalle(
                                $nIdRegistro,
                                $aryLoop["nIdProducto"],
                                $aryLoop["nCantidad"],
                                $aryLoop["nPrecio"],
                                0,
                                0,
                                $nEstado
                            );

                            $this->fncActualizarStockActual($aryLoop["nIdProducto"]);
                        }
                    }
                }
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Movimiento de salida registrado exitosamente...' : 'Movimiento de salida actualizado exitosamente...';

            $this->json(array(
                "success"            => $sSuccess,
                "nIdMovimientoNew"   => $nIdMovimientoNew,
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
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryDataDetalle = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $nIdRegistro]);

            $aryDataHM      = $this->productos->fncGetHistorialEquivalencia(["nIdMovimientoGeneral" => $nIdRegistro]);

            // Equivalencia
            if (fncValidateArray($aryDataHM)) {
                foreach ($aryDataHM as $key => $aryLoop) {
                    $aryDetalleSalida  = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoSalida"]]);
                    $aryDetalleEntrada = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoEntrada"]]);

                    $this->movimientos->fncEliminarMovimiento($aryLoop["nIdMovimientoSalida"]);
                    $this->movimientos->fncEliminarMovimiento($aryLoop["nIdMovimientoEntrada"]);

                    $this->movimientos->fncEliminarDetalleByIdMovimiento($aryLoop["nIdMovimientoSalida"]);
                    $this->movimientos->fncEliminarDetalleByIdMovimiento($aryLoop["nIdMovimientoEntrada"]);

                    if (fncValidateArray($aryDetalleSalida)) {
                        foreach ($aryDetalleSalida  as $key => $aryLoopS) {
                            $this->fncActualizarStockActual($aryLoopS["nIdProducto"]);
                        }
                    }

                    if (fncValidateArray($aryDetalleEntrada)) {
                        foreach ($aryDetalleEntrada  as $key => $aryLoopE) {
                            $this->fncActualizarStockActual($aryLoopE["nIdProducto"]);
                        }
                    }
                }
            }

            if (fncValidateArray($aryDataHM)) {
                foreach ($aryDataHM as $key => $aryLoopD) {
                    $this->productos->fncEliminarHistorialEquivalencia($aryLoopD["nIdHistorialEquivalencia"]);
                }
            }

            $this->movimientos->fncEliminarMovimiento($nIdRegistro);
            // End Equivalencia

            if (fncValidateArray($aryDataDetalle)) {
                foreach ($aryDataDetalle as $nKey => $aryData) {
                    $this->fncActualizarStockActual($aryData["nIdProducto"]);
                }
            }

            $this->json(array("success" => 'Movimiento eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }



    // Funcion para eliminar un movimiento 
    public function fncEliminarMovimiento($nIdMovimiento)
    {
        // Recibe valores del formulario

        try {

            // Valida valores del formulario
            if (is_null($nIdMovimiento)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            # Obtiene del detalle del movimiento
            $aryDataDetalle = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $nIdMovimiento]);


            # Si elimino el movimiento por default se elimina el detalle porque tiene la relacion en casacada
            $this->movimientos->fncEliminarMovimiento($nIdMovimiento);

            if (fncValidateArray($aryDataDetalle)) {
                foreach ($aryDataDetalle as $nKey => $aryData) {
                    $this->fncActualizarStockActual($aryData["nIdProducto"]);
                }
            }

            return true;
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

            $aryData      = $this->movimientos->fncGetMovimientos(["nIdMovimiento" => $nIdRegistro]);
            $aryDetalle   = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $nIdRegistro]);

            $this->json(array(
                "success"           => true,
                "aryMovimiento"     => fncValidateArray($aryData) ? $aryData[0] : null,
                "aryDetalle"        => $aryDetalle
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMovimientoPdf($nIdMovimiento)
    {
        try {
            $aryMov   = $this->movimientos->fncGetMovimientos(["nIdMovimiento" => $nIdMovimiento]);

            if (!fncValidateArray($aryMov)) {
                $this->exception("Error. No se encontro datos sobre el movimiento quizas se se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryMov        = $aryMov[0];

            $aryMovDetalle = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $nIdMovimiento]);

            if (!fncValidateArray($aryMovDetalle)) {
                $this->exception("Error. No se encontro datos sobre el detalle del movimiento problablemente se haya eliminado o no exista. Porfavor verifique.");
            }


            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryMov["nIdSede"]]);

            if (!fncValidateArray($arySede)) {
                $this->exception("Error. No se encontro datos de la sede problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $arySede = $arySede[0];

            ob_start();

            $this->view("admin/pdf-movimiento", [
                "sTitulo"           => "NOTA DE INGRESO",
                "aryMov"            => $aryMov,
                "aryMovDetalle"     => $aryMovDetalle,
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

    public function fncActualizarStockActual($nIdProducto)
    {
        try {
            $aryProducto = $this->productos->fncObtenerFlagProducto($nIdProducto)[0];

            if ($aryProducto["nVenderStock"] == 1) {

                $aryEntradas = $this->movimientos->fncObtenterES($nIdProducto, 1);
                $arySalidas  = $this->movimientos->fncObtenterES($nIdProducto, 2);

                $nValorEntradas = fncValidateArray($aryEntradas) ? $aryEntradas[0]["nValor"] : 0;
                $nValorSalidas  = fncValidateArray($arySalidas)  ? $arySalidas[0]["nValor"] : 0;

                $nStockActual = $nValorEntradas -  $nValorSalidas;

                $this->productos->fncActualizarDataStock($nIdProducto, $nStockActual);
            }
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateEquivalencias()
    {
        try {


            // Valida valores del formulario
            $aryRows      = [];
            $user         = $this->session->get("user");


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            $aryData  = $this->productos->fncGetHistorialEquivalencia([
                "nIdSede"                      => $user["nIdSede"],
                "nIdMovimientoGeneralNull"     => " IS NULL ",
            ]);


            $bIsAdmin   = $this->fncIsAdmin($user["nIdRol"], $this->sUrlEquivalencia);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    // Si esque se ha echo  alguna vengta o movimiento externo 


                    $aryDetalleEntrada = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoEntrada"]]);
                    $aryDetalleSalida  = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoSalida"]]);

                    $nCantidadPadre = 0;
                    $sProductoPadre = "";

                    $bExisteMov     = false;

                    if (fncValidateArray($aryDetalleSalida)) {
                        foreach ($aryDetalleSalida as $key => $aryLoopS) {
                            $aryProducto    = $this->productos->fncGetProductos(["nIdProducto" => $aryLoopS["nIdProducto"]])[0];
                            $nCantidadPadre = $aryLoopS["nCantidad"];
                            $sProductoPadre = $aryProducto["sDescripcion"];

                            // Verificar si esque existe en el detalle  del pedido
                            $aryDetallePD = $this->pedidos->fncObtenerPedidosDetalle(["nIdProducto" => $aryLoopS["nIdProducto"]]);

                            if (fncValidateArray($aryDetallePD)) {
                                $bExisteMov = true;
                            }
                        }
                    }

                    $nCantidadHijo = 0;
                    $sProductoHijo = "";

                    if (fncValidateArray($aryDetalleEntrada)) {
                        foreach ($aryDetalleEntrada as $key => $aryLoopE) {
                            $aryProducto     = $this->productos->fncGetProductos(["nIdProducto" => $aryLoopE["nIdProducto"]])[0];
                            $nCantidadHijo   = $aryLoopE["nCantidad"];
                            $sProductoHijo   = $aryProducto["sDescripcion"];

                            // Verificar si esque existe en el detalle  del pedido
                            $aryDetallePD = $this->pedidos->fncObtenerPedidosDetalle(["nIdProducto" => $aryLoopE["nIdProducto"]]);

                            if (fncValidateArray($aryDetallePD)) {
                                $bExisteMov = true;
                            }
                        }
                    }

                    // var_dump($bExisteMov);


                    $sActionShow       = "fncMostrarEQ(" . $aryLoop['nIdHistorialEquivalencia'] . ", 'ver' );";
                    $sActionEdit       = "fncMostrarEQ(" . $aryLoop['nIdHistorialEquivalencia'] . ", 'editar' );";
                    $sActionEliminar   = "fncEliminarEQ(" . $aryLoop['nIdHistorialEquivalencia'] . ");";

                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin && !$bExisteMov ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin && !$bExisteMov ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"        => $sAcciones,
                        "sProductoPadre"   => strup($sProductoPadre),
                        "nCantidadPadre"   => $nCantidadPadre,
                        "sProductoHijo"    => strup($sProductoHijo),
                        "nCantidadHijo"    => $nCantidadHijo,
                        "dFechaCreacion"   => $aryLoop["dFechaCreacion"],
                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncProcesarEquivalencia()
    {
        try {
            $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdProductoPadre       = isset($_POST['nIdProductoPadre']) ? $_POST['nIdProductoPadre'] : null;
            $nIdUnidadMedidaPadre   = isset($_POST['nIdUnidadMedidaPadre']) ? $_POST['nIdUnidadMedidaPadre'] : null;
            $nConvertir             = isset($_POST['nConvertir']) ? $_POST['nConvertir'] : null;
            $nIdProductoHijo        = isset($_POST['nIdProductoHijo']) ? $_POST['nIdProductoHijo'] : null;
            $nIdUnidadMedidaHijo    = isset($_POST['nIdUnidadMedidaHijo']) ? $_POST['nIdUnidadMedidaHijo'] : null;
            $nCantidadPadre         = isset($_POST['nCantidadPadre']) ? $_POST['nCantidadPadre'] : null;
            $nCantidadHijo          = isset($_POST['nCantidadHijo']) ? $_POST['nCantidadHijo'] : null;
            $nEstado                = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdResponsable = $user["nIdRol"] == $this->fncGetVarConfig("nIdRolAdmin") ? $user["nIdUsuario"] : $user["nIdEmpleado"];
            $nEntrada = $this->fncGetVarConfig("nEntrada");
            $nSalida  = $this->fncGetVarConfig("nSalida");


            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            // Crear
            if ($nIdRegistro == 0) {
                if ($nConvertir > 0) {

                    // Vealidar si existe stock para poder realizar la conversion
                    $aryProductoP = $this->productos->fncGetProductos(["nIdProducto" => $nIdProductoPadre]);

                    if (fncValidateArray($aryProductoP)) {
                        $aryProductoP = $aryProductoP[0];
                        if ($aryProductoP["nVenderStock"] == 1) {
                            $nDiferencia = $aryProductoP["nStockActual"] - $nConvertir;

                            if ($nDiferencia < 0) {
                                $this->exception("Error . No se puede realizar la conversion de el producto " . strup($aryProductoP["sDescripcion"]) . " . Stock Actual : " . $aryProductoP["nStockActual"] .  " - Cantidad Requerida : " . $nConvertir  . " . Porfavor verifique");
                            }
                        }
                    } else {
                        $this->exception("Error.No se encontro el producto quizas se haya eliminado o no exista.Porfavor verifique");
                    }

                    // Si existe stock realizar la conversion
                    $aryProductoEquivalencia = $this->productos->fncGetProductoEquivalencia(["nIdProductoPadre" => $nIdProductoPadre]);

                    if (fncValidateArray($aryProductoEquivalencia)) {
                        // Si existe la equivalencia
                        $aryProductoEquivalencia = $aryProductoEquivalencia[0];

                        // Creamos las salidas del producto padre

                        $nIdMovimientoSalidaEq = $this->movimientos->fncGrabarMovimiento(
                            $user["nIdEmpresa"],
                            $user["nIdSede"],
                            null,
                            $nIdResponsable,
                            "CONVERSION DEL PRODUCTO SALIDA" . $nIdProductoPadre,
                            $nSalida,
                            null,
                            null,
                            date("d/m/Y"),
                            $arySede["nTipoMoneda"],
                            1,
                            $nEstado
                        );

                        $this->movimientos->fncGrabarMovimientoDetalle(
                            $nIdMovimientoSalidaEq,
                            $nIdProductoPadre,
                            $nConvertir,
                            $aryProductoP["nPrecioCompra"],
                            0,
                            0,
                            $nEstado
                        );

                        // Creamos la entrada del hijo
                        $nCantidadEntradaHijo = $aryProductoEquivalencia["nCantidadPadre"] * $nConvertir * $nCantidadHijo;

                        $nIdMovimientoEntradaEq = $this->movimientos->fncGrabarMovimiento(
                            $user["nIdEmpresa"],
                            $user["nIdSede"],
                            null,
                            $nIdResponsable,
                            "CONVERSION DEL PRODUCTO ENTRADA" . $aryProductoEquivalencia["nIdProductoHijo"],
                            $nEntrada,
                            null,
                            null,
                            date("d/m/Y"),
                            $arySede["nTipoMoneda"],
                            1,
                            $nEstado
                        );

                        $aryProducto = $this->productos->fncGetProductos(["nIdProducto" =>  $aryProductoEquivalencia["nIdProductoHijo"]])[0];

                        $this->movimientos->fncGrabarMovimientoDetalle(
                            $nIdMovimientoEntradaEq,
                            $aryProductoEquivalencia["nIdProductoHijo"],
                            $nCantidadEntradaHijo,
                            $aryProducto["nPrecioCompra"],
                            0,
                            0,
                            $nEstado
                        );


                        $this->fncActualizarStockActual($nIdProductoPadre);
                        $this->fncActualizarStockActual($aryProductoEquivalencia["nIdProductoHijo"]);

                        $this->productos->fncGrabarHistorialEquivalencia(
                            $user["nIdEmpresa"],
                            $user["nIdSede"],
                            null,
                            $nIdMovimientoEntradaEq,
                            $nIdMovimientoSalidaEq,
                            $nEstado
                        );
                    }
                }
            } else {


                // Verificar Historial de movimientos equivalentes
                $aryHistorialEquivalentes = $this->productos->fncGetHistorialEquivalencia(["nIdHistorialEquivalencia" => $nIdRegistro]);

                if (fncValidateArray($aryHistorialEquivalentes)) {
                    foreach ($aryHistorialEquivalentes as $key => $aryHistorialEquivalente) {
                        $aryDetalleSalida  = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryHistorialEquivalente["nIdMovimientoSalida"]]);
                        $aryDetalleEntrada = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryHistorialEquivalente["nIdMovimientoEntrada"]]);


                        $this->movimientos->fncEliminarMovimiento($aryHistorialEquivalente["nIdMovimientoSalida"]);
                        $this->movimientos->fncEliminarMovimiento($aryHistorialEquivalente["nIdMovimientoEntrada"]);

                        $this->movimientos->fncEliminarDetalleByIdMovimiento($aryHistorialEquivalente["nIdMovimientoSalida"]);
                        $this->movimientos->fncEliminarDetalleByIdMovimiento($aryHistorialEquivalente["nIdMovimientoEntrada"]);

                        if (fncValidateArray($aryDetalleSalida)) {
                            foreach ($aryDetalleSalida  as $key => $aryLoop) {
                                $this->fncActualizarStockActual($aryLoop["nIdProducto"]);
                            }
                        }

                        if (fncValidateArray($aryDetalleEntrada)) {
                            foreach ($aryDetalleEntrada  as $key => $aryLoop) {
                                $this->fncActualizarStockActual($aryLoop["nIdProducto"]);
                            }
                        }
                    }
                }

                $this->productos->fncEliminarHistorialEquivalencia($nIdRegistro);


                if ($nConvertir > 0) {

                    // Vealidar si existe stock para poder realizar la conversion
                    $aryProductoP = $this->productos->fncGetProductos(["nIdProducto" => $nIdProductoPadre]);

                    if (fncValidateArray($aryProductoP)) {
                        $aryProductoP = $aryProductoP[0];
                        if ($aryProductoP["nVenderStock"] == 1) {
                            $nDiferencia = $aryProductoP["nStockActual"] - $nConvertir;

                            if ($nDiferencia < 0) {
                                $this->exception("Error . No se puede realizar la conversion de el producto " . strup($aryProductoP["sDescripcion"]) . " . Stock Actual : " . $aryProductoP["nStockActual"] .  " - Cantidad Requerida : " . $nConvertir  . " . Porfavor verifique");
                            }
                        }
                    } else {
                        $this->exception("Error.No se encontro el producto quizas se haya eliminado o no exista.Porfavor verifique");
                    }

                    // Si existe stock realizar la conversion
                    $aryProductoEquivalencia = $this->productos->fncGetProductoEquivalencia(["nIdProductoPadre" => $nIdProductoPadre]);

                    if (fncValidateArray($aryProductoEquivalencia)) {
                        // Si existe la equivalencia
                        $aryProductoEquivalencia = $aryProductoEquivalencia[0];

                        // Creamos las salidas del producto padre

                        $nIdMovimientoSalidaEq = $this->movimientos->fncGrabarMovimiento(
                            $user["nIdEmpresa"],
                            $user["nIdSede"],
                            null,
                            $nIdResponsable,
                            "CONVERSION DEL PRODUCTO SALIDA" . $nIdProductoPadre,
                            $nSalida,
                            null,
                            null,
                            date("d/m/Y"),
                            $arySede["nTipoMoneda"],
                            1,
                            $nEstado
                        );

                        $this->movimientos->fncGrabarMovimientoDetalle(
                            $nIdMovimientoSalidaEq,
                            $nIdProductoPadre,
                            $nConvertir,
                            $aryProductoP["nPrecioCompra"],
                            0,
                            0,
                            $nEstado
                        );

                        // Creamos la entrada del hijo
                        $nCantidadEntradaHijo = $aryProductoEquivalencia["nCantidadPadre"] * $nConvertir *  $nCantidadHijo;

                        $nIdMovimientoEntradaEq = $this->movimientos->fncGrabarMovimiento(
                            $user["nIdEmpresa"],
                            $user["nIdSede"],
                            null,
                            $nIdResponsable,
                            "CONVERSION DEL PRODUCTO ENTRADA" . $aryProductoEquivalencia["nIdProductoHijo"],
                            $nEntrada,
                            null,
                            null,
                            date("d/m/Y"),
                            $arySede["nTipoMoneda"],
                            1,
                            $nEstado
                        );

                        $aryProducto = $this->productos->fncGetProductos(["nIdProducto" =>  $aryProductoEquivalencia["nIdProductoHijo"]])[0];

                        $this->movimientos->fncGrabarMovimientoDetalle(
                            $nIdMovimientoEntradaEq,
                            $aryProductoEquivalencia["nIdProductoHijo"],
                            $nCantidadEntradaHijo,
                            $aryProducto["nPrecioCompra"],
                            0,
                            0,
                            $nEstado
                        );

                        $this->fncActualizarStockActual($nIdProductoPadre);
                        $this->fncActualizarStockActual($aryProductoEquivalencia["nIdProductoHijo"]);

                        $this->productos->fncGrabarHistorialEquivalencia(
                            $user["nIdEmpresa"],
                            $user["nIdSede"],
                            null,
                            $nIdMovimientoEntradaEq,
                            $nIdMovimientoSalidaEq,
                            $nEstado
                        );
                    }
                }
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Equivalencia registrado exitosamente...' : 'Equivalencia actualizado exitosamente...';

            $this->json(array("success" => $sSuccess,));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarEquivalencia()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $aryDataHM = $this->productos->fncGetHistorialEquivalencia(["nIdHistorialEquivalencia" => $nIdRegistro]);

            // Equivalencia
            if (fncValidateArray($aryDataHM)) {
                foreach ($aryDataHM as $key => $aryLoop) {
                    $aryDetalleSalida  = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoSalida"]]);
                    $aryDetalleEntrada = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoEntrada"]]);

                    $this->movimientos->fncEliminarMovimiento($aryLoop["nIdMovimientoSalida"]);
                    $this->movimientos->fncEliminarMovimiento($aryLoop["nIdMovimientoEntrada"]);

                    $this->movimientos->fncEliminarDetalleByIdMovimiento($aryLoop["nIdMovimientoSalida"]);
                    $this->movimientos->fncEliminarDetalleByIdMovimiento($aryLoop["nIdMovimientoEntrada"]);

                    if (fncValidateArray($aryDetalleSalida)) {
                        foreach ($aryDetalleSalida  as $key => $aryLoopS) {
                            $this->fncActualizarStockActual($aryLoopS["nIdProducto"]);
                        }
                    }

                    if (fncValidateArray($aryDetalleEntrada)) {
                        foreach ($aryDetalleEntrada  as $key => $aryLoopE) {
                            $this->fncActualizarStockActual($aryLoopE["nIdProducto"]);
                        }
                    }
                }
            }

            if (fncValidateArray($aryDataHM)) {
                foreach ($aryDataHM as $key => $aryLoopD) {
                    $this->productos->fncEliminarHistorialEquivalencia($aryLoopD["nIdHistorialEquivalencia"]);
                }
            }

            // End Equivalencia

            $this->json(array("success" => 'Equivalencia eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarEquivalencia()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $aryDataHM = $this->productos->fncGetHistorialEquivalencia(["nIdHistorialEquivalencia" => $nIdRegistro]);

            // Equivalencia
            if (fncValidateArray($aryDataHM)) {
                foreach ($aryDataHM as $key => $aryLoop) {
                    $aryDetalleSalida  = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoSalida"]]);
                    $aryDetalleEntrada = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryLoop["nIdMovimientoEntrada"]]);
                }
            }

            $aryData = [
                "aryDataHM"         => $aryDataHM,
                "aryDetalleSalida"  => $aryDetalleSalida,
                "aryDetalleEntrada" => $aryDetalleEntrada,
            ];


            $this->json(array("success" => 'Mostrando resultados...', 'aryData' => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
