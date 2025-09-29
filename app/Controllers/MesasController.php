<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\CartaDigital;
use Application\Models\Mesas;

class MesasController extends Controller
{
    //model principal
    public $mesas; // Es mi modelo
    public $session;
    public $cartaDigital;
    public function __construct()
    {
        parent::__construct();
        $this->session         = new Session();
        $this->mesas           = new Mesas();
        $this->cartaDigital           = new CartaDigital();

        $this->session->init();
    }


    public function mesas()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/mesas', [
                'sTitulo'          => 'Mantenimientos de Mesas',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "aryCartaDigital"  => $this->cartaDigital->fncObtenerCartaDigital(["nEstado" => 1 , "nIdEmpresa" => $user["nIdEmpresa"] , "nIdSede" => $user["nIdSede"] ])
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
            $aryData      = $this->mesas->fncObtenerRegistros(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {

                    $sURL = route("carta-digital?id=" . $aryLoop["nIdCartaDigital"] . "&idmesa=" . $aryLoop["nIdMesa"]);

                    $sActionQR        = "fncMostrarQR('" . $sURL . "','" . $aryLoop["sColor3"] . "','" . $aryLoop["sColor4"] . "');";
                    $sActionShow      = "fncMostrarRegistro(" . $aryLoop['nIdMesa'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarRegistro(" . $aryLoop['nIdMesa'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarRegistro(" . $aryLoop['nIdMesa'] . ");";


                    $sLinkQR     = '<a onclick="' . $sActionQR . '" href="javascript:;"   title="Ver imagen QR" class="text-primary"><i class="material-icons">link</i> </a>';
                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkQR . '
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"         => $sAcciones,
                        "sDescripcion"      => $aryLoop["sDescripcion"],
                        "sCartaDigital"     => $aryLoop["sCartaDigital"],
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                        "sURL"              => $sURL
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarRegistro()
    {
        try {
            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $nIdCartaDigital    = isset($_POST['nIdCartaDigital']) ? $_POST['nIdCartaDigital'] : null;
            $sComentario        = isset($_POST['sComentario']) ? $_POST['sComentario'] : null;
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
                $nIdNewRegistro = $this->mesas->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCartaDigital,
                    $sDescripcion,
                    $sComentario,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->mesas->fncActualizarRegistro(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdCartaDigital,
                    $sDescripcion,
                    $sComentario,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Mesa registrada exitosamente...' : 'Mesa actualizada exitosamente...';

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

            $aryData = $this->mesas->fncObtenerRegistros(["nIdMesa" => $nIdRegistro]);

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


            $this->mesas->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncObtenerRegistros()
    {
        // Recibe valores del formulario

        try {
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $aryData = $this->mesas->fncObtenerRegistros([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nEstado"       => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
