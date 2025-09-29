<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Models\Ubigeo;
use Application\Models\Clientes;
use Application\Models\Empresas;
use Application\Models\CatalogoTabla;
use Application\Core\Controller as Controller;

class EmpresasController extends Controller
{
    //model principal
    public $users;

    public $session;
    public $empresas;
    public $catalogoTabla;


    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->empresas         = new Empresas();
        $this->catalogoTabla    = new CatalogoTabla();
        $this->session->init();
    }


    public function index()
    {
        try {


            if (is_null($this->session->get("user"))) {
                $this->redirect("acceso");
            }

            $nIdRolAdmin = $this->fncGetVarConfig("nIdRolAdmin");

            $user = $this->session->get("user");

            if (!is_null($user) && $user["nIdRol"] != $nIdRolAdmin) {
                $this->exception("Error. Usted no es administrador no tiene permisos para este vista .Porfavor verifique o solicite asistencia");
            }

            $this->view('admin/empresas', [
                'sTitulo'          => 'Mis Empresas',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => false,
                'aryTipoDocumento' => $this->catalogoTabla->fncListado("TIPO_DOCUMENTO_IDENTIDAD"),
                'aryTipoMoneda'    => $this->catalogoTabla->fncListado("TIPO_MONEDA"),
                'aryTipoTicket'    => $this->catalogoTabla->fncListado("TIPO_TICKET"),
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
                $this->exception("Error. no existe el usuario para poder listar las empresas.Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows    = [];
            $aryData    = $this->empresas->fncGetEmpresas(["nIdUsuario" => $user["nIdUsuario"]]);

            if (fncValidateArray($aryData)) {
                foreach ($aryData as $aryLoop) {

                    $sUrl = route('acceso?nIdEmpresa=' . $aryLoop['nIdEmpresa']);
                    $sUrlNuevoCliente = route('ncliente/' . $aryLoop['nIdEmpresa']);

                    $sActioReportSedes    = "fncMostrarReportSedes(" . $aryLoop['nIdEmpresa'] . " , '" . fncCleanQuotes($aryLoop["sNombre"]) . "');";
                    $sActioVerSedes       = "fncMostrarMantenimientoSedes(" . $aryLoop['nIdEmpresa'] . ");";
                    $sActionShow          = "fncMostrarEmpresa(" . $aryLoop['nIdEmpresa'] . ", 'ver' );";
                    $sActionEdit          = "fncMostrarEmpresa(" . $aryLoop['nIdEmpresa'] . ", 'editar' );";
                    $sActionEliminar      = "fncEliminarEmpresa(" . $aryLoop['nIdEmpresa'] . ");";

                    $sActionCopyURL                  = "fncCopyLinkEmpresa(" . $aryLoop['nIdEmpresa'] . " , '" . $sUrl . "');";
                    $sActionCopyURLNuevoCliente      = "fncCopyLinkEmpresa(" . $aryLoop['nIdEmpresa'] . " , '" . $sUrlNuevoCliente . "');";


                    $sAcciones = '<div class="content-acciones">
                                    <a onclick="' . $sActioVerSedes . '" href="javascript:;"   title="Ver Sedes" class="text-primary"><i class="material-icons">view_list</i> </a>
                                    <a onclick="' . $sActionCopyURLNuevoCliente . '" href="javascript:;"   title="Copiar link para creacion de un cliente" class="text-primary"><i class="material-icons">person</i> </a>
                                    <a onclick="' . $sActionCopyURL . '" href="javascript:;"   title="Copiar URL de login directo" class="text-primary"><i class="material-icons">insert_link</i> </a>
                                    <a onclick="' . $sActioReportSedes . '" href="javascript:;"   title="Ver Reporte" class="text-primary"><i class="material-icons">timeline</i> </a>
                                    <a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>
                                    <a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>
                                    <a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>
                                </div>';

                    $aryRows[] = [
                        "sAcciones"             => $sAcciones,
                        "sTipoDocumento"        => $aryLoop["sTipoDoc"],
                        "sNumeroDocumento"      => $aryLoop["sNumeroDocumento"],
                        "dFechaCreacion"        => $aryLoop["dFechaCreacion"],
                        "sNombre"               => $aryLoop["sNombre"],
                        "sDireccion"            => $aryLoop["sDireccion"],
                        "sCorreo"               => $aryLoop["sCorreo"],
                        "sTelefono"             => $aryLoop["sTelefono"],
                        "sImagen"               =>  !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',
                        "sEstado"               => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarEmpresa()
    {
        try {
            $nIdRegistro             = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $nTipoDocumento          = isset($_POST['nTipoDocumento']) ? $_POST['nTipoDocumento'] : null;
            $sNumeroDocumento        = isset($_POST['sNumeroDocumento']) ? $_POST['sNumeroDocumento'] : null;
            $sNombre                 = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sDireccion              = isset($_POST['sDireccion']) ? $_POST['sDireccion'] : null;
            $sCorreo                 = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : null;
            $sTelefono               = isset($_POST['sTelefono']) ? $_POST['sTelefono'] : null;
            $sImagen                 = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $sImagenFondoLogin       = isset($_FILES['sImagenFondoLogin']) ? $_FILES['sImagenFondoLogin'] : null;
            $nEstado                 = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
            $sDescripcion1Ctz        = isset($_POST['sDescripcion1Ctz']) ? $_POST['sDescripcion1Ctz'] : null;
            $sDescripcion2Ctz        = isset($_POST['sDescripcion2Ctz']) ? $_POST['sDescripcion2Ctz'] : null;
            $sDescripcion3Ctz        = isset($_POST['sDescripcion3Ctz']) ? $_POST['sDescripcion3Ctz'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $nIdEmpresaNew = null;
            $sNombreImagen = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            if (isset($sImagenFondoLogin) && !is_null($sImagenFondoLogin)) {
                $sImagenFondoLogin = Upload::process($sImagenFondoLogin, 'multi');
            }


            $nIdRolAdmin = $this->fncGetVarConfig("nIdRolAdmin");

            $user = $this->session->get("user");

            if (!is_null($user) && $user["nIdRol"] != $nIdRolAdmin) {
                $this->exception("Error. Usted no es administrador no puede agregar empresas.Porfavor verifique o solicite asistencia");
            }

            // Crear
            if ($nIdRegistro == 0) {
                $aryDataCliValidacion =  $this->empresas->fncGetEmpresas(["sNumeroDocumento" => $sNumeroDocumento]);

                if (fncValidateArray($aryDataCliValidacion)) {
                    $this->exception("Error. Ya existe una empresa con este numero de documento . Porfavor verifique");
                }

                $nIdEmpresaNew = $this->empresas->fncGrabarRegistro(
                    $user["nIdUsuario"],
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombre,
                    $sDireccion,
                    $sCorreo,
                    $sTelefono,
                    $sNombreImagen,
                    $sImagenFondoLogin,
                    $nEstado,
                    $sDescripcion1Ctz,
                    $sDescripcion2Ctz,
                    $sDescripcion3Ctz
                );
                // Crear Sede 1
            } else {
                //Actualizar
                $this->empresas->fncActualizarRegistro(
                    $nIdRegistro,
                    $user["nIdUsuario"],
                    $nTipoDocumento,
                    $sNumeroDocumento,
                    $sNombre,
                    $sDireccion,
                    $sCorreo,
                    $sTelefono,
                    $sNombreImagen,
                    $sImagenFondoLogin,
                    $nEstado,
                    $sDescripcion1Ctz,
                    $sDescripcion2Ctz,
                    $sDescripcion3Ctz
                );
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Empresa registrado exitosamente...' : 'Empresa actualizado exitosamente...';

            $this->json(array("success" => $sSuccess, "nIdEmpresaNew" => $nIdEmpresaNew));
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

            $aryData = $this->empresas->fncGetEmpresas(["nIdEmpresa" => $nIdRegistro]);

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

            $this->empresas->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Empresa eliminada exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGetEmpresas()
    {
        // Recibe valores del formulario

        try {

            $nIdEmpresa = isset($_POST["nIdEmpresa"]) ? $_POST["nIdEmpresa"] : null;
            $nIdUsuario = isset($_POST["nIdUsuario"]) ? $_POST["nIdUsuario"] : null;

            $aryData = $this->empresas->fncGetEmpresas([
                "nIdEmpresa"  => $nIdEmpresa,
                "nIdUsuario"  => $nIdUsuario,
                "nEstado"     => 1
            ]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
