<?php

namespace Application\Controllers;

use Exception;
use Application\Libs\Upload;
use Application\Libs\Session;
use Application\Core\Controller as Controller;
use Application\Models\CartaDigital;
use Application\Models\CatalogoTabla;
use Application\Models\Categorias;
use Application\Models\Mesas;

class CartaDigitalController extends Controller
{
    //model principal
    public $cartaDigital; // Es mi modelo
    public $session;
    public $categorias;
    public $catalogoTabla;
    public $mesas;

    public function __construct()
    {
        parent::__construct();
        $this->session          = new Session();
        $this->cartaDigital     = new CartaDigital();
        $this->categorias       = new Categorias();
        $this->catalogoTabla    = new CatalogoTabla();
        $this->mesas            = new Mesas();
        $this->session->init();
    }


    public function configuracionCarta()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/configuracion-carta', [
                'sTitulo'          => 'Mantenimientos de cartas digitales',
                'user'             => $this->session->get('user'),
                'bShowMenu'        => true,
                'aryCategorias'    => (new CategoriasController())->fncProcesarArbolCategorias($user["nIdSede"]),
                'aryExtras'        => $this->cartaDigital->fncObtenerExtra(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]),
                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function cartaDigital()
    {

        $nIdCartaDigital = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
        $nIdMesa         = isset($_REQUEST["idmesa"]) ? $_REQUEST["idmesa"] : 0;


        try {


            if (is_null($nIdCartaDigital)) {
                $this->exception("Error. No se ha ingresado el Id de la carta digital. Porfavor verifique");
            }

            $aryData = $this->cartaDigital->fncObtenerCartaDigital(["nIdCartaDigital" => $nIdCartaDigital,  "nEstado" => 1]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];

            $aryDetalle = [];
            $aryDetalleDB = $this->cartaDigital->fncObtenerCartaDigitalSeccion(["nIdCartaDigital" => $nIdCartaDigital, "nEstado" => 1]);

            $aryMesa = null;
            if ($nIdMesa > 0) {
                $aryMesa = $this->mesas->fncObtenerRegistros(["nIdMesa" => $nIdMesa]);
                if (!fncValidateArray($aryMesa)) {
                    $this->exception('Error. No se pudo ubicar la mesa quizas este anulado o se haya eliminado. Por favor verifique.');
                }
                $aryMesa = $aryMesa[0];
            }

            foreach ($aryDetalleDB as $key => $aryLoopD) {

                # Obtener subdetalle 
                $arySubDetalleDB = $this->cartaDigital->fncObtenerCDSP(["nIdCartaDigitalSeccion" => $aryLoopD["nIdCartaDigitalSeccion"], "nEstado" => 1]);
                $arySubDetalle   = [];
                foreach ($arySubDetalleDB as $key => $aryLoopSD) {

                    $aryExtras = [];
                    if (strlen($aryLoopSD["sIdsExtra"]) > 0) {
                        $aryExtras = $this->cartaDigital->fncObtenerExtra(["sIdsExtra" => $aryLoopSD["sIdsExtra"], "nEstado" => 1]);
                    }

                    $arySubDetalle[] = [
                        "nIdCDProductos"   => $aryLoopSD["nIdCDProductos"],
                        "nIdCategoria"     => $aryLoopSD["nIdCategoria"],
                        "nIdProducto"      => $aryLoopSD["nIdProducto"],
                        "sCategoria"       => $aryLoopSD["sCategoria"],
                        "sProducto"        => $aryLoopSD["sProducto"],
                        "nEstado"          => $aryLoopSD["nEstado"],
                        "nOrden"           => $aryLoopSD["nOrden"],
                        "sDetalleProducto" => $aryLoopSD["sDetalleProducto"],
                        "nPrecioProducto"  => $aryLoopSD["nPrecioProducto"],
                        "sImagenProducto"  => $aryLoopSD["sImagenProducto"],
                        "sEstado"          => $aryLoopSD["nEstado"] == 1 ? "ACTIVO" : "INACTIVO",
                        "sExtra"           => $aryLoopSD["sExtra"],
                        "aryExtras"        => $aryExtras
                    ];
                }

                $aryDetalle[] = [
                    "nIdCartaDigitalSeccion"         => $aryLoopD["nIdCartaDigitalSeccion"],
                    "sNombre"                        => $aryLoopD["sNombre"],
                    "nEstado"                        => $aryLoopD["nEstado"],
                    "nOrden"                         => $aryLoopD["nOrden"],
                    "nCantidadItems"                 => count($arySubDetalle),
                    "aryDetalle"                     => $arySubDetalle,
                    "sEstado"                        => $aryLoopD["nEstado"] == 1 ? "ACTIVO" : "INACTIVO",
                ];
            }
            $this->view('admin/carta-digital', [
                'sTitulo'            => $aryHeader["sNombre"],
                'nIdCartaDigital'    => $nIdCartaDigital,
                'nIdMesa'            => $nIdMesa,
                "aryHeader"          => $aryHeader,
                "aryDetalle"         => $aryDetalle,
                "nIdEstadoPendiente" => $this->fncGetVarConfig("nIdEstadoPendienteCD"),
                "aryMesa"            => $aryMesa,
                "bIsMovil"           => fncEsMovil()
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function cartaDigitalPedidos()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/carta-digital-pedidos', [
                'sTitulo'               => 'Pedidos',
                'user'                  => $this->session->get('user'),
                'bShowMenu'             => true,
                "nAdmin"                => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
                "nIdEstadoPendiente"    => $this->fncGetVarConfig("nIdEstadoPendienteCD"),
                'aryMesas'              => $this->mesas->fncObtenerRegistros(["nEstado" => 1]),
                'aryIdEstado'           => $this->catalogoTabla->fncListado("ESTADO_PEDIDO_CD"),
                'aryCartaDigital'       => $this->cartaDigital->fncObtenerCartaDigital(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]])
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function extras()
    {
        try {
            $this->authAdmin($this->session);

            $user = $this->session->get('user');

            $this->view('admin/extras', [
                'sTitulo'          => 'Mantenimientos de Extras',
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
            $aryData      = $this->cartaDigital->fncObtenerCartaDigital(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);
            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {


                    $sURL = route("carta-digital?id=" . $aryLoop["nIdCartaDigital"]);

                    # Para el color del fondo se va a tomar el color de fondo del boton y de color de texto del boton
                    $sActionQR      = "fncMostrarQR('" . $sURL . "','" . $aryLoop["sColor3"] . "','" . $aryLoop["sColor4"] . "');";

                    $sActionEdit      = "fncMostrarRegistro(" . $aryLoop['nIdCartaDigital'] . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarRegistro(" . $aryLoop['nIdCartaDigital'] . ");";

                    $sLinkQR   = '<a onclick="' . $sActionQR . '" href="javascript:;"   title="Ver QR" class="text-primary"><i class="material-icons">link</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkQR . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"         => $sAcciones,
                        "sNombre"           => $aryLoop["sNombre"],
                        "sEstado"           => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncGrabarRegistro()
    {
        $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $sNombre            = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
        $sComentario        = isset($_POST['sComentario']) ? $_POST['sComentario'] : null;
        $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
        $aryDetalle         = isset($_POST['aryDetalle']) ? json_decode($_POST['aryDetalle'], true) : null;

        $sImagen            = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;

        $sColor1            = isset($_POST['sColor1']) ? $_POST['sColor1'] : null;
        $sColor2            = isset($_POST['sColor2']) ? $_POST['sColor2'] : null;
        $sColor3            = isset($_POST['sColor3']) ? $_POST['sColor3'] : null;
        $sColor4            = isset($_POST['sColor4']) ? $_POST['sColor4'] : null;
        $sColor5            = isset($_POST['sColor5']) ? $_POST['sColor5'] : null;
        $sColor6            = isset($_POST['sColor6']) ? $_POST['sColor6'] : null;
        $sColor7            = isset($_POST['sColor7']) ? $_POST['sColor7'] : null;
        $sColor8            = isset($_POST['sColor8']) ? $_POST['sColor8'] : null;
        $sColor9            = isset($_POST['sColor9']) ? $_POST['sColor9'] : null;
        $sColor10           = isset($_POST['sColor10']) ? $_POST['sColor10'] : null;
        $sColor11           = isset($_POST['sColor11']) ? $_POST['sColor11'] : null;
        $sColor12           = isset($_POST['sColor12']) ? $_POST['sColor12'] : null;
        $sColor13           = isset($_POST['sColor13']) ? $_POST['sColor13'] : null;
        $sImagenHeader      = isset($_FILES['sImagenHeader']) ? $_FILES['sImagenHeader'] : null;


        try {

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

            if (isset($sImagenHeader) && !is_null($sImagenHeader)) {
                $sImagenHeader = Upload::process($sImagenHeader, 'multi');
            }


            $nIdNewRegistro = null;
            $sURL = slug($sNombre);
            // Crear
            if ($nIdRegistro == 0) {
                $nIdNewRegistro = $this->cartaDigital->fncGrabarCartaDigital(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sComentario,
                    $sURL,
                    $nEstado,
                    $sImagen,
                    $sColor1,
                    $sColor2,
                    $sColor3,
                    $sColor4,
                    $sColor5,
                    $sColor6,
                    $sColor7,
                    $sColor8,
                    $sColor9,
                    $sColor10,
                    $sColor11,
                    $sColor12,
                    $sColor13,
                    $sImagenHeader
                );
            } else {
                //Actualizar
                $this->cartaDigital->fncActualizarDigital(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $sNombre,
                    $sComentario,
                    $sURL,
                    $nEstado,
                    $sImagen,
                    $sColor1,
                    $sColor2,
                    $sColor3,
                    $sColor4,
                    $sColor5,
                    $sColor6,
                    $sColor7,
                    $sColor8,
                    $sColor9,
                    $sColor10,
                    $sColor11,
                    $sColor12,
                    $sColor13,
                    $sImagenHeader
                );
            }


            # Construye el array de IDS para obtener los registros que se han eliminado en la vista
            # luego elimina los hijos del detalle
            # Luego Elimina el detalle
            if ($nIdRegistro != 0) {
                $aryIds = [];
                foreach ($aryDetalle as $aryLoop) {
                    if ($aryLoop["nIdCartaDigitalSeccion"] != 0) {
                        array_push($aryIds, $aryLoop["nIdCartaDigitalSeccion"]);
                    }
                }

                $sIdLIst = implode(",", $aryIds);

                # Eliminar los registros del detalle
                $this->cartaDigital->fncEliminarItemsDetalle($nIdRegistro, $sIdLIst);
            }

            # Id Registro Current
            $nIdRegistroCurrent = $nIdRegistro == 0 ? $nIdNewRegistro : $nIdRegistro;

            foreach ($aryDetalle as $nKey => $aryLoop) {
                # Insertar detalle
                $sImagen = null;
                $nIdCartaDigitalSeccionNew = null;
                if ($aryLoop["nIdCartaDigitalSeccion"] == 0) {

                    # Obtener el ultimo registro de la tabla detalle
                    $nIdCartaDigitalSeccionNew = $this->cartaDigital->fncGrabarCartaDigitalSeccion(
                        $nIdRegistroCurrent,
                        $aryLoop["sNombre"],
                        isset($aryLoop["sIcono"]) ? $aryLoop["sIcono"] : null,
                        $sImagen,
                        slug($aryLoop["sNombre"]),
                        $aryLoop["nEstado"],
                        $aryLoop["nOrden"]
                    );
                } else {
                    # Actualizar detalle
                    $this->cartaDigital->fncActualizarCartaDigitalSeccion(
                        $aryLoop["nIdCartaDigitalSeccion"],
                        $nIdRegistroCurrent,
                        $aryLoop["sNombre"],
                        isset($aryLoop["sIcono"]) ? $aryLoop["sIcono"] : null,
                        $sImagen,
                        slug($aryLoop["sNombre"]),
                        $aryLoop["nEstado"],
                        $aryLoop["nOrden"]
                    );
                }

                $arySubDetalle = json_decode($aryLoop["aryDetalle"], true);
                $nIdCartaDigitalSeccionCurrent = $aryLoop["nIdCartaDigitalSeccion"] == 0 ? $nIdCartaDigitalSeccionNew : $aryLoop["nIdCartaDigitalSeccion"];

                # Eliminar el subdetalle que ya no se encuetnra en la vista 
                if ($aryLoop["nIdCartaDigitalSeccion"] != 0 && isset($arySubDetalle)) {

                    $aryIds = [];
                    foreach ($arySubDetalle as $aryLoopSD) {
                        if ($aryLoopSD["nIdCDProductos"] != 0) {
                            array_push($aryIds, $aryLoopSD["nIdCDProductos"]);
                        }
                    }

                    $sIdLIst = implode(",", $aryIds);

                    # Eliminar los registros del subdetalle
                    $this->cartaDigital->fncEliminarItemsSubDetalle($aryLoop["nIdCartaDigitalSeccion"], $sIdLIst);
                }


                # Insertar o actualizar subDetalle
                if (isset($arySubDetalle) && is_array($arySubDetalle) && count($arySubDetalle) > 0) {
                    foreach ($arySubDetalle as $nKeySD => $aryLoopSD) {

                        # Insertar subdetalle
                        if ($aryLoopSD["nIdCDProductos"] == 0) {
                            $this->cartaDigital->fncGrabarCDSP(
                                $nIdCartaDigitalSeccionCurrent,
                                $aryLoopSD["nIdCategoria"],
                                $aryLoopSD["nIdProducto"],
                                $aryLoopSD["nEstado"],
                                $aryLoopSD["sIdsExtra"],
                                $aryLoopSD["nOrden"]
                            );
                        } else {
                            # Actualizar subdetalle
                            $this->cartaDigital->fncActualizarCDSP(
                                $aryLoopSD["nIdCDProductos"],
                                $nIdCartaDigitalSeccionCurrent,
                                $aryLoopSD["nIdCategoria"],
                                $aryLoopSD["nIdProducto"],
                                $aryLoopSD["nEstado"],
                                $aryLoopSD["sIdsExtra"],
                                $aryLoopSD["nOrden"]
                            );
                        }
                    }
                }
            }

            $sSuccess = $nIdRegistro == 0 ? 'Carta Digital registrada exitosamente...' : 'Carta Digital actualizada exitosamente...';
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

            $aryData = $this->cartaDigital->fncObtenerCartaDigital(["nIdCartaDigital" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];

            $aryDetalle = [];
            $aryDetalleDB = $this->cartaDigital->fncObtenerCartaDigitalSeccion(["nIdCartaDigital" => $nIdRegistro]);

            $nIdRowD = 0;
            foreach ($aryDetalleDB as $key => $aryLoopD) {
                $nIdRowD++;

                # Obtener subdetalle 
                $arySubDetalleDB = $this->cartaDigital->fncObtenerCDSP(["nIdCartaDigitalSeccion" => $aryLoopD["nIdCartaDigitalSeccion"]]);
                $arySubDetalle   = [];
                $nIdRowSD        = 0;
                foreach ($arySubDetalleDB as $key => $aryLoopSD) {

                    $nIdRowSD++;
                    $sActionEdit      = "fncEditarSD(" . $nIdRowSD . ", 'editar' );";
                    $sActionEliminar  = "fncEliminarSD(" . $nIdRowSD . ");";

                    $sLinkEdit   = '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>';
                    $sLinkDelete = '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i></a>';

                    $sAcciones = '<div class="content-acciones">
                                ' . $sLinkEdit . '
                                ' . $sLinkDelete . '
                            </div>';

                    $aryExtras = [];
                    if (strlen($aryLoopSD["sIdsExtra"]) > 0) {
                        $aryExtras = $this->cartaDigital->fncObtenerExtra(["sIdsExtra" => $aryLoopSD["sIdsExtra"], "nEstado" => 1]);
                    }

                    $arySubDetalle[] = [
                        "nIdRow"          => $nIdRowSD,
                        "sAcciones"       => $sAcciones,
                        "nIdCDProductos"  => $aryLoopSD["nIdCDProductos"],
                        "nIdCategoria"    => $aryLoopSD["nIdCategoria"],
                        "nIdProducto"     => $aryLoopSD["nIdProducto"],
                        "sCategoria"      => $aryLoopSD["sCategoria"],
                        "sProducto"       => $aryLoopSD["sProducto"],
                        "nEstado"         => $aryLoopSD["nEstado"],
                        "nOrden"          => $aryLoopSD["nOrden"],
                        "sIdsExtra"       => $aryLoopSD["sIdsExtra"],
                        "sExtra"          => $aryLoopSD["sExtra"],
                        "sEstado"         => $aryLoopSD["nEstado"] == 1 ? "ACTIVO" : "INACTIVO",
                        "nPrecioProducto" => $aryLoopSD["nPrecioProducto"],
                        "aryExtras"       => $aryExtras
                    ];
                }


                $sActionEdit      = "fncEditarDetalle(" . $nIdRowD . ", 'editar' );";
                $sActionEliminar  = "fncEliminarDetalle(" . $nIdRowD . ");";

                $sLinkEdit   = '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>';
                $sLinkDelete = '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i></a>';

                $sAcciones = '<div class="content-acciones">
                                ' . $sLinkEdit . '
                                ' . $sLinkDelete . '
                            </div>';

                $aryDetalle[] = [
                    "sAcciones"                      => $sAcciones,
                    "nIdRow"                         => $nIdRowD,
                    "nIdCartaDigitalSeccion"         => $aryLoopD["nIdCartaDigitalSeccion"],
                    "sNombre"                        => $aryLoopD["sNombre"],
                    "nEstado"                        => $aryLoopD["nEstado"],
                    "nOrden"                         => $aryLoopD["nOrden"],
                    "nCantidadItems"                 => count($arySubDetalle),
                    "aryDetalle"                     => json_encode($arySubDetalle),
                    "sEstado"                        => $aryLoopD["nEstado"] == 1 ? "ACTIVO" : "INACTIVO",
                ];
            }

            $this->json(array("success" => true, "aryData" => $aryHeader, "aryDetalle" => $aryDetalle));
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


            $this->cartaDigital->fncEliminarCartaDigital($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    # Pedidos
    public function fncGrabarPedido()
    {
        $nIdRegistro         = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $nIdEmpresa          = isset($_POST['nIdEmpresa']) ? $_POST['nIdEmpresa'] : null;
        $nIdSede             = isset($_POST['nIdSede']) ? $_POST['nIdSede'] : null;
        $sCliente            = isset($_POST['sCliente']) ? $_POST['sCliente'] : null;
        $sObservacion        = isset($_POST['sObservacion']) ? $_POST['sObservacion'] : null;
        $nIdEstado           = isset($_POST['nIdEstado']) ? $_POST['nIdEstado'] : null;
        $nIdCartaDigital     = isset($_POST['nIdCartaDigital']) ? $_POST['nIdCartaDigital'] : null;
        $nIdMesa             = isset($_POST['nIdMesa']) ? $_POST['nIdMesa'] : null;
        $nTotal              = isset($_POST['nTotal']) ? $_POST['nTotal'] : null;
        $nEstado             = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
        $aryDetalle          = isset($_POST['aryDetalle']) ? json_decode($_POST['aryDetalle'], true) : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nIdEmpresa) || is_null($nIdSede)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $nIdMesa = $nIdMesa == 0 ? null : $nIdMesa;

            $nIdNewRegistro = null;
            // Crear
            if ($nIdRegistro == 0) {
                $nIdNewRegistro = $this->cartaDigital->fncGrabarCartaDigitalPedido(
                    $nIdEmpresa,
                    $nIdSede,
                    $sCliente,
                    $sObservacion,
                    $nIdEstado,
                    $nIdMesa,
                    $nTotal,
                    $nEstado,
                    $nIdCartaDigital
                );
            } else {
                //Actualizar
                $this->cartaDigital->fncActualizarDigitalPedido(
                    $nIdRegistro,
                    $sCliente,
                    $sObservacion,
                    $nIdEstado,
                    $nIdMesa,
                    $nTotal,
                    $nEstado,
                    $nIdCartaDigital
                );
            }


            # Construye el array de IDS para obtener los registros que se han eliminado en la vista
            # luego elimina los hijos del detalle
            # Luego Elimina el detalle
            if ($nIdRegistro != 0) {
                $aryIds = [];
                foreach ($aryDetalle as $aryLoop) {
                    if ($aryLoop["nIdDetalle"] != 0) {
                        array_push($aryIds, $aryLoop["nIdDetalle"]);
                    }
                }

                $sIdLIst = implode(",", $aryIds);

                # Eliminar los registros del detalle
                $this->cartaDigital->fncEliminarItemsPedidoDetalle($nIdRegistro, $sIdLIst);
            }

            # Id Registro Current
            $nIdRegistroCurrent = $nIdRegistro == 0 ? $nIdNewRegistro : $nIdRegistro;

            foreach ($aryDetalle as $nKey => $aryLoop) {
                # Insertar detalle
                if ($aryLoop["nIdDetalle"] == 0) {

                    $aryLoop["aryExtras"]       = !isset($aryLoop["aryExtras"]) || empty($aryLoop["aryExtras"]) ||  $aryLoop["aryExtras"] == "[]" ? null :  $aryLoop["aryExtras"];
                    $aryLoop["aryValuesExtras"] = !isset($aryLoop["aryValuesExtras"]) || empty($aryLoop["aryValuesExtras"]) ||  $aryLoop["aryValuesExtras"] == "[]" ? null :  $aryLoop["aryValuesExtras"];

                    # Obtener el ultimo registro de la tabla detalle
                    $this->cartaDigital->fncGrabarPedidoDetalle(
                        $nIdRegistroCurrent,
                        $aryLoop["nIdProducto"],
                        $aryLoop["nPrecio"],
                        $aryLoop["nCantidad"],
                        $aryLoop["nTotal"],
                        $aryLoop["sObservacion"],
                        $aryLoop["aryExtras"],
                        $aryLoop["aryValuesExtras"] // Es un array convertido a JSON
                    );
                } else {
                    # Actualizar detalle
                    $this->cartaDigital->fncActualizarPedidoDetalle(
                        $aryLoop["nIdDetalle"],
                        $nIdRegistroCurrent,
                        $aryLoop["nIdProducto"],
                        $aryLoop["nPrecio"],
                        $aryLoop["nCantidad"],
                        $aryLoop["nTotal"],
                        $aryLoop["sObservacion"],
                        $aryLoop["aryExtras"],
                        $aryLoop["aryValuesExtras"]
                    );
                }
            }

            $sSuccess = $nIdRegistro == 0 ? 'Pedido registrado exitosamente...' : 'Pedido actualizado exitosamente...';
            $this->json(array("success" => $sSuccess, "nIdNewRegistro" => $nIdNewRegistro, "sIdNewRegistro" => $nIdNewRegistro == null ? "" : sp($nIdNewRegistro)));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarPedido()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->cartaDigital->fncObtenerPedidos(["nIdPedidoCD" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];

            $aryDetalle = [];
            $aryDetalleDB = $this->cartaDigital->fncObtenerPedidoDetalle(["nIdPedidoCD" => $nIdRegistro]);

            $nIdRowD = 0;
            foreach ($aryDetalleDB as $key => $aryLoopD) {
                $nIdRowD++;

                $sActionEdit      = "fncEditarDetalle(" . $nIdRowD . ", 'editar' );";
                $sActionEliminar  = "fncEliminarDetalle(" . $nIdRowD . ");";

                $sLinkEdit   = '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>';
                $sLinkDelete = '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i></a>';

                $sAcciones = '<div class="content-acciones">
                                ' . $sLinkEdit . '
                                ' . $sLinkDelete . '
                            </div>';

                             
                $aryDetalle[] = [
                    "sAcciones"                      => $sAcciones,
                    "nIdRow"                         => $nIdRowD,
                    "nIdDetalle"                     => $aryLoopD["nIdDetalle"],
                    "nIdPedidoCD"                    => $aryLoopD["nIdPedidoCD"],
                    "nIdProducto"                    => $aryLoopD["nIdProducto"],
                    "nPrecio"                        => $aryLoopD["nPrecio"],
                    "nCantidad"                      => $aryLoopD["nCantidad"],
                    "nTotal"                         => $aryLoopD["nTotal"],
                    "sObservacion"                   => $aryLoopD["sObservacion"],
                    "sProducto"                      => $aryLoopD["sProducto"],
                    "sImagenProducto"                => $aryLoopD["sImagenProducto"],
                    "aryExtras"                      => $aryLoopD["jsnConfigExtra"],
                    "aryValuesExtras"                => $aryLoopD["jsnValuesExtra"],

                ];
            }

            $this->json(array("success" => true, "aryData" => $aryHeader, "aryDetalle" => $aryDetalle));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarPedido()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $this->cartaDigital->fncEliminarCartaDigitalPedido($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulatePedido()
    {

        $sIdsEstado     = isset($_POST["sIdsEstado"]) ? $_POST["sIdsEstado"] : null;
        $dFechaInicio   = isset($_POST["dFechaInicio"]) ? $_POST["dFechaInicio"] : null;
        $dFechaFin      = isset($_POST["dFechaFin"]) ? $_POST["dFechaFin"] : null;
        $nVendido       = isset($_POST["nVendido"]) ? $_POST["nVendido"] : null;

        try {


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows = [];

            $aryData = $this->cartaDigital->fncObtenerPedidos([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nIdSede"       => $user["nIdSede"],
                "sIdsEstado"    => $sIdsEstado,
                "dFechaInicio"  => $dFechaInicio,
                "dFechaFin"     => $dFechaFin,
                "nVendido"      => $nVendido
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionEdit      =  $aryLoop["nVendido"] == 0  ? "fncMostrarRegistro(" . $aryLoop['nIdPedidoCD'] . ", 'editar' );" : "";
                    $sActionEliminar  =  $aryLoop["nVendido"] == 0  ? "fncEliminarRegistro(" . $aryLoop['nIdPedidoCD'] . ");" : "";

                    $sIconEdit =  $aryLoop["nVendido"] == 0 ? "edit" : "block";
                    $sIconDelete =  $aryLoop["nVendido"] == 0 ? "delete" : "block";

                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">' . $sIconEdit . '</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">' . $sIconDelete . '</i> </a>'  : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"          => $sAcciones,
                        "nIdPedidoCD"        => $aryLoop["nIdPedidoCD"],
                        "sIdPedidoCD"        => sp($aryLoop["nIdPedidoCD"]),
                        "sCliente"           => $aryLoop["sCliente"],
                        "sMesa"              => $aryLoop["sMesa"],
                        "sEstadoAprobacion"  => $aryLoop["sEstadoAprobacion"],
                        "nTotal"             => nf($aryLoop["nTotal"], true),
                        "dFechaCreacion"     => $aryLoop["dFechaCreacion"],
                        "sVenta"             => $aryLoop["nVendido"] == 1 ? "COMPLETADO" : "SIN VENDER",
                        "sEstado"            => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    # Carta digital Extra
    public function fncGrabarExtra()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $sNombre     = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;
        $nTipo       = isset($_POST['nTipo']) ? $_POST['nTipo'] : null;
        $sValores    = isset($_POST['sValores']) ? $_POST['sValores'] : null;
        $nEstado     = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($sNombre) || is_null($nTipo)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }
            $user = $this->session->get('user');

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }
            $nIdNewRegistro = null;
            // Crear
            if ($nIdRegistro == 0) {
                $nIdNewRegistro = $this->cartaDigital->fncGrabarExtra($user["nIdEmpresa"], $user["nIdSede"], $sNombre, $nTipo, $sValores, $nEstado);
            } else {
                //Actualizar
                $this->cartaDigital->fncActualizarExtra($nIdRegistro, $sNombre, $nTipo, $sValores, $nEstado);
            }

            $sSuccess = $nIdRegistro == 0 ? 'Extra registrado exitosamente...' : 'Extra actualizado exitosamente...';
            $this->json(array("success" => $sSuccess));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncMostrarExtra()
    {
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $aryData = $this->cartaDigital->fncObtenerExtra(["nIDCDExtra" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }

            $aryHeader = $aryData[0];
            $this->json(array("success" => true, "aryData" => $aryHeader));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncEliminarExtra()
    {
        // Recibe valores del formulario
        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro)) {
                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }

            $this->cartaDigital->fncEliminarExtra($nIdRegistro);
            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPopulateExtra()
    {

        try {

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario
            $aryRows = [];

            $aryData = $this->cartaDigital->fncObtenerExtra([
                "nIdEmpresa"    => $user["nIdEmpresa"],
                "nIdSede"       => $user["nIdSede"]
            ]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (is_array($aryData) && count($aryData) > 0) {
                foreach ($aryData as $aryLoop) {
                    $sActionEdit      =  "fncMostrarRegistro(" . $aryLoop['nIDCDExtra'] . ", 'editar' );";
                    $sActionEliminar  =  "fncEliminarRegistro(" . $aryLoop['nIDCDExtra'] . ");";

                    $sIconEdit = "edit";
                    $sIconDelete = "delete";

                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">' . $sIconEdit . '</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">' . $sIconDelete . '</i> </a>'  : '';

                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"  => $sAcciones,
                        "sNombre"    => $aryLoop["sNombre"],
                        "sTipo"      => $aryLoop["nTipo"] == '1' ? 'UNICA' : 'MULTIPLE',
                        "sValores"   => $aryLoop["sValores"],
                        "sEstado"    => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
