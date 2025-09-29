<?php



namespace Application\Controllers;



use Exception;

use Application\Libs\Session;

use Application\Core\Controller as Controller;

use Application\Models\Cajas;

use Application\Models\Empleados;

use Application\Models\OrdenCompra;

use Application\Models\Pedidos;



class CajasController extends Controller

{

    //model principal

    public $users;

    public $cajas; // Es mi modelo

    public $session;

    public $empleados;

    public $pedidos;

    public $ordenCompra;



    public function __construct()

    {

        parent::__construct();

        $this->session          = new Session();

        $this->cajas            = new Cajas();

        $this->empleados        = new Empleados();

        $this->pedidos          = new Pedidos();

        $this->ordenCompra      = new OrdenCompra();

        $this->session->init();

    }



    public function index()

    {

        try {

            $this->authAdmin($this->session);



            $user = $this->session->get('user');



            $this->view('admin/cajas', [

                'sTitulo'          => 'Mantenimientos de cajas',

                'user'             => $this->session->get('user'),

                'bShowMenu'        => true,

                "aryEmpleados"     => $this->empleados->fncGetEmpleados(["nIdEmpresa" => $user["nIdEmpresa"] , "nCajaEmpleado" => 1]),

                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,

            ]);

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function cajaDiaria()

    {

        try {





            $this->authAdmin($this->session);



            $user        = $this->session->get('user');

            $nIdEmpleado = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"],  $this->fncGetVista())) ? null : $user["nIdEmpleado"];



            $this->view('admin/caja-diaria', [

                'sTitulo'          => 'Apertura de caja',

                'user'             => $this->session->get('user'),

                'bShowMenu'        => true,

                "aryCajas"         => $this->cajas->fncGetCajas(["nIdEmpresa" => $user["nIdEmpresa"] , "nIdSede" => $user["nIdSede"]]),

                "aryEmpleados"     => $this->empleados->fncGetEmpleados(["nIdEmpresa" => $user["nIdEmpresa"],  "nDelivery" => 0 ,  "nIdEmpleado" => $nIdEmpleado ]),

                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,

            ]);

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function reporteVariasCajas()

    {

        try {

            $this->authAdmin($this->session);



            $user = $this->session->get('user');



            $this->view('admin/reporte-cajas-varias', [

                'sTitulo'          => 'Reporte varias cajas',

                'user'             => $this->session->get('user'),

                'bShowMenu'        => true,

                "aryCajas"         => $this->cajas->fncGetCajas(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]),

                "aryEmpleados"     => $this->empleados->fncGetEmpleados(["nIdEmpresa" => $user["nIdEmpresa"] ,"nDelivery" => 0 ]),

                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,

            ]);

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function reporteCajaIndividual()

    {

        try {

            $this->authAdmin($this->session);



            $user = $this->session->get('user');



            $this->view('admin/reporte-caja-diaria', [

                'sTitulo'          => 'Reporte caja indiviudal',

                'user'             => $this->session->get('user'),

                'bShowMenu'        => true,

                "aryCajas"         => $this->cajas->fncGetCajas(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]),

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

            $aryData      = $this->cajas->fncGetCajas(["nIdEmpresa" => $user["nIdEmpresa"], "nIdSede" => $user["nIdSede"]]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());



            if (is_array($aryData) && count($aryData) > 0) {

                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarCaja(" . $aryLoop['nIdCaja'] . ", 'ver' );";

                    $sActionEdit      = "fncMostrarCaja(" . $aryLoop['nIdCaja'] . ", 'editar' );";

                    $sActionEliminar  = "fncEliminarCaja(" . $aryLoop['nIdCaja'] . ");";





                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';

                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';

                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';





                    $sAcciones = '<div class="content-acciones">

                                    ' . $sLinkShow . '

                                    ' . $sLinkEdit . '

                                    ' . $sLinkDelete . '

                                </div>';



                    $aryRows[] = [

                        "sAcciones"      => $sAcciones,

                        "sDescripcion"   => $aryLoop["sDescripcion"],

                        "sDetalle"       => $aryLoop["sDetalle"],

                        "sEmpleado"      => $aryLoop["sEmpleado"],

                        "sEstado"        => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",

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

        try {

            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;

            $sDetalle           = isset($_POST['sDetalle']) ? $_POST['sDetalle'] : null;

            $nIdEmpleado        = isset($_POST['nIdEmpleado']) ? $_POST['nIdEmpleado'] : null;

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

                $nIdNewEegistro = $this->cajas->fncGrabarRegistro($user["nIdEmpresa"], $user["nIdSede"], $sDescripcion, $sDetalle, $nIdEmpleado, $nEstado);

            } else {

                //Actualizar

                $this->cajas->fncActualizarRegistro($nIdRegistro, $user["nIdEmpresa"], $user["nIdSede"], $sDescripcion, $sDetalle, $nIdEmpleado, $nEstado);

            }



            $sSuccess =  $nIdRegistro == 0 ? 'Caja registrado exitosamente...' : 'Caja actualizado exitosamente...';



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





            $aryData = $this->cajas->fncGetCajas(["nIdCaja" => $nIdRegistro]);



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





            $this->cajas->fncEliminarRegistro($nIdRegistro);

            $this->json(array("success" => 'Caja eliminado exitosamente.'));

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function fncGetCajas()

    {

        // Recibe valores del formulario



        try {

            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');

            }



            $aryData = $this->cajas->fncGetCajas([

                "nIdSede"    => $user["nIdSede"],

                "nEstado"    => 1

            ]);



            $this->json(array("success" => true, "aryData" => $aryData));

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }





    public function fncGrabarCajaDiaria()

    {

        try {

            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $nIdCaja            = isset($_POST['nIdCaja']) ? $_POST['nIdCaja'] : null;

            $nIdEmpleado        = isset($_POST['nIdEmpleado']) ? $_POST['nIdEmpleado'] : null;

            $nMontoApertura     = isset($_POST['nMontoApertura']) ? $_POST['nMontoApertura'] : null;

            $nMontoDeposito     = isset($_POST['nMontoDeposito']) ? $_POST['nMontoDeposito'] : null;

            $nMontoSalidas      = isset($_POST['nMontoSalidas']) ? $_POST['nMontoSalidas'] : null;

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



                // Validar si esque ya se aperturo la caja 

                $aryDataCajaDiaria =  $this->cajas->fncGetCajaDiaria(["dFechaHoraApertura" => date("d/m/Y"), "nIdCaja" => $nIdCaja]);



                if (fncValidateArray($aryDataCajaDiaria)) {

                    $this->exception('Error. Ya se aperturo la caja para el dia de hoy. Por favor verifique.');

                }



                $nIdNewEegistro = $this->cajas->fncGrabarCajaDiaria($nIdCaja, $nIdEmpleado, $nMontoApertura, $nMontoDeposito, $nMontoSalidas, $nEstado);

            } else {

                //Actualizar

                $this->cajas->fncActualizarCajaDiaria($nIdRegistro, $nIdEmpleado, $nMontoApertura, $nMontoDeposito, $nMontoSalidas);

            }



            $sSuccess =  $nIdRegistro == 0 ? 'Caja diaria registrado exitosamente...' : 'Caja actualizado exitosamente...';



            $this->json(array("success" => $sSuccess, "nIdNewEegistro" => $nIdNewEegistro));

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function fncMostrarCajaDiaria()

    {

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');

            }



            $aryData = $this->cajas->fncGetCajaDiaria(["nIdCajaDiaria" => $nIdRegistro]);



            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function fncCambiarEstadoCajaDiaria()

    {

        try {

            $nIdRegistro    = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $nEstado        = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;





            // Valida valores del formulario

            if (is_null($nIdRegistro)) {

                $this->exception('Error. Existen valores vacios. Por favor verifique.');

            }





            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');

            }



            $this->cajas->fncCerrarCajaDiaria($nIdRegistro, $nEstado);



            $sSuccess =  $nEstado == 1 ? 'Se aperturo la caja nuevamente ..' : 'Se cerro la caja exitosamente...';



            $this->json(array("success" => $sSuccess));

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function fncPopulateCajaDiaria()

    {

        $aryIdCajas     = isset($_POST['aryIdCajas']) ? $_POST['aryIdCajas'] : null;

        $dFechaInicio   = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;

        $dFechaFin      = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;



        try {

            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");

            }





            $nIdEmpleado = ($this->fncGetVarConfig("nIdRolAdmin") == $user["nIdRol"]) || ($this->fncIsAdmin($user["nIdRol"],  $this->fncGetVista())) ? null : $user["nIdEmpleado"];



            // Valida valores del formulario

            $aryRows  = [];

            $aryData  = $this->cajas->fncGetCajaDiaria([

                "nIdEmpresa"      => $user["nIdEmpresa"],

                "nIdSede"         => $user["nIdSede"],

                "aryIdCajas"      => $aryIdCajas,

                "dFechaInicio"    => $dFechaInicio,

                "dFechaFin"       => $dFechaFin,

                "nIdEmpleado"     => $nIdEmpleado

            ]);



            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            $nIdEstadoPagoPagado = $this->fncGetVarConfig("nIdEstadoPagoPagado");



            $nTipoPagoTarjeta           = $this->fncGetVarConfig("nTipoPagoTarjeta");

            $nTipoPagoTransferencia     = $this->fncGetVarConfig("nTipoPagoTransferencia");

            $nTipoPagoEfectivo          = $this->fncGetVarConfig("nTipoPagoEfectivo");

            $nTipoPagoYape              = $this->fncGetVarConfig("nTipoPagoYape");





            if (is_array($aryData) && count($aryData) > 0) {

                foreach ($aryData as $nKeyCajaDiaria => $aryLoop) {



                    $nNuevoEstado        = $aryLoop["nEstado"] == 1 ? 0 : 1;

                    $sTitleEstado        = $nNuevoEstado == 1 ? "Aperturar Caja" : "Cerrar Caja";

                    $sIcoEstado          = $nNuevoEstado == 1 ? "check" : "power_settings_new";



                    $sActionChangeState  = "fncCambiarEstadoCaja(" . $aryLoop['nIdCajaDiaria'] . ", " . $nNuevoEstado . ");";

                    $sActionShow         = "fncMostrarCajaDiaria(" . $aryLoop['nIdCajaDiaria'] . ", 'ver' );";

                    $sActionEdit         = "fncMostrarCajaDiaria(" . $aryLoop['nIdCajaDiaria'] . ", 'editar' );";

                    $sActionEliminar     = "fncEliminarCajaDiaria(" . $aryLoop['nIdCajaDiaria'] . ");";











                    $sLinkShow    = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';



                    $sLinkChange  = '<a onclick="' . $sActionChangeState . '" href="javascript:;" title="' . $sTitleEstado . '" class="text-primary"><i class="material-icons">' . $sIcoEstado . '</i> </a>' ;

                    $sLinkEdit    = $aryLoop["nEstado"]  == 1 ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>' : ''  ;

                    $sLinkDelete  =  '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>' ;







                    # Totales pedidos 

                    $nTotalPedidos = 0;

                    $aryPedidos    = $this->pedidos->fncObtenerPedidos(["nIdCaja" => $aryLoop["nIdCaja"], "dFechaRegistro" => $aryLoop["dFechaRegistro"]]);



                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si esta facturado y la condicion de pago es al contado

                            if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1) {

                                $nTotalPedidos += $aryLoopPedido["nTotal"];

                            } else {



                                # Si la condicion de pago es parcial o en cuotas 

                                # .. solo va a toamr las cuotas que estan pagadas y el adelanto

                                if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {



                                    $nTotalPedidoItem = 0;

                                    # Suma el adelanto

                                    $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];



                                    $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(

                                        [

                                            "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],

                                            "nEstadoPago"    => $nIdEstadoPagoPagado

                                        ]

                                    );



                                    # Suma las cuotas pagadas del pedido 

                                    if (fncValidateArray($aryDataPedidosCuotas)) {

                                        foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {

                                            $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];

                                        }

                                    }



                                    $nTotalPedidos += $nTotalPedidoItem;

                                }

                            }

                        }

                    }





                    # Total pago tarjeta

                    $aryPedidos           = $this->pedidos->fncObtenerPedidos(["nIdCaja" => $aryLoop["nIdCaja"], "dFechaRegistro" => $aryLoop["dFechaRegistro"]]);

                    $nTotalPedidosTarjeta = 0;



                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si esta facturado y la condicion de pago es al contado

                           # if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1  && $aryLoopPedido["nIdMetodoPago"] == $nTipoPagoYape) {
							if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1  && $aryLoopPedido["nIdMetodoPago"] == $nTipoPagoTarjeta) {

                                $nTotalPedidosTarjeta += $aryLoopPedido["nTotal"];

                            } else {



                                # Si la condicion de pago es parcial o en cuotas 

                                # .. solo va a toamr las cuotas que estan pagadas y el adelanto

                                if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {



                                    $nTotalPedidoItem = 0;

                                    # Suma el adelanto



                                    if ($aryLoopPedido["nIdMetodoPago"] == $nTipoPagoTarjeta) {

                                        $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];

                                    }



                                    $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(

                                        [

                                            "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],

                                            "nEstadoPago"    => $nIdEstadoPagoPagado,

                                            "nIdMetodoPago"  => $nTipoPagoTarjeta,

                                        ]

                                    );



                                    # Suma las cuotas pagadas del pedido 

                                    if (fncValidateArray($aryDataPedidosCuotas)) {

                                        foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {

                                            $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];

                                        }

                                    }



                                    $nTotalPedidosTarjeta += $nTotalPedidoItem;

                                }

                            }

                        }

                    }





                    # Total pago transferencia

                    $nTotalPedidosTransferencia = 0;



                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si esta facturado y la condicion de pago es al contado

                            if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1  && $aryLoopPedido["nIdMetodoPago"] == $nTipoPagoTransferencia) {

                                $nTotalPedidosTransferencia += $aryLoopPedido["nTotal"];

                            } else {



                                # Si la condicion de pago es parcial o en cuotas 

                                # .. solo va a toamr las cuotas que estan pagadas y el adelanto

                                if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {



                                    $nTotalPedidoItem = 0;

                                    # Suma el adelanto



                                    if ($aryLoopPedido["nIdMetodoPago"] == $nTipoPagoTransferencia) {

                                        $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];

                                    }



                                    $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(

                                        [

                                            "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],

                                            "nEstadoPago"    => $nIdEstadoPagoPagado,

                                            "nIdMetodoPago"  => $nTipoPagoTransferencia,

                                        ]

                                    );



                                    # Suma las cuotas pagadas del pedido 

                                    if (fncValidateArray($aryDataPedidosCuotas)) {

                                        foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {

                                            $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];

                                        }

                                    }



                                    $nTotalPedidosTransferencia += $nTotalPedidoItem;

                                }

                            }

                        }

                    }





                    # Total pago efectivo

                    $nTotalPedidosEfectivo = 0;



                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si esta facturado y la condicion de pago es al contado

                            if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1  && $aryLoopPedido["nIdMetodoPago"] == $nTipoPagoEfectivo) {

                                $nTotalPedidosEfectivo += $aryLoopPedido["nTotal"];

                            } else {



                                # Si la condicion de pago es parcial o en cuotas 

                                # .. solo va a toamr las cuotas que estan pagadas y el adelanto

                                if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {



                                    $nTotalPedidoItem = 0;

                                    # Suma el adelanto



                                    if ($aryLoopPedido["nIdMetodoPago"] == $nTipoPagoEfectivo) {

                                        $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];

                                    }



                                    $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(

                                        [

                                            "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],

                                            "nEstadoPago"    => $nIdEstadoPagoPagado,

                                            "nIdMetodoPago"  => $nTipoPagoEfectivo,

                                        ]

                                    );



                                    # Suma las cuotas pagadas del pedido 

                                    if (fncValidateArray($aryDataPedidosCuotas)) {

                                        foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {

                                            $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];

                                        }

                                    }



                                    $nTotalPedidosEfectivo += $nTotalPedidoItem;

                                }

                            }

                        }

                    }





                    # Total pago yape

                    $nTotalPedidosYape = 0;



                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si esta facturado y la condicion de pago es al contado

                            if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1  && $aryLoopPedido["nIdMetodoPago"] == $nTipoPagoYape) {

                                $nTotalPedidosYape += $aryLoopPedido["nTotal"];

                            } else {



                                # Si la condicion de pago es parcial o en cuotas 

                                # .. solo va a toamr las cuotas que estan pagadas y el adelanto

                                if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {



                                    $nTotalPedidoItem = 0;

                                    # Suma el adelanto

                                    if ($aryLoopPedido["nIdMetodoPago"] == $nTipoPagoYape) {

                                        $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];

                                    }

                                    $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(

                                        [

                                            "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],

                                            "nEstadoPago"    => $nIdEstadoPagoPagado,

                                            "nIdMetodoPago"  => $nTipoPagoYape,

                                        ]

                                    );



                                    # Suma las cuotas pagadas del pedido 

                                    if (fncValidateArray($aryDataPedidosCuotas)) {

                                        foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {

                                            $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];

                                        }

                                    }



                                    $nTotalPedidosYape += $nTotalPedidoItem;

                                }

                            }

                        }

                    }





                    # Total pago al contado

                    $aryPedidos           = $this->pedidos->fncObtenerPedidos(["nIdCaja" => $aryLoop["nIdCaja"], "nCondicionPago" => 1, "dFechaRegistro" => $aryLoop["dFechaRegistro"]]);

                    $nTotalPedidosContado = 0;



                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si esta facturado y la condicion de pago es al contado

                            if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1) {

                                $nTotalPedidosContado += $aryLoopPedido["nTotal"];

                            }

                        }

                    }



                    # Total pago parcial

                    $aryPedidos           = $this->pedidos->fncObtenerPedidos(["nIdCaja" => $aryLoop["nIdCaja"], "nCondicionPago" => 2, "dFechaRegistro" => $aryLoop["dFechaRegistro"]]);

                    $nTotalPedidosParcial = 0;



                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si la condicion de pago es parcial o en cuotas 

                            # .. solo va a toamr las cuotas que estan pagadas y el adelanto

                            if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {



                                $nTotalPedidoItem = 0;

                                # Suma el adelanto

                                $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];





                                $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(

                                    [

                                        "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],

                                        "nEstadoPago"    => $nIdEstadoPagoPagado,

                                    ]

                                );



                                # Suma las cuotas pagadas del pedido 

                                if (fncValidateArray($aryDataPedidosCuotas)) {

                                    foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {

                                        $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];

                                    }

                                }



                                $nTotalPedidosParcial += $nTotalPedidoItem;

                            }

                        }

                    }









                    # Totales orden de compra 

                    $nTotalOC = 0;

                    $aryOC    = $this->ordenCompra->fncObtenerOrdenCompra(["nIdCaja" => $aryLoop["nIdCaja"], "nProcesado" => 1, "nTipo" => 1, "dFechaCreacion" => $aryLoop["dFechaRegistro"]]);



                    if (fncValidateArray($aryOC)) {

                        foreach ($aryOC as $nKeyO => $aryLoopOC) {

                            $nTotalOC += $aryLoopOC["nTotal"];

                        }

                    }



                    # Total gastos 



                    $nTotalGastos = 0;

                    $aryOC       = $this->ordenCompra->fncObtenerOrdenCompra(["nIdCaja" => $aryLoop["nIdCaja"], "nEjecutado" => 1, "nTipo" => 2, "dFechaCreacion" => $aryLoop["dFechaRegistro"]]);



                    if (fncValidateArray($aryOC)) {

                        foreach ($aryOC as $nKeyG => $aryLoopG) {

                            $nTotalGastos += $aryLoopG["nTotal"];

                        }

                    }



                    # Suma de ordenes de compras mas gastos

                    $nTotalOCG =  $nTotalOC + $nTotalGastos;





                    $nSaldoCaja = ($aryLoop["nMontoApertura"] + $aryLoop["nMontoDeposito"] +  $nTotalPedidos) - ($nTotalOCG + $aryLoop["nMontoSalidas"]);





                    $sActionRC  = "fncReporteCaja(" . $nKeyCajaDiaria . ");";



                    $sLinkRC    = '<a onclick="' . $sActionRC . '" href="javascript:;" title="Reporte caja" class="text-primary"><i class="material-icons">timeline</i> </a>';





                    $sAcciones  = '<div class="content-acciones">

                                    ' . $sLinkRC . '

                                    ' . $sLinkChange . '

                                    ' . $sLinkShow . '

                                    ' . $sLinkEdit . '

                                    ' . $sLinkDelete . '

                                </div>';



                    $aryRows[] = [

                        "sAcciones"                     => $sAcciones,

                        "nRow"                          => $nKeyCajaDiaria,

                        "sCaja"                         => $aryLoop["sCaja"],

                        "sEmpleado"                     => $aryLoop["sEmpleado"],

                        "dFechaHoraApertura"            => $aryLoop["dFechaHoraApertura"],

                        "dFechaCierre"                  => $aryLoop["dFechaCierre"],



                        "nTotalPedidosTarjeta"          => nf($nTotalPedidosTarjeta, 2),

                        "nTotalPedidosTransferencia"    => nf($nTotalPedidosTransferencia, 2),

                        "nTotalPedidosEfectivo"         => nf($nTotalPedidosEfectivo, 2),

                        "nTotalPedidosYape"             => nf($nTotalPedidosYape, 2),



                        "nTotalPedidosContado"          => nf($nTotalPedidosContado, 2),

                        "nTotalPedidosParcial"          => nf($nTotalPedidosParcial, 2),



                        "nMontoApertura"                => nf($aryLoop["nMontoApertura"], 2),

                        "nMontoDeposito"                => nf($aryLoop["nMontoDeposito"], 2),

                        "nMontoSalidas"                 => nf($aryLoop["nMontoSalidas"], 2),

                        "nTotalPedidos"                 => nf($nTotalPedidos, 2),

                        "nTotalOCG"                     => nf($nTotalOCG, 2),

                        "nSaldoCaja"                    => nf($nSaldoCaja, 2),



                        "sEstado"                       => $aryLoop["nEstado"] == 1 ? "<div class='div-verde'>ABIERTO</div>" : "<div class='div-rojo'>CERRADO</div>",

                    ];

                }

            }



            $this->json($aryRows);

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function fncObtenerCajasDisponibles()

    {

        $dFechaHoraApertura = isset($_POST['dFechaHoraApertura']) ? $_POST['dFechaHoraApertura'] : null;

        $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;



        try {

            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");

            }



            // Valida valores del formulario

            $aryData = $this->cajas->fncGetCajaDiaria([

                "nIdEmpresa"         => $user["nIdEmpresa"],

                "nIdSede"            => $user["nIdSede"],

                'dFechaHoraApertura' => $dFechaHoraApertura,

                'nEstado'            => $nEstado

            ]);



            $this->json(array("success" => true, "aryData" => $aryData));

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }



    public function fncPopulateReporteCajaIndividual()

    {



        $nIdCaja          = isset($_POST['nIdCaja']) ? $_POST['nIdCaja'] : null;

        $dFechaInicio     = isset($_POST['dFechaInicio']) ? $_POST['dFechaInicio'] : null;

        $dFechaFin        = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;



        try {

            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");

            }



            // Valida valores del formulario

            $aryRows      = [];

            $aryData      = $this->cajas->fncGetCajaDiaria([

                "nIdEmpresa"    => $user["nIdEmpresa"],

                "nIdSede"       => $user["nIdSede"],

                "nIdCaja"       => $nIdCaja,

                "dFechaInicio"  => $dFechaInicio,

                "dFechaFin"     => $dFechaFin,

            ]);



            $bIsAdmin            = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            $nIdEstadoPagoPagado = $this->fncGetVarConfig("nIdEstadoPagoPagado");



            if (is_array($aryData) && count($aryData) > 0) {

                foreach ($aryData as $aryLoop) {





                    # Monto de saldo anterior

                    $nSaldoAnterior = 0;



                    if ($aryLoop["nIdCajaDiariaAnterior"] !== '0' && $aryLoop["nIdCajaDiariaAnterior"] !== '') {



                        $aryDataCA = $this->cajas->fncGetCajaDiaria(["nIdCajaDiaria" => $aryLoop["nIdCajaDiariaAnterior"]]);



                        if (fncValidateArray($aryDataCA)) {

                            $aryDataCA = $aryDataCA[0];



                            # Totales pedidos de la caja anterior

                            $nTotalPedidosCA = 0;

                            $aryPedidosCA    = $this->pedidos->fncObtenerPedidos(["nIdCaja" => $aryDataCA["nIdCaja"], "nFacturado" => 1, "dFechaRegistro" => $aryDataCA["dFechaRegistro"]]);



                            if (fncValidateArray($aryPedidosCA)) {

                                foreach ($aryPedidosCA as $nKeyPCA => $aryLoopPedidoCA) {

                                    $nTotalPedidosCA += $aryLoopPedidoCA["nTotal"];

                                }

                            }



                            # Totales orden de compra 

                            $nTotalOCCA = 0;

                            $aryOCCA    = $this->ordenCompra->fncObtenerOrdenCompra(["nIdCaja" => $aryDataCA["nIdCaja"], "nProcesado" => 1, "nTipo" => 1, "dFechaCreacion" => $aryDataCA["dFechaRegistro"]]);



                            if (fncValidateArray($aryOCCA)) {

                                foreach ($aryOCCA as $nKeyO => $aryLoopOCCA) {

                                    $nTotalOCCA += $aryLoopOCCA["nTotal"];

                                }

                            }



                            # Total gastos 

                            $nTotalGastosCA = 0;

                            $aryOCCA        = $this->ordenCompra->fncObtenerOrdenCompra(["nIdCaja" => $aryDataCA["nIdCaja"], "nEjecutado" => 1, "nTipo" => 2, "dFechaCreacion" => $aryDataCA["dFechaRegistro"]]);



                            if (fncValidateArray($aryOCCA)) {

                                foreach ($aryOCCA as $nKeyCA => $aryLoopG) {

                                    $nTotalGastosCA += $aryLoopG["nTotal"];

                                }

                            }



                            # Suma de ordenes de compras mas gastos

                            $nTotalOCGCA =  $nTotalOCCA + $nTotalGastosCA;





                            $nSaldoAnterior = ($aryDataCA["nMontoApertura"] + $aryDataCA["nMontoDeposito"] +  $nTotalPedidosCA) - ($nTotalOCGCA + $aryDataCA["nMontoSalidas"]);

                        }

                    }





                    $aryLoop["nMontoApertura"]  = $aryLoop["nMontoApertura"] + $nSaldoAnterior;





                    # Totales pedidos 

                    $nTotalPedidos = 0;

                    $aryPedidos    = $this->pedidos->fncObtenerPedidos(["nIdCaja" => $aryLoop["nIdCaja"], "dFechaRegistro" => $aryLoop["dFechaRegistro"]]);





                    if (fncValidateArray($aryPedidos)) {

                        foreach ($aryPedidos as $nKeyP => $aryLoopPedido) {



                            # Si esta facturado y la condicion de pago es al contado

                            if ($aryLoopPedido["nFacturado"]  == 1 && $aryLoopPedido["nCondicionPago"] == 1) {

                                $nTotalPedidos += $aryLoopPedido["nTotal"];

                            } else {



                                # Si la condicion de pago es parcial o en cuotas 

                                # .. solo va a toamr las cuotas que estan pagadas y el adelanto

                                if ($aryLoopPedido["nCondicionPago"] == 2 && $aryLoopPedido["nIdPedidoCuota"] !== '0') {



                                    $nTotalPedidoItem = 0;

                                    # Suma el adelanto

                                    $nTotalPedidoItem += $aryLoopPedido["nAdelanto"];



                                    $aryDataPedidosCuotas = $this->pedidos->fncObtenerPedidoCuotasDetalle(

                                        [

                                            "nIdPedidoCuota" => $aryLoopPedido["nIdPedidoCuota"],

                                            "nEstadoPago"    => $nIdEstadoPagoPagado

                                        ]

                                    );



                                    # Suma las cuotas pagadas del pedido 

                                    if (fncValidateArray($aryDataPedidosCuotas)) {

                                        foreach ($aryDataPedidosCuotas as $keyPC => $aryLoopPC) {

                                            $nTotalPedidoItem += $aryLoopPC["nMontoCuota"];

                                        }

                                    }



                                    $nTotalPedidos += $nTotalPedidoItem;

                                }

                            }

                        }

                    }





                    # Totales orden de compra 

                    $nTotalOC = 0;

                    $aryOC    = $this->ordenCompra->fncObtenerOrdenCompra(["nIdCaja" => $aryLoop["nIdCaja"], "nProcesado" => 1, "nTipo" => 1, "dFechaCreacion" => $aryLoop["dFechaRegistro"]]);



                    if (fncValidateArray($aryOC)) {

                        foreach ($aryOC as $nKeyO => $aryLoopOC) {

                            $nTotalOC += $aryLoopOC["nTotal"];

                        }

                    }



                    # Total gastos 



                    $nTotalGastos = 0;

                    $aryOC       = $this->ordenCompra->fncObtenerOrdenCompra(["nIdCaja" => $aryLoop["nIdCaja"], "nEjecutado" => 1, "nTipo" => 2, "dFechaCreacion" => $aryLoop["dFechaRegistro"]]);



                    if (fncValidateArray($aryOC)) {

                        foreach ($aryOC as $nKeyG => $aryLoopG) {

                            $nTotalGastos += $aryLoopG["nTotal"];

                        }

                    }



                    # Suma de ordenes de compras mas gastos

                    $nTotalOCG  = $nTotalOC + $nTotalGastos;



                    $nSaldoCaja = ($aryLoop["nMontoApertura"] + $aryLoop["nMontoDeposito"] +  $nTotalPedidos) - ($nTotalOCG + $aryLoop["nMontoSalidas"]);







                    $aryRows[] = [

                        "sCaja"                 => $aryLoop["sCaja"],

                        "sEmpleado"             => $aryLoop["sEmpleado"],

                        "dFechaHoraApertura"    => $aryLoop["dFechaHoraApertura"],

                        "dFechaCierre"          => $aryLoop["dFechaCierre"],

                        "nSaldoAnterior"        => $nSaldoAnterior,



                        "nMontoApertura"        => nf($aryLoop["nMontoApertura"], 2),

                        "nMontoDeposito"        => nf($aryLoop["nMontoDeposito"], 2),

                        "nMontoSalidas"         => nf($aryLoop["nMontoSalidas"], 2),

                        "nTotalPedidos"         => nf($nTotalPedidos, 2),

                        "nTotalOC"              => nf($nTotalOC, 2),

                        "nSaldoCaja"            => nf($nSaldoCaja, 2),

                        "sEstado"               => $aryLoop["nEstado"] == 1 ? "<div class='div-verde'>ABIERTO</div>" : "<div class='div-rojo'>CERRADO</div>",

                    ];

                }

            }



            $this->json($aryRows);

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }





    public function fncEliminarCajaDiaria()

    {

        // Recibe valores del formulario

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');

            }



            // Validar si esque ahi movimientos con esa caja 



            $aryCajaDiaria = $this->cajas->fncGetCajaDiaria(["nIdCajaDiaria" => $nIdRegistro]);

            if (fncValidateArray($aryCajaDiaria)) {



                $aryCajaDiaria  = $aryCajaDiaria[0];



                $aryPedidos     = $this->pedidos->fncObtenerPedidos(["nIdCaja" => $aryCajaDiaria["nIdCaja"], "dFechaRegistro" => $aryCajaDiaria["dFechaApertura"]]);

                $aryOC          = $this->ordenCompra->fncObtenerOrdenCompra(["nIdCaja" => $aryCajaDiaria["nIdCaja"], "dFechaCreacion" => $aryCajaDiaria["dFechaApertura"]]);



                if (fncValidateArray($aryPedidos) || fncValidateArray($aryOC)) {

                    $this->exception('Error. No se puede eliminar este registro porque tiene movimientos.. Por favor verifique.');

                }

            }







            $this->cajas->fncEliminarCajaDiaria($nIdRegistro);

            $this->json(array("success" => 'Caja diaria eliminada exitosamente.'));

        } catch (Exception $ex) {

            echo $ex->getMessage();

        }

    }

}

