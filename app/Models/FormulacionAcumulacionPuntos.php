<?php

namespace Application\Models;

use Application\Core\Database as Database;

class FormulacionAcumulacionPuntos
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

 
    public function fncGrabarFAP(
        $nIdEmpresa,
        $nIdSede,
        $sDescripcion,
        $nValorInicial,
        $nValorFinal,
        $nPorcentaje,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("formulacionacumulacionpuntos", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sDescripcion"          => $sDescripcion,
            "nValorInicial"         => $nValorInicial,
            "nValorFinal"           => $nValorFinal,
            "nPorcentaje"           => $nPorcentaje,
            "nEstado"               => $nEstado,
        ]);

  
        return  $this->db->run($sSQL);
    }


    public function fncActualizarFAP(
        $nIdFormulacionAcumulacionPuntos,
        $nIdEmpresa,
        $nIdSede,
        $sDescripcion,
        $nValorInicial,
        $nValorFinal,
        $nPorcentaje,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("formulacionacumulacionpuntos", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sDescripcion"          => $sDescripcion,
            "nValorInicial"         => $nValorInicial,
            "nValorFinal"           => $nValorFinal,
            "nPorcentaje"           => $nPorcentaje,
            "nEstado"               => $nEstado,
        ], "nIdFormulacionAcumulacionPuntos = $nIdFormulacionAcumulacionPuntos");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarFAP($nIdFormulacionAcumulacionPuntos)
    {
        $sSQL = $this->db->generateSQLDelete("formulacionacumulacionpuntos", " nIdFormulacionAcumulacionPuntos = $nIdFormulacionAcumulacionPuntos  ");
        $this->db->run($sSQL);
    }


    public function fncGetFAP($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"                            => "fap.nIdFormulacionAcumulacionPuntos ASC",
            "sLimit"                              => null,
            "nIdFormulacionAcumulacionPuntos"     => null,
            "nIdEmpresa"                          => null,
            "nIdSede"                             => null,
            "nEstado"                             => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                        fap.nIdFormulacionAcumulacionPuntos,
                        fap.nIdEmpresa,
                        fap.sDescripcion,
                        fap.nValorInicial,
                        fap.nValorFinal,
                        fap.nPorcentaje,
                        fap.nEstado
                FROM formulacionacumulacionpuntos AS fap";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdFormulacionAcumulacionPuntos"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " fap.nIdFormulacionAcumulacionPuntos = {$this->db->quote($ary['nIdFormulacionAcumulacionPuntos'])}  ");
 
        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " fap.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " fap.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " fap.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }

    
    public function fncGetPorcentajeRango($nIdSede, $nMonto)
    {
        $sSQL = "SELECT fab.nPorcentaje AS nPorcentaje FROM formulacionacumulacionpuntos AS fab
                WHERE fab.nIdSede = $nIdSede AND ( $nMonto >= fab.nValorInicial AND $nMonto <= fab.nValorFinal)
                AND fab.nEstado = 1 ORDER BY fab.nIdFormulacionAcumulacionPuntos DESC LIMIT 1";

        return $this->db->run(trim($sSQL));
    }
}
