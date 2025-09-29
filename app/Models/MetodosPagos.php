<?php

namespace Application\Models;

use Application\Core\Database as Database;

class MetodosPagos
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarMetodoPago(
        $sNombre,
        $sDescripcion,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("metodospago", [
            "sNombre"                   => $sNombre,
            "sDescripcion"              => $sDescripcion,
            "sImagen"                   => $sImagen,
            "nEstado"                   => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarMetodoPago(
        $nIdMetodoPago,
        $sNombre,
        $sDescripcion,
        $sImagen,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLUpdate("metodospago", [
            "sNombre"                   => $sNombre,
            "sDescripcion"              => $sDescripcion,
            "sImagen"                   => $sImagen,
            "nEstado"                   => $nEstado,
        ], "nIdMetodoPago = $nIdMetodoPago");


        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdMetodoPago)
    {
        $sSQL = $this->db->generateSQLDelete("metodospago", " nIdMetodoPago = $nIdMetodoPago ");
        return $this->db->run($sSQL);
    }


    public function fncGetMetodosPagos($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "nIdMetodoPago"      => null,
            "sNombre"            => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT mp.nIdMetodoPago,
                        mp.sNombre,
                        mp.sDescripcion,
                        mp.sImagen,
                        mp.nEstado
                    FROM metodospago AS mp";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdMetodoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mp.nIdMetodoPago = {$this->db->quote($ary['nIdMetodoPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["sNombre"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mp.sNombre = {$this->db->quote($ary['sNombre'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " mp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        return $this->db->run(trim($sSQL));
    }



    public function fncGrabarSedeMetodoPago(
        $nIdSede,
        $nIdMetodoPago,
        $sDetalle,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("sedesmetodopago", [
            "nIdSede"                   => $nIdSede,
            "nIdMetodoPago"             => $nIdMetodoPago,
            "sDetalle"                  => $sDetalle,
            "sImagen"                   => $sImagen,
            "nEstado"                   => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarSedeMetodoPago(
        $nIdSedeMetodoPago,
        $nIdSede,
        $nIdMetodoPago,
        $sDetalle,
        $sImagen,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("sedesmetodopago", [
            "nIdSede"                   => $nIdSede,
            "nIdMetodoPago"             => $nIdMetodoPago,
            "sDetalle"                  => $sDetalle,
            "sImagen"                   => $sImagen,
            "nEstado"                   => $nEstado,
        ], "nIdSedeMetodoPago = $nIdSedeMetodoPago");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarSedeMetodoPago($nIdSedeMetodoPago)
    {
        $sSQL = $this->db->generateSQLDelete("sedesmetodopago", " nIdSedeMetodoPago = $nIdSedeMetodoPago ");
        return $this->db->run($sSQL);
    }


    
    public function fncGetSedesMetodosPagos($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "nIdSedeMetodoPago"  => null,
            "nIdEmpresa"         => null,
            "nIdSede"            => null,
            "nIdMetodoPago"      => null,
            "sIdsNot"            => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT smp.nIdSedeMetodoPago,
                        smp.nIdSede,
                        smp.nIdMetodoPago,
                        smp.sDetalle,
                        smp.sImagen,
                        UPPER(IFNULL(mp.sNombre,'')) AS sNombrePago,
                        smp.nEstado
                    FROM sedesmetodopago AS smp
                    INNER JOIN metodospago AS mp ON smp.nIdMetodoPago = mp.nIdMetodoPago
                    INNER JOIN sedes AS s ON smp.nIdSede = s.nIdSede";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdSedeMetodoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " smp.nIdSedeMetodoPago = {$this->db->quote($ary['nIdSedeMetodoPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " smp.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");
       
        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " s.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdMetodoPago"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " smp.nIdMetodoPago = {$this->db->quote($ary['nIdMetodoPago'])}  ");

        $sWhere .= ($this->db->isNull($ary["sIdsNot"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " smp.nIdMetodoPago NOT IN (" . $ary['sIdsNot']  .")" );

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " smp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        return $this->db->run(trim($sSQL));
    }

}