<?php

namespace Application\Models;

use Application\Core\Database as Database;

class OrdenCompra
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarOrdenCompra(
        $nIdEmpresa,
        $nIdSede,
        $nIdCaja,
        $nIdResponsable,
        $sDescripcion,
        $dFechaOrdenCompra,
        $nProcesado,
        $nTipoMoneda,
        $nTipo,
        $nEjecutado,
        $nSubTotal,
        $nIgv,
        $nTotal,
        $nIdProveedor,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLInsert("ordencompra", [
            "nIdEmpresa"         => $nIdEmpresa,
            "nIdSede"            => $nIdSede,
            "nIdCaja"            => $nIdCaja,

            "nIdResponsable"     => $nIdResponsable,
            "sDescripcion"       => $sDescripcion,
            "dFechaOrdenCompra"  => "STR_TO_DATE( '$dFechaOrdenCompra', '%d/%m/%Y' ) ",
            "nProcesado"         => $nProcesado,
            "dFechaCreacion"     => "NOW()",
            "nTipoMoneda"        => $nTipoMoneda,
            "nTipo"              => $nTipo,
            "nEjecutado"         => $nEjecutado,
            "nSubTotal"          => $nSubTotal,
            "nIgv"               => $nIgv,
            "nTotal"             => $nTotal,
            "nIdProveedor"       => $nIdProveedor == 0 ? null : $nIdProveedor,
            "nEstado"            => $nEstado
            
        ]);

        return $this->db->run($sSQL);
    }


    public function fncActualizarOrdenCompra(
        $nIdOrdenCompra,
        $nIdEmpresa,
        $nIdSede,
        $nIdCaja,
        $nIdResponsable,
        $sDescripcion,
        $dFechaOrdenCompra,
        $nProcesado,
        $nTipoMoneda,
        $nTipo,
        $nEjecutado,
        $nSubTotal,
        $nIgv,
        $nTotal,
        $nIdProveedor,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("ordencompra", [
            "nIdEmpresa"         => $nIdEmpresa,
            "nIdSede"            => $nIdSede,
            "nIdCaja"            => $nIdCaja,
            "nIdResponsable"     => $nIdResponsable,
            "sDescripcion"       => $sDescripcion,
            "dFechaOrdenCompra"  => "STR_TO_DATE( '$dFechaOrdenCompra', '%d/%m/%Y' ) ",
            "nProcesado"         => $nProcesado,
            "dFechaCreacion"     => "NOW()",
            "nTipoMoneda"        => $nTipoMoneda,
            "nTipo"              => $nTipo,
            "nEjecutado"         => $nEjecutado,
            "nSubTotal"          => $nSubTotal,
            "nIgv"               => $nIgv,
            "nTotal"             => $nTotal,
            "nIdProveedor"       => $nIdProveedor == 0 ? null : $nIdProveedor,

            "nEstado"            => $nEstado,
        ], "nIdOrdenCompra = $nIdOrdenCompra");

        return $this->db->run($sSQL);
    }


    # Este Metodo sirve para cambiar es estado de procesado es decir si esque sesta orden de compra se ha utilizado para realizar alguna entrada de almacen
    public function fncActualizarProcesado(
        $nIdOrdenCompra,
        $nProcesado
    ) {

        $sSQL = $this->db->generateSQLUpdate("ordencompra", [
            "nProcesado"         => $nProcesado,
        ], "nIdOrdenCompra = $nIdOrdenCompra");

        return $this->db->run($sSQL);
    }

    # Este metodo sirve para cambiar es estado de ejecucion es decir si esque la Orden de compra esta ejecutada o planificada 

    public function fncActualizarEjecutado(
        $nIdOrdenCompra,
        $nEjecutado
    ) {

        $sSQL = $this->db->generateSQLUpdate("ordencompra", [
            "nEjecutado"   => $nEjecutado,
        ], "nIdOrdenCompra = $nIdOrdenCompra");

        return $this->db->run($sSQL);
    }


    public function fncActualizarEstadpRegistroDocumento(
        $nIdOrdenCompra,
        $nEstadoRegistroDocumentos
    ) {

        $sSQL = $this->db->generateSQLUpdate("ordencompra", [
            "nEstadoRegistroDocumentos"   => $nEstadoRegistroDocumentos,
        ], "nIdOrdenCompra = $nIdOrdenCompra");

        return $this->db->run($sSQL);
    }


    public function fncEliminarOrdenCompra($nIdOrdenCompra)
    {
        $sSQL = $this->db->generateSQLDelete("ordencompra", " nIdOrdenCompra = $nIdOrdenCompra ");
        return $this->db->run($sSQL);
    }

    public function fncObtenerOrdenCompra($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => "oc.nIdOrdenCompra DESC",
            "sLimit"             => null,
            "nIdOrdenCompra"     => null,
            "aryIdsOC"           => null,
            "nIdEmpresa"         => null,
            "nIdSede"            => null,
            "aryIdSede"          => null,
            "nIdCompra"          => null,
            "nIdResponsable"     => null,
            "aryProductos"       => null,
            "dFechaInicio"       => null,
            "dFechaFin"          => null,
            "dFechaCreacion"     => null,
            "nProcesado"         => null,
            "nTipo"              => null,
            "nEjecutado"         => null,
            "nIdCaja"            => null,
            "nEstadoRegistroDocumentos"        => null,
            "nEstado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT DISTINCT
                        oc.nIdCaja,  
                        oc.nIdOrdenCompra,  
                        oc.nIdEmpresa,  
                        oc.nIdSede , 
                        oc.nIdResponsable,  
                        oc.sDescripcion,  
                        oc.nTipo,
                        UPPER(CONCAT(IFNULL( tipomoneda.sDescripcionCortaItem,'' ), ' ')) AS sPrefijoMoneda, 
                        IFNULL(emp.sNombre , IFNULL(CONCAT(usu.sNombre,' ',usu.sApellidos),'') ) AS sResponsable,
                        IFNULL( DATE_FORMAT( oc.dFechaCreacion, '%d/%m/%Y' ), '' ) AS dFechaCreacion,  
                        IFNULL( DATE_FORMAT( oc.dFechaOrdenCompra, '%d/%m/%Y' ), '' ) AS dFechaOrdenCompra, 
                        IFNULL(caj.sDescripcion, '') AS sCaja,
                        oc.nIdProveedor,
                        oc.nProcesado,  
                        oc.nEjecutado,
                        oc.nTotal,
                        oc.nEstadoRegistroDocumentos,
                        oc.nEstado
            FROM ordencompra AS oc
            LEFT JOIN ordencompradetalle AS ocd ON oc.nIdOrdenCompra = ocd.nIdOrdenCompra
            LEFT JOIN empleados AS emp ON oc.nIdResponsable = emp.nIdEmpleado
            LEFT JOIN usuarios AS usu ON oc.nIdResponsable = usu.nIdUsuario
            LEFT JOIN catalogotabla AS tipomoneda ON oc.nTipoMoneda = tipomoneda.nIdCatalogoTabla
            LEFT JOIN cajas AS caj ON oc.nIdCaja = caj.nIdCaja";

        $sWhere = "";


        $sWhere .= ($this->db->isNull($ary["nIdOrdenCompra"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nIdOrdenCompra = {$this->db->quote($ary['nIdOrdenCompra'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdsOC"])  && !is_array($ary["aryIdsOC"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' ocd.nIdOrdenCompra IN (' . implode(",", $ary['aryIdsOC']) . ')');

        $sWhere .= ($this->db->isNull($ary["nIdResponsable"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nIdResponsable = {$this->db->quote($ary['nIdResponsable'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdCaja"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nIdCaja = {$this->db->quote($ary['nIdCaja'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryIdSede"]) && !is_array($ary["aryIdSede"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' oc.nIdSede IN (' . implode(",", $ary['aryIdSede']) . ')');

        $sWhere .= ($this->db->isNull($ary["dFechaCreacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " DATE(oc.dFechaCreacion) =  STR_TO_DATE( '" . $ary['dFechaCreacion'] . "', '%d/%m/%Y' )  ");

        $sWhere .= ($this->db->isNull($ary["aryProductos"])  && !is_array($ary["aryProductos"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' ocd.nIdProducto IN (' . implode(",", $ary['aryProductos']) . ')');

        $sWhere .= ($this->db->isNull($ary['dFechaInicio'])  && $this->db->isNull($ary['dFechaFin'])  ? "" : (strlen($sWhere) > 0 ? " AND " : '') . "  DATE(oc.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nProcesado"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nProcesado = {$this->db->quote($ary['nProcesado'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEjecutado"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nEjecutado = {$this->db->quote($ary['nEjecutado'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstadoRegistroDocumentos"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nEstadoRegistroDocumentos = {$this->db->quote($ary['nEstadoRegistroDocumentos'])}  ");

        $sWhere .= ($this->db->isNull($ary["nTipo"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nTipo = {$this->db->quote($ary['nTipo'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }




    public function fncGrabarOrdenCompraDetalle(
        $nIdOrdenCompra,
        $nIdProducto,
        $nIdProveedor,
        $nCantidad,
        $nPrecio,
        $nIdUnidadMedida,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLInsert("ordencompradetalle", [
            "nIdOrdenCompra"     => $nIdOrdenCompra,
            "nIdProducto"        => $nIdProducto,
            "nIdProveedor"       => $nIdProveedor,
            "nCantidad"          => $nCantidad,
            "nPrecio"            => $nPrecio,
            "nIdUnidadMedida"    => $nIdUnidadMedida,
            "nEstado"            => $nEstado,
        ]);

        return $this->db->run($sSQL);
    }


    public function fncActualizarOrdenCompraOrdenCompraDetalle(
        $nIdOrdenCompraDetalle,
        $nIdOrdenCompra,
        $nIdProducto,
        $nIdProveedor,
        $nCantidad,
        $nPrecio,
        $nIdUnidadMedida,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("ordencompradetalle", [
            "nIdOrdenCompra"     => $nIdOrdenCompra,
            "nIdProducto"        => $nIdProducto,
            "nIdProveedor"       => $nIdProveedor,
            "nCantidad"          => $nCantidad,
            "nPrecio"            => $nPrecio,
            "nIdUnidadMedida"    => $nIdUnidadMedida,
            "nEstado"            => $nEstado,
        ], "nIdOrdenCompraDetalle = $nIdOrdenCompraDetalle");

        return $this->db->run($sSQL);
    }

    public function fncEliminarOrdenCompraDetalleByIdOrdenCompra($nIdOrdenCompra)
    {
        $sSQL = $this->db->generateSQLDelete("ordencompradetalle", " nIdOrdenCompra = $nIdOrdenCompra ");
        return $this->db->run($sSQL);
    }


    public function fncEliminarOrdenCompraByIdDetalle($nIdOrdenCompraDetalle)
    {
        $sSQL = $this->db->generateSQLDelete("ordencompradetalle", " nIdOrdenCompraDetalle = $nIdOrdenCompraDetalle ");
        return $this->db->run($sSQL);
    }



    public function fncObtenerDetalleOrdenCompra($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"                  => "ocd.nIdOrdenCompraDetalle DESC",
            "sLimit"                    => null,
            "nIdOrdenCompraDetalle"     => null,
            "nIdOrdenCompra"            => null,
            "nTipo"                     => null,
            "nEjecutado"                => null,
            "nEstado"                   => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT 
                        DISTINCT
                        ocd.nIdOrdenCompraDetalle,  
                        ocd.nIdOrdenCompra,
                        IFNULL(ocd.nIdProveedor,0) AS nIdProveedor,
                        ocd.nIdProducto,  
                        ocd.nCantidad,  
                        ocd.nPrecio,  
                        IFNULL( DATE_FORMAT( oc.dFechaCreacion, '%d/%m/%Y' ), '' ) AS dFechaCreacion, 
                        IFNULL(provee.sNombreoRazonSocial , 'NINGUNO') AS sProveedor,
                        IFNULL( UPPER( prod.sDescripcion ) ,'') AS sProducto,
                        IFNULL( UPPER(prod.sCodigoInterno), '') AS sCodigoInternoProducto,
                        IFNULL(prod.sImagen,'') AS sImagenProducto,  
                        IFNULL(prod.nEquivalencia,'') AS nEquivalencia,
                        IFNULL(unimedida.sNombreLargo ,'') AS sUnidadMedida, 
                        IFNULL(prod.nIdUbicacionAlmacen,'0') AS nIdUbicacionAlmacen,
                        IFNULL(ua.sNombre , '' ) AS sNombreUbicacionAlmacen,
                        IFNULL(ua.sCodigo , '' ) AS sCodigoUbicacionAlmacen,
                        ocd.nIdUnidadMedida,  
                        ocd.nEstado
            FROM ordencompradetalle AS ocd
            LEFT JOIN ordencompra AS oc ON oc.nIdOrdenCompra = ocd.nIdOrdenCompra 
            LEFT JOIN productos AS prod ON ocd.nIdProducto = prod.nIdProducto  
            LEFT JOIN unidadmedidas AS unimedida ON unimedida.nIdUnidadMedida  = ocd.nIdUnidadMedida
            LEFT JOIN proveedores AS provee ON provee.nIdProveedor  = ocd.nIdProveedor
            LEFT JOIN ubicacionesalmacen AS ua ON ua.nIdUbicacionAlmacen  = prod.nIdUbicacionAlmacen";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdOrdenCompraDetalle"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " ocd.nIdOrdenCompraDetalle = {$this->db->quote($ary['nIdOrdenCompraDetalle'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdOrdenCompra"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " ocd.nIdOrdenCompra = {$this->db->quote($ary['nIdOrdenCompra'])}  ");

        $sWhere .= ($this->db->isNull($ary["nTipo"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nTipo = {$this->db->quote($ary['nTipo'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEjecutado"]) ? "" : (strlen($sWhere) > 0 ? " AND " : "") . " oc.nEjecutado = {$this->db->quote($ary['nEjecutado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        return $this->db->run(trim($sSQL));
    }
}
