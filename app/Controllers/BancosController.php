<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\Bancos;

class BancosController extends Controller
{
    //model principal
    public $bancos; // Es mi modelo
    public $session;

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->bancos           = new Bancos();
        $this->session->init();
    }


    public function index()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/bancos', [
                'sTitulo'          => 'Mantenimientos de bancos',
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
            $aryRows      = [];
            $aryData      = $this->bancos->fncGetBancos(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionShow      = "fncMostrarBanco(" . $aryLoop['nIdBanco'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarBanco(" . $aryLoop['nIdBanco'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarBanco(" . $aryLoop['nIdBanco'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"         => $sAcciones,
                        "sNombre"           => $aryLoop["sNombre"],
                        'sImagen'           => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarBanco()
    {
        try {
            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombre            = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $sImagen            = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            if (isset($sImagen) && !is_null($sImagen)) {
                $sImagen = Upload::process($sImagen, 'multi');
            }

            $nIdNewRegistro = null;
            // Crear
            if ($nIdRegistro == 0) {
                $nIdNewRegistro = $this->bancos->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sDescripcion,
                    $sImagen,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->bancos->fncActualizarRegistro(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sDescripcion,
                    $sImagen,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Banco registrado exitosamente...' : 'Banco actualizado exitosamente...';

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

            $aryData = $this->bancos->fncGetBancos(["nIdBanco" => $nIdRegistro]);

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


            $this->bancos->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetBancos()
    {
        // Recibe valores del formulario

        try {
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $aryData = $this->bancos->fncGetBancos([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nEstado"       => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
