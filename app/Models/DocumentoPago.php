<?php

namespace Application\Models;

use Application\Core\Database as Database;

class DocumentoPago
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdProveedor,
        $nIdEmpresa,
        $nIdSede,
        $nIdOrdenCompra,
        $nIdTipoDocumento,
        $sNumero,
        $dFecha,
        $dVencimiento,
        $dPeriodo,
        $nCondicionPago,
        $nPorcentajeIGV,
        $nPorcentajeDsct,
        $nTotalDsct,
        $nSubTotal,
        $nIgv,
        $nTotal,
        $nPagoPendiente,
        $nEstadoPago,
        $sComentario,
        $nTipoMoneda,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLInsert("documentopago", [
            "nIdProveedor"                  => $nIdProveedor,
            "nIdEmpresa"                    => $nIdEmpresa,
            "nIdSede"                       => $nIdSede,
            "nIdOrdenCompra"                => $nIdOrdenCompra == 0 ? null : $nIdOrdenCompra,
            "nIdTipoDocumento"              => $nIdTipoDocumento,
            "sNumero"                       => $sNumero,
            "dFecha"                        => "STR_TO_DATE( '$dFecha', '%d/%m/%Y' ) ",
            "dVencimiento"                  => "STR_TO_DATE( '$dVencimiento', '%d/%m/%Y' ) ",
            "dPeriodo"                      => "STR_TO_DATE( '$dPeriodo', '%d/%m/%Y' ) ",
            "nEstadoPago"                   => $nEstadoPago,
            "dFechaRegistro"                => "NOW()",
            "nCondicionPago"                => $nCondicionPago,
            "nPorcentajeDsct"               => $nPorcentajeDsct,
            "nPorcentajeIGV"                => $nPorcentajeIGV,
            "nTotalDsct"                    => $nTotalDsct,
            "nSubTotal"                     => $nSubTotal,
            "nIgv"                          => $nIgv,
            "nTotal"                        => $nTotal,
            "nPagoPendiente"                => $nPagoPendiente,
            "sComentario"                   => $sComentario,
            "nTipoMoneda"                   => $nTipoMoneda,
            "nEstado"                       => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarRegistro(
        $nIdDocumentosPago,
        $nIdProveedor,
        $nIdEmpresa,
        $nIdSede,
        $nIdOrdenCompra,
        $nIdTipoDocumento,
        $sNumero,
        $dFecha,
        $dVencimiento,
        $dPeriodo,
        $nCondicionPago,
        $nPorcentajeIGV,
        $nPorcentajeDsct,
        $nTotalDsct,
        $nSubTotal,
        $nIgv,
        $nTotal,
        $nPagoPendiente,
        $nEstadoPago,
        $sComentario,
        $nTipoMoneda,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLUpdate("documentopago", [
            "nIdProveedor"                  => $nIdProveedor,
            "nIdEmpresa"                    => $nIdEmpresa,
            "nIdSede"                       => $nIdSede,
            "nIdOrdenCompra"                => $nIdOrdenCompra,
            "nIdTipoDocumento"              => $nIdTipoDocumento,
            "sNumero"                       => $sNumero,
            "dFecha"                        => "STR_TO_DATE( '$dFecha', '%d/%m/%Y' ) ",
            "dVencimiento"                  => "STR_TO_DATE( '$dVencimiento', '%d/%m/%Y' ) ",
            "dPeriodo"                      => "STR_TO_DATE( '$dPeriodo', '%d/%m/%Y' ) ",
            "nEstadoPago"                   => $nEstadoPago,
            "nCondicionPago"                => $nCondicionPago,
            "nPorcentajeDsct"               => $nPorcentajeDsct,
            "nPorcentajeIGV"                => $nPorcentajeIGV,
            "nTotalDsct"                    => $nTotalDsct,
            "nSubTotal"                     => $nSubTotal,
            "nIgv"                          => $nIgv,
            "nTotal"                        => $nTotal,
            "nPagoPendiente"                => $nPagoPendiente,
            "sComentario"                   => $sComentario,
            "nTipoMoneda"                   => $nTipoMoneda,
            "nEstado"                       => $nEstado,
        ], "nIdDocumentosPago = $nIdDocumentosPago");

        // echo $sSQL;
        // exit;
        return  $this->db->run($sSQL);
    }


    public function fncActualizarEstadoPago(
        $nIdDocumentosPago,
        $nEstadoPago
    ) {
        $sSQL = $this->db->generateSQLUpdate("documentopago", [
            "nEstadoPago"   => $nEstadoPago,
        ], "nIdDocumentosPago = $nIdDocumentosPago");

        // echo $sSQL;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarPagoPendiente(
        $nIdDocumentosPago,
        $nPagoPendiente
    ) {
        $sSQL = $this->db->generateSQLUpdate("documentopago", ["nPagoPendiente"   => $nPagoPendiente], "nIdDocumentosPago = $nIdDocumentosPago");
        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdDocumentosPago)
    {
        $sSQL = $this->db->generateSQLDelete("documentopago", "nIdDocumentosPago = $nIdDocumentosPago");
        return $this->db->run($sSQL);
    }


    public function fncObtenerDocumentosPagos($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"               => "dp.nIdDocumentosPago DESC",
            "sLimit"                 => null,
            "nIdDocumentosPago"      => null,
            "nIdEmpresa"             => null,
            "nIdSede"                => null,
            "nEstadoPago"            => null,

            "dFechaInicio"           => null,
            "dFechaFin"              => null,
            "dFechaCreacion"         => null,
            "dFechaRegistro"         => null,
            "nCondicionPago"         => null,
            "nIdTipoDocumento"       => null,
            "sNumero"                => null,

            "nEstado"                => null,
            "nIdMetodoPago"          => null

        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        dp.nIdDocumentosPago,
                        dp.nIdEmpresa,
                        dp.nIdSede,
                        IFNULL(dp.nIdProveedor,0) AS nIdProveedor ,
                        IFNULL(dp.nIdOrdenCompra,0) AS nIdOrdenCompra,

                        IFNULL(oc.sDescripcion,'') AS sDescripcionOrdenCompra,

                        dp.nIdTipoDocumento,
                        dp.sNumero,
                        IFNULL( DATE_FORMAT( dp.dFechaRegistro, '%d/%m/%Y' ), '' ) AS dFechaRegistro,  
                        IFNULL( DATE_FORMAT( dp.dFecha, '%d/%m/%Y' ), '' ) AS dFecha,  
                        IFNULL( DATE_FORMAT( dp.dVencimiento, '%d/%m/%Y' ), '' ) AS dVencimiento,  
                        IFNULL( DATE_FORMAT( dp.dPeriodo, '%d/%m/%Y' ), '' ) AS dPeriodo,  
                        IFNULL( pro.sNombreoRazonSocial , '') AS sProveedor ,
                        IFNULL( tipodoc.sDescripcionCortaItem  , '') AS sTipoDoc,
                        dp.nCondicionPago,
                        (CASE WHEN nCondicionPago = 1 THEN 'CONTADO' ELSE 'PARCIAL' END) AS sCondicionPago,
                        dp.nPorcentajeIGV,
                        IFNULL(dp.nPorcentajeDsct,0) AS nPorcentajeDsct,
                        dp.nTotalDsct,
                        dp.nSubTotal,
                        dp.nIgv,
                        dp.nTotal,
                        dp.nPagoPendiente,
                        dp.nEstadoPago,
                        dp.sComentario,
                        dp.nTipoMoneda,
                        dp.nEstado
                FROM documentopago AS dp
                LEFT JOIN proveedores AS pro ON pro.nIdProveedor = dp.nIdProveedor
                LEFT JOIN ordencompra AS oc ON oc.nIdOrdenCompra = dp.nIdOrdenCompra
                LEFT JOIN catalogotabla AS tipodoc ON tipodoc.nIdCatalogoTabla = dp.nIdTipoDocumento

                ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdDocumentosPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nIdDocumentosPago = {$this->db->quote($ary['nIdDocumentosPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdTipoDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nIdTipoDocumento = {$this->db->quote($ary['nIdTipoDocumento'])}  ");
       
        $sWhere .= ($this->db->isNull($ary["sNumero"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.sNumero LIKE '%" . $ary['sNumero'] . "%' ");

        $sWhere .= ($this->db->isNull($ary["nEstadoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nEstadoPago = {$this->db->quote($ary['nEstadoPago'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(dp.dFechaRegistro)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["dFechaRegistro"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(dp.dFechaRegistro) =  STR_TO_DATE( '" . $ary['dFechaRegistro'] . "', '%d/%m/%Y' )  ");

        $sWhere .= ($this->db->isNull($ary["nCondicionPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nCondicionPago = {$this->db->quote($ary['nCondicionPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= '  GROUP by dp.nIdDocumentosPago ';

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncGrabarRegistroDetalle(
        $nIdDocumentosPago,
        $nIdProducto,
        $nPrecio,
        $nCantidad
    ) {

        $sSQL = $this->db->generateSQLInsert("documentopagodetalle", [
            "nIdDocumentosPago"      => $nIdDocumentosPago,
            "nIdProducto"            => $nIdProducto,
            "nPrecio"                => $nPrecio,
            "nCantidad"              => $nCantidad,
        ]);

        return $this->db->run($sSQL);
    }


    public function fncActualizarRegistroDetalle(
        $nIdDocumentoDetalle,
        $nIdDocumentosPago,
        $nIdProducto,
        $nPrecio,
        $nCantidad
    ) {

        $sSQL = $this->db->generateSQLUpdate("documentopagodetalle", [
            "nIdDocumentosPago"      => $nIdDocumentosPago,
            "nIdProducto"            => $nIdProducto,
            "nPrecio"                => $nPrecio,
            "nCantidad"              => $nCantidad,
        ], "nIdDocumentoDetalle = $nIdDocumentoDetalle");

        return $this->db->run($sSQL);
    }


    public function fncEliminarRegistroDetalleByIdDocumentoPago($nIdDocumentosPago)
    {
        $sSQL = $this->db->generateSQLDelete("documentopagodetalle", " nIdDocumentosPago = $nIdDocumentosPago");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarDPDetalle($nIdDocumentoDetalle)
    {
        $sSQL = $this->db->generateSQLDelete("documentopagodetalle", " nIdDocumentoDetalle = $nIdDocumentoDetalle");
        return  $this->db->run($sSQL);
    }

    public function fncObtenerDocumentosPagosDetalle($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"                => "dpd.nIdDocumentoDetalle DESC",
            "sLimit"                  => null,
            "nIdDocumentoDetalle"     => null,
            "nIdDocumentosPago"       => null,
            "nIdEmpresa"              => null,
            "nIdSede"                 => null,
            "dFechaInicio"            => null,
            "dFechaFin"               => null,

        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);


        $sSQL = "SELECT   
                        dpd.nIdDocumentoDetalle,
                        dpd.nIdDocumentosPago,
                        dpd.nIdProducto,
                        dpd.nPrecio,
                        dpd.nCantidad,
                        UPPER(prod.sDescripcion) AS sProducto, 
                        IFNULL( prod.sImagen , '' )  AS sImagenProducto, 
                        IFNULL( DATE_FORMAT( dp.dFechaRegistro, '%d/%m/%Y' ), '' ) as dFechaRegistro, 
                        IFNULL( unimedida.sNombreLargo ,'' ) AS sUnidadMedida,
                        IFNULL( unimedida.sNombreCorto ,'' ) AS sUnidadMedidaCorto
                FROM documentopagodetalle AS dpd
                INNER JOIN productos AS prod ON dpd.nIdProducto = prod.nIdProducto  
                INNER JOIN documentopago AS dp ON dp.nIdDocumentosPago = dpd.nIdDocumentosPago  
                LEFT JOIN unidadmedidas AS unimedida ON unimedida.nIdUnidadMedida = prod.nIdUnidadMedida";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdDocumentoDetalle"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dpd.nIdDocumentoDetalle = {$this->db->quote($ary['nIdDocumentoDetalle'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdDocumentosPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dpd.nIdDocumentosPago = {$this->db->quote($ary['nIdDocumentosPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " dp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["dFechaInicio"]) && $this->db->isNull($ary["dFechaFin"]) ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(dp.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary["dFechaInicio"] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary["dFechaFin"] . "', '%d/%m/%Y' )");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
