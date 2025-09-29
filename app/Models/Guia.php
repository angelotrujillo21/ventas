<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Guia
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $sNumero,
        $dFechaGuia,
        $nIdPedido,
        $nTipoDespacho,
        $nIdCliente,
        $nIdChofer,
        $nIdVehiculo,
        $nIdTipoMovimiento,
        $sTipoViaRmt,
        $sNroRmt,
        $sZonaRmt,
        $sProvinciaRmt,
        $sViaNombreRmt,
        $sInteriorRmt,
        $sDistritoRmt,
        $sDptRmt,
        $sRemitente,
        $sNumeroDocRmt,
        $sTipoViaDest,
        $sNroDest,
        $sZonaDest,
        $sProvinciaDest,
        $sViaNombreDest,
        $sInteriorDest,
        $sDistritoDest,
        $sDptDest,
        $sDestinatario,
        $sNumeroDocDest,
        $sComentario,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("guia", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNumero"               => $sNumero,
            "dFechaGuia"            => $dFechaGuia,
            "nIdPedido"             => $nIdPedido,
            "nIdCliente"            => $nIdCliente,
            "nTipoDespacho"         => $nTipoDespacho,
            "nIdChofer"             => $nIdChofer,
            "nIdVehiculo"           => $nIdVehiculo,
            "nIdTipoMovimiento"     => $nIdTipoMovimiento,
            "sTipoViaRmt"           => $sTipoViaRmt,
            "sNroRmt"               => $sNroRmt,
            "sZonaRmt"              => $sZonaRmt,
            "sProvinciaRmt"         => $sProvinciaRmt,
            "sViaNombreRmt"         => $sViaNombreRmt,
            "sInteriorRmt"          => $sInteriorRmt,
            "sDistritoRmt"          => $sDistritoRmt,
            "sDptRmt"               => $sDptRmt,
            "sRemitente"            => $sRemitente,
            "sNumeroDocRmt"         => $sNumeroDocRmt,
            "sTipoViaDest"          => $sTipoViaDest,
            "sNroDest"              => $sNroDest,
            "sZonaDest"             => $sZonaDest,
            "sProvinciaDest"        => $sProvinciaDest,
            "sViaNombreDest"        => $sViaNombreDest,
            "sInteriorDest"         => $sInteriorDest,
            "sDistritoDest"         => $sDistritoDest,
            "sDptDest"              => $sDptDest,
            "sDestinatario"         => $sDestinatario,
            "sNumeroDocDest"        => $sNumeroDocDest,
            "sComentario"           => $sComentario,
            "nEstado"               => $nEstado,
            "dFechaCreacion"        => "NOW()"
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarRegistro(
        $nIdGuia,
        $dFechaGuia,
        $nIdPedido,
        $nTipoDespacho,
        $nIdCliente,
        $nIdChofer,
        $nIdVehiculo,
        $nIdTipoMovimiento,
        $sTipoViaRmt,
        $sNroRmt,
        $sZonaRmt,
        $sProvinciaRmt,
        $sViaNombreRmt,
        $sInteriorRmt,
        $sDistritoRmt,
        $sDptRmt,
        $sRemitente,
        $sNumeroDocRmt,
        $sTipoViaDest,
        $sNroDest,
        $sZonaDest,
        $sProvinciaDest,
        $sViaNombreDest,
        $sInteriorDest,
        $sDistritoDest,
        $sDptDest,
        $sDestinatario,
        $sNumeroDocDest,
        $sComentario,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("guia", [
            "dFechaGuia"            => $dFechaGuia,
            "nIdPedido"             => $nIdPedido,
            "nIdCliente"            => $nIdCliente,
            "nTipoDespacho"         => $nTipoDespacho,
            "nIdChofer"             => $nIdChofer,
            "nIdVehiculo"           => $nIdVehiculo,
            "nIdTipoMovimiento"     => $nIdTipoMovimiento,
            "sTipoViaRmt"           => $sTipoViaRmt,
            "sNroRmt"               => $sNroRmt,
            "sZonaRmt"              => $sZonaRmt,
            "sProvinciaRmt"         => $sProvinciaRmt,
            "sViaNombreRmt"         => $sViaNombreRmt,
            "sInteriorRmt"          => $sInteriorRmt,
            "sDistritoRmt"          => $sDistritoRmt,
            "sDptRmt"               => $sDptRmt,
            "sRemitente"            => $sRemitente,
            "sNumeroDocRmt"         => $sNumeroDocRmt,
            "sTipoViaDest"          => $sTipoViaDest,
            "sNroDest"              => $sNroDest,
            "sZonaDest"             => $sZonaDest,
            "sProvinciaDest"        => $sProvinciaDest,
            "sViaNombreDest"        => $sViaNombreDest,
            "sInteriorDest"         => $sInteriorDest,
            "sDistritoDest"         => $sDistritoDest,
            "sDptDest"              => $sDptDest,
            "sDestinatario"         => $sDestinatario,
            "sNumeroDocDest"        => $sNumeroDocDest,
            "sComentario"           => $sComentario,
            "nEstado"               => $nEstado,
            "dFechaCreacion"        => "NOW()"
        ], "nIdGuia = $nIdGuia");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarGuia($nIdGuia)
    {
        $sSQL = $this->db->generateSQLDelete("guia", " nIdGuia = $nIdGuia ");
        $this->db->run($sSQL);
    }

    public function fncObtenerRegistros($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "ctz.nIdGuia ASC",
            "sLimit"               => null,
            "nIdGuia"               => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "nEstado"              => null,
            "sIdsCliente"          => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "nVendido"             => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT
                    g.nIdGuia,g.nIdEmpresa,g.nIdSede,g.sNumero,g.dFechaGuia, g.nIdPedido, 
                    g.nTipoDespacho, g.nIdCliente, g.nIdChofer,g.nIdVehiculo, g.nIdTipoMovimiento, g.sTipoViaRmt, g.sNroRmt, g.sZonaRmt, 
                    g.sProvinciaRmt, g.sViaNombreRmt, g.sInteriorRmt, g.sDistritoRmt, g.sDptRmt, g.sRemitente, g.sNumeroDocRmt, 
                    g.sTipoViaDest, g.sNroDest, g.sZonaDest, g.sProvinciaDest, g.sViaNombreDest, 
                    g.sInteriorDest, g.sDistritoDest, g.sDptDest, g.sDestinatario, g.sNumeroDocDest, g.sComentario, 
                    IFNULL( DATE_FORMAT( g.dFechaGuia, '%d/%m/%Y' ), '' ) as sFechaGuia,
                    IFNULL( DATE_FORMAT( g.dFechaCreacion, '%d/%m/%Y' ), '' ) as dFechaCreacion, 
                    IFNULL( DATE_FORMAT( g.dFechaEdicion, '%d/%m/%Y' ), '' ) as dFechaEdicion, 
                    g.nEstado,
                    cli.sNombreoRazonSocial AS sCliente,
                    IFNULL(CONCAT(cho.sNombres,' ' , cho.sApellidos),'' ) AS sChofer,
                    IFNULL(v.sPlaca,'' ) AS sPlaca,
                    IFNULL(p.sNumero,'') AS sNumero
                FROM guia AS g
                LEFT JOIN clientes AS cli ON g.nIdCliente = cli.nIdCliente
                LEFT JOIN choferes AS cho ON g.nIdChofer = cho.nIdChofer
                LEFT JOIN vehiculo AS v ON g.nIdVehiculo = v.nIdVehiculo
                LEFT JOIN pedidos AS p ON p.nIdPedido = g.nIdPedido";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdGuia"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " g.nIdGuia = {$this->db->quote($ary['nIdGuia'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " g.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");
        
        $sWhere .= ($this->db->isNull($ary["sIdsCliente"]) || empty($ary["sIdsCliente"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " g.nIdCLiente IN(" . $ary["sIdsCliente"]. ")");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " g.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " g.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }

    public function fncGrabarDetalle(
        $nIdGuia,
        $nIdProducto,
        $nTotalPedido,
        $nDespachado
    ) {

        $sSQL = $this->db->generateSQLInsert("guiadetalle", [
            "nIdGuia"      => $nIdGuia,
            "nIdProducto"  => $nIdProducto,
            "nTotalPedido" => $nTotalPedido,
            "nDespachado"  => $nDespachado
        ]);
        return  $this->db->run($sSQL);
    }

    public function fncActualizarDetalle(
        $nIdDetalle,
        $nIdProducto,
        $nTotalPedido,
        $nDespachado
    ) {

        $sSQL = $this->db->generateSQLUpdate("guiadetalle", [
            "nIdProducto"  => $nIdProducto,
            "nTotalPedido" => $nTotalPedido,
            "nDespachado"  => $nDespachado
        ], "nIdDetalle = $nIdDetalle");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarDetalle($nIdDetalle)
    {
        $sSQL = $this->db->generateSQLDelete("guiadetalle", " nIdDetalle = $nIdDetalle ");
        return $this->db->run($sSQL);
    }

    public function fncObtenerDetalle($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"      => "det.nIdDetalle ASC",
            "sLimit"        => null,
            "nIdDetalle"    => null,
            "nIdGuia"       => null,
            "nIdProducto"   => null,
            "nEstado"       => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    det.nIdDetalle,
                    det.nIdGuia,
                    det.nIdProducto,
                    det.nTotalPedido,
                    det.nDespachado,
                    prod.sDescripcion AS sProducto
                FROM guiadetalle AS det
                LEFT JOIN productos AS prod ON det.nIdProducto = prod.nIdProducto  
                LEFT JOIN unidadmedidas AS unimedida ON unimedida.nIdUnidadMedida = det.nIdUnidadMedida";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdDetalle"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " det.nIdDetalle = {$this->db->quote($ary['nIdDetalle'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdGuia"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " det.nIdGuia = {$this->db->quote($ary['nIdGuia'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }

    public function fncEliminarItemsDetalle($nIdGuia, $sIdLIst)
    {
        $sSQL = "DELETE FROM guiadetalle WHERE ";
        $sSQL .= ($sIdLIst == '' ? "nIdGuia = '$nIdGuia'" : "nIdGuia = '$nIdGuia' AND nIdDetalle NOT IN ($sIdLIst)");
        return $this->db->run($sSQL);
    }
}
