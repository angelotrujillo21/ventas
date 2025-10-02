<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\CatalogoTabla;
use Application\Models\Sedes;
use Application\Models\SerieNumeros;

class SedesController extends Controller
{
    //model principal
    public $users;

    public $session;
    public $sedes;
    public $catalogoTabla;
    public $serieNumeros;

    public $sUrlMiSede  = "mi-sede";

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->sedes            = new Sedes();
        $this->catalogoTabla    = new CatalogoTabla();
        $this->serieNumeros     = new SerieNumeros();

        $this->session->init();
    }



    public function miSede()
    {
        $this->authAdmin($this->session);

        //  Listamos todos los modulos con sus submodilos 

        $user = $this->session->get("user");

        $this->view(
            'admin/mi-sede',
            [
                "sTitulo"               => "Configuracion de mi sede ",
                "user"                  => $user,
                "bShowMenu"             => true,
                "nAdmin"                => $this->fncIsAdmin($user["nIdRol"], $this->sUrlMiSede) ? 1 : 0,
                'aryTipoMoneda'         => $this->catalogoTabla->fncListado("TIPO_MONEDA"),
                'aryTipoTicket'         => $this->catalogoTabla->fncListado("TIPO_TICKET"),
            ]
        );
    }


    public function fncPopulate()
    {
        try {

            $nIdEmpresa     = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;

            // Valida valores del formulario
            $aryRows    = [];
            $aryData    = $this->sedes->fncGetSedes([
                "nIdEmpresa" => $nIdEmpresa
            ]);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionAddSede   = route('usuarios/fncAddSedeForUsuario/' . $aryLoop["nIdSede"]);
                    $sActionShow      = "fncMostrarSede(" . $aryLoop['nIdSede'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarSede(" . $aryLoop['nIdSede'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarSede(" . $aryLoop['nIdSede'] . ");";

                    $sAcciones = '<div class="content-acciones">
                                    <a href="' . $sActionAddSede . '"   title="Ir a mi panel" class="text-primary"><i class="material-icons">dashboard</i> </a>
                                    <a onclick="' . $sActionShow . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>
                                    <a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>
                                    <a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>
                                </div>';

                    $aryRows[] = [
                        "sAcciones"             => $sAcciones,
                        "sNombre"               => $aryLoop["sNombre"],
                        "sDireccion"            => $aryLoop["sDireccion"],
                        "sTelefono"             => $aryLoop["sTelefono"],
                        "sEncargado"            => $aryLoop["sEncargado"],
                        "nTipoMoneda"           => $aryLoop["nTipoMoneda"],
                        "nTipoTicket"           => $aryLoop["nTipoTicket"],
                        "sTipoTicket"           => $aryLoop["sTipoTicket"],
                        "sTipoMoneda"           => $aryLoop["sTipoMoneda"],
                        "sImagen"               => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : (!empty($aryLoop['sImagenEmpresa']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagenEmpresa'])  . '" alt="' . $aryLoop['sImagenEmpresa'] . '">' : ''),
                        "sDescripcion"          => $aryLoop["sDescripcion"] ,
                        "sEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarSede()
    {
        try {
            $nIdRegistro             = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nIdEmpresa              = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;
            $sNombre                 = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sDireccion              = isset($_POST['sDireccion']) ? $_POST['sDireccion'] : null;
            $sTelefono               = isset($_POST['sTelefono']) ? $_POST['sTelefono'] : null;
            $sEncargado              = isset($_POST['sEncargado']) ? $_POST['sEncargado'] : null;
            $nTipoTicket             = isset($_POST['nTipoTicket']) ? $_POST['nTipoTicket'] : null;
            $nTipoMoneda             = isset($_POST['nTipoMoneda']) ? $_POST['nTipoMoneda'] : null;
            $sImagen                 = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $sDescripcion            = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
            $nProduccionSUNAT        = isset($_POST['nProduccionSUNAT']) ? $_POST['nProduccionSUNAT'] : null;
            $sRutaProdSUNAT          = isset($_POST['sRutaProdSUNAT']) ? $_POST['sRutaProdSUNAT'] : null;
            $sTokenProdSUNAT         = isset($_POST['sTokenProdSUNAT']) ? $_POST['sTokenProdSUNAT'] : null;
            $sRutaBetaSUNAT          = isset($_POST['sRutaBetaSUNAT']) ? $_POST['sRutaBetaSUNAT'] : null;
            $sTokenBetaSUNAT         = isset($_POST['sTokenBetaSUNAT']) ? $_POST['sTokenBetaSUNAT'] : null;
            $nEstado                 = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
            $nEnvioAutomaticoSUNAT   = isset($_POST['nEnvioAutomaticoSUNAT']) ? $_POST['nEnvioAutomaticoSUNAT'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $nIdSedeNew    = null;
            $sNombreImagen = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            // Crear
            if ($nIdRegistro == 0) {

                $nIdSedeNew = $this->sedes->fncGrabarRegistro(
                    $nIdEmpresa,
                    $sNombre,
                    $sDireccion,
                    $sTelefono,
                    $sEncargado,
                    $nTipoMoneda,
                    $nTipoTicket,
                    $sNombreImagen,
                    $sDescripcion,
                    $nProduccionSUNAT,
                    $sRutaProdSUNAT,
                    $sTokenProdSUNAT,
                    $sRutaBetaSUNAT,
                    $sTokenBetaSUNAT,
                    $nEstado,
                    $nEnvioAutomaticoSUNAT
                );
                // Crear Sede 1 

                $arySeriesNumerosDefault = $this->catalogoTabla->fncListado("SERIES_NUMEROS_DEFAULT");

                if (fncValidateArray($arySeriesNumerosDefault)) {
                    foreach ($arySeriesNumerosDefault as $key => $aryLoop) {

                        $this->serieNumeros->fncGrabarSerieNumero(
                            $nIdEmpresa,
                            $nIdSedeNew,
                            $aryLoop["sDescripcionLargaItem"],
                            "000000000",
                            $aryLoop["sDescripcionCortaItem"]
                        );

                    }
                }
                
            } else {
                //Actualizar
                $this->sedes->fncActualizarRegistro(
                    $nIdRegistro,
                    $nIdEmpresa,
                    $sNombre,
                    $sDireccion,
                    $sTelefono,
                    $sEncargado,
                    $nTipoMoneda,
                    $nTipoTicket,
                    $sNombreImagen,
                    $sDescripcion,
                    $nProduccionSUNAT,
                    $sRutaProdSUNAT,
                    $sTokenProdSUNAT,
                    $sRutaBetaSUNAT,
                    $sTokenBetaSUNAT,
                    $nEstado,
                    $nEnvioAutomaticoSUNAT
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Sede registrado exitosamente...' : 'Sede actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdSedeNew" => $nIdSedeNew));
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

            $aryData = $this->sedes->fncGetSedes(["nIdSede" => $nIdRegistro]);

            $this->json(array("success" => true, "aryData" => $aryData[0]));
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

            $this->sedes->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Empresa eliminada exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetSedes()
    {
        // Recibe valores del formulario

        try {

            $nIdEmpresa     = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;

            if (is_null($nIdEmpresa)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $aryData = $this->sedes->fncGetSedes([
                "nIdEmpresa" => $nIdEmpresa,
                "nEstado"    => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
