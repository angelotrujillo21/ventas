<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\MetodosEnvios;
 
class MetodoEnvioController extends Controller
{

    //model principal
    public $session;
    public $catalogoTabla;
    public $metodosEnvio;
    public $users;


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogoTabla    = new CatalogoTabla();
        $this->metodosEnvio     = new MetodosEnvios();
        $this->session->init();
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
            $aryData     = $this->metodosEnvio->fncGetMetodosEnvio();

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarMetodoEnvio(" . $aryLoop['nIdMetodoPago'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarMetodoEnvio(" . $aryLoop['nIdMetodoPago'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarMetodoEnvio(" . $aryLoop['nIdMetodoPago'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>';
                    $sLinkDelete = '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"             => $sAcciones,
                        "sNombre"               => $aryLoop["sNombre"],
                        "sDescripcion"          => $aryLoop["sDescripcion"],
                        "sImagen"               => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',
                        "sEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarMetodoEnvio()
    {
        try {
            $nIdRegistro     = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombre         = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sDescripcion    = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $sImagen         = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $nEstado         = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdMetodoEnvioNew = null;
            $sNombreImagen     = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            // Crear
            if ($nIdRegistro == 0) {

                // Verficar que no se ha registrado un mismo empleado en la empresa

                $aryMetodoEnvio = $this->metodosEnvio->fncGetMetodosEnvio([
                    "sNombre"    => $sNombre
                ]);

                if (fncValidateArray($aryMetodoEnvio)) {
                    $this->exception('Error. Ya se encuentra registrado un metodo de envio con este nombre. Por favor verifique o solicite asistencia.');
                }

                $nIdMetodoEnvioNew = $this->metodosEnvio->fncGrabarMetodoEnvio(
                    $sNombre,
                    $sDescripcion,
                    $sNombreImagen,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->metodosEnvio->fncActualizarMetodoEnvio(
                    $nIdRegistro,
                    $sNombre,
                    $sDescripcion,
                    $sNombreImagen,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Metodo de envio registrado exitosamente...' : 'Metodo de envio actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdMetodoEnvioNew" => $nIdMetodoEnvioNew));
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


            $aryData = $this->metodosEnvio->fncGetMetodosEnvio(["nIdMetodoEnvio" => $nIdRegistro]);

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
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->metodosEnvio->fncGetMetodosEnvio(["nIdMetodoEnvio" => $nIdRegistro]);


            if (fncValidateArray($aryData)) {
                $aryData = $aryData[0];
                // Eliminar la imagen
                if (strlen($aryData['sImagen']) > 0 && !empty($aryData['sImagen'])) {
                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }

            $this->metodosEnvio->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Metodo de pago eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateSedeMetodoEnvio()
    {
        try {

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];
            $aryData      = $this->metodosEnvio->fncGetSedesMetodosEnvio([
                "nIdSede" => $user["nIdSede"]
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], "configuracion");

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarSedeMetodoEnvio(" . $aryLoop['nIdSedeMetodoEnvio'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarSedeMetodoEnvio(" . $aryLoop['nIdSedeMetodoEnvio'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarSedeMetodoEnvio(" . $aryLoop['nIdSedeMetodoEnvio'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   =  $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>' : '';
                    $sLinkDelete =  $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>' : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"             => $sAcciones,
                        "sNombreEnvio"          => $aryLoop["sNombreEnvio"],
                        "sDetalle"              => $aryLoop["sDetalle"],
                        "sImagen"               => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',
                        "sEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarSedeMetodoEnvio()
    {
        try {


            $nIdRegistro      = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdMetodoEnvio   = isset($_POST['nIdMetodoEnvio']) ? $_POST['nIdMetodoEnvio'] : null;
            $sDetalle         = isset($_POST['sDetalle']) ? $_POST['sDetalle'] : null;
            $sImagen          = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $nEstado          = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user) || (!isset($user["nIdSede"]) || !isset($user["nIdEmpresa"]))) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdNewSedeMetodoEnvio = null;
            $sNombreImagen         = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            // Crear
            if ($nIdRegistro == 0) {

                // Verficar que no se ha registrado un mismo empleado en la empresa

                $aryMetodoEnvio = $this->metodosEnvio->fncGetSedesMetodosEnvio([
                    "nIdSede"           => $user["nIdSede"],
                    "nIdMetodoEnvio"    => $nIdMetodoEnvio,
                ]);

                if (fncValidateArray($aryMetodoEnvio)) {
                    $this->exception('Error. Ya se encuentra registrado un metodo de envio con este nombre. Por favor verifique o solicite asistencia.');
                }

                $nIdNewSedeMetodoEnvio = $this->metodosEnvio->fncGrabarSedeMetodoEnvio(
                    $user["nIdSede"],
                    $nIdMetodoEnvio,
                    $sDetalle,
                    $sNombreImagen,
                    $nEstado
                );
            } else {

                //Actualizar
                $this->metodosEnvio->fncActualizarSedeMetodoPago(
                    $nIdRegistro ,
                    $user["nIdSede"],
                    $nIdMetodoEnvio,
                    $sDetalle,
                    $sNombreImagen,
                    $nEstado
                );
            }

            $sSuccess = $nIdRegistro == 0 ? 'Metodo de envio de la sede registrado exitosamente...' : 'Metodo de envio de la sede actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdNewSedeMetodoEnvio" => $nIdNewSedeMetodoEnvio));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarSedeMetodoEnvio()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $aryData = $this->metodosEnvio->fncGetSedesMetodosEnvio(["nIdSedeMetodoEnvio" => $nIdRegistro]);

            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarSedeMetodoEnvio()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->metodosEnvio->fncGetSedesMetodosEnvio(["nIdSedeMetodoEnvio" => $nIdRegistro]);

            if (fncValidateArray($aryData)) {
                $aryData = $aryData[0];
                // Eliminar la imagen
                if (strlen($aryData['sImagen']) > 0 && !empty($aryData['sImagen'])) {
                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }

            $this->metodosEnvio->fncEliminarSedeMetodoPago($nIdRegistro);
            $this->json(array("success" => 'Metodo de envio de sede eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}

