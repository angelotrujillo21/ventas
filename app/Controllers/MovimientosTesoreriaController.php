<?php



namespace Application\Controllers;



use Exception;

use Application\Libs\Upload;

use Application\Libs\Session;

use Application\Core\Controller as Controller;

use Application\Models\CuentasCorrientes;

use Application\Models\MovimientosTesoreria;

use Application\Models\Sedes;



class MovimientosTesoreriaController extends Controller

{

    //model principal

    public $movimientostesoreria; // Es mi modelo

    public $cuentasCorrientes;

    public $sedes;



    public $session;



    public function __construct()

    {

        parent::__construct();

        $this->session                = new Session();

        $this->movimientostesoreria   = new MovimientosTesoreria();

        $this->cuentasCorrientes      = new CuentasCorrientes();

        $this->sedes                  = new Sedes();

        $this->session->init();
    }





    public function movimientosLB()

    {

        try {

            $this->authAdmin($this->session);



            $user = $this->session->get('user');



            $this->view('admin/movimientoslb', [

                'sTitulo'                => 'Mantenimientos de libros bancos',

                'user'                   => $this->session->get('user'),

                'bShowMenu'              => true,

                "nAdmin"                 => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,

                "aryCuentasCorrientes"   => $this->cuentasCorrientes->fncGetCuentasCorrientes(["nIdSede" => $user["nIdSede"]]),

                'arySede'                => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],



            ]);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncPopulate()

    {

        try {

            $nIdCuentaCorriente = isset($_POST["nIdCuentaCorriente"]) ? $_POST["nIdCuentaCorriente"]  : null;
            $dFechaInicio       = isset($_POST["dFechaInicio"]) ? $_POST["dFechaInicio"]  : null;
            $dFechaFin          = isset($_POST["dFechaFin"]) ? $_POST["dFechaFin"]  : null;
            $nAnhio             = isset($_POST["nAnhio"]) ? $_POST["nAnhio"]  : null;
            $nMes               = isset($_POST["nMes"]) ? $_POST["nMes"]  : null;


            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }

            // Valida valores del formulario

            $aryRows      = [];

            $aryData      = $this->movimientostesoreria->fncGetMovimientos([
                "nIdEmpresa"          => $user["nIdEmpresa"],
                "nIdSede"             => $user["nIdSede"],
                "nIdCuentaCorriente"  => $nIdCuentaCorriente,
                "nAnhio"              => $nAnhio,
                "nMes"                => $nMes
            ]);



            $nIngresos = 0;

            $nSalidas  = 0;



            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());



            if (is_array($aryData) && count($aryData) > 0) {

                foreach ($aryData as $aryLoop) {

                    $sActionShow      = "fncMostrarMT(" . $aryLoop['nIdMovimientoTesoreria'] . ", 'ver' );";

                    $sActionEdit      = "fncMostrarMT(" . $aryLoop['nIdMovimientoTesoreria'] . ", 'editar' );";

                    $sActionEliminar  = "fncEliminarMT(" . $aryLoop['nIdMovimientoTesoreria'] . ");";


                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';

                    $sLinkEdit   = $bIsAdmin  && $aryLoop["nTipoEntidad"] == 0 ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';

                    $sLinkDelete = $bIsAdmin  && $aryLoop["nTipoEntidad"] == 0  ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">

                                    ' . $sLinkShow . '

                                    ' . $sLinkEdit . '

                                    ' . $sLinkDelete . '

                                </div>';



                    if ($aryLoop["nTipo"] == 1) {
                        $nIngresos += $aryLoop["nMonto"];
                    }



                    if ($aryLoop["nTipo"] == 2) {
                        $nSalidas += $aryLoop["nMonto"];
                    }


                    $aryRows[] = [

                        "sAcciones"               => $sAcciones,

                        "sDescripcion"            => $aryLoop["sDescripcion"],

                        "sCuentaCorriente"        => $aryLoop["sPropietario"] . " | " . $aryLoop["sBanco"] . " | " . $aryLoop["sTipoCuenta"] . " | " . $aryLoop["sNumeroCC"],

                        "dFechaRegistro"          => $aryLoop["dFechaRegistro"],

                        "sTipo"                   => $aryLoop["nTipo"] == 1 ? "DEBE" : "HABER",

                        "nMonto"                  => $aryLoop["nMonto"],

                        "sEstado"                 => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",

                    ];
                }
            }


            $aryTotalesMesCurso = [
                "sIngresos"     => nf($nIngresos),
                "sSalidas"      => nf($nSalidas),
                "sSaldoActual"  => nf($nIngresos - $nSalidas),
                "nSaldoActual"  => ($nIngresos - $nSalidas),

            ];

            # Calcular los totales de todos los meses del año seleccionado 
            $aryDataMeses = [];

            $aryData  = $this->movimientostesoreria->fncGetMovimientos([
                "nIdEmpresa"          => $user["nIdEmpresa"],
                "nIdSede"             => $user["nIdSede"],
                "nIdCuentaCorriente"  => $nIdCuentaCorriente,
                "nAnhio"              => $nAnhio,

            ]);


            foreach ($aryData as $aryLoop) {

                if (!isset($aryDataMeses[$aryLoop["nMes"]])) {
                    $aryDataMeses[$aryLoop["nMes"]]["nMes"] = $aryLoop["nMes"];
                    $aryDataMeses[$aryLoop["nMes"]]["nIngresos"] = 0;
                    $aryDataMeses[$aryLoop["nMes"]]["nSalidas"] = 0;
                    $aryDataMeses[$aryLoop["nMes"]]["nSaldoActual"] = 0;
                }

                if ($aryLoop["nTipo"] == 1) {
                    $aryDataMeses[$aryLoop["nMes"]]["nIngresos"] += $aryLoop["nMonto"];
                }

                if ($aryLoop["nTipo"] == 2) {
                    $aryDataMeses[$aryLoop["nMes"]]["nSalidas"] += $aryLoop["nMonto"];
                }

                $aryDataMeses[$aryLoop["nMes"]]["nSaldoActual"] = $aryDataMeses[$aryLoop["nMes"]]["nIngresos"] - $aryDataMeses[$aryLoop["nMes"]]["nSalidas"];
            }

            $nSaldoAnteriorMesCurso = 0;

            foreach ($aryDataMeses as $nMesA => $aryLoop) {
                if (intval($nMesA) < intval($nMes)) {
                    $nSaldoAnteriorMesCurso += ($aryLoop["nSaldoActual"]);
                }
            }

            $nMesMinimo = min(array_column($aryDataMeses, "nMes"));
            $sMesMinimo = $nMesMinimo <= 9 ? '0' . $nMesMinimo : $nMesMinimo;


            $aryDataExtra  = [
                "nSaldoAnteriorMesCurso"   => nf($nSaldoAnteriorMesCurso),
                "aryDataMeses"             => array_reverse(array_values($aryDataMeses)),
                "aryTotalesMesCurso"       => $aryTotalesMesCurso,
                "sMesConsultado"           => ((intval($nMes)) <= 9 ? '0' . (intval($nMes)) : intval($nMes)) . " del " .  $nAnhio,
                "sMesesDiff"               => $sMesMinimo . " - " .  ((intval($nMes) - 1) <= 9 ? '0' . (intval($nMes) - 1) : intval($nMes) - 1) . " del " .  $nAnhio,
                "nSaldoActualTotal"        => nf($nSaldoAnteriorMesCurso + $aryTotalesMesCurso["nSaldoActual"])
            ];

            $this->json(["data" => $aryRows, "aryDataExtra" => $aryDataExtra]);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncGrabarMT()

    {

        try {

            $nIdRegistro         = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $nIdCuentaCorriente  = isset($_POST['nIdCuentaCorriente']) ? $_POST['nIdCuentaCorriente'] : null;

            $sDescripcion        = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;

            $nTipoEntidad        = isset($_POST['nTipoEntidad']) ? $_POST['nTipoEntidad'] : null;





            $nIdEntidad     = isset($_POST['nIdEntidad']) ? $_POST['nIdEntidad'] : null;

            $nTipo          = isset($_POST['nTipo']) ? $_POST['nTipo'] : null;

            $nMonto         = isset($_POST['nMonto']) ? $_POST['nMonto'] : null;

            $nTipoMoneda    = isset($_POST['nTipoMoneda']) ? $_POST['nTipoMoneda'] : null;

            $nTipoCambio    = isset($_POST['nTipoCambio']) ? $_POST['nTipoCambio'] : 0;

            $nEstado        = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;



            // Valida valores del formulario

            if (is_null($nIdRegistro)) {

                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }





            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }





            $nIdNewRegistro = null;

            // Crear

            if ($nIdRegistro == 0) {

                $nIdNewRegistro = $this->movimientostesoreria->fncGrabarRegistro(

                    $nIdCuentaCorriente,

                    $sDescripcion,

                    $nTipoEntidad,

                    $nIdEntidad,

                    $nTipo,

                    $nMonto,

                    $nTipoMoneda,

                    $nTipoCambio,

                    $nEstado

                );
            } else {

                //Actualizar

                $this->movimientostesoreria->fncActualizarRegistro(

                    $nIdRegistro,

                    $nIdCuentaCorriente,

                    $sDescripcion,

                    $nTipoEntidad,

                    $nIdEntidad,

                    $nTipo,

                    $nMonto,

                    $nTipoMoneda,

                    $nTipoCambio,

                    $nEstado

                );
            }



            if (!is_null($nIdCuentaCorriente) &&  $nIdCuentaCorriente > 0) {

                $this->fncActualizarSaldoCuentaCorriente($nIdCuentaCorriente);
            }



            $sSuccess =  $nIdRegistro == 0 ? 'Movimiento registrado exitosamente...' : 'Movimiento actualizado exitosamente...';



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



            $aryData = $this->movimientostesoreria->fncGetMovimientos(["nIdMovimientoTesoreria" => $nIdRegistro]);



            if (!fncValidateArray($aryData)) {

                $this->exception('Error. No se pudo ubicar el registro es posible que no exista o se haya eliminado. Por favor verifique.');
            }



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



            # Obtiene el registro

            $aryData = $this->movimientostesoreria->fncGetMovimientos(["nIdMovimientoTesoreria" => $nIdRegistro]);



            if (!fncValidateArray($aryData)) {

                $this->exception('Error.No se pudo obtener el movimiento quizas ya fue eliminado. Por favor verifique.');
            }



            $aryData = $aryData[0];

            # Elimina el registro

            $this->movimientostesoreria->fncEliminarRegistro($nIdRegistro);



            # Actualiza el saldo de la cuenta corriente 

            $this->fncActualizarSaldoCuentaCorriente($aryData["nIdCuentaCorriente"]);

            $this->json(array("success" => 'Registro eliminado exitosamente.'));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncActualizarSaldoCuentaCorriente($nIdCuentaCorriente)

    {

        if (is_null($nIdCuentaCorriente)) {

            $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
        }



        $nEntradas = 0;

        $nSalidas  = 0;



        $nIngresoMovimientoTesoria = $this->fncGetVarConfig("nIngresoMovimientoTesoria");

        $nSalidaMovimientoTesoria  = $this->fncGetVarConfig("nSalidaMovimientoTesoria");



        # Entradas 

        $aryData = $this->movimientostesoreria->fncGetMovimientos(["nIdCuentaCorriente" => $nIdCuentaCorriente, "nEstado" => 1, "nTipo" => $nIngresoMovimientoTesoria]);



        if (fncValidateArray($aryData)) {

            foreach ($aryData as $key => $aryLoop) {

                $nEntradas += $aryLoop["nMonto"];
            }
        }



        # Salidas  

        $aryData = $this->movimientostesoreria->fncGetMovimientos(["nIdCuentaCorriente" => $nIdCuentaCorriente, "nEstado" => 1, "nTipo" => $nSalidaMovimientoTesoria]);



        if (fncValidateArray($aryData)) {

            foreach ($aryData as $key => $aryLoop) {

                $nSalidas += $aryLoop["nMonto"];
            }
        }



        $nSaldo = $nEntradas - $nSalidas;



        $this->cuentasCorrientes->fncActualizarSaldo($nIdCuentaCorriente, $nSaldo);

        return true;
    }
}
