<?php

namespace Application\Models;

use Application\Core\Database as Database;

class CartaDigital
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fncGrabarCartaDigital(
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sComentario,
        $sURL,
        $nEstado,
        $sImagen,
        $sColor1,
        $sColor2,
        $sColor3,
        $sColor4,
        $sColor5,
        $sColor6,
        $sColor7,
        $sColor8,
        $sColor9,
        $sColor10,
        $sColor11,
        $sColor12,
        $sColor13,
        $sImagenHeader
    ) {

        $sSQL = $this->db->generateSQLInsert("cartadigital", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sComentario"           => $sComentario,
            "sURL"                  => $sURL,
            "sImagen"               => $sImagen,
            "nEstado"               => $nEstado,
            "sColor1"               => $sColor1,
            "sColor2"               => $sColor2,
            "sColor3"               => $sColor3,
            "sColor4"               => $sColor4,
            "sColor5"               => $sColor5,
            "sColor6"               => $sColor6,
            "sColor7"               => $sColor7,
            "sColor8"               => $sColor8,
            "sColor9"               => $sColor9,
            "sColor10"              => $sColor10,
            "sColor11"              => $sColor11,
            "sColor12"              => $sColor12,
            "sColor13"              => $sColor13,
            "sImagenHeader"         => $sImagenHeader,
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarDigital(
        $nIdCartaDigital,
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $sComentario,
        $sURL,
        $nEstado,
        $sImagen,
        $sColor1,
        $sColor2,
        $sColor3,
        $sColor4,
        $sColor5,
        $sColor6,
        $sColor7,
        $sColor8,
        $sColor9,
        $sColor10,
        $sColor11,
        $sColor12,
        $sColor13,
        $sImagenHeader
    ) {

        $sSQL = $this->db->generateSQLUpdate("cartadigital", [
            "nIdEmpresa"            => $nIdEmpresa,
            "nIdSede"               => $nIdSede,
            "sNombre"               => $sNombre,
            "sComentario"           => $sComentario,
            "sURL"                  => $sURL,
            "nEstado"               => $nEstado,
            "sImagen"               => $sImagen,
            "sColor1"               => $sColor1,
            "sColor2"               => $sColor2,
            "sColor3"               => $sColor3,
            "sColor4"               => $sColor4,
            "sColor5"               => $sColor5,
            "sColor6"               => $sColor6,
            "sColor7"               => $sColor7,
            "sColor8"               => $sColor8,
            "sColor9"               => $sColor9,
            "sColor10"              => $sColor10,
            "sColor11"              => $sColor11,
            "sColor12"              => $sColor12,
            "sColor13"              => $sColor13,
            "sImagenHeader"         => $sImagenHeader
        ], "nIdCartaDigital = $nIdCartaDigital");

        return  $this->db->run($sSQL);
    }

    public function fncEliminarCartaDigital($nIdCartaDigital)
    {
        $sSQL = $this->db->generateSQLDelete("cartadigital", " nIdCartaDigital = $nIdCartaDigital ");
        $this->db->run($sSQL);
    }

    public function fncObtenerCartaDigital($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "cd.nIdCartaDigital ASC",
            "sLimit"               => null,
            "nIdCartaDigital"      => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "nEstado"              => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    cd.nIdCartaDigital,
                    cd.nIdEmpresa,
                    cd.nIdSede,
                    cd.sNombre,
                    cd.sComentario,
                    cd.sURL,
                    cd.nEstado,
                    IFNULL(cd.sImagen,'') AS sImagen,
                    IFNULL(cd.sColor1,'') AS sColor1,
                    IFNULL(cd.sColor2,'') AS sColor2,
                    IFNULL(cd.sColor3,'') AS sColor3,
                    IFNULL(cd.sColor4,'') AS sColor4,
                    IFNULL(cd.sColor5,'') AS sColor5,
                    IFNULL(cd.sColor6,'') AS sColor6,
                    IFNULL(cd.sColor7,'') AS sColor7,
                    IFNULL(cd.sColor8,'') AS sColor8,
                    IFNULL(cd.sColor9,'') AS sColor9,
                    IFNULL(cd.sColor10,'') AS sColor10,
                    IFNULL(cd.sColor11,'') AS sColor11,
                    IFNULL(cd.sColor12,'') AS sColor12,
                    IFNULL(cd.sColor13,'') AS sColor13,
                    IFNULL(cd.sImagenHeader,'') AS sImagenHeader
                FROM cartadigital AS cd";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCartaDigital"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nIdCartaDigital = {$this->db->quote($ary['nIdCartaDigital'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cd.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }


    # Carta digital Seccion
    public function fncGrabarCartaDigitalSeccion(
        $nIdCartaDigital,
        $sNombre,
        $sIcono,
        $sImagen,
        $sURL,
        $nEstado,
        $nOrden
    ) {

        $sSQL = $this->db->generateSQLInsert("cartadigitalseccion", [
            "nIdCartaDigital"   => $nIdCartaDigital,
            "sNombre"           => $sNombre,
            "sIcono"            => $sIcono,
            "sImagen"           => $sImagen,
            "sURL"              => $sURL,
            "nEstado"           => $nEstado,
            "nOrden"            => $nOrden,
        ]);
        return  $this->db->run($sSQL);
    }

    public function fncActualizarCartaDigitalSeccion(
        $nIdCartaDigitalSeccion,
        $nIdCartaDigital,
        $sNombre,
        $sIcono,
        $sImagen,
        $sURL,
        $nEstado,
        $nOrden
    ) {

        $sSQL = $this->db->generateSQLUpdate("cartadigitalseccion", [
            "nIdCartaDigital"   => $nIdCartaDigital,
            "sNombre"           => $sNombre,
            "sIcono"            => $sIcono,
            "sImagen"           => $sImagen,
            "sURL"              => $sURL,
            "nEstado"           => $nEstado,
            "nOrden"            => $nOrden,

        ], "nIdCartaDigitalSeccion = $nIdCartaDigitalSeccion");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarCartaDigitalSeccion($nIdCartaDigitalSeccion)
    {
        $sSQL = $this->db->generateSQLDelete("cartadigitalseccion", " nIdCartaDigitalSeccion = $nIdCartaDigitalSeccion ");
        return $this->db->run($sSQL);
    }

    public function fncObtenerCartaDigitalSeccion($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"                => "cds.nOrden ASC",
            "sLimit"                  => null,
            "nIdCartaDigitalSeccion"  => null,
            "nIdCartaDigital"         => null,
            "nEstado"                 => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    cds.nIdCartaDigitalSeccion,
                    cds.nIdCartaDigital,
                    cds.sNombre,
                    IFNULL(cds.sIcono,'') AS sIcono,
                    IFNULL(cds.sImagen,'') AS sImagen,
                    IFNULL(cds.sURL,'') AS sURL,
                    cds.nOrden,
                    cds.nEstado
                FROM cartadigitalseccion AS cds";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCartaDigitalSeccion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cds.nIdCartaDigitalSeccion = {$this->db->quote($ary['nIdCartaDigitalSeccion'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdCartaDigital"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cds.nIdCartaDigital = {$this->db->quote($ary['nIdCartaDigital'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cds.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }

    public function fncEliminarItemsDetalle($nIdCartaDigital, $sIdLIst)
    {
        $sSQL = "DELETE FROM cartadigitalseccion WHERE ";
        $sSQL .= ($sIdLIst == '' ? "nIdCartaDigital = '$nIdCartaDigital'" : "nIdCartaDigital = '$nIdCartaDigital' AND nIdCartaDigitalSeccion NOT IN ($sIdLIst)");
        return $this->db->run($sSQL);
    }


    # Carta digital Productos
    public function fncGrabarCDSP(
        $nIdCartaDigitalSeccion,
        $nIdCategoria,
        $nIdProducto,
        $nEstado,
        $sIdsExtra,
        $nOrden
    ) {
        $sSQL = $this->db->generateSQLInsert("cartadigitalproductos", [
            "nIdCartaDigitalSeccion"   => $nIdCartaDigitalSeccion,
            "nIdCategoria"             => $nIdCategoria,
            "nIdProducto"              => $nIdProducto,
            "nEstado"                  => $nEstado,
            "sIdsExtra"                => $sIdsExtra,

            "nOrden"                   => $nOrden
        ]);
        return  $this->db->run($sSQL);
    }

    public function fncActualizarCDSP(
        $nIdCDProductos,
        $nIdCartaDigitalSeccion,
        $nIdCategoria,
        $nIdProducto,
        $nEstado,
        $sIdsExtra,
        $nOrden
    ) {
        $sSQL = $this->db->generateSQLUpdate("cartadigitalproductos", [
            "nIdCartaDigitalSeccion"   => $nIdCartaDigitalSeccion,
            "nIdCategoria"             => $nIdCategoria,
            "nIdProducto"              => $nIdProducto,
            "nEstado"                  => $nEstado,
            "sIdsExtra"                => $sIdsExtra,
            "nOrden"                   => $nOrden
        ], "nIdCDProductos =$nIdCDProductos");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarCDSP($nIdCDProductos)
    {
        $sSQL = $this->db->generateSQLDelete("cartadigitalproductos", " nIdCDProductos = $nIdCDProductos ");
        return $this->db->run($sSQL);
    }

    public function fncObtenerCDSP($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"                => "cdsp.nOrden ASC",
            "sLimit"                  => null,
            "nIdCDProductos"          => null,
            "nIdCartaDigitalSeccion"  => null,
            "nEstado"                 => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    cdsp.nIdCDProductos,
                    cdsp.nIdCartaDigitalSeccion,
                    cdsp.nIdCategoria,
                    cdsp.nIdProducto,
                    cdsp.nEstado,
                    prod.sDescripcion AS sProducto,
                    prod.nPrecioVenta AS nPrecioProducto,
                    prod.sImagen AS sImagenProducto,
                    prod.sDetalle AS sDetalleProducto,
                    cat.sNombre AS sCategoria,
                    cdsp.nOrden,
                    IFNULL(cdsp.sIdsExtra,'') AS sIdsExtra,
                    IFNULL(( SELECT GROUP_CONCAT( ex.sNombre ) FROM cartadigitalextra AS ex WHERE FIND_IN_SET(ex.nIDCDExtra,cdsp.sIdsExtra) ) ,'') AS sExtra
                FROM cartadigitalproductos AS cdsp
                INNER JOIN productos AS prod ON prod.nIdProducto = cdsp.nIdProducto
                INNER JOIN categorias AS cat ON cat.nIdCategoria = cdsp.nIdCategoria";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdCDProductos"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cdsp.nIdCDProductos = {$this->db->quote($ary['nIdCDProductos'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdCartaDigitalSeccion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cdsp.nIdCartaDigitalSeccion = {$this->db->quote($ary['nIdCartaDigitalSeccion'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cdsp.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }

    public function fncEliminarItemsSubDetalle($nIdCartaDigitalSeccion, $sIdLIst)
    {
        $sSQL = "DELETE FROM cartadigitalproductos WHERE ";
        $sSQL .= ($sIdLIst == '' ? "nIdCartaDigitalSeccion = '$nIdCartaDigitalSeccion'" : "nIdCartaDigitalSeccion = '$nIdCartaDigitalSeccion' AND nIdCDProductos NOT IN ($sIdLIst)");
        return $this->db->run($sSQL);
    }

    # Carta Digital Pedido
    public function fncGrabarCartaDigitalPedido(
        $nIdEmpresa,
        $nIdSede,
        $sCliente,
        $sObservacion,
        $nIdEstado,
        $nIdMesa,
        $nTotal,
        $nEstado,
        $nIdCartaDigital
    ) {

        $sSQL = $this->db->generateSQLInsert("cartadigitalpedido", [
            "nIdEmpresa"         => $nIdEmpresa,
            "nIdSede"            => $nIdSede,
            "sCliente"           => $sCliente,
            "sObservacion"       => $sObservacion,
            "nIdEstado"          => $nIdEstado,
            "nIdMesa"            => $nIdMesa,
            "nTotal"             => $nTotal,
            "dFechaCreacion"     => "NOW()",
            "nEstado"            => $nEstado,
            "nIdCartaDigital"    => $nIdCartaDigital
        ]);

        return  $this->db->run($sSQL);
    }

    public function fncActualizarDigitalPedido(
        $nIdPedidoCD,
        $sCliente,
        $sObservacion,
        $nIdEstado,
        $nIdMesa,
        $nTotal,
        $nEstado,
        $nIdCartaDigital
    ) {

        $sSQL = $this->db->generateSQLUpdate("cartadigitalpedido", [
            "sCliente"           => $sCliente,
            "sObservacion"       => $sObservacion,
            "nIdEstado"          => $nIdEstado,
            "nIdMesa"            => $nIdMesa,
            "nTotal"             => $nTotal,
            "nEstado"            => $nEstado,
            "nIdCartaDigital"    => $nIdCartaDigital
        ], "nIdPedidoCD = $nIdPedidoCD");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarCartaDigitalPedido($nIdPedidoCD)
    {
        $sSQL = $this->db->generateSQLDelete("cartadigitalpedido", " nIdPedidoCD = $nIdPedidoCD ");
        return $this->db->run($sSQL);
    }

    public function fncObtenerPedidos($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "ped.nIdPedidoCD ASC",
            "sLimit"               => null,
            "nIdPedidoCD"          => null,
            "nIdEmpresa"           => null,
            "nIdSede"              => null,
            "dFechaInicio"         => null,
            "dFechaFin"            => null,
            "nIdEstado"            => null,
            "sIdsEstado"           => null,
            "nEstado"              => null,
            "nVendido"             => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                    ped.nIdPedidoCD,
                    ped.sCliente,
                    ped.sObservacion,
                    ped.nIdEstado,
                    ped.nIdCartaDigital,
                    IFNULL(ped.nIdMesa,0) AS nIdMesa,
                    ped.nTotal,
                    ped.nEstado,
                    IFNULL(cd.sNombre,'') AS sCartaDigital,
                    m.sDescripcion AS sMesa,
                    IFNULL( DATE_FORMAT( ped.dFechaCreacion, '%d/%m/%Y %H:%i' ), '' ) as dFechaCreacion, 
                    IFNULL(apro.sDescripcionLargaItem,'') AS sEstadoAprobacion,
                    ped.nVendido
                FROM cartadigitalpedido AS ped
                LEFT JOIN mesas AS m ON m.nIdMesa = ped.nIdMesa
                LEFT JOIN cartadigital AS cd ON cd.nIdCartaDigital= ped.nIdCartaDigital
                LEFT JOIN catalogotabla AS apro ON apro.nIdCatalogoTabla = ped.nIdEstado";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdPedidoCD"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdPedidoCD = {$this->db->quote($ary['nIdPedidoCD'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdEstado = {$this->db->quote($ary['nIdEstado'])}  ");

        $sWhere .= ($this->db->isNull($ary["sIdsEstado"]) || empty($ary["sIdsEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdEstado IN ( " . $ary['sIdsEstado'] . " ) ");

        $sWhere .= ($this->db->isNull($ary["nVendido"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nVendido = {$this->db->quote($ary['nVendido'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary['dFechaInicio']) && $this->db->isNull($ary['dFechaFin'])  ? '' : (strlen($sWhere) > 0 ? " AND " : '') . " DATE(ped.dFechaCreacion)  BETWEEN STR_TO_DATE( '" . $ary['dFechaInicio'] . "', '%d/%m/%Y' ) AND STR_TO_DATE( '" . $ary['dFechaFin'] . "', '%d/%m/%Y' )");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ped.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }

    public function fncGrabarPedidoDetalle(
        $nIdPedidoCD,
        $nIdProducto,
        $nPrecio,
        $nCantidad,
        $nTotal,
        $sObservacion,
        $jsnConfigExtra,
        $jsnValuesExtra
    ) {
        $sSQL = $this->db->generateSQLInsert("cartadigitalpedidodetalle", [
            "nIdPedidoCD"           => $nIdPedidoCD,
            "nIdProducto"           => $nIdProducto,
            "nPrecio"               => $nPrecio,
            "nCantidad"             => $nCantidad,
            "nTotal"                => $nTotal,
            "sObservacion"          => $sObservacion,
            "jsnConfigExtra"        => $jsnConfigExtra,
            "jsnValuesExtra"        => $jsnValuesExtra
        ]);
        return  $this->db->run($sSQL);
    }

    public function fncActualizarPedidoDetalle(
        $nIdDetalle,
        $nIdPedidoCD,
        $nIdProducto,
        $nPrecio,
        $nCantidad,
        $nTotal,
        $sObservacion,
        $jsnConfigExtra,
        $jsnValuesExtra
    ) {
        $sSQL = $this->db->generateSQLUpdate("cartadigitalpedidodetalle", [
            "nIdPedidoCD"           => $nIdPedidoCD,
            "nIdProducto"           => $nIdProducto,
            "nPrecio"               => $nPrecio,
            "nCantidad"             => $nCantidad,
            "nTotal"                => $nTotal,
            "sObservacion"          => $sObservacion,
            "jsnConfigExtra"        => $jsnConfigExtra,
            "jsnValuesExtra"        => $jsnValuesExtra
        ], "nIdDetalle = $nIdDetalle");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarItemsPedidoDetalle($nIdPedidoCD, $sIdLIst)
    {
        $sSQL = "DELETE FROM cartadigitalpedidodetalle WHERE ";
        $sSQL .= ($sIdLIst == '' ? "nIdPedidoCD = '$nIdPedidoCD'" : "nIdPedidoCD = '$nIdPedidoCD' AND nIdDetalle NOT IN ($sIdLIst)");
        return $this->db->run($sSQL);
    }

    public function fncObtenerPedidoDetalle($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"             => "det.nIdDetalle ASC",
            "sLimit"               => null,
            "nIdDetalle"           => null,
            "nIdPedidoCD"          => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                   det.nIdDetalle,
                   det.nIdPedidoCD,
                   det.nIdProducto,
                   det.nPrecio,
                   det.nCantidad,
                   det.nTotal,
                   det.sObservacion,
                   prod.sImagen AS sImagenProducto,
                   UPPER(prod.sDescripcion) AS sProducto,
                   IFNULL(det.jsnConfigExtra,'') AS jsnConfigExtra,
                   IFNULL(det.jsnValuesExtra,'') AS jsnValuesExtra
                FROM cartadigitalpedidodetalle AS det
                INNER JOIN productos AS prod ON det.nIdProducto = prod.nIdProducto";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIdDetalle"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " det.nIdDetalle = {$this->db->quote($ary['nIdDetalle'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdPedidoCD"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " det.nIdPedidoCD = {$this->db->quote($ary['nIdPedidoCD'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }


    public function fncActualizarFlagVendido($nIdPedidoCD, $nVendido)
    {
        $sSQL = "UPDATE cartadigitalpedido SET nVendido = $nVendido WHERE nIdPedidoCD = $nIdPedidoCD";
        return $this->db->run($sSQL);
    }

    # Carta digital extra
    public function fncGrabarExtra(
        $nIdEmpresa,
        $nIdSede,
        $sNombre,
        $nTipo,
        $sValores,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLInsert("cartadigitalextra", [
            "nIdEmpresa"        => $nIdEmpresa,
            "nIdSede"           => $nIdSede,
            "sNombre"           => $sNombre,
            "nTipo"             => $nTipo,
            "sValores"          => $sValores,
            "nEstado"           => $nEstado
        ]);
        return  $this->db->run($sSQL);
    }

    public function fncActualizarExtra(
        $nIDCDExtra,
        $sNombre,
        $nTipo,
        $sValores,
        $nEstado
    ) {
        $sSQL = $this->db->generateSQLUpdate("cartadigitalextra", [

            "sNombre"           => $sNombre,
            "nTipo"             => $nTipo,
            "sValores"          => $sValores,
            "nEstado"           => $nEstado
        ], "nIDCDExtra = $nIDCDExtra");
        return  $this->db->run($sSQL);
    }

    public function fncEliminarExtra($nIDCDExtra)
    {
        $sSQL = "DELETE FROM cartadigitalextra WHERE nIDCDExtra= $nIDCDExtra";
        return $this->db->run($sSQL);
    }

    public function fncObtenerExtra($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"            => "ex.nIDCDExtra ASC",
            "sLimit"              => null,
            "nIDCDExtra"          => null,
            "sIdsExtra"           => null,
            "nIdEmpresa"          => null,
            "nIdSede"             => null,
            "nEstado"             => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  
                   ex.nIDCDExtra,
                   ex.nIdEmpresa,
                   ex.nIdSede,
                   ex.sNombre,
                   ex.nTipo,
                   ex.sValores,
                   ex.nEstado
                FROM cartadigitalextra AS ex";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["nIDCDExtra"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ex.nIDCDExtra = {$this->db->quote($ary['nIDCDExtra'])}  ");

        $sWhere .= ($this->db->isNull($ary["sIdsExtra"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ex.nIDCDExtra IN (" . $ary['sIdsExtra'] . ")");

        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ex.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");

        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ex.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ex.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;
        return $this->db->run(trim($sSQL));
    }
}
