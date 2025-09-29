<?php

namespace Application\Models;

use Application\Core\Database as Database;

class CondicionComercial
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
        $sTiempoEntrega,
        $sFormaPago,
        $sLugarEntrega,
        $sGarantia,
        $sValidezOferta,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("condicioncomercial", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sTiempoEntrega"        => $sTiempoEntrega,
            "sFormaPago"            => $sFormaPago,
            "sLugarEntrega"         => $sLugarEntrega,
            "sGarantia"             => $sGarantia,
            "sValidezOferta"        => $sValidezOferta,
            "nEstado"               => $nEstado
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarRegistro(
        $nIdCondicionComercial,
        $sNombre,
        $sTiempoEntrega,
        $sFormaPago,
        $sLugarEntrega,
        $sGarantia,
        $sValidezOferta,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("condicioncomercial", [
            "sNombre"               => $sNombre,
            "sTiempoEntrega"        => $sTiempoEntrega,
            "sFormaPago"            => $sFormaPago,
            "sLugarEntrega"         => $sLugarEntrega,
            "sGarantia"             => $sGarantia,
            "sValidezOferta"        => $sValidezOferta,
            "nEstado"               => $nEstado
        ], "nIdCondicionComercial = $nIdCondicionComercial");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($nIdCondicionComercial)
    {
        $sSQL = $this->db->generateSQLDelete("condicioncomercial", " nIdCondicionComercial = $nIdCondicionComercial ");
        $this->db->run($sSQL);
    }

    public function fncObtenerRegistros($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"                => "cc.nIdCondicionComercial ASC",
            "sLimit"                  => null,
            "nIdCondicionComercial"   => null,
            "nIdEmpresa"              => null,
            "nIdSede"                 => null,
            "nEstado"                 => null,
         
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                    cc.sNombre,
                    cc.nIdCondicionComercial,
                    IFNULL(cc.sTiempoEntrega,'') AS  sTiempoEntrega,
                    IFNULL(cc.sFormaPago,'') AS  sFormaPago,
                    IFNULL(cc.sLugarEntrega,'') AS  sLugarEntrega,
                    IFNULL(cc.sGarantia,'') AS  sGarantia,
                    IFNULL(cc.sValidezOferta,'') AS  sValidezOferta,
                    cc.nEstado
                FROM condicioncomercial AS cc";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCondicionComercial"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cc.nIdCondicionComercial = {$this->db->quote($ary['nIdCondicionComercial'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cc.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cc.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cc.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }



 
}
