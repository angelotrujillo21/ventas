<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Pedidos
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarPedido(
        $nIdCaja,
        $sSerie,
        $sNumero,
        $nIdEmpresa,
        $nIdSede,
        $nIdCliente,
        $nIdResponsable,
        $nIdMetodoEnvio,
        $nIdMetodoPago,
        $nEstadoEnvio,
        $nEstadoPago,
        $dFechaCreacion,
        $nEfectivo,
        $nVuelto,
        $nTipoMoneda,
        $nDespachado,
        $nDescuento,
        $nDescuentoCanje,
        $nPuntosCanje,
        $sDescripcion,
        $nCondicionPago,
        $nPorcentajeIGV,
        $nTotalBruto,
        $nTotalDsctSimple,
        $nTotalDescuentoCanje,
        $nTotalDsct,
        $nSubTotal,
        $nIgv,
        $nTotal,
        $nIdResponsableDelivery,
        $nIdPedidoCD,
        $nIdCotizacion,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLInsert("pedidos", [
            "nIdCaja"                       => $nIdCaja,
            "sSerie"                        => $sSerie,
            "sNumero"                       => $sNumero,
            "nIdEmpresa"                    => $nIdEmpresa,
            "nIdSede"                       => $nIdSede,
            "nIdCliente"                    => $nIdCliente,
            "nIdResponsable"                => $nIdResponsable,
            "nIdMetodoEnvio"                => $nIdMetodoEnvio,
            "nIdMetodoPago"                 => $nIdMetodoPago,
            "nEstadoEnvio"                  => $nEstadoEnvio,
            "nEstadoPago"                   => $nEstadoPago,
            "dFechaRegistro"                => "NOW()",
            "dFechaCreacion"                => "STR_TO_DATE( '$dFechaCreacion', '%d/%m/%Y' ) ",
            "nEfectivo"                     => $nEfectivo,
            "nVuelto"                       => $nVuelto,
            "nTipoMoneda"                   => $nTipoMoneda,
            "nDespachado"                   => $nDespachado,

            "nDescuento"                   => $nDescuento,
            "nDescuentoCanje"              => $nDescuentoCanje,
            "nPuntosCanje"                 => $nPuntosCanje,
            "sDescripcion"                 => $sDescripcion,
            "nCondicionPago"               => $nCondicionPago,

            "nPorcentajeIGV"               => $nPorcentajeIGV,
            "nTotalBruto"                  => $nTotalBruto,
            "nTotalDsctSimple"             => $nTotalDsctSimple,
            "nTotalDescuentoCanje"         => $nTotalDescuentoCanje,
            "nTotalDsct"                   => $nTotalDsct,
            "nSubTotal"                    => $nSubTotal,
            "nIgv"                         => $nIgv,
            "nTotal"                       => $nTotal,
            "nIdResponsableDelivery"       => $nIdResponsableDelivery,
            "nIdPedidoCD"                  => $nIdPedidoCD,
            "nIdCotizacion"                => $nIdCotizacion,
            "nEstado"                      => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarPedido(

        $nIdPedido,
        $nIdCaja,
        $sSerie,
        $sNumero,
        $nIdEmpresa,
        $nIdSede,
        $nIdCliente,
        $nIdResponsable,
        $nIdMetodoEnvio,
        $nIdMetodoPago,
        $nEstadoEnvio,
        $nEstadoPago,
        $dFechaCreacion,
        $nEfectivo,
        $nVuelto,
        $nTipoMoneda,
        $nDespachado,
        $nDescuento,
        $nDescuentoCanje,
        $nPuntosCanje,
        $sDescripcion,
        $nCondicionPago,
        $nPorcentajeIGV,
        $nTotalBruto,

        $nTotalDsctSimple,
        $nTotalDescuentoCanje,
        $nTotalDsct,
        $nSubTotal,
        $nIgv,
        $nTotal,
        $nIdResponsableDelivery,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLUpdate("pedidos", [
            "nIdCaja"                    => $nIdCaja,
            "sSerie"                     => $sSerie,
            "sNumero"                    => $sNumero,
            "nIdEmpresa"                 => $nIdEmpresa,
            "nIdSede"                    => $nIdSede,
            "nIdCliente"                 => $nIdCliente,
            "nIdResponsable"             => $nIdResponsable,
            "nIdMetodoEnvio"             => $nIdMetodoEnvio,
            "nIdMetodoPago"              => $nIdMetodoPago,
            "nEstadoEnvio"               => $nEstadoEnvio,
            "nEstadoPago"                => $nEstadoPago,
            "dFechaCreacion"             => "STR_TO_DATE( '$dFechaCreacion', '%d/%m/%Y' ) ",
            "dFechaEdicion"              => "NOW()",
            "nEfectivo"                  => $nEfectivo,
            "nVuelto"                    => $nVuelto,
            "nTipoMoneda"                => $nTipoMoneda,
            "nDespachado"                => $nDespachado,
            "nDescuento"                 => $nDescuento,
            "nDescuentoCanje"            => $nDescuentoCanje,
            "nPuntosCanje"               => $nPuntosCanje,
            "sDescripcion"               => $sDescripcion,
            "nCondicionPago"             => $nCondicionPago,


            "nPorcentajeIGV"               => $nPorcentajeIGV,
            "nTotalBruto"                  => $nTotalBruto,
            "nTotalDsctSimple"             => $nTotalDsctSimple,
            "nTotalDescuentoCanje"         => $nTotalDescuentoCanje,
            "nTotalDsct"                   => $nTotalDsct,
            "nSubTotal"                    => $nSubTotal,
            "nIgv"                         => $nIgv,
            "nTotal"                       => $nTotal,
            "nIdResponsableDelivery"       => $nIdResponsableDelivery,

            "nEstado"                    => $nEstado,
        ], "nIdPedido = $nIdPedido");

        // echo $sSQL;
        // exit;


        return  $this->db->run($sSQL);
    }


    public function fncActualizarFacturado(
        $nIdPedido,
        $nFacturado
    ) {
        $sSQL = $this->db->generateSQLUpdate("pedidos", [
            "nFacturado"   => $nFacturado,
        ], "nIdPedido = $nIdPedido");


        return  $this->db->run($sSQL);
    }



    public function fncActualizarDespachado(
        $nIdPedido,
        $nDespachado
    ) {
        $sSQL = $this->db->generateSQLUpdate("pedidos", [
            "nDespachado"   => $nDespachado,
        ], "nIdPedido = $nIdPedido");


        return  $this->db->run($sSQL);
    }


    public function fncActualizarMovimiento(
        $nIdPedido,
        $nIdMovimiento
    ) {
        $sSQL = $this->db->generateSQLUpdate("pedidos", [
            "nIdMovimiento"   => $nIdMovimiento,
        ], "nIdPedido = $nIdPedido");


        return  $this->db->run($sSQL);
    }


    public function fncEliminarPedido($nIdPedido)
    {
        $sSQL = $this->db->generateSQLDelete("pedidos", "nIdPedido = $nIdPedido");
        return  $this->db->run($sSQL);
    }


    public function fncObtenerPedidos($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"         => "p.nIdPedido DESC",
            "sLimit"           => null,
            "nIdCaja"          => null,
            "nIdPedido"        => null,
            "nIdEmpresa"       => null,
            "nIdSede"          => null,
            "aryIdSede"        => null,
            "nIdResponsable"   => null,
            "aryProductos"     => null,
            "aryClientes"      => null,
            "aryIdPedido"      => null,
            "nFacturado"       => null,
            "nDespachado"      => null,
            "dFechaInicio"     => null,
            "dFechaFin"        => null,
            "dFechaCreacion"   => null,
            "dFechaRegistro"   => null,
            "arysNum"          => null,
            "sSerie"           => null,
            "sNumero"          => null,
            "nCondicionPago"   => null,
            "nEstado"          => null,

            # Filtros para Metodos y estados de pago y envio
            "aryMetodoPago"    => null,
            "aryEstadoPago"    => null,
            "aryMetodoEnvio"   => null,
            "aryEstadoEnvio"   => null,
            "nIdResponsableDelivery"  => null,
            "nIdMetodoPago"    => null,
 
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        p.nIdPedido,
                        IFNULL(p.nIdCaja,0) AS nIdCaja,
                        p.sSerie,
                        p.sNumero,
                        p.nIdEmpresa,
                        p.nIdSede,
                        p.nIdCliente, 
                        p.nIdResponsable, 
                        p.nIdMetodoEnvio,
                        p.nIdMetodoPago,
                        p.nEstadoEnvio,
                        p.nEstadoPago,
                        p.nEfectivo,
                        p.nVuelto,
                        p.nFacturado,
                        p.nDespachado,
                        p.nTipoMoneda,
                        p.sDescripcion, 
                        IFNULL(p.nCondicionPago,0) AS nCondicionPago,
                        IFNULL(doc.nIdDocumento,'0') AS nIdDocumento, 
                        IFNULL(doc.nAnulado,'0') AS nAnulado, 
                        IFNULL(cli.sNumeroDocumento,'') AS sNumeroDocumentoCliente, 
                        IFNULL(cli.nTipoDocumento,'') AS nTipoDocumentoCliente, 
                        UPPER(CONCAT(IFNULL( tipomoneda.sDescripcionLargaItem,'' ), ' ')) AS sMoneda, 
                        UPPER(CONCAT(IFNULL( tipomoneda.sDescripcionCortaItem,'' ), ' ')) AS sPrefijoMoneda, 

                        IFNULL( DATE_FORMAT( p.dFechaRegistro, '%d/%m/%Y' ), '' ) as dFechaRegistro, 
                        IFNULL( DATE_FORMAT( p.dFechaCreacion, '%d/%m/%Y' ), '' ) as dFechaCreacion, 


                        IFNULL( DATE_FORMAT( p.dFechaEdicion, '%d/%m/%Y' ), '' ) as dFechaEdicion, 
                        IFNULL(cli.sNombreoRazonSocial,'') AS sCliente, 
                        
                        IFNULL(emp.sNombre , IFNULL(CONCAT(usu.sNombre,' ',usu.sApellidos),'') ) AS sResponsable,
                        
                        IFNULL(me.sNombre,'') AS sMetodoEnvio,
                        IFNULL(mp.sNombre,'') AS sMetodoPago,
                        IFNULL(estadopago.sDescripcionLargaItem,'') AS sEstadoPago,
                        IFNULL(estadoenvio.sDescripcionLargaItem,'') AS sEstadoEnvio,
                        IFNULL(p.nIdMovimiento,0) AS nIdMovimiento,

                        -- Descuento
                        IFNULL(p.nDescuento , 0) AS nDescuento, -- Porcentaje de descuento
                        IFNULL(p.nDescuentoCanje , 0) AS nDescuentoCanje,
                        IFNULL(p.nPuntosCanje , 0) AS nPuntosCanje,
                        IFNULL(p.nPuntosAcumuladosItem , 0) AS nPuntosAcumuladosItem,

                        IFNULL(pdct.nIdPedidoCuota, 0) AS nIdPedidoCuota,
                        IFNULL(pdct.nAdelanto , 0) AS nAdelanto,
                        IFNULL(pdct.nCuotas , 0) AS nCuotas,

                        
                        IFNULL(p.nPorcentajeIGV, 0) AS nPorcentajeIGV,
                        IFNULL(p.nTotalBruto , 0) AS nTotalBruto,
                        IFNULL(p.nTotalDsctSimple , 0) AS nTotalDsctSimple,
                        IFNULL(p.nTotalDescuentoCanje , 0) AS nTotalDescuentoCanje,
                        IFNULL(p.nTotalDsct , 0) AS nTotalDsct,
                        IFNULL(p.nSubTotal , 0) AS nSubTotal,
                        IFNULL(p.nIgv , 0) AS nIgv,
                        IFNULL(p.nTotal , 0) AS nTotal,
                        IFNULL(caj.sDescripcion ,'') AS sCaja,
                        IFNULL(empmt.sNombre , '' ) AS sMotorizado,
                        IFNULL(p.nIdResponsableDelivery , 0) AS nIdResponsableDelivery,
                        IFNULL(mt.nIdMovimientoTesoreria , 0) AS nIdMovimientoTesoreria,
                        IFNULL(mt.nIdCuentaCorriente , 0) AS nIdCuentaCorriente,
                        p.nEstado,
                        IFNULL(p.nIdPedidoCD,0) AS nIdPedidoCD,
                        IFNULL(p.nIdCotizacion,0) AS nIdCotizacion,

                        IFNULL(tipodocumentocli.sCodigoItem,'') AS sCodigoDocumentoCliente,
                        IFNULL(cli.sDireccion,'') AS sDireccionCliente
                FROM pedidos AS p
                LEFT JOIN clientes AS cli ON p.nIdCliente = cli.nIdCliente 
                LEFT JOIN catalogotabla AS tipodocumentocli ON cli.nTipoDocumento = tipodocumentocli.nIdCatalogoTabla 

                LEFT JOIN pedidosdetalle AS pd ON p.nIdPedido = pd.nIdPedido   
                LEFT JOIN metodosenvio AS me ON p.nIdMetodoEnvio = me.nIdMetodoEnvio   
                LEFT JOIN metodospago AS mp ON p.nIdMetodoPago = mp.nIdMetodoPago   
                
                LEFT JOIN empleados AS emp ON p.nIdResponsable = emp.nIdEmpleado
                LEFT JOIN usuarios AS usu ON p.nIdResponsable = usu.nIdUsuario

                LEFT JOIN catalogotabla AS estadopago ON estadopago.nIdCatalogoTabla = p.nEstadoPago
                LEFT JOIN catalogotabla AS estadoenvio ON estadoenvio.nIdCatalogoTabla = p.nEstadoEnvio
                LEFT JOIN catalogotabla AS tipomoneda ON p.nTipoMoneda = tipomoneda.nIdCatalogoTabla
                LEFT JOIN documentos AS doc ON p.nIdPedido = doc.nIdPedido
                LEFT JOIN pedidoscuotas AS pdct ON p.nIdPedido = pdct.nIdPedido
                LEFT JOIN cajas AS caj ON p.nIdCaja = caj.nIdCaja 
                
                LEFT JOIN empleados AS empmt ON p.nIdResponsableDelivery = empmt.nIdEmpleado
                LEFT JOIN movimientostesoreria AS mt ON mt.nIdEntidad = p.nIdPedido AND mt.nTipo = 1";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdPedido"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdPedido = {$this->db->quote($ary['nIdPedido'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdCaja"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdCaja = {$this->db->quote($ary['nIdCaja'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdSede"]) && !is_array($ary["aryIdSede"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdSede IN (' . implode(",", $ary['aryIdSede']) . ')');

        $sWhere .= ($this->db->isNull($ary["nIdResponsable"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdResponsable = {$this->db->quote($ary['nIdResponsable'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryProductos"]) && !is_array($ary["aryProductos"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' pd.nIdProducto IN (' . implode(",", $ary['aryProductos']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryClientes"]) && !is_array($ary["aryClientes"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdCliente IN (' . implode(",", $ary['aryClientes']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryIdPedido"]) && !is_array($ary["aryIdPedido"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdPedido IN (' . implode(",", $ary['aryIdPedido']) . ')');

        $sWhere .= ($this->db->isNull($ary["arysNum"]) && !is_array($ary["arysNum"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.sNumero IN (' . implode(",", $ary['arysNum']) . ')');

        $sWhere .= ($this->db->isNull($ary["nFacturado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nFacturado = {$this->db->quote($ary['nFacturado'])}  ");

        $sWhere .= ($this->db->isNull($ary["nDespachado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nDespachado = {$this->db->quote($ary['nDespachado'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdResponsableDelivery"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdResponsableDelivery = {$this->db->quote($ary['nIdResponsableDelivery'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(p.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["dFechaCreacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(p.dFechaCreacion) =  STR_TO_DATE( '" . $ary['dFechaCreacion'] . "', '%d/%m/%Y' )  ");

        $sWhere .= ($this->db->isNull($ary["dFechaRegistro"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(p.dFechaRegistro) =  STR_TO_DATE( '" . $ary['dFechaRegistro'] . "', '%d/%m/%Y' )  ");


        $sWhere .= ($this->db->isNull($ary["sSerie"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.sSerie = {$this->db->quote($ary['sSerie'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNumero"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.sNumero = {$this->db->quote($ary['sNumero'])}  ");

        $sWhere .= ($this->db->isNull($ary["nCondicionPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nCondicionPago = {$this->db->quote($ary['nCondicionPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdMetodoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdMetodoPago = {$this->db->quote($ary['nIdMetodoPago'])}  ");


        $sWhere .= ($this->db->isNull($ary["aryMetodoPago"]) && !is_array($ary["aryMetodoPago"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdMetodoPago IN (' . implode(",", $ary['aryMetodoPago']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryEstadoPago"]) && !is_array($ary["aryEstadoPago"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nEstadoPago IN (' . implode(",", $ary['aryEstadoPago']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryMetodoEnvio"]) && !is_array($ary["aryMetodoEnvio"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdMetodoEnvio IN (' . implode(",", $ary['aryMetodoEnvio']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryEstadoEnvio"]) && !is_array($ary["aryEstadoEnvio"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nEstadoEnvio IN (' . implode(",", $ary['aryEstadoEnvio']) . ')');


        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= '  GROUP by p.nIdPedido ';

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }



    public function fncGrabarPedidoDetalle(
        $nIdPedido,
        $nIdProducto,
        $nPrecio,
        $nCantidad,
        $sDetalle
    ) {
        $sSQL = $this->db->generateSQLInsert("pedidosdetalle", [
            "nIdPedido"      => $nIdPedido,
            "nIdProducto"    => $nIdProducto,
            "nPrecio"        => $nPrecio,
            "nCantidad"      => $nCantidad,
            "sDetalle"       => $sDetalle,

        ]);

        return $this->db->run($sSQL);
    }

    public function fncActualizarPedidoDetalle(
        $nIdDetallePedido,
        $nIdPedido,
        $nIdProducto,
        $nPrecio,
        $nCantidad,
        $sDetalle
    ) {
        $sSQL = $this->db->generateSQLUpdate("pedidosdetalle", [
            "nIdPedido"      => $nIdPedido,
            "nIdProducto"    => $nIdProducto,
            "nPrecio"        => $nPrecio,
            "nCantidad"      => $nCantidad,
            "sDetalle"       => $sDetalle,
        ], "nIdDetallePedido = $nIdDetallePedido");

        return $this->db->run($sSQL);
    }


    public function fncEliminarPedidoDetalleByIdPedido($nIdPedido)
    {
        $sSQL = $this->db->generateSQLDelete("pedidosdetalle", " nIdPedido = $nIdPedido");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarPedidoDetalle($nIdDetallePedido)
    {
        $sSQL = $this->db->generateSQLDelete("pedidosdetalle", " nIdDetallePedido = $nIdDetallePedido");
        return  $this->db->run($sSQL);
    }

    public function fncObtenerPedidosDetalle($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "pd.nIdPedido DESC",
            "sLimit"               => null,
            "nIdDetallePedido"     => null,
            "nIdPedido"            => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "nIdResponsable"       => null,
            "aryIdPedido"          => null,
            "aryProductos"         => null,
            "aryClientes"          => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "dFechaCreacion"       => null,
            "nFacturado"           => null,
            "nIdProducto"          => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);


        $sSQL = "SELECT pd.nIdDetallePedido, 
                        pd.nIdPedido, 
                        UPPER(prod.sDescripcion) AS sProducto, 
                        IFNULL( prod.sImagen , '' )  AS sImagenProducto, 
                        IFNULL( prod.nAcumulaPuntos , 0 )  AS nAcumulaPuntos,
                        IFNULL(emp.sNombre , IFNULL(CONCAT(usu.sNombre,' ',usu.sApellidos),'') ) AS sResponsable,
                        IFNULL( DATE_FORMAT( ped.dFechaCreacion, '%d/%m/%Y' ), '' ) as dFechaCreacion, 
                        IFNULL( unimedida.sNombreLargo ,'' ) AS sUnidadMedida,
                        IFNULL( unimedida.sNombreCorto ,'' ) AS sUnidadMedidaCorto,
                        IFNULL(pd.sDetalle , '') AS sDetalle, 
                        IFNULL(ped.nDescuento , '') AS nDescuento, 
                        IFNULL(ped.nDescuentoCanje , '') AS nDescuentoCanje, 
                        pd.nIdProducto, 
                        pd.nPrecio, 
                        pd.nCantidad
                FROM pedidosdetalle AS pd
                INNER JOIN productos AS prod ON pd.nIdProducto = prod.nIdProducto  
                INNER JOIN pedidos AS ped ON ped.nIdPedido = pd.nIdPedido  
                LEFT JOIN empleados AS emp ON ped.nIdResponsable = emp.nIdEmpleado
                LEFT JOIN usuarios AS usu ON ped.nIdResponsable = usu.nIdUsuario
                LEFT JOIN unidadmedidas AS unimedida ON unimedida.nIdUnidadMedida = prod.nIdUnidadMedida";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdDetallePedido"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pd.nIdDetallePedido = {$this->db->quote($ary['nIdDetallePedido'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdPedido"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pd.nIdPedido = {$this->db->quote($ary['nIdPedido'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdResponsable"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdResponsable = {$this->db->quote($ary['nIdResponsable'])}  ");

        $sWhere .= ($this->db->isNull($ary["dFechaCreacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(ped.dFechaCreacion)  =  STR_TO_DATE( '" . $ary["dFechaCreacion"] . "' , '%d/%m/%Y')");

        $sWhere .= ($this->db->isNull($ary["aryClientes"]) && !is_array($ary["aryClientes"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' ped.nIdCliente IN (' . implode(",", $ary['aryClientes']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryIdPedido"])  && !is_array($ary["aryIdPedido"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' ped.nIdPedido IN (' . implode(",", $ary["aryIdPedido"]) . ')');

        $sWhere .= ($this->db->isNull($ary["aryProductos"])  && !is_array($ary["aryProductos"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' pd.nIdProducto IN (' . implode(",", $ary["aryProductos"]) . ')');

        $sWhere .= ($this->db->isNull($ary["nIdProducto"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pd.nIdProducto = {$this->db->quote($ary['nIdProducto'])}  ");

        $sWhere .= ($this->db->isNull($ary["dFechaInicio"]) && $this->db->isNull($ary["dFechaFin"]) ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(ped.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary["dFechaInicio"] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary["dFechaFin"] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nFacturado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nFacturado = {$this->db->quote($ary['nFacturado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }

    public function fncObtenerPedidosByMes($aryInput)
    {
        $aryAllFilters = [
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "aryIdSede"            => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "dFechaCreacion"       => null,
            "nFacturado"           => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT YEAR(p.dFechaCreacion) AS sAnio,
                        MONTH(p.dFechaCreacion) AS sNumeroMes, 
                        SUM(pd.nPrecio * pd.nCantidad) AS nTotal
                FROM pedidos AS p
                INNER JOIN pedidosdetalle AS pd ON p.nIdPedido = pd.nIdPedido";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdSede"]) && !is_array($ary["aryIdSede"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdSede IN (' . implode(",", $ary['aryIdSede']) . ')');

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(p.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nFacturado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nFacturado = {$this->db->quote($ary['nFacturado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .=  " GROUP BY MONTH(p.dFechaCreacion) , YEAR(p.dFechaCreacion) ";

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncObtenerDataForReportCategorias($aryInput)
    {
        $aryAllFilters = [
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "aryIdSede"            => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "dFechaCreacion"       => null,
            "nFacturado"           => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT UPPER(IFNULL(cat.sNombre,'')) AS sCategoria,
                        SUM(pd.nPrecio * pd.nCantidad) AS nTotal
                FROM pedidos AS p
                INNER JOIN pedidosdetalle AS pd ON p.nIdPedido = pd.nIdPedido
                INNER JOIN productos AS prod ON pd.nIdProducto = prod.nIdProducto
                INNER JOIN categorias AS cat ON prod.nIdCategoria = cat.nIdCategoria";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdSede"]) && !is_array($ary["aryIdSede"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdSede IN (' . implode(",", $ary['aryIdSede']) . ')');

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(p.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nFacturado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nFacturado = {$this->db->quote($ary['nFacturado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .=  " GROUP BY prod.nIdCategoria ORDER BY nTotal DESC LIMIT 5 ";

        // echo ($sSQL);
        // exit;

        return $this->db->run(trim($sSQL));
    }

    public function fncObtenerDataForReportProductos($aryInput)
    {
        $aryAllFilters = [
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "aryIdSede"            => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "dFechaCreacion"       => null,
            "nFacturado"           => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT UPPER(IFNULL(prod.sDescripcion,'')) AS sProducto,
                        SUM(pd.nPrecio * pd.nCantidad) AS nTotal
                FROM pedidos AS p
                INNER JOIN pedidosdetalle AS pd ON p.nIdPedido = pd.nIdPedido
                INNER JOIN productos AS prod ON pd.nIdProducto = prod.nIdProducto";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdSede"]) && !is_array($ary["aryIdSede"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdSede IN (' . implode(",", $ary['aryIdSede']) . ')');

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(p.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nFacturado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nFacturado = {$this->db->quote($ary['nFacturado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .=  " GROUP BY prod.nIdProducto ORDER BY nTotal DESC LIMIT 5  ";

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }

    public function fncObtenerDataForReportClientes($aryInput)
    {
        $aryAllFilters = [
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "aryIdSede"            => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "dFechaCreacion"       => null,
            "nFacturado"           => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT UPPER(IFNULL(cli.sNombreoRazonSocial,'')) AS sCliente,           
                        SUM(pd.nPrecio * pd.nCantidad) AS nTotal
                FROM pedidos AS p
                INNER JOIN pedidosdetalle AS pd ON p.nIdPedido = pd.nIdPedido
                INNER JOIN clientes AS cli ON p.nIdCliente = cli.nIdCliente";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdSede"]) && !is_array($ary["aryIdSede"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdSede IN (' . implode(",", $ary['aryIdSede']) . ')');

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(p.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nFacturado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nFacturado = {$this->db->quote($ary['nFacturado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .=  " GROUP BY cli.nIdCliente ORDER BY nTotal DESC LIMIT 5  ";

        return $this->db->run(trim($sSQL));
    }



    public function fncActualizarEstado(
        $nIdPedido,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLUpdate("pedidos", [
            "nEstado"    => $nEstado,
        ], "nIdPedido = $nIdPedido");

        return $this->db->run($sSQL);
    }

    public function fncActualizarPuntosAcumulados($nIdPedido, $nPuntosAcumuladosItem)
    {
        $sSQL = $this->db->generateSQLUpdate("pedidos", ["nPuntosAcumuladosItem"    => $nPuntosAcumuladosItem,], "nIdPedido = $nIdPedido");
        return $this->db->run($sSQL);
    }

    public function fncObtenerPedidosQueAcumulanPuntosPorcliente($nIdCliente)
    {
        $sSQL = "SELECT nIdPedido FROM pedidos WHERE nIdCliente = $nIdCliente  AND nPuntosAcumuladosItem > 0";
        return $this->db->run($sSQL);
    }


    public function fncObtenerReportePuntosCanjeados($aryInput = [])
    {
        $aryAllFilters = [

            "aryClientes"        => null,
            "nPuntosCanje"       => null,
            "nTienePuntosCanje"  => null,
            "nEstado"            => null,
            "sOrderBy"           => null,
            "sLimit"             => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        IFNULL(cli.sNombreoRazonSocial , '' ) AS sCliente,
                        COUNT(p.nIdPedido) AS nVentas,
                        SUM(p.nPuntosCanje) AS nPuntosCanje,
                        SUM(p.nDescuentoCanje) AS nDescuentoCanje                
                FROM pedidos AS p
                LEFT JOIN pedidosdetalle AS pd ON p.nIdPedido = pd.nIdPedido
                LEFT JOIN clientes AS cli ON p.nIdCliente = cli.nIdCliente ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nTienePuntosCanje"]) && !is_array($ary["nTienePuntosCanje"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . " p.nPuntosCanje " . $ary['nTienePuntosCanje']);

        $sWhere .= ($this->db->isNull($ary["aryClientes"]) && !is_array($ary["aryClientes"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' p.nIdCliente IN (' . implode(",", $ary['aryClientes']) . ')');

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= '  GROUP by p.nidCliente ';

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncObtenerResponsables($nIdSede)
    {


        $sSQL = "SELECT 
                        p.nIdResponsable, 
                        IFNULL(emp.sNombre , IFNULL(CONCAT(usu.sNombre,' ',usu.sApellidos),'') ) AS sResponsable
                FROM pedidos AS p
                LEFT JOIN empleados AS emp ON p.nIdResponsable = emp.nIdEmpleado
                LEFT JOIN usuarios AS usu ON p.nIdResponsable = usu.nIdUsuario 
                WHERE p.nEstado = 1 AND p.nIdSede  = $nIdSede GROUP BY p.nIdResponsable  ";

        return $this->db->run(trim($sSQL));
    }


    public function fncGrabarPedidoCuota(
        $nIdPedido,
        $nAdelanto,
        $nCuotas,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("pedidoscuotas", [
            "nIdPedido"     => $nIdPedido,
            "nAdelanto"     => $nAdelanto,
            "nCuotas"       => $nCuotas,
            "nEstado"       => $nEstado,
        ]);

        return $this->db->run($sSQL);
    }



    public function fncActualizarPedidoCuota(
        $nIdPedidoCuota,
        $nIdPedido,
        $nAdelanto,
        $nCuotas,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("pedidoscuotas", [
            "nIdPedido"      => $nIdPedido,
            "nAdelanto"      => $nAdelanto,
            "nCuotas"        => $nCuotas,
            "nEstado"        => $nEstado,
        ], "  nIdPedidoCuota = $nIdPedidoCuota  ");

        return $this->db->run($sSQL);
    }

    public function fncEliminarPedidoCuotaDetalleByIdPedidoCuota($nIdPedidoCuota)
    {
        $sSQL = $this->db->generateSQLDelete("pedidoscuotasdetalle", " nIdPedidoCuota = $nIdPedidoCuota");
        return  $this->db->run($sSQL);
    }

    public function fncObtenerPedidoCuotas($aryInput = [])
    {
        $aryAllFilters = [
            "nIdPedidoCuota"      => null,
            "nIdPedido"           => null,
            "nEstado"             => null,
            "sOrderBy"            => null,
            "sLimit"              => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        
                    pc.nIdPedidoCuota,
                    pc.nIdPedido,
                    pc.nAdelanto,
                    pc.nCuotas,
                    pc.nEstado
                FROM pedidoscuotas AS pc";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdPedidoCuota"]) && !is_array($ary["nIdPedidoCuota"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . " pc.nIdPedidoCuota =  {$this->db->quote($ary['nIdPedidoCuota'])} ");

        $sWhere .= ($this->db->isNull($ary["nIdPedido"]) && !is_array($ary["nIdPedido"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . " pc.nIdPedido =  {$this->db->quote($ary['nIdPedido'])} ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pedct.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }




    public function fncGrabarPedidoCuotaDetalle(
        $nIdPedidoCuota,
        $nNumeroCuota,
        $nMontoCuota,
        $nIdMetodoPago,
        $nEstadoPago,
        $dFechaPago,
        $dFechaVencimiento,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("pedidoscuotasdetalle", [
            "nIdPedidoCuota"    => $nIdPedidoCuota,
            "nNumeroCuota"      => $nNumeroCuota,
            "nMontoCuota"       => $nMontoCuota,
            "nIdMetodoPago"     => $nIdMetodoPago,
            "nEstadoPago"       => $nEstadoPago,
            "dFechaPago"        => (strlen($dFechaPago)  === 0 ? NULL : "STR_TO_DATE( '$dFechaPago', '%d/%m/%Y' )"),
            "dFechaVencimiento" => (strlen($dFechaVencimiento) ===  0 ? NULL : "STR_TO_DATE( '$dFechaVencimiento', '%d/%m/%Y' ) "),
            "nEstado"           => $nEstado,
        ]);


        return $this->db->run($sSQL);
    }



    public function fncActualizarPedidoCuotaDetalle(
        $nIdPedidoCuotaDetalle,
        $nIdPedidoCuota,
        $nNumeroCuota,
        $nMontoCuota,
        $nIdMetodoPago,
        $nEstadoPago,
        $dFechaPago,
        $dFechaVencimiento,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("pedidoscuotasdetalle", [
            "nIdPedidoCuota"    => $nIdPedidoCuota,
            "nNumeroCuota"      => $nNumeroCuota,
            "nMontoCuota"       => $nMontoCuota,
            "nIdMetodoPago"     => $nIdMetodoPago,
            "nEstadoPago"       => $nEstadoPago,
            "dFechaPago"        => $dFechaPago == '' ? NULL : "STR_TO_DATE( '$dFechaPago', '%d/%m/%Y' ) ",
            "dFechaVencimiento" => $dFechaVencimiento == '' ? NULL : "STR_TO_DATE( '$dFechaVencimiento', '%d/%m/%Y' ) ",
            "nEstado"           => $nEstado,
        ], "nIdPedidoCuotaDetalle = $nIdPedidoCuotaDetalle");

        return $this->db->run($sSQL);
    }



    public function fncObtenerPedidoCuotasDetalle($aryInput = [])
    {
        $aryAllFilters = [
            "nIdPedidoCuotaDetalle"      => null,
            "nIdPedidoCuota"             => null,
            "nEstado"                    => null,
            "sOrderBy"                   => null,
            "nEstadoPago"                => null,
            "nIdMetodoPago"              => null,
            "sLimit"                     => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        pedct.nIdPedidoCuotaDetalle,
                        pedct.nIdPedidoCuota,
                        pedct.nNumeroCuota,
                        pedct.nMontoCuota,
                        pedct.nIdMetodoPago,
                        pedct.nEstadoPago,
                        IFNULL( DATE_FORMAT( pedct.dFechaPago, '%d/%m/%Y' ), '' ) as dFechaPago, 
                        IFNULL( DATE_FORMAT( pedct.dFechaVencimiento, '%d/%m/%Y' ), '' ) as dFechaVencimiento,
                        pedct.nEstado
                FROM pedidoscuotasdetalle AS pedct";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdPedidoCuotaDetalle"]) && !is_array($ary["nIdPedidoCuotaDetalle"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . " pedct.nIdPedidoCuotaDetalle =  {$this->db->quote($ary['nIdPedidoCuotaDetalle'])} ");

        $sWhere .= ($this->db->isNull($ary["nIdPedidoCuota"]) && !is_array($ary["nIdPedidoCuota"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . " pedct.nIdPedidoCuota =  {$this->db->quote($ary['nIdPedidoCuota'])} ");

        $sWhere .= ($this->db->isNull($ary["nEstadoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pedct.nEstadoPago = {$this->db->quote($ary['nEstadoPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdMetodoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pedct.nIdMetodoPago = {$this->db->quote($ary['nIdMetodoPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pedct.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }

    public function fncActualizarEstadoPago(
        $nIdPedido,
        $nEstadoPago
    ) {
        $sSQL = $this->db->generateSQLUpdate("pedidos", [
            "nEstadoPago"    => $nEstadoPago,
        ], "nIdPedido = $nIdPedido");

        return $this->db->run($sSQL);
    }
}
