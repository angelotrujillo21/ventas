<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\Lotes;

class LotesController extends Controller
{
    //model principal
    public $users;
    public $lotes; // Es mi modelo
    public $session;

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->lotes            = new Lotes();
        $this->session->init();
    }


    public function index()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/lotes', [
                'sTitulo'          => 'Mantenimientos de lotes',
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
            $aryData      = $this->lotes->fncGetLotes(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarLote(" . $aryLoop['nIdLote'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarLote(" . $aryLoop['nIdLote'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarLote(" . $aryLoop['nIdLote'] . ");";


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
                        "sCodigo"           => $aryLoop["sCodigo"],
                        "sDescripcion"      => $aryLoop["sDescripcion"],
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarLote()
    {
        try {

            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombre            = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sCodigo            = isset($_POST['sCodigo']) ? $_POST['sCodigo'] : null;
            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $nIdNewEegistro = null;
            // Crear
            if ($nIdRegistro == 0) {

                $nIdNewEegistro = $this->lotes->fncGrabarLote(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sCodigo,
                    $sDescripcion,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->lotes->fncActualizarLote(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sCodigo,
                    $sDescripcion,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Lote registrado exitosamente...' : 'Lote actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdNewEegistro" => $nIdNewEegistro));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarRegistro()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $aryData = $this->lotes->fncGetLotes(["nIdLote" => $nIdRegistro]);

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


            $this->lotes->fncEliminarLote($nIdRegistro);
            $this->json(array("success" => 'Lote eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetLotes()
    {
        // Recibe valores del formulario

        try {

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $aryData = $this->lotes->fncGetLotes([
                "nIdSede"    => $user["nIdSede"],
                "nEstado"    => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
