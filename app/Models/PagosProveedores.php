<?php

namespace Application\Models;

use Application\Core\Database as Database;

class PagosProveedores
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $nIdProveedor,
        $sDescripcion,
        $dFechaPago,
        $nIdCuentaCorriente,
        $nIdMetodoPago,
        $nTotal,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLInsert("pagosproveedores", [
            "nIdEmpresa"                    => $nIdEmpresa,
            "nIdSede"                       => $nIdSede,
            "nIdProveedor"                  => $nIdProveedor,
            "sDescripcion"                  => $sDescripcion,
            "dFechaRegistro"                => "NOW()",
            "dFechaPago"                    => "STR_TO_DATE( '$dFechaPago', '%d/%m/%Y' ) ",
            "nIdCuentaCorriente"            => $nIdCuentaCorriente,
            "nIdMetodoPago"                 => $nIdMetodoPago,
            "nTotal"                        => $nTotal,
            "nEstado"                       => $nEstado,
        ]);

        return $this->db->run($sSQL);
    }

    public function fncActualizarRegistro(
        $nIdPagoProveedor,
        $nIdEmpresa,
        $nIdSede,
        $nIdProveedor,
        $sDescripcion,
        $dFechaPago,
        $nIdCuentaCorriente,
        $nIdMetodoPago,
        $nTotal,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLUpdate("pagosproveedores", [
            "nIdEmpresa"                    => $nIdEmpresa,
            "nIdSede"                       => $nIdSede,
            "nIdProveedor"                  => $nIdProveedor,
            "sDescripcion"                  => $sDescripcion,
            "dFechaPago"                    => "STR_TO_DATE( '$dFechaPago', '%d/%m/%Y' ) ",
            "nIdCuentaCorriente"            => $nIdCuentaCorriente,
            "nIdMetodoPago"                 => $nIdMetodoPago,
            "nTotal"                        => $nTotal,
            "nEstado"                       => $nEstado,
        ], "nIdPagoProveedor = $nIdPagoProveedor");

        // echo $sSQL;
        // exit;
        return  $this->db->run($sSQL);
    }



    public function fncEliminarRegistro($nIdPagoProveedor)
    {
        $sSQL = $this->db->generateSQLDelete("pagosproveedores", "nIdPagoProveedor = $nIdPagoProveedor");
        return $this->db->run($sSQL);
    }


    public function fncObtenerPagosProveedores($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"               => "pp.nIdPagoProveedor DESC",
            "sLimit"                 => null,
            "nIdPagoProveedor"       => null,
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
            "nIdMetodoPago"          => null,
            "nIdProveedor"          => null,


        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        pp.nIdPagoProveedor,
                        pp.nIdEmpresa,
                        pp.nIdSede,
                        pp.sDescripcion,
                        IFNULL( DATE_FORMAT( pp.dFechaRegistro, '%d/%m/%Y' ), '' ) AS dFechaRegistro,  
                        IFNULL( DATE_FORMAT( pp.dFechaPago, '%d/%m/%Y' ), '' ) AS dFechaPago,
                        IFNULL( pro.sNombreoRazonSocial , '' ) AS sProveedor,
                        UPPER(mp.sNombre) AS sMetodoPago,
                        UPPER(cc.sPropietario) AS sPropietarioCC ,
                        cc.sNumero AS sNumeroCC,
                        cc.sNumero AS sNumeroCC,
                        tc.sNombre AS sTipoCuentaCC,
                        b.sNombre AS sBancoCC,
                        IFNULL((SELECT COUNT(*) FROM pagosproveedoresdetalle AS ppd WHERE ppd.nIdPagoProveedor = pp.nIdPagoProveedor LIMIT 1 ) ,0) AS nCantidadDocs,
                        pp.nIdProveedor,
                        pp.nIdCuentaCorriente,
                        pp.nIdMetodoPago,
                        pp.nTotal,
                        pp.nEstado
                FROM pagosproveedores AS pp
                LEFT JOIN proveedores AS pro ON pro.nIdProveedor = pp.nIdProveedor
                LEFT JOIN metodospago AS mp ON mp.nIdMetodoPago = pp.nIdMetodoPago
                LEFT JOIN cuentascorrientes AS cc ON cc.nIdCuentaCorriente = pp.nIdCuentaCorriente
                LEFT JOIN tiposcuentas AS tc ON cc.nIdTipoCuenta = tc.nIdTipoCuenta
                LEFT JOIN bancos AS b ON cc.nIdBanco = b.nIdBanco

                ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdPagoProveedor"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pp.nIdPagoProveedor = {$this->db->quote($ary['nIdPagoProveedor'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdProveedor"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pp.nIdProveedor = {$this->db->quote($ary['nIdProveedor'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(pp.dFechaRegistro)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= '  GROUP BY pp.nIdPagoProveedor ';

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncGrabarRegistroDetalle(
        $nIdPagoProveedor,
        $nIdDocumentosPago,
        $nTotal
    ) {

        $sSQL = $this->db->generateSQLInsert("pagosproveedoresdetalle", [
            "nIdPagoProveedor"     => $nIdPagoProveedor,
            "nIdDocumentosPago"    => $nIdDocumentosPago,
            "nTotal"               => $nTotal,
        ]);

        return $this->db->run($sSQL);
    }

  
    public function fncEliminarRegistroDetalleByIdPagoProveedor($nIdPagoProveedor)
    {
        $sSQL = $this->db->generateSQLDelete("pagosproveedoresdetalle", " nIdPagoProveedor = $nIdPagoProveedor");
        return  $this->db->run($sSQL);
    }


    public function fncObtenerPagosProveedoresDetalle($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"                => "ppd.nIdPagoProveedorDetalle DESC",
            "sLimit"                  => null,
            "nIdDocumentoDetalle"     => null,
            "nIdPagoProveedorDetalle" => null,
            "nIdDocumentosPago"       => null,
            "nIdPagoProveedor"        => null,
            "nIdEmpresa"              => null,
            "nIdSede"                 => null,
            "dFechaInicio"            => null,
            "dFechaFin"               => null,

        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);


        $sSQL = "SELECT   
                    ppd.nIdPagoProveedorDetalle,
                    ppd.nIdPagoProveedor,
                    ppd.nIdDocumentosPago,
                    ppd.nTotal,

                    IFNULL( DATE_FORMAT( dp.dFecha, '%d/%m/%Y' ), '' ) AS dFecha,  
                    IFNULL( DATE_FORMAT( dp.dVencimiento, '%d/%m/%Y' ), '' ) AS dVencimiento,  
                    IFNULL( DATE_FORMAT( dp.dPeriodo, '%d/%m/%Y' ), '' ) AS dPeriodo,  

                    dp.sNumero,
                    IFNULL( pro.sNombreoRazonSocial , '') AS sProveedor ,
                    IFNULL( tipodoc.sDescripcionCortaItem  , '') AS sTipoDoc

                FROM pagosproveedoresdetalle AS ppd
                INNER JOIN pagosproveedores AS pp ON pp.nIdPagoProveedor = ppd.nIdPagoProveedor

                LEFT JOIN documentopago AS dp ON dp.nIdDocumentosPago = ppd.nIdDocumentosPago
                LEFT JOIN proveedores AS pro ON pro.nIdProveedor = dp.nIdProveedor
                LEFT JOIN ordencompra AS oc ON oc.nIdOrdenCompra = dp.nIdOrdenCompra
                LEFT JOIN catalogotabla AS tipodoc ON tipodoc.nIdCatalogoTabla = dp.nIdTipoDocumento";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdPagoProveedorDetalle"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ppd.nIdPagoProveedorDetalle = {$this->db->quote($ary['nIdPagoProveedorDetalle'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdDocumentosPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ppd.nIdDocumentosPago = {$this->db->quote($ary['nIdDocumentosPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdPagoProveedor"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ppd.nIdPagoProveedor = {$this->db->quote($ary['nIdPagoProveedor'])}  ");
        
        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["dFechaInicio"]) && $this->db->isNull($ary["dFechaFin"]) ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(pp.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary["dFechaInicio"] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary["dFechaFin"] . "', '%d/%m/%Y' )");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
