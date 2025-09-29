<?php

namespace Application\Models;

use Application\Core\Database as Database;

class CanjePuntos
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarCP(
        $nIdEmpresa,
        $nIdSede,
        $sDescripcion,
        $nValorInicial,
        $nValorFinal,
        $nPuntos,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("canjepuntos", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sDescripcion"          => $sDescripcion,
            "nValorInicial"         => $nValorInicial,
            "nValorFinal"           => $nValorFinal,
            "nPuntos"               => $nPuntos,
            "nEstado"               => $nEstado,
        ]);


        return  $this->db->run($sSQL);
    }


    public function fncActualizarCP(
        $nIdCanjePuntos,
        $nIdEmpresa,
        $nIdSede,
        $sDescripcion,
        $nValorInicial,
        $nValorFinal,
        $nPuntos,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("canjepuntos", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sDescripcion"          => $sDescripcion,
            "nValorInicial"         => $nValorInicial,
            "nValorFinal"           => $nValorFinal,
            "nPuntos"               => $nPuntos,
            "nEstado"               => $nEstado,
        ], " nIdCanjePuntos = $nIdCanjePuntos");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarCP($nIdCanjePuntos)
    {
        $sSQL = $this->db->generateSQLDelete("canjepuntos", " nIdCanjePuntos = $nIdCanjePuntos  ");
        return $this->db->run($sSQL);
    }


    public function fncGetCP($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"        => "cp.nIdCanjePuntos DESC",
            "sLimit"          => null,
            "nIdCanjePuntos"  => null,
            "nIdEmpresa"      => null,
            "nIdSede"         => null,
            "nEstado"         => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                        cp.nIdCanjePuntos,
                        cp.nIdEmpresa,
                        cp.sDescripcion,
                        cp.nValorInicial,
                        cp.nValorFinal,
                        cp.nPuntos,
                        cp.nEstado
                FROM canjepuntos AS cp";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCanjePuntos"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cp.nIdCanjePuntos = {$this->db->quote($ary['nIdCanjePuntos'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncGetMontoDsctPorRango($nIdSede, $nPuntos)
    {
        $sSQL = "SELECT cp.nPuntos AS nMontoDsct FROM canjepuntos AS cp
                WHERE cp.nIdSede = $nIdSede AND ( $nPuntos >= cp.nValorInicial AND $nPuntos <= cp.nValorFinal)
                AND cp.nEstado = 1 ORDER BY cp.nIdCanjePuntos DESC LIMIT 1";

        return $this->db->run(trim($sSQL));
    }

}
