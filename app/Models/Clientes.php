<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Clientes
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarCliente(
        $nIdEmpresa,
        $nIdSede,
        $nTipoDocumento,
        $sNumeroDocumento,
        $sNombreoRazonSocial,
        $sCorreo,
        $nIdDepartamento,
        $nIdProvincia,
        $nIdDistrito,
        $sTelefono,
        $sDireccion,
        $nAcumulaPuntos,
        $sFacebook,
        $sWtsp,
        $sTwiter,
        $sOtraRedSocial,
        $nEstado,
        $nIdCondicionComercial = null
    ) {


        $sSQL = $this->db->generateSQLInsert("clientes", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "nTipoDocumento"        => $nTipoDocumento,
            "sNumeroDocumento"      => $sNumeroDocumento,
            "sNombreoRazonSocial"   => $sNombreoRazonSocial,
            "sCorreo"               => $sCorreo,
            "dFechaCreacion"        => "NOW()",
            "nIdDepartamento"       => $nIdDepartamento,
            "nIdProvincia"          => $nIdProvincia,
            "nIdDistrito"           => $nIdDistrito,
            "sTelefono"             => $sTelefono,
            "sDireccion"            => $sDireccion,
            "nAcumulaPuntos"        => $nAcumulaPuntos,
            "sFacebook"             => $sFacebook,
            "sWtsp"                 => $sWtsp,
            "sTwiter"               => $sTwiter,
            "sOtraRedSocial"        => $sOtraRedSocial,
            "nEstado"               => $nEstado,
            "nIdCondicionComercial"  => $nIdCondicionComercial,

        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarCliente(
        $nIdCliente,
        $nIdEmpresa,
        $nIdSede,
        $nTipoDocumento,
        $sNumeroDocumento,
        $sNombreoRazonSocial,
        $sCorreo,
        $nIdDepartamento,
        $nIdProvincia,
        $nIdDistrito,
        $sTelefono,
        $sDireccion,
        $nAcumulaPuntos,
        $sFacebook,
        $sWtsp,
        $sTwiter,
        $sOtraRedSocial,
        $nEstado,
        $nIdCondicionComercial = null
    ) {

        $sSQL = $this->db->generateSQLUpdate("clientes", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "nTipoDocumento"        => $nTipoDocumento,
            "sNumeroDocumento"      => $sNumeroDocumento,
            "sNombreoRazonSocial"   => $sNombreoRazonSocial,
            "sCorreo"               => $sCorreo,
            "dFechaEdicion"         => "NOW()",
            "nIdDepartamento"       => $nIdDepartamento,
            "nIdProvincia"          => $nIdProvincia,
            "nIdDistrito"           => $nIdDistrito,
            "sTelefono"             => $sTelefono,
            "sDireccion"            => $sDireccion,
            "nAcumulaPuntos"        => $nAcumulaPuntos,
            "sFacebook"             => $sFacebook,
            "sWtsp"                 => $sWtsp,
            "sTwiter"               => $sTwiter,
            "sOtraRedSocial"        => $sOtraRedSocial,
            "nEstado"               => $nEstado,
            "nIdCondicionComercial" => $nIdCondicionComercial,

        ], "nIdCliente = $nIdCliente");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarCliente($nIdCliente)
    {
        $sSQL = $this->db->generateSQLDelete("clientes", " nIdCliente = $nIdCliente ");
        $this->db->run($sSQL);
    }


    public function fncGetClientes($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"                   => "cli.nIdCliente DESC",
            "sLimit"                     => null,
            "nIdCliente"                 => null,
            "nIdEmpresa"                 => null,
            "nIdSede"                    => null,
            "aryIdSede"                  => null,
            "nTipoDocumento"             => null,
            "sNumeroDocumento"           => null,
            "dFechaInicio"               => null,
            "dFechaFin"                  => null,

            "aryClientes"                => null,
            "nTienePuntosAcumulados"     => null,
            "sSearch"                    => null,

            "nEstado"                    => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                   cli.nIdCliente,
                   cli.nIdEmpresa,
                   IFNULL(tipodoc.sDescripcionCortaItem,'') AS sTipoDoc, 
                   cli.nTipoDocumento,
                   cli.sNumeroDocumento,
                   UPPER(cli.sNombreoRazonSocial) AS sNombreoRazonSocial,
                   cli.sCorreo,
                   cli.nIdDepartamento,
                   cli.nIdProvincia,
                   cli.nIdDistrito,
                   cli.sTelefono,
                   cli.sDireccion,
                   cli.nAcumulaPuntos,
                   IFNULL( DATE_FORMAT( cli.dFechaCreacion, '%d/%m/%Y' ), '' ) as dFechaCreacion, 
                   IFNULL( DATE_FORMAT( cli.dFechaEdicion, '%d/%m/%Y' ), '' ) as dFechaEdicion, 
                   IFNULL(dpt.sNombre,'') as sDpt ,
                   IFNULL(prov.sNombre,'')  as sProvincia ,
                   IFNULL(dist.sNombre,'') as sDistrito ,
                   IFNULL(cli.nPuntosAcumulados,0) AS nPuntosAcumulados,
                   IFNULL(cli.sFacebook,'') as sFacebook,
                   IFNULL(cli.sWtsp,'') as sWtsp,
                   IFNULL(cli.sTwiter,'') as sTwiter,
                   IFNULL(cli.sOtraRedSocial,'') as sOtraRedSocial,
                   IFNULL(cli.nIdCondicionComercial,'0') as nIdCondicionComercial,                   
                   cli.nEstado
                FROM clientes AS cli 
                LEFT JOIN departamentos AS dpt ON cli.nIdDepartamento = dpt.nIdDepartamento
                LEFT JOIN provincia AS prov ON cli.nIdProvincia = prov.nIdProvincia
                LEFT JOIN distrito AS dist ON cli.nIdDistrito = dist.nIdDistrito
                LEFT JOIN catalogotabla AS tipodoc ON cli.nTipoDocumento = tipodoc.nIdCatalogoTabla";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCliente"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.nIdCliente = {$this->db->quote($ary['nIdCliente'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdSede"]) && !is_array($ary["aryIdSede"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' cli.nIdSede IN (' . implode(",", $ary['aryIdSede']) . ')');

        $sWhere .= ($this->db->isNull($ary["nTipoDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.nTipoDocumento = {$this->db->quote($ary['nTipoDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNumeroDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.sNumeroDocumento = {$this->db->quote($ary['sNumeroDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(cli.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["aryClientes"]) && !is_array($ary["aryClientes"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' cli.nIdCliente IN (' . implode(",", $ary['aryClientes']) . ')');

        $sWhere .= ($this->db->isNull($ary["nTienePuntosAcumulados"]) || $ary["nTienePuntosAcumulados"]  == '0' ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.nPuntosAcumulados > 0  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cli.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sWhere .= ($this->db->isNull($ary["sSearch"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " CONCAT( cli.sNumeroDocumento , ' ' , cli.sNombreoRazonSocial , ' ' ,  cli.sTelefono  ) LIKE  '%".$ary['sSearch']."%'  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncActualizarPuntos(
        $nIdCliente,
        $nPuntosAcumulados
    ) {

        $sSQL = "UPDATE clientes SET nPuntosAcumulados = IFNULL(nPuntosAcumulados,0) + $nPuntosAcumulados WHERE nIdCliente = $nIdCliente";
        return $this->db->run($sSQL);
    }

    public function fncRestarPuntos(
        $nIdCliente,
        $nPuntos
    ) {

        $sSQL = "UPDATE clientes SET nPuntosAcumulados = IFNULL(nPuntosAcumulados,0) - $nPuntos WHERE  nIdCliente = $nIdCliente ";
        return $this->db->run($sSQL);
    }


    public function fncObtenerFlagAcumulaPuntos($nIdCliente)
    {

        $sSQL = "SELECT nAcumulaPuntos FROM clientes WHERE nIdCliente = $nIdCliente";
        return $this->db->run($sSQL);
    }
}
