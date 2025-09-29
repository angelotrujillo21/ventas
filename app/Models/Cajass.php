<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Cajas
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $sDescripcion,
        $sDetalle,
        $nIdEmpleado,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("cajas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sDescripcion"          => $sDescripcion,
            "sDetalle"              => $sDetalle,
            "nIdEmpleado"           => $nIdEmpleado,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $nIdCaja,
        $nIdEmpresa,
        $nIdSede,
        $sDescripcion,
        $sDetalle,
        $nIdEmpleado,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("cajas", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sDescripcion"          => $sDescripcion,
            "sDetalle"              => $sDetalle,
            "nIdEmpleado"           => $nIdEmpleado,
            "nEstado"               => $nEstado,
        ], "nIdCaja = $nIdCaja");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdCaja)
    {
        $sSQL = $this->db->generateSQLDelete("cajas", " nIdCaja = $nIdCaja ");
        $this->db->run($sSQL);
    }


    public function fncGetCajas($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"     => "c.nIdCaja DESC",
            "sLimit"       => null,
            "nIdCaja"      => null,
            "nIdEmpresa"   => null,
            "nIdSede"      => null,
            "nIdEmpleado"  =>null ,
            "nEstado"      => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    c.nIdCaja,
                    c.nIdEmpresa,
                    c.nIdSede,
                    c.sDescripcion,
                    c.sDetalle,
                    c.nIdEmpleado,
                    IFNULL(emp.sNombre, '') AS sEmpleado,
                    c.nEstado
                FROM cajas AS c
                LEFT JOIN empleados AS emp ON c.nIdEmpleado = emp.nIdEmpleado
                ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCaja"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " c.nIdCaja = {$this->db->quote($ary['nIdCaja'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " c.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " c.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpleado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " c.nIdEmpleado = {$this->db->quote($ary['nIdEmpleado'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " c.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }




    public function fncGrabarCajaDiaria(
        $nIdCaja,
        $nIdEmpleado,
        $nMontoApertura,
        $nMontoDeposito,
        $nMontoSalidas,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("cajadiaria", [
            "nIdCaja"                  => $nIdCaja,
            "nIdEmpleado"              => $nIdEmpleado,
            "dFechaHoraApertura"       => "NOW()",
            "nMontoApertura"           => $nMontoApertura,
            "nMontoDeposito"           => $nMontoDeposito,
            "nMontoSalidas"            => $nMontoSalidas,
            "nEstado"                  => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarCajaDiaria(
        $nIdCajaDiaria,
        $nIdEmpleado,
        $nMontoApertura,
        $nMontoDeposito,
        $nMontoSalidas
    ) {

        $sSQL = $this->db->generateSQLUpdate("cajadiaria", [
            "nIdEmpleado"              => $nIdEmpleado,
            "nMontoApertura"           => $nMontoApertura,
            "nMontoDeposito"           => $nMontoDeposito,
            "nMontoSalidas"            => $nMontoSalidas,
        ],  "nIdCajaDiaria = $nIdCajaDiaria");

        return  $this->db->run($sSQL);
    }

    public function fncCerrarCajaDiaria(
        $nIdCajaDiaria,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("cajadiaria", [
            "dFechaCierre"       => "NOW()",
            "nEstado"            => $nEstado,
        ], "nIdCajaDiaria = $nIdCajaDiaria");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarCajaDiaria($nIdCajaDiaria)
    {
        $sSQL = $this->db->generateSQLDelete("cajadiaria", " nIdCajaDiaria = $nIdCajaDiaria ");
        $this->db->run($sSQL);
    }

    public function fncGetCajaDiaria($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => "cd.dFechaHoraApertura DESC",
            "sLimit"             => null,
            "nIdCajaDiaria"      => null,
            "nIdEmpresa"         => null,
            "nIdSede"            => null,
            "nIdCaja"            => null,
            "aryIdCajas"         => null,
            "dFechaHoraApertura" => null,
            "dFechaInicio"       => null,
            "dFechaFin"          => null,
            "nIdEmpleado"        => null,
            "nIdSede"            => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    cd.nIdCajaDiaria,
                    cd.nIdCaja,
                    cd.nIdEmpleado,
                    cd.nMontoApertura,
                    cd.nMontoDeposito,
                    cd.nMontoSalidas,
                    IFNULL( UPPER( c.sDescripcion ) , '') AS sCaja , 
                    IFNULL(emp.sNombre , '') AS sEmpleado , 
                    IFNULL( DATE_FORMAT( cd.dFechaHoraApertura, '%d/%m/%Y' ), '' ) AS dFechaRegistro, 
                    IFNULL( DATE_FORMAT( cd.dFechaHoraApertura, '%d/%m/%Y' ), '' ) AS dFechaApertura, 
                    IFNULL( DATE_FORMAT( cd.dFechaHoraApertura, '%d/%m/%Y %h:%i:%s' ), '' ) AS dFechaHoraApertura, 
                    IFNULL( DATE_FORMAT( cd.dFechaCierre, '%d/%m/%Y %h:%i:%s' ), '' ) AS dFechaCierre, 
                    IFNULL((SELECT cda.nIdCajaDiaria FROM cajadiaria AS cda where cda.nIdCajaDiaria = (SELECT MAX(cdaa.nIdCajaDiaria) FROM cajadiaria AS cdaa where cdaa.nIdCajaDiaria < cd.nIdCajaDiaria)),0) AS nIdCajaDiariaAnterior,
                    cd.nEstado
                FROM cajadiaria AS cd
                INNER JOIN cajas AS c ON cd.nIdCaja = c.nIdCaja
                LEFT JOIN empleados AS emp ON cd.nIdEmpleado = emp.nIdEmpleado";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCajaDiaria"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nIdCajaDiaria = {$this->db->quote($ary['nIdCajaDiaria'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdCaja"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nIdCaja = {$this->db->quote($ary['nIdCaja'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " c.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");


        $sWhere .= ($this->db->isNull($ary["aryIdCajas"]) && !is_array($ary["aryIdCajas"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' cd.nIdCaja IN (' . implode(",", $ary['aryIdCajas']) . ')');

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " c.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["dFechaHoraApertura"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(cd.dFechaHoraApertura) =  STR_TO_DATE( '" . $ary['dFechaHoraApertura'] . "', '%d/%m/%Y' )  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(cd.dFechaHoraApertura)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nIdEmpleado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nIdEmpleado = {$this->db->quote($ary['nIdEmpleado'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
