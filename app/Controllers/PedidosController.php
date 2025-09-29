<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Matrix\Functions;
use Application\Libs\Excel;
use Application\Libs\Session;
use Application\Models\Sedes;
use Application\Models\Ubigeo;
use Application\Models\Pedidos;
use Application\Models\Clientes;
use Application\Models\Empresas;
use Application\Models\Empleados;
use Application\Models\Productos;
use Application\Models\Categorias;
use Application\Models\Documentos;
use Application\Models\Movimientos;
use Application\Models\MetodosPagos;
use Application\Models\SerieNumeros;
use Application\Models\CatalogoTabla;
use Application\Models\MetodosEnvios;
use Application\Models\UbicacionAlmacen;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Application\Core\Controller as Controller;
use Application\Controllers\CanjePuntosController;
use Application\Controllers\MovimientosController;
use Application\Models\Cajas;
use Application\Models\CartaDigital;
use Application\Models\Cotizacion;
use Application\Models\MovimientosTesoreria;


class PedidosController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $categorias;
    public $productos;
    public $catalogotabla;
    public $clientes;
    public $ubigeo;
    public $pedidos;
    public $sedes;
    public $empresas;
    public $empleados;
    public $documentos;

    public $metodosPagos;
    public $metodosEnvios;
    public $serieNumeros;
    public $movimientos;
    public $ubicacionAlmacen;
    public $cajas;

    public $movimientosTesoreria;

    public $sUrlRealizarVenta        = "realizar-venta";
    public $sUrlGestionVentas        = "gestion-ventas";
    public $sUrlReporteGestionVentas = "reporte-gestion-de-ventas";
    public $sUrlAnulaVentas          = "anula-ventas";

    public $sDocumento = "PEDIDO";
    public $cartaDigital;
    public $cotizacion;

    public function __construct()
    {
        parent::__construct();
        $this->session                          = new Session();
        $this->catalogotabla                    = new CatalogoTabla();
        $this->categorias                       = new Categorias();
        $this->productos                        = new Productos();
        $this->clientes                         = new Clientes();
        $this->ubigeo                           = new Ubigeo();
        $this->pedidos                          = new Pedidos();
        $this->metodosPagos                     = new MetodosPagos();
        $this->metodosEnvios                    = new MetodosEnvios();
        $this->sedes                            = new Sedes();
        $this->empresas                         = new Empresas();
        $this->empleados                        = new Empleados();
        $this->documentos                       = new Documentos();
        $this->serieNumeros                     = new SerieNumeros();
        $this->movimientos                      = new Movimientos();
        $this->ubicacionAlmacen                 = new UbicacionAlmacen();
        $this->cajas                            = new Cajas();
        $this->movimientosTesoreria             = new MovimientosTesoreria();
        $this->cartaDigital                     = new CartaDigital();
        $this->cotizacion                       = new Cotizacion();
        $this->session->init();
    }


    public function realizarVenta()
    {
        try {
            $this->authAdmin($this->session);

            $nRegistroCotizacion = isset($_REQUEST["nRegistroCotizacion"]) ? $_REQUEST["nRegistroCotizacion"] : 0;

            $user    = $this->session->get('user');
            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            $aryCajas =  [];


            if ($bIsAdmin) {
                $aryCajas =   $this->cajas->fncGetCajaDiaria(["nIdSede" => $user["nIdSede"], "dFechaHoraApertura" => date("d/m/Y"), "nEstado" => 1]);
            } else {

                $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->fncGetVista())) ? null : $user["nIdEmpleado"];
                $aryCajas       =  $this->cajas->fncGetCajaDiaria(["nIdSede" => $user["nIdSede"], "nIdEmpleado" => $nIdResponsable, "dFechaHoraApertura" => date("d/m/Y"), "nEstado" => 1]);
            }

            $this->view('admin/realizar-venta', [
                'sTitulo'                    => 'Realizar Venta',
                'user'                       => $user,
                'bShowMenu'                  => true,
                'aryMetodosPagos'            => $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSede" => $user["nIdSede"]]),
                'aryMetodosEnvio'            => $this->metodosEnvios->fncGetSedesMetodosEnvio(["nIdSede" => $user["nIdSede"]]),
                'aryEstadoPago'              => $this->catalogotabla->fncListado("ESTADO_PAGO_PEDIDO"),
                'aryEstadoEnvio'             => $this->catalogotabla->fncListado("ESTADO_ENVIO_PEDIDO"),
                'aryProductos'               => (new ProductosController())->fncObtenerProductoVentas(),
                'aryTipoDocumento'           => $this->catalogotabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryDepartamentos'           => $this->ubigeo->fncObtenerDepartamentos(),
                'nIdEstadoPagoPagado'        => $this->fncGetVarConfig("nIdEstadoPagoPagado"),
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->sUrlRealizarVenta) ? 1 : 0,
                'aryTipoComprobante'         => $this->catalogotabla->fncListado("TIPO_COMPROBANTE"),
                "arySede"                    => $arySede,
                "aryCajas"                   => $aryCajas,
                "aryResponsableDelivery"     => $this->empleados->fncGetEmpleados(["nIdSede" => $user["nIdSede"], "nDelivery" => 1]),
                "nTipoComproFactura"         => $this->fncGetVarConfig("nTipoComproFactura"),
                "nTipoComproBoleta"          => $this->fncGetVarConfig("nTipoComproBoleta"),
                "nTipoComproOrdenCompra"     => $this->fncGetVarConfig("nTipoComproOrdenCompra"),
                "nTipoDocDNI"                => $this->fncGetVarConfig("nTipoDocDNI"),
                "nTipoDocRUC"                => $this->fncGetVarConfig("nTipoDocRUC"),
                "nIdMetodoEnvioRT"           => $this->fncGetVarConfig("nIdMetodoEnvioRT"),
                "nEstadoEnvioEntregado"      => $this->fncGetVarConfig("nEstadoEnvioEntregado"),
                "nIdEstadoAprobadoCD"        => $this->fncGetVarConfig("nIdEstadoAprobadoCD"),
                "nRegistroCotizacion"        => $nRegistroCotizacion
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function gestionVentas()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            // Si es dueno del negocio o es administrador por rol de submodulo
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlGestionVentas)) ? null : $user["nIdEmpleado"];

            $aryPedidos     = $this->pedidos->fncObtenerPedidos(["nIdSede" => $user["nIdSede"], "nIdResponsable" => $nIdResponsable]);
            $aryIdPedidos   = fncValidateArray($aryPedidos) ? array_unique(array_column($aryPedidos, "nIdPedido"))  : [];



            # Valida la url por realizar venta
            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->sUrlRealizarVenta);

            $aryCaja =  [];
            if ($bIsAdmin) {
                $aryCaja =  [];
            } else {

                $nIdEmpleado  = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"],   $this->sUrlRealizarVenta)) ? null : $user["nIdEmpleado"];
                $aryCaja      = $this->cajas->fncGetCajaDiaria(["nIdSede" => $user["nIdSede"], "nIdEmpleado" => $nIdEmpleado, "dFechaHoraApertura" => date("d/m/Y"), "nEstado" => 1]);
                $aryCaja      = fncValidateArray($aryCaja) ? $aryCaja[0] : null;
            }


            $this->view('admin/gestion-ventas', [
                'sTitulo'                    => 'Gestion de Ventas',
                'user'                       => $user,
                'aryIdPedidos'               => $aryIdPedidos,
                'aryPedidos'                 => $aryPedidos,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->sUrlGestionVentas) ? 1 : 0,
                'aryClientes'                => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'aryProductos'               => (new ProductosController())->fncObtenerProductoVentas(),
                'aryTipoDocumento'           => $this->catalogotabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryDepartamentos'           => $this->ubigeo->fncObtenerDepartamentos(),
                'nIdEstadoPagoPagado'        => $this->fncGetVarConfig("nIdEstadoPagoPagado"),
                'aryTipoComprobante'         => $this->catalogotabla->fncListado("TIPO_COMPROBANTE"),
                "arySede"                    => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
                'aryMetodosPagos'            => $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSede" => $user["nIdSede"]]),
                'aryMetodosEnvio'            => $this->metodosEnvios->fncGetSedesMetodosEnvio(["nIdSede" => $user["nIdSede"]]),
                'aryEstadoPago'              => $this->catalogotabla->fncListado("ESTADO_PAGO_PEDIDO"),
                'aryEstadoEnvio'             => $this->catalogotabla->fncListado("ESTADO_ENVIO_PEDIDO"),
                "nTipoComproFactura"         => $this->fncGetVarConfig("nTipoComproFactura"),
                "nTipoComproBoleta"          => $this->fncGetVarConfig("nTipoComproBoleta"),
                "nTipoComproOrdenCompra"     => $this->fncGetVarConfig("nTipoComproOrdenCompra"),
                "nTipoDocDNI"                => $this->fncGetVarConfig("nTipoDocDNI"),
                "nTipoDocRUC"                => $this->fncGetVarConfig("nTipoDocRUC"),
                "nIdMetodoEnvioRT"           => $this->fncGetVarConfig("nIdMetodoEnvioRT"),
                "nEstadoEnvioEntregado"      => $this->fncGetVarConfig("nEstadoEnvioEntregado"),

                "aryResponsableDelivery"     => $this->empleados->fncGetEmpleados(["nIdSede" => $user["nIdSede"], "nDelivery" => 1]),

                'aryMetodosPagos'            => $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSede" => $user["nIdSede"]]),
                'aryMetodosEnvio'            => $this->metodosEnvios->fncGetSedesMetodosEnvio(["nIdSede" => $user["nIdSede"]]),
                'aryEstadoPago'              => $this->catalogotabla->fncListado("ESTADO_PAGO_PEDIDO"),
                'aryEstadoEnvio'             => $this->catalogotabla->fncListado("ESTADO_ENVIO_PEDIDO"),
                'nIdCajaEmpleadoVenta'       => isset($aryCaja["nIdCaja"]) ? $aryCaja["nIdCaja"] : 0,
                "nIdEstadoAprobadoCD"        => $this->fncGetVarConfig("nIdEstadoAprobadoCD")

            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteGestionVentas()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionVentas)) ? null : $user["nIdEmpleado"];

            $aryPedidos     = $this->pedidos->fncObtenerPedidos(["nIdSede" => $user["nIdSede"], "nIdResponsable" => $nIdResponsable, "nFacturado" => 1]);

            $aryIdPedidos = fncValidateArray($aryPedidos) ? array_unique(array_column($aryPedidos, "nIdPedido"))  : [];

            $this->view('admin/reporte-gestion-ventas', [
                'sTitulo'                    => 'Reporte gestion de ventas',
                'user'                       => $user,
                'aryIdPedidos'               => $aryIdPedidos,
                'aryPedidos'                 => $aryPedidos,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionVentas) ? 1 : 0,
                'aryClientes'                => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'aryProductos'               => (new ProductosController())->fncObtenerProductoVentas(),
                "arySede"                    => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
                'aryMetodosPagos'            => $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSede" => $user["nIdSede"]]),
                'aryMetodosEnvio'            => $this->metodosEnvios->fncGetSedesMetodosEnvio(["nIdSede" => $user["nIdSede"]]),
                'aryEstadoPago'              => $this->catalogotabla->fncListado("ESTADO_PAGO_PEDIDO"),
                'aryEstadoEnvio'             => $this->catalogotabla->fncListado("ESTADO_ENVIO_PEDIDO"),

            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteCuadroComparativo()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/reporte-cuadro-comparativo', [
                'sTitulo'      => 'Reporte cuadro comparativo',
                'user'         => $user,
                'bShowMenu'    => true,
                "nAdmin"       => $this->fncIsAdmin($user["nIdRol"], $this->sUrlGestionVentas) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function anulacionesVentas()
    {
        try {
            $this->authAdmin($this->session);

            $user    = $this->session->get('user');
            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/anulaciones-ventas', [
                'sTitulo'                    => 'Anulacion para ventas',
                'user'                       => $user,
                'bShowMenu'                  => true,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteVentasUsuario()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');


            $aryResponsable     = $this->pedidos->fncObtenerResponsables($user["nIdSede"]);

            $this->view('admin/reporte-ventas-usuario', [
                'sTitulo'                    => 'Reporte ventas por Empleado',
                'user'                       => $user,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                'aryResponsable'             => $aryResponsable,
                "arySede"                    => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function comisionPorEmpleado()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $aryEmpleados = $this->empleados->fncGetEmpleados(["nIdSede" => $user["nIdSede"], "nDelivery" => 0]);

            $this->view('admin/comision-por-empleado', [
                'sTitulo'         => 'Comision por empleado',
                'user'            => $user,
                'bShowMenu'       => true,
                "nAdmin"          => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                'aryEmpleados'    => $aryEmpleados,
                "arySede"         => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function comisionPorProducto()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/comision-por-producto', [
                'sTitulo'         => 'Comision por producto',
                'user'            => $user,
                'bShowMenu'       => true,
                'aryProductos'    => (new ProductosController())->fncObtenerProductoVentas(),
                "nAdmin"          => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "arySede"         => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function PagosParciales()
    {
        try {
            $this->authAdmin($this->session);

            $user    = $this->session->get('user');
            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0];

            $this->view('admin/pagos-parciales', [

                'sTitulo'                    => 'Ventas pagos parciales',
                'user'                       => $user,
                'bShowMenu'                  => true,
                'aryClientes'                => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'aryProductos'               => (new ProductosController())->fncObtenerProductoVentas(),
                'aryMetodosPagos'            => $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSede" => $user["nIdSede"]]),
                'aryEstadoPago'              => $this->catalogotabla->fncListado("ESTADO_PAGO_PEDIDO"),
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                'aryTipoComprobante'         => $this->catalogotabla->fncListado("TIPO_COMPROBANTE"),
                "arySede"                    => $arySede,

            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function reporteMotorizado()
    {
        try {
            $this->authAdmin($this->session);

            $user           = $this->session->get('user');

            $this->view('admin/reporte-motorizado', [
                'sTitulo'                    => 'Reporte Motorizado',
                'user'                       => $user,
                'bShowMenu'                  => true,
                "nAdmin"                     => $this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionVentas) ? 1 : 0,
                "arySede"                    => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
                "aryResponsablesDelivery"    => $this->empleados->fncGetEmpleados(["nIdSede" => $user["nIdSede"], "nDelivery" => 1])
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulate()
    {
        try {
            $aryIdPedido        = isset($_POST['aryIdPedido']) ? $_POST['aryIdPedido'] : null;
            $aryProductos       = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $nFacturado         = isset($_POST['nFacturado']) ? $_POST['nFacturado'] : null;
            $dFechaInicio       = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin          = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            $aryMetodoPago      = isset($_POST['aryMetodoPago']) ? $_POST['aryMetodoPago'] : null;
            $aryEstadoPago      = isset($_POST['aryEstadoPago']) ? $_POST['aryEstadoPago'] : null;
            $aryMetodoEnvio     = isset($_POST['aryMetodoEnvio']) ? $_POST['aryMetodoEnvio'] : null;
            $aryEstadoEnvio     = isset($_POST['aryEstadoEnvio']) ? $_POST['aryEstadoEnvio'] : null;

            $aryIdClientes     = isset($_POST['aryIdClientes']) ? $_POST['aryIdClientes'] : null;


            // Valida valores del formulario
            $aryRows        = [];
            $user           = $this->session->get("user");
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlGestionVentas)) ? null : $user["nIdEmpleado"];


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            if (
                is_null($aryIdPedido) && is_null($aryProductos) && is_null($nFacturado) && is_null($dFechaInicio) && is_null($dFechaFin)
                && is_null($aryEstadoEnvio) && is_null($aryEstadoPago) && is_null($aryMetodoEnvio) && is_null($aryEstadoEnvio)
            ) {
                $aryData  = $this->pedidos->fncObtenerPedidos([
                    "nIdResponsable" => $nIdResponsable,
                    "nIdSede"        => $user["nIdSede"],
                    "dFechaCreacion" => date("d/m/Y")
                ]);
            } else {
                $aryData  = $this->pedidos->fncObtenerPedidos([
                    "nIdResponsable"  => $nIdResponsable,
                    "nIdSede"         => $user["nIdSede"],
                    "aryIdPedido"     => $aryIdPedido,
                    "aryProductos"    => $aryProductos,
                    "nFacturado"      => $nFacturado,
                    "dFechaInicio"    => $dFechaInicio,
                    "dFechaFin"       => $dFechaFin,
                    "aryMetodoPago"   => $aryMetodoPago,
                    "aryEstadoPago"   => $aryEstadoPago,
                    "aryMetodoEnvio"  => $aryMetodoEnvio,
                    "aryEstadoEnvio"  => $aryEstadoEnvio,
                    "aryClientes"     => $aryIdClientes
                ]);
            }

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {
                    $sActionDoc         = "fncGenerarDocPedido(" . $aryLoop['nIdPedido'] . " , '" . sp($aryLoop['sNumero']) . "' , '" . $aryLoop["nTipoDocumentoCliente"] . "' , '" . $aryLoop["sNumeroDocumentoCliente"] . "' , '" . fncCleanQuotes($aryLoop["sCliente"]) . "');";
                    $sActionVerFactura  = "fncMostrarDocPedido(" . $aryLoop['nIdDocumento'] . " , '" . sp($aryLoop['sNumero']) . "' , 'ver' );";

                    $sActionShow       = "fncMostrarPedido(" . $aryLoop['nIdPedido'] . ", 'ver' );";
                    $sActionEdit       = "fncMostrarPedido(" . $aryLoop['nIdPedido'] . ", 'editar' );";
                    $sActionEliminar   = "fncEliminarPedido(" . $aryLoop['nIdPedido'] . ");";

                    $sLinkPDF    = '<a target="_blank" href="' . route('pedidos/fncPedidoPdf/' . $aryLoop['nIdPedido']) . '"   title="Ver PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';
                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';

                    // $sLinkFact   = $bIsAdmin && $aryLoop["nFacturado"] == 0 ? '<a onclick="' . $sActionDoc . '" href="javascript:;"   title="Generar comprobante" class="text-primary"><i class="material-icons">paid</i> </a>'  : '';
                    // $sLinkEdit   = $bIsAdmin && $aryLoop["nFacturado"] == 0 ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    // $sLinkDelete = $bIsAdmin && $aryLoop["nFacturado"] == 0 ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sLinkFact   = $aryLoop["nFacturado"] == 0 ? '<a onclick="' . $sActionDoc . '" href="javascript:;"   title="Generar comprobante" class="text-primary"><i class="material-icons">paid</i> </a>'  : '';
                    $sLinkEdit   = $aryLoop["nFacturado"] == 0 ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $aryLoop["nFacturado"] == 0 ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';

                    $sLinkVerFact   = $aryLoop["nFacturado"] == 1 ? '<a onclick="' . $sActionVerFactura . '" href="javascript:;"   title="Ver" class="text-white"><i class="material-icons">remove_red_eye</i> </a>'  : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkFact . '
                                    ' . $sLinkPDF . '
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    # $aryDataTotales =  $this->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);

                    $aryDataDetalles = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop['nIdPedido'], "aryProductos" => $aryProductos]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;
                    $nTotalBrutoDetalle = 0;

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {
                            $nTotalBrutoDetalle += $aryDet["nPrecio"] * $aryDet["nCantidad"];
                            $nTotalCantidad     += $aryDet["nCantidad"];
                            $sDetalle           .= $aryDet["sProducto"] . " |  " . nf($aryDet["nPrecio"]) . " x " . $aryDet["nCantidad"] . "<br>";
                        }
                    }


                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                    $aryRows[] = [
                        "sAcciones"          => $sAcciones,
                        "nIdPedido"          => sp($aryLoop["nIdPedido"]),
                        "sNumero"            => $aryLoop["sNumero"],
                        "sCaja"              => strup($aryLoop["sCaja"]),
                        "sCliente"           => strup($aryLoop["sCliente"]),
                        "sResponsable"       => strup($aryLoop["sResponsable"]),
                        "sMetodoEnvio"       => strup($aryLoop["sMetodoEnvio"]),
                        "sMetodoPago"        => strup($aryLoop["sMetodoPago"]),
                        "sEstadoPago"        => strup($aryLoop["sEstadoPago"]),
                        "sEstadoEnvio"       => strup($aryLoop["sEstadoEnvio"]),
                        "dFechaCreacion"     => $aryLoop["dFechaCreacion"],
                        "sFacturado"         => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryLoop["nFacturado"] == 1 ? '<div class="div-verde">FACTURADO ' . $sLinkVerFact . '</div>' : '<div onclick="' . $sActionDoc . '" class="div-rojo cursor-pointer">SIN FACTURAR</div>'),
                        "sDetalle"           => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                        "nTotalBrutoDetalle" => nf($nTotalBrutoDetalle, true),
                        "nTotalBruto"        => nf($aryLoop["nTotalBruto"], true),
                        "nDsct"              => nf($aryLoop["nTotalDsctSimple"], true),
                        "nDsctCP"            => nf($aryLoop["nTotalDescuentoCanje"], true),
                        "nDsctTotal"         => nf($aryLoop["nTotalDsct"], true),
                        "nSubtotal"          => nf($aryLoop["nSubTotal"], true),
                        "nIgv"               => nf($aryLoop["nIgv"], true),
                        "nTotal"             => nf($aryLoop["nTotal"], true),

                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sDespachado"      => $aryLoop["nDespachado"] == 1 ? "DESPACHADO" : "SIN DESPACHAR",
                        "sMotorizado"      => $aryLoop["sMotorizado"]

                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncPopulatePagosParciales()
    {
        try {
            $aryIdPedido        = isset($_POST['aryIdPedido']) ? $_POST['aryIdPedido0'] : null;
            $dFechaInicio       = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin          = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;


            // Valida valores del formulario
            $aryRows        = [];
            $user           = $this->session->get("user");
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->fncGetVista())) ? null : $user["nIdEmpleado"];


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            $aryData  = $this->pedidos->fncObtenerPedidos([
                "nIdResponsable"    => $nIdResponsable,
                "nIdSede"           => $user["nIdSede"],
                "aryIdPedido"       => $aryIdPedido,
                "nCondicionPago"    => 2,
                "dFechaInicio"      => $dFechaInicio,
                "dFechaFin"         => $dFechaFin,

            ]);


            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {
                    $aryDataTotales =  $this->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);

                    $aryDataDetalles = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop['nIdPedido']]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {
                            $nTotalCantidad += $aryDet["nCantidad"];
                            $sDetalle       .= $aryDet["sProducto"] . " |  " . nf($aryDet["nPrecio"]) . " x " . $aryDet["nCantidad"] . "<br>";
                        }
                    }

                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');


                    $sActionConfig  = "fncConfigPagosParciales(" . $aryLoop['nIdPedido'] . " , " . $aryLoop["nIdPedidoCuota"] . " , " . $aryDataTotales["nTotal"] . ");";
                    $sLinkConfig    =  '<a onclick="' . $sActionConfig . '" href="javascript:;" title="Configurar cuotas" class="text-primary"><i class="material-icons">settings</i> </a>';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkConfig . '
                                 </div>';



                    $aryRows[] = [
                        "sAcciones"          => $sAcciones,
                        "nIdPedido"          => sp($aryLoop["nIdPedido"]),
                        "sNumero"            => $aryLoop["sNumero"],
                        "sCliente"           => strup($aryLoop["sCliente"]),
                        "sResponsable"       => strup($aryLoop["sResponsable"]),
                        "sMetodoEnvio"       => strup($aryLoop["sMetodoEnvio"]),
                        "sMetodoPago"        => strup($aryLoop["sMetodoPago"]),
                        "sEstadoPago"        => strup($aryLoop["sEstadoPago"]),
                        "sEstadoEnvio"       => strup($aryLoop["sEstadoEnvio"]),
                        "dFechaCreacion"     => $aryLoop["dFechaCreacion"],
                        "sFacturado"         => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryLoop["nFacturado"] == 1 ? '<div class="div-verde">FACTURADO </div>' : '<div class="div-rojo cursor-pointer">SIN FACTURAR</div>'),
                        "sDetalle"           => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",

                        "nTotalBruto"        => nf($aryDataTotales["nTotalBruto"], true),
                        "nDsct"              => nf($aryDataTotales["nDsct"], true),
                        "nDsctCP"            => nf($aryDataTotales["nDsctCP"], true),
                        "nDsctTotal"         => nf($aryDataTotales["nDsctTotal"], true),
                        "nSubtotal"          => nf($aryDataTotales["nSubtotal"], true),
                        "nIgv"               => nf($aryDataTotales["nIgv"], true),
                        "nTotal"             => nf($aryDataTotales["nTotal"], true),
                        "sEstado"            => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sDespachado"        => $aryLoop["nDespachado"] == 1 ? "DESPACHADO" : "SIN DESPACHAR",

                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    # Este metodo sirve para anular pedidos exclusivamente  para anular pedidos
    public function fncPopulateAnulaciones()
    {
        try {


            // Valida valores del formulario
            $aryRows        = [];
            $user           = $this->session->get("user");
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlAnulaVentas)) ? null : $user["nIdEmpleado"];


            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            $aryData  = $this->pedidos->fncObtenerPedidos([
                "nIdSede"        => $user["nIdSede"],
            ]);


            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->sUrlAnulaVentas);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {
                    $nNewState          = $aryLoop["nEstado"] == 1 ? 0 : 1;
                    $sIconState         = $aryLoop['nEstado'] == 1 ? 'power_settings_new' : 'check';
                    $sTitleState        = $aryLoop['nEstado'] == 1 ? 'Anular Venta' : 'Quitar Anulacion';

                    $sActionAnular     = "fncCambiarEstado(" . $aryLoop['nIdPedido'] . " , '" . $nNewState . "');";
                    $sLinkPDF          = '<a target="_blank" href="' . route('pedidos/fncPedidoPdf/' . $aryLoop['nIdPedido']) . '"   title="Ver PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';
                    $sLinkAnular       = '<a onclick="' . $sActionAnular . '" href="javascript:;" title="' . $sTitleState . '" class="text-primary"><i class="material-icons">' . $sIconState . '</i> </a>';

                    $sAcciones = '<div class="content-acciones">
                                     ' . $sLinkPDF . '
                                     ' . $sLinkAnular . '
                                </div>';

                    # $aryDataTotales =  $this->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);

                    $aryDataDetalles = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop['nIdPedido']]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {
                            $nTotalCantidad += $aryDet["nCantidad"];
                            $sDetalle       .= $aryDet["sProducto"] . " |  " . nf($aryDet["nPrecio"]) . " x " . $aryDet["nCantidad"] . "<br>";
                        }
                    }

                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                    $aryRows[] = [
                        "sAcciones"        => $sAcciones,
                        "nIdPedido"        => sp($aryLoop["nIdPedido"]),
                        "sNumero"          => $aryLoop["sNumero"],
                        "sCliente"         => strup($aryLoop["sCliente"]),
                        "sResponsable"     => strup($aryLoop["sResponsable"]),
                        "sMetodoEnvio"     => strup($aryLoop["sMetodoEnvio"]),
                        "sMetodoPago"      => strup($aryLoop["sMetodoPago"]),
                        "sEstadoPago"      => strup($aryLoop["sEstadoPago"]),
                        "sEstadoEnvio"     => strup($aryLoop["sEstadoEnvio"]),
                        "dFechaCreacion"   => $aryLoop["dFechaCreacion"],
                        "sFacturado"       => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryLoop["nFacturado"] == 1 ? '<div class="div-verde">FACTURADO </div>' : '<div class="div-rojo">SIN FACTURAR</div>'),
                        "sDetalle"         => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                        "nSubtotal"        => nf($aryLoop["nSubTotal"], true),
                        "nIgv"             => nf($aryLoop["nIgv"], true),
                        "nTotal"           => nf($aryLoop["nTotal"], true),
                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sDespachado"      => $aryLoop["nDespachado"] == 1 ? "DESPACHADO" : "SIN DESPACHAR",

                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateReporteMotorizado()
    {
        try {
            $nIdResponsableDelivery   = isset($_POST['nIdResponsableDelivery']) ? $_POST['nIdResponsableDelivery'] : null;

            $nFacturado               = isset($_POST['nFacturado']) ? $_POST['nFacturado'] : null;
            $dFechaInicio             = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin                = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            // Valida valores del formulario
            $aryRows        = [];
            $user           = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            $aryData  = $this->pedidos->fncObtenerPedidos([
                "nIdResponsableDelivery" => $nIdResponsableDelivery,
                "nFacturado"             => $nFacturado,
                "dFechaInicio"           => $dFechaInicio,
                "dFechaFin"              => $dFechaFin,
                "nIdSede"                => $user["nIdSede"],
            ]);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $aryDataDetalles = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop['nIdPedido']]);
                    $sDetalle        = "";
                    $nTotalCantidad  = 0;

                    if (fncValidateArray($aryDataDetalles)) {
                        foreach ($aryDataDetalles as $nKey => $aryDet) {
                            $nTotalCantidad += $aryDet["nCantidad"];
                            $sDetalle       .= $aryDet["sProducto"] . " |  " . nf($aryDet["nPrecio"]) . " x " . $aryDet["nCantidad"] . "<br>";
                        }
                    }

                    $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                    $aryRows[] = [
                        "nIdPedido"        => sp($aryLoop["nIdPedido"]),
                        "sNumero"          => $aryLoop["sNumero"],
                        "sCliente"         => strup($aryLoop["sCliente"]),
                        "sResponsable"     => strup($aryLoop["sResponsable"]),
                        "sMetodoEnvio"     => strup($aryLoop["sMetodoEnvio"]),
                        "sMetodoPago"      => strup($aryLoop["sMetodoPago"]),
                        "sEstadoPago"      => strup($aryLoop["sEstadoPago"]),
                        "sEstadoEnvio"     => strup($aryLoop["sEstadoEnvio"]),
                        "dFechaCreacion"   => $aryLoop["dFechaCreacion"],
                        "sFacturado"       => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryLoop["nFacturado"] == 1 ? '<div class="div-verde">FACTURADO </div>' : '<div class="div-rojo">SIN FACTURAR</div>'),
                        "sDetalle"         => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                        "nSubtotal"        => nf($aryLoop["nSubTotal"], true),
                        "nIgv"             => nf($aryLoop["nIgv"], true),
                        "nTotal"           => nf($aryLoop["nTotal"], true),
                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sDespachado"      => $aryLoop["nDespachado"] == 1 ? "DESPACHADO" : "SIN DESPACHAR",
                        "sMotorizado"      => $aryLoop["sMotorizado"]

                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncGetTotalesPedidoById($nIdPedido)
    {
        try {
            $aryPedido        = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdPedido])[0];
            $aryPedidoDetalle = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $nIdPedido]);

            $nSubtotal   = 0;
            $nIgv        = 0;
            $nTotal      = 0;

            $nDsct       = 0;
            $nDsctCP     = 0;
            $nDsctTotal  = 0;
            $nTotalBruto  = 0;

            if (fncValidateArray($aryPedidoDetalle)) {
                foreach ($aryPedidoDetalle as $nKey => $aryDetalle) {
                    $nTotalItem  = $aryDetalle["nPrecio"] *  $aryDetalle["nCantidad"];
                    $nSubtotal  += $nTotalItem;
                }

                # Calculo Totales
                $nTotalBruto    =  $nSubtotal;
                $nDsct          = $nSubtotal * ($aryPedido["nDescuento"] / 100);
                $nDsctCP        = $aryPedido["nDescuentoCanje"];

                $nDsctTotal =  $nDsct + $nDsctCP;

                $nIgv       = $nSubtotal * (IGV / 100);
                $nSubtotal  = $nSubtotal > $nDsctTotal ? ($nSubtotal - $nDsctTotal) - $nIgv : 0;
                $nTotal     = $nSubtotal + $nIgv;
            }

            return ["nTotalBruto" => $nTotalBruto, "nSubtotal" => $nSubtotal, "nDsct" =>  $nDsct, "nDsctCP" =>  $nDsctCP, "nDsctTotal" => $nDsctTotal,  "nIgv" => $nIgv, "nTotal" => $nTotal];
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarPedido()
    {
        $nIdRegistro      = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        $nIdCaja          = isset($_POST['nIdCaja']) ? $_POST['nIdCaja'] : null;

        $nIdCliente       = isset($_POST['nIdCliente']) ? $_POST['nIdCliente'] : null;
        $aryDataProd      = isset($_POST['aryDataProd']) ? $_POST['aryDataProd'] : null;

        $nIdMetodoEnvio    = isset($_POST['nIdMetodoEnvio']) ? $_POST['nIdMetodoEnvio'] : null;
        $nIdMetodoPago     = isset($_POST['nIdMetodoPago']) ? $_POST['nIdMetodoPago'] : null;
        $nEstadoEnvio      = isset($_POST['nEstadoEnvio']) ? $_POST['nEstadoEnvio'] : null;
        $sEstadoEnvio      = isset($_POST['sEstadoEnvio']) ? $_POST['sEstadoEnvio'] : null;

        $nEstadoPago       = isset($_POST['nEstadoPago']) ? $_POST['nEstadoPago'] : null;
        $dFechaCreacion    = isset($_POST['dFechaCreacion']) ? $_POST['dFechaCreacion'] : null;

        $nEfectivo         = isset($_POST['nEfectivo']) ? $_POST['nEfectivo'] : null;
        $nVuelto           = isset($_POST['nVuelto']) ? $_POST['nVuelto'] : null;
        $nTipoMoneda       = isset($_POST['nTipoMoneda']) ? $_POST['nTipoMoneda'] : null;
        $nDespachado       = isset($_POST['nDespachado']) ? $_POST['nDespachado'] : null;

        $nDescuento         = isset($_POST['nDescuento']) ? $_POST['nDescuento'] : null; // Porcentaje de descuento
        $nDescuentoCanje    = isset($_POST['nDescuentoCanje']) ? $_POST['nDescuentoCanje'] : null; // Monto de descuento
        $nPuntosCanje       = isset($_POST['nPuntosCanje']) ? $_POST['nPuntosCanje'] : null;  // Cantidad de puntos canjeados
        $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;  // Cantidad de puntos canjeados


        $nCondicionPago     = isset($_POST['nCondicionPago']) ? $_POST['nCondicionPago'] : null;


        $nPorcentajeIGV           = isset($_POST['nPorcentajeIGV']) ? $_POST['nPorcentajeIGV'] : null;
        $nTotalBruto              = isset($_POST['nTotalBruto']) ? $_POST['nTotalBruto'] : null;


        $nTotalDsctSimple         = isset($_POST['nTotalDsctSimple']) ? $_POST['nTotalDsctSimple'] : null;
        $nTotalDescuentoCanje     = isset($_POST['nTotalDescuentoCanje']) ? $_POST['nTotalDescuentoCanje'] : null;

        $nTotalDsct               = isset($_POST['nTotalDsct']) ? $_POST['nTotalDsct'] : null;
        $nSubTotal                = isset($_POST['nSubTotal']) ? $_POST['nSubTotal'] : null;
        $nIgv                     = isset($_POST['nIgv']) ? $_POST['nIgv'] : null;
        $nTotal                   = isset($_POST['nTotal']) ? $_POST['nTotal'] : null;

        $nIdResponsableDelivery   = isset($_POST['nIdResponsableDelivery']) ? $_POST['nIdResponsableDelivery'] : null;
        $nIdCuentaCorriente       = isset($_POST['nIdCuentaCorriente']) ? $_POST['nIdCuentaCorriente'] : null;
        $nEstado                  = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
        $nIdPedidoCD              = isset($_POST['nIdPedidoCD']) ? $_POST['nIdPedidoCD'] : null;
        $nIdCotizacion            = isset($_POST['nIdCotizacion']) ? $_POST['nIdCotizacion'] : null;

        try {



            // Valida valores del formulario
            if (is_null($nIdRegistro)  || is_null($nIdCliente) || is_null($nDespachado)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $nIdCaja = $nIdCaja == 0 ? null : $nIdCaja;

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdPedidoNew = null;

            $nIdResponsable = $user["nIdRol"] == $this->fncGetVarConfig("nIdRolAdmin") ? $user["nIdUsuario"] : $user["nIdEmpleado"];

            // var_dump($nIdResponsable);
            // exit;

            $aryDataSerieNumero = $this->serieNumeros->fncGetSerieNumerosByNomSerie($this->sDocumento, $user["nIdEmpresa"], $user["nIdSede"]);

            if (!fncValidateArray($aryDataSerieNumero)) {
                $this->exception('Error. No se encontro una serie y numero para el documento ' . $this->sDocumento . '. Por favor verifique.');
            }

            $aryPedido = $this->pedidos->fncObtenerPedidos([
                "nIdSede" => $user["nIdSede"],
                "sSerie"  => $aryDataSerieNumero["sPrefijo"],
                "sNumero" => sp($aryDataSerieNumero["sValor"]),
            ]);

            if (fncValidateArray($aryPedido)) {
                $this->exception('Error. Ya existe un numero de pedido con este correlativo para esta sede N° ' . sp($aryDataSerieNumero["sValor"]) . '. Por favor verifique.');
            }

            # Validar el stock del productos ..
            # Valida si esque el producto tiene descompicion y se venden con stock...

            if ($nIdRegistro == 0) {

                if (fncValidateArray($aryDataProd)) {
                    foreach ($aryDataProd as $nKey => $aryData) {
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
            }


            $canjePuntosController = new CanjePuntosController();
            $movimientosTesoreriaController = new MovimientosTesoreriaController();

            // Crear
            if ($nIdRegistro == 0) {

                # Graba el pedido
                $nIdPedidoNew = $this->pedidos->fncGrabarPedido(
                    $nIdCaja,
                    $aryDataSerieNumero["sPrefijo"],
                    sp($aryDataSerieNumero["sValor"]),
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCliente,
                    $nIdResponsable,
                    $nIdMetodoEnvio,
                    $nIdMetodoPago,
                    $nEstadoEnvio,
                    $nEstadoPago,
                    $dFechaCreacion,
                    $nEfectivo,
                    $nVuelto,
                    $nTipoMoneda,
                    $nDespachado,
                    $nDescuento,
                    $nDescuentoCanje,
                    $nPuntosCanje,
                    $sDescripcion,
                    $nCondicionPago,
                    $nPorcentajeIGV,
                    $nTotalBruto,
                    $nTotalDsctSimple,
                    $nTotalDescuentoCanje,
                    $nTotalDsct,
                    $nSubTotal,
                    $nIgv,
                    $nTotal,
                    $nIdResponsableDelivery,
                    $nIdPedidoCD,
                    $nIdCotizacion,
                    $nEstado
                );

                # Graba el detalle del pedido
                if (fncValidateArray($aryDataProd)) {
                    foreach ($aryDataProd as $nKey => $aryData) {
                        $this->pedidos->fncGrabarPedidoDetalle(
                            $nIdPedidoNew,
                            $aryData["nIdProducto"],
                            $aryData["nPrecio"],
                            $aryData["nCantidad"],
                            $aryData["sDetalle"]
                        );
                    }
                }

                # Si tiene una cuenta bancaria vamos a realizar un ingreso 
                if (!is_null($nIdCuentaCorriente) && $nIdCuentaCorriente > 0) {

                    # Ingresamos el movimiento bancario 
                    $this->movimientosTesoreria->fncGrabarRegistro(
                        $nIdCuentaCorriente,
                        "VENTA DEL PEDIDO : " . $aryDataSerieNumero["sPrefijo"] . "-" . sp($aryDataSerieNumero["sValor"]),
                        $this->fncGetVarConfig("nTipoEntidadPedido"),
                        $nIdPedidoNew,
                        $this->fncGetVarConfig("nIngresoMovimientoTesoria"),
                        $nTotal,
                        $nTipoMoneda,
                        0,
                        $nEstado
                    );

                    $movimientosTesoreriaController->fncActualizarSaldoCuentaCorriente($nIdCuentaCorriente);
                }

                if (!is_null($nIdPedidoCD) &&  $nIdPedidoCD != 0) {
                    $this->cartaDigital->fncActualizarFlagVendido($nIdPedidoCD, 1);
                }


                if (!is_null($nIdCotizacion) &&  $nIdCotizacion != 0) {
                    $this->cotizacion->fncActualizarFlagVendido($nIdCotizacion, 1);
                }

                
            } else {

                // Actualizar

                # Obtiene el Pedido

                $movimientoController = new MovimientosController();

                $aryPedido = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdRegistro]);

                if (!fncValidateArray($aryPedido)) {
                    $this->exception('Error. No existe el pedido o se ha eliminado . Por favor verifique.');
                }

                $aryPedido = $aryPedido[0];

                # Si existe algun movimiento libera el movimiento y actualiza el stock
                if ($aryPedido["nIdMovimiento"] > 0) {
                    $movimientoController->fncEliminarMovimiento($aryPedido["nIdMovimiento"]);
                }

                # Una vez devuelto el stock lo vuelve a validar 
                if (fncValidateArray($aryDataProd)) {
                    foreach ($aryDataProd as $nKey => $aryData) {
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

                # Actualiza la cabecera del pedido
                $this->pedidos->fncActualizarPedido(
                    $nIdRegistro,
                    $nIdCaja,
                    $aryDataSerieNumero["sPrefijo"],
                    sp($aryDataSerieNumero["sValor"]),
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCliente,
                    $nIdResponsable,
                    $nIdMetodoEnvio,
                    $nIdMetodoPago,
                    $nEstadoEnvio,
                    $nEstadoPago,
                    $dFechaCreacion,
                    $nEfectivo,
                    $nVuelto,
                    $nTipoMoneda,
                    $nDespachado,
                    $nDescuento,
                    $nDescuentoCanje,
                    $nPuntosCanje,
                    $sDescripcion,
                    $nCondicionPago,
                    $nPorcentajeIGV,
                    $nTotalBruto,
                    $nTotalDsctSimple,
                    $nTotalDescuentoCanje,
                    $nTotalDsct,
                    $nSubTotal,
                    $nIgv,
                    $nTotal,
                    $nIdResponsableDelivery,
                    $nEstado
                );

                # Elimino el detalle del pedido
                $this->pedidos->fncEliminarPedidoDetalleByIdPedido($nIdRegistro);

                # Inserto el detalle del pedido
                if (fncValidateArray($aryDataProd)) {
                    foreach ($aryDataProd as $nKey => $aryData) {
                        $this->pedidos->fncGrabarPedidoDetalle(
                            $nIdRegistro,
                            $aryData["nIdProducto"],
                            $aryData["nPrecio"],
                            $aryData["nCantidad"],
                            $aryData["sDetalle"]
                        );
                    }
                }

                # Si tiene una cuenta bancaria vamos a actualizar el movimiento
                if (!is_null($nIdCuentaCorriente) && $nIdCuentaCorriente > 0) {

                    # Si exite algun movimiento bancario vamos a actualizarlo .. 
                    $aryMovimientosBancarios = $this->movimientosTesoreria->fncGetMovimientos(["nTipoEntidad" => $this->fncGetVarConfig("nTipoEntidadPedido"), "nIdEntidad" => $nIdRegistro]);

                    if (fncValidateArray($aryMovimientosBancarios)) {

                        $aryMovTs = $aryMovimientosBancarios[0];

                        $this->movimientosTesoreria->fncActualizarRegistro(
                            $aryMovTs["nIdMovimientoTesoreria"],
                            $nIdCuentaCorriente,
                            "VENTA DEL PEDIDO : " . $aryDataSerieNumero["sPrefijo"] . "-" . sp($aryDataSerieNumero["sValor"]),
                            $this->fncGetVarConfig("nTipoEntidadPedido"),
                            $nIdRegistro,
                            $this->fncGetVarConfig("nIngresoMovimientoTesoria"),
                            $nTotal,
                            $nTipoMoneda,
                            0,
                            $nEstado
                        );

                        $movimientosTesoreriaController->fncActualizarSaldoCuentaCorriente($nIdCuentaCorriente);
                    }
                }
            }

            # Obtenfo el Id para el descuento del stock

            $nIdPedidoForStock =  $nIdRegistro == 0 ? $nIdPedidoNew : $nIdRegistro;

            if ($nDespachado == 0 && $sEstadoEnvio === 'ENTREGADO') {

                // Descontar el stock

                $movimientosController = new MovimientosController();

                $aryDetallePedido = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $nIdPedidoForStock]);

                # Valida que haya stock
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
                    "Despacho del pedido" . $nIdPedidoNew,
                    $nSalida,
                    null,
                    null,
                    null,
                    $nTipoMoneda,
                    1,
                    $nEstado
                );

                if (fncValidateArray($aryDetallePedido)) {
                    foreach ($aryDetallePedido as $aryLoop) {

                        // Obtenemos data de la descompocicion por el proudcto hijo
                        $aryDescomp = $this->productos->fncGetProductosDescompDet(["nIdProductoHijo" => $aryLoop["nIdProducto"]]);

                        if (fncValidateArray($aryDescomp)) {

                            // Si es un producto de descompocision
                            $aryDescomp  = $aryDescomp[0];

                            $aryProductoPadre = $this->productos->fncGetProductos(["nIdProducto" => $aryDescomp["nIdProductoPadre"]])[0];
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
                $this->pedidos->fncActualizarDespachado($nIdPedidoForStock, 1);

                # Actualizamos el movimiento que se hizo para el descuento de stock
                $this->pedidos->fncActualizarMovimiento($nIdPedidoForStock, $nIdMovimientoNew);


                # Obtener flag para verificar si el cliente puede acumular puntos o no

                $aryCliente = $this->clientes->fncObtenerFlagAcumulaPuntos($nIdCliente)[0];

                if ($aryCliente["nAcumulaPuntos"] == '1') {
                    # Restar puntos que ha canjeado el cliente
                    $this->clientes->fncRestarPuntos($nIdCliente, $nPuntosCanje);

                    # Actualiza los puntos de canje
                    # Suma el total de productos que acumulan puntos y los actualiza
                    $aryDataCP = $canjePuntosController->fncCanjearPuntosByPedido($nIdPedidoForStock);

                    if ($aryDataCP["success"]) {
                        $this->pedidos->fncActualizarPuntosAcumulados($nIdPedidoForStock, $aryDataCP["nPuntos"]);
                    }
                }
            }

            $sSuccess = $nIdRegistro == 0 ? 'Pedido registrado exitosamente...' : 'Pedido actualizado exitosamente...';

            $this->serieNumeros->fncActualizarValorSerieByNomSerie($user["nIdSede"], sp($aryDataSerieNumero["sValor"]), $this->sDocumento);

            $this->json(array(
                "success"            => $sSuccess,
                "nIdPedidoNew"       => $nIdPedidoNew,
                "nIdPedidoNewFormat" => is_null($nIdPedidoNew) ? '' :  sp($nIdPedidoNew),
                "sValor"             => sp($aryDataSerieNumero["sValor"])
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPedidoPdf($nIdPedido)
    {
        try {
            $aryPedido   = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdPedido]);

            if (!fncValidateArray($aryPedido)) {
                $this->exception("Error. No se encontro datos sobre el pedido problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryPedido        = $aryPedido[0];

            $aryPedidoDetalle = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $nIdPedido]);

            if (!fncValidateArray($aryPedidoDetalle)) {
                $this->exception("Error. No se encontro datos sobre el detalle del pedido problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryCliente = $this->clientes->fncGetClientes(["nIdCliente" =>  $aryPedido["nIdCliente"]]);

            if (!fncValidateArray($aryCliente)) {
                $this->exception("Error. No se encontro datos el cliente del pedido problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryCliente = $aryCliente[0];


            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryPedido["nIdSede"]]);

            if (!fncValidateArray($arySede)) {
                $this->exception("Error. No se encontro datos de la sede problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $arySede    = $arySede[0];

            $aryFactura = [];

            if ($aryPedido["nFacturado"] == 1) {
                $aryFactura = $this->documentos->fncObtenerDocumentos(["nIdPedido" => $aryPedido["nIdPedido"]]);
                $aryFactura = fncValidateArray($aryFactura) ? $aryFactura[0] : [];
            }


            // var_dump($aryFactura);
            // exit;


            ob_start();
            $this->view("admin/pdf-pedido", [
                "nIdPedido"         => $nIdPedido,
                "arySede"           => $arySede,
                "sTitulo"           => $aryPedido["nFacturado"] == 1 ? "Nota de venta" : "Pedido",
                "aryCliente"        => $aryCliente,
                "aryPedido"         => $aryPedido,
                "aryFactura"        => $aryFactura,
                "aryPedidoDetalle"  => $aryPedidoDetalle,
                "nA4"               => $arySede["nTipoTicket"] == $this->fncGetVarConfig("nTipoTicketA4")  ? 1 : 0
            ]);
            $html = ob_get_contents();
            ob_end_clean();

            $aryConfig = $arySede["nTipoTicket"] == $this->fncGetVarConfig("nTipoTicketA4") ? [] : [
                'format' => [80, 150], 'orientation' => 'P',
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 2,
                'margin_bottom' => 2,
            ];

            $mpdf = new Mpdf($aryConfig);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarPedido()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryPedido = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdRegistro]);

            if (!fncValidateArray($aryPedido)) {
                $this->exception("Error.No se pudo encontrar el pedido o se haya eliminado.Porfavor verifique");
            }

            # Verifica si existe un movimiento y se limpia el movimiento y acualiza el stock
            $aryPedido = $aryPedido[0];
            if ($aryPedido["nIdMovimiento"] > 0) {
                $movimientosController = new MovimientosController();
                $movimientosController->fncEliminarMovimiento($aryPedido["nIdMovimiento"]);
            }

            if ($aryPedido["nIdPedidoCD"] > 0) {
                $this->cartaDigital->fncActualizarFlagVendido($aryPedido["nIdPedidoCD"], 0);
            }

            if ($aryPedido["nIdCotizacion"] > 0) {
                $this->cartaDigital->fncActualizarFlagVendido($aryPedido["nIdCotizacion"], 0);
            }
            
            $this->pedidos->fncEliminarPedido($nIdRegistro);
            $this->json(array("success" => 'Producto eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarPedido()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryPedido        = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdRegistro]);
            $aryPedidoDetalle = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $nIdRegistro]);

            $this->json(array(
                "success"           => true,
                "aryPedido"         => fncValidateArray($aryPedido) ? $aryPedido[0] : null,
                "aryPedidoDetalle"  => $aryPedidoDetalle
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncExportarExcel()
    {
        try {
            $nTipoReporte     = isset($_POST['nTipoReporte']) ? $_POST['nTipoReporte'] : null;
            $aryProductos     = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $aryClientes      = isset($_POST['aryClientes']) ? $_POST['aryClientes'] : null;
            $aryIdPedido      = isset($_POST['aryIdPedido']) ? $_POST['aryIdPedido'] : null;
            $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            $objExcel = new Excel();


            // Header

            $sReporte = $nTipoReporte == "1" ? "GENERAL" : "DETALLADO";
            $user     = $this->session->get("user");
            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionVentas)) ? null : $user["nIdEmpleado"];


            if ($nTipoReporte == "1") {

                // General
                $user         = $this->session->get("user");
                // $dFecha      = is_null($dFechaInicio) && is_null($dFechaFin) ? date("d/m/Y") : null;
                // nIdEmpleado  = $this->fncGetVarConfig("nIdRolAdmin") == $user["nIdEmpleado"] ? null : $user["nIdEmpleado"];

                $aryData      = $this->pedidos->fncObtenerPedidos([
                    "nIdSede"           => $user["nIdSede"],
                    "nIdResponsable"    => $nIdResponsable,
                    "aryClientes"       => $aryClientes,
                    "aryIdPedido"       => $aryIdPedido,
                    "aryProductos"      => $aryProductos,
                    "dFechaInicio"      => $dFechaInicio,
                    "dFechaFin"         => $dFechaFin,
                    "nFacturado"        => 1
                ]);

                $nRow = 1;

                $objExcel->sheet->mergeCells('A' . $nRow . ':F' . $nRow);
                $objExcel->sheet->setCellValue('A' . $nRow, "FECHA : " . date("d/m/Y") . " - HORA : " . date("H:i:s"));
                $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

                $sTitulo = "";

                $nRow++;
                $nRow++;

                if (strlen($dFechaInicio) > 0 &&  strlen($dFechaFin) > 0) {
                    if ($dFechaInicio == $dFechaFin) {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio;
                    } else {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio . ' AL ' . $dFechaFin;
                    }
                } else {
                    $sTitulo = ' REPORTE ' . $sReporte . ' DE VENTAS ';
                }

                if (strlen($sTitulo) > 0) {
                    $objExcel->sheet->mergeCells('A' . $nRow . ':F' . $nRow);
                    $objExcel->sheet->setCellValue('A' . $nRow, $sTitulo);
                    $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader);
                }

                $nTotalReporte = 0;


                if (fncValidateArray($aryData)) {
                    $aryHeader  = ['Item', 'Descripcion', 'Fecha', 'Precio', 'Cantidad', 'Total'];
                    $aryCols    = ['nItem', 'sProducto', 'dFechaCreacion', 'nPrecio', 'nCantidad', 'nTotal'];

                    foreach ($aryData as $nKey => $aryLoop) {
                        $nRow++;

                        $nRow++;

                        $objExcel->sheet->mergeCells('A' . $nRow . ':F' . $nRow);
                        $objExcel->sheet->setCellValue('A' . $nRow, 'VENTA : ' . sp($aryLoop["sNumero"]) . ' - CLI : ' . $aryLoop["sCliente"] . ' - EMP : ' . $aryLoop["sResponsable"]);
                        $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader2);

                        $nRow++;
                        foreach ($aryHeader as $nKeyLetra => $sValor) {
                            $objExcel->sheet->setCellValue($objExcel->aryL[$nKeyLetra] . $nRow, $sValor);
                            $objExcel->sheet->getStyle($objExcel->aryL[$nKeyLetra] . $nRow)->applyFromArray($objExcel->styleArrayRows);
                            $objExcel->sheet->getStyle($objExcel->aryL[$nKeyLetra] . $nRow)->getFont()->setBold(true);;
                        }



                        // Fin de header


                        // Cuerpo

                        $aryDataDetalle = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop["nIdPedido"]]);

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


                        # Calculo Totales

                        $nTotalBruto =   $nSubtotalItem;

                        $nDsct      = $nSubtotalItem * ($aryLoop["nDescuento"] / 100);
                        $nDsctCP    = $aryLoop["nDescuentoCanje"];

                        $nDsctTotal =  $nDsct + $nDsctCP;

                        $nIgvItem       = $nSubtotalItem * (IGV / 100);
                        $nSubtotalItem  = $nSubtotalItem > $nDsctTotal ? ($nSubtotalItem - $nDsctTotal) - $nIgvItem : 0;
                        $nTotalItem     = $nSubtotalItem + $nIgvItem;

                        $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                        $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL BRUTO ');
                        $objExcel->sheet->setCellValue('F' . $nRow, nf($nTotalBruto, true));
                        $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayRows);


                        $nRow++;

                        $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                        $objExcel->sheet->setCellValue('A' . $nRow, ' DSCT TOTAL ');
                        $objExcel->sheet->setCellValue('F' . $nRow, nf($nDsctTotal, true));
                        $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayRows);


                        $nRow++;

                        $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                        $objExcel->sheet->setCellValue('A' . $nRow, ' SUBTOTAL ');
                        $objExcel->sheet->setCellValue('F' . $nRow, nf($nSubtotalItem, true));
                        $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayRows);

                        $nRow++;

                        $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                        $objExcel->sheet->setCellValue('A' . $nRow, ' IGV ');
                        $objExcel->sheet->setCellValue('F' . $nRow, nf($nIgvItem, true));
                        $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayRows);

                        $nRow++;

                        $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                        $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL ');
                        $objExcel->sheet->setCellValue('F' . $nRow, nf($nTotalItem, true));
                        $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayRows);
                        $nTotalReporte += $nTotalItem;
                    }
                }

                $nRow++;
                $nRow++;
                $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL GENERAL ');
                $objExcel->sheet->setCellValue('F' . $nRow, nf($nTotalReporte, true));
                $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

                foreach (range('A', 'F') as $columnID) {
                    $objExcel->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            } elseif ($nTipoReporte == "2") {
                $aryDataDetalle  = $this->pedidos->fncObtenerPedidosDetalle([
                    "nIdSede"           => $user["nIdSede"],
                    "nIdResponsable"    => $nIdResponsable,
                    "aryClientes"       => $aryClientes,
                    "aryIdPedido"       => $aryIdPedido,
                    "aryProductos"      => $aryProductos,
                    "dFechaInicio"      => $dFechaInicio,
                    "dFechaFin"         => $dFechaFin,
                    "nFacturado"        => 1
                ]);

                $nRow = 1;

                $objExcel->sheet->mergeCells('A' . $nRow . ':F' . $nRow);
                $objExcel->sheet->setCellValue('A' . $nRow, "FECHA : " . date("d/m/Y") . " - HORA : " . date("H:i:s"));
                $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

                $sTitulo = "";

                $nRow++;
                $nRow++;

                if (strlen($dFechaInicio) > 0 &&  strlen($dFechaFin) > 0) {
                    if ($dFechaInicio == $dFechaFin) {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio;
                    } else {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio . ' AL ' . $dFechaFin;
                    }
                } else {
                    $sTitulo = ' REPORTE ' . $sReporte . ' DE VENTAS ';
                }

                if (strlen($sTitulo) > 0) {
                    $objExcel->sheet->mergeCells('A' . $nRow . ':F' . $nRow);
                    $objExcel->sheet->setCellValue('A' . $nRow, $sTitulo);
                    $objExcel->sheet->getStyle('A' . $nRow)->applyFromArray($objExcel->styleArrayHeader);
                }

                $nTotalReporte = 0;


                $aryHeader  = ['Item', 'Descripcion', 'Fecha', 'Precio', 'Cantidad', 'Total'];
                $aryCols    = ['nItem', 'sProducto', 'dFechaCreacion', 'nPrecio', 'nCantidad', 'nTotal'];

                $nRow++;

                foreach ($aryHeader as $nKeyLetra => $sValor) {
                    $objExcel->sheet->setCellValue($objExcel->aryL[$nKeyLetra] . $nRow, $sValor);
                    $objExcel->sheet->getStyle($objExcel->aryL[$nKeyLetra] . $nRow)->applyFromArray($objExcel->styleArrayRows);
                    $objExcel->sheet->getStyle($objExcel->aryL[$nKeyLetra] . $nRow)->getFont()->setBold(true);;
                }

                $nRow++;
                $nKeyItem = 0;

                // Cuerpo

                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $keyLoop => $aryDetalle) {
                        $aryIdPedidos[]   = $aryDetalle["nIdPedido"];
                        $nKeyItem++;
                        foreach ($aryCols as $nKeyCol => $sCol) {
                            switch ($sCol) {
                                case 'nItem':
                                    $objExcel->sheet->setCellValue($objExcel->aryL[$nKeyCol] . $nRow, sp($nKeyItem, 4));
                                    break;
                                case 'nTotal':
                                    $nTotalItem      = $aryDetalle["nPrecio"] * $aryDetalle["nCantidad"];
                                    $nTotalReporte   += $nTotalItem;
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



                $nTotalDsct   = 0;
                $aryIdPedidos = array_unique($aryIdPedidos);
                foreach ($aryIdPedidos as $key => $nIdPedido) {
                    $aryTotales = $this->fncGetTotalesPedidoById($nIdPedido);
                    $nTotalDsct += $aryTotales["nDsctTotal"];
                }



                $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL BRUTO ');
                $objExcel->sheet->setCellValue('F' . $nRow, $nTotalReporte);
                $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

                $nRow++;

                $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL DSCT ');
                $objExcel->sheet->setCellValue('F' . $nRow, $nTotalDsct);
                $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayHeader);

                $nRow++;

                $objExcel->sheet->mergeCells('A' . $nRow . ':E' . $nRow);
                $objExcel->sheet->setCellValue('A' . $nRow, ' TOTAL ');
                $objExcel->sheet->setCellValue('F' . $nRow, $nTotalReporte - $nTotalDsct);
                $objExcel->sheet->getStyle('A' . $nRow . ':F' . $nRow)->applyFromArray($objExcel->styleArrayHeader);
                foreach (range('A', 'F') as $columnID) {
                    $objExcel->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            }




            // Fin de footer
            $sLink  = $sReporte . date("d-m-Y_H-i-s") . ".xlsx";
            $writer = new Xlsx($objExcel->spreadsheet);
            $writer->save((ROOTPATHRESOURCE . "/docs/" . $sLink));

            $this->json(array("success" => "Mostrando datos obtenidos..", "sUrl" => routeDoc($sLink)));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncObtenerDataReporte()
    {
        try {
            $nTipoReporte     = isset($_POST['nTipoReporte']) ? $_POST['nTipoReporte'] : null;
            $aryIdPedido      = isset($_POST['aryIdPedido']) ? $_POST['aryIdPedido'] : null;
            $aryProductos     = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;
            $aryClientes      = isset($_POST['aryClientes']) ? $_POST['aryClientes'] : null;
            $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;


            $aryMetodoPago      = isset($_POST['aryMetodoPago']) ? $_POST['aryMetodoPago'] : null;
            $aryEstadoPago      = isset($_POST['aryEstadoPago']) ? $_POST['aryEstadoPago'] : null;
            $aryMetodoEnvio     = isset($_POST['aryMetodoEnvio']) ? $_POST['aryMetodoEnvio'] : null;
            $aryEstadoEnvio     = isset($_POST['aryEstadoEnvio']) ? $_POST['aryEstadoEnvio'] : null;


            $sReporte    = $nTipoReporte == "1" ? "GENERAL" : "DETALLADO";
            $user        = $this->session->get("user");

            $nIdResponsable = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"], $this->sUrlReporteGestionVentas)) ? null : $user["nIdEmpleado"];

            if ($nTipoReporte == "1") {

                // General
                $user         = $this->session->get("user");


                $aryData     = $this->pedidos->fncObtenerPedidos([
                    "nIdSede"         => $user["nIdSede"],
                    "nIdResponsable"  => $nIdResponsable,
                    "aryProductos"    => $aryProductos,
                    "aryIdPedido"     => $aryIdPedido,
                    "aryClientes"     => $aryClientes,
                    "dFechaInicio"    => $dFechaInicio,
                    "dFechaFin"       => $dFechaFin,
                    "nFacturado"      => 1,
                    "aryMetodoPago"   => $aryMetodoPago,
                    "aryEstadoPago"   => $aryEstadoPago,
                    "aryMetodoEnvio"  => $aryMetodoEnvio,
                    "aryEstadoEnvio"  => $aryEstadoEnvio,
                ]);


                if (strlen($dFechaInicio) > 0 &&  strlen($dFechaFin) > 0) {
                    if ($dFechaInicio == $dFechaFin) {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio;
                    } else {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio . ' AL ' . $dFechaFin;
                    }
                } else {
                    $sTitulo = ' REPORTE ' . $sReporte . ' DE VENTAS ';
                }

                $nTotalReporte = 0;
                $aryRows = [];
                $aryRowForDT = []; // ARREGLO PARA PINTAR EN DATTABLE

                if (fncValidateArray($aryData)) {
                    foreach ($aryData as $nKey => $aryLoop) {
                        $aryDataDetalle  = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop["nIdPedido"]]);
                        $nSubtotalItem   = 0;
                        $aryRowsDetalle  = [];
                        $sDetalle        = "";
                        $nTotalCantidad  = 0;

                        if (fncValidateArray($aryDataDetalle)) {
                            foreach ($aryDataDetalle as $keyLoop => $aryDetalle) {
                                $nTotalCantidad += $aryDetalle["nCantidad"];
                                $sDetalle       .= $aryDetalle["sProducto"] . " |  " . nf($aryDetalle["nPrecio"]) . " x " . $aryDetalle["nCantidad"] . "<br>";

                                $nTotalItem       = $aryDetalle["nPrecio"] * $aryDetalle["nCantidad"];
                                $nSubtotalItem   += $nTotalItem;

                                $aryRowsDetalle[] = [
                                    "nItem"             => sp($keyLoop + 1, 4),
                                    "sProducto"         => strup($aryDetalle["sProducto"]),
                                    "nPrecio"           => nf($aryDetalle["nPrecio"]),
                                    "nCantidad"         => $aryDetalle["nCantidad"],
                                    "dFechaCreacion"    => $aryDetalle["dFechaCreacion"],
                                    "nTotal"            => nf($nTotalItem, true)
                                ];
                            }
                        }

                        $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');


                        # Calculo Totales
                        $nTotalBrutoItem =  $nSubtotalItem;
                        $nDsct      = $nSubtotalItem * ($aryLoop["nDescuento"] / 100);
                        $nDsctCP    = $aryLoop["nDescuentoCanje"];

                        $nDsctTotal =  $nDsct + $nDsctCP;

                        $nIgvItem       = $nSubtotalItem * (IGV / 100);
                        $nSubtotalItem  = $nSubtotalItem > $nDsctTotal ? ($nSubtotalItem - $nDsctTotal) - $nIgvItem : 0;
                        $nTotalItem     = $nSubtotalItem + $nIgvItem;


                        $aryRows[] = [
                            "sTitulo"         => 'VENTA : ' . sp($aryLoop["sNumero"]) . ' - CLI : ' . $aryLoop["sCliente"] . ' - EMP : ' . $aryLoop["sResponsable"],
                            "aryRowsDetalle"  => $aryRowsDetalle,
                            "nIgvItem"        => nf($nIgvItem, true),
                            "nSubtotalItem"   => nf($nSubtotalItem, true),
                            "nTotalItem"      => nf($nTotalItem, true)
                        ];

                        $aryRowForDT[] = [
                            "nIdPedido"        => sp($aryLoop["nIdPedido"]),
                            "sNumero"          => $aryLoop["sNumero"],
                            "sCliente"         => strup($aryLoop["sCliente"]),
                            "sResponsable"     => strup($aryLoop["sResponsable"]),
                            "dFechaCreacion"   => $aryLoop["dFechaCreacion"],
                            "sFacturado"       => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryLoop["nFacturado"] == 1 ? '<div class="div-verde">FACTURADO  </div>' : '<div class="div-rojo">SIN FACTURAR</div>'),
                            "sDetalle"         => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",

                            "nTotalBruto"       => nf($nTotalBrutoItem, true),
                            "nDsctTotal"        => nf($nDsctTotal, true),

                            "nSubtotal"        => nf($nSubtotalItem, true),
                            "nIgv"             => nf($nIgvItem, true),
                            "nTotal"           => nf($nTotalItem, true),
                        ];

                        $nTotalReporte += $nTotalItem;
                    }
                }

                $this->json(["success" => "Mostrando Datos", "sTitulo" => $sTitulo, "aryData" => $aryRows, "aryRowForDT" => $aryRowForDT, "nTotalReporte" => nf($nTotalReporte)]);
            } elseif ($nTipoReporte == "2") {
                $aryDataDetalle  = $this->pedidos->fncObtenerPedidosDetalle([
                    "nIdSede"        => $user["nIdSede"],
                    "nIdResponsable" => $nIdResponsable,
                    "aryIdPedido"    => $aryIdPedido,
                    "aryClientes"    => $aryClientes,
                    "aryProductos"   => $aryProductos,
                    "dFechaInicio"   => $dFechaInicio,
                    "dFechaFin"      => $dFechaFin,
                    "nFacturado"     => 1
                ]);

                if (strlen($dFechaInicio) > 0 &&  strlen($dFechaFin) > 0) {
                    if ($dFechaInicio == $dFechaFin) {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio;
                    } else {
                        $sTitulo = ' REPORTE ' . $sReporte . ' - VENTAS DEL: ' . $dFechaInicio . ' AL ' . $dFechaFin;
                    }
                } else {
                    $sTitulo = ' REPORTE ' . $sReporte . ' DE VENTAS ';
                }

                $nTotalReporte = 0;
                // Cuerpo
                $aryRows  = [];
                $aryIdPedidos  = [];

                if (fncValidateArray($aryDataDetalle)) {
                    foreach ($aryDataDetalle as $keyLoop => $aryDetalle) {
                        $aryIdPedidos[]   = $aryDetalle["nIdPedido"];

                        $nTotalItem       = $aryDetalle["nPrecio"] * $aryDetalle["nCantidad"];
                        $nTotalReporte   += $nTotalItem;

                        $aryRows[] = [
                            "nItem"           => sp($keyLoop + 1, 4),
                            "sProducto"       => strup($aryDetalle["sProducto"]),
                            "nPrecio"         => nf($aryDetalle["nPrecio"]),
                            "nCantidad"       => $aryDetalle["nCantidad"],
                            "dFechaCreacion"  => $aryDetalle["dFechaCreacion"],
                            "nTotal"          => nf($nTotalItem, true),
                        ];
                    }
                }

                $nTotalDsct   = 0;
                $aryIdPedidos = array_unique($aryIdPedidos);
                foreach ($aryIdPedidos as $key => $nIdPedido) {
                    $aryTotales = $this->fncGetTotalesPedidoById($nIdPedido);
                    $nTotalDsct += $aryTotales["nDsctTotal"];
                }


                $aryRows[] = [
                    "nItem"           => '',
                    "sProducto"       => '',
                    "nPrecio"         => '',
                    "nCantidad"       => '',
                    "dFechaCreacion"  => '<b style="font-weight: 700;">Total Bruto</b>',
                    "nTotal"          => nf($nTotalReporte, true),
                ];

                $aryRows[] = [
                    "nItem"           => '',
                    "sProducto"       => '',
                    "nPrecio"         => '',
                    "nCantidad"       => '',
                    "dFechaCreacion"  => '<b style="font-weight: 700;">Total Dsct</b>',
                    "nTotal"          => nf($nTotalDsct, true),
                ];

                $aryRows[] = [
                    "nItem"           => '',
                    "sProducto"       => '',
                    "nPrecio"         => '',
                    "nCantidad"       => '',
                    "dFechaCreacion"  => '<b style="font-weight: 700;">Total Venta</b>',
                    "nTotal"          =>  nf($nTotalReporte - $nTotalDsct),
                ];

                $this->json(["success" => "Mostrando Datos", "sTitulo" => $sTitulo, "aryData" => $aryRows, "nTotalDsct" => $nTotalDsct, "nTotalReporte" => nf($nTotalReporte - $nTotalDsct)]);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetTotalesPedidos($aryProductos = null, $dFechaInicio = null, $dFechaFin = null, $nFacturado = null)
    {
        try {

            // General
            $user        = $this->session->get("user");
            $dFecha      = is_null($dFechaInicio) && is_null($dFechaFin) ? date("d/m/Y") : null;
            $nIdEmpleado = $this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"] ? null : $user["nIdEmpleado"];

            $aryData     = $this->pedidos->fncObtenerPedidos(
                [
                    "nIdSede"        => $user["nIdSede"],
                    "nIdEmpleado"    => $nIdEmpleado,
                    "aryProductos"   => $aryProductos,
                    "dFechaInicio"   => $dFechaInicio,
                    "dFechaFin"      => $dFechaFin,
                    "dFechaCreacion" => $dFecha,
                    "nFacturado"     => $nFacturado,
                ]
            );


            $nTotalReporte = 0;

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $nKey => $aryLoop) {
                    $nSubtotalItem  = 0;
                    $aryDataDetalle = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop["nIdPedido"]]);

                    if (fncValidateArray($aryDataDetalle)) {
                        foreach ($aryDataDetalle as $keyLoop => $aryDetalle) {
                            $nTotalItem       = $aryDetalle["nPrecio"] * $aryDetalle["nCantidad"];
                            $nSubtotalItem   += $nTotalItem;
                        }
                    }


                    # Calculo Totales

                    $nDsct      = $nSubtotalItem * ($aryLoop["nDescuento"] / 100);
                    $nDsctCP    = $aryLoop["nDescuentoCanje"];

                    $nDsctTotal =  $nDsct + $nDsctCP;

                    $nIgvItem       = $nSubtotalItem * (IGV / 100);
                    $nSubtotalItem  = $nSubtotalItem > $nDsctTotal ? ($nSubtotalItem - $nDsctTotal) - $nIgvItem : 0;
                    $nTotalItem     = $nSubtotalItem + $nIgvItem;

                    $nTotalReporte += $nTotalItem;
                }

                return $nTotalReporte;
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncCambiarEstado()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $nEstado     = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryPedido   = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdRegistro]);

            if (!fncValidateArray($aryPedido)) {
                $this->exception("Error.No se encontro el pedido . Porfavor verifique o soliicte asistencia-");
            }

            $aryPedido = $aryPedido[0];

            $movimientosController = new MovimientosController();


            if ($nEstado == 1) {

                // Restablecer siempre y cuando exista un movimiento
                if ($aryPedido["nIdMovimiento"] > 0) {
                    $aryDataDet = $this->movimientos->fncGetMovimientosDetalle(["nIdMovimiento" => $aryPedido["nIdMovimiento"]]);

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

                    // Actualizamos el despacho porque reestablecere el despacho

                    $this->pedidos->fncActualizarDespachado($nIdRegistro, 1);

                    // Si esque existe un documento es decir que este pedido ha sido facutrado
                    if ($aryPedido["nIdDocumento"] > 0) {
                        $this->pedidos->fncActualizarFacturado($nIdRegistro, 1);

                        $this->documentos->fncActualizarEstado($aryPedido["nIdDocumento"], 0);
                        $this->documentos->fncActualizarAnulado($aryPedido["nIdDocumento"], 0);
                    }


                    $aryData = $this->movimientos->fncGetMovimientos(["nIdMovimiento" =>  $aryPedido["nIdMovimiento"]]);

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

                if ($aryPedido["nIdPedidoCD"] > 0) {
                    $this->cartaDigital->fncActualizarFlagVendido($aryPedido["nIdPedidoCD"], 1);
                }
    
                if ($aryPedido["nIdCotizacion"] > 0) {
                    $this->cartaDigital->fncActualizarFlagVendido($aryPedido["nIdCotizacion"], 1);
                }

            } else {

                # Si existe un movimiento vamos a anularlo
                if ($aryPedido["nIdMovimiento"] > 0) {


                    // Quitamos el flag de facturado a el pedido
                    $this->pedidos->fncActualizarFacturado($nIdRegistro, 0);
                    $this->pedidos->fncActualizarDespachado($nIdRegistro, 0);

                    if ($aryPedido["nIdDocumento"] > 0) {
                        $this->documentos->fncActualizarEstado($aryPedido["nIdDocumento"], 0);
                        $this->documentos->fncActualizarAnulado($aryPedido["nIdDocumento"], 1);
                    }


                    $aryData = $this->movimientos->fncGetMovimientos(["nIdMovimiento" => $aryPedido["nIdMovimiento"]]);

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
                }


                if ($aryPedido["nIdPedidoCD"] > 0) {
                    $this->cartaDigital->fncActualizarFlagVendido($aryPedido["nIdPedidoCD"], 0);
                }
    
                if ($aryPedido["nIdCotizacion"] > 0) {
                    $this->cartaDigital->fncActualizarFlagVendido($aryPedido["nIdCotizacion"], 0);
                }

            }

            $this->pedidos->fncActualizarEstado($nIdRegistro, $nEstado);


            $this->json(array(
                "success"   => "Genial. Se cambio el estado del pedido."
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncObtenerReporteResponasbleResumen()
    {
        $aryResponsable   = isset($_POST['aryResponsable']) ? $_POST['aryResponsable'] : null;
        $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
        $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
        $nFacturado       = isset($_POST['nFacturado']) ? $_POST['nFacturado'] : null;

        try {
            if (is_null($aryResponsable) || count($aryResponsable) == 0) {
                $this->exception("Error.No ha pasado todos los parametros .Porfavor verifique");
            }

            $aryData = [];
            foreach ($aryResponsable as $key => $nIdResponsable) {
                $aryPedidos = $this->pedidos->fncObtenerPedidos(["nIdResponsable" => $nIdResponsable, "dFechaInicio" => $dFechaInicio, "dFechaFin" => $dFechaFin, "nFacturado" => $nFacturado]);

                $nTotal       = 0;
                $sResponsable = "";

                if (fncValidateArray($aryPedidos)) {
                    foreach ($aryPedidos as $aryLoop) {
                        $aryDataTotales =  $this->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);
                        $nTotal         += $aryDataTotales["nTotal"];
                        $sResponsable    = $aryLoop["sResponsable"];
                    }

                    $aryData[] = [
                        "sResponsable" => strup($sResponsable),
                        "nTotal"       => $nTotal,
                    ];
                }
            }


            $this->json(array("success"   => "Mostrando resultados obtenidos..", "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncObtenerReporteResponasbleDetalle()
    {
        $aryResponsable   = isset($_POST['aryResponsable']) ? $_POST['aryResponsable'] : null;
        $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
        $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
        $nFacturado       = isset($_POST['nFacturado']) ? $_POST['nFacturado'] : null;



        try {
            if (is_null($aryResponsable) || count($aryResponsable) == 0) {
                $this->exception("Error.No ha pasado todos los parametros .Porfavor verifique");
            }


            $aryRows = [];
            foreach ($aryResponsable as $key => $nIdResponsable) {
                $aryPedidos = $this->pedidos->fncObtenerPedidos(["nIdResponsable" => $nIdResponsable, "dFechaInicio" => $dFechaInicio, "dFechaFin" => $dFechaFin,  "nFacturado" => $nFacturado]);

                if (fncValidateArray($aryPedidos)) {
                    foreach ($aryPedidos as $aryLoop) {
                        $aryDataTotales =  $this->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);

                        $aryDataDetalles = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $aryLoop['nIdPedido']]);
                        $sDetalle        = "";
                        $nTotalCantidad  = 0;

                        if (fncValidateArray($aryDataDetalles)) {
                            foreach ($aryDataDetalles as $nKey => $aryDet) {
                                $nTotalCantidad += $aryDet["nCantidad"];
                                $sDetalle       .= $aryDet["sProducto"] . " |  " . nf($aryDet["nPrecio"]) . " x " . $aryDet["nCantidad"] . "<br>";
                            }
                        }

                        $sNombreDetalle = $nTotalCantidad . ' ' . ($nTotalCantidad == 1 ? 'Articulo' : 'Articulos');

                        $aryRows[] = [
                            "nIdPedido"         => sp($aryLoop["nIdPedido"]),
                            "sNumero"            => $aryLoop["sNumero"],
                            "sCliente"           => strup($aryLoop["sCliente"]),
                            "sResponsable"       => strup($aryLoop["sResponsable"]),
                            "dFechaCreacion"    => $aryLoop["dFechaCreacion"],
                            "sFacturado"         => $aryLoop["nAnulado"] == 1 ? '<div class="div-rojo">ANULADO</div>' : ($aryLoop["nFacturado"] == 1 ? '<div class="div-verde">FACTURADO</div>' : '<div class="div-rojo cursor-pointer">SIN FACTURAR</div>'),
                            "sDetalle"           => "<a href='javascript:;' onclick='fncDesplegarSgt(this);' class='show-order-items'>" . $sNombreDetalle . " </a>" . "<div class='order-items' cellspacing='0'>" . $sDetalle . "</div>",
                            "nTotalBruto"        => nf($aryDataTotales["nTotalBruto"], true),
                            "nDsct"              => nf($aryDataTotales["nDsct"], true),
                            "nDsctCP"            => nf($aryDataTotales["nDsctCP"], true),
                            "nDsctTotal"         => nf($aryDataTotales["nDsctTotal"], true),
                            "nSubtotal"          => nf($aryDataTotales["nSubtotal"], true),
                            "nIgv"               => nf($aryDataTotales["nIgv"], true),
                            "nTotal"             => nf($aryDataTotales["nTotal"], true),
                            "sEstado"            => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                            "sDespachado"        => $aryLoop["nDespachado"] == 1 ? "DESPACHADO" : "SIN DESPACHAR",
                        ];
                    }
                }
            }


            $this->json(array("success"   => "Mostrando resultados obtenidos..", "aryData" => $aryRows));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarCuotasPedido()
    {
        try {
            $nIdRegistro    = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdPedido      = isset($_POST['nIdPedido']) ? $_POST['nIdPedido'] : null;
            $nAdelanto      = isset($_POST['nAdelanto']) ? $_POST['nAdelanto'] : null;
            $nCuotas        = isset($_POST['nCuotas']) ? $_POST['nCuotas'] : null;
            $aryDetalle     = isset($_POST['aryDetalle']) ? $_POST['aryDetalle'] : null;
            $nEstado        = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $nIdPedidoCuota = null;
            // Crear
            if ($nIdRegistro == 0) {
                $nIdPedidoCuota = $this->pedidos->fncGrabarPedidoCuota(
                    $nIdPedido,
                    $nAdelanto,
                    $nCuotas,
                    $nEstado
                );


                # Inserto el detalle del pedido cuota
                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {
                        $this->pedidos->fncGrabarPedidoCuotaDetalle(
                            $nIdPedidoCuota,
                            $nKey + 1,
                            $aryLoop["nMontoCuota"],
                            $aryLoop["nIdMetodoPago"],
                            $aryLoop["nEstadoPago"],
                            $aryLoop["dFechaPago"],
                            $aryLoop["dFechaVencimiento"],
                            $aryLoop["nEstado"]
                        );
                    }
                }
            } else {

                // Actualizar

                # Actualiza la cabecera del pedido cuota
                $this->pedidos->fncActualizarPedidoCuota(
                    $nIdRegistro,
                    $nIdPedido,
                    $nAdelanto,
                    $nCuotas,
                    $nEstado
                );

                # Elimino el detalle del pedido
                $this->pedidos->fncEliminarPedidoCuotaDetalleByIdPedidoCuota($nIdRegistro);

                // var_dump($aryDetalle);

                # Inserto el detalle del pedido cuota
                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {
                        // var_dump($aryLoop);
                        $this->pedidos->fncGrabarPedidoCuotaDetalle(
                            $nIdRegistro,
                            $nKey + 1,
                            $aryLoop["nMontoCuota"],
                            $aryLoop["nIdMetodoPago"],
                            $aryLoop["nEstadoPago"],
                            $aryLoop["dFechaPago"],
                            $aryLoop["dFechaVencimiento"],
                            $aryLoop["nEstado"]
                        );
                    }
                }
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Pedido Cuota registrado exitosamente...' : 'Pedido Cuota actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdPedidoCuota" => $nIdPedidoCuota));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarPedidoCuota()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryPedidoCuota        = $this->pedidos->fncObtenerPedidoCuotas(["nIdPedidoCuota" => $nIdRegistro]);
            $aryPedidoCuotaDetalle = $this->pedidos->fncObtenerPedidoCuotasDetalle(["nIdPedidoCuota" => $nIdRegistro]);

            $this->json(array(
                "success"                => true,
                "aryPedidoCuota"         => fncValidateArray($aryPedidoCuota) ? $aryPedidoCuota[0] : null,
                "aryPedidoCuotaDetalle"  => $aryPedidoCuotaDetalle
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateReporteComision()
    {
        try {
            $aryIdEmpleado      = isset($_POST['aryIdEmpleado']) ? $_POST['aryIdEmpleado'] : null;
            $dFechaInicio       = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin          = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $user              = $this->session->get("user");


            // Valida valores del formulario

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }



            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());
            $aryRows = [];

            if (fncValidateArray($aryIdEmpleado)) {
                foreach ($aryIdEmpleado as $nIdEmpleado) {
                    $aryEmpleado = $this->empleados->fncGetEmpleados(["nIdEmpleado" => $nIdEmpleado])[0];

                    # $aryDataTotales =  $this->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);

                    $aryPedidos = $this->pedidos->fncObtenerPedidos(
                        [
                            "nIdResponsable" => $aryEmpleado['nIdEmpleado'],
                            "dFechaInicio"   => $dFechaInicio,
                            "dFechaFin"      => $dFechaFin,
                            "nFacturado"     => 1
                        ]
                    );

                    $nTotal = 0;

                    if (fncValidateArray($aryPedidos)) {
                        foreach ($aryPedidos as $nKey => $aryLoop) {
                            $nTotal += $aryLoop["nTotal"];
                        }
                    }

                    $nComision = $nTotal * ($aryEmpleado["nPorcentajeComision"] / 100);

                    $aryRows[] = [
                        "sEmpleado"             => $aryEmpleado["sNombre"],
                        "dFechaInicio"          => $dFechaInicio,
                        "dFechaFin"             => $dFechaFin,
                        "nTotalVenta"           => nf($nTotal, true),
                        "nPorcentajeComision"   => $aryEmpleado["nPorcentajeComision"] . '%',
                        "nComision"             => nf($nComision, true)
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateReporteComisionProducto()
    {
        try {
            $aryIdProducto      = isset($_POST['aryIdProducto']) ? $_POST['aryIdProducto'] : null;
            $dFechaInicio        = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin           = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;
            $user                = $this->session->get("user");


            // Valida valores del formulario

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }


            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());
            $aryRows = [];
            if (fncValidateArray($aryIdProducto)) {
                foreach ($aryIdProducto as $nIdProducto) {
                    $aryProducto = $this->productos->fncGetProductos(["nIdProducto" => $nIdProducto])[0];

                    # $aryDataTotales =  $this->fncGetTotalesPedidoById($aryLoop["nIdPedido"]);

                    $aryDetalleProd = $this->pedidos->fncObtenerPedidosDetalle(
                        [
                            "nIdProducto"    => $nIdProducto,
                            "dFechaInicio"   => $dFechaInicio,
                            "dFechaFin"      => $dFechaFin,
                            "nFacturado"     => 1
                        ]
                    );

                    $nTotal = 0;

                    if (fncValidateArray($aryDetalleProd)) {
                        foreach ($aryDetalleProd as $nKey => $aryLoop) {
                            $nTotal += $aryLoop["nPrecio"] * $aryLoop["nCantidad"];
                        }
                    }

                    $nComision = $nTotal * ($aryProducto["nPorcentajeComision"] / 100);

                    $aryRows[] = [
                        "sProducto"             => $aryProducto["sDescripcion"],
                        "dFechaInicio"          => $dFechaInicio,
                        "dFechaFin"             => $dFechaFin,
                        "nTotalVenta"           => nf($nTotal, true),
                        "nPorcentajeComision"   => $aryProducto["nPorcentajeComision"] . '%',
                        "nComision"             => nf($nComision, true)
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
