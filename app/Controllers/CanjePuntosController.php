<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Models\Pedidos;
use Application\Models\Clientes;
use Application\Models\CanjePuntos;
use Application\Core\Controller as Controller;
use Application\Models\FormulacionAcumulacionPuntos;

class CanjePuntosController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $cp;
    public $sUrlCP = "canje-puntos";
    public $sUrlCPA = "consulta-puntos-acumulados";
    public $sUrlCPC = "consulta-puntos-canjeados";
    public $sUrlCPM = "consulta-puntos-monetarios";

    public $clientes;
    public $pedidos;
    public $fap;

    public function __construct()
    {
        parent::__construct();
        $this->session   = new Session();
        $this->cp        = new CanjePuntos();
        $this->clientes  = new Clientes();
        $this->pedidos   = new Pedidos();
        $this->fap       = new FormulacionAcumulacionPuntos();

        $this->session->init();
    }


    public function index()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/canje-puntos', [
                'sTitulo'          => 'Canje de puntos',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlCP) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }





    public function consultaPuntosAcumulados()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/consulta-puntos-acumulados', [
                'sTitulo'          => 'Consulta puntos Acumulados',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                'aryClientes'      => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlCPA) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function consultaPuntosCanjeados()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/consulta-puntos-canjeados', [
                'sTitulo'          => 'Consulta puntos Canjeados',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                'aryClientes'      => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlCPA) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function consultaPuntosMonetarios()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/consulta-puntos-monetarios', [
                'sTitulo'          => 'Consulta puntos Monetarios',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                'aryClientes'      => $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"]]),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlCPM) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }



    public function fncPopulatePuntosAcumulados()
    {
        try {
            $aryClientes            = isset($_POST['aryClientes']) ? $_POST['aryClientes'] : null;
            $nTienePuntosAcumulados = isset($_POST['nTienePuntosAcumulados']) ? $_POST['nTienePuntosAcumulados'] : null;

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];

            $aryData      = $this->clientes->fncGetClientes([
                "nIdEmpresa"             => $user["nIdEmpresa"],
                "aryClientes"            => $aryClientes,
                "nTienePuntosAcumulados" => $nTienePuntosAcumulados
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlCPA);

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $aryDataPC = $this->pedidos->fncObtenerPedidosQueAcumulanPuntosPorcliente($aryLoop["nIdCliente"]);

                    $aryRows[] = [
                        "sNombreoRazonSocial"     => $aryLoop["sNombreoRazonSocial"],
                        "nPuntosAcumulados"       => $aryLoop["nPuntosAcumulados"],
                        "nCantidadVentas"         => count($aryDataPC)
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncPopulatePuntosCanjeados()
    {
        try {
            $aryClientes            = isset($_POST['aryClientes']) ? $_POST['aryClientes'] : null;
            $nTienePuntosCanje      = isset($_POST['nTienePuntosCanje']) ? $_POST['nTienePuntosCanje'] : null;

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];

            $aryData      = $this->pedidos->fncObtenerReportePuntosCanjeados([
                "nIdEmpresa"             => $user["nIdEmpresa"],
                "aryClientes"            => $aryClientes,
                "nTienePuntosCanje"      => is_null($nTienePuntosCanje) ? null : ($nTienePuntosCanje == 1 ? "  > 0  " :  " <= 0 ") ,
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlCPA);

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $aryRows[] = [
                        "sCliente"         => $aryLoop["sCliente"],
                        "nCantidadVentas"  => $aryLoop["nVentas"],
                        "nPuntosCanje"     => $aryLoop["nPuntosCanje"],
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulatePuntosMontarios()
    {
        try {
            $aryClientes            = isset($_POST['aryClientes']) ? $_POST['aryClientes'] : null;
            $nTienePuntosCanje      = isset($_POST['nTienePuntosCanje']) ? $_POST['nTienePuntosCanje'] : null;

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];

            $aryData      = $this->pedidos->fncObtenerReportePuntosCanjeados([
                "nIdEmpresa"             => $user["nIdEmpresa"],
                "aryClientes"            => $aryClientes,
                "nTienePuntosCanje"      => is_null($nTienePuntosCanje) ? null : ($nTienePuntosCanje == 1 ? "  > 0  " :  " <= 0 ") ,
                "nEstado"                => 1
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlCPA);

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $aryRows[] = [
                        "sCliente"            => $aryLoop["sCliente"],
                        "nCantidadVentas"     => $aryLoop["nVentas"],
                        "nPuntosCanje"        => $aryLoop["nPuntosCanje"],
                        "nDescuentoCanje"     => $aryLoop["nDescuentoCanje"],

                    ];
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
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];
            $aryData      = $this->cp->fncGetCP(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlCP);

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionShow      = "fncMostrarFAP(" . $aryLoop['nIdCanjePuntos'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarFAP(" . $aryLoop['nIdCanjePuntos'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarFAP(" . $aryLoop['nIdCanjePuntos'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"         => $sAcciones,
                        "sDescripcion"      => $aryLoop["sDescripcion"],
                        "nValorInicial"     => $aryLoop["nValorInicial"],
                        "nValorFinal"       => $aryLoop["nValorFinal"],
                        "nPuntos"           => nf($aryLoop["nPuntos"]),
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarCP()
    {
        try {
            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $nValorInicial      = isset($_POST['nValorInicial']) ? $_POST['nValorInicial'] : null;
            $nValorFinal        = isset($_POST['nValorFinal']) ? $_POST['nValorFinal'] : null;
            $nPuntos            = isset($_POST['nPuntos']) ? $_POST['nPuntos'] : null;
            $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $nIdNewEegistro = null;
            // Crear
            if ($nIdRegistro == 0) {
                $nIdNewEegistro = $this->cp->fncGrabarCP(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sDescripcion,
                    $nValorInicial,
                    $nValorFinal,
                    $nPuntos,
                    $nEstado
                );
            } else {

                // Actualizar
                $this->cp->fncActualizarCP(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sDescripcion,
                    $nValorInicial,
                    $nValorFinal,
                    $nPuntos,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Registro agregado exitosamente...' : 'Registro actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdNewEegistro" => $nIdNewEegistro));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarRegistro()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $aryData = $this->cp->fncGetCP(["nIdCanjePuntos" => $nIdRegistro]);

            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));
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


            $this->cp->fncEliminarCP($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncValidarPuntosCliente()
    {
        // Recibe valores del formulario
        $nIdCliente = isset($_POST['nIdCliente']) ? $_POST['nIdCliente'] : null;
        $nPuntos    = isset($_POST['nPuntos']) ? $_POST['nPuntos'] : null;

        try {
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            if (is_null($nIdCliente) || is_null($nPuntos)) {
                $this->exception('Error. Los valores entregados al controlador no estan completos. Por favor verifique.');
            }


            $aryCliente = $this->clientes->fncObtenerFlagAcumulaPuntos($nIdCliente)[0];

            if ($aryCliente["nAcumulaPuntos"] == '0') {
                $this->exception('Error. Este cliente no acumula puntos. Por favor verifique.');
            }


            $aryCliente = $this->clientes->fncGetClientes(["nIdCliente" => $nIdCliente])[0];

            if ($aryCliente["nPuntosAcumulados"] == 0) {
                $this->exception('Advertencia. El cliente no tiene puntos acumulados. Por favor verifique.');
            }


            $nDiferenciaPuntos = $aryCliente["nPuntosAcumulados"] - $nPuntos;

            if ($nDiferenciaPuntos < 0) {
                $this->exception('Advertencia. El cliente no tiene puntos suficientes para poder canjear , puede canjear como Maximo (' . $aryCliente["nPuntosAcumulados"] . ') Puntos. Por favor verifique.');
            }

            $aryMontoDsct = $this->cp->fncGetMontoDsctPorRango($user["nIdSede"], $nPuntos);
            $nDsct        = 0;

            if (fncValidateArray($aryMontoDsct)) {
                $aryMontoDsct = $aryMontoDsct[0];
                $nDsct        = $aryMontoDsct["nMontoDsct"];
            }

            $this->json(array("success" => "Genial se canjeo los puntos de forma correcta ...", "nDsct"  => $nDsct));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncCanjearPuntosByPedido($nIdPedido)
    {
        $user = $this->session->get("user");

        if (is_null($user)) {
            $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
        }

        // Valida valores del formulario
        if (is_null($nIdPedido)) {
            $this->exception('Error. Los valores entregados al controlador no estan completos. Por favor verifique.');
        }

        # Busca el pedido
        $aryPedido = $this->pedidos->fncObtenerPedidos(["nIdPedido" => $nIdPedido]);

        if (!fncValidateArray($aryPedido)) {
            $this->exception('Advertencia. No se pudo ubicar el pedido ' . $nIdPedido . ' . Por favor verifique.');
        }

        $aryPedido = $aryPedido[0];

        # Busca el detalle del pedido

        $aryDetallePedido = $this->pedidos->fncObtenerPedidosDetalle(["nIdPedido" => $nIdPedido]);

        if (!fncValidateArray($aryDetallePedido)) {
            $this->exception('Advertencia. No se pudo ubicar el pedido ' . $nIdPedido . ' . Por favor verifique.');
        }

        # Calcula el monto total del canje
        $nTotalMontoCanje = 0;

        foreach ($aryDetallePedido as $nKey => $aryLoop) {
            if ($aryLoop["nAcumulaPuntos"] == 1) {
                $nTotalItem        =  $aryLoop["nCantidad"] * $aryLoop["nPrecio"];
                $nTotalMontoCanje +=  $nTotalItem;
            }
        }


        # Busca el porcentaje por un cierto rango pasando como parametro el monto total en la formulacion de canje

        $nPorcentaje = 0;

        $aryDataPorcentaje = $this->fap->fncGetPorcentajeRango($user["nIdSede"], $nTotalMontoCanje);
        if (fncValidateArray($aryDataPorcentaje)) {
            $aryDataPorcentaje = $aryDataPorcentaje[0];
            $nPorcentaje       = $aryDataPorcentaje["nPorcentaje"];
        }


        # Calcula los puntos
        $nPuntos = $nTotalMontoCanje * ($nPorcentaje / 100);
        // var_dump( $aryPedido["nIdCliente"] , $nPuntos,   $aryDataPorcentaje  , $nPorcentaje , $nTotalMontoCanje  );
        // exit;

        # Actualiza los puntos en el cliente
        $this->clientes->fncActualizarPuntos($aryPedido["nIdCliente"], $nPuntos);

        return ["success" => true, "nTotalMontoCanje" => $nTotalMontoCanje, "nPuntos" => $nPuntos];
    }
}
