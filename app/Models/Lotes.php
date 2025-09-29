<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Lotes
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarLote(
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sCodigo,
        $sDescripcion,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("lotes", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sCodigo"               => $sCodigo,
            "sDescripcion"          => $sDescripcion,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarLote(
        $nIdLote,
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sCodigo,
        $sDescripcion,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("lotes", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sCodigo"               => $sCodigo,
            "sDescripcion"          => $sDescripcion,
            "nEstado"               => $nEstado,
        ], "nIdLote = $nIdLote");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarLote($nIdLote)
    {
        $sSQL = $this->db->generateSQLDelete("lotes", " nIdLote = $nIdLote ");
        $this->db->run($sSQL);
    }


    public function fncGetLotes($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"     => "lot.nIdLote DESC",
            "sLimit"       => null,
            "nIdLote"      => null,
            "nIdEmpresa"   => null,
            "nIdSede"      => null,
            "nEstado"      => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                        lot.nIdLote,
                        lot.nIdEmpresa,
                        lot.nIdSede,
                        lot.sNombre,
                        lot.sCodigo,
                        lot.sDescripcion,
                        lot.nEstado
                FROM lotes AS lot";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdLote"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " lot.nIdLote = {$this->db->quote($ary['nIdLote'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " lot.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " lot.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
