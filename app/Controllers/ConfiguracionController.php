<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Models\Roles;
use Application\Models\Users;
use Application\Core\Controller as Controller;
use Application\Models\MetodosEnvios;
use Application\Models\MetodosPagos;
use Application\Models\Sedes;

class ConfiguracionController extends Controller

{

    //model principal
    public $negocios;
    public $session;
    public $users;
    public $roles;
    public $metodosEnvio;
    public $metodosPago;
    public $sedes;

    public $sUrlConfiguracion = "configuracion";

    public function __construct()
    {
        parent::__construct();

        $this->session         = new Session();
        $this->users           = new Users();
        $this->roles           = new Roles();
        $this->sedes           = new Sedes();
        $this->metodosEnvio    = new MetodosEnvios();
        $this->metodosPago     = new MetodosPagos();

        $this->session->init();
        $this->authAdmin($this->session);
    }

    public function index()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/configuracion', [
                'sTitulo'          => 'Configuracion General de la sede',
                'user'             => $user,
                'bShowMenu'        => true,
                'aryTipoPago'      => $this->metodosPago->fncGetMetodosPagos(["nEstado" => 1]),
                'aryTipoEnvio'     => $this->metodosEnvio->fncGetMetodosEnvio(["nEstado" => 1]),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlConfiguracion) ? 1 : 0,

             ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
