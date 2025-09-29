<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\Vehiculo;

class VehiculoController extends Controller
{
    //model principal
    public $vehiculos; // Es mi modelo
    public $session;
    public $catalogoTabla;

    public function __construct()
    {
        parent::__construct();
        $this->session             = new Session();
        $this->vehiculos           = new Vehiculo();
        $this->catalogoTabla      = new CatalogoTabla();
        $this->session->init();
    }

    public function vehiculo()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/vehiculo', [
                'sTitulo'          => 'Mantenimientos de vehiculos',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
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
            $aryRows = [];

            $aryData = $this->vehiculos->fncObtenerRegistros([
                "nIdEmpresa" => $user["nIdEmpresa"],
                "nIdSede"    => $user["nIdSede"]
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionEdit      = "fncMostrarRegistro(" . $aryLoop['nIdVehiculo'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarRegistro(" . $aryLoop['nIdVehiculo'] . ");";

                    $sIconEdit =    "edit";
                    $sIconDelete =  "delete";

                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">' . $sIconEdit . '</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">' . $sIconDelete . '</i> </a>'  : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"     => $sAcciones,
                        "nIdVehiculo"   => $aryLoop["nIdVehiculo"],
                        "sPlaca"        => $aryLoop["sPlaca"],
                        "sDetalle"      => $aryLoop["sDetalle"],
                        "sEstado"       => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
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
        $nIdRegistro            = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $sPlaca                 = isset($_POST['sPlaca']) ? $_POST['sPlaca'] : null;
        $sDetalle               = isset($_POST['sDetalle']) ? $_POST['sDetalle'] : null;
        $nEstado                = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


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
                $nIdNewRegistro = $this->vehiculos->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sPlaca,
                    $sDetalle,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->vehiculos->fncActualizarRegistro(
                    $nIdRegistro,
                    $sPlaca,
                    $sDetalle,
                    $nEstado
                );
            }

            $sSuccess = $nIdRegistro == 0 ? 'Vehiculo registrado exitosamente...' : 'Vehiculo actualizado exitosamente...';
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

            $aryData = $this->vehiculos->fncObtenerRegistros(["nIdVehiculo" => $nIdRegistro]);

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

            $this->vehiculos->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}