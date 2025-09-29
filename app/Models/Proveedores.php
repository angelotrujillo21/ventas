<?php

namespace Application\Models;

use Application\Core\Database as Database;
use Application\Core\Model;

class Proveedores
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarProveedor(
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
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("proveedores", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "nTipoDocumento"        => $nTipoDocumento,
            "sNumeroDocumento"      => $sNumeroDocumento,
            "sNombreoRazonSocial"   => $sNombreoRazonSocial,
            "sCorreo"               => $sCorreo,
            "nIdDepartamento"       => $nIdDepartamento,
            "nIdProvincia"          => $nIdProvincia,
            "nIdDistrito"           => $nIdDistrito,
            "sTelefono"             => $sTelefono,
            "sDireccion"            => $sDireccion,
            "nEstado"               => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarProveedor(
        $nIdProveedor,
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
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("proveedores", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "nTipoDocumento"        => $nTipoDocumento,
            "sNumeroDocumento"      => $sNumeroDocumento,
            "sNombreoRazonSocial"   => $sNombreoRazonSocial,
            "sCorreo"               => $sCorreo,
            "nIdDepartamento"       => $nIdDepartamento,
            "nIdProvincia"          => $nIdProvincia,
            "nIdDistrito"           => $nIdDistrito,
            "sTelefono"             => $sTelefono,
            "sDireccion"            => $sDireccion,
            "nEstado"               => $nEstado,
        ], "nIdProveedor = $nIdProveedor");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarProveedor($nIdProveedor)
    {
        $sSQL = $this->db->generateSQLDelete("proveedores", " nIdProveedor = $nIdProveedor ");
        return $this->db->run($sSQL);
    }


    public function fncGetProveedores($aryInput = [])
    {

        $aryAllFilters = [
          //  "sOrderBy"                   => null,
			"sOrderBy"                   => "prove.nIdProveedor DESC",
            "sLimit"                     => null,
            "nIdProveedor"               => null,
            "nIdEmpresa"                 => null,
            "nTipoDocumento"             => null,
            "sNumeroDocumento"           => null,
            "nEstado"                    => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                   prove.nIdProveedor,
                   prove.nIdEmpresa,
                   IFNULL(tipodoc.sDescripcionCortaItem,'') AS sTipoDoc, 
                   prove.nTipoDocumento,
                   prove.sNumeroDocumento,
                   prove.sNombreoRazonSocial,
                   prove.sCorreo,
                   prove.nIdDepartamento,
                   prove.nIdProvincia,
                   prove.nIdDistrito,
                   prove.sTelefono,
                   prove.sDireccion,
                   IFNULL(dpt.sNombre,'') as sDpt ,
                   IFNULL(prov.sNombre,'')  as sProvincia ,
                   IFNULL(dist.sNombre,'') as sDistrito ,
                   prove.nEstado
                FROM proveedores AS prove
                LEFT JOIN departamentos AS dpt ON prove.nIdDepartamento = dpt.nIdDepartamento
                LEFT JOIN provincia AS prov ON prove.nIdProvincia = prov.nIdProvincia
                LEFT JOIN distrito AS dist ON prove.nIdDistrito = dist.nIdDistrito
                LEFT JOIN catalogotabla AS tipodoc ON prove.nTipoDocumento = tipodoc.nIdCatalogoTabla";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdProveedor"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prove.nIdProveedor = {$this->db->quote($ary['nIdProveedor'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prove.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nTipoDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prove.nTipoDocumento = {$this->db->quote($ary['nTipoDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNumeroDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prove.sNumeroDocumento = {$this->db->quote($ary['sNumeroDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prove.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        return $this->db->run(trim($sSQL));
    }
}
