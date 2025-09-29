<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Users
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarUsuario(
        $sNombre,
        $sApellidos,
        $sLogin,
        $sClave,
        $sImagen,
        $nIdRol,
        $sCorreo,
        $sImagenFondoLogin,
        $sImagenLogoGeneral,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("usuarios", [
            "sNombre"                   => $sNombre,
            "sApellidos"                => $sApellidos,
            "sLogin"                    => $sLogin,
            "sClave"                    => $sClave,
            "nIdRol"                    => $nIdRol,
            "sImagen"                   => $sImagen,
            "sCorreo"                   => $sCorreo,
            "sImagenFondoLogin"         => $sImagenFondoLogin,
            "sImagenLogoGeneral"        => $sImagenLogoGeneral,
            "nEstado"                   => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarUsuario(
        $nIdUsuario,
        $sNombre,
        $sApellidos,
        $sLogin,
        $sClave,
        $sImagen,
        $nIdRol,
        $sCorreo,
        $sImagenFondoLogin,
        $sImagenLogoGeneral,
        $nEstado
    ) {



        $sSQL = $this->db->generateSQLUpdate("usuarios", [
            "sNombre"                   => $sNombre,
            "sApellidos"                => $sApellidos,
            "sLogin"                    => $sLogin,
            "sClave"                    => $sClave,
            "nIdRol"                    => $nIdRol,
            "sImagen"                   => $sImagen,
            "sCorreo"                   => $sCorreo,
            "sImagenFondoLogin"         => $sImagenFondoLogin,
            "sImagenLogoGeneral"        => $sImagenLogoGeneral,
            "nEstado"                   => $nEstado,
        ], "nIdUsuario = $nIdUsuario");


        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncEliminarUsuario($nIdUsuario)
    {
        $sSQL = $this->db->generateSQLDelete("usuarios", " nIdUsuario = $nIdUsuario ");
        return $this->db->run($sSQL);
    }


    public function fncGetUsuarios($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "nIdUsuario"         => null,
            "nIdUsuarioNot"      => null,
            "sLogin"             => null,
            "sClave"             => null,
            "sCorreo"            => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT usu.nIdUsuario, 
                        usu.sNombre, 
                        rol.sNombreRol, 
                        usu.sApellidos, 
                        usu.sLogin, 
                        usu.sClave, 
                        usu.sImagen, 
                        usu.sCorreo, 
                        usu.nIdRol,
                        IFNULL(usu.sImagenFondoLogin, '') AS sImagenFondoLogin,
                        IFNULL(usu.sImagenLogoGeneral,'') AS sImagenLogoGeneral,
                        usu.nEstado 
                    FROM usuarios AS usu
                    INNER JOIN roles as rol ON usu.nIdRol = rol.nIdRol";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdUsuario"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.nIdUsuario = {$this->db->quote($ary['nIdUsuario'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdUsuarioNot"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.nIdUsuario <> {$this->db->quote($ary['nIdUsuarioNot'])}  ");

        $sWhere .= ($this->db->isNull($ary["sLogin"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.sLogin = {$this->db->quote($ary['sLogin'])}  ");

        $sWhere .= ($this->db->isNull($ary["sClave"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.sClave = {$this->db->quote($ary['sClave'])}  ");

        $sWhere .= ($this->db->isNull($ary["sCorreo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.sCorreo = {$this->db->quote($ary['sCorreo'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return ($this->db->run(trim($sSQL)));
    }
}
