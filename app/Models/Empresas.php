<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Empresas
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }



    public function fncGrabarRegistro(
        $nIdUsuario,
        $nTipoDocumento,
        $sNumeroDocumento,
        $sNombre,
        $sDireccion,
        $sCorreo,
        $sTelefono,
        $sImagen,
        $sImagenFondoLogin,
        $nEstado,
        $sDescripcion1Ctz,
        $sDescripcion2Ctz,
        $sDescripcion3Ctz
    ) {

        $sSQL = $this->db->generateSQLInsert("empresas", [
            "nIdUsuario"                => $nIdUsuario,
            "nTipoDocumento"            => $nTipoDocumento,
            "sNumeroDocumento"          => $sNumeroDocumento,
            "sNombre"                   => $sNombre,
            "dFechaCreacion"            => "NOW()",
            "sDireccion"                => $sDireccion,
            "sTelefono"                 => $sTelefono,
            "sCorreo"                   => $sCorreo,
            "sImagen"                   => $sImagen,
            "sImagenFondoLogin"         => $sImagenFondoLogin,
            "nEstado"                   => $nEstado,

            "sDescripcion1Ctz"                   => $sDescripcion1Ctz,
            "sDescripcion2Ctz"                   => $sDescripcion2Ctz,
            "sDescripcion3Ctz"                   => $sDescripcion3Ctz,

        ]);

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $nIdEmpresa,
        $nIdUsuario,
        $nTipoDocumento,
        $sNumeroDocumento,
        $sNombre,
        $sDireccion,
        $sCorreo,
        $sTelefono,
        $sImagen,
        $sImagenFondoLogin,
        $nEstado,
        $sDescripcion1Ctz,
        $sDescripcion2Ctz,
        $sDescripcion3Ctz
    ) {

        $sSQL = $this->db->generateSQLUpdate("empresas", [
            "nIdUsuario"                => $nIdUsuario,
            "nTipoDocumento"            => $nTipoDocumento,
            "sNumeroDocumento"          => $sNumeroDocumento,
            "sNombre"                   => $sNombre,
            "sDireccion"                => $sDireccion,
            "sTelefono"                 => $sTelefono,
            "sCorreo"                   => $sCorreo,
            "sImagen"                   => $sImagen,
            "sImagenFondoLogin"         => $sImagenFondoLogin,
            "nEstado"                   => $nEstado,
            "sDescripcion1Ctz"                   => $sDescripcion1Ctz,
            "sDescripcion2Ctz"                   => $sDescripcion2Ctz,
            "sDescripcion3Ctz"                   => $sDescripcion3Ctz,
        ], "nIdEmpresa = $nIdEmpresa");

    //     echo $sSQL;
    // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($nIdEmpresa)
    {
        $sSQL = $this->db->generateSQLDelete("empresas", " nIdEmpresa = $nIdEmpresa ");
        return $this->db->run($sSQL);
    }


    public function fncGetEmpresas($aryInput = []) {

        $aryAllFilters = [
            "sOrderBy"         => null,
            "sLimit"           => null,
            "nIdEmpresa"       => null,
            "nIdUsuario"       => null,
            "nTipoDocumento"   => null,
            "sNumeroDocumento" => null,
            "sCorreo"          => null,
            "nEstado"          => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    emp.nIdEmpresa,
                    emp.nTipoDocumento,
                    emp.sNumeroDocumento,
                    emp.sNombre,
                    emp.nIdUsuario,
                    IFNULL( tipodoc.sDescripcionCortaItem,'' ) AS sTipoDoc, 
                    IFNULL( DATE_FORMAT( emp.dFechaCreacion , '%d/%m/%Y %H:%i:%s' ), '' ) as dFechaCreacion,
                    IFNULL( DATE_FORMAT( emp.dFechaEdicion , '%d/%m/%Y %H:%i:%s' ), '' ) as dFechaEdicion,
                    emp.sDireccion,
                    emp.sCorreo,
                    emp.sTelefono,
                    emp.sImagen,
                    IFNULL(emp.sImagenFondoLogin,'') AS sImagenFondoLogin,
                    IFNULL(usu.sImagenFondoLogin,'') AS sImagenFondoLoginUsuario,
                    IFNULL(usu.sImagenLogoGeneral,'') AS sImagenLogoGeneralUsuario,
                    emp.nEstado,
                    IFNULL(emp.sDescripcion1Ctz,'') AS sDescripcion1Ctz,
                    IFNULL(emp.sDescripcion2Ctz,'') AS sDescripcion2Ctz,
                    IFNULL(emp.sDescripcion3Ctz,'') AS sDescripcion3Ctz
                FROM empresas AS emp 
                LEFT JOIN catalogotabla AS tipodoc ON emp.nTipoDocumento = tipodoc.nIdCatalogoTabla
                LEFT JOIN usuarios AS usu ON emp.nIdUsuario = usu.nIdUsuario

                ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdUsuario"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nIdUsuario = {$this->db->quote($ary['nIdUsuario'])}  ");

        $sWhere .= ($this->db->isNull($ary["nTipoDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nTipoDocumento = {$this->db->quote($ary['nTipoDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNumeroDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.sNumeroDocumento = {$this->db->quote($ary['sNumeroDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary["sCorreo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.sCorreo = {$this->db->quote($ary['sCorreo'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " emp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
