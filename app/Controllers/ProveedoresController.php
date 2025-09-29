<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\CatalogoTabla;
use Application\Models\Clientes;
use Application\Models\Proveedores;
use Application\Models\Ubigeo;

class ProveedoresController extends Controller
{
    //model principal
    public $users;
    public $proveedores; // Es mi modelo
    public $session;
    public $catalogotabla;
    public $ubigeo;
    public $sUrlProveedores = "proveedores";


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->proveedores      = new Proveedores();
        $this->catalogotabla    = new CatalogoTabla();
        $this->ubigeo           = new Ubigeo();
        $this->session->init();
    }


    public function index()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/proveedores', [
                'sTitulo'          => 'Mantenimientos de proveedores',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                'aryTipoDocumento' => $this->catalogotabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryDepartamentos' => $this->ubigeo->fncObtenerDepartamentos(),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlProveedores) ? 1 : 0,
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
            $aryClientes  = $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlProveedores);

            if (is_array($aryClientes) && count($aryClientes) > 0) {
                foreach ($aryClientes as $aryLoop) {

                    $sActionShow      = "fncMostrarProveedor(" . $aryLoop['nIdProveedor'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarProveedor(" . $aryLoop['nIdProveedor'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarProveedor(" . $aryLoop['nIdProveedor'] . ");";


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
                        "nTipoDocumento"        => $aryLoop["sTipoDoc"],
                        "sNombreoRazonSocial"   => $aryLoop["sNombreoRazonSocial"],
                        "sNumeroDocumento"      => $aryLoop["sNumeroDocumento"],
                        "sCorreo"               => $aryLoop["sCorreo"],
                        "nIdDepartamento"       => $aryLoop["sDpt"],
                        "nIdProvincia"          => $aryLoop["sProvincia"],
                        "nIdDistrito"           => $aryLoop["sDistrito"],
                        "sTelefono"             => "<a target='_blank' href='tel:" . $aryLoop["sTelefono"] . "'>" . $aryLoop["sTelefono"] . "</a>",
                        "sDireccion"            => $aryLoop["sDireccion"],
                        "nEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarProveedor()
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
            $nEstado                 = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $nIdProveedorNew = null;
            // Crear
            if ($nIdRegistro == 0) {

                $aryDataCliValidacion = $this->proveedores->fncGetProveedores([
                    "nIdEmpresa"       => $user["nIdEmpresa"],
                    "nTipoDocumento"   => $nTipoDocumento,
                    "sNumeroDocumento" => $sNumeroDocumento,
                ]);

                if (fncValidateArray($aryDataCliValidacion)) {
                    $this->exception("Error. Ya existe un proveedor con este numero de documento registrado en la empresa . Porfavor verifique");
                }

                $nIdProveedorNew = $this->proveedores->fncGrabarProveedor(
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
                    $nEstado
                );
            } else {
                //Actualizar
                $this->proveedores->fncActualizarProveedor(
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
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Proveedor registrado exitosamente...' : 'Proveedor actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdProveedor" => $nIdProveedorNew));
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


            $aryData = $this->proveedores->fncGetProveedores(["nIdProveedor" => $nIdRegistro]);

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


            $this->proveedores->fncEliminarProveedor($nIdRegistro);
            $this->json(array("success" => 'Proveedor eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetProveedores()
    {
        // Recibe valores del formulario

        try {

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $aryData = $this->proveedores->fncGetProveedores([
                "nIdEmpresa" => $user["nIdEmpresa"],
                "nEstado"    => 1
            ]);
            
            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
