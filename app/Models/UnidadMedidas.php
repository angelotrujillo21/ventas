<?php

namespace Application\Models;

use Application\Core\Database as Database;
use Application\Core\Model;

class UnidadMedidas
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarUnidadMedida(
        $nIdEmpresa,
        $nIdSede,
        $sNombreLargo,
        $sNombreCorto,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("unidadmedidas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombreLargo"          => $sNombreLargo,
            "sNombreCorto"          => $sNombreCorto,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarUnidadMedida(
        $nIdUnidadMedida,
        $nIdEmpresa,
        $nIdSede,
        $sNombreLargo,
        $sNombreCorto,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("unidadmedidas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombreLargo"          => $sNombreLargo,
            "sNombreCorto"          => $sNombreCorto,
            "nEstado"               => $nEstado,
        ], "nIdUnidadMedida = $nIdUnidadMedida");

        return $this->db->run($sSQL);
    }


    public function fncEliminarUnidadMedida($nIdUnidadMedida)
    {
        $sSQL = $this->db->generateSQLDelete("unidadmedidas", " nIdUnidadMedida = $nIdUnidadMedida ");
        $this->db->run($sSQL);
    }


    public function fncGetUnidadesMedidas($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"                   => null,
            "sLimit"                     => null,
            "nIdUnidadMedida"            => null,
            "nIdEmpresa"                 => null,
            "sNombreLargo"               => null,
            "sNombreCorto"               => null,
            "nIdSede"                    => null,
            "nEstado"                    => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                        um.nIdUnidadMedida,
                        um.nIdEmpresa,
                        um.nIdSede,
                        um.sNombreLargo,
                        um.sNombreCorto,
                        um.nEstado
                 FROM unidadmedidas AS um";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdUnidadMedida"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " um.nIdUnidadMedida = {$this->db->quote($ary['nIdUnidadMedida'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " um.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " um.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNombreLargo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " um.sNombreLargo = {$this->db->quote($ary['sNombreLargo'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNombreCorto"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " um.sNombreCorto = {$this->db->quote($ary['sNombreCorto'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " um.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
