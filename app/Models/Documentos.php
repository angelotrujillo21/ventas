<?php

namespace Application\Models;

use Application\Core\Database as Database;
use Application\Core\Model;

class Documentos
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarDocumento(
        $nTipoComprobante,
        $sSerieDocumentoComprobante,
        $sNumeroDocumentoComprobante,
        $nTipoDocumento,
        $sNumeroDocumento,
        $sNombreoRazonSocial,
        $nIdPedido,
        $dFechaEmision,
        $nIdEmpleado,
        $sCorreo,
        $nAnulado,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("documentos", [
            "nTipoComprobante"              => $nTipoComprobante,
            "sSerieDocumentoComprobante"    => $sSerieDocumentoComprobante,
            "sNumeroDocumentoComprobante"   => $sNumeroDocumentoComprobante,
            "nTipoDocumento"                => $nTipoDocumento,
            "sNumeroDocumento"              => $sNumeroDocumento,
            "sNombreoRazonSocial"           => $sNombreoRazonSocial,
            "nIdPedido"                     => $nIdPedido,
            "dFechaCreacion"                => "NOW()",
            "dFechaEmision"                 => "STR_TO_DATE( '$dFechaEmision', '%d/%m/%Y' ) ",
            "nIdEmpleado"                   => $nIdEmpleado,
            "sCorreo"                       => $sCorreo,
            "nAnulado"                      => $nAnulado,
            "nEstado"                       => $nEstado
        ]);

        return $this->db->run($sSQL);
    }

    public function fncActualizarAnulado($nIdDocumento,$nAnulado) {

        $sSQL = $this->db->generateSQLUpdate("documentos", [
            "nAnulado"   => $nAnulado,
        ], "nIdDocumento = $nIdDocumento");

        return  $this->db->run($sSQL);
    }


    public function fncActualizarEstado($nIdDocumento,$nEstado) {

        $sSQL = $this->db->generateSQLUpdate("documentos", [
            "nEstado"   => $nEstado,
        ], "nIdDocumento = $nIdDocumento");
        
        return  $this->db->run($sSQL);
    }




    public function fncActualizarDocumento(
        $nIdDocumento,
        $nTipoComprobante,
        $sSerieDocumentoComprobante,
        $sNumeroDocumentoComprobante,
        $nTipoDocumento,
        $sNumeroDocumento,
        $sNombreoRazonSocial,
        $nIdPedido,
        $dFechaEmision,
        $nIdEmpleado,
        $sCorreo,
        $nAnulado,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate(
            "documentos",
            [
                "nTipoComprobante"              => $nTipoComprobante,
                "sSerieDocumentoComprobante"    => $sSerieDocumentoComprobante,
                "sNumeroDocumentoComprobante"   => $sNumeroDocumentoComprobante,
                "nTipoDocumento"                => $nTipoDocumento,
                "sNumeroDocumento"              => $sNumeroDocumento,
                "sNombreoRazonSocial"           => $sNombreoRazonSocial,
                "nIdPedido"                     => $nIdPedido,
                "dFechaCreacion"                => "NOW()",
                "dFechaEmision"                 => "STR_TO_DATE( '$dFechaEmision', '%d/%m/%Y' ) ",
                "nIdEmpleado"                   => $nIdEmpleado,
                "sCorreo"                       => $sCorreo,
                "nAnulado"                      => $nAnulado,
                "nEstado"                       => $nEstado
            ],
            "nIdDocumento = $nIdDocumento"
        );

        return  $this->db->run($sSQL);
    }


    public function fncEliminarRegistro($nIdDocumento)
    {
        $sSQL = $this->db->generateSQLDelete("documentos", " nIdDocumento = $nIdDocumento ");
        return $this->db->run($sSQL);
    }

    public function fncObtenerDocumentos($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"              => "doc.nIdDocumento DESC",
            "sLimit"                => null,
            "nIdDocumento"          => null,
            "nIdPedido"             => null,
            "nIdEmpresa"            => null,
            "nIdSede"               => null,
            "nIdEmpleado"           => null,
            "dFechaInicio"          => null,
            "dFechaFin"             => null,
            "dFechaEmision"         => null,
            "dFechaCreacion"        => null,
            "nEstado"               => null,
            "nIdTipoComprobante"    => null,
            "sEstatusXML"           => null
        ];
         
        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT DISTINCT
                        doc.nIdDocumento,
                        doc.nTipoComprobante,
                        doc.sSerieDocumentoComprobante,
                        doc.sNumeroDocumentoComprobante,
                        doc.nTipoDocumento,
                        doc.sNumeroDocumento,
                        doc.sNombreoRazonSocial,
                        doc.nIdPedido,
                        doc.nIdEmpleado,
                        doc.sCorreo,
                        doc.nAnulado,
                        IFNULL(cli.sNombreoRazonSocial,'') AS sCliente, 
                        IFNULL(cli.sDireccion,'') AS sDireccionCliente, 
                        UPPER(CONCAT(IFNULL( tipomoneda.sDescripcionLargaItem,'' ), ' ')) AS sMoneda, 
                        IFNULL(emp.sNombre , IFNULL(CONCAT(usu.sNombre,' ',usu.sApellidos),'') ) AS sResponsable,
                        IFNULL( DATE_FORMAT( doc.dFechaCreacion, '%d/%m/%Y' ), '' ) as dFechaCreacion, 
                        IFNULL( DATE_FORMAT( doc.dFechaEmision, '%d/%m/%Y' ), '' ) as dFechaEmision, 
                        IFNULL(tipocomprobante.sDescripcionLargaItem,'') AS sTipoComprobante,
                        IFNULL(tipodocumento.sDescripcionCortaItem,'') AS sTipoDocumento,

                        IFNULL(p.sNumero,'') AS sNumeroPedido,
                        IFNULL(p.nFacturado,'') AS nFacturadoPedido,
                        emp.sNombre AS sEmpresa,
 
                        doc.nEstado,
                        p.nIdEmpresa,
                        p.nIdSede,
 
                        doc.statusXML,
                        doc.enlace,
                        doc.aceptada_por_sunat,
                        doc.sunat_description,
                        doc.sunat_note,
                        doc.sunat_responsecode,
                        doc.cadena_para_codigo_qr,
                        doc.codigo_hash,

                        p.nSubTotal as nSubTotalPedido,
                        p.nIgv as nIgvPedido,
                        p.nTotal as nTotalPedido,
                        p.nDespachado as nDespachadoPedido


                FROM documentos AS doc
                LEFT JOIN pedidos AS p ON doc.nIdPedido = p.nIdPedido 
                LEFT JOIN clientes AS cli ON p.nIdCliente = cli.nIdCliente 
                LEFT JOIN empresas AS emp ON p.nIdEmpresa = emp.nIdEmpresa 

                LEFT JOIN empleados AS emp ON p.nIdResponsable = emp.nIdEmpleado
                LEFT JOIN usuarios AS usu ON p.nIdResponsable = usu.nIdUsuario

                LEFT JOIN catalogotabla AS tipocomprobante ON doc.nTipoComprobante = tipocomprobante.nIdCatalogoTabla
                LEFT JOIN catalogotabla AS tipodocumento ON doc.nTipoDocumento =  tipodocumento.nIdCatalogoTabla
                LEFT JOIN catalogotabla AS tipomoneda ON p.nTipoMoneda = tipomoneda.nIdCatalogoTabla

                ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdTipoComprobante"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " doc.nIdTipoComprobante = {$this->db->quote($ary['nIdTipoComprobante'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " doc.nIdDocumento = {$this->db->quote($ary['nIdDocumento'])}  ");
        
        $sWhere .= ($this->db->isNull($ary["nIdPedido"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " doc.nIdPedido = {$this->db->quote($ary['nIdPedido'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpleado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nIdEmpleado = {$this->db->quote($ary['nIdEmpleado'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " doc.dFechaEmision  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['$dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["dFechaEmision"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(doc.dFechaEmision) =  STR_TO_DATE( '" . $ary['dFechaEmision'] . "', '%d/%m/%Y' )  ");

        $sWhere .= ($this->db->isNull($ary["dFechaCreacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(doc.dFechaCreacion) =  STR_TO_DATE( '" . $ary['dFechaCreacion'] . "', '%d/%m/%Y' )  ");

        $sWhere .= ($this->db->isNull($ary["sEstatusXML"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " doc.statusXML = {$this->db->quote($ary['sEstatusXML'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " p.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncActualizarErrorNBFACT(
        $nIdDocumento,
        $error_nubefact
    ) {

        $sSQL =  $this->db->generateSQLUpdate("documentos", [
            "error_nubefact"   => $error_nubefact,
        ], "nIdDocumento = $nIdDocumento");

        return $this->db->run($sSQL);
    }


    public function fncActualizarDatosCPE2(
        $nIdDocumento,
        $statusXML,
        $enlace,
        $aceptada_por_sunat,
        $sunat_description,
        $sunat_note,
        $sunat_responsecode,
        $cadena_para_codigo_qr,
        $codigo_hash
    ) {

        $sSQL =  $this->db->generateSQLUpdate("documentos", [
            "statusXML"                 => $statusXML,
            "enlace"                    => $enlace,
            "aceptada_por_sunat"        => $aceptada_por_sunat,
            "sunat_description"         => $sunat_description,
            "sunat_note"                => $sunat_note,
            "sunat_responsecode"        => $sunat_responsecode,
            "cadena_para_codigo_qr"     => $cadena_para_codigo_qr,
            "codigo_hash"               => $codigo_hash,
            "dFechaEmision"             => "NOW()"
        ], "nIdDocumento = $nIdDocumento");

        return $this->db->run($sSQL);
    }


}
