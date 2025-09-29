<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Models\Choferes;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\Vehiculo;

class ChoferController extends Controller
{
    //model principal
    public $choferes; // Es mi modelo
    public $session;
    public $catalogoTabla;
    public $vehiculos;

    public function __construct()
    {
        parent::__construct();
        $this->session             = new Session();
        $this->choferes           = new Choferes();
        $this->catalogoTabla    = new CatalogoTabla();
        $this->vehiculos        = new Vehiculo();

        $this->session->init();
    }

    public function chofer()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/chofer', [
                'sTitulo'          => 'Mantenimientos de choferes',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                'aryTipoDocumento' => $this->catalogoTabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryVehiculo'      => $this->vehiculos->fncObtenerRegistros(["nEstado" => 1])

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

            $aryData = $this->choferes->fncObtenerChoferes([
                "nIdEmpresa" => $user["nIdEmpresa"],
                "nIdSede"    => $user["nIdSede"]
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionEdit      = "fncMostrarRegistro(" . $aryLoop['nIdChofer'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarRegistro(" . $aryLoop['nIdChofer'] . ");";

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
                        "nIdChofer"     => $aryLoop["nIdChofer"],
                        "sDocumento"    => $aryLoop["sTipoDoc"] . " " . $aryLoop["sNumeroDocumento"],
                        "sNombres"      => $aryLoop["sNombres"] . " " . $aryLoop["sApellidos"],
                        "sLicencia"     => $aryLoop["sLicencia"],
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
        $nIdTipoDocumento             = isset($_POST['nIdTipoDocumento']) ? $_POST['nIdTipoDocumento'] : null;
        $sNumeroDocumento       = isset($_POST['sNumeroDocumento']) ? $_POST['sNumeroDocumento'] : null;
        $sNombres               = isset($_POST['sNombres']) ? $_POST['sNombres'] : null;
        $sApellidos         = isset($_POST['sApellidos']) ? $_POST['sApellidos'] : null;
        $nIdVehiculo             = isset($_POST['nIdVehiculo']) ? $_POST['nIdVehiculo'] : null;
        $sLicencia                  = isset($_POST['sLicencia']) ? $_POST['sLicencia'] : null;
        $nEstado                  = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


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



                $nIdNewRegistro = $this->choferes->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdTipoDocumento,
                    $sNumeroDocumento,
                    $sNombres,
                    $sApellidos,
                    $nIdVehiculo,
                    $sLicencia,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->choferes->fncActualizarRegistro(
                    $nIdRegistro,
                    $nIdTipoDocumento,
                    $sNumeroDocumento,
                    $sNombres,
                    $sApellidos,
                    $nIdVehiculo,
                    $sLicencia,
                    $nEstado
                );
            }

            $sSuccess = $nIdRegistro == 0 ? 'Chofer registrado exitosamente...' : 'Chofer actualizado exitosamente...';
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

            $aryData = $this->choferes->fncObtenerChoferes(["nIdChofer" => $nIdRegistro]);

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

            $this->choferes->fncEliminarchoferes($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
