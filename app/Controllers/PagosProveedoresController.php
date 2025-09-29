<?php

namespace Application\Controllers;

use Exception;
use Mpdf\Mpdf;
use Application\Libs\Session;
use Application\Models\Sedes;
use Application\Models\Proveedores;
use Application\Models\MetodosPagos;
use Application\Models\DocumentoPago;
use Application\Models\PagosProveedores;
use Application\Models\CuentasCorrientes;
use Application\Models\MovimientosTesoreria;
use Application\Core\Controller as Controller;

class PagosProveedoresController extends Controller
{
    //model principal
    public $users;
    public $session;
    public $documentoPago;
    public $proveedores;
    public $sedes;
    public $pagosProveedores;
    public $metodosPagos;
    public $cuentasCorrientes;
    public $movimientosTesoreria;

    public function __construct()
    {
        parent::__construct();
        $this->session                   = new Session();
        $this->documentoPago             = new DocumentoPago();
        $this->proveedores               = new Proveedores();
        $this->sedes                     = new Sedes();
        $this->pagosProveedores          = new PagosProveedores();
        $this->metodosPagos              = new MetodosPagos();
        $this->cuentasCorrientes         = new CuentasCorrientes();
        $this->movimientosTesoreria      = new MovimientosTesoreria();

        $this->session->init();
    }


    public function pagosProveedores()
    {
        try {
            $this->authAdmin($this->session);
            $user = $this->session->get('user');
            $this->view('admin/pagos-proveedores', [
                'sTitulo'           => 'Pagos Proveedores',
                'user'              => $user,
                'aryMetodosPagos'   => $this->metodosPagos->fncGetSedesMetodosPagos(["nIdSede" => $user["nIdSede"]]),
                'aryProveedores'    => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),
                'arySede'           => $this->sedes->fncGetSedes(["nIdSede" => $user["nIdSede"]])[0],
                'bShowMenu'         => true,
                "nAdmin"            => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0,
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }



    public function fncPopulate()
    {
        try {

            $nIdProveedor       = isset($_POST["nIdProveedor"]) ? $_POST["nIdProveedor"] : null;
            $dFechaInicio       = isset($_POST["dFechaInicio"]) ? $_POST["dFechaInicio"] : null;
            $dFechaFin          = isset($_POST["dFechaFin"]) ? $_POST["dFechaFin"] : null;


            // Valida valores del formulario
            $aryRows        = [];
            $user           = $this->session->get("user");

            $aryData  = $this->pagosProveedores->fncObtenerPagosProveedores([
                "nIdSede"           => $user["nIdSede"],
                "nIdProveedor"      => $nIdProveedor,
                "dFechaInicio"      => $dFechaInicio,
                "dFechaFin"         => $dFechaFin,
            ]);

            $bIsAdmin  = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());

            if (fncValidateArray($aryData)) {

                foreach ($aryData as $aryLoop) {

                    $sActionShow       = "fncMostrarRegistro(" . $aryLoop['nIdPagoProveedor'] . ", 'ver' );";
                    $sActionEdit       = "fncMostrarRegistro(" . $aryLoop['nIdPagoProveedor'] . ", 'editar' );";
                    $sActionEliminar   = "fncEliminarRegistro(" . $aryLoop['nIdPagoProveedor'] . ");";

                    $sLinkPDF          = '<a target="_blank" href="' . route('pagosProveedores/fncPPPDF/' . $aryLoop['nIdPagoProveedor']) . '"   title="Ver PDF" class="text-primary"><i class="material-icons">picture_as_pdf</i> </a>';

                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';
                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';
                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';


                    $sAcciones = '<div class="content-acciones">
                                    ' . $sLinkPDF . '
                                    ' . $sLinkShow . '
                                    ' . $sLinkEdit . '
                                    ' . $sLinkDelete . '
                                </div>';

                    $aryRows[] = [
                        "sAcciones"               => $sAcciones,
                        "sProveedor"              => $aryLoop["sProveedor"],
                        "sMetodoPago"             => $aryLoop["sMetodoPago"],
                        "dFechaPago"              => $aryLoop["dFechaPago"],
                        "sCuentaCorriente"        => $aryLoop["sPropietarioCC"] . " | " . $aryLoop["sBancoCC"] . " | " . $aryLoop["sTipoCuentaCC"] . " | " . $aryLoop["sNumeroCC"],
                        "dFechaRegistro"          => $aryLoop["dFechaRegistro"],
                        "nCantidadDocs"           => $aryLoop["nCantidadDocs"],
                        "nTotal"                  => nf($aryLoop["nTotal"], true),
                        "sEstado"                 => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",
                    ];
                }
            }

            $this->json($aryRows);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function fncGrabarPago()
    {
        $nIdRegistro       = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;
        $nIdProveedor      = isset($_POST['nIdProveedor']) ? $_POST['nIdProveedor'] : null;
        $sDescripcion      = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;
        $dFechaPago        = isset($_POST['dFechaPago']) ? $_POST['dFechaPago'] : null;

        $nIdCuentaCorriente = isset($_POST['nIdCuentaCorriente']) ? $_POST['nIdCuentaCorriente'] : null;
        $nIdMetodoPago      = isset($_POST['nIdMetodoPago']) ? $_POST['nIdMetodoPago'] : null;


        $nTotal             = isset($_POST['nTotal']) ? $_POST['nTotal'] : null;
        $nEstado            = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;
        $aryDetalle         = isset($_POST['aryDetalle']) ? $_POST['aryDetalle'] : null;


        try {

            // Valida valores del formulario
            if (is_null($nIdRegistro) || is_null($nIdProveedor)) {
                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }

            $user = $this->session->get("user");

            if (is_null($user)) {
                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }

            $movimientosTesoreriaController = new MovimientosTesoreriaController();

            $nIdNewRegistro = null;

            // Crear
            if ($nIdRegistro == 0) {

                # Graba el pedido

                # Validar la cuenta corriente 
                $aryCuentaCorriente = $this->cuentasCorrientes->fncGetCuentasCorrientes(["nIdCuentaCorriente" => $nIdCuentaCorriente])[0];
                $nDiff              = $aryCuentaCorriente["nSaldoActual"] - $nTotal;

                if ($nDiff < 0) {
                    $this->exception('Error.La cuenta corriente actual no cuenta con el saldo suficiente para pagar al proveedor. Por favor verifique.');
                }


                $nIdNewRegistro = $this->pagosProveedores->fncGrabarRegistro(
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdProveedor,
                    $sDescripcion,
                    $dFechaPago,
                    $nIdCuentaCorriente,
                    $nIdMetodoPago,
                    $nTotal,
                    $nEstado
                );

                # Graba el detalle 
                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {

                        $aryDocumentosPagos = $this->documentoPago->fncObtenerDocumentosPagos(["nIdDocumentosPago" => $aryLoop["nIdDocumentosPago"]]);

                        if (!fncValidateArray($aryDocumentosPagos)) {
                            $this->exception('Error. No se pudo ubicar el documento de pago. Por favor verifique.');
                        }

                        $aryDocumentosPagos = $aryDocumentosPagos[0];

                        # Inserta el registro de detalle 
                        $this->pagosProveedores->fncGrabarRegistroDetalle($nIdNewRegistro, $aryLoop["nIdDocumentosPago"], $aryLoop["nTotal"]);

                        # Una vez insertado los pagos descontar esto de la cuenta corriente
                        # Vamos a ingresar el monto total ya qye 
                        $this->movimientosTesoreria->fncGrabarRegistro(
                            $nIdCuentaCorriente,
                            "PAGO DE DOCUMENTO :" . $aryDocumentosPagos["sTipoDoc"] . "-" . $aryDocumentosPagos["sNumero"],
                            2,
                            $aryLoop["nIdDocumentosPago"],
                            $this->fncGetVarConfig("nSalidaMovimientoTesoria"),
                            $aryLoop["nTotal"],
                            $aryDocumentosPagos["nTipoMoneda"],
                            0,
                            $nEstado
                        );

                        # Validar si el documento esta saldo
                        $nDiff = $aryDocumentosPagos["nPagoPendiente"] - $aryLoop["nTotal"];

                        if ($nDiff <= 0) {
                            # El documento estado pagado por lo tanto actualizo el flag de estado pagaddo y actualizo el estado de pago pendiente
                            $this->documentoPago->fncActualizarPagoPendiente($aryLoop["nIdDocumentosPago"], $nDiff);
                            $this->documentoPago->fncActualizarEstadoPago($aryLoop["nIdDocumentosPago"], 1);
                        } else {
                            $this->documentoPago->fncActualizarPagoPendiente($aryLoop["nIdDocumentosPago"], $nDiff);
                        }

                        $movimientosTesoreriaController->fncActualizarSaldoCuentaCorriente($nIdCuentaCorriente);
                    }
                }
            } else {

                // Actualizar
                $aryDetalleBD = $this->pagosProveedores->fncObtenerPagosProveedoresDetalle(["nIdPagoProveedor" => $nIdRegistro]);

                #  Obtiene el detalle de la BD
                foreach ($aryDetalleBD as $key => $aryLoop) {
                    # Eliminaremos los movimientos anteriores 

                    $aryMov = $this->movimientosTesoreria->fncGetMovimientos(["nTipoEntidad" => 2, "nIdEntidad" =>  $aryLoop["nIdDocumentosPago"]]);

                    if (fncValidateArray($aryMov)) {
                        $aryMov = $aryMov[0];
                        $this->movimientosTesoreria->fncEliminarRegistro($aryMov["nIdMovimientoTesoreria"]);
                    }

                    # Actualizar el monto pendiente de pago a pagos proveedores 
                    # Tomamos el monto total pagado mas el monto pendiente ed pago para totalizar el documento y regrese a como este antes 
                    $aryDocPago  = $this->documentoPago->fncObtenerDocumentosPagos(["nIdDocumentosPago" =>  $aryLoop["nIdDocumentosPago"]])[0];

                    $this->documentoPago->fncActualizarPagoPendiente($aryDocPago["nIdDocumentosPago"], $aryDocPago["nTotal"]);
                    $this->documentoPago->fncActualizarEstadoPago($aryDocPago["nIdDocumentosPago"], 0);

                    $movimientosTesoreriaController->fncActualizarSaldoCuentaCorriente($nIdCuentaCorriente);
                }


                # Validar la cuenta corriente 
                $aryCuentaCorriente = $this->cuentasCorrientes->fncGetCuentasCorrientes(["nIdCuentaCorriente" => $nIdCuentaCorriente])[0];
                $nDiff              = $aryCuentaCorriente["nSaldoActual"] - $nTotal;

                if ($nDiff < 0) {
                    $this->exception('Error.La cuenta corriente actual no cuenta con el saldo suficiente para pagar al proveedor. Por favor verifique.');
                }

                # Antes de actualizar retorna todo a como estaba antes y vuelve a validar 
                # Actualiza la cabecera del pedido
                $this->pagosProveedores->fncActualizarRegistro(
                    $nIdRegistro,
                    $user["nIdEmpresa"],
                    $user["nIdSede"],
                    $nIdProveedor,
                    $sDescripcion,
                    $dFechaPago,
                    $nIdCuentaCorriente,
                    $nIdMetodoPago,
                    $nTotal,
                    $nEstado
                );


                # Elimino el detalle
                $this->pagosProveedores->fncEliminarRegistroDetalleByIdPagoProveedor($nIdRegistro);

                # Graba el detalle 
                if (fncValidateArray($aryDetalle)) {
                    foreach ($aryDetalle as $nKey => $aryLoop) {

                        $aryDocumentosPagos = $this->documentoPago->fncObtenerDocumentosPagos(["nIdDocumentosPago" => $aryLoop["nIdDocumentosPago"]]);

                        if (!fncValidateArray($aryDocumentosPagos)) {
                            $this->exception('Error. No se pudo ubicar el documento de pago. Por favor verifique.');
                        }

                        $aryDocumentosPagos = $aryDocumentosPagos[0];

                        # Inserta el registro de detalle 
                        $this->pagosProveedores->fncGrabarRegistroDetalle($nIdRegistro, $aryLoop["nIdDocumentosPago"], $aryLoop["nTotal"]);

                        # Una vez insertado los pagos descontar esto de la cuenta corriente
                        # Vamos a ingresar el monto total ya qye 
                        $this->movimientosTesoreria->fncGrabarRegistro(
                            $nIdCuentaCorriente,
                            "PAGO DE DOCUMENTO :" . $aryDocumentosPagos["sTipoDoc"] . "-" . $aryDocumentosPagos["sNumero"],
                            2,
                            $aryLoop["nIdDocumentosPago"],
                            $this->fncGetVarConfig("nSalidaMovimientoTesoria"),
                            $aryLoop["nTotal"],
                            $aryDocumentosPagos["nTipoMoneda"],
                            0,
                            $nEstado
                        );

                        # Validar si el documento esta saldo
                        $nDiff = floatval($aryDocumentosPagos["nPagoPendiente"]) - floatval($aryLoop["nTotal"]);
                        if ($nDiff <= 0) {
                            # El documento estado pagado por lo tanto actualizo el flag de estado pagaddo y actualizo el estado de pago pendiente
                            $this->documentoPago->fncActualizarPagoPendiente($aryLoop["nIdDocumentosPago"], $nDiff);
                            $this->documentoPago->fncActualizarEstadoPago($aryLoop["nIdDocumentosPago"], 1);
                        } else {
                            $this->documentoPago->fncActualizarPagoPendiente($aryLoop["nIdDocumentosPago"], $nDiff);
                        }

                        $movimientosTesoreriaController->fncActualizarSaldoCuentaCorriente($nIdCuentaCorriente);
                    }
                }
            }

            $sSuccess = $nIdRegistro == 0 ? 'Pago proveedores registrado exitosamente...' : 'Pago proveedores actualizado exitosamente...';

            $this->json(array(
                "success"            => $sSuccess,
                "nIdNewRegistro"     => $nIdNewRegistro,
            ));
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

            $aryData = $this->pagosProveedores->fncObtenerPagosProveedores(["nIdPagoProveedor" => $nIdRegistro]);

            if (!fncValidateArray($aryData)) {
                $this->exception("Error.No se pudo encontrar el pedido o se haya eliminado.Porfavor verifique");
            }

            $aryData = $aryData[0];

            $aryDetalleBD = $this->pagosProveedores->fncObtenerPagosProveedoresDetalle(["nIdPagoProveedor" => $nIdRegistro]);
            $movimientosTesoreriaController = new MovimientosTesoreriaController();

            #  Obtiene el detalle de la BD
            foreach ($aryDetalleBD as $key => $aryLoop) {
                # Eliminaremos los movimientos anteriores 

                $aryMov = $this->movimientosTesoreria->fncGetMovimientos(["nTipoEntidad" => 2, "nIdEntidad" =>  $aryLoop["nIdDocumentosPago"]]);

                if (fncValidateArray($aryMov)) {
                    $aryMov = $aryMov[0];
                    $this->movimientosTesoreria->fncEliminarRegistro($aryMov["nIdMovimientoTesoreria"]);
                }

                # Actualizar el monto pendiente de pago a pagos proveedores 
                # Tomamos el monto total pagado mas el monto pendiente ed pago para totalizar el documento y regrese a como este antes 
                $aryDocPago  = $this->documentoPago->fncObtenerDocumentosPagos(["nIdDocumentosPago" =>  $aryLoop["nIdDocumentosPago"]])[0];

                $this->documentoPago->fncActualizarPagoPendiente($aryDocPago["nIdDocumentosPago"], $aryDocPago["nTotal"]);
                $this->documentoPago->fncActualizarEstadoPago($aryDocPago["nIdDocumentosPago"], 0);

                # Actualizamos el saldo corrinete
                $movimientosTesoreriaController->fncActualizarSaldoCuentaCorriente($aryData["nIdCuentaCorriente"]);
            }

            $this->pagosProveedores->fncEliminarRegistro($nIdRegistro);
            $this->json(array("success" => 'Pago Proveedores eliminado exitosamente.'));
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

            $aryPago        = $this->pagosProveedores->fncObtenerPagosProveedores(["nIdPagoProveedor" => $nIdRegistro]);
            $aryDocDetalle  = $this->pagosProveedores->fncObtenerPagosProveedoresDetalle(["nIdPagoProveedor" => $nIdRegistro]);

            $this->json(array(
                "success"           => true,
                "aryPago"           => fncValidateArray($aryPago) ? $aryPago[0] : null,
                "aryDocDetalle"     => $aryDocDetalle
            ));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function fncPPPDF($nIdPagoProveedor)
    {
        try {

            $aryPagoProveedor   = $this->pagosProveedores->fncObtenerPagosProveedores(["nIdPagoProveedor" => $nIdPagoProveedor]);

            if (!fncValidateArray($aryPagoProveedor)) {
                $this->exception("Error. No se encontro datos el pago a el proveedor quizas se se haya eliminado o no exista. Porfavor verifique.");
            }

            $aryPagoProveedor        = $aryPagoProveedor[0];

            $aryDetalle = $this->pagosProveedores->fncObtenerPagosProveedoresDetalle(["nIdPagoProveedor" => $nIdPagoProveedor]);

            if (!fncValidateArray($aryDetalle)) {
                $this->exception("Error. No se encontro datos sobre el detalle del pago problablemente se haya eliminado o no exista. Porfavor verifique.");
            }


            $arySede = $this->sedes->fncGetSedes(["nIdSede" => $aryPagoProveedor["nIdSede"]]);

            if (!fncValidateArray($arySede)) {
                $this->exception("Error. No se encontro datos de la sede problablemente se haya eliminado o no exista. Porfavor verifique.");
            }

            $arySede    = $arySede[0];

            ob_start();


            $this->view("admin/pdf-pagoproveedor", [
                "sTitulo"           =>  "VOUCHER PAGO A PROVEEDORES",
                "aryPagoProveedor"  => $aryPagoProveedor,
                "aryDetalle"        => $aryDetalle,
                "arySede"           => $arySede,
            ]);

            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new Mpdf([]);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
