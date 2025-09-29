<?php

namespace Application\Models;

use Application\Core\Database as Database;
use Application\Core\Model;

class Roles
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGetRoles($nIdEmpresa)
    {

        // Traer todos menos el super admino dueno del negocio
        $sSQL = "SELECT * FROM roles WHERE nIdRol <> 1 AND nIdEmpresa = $nIdEmpresa";
        return  $this->db->run($sSQL);
    }

    public function fncGetModulos()
    {
        $sSQL = "SELECT * FROM modulos ORDER BY nOrden ASC";
        return  $this->db->run($sSQL);
    }

    public function fncGetRolModulo($nIdRol)
    {
        $sSQL = "SELECT * FROM rolesmodulos as rm INNER JOIN modulos AS m ON rm.nIdModulo = m.nidModulo  WHERE rm.nIdRol = $nIdRol";
        return  $this->db->run($sSQL);
    }

    public function fncGetModulo($nidModulo)
    {
        $sSQL = "SELECT * FROM modulos WHERE nIdModulo = $nidModulo";
        return  $this->db->run($sSQL);
    }

    public function fncGetSubmodulo($nIdModulo, $sExtraField = "")
    {
        $sSQL = "SELECT * $sExtraField FROM submodulos WHERE nIdModulo = $nIdModulo ORDER BY nOrden ASC";
        return  $this->db->run($sSQL);
    }

    public function fncGetSubmoduloForParent($aryInput )
    {


        $aryAllFilters = [
            "sOrderBy"         => "sub.nOrden ASC",
            "sLimit"           => null,
            "nIdModulo"        => null,
            "nIdPadre"         => null,
             
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT * FROM submodulos AS sub";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdModulo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sub.nIdModulo = {$this->db->quote($ary['nIdModulo'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdPadre"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " sub.nIdPadre = {$this->db->quote($ary['nIdPadre'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }

    public function fncGetRolesSubModulos($nIdRolModulo)
    {
        $sSQL = "SELECT rolsubmod.nIdRolSubmodulo,
                        rolsubmod.nIdRolModulo,
                        rolsubmod.nIdSubModulo,
                        rolsubmod.nRolSubModulo,
                        IFNULL(sub.nExisteRol,'') AS nExisteRol,
                        IFNULL(sub.sUrl,'') AS sUrl,
                        IFNULL(sub.sNombreSubmodulo,'') AS sNombreSubmodulo,
                        IFNULL(sub.sIconoSubmodulo,'') AS sIconoSubmodulo,
                        IFNULL(sub.nIdPadre,'') AS nIdPadre,
                        IFNULL(rolsubmod.nDefault , 0) AS nDefault
                FROM rolessubmodulos AS rolsubmod 
                INNER JOIN submodulos AS sub ON rolsubmod.nIdSubModulo = sub.nIdSubModulo 
                WHERE rolsubmod.nIdRolModulo = $nIdRolModulo ";
        return  $this->db->run($sSQL);
    }

    public function fncObtenerRolSubModuloByIdRol($nIdRol, $sUrl)
    {
        $sSQL = "SELECT sub.nIdSubModulo , rolsub.nRolSubModulo  FROM  roles as rol
        INNER JOIN rolesmodulos AS rolmod ON rol.nIdRol = rolmod.nIdRol
        INNER JOIN rolessubmodulos AS rolsub ON rolmod.nIdRolModulo = rolsub.nIdRolModulo
        INNER JOIN submodulos AS sub ON rolsub.nIdSubModulo = sub.nIdSubModulo
        WHERE rol.nIdRol = $nIdRol AND sub.sUrl = '$sUrl'";
        return  $this->db->run($sSQL);
    }

    public function fncGetSubModuloDefaultByIdRol($nIdRol)
    {
        $sSQL = "SELECT rolsubmod.nIdSubModulo , sub.sNombreSubmodulo , sub.sUrl  FROM rolesmodulos AS rolmod
        INNER JOIN rolessubmodulos AS rolsubmod ON rolmod.nIdRolModulo = rolsubmod.nIdRolModulo
        INNER JOIN submodulos AS sub ON sub.nIdSubModulo = rolsubmod.nIdSubModulo
        WHERE rolsubmod.nDefault = 1 AND rolmod.nIdRol = $nIdRol LIMIT 1";
        return  $this->db->run($sSQL);
    }

    public function fncGrabarRol($sNombreRol, $nIdEmpresa, $sDetalle)
    {
        $sSQL = $this->db->generateSQLInsert("roles", [
            "sNombreRol"     => $sNombreRol,
            "nIdEmpresa"     => $nIdEmpresa,
            "sDetalle"       => $sDetalle
        ]);

        return $this->db->run($sSQL);
    }


    public function fncActualizarRol($nIdRol, $sNombreRol, $nIdEmpresa, $sDetalle)
    {
        $sSQL = $this->db->generateSQLUpdate(
            "roles",
            [
                "sNombreRol"     => $sNombreRol,
                "nIdEmpresa"     => $nIdEmpresa,
                "sDetalle"       => $sDetalle
            ],
            "nIdRol = $nIdRol"
        );

        return  $this->db->run($sSQL);
    }


    public function fncObtenerRolById($nIdRol)
    {
        $sSQL = "SELECT rol.nIdRol, rol.sNombreRol, rol.sDetalle  FROM roles AS rol WHERE nIdRol = $nIdRol ";
        return $this->db->run($sSQL);
    }


    public function fncEliminarRol($nIdRol)
    {
        $sSQL = $this->db->generateSQLDelete("roles", " nIdRol = $nIdRol ");
        return $this->db->run($sSQL);
    }


    public function fncGrabarRolModulo(
        $nIdRol,
        $nIdModulo
    ) {
        $sSQL = $this->db->generateSQLInsert("rolesmodulos", [
            "nIdRol"        => $nIdRol,
            "nIdModulo"     => $nIdModulo,
        ]);

        return  $this->db->run($sSQL);
    }



    public function fncEliminarRolesModulosByIdRol($nIdRol)
    {
        $sSQL = $this->db->generateSQLDelete("rolesmodulos", " nIdRol = $nIdRol ");
        return  $this->db->run($sSQL);
    }

    public function fncGrabarRolSubModulo($nIdRolModulo, $nIdSubModulo, $nDefault, $nRolSubModulo)
    {
        $sSQL = $this->db->generateSQLInsert("rolessubmodulos", [
            "nIdRolModulo"     => $nIdRolModulo,
            "nIdSubModulo"     => $nIdSubModulo,
            "nDefault"         => $nDefault,
            "nRolSubModulo"    => $nRolSubModulo
        ]);
        return $this->db->run($sSQL);
    }

    public function fncEliminarRolesSubModuloByIdRolModulo($nIdRolModulo)
    {
        $sSQL = $this->db->generateSQLDelete("rolessubmodulos", " nIdRolModulo = $nIdRolModulo ");
        return  $this->db->run($sSQL);
    }
}
