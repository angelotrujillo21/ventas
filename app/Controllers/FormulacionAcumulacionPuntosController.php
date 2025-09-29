<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\FormulacionAcumulacionPuntos;

class FormulacionAcumulacionPuntosController extends Controller
{
    //model principal
    public $users;
    public $lotes; // Es mi modelo
    public $session;
    public $catalogotabla;
    public $ubigeo;
    public $sUrlFAP = "mantenimiento-formulacion-acumulacion-puntos";


    public function __construct()
    {
        parent::__construct();
        $this->session        = new Session();
        $this->fap            = new FormulacionAcumulacionPuntos();
        $this->session->init();
    }


    public function index()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/fap', [
                'sTitulo'          => 'Mantenimientos de formulacion de acumulacion de puntos',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlFAP) ? 1 : 0,
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
            $aryData      = $this->fap->fncGetFAP(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlFAP);

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarFAP(" . $aryLoop['nIdFormulacionAcumulacionPuntos'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarFAP(" . $aryLoop['nIdFormulacionAcumulacionPuntos'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarFAP(" . $aryLoop['nIdFormulacionAcumulacionPuntos'] . ");";


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
                        "sDescripcion"      => $aryLoop["sDescripcion"],
                        "nValorInicial"     => $aryLoop["nValorInicial"],
                        "nValorFinal"       => $aryLoop["nValorFinal"],
                        "nPorcentaje"       => $aryLoop["nPorcentaje"],
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarFAP()
    {
        try {
            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $nValorInicial      = isset($_POST['nValorInicial']) ? $_POST['nValorInicial'] : null;
            $nValorFinal        = isset($_POST['nValorFinal']) ? $_POST['nValorFinal'] : null;
            $nPorcentaje        = isset($_POST['nPorcentaje']) ? $_POST['nPorcentaje'] : null;
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

                $nIdNewEegistro = $this->fap->fncGrabarFAP(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sDescripcion,
                    $nValorInicial,
                    $nValorFinal,
                    $nPorcentaje,
                    $nEstado
                );
            } else {

                // Actualizar
                $this->fap->fncActualizarFAP(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sDescripcion,
                    $nValorInicial,
                    $nValorFinal,
                    $nPorcentaje,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Registro agregado exitosamente...' : 'Registro actualizado exitosamente...';

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


            $aryData = $this->fap->fncGetFAP(["nIdFormulacionAcumulacionPuntos" => $nIdRegistro]);

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


            $this->fap->fncEliminarFAP($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}

