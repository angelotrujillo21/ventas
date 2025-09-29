<?php

namespace Application\Models;

use Application\Core\Database as Database;

class Cotizacion
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarRegistro(
        $nIdEmpresa,
        $nIdSede,
        $sSerie,
        $nCorrelativo,
        $sNumero,
        $nIdCliente,
        $dFechaCotizacion,
        $nFlagIGV,
        $nBaseImponible,
        $nDescuento,
        $nNeto,
        $nImpuesto,
        $nTotal,
        $nIdFormaPago,
        
        $nIdMoneda,
        $sObservacion,
        $nEstado,
        $nIdCondicionComercial,
        $nCotizacion
    ) {

        $sSQL = $this->db->generateSQLInsert("cotizacion", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sSerie"                => $sSerie,
            "nCorrelativo"          => $nCorrelativo,
            "sNumero"               => $sNumero,
            "nIdCliente"            => $nIdCliente,
            "dFechaCotizacion"      => $dFechaCotizacion,
            "nFlagIGV"              => $nFlagIGV,
            "nBaseImponible"        => $nBaseImponible,
            "nDescuento"            => $nDescuento,
            "nNeto"                 => $nNeto,
            "nImpuesto"             => $nImpuesto,
            "nTotal"                => $nTotal,
            "nIdFormaPago"          => $nIdFormaPago,
           
            "nEstado"               => $nEstado,
            "nIdMoneda"             => $nIdMoneda,
            "sObservacion"          => $sObservacion,
            "dFechaCreacion"        => "NOW()",
            "nIdCondicionComercial" =>$nIdCondicionComercial,
            "nCotizacion"           =>$nCotizacion,

        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarRegistro(
        $nIdCotizacion,
        $nIdCliente,
        $dFechaCotizacion,
        $nFlagIGV,
        $nBaseImponible,
        $nDescuento,
        $nNeto,
        $nImpuesto,
        $nTotal,
        $nIdFormaPago,
       
        $nEstado,
        $nIdMoneda,
        $sObservacion,
        $nIdCondicionComercial,
        $nCotizacion
    ) {

        $sSQL = $this->db->generateSQLUpdate("cotizacion", [
        
            "nIdCliente"            => $nIdCliente,
            "dFechaCotizacion"      => $dFechaCotizacion,
            "nFlagIGV"              => $nFlagIGV,
            "nBaseImponible"        => $nBaseImponible,
            "nDescuento"            => $nDescuento,
            "nNeto"                 => $nNeto,
            "nImpuesto"             => $nImpuesto,
            "nTotal"                => $nTotal,
            "nIdFormaPago"          => $nIdFormaPago,
           
            "nEstado"               => $nEstado,
            "nIdMoneda"             => $nIdMoneda,
            "sObservacion"          => $sObservacion,
            "dFechaEdicion"         => "NOW()",
            "nIdCondicionComercial" =>$nIdCondicionComercial,
            "nCotizacion"           =>$nCotizacion,


        ], "nIdCotizacion = $nIdCotizacion");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarCotizacion($nIdCotizacion)
    {
        $sSQL = $this->db->generateSQLDelete("cotizacion", " nIdCotizacion = $nIdCotizacion ");
        $this->db->run($sSQL);
    }

    public function fncObtenerCotizacion($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "ctz.nIdCotizacion ASC",
            "sLimit"               => null,
            "nIdCotizacion"        => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "nEstado"              => null,
            "sIdsCliente"          => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "nVendido"             => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT ctz.nIdCotizacion, ctz.nIdEmpresa, ctz.nIdSede, ctz.sSerie, ctz.nCorrelativo, ctz.sNumero, ctz.nIdCliente,
                  ctz.dFechaCotizacion AS dFechaCotizacionDate,
                  IFNULL( DATE_FORMAT( ctz.dFechaCotizacion, '%d/%m/%Y' ), '' ) as dFechaCotizacion, 
                  ctz.nFlagIGV, ctz.nBaseImponible, ctz.nDescuento, ctz.nNeto, ctz.nImpuesto, ctz.nTotal, ctz.nIdFormaPago, ctz.nIdMoneda, 
                  IFNULL( DATE_FORMAT( ctz.dFechaCreacion, '%d/%m/%Y' ), '' ) as dFechaCreacion,  IFNULL( DATE_FORMAT( ctz.dFechaEdicion, '%d/%m/%Y' ), '' ) as dFechaEdicion,
                  ctz.nEstado, IFNULL(cli.sNumeroDocumento,'') AS sNumeroDocumentoCliente,  IFNULL(cli.nTipoDocumento,'') AS nTipoDocumentoCliente,  
                  IFNULL(cli.sNombreoRazonSocial,'') AS sCliente, IFNULL(ctz.sObservacion,'') AS sObservacion,
                  ctz.nVendido,
                  IFNULL(ctz.nIdCondicionComercial,0) AS nIdCondicionComercial,
                  IFNULL(tipodoc.sDescripcionCortaItem,'') AS sTipoDocCliente,
                  IFNULL(cli.sDireccion,'') AS sDireccionCliente,
                  IFNULL(cc.sNombre,'') AS sCondicionComercial,
                  IFNULL(cc.sTiempoEntrega,'') AS  sTiempoEntregaCC,
                  IFNULL(cc.sFormaPago,'') AS  sFormaPagoCC,
                  IFNULL(cc.sLugarEntrega,'') AS  sLugarEntregaCC,
                  IFNULL(cc.sGarantia,'') AS  sGarantiaCC,
                  IFNULL(cc.sValidezOferta,'') AS  sValidezOfertaCC,
                  IFNULL(moneda.sDescripcionCortaItem,'') AS sMoneda
                FROM cotizacion AS ctz
                LEFT JOIN catalogotabla AS moneda ON ctz.nIdMoneda = moneda.nIdCatalogoTabla
                LEFT JOIN condicioncomercial cc ON cc.nIdCondicionComercial = ctz.nIdCondicionComercial
                LEFT JOIN clientes AS cli ON ctz.nIdCliente = cli.nIdCliente
                LEFT JOIN catalogotabla AS tipodoc ON cli.nTipoDocumento = tipodoc.nIdCatalogoTabla  ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCotizacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ctz.nIdCotizacion = {$this->db->quote($ary['nIdCotizacion'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ctz.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["sIdsCliente"]) || empty($ary["sIdsCliente"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ctz.nIdCLiente IN(" . $ary["sIdsCliente"]. ")");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(ctz.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ctz.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ctz.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sWhere .= ($this->db->isNull($ary["nVendido"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ctz.nVendido = {$this->db->quote($ary['nVendido'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }




    public function fncGrabarDetalle(
        $nIdCotizacion,
        $nIdProducto,
        $nIdUnidadMedida,
        $nCantidad,
        $nPrecio,
        $nSubTotal,
        $nPorcentajeDsct,
        $nDescuento,
        $nTotal,
        $sObservacion
    ) {

        $sSQL = $this->db->generateSQLInsert("cotizaciondetalle", [
            "nIdCotizacion"      => $nIdCotizacion,
            "nIdProducto"        => $nIdProducto,
            "nIdUnidadMedida"    => $nIdUnidadMedida,
            "nCantidad"          => $nCantidad,
            "nPrecio"            => $nPrecio,
            "nSubTotal"          => $nSubTotal,
            "nPorcentajeDsct"    => $nPorcentajeDsct,
            "nDescuento"         => $nDescuento,
            "nTotal"             => $nTotal,
            "sObservacion"       => $sObservacion,
        ]);
        return  $this->db->run($sSQL);
    }

    public function fncActualizarDetalle(
        $nIdDetalle,
        $nIdProducto,
        $nIdUnidadMedida,
        $nCantidad,
        $nPrecio,
        $nSubTotal,
        $nPorcentajeDsct,
        $nDescuento,
        $nTotal,
        $sObservacion
    ) {

        $sSQL = $this->db->generateSQLUpdate("cotizaciondetalle", [
            "nIdProducto"        => $nIdProducto,
            "nIdUnidadMedida"    => $nIdUnidadMedida,
            "nCantidad"          => $nCantidad,
            "nPrecio"            => $nPrecio,
            "nSubTotal"          => $nSubTotal,
            "nPorcentajeDsct"    => $nPorcentajeDsct,
            "nDescuento"         => $nDescuento,
            "nTotal"             => $nTotal,
            "sObservacion"       => $sObservacion,
        ], "nIdDetalle = $nIdDetalle");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarDetalle($nIdDetalle)
    {
        $sSQL = $this->db->generateSQLDelete("cotizaciondetalle", " nIdDetalle = $nIdDetalle ");
        return $this->db->run($sSQL);
    }

    public function fncObtenerDetalle($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"                => "det.nIdDetalle ASC",
            "sLimit"                  => null,
            "nIdDetalle"              => null,
            "nIdCotizacion"           => null,
            "nEstado"                 => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    det.nIdDetalle,
                    det.nIdCotizacion,
                    det.nIdProducto,
                    det.nIdUnidadMedida,
                    det.nCantidad,
                    det.nPrecio,
                    det.nSubTotal,
                    det.nPorcentajeDsct,
                    det.nDescuento,
                    det.sObservacion,
                    det.nTotal,
                    UPPER(prod.sDescripcion) AS sProducto, 
                    IFNULL( prod.sImagen , '' )  AS sImagenProducto,
                    IFNULL( unimedida.sNombreLargo ,'' ) AS sUnidadMedida,
                    IFNULL( unimedida.sNombreCorto ,'' ) AS sUnidadMedidaCorto,
                    prod.sCodigoInterno AS sCodigoInternoProducto 
                FROM cotizaciondetalle AS det
                LEFT JOIN productos AS prod ON det.nIdProducto = prod.nIdProducto  
                LEFT JOIN unidadmedidas AS unimedida ON unimedida.nIdUnidadMedida = det.nIdUnidadMedida";


        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdDetalle"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " det.nIdDetalle = {$this->db->quote($ary['nIdDetalle'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdCotizacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " det.nIdCotizacion = {$this->db->quote($ary['nIdCotizacion'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " det.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }

    public function fncEliminarItemsDetalle($nIdCotizacion, $sIdLIst)
    {
        $sSQL = "DELETE FROM cotizaciondetalle WHERE ";
        $sSQL .= ($sIdLIst == '' ? "nIdCotizacion = '$nIdCotizacion'" : "nIdCotizacion = '$nIdCotizacion' AND nIdDetalle NOT IN ($sIdLIst)");
        return $this->db->run($sSQL);
    }

    public function fncActualizarFlagVendido($nIdCotizacion, $nVendido)
    {
        $sSQL = "UPDATE cotizacion SET nVendido = $nVendido WHERE nIdCotizacion = $nIdCotizacion";
        return $this->db->run($sSQL);
    }


}
