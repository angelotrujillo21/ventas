<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\Negocios;
use Application\Models\Roles;

class RolesController extends Controller
{

    //model principal
    public $negocios;
    public $session;
    public $users;
    public $roles;
    public $sUrlRoles = "roles";

    public function __construct()
    {
        parent::__construct();
        $this->roles    = new Roles();
        $this->session  = new Session();
        $this->session->init();
    }

    public function index()
    {
        $this->authAdmin($this->session);


        $aryDataAllModulos = [];

       
        $user = $this->session->get("user");

        $this->view(
            'admin/roles',
            [
                "sTitulo"               => "Mantemiento de roles",
                "user"                  => $user,
                "bShowMenu"             => true,
                "aryDataAllModulos"     => $this->fncGetModulosAndSubmodulos($this->fncGetVarConfig("nIdRolAdmin")),
                "nAdmin"                => $this->fncIsAdmin($user["nIdRol"], $this->sUrlRoles) ? 1 : 0,

            ]
        );
    }

    public function fncGetModulosAndSubmodulos($nIdRol)
    {
        try {
            $aryData     = [];
            $nIdRolAdmin =  $this->fncGetVarConfig("nIdRolAdmin");

            switch ($nIdRol) {
                case $nIdRolAdmin:
                    // El puede ver todo
                    $aryDataModulos = $this->roles->fncGetModulos();


                    if (fncValidateArray($aryDataModulos)) {
                        foreach ($aryDataModulos as $aryLoop) {
                            // Le damos el acceso de administrador en todos los submodulos

                            $aryDataSubModulo   = $this->roles->fncGetSubmodulo($aryLoop["nIdModulo"], ", 1 AS nRolSubModulo  ");

                            if (fncValidateArray($aryDataSubModulo)) {
                                
                                $aryData[] = [
                                    "nIdModulo"     => $aryLoop["nIdModulo"],
                                    "sModulo"       => $aryLoop["sNombreModulo"],
                                    "sIconoModulo"  => $aryLoop["sIconoModulo"],
                                    "arySubModulos" => $aryDataSubModulo
                                ];

                            }
                        }
                    }


                    break;

                default:
                    $aryDataRolesModulos = $this->roles->fncGetRolModulo($nIdRol);
                    if (fncValidateArray($aryDataRolesModulos)) {
                        foreach ($aryDataRolesModulos as $aryDataRolModulo) {
                            $aryDataModulo    = $this->roles->fncGetModulo($aryDataRolModulo["nIdModulo"])[0];
                            if (fncValidateArray($aryDataModulo)) {
                                $aryData[] = [
                                    "nIdModulo"     => $aryDataModulo["nIdModulo"],
                                    "sModulo"       => $aryDataModulo["sNombreModulo"],
                                    "sIconoModulo"  => $aryDataModulo["sIconoModulo"],
                                    "arySubModulos" => $this->roles->fncGetRolesSubModulos($aryDataRolModulo["nIdRolModulo"])
                                ];
                            }
                        }
                    }

                    break;
            }




            return $aryData;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulate()
    {
        try {
            $user         = $this->session->get("user");
            $aryResultado = $this->roles->fncGetRoles($user["nIdEmpresa"]);

            $aryRows    = [];
            $bIsAdmin   = $this->fncIsAdmin($user["nIdRol"], $this->sUrlRoles);

            if (fncValidateArray($aryResultado)) {
                foreach ($aryResultado as $aryLoop) {
                    $sActionShow      = "fncMostrarRegistro(" . $aryLoop['nIdRol'] . ", 'ver' );";
                    $sActionEdit      = "fncMostrarRegistro(" . $aryLoop['nIdRol'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarRegistro(" . $aryLoop['nIdRol'] . ");";

                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryDataRolModulo = $this->roles->fncGetRolModulo($aryLoop['nIdRol']);
                    $sModulos         = fncValidateArray($aryDataRolModulo) ? implode(" , ", array_column($aryDataRolModulo, "sNombreModulo")) : "";

                    $aryRows[] = array(
                        'sAcciones'    => $sAcciones,
                        'nIdRol'       => $aryLoop['nIdRol'],
                        'sNombreRol'   => $aryLoop['sNombreRol'],
                        'sModulos'     => $sModulos
                    );
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncGrabarRol()
    {
        try {
            $nIdRegistro    = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
            $sNombreRol     = isset($_POST['sNombreRol']) ? $_POST['sNombreRol'] : null;
            $aryDataRol     = isset($_POST['aryDataRol']) ? $_POST['aryDataRol'] : null;
            $sDetalleRol    = isset($_POST['sDetalleRol']) ? $_POST['sDetalleRol'] : null;

            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($sNombreRol) || is_null($aryDataRol)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user) || !isset($user["nIdEmpresa"])) {
                $this->exception('Error. No se encontro un usuario para realizar la operacion . Por favor verifique o solicite asistencia.');
            }

            // Crear
            if ($nIdRegistro == 0) {
                $nIdRol = $this->roles->fncGrabarRol($sNombreRol, $user["nIdEmpresa"], $sDetalleRol);

                if (fncValidateArray($aryDataRol)) {
                    foreach ($aryDataRol as $aryLoop) {
                        $nIdRolModulo = $this->roles->fncGrabarRolModulo($nIdRol, $aryLoop["nIdModulo"]);

                        if (fncValidateArray($aryLoop["arySubModulos"])) {
                            foreach ($aryLoop["arySubModulos"] as $arySubModulo) {
                                $this->roles->fncGrabarRolSubModulo(
                                    $nIdRolModulo,
                                    $arySubModulo["nIdSubModulo"],
                                    $arySubModulo["nDefault"],
                                    $arySubModulo["nRolSubModulo"]
                                );
                            }
                        }
                    }
                }
            } else {
                //Actualizar
                $this->roles->fncActualizarRol($nIdRegistro, $sNombreRol, $user["nIdEmpresa"], $sDetalleRol);

                $this->roles->fncEliminarRolesModulosByIdRol($nIdRegistro);

                if (fncValidateArray($aryDataRol)) {
                    foreach ($aryDataRol as $aryLoop) {
                        $nIdRolModulo = $this->roles->fncGrabarRolModulo($nIdRegistro, $aryLoop["nIdModulo"]);

                        if (fncValidateArray($aryLoop["arySubModulos"])) {
                            foreach ($aryLoop["arySubModulos"] as $arySubModulo) {
                                $this->roles->fncGrabarRolSubModulo(
                                    $nIdRolModulo,
                                    $arySubModulo["nIdSubModulo"],
                                    $arySubModulo["nDefault"],
                                   isset($arySubModulo["nRolSubModulo"])? $arySubModulo["nRolSubModulo"] : 0 
                                );
                            }
                        }
                    }
                }
            }

            $sSuccess =  $nIdRegistro == 0 ? 'Rol registrado exitosamente...' : 'Rol actualizado exitosamente...';
            $this->json(array("success" => $sSuccess));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarRol()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = [
                "aryDataRol" => $this->roles->fncObtenerRolById($nIdRegistro)[0],
                "aryModulos" => $this->fncGetModulosAndSubmodulos($nIdRegistro)
            ];

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarRol()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {
            // Valida valores del formulario
            if ($nIdRegistro == null) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $this->roles->fncEliminarRol($nIdRegistro);

            $this->json(array("success" => 'Rol eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncGetRoles()
    {
        // Recibe valores del formulario

        try {
            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }


            $aryData = $this->roles->fncGetRoles($user["nIdEmpresa"]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
