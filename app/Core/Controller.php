<?php

namespace Application\Core;

use Application\Models\Roles;
use Application\Models\VariblesConfiguracion;
use Exception;

class Controller
{
    public function __construct()
    {
        $this->load_helper(['view']);
    }

    /**
     * @param $model
     * @return object|bool
     *
     * Load specified Model if the file exists.
     */



    protected function json($data)
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //Técnologia
    }

    protected function exception($sMessage)
    {
        throw new Exception(json_encode(["error" => $sMessage]), 1);
    }


    // Escapa los caracteres
    public function fncSlash($sString)
    {
        return (addcslashes($sString, "\/'\"\|\$\&\`\´\@"));
    }


    public function fncGetVarConfig($sNombre, $sField = "sValorPrincipal")
    {
        $config  =  new VariblesConfiguracion();
        $aryData = $config->fncGetVarConfig($sNombre, $sField);
        if (is_array($aryData) && count($aryData) > 0) {
            return $aryData[0][$sField];
        }
        return false;
    }

    /**
     * @param $view
     * @param array $data
     * @return bool
     *
     * Load specified View if the file exists.
     * The values of $data are available to the View as are the
     * index of each $data as it's own variable.
     */
    protected function view($view, $data = [])
    {
        if (file_exists(VIEWS_PATH . $view . '.php')) {
            // Set each index of data to its named variable.
            if (count($data) > 0) {
                foreach ($data as $key => $value) {
                    $$key = $value;
                }
            }
            require_once VIEWS_PATH . $view . '.php';
        } else {
            $this->exception("No se pudo ubicar la vista.");
        }
    }





    /**
     * @param array $files
     *
     * Load Helper files.
     *
     */


    /**
     * @param array $files
     *
     * Load Helper files.
     *
     */
    protected function load_helper($files = [])
    {
        foreach ($files as $file) {
            require_once HELPERS_PATH . $file . '.php';
        }
    }

    public function redirect($path, $bIsPathComplete = false)
    {
        if ($bIsPathComplete === true) {
            header("location:" . $path);
        } else {
            header("location:" . WEB_ROOT . $path);
        }
    }

    protected function authAdmin($session)
    {
        if ($session->getStatus() === 1 || empty($session->get('user'))) {
            $this->redirect('acceso');
        } else {
            $user = $session->get("user");
            // Si es administrador  y no tiene una empresa y sede
            if ($user["nIdRol"] == 1 && (!isset($user["nIdEmpresa"])  || !isset($user["nIdSede"]))) {
                $this->redirect("empresas");
            }
        }
    }


    public function fncIsAdmin($nIdRol, $sUrlModulo)
    {
        $nIdRolAdmin = $this->fncGetVarConfig("nIdRolAdmin");

        if ($nIdRol == $nIdRolAdmin) {
            return true;
        }

        $roles = new Roles();

        $aryDataRol = $roles->fncObtenerRolSubModuloByIdRol($nIdRol, $sUrlModulo);

        if (fncValidateArray($aryDataRol)) {
            $aryDataRol = $aryDataRol[0];
            // Admin
            if ($aryDataRol["nRolSubModulo"] ==  $nIdRolAdmin) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    protected function fncGetVista()
    {


        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //request is ajax
            $sURL = $_SERVER["HTTP_REFERER"];

            $sURL =  str_replace(WEB_ROOT, "", $sURL);
        } else {

            $sURL = $_SERVER["REQUEST_URI"];
            # Si es produccion quita el / si es en el local como esta dentro de la carpeta ventas quita el path /ventas/ 
            if (IS_PRODUCTION) {
                $sURL = str_replace("/", "", $sURL);
            } else {
                $sURL = str_replace("/ventas/", "", $sURL);
            }
        }
 
        return $sURL;
    }
}
