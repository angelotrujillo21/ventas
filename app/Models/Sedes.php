<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Sedes
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdEmpresa,
        $sNombre,
        $sDireccion,
        $sTelefono,
        $sEncargado,
        $nTipoMoneda,
        $nTipoTicket,
        $sImagen,
        $sDescripcion,
        $nProduccionSUNAT,
        $sRutaProdSUNAT,
        $sTokenProdSUNAT,
        $sRutaBetaSUNAT,
        $sTokenBetaSUNAT,
        $nEstado,
        $nEnvioAutomaticoSUNAT
    ) {

        $sSQL = $this->db->generateSQLInsert("sedes", [
            "nIdEmpresa"                => $nIdEmpresa,
            "sNombre"                   => $sNombre,
            "sDireccion"                => $sDireccion,
            "sTelefono"                 => $sTelefono,
            "sEncargado"                => $sEncargado,
            "nTipoMoneda"               => $nTipoMoneda,
            "nTipoTicket"               => $nTipoTicket,
            "sImagen"                   => $sImagen,
            "sDescripcion"              => $sDescripcion,
            "nProduccionSUNAT"          => $nProduccionSUNAT,
            "sRutaProdSUNAT"            => $sRutaProdSUNAT,
            "sTokenProdSUNAT"           => $sTokenProdSUNAT,
            "sRutaBetaSUNAT"            => $sRutaBetaSUNAT,
            "sTokenBetaSUNAT"           => $sTokenBetaSUNAT,
            "nEstado"                   => $nEstado,
            "nEnvioAutomaticoSUNAT"     => $nEnvioAutomaticoSUNAT,
        ]);

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $nIdSede,
        $nIdEmpresa,
        $sNombre,
        $sDireccion,
        $sTelefono,
        $sEncargado,
        $nTipoMoneda,
        $nTipoTicket,
        $sImagen,
        $sDescripcion,
        $nProduccionSUNAT,
        $sRutaProdSUNAT,
        $sTokenProdSUNAT,
        $sRutaBetaSUNAT,
        $sTokenBetaSUNAT,
        $nEstado,
        $nEnvioAutomaticoSUNAT
    ) {

        $sSQL = $this->db->generateSQLUpdate("sedes", [
            "nIdEmpresa"                => $nIdEmpresa,
            "sNombre"                   => $sNombre,
            "sDireccion"                => $sDireccion,
            "sTelefono"                 => $sTelefono,
            "sEncargado"                => $sEncargado,
            "nTipoMoneda"               => $nTipoMoneda,
            "nTipoTicket"               => $nTipoTicket,
            "sImagen"                   => $sImagen,
            "sDescripcion"              => $sDescripcion,
            "nProduccionSUNAT"          => $nProduccionSUNAT,
            "sRutaProdSUNAT"            => $sRutaProdSUNAT,
            "sTokenProdSUNAT"           => $sTokenProdSUNAT,
            "sRutaBetaSUNAT"            => $sRutaBetaSUNAT,
            "sTokenBetaSUNAT"           => $sTokenBetaSUNAT,
            "nEstado"                   => $nEstado,
            "nEnvioAutomaticoSUNAT"     => $nEnvioAutomaticoSUNAT,
        ], "nIdSede = $nIdSede");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($nIdSede)
    {
        $sSQL = $this->db->generateSQLDelete("sedes", " nIdSede = $nIdSede ");
        return $this->db->run($sSQL);
    }


    public function fncGetSedes($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"         => null,
            "sLimit"           => null,
            "nIdSede"          => null,
            "nIdEmpresa"       => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT DISTINCT 
                    s.nIdSede,
                    s.nIdEmpresa,
                    s.sNombre,
                    s.sDireccion,
                    s.sTelefono,
                    s.sEncargado,
                    s.nTipoMoneda,
                    s.nTipoTicket,
                    s.sImagen,
                    s.sDescripcion,
                    s.nProduccionSUNAT,
                    s.sRutaProdSUNAT,
                    s.sTokenProdSUNAT,
                    s.sRutaBetaSUNAT,
                    s.sTokenBetaSUNAT,
                    s.nEnvioAutomaticoSUNAT,
                    IFNULL(  emp.sDireccion, '' ) AS sDireccionEmp,
                    IFNULL(  emp.sNumeroDocumento, '' ) AS sNumeroDocEmp,
                    IFNULL( tipodocemp.sDescripcionCortaItem,'' ) AS sTipoDocEmp, 
                    UPPER(CONCAT(IFNULL( tipomoneda.sDescripcionCortaItem,'' ), ' ')) AS sPrefijoMoneda, 
                    IFNULL( tipomoneda.sDescripcionLargaItem,'' ) AS sTipoMoneda, 
                    IFNULL( tipoticket.sDescripcionLargaItem,'' ) AS sTipoTicket, 
                    IFNULL(emp.sImagen , '') AS sImagenEmpresa ,
                    IFNULL(s.sImagen , '') AS sImagenSede,
                    IFNULL(emp.sNombre , '') AS sNombreEmpresa ,
                    IFNULL(emp.sCorreo,'') AS sCorreoEmpresa ,
                    IFNULL(emp.sDescripcion1Ctz,'') AS sDescripcion1Ctz,
                    IFNULL(emp.sDescripcion2Ctz,'') AS sDescripcion2Ctz,
                    IFNULL(emp.sDescripcion3Ctz,'') AS sDescripcion3Ctz,
                    s.nEstado
                FROM sedes AS s 
                LEFT JOIN empresas AS emp ON s.nIdEmpresa = emp.nIdEmpresa
                LEFT JOIN catalogotabla AS tipomoneda ON s.nTipoMoneda = tipomoneda.nIdCatalogoTabla
                LEFT JOIN catalogotabla AS tipoticket ON s.nTipoTicket = tipoticket.nIdCatalogoTabla
                LEFT JOIN catalogotabla AS tipodocemp ON emp.nTipoDocumento = tipodocemp.nIdCatalogoTabla
                ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " s.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " s.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }
}
