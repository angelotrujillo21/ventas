<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Choferes
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $nIdTipoDocumento,
        $sNumeroDocumento,
        $sNombres,
        $sApellidos,
        $nIdVehiculo,
        $sLicencia,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("choferes", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "nIdTipoDocumento"      => $nIdTipoDocumento,
            "sNumeroDocumento"       => $sNumeroDocumento,
            "sNombres"               => $sNombres,
            "sApellidos"            => $sApellidos,
            "nIdVehiculo"      => $nIdVehiculo,
            "sLicencia"         => $sLicencia,
            "nEstado"           => $nEstado
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarRegistro(
        $nIdChofer,

        $nIdTipoDocumento,
        $sNumeroDocumento,
        $sNombres,
        $sApellidos,
        $nIdVehiculo,
        $sLicencia,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("choferes", [


            "nIdTipoDocumento"      => $nIdTipoDocumento,
            "sNumeroDocumento"       => $sNumeroDocumento,
            "sNombres"               => $sNombres,
            "sApellidos"            => $sApellidos,
            "nIdVehiculo"      => $nIdVehiculo,
            "sLicencia"         => $sLicencia,
            "nEstado"           => $nEstado


        ], "nIdChofer = $nIdChofer");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarchoferes($nIdChofer)
    {
        $sSQL = $this->db->generateSQLDelete("choferes", " nIdChofer = $nIdChofer ");
        $this->db->run($sSQL);
    }

    public function fncObtenerChoferes($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "ch.nIdChofer ASC",
            "sLimit"               => null,
            "nIdChofer"            => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "nEstado"              => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    ch.nIdChofer,
                    ch.nIdEmpresa,
                    ch.nIdSede,
                    ch.nIdTipoDocumento,
                    ch.sNumeroDocumento,
                    ch.sNombres,
                    ch.sApellidos,
                    UPPER(CONCAT( ch.sNombres , ' ' , ch.sApellidos)) AS sNombreCompleto,
                    ch.nIdVehiculo,
                    ch.sLicencia,
                    ch.nEstado,
                    UPPER(CONCAT(IFNULL( tipodoc.sDescripcionCortaItem,'' ), ' ')) AS sTipoDoc 
                FROM choferes AS ch
                LEFT JOIN catalogotabla AS tipodoc ON ch.nIdTipoDocumento = tipodoc.nIdCatalogoTabla";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdChofer"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ch.nIdChofer = {$this->db->quote($ary['nIdChofer'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ch.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ch.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ch.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }
}
