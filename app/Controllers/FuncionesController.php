<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller;
use Application\Models\Productos;

class FuncionesController extends Controller
{
    public $session;
    public $productos;

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->productos = new Productos();

        $this->session->init();
    }


    public function fncValidarSession()
    {
        try {
            if ($this->session->getStatus() === 1 || empty($this->session->get('user'))) {

                $this->json(array(
                    "error"          => true,
                    "sMensaje"       => "Se acabo la sesion",
                    "sRuta"          => route("acceso")
                ));
            } else {

                $this->json(array(
                    "succes"          => true,
                    "sMensaje"       => "Session activa",
                ));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    # Esta funcion mostrara las notificaciones o alertas 
    # Por ahora solo muestra los productos que tienen menos que su STOCK MINIMO 
    public function fncObtenerMensajes()
    {
        try {

            $user = $this->session->get("user");
            if (is_null($user)) {
                $this->exception("Error.No se pudo ubicar el usuario . Porfavor verifica o vuelve a ingresar al sistema");
            }

            $aryData = [];

            if (isset($user["nIdSede"])) {
                $aryData = $this->productos->fncObtenerProductosAlerta($user["nIdSede"]);
            }

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
