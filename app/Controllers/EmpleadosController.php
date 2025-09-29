<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Mail;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Models\Negocios;
use Application\Models\Empleados;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\Roles;
use Application\Models\Users;

class EmpleadosController extends Controller
{

    //model principal
    public $session;
    public $catalogoTabla;
    public $negocios;
    public $empleados;
    public $roles;

    public $users;
    public $sUrlEmpleados = "empleados";


    public function __construct()
    {
        parent::__construct();
        $this->session       = new Session();
        $this->catalogoTabla = new CatalogoTabla();
        $this->empleados     = new Empleados();
        $this->roles         = new Roles();
        $this->users         = new Users();
        $this->session->init();
    }


    public function index()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            // var_dump($user);

            $this->view('admin/empleados', [
                'sTitulo'          => 'Mantenimiento de empleados',
                'user'             => $user,
                'bShowMenu'        => true,
                'aryTipoDocumento' => $this->catalogoTabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryRoles'         => $this->roles->fncGetRoles($user["nIdEmpresa"]),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlEmpleados) ? 1 : 0,
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
            $aryRows     = [];
            $aryData     = $this->empleados->fncGetEmpleados(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin    = $this->fncIsAdmin($user["nIdRol"], $this->sUrlEmpleados);


            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarEmpleado(" . $aryLoop['nIdEmpleado'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarEmpleado(" . $aryLoop['nIdEmpleado'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarEmpleado(" . $aryLoop['nIdEmpleado'] . ");";


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
                        "sTipoDocumento"        => $aryLoop["sTipoDoc"],
                        "sNumeroDocumento"      => $aryLoop["sNumeroDocumento"],
                        "sNombre"               => $aryLoop["sNombre"],
                        "sDireccion"            => $aryLoop["sDireccion"],
                        "sTelefono"             => $aryLoop["sTelefono"],
                        "sCorreo"               => $aryLoop["sCorreo"],
                        "sLogin"                => $aryLoop["sLogin"],
                        "sClave"                => $aryLoop["sClave"],
                        "sNombreRol"            => $aryLoop["sNombreRol"],
                        "dFechaCreacion"        => $aryLoop["dFechaCreacion"],
                        "sImagen"               => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',
                        "sDelivery"             => $aryLoop["nDelivery"] == 1 ? "SI" : "NO",
						"nCajaEmpleado"             => $aryLoop["nCajaEmpleado"] == 1 ? "SI" : "NO",
                        "sEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarEmpleado()
    {
        try {
            $nIdRegistro                    = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nTipoDocumento                 = isset($_POST['nTipoDocumento']) ? $_POST['nTipoDocumento'] : null;
            $sNumeroDocumento               = isset($_POST['sNumeroDocumento']) ? $_POST['sNumeroDocumento'] : null;
            $sNombre                        = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sDireccion                     = isset($_POST['sDireccion']) ? $_POST['sDireccion'] : null;
            $sTelefono                      = isset($_POST['sTelefono']) ? $_POST['sTelefono'] : null;
            $sCorreo                        = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : null;
            $sLogin                         = isset($_POST['sLogin']) ? $_POST['sLogin'] : null;
            $sClave                         = isset($_POST['sClave']) ? $_POST['sClave'] : null;
            $nIdRol                         = isset($_POST['nIdRol']) ? $_POST['nIdRol'] : null;
            $sImagen                        = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $nPorcentajeComision            = isset($_POST['nPorcentajeComision']) ? $_POST['nPorcentajeComision'] : null;
            $nDelivery                      = isset($_POST['nDelivery']) ? $_POST['nDelivery'] : null;
			$nCajaEmpleado                  = isset($_POST['nCajaEmpleado']) ? $_POST['nCajaEmpleado'] : null;
            $nEstado                        = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nTipoDocumento)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdEmpleadoNew = null;
            $sNombreImagen  = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            // Verficar que no se ha registrado un empleado con el mismo login que un administrador

            $aryUsuario = $this->users->fncGetUsuarios(["sLogin" => $sLogin]);

            if (fncValidateArray($aryUsuario)) {
                $this->exception('Error. Ya se encuentra registro un usuario con este nombre login , pruebe con otro . Gracias .');
            }


            // Crear
            if ($nIdRegistro == 0) {


                // Verficar que no se ha registrado un empleado con el mismo login 

                $aryEmpleado = $this->empleados->fncGetEmpleados([
                    "sLogin"      => $sLogin,
                    "nIdEmpresa"  => $user["nIdEmpresa"]
                ]);

                if (fncValidateArray($aryEmpleado)) {
                    $this->exception('Error. Ya se encuentra registrado un empleado con este login en la empresa , pruebe con otro . Gracias.');
                }

                // Verficar que no se ha registrado un mismo empleado en la empresa
                $aryEmpleado = $this->empleados->fncGetEmpleados([
                    "nTipoDocumento"    => $nTipoDocumento,
                    "sNumeroDocumento"  => $sNumeroDocumento,
                    "nIdEmpresa"        => $user["nIdEmpresa"]
                ]);

                if (fncValidateArray($aryEmpleado)) {
                    $this->exception('Error. Ya se encuentra registrado un empleado con este numero de documento en la empresa. Por favor verifique o solicite asistencia.');
                }

                $nIdEmpleadoNew = $this->empleados->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombre,
                    $sDireccion,
                    $sTelefono,
                    $sCorreo,
                    $sLogin,
                    $sClave,
                    $nIdRol,
                    $sNombreImagen,
                    $nPorcentajeComision,
                    $nDelivery,
					$nCajaEmpleado,
                    $nEstado
                );
            } else {


                // Vamos a verificar a todos los usuarios excepto el que se esta actualizando para ver si esque si se repite el login para que no genere errores

                $aryEmpleado = $this->empleados->fncGetEmpleados([
                    "nIdEmpleadoNot" => $nIdRegistro,
                    "sLogin"         => $sLogin,
                    "nIdEmpresa"     => $user["nIdEmpresa"]
                ]);

                if (fncValidateArray($aryEmpleado)) {
                    $this->exception('Error. Ya se encuentra registrado un empleado con este login en la empresa , pruebe con otro . Gracias.');
                }

                //Actualizar
                $this->empleados->fncActualizarRegistro(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombre,
                    $sDireccion,
                    $sTelefono,
                    $sCorreo,
                    $sLogin,
                    $sClave,
                    $nIdRol,
                    $sNombreImagen,
                    $nPorcentajeComision,
                    $nDelivery,
					$nCajaEmpleado,
                    $nEstado
                );

                if (isset($user["nIdEmpleado"]) &&  $user["nIdEmpleado"] == $nIdRegistro) {

                    $aryEmpleado = $this->empleados->fncGetEmpleados(["nIdEmpleado" => $nIdRegistro])[0];

                    $rolesController = new RolesController();

                    $aryDataModuloDefault = $this->roles->fncGetSubModuloDefaultByIdRol($aryEmpleado["nIdRol"]);

                    if (fncValidateArray($aryDataModuloDefault)) {

                        $aryDataModuloDefault           = $aryDataModuloDefault[0];

                        $aryEmpleado["aryModulos"]      = $rolesController->fncGetModulosAndSubmodulos($aryEmpleado["nIdRol"]);

                        $aryEmpleado["sModuloDefault"]  = trim($aryDataModuloDefault["sUrl"]);

                        $this->session->add('user', $aryEmpleado);
                    }
                }
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Empleado registrado exitosamente...' : 'Empleado actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdEmpleadoNew" => $nIdEmpleadoNew));
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


            $aryData = $this->empleados->fncGetEmpleados(["nIdEmpleado" => $nIdRegistro]);

            $this->json(array("success" => true, "aryData" => $aryData[0]));
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

            $aryData = $this->empleados->fncGetEmpleados(["nIdEmpleado" => $nIdRegistro]);
            if (fncValidateArray($aryData)) {
                $aryData = $aryData[0];
                // Eliminar la imagen
                if (strlen($aryData['sImagen']) > 0 && !empty($aryData['sImagen'])) {
                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }

            $this->empleados->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Empleado eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
