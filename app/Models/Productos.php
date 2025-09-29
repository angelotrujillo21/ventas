<?php



namespace Application\Models;



use Application\Core\Database as Database;



class Productos

{

    private $db;



    public function __construct()

    {

        $this->db = new Database();

    }





    public function fncGrabarProducto(

        $nIdCategoria,

        $sDescripcion,

        $nIdUnidadMedida,

        $nIdTipo,

        $sImagen,

        $nTipoPrecio,

        $nPrecioCompra,

        $nPrecioVenta,

        $nVenderStock,

        $nEquivalencia,

        $nIdLote,

        $nIdUbicacionAlmacen,



        $dFechaVencimiento,

        $nStockMinimo,

        $nStockMaximo,

        $nAcumulaPuntos,



        $sDetalle,

        $sCodigoInterno,

        $sCodigoBarras,

        $nPorcentajeComision,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLInsert("productos", [

            "nIdCategoria"              => $nIdCategoria,

            "sDescripcion"              => $sDescripcion,

            "nIdUnidadMedida"           => $nIdUnidadMedida,

            "nIdTipo"                   => $nIdTipo,

            "sImagen"                   => $sImagen,

            "nTipoPrecio"               => $nTipoPrecio,

            "nPrecioCompra"             => $nPrecioCompra,

            "nPrecioVenta"              => $nPrecioVenta,

            "nVenderStock"              => $nVenderStock,

            "nEquivalencia"             => $nEquivalencia,

            "nIdLote"                   => $nIdLote,

            "nIdUbicacionAlmacen"       => $nIdUbicacionAlmacen,



            "dFechaVencimiento"         =>  "STR_TO_DATE( '$dFechaVencimiento', '%d/%m/%Y' ) ",

            "nStockMinimo"              => $nStockMinimo,

            "nStockMaximo"              => $nStockMaximo,

            "nAcumulaPuntos"            => $nAcumulaPuntos,





            "sDetalle"                  => $sDetalle,

            "sCodigoInterno"            => $sCodigoInterno,

            "sCodigoBarras"             => $sCodigoBarras,



            "nPorcentajeComision"       => $nPorcentajeComision,



            "nEstado"                   => $nEstado,

        ]);



        return  $this->db->run($sSQL);

    }





    public function fncActualizarProducto(

        $nIdProducto,

        $nIdCategoria,

        $sDescripcion,

        $nIdUnidadMedida,

        $nIdTipo,

        $sImagen,

        $nTipoPrecio,

        $nPrecioCompra,

        $nPrecioVenta,

        $nVenderStock,

        $nEquivalencia,

        $nIdLote,

        $nIdUbicacionAlmacen,

        $dFechaVencimiento,

        $nStockMinimo,

        $nStockMaximo,

        $nAcumulaPuntos,



        $sDetalle,

        $sCodigoInterno,

        $sCodigoBarras,

        $nPorcentajeComision,





        $nEstado

    ) {



        $sSQL = $this->db->generateSQLUpdate("productos", [

            "nIdCategoria"              => $nIdCategoria,

            "sDescripcion"              => $sDescripcion,

            "nIdUnidadMedida"           => $nIdUnidadMedida,

            "nIdTipo"                   => $nIdTipo,

            "sImagen"                   => $sImagen,

            "nTipoPrecio"               => $nTipoPrecio,

            "nPrecioCompra"             => $nPrecioCompra,

            "nPrecioVenta"              => $nPrecioVenta,

            "nVenderStock"              => $nVenderStock,

            "nEquivalencia"             => $nEquivalencia,

            "nIdLote"                   => $nIdLote,

            "nIdUbicacionAlmacen"       => $nIdUbicacionAlmacen,

            "dFechaVencimiento"         =>  "STR_TO_DATE( '$dFechaVencimiento', '%d/%m/%Y' ) ",

            "nStockMinimo"              => $nStockMinimo,

            "nStockMaximo"              => $nStockMaximo,

            "nAcumulaPuntos"            => $nAcumulaPuntos,



            "sDetalle"                  => $sDetalle,

            "sCodigoInterno"            => $sCodigoInterno,

            "sCodigoBarras"             => $sCodigoBarras,

            "nPorcentajeComision"       => $nPorcentajeComision,



            "nEstado"                   => $nEstado,

        ], "nIdProducto = $nIdProducto");



        // echo $sSQL;

        // exit;



        return  $this->db->run($sSQL);

    }







    public function fncActualizarDataStock(

        $nIdProducto,

        $nStockActual

    ) {



        $sSQL = $this->db->generateSQLUpdate("productos", [

            "nStockActual" => $nStockActual,

        ], "nIdProducto = $nIdProducto");



        return  $this->db->run($sSQL);

    }



    public function fncEliminarProducto($nIdProducto)

    {

        $sSQL = $this->db->generateSQLDelete("productos", " nIdProducto = $nIdProducto ");

        $this->db->run($sSQL);

    }





    public function fncGetProductos($aryInput = [])

    {



        $aryAllFilters = [

            "sOrderBy"         => "prod.nIdProducto DESC",

            "sLimit"           => null,

            "nIdProducto"      => null,

            "nIdTipo"          => null,

            "nIdSede"          => null,

            "nTipoPrecio"      => null,

            "aryProductos"     => null,

            "nStockActual"     => null,

            "nVenderStock"     => null,

            "nAcumulaPuntos"   => null,

            "aryCategoria"     => null,

            "nIdCategoria"     => null,

            "aryIdTipo"        => null,

            "aryTipoPrecio"    => null,

            "nEquivalencia"    => null,

            "nEstado"          => null,

            "sSearch"          => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT prod.nIdProducto,

                        prod.nIdCategoria,

                        UPPER(prod.sDescripcion) AS sDescripcion,

                        prod.nIdUnidadMedida,

                        prod.nIdTipo,

                        prod.nTipoPrecio,

                        prod.nPrecioCompra,

                        prod.nPrecioVenta,

                        prod.sImagen,

                        prod.nStockActual,

                        prod.nVenderStock,

                        prod.nEquivalencia,

                        prod.nIdUbicacionAlmacen,

                        IFNULL(cat.sNombre,'') AS sCategoria,

                        IFNULL(unimedida.sNombreLargo,'') AS sUnidadMedida,

                        IFNULL(unimedida.sNombreCorto,'') AS sUnidadMedidaCorto,

                        IFNULL(tipoprod.sDescripcionLargaItem,'') AS sTipoProducto,

                        IFNULL(ntipoprecio.sDescripcionLargaItem,'') AS sTipoPrecio,

                        IFNULL(prod.nIdLote,0) AS nIdLote,

                        IFNULL( DATE_FORMAT( prod.dFechaVencimiento, '%d/%m/%Y' ), '' ) AS dFechaVencimiento,  

                        IFNULL(prod.nStockMinimo,0) AS nStockMinimo,

                        IFNULL(prod.nStockMaximo,0) AS nStockMaximo ,

                        IFNULL(prod.nAcumulaPuntos,0) AS nAcumulaPuntos,

                        IFNULL(UPPER(ua.sNombre), '') AS sNombreUbicacionAlmacen,

                        IFNULL(prod.sDetalle, '') AS sDetalle,

                        IFNULL(prod.sCodigoInterno, '') AS sCodigoInterno,

                        IFNULL(prod.sCodigoBarras, '') AS sCodigoBarras,

                        prod.nPorcentajeComision,

                        prod.nEstado

         FROM productos AS prod

         INNER JOIN categorias AS cat ON cat.nIdCategoria = prod.nIdCategoria

         LEFT JOIN unidadmedidas AS unimedida ON unimedida.nIdUnidadMedida = prod.nIdUnidadMedida

         LEFT JOIN catalogotabla AS tipoprod ON tipoprod.nIdCatalogoTabla = prod.nIdTipo

         LEFT JOIN catalogotabla AS ntipoprecio ON ntipoprecio.nIdCatalogoTabla = prod.nTipoPrecio

         LEFT JOIN ubicacionesalmacen AS ua ON ua.nIdUbicacionAlmacen = prod.nIdUbicacionAlmacen";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdProducto"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nIdProducto = {$this->db->quote($ary['nIdProducto'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cat.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdTipo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nIdTipo = {$this->db->quote($ary['nIdTipo'])}  ");



        $sWhere .= ($this->db->isNull($ary["nTipoPrecio"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nTipoPrecio = {$this->db->quote($ary['nTipoPrecio'])}  ");



        $sWhere .= ($this->db->isNull($ary["aryProductos"]) && !is_array($ary["aryProductos"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nIdProducto IN (' . implode(",", $ary['aryProductos']) . ')');



        $sWhere .= ($this->db->isNull($ary["aryCategoria"]) && !is_array($ary["aryCategoria"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nIdCategoria IN (' . implode(",", $ary['aryCategoria']) . ')');

       
        $sWhere .= ($this->db->isNull($ary["nIdCategoria"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nIdCategoria = '. $ary['nIdCategoria']);


        $sWhere .= ($this->db->isNull($ary["aryIdTipo"]) && !is_array($ary["aryIdTipo"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nIdTipo IN (' . implode(",", $ary['aryIdTipo']) . ')');



        $sWhere .= ($this->db->isNull($ary["aryTipoPrecio"]) && !is_array($ary["aryTipoPrecio"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nTipoPrecio IN (' . implode(",", $ary['aryTipoPrecio']) . ')');



        $sWhere .= ($this->db->isNull($ary["nStockActual"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nStockActual  " . $ary['nStockActual'] . "  ");



        $sWhere .= ($this->db->isNull($ary["nVenderStock"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nVenderStock = {$this->db->quote($ary['nVenderStock'])}  ");



        $sWhere .= ($this->db->isNull($ary["nAcumulaPuntos"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nAcumulaPuntos = {$this->db->quote($ary['nAcumulaPuntos'])} ");



        $sWhere .= ($this->db->isNull($ary["nEquivalencia"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nEquivalencia = {$this->db->quote($ary['nEquivalencia'])} ");

        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nEstado = {$this->db->quote($ary['nEstado'])}  ");

        $sWhere .= ($this->db->isNull($ary["sSearch"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.sDescripcion LIKE '%". $ary['sSearch'] . "%'");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        // echo $sSQL;

        // exit;


        return $this->db->run(trim($sSQL));

    }



    public function fncGetProductosDatosBasicos($aryInput = [])

    {



        $aryAllFilters = [

            "sOrderBy"         => "prod.nIdProducto DESC",

            "sLimit"           => null,

            "nIdProducto"      => null,

            "nIdTipo"          => null,

            "nIdSede"          => null,

            "nTipoPrecio"      => null,

            "aryProductos"     => null,

            "nStockActual"     => null,

            "nVenderStock"     => null,

            "nAcumulaPuntos"   => null,

            "aryCategoria"     => null,

            "aryIdTipo"        => null,

            "aryTipoPrecio"    => null,

            "nEquivalencia"    => null,

            "nEstado"          => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT prod.nIdProducto,

                        prod.sDescripcion,

                        prod.nStockActual,

                        IFNULL(cat.sNombre,'') AS sCategoria,

                        IFNULL(unimedida.sNombreLargo,'') AS sUnidadMedida,

                        IFNULL(prod.sDetalle, '') AS sDetalle,

                        IFNULL(UPPER(ua.sNombre), '') AS sNombreUbicacionAlmacen,

                        IFNULL(prod.sCodigoInterno, '') AS sCodigoInterno,

                        IFNULL(prod.sCodigoBarras, '') AS sCodigoBarras,

                        IFNULL(unimedida.sNombreLargo,'') AS sUnidadMedida,

                        IFNULL(unimedida.sNombreCorto,'') AS sUnidadMedidaCorto,

                        prod.nEstado

         FROM productos AS prod

         INNER JOIN categorias AS cat ON cat.nIdCategoria = prod.nIdCategoria

         LEFT JOIN unidadmedidas AS unimedida ON unimedida.nIdUnidadMedida = prod.nIdUnidadMedida

         LEFT JOIN ubicacionesalmacen AS ua ON ua.nIdUbicacionAlmacen = prod.nIdUbicacionAlmacen";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdProducto"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nIdProducto = {$this->db->quote($ary['nIdProducto'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cat.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdTipo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nIdTipo = {$this->db->quote($ary['nIdTipo'])}  ");



        $sWhere .= ($this->db->isNull($ary["nTipoPrecio"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nTipoPrecio = {$this->db->quote($ary['nTipoPrecio'])}  ");



        $sWhere .= ($this->db->isNull($ary["aryProductos"]) && !is_array($ary["aryProductos"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nIdProducto IN (' . implode(",", $ary['aryProductos']) . ')');



        $sWhere .= ($this->db->isNull($ary["aryCategoria"]) && !is_array($ary["aryCategoria"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nIdCategoria IN (' . implode(",", $ary['aryCategoria']) . ')');



        $sWhere .= ($this->db->isNull($ary["aryIdTipo"]) && !is_array($ary["aryIdTipo"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nIdTipo IN (' . implode(",", $ary['aryIdTipo']) . ')');



        $sWhere .= ($this->db->isNull($ary["aryTipoPrecio"]) && !is_array($ary["aryTipoPrecio"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' prod.nTipoPrecio IN (' . implode(",", $ary['aryTipoPrecio']) . ')');



        $sWhere .= ($this->db->isNull($ary["nStockActual"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nStockActual  " . $ary['nStockActual'] . "  ");



        $sWhere .= ($this->db->isNull($ary["nVenderStock"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nVenderStock = {$this->db->quote($ary['nVenderStock'])}  ");



        $sWhere .= ($this->db->isNull($ary["nAcumulaPuntos"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nAcumulaPuntos = {$this->db->quote($ary['nAcumulaPuntos'])} ");



        $sWhere .= ($this->db->isNull($ary["nEquivalencia"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nEquivalencia = {$this->db->quote($ary['nEquivalencia'])} ");



        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prod.nEstado = {$this->db->quote($ary['nEstado'])}  ");



        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        // echo $sSQL;

        // exit;





        return $this->db->run(trim($sSQL));

    }



    public function fncGrabarProductoListaPrecio(

        $nIdProducto,

        $nIdTipo,

        $dFechaAlta,

        $dFechaFin,

        $nPrecio,

        $nIndefinido,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLInsert("productoslistaprecios", [

            "nIdProducto"   => $nIdProducto,

            "nIdTipo"       => $nIdTipo,

            "dFechaAlta"    => "STR_TO_DATE( '$dFechaAlta', '%d/%m/%Y' ) ",

            "dFechaFin"     => "STR_TO_DATE( '$dFechaFin', '%d/%m/%Y' ) ",

            "nPrecio"       => $nPrecio,

            "nIndefinido"   => $nIndefinido,

            "nEstado"       => $nEstado,

        ]);



        return  $this->db->run(trim($sSQL));

    }





    public function fncActualizarProductoListaPrecio(

        $nIdProductoListaPrecio,

        $nIdProducto,

        $nIdTipo,

        $dFechaAlta,

        $dFechaFin,

        $nPrecio,

        $nIndefinido,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLUpdate("productoslistaprecios", [

            "nIdProducto"   => $nIdProducto,

            "nIdTipo"       => $nIdTipo,

            "dFechaAlta"    => "STR_TO_DATE( '$dFechaAlta', '%d/%m/%Y' ) ",

            "dFechaFin"     => "STR_TO_DATE( '$dFechaFin', '%d/%m/%Y' ) ",

            "nPrecio"       => $nPrecio,

            "nIndefinido"   => $nIndefinido,

            "nEstado"       => $nEstado,

        ], " nIdProductoListaPrecio = $nIdProductoListaPrecio");



        return  $this->db->run(trim($sSQL));

    }







    public function fncActualizarIndefinidoByProducto(

        $nIdProducto,

        $nIdTipo,

        $nIndefinido

    ) {



        $sSQL = $this->db->generateSQLUpdate("productoslistaprecios", [

            "nIndefinido" => $nIndefinido,

        ], " nIdProducto = $nIdProducto AND nIdTipo = $nIdTipo ");



        return $this->db->run(trim($sSQL));

    }





    public function fncEliminarProductoListaPrecio($nIdProductoListaPrecio)

    {

        $sSQL = $this->db->generateSQLDelete("productoslistaprecios", " nIdProductoListaPrecio = $nIdProductoListaPrecio ");



        return $this->db->run($sSQL);

    }



    public function fncGetProductoListaPrecio($aryInput = [])

    {

        $aryAllFilters = [

            "sOrderBy"                   => null,

            "sLimit"                     => null,

            "nIdProductoListaPrecio"     => null,

            "nIdProducto"                => null,

            "nIdTipo"                    => null,

            "nIndefinido"                => null,

            "nEstado"                    => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT 

                    prodlist.nIdProductoListaPrecio,

                    prodlist.nIdProducto,

                    prodlist.nPrecio,

                    prodlist.nIdTipo,

                    prodlist.nIndefinido,

                    prod.sDescripcion as sProducto,

                    IFNULL( DATE_FORMAT( prodlist.dFechaAlta, '%d/%m/%Y' ), '' ) as dFechaAlta,

                    IFNULL( DATE_FORMAT( prodlist.dFechaFin, '%d/%m/%Y' ), '' ) as dFechaFin,

                    prodlist.nEstado

                FROM productoslistaprecios AS prodlist

                INNER JOIN productos AS prod ON prodlist.nIdProducto = prod.nIdProducto";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdProductoListaPrecio"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodlist.nIdProductoListaPrecio = {$this->db->quote($ary['nIdProductoListaPrecio'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdProducto"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodlist.nIdProducto = {$this->db->quote($ary['nIdProducto'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdTipo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodlist.nIdTipo = {$this->db->quote($ary['nIdTipo'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIndefinido"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodlist.nIndefinido = {$this->db->quote($ary['nIndefinido'])}  ");



        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        return $this->db->run(trim($sSQL));

    }





    public function fncGetPrecioListaPrecio($nIdProducto, $nIdTipo)

    {

        $sSQL = "SELECT prodlist.nPrecio FROM productoslistaprecios AS prodlist

                WHERE (CURDATE() >= prodlist.dFechaAlta AND CURDATE() <= prodlist.dFechaFin) 

                AND prodlist.nIdProducto = $nIdProducto AND nIdTipo = $nIdTipo AND prodlist.nEstado = 1 AND prodlist.nIndefinido = 0 

                AND prodlist.dFechaAlta IS NOT NULL AND prodlist.dFechaAlta IS NOT NULL ORDER BY prodlist.nIdProductoListaPrecio DESC LIMIT 1";



        return $this->db->run(trim($sSQL));

    }





    public function fncActualizarPC($nIdProducto, $nPrecioCompra)

    {



        $sSQL = $this->db->generateSQLUpdate("productos", [

            "nPrecioCompra" => $nPrecioCompra,

        ], " nIdProducto = $nIdProducto");



        return $this->db->run(trim($sSQL));

    }





    public function fncActualizarPV($nIdProducto, $nPrecioVenta)

    {



        $sSQL = $this->db->generateSQLUpdate("productos", [

            "nPrecioVenta" => $nPrecioVenta,

        ], " nIdProducto = $nIdProducto");



        return $this->db->run(trim($sSQL));

    }





    public function fncGrabarProductoEquivalencia(

        $nIdProductoPadre,

        $nIdUnidadMedidaPadre,

        $nCantidadPadre,

        $nIdProductoHijo,

        $nIdUnidadMedidaHijo,

        $nCantidadHijo,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLInsert("productosequivalencia", [

            "nIdProductoPadre"         => $nIdProductoPadre,

            "nIdUnidadMedidaPadre"     => $nIdUnidadMedidaPadre,

            "nCantidadPadre"           => $nCantidadPadre,

            "nIdProductoHijo"          => $nIdProductoHijo,

            "nIdUnidadMedidaHijo"      => $nIdUnidadMedidaHijo,

            "nCantidadHijo"            => $nCantidadHijo,

            "nEstado"                  => $nEstado,



        ]);



        return  $this->db->run(trim($sSQL));

    }



    public function fncActualizarProductoEquivalencia(

        $nIdProductoEquivalencia,

        $nIdProductoPadre,

        $nIdUnidadMedidaPadre,

        $nCantidadPadre,

        $nIdProductoHijo,

        $nIdUnidadMedidaHijo,

        $nCantidadHijo,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLUpdate("productosequivalencia", [

            "nIdProductoPadre"         => $nIdProductoPadre,

            "nIdUnidadMedidaPadre"     => $nIdUnidadMedidaPadre,

            "nCantidadPadre"           => $nCantidadPadre,

            "nIdProductoHijo"          => $nIdProductoHijo,

            "nIdUnidadMedidaHijo"      => $nIdUnidadMedidaHijo,

            "nCantidadHijo"            => $nCantidadHijo,

            "nEstado"                  => $nEstado,

        ], "nIdProductoEquivalencia = $nIdProductoEquivalencia");



        return  $this->db->run(trim($sSQL));

    }



    public function fncEliminarProductoEquivalencia($nIdProductoEquivalencia)

    {

        $sSQL = $this->db->generateSQLDelete("productosequivalencia", " nIdProductoEquivalencia = $nIdProductoEquivalencia ");

        return $this->db->run($sSQL);

    }



    public function fncGetProductoEquivalencia($aryInput = [])

    {

        $aryAllFilters = [

            "sOrderBy"                    => null,

            "sLimit"                      => null,

            "nIdProductoEquivalencia"     => null,

            "nIdProductoPadre"            => null,

            "nIdProductoHijo"             => null,

            "nEstado"                     => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT 

                    pe.nIdProductoEquivalencia,

                    pe.nIdProductoPadre,

                    pe.nIdUnidadMedidaPadre,

                    pe.nCantidadPadre,

                    pe.nIdProductoHijo,

                    pe.nIdUnidadMedidaHijo,

                    pe.nCantidadHijo,

                    pe.nEstado

                FROM productosequivalencia AS pe";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdProductoEquivalencia"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pe.nIdProductoEquivalencia = {$this->db->quote($ary['nIdProductoEquivalencia'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdProductoPadre"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pe.nIdProductoPadre = {$this->db->quote($ary['nIdProductoPadre'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdProductoHijo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pe.nIdProductoHijo = {$this->db->quote($ary['nIdProductoHijo'])}  ");



        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pe.nEstado = {$this->db->quote($ary['nEstado'])}  ");



        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        return $this->db->run(trim($sSQL));

    }









    public function fncGrabarHistorialEquivalencia(

        $nIdEmpresa,

        $nIdSede,

        $nIdMovimientoGeneral,

        $nIdMovimientoEntrada,

        $nIdMovimientoSalida,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLInsert("historialequivalencia", [

            "nIdEmpresa"               => $nIdEmpresa,

            "nIdSede"                  => $nIdSede,

            "nIdMovimientoGeneral"     => $nIdMovimientoGeneral,

            "nIdMovimientoEntrada"     => $nIdMovimientoEntrada,

            "nIdMovimientoSalida"      => $nIdMovimientoSalida,

            "dFechaCreacion"           => "NOW()",

            "nEstado"                  => $nEstado,

        ]);



        return $this->db->run(trim($sSQL));

    }





    public function fncActualizarHistorialEquivalencia(

        $nIdHistorialEquivalencia,

        $nIdEmpresa,

        $nIdSede,

        $nIdMovimientoGeneral,

        $nIdMovimientoEntrada,

        $nIdMovimientoSalida,

        $nEstado

    ) {



        $sSQL = $this->db->generateSQLUpdate("historialequivalencia", [

            "nIdEmpresa"               => $nIdEmpresa,

            "nIdSede"                  => $nIdSede,

            "nIdMovimientoGeneral"     => $nIdMovimientoGeneral,

            "nIdMovimientoEntrada"     => $nIdMovimientoEntrada,

            "nIdMovimientoSalida"      => $nIdMovimientoSalida,

            "nEstado"                  => $nEstado,

        ], "nIdHistorialEquivalencia = $nIdHistorialEquivalencia");



        return $this->db->run(trim($sSQL));

    }





    public function fncEliminarHistorialEquivalencia($nIdHistorialEquivalencia)

    {

        $sSQL = $this->db->generateSQLDelete("historialequivalencia", " nIdHistorialEquivalencia = $nIdHistorialEquivalencia ");

        return $this->db->run($sSQL);

    }





    public function fncEliminarHistorialEquivalenciaByMov($nIdMovimientoGeneral)

    {

        $sSQL = $this->db->generateSQLDelete("historialequivalencia", " nIdMovimientoGeneral = $nIdMovimientoGeneral ");

        return $this->db->run($sSQL);

    }



    public function fncGetHistorialEquivalencia($aryInput = [])

    {

        $aryAllFilters = [

            "sOrderBy"                     => null,

            "sLimit"                       => null,

            "nIdEmpresa"                   => null,

            "nIdSede"                      => null,

            "nIdHistorialEquivalencia"     => null,

            "nIdMovimientoGeneral"         => null,

            "nIdMovimientoGeneralNull"     => null,

            "nIdMovimientoEntrada"         => null,

            "nIdMovimientoSalida"          => null,

            "nEstado"                      => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT DISTINCT 

                   he.nIdEmpresa,

                   he.nIdSede,

                   he.nIdHistorialEquivalencia,

                   he.nIdMovimientoGeneral,

                   he.nIdMovimientoEntrada,

                   he.nIdMovimientoSalida,

                   IFNULL( DATE_FORMAT( he.dFechaCreacion, '%d/%m/%Y' ), '' ) as dFechaCreacion, 



                   he.nEstado

                FROM historialequivalencia AS he";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdHistorialEquivalencia"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " he.nIdHistorialEquivalencia = {$this->db->quote($ary['nIdHistorialEquivalencia'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdEmpresa"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " he.nIdEmpresa = {$this->db->quote($ary['nIdEmpresa'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " he.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdMovimientoGeneral"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " he.nIdMovimientoGeneral = {$this->db->quote($ary['nIdMovimientoGeneral'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdMovimientoGeneral"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " he.nIdMovimientoGeneral = {$this->db->quote($ary['nIdMovimientoGeneral'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdMovimientoGeneralNull"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " he.nIdMovimientoGeneral " . $ary['nIdMovimientoGeneralNull']);



        $sWhere .= ($this->db->isNull($ary["nIdMovimientoSalida"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " he.nIdMovimientoSalida = {$this->db->quote($ary['nIdMovimientoSalida'])}  ");



        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " pe.nEstado = {$this->db->quote($ary['nEstado'])}  ");



        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        return $this->db->run(trim($sSQL));

    }





    public function fncGrabarProductoDescomp(

        $sNombre,

        $nEstado

    ) {

        $sSQL = $this->db->generateSQLInsert("productosdescomp", [

            "sNombre"      => $sNombre,

            "nEstado"      => $nEstado,

        ]);

        return $this->db->run($sSQL);

    }



    public function fncActualizarProductoDescomp(

        $nIdProductoDescomp,

        $sNombre,

        $nEstado

    ) {

        $sSQL = $this->db->generateSQLUpdate("productosdescomp", [

            "sNombre"      => $sNombre,

            "nEstado"      => $nEstado,

        ], "nIdProductoDescomp = $nIdProductoDescomp");

        return $this->db->run($sSQL);

    }





    public function fncEliminarProductosDescomp($nIdProductoDescomp)

    {

        $sSQL = $this->db->generateSQLDelete("productosdescomp", " nIdProductoDescomp = $nIdProductoDescomp ");

        return $this->db->run($sSQL);

    }



    public function fncGetProductosDescomp($aryInput = [])

    {

        $aryAllFilters = [

            "sOrderBy"                     => null,

            "sLimit"                       => null,

            "nIdProductoDescomp"           => null,

            "nIdSede"                      => null,

            "nEstado"                      => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT DISTINCT 

                    prodsc.nIdProductoDescomp,

                    prodsc.sNombre,

                    prodsc.nEstado

                FROM productosdescomp AS prodsc

                LEFT JOIN productosdescompdetalle AS prodscdet ON  prodsc.nIdProductoDescomp = prodscdet.nIdProductoDescomp

                LEFT JOIN productos AS prod ON  prodscdet.nIdProductoPadre = prod.nIdProducto

                LEFT JOIN categorias AS cat ON  prod.nIdCategoria = cat.nIdCategoria";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdProductoDescomp"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodsc.nIdProductoDescomp = {$this->db->quote($ary['nIdProductoDescomp'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdSede"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " cat.nIdSede = {$this->db->quote($ary['nIdSede'])}  ");



        $sWhere .= ($this->db->isNull($ary["nEstado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodsc.nEstado = {$this->db->quote($ary['nEstado'])}  ");



        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        return $this->db->run(trim($sSQL));

    }







    public function fncGrabarProductoDescompDet(

        $nIdProductoDescomp,

        $nIdProductoPadre,

        $nIdUnidadMedidaPadre,

        $nIdProductoHijo,

        $nIdUnidadMedidaHijo,

        $nDescomp

    ) {

        $sSQL = $this->db->generateSQLInsert("productosdescompdetalle", [

            "nIdProductoDescomp"   => $nIdProductoDescomp,

            "nIdProductoPadre"     => $nIdProductoPadre,

            "nIdUnidadMedidaPadre" => $nIdUnidadMedidaPadre,

            "nIdProductoHijo"      => $nIdProductoHijo,

            "nIdUnidadMedidaHijo"  => $nIdUnidadMedidaHijo,

            "nDescomp"             => $nDescomp,

        ]);

        return $this->db->run($sSQL);

    }







    public function fncActualizarProductoDescompDet(

        $nIdProductoDescomDetalle,

        $nIdProductoDescomp,

        $nIdProductoPadre,

        $nIdUnidadMedidaPadre,

        $nIdProductoHijo,

        $nIdUnidadMedidaHijo,

        $nDescomp

    ) {

        $sSQL = $this->db->generateSQLUpdate("productosdescompdetalle", [

            "nIdProductoDescomp"   => $nIdProductoDescomp,

            "nIdProductoPadre"     => $nIdProductoPadre,

            "nIdUnidadMedidaPadre" => $nIdUnidadMedidaPadre,

            "nIdProductoHijo"      => $nIdProductoHijo,

            "nIdUnidadMedidaHijo"  => $nIdUnidadMedidaHijo,

            "nDescomp"             => $nDescomp,

        ], "nIdProductoDescomDetalle = $nIdProductoDescomDetalle");

        return $this->db->run($sSQL);

    }



    public function fncEliminarProdDesDetByIdProdDescp($nIdProductoDescomp)

    {

        $sSQL = $this->db->generateSQLDelete("productosdescompdetalle", " nIdProductoDescomp = $nIdProductoDescomp ");

        return $this->db->run($sSQL);

    }



    public function fncEliminarProductosDescompDet($nIdProductoDescomDetalle)

    {

        $sSQL = $this->db->generateSQLDelete("productosdescompdetalle", " nIdProductoDescomDetalle = $nIdProductoDescomDetalle ");

        return $this->db->run($sSQL);

    }







    public function fncGetProductosDescompDet($aryInput = [])

    {

        $aryAllFilters = [

            "sOrderBy"                     => null,

            "sLimit"                       => null,

            "nIdProductoDescomDetalle"     => null,

            "nIdProductoDescomp"           => null,

            "nIdProductoPadre"             => null,

            "nIdProductoHijo"              => null,

            "nEstado"                      => null

        ];



        $ary = $this->db->filterArray($aryInput, $aryAllFilters);



        $sSQL = "SELECT DISTINCT 

                    prodscdet.nIdProductoDescomDetalle,

                    prodscdet.nIdProductoDescomp,

                    prodscdet.nIdProductoPadre,

                    prodscdet.nIdProductoHijo,

                    prodscdet.nIdUnidadMedidaPadre,

                    prodscdet.nIdUnidadMedidaHijo,

                    IFNULL(prodPadre.sDescripcion,'') AS sDescripcionPadre,

                    IFNULL(prodHijo.sDescripcion,'') AS sDescripcionHijo,

                    IFNULL(umPadre.sNombreCorto,'') AS sCortoUMPadre,

                    IFNULL(umHijo.sNombreCorto,'') AS sCortoUMHijo,

                    prodscdet.nDescomp

                FROM productosdescompdetalle AS prodscdet

                LEFT JOIN productos AS prodPadre ON  prodscdet.nIdProductoPadre = prodPadre.nIdProducto

                LEFT JOIN unidadmedidas AS umPadre ON  prodscdet.nIdUnidadMedidaPadre = umPadre.nIdUnidadMedida 

                LEFT JOIN productos AS prodHijo ON  prodscdet.nIdProductoHijo = prodHijo.nIdProducto

                LEFT JOIN unidadmedidas AS umHijo ON  prodscdet.nIdUnidadMedidaHijo = umHijo.nIdUnidadMedida    ";



        $sWhere = "";



        $sWhere .= ($this->db->isNull($ary["nIdProductoDescomDetalle"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodscdet.nIdProductoDescomDetalle = {$this->db->quote($ary['nIdProductoDescomDetalle'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdProductoDescomp"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodscdet.nIdProductoDescomp = {$this->db->quote($ary['nIdProductoDescomp'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdProductoPadre"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodscdet.nIdProductoPadre = {$this->db->quote($ary['nIdProductoPadre'])}  ");



        $sWhere .= ($this->db->isNull($ary["nIdProductoHijo"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " prodscdet.nIdProductoHijo = {$this->db->quote($ary['nIdProductoHijo'])}  ");



        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;



        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);



        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);



        return $this->db->run(trim($sSQL));

    }





    public function fncObtenerProductosAlerta($nIdSede)

    {

        $sSQL = "SELECT prod.sDescripcion AS sProducto, IFNULL(prod.sCodigoInterno, '') AS sCodigoInternoProducto,   IFNULL(um.sNombreCorto, '') AS sUnidadMedidaProducto, prod.nStockActual, prod.nStockMinimo

            FROM productos AS prod

            LEFT JOIN categorias AS cat ON cat.nIdCategoria = prod.nIdCategoria

            LEFT JOIN unidadmedidas AS um ON um.nIdUnidadMedida = prod.nIdUnidadMedida

            WHERE prod.nStockActual <= prod.nStockMinimo AND cat.nIdSede = $nIdSede AND prod.nVenderStock = 1 AND prod.nStockMinimo <> 0 AND prod.nStockMaximo <> 0  GROUP BY prod.nIdProducto ";

        // echo $sSQL;

        return $this->db->run(trim($sSQL));

    }





    public function fncObtenerFlagProducto($nIdProducto)

    {

        $sSQL = "SELECT prod.nVenderStock FROM productos AS prod WHERE prod.nIdProducto = $nIdProducto";

        // echo $sSQL;

        return $this->db->run(trim($sSQL));

    }





}

