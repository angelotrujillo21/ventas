<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;
use Application\Models\SerieNumeros;

class SerieNumerosController extends Controller
{

    //model principal
    public $session;
    public $catalogoTabla;
    public $serieNumeros;
    public $users;


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogoTabla    = new CatalogoTabla();
        $this->serieNumeros     = new SerieNumeros();
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
            $aryRows  = [];
            $aryData  = $this->serieNumeros->fncGetSerieNumeros([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nIdSede"       => $user["nIdSede"],
                //"sAryNombres"   => " 'BOLETA', 'FACTURA' , 'TICKET' ",
            ]);

            $bIsAdmin    = $this->fncIsAdmin($user["nIdRol"], "configuracion");
            $aryNombres  = ['BOLETA', 'FACTURA', 'TICKET','PEDIDO' , 'COTIZACION'];

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarSN(" . $aryLoop['nIdSerie'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarSN(" . $aryLoop['nIdSerie'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarSN(" . $aryLoop['nIdSerie'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>' : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>' : '';



                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . (in_array(trim(strup($aryLoop["sNombre"])), $aryNombres) ? ""  : $sLinkDelete) . '
                                 </div>';

                    $aryRows[] = [
                        "sAcciones"     => $sAcciones,
                        "sNombre"       => strup($aryLoop["sNombre"]),
                        "sValor"        => strup($aryLoop["sValor"]),
                        "sPrefijo"      => strup($aryLoop["sPrefijo"]),
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarSerieNumero()
    {
        try {

            $nIdRegistro     = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombre         = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sPrefijo        = isset($_POST['sPrefijo']) ? $_POST['sPrefijo'] : null;
            $sValor          = isset($_POST['sValor']) ? $_POST['sValor'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdSN = null;

            if ($nIdRegistro == 0) {

                $aryData = $this->serieNumeros->fncGetSerieNumeros([
                    "nIdSede"   => $user["nIdSede"],
                    "sPrefijo"  => $sPrefijo,
                ]);

                if (fncValidateArray($aryData)) {
                    $this->exception("Error . Ya se encuentra registrado la serie .Porfavor verifique");
                }

                $aryData = $this->serieNumeros->fncGetSerieNumeros([
                    "nIdSede"   =>  $user["nIdSede"],
                    "sNombre"    => $sNombre,
                ]);

                if (fncValidateArray($aryData)) {
                    $this->exception("Error . Ya se encuentra registrado el nombre .Porfavor verifique");
                }

                $nIdSN = $this->serieNumeros->fncGrabarSerieNumero(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sValor,
                    $sPrefijo
                );
            } else {

                //Actualizar
                $this->serieNumeros->fncActualizarSerieNumero(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sValor,
                    $sPrefijo
                );
                
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Serie Numero registrado exitosamente...' : 'Serie Numero actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdSN" => $nIdSN));
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


            $aryData = $this->serieNumeros->fncGetSerieNumeros(["nIdSerie" => $nIdRegistro]);

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

            $this->serieNumeros->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Serie Numero eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
