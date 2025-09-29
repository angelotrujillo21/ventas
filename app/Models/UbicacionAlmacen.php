<?php

namespace Application\Models;

use Application\Core\Database as Database;

class UbicacionAlmacen
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarUA(
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sCodigo,
        $sDescripcion,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("ubicacionesalmacen", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sCodigo"               => $sCodigo,
            "sDescripcion"          => $sDescripcion,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarUA(
        $nIdUbicacionAlmacen,
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sCodigo,
        $sDescripcion,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("ubicacionesalmacen", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sCodigo"               => $sCodigo,
            "sDescripcion"          => $sDescripcion,
            "nEstado"               => $nEstado,
        ], "nIdUbicacionAlmacen = $nIdUbicacionAlmacen");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarUA($nIdUbicacionAlmacen)
    {
        $sSQL = $this->db->generateSQLDelete("ubicacionesalmacen", " nIdUbicacionAlmacen = $nIdUbicacionAlmacen  ");
        $this->db->run($sSQL);
    }


    public function fncGetUA($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"                  => "ua.nIdUbicacionAlmacen DESC",
            "sLimit"                    => null,
            "nIdUbicacionAlmacen"       => null,
            "nIdEmpresa"                => null,
            "nIdSede"                   => null,
            "nEstado"                   => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                        ua.nIdUbicacionAlmacen,
                        ua.nIdEmpresa,
                        ua.nIdSede,
                        UPPER(ua.sNombre) AS sNombre ,
                        ua.sCodigo,
                        ua.sDescripcion,
                        ua.nEstado
                FROM ubicacionesalmacen AS ua";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdUbicacionAlmacen"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ua.nIdUbicacionAlmacen = {$this->db->quote($ary['nIdUbicacionAlmacen'])}  ");
 
        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ua.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ua.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ua.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
