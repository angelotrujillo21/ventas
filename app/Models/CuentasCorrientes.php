<?php

namespace Application\Models;

use Application\Core\Database as Database;

class CuentasCorrientes
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdBanco,
        $sPropietario,
        $sNumero,
        $nIdTipoCuenta,
        $nSaldoActual,

        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("cuentascorrientes", [
            "nIdBanco"             => $nIdBanco,
            "sPropietario"         => $sPropietario,
            "sNumero"              => $sNumero,
            "nIdTipoCuenta"        => $nIdTipoCuenta,
            "nSaldoActual"         => $nSaldoActual,
            "nEstado"              => $nEstado,
        ]);

        return $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $nIdCuentaCorriente,
        $nIdBanco,
        $sPropietario,
        $sNumero,
        $nIdTipoCuenta,
        $nSaldoActual,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("cuentascorrientes", [
            "nIdBanco"             => $nIdBanco,
            "sPropietario"         => $sPropietario,
            "sNumero"              => $sNumero,
            "nIdTipoCuenta"        => $nIdTipoCuenta,
            "nSaldoActual"         => $nSaldoActual,
            "nEstado"              => $nEstado,
        ], "nIdCuentaCorriente = $nIdCuentaCorriente");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdCuentaCorriente)
    {
        $sSQL = $this->db->generateSQLDelete("cuentascorrientes", " nIdCuentaCorriente = $nIdCuentaCorriente ");
        $this->db->run($sSQL);
    }


    public function fncGetCuentasCorrientes($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => "cc.nIdCuentaCorriente DESC",
            "sLimit"             => null,
            "nIdCuentaCorriente" => null,
            "nIdEmpresa"         => null,
            "nIdSede"            => null,
            "nIdBanco"           => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                    cc.nIdCuentaCorriente,
                    cc.nIdBanco,
                    cc.sNumero,
                    cc.nIdTipoCuenta,
                    IFNULL(b.sNombre,'') AS sBanco,
                    IFNULL(tc.sNombre,'') AS sTipoCuenta,
                    UPPER(cc.sPropietario) AS sPropietario,
                    cc.nSaldoActual,
                    cc.nEstado
                FROM cuentascorrientes AS cc
                INNER JOIN bancos AS b ON cc.nIdBanco = b.nIdBanco
                INNER JOIN tiposcuentas AS tc ON cc.nIdTipoCuenta = tc.nIdTipoCuenta";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCuentaCorriente"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cc.nIdCuentaCorriente = {$this->db->quote($ary['nIdCuentaCorriente'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdBanco"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cc.nIdBanco = {$this->db->quote($ary['nIdBanco'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cc.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }


    public function fncGrabarCCMP(
        $nIdEmpresa,
        $nIdSede,
        $nIdCuentaCorriente,
        $nIdMetodoPago,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("cuentascorrientesmetodospago", [
            "nIdEmpresa"             => $nIdEmpresa,
            "nIdSede"                => $nIdSede,
            "nIdCuentaCorriente"     => $nIdCuentaCorriente,
            "nIdMetodoPago"          => $nIdMetodoPago,
            "nEstado"                => $nEstado,
        ]);

        return $this->db->run($sSQL);
    }


    public function fncActualizarCCMP(
        $nIdCuentaCorrienteMP,
        $nIdEmpresa,
        $nIdSede,
        $nIdCuentaCorriente,
        $nIdMetodoPago,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("cuentascorrientesmetodospago", [
            "nIdEmpresa"             => $nIdEmpresa,
            "nIdSede"                => $nIdSede,
            "nIdCuentaCorriente"     => $nIdCuentaCorriente,
            "nIdMetodoPago"          => $nIdMetodoPago,
            "nEstado"                => $nEstado,
        ], "nIdCuentaCorrienteMP = $nIdCuentaCorrienteMP");

        return $this->db->run($sSQL);
    }




    public function fncGetCCMP($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"             => "ccmp.nIdCuentaCorrienteMP DESC",
            "sLimit"               => null,
            "nIdCuentaCorrienteMP" => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "nIdMetodoPago"        => null,
            "nEstado"              => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        ccmp.nIdCuentaCorrienteMP,
                        ccmp.nIdEmpresa,
                        ccmp.nIdSede,
                        ccmp.nIdCuentaCorriente,
                        ccmp.nIdMetodoPago,
                        ccmp.nEstado,
                        cc.sNumero AS sNumeroCC,
                        cc.sPropietario AS sPropietario,
                        tc.sNombre AS sTipoCuenta,
                        b.sNombre AS sBanco,
                        UPPER(mp.sNombre) AS sMetodoPago
                FROM cuentascorrientesmetodospago AS ccmp
                INNER JOIN cuentascorrientes AS cc ON cc.nIdCuentaCorriente = ccmp.nIdCuentaCorriente
                INNER JOIN bancos AS b ON cc.nIdBanco = b.nIdBanco
                INNER JOIN tiposcuentas AS tc ON cc.nIdTipoCuenta = tc.nIdTipoCuenta
                INNER JOIN metodospago AS mp ON ccmp.nIdMetodoPago = mp.nIdMetodoPago";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCuentaCorrienteMP"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ccmp.nIdCuentaCorrienteMP = {$this->db->quote($ary['nIdCuentaCorrienteMP'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ccmp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ccmp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdMetodoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ccmp.nIdMetodoPago = {$this->db->quote($ary['nIdMetodoPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ccmp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }


    public function fncEliminarCMMP($nIdCuentaCorrienteMP)
    {
        $sSQL = $this->db->generateSQLDelete("cuentascorrientesmetodospago", " nIdCuentaCorrienteMP = $nIdCuentaCorrienteMP ");
        $this->db->run($sSQL);
    }


    public function fncActualizarSaldo(
        $nIdCuentaCorriente,
        $nSaldoActual
    ) {

        $sSQL = $this->db->generateSQLUpdate("cuentascorrientes", [
            "nSaldoActual"  => $nSaldoActual,

        ], "nIdCuentaCorriente = $nIdCuentaCorriente");

        return  $this->db->run($sSQL);
    }
}
