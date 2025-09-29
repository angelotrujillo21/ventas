<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Mesas
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $nIdCartaDigital,
        $sDescripcion,
        $sComentario,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("mesas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "nIdCartaDigital"       => $nIdCartaDigital,
            "sDescripcion"          => $sDescripcion,
            "sComentario"           => $sComentario,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $nIdMesa,
        $nIdEmpresa,
        $nIdSede,
        $nIdCartaDigital,
        $sDescripcion,
        $sComentario,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("mesas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "nIdCartaDigital"       => $nIdCartaDigital,
            "sDescripcion"          => $sDescripcion,
            "sComentario"           => $sComentario,
            "nEstado"               => $nEstado,
        ], "nIdMesa = $nIdMesa");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdMesa)
    {
        $sSQL = $this->db->generateSQLDelete("mesas", " nIdMesa = $nIdMesa ");
        $this->db->run($sSQL);
    }


    public function fncObtenerRegistros($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"     => "m.nIdMesa ASC",
            "sLimit"       => null,
            "nIdMesa"      => null,
            "nIdEmpresa"   => null,
            "nIdSede"      => null,
            "nEstado"      => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    m.nIdMesa,
                    m.nIdEmpresa,
                    m.nIdSede,
                    IFNULL(m.nIdCartaDigital,0) AS nIdCartaDigital,
                    m.sDescripcion,
                    m.sComentario,
                    m.nEstado,
                    IFNULL(cd.sNombre,'') AS sCartaDigital,
                    IFNULL(cd.sColor3,'') AS sColor3,
                    IFNULL(cd.sColor4,'') AS sColor4
                FROM mesas AS m
                LEFT JOIN cartadigital AS cd ON m.nIdCartaDigital = cd.nIdCartaDigital";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdMesa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdMesa = {$this->db->quote($ary['nIdMesa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}