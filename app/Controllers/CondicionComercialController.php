<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Application\Libs\Session;

use Application\Core\Controller as Controller;
use Application\Models\CondicionComercial;

class CondicionComercialController extends Controller
{
    //model principal
    public $condicionComercial; // Es mi modelo
    public $session;
    public $categorias;
    public $catalogoTabla;

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->condicionComercial      = new CondicionComercial();
        $this->session->init();
    }

    public function condicionComercial()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/condicioncomercial', [
                'sTitulo'      => 'Mantenimientos de Condicion Comercial',
                'user'         => $this->session->get('user'),
                'bShowMenu'    => true,
                "nAdmin"       => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarRegistro()
    {
        $nIdRegistro         = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $sNombre             = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
        $sTiempoEntrega      = isset($_POST['sTiempoEntrega']) ? $_POST['sTiempoEntrega'] : null;
        $sFormaPago          = isset($_POST['sFormaPago']) ? $_POST['sFormaPago'] : null;
        $sLugarEntrega       = isset($_POST['sLugarEntrega']) ? $_POST['sLugarEntrega'] : null;
        $sGarantia           = isset($_POST['sGarantia']) ? $_POST['sGarantia'] : null;
        $sValidezOferta      = isset($_POST['sValidezOferta']) ? $_POST['sValidezOferta'] : null;
        $nEstado             = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

        try {

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

                $nIdNewRegistro = $this->condicionComercial->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sTiempoEntrega,
                    $sFormaPago,
                    $sLugarEntrega,
                    $sGarantia,
                    $sValidezOferta,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->condicionComercial->fncActualizarRegistro(
                    $nIdRegistro,
                    $sNombre,
                    $sTiempoEntrega,
                    $sFormaPago,
                    $sLugarEntrega,
                    $sGarantia,
                    $sValidezOferta,
                    $nEstado
                );
            }



            $sSuccess = $nIdRegistro == 0 ? 'Condicion comercial registrado exitosamente...' : 'Condicion Comercial actualizado exitosamente...';
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

            $aryData = $this->condicionComercial->fncObtenerRegistros(["nIdCondicionComercial" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];

            $this->json(array("success" => true, "aryData" => $aryHeader));
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

            $this->condicionComercial->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
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
            $aryRows = [];

            $aryData = $this->condicionComercial->fncObtenerRegistros([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nIdSede"       => $user["nIdSede"],

            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionEdit      = "fncMostrarRegistro(" . $aryLoop['nIdCondicionComercial'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarRegistro(" . $aryLoop['nIdCondicionComercial'] . ");";

                    $sIconEdit = "edit";
                    $sIconDelete = "delete";

                    $sLinkEdit   =  '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">' . $sIconEdit . '</i> </a>';
                    $sLinkDelete =  '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">' . $sIconDelete . '</i> </a>';

                    $sAcciones = '<div class="content-acciones">
                                     ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"          => $sAcciones,
                        "sNombre"            => $aryLoop["sNombre"],
                        "sTiempoEntrega"     => $aryLoop["sTiempoEntrega"],
                        "sFormaPago"         => $aryLoop["sFormaPago"],
                        "sGarantia"          => $aryLoop["sGarantia"],
                        "sValidezOferta"     => $aryLoop["sValidezOferta"],
                        "sEstado"            => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}