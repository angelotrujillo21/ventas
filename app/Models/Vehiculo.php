<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Vehiculo
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $sPlaca,
        $sDetalle,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("vehiculo", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sPlaca"      => $sPlaca,
            "sDetalle"       => $sDetalle,
            "nEstado"           => $nEstado
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarRegistro(
        $nIdVehiculo,
        $sPlaca,
        $sDetalle,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("vehiculo", [
            "sPlaca"      => $sPlaca,
            "sDetalle"    => $sDetalle,
            "nEstado"     => $nEstado
        ], "nIdVehiculo = $nIdVehiculo");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($nIdVehiculo)
    {
        $sSQL = $this->db->generateSQLDelete("vehiculo", " nIdVehiculo = $nIdVehiculo ");
        $this->db->run($sSQL);
    }

    public function fncObtenerRegistros($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "v.nIdVehiculo ASC",
            "sLimit"               => null,
            "nIdVehiculo"          => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "nEstado"              => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    v.nIdVehiculo,
                    v.nIdEmpresa,
                    v.nIdSede,
                    v.sPlaca,
                    v.sDetalle,
                    v.nEstado
                FROM vehiculo AS v";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdVehiculo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " v.nIdVehiculo = {$this->db->quote($ary['nIdVehiculo'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " v.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " v.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " v.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }
}
