<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\Empleados;
use Application\Models\Empresas;
use Application\Models\Roles;
use Application\Models\Users;

class LoginAdminController extends Controller
{

    //model principal
    public $session;
    public $users;
    public $empleados;
    public $roles;
    public $empresas;

    public function __construct()
    {
        parent::__construct();
        $this->session      = new Session();
        $this->users        = new Users();
        $this->empleados    = new Empleados();
        $this->roles        = new Roles();
        $this->empresas     = new Empresas();

        $this->session->init();
    }

    public function acceso()
    {
        try {

            if (!is_null($this->session->get('user'))) {

                $nIdRolAdmin = $this->fncGetVarConfig("nIdRolAdmin");
                $user        = $this->session->get('user');

                $this->redirect($user["sModuloDefault"]);
            } else {
                $this->view('admin/login', ['aryEmpresas' => $this->empresas->fncGetEmpresas()]);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function accesoAjax()
    {
        try {

            $nIdEmpresa         = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;
            $sUsuario           = isset($_POST['sUsuario']) ? $_POST['sUsuario'] : null;
            $sClave             = isset($_POST['sClave']) ? $_POST['sClave'] : null;
            $sURL               = isset($_POST['sURL']) ? $_POST['sURL'] : null;

            $nIdRolAdmin          = $this->fncGetVarConfig("nIdRolAdmin"); // El rol admin es tambien llamado dueño del negocio

            $rolesController = new RolesController();

            // Evaluar si es administrador

            $aryUsuario = $this->users->fncGetUsuarios(["sLogin" => $sUsuario, "nEstado" => 1]);

            if (fncValidateArray($aryUsuario)) {

                // Es administrador
                $aryUsuario = $aryUsuario[0];

                if ($aryUsuario["sClave"] == $sClave) {
                    $aryUsuario["aryModulos"]      = $rolesController->fncGetModulosAndSubmodulos($nIdRolAdmin);

                    $aryUsuario["sModuloDefault"]  = "empresas";

                    $aryUsuario["sURL"]  = $sURL;


                    $this->session->add('user', $aryUsuario);

                    $this->json(["success" => true, "msg" => 'Bienvenido al sistema']);
                    exit;
                } else {
                    $this->json(["success" => false, "msg" => 'Por favor verifique su usuario o contraseña']);
                    exit;
                }
            }

            // Verificamos si esque existe el empleado

            $aryEmpleado  =  $this->empleados->fncGetEmpleados([
                "nIdEmpresa"  => $nIdEmpresa,
                "sLogin"      => $sUsuario,
                "nEstado"     => 1
            ]);


            if (fncValidateArray($aryEmpleado)) {

                $aryEmpleado   =  $aryEmpleado[0];

                if ($aryEmpleado["sClave"] == $sClave) {

                    $aryDataModuloDefault =  $this->roles->fncGetSubModuloDefaultByIdRol($aryEmpleado["nIdRol"]);

                    if (fncValidateArray($aryDataModuloDefault)) {

                        $aryDataModuloDefault          = $aryDataModuloDefault[0];

                        $aryEmpleado["aryModulos"]      = $rolesController->fncGetModulosAndSubmodulos($aryEmpleado["nIdRol"]);

                        $aryEmpleado["sModuloDefault"]  = trim($aryDataModuloDefault["sUrl"]);
                        $aryEmpleado["sURL"]            = $sURL;

                        $this->session->add('user', $aryEmpleado);

                        $this->json(["success" => true, "msg" => 'Bienvenido al sistema']);
                        exit;
                    } else {
                        $this->json(["success" => false, "msg" => 'No se encontro un modulo por default para este usuario .Por favor solicite asistencia.']);
                        exit;
                    }
                } else {
                    $this->json(["success" => false, "msg" => 'Por favor verifique su contraseña']);
                }
            } else {
                $this->json(["success" => false, "msg" => 'Por favor verifique su usuario o contraseña']);
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function salir()
    {
        $user = $this->session->get('user');

        $this->session->close();

        if (is_null($user)) {
            $this->redirect('acceso');
        } else {
            $this->redirect($user["sURL"], true);
        }
    }
}
