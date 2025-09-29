<?php

namespace Application\Models;

use Application\Core\Database as Database;

class MetodosEnvios
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarMetodoEnvio(
        $sNombre,
        $sDescripcion,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("metodosenvio", [
            "sNombre"                   => $sNombre,
            "sDescripcion"              => $sDescripcion,
            "sImagen"                   => $sImagen,
            "nEstado"                   => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarMetodoEnvio(
        $nIdMetodoEnvio,
        $sNombre,
        $sDescripcion,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("metodosenvio", [
            "sNombre"          => $sNombre,
            "sDescripcion"     => $sDescripcion,
            "sImagen"          => $sImagen,
            "nEstado"          => $nEstado,
        ], "nIdMetodoEnvio = $nIdMetodoEnvio");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdMetodoEnvio)
    {
        $sSQL = $this->db->generateSQLDelete("metodosenvio", " nIdMetodoEnvio = $nIdMetodoEnvio ");
        return $this->db->run($sSQL);
    }


    public function fncGetMetodosEnvio($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "nIdMetodoEnvio"     => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT me.nIdMetodoEnvio,
                        me.sNombre,
                        me.sDescripcion,
                        me.sImagen,
                        me.nEstado
                    FROM metodosenvio AS me";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdMetodoEnvio"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " me.nIdMetodoEnvio = {$this->db->quote($ary['nIdMetodoEnvio'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " me.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        return $this->db->run(trim($sSQL));
    }



    public function fncGrabarSedeMetodoEnvio(
        $nIdSede,
        $nIdMetodoEnvio,
        $sDetalle,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("sedesmetodoenvio", [
            "nIdSede"                   => $nIdSede,
            "nIdMetodoEnvio"            => $nIdMetodoEnvio,
            "sDetalle"                  => $sDetalle,
            "sImagen"                   => $sImagen,
            "nEstado"                   => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarSedeMetodoPago(
        $nIdSedeMetodoEnvio ,
        $nIdSede,
        $nIdMetodoEnvio,
        $sDetalle,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("sedesmetodoenvio", [
            "nIdSede"                   => $nIdSede,
            "nIdMetodoEnvio"            => $nIdMetodoEnvio,
            "sDetalle"                  => $sDetalle,
            "sImagen"                   => $sImagen,
            "nEstado"                   => $nEstado,
        ], "nIdSedeMetodoEnvio = $nIdSedeMetodoEnvio");

        return $this->db->run($sSQL);
    }

    public function fncEliminarSedeMetodoPago($nIdSedeMetodoEnvio)
    {
        $sSQL = $this->db->generateSQLDelete("sedesmetodoenvio", " nIdSedeMetodoEnvio = $nIdSedeMetodoEnvio ");
        return $this->db->run($sSQL);
    }


    
    public function fncGetSedesMetodosEnvio($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "nIdSedeMetodoEnvio" => null,
            "nIdEmpresa"         => null,
            "nIdSede"            => null,
            "nIdMetodoEnvio"     => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT sme.nIdSedeMetodoEnvio,
                        sme.nIdSede,
                        sme.nIdMetodoEnvio,
                        sme.sDetalle,
                        sme.sImagen,
                        IFNULL(me.sNombre,'') AS sNombreEnvio,
                        sme.nEstado
                    FROM sedesmetodoenvio AS sme
                    INNER JOIN metodosenvio AS me ON sme.nIdMetodoEnvio = me.nIdMetodoEnvio
                    INNER JOIN sedes AS s ON sme.nIdSede = s.nIdSede";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdSedeMetodoEnvio"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sme.nIdSedeMetodoEnvio = {$this->db->quote($ary['nIdSedeMetodoEnvio'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sme.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");
       
        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " s.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdMetodoEnvio"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sme.nIdMetodoEnvio = {$this->db->quote($ary['nIdMetodoEnvio'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sme.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        return $this->db->run(trim($sSQL));
    }

}
