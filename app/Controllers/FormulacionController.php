<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Mail;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
 
class FormulacionController extends Controller

{

    //model principal
    public $session;
    public $sUrlFormulacion = "formulacion";


    public function __construct()
    {
        parent::__construct();

        $this->session      = new Session();

        $this->session->init();
    }

    public function index()
    {

        $this->authAdmin($this->session);

        $user      = $this->session->get('user');

        $this->view(
            'admin/formulacion',
            [
                "sTitulo"     => "Formulacion",
                "user"        => $this->session->get("user"),
                'bShowMenu'   => true,
                "nAdmin"      => $this->fncIsAdmin($user["nIdRol"], $this->sUrlFormulacion) ? 1 : 0,
            ]
        );
    }

    
}
