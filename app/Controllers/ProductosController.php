<?php



namespace Application\Controllers;



use Exception;

use Application\Libs\Upload;

use Application\Libs\Session;

use Application\Models\Categorias;

use Application\Models\CatalogoTabla;

use Application\Core\Controller as Controller;

use Application\Models\Lotes;

use Application\Models\Productos;

use Application\Models\Proveedores;

use Application\Models\Sedes;

use Application\Models\UbicacionAlmacen;

use Application\Models\UnidadMedidas;



class ProductosController extends Controller

{

    //model principal

    public $users;

    public $session;

    public $categorias;

    public $productos;

    public $proveedores;

    public $catalogotabla;

    public $unidadMedidas;

    public $sedes;

    public $lotes;

    public $ubicacionAlmacen;



    public $sUrlProductos  = "productos";

    public $sUrlDescomp    = "descompocision";



    public function __construct()

    {

        parent::__construct();

        $this->session          = new Session();

        $this->catalogotabla    = new CatalogoTabla();

        $this->categorias       = new Categorias();

        $this->productos        = new Productos();

        $this->proveedores      = new Proveedores();

        $this->unidadMedidas    = new UnidadMedidas();

        $this->sedes            = new Sedes();

        $this->lotes            = new Lotes();

        $this->ubicacionAlmacen    = new UbicacionAlmacen();



        $this->session->init();
    }





    public function index()

    {

        $this->authAdmin($this->session);



        $user = $this->session->get('user');



        try {



            $categoriasController = new CategoriasController();



            $this->view('admin/productos', [

                'sTitulo'               => 'Mantenimientos de productos',

                'user'                  => $user,

                'aryCategorias'         => $categoriasController->fncProcesarArbolCategorias($user["nIdSede"]),

                'aryUnidadMedida'       => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdSede" => $user["nIdSede"]]),

                'aryTipoProducto'       => $this->catalogotabla->fncListado("TIPO_PRODUCTO"),

                'aryTipoPrecio'         => $this->catalogotabla->fncListado("TIPO_PRECIO_PRODUCTOS"),

                'aryProveedores'        => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),

                'aryLotes'              => $this->lotes->fncGetLotes(["nIdSede" => $user["nIdSede"]]),

                'bShowMenu'             => true,

                "nAdmin"                => $this->fncIsAdmin($user["nIdRol"], $this->sUrlProductos) ? 1 : 0,

                "aryUbicacionAlmacen"   => $this->ubicacionAlmacen->fncGetUA(["nIdSede" => $user["nIdSede"]])

            ]);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncPopulate()

    {

        try {



            $aryCategoria       = isset($_POST['aryCategoria']) ? $_POST['aryCategoria'] : null;

            $aryIdTipo          = isset($_POST['aryIdTipo']) ? $_POST['aryIdTipo'] : null;

            $aryTipoPrecio      = isset($_POST['aryTipoPrecio']) ? $_POST['aryTipoPrecio'] : null;

            $nVenderStock       = isset($_POST['nVenderStock']) ? $_POST['nVenderStock'] : null;

            $nAcumulaPuntos     = isset($_POST['nAcumulaPuntos']) ? $_POST['nAcumulaPuntos'] : null;









            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }



            // Valida valores del formulario

            $aryRows      = [];

            $aryData      = $this->productos->fncGetProductos([

                "nIdSede"           => $user["nIdSede"],

                "aryCategoria"      => $aryCategoria,

                "aryIdTipo"         => $aryIdTipo,

                "aryTipoPrecio"     => $aryTipoPrecio,

                "nVenderStock"      => $nVenderStock,

                "nAcumulaPuntos"    => $nAcumulaPuntos,

            ]);





            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista());





            $nTipoProductoVenta        = $this->fncGetVarConfig("nTipoProductoVenta");

            $nTipoProductoCompraVenta  = $this->fncGetVarConfig("nTipoProductoCompraVenta");

            $nTipoProductoCompra       = $this->fncGetVarConfig("nTipoProductoCompra");

            $nTipoPrecioVariable       = $this->fncGetVarConfig("nTipoPrecioVariable");



            if (fncValidateArray($aryData)) {

                foreach ($aryData as $aryLoop) {



                    // nf($aryLoop["nPrecioCompra"]) ;

                    // nf($aryLoop["nPrecioVenta"]) ;

                    // continue;



                    $sActionShow         = "fncMostrarProducto(" . $aryLoop['nIdProducto'] . ", 'ver' );";

                    $sActionEdit         = "fncMostrarProducto(" . $aryLoop['nIdProducto'] . ", 'editar' );";

                    $sActionEliminar     = "fncEliminarProducto(" . $aryLoop['nIdProducto'] . ");";



                    $sActionListaPC      = "fncMostrarContentLista(" . $aryLoop['nIdProducto'] . " , " . $nTipoProductoCompra . " , 'COMPRA' );";

                    $sActionListaPV      = "fncMostrarContentLista(" . $aryLoop['nIdProducto'] . " , " . $nTipoProductoVenta . " , 'VENTA' );";



                    $sLinkListaPC         = "";

                    $sLinkListaPV         = "";



                    // Si el precio es variable

                    if ($nTipoPrecioVariable == $aryLoop["nTipoPrecio"]) {

                        if ($nTipoProductoCompraVenta == $aryLoop["nIdTipo"]) {

                            $sLinkListaPC  = ' <a onclick="' . $sActionListaPC . '" href="javascript:;"   title="Lista de precios de compras" class="text-primary"><i class="material-icons">shopping_basket</i> </a>';

                            $sLinkListaPV  = ' <a onclick="' . $sActionListaPV . '" href="javascript:;"   title="Lista de precios de ventas" class="text-primary"><i class="material-icons">attach_money</i> </a>';
                        } elseif ($nTipoProductoCompra == $aryLoop["nIdTipo"]) {

                            $sLinkListaPC  = ' <a onclick="' . $sActionListaPC . '" href="javascript:;"   title="Lista de precios de compras" class="text-primary"><i class="material-icons">shopping_basket</i> </a>';
                        } elseif ($nTipoProductoVenta == $aryLoop["nIdTipo"]) {

                            $sLinkListaPV  = ' <a onclick="' . $sActionListaPV . '" href="javascript:;"   title="Lista de precios de ventas" class="text-primary"><i class="material-icons">attach_money</i> </a>';
                        }
                    }



                    // // Tipo de producto de venta - tipo de precio variable

                    // if ($nTipoProductoVenta == $aryLoop["nIdTipo"] && $nTipoPrecioVariable == $aryLoop["nTipoPrecio"]) {

                    //     $sActionListaPrecio  = "fncMostrarContentListaPrecio(" . $aryLoop['nIdProducto'] . ");";

                    //     $sActionLista        = ' <a onclick="' . $sActionListaPrecio . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">attach_money</i> </a>';

                    //     $aryDataProducto     = $this->productos->fncGetPrecioListaPrecio($aryLoop["nIdProducto"]);

                    //     $nPrecio             = fncValidateArray($aryDataProducto) ? $aryDataProducto[0]["nPrecio"]  : '<span class="text-danger">No se encontro un precio . Verifique su lista de precios porfavor.</span>';

                    // } else {

                    //     $nPrecio = $aryLoop["nPrecio"];

                    // }



                    $sLinkShow   = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';

                    $sLinkEdit   = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>'  : '';

                    $sLinkDelete = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>'  : '';





                    $sAcciones = '<div class="content-acciones">

                                    ' . $sLinkShow . '

                                    ' . $sLinkEdit . '

                                    ' . $sLinkListaPC . '

                                    ' . $sLinkListaPV . '

                                    ' . $sLinkDelete . '

                                </div>';



                    $aryRows[] = [

                        "sAcciones"        => $sAcciones,

                        "sCategoria"       => strup($aryLoop["sCategoria"]),

                        "sDescripcion"     => strup($aryLoop["sDescripcion"]),

                        "sCodigoInterno"   => strup($aryLoop["sCodigoInterno"]),

                        "sUnidadMedida"    => strup($aryLoop["sUnidadMedida"]),

                        "sCodigoBarras"    => $aryLoop["sCodigoBarras"],

                        "sTipoPrecio"      => $aryLoop["sTipoPrecio"],

                        "sTipoProducto"    => $aryLoop["sTipoProducto"],

                        "nStockActual"     => $aryLoop["nVenderStock"] == 1  ? $aryLoop["nStockActual"] : 0, // Si tiene el flag de vender con stock mostrarar su stock actual si no 0

                        "sVenderStock"     => $aryLoop["nVenderStock"] == 1 ? 'SI' : 'NO',

                        "sEquivalencia"    => $aryLoop["nEquivalencia"] == 1 ? 'SI' : 'NO',

                        "sAcumulaPuntos"   => $aryLoop["nAcumulaPuntos"] == 1 ? 'SI' : 'NO',

                        "nPrecioCompra"    => nf($aryLoop["nPrecioCompra"]),

                        "nPrecioVenta"     => nf($aryLoop["nPrecioVenta"]),

                        'sImagen'          => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',

                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",

                    ];
                }
            }



            $this->json($aryRows);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }





    public function fncPopulateConsultaStock()

    {

        try {



            $aryProductos = isset($_POST['aryProductos']) ? $_POST['aryProductos'] : null;

            $nTieneStock  = isset($_POST['nTieneStock']) ? $_POST['nTieneStock'] : '';



            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }



            // Valida valores del formulario



            $sWhereStock =  $nTieneStock == '' ? null : ($nTieneStock == 1 ? " > 0 " : " = 0 ");

            $aryRows      = [];

            $aryData      = $this->productos->fncGetProductos(["nIdSede" => $user["nIdSede"], "aryProductos" => $aryProductos,  "nStockActual" => $sWhereStock]);

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlProductos);



            if (fncValidateArray($aryData)) {

                foreach ($aryData as $aryLoop) {

                    $aryRows[] = [

                        "sCategoria"       => strup($aryLoop["sCategoria"]),

                        "sDescripcion"     => strup($aryLoop["sDescripcion"]),

                        "sUnidadMedida"    => strup($aryLoop["sUnidadMedida"]),

                        "sCodigoInterno"   => $aryLoop["sCodigoInterno"],

                        "sTipoPrecio"      => $aryLoop["sTipoPrecio"],

                        "sTipoProducto"    => $aryLoop["sTipoProducto"],

                        "nStockActual"     => $aryLoop["nStockActual"],

                        "sVenderStock"     => $aryLoop["nVenderStock"] == 1 ? 'SI' : 'NO',

                        "nPrecioCompra"    => nf($aryLoop["nPrecioCompra"]),

                        "nPrecioVenta"     => nf($aryLoop["nPrecioVenta"]),

                        'sImagen'          => !empty($aryLoop['sImagen']) ? '<img class="user-avatar rounded-circle  img-usuario" src="' . src('multi/' . $aryLoop['sImagen'])  . '" alt="' . $aryLoop['sImagen'] . '">' : '',

                        "sEstado"          => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",

                    ];
                }
            }



            $this->json($aryRows);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function consultaStock()

    {

        try {

            $this->authAdmin($this->session);



            $user = $this->session->get('user');



            $this->view('admin/reporte-consulta-stock', [

                'sTitulo'          => 'Consulta de stock',

                'user'             => $user,

                'bShowMenu'        => true,

                'aryProductos'     => $this->productos->fncGetProductos(["nIdSede" => $user["nIdSede"]]),

                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->fncGetVista()) ? 1 : 0

            ]);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncGrabarProducto()

    {

        try {

            $nIdRegistro        = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $nIdCategoria       = isset($_POST['nIdCategoria']) ? $_POST['nIdCategoria'] : null;



            $sDescripcion       = isset($_POST['sDescripcion']) ? $_POST['sDescripcion'] : null;

            $nIdUnidadMedida    = isset($_POST['nIdUnidadMedida']) ? $_POST['nIdUnidadMedida'] : null;

            $nIdTipo            = isset($_POST['nIdTipo']) ? $_POST['nIdTipo'] : null;

            $sImagen            = isset($_FILES['sImagen']) ? $_FILES['sImagen'] : null;

            $nTipoPrecio        = isset($_POST['nTipoPrecio']) ? $_POST['nTipoPrecio'] : null;

            $nPrecioCompra      = isset($_POST['nPrecioCompra']) ? $_POST['nPrecioCompra'] : null;

            $nPrecioVenta       = isset($_POST['nPrecioVenta']) ? $_POST['nPrecioVenta'] : null;



            $nVenderStock       = isset($_POST['nVenderStock']) ? $_POST['nVenderStock'] : null;

            $nEquivalencia      = isset($_POST['nEquivalencia']) ? $_POST['nEquivalencia'] : null;



            $nIdProductoHijo        = isset($_POST['nIdProductoHijo']) ? $_POST['nIdProductoHijo'] : null;

            $nIdUnidadMedidaHijo    = isset($_POST['nIdUnidadMedidaHijo']) ? $_POST['nIdUnidadMedidaHijo'] : null;

            $nCantidadPadre         = isset($_POST['nCantidadPadre']) ? $_POST['nCantidadPadre'] : null;

            $nCantidadHijo          = isset($_POST['nCantidadHijo']) ? $_POST['nCantidadHijo'] : null;





            $nIdLote               = isset($_POST['nIdLote']) ? $_POST['nIdLote'] : null;

            $nIdUbicacionAlmacen    = isset($_POST['nIdUbicacionAlmacen']) ? $_POST['nIdUbicacionAlmacen'] : null;



            $dFechaVencimiento     = isset($_POST['dFechaVencimiento']) ? $_POST['dFechaVencimiento'] : null;

            $nStockMinimo          = isset($_POST['nStockMinimo']) ? $_POST['nStockMinimo'] : null;

            $nStockMaximo          = isset($_POST['nStockMaximo']) ? $_POST['nStockMaximo'] : null;

            $nAcumulaPuntos        = isset($_POST['nAcumulaPuntos']) ? $_POST['nAcumulaPuntos'] : null;





            $sDetalle             = isset($_POST['sDetalle']) ? $_POST['sDetalle'] : null;

            $sCodigoInterno       = isset($_POST['sCodigoInterno']) ? $_POST['sCodigoInterno'] : null;

            $sCodigoBarras        = isset($_POST['sCodigoBarras']) ? $_POST['sCodigoBarras'] : null;

            $nPorcentajeComision  = isset($_POST['nPorcentajeComision']) ? $_POST['nPorcentajeComision'] : null;





            $nEstado                = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;





            // Valida valores del formulario

            if (is_null($nIdRegistro)) {

                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }



            $sNombreImagen = null;

            $nIdProductoNew = null;



            if (isset($sImagen) && !is_null($sImagen)) {

                $sNombreImagen = Upload::process($sImagen, 'multi');
            }



            // Crear

            if ($nIdRegistro == 0) {

                $nIdProductoNew = $this->productos->fncGrabarProducto(

                    $nIdCategoria,

                    $sDescripcion,

                    $nIdUnidadMedida,

                    $nIdTipo,

                    $sNombreImagen,

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

                );



                if ($nEquivalencia == 1) {

                    $this->productos->fncGrabarProductoEquivalencia(

                        $nIdProductoNew,

                        $nIdUnidadMedida,

                        $nCantidadPadre,

                        $nIdProductoHijo,

                        $nIdUnidadMedidaHijo,

                        $nCantidadHijo,

                        $nEstado

                    );
                }
            } else {

                //Actualizar

                $this->productos->fncActualizarProducto(

                    $nIdRegistro,

                    $nIdCategoria,

                    $sDescripcion,

                    $nIdUnidadMedida,

                    $nIdTipo,

                    $sNombreImagen,

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

                );



                $nTipoPrecioVariable      = $this->fncGetVarConfig("nTipoPrecioVariable");

                $nTipoProductoVenta       = $this->fncGetVarConfig("nTipoProductoVenta");

                $nTipoProductoCompra      = $this->fncGetVarConfig("nTipoProductoCompra");

                $nTipoProductoCompraVenta = $this->fncGetVarConfig("nTipoProductoCompraVenta");



                if ($nTipoPrecio == $nTipoPrecioVariable) {

                    if ($nIdTipo == $nTipoProductoVenta) {

                        $this->fncActualizarPrecioVariable($nIdRegistro, $nTipoProductoVenta);
                    } elseif ($nIdTipo == $nTipoProductoCompra) {

                        $this->fncActualizarPrecioVariable($nIdRegistro, $nTipoProductoCompra);
                    } elseif ($nIdTipo == $nTipoProductoCompraVenta) {

                        $this->fncActualizarPrecioVariable($nIdRegistro, $nTipoProductoVenta);

                        $this->fncActualizarPrecioVariable($nIdRegistro, $nTipoProductoCompra);
                    }
                }





                if ($nEquivalencia == 1) {

                    $aryProductoEquivalencia = $this->productos->fncGetProductoEquivalencia(["nIdProductoPadre" => $nIdRegistro]);

                    if (fncValidateArray($aryProductoEquivalencia)) {

                        // Si existe informacion actualizamos

                        $aryProductoEquivalencia = $aryProductoEquivalencia[0];



                        $this->productos->fncActualizarProductoEquivalencia(

                            $aryProductoEquivalencia["nIdProductoEquivalencia"],

                            $nIdRegistro,

                            $nIdUnidadMedida,

                            $nCantidadPadre,

                            $nIdProductoHijo,

                            $nIdUnidadMedidaHijo,

                            $nCantidadHijo,

                            $nEstado

                        );
                    } else {

                        // Si No existe informacion insertamos



                        $this->productos->fncGrabarProductoEquivalencia(

                            $nIdRegistro,

                            $nIdUnidadMedida,

                            $nCantidadPadre,

                            $nIdProductoHijo,

                            $nIdUnidadMedidaHijo,

                            $nCantidadHijo,

                            $nEstado

                        );
                    }
                }
            }



            $sSuccess =  $nIdRegistro == 0 ? 'Producto registrado exitosamente...' : 'Producto actualizado exitosamente...';



            $this->json(array("success" => $sSuccess, "nIdProductoNew" => $nIdProductoNew));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncMostrarProducto()

    {

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }



            $aryData = $this->productos->fncGetProductos(["nIdProducto" => $nIdRegistro]);

            $aryDataProductoEquivalencia = $this->productos->fncGetProductoEquivalencia(["nIdProductoPadre" => $nIdRegistro]);



            $this->json(array(

                "success"                     => true,

                "aryData"                     => fncValidateArray($aryData) ? $aryData[0] : null,

                "nPrecioCompra"               => fncValidateArray($aryData) ? nf($aryData[0]["nPrecioCompra"]) : null,

                "nPrecioVenta"                => fncValidateArray($aryData) ? nf($aryData[0]["nPrecioVenta"]) : null,

                "aryDataProductoEquivalencia" => fncValidateArray($aryDataProductoEquivalencia) ? $aryDataProductoEquivalencia[0] : null

            ));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncEliminarProducto()

    {

        // Recibe valores del formulario

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }



            $aryData = $this->productos->fncGetProductos(["nIdProducto" => $nIdRegistro]);



            if (fncValidateArray($aryData)) {

                $aryData = $aryData[0];

                // Eliminar la imagen

                if (!empty($aryData['sImagen']) && strlen($aryData['sImagen']) > 0) {

                    fncEliminarArchivo(ROOTPATHRESOURCE . "/images/multi/" . $aryData['sImagen']);
                }
            }



            $this->productos->fncEliminarProducto($nIdRegistro);

            $this->json(array("success" => 'Producto eliminado exitosamente.'));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncGrabarProductoListaPrecio()

    {

        try {

            $nIdRegistro   = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $nIdProducto   = isset($_POST['nIdProducto']) ? $_POST['nIdProducto'] : null;

            $nIdTipo       = isset($_POST['nIdTipo']) ? $_POST['nIdTipo'] : null;

            $dFechaAlta    = isset($_POST['dFechaAlta']) ? $_POST['dFechaAlta'] : null;

            $dFechaFin     = isset($_POST['dFechaFin']) ? $_POST['dFechaFin'] : null;

            $nPrecio       = isset($_POST['nPrecio']) ? $_POST['nPrecio'] : null;

            $nIndefinido   = isset($_POST['nIndefinido']) ? $_POST['nIndefinido'] : null;

            $nEstado       = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;





            // Valida valores del formulario

            if (is_null($nIdRegistro)) {

                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }



            $nIdProductoListaPrecioNew = null;



            if ($nIndefinido == 1) {

                //Seteamos todos a 0

                $this->productos->fncActualizarIndefinidoByProducto($nIdProducto, $nIdTipo, 0);
            }



            // Crear

            if ($nIdRegistro == 0) {

                $nIdProductoListaPrecioNew = $this->productos->fncGrabarProductoListaPrecio(

                    $nIdProducto,

                    $nIdTipo,

                    $dFechaAlta,

                    $dFechaFin,

                    $nPrecio,

                    $nIndefinido,

                    $nEstado

                );
            } else {



                //Actualizar

                $this->productos->fncActualizarProductoListaPrecio(

                    $nIdRegistro,

                    $nIdProducto,

                    $nIdTipo,

                    $dFechaAlta,

                    $dFechaFin,

                    $nPrecio,

                    $nIndefinido,

                    $nEstado

                );
            }





            $this->fncActualizarPrecioVariable($nIdProducto, $nIdTipo);



            $sSuccess = $nIdRegistro == 0 ? 'Lista del precio registrado exitosamente...' : 'Lista del precio actualizado exitosamente...';



            $this->json(array("success" => $sSuccess, "nIdProductoListaPrecioNew" => $nIdProductoListaPrecioNew));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncMostrarProductoListaPrecio()

    {

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }



            $aryData = $this->productos->fncGetProductoListaPrecio(["nIdProductoListaPrecio" => $nIdRegistro]);



            $this->json(array("success" => true, "aryData" => fncValidateArray($aryData) ? $aryData[0] : null));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncEliminarProductoListaPrecio()

    {

        // Recibe valores del formulario

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }





            $this->productos->fncEliminarProductoListaPrecio($nIdRegistro);

            $this->json(array("success" => 'Item eliminado exitosamente.'));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncPopulateListaPrecio()

    {

        try {



            // Valida valores del formulario

            $nIdRegistro   = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $nIdTipo       = isset($_POST['nIdTipo']) ? $_POST['nIdTipo'] : null;



            // Valida valores del formulario

            if (is_null($nIdRegistro)) {

                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }



            $user = $this->session->get("user");



            $aryRows      = [];

            $aryProducto  = [];

            $aryProducto  = [];



            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlProductos);

            $aryProducto  = $this->productos->fncGetProductos(["nIdProducto" => $nIdRegistro]);



            if (fncValidateArray($aryProducto)) {

                $aryData  = $this->productos->fncGetProductoListaPrecio(["nIdProducto" => $nIdRegistro,  "nIdTipo" =>  $nIdTipo]);



                if (fncValidateArray($aryData)) {

                    foreach ($aryData as $nKey => $aryLoop) {

                        $sActionShow         = "fncMostrarListaPrecio(" . $aryLoop['nIdProductoListaPrecio'] . ",'ver');";

                        $sActionEdit         = "fncMostrarListaPrecio(" . $aryLoop['nIdProductoListaPrecio'] . ",'editar');";

                        $sActionEliminar     = "fncEliminarListaPrecio(" . $aryLoop['nIdProductoListaPrecio'] . " , " . $aryLoop["nIdTipo"] . ");";



                        $sLinkShow     = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';

                        $sLinkEdit     = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>' : '';

                        $sLinkDelete   = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>' : '';



                        $sAcciones = '<div class="content-acciones">

                                        ' . $sLinkShow . '

                                        ' . $sLinkEdit . '

                                        ' . $sLinkDelete . '

                                    </div>';



                        $aryRows[] = [

                            "sAcciones"    => $sAcciones,

                            "nOrden"       => sp($nKey + 1, 4),

                            "sProducto"    => $aryLoop["sProducto"],

                            "dFechaAlta"   => $aryLoop["dFechaAlta"],

                            "dFechaFin"    => $aryLoop["dFechaFin"],

                            "nPrecio"      => nf($aryLoop["nPrecio"]),

                            "sIndefinido"  => $aryLoop["nIndefinido"] == 1 ? 'SI' : 'NO',

                            "sEstado"      => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",

                        ];
                    }
                }
            }

            $this->json(array("success" => true, "aryData" => $aryRows, "aryProducto" => $aryProducto));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncObtenerProductos()

    {

        try {

            $user = $this->session->get('user');



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }



            // Valida valores del formulario

            $aryData  = $this->productos->fncGetProductos(["nIdSede" => $user["nIdSede"]]);

            $this->json(array("success" => true, "aryData" => $aryData));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncObtenerProductoVentas($sSearch = null, $nIdCategoria = null)

    {

        try {

            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }



            $nTipoProductoVenta         = $this->fncGetVarConfig("nTipoProductoVenta");

            $nTipoProductoCompraVenta   = $this->fncGetVarConfig("nTipoProductoCompraVenta");



            $aryResultado  = $this->productos->fncGetProductos([

                "nIdSede"   => $user["nIdSede"],

                "aryIdTipo" => [$nTipoProductoVenta, $nTipoProductoCompraVenta],

                "nEstado"   => 1,

                "sOrderBy"  => "prod.sDescripcion ASC",

                "sSearch"   => $sSearch,
                "nIdCategoria" => $nIdCategoria
            ]);



            $aryData = [];



            if (fncValidateArray($aryResultado)) {

                foreach ($aryResultado as $aryLoop) {



                    // Va a mostrar solo los productos que se vendan sin stcok o los productos que se vendan con stock y que tenga stock en almacen

                    if ($aryLoop["nVenderStock"] == 0 || ($aryLoop["nVenderStock"] == 1 && $aryLoop["nStockActual"] > 0)) {

                        $aryData[] = [

                            "nIdProducto"               => $aryLoop["nIdProducto"],

                            "sCodigoInterno"            => $aryLoop["sCodigoInterno"],

                            "sImagen"                   => $aryLoop["sImagen"],

                            "nStockActual"              => $aryLoop["nStockActual"],

                            "sDescripcion"              => strup($aryLoop["sDescripcion"]) . (strlen($aryLoop["sCodigoInterno"]) > 0 ? " - " . $aryLoop["sCodigoInterno"] : ""),

                            "sDescripcionText"          => $aryLoop["sDescripcion"],
                            
                            "nPrecio"                   => nf($aryLoop["nPrecioVenta"]),

                            "sUnidadMedidaCorto"        => strup($aryLoop["sUnidadMedidaCorto"]),

                            "sNombreUbicacionAlmacen"   => strup($aryLoop["sNombreUbicacionAlmacen"]),

                            "sDetalle"                  => strup($aryLoop["sDetalle"]),

                            "nIdUnidadMedida"           => $aryLoop["nIdUnidadMedida"]



                        ];
                    }
                }
            }



            return $aryData;
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncObtenerProductoCompras()

    {

        try {

            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception("Error. no existe el usuario para poder listar los registros .Porfavor verifique o solicite asistencia");
            }



            $nTipoProductoCompra        = $this->fncGetVarConfig("nTipoProductoCompra");

            $nTipoProductoCompraVenta   = $this->fncGetVarConfig("nTipoProductoCompraVenta");



            $aryResultado  = $this->productos->fncGetProductos([

                "nIdSede"   => $user["nIdSede"],

                "aryIdTipo" => [$nTipoProductoCompra, $nTipoProductoCompraVenta],

                "nEstado"   => 1

            ]);



            $aryData = [];



            if (fncValidateArray($aryResultado)) {

                foreach ($aryResultado as $aryLoop) {



                    // Va a mostrar solo los productos que se vendan sin stcok o los productos que se vendan con stock y que tenga stock en almacen

                    $aryData[] = [

                        "nIdProducto"        => $aryLoop["nIdProducto"],

                        "sImagen"            => $aryLoop["sImagen"],

                        "nIdUnidadMedida"    => $aryLoop["nIdUnidadMedida"],

                        "sUnidadMedida"      => $aryLoop["sUnidadMedida"],

                        "sUnidadMedidaCorto" => strup($aryLoop["sUnidadMedidaCorto"]),

                        "sDescripcion"       => strup($aryLoop["sDescripcion"]) . (strlen($aryLoop["sCodigoInterno"]) > 0 ? " - " . $aryLoop["sCodigoInterno"] : ""),

                        "nPrecio"            => nf($aryLoop["nPrecioCompra"]),

                    ];
                }
            }



            return $aryData;
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncActualizarPrecioVariable($nIdProducto, $nIdTipo)

    {

        try {

            $nTipoProductoVenta  = $this->fncGetVarConfig("nTipoProductoVenta");

            $nTipoProductoCompra = $this->fncGetVarConfig("nTipoProductoCompra");



            // Buscamos el indefinido

            $aryListaProductoIndefinido = $this->productos->fncGetProductoListaPrecio(["nIdProducto" => $nIdProducto, "nIdTipo" => $nIdTipo, "nIndefinido" => 1]);



            $nPrecio = fncValidateArray($aryListaProductoIndefinido) ? $aryListaProductoIndefinido[0]["nPrecio"] : 0;



            if ($nPrecio > 0) {



                // En caso encontremos actualizamos

                if ($nTipoProductoVenta  == $nIdTipo) {

                    $this->productos->fncActualizarPV($nIdProducto, $nPrecio);
                } elseif ($nTipoProductoCompra == $nIdTipo) {

                    $this->productos->fncActualizarPC($nIdProducto, $nPrecio);
                }
            } else {



                // En caso no encontramos buscamos en la lista de precios

                $aryDataPrecio  = $this->productos->fncGetPrecioListaPrecio($nIdProducto, $nIdTipo);

                $nPrecio        = fncValidateArray($aryDataPrecio) ? $aryDataPrecio[0]["nPrecio"] : 0;



                if ($nTipoProductoVenta == $nIdTipo) {

                    $this->productos->fncActualizarPV($nIdProducto, $nPrecio);
                } elseif ($nTipoProductoCompra == $nIdTipo) {

                    $this->productos->fncActualizarPC($nIdProducto, $nPrecio);
                }
            }
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }





    public function descompocision()

    {

        $this->authAdmin($this->session);



        $user = $this->session->get('user');



        try {



            $this->view('admin/descompocision', [

                'sTitulo'          => 'Mantenimientos Descompocision',

                'user'             => $user,

                'aryProductos'     => $this->productos->fncGetProductos(["nIdSede" => $user["nIdSede"]]),

                'aryUnidadMedida'  => $this->unidadMedidas->fncGetUnidadesMedidas(["nIdSede" => $user["nIdSede"]]),

                'aryProveedores'   => $this->proveedores->fncGetProveedores(["nIdEmpresa" => $user["nIdEmpresa"]]),

                'bShowMenu'        => true,

                "nAdmin"           => $this->fncIsAdmin($user["nIdRol"], $this->sUrlDescomp) ? 1 : 0

            ]);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncPopulateProductoDescomp()

    {

        try {





            $user = $this->session->get("user");



            $aryRows      = [];

            $bIsAdmin     = $this->fncIsAdmin($user["nIdRol"], $this->sUrlDescomp);

            $aryData      = $this->productos->fncGetProductosDescomp(["nIdSede" => $user["nIdSede"]]);



            if (fncValidateArray($aryData)) {

                foreach ($aryData as $nKey => $aryLoop) {

                    $sActionShow         = "fncMostrarPD(" . $aryLoop['nIdProductoDescomp'] . ",'ver');";

                    $sActionEdit         = "fncMostrarPD(" . $aryLoop['nIdProductoDescomp'] . ",'editar');";

                    $sActionEliminar     = "fncEliminarPD(" . $aryLoop['nIdProductoDescomp'] . ");";



                    $sLinkShow     = '<a onclick="' . $sActionShow . '" href="javascript:;"   title="Ver" class="text-primary"><i class="material-icons">remove_red_eye</i> </a>';

                    $sLinkEdit     = $bIsAdmin ? '<a onclick="' . $sActionEdit . '" href="javascript:;"   title="Editar" class="text-primary"><i class="material-icons">edit</i> </a>' : '';

                    $sLinkDelete   = $bIsAdmin ? '<a onclick="' . $sActionEliminar . '" href="javascript:;"  title="Eliminar" class="text-danger"><i class="material-icons">delete</i> </a>' : '';



                    $sAcciones = '<div class="content-acciones">

                                        ' . $sLinkShow . '

                                        ' . $sLinkEdit . '

                                        ' . $sLinkDelete . '

                                    </div>';



                    $aryRows[] = [

                        "sAcciones"    => $sAcciones,

                        "sNombre"      => $aryLoop["sNombre"],

                        "sEstado"      => $aryLoop["nEstado"] == 1 ? "ACTIVO" : "DESACTIVO",

                    ];
                }
            }



            $this->json($aryRows);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncGrabarProductosDescomp()

    {

        try {



            $nIdRegistro      = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;

            $sNombre          = isset($_POST['sNombre']) ? $_POST['sNombre'] : null;

            $aryDetalle       = isset($_POST['aryDetalle']) ? $_POST['aryDetalle'] : null;

            $nEstado          = isset($_POST['nEstado']) ? $_POST['nEstado'] : null;



            // Valida valores del formulario

            if (is_null($nIdRegistro)) {

                $this->exception('Error. Existen valores vacios. Por favor verifique.');
            }



            $user = $this->session->get("user");



            if (is_null($user)) {

                $this->exception('Error. No se encontro un usuario para poder realizar la operacion. Por favor verifique.');
            }



            $nIdProductoDescompNew = null;



            // Crear

            if ($nIdRegistro == 0) {





                $nIdProductoDescompNew = $this->productos->fncGrabarProductoDescomp(

                    $sNombre,

                    $nEstado

                );



                if (fncValidateArray($aryDetalle)) {

                    foreach ($aryDetalle as $nKey => $aryLoop) {

                        $this->productos->fncGrabarProductoDescompDet(

                            $nIdProductoDescompNew,

                            $aryLoop["nIdProductoPadre"],

                            $aryLoop["nIdUnidadMedidaPadre"],

                            $aryLoop["nIdProductoHijo"],

                            $aryLoop["nIdUnidadMedidaHijo"],

                            $aryLoop["nDescomp"]

                        );
                    }
                }
            } else {



                //Actualizar

                $this->productos->fncActualizarProductoDescomp(

                    $nIdRegistro,

                    $sNombre,

                    $nEstado

                );



                $this->productos->fncEliminarProdDesDetByIdProdDescp($nIdRegistro);



                if (fncValidateArray($aryDetalle)) {

                    foreach ($aryDetalle as $nKey => $aryLoop) {

                        $this->productos->fncGrabarProductoDescompDet(

                            $nIdRegistro,

                            $aryLoop["nIdProductoPadre"],

                            $aryLoop["nIdUnidadMedidaPadre"],

                            $aryLoop["nIdProductoHijo"],

                            $aryLoop["nIdUnidadMedidaHijo"],

                            $aryLoop["nDescomp"]

                        );
                    }
                }
            }



            $sSuccess =  $nIdRegistro == 0 ? 'Producto descompisicion registrado exitosamente...' : 'Producto descompisicion  actualizado exitosamente...';



            $this->json(array("success" => $sSuccess,  "nIdProductoDescompNew" => $nIdProductoDescompNew));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }



    public function fncMostrarProductoDescomp()

    {

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }



            $aryData    = $this->productos->fncGetProductosDescomp(["nIdProductoDescomp" => $nIdRegistro]);

            $aryDetalle = $this->productos->fncGetProductosDescompDet(["nIdProductoDescomp" => $nIdRegistro]);



            $this->json(array(

                "success"    => true,

                "aryData"    => fncValidateArray($aryData) ? $aryData[0] : null,

                "aryDetalle" => $aryDetalle

            ));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }





    public function fncEliminarProductoDescom()

    {

        // Recibe valores del formulario

        $nIdRegistro = isset($_POST['nIdRegistro']) ? $_POST['nIdRegistro'] : null;



        try {



            // Valida valores del formulario

            if ($nIdRegistro == null) {

                $this->exception('Error. El código de identificación del registro no es el correcto. Por favor verifique.');
            }





            $this->productos->fncEliminarProductosDescomp($nIdRegistro);

            $this->json(array("success" => 'Item eliminado exitosamente.'));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }


    public function fncObtenerProductoVentasAjax()
    {


        try {

            $sSearch = isset($_POST['sSearch']) ? $_POST['sSearch'] : null;
            $nIdCategoria = isset($_POST['nIdCategoria']) ? $_POST['nIdCategoria'] : null;

            $sSearch = str_replace(" ", "%", $sSearch);

            $aryData = $this->fncObtenerProductoVentas($sSearch, $nIdCategoria);

            $this->json(array("success" => 'Mostrando resultados obtenidos.', 'aryData' => $aryData));
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }
}
