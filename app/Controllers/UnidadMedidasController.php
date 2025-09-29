<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\CatalogoTabla;
use Application\Models\UnidadMedidas;

class UnidadMedidasController extends Controller
{
    //model principal
    public $users;
    public $clientes; // Es mi modelo
    public $session;
    public $catalogotabla;
    public $unidadMedidas;


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogotabla    = new CatalogoTabla();
        $this->unidadMedidas    = new UnidadMedidas();
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
            $aryRows      = [];
            $aryClientes  = $this->unidadMedidas->fncGetUnidadesMedidas(["nIdEmpresa" => $user["nIdEmpresa"] , "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], "configuracion");

            if (is_array($aryClientes) && count($aryClientes) > 0) {
                foreach ($aryClientes as $aryLoop) {

                    $sActionShow      = "fncMostrarUM(" . $aryLoop['nIdUnidadMedida'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarUM(" . $aryLoop['nIdUnidadMedida'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarUM(" . $aryLoop['nIdUnidadMedida'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"             => $sAcciones,
                        "nIdUnidadMedida"       => $aryLoop["nIdUnidadMedida"],
                        "nIdEmpresa"            => $aryLoop["nIdEmpresa"],
                        "nIdSede"               => $aryLoop["nIdSede"],
                        "sNombreLargo"          => $aryLoop["sNombreLargo"],
                        "sNombreCorto"          => $aryLoop["sNombreCorto"],
                        "sEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarUnidadMedida()
    {
        try {

            $nIdRegistro             = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombreLargo            = isset($_POST['sNombreLargo']) ? $_POST['sNombreLargo'] : null;
            $sNombreCorto            = isset($_POST['sNombreCorto']) ? $_POST['sNombreCorto'] : null;
            $nEstado                 = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $nIdUnidadMedidaNew = null;
            // Crear
            if ($nIdRegistro == 0) {

                $aryDataValidacion = $this->unidadMedidas->fncGetUnidadesMedidas([
                    "nIdEmpresa"       => $user["nIdEmpresa"],
                    "sNombreLargo"     => $sNombreLargo,
                 ]);

                if (fncValidateArray($aryDataValidacion)) {
                    $this->exception("Error. Ya existe una unidad de medida con este nombre registrado en la empresa . Porfavor verifique");
                }

                $nIdUnidadMedidaNew = $this->unidadMedidas->fncGrabarUnidadMedida(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombreLargo,
                    $sNombreCorto,
                    $nEstado
                );
            } else {
                //Actualizar
                $this->unidadMedidas->fncActualizarUnidadMedida(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombreLargo,
                    $sNombreCorto,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Unidad Medida registrado exitosamente...' : 'Unidad Medida actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdUnidadMedidaNew" => $nIdUnidadMedidaNew));
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


            $aryData = $this->unidadMedidas->fncGetUnidadesMedidas(["nIdUnidadMedida" => $nIdRegistro]);

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


            $this->unidadMedidas->fncEliminarUnidadMedida($nIdRegistro);
            $this->json(array("success" => 'Unidad de medida eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetUnidadesMedida()
    {
 
        try {

            
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            $aryData = $this->unidadMedidas->fncGetUnidadesMedidas([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nEstado"       => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncImportarUnidadesMedidasPorDefault()
    {
        // Recibe valores del formulario

        try {

            $user = $this->session->get("user");

            // var_dump($user);

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder importar los registros .Porfavor verifique o solicite asistencia");
            }

            $aryUnidadesMedidas = $this->catalogotabla->fncListado("UNIDAD_MEDIDA");

            if (fncValidateArray($aryUnidadesMedidas)) {
                foreach ($aryUnidadesMedidas as $aryLoop) {

                    $aryDataValidacion = $this->unidadMedidas->fncGetUnidadesMedidas([
                        "nIdEmpresa"       => $user["nIdEmpresa"],
                        "nIdSede"          => $user["nIdSede"],
                        "sNombreLargo"     => $aryLoop["sDescripcionLargaItem"],
                     ]);
    
                    if (!fncValidateArray($aryDataValidacion)) {
 
                        $this->unidadMedidas->fncGrabarUnidadMedida(
                            $user["nIdEmpresa"],
                            $user["nIdSede"],
                            $aryLoop["sDescripcionLargaItem"],
                            $aryLoop["sDescripcionCortaItem"],
                            1
                        );

                    }

                }
            }

            $this->json(array("success" => "Genial! Datos importados correctamente..."));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
