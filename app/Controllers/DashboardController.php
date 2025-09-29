<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Models\Negocios;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\Clientes;
use Application\Models\Empleados;
use Application\Models\OrdenCompra;
use Application\Models\Pedidos;

class DashboardController extends Controller
{

    //model principal
    public $negocios;
    public $session;
    public $catalogoTabla;
    public $empleados;

    public $users;
    public $clientes;
    public $pedidos;
    public $ordenCompra;

    public $sUrlDashboard = "dashboard";

    public function __construct()
    {
        parent::__construct();
        $this->session       = new Session();
        $this->catalogoTabla = new CatalogoTabla();
        $this->empleados     = new Empleados();
        $this->clientes      = new Clientes();
        $this->pedidos       = new Pedidos();
        $this->ordenCompra   = new OrdenCompra();
        $this->session->init();
    }




    public function dashboard()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/dashboard', [
                'sTitulo'          => 'Dashboard',
                'user'             => $user,
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlDashboard) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncPopulateDashboard()
    {
        try {

            $nIdEmpresa     = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;
            $nIdSede        = isset($_POST['nIdSede']) ? $_POST['nIdSede'] : null;
            $aryIdSede      = isset($_POST['aryIdSede']) ? $_POST['aryIdSede'] : null;
            $dFechaInicio   = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;
            $dFechaFin      = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;


            $aryFilter = [
                "nIdEmpresa"   => $nIdEmpresa,
                "nIdSede"      => $nIdSede,
                "aryIdSede"    => $aryIdSede,
                "dFechaInicio" => $dFechaInicio,
                "dFechaFin"    => $dFechaFin,
            ];

            // clientes 


            $nIdEstadoPagoPagado = $this->fncGetVarConfig("nIdEstadoPagoPagado");
            $aryNuevosClientes   = $this->clientes->fncGetClientes($aryFilter);
            $aryTotalClientes    = $this->clientes->fncGetClientes(["nIdEmpresa"   => $nIdEmpresa]);

            $nTotalNuevosClientes = count($aryNuevosClientes);
            $nTotalClientes       = count($aryTotalClientes);

            // End Clientes

            // Pedidos


            $aryPedidos       = $this->pedidos->fncObtenerPedidos($aryFilter);
            $nCantidadPedidos = count($aryPedidos);
            $nTotalPedidos    = 0;

            if (fncValidateArray($aryPedidos)) {
                foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {

                    # Si esta facturado y la condicion de pago es al contado
                    if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1) {
                        $nTotalPedidos += $aryLoopPedido["nTotal"];
                    } else {

                        # Si la condicion de pago es parcial o en cuotas 
                        # .. solo va a toamr las cuotas que estan pagadas y el adelanto
                        if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {

                            $nTotalPedidoItem = 0;
                            # Suma el adelanto
                            $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];

                            $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(
                                [
                                    "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],
                                    "nEstadoPago"    => $nIdEstadoPagoPagado
                                ]
                            );

                            # Suma las cuotas pagadas del pedido 
                            if (fncValidateArray($aryDataPedidosCuotas)) {
                                foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {
                                    $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];
                                }
                            }

                            $nTotalPedidos += $nTotalPedidoItem;
                        }
                    }
                }
            }


            // End Pedidos

            // Orden de compra

            $aryFilterOC               = $aryFilter;
            $aryFilterOC["nTipo"]      = $this->fncGetVarConfig("nTipoOrdenCompra");
            $aryFilterOC["nEjecutado"] = 1;

            $aryOrdenCompra     = $this->ordenCompra->fncObtenerOrdenCompra($aryFilterOC);
            $nTotalOrdenCompra  = 0;

            if (fncValidateArray($aryOrdenCompra)) {
                foreach ($aryOrdenCompra as $key => $aryLoop) {
                    $aryDetalle = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $aryLoop["nIdOrdenCompra"]]);

                    if (fncValidateArray($aryDetalle)) {
                        foreach ($aryDetalle as $key => $aryLoopDet) {
                            $nTotalItem = $aryLoopDet["nPrecio"] * $aryLoopDet["nCantidad"];
                            $nTotalOrdenCompra += $nTotalItem;
                        }
                    }
                }
            }

            // Fin de orden de compra



            // Gastos

            $aryFilterG                = $aryFilter;
            $aryFilterG["nTipo"]       = $this->fncGetVarConfig("nTipoGasto");
            $aryFilterG["nEjecutado"] = 1;

            $aryOrdenCompra     = $this->ordenCompra->fncObtenerOrdenCompra($aryFilterG);
            $nTotalGastos       = 0;

            if (fncValidateArray($aryOrdenCompra)) {
                foreach ($aryOrdenCompra as $key => $aryLoop) {
                    $aryDetalle = $this->ordenCompra->fncObtenerDetalleOrdenCompra(["nIdOrdenCompra" => $aryLoop["nIdOrdenCompra"]]);

                    if (fncValidateArray($aryDetalle)) {
                        foreach ($aryDetalle as $key => $aryLoopDet) {
                            $nTotalItem = $aryLoopDet["nPrecio"] * $aryLoopDet["nCantidad"];
                            $nTotalGastos += $nTotalItem;
                        }
                    }
                }
            }

            // Fin de gastos


            // Diferencia entre pedidos y (orden de compra + gastos)
            $nOrdenComprasGastos = $nTotalOrdenCompra + $nTotalGastos;
            $nDiferencia         = $nTotalPedidos - ($nTotalOrdenCompra + $nTotalGastos);
            // Fin de diferencia

            // volver a validar el facturado para el datos de los meses 
            $aryFilter["nFacturado"] = 1;

            $aryDataMeses     = $this->pedidos->fncObtenerPedidosByMes($aryFilter);
            $aryDataCategoria = $this->pedidos->fncObtenerDataForReportCategorias($aryFilter);
            $aryDataProducto  = $this->pedidos->fncObtenerDataForReportProductos($aryFilter);
            $aryDataCliente   = $this->pedidos->fncObtenerDataForReportClientes($aryFilter);


            $aryData = [
                "nTotalNuevosClientes" => (int) nf($nTotalNuevosClientes, true),
                "nTotalClientes"       => (int) nf($nTotalClientes, true),
                "nCantidadPedidos"     => (int) nf($nCantidadPedidos, true),
                "nTotalPedidos"        => nf($nTotalPedidos, true),
                "nTotalOrdenCompra"    => nf($nTotalOrdenCompra, true),
                "nTotalGastos"         => nf($nTotalGastos, true),
                "nOrdenComprasGastos"  => nf($nOrdenComprasGastos, true),
                "nDiferencia"          => nf($nDiferencia, true),
                "aryDataMeses"         => $aryDataMeses,
                "aryDataCategoria"     => $aryDataCategoria,
                "aryDataProducto"      => $aryDataProducto,
                "aryDataCliente"       => $aryDataCliente,
            ];

            $this->json(array("success" => "Mostradno resultados obtenidos ...", "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
