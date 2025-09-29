<?php

namespace Application\Models;

use Application\Core\Database as Database;
use Application\Core\Model;

class Movimientos
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function fncGrabarMovimiento(
        $nIdEmpresa,
        $nIdSede,
        $nIdOrdenCompra,
        $nIdResponsable,
        $sDescripcion,
        $nEntradaSalida,
        $nTipoMovimiento,
        $nIdDocumento,
        $dFechaMovimiento,
        $nTipoMoneda,
        $nMovimientoInterno,
        $nEstado
    ) {


        $sSQL = $this->db->generateSQLInsert("movimientos", [
            "nIdEmpresa"         => $nIdEmpresa,
            "nIdSede"            => $nIdSede,
            "nIdOrdenCompra"     => $nIdOrdenCompra,
            "nIdResponsable"     => $nIdResponsable,
            "sDescripcion"       => $sDescripcion,
            "nEntradaSalida"     => $nEntradaSalida,
            "nTipoMovimiento"    => $nTipoMovimiento,
            "nIdDocumento"       => $nIdDocumento,
            "dFechaMovimiento"   => "STR_TO_DATE( '$dFechaMovimiento', '%d/%m/%Y' ) ",
            "dFechaCreacion"     => "NOW()",
            "nTipoMoneda"        => $nTipoMoneda,
            "nMovimientoInterno" => $nMovimientoInterno,
            "nEstado"            => $nEstado,
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarMovimiento(
        $nIdMovimiento,
        $nIdEmpresa,
        $nIdSede,
        $nIdOrdenCompra,
        $nIdResponsable,
        $sDescripcion,
        $nEntradaSalida,
        $nTipoMovimiento,
        $nIdDocumento,
        $dFechaMovimiento,
        $nTipoMoneda,
        $nMovimientoInterno,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("movimientos", [
            "nIdEmpresa"         => $nIdEmpresa,
            "nIdSede"            => $nIdSede,
            "nIdOrdenCompra"     => $nIdOrdenCompra,
            "nIdResponsable"     => $nIdResponsable,
            "sDescripcion"       => $sDescripcion,
            "nEntradaSalida"     => $nEntradaSalida,
            "nTipoMovimiento"    => $nTipoMovimiento,
            "nIdDocumento"       => $nIdDocumento,
            "dFechaMovimiento"   => "STR_TO_DATE( '$dFechaMovimiento', '%d/%m/%Y' ) ",
            "nTipoMoneda"        => $nTipoMoneda,
            "nMovimientoInterno" => $nMovimientoInterno,
            "nEstado"            => $nEstado,

        ], "nIdMovimiento = $nIdMovimiento");

        return $this->db->run($sSQL);
    }



    public function fncActualizarEstado(
        $nIdMovimiento,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("movimientos", [
            "nEstado"   => $nEstado,
        ], "nIdMovimiento = $nIdMovimiento");

        return $this->db->run($sSQL);
    }

    public function fncEliminarMovimiento($nIdMovimiento)
    {
        $sSQL = $this->db->generateSQLDelete("movimientos", " nIdMovimiento = $nIdMovimiento ");
        return $this->db->run($sSQL);
    }


    public function fncGetMovimientos($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"                   => "m.nIdMovimiento DESC",
            "sLimit"                     => null,
            "nIdMovimiento"              => null,
            "nIdEmpresa"                 => null,
            "nIdSede"                    => null,
            "nIdResponsable"             => null,
            "nEntradaSalida"             => null,
            "aryProductos"               => null,
            "aryIdMovimiento"            => null,
            "aryIdMovimientoNot"         => null,
            "nTipoMovimiento"            => null,
            "dFechaInicio"               => null,
            "dFechaFin"                  => null,
            "nIdDocumento"               => null,
            "nMovimientoInterno"         => null,
            "nEstado"                    => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    DISTINCT
                    m.nIdMovimiento,
                    m.nIdEmpresa,
                    m.nIdSede,
                    m.nIdResponsable,
                    m.sDescripcion,
                    m.nEntradaSalida,
                    m.nTipoMovimiento,
                    m.nIdDocumento,
                    m.nMovimientoInterno,
                    IFNULL(emp.sNombre , IFNULL(CONCAT(usu.sNombre,' ',usu.sApellidos),'') ) AS sResponsable,
                    IFNULL(emp.sLogin , IFNULL(usu.sLogin ,'') ) AS sLoginResponsable,
                    UPPER(CONCAT(IFNULL( tipomoneda.sDescripcionCortaItem,'' ), ' ')) AS sPrefijoMoneda, 
                    IFNULL(m.nIdOrdenCompra , '0') AS nIdOrdenCompra,
                    IFNULL(DATE_FORMAT( m.dFechaMovimiento , '%d/%m/%Y' ), '') as dFechaMovimiento,
                    IFNULL(tipomov.sDescripcionLargaItem,'') AS sTipoMovimiento, 
                    IFNULL(DATE_FORMAT( m.dFechaCreacion , '%d/%m/%Y %H:%i:%s' ), '') as dFechaCreacion,
                    m.nEstado
                FROM movimientos AS m
                LEFT JOIN catalogotabla AS tipomov ON m.nTipoMovimiento = tipomov.nIdCatalogoTabla
                LEFT JOIN movimientosdetalle AS md ON  m.nIdMovimiento = md.nIdMovimiento
                LEFT JOIN catalogotabla AS tipomoneda ON m.nTipoMoneda = tipomoneda.nIdCatalogoTabla
                LEFT JOIN empleados AS emp ON m.nIdResponsable = emp.nIdEmpleado
                LEFT JOIN usuarios AS usu ON m.nIdResponsable = usu.nIdUsuario";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdMovimiento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdMovimiento = {$this->db->quote($ary['nIdMovimiento'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdResponsable"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdResponsable = {$this->db->quote($ary['nIdResponsable'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEntradaSalida"]) || $ary["nEntradaSalida"] == '0' ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nEntradaSalida = {$this->db->quote($ary['nEntradaSalida'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryProductos"]) && !is_array($ary["aryProductos"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' md.nIdProducto IN (' . implode(",", $ary['aryProductos']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryIdMovimiento"]) && !is_array($ary["aryIdMovimiento"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' m.nIdMovimiento IN (' . implode(",", $ary['aryIdMovimiento']) . ')');

        $sWhere .= ($this->db->isNull($ary["aryIdMovimientoNot"]) && !is_array($ary["aryIdMovimientoNot"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' m.nIdMovimiento NOT IN (' . implode(",", $ary['aryIdMovimientoNot']) . ')');

        $sWhere .= ($this->db->isNull($ary["nTipoMovimiento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nTipoMovimiento = {$this->db->quote($ary['nTipoMovimiento'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(m.dFechaCreacion) BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nIdDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdDocumento = {$this->db->quote($ary['nIdDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary["nMovimientoInterno"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nMovimientoInterno = {$this->db->quote($ary['nMovimientoInterno'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }


    public function fncGrabarMovimientoDetalle(
        $nIdMovimiento,
        $nIdProducto,
        $nCantidad,
        $nPrecio,
        $nConversion,
        $nIdUbicacionAlmacen,
        $nEstado

    ) {

        $sSQL = $this->db->generateSQLInsert("movimientosdetalle", [
            "nIdMovimiento"               => $nIdMovimiento,
            "nIdProducto"                 => $nIdProducto,
            "nCantidad"                   => $nCantidad,
            "nPrecio"                     => $nPrecio,
            "nConversion"                 => $nConversion,
            "nIdUbicacionAlmacen"         => $nIdUbicacionAlmacen == 0 ? "NULL"  : $nIdUbicacionAlmacen,
            "nEstado"                     => $nEstado
        ]);

        return  $this->db->run($sSQL);
    }


    public function fncActualizarMovimientoDetalle(
        $nIdDetalleMovimiento,
        $nIdMovimiento,
        $nIdProducto,
        $nCantidad,
        $nPrecio,
        $nConversion,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("movimientosdetalle", [
            "nIdMovimiento"       => $nIdMovimiento,
            "nIdProducto"         => $nIdProducto,
            "nCantidad"           => $nCantidad,
            "nPrecio"             => $nPrecio,
            "nConversion"         => $nConversion,
            "nEstado"             => $nEstado,
        ], "nIdDetalleMovimiento = $nIdDetalleMovimiento");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarMovimientoDetalle($nIdDetalleMovimiento)
    {
        $sSQL = $this->db->generateSQLDelete("movimientosdetalle", " nIdDetalleMovimiento = $nIdDetalleMovimiento ");
        return $this->db->run($sSQL);
    }


    public function fncEliminarDetalleByIdMovimiento($nIdMovimiento)
    {
        $sSQL = $this->db->generateSQLDelete("movimientosdetalle", " nIdMovimiento = $nIdMovimiento ");
        return $this->db->run($sSQL);
    }


    public function fncActualizarEstadoDetalleByIdMov(
        $nIdMovimiento,
        $nEstado
    ) {

        $sSQL = $this->db->generateSQLUpdate("movimientosdetalle", [
            "nEstado"   => $nEstado,
        ], "nIdMovimiento = $nIdMovimiento");

        return $this->db->run($sSQL);
    }

    public function fncGetMovimientosDetalle($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"                   => null,
            "sLimit"                     => null,
            "nIdDetalleMovimiento"       => null,
            "nIdMovimiento"              => null,
            "nIdEmpresa"                 => null,
            "nIdSede"                    => null,
            "nEntradaSalida"             => null,
            "nTipoMovimiento"            => null,
            "nIdDocumento"               => null,
            "nMovimientoInterno"         => null,
            "aryProductos"               => null,
            "nIdProducto"                => null,
            "dFechaInicio"               => null,
            "dFechaFin"                  => null,
            "nEstado"                    => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    DISTINCT
                    md.nIdDetalleMovimiento,
                    md.nIdMovimiento,
                    md.nIdProducto,
                    IFNULL(UPPER(prod.sDescripcion), '') AS sProducto,
                    IFNULL(UPPER(prod.sCodigoInterno), '') AS sCodigoInternoProducto,
                    IFNULL(prod.sImagen,'') AS sImagenProducto,
                    IFNULL(prod.nStockActual,'') AS nStockActual,
                    md.nCantidad,
                    md.nPrecio,
                    IFNULL(md.nConversion,'0') AS nConversion,
                    IFNULL(md.nIdUbicacionAlmacen,'0') AS nIdUbicacionAlmacen,    
                    IFNULL(ua.sNombre,'') AS sNombreUbicacionAlmacen,   
                    IFNULL(ua.sCodigo,'') AS sCodigoUbicacionAlmacen,
                    IFNULL(UPPER(um.sNombreCorto),'') AS sUnidadMedida,

                    md.nEstado
                FROM movimientosdetalle AS md
                INNER JOIN movimientos AS m ON m.nIdMovimiento = md.nIdMovimiento
                LEFT JOIN productos AS prod ON md.nIdProducto  = prod.nIdProducto
                LEFT JOIN unidadmedidas AS um ON um.nIdUnidadMedida  = prod.nIdUnidadMedida 
                LEFT JOIN ubicacionesalmacen AS ua ON ua.nIdUbicacionAlmacen = md.nIdUbicacionAlmacen 
                ";

        $sWhere = "";


        $sWhere .= ($this->db->isNull($ary["nIdDetalleMovimiento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " md.nIdDetalleMovimiento = {$this->db->quote($ary['nIdDetalleMovimiento'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdMovimiento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " md.nIdMovimiento = {$this->db->quote($ary['nIdMovimiento'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEntradaSalida"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nEntradaSalida = {$this->db->quote($ary['nEntradaSalida'])}  ");

        $sWhere .= ($this->db->isNull($ary["nTipoMovimiento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nTipoMovimiento = {$this->db->quote($ary['nTipoMovimiento'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdDocumento"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nIdDocumento = {$this->db->quote($ary['nIdDocumento'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryProductos"]) && !is_array($ary["aryProductos"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' md.nIdProducto IN (' . implode(",", $ary['aryProductos']) . ')');

        $sWhere .= ($this->db->isNull($ary["nIdProducto"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " md.nIdProducto = {$this->db->quote($ary['nIdProducto'])}  ");

        $sWhere .= ($this->db->isNull($ary["nMovimientoInterno"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " m.nMovimientoInterno = {$this->db->quote($ary['nMovimientoInterno'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " md.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(m.dFechaCreacion) BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        

        return $this->db->run(trim($sSQL));
    }




    public function fncObtenterES($nIdProducto, $nEntradaSalida)
    {
        $sSQL = "SELECT COALESCE(SUM(md.nCantidad),0) AS nValor FROM movimientos AS m
                INNER JOIN movimientosdetalle AS md ON m.nIdMovimiento = md.nIdMovimiento
                WHERE md.nIdProducto = $nIdProducto AND m.nEntradaSalida = $nEntradaSalida AND md.nEstado = 1
                GROUP BY md.nIdProducto";
        return $this->db->run($sSQL);
    }



    # Este metodo sirve para validar si esque algunos de los productos del movimientos se han vendido o esta en el historial de los pedidos
    public function fncVerificarMovimientoPedido($nIdMovimiento)
    {
        $sSQL = "SELECT m.nIdMovimiento FROM movimientos AS m 
                INNER JOIN movimientosdetalle AS md ON m.nIdMovimiento = md.nIdMovimiento 
                INNER JOIN pedidosdetalle AS pd ON md.nIdProducto = pd.nIdProducto
                WHERE m.nIdMovimiento = $nIdMovimiento";
        return $this->db->run($sSQL);
    }



    public function fncActualizarDocumento(
        $nIdMovimiento,
        $nIdDocumento
    ) {

        $sSQL = $this->db->generateSQLUpdate("movimientos", [
            "nIdDocumento"   => $nIdDocumento,
        ], "nIdMovimiento = $nIdMovimiento");

        return $this->db->run($sSQL);
    }
}
