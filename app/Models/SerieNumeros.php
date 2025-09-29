<?php

namespace Application\Models;

use Application\Core\Database as Database;

class SerieNumeros
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGetSerieNumerosByNomSerie($sNombre, $nIdEmpresa, $nIdSede)
    {
        $result =  $this->db->selectOne(
            "serienumeros",
            "sNombre = :sNombre AND nIdEmpresa = :nIdEmpresa AND nIdSede = :nIdSede ",
            [
                ":sNombre"      => $sNombre,
                ":nIdEmpresa"   => $nIdEmpresa,
                ":nIdSede"      => $nIdSede,
            ],
            "sPrefijo,(sValor+1) AS sValor"
        );
        if ($result != false) {
            return $result;
        }
        return 0;
    }

    public function fncActualizarValorSerieByNomSerie( $nIdSede , $sValor,  $sNombre)
    {

        $sSQL = $this->db->generateSQLUpdate("serienumeros", [
            "sValor"   => $sValor,
        ], "nIdSede = $nIdSede AND sNombre = '$sNombre' ");

        return  $this->db->run($sSQL);
    }


    public function fncGrabarSerieNumero(
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sValor,
        $sPrefijo
    ) {
        $sSQL = $this->db->generateSQLInsert("serienumeros", [
            "nIdEmpresa"  => $nIdEmpresa,
            "nIdSede"     => $nIdSede,
            "sNombre"     => $sNombre,
            "sValor"      => $sValor,
            "sPrefijo"    => $sPrefijo,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarSerieNumero(
        $nIdSerie,
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sValor,
        $sPrefijo
    ) {

        $sSQL = $this->db->generateSQLUpdate("serienumeros", [
            "nIdEmpresa"  => $nIdEmpresa,
            "nIdSede"     => $nIdSede,
            "sNombre"     => $sNombre,
            "sValor"      => $sValor,
            "sPrefijo"    => $sPrefijo,
        ], "nIdSerie = $nIdSerie");

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($nIdSerie)
    {
        $sSQL = $this->db->generateSQLDelete("serienumeros", " nIdSerie = $nIdSerie ");
        return $this->db->run($sSQL);
    }



    public function fncGetSerieNumeros($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"             => "sn.sNombre ASC",
            "sLimit"               => null,
            "nIdSerie"             => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "sNombre"              => null,
            "sPrefijo"             => null,
            "sAryNombres"          => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    sn.nIdSerie,
                    sn.nIdEmpresa,
                    sn.nIdSede,
                    sn.sNombre,
                    sn.sValor,
                    sn.sPrefijo
                FROM serienumeros AS sn ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdSerie"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sn.nIdSerie = {$this->db->quote($ary['nIdSerie'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sn.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sn.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNombre"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sn.sNombre = {$this->db->quote($ary['sNombre'])}  ");

        $sWhere .= ($this->db->isNull($ary["sPrefijo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sn.sPrefijo = {$this->db->quote($ary['sPrefijo'])}  ");

        $sWhere .= ($this->db->isNull($ary["sAryNombres"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sn.sNombre IN ( " . $ary["sAryNombres"] . " )");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
