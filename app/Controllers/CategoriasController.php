<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Models\Categorias;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;

class CategoriasController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $categorias;

    public $catalogotabla;
    public $sUrlCategorias = "categorias";

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->catalogotabla    = new CatalogoTabla();
        $this->categorias       = new Categorias();
        $this->session->init();
    }


    public function index()
    {
        try {

            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/categorias', [
                'sTitulo'          => 'Mantenimientos de categorias',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlCategorias) ? 1 : 0
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
            $aryRows  = [];
            $aryData  = $this->categorias->fncGetCategorias([
                "nIdSede" => $user["nIdSede"]
            ]);

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->sUrlCategorias);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarCategoria(" . $aryLoop['nIdCategoria'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarCategoria(" . $aryLoop['nIdCategoria'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarCategoria(" . $aryLoop['nIdCategoria'] . ");";

                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"     => $sAcciones,
                        "nIdCategoria"  => $aryLoop["nIdCategoria"],
                        "sNombre"       => $aryLoop["sNombre"],
                        "sNombrePadre"  => $aryLoop["sNombrePadre"],
                        'sImagen'       => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',
                        "nIdPadre"      => $aryLoop["nIdPadre"],
                        "sEstado"       => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarCategoria()
    {
        try {
            $nIdRegistro     = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombre         = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sImagen         = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $nIdPadre        = isset($_POST['nIdPadre']) ? $_POST['nIdPadre'] : null;
            $nEstado         = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $nIdCategoriaNew = null;
            $sNombreImagen   = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }
            // Crear
            if ($nIdRegistro == 0) {

                $nIdCategoriaNew = $this->categorias->fncGrabarCategoria(
                    $user["nIdSede"],
                    $sNombre,
                    $sNombreImagen,
                    $nIdPadre,
                    $nEstado
                );
            } else {

                //Actualizar

                $this->categorias->fncActualizarCategoria(
                    $nIdRegistro,
                    $user["nIdSede"],
                    $sNombre,
                    $sNombreImagen,
                    $nIdPadre,
                    $nEstado
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Categoria registrado exitosamente...' : 'Categoria actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdCategoriaNew" => $nIdCategoriaNew));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarCategoria()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->categorias->fncGetCategorias(["nIdCategoria" => $nIdRegistro]);

            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarCategoria()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->categorias->fncGetCategorias(["nIdCategoria" => $nIdRegistro]);

            if (fncValidateArray($aryData)) {
                $aryData = $aryData[0];
                // Eliminar la imagen
                if (!empty($aryData['sImagen']) && strlen($aryData['sImagen']) > 0) {
                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }

            $this->categorias->fncEliminarCategoria($nIdRegistro);
            $this->json(array("success" => 'Categoria eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncObtenerArbolCategorias()
    {
        // Recibe valores del formulario
        try {

            $user = $this->session->get('user');

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            $aryData = $this->fncProcesarArbolCategorias($user["nIdSede"]);

            $this->json(array("success" => 'Mostrando resultado obtenidos..', "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function fncProcesarArbolCategorias($nIdSede = 0, $nIdPadre = 0,  $sSpacing = '', $aryUserTreeArray = '')
    {
        try {

            if (!is_array($aryUserTreeArray))
                $aryUserTreeArray = array();

            $aryData = $this->categorias->fncGetCategorias(["nIdPadre" => $nIdPadre, "nIdSede" => $nIdSede, "nEstado" => 1]);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {
                    $aryUserTreeArray[] = [
                        "nIdCategoria" => $aryLoop["nIdCategoria"], 
                        "sNombre"      => $sSpacing . strup($aryLoop["sNombre"])
                    ];
                    $aryUserTreeArray = $this->fncProcesarArbolCategorias($nIdSede, $aryLoop["nIdCategoria"], $sSpacing . '&nbsp;&nbsp;', $aryUserTreeArray);
                }
            }

            return $aryUserTreeArray;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
