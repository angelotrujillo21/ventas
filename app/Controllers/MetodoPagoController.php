<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\MetodosPagos;

class MetodoPagoController extends Controller
{

    //model principal
    public $session;
    public $catalogoTabla;
    public $metodosPagos;
    public $users;


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogoTabla    = new CatalogoTabla();
        $this->metodosPagos     = new MetodosPagos();
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
            $aryData     = $this->metodosPagos->fncGetMetodosPagos();

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarMetodoPago(" . $aryLoop['nIdMetodoPago'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarMetodoPago(" . $aryLoop['nIdMetodoPago'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarMetodoPago(" . $aryLoop['nIdMetodoPago'] . ");";


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

    public function fncGrabarMetodoPago()
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

            $nIdMetodoPagoNew = null;
            $sNombreImagen    = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            // Crear
            if ($nIdRegistro == 0) {

                // Verficar que no se ha registrado un mismo empleado en la empresa

                $aryMetodoPago = $this->metodosPagos->fncGetMetodosPagos([
                    "sNombre"    => $sNombre
                ]);

                if (fncValidateArray($aryMetodoPago)) {
                    $this->exception('Error. Ya se encuentra registrado un metodo de pago con este nombre. Por favor verifique o solicite asistencia.');
                }

                $nIdMetodoPagoNew = $this->metodosPagos->fncGrabarMetodoPago($sNombre, $sDescripcion, $sNombreImagen, $nEstado);
            } else {
                //Actualizar
                $this->metodosPagos->fncActualizarMetodoPago($nIdRegistro, $sNombre, $sDescripcion, $sNombreImagen, $nEstado);
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Metodo de pago registrado exitosamente...' : 'Metodo de pago actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdMetodoPagoNew" => $nIdMetodoPagoNew));
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


            $aryData = $this->metodosPagos->fncGetMetodosPagos(["nIdMetodoPago" => $nIdRegistro]);

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

            $aryData = $this->metodosPagos->fncGetMetodosPagos(["nIdMetodoPago" => $nIdRegistro]);


            if (fncValidateArray($aryData)) {
                $aryData = $aryData[0];
                // Eliminar la imagen
                if (strlen($aryData['sImagen']) > 0 && !empty($aryData['sImagen'])) {
                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }

            $this->metodosPagos->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Metodo de pago eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateSedeMetodoPago()
    {
        try {

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows      = [];
            $aryData      = $this->metodosPagos->fncGetSedesMetodosPagos([
                "nIdSede" => $user["nIdSede"]
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], "configuracion");

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarSedeMetodoPago(" . $aryLoop['nIdSedeMetodoPago'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarSedeMetodoPago(" . $aryLoop['nIdSedeMetodoPago'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarSedeMetodoPago(" . $aryLoop['nIdSedeMetodoPago'] . ");";


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
                        "sNombrePago"           => $aryLoop["sNombrePago"],
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

    public function fncGrabarSedeMetodoPago()
    {
        try {


            $nIdRegistro     = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdMetodoPago   = isset($_POST['nIdMetodoPago']) ? $_POST['nIdMetodoPago'] : null;
            $sDetalle        = isset($_POST['sDetalle']) ? $_POST['sDetalle'] : null;
            $sImagen         = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $nEstado         = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user) || (!isset($user["nIdSede"]) || !isset($user["nIdEmpresa"]))) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdNewSedeMetodoPago = null;
            $sNombreImagen        = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            // Crear
            if ($nIdRegistro == 0) {

                // Verficar que no se ha registrado un mismo empleado en la empresa

                $aryMetodoPago = $this->metodosPagos->fncGetSedesMetodosPagos([
                    "nIdSede"          => $user["nIdSede"],
                    "nIdMetodoPago"    => $nIdMetodoPago,
                ]);

                if (fncValidateArray($aryMetodoPago)) {
                    $this->exception('Error. Ya se encuentra registrado este metodo de pago para la sede. Por favor verifique o solicite asistencia.');
                }

                $nIdNewSedeMetodoPago = $this->metodosPagos->fncGrabarSedeMetodoPago(
                    $user["nIdSede"],
                    $nIdMetodoPago,
                    $sDetalle,
                    $sNombreImagen,
                    $nEstado
                );
            } else {

                //Actualizar
                $this->metodosPagos->fncActualizarSedeMetodoPago(
                    $nIdRegistro,
                    $user["nIdSede"],
                    $nIdMetodoPago,
                    $sDetalle,
                    $sNombreImagen,
                    $nEstado
                );
            }

            $sSuccess = $nIdRegistro == 0 ? 'Metodo de pago de la sede registrado exitosamente...' : 'Metodo de pago de la sede actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdNewSedeMetodoPago" => $nIdNewSedeMetodoPago));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarSedeMetodoPago()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $aryData = $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSedeMetodoPago" => $nIdRegistro]);

            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarSedeMetodoPago()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSedeMetodoPago" => $nIdRegistro]);

            if (fncValidateArray($aryData)) {
                $aryData = $aryData[0];
                // Eliminar la imagen
                if (strlen($aryData['sImagen']) > 0 && !empty($aryData['sImagen'])) {
                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }

            $this->metodosPagos->fncEliminarSedeMetodoPago($nIdRegistro);
            $this->json(array("success" => 'Metodo de pago de sede eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
