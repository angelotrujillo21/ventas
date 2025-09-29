<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\Bancos;
use Application\Models\CuentasCorrientes;
use Application\Models\MetodosPagos;
use Application\Models\Sedes;
use Application\Models\TiposCuentas;

class CuentasCorrientesController extends Controller
{
    //model principal
    public $bancos;
    public $tiposcuentas;
    public $cuentascorrientes;
    public $metodosPagos;
    public $sedes;

    public $session;

    public function __construct()
    {
        parent::__construct();
        $this->session               = new Session();
        $this->bancos                = new Bancos();
        $this->tiposcuentas          = new TiposCuentas();
        $this->cuentascorrientes     = new CuentasCorrientes();
        $this->metodosPagos          = new MetodosPagos();
        $this->sedes                 = new Sedes();

        $this->session->init();
    }

    public function index()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/cuentas-corrientes', [
                'sTitulo'          => 'Mantenimientos de Cuentas Corrientes',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                'aryBancos'        => $this->bancos->fncGetBancos(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"], "nEstado" => 1]),
                'aryTipoCuentas'   => $this->tiposcuentas->fncGetTipoCuenta(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"], "nEstado" => 1]),
                "arySede"          => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }



    public function mPagoCCorriente()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');
            # Obtener todos los metodos de pagos excepto el de efectivo
            $nTipoPagoEfectivo = $this->fncGetVarConfig("nTipoPagoEfectivo");
            $sIdsNot = "$nTipoPagoEfectivo";
            $this->view('admin/mpago-ccorriente', [
                'sTitulo'                     => 'Metodos de pagos y cuentas corrientes',
                'user'                        => $this->session->get('user'),
                'bShowMenu'                   => true,
                'aryCuentasCorrientes'        => $this->cuentascorrientes->fncGetCuentasCorrientes(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"], "nEstado" => 1]),
                'aryMetodosPagos'             => $this->metodosPagos->fncGetSedesMetodosPagos(["nIdEmpresa" => $user["nIdEmpresa"], "sIdsNot" => $sIdsNot]),
                "nAdmin"                      => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
            ]);
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
            $aryData      = $this->cuentascorrientes->fncGetCuentasCorrientes(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionShow      = "fncMostrarCC(" . $aryLoop['nIdCuentaCorriente'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarCC(" . $aryLoop['nIdCuentaCorriente'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarCC(" . $aryLoop['nIdCuentaCorriente'] . ");";


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
                        "sPropietario"      => $aryLoop["sPropietario"],
                        "sBanco"            => $aryLoop["sBanco"],
                        "sTipoCuenta"       => $aryLoop["sTipoCuenta"],
                        "sNumero"           => $aryLoop["sNumero"],
                        "nSaldoActual"      => $aryLoop["nSaldoActual"],
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarCC()
    {
        try {
            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdBanco           = isset($_POST['nIdBanco']) ? $_POST['nIdBanco'] : null;
            $sPropietario       = isset($_POST['sPropietario']) ? $_POST['sPropietario'] : null;
            $sNumero            = isset($_POST['sNumero']) ? $_POST['sNumero'] : null;
            $nIdTipoCuenta      = isset($_POST['nIdTipoCuenta']) ? $_POST['nIdTipoCuenta'] : null;
            $nSaldoActual       = isset($_POST['nSaldoActual']) ? $_POST['nSaldoActual'] : null;
            $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

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
                $nIdNewRegistro = $this->cuentascorrientes->fncGrabarRegistro(
                    $nIdBanco,
                    $sPropietario,
                    $sNumero,
                    $nIdTipoCuenta,
                    $nSaldoActual,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->cuentascorrientes->fncActualizarRegistro(
                    $nIdRegistro,
                    $nIdBanco,
                    $sPropietario,
                    $sNumero,
                    $nIdTipoCuenta,
                    $nSaldoActual,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Cuenta corriente registrada exitosamente...' : 'Cuenta corriente actualizada exitosamente...';

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

            $aryData = $this->cuentascorrientes->fncGetCuentasCorrientes(["nIdCuentaCorriente" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

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
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $this->cuentascorrientes->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetCuentasCorrientes()
    {
        // Recibe valores del formulario
        $nIdBanco = isset($_POST['nIdBanco']) ? $_POST['nIdBanco'] : null;

        try {
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $aryData = $this->cuentascorrientes->fncGetCuentasCorrientes([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nIdBanco"      => $nIdBanco,
                "nEstado"       => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    // Cuentas corrientes  - Metodos de pagos  CCMP
    public function fncPopulateCCMP()
    {
        try {
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];
            $aryData      = $this->cuentascorrientes->fncGetCCMP(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarCCMP(" . $aryLoop['nIdCuentaCorrienteMP'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarCCMP(" . $aryLoop['nIdCuentaCorrienteMP'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarCCMP(" . $aryLoop['nIdCuentaCorrienteMP'] . ");";

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
                        "sBanco"            => $aryLoop["sBanco"],
                        "sPropietario"      => $aryLoop["sPropietario"],
                        "sTipoCuenta"       => $aryLoop["sTipoCuenta"],
                        "sNumeroCC"         => $aryLoop["sNumeroCC"],
                        "sMetodoPago"       => $aryLoop["sMetodoPago"],
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarCCMP()
    {
        try {
            $nIdRegistro         = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdCuentaCorriente  = isset($_POST['nIdCuentaCorriente']) ? $_POST['nIdCuentaCorriente'] : null;
            $nIdMetodoPago       = isset($_POST['nIdMetodoPago']) ? $_POST['nIdMetodoPago'] : null;
            $nEstado             = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

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
                $nIdNewRegistro = $this->cuentascorrientes->fncGrabarCCMP(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCuentaCorriente,
                    $nIdMetodoPago,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->cuentascorrientes->fncActualizarCCMP(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCuentaCorriente,
                    $nIdMetodoPago,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Relacion registrada exitosamente...' : 'Relacion corriente actualizada exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdNewRegistro" => $nIdNewRegistro));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarCCMP()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->cuentascorrientes->fncGetCCMP(["nIdCuentaCorrienteMP" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarCMMP()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $this->cuentascorrientes->fncEliminarCMMP($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetCMMP()
    {
        // Recibe valores del formulario
        $nIdMetodoPago = isset($_POST['nIdMetodoPago']) ? $_POST['nIdMetodoPago'] : null;

        try {
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $aryData = $this->cuentascorrientes->fncGetCCMP([
                "nIdEmpresa"         => $user["nIdEmpresa"],
                "nIdMetodoPago"      => $nIdMetodoPago,
                "nEstado"            => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
