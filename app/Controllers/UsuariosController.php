<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Mail;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Models\Roles;
use Application\Models\Sedes;
use Application\Models\Users;
use Application\Models\Empleados;
use Application\Core\Controller as Controller;
use Application\Models\Empresas;

class UsuariosController extends Controller

{

    //model principal
    public $negocios;
    public $session;
    public $users;
    public $roles;
    public $empleados;
    public $empresas;

    public function __construct()
    {
        parent::__construct();

        $this->session      = new Session();
        $this->users        = new Users();
        $this->roles        = new Roles();
        $this->sedes        = new Sedes();
        $this->empleados    = new Empleados();
        $this->empresas     = new Empresas();

        $this->session->init();
    }

    public function index()
    {

        $this->authAdmin($this->session);

        $this->view(
            'admin/cuentas',
            [
                "sTitulo"    => "Mantemiento de usuarios",
                "user"       => $this->session->get("user"),
            ]
        );
    }

    public function fncAddSedeByUsuario($nIdSede)
    {

        try {

            $user = $this->session->get("user");

            if (!is_null($user)) {

                $arySede = $this->sedes->fncGetSedes(["nIdSede" => $nIdSede]);

                if (fncValidateArray($arySede)) {
                    $arySede = $arySede[0];

                    $user["nIdSede"]         = $arySede["nIdSede"];
                    $user["nIdEmpresa"]      = $arySede["nIdEmpresa"];

                    $user["sEmpresa"]  = $arySede["sNombreEmpresa"];
                    $user["sSede"]     = $arySede["sNombre"];


                    $user["sImagenEmpresa"]  = $arySede["sImagenEmpresa"];
                    $user["sImagenSede"]     = $arySede["sImagenSede"];
                    $this->session->add("user", $user);

                    $this->redirect("empleados");
                } else {
                    $this->redirect("empresas");
                }
            } else {
                $this->redirect("");
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    // public function fncPopulate()
    // {
    //     try {

    //         $aryResultado = $this->users->fncObtenerUsuarios();
    //         $aryRows = [];

    //         if ($aryResultado != false) {
    //             foreach ($aryResultado as $aryLoop) {

    //                 $sLinkEdit   = 'fncMostrarRegistro( ' . $aryLoop['nIdUsuario'] . ' )';
    //                 $sLinkDelete = 'fncEliminarRegistro( ' . $aryLoop['nIdUsuario'] . ' )';

    //                 $sActions = '<center>
    //                              <a onclick="' . $sLinkEdit . '" class="action-table far fa-edit" data-toggle="tooltip" data-placement="bottom" title="Editar"></a>
    //                              <a onclick="' . $sLinkDelete . '" class="action-table far fa-trash-alt text-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar"></a>                      
    //                         </center>';

    //                 $aryRows[] = array(
    //                     'sAcciones'     => $aryLoop['nIdUsuario'] == 1 ? "" : $sActions,
    //                     'nIdUsuario'    => $aryLoop['nIdUsuario'],
    //                     'sNombre'       => $aryLoop['sNombre'],
    //                     'sApellidos'    => $aryLoop['sApellidos'],
    //                     'sLogin'        => $aryLoop['sLogin'],
    //                     'sClave'        => $aryLoop['sClave'],
    //                     'sImagen'       => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',
    //                     'sNombreRol'    => $aryLoop['sNombreRol'],
    //                     'sEstado'       => $aryLoop['nestado'] == '1' ? 'ACTIVO' : 'INACTIVO',
    //                 );
    //             }
    //         }

    //         $this->json($aryRows);
    //     } catch (Exception $ex) {
    //         echo $ex->getMessage();
    //     }
    // }


    public function fncGrabarUsuario()
    {
        try {

            $nIdRegistro   = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombre       = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
            $sApellidos    = isset($_POST['sApellidos']) ? $_POST['sApellidos'] : null;
            $sLogin        = isset($_POST['sLogin']) ? $_POST['sLogin'] : null;
            $sClave        = isset($_POST['sClave']) ? $_POST['sClave'] : null;
            $sImagen       = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;
            $nIdRol        = isset($_POST['nIdRol']) ? $_POST['nIdRol'] : null;
            $sCorreo       = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : null;

            $sImagenFondoLogin    = isset($_FILES['sImagenFondoLogin']) ? $_FILES['sImagenFondoLogin'] : null;
            $sImagenLogoGeneral   = isset($_FILES['sImagenLogoGeneral']) ? $_FILES['sImagenLogoGeneral'] : null;

            $nEstado       = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;


            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($sNombre) || is_null($sApellidos) || is_null($sLogin) || is_null($sClave)  || is_null($nIdRol)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }


            $sNombreImagen = null;
            $nIdUsuarioNew = null;

            if (isset($sImagen) && !is_null($sImagen)) {
                $sNombreImagen = Upload::process($sImagen, 'multi');
            }

            if (isset($sImagenFondoLogin) && !is_null($sImagenFondoLogin)) {
                $sImagenFondoLogin = Upload::process($sImagenFondoLogin, 'multi');
            }

            if (isset($sImagenLogoGeneral) && !is_null($sImagenLogoGeneral)) {
                $sImagenLogoGeneral = Upload::process($sImagenLogoGeneral, 'multi');
            }

            // Crear 
            if ($nIdRegistro == 0) {

                // Verficar que no se ha registrado un empleado con el mismo login 

                $aryUsuario = $this->users->fncGetUsuarios([
                    "sLogin"      => $sLogin,
                ]);

                if (fncValidateArray($aryUsuario)) {
                    $this->exception('Error. Ya se encuentra registrado un usuario con este login , pruebe con otro . Gracias.');
                }


                $nIdUsuarioNew = $this->users->fncGrabarUsuario(
                    $sNombre,
                    $sApellidos,
                    $sLogin,
                    $sClave,
                    $sNombreImagen,
                    $nIdRol,
                    $sCorreo,
                    $sImagenFondoLogin,
                    $sImagenLogoGeneral,
                    $nEstado
                );
            } else {

                //Actualizar


                $aryUsuario = $this->users->fncGetUsuarios([
                    "nIdUsuarioNot" => $nIdRegistro,
                    "sLogin"        => $sLogin,
                ]);

                if (fncValidateArray($aryUsuario)) {
                    $this->exception('Error. Ya se encuentra registrado un usuario con este login , pruebe con otro . Gracias.');
                }

                $aryEmpresas = $this->empresas->fncGetEmpresas(["nIdUsuario" => $nIdRegistro]);

                if (fncValidateArray($aryEmpresas)) {
                    foreach ($aryEmpresas as $aryEmpresa) {

                        $aryEmpleado = $this->empleados->fncGetEmpleados([
                            "sLogin"      => $sLogin,
                            "nIdEmpresa"  => $aryEmpresa["nIdEmpresa"]
                        ]);

                        if (fncValidateArray($aryEmpleado)) {
                            $this->exception('Error. Ya se encuentra registrado un empleado con este login en la empresa , pruebe con otro . Gracias.');
                        }
                    }
                }

                $this->users->fncActualizarUsuario(
                    $nIdRegistro,
                    $sNombre,
                    $sApellidos,
                    $sLogin,
                    $sClave,
                    $sNombreImagen,
                    $nIdRol,
                    $sCorreo,
                    $sImagenFondoLogin,
                    $sImagenLogoGeneral,
                    $nEstado
                );

                $user = $this->session->get("user");

                if ($nIdRol == $this->fncGetVarConfig("nIdRolAdmin") && !is_null($user)) {

                    $rolesController = new RolesController();

                    $aryUsuario = $this->users->fncGetUsuarios(["nIdUsuario" => $nIdRegistro])[0];

                    if (isset($user["nIdEmpresa"]) && isset($user["nIdSede"])) {
                        $aryUsuario["nIdEmpresa"] = $user["nIdEmpresa"];
                        $aryUsuario["nIdSede"]    = $user["nIdSede"];
                    }

                    $aryUsuario["aryModulos"]     = $rolesController->fncGetModulosAndSubmodulos($nIdRol);

                    $aryUsuario["sModuloDefault"]  = "empresas";

                    $this->session->add('user', $aryUsuario);
                }
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Usuario registrado exitosamente...' : 'Usuario actualizado exitosamente...';
            $this->json(array("success" => $sSuccess, "nIdUsuarioNew" => $nIdUsuarioNew));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncMostrarUsuario()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = [];
            $aryData = $this->users->fncGetUsuarios(["nIdUsuario" => $nIdRegistro]);

            $sURLAcceso = route("acceso?nIdUsuario=" . $nIdRegistro);

            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null, "sURLAcceso" => $sURLAcceso));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarUsuario()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }


            $aryData = $this->users->fncGetUsuarios(["nIdUsuario" => $nIdRegistro]);

            if (fncValidateArray($aryData)) {
                $aryData = $aryData[0];
                // Eliminar la imagen
                if (!empty($aryData['sImagen']) && strlen($aryData["sImagen"]) > 0) {
                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }

            $this->users->fncEliminarUsuario($nIdRegistro);
            $this->json(array("success" => 'Usuario eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncRecuperarClave()
    {
        $nTipoUsuario   = isset($_POST['nTipoUsuario']) ? $_POST['nTipoUsuario'] : null;
        $nIdEmpresa     = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;
        $nIdSede        = isset($_POST['nIdSede']) ? $_POST['nIdSede'] : null;
        $sCorreo        = isset($_POST['sCorreo']) ? $_POST['sCorreo'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nTipoUsuario)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $nIdRolAdmin = $this->fncGetVarConfig("nIdRolAdmin");
            $mail        = new Mail();

            if ($nIdRolAdmin == $nTipoUsuario) {
                // Recuperar la cuenta del admin
                $aryUsuario = $this->users->fncGetUsuarios(["sCorreo" => $sCorreo]);
                if (fncValidateArray($aryUsuario)) {
                    $aryUsuario = $aryUsuario[0];

                    $sHtml = "<p>Hola " . $aryUsuario["sNombre"] . "  " . $aryUsuario["sApellidos"] . " .</p> <p> Sus credenciales son: </p> " . " <p> Login : " . $aryUsuario["sLogin"] . "</p>" . " <p> Clave : " . $aryUsuario["sClave"] . "</p>";

                    if ($mail->send(['sFrom' => NOMBRE_SITIO, 'subject' => 'Recuperacion  de clave', 'body' => $sHtml, 'sCorreo' => $aryUsuario["sCorreo"], 'sNombre' => $aryUsuario["sNombre"] . " " . $aryUsuario["sApellidos"]])) {
                        $this->json(array("success" => "Se envio al correo con sus credenciales . Muchas gracias"));
                    } else {
                        $this->json(array("error" => "Error.No se puede enviar el correo. Porfavor requiera asesoria. "));
                    }
                } else {
                    $this->exception('Error. No se pudo ubicar un usuario con este correo. Por favor verifique.');
                }
            } else {
                $aryEmpleado = $this->empleados->fncGetEmpleados(["nIdEmpresa" => $nIdEmpresa, "nIdSede" => $nIdSede, "sCorreo" => $sCorreo]);
                if (fncValidateArray($aryEmpleado)) {
                    $aryEmpleado = $aryEmpleado[0];

                    $sHtml = "<p>Hola " . $aryEmpleado["sNombre"]   . " .</p> <p> Sus credenciales son: </p> " . " <p> Login : " . $aryEmpleado["sLogin"] . "</p>" . " <p> Clave : " . $aryEmpleado["sClave"] . "</p>";

                    if ($mail->send(['sFrom' => NOMBRE_SITIO, 'subject' => 'Recuperacion  de clave', 'body' => $sHtml, 'sCorreo' => $aryEmpleado["sCorreo"], 'sNombre' => $aryEmpleado["sNombre"]])) {
                        $this->json(array("success" => "Se envio al correo con sus credenciales . Muchas gracias"));
                    } else {
                        $this->json(array("error" => "Error.No se puede enviar el correo. Porfavor requiera asesoria. "));
                    }
                } else {
                    $this->exception('Error. No se pudo ubicar un empleado con este correo. Por favor verifique.');
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
