<?php

namespace Application\Models;

use Application\Core\Database as Database;
use Application\Core\Model;

class Categorias
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarCategoria(
        $nIdSede,
        $sNombre,
        $sImagen,
        $nIdPadre,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("categorias", [
            "nIdSede"    => $nIdSede,
            "sNombre"    => $sNombre,
            "sImagen"    => $sImagen,
            "nIdPadre"   => $nIdPadre,
            "nEstado"    => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarCategoria(
        $nIdCategoria,
        $nIdSede,
        $sNombre,
        $sImagen,
        $nIdPadre,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("categorias", [
            "nIdSede"    => $nIdSede,
            "sNombre"    => $sNombre,
            "sImagen"    => $sImagen,
            "nIdPadre"   => $nIdPadre,
            "nEstado"    => $nEstado,
        ], " nIdCategoria = $nIdCategoria ");

        return  $this->db->run($sSQL);
    }


    public function fncEliminarCategoria($nIdCategoria)
    {
        $sSQL = $this->db->generateSQLDelete("categorias", " nIdCategoria = $nIdCategoria ");
        $this->db->run($sSQL);
    }


    public function fncGetCategorias($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"                   => null,
            "sLimit"                     => null,
            "nIdCategoria"               => null,
            "nIdSede"                    => null,
            "nIdPadre"                   => null,
            "nEstado"                    => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT cat.nIdCategoria, 
                        cat.nIdSede,
                        cat.sNombre, 
                        cat.sImagen, 
                        cat.nIdPadre, 
                        IFNULL((SELECT catsub.sNombre FROM categorias AS catsub WHERE catsub.nIdCategoria = cat.nIdPadre LIMIT 1), 'NINGUNA') AS sNombrePadre,
                        cat.nEstado 
                FROM categorias AS cat";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCategoria"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cat.nIdCategoria = {$this->db->quote($ary['nIdCategoria'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cat.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");
        
        $sWhere .= ($this->db->isNull($ary["nIdPadre"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cat.nIdPadre = {$this->db->quote($ary['nIdPadre'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cat.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);


        return $this->db->run(trim($sSQL));
    }

 
}
