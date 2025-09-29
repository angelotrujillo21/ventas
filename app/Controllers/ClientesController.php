<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\CatalogoTabla;
use Application\Models\Clientes;
use Application\Models\CondicionComercial;
use Application\Models\Empresas;
use Application\Models\Ubigeo;

class ClientesController extends Controller
{
    //model principal
    public $users;
    public $clientes; // Es mi modelo
    public $session;
    public $catalogotabla;
    public $ubigeo;
    public $empresas;
    public $condicionComercial;

    public $sUrlClientes = "clientes";


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->clientes         = new Clientes();
        $this->catalogotabla    = new CatalogoTabla();
        $this->ubigeo           = new Ubigeo();
        $this->empresas         = new Empresas();
        $this->condicionComercial   = new CondicionComercial();
        $this->session->init();
    }


    public function index()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/clientes', [
                'sTitulo'          => 'Mantenimientos de clientes',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                'aryTipoDocumento' => $this->catalogotabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryDepartamentos' => $this->ubigeo->fncObtenerDepartamentos(),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlClientes) ? 1 : 0,
                'aryCC'            => $this->condicionComercial->fncObtenerRegistros(["nIdEmpresa" => $user["nIdEmpresa"], "nEstado" => 1]),
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function nuevoCliente($nIdEmpresa)
    {
        try {

            $aryEmpresa = $this->empresas->fncGetEmpresas(["nIdEmpresa"]);
            if (fncValidateArray($aryEmpresa)) {

                $aryEmpresa = $aryEmpresa[0];
            } else {
                $this->exception("Error . No se pudo ubicar la empresa . Porfavor verifique o solicite contacto ");
            }

            $this->view('admin/nuevo-cliente', [
                'sTitulo'          => 'NUEVO CLIENTE - ' . $aryEmpresa["sNombre"],
                'nIdEmpresa'       => $nIdEmpresa,
                'aryEmpresa'       => $aryEmpresa,
                'bShowMenu'        => false,
                'aryTipoDocumento' => $this->catalogotabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryDepartamentos' => $this->ubigeo->fncObtenerDepartamentos(),
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }




    public function fncPopulate()
    {
        $nEstado = isset($_REQUEST["nEstado"]) ? $_REQUEST["nEstado"] : null;

        try {

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];
            $aryClientes  = $this->clientes->fncGetClientes(["nIdEmpresa" => $user["nIdEmpresa"] , "nEstado" => $nEstado]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlClientes);

            if (is_array($aryClientes) && count($aryClientes) > 0) {
                foreach ($aryClientes as $aryLoop) {

                    $sActionShow      = "fncMostrarCliente(" . $aryLoop['nIdCliente'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarCliente(" . $aryLoop['nIdCliente'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarCliente(" . $aryLoop['nIdCliente'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"             => $sAcciones,
                        "nIdCliente"            => $aryLoop["nIdCliente"],
                        "nTipoDocumento"        => $aryLoop["sTipoDoc"],
                        "sNombreoRazonSocial"   => $aryLoop["sNombreoRazonSocial"],
                        "sNumeroDocumento"      => $aryLoop["sNumeroDocumento"],
                        "sCorreo"               => $aryLoop["sCorreo"],
                        "nIdDepartamento"       => $aryLoop["sDpt"],
                        "nIdProvincia"          => $aryLoop["sProvincia"],
                        "nIdDistrito"           => $aryLoop["sDistrito"],
                        "sTelefono"             => "<a target='_blank' href='tel:" . $aryLoop["sTelefono"] . "'>" . $aryLoop["sTelefono"] . "</a>",
                        "sDireccion"            => $aryLoop["sDireccion"],
                        "nPuntosAcumulados"     => $aryLoop["nPuntosAcumulados"],
                        "nIdCondicionComercial" => $aryLoop["nIdCondicionComercial"],
                        "nEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarCliente()
    {
        try {
            $nIdRegistro             = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nTipoDocumento          = isset($_POST['nTipoDocumento']) ? $_POST['nTipoDocumento'] : null;
            $sNumeroDocumento        = isset($_POST['sNumeroDocumento']) ? $_POST['sNumeroDocumento'] : null;
            $sNombreoRazonSocial     = isset($_POST['sNombreoRazonSocial']) ? $_POST['sNombreoRazonSocial'] : null;
            $sCorreo                 = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : null;
            $nIdDepartamento         = isset($_POST['nIdDepartamento']) ? $_POST['nIdDepartamento'] : null;
            $nIdProvincia            = isset($_POST['nIdProvincia']) ? $_POST['nIdProvincia'] : null;
            $nIdDistrito             = isset($_POST['nIdDistrito']) ? $_POST['nIdDistrito'] : null;
            $sTelefono               = isset($_POST['sTelefono']) ? $_POST['sTelefono'] : null;
            $sDireccion              = isset($_POST['sDireccion']) ? $_POST['sDireccion'] : null;
            $nAcumulaPuntos          = isset($_POST['nAcumulaPuntos']) ? $_POST['nAcumulaPuntos'] : null;

            $nIdEmpresa              = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;
            $nIdSede                 = isset($_POST['nIdSede']) ? $_POST['nIdSede'] : null;

            $sFacebook               = isset($_POST['sFacebook']) ? $_POST['sFacebook'] : null;
            $sWtsp                   = isset($_POST['sWtsp']) ? $_POST['sWtsp'] : null;
            $sTwiter                 = isset($_POST['sTwiter']) ? $_POST['sTwiter'] : null;
            $sOtraRedSocial          = isset($_POST['sOtraRedSocial']) ? $_POST['sOtraRedSocial'] : null;

            $nIdCondicionComercial   = isset($_POST['nIdCondicionComercial']) ? $_POST['nIdCondicionComercial'] : null;

            $nEstado                 = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $user = $this->session->get("user");

            if (is_null($nIdEmpresa) && is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $nIdClienteNew = null;
            // Crear
            if ($nIdRegistro == 0) {

                $aryDataCliValidacion = $this->clientes->fncGetClientes([
                    "nIdEmpresa"       => !is_null($nIdEmpresa) ? $nIdEmpresa  : $user["nIdEmpresa"],
                    "nTipoDocumento"   => $nTipoDocumento,
                    "sNumeroDocumento" => $sNumeroDocumento,
                ]);

                if (fncValidateArray($aryDataCliValidacion)) {
                    $this->exception("Error. Ya existe un cliente con este numero de documento registrado en la empresa . Porfavor verifique");
                }

                $nIdCondicionComercial= empty($nIdCondicionComercial) ? null : $nIdCondicionComercial;
                
                $nIdClienteNew = $this->clientes->fncGrabarCliente(
                    !is_null($nIdEmpresa) ? $nIdEmpresa  : $user["nIdEmpresa"],
                    !is_null($nIdSede) ? $nIdSede  : $user["nIdSede"],
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombreoRazonSocial,
                    $sCorreo,
                    $nIdDepartamento,
                    $nIdProvincia,
                    $nIdDistrito,
                    $sTelefono,
                    $sDireccion,
                    $nAcumulaPuntos,
                    $sFacebook,
                    $sWtsp,
                    $sTwiter,
                    $sOtraRedSocial,
                    $nEstado,
                    $nIdCondicionComercial
                );
            } else {
                //Actualizar
                $this->clientes->fncActualizarCliente(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombreoRazonSocial,
                    $sCorreo,
                    $nIdDepartamento,
                    $nIdProvincia,
                    $nIdDistrito,
                    $sTelefono,
                    $sDireccion,
                    $nAcumulaPuntos,
                    $sFacebook,
                    $sWtsp,
                    $sTwiter,
                    $sOtraRedSocial,
                    $nEstado,
                    $nIdCondicionComercial
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Cliente registrado exitosamente...' : 'Cliente actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdClienteNew" => $nIdClienteNew));
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


            $aryData = $this->clientes->fncGetClientes(["nIdCliente" => $nIdRegistro]);

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


            $this->clientes->fncEliminarCliente($nIdRegistro);
            $this->json(array("success" => 'Cliente eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetClientes()
    {
        // Recibe valores del formulario

        try {

            $sSearch = isset($_POST["term"]["term"]) ?  $_POST["term"]["term"] : null;

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $aryData = $this->clientes->fncGetClientes([
                "nIdEmpresa" => $user["nIdEmpresa"],
                "nEstado"    => 1,
                "sSearch"    => $sSearch
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
