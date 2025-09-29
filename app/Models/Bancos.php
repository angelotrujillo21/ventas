<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Bancos
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
        $sImagen,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("bancos", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sDescripcion"          => $sDescripcion,
            "sImagen"               => $sImagen,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $nIdBanco,
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sDescripcion,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("bancos", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sDescripcion"          => $sDescripcion,
            "sImagen"               => $sImagen,
            "nEstado"               => $nEstado,
        ], "nIdBanco = $nIdBanco");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdBanco)
    {
        $sSQL = $this->db->generateSQLDelete("bancos", " nIdBanco = $nIdBanco ");
        $this->db->run($sSQL);
    }


    public function fncGetBancos($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"     => "b.nIdBanco DESC",
            "sLimit"       => null,
            "nIdBanco"     => null,
            "nIdEmpresa"   => null,
            "nIdSede"      => null,
            "nEstado"      => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                       b.nIdBanco,
                       b.nIdEmpresa,
                       b.nIdSede,
                       b.sNombre,
                       b.sDescripcion,
                       b.sImagen,
                       b.nEstado
                FROM bancos AS b";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdBanco"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nIdBanco = {$this->db->quote($ary['nIdBanco'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
