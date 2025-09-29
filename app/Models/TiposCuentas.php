<?php

namespace Application\Models;

use Application\Core\Database as Database;

class TiposCuentas
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sDescripcion,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("tiposcuentas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sDescripcion"          => $sDescripcion,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $nIdTipoCuenta ,
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sDescripcion,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("tiposcuentas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sDescripcion"          => $sDescripcion,
            "nEstado"               => $nEstado,
        ], " nIdTipoCuenta = $nIdTipoCuenta ");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdTipoCuenta )
    {
        $sSQL = $this->db->generateSQLDelete("tiposcuentas", " nIdTipoCuenta  = $nIdTipoCuenta  ");
        $this->db->run($sSQL);
    }


    public function fncGetTipoCuenta($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => "tc.nIdTipoCuenta DESC",
            "sLimit"             => null,
            "nIdTipoCuenta"      => null,
            "nIdEmpresa"         => null,
            "nIdSede"            => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                       tc.nIdTipoCuenta ,
                       tc.nIdEmpresa,
                       tc.nIdSede,
                       tc.sNombre,
                       tc.sDescripcion,
                       tc.nEstado
                FROM tiposcuentas AS tc";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdTipoCuenta"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " tc.nIdTipoCuenta  = {$this->db->quote($ary['nIdTipoCuenta'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " tc.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " tc.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " tc.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
