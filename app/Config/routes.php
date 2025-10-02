<?php

// Home 
$router->any('api/dni/:id', 'ApisController@dni');
$router->any('api/ruc/:id', 'ApisController@ruc');




// Ubigeo 
$router->any('ubigeo/fncObtenerProvincias', 'UbigeoController@fncObtenerProvincias');
$router->any('ubigeo/fncObtenerDistrito', 'UbigeoController@fncObtenerDistrito');
// Fin de ubigeo


// Mantenimiento Lotes
$router->any('lotes/fncPopulate', 'LotesController@fncPopulate');
$router->any('lotes/fncGrabarLote', 'LotesController@fncGrabarLote');
$router->any('lotes/fncMostrarRegistro', 'LotesController@fncMostrarRegistro');
$router->any('lotes/fncEliminarRegistro', 'LotesController@fncEliminarRegistro');
$router->any('lotes/fncGetLotes', 'LotesController@fncGetLotes');
$router->any('lotes', 'LotesController@index');
// Fin del Lotes



// Mantenimiento Cajas
$router->any('cajas/fncPopulateReporteCajaIndividual', 'CajasController@fncPopulateReporteCajaIndividual');
$router->any('reporte-caja-individual', 'CajasController@reporteCajaIndividual');
$router->any('reporte-varias-cajas', 'CajasController@reporteVariasCajas');


$router->any('cajas/fncObtenerCajasDisponibles', 'CajasController@fncObtenerCajasDisponibles');
$router->any('cajas/fncCambiarEstadoCajaDiaria', 'CajasController@fncCambiarEstadoCajaDiaria');

$router->any('cajas/fncEliminarCajaDiaria', 'CajasController@fncEliminarCajaDiaria');
$router->any('cajas/fncPopulateCajaDiaria', 'CajasController@fncPopulateCajaDiaria');
$router->any('cajas/fncGrabarCajaDiaria', 'CajasController@fncGrabarCajaDiaria');
$router->any('cajas/fncMostrarCajaDiaria', 'CajasController@fncMostrarCajaDiaria');
$router->any('cajas/fncCerrarCajaDiaria', 'CajasController@fncCerrarCajaDiaria');
$router->any('caja-diaria', 'CajasController@cajaDiaria');



$router->any('cajas/fncPopulate', 'CajasController@fncPopulate');
$router->any('cajas/fncGrabarRegistro', 'CajasController@fncGrabarRegistro');
$router->any('cajas/fncMostrarRegistro', 'CajasController@fncMostrarRegistro');
$router->any('cajas/fncEliminarRegistro', 'CajasController@fncEliminarRegistro');
$router->any('cajas/fncGetCajas', 'CajasController@fncGetCajas');
$router->any('cajas', 'CajasController@index');
// Fin del Cajas


// Mantenimiento Ubicacion de almacen - UA
$router->any('ubicaciones/fncPopulate', 'UbicacionAlmacenController@fncPopulate');
$router->any('ubicaciones/fncGrabarUA', 'UbicacionAlmacenController@fncGrabarUA');
$router->any('ubicaciones/fncMostrarRegistro', 'UbicacionAlmacenController@fncMostrarRegistro');
$router->any('ubicaciones/fncEliminarRegistro', 'UbicacionAlmacenController@fncEliminarRegistro');
$router->any('ubicaciones/fncGetUA', 'UbicacionAlmacenController@fncGetUA');
$router->any('ubicaciones-almacen', 'UbicacionAlmacenController@index');
// Fin del ubicacion de almacen


// Mantenimiento Formulacion acumulacion puntos - FAP
$router->any('fap/fncPopulate', 'FormulacionAcumulacionPuntosController@fncPopulate');
$router->any('fap/fncGrabarFAP', 'FormulacionAcumulacionPuntosController@fncGrabarFAP');
$router->any('fap/fncMostrarRegistro', 'FormulacionAcumulacionPuntosController@fncMostrarRegistro');
$router->any('fap/fncEliminarRegistro', 'FormulacionAcumulacionPuntosController@fncEliminarRegistro');
$router->any('mantenimiento-formulacion-acumulacion-puntos', 'FormulacionAcumulacionPuntosController@index');
// Fin del Fap


// Mantenimiento Canje de puntos - CP
$router->any('canjepuntos/fncValidarPuntosCliente', 'CanjePuntosController@fncValidarPuntosCliente');
$router->any('canjepuntos/fncPopulate', 'CanjePuntosController@fncPopulate');
$router->any('canjepuntos/fncGrabarCP', 'CanjePuntosController@fncGrabarCP');
$router->any('canjepuntos/fncMostrarRegistro', 'CanjePuntosController@fncMostrarRegistro');
$router->any('canjepuntos/fncEliminarRegistro', 'CanjePuntosController@fncEliminarRegistro');
$router->any('canje-puntos', 'CanjePuntosController@index');
// Reportes 
$router->any('canjepuntos/fncPopulatePuntosAcumulados', 'CanjePuntosController@fncPopulatePuntosAcumulados');
$router->any('canjepuntos/fncPopulatePuntosCanjeados', 'CanjePuntosController@fncPopulatePuntosCanjeados');
$router->any('canjepuntos/fncPopulatePuntosMontarios', 'CanjePuntosController@fncPopulatePuntosMontarios');



$router->any('consulta-puntos-acumulados', 'CanjePuntosController@consultaPuntosAcumulados');
$router->any('consulta-puntos-canjeados', 'CanjePuntosController@consultaPuntosCanjeados');
$router->any('consulta-puntos-monetarios', 'CanjePuntosController@consultaPuntosMonetarios');



// Fin del cp




// Mantenimiento Pedidos
$router->any('pedidos/fncPopulateAnulaciones', 'PedidosController@fncPopulateAnulaciones');
$router->any('pedidos/fncCambiarEstado', 'PedidosController@fncCambiarEstado');
$router->any('pedidos/fncObtenerDataReporte', 'PedidosController@fncObtenerDataReporte');
$router->any('pedidos/fncPedidoPdf/:id', 'PedidosController@fncPedidoPdf');
$router->any('pedidos/fncExportarExcel', 'PedidosController@fncExportarExcel');
$router->any('pedidos/fncPopulate', 'PedidosController@fncPopulate');
$router->any('pedidos/fncGrabarPedido', 'PedidosController@fncGrabarPedido');
$router->any('pedidos/fncMostrarPedido', 'PedidosController@fncMostrarPedido');
$router->any('pedidos/fncEliminarPedido', 'PedidosController@fncEliminarPedido');
$router->any('pedidos/fncPopulateReporteMotorizado', 'PedidosController@fncPopulateReporteMotorizado');
$router->any('realizar-venta', 'PedidosController@realizarVenta');
$router->any('gestion-ventas', 'PedidosController@gestionVentas');
$router->any('reporte-gestion-de-ventas', 'PedidosController@reporteGestionVentas');
$router->any('reporte-cuadro-comparativo', 'PedidosController@reporteCuadroComparativo');
$router->any('anula-ventas', 'PedidosController@anulacionesVentas');
$router->any('reporte-ventas-usuarios', 'PedidosController@reporteVentasUsuario');
$router->any('comision-por-empleado', 'PedidosController@comisionPorEmpleado');
$router->any('comision-por-producto', 'PedidosController@comisionPorProducto');
$router->any('reporte-motorizado', 'PedidosController@reporteMotorizado');

$router->any('pedidos/fncPopulateReporteComision', 'PedidosController@fncPopulateReporteComision');
$router->any('pedidos/fncPopulateReporteComisionProducto', 'PedidosController@fncPopulateReporteComisionProducto');


$router->any('pedidos/fncObtenerReporteResponasbleResumen', 'PedidosController@fncObtenerReporteResponasbleResumen');
$router->any('pedidos/fncObtenerReporteResponasbleDetalle', 'PedidosController@fncObtenerReporteResponasbleDetalle');

// Pagos Parciales 

$router->any('pedidos/fncMostrarPedidoCuota', 'PedidosController@fncMostrarPedidoCuota');
$router->any('pedidos/fncGrabarCuotasPedido', 'PedidosController@fncGrabarCuotasPedido');
$router->any('pedidos/fncPopulatePagosParciales', 'PedidosController@fncPopulatePagosParciales');
$router->any('pagos-parciales', 'PedidosController@PagosParciales');


// Fin del Pedidos




// Mantenimiento oc

$router->any('ordenCompra/fncPopulateMovientosComprasGastos', 'OrdenCompraController@fncPopulateMovientosComprasGastos');

$router->any('ordenCompra/fncExportarExcel', 'OrdenCompraController@fncExportarExcel');
$router->any('ordenCompra/fncObtenerDataReporte', 'OrdenCompraController@fncObtenerDataReporte');
$router->any('ordenCompra/fncOcPdf/:id', 'OrdenCompraController@fncOcPdf');
$router->any('ordenCompra/fncImprimirOrdenAndGasto/:id/:id', 'OrdenCompraController@fncImprimirOrdenAndGasto');
$router->any('ordenCompra/fncPopulate', 'OrdenCompraController@fncPopulate');
$router->any('ordenCompra/fncGrabarOrdenCompra', 'OrdenCompraController@fncGrabarOrdenCompra');
$router->any('ordenCompra/fncMostrarOrdenCompra', 'OrdenCompraController@fncMostrarOrdenCompra');
$router->any('ordenCompra/fncEliminarOrdenCompra', 'OrdenCompraController@fncEliminarOrdenCompra');
$router->any('ordenCompra/fncObtenerOC', 'OrdenCompraController@fncObtenerOC');
$router->any('ordenCompra/fncCambiarEstadoEjecutado', 'OrdenCompraController@fncCambiarEstadoEjecutado');
$router->any('orden-compra', 'OrdenCompraController@ordenCompra');
$router->any('print-oc-gastos', 'OrdenCompraController@printOrdenCompraGasto');



$router->any('reporte-gestion-de-compras', 'OrdenCompraController@reporteGestionCompras');
$router->any('gastos', 'OrdenCompraController@gastos');
$router->any('reporte-gastos', 'OrdenCompraController@reporteGastos');
$router->any('movimientos-compras', 'OrdenCompraController@movimientosCompras');
$router->any('movimientos-gastos', 'OrdenCompraController@movimientosGastos');


// Fin del OC




// Mantenimiento Productos

// lista Precios
$router->any('productos/fncPopulateListaPrecio', 'ProductosController@fncPopulateListaPrecio');
$router->any('productos/fncGrabarProductoListaPrecio', 'ProductosController@fncGrabarProductoListaPrecio');
$router->any('productos/fncMostrarProductoListaPrecio', 'ProductosController@fncMostrarProductoListaPrecio');
$router->any('productos/fncEliminarProductoListaPrecio', 'ProductosController@fncEliminarProductoListaPrecio');
// Fin de lista Precios


$router->any('productos/fncObtenerProductos', 'ProductosController@fncObtenerProductos');
$router->any('productos/fncPopulate', 'ProductosController@fncPopulate');
$router->any('productos/fncGrabarProducto', 'ProductosController@fncGrabarProducto');
$router->any('productos/fncMostrarProducto', 'ProductosController@fncMostrarProducto');
$router->any('productos/fncEliminarProducto', 'ProductosController@fncEliminarProducto');
$router->any('productos', 'ProductosController@index');
$router->any('consulta-stock', 'ProductosController@consultaStock');
$router->any('productos/fncPopulateConsultaStock', 'ProductosController@fncPopulateConsultaStock');
$router->any('productos/fncObtenerProductoVentasAjax', 'ProductosController@fncObtenerProductoVentasAjax');

// lista Descomp
$router->any('productos/fncPopulateProductoDescomp', 'ProductosController@fncPopulateProductoDescomp');
$router->any('productos/fncGrabarProductosDescomp', 'ProductosController@fncGrabarProductosDescomp');
$router->any('productos/fncMostrarProductoDescomp', 'ProductosController@fncMostrarProductoDescomp');
$router->any('productos/fncEliminarProductoDescom', 'ProductosController@fncEliminarProductoDescom');
$router->any('descompocision', 'ProductosController@descompocision');
// lista Descomp

// Fin del Productos


// Mantenimiento Categorias
$router->any('categorias/fncPopulate', 'CategoriasController@fncPopulate');
$router->any('categorias/fncGrabarCategoria', 'CategoriasController@fncGrabarCategoria');
$router->any('categorias/fncMostrarCategoria', 'CategoriasController@fncMostrarCategoria');
$router->any('categorias/fncEliminarCategoria', 'CategoriasController@fncEliminarCategoria');
$router->any('categorias/fncGetCategoria', 'CategoriasController@fncGetCategoria');
$router->any('categorias/fncObtenerArbolCategorias', 'CategoriasController@fncObtenerArbolCategorias');
$router->any('categorias', 'CategoriasController@index');
// Fin del Categorias



// Mantenimiento Cliente
$router->any('clientes/fncPopulate', 'ClientesController@fncPopulate');
$router->any('clientes/fncGrabarCliente', 'ClientesController@fncGrabarCliente');
$router->any('clientes/fncMostrarRegistro', 'ClientesController@fncMostrarRegistro');
$router->any('clientes/fncEliminarRegistro', 'ClientesController@fncEliminarRegistro');
$router->any('clientes/fncGetClientes', 'ClientesController@fncGetClientes');
$router->any('clientes', 'ClientesController@index');
$router->any('ncliente/:id', 'ClientesController@nuevoCliente');

// Fin del cliente


// Mantenimiento Roles
$router->any('roles/fncGrabarRol', 'RolesController@fncGrabarRol');
$router->any('roles/fncMostrarRol', 'RolesController@fncMostrarRol');
$router->any('roles/fncEliminarRol', 'RolesController@fncEliminarRol');
$router->any('roles/fncPopulate', 'RolesController@fncPopulate');
$router->any('roles/fncGetRoles', 'RolesController@fncGetRoles');
$router->any('roles', 'RolesController@index');
// Fin del roles

// Mantenimiento Usuario
$router->any('usuarios/fncGrabarUsuario', 'UsuariosController@fncGrabarUsuario');
$router->any('usuarios/fncMostrarUsuario', 'UsuariosController@fncMostrarUsuario');
$router->any('usuarios/fncEliminarUsuario', 'UsuariosController@fncEliminarUsuario');
$router->any('usuarios/fncPopulate', 'UsuariosController@fncPopulate');
$router->any('usuarios/fncAddSedeForUsuario/:any', 'UsuariosController@fncAddSedeByUsuario');
$router->any('usuarios/fncRecuperarClave', 'UsuariosController@fncRecuperarClave');
$router->any('cuentas', 'UsuariosController@index');
// Fin del usuario


// Mantenimiento Empleados
$router->any('empleados/fncGrabarEmpleado', 'EmpleadosController@fncGrabarEmpleado');
$router->any('empleados/fncMostrarRegistro', 'EmpleadosController@fncMostrarRegistro');
$router->any('empleados/fncEliminarRegistro', 'EmpleadosController@fncEliminarRegistro');
$router->any('empleados/fncPopulate', 'EmpleadosController@fncPopulate');
$router->any('empleados', 'EmpleadosController@index');
// Fin del empleados



// Mantenimiento Catalogo Tabla
$router->any('catalogoTabla/populate', 'CatalogoTablaController@fncPopulate');
$router->any('catalogoTabla/fncGrabaCatalogo', 'CatalogoTablaController@fncGrabaCatalogo');
$router->any('catalogoTabla/fncGrabaCatalogoItem', 'CatalogoTablaController@fncGrabaCatalogoItem');
$router->any('catalogoTabla/fncMostrarRegistro', 'CatalogoTablaController@fncMostrarRegistro');
$router->any('catalogoTabla/fncListadoItemsPadre', 'CatalogoTablaController@fncListadoItemsPadre');
$router->any('catalogoTabla/fncCambiarEstado', 'CatalogoTablaController@fncCambiarEstado');
$router->any('catalogoTabla/fncEliminarRegistro', 'CatalogoTablaController@fncEliminarRegistro');
$router->any('catalogoTabla/fncPopulateConfig', 'CatalogoTablaController@fncPopulateConfig');
$router->any('catalogoTabla/fncListado', 'CatalogoTablaController@fncListado');


$router->any('catalogo-tablas', 'CatalogoTablaController@index');
// Fin del Mantenimiento

// Mantenimiento Empresas Tabla
$router->any('empresas/fncGetEmpresas', 'EmpresasController@fncGetEmpresas');
$router->any('empresas/fncPopulate', 'EmpresasController@fncPopulate');
$router->any('empresas/fncGrabarEmpresa', 'EmpresasController@fncGrabarEmpresa');
$router->any('empresas/fncMostrarRegistro', 'EmpresasController@fncMostrarRegistro');
$router->any('empresas/fncEliminarRegistro', 'EmpresasController@fncEliminarRegistro');
$router->any('empresas', 'EmpresasController@index');
// Fin de Empresas


// Mantenimiento Sedes Tabla
$router->any('sedes/fncGetSedes', 'SedesController@fncGetSedes');
$router->any('sedes/fncPopulate', 'SedesController@fncPopulate');
$router->any('sedes/fncGrabarSede', 'SedesController@fncGrabarSede');
$router->any('sedes/fncMostrarRegistro', 'SedesController@fncMostrarRegistro');
$router->any('sedes/fncEliminarRegistro', 'SedesController@fncEliminarRegistro');
$router->any('sedes', 'SedesController@index');
$router->any('mi-sede', 'SedesController@miSede');
// Fin de Empresas

// Configuracion
$router->any('configuracion', 'ConfiguracionController@index');
// Configuracion

// Mantenimiento Metodos de pago
$router->any('metodosPago/fncGrabarMetodoPago', 'MetodoPagoController@fncGrabarMetodoPago');
$router->any('metodosPago/fncMostrarRegistro', 'MetodoPagoController@fncMostrarRegistro');
$router->any('metodosPago/fncEliminarRegistro', 'MetodoPagoController@fncEliminarRegistro');
$router->any('metodosPago/fncGrabarSedeMetodoPago', 'MetodoPagoController@fncGrabarSedeMetodoPago');
$router->any('metodosPago/fncMostrarSedeMetodoPago', 'MetodoPagoController@fncMostrarSedeMetodoPago');
$router->any('metodosPago/fncEliminarSedeMetodoPago', 'MetodoPagoController@fncEliminarSedeMetodoPago');
$router->any('metodosPago/fncPopulateSedeMetodoPago', 'MetodoPagoController@fncPopulateSedeMetodoPago');


// Fin de Metodos de pago


// Mantenimiento Metodos de envio
$router->any('metodosEnvio/fncGrabarMetodoEnvio', 'MetodoEnvioController@fncGrabarMetodoEnvio');
$router->any('metodosEnvio/fncMostrarRegistro', 'MetodoEnvioController@fncMostrarRegistro');
$router->any('metodosEnvio/fncEliminarRegistro', 'MetodoEnvioController@fncEliminarRegistro');
$router->any('metodosEnvio/fncGrabarSedeMetodoEnvio', 'MetodoEnvioController@fncGrabarSedeMetodoEnvio');
$router->any('metodosEnvio/fncMostrarSedeMetodoEnvio', 'MetodoEnvioController@fncMostrarSedeMetodoEnvio');
$router->any('metodosEnvio/fncEliminarSedeMetodoEnvio', 'MetodoEnvioController@fncEliminarSedeMetodoEnvio');
$router->any('metodosEnvio/fncPopulateSedeMetodoEnvio', 'MetodoEnvioController@fncPopulateSedeMetodoEnvio');
// Fin de Metodo envio

// Mantenimiento Unidades de medidas
$router->any('unidadesMedida/fncPopulate', 'UnidadMedidasController@fncPopulate');
$router->any('unidadesMedida/fncGrabarUnidadMedida', 'UnidadMedidasController@fncGrabarUnidadMedida');
$router->any('unidadesMedida/fncMostrarRegistro', 'UnidadMedidasController@fncMostrarRegistro');
$router->any('unidadesMedida/fncEliminarRegistro', 'UnidadMedidasController@fncEliminarRegistro');
$router->any('unidadesMedida/fncGetUnidadesMedida', 'UnidadMedidasController@fncGetUnidadesMedida');
$router->any('unidadesMedida/fncImportarUnidadesMedidasPorDefault', 'UnidadMedidasController@fncImportarUnidadesMedidasPorDefault');
// Fin de Unidades de medidad


// Mantenimiento Documentos

$router->any('documentos/fncAnularDocumentoPedido', 'DocumentosController@fncAnularDocumentoPedido');
$router->any('documentos/fncPopulate', 'DocumentosController@fncPopulate');
$router->any('documentos/fncGrabarDocumento', 'DocumentosController@fncGrabarDocumento');
$router->any('documentos/fncMostrarRegistro', 'DocumentosController@fncMostrarRegistro');
$router->any('documentos/fncEliminarRegistro', 'DocumentosController@fncEliminarRegistro');
$router->any('documentos/fncAnularDocumentoSunat', 'DocumentosController@fncAnularDocumentoSunat');
$router->any('documentos/fncEnviarXMLCPE', 'DocumentosController@fncEnviarXMLCPE');
$router->any('documentos/fncEnviarMultipleXMLCPE', 'DocumentosController@fncEnviarMultipleXMLCPE');
$router->any('documentos/fncEnviarComprobanteCustom', 'DocumentosController@fncEnviarComprobanteCustom');
$router->any('documentos-electronicos', 'DocumentosController@documentos');

// Fin del Documentos





// Mantenimiento proveedores
$router->any('proveedores/fncPopulate', 'ProveedoresController@fncPopulate');
$router->any('proveedores/fncGrabarProveedor', 'ProveedoresController@fncGrabarProveedor');
$router->any('proveedores/fncMostrarRegistro', 'ProveedoresController@fncMostrarRegistro');
$router->any('proveedores/fncEliminarRegistro', 'ProveedoresController@fncEliminarRegistro');
$router->any('proveedores/fncGetProveedores', 'ProveedoresController@fncGetProveedores');
$router->any('proveedores', 'ProveedoresController@index');
// Fin del proveedores




// Mantenimiento Movimientos



$router->any('movimientos/fncPopulateEquivalencias', 'MovimientosController@fncPopulateEquivalencias');
$router->any('movimientos/fncProcesarEquivalencia', 'MovimientosController@fncProcesarEquivalencia');
$router->any('movimientos/fncEliminarEquivalencia', 'MovimientosController@fncEliminarEquivalencia');
$router->any('movimientos/fncMostrarEquivalencia', 'MovimientosController@fncMostrarEquivalencia');





$router->any('movimientos/fncMovimientoPdf/:id', 'MovimientosController@fncMovimientoPdf');
$router->any('movimientos/fncPopulate', 'MovimientosController@fncPopulate');
$router->any('movimientos/fncGrabarMovimiento', 'MovimientosController@fncGrabarMovimiento');
$router->any('movimientos/fncGrabarMovimientoSalida', 'MovimientosController@fncGrabarMovimientoSalida');
$router->any('movimientos/fncMostrarRegistro', 'MovimientosController@fncMostrarRegistro');
$router->any('movimientos/fncEliminarRegistro', 'MovimientosController@fncEliminarRegistro');
$router->any('nota-ingreso', 'MovimientosController@notaIngreso');
$router->any('nota-salida', 'MovimientosController@notaSalida');
$router->any('equivalencia', 'MovimientosController@equivalencia');

// Reportes

// Populate Reporte 

$router->any('movimientos/fncPopulateReporteEntrada', 'MovimientosController@fncPopulateReporteEntrada');
$router->any('movimientos/fncPopulateReporteSalida', 'MovimientosController@fncPopulateReporteSalida');
$router->any('movimientos/fncPopulateReporteMovimientos', 'MovimientosController@fncPopulateReporteMovimientos');
$router->any('movimientos/fncPopulateReporteMovimientosDetallado', 'MovimientosController@fncPopulateReporteMovimientosDetallado');



$router->any('reporte-movimiento-ingreso', 'MovimientosController@reporteMovimientoIngreso');
$router->any('reporte-movimiento-salida', 'MovimientosController@reporteMovimientoSalida');
$router->any('reporte-movimientos', 'MovimientosController@reporteMovimientos');
$router->any('reporte-movimientos-detallado', 'MovimientosController@reporteMovimientosDetallado');



// Fin del Movimientos

// Mantenimiento Serie Numeros
$router->any('serieNumeros/fncPopulate', 'SerieNumerosController@fncPopulate');
$router->any('serieNumeros/fncGrabarSerieNumero', 'SerieNumerosController@fncGrabarSerieNumero');
$router->any('serieNumeros/fncMostrarRegistro', 'SerieNumerosController@fncMostrarRegistro');
$router->any('serieNumeros/fncEliminarRegistro', 'SerieNumerosController@fncEliminarRegistro');
// Fin de Serie Numeros

// Mantenimiento Dashboard

$router->any('dashboard/fncPopulateDashboard', 'DashboardController@fncPopulateDashboard');
$router->any('dashboard', 'DashboardController@dashboard');

// Fin de Dashboard


// Mantenimiento Formulacion

$router->any('formulacion', 'FormulacionController@index');

// Fin de Formulacion


$router->any('accesoAjax', 'LoginAdminController@accesoAjax');
$router->any('acceso', 'LoginAdminController@acceso');
$router->any('salir', 'LoginAdminController@salir');
$router->any('/', 'LoginAdminController@acceso');


// Bancos 
$router->any('bancos/fncPopulate', 'BancosController@fncPopulate');
$router->any('bancos/fncGrabarBanco', 'BancosController@fncGrabarBanco');
$router->any('bancos/fncMostrarRegistro', 'BancosController@fncMostrarRegistro');
$router->any('bancos/fncEliminarRegistro', 'BancosController@fncEliminarRegistro');
$router->any('bancos/fncGetBancos', 'BancosController@fncGetBancos');
$router->any('bancos', 'BancosController@index');

// Tipos cuentas 
$router->any('tiposcuentas/fncPopulate', 'TiposCuentasController@fncPopulate');
$router->any('tiposcuentas/fncGrabarTipoCuenta', 'TiposCuentasController@fncGrabarTipoCuenta');
$router->any('tiposcuentas/fncMostrarRegistro', 'TiposCuentasController@fncMostrarRegistro');
$router->any('tiposcuentas/fncEliminarRegistro', 'TiposCuentasController@fncEliminarRegistro');
$router->any('tiposcuentas/fncGetTipoCuentas', 'TiposCuentasController@fncGetTipoCuentas');
$router->any('tipos-cuentas', 'TiposCuentasController@index');

// Cuentas corrientes 
$router->any('cuentascorrientes/fncPopulate', 'CuentasCorrientesController@fncPopulate');
$router->any('cuentascorrientes/fncGrabarCC', 'CuentasCorrientesController@fncGrabarCC');
$router->any('cuentascorrientes/fncMostrarRegistro', 'CuentasCorrientesController@fncMostrarRegistro');
$router->any('cuentascorrientes/fncEliminarRegistro', 'CuentasCorrientesController@fncEliminarRegistro');
$router->any('cuentascorrientes/fncGetCuentasCorrientes', 'CuentasCorrientesController@fncGetCuentasCorrientes');
$router->any('cuentas-corrientes', 'CuentasCorrientesController@index');

// Cuentas corrientes - Metodos de pago 
$router->any('cuentascorrientes/fncPopulateCCMP', 'CuentasCorrientesController@fncPopulateCCMP');
$router->any('cuentascorrientes/fncGrabarCCMP', 'CuentasCorrientesController@fncGrabarCCMP');
$router->any('cuentascorrientes/fncMostrarCCMP', 'CuentasCorrientesController@fncMostrarCCMP');
$router->any('cuentascorrientes/fncEliminarCMMP', 'CuentasCorrientesController@fncEliminarCMMP');
$router->any('cuentascorrientes/fncGetCMMP', 'CuentasCorrientesController@fncGetCMMP');
$router->any('mpago-ccorriente', 'CuentasCorrientesController@mPagoCCorriente');

// Movimientos tesoreria
$router->any('movimientosTesoreria/fncPopulate', 'MovimientosTesoreriaController@fncPopulate');
$router->any('movimientosTesoreria/fncGrabarMT', 'MovimientosTesoreriaController@fncGrabarMT');
$router->any('movimientosTesoreria/fncMostrarRegistro', 'MovimientosTesoreriaController@fncMostrarRegistro');
$router->any('movimientosTesoreria/fncEliminarRegistro', 'MovimientosTesoreriaController@fncEliminarRegistro');
$router->any('movimientos-lb', 'MovimientosTesoreriaController@movimientosLB');

// Documentos Pagos
$router->any('documentosPagos/fncPopulate', 'DocumentosPagoController@fncPopulate');
$router->any('documentosPagos/fncGrabarDocumento', 'DocumentosPagoController@fncGrabarDocumento');
$router->any('documentosPagos/fncMostrarRegistro', 'DocumentosPagoController@fncMostrarRegistro');
$router->any('documentosPagos/fncEliminarRegistro', 'DocumentosPagoController@fncEliminarRegistro');
$router->any('documentosPagos/fncObtenerDocumentos', 'DocumentosPagoController@fncObtenerDocumentos');
$router->any('registro-documentos', 'DocumentosPagoController@registroDocumento');

// Pagos Proveedores
$router->any('pagosProveedores/fncPopulate', 'PagosProveedoresController@fncPopulate');
$router->any('pagosProveedores/fncGrabarPago', 'PagosProveedoresController@fncGrabarPago');
$router->any('pagosProveedores/fncMostrarRegistro', 'PagosProveedoresController@fncMostrarRegistro');
$router->any('pagosProveedores/fncEliminarRegistro', 'PagosProveedoresController@fncEliminarRegistro');
$router->any('pagosProveedores/fncPPPDF/:id', 'PagosProveedoresController@fncPPPDF');
$router->any('pago-proveedores', 'PagosProveedoresController@pagosProveedores');

// Mesas
$router->any('mesas/fncPopulate', 'MesasController@fncPopulate');
$router->any('mesas/fncGrabarRegistro', 'MesasController@fncGrabarRegistro');
$router->any('mesas/fncMostrarRegistro', 'MesasController@fncMostrarRegistro');
$router->any('mesas/fncEliminarRegistro', 'MesasController@fncEliminarRegistro');
$router->any('mesas', 'MesasController@mesas');

// Carta digital
$router->any('cartaDigital/fncPopulate', 'CartaDigitalController@fncPopulate');
$router->any('cartaDigital/fncGrabarRegistro', 'CartaDigitalController@fncGrabarRegistro');
$router->any('cartaDigital/fncMostrarRegistro', 'CartaDigitalController@fncMostrarRegistro');
$router->any('cartaDigital/fncEliminarRegistro', 'CartaDigitalController@fncEliminarRegistro');
$router->any('cartaDigital/fncGrabarPedido', 'CartaDigitalController@fncGrabarPedido');
$router->any('cartaDigital/fncMostrarPedido', 'CartaDigitalController@fncMostrarPedido');
$router->any('cartaDigital/fncEliminarPedido', 'CartaDigitalController@fncEliminarPedido');
$router->any('cartaDigital/fncPopulatePedido', 'CartaDigitalController@fncPopulatePedido');
$router->any('cartaDigital/fncGrabarExtra', 'CartaDigitalController@fncGrabarExtra');
$router->any('cartaDigital/fncMostrarExtra', 'CartaDigitalController@fncMostrarExtra');
$router->any('cartaDigital/fncEliminarExtra', 'CartaDigitalController@fncEliminarExtra');
$router->any('cartaDigital/fncPopulateExtra', 'CartaDigitalController@fncPopulateExtra');


$router->any('configuracion-carta', 'CartaDigitalController@configuracionCarta');
$router->any('carta-digital-pedidos', 'CartaDigitalController@cartaDigitalPedidos');
$router->any('carta-digital-extras', 'CartaDigitalController@extras');
$router->any('carta-digital', 'CartaDigitalController@cartaDigital');

// Cotizacion
$router->any('cotizacion/fncGrabarRegistro', 'CotizacionController@fncGrabarRegistro');
$router->any('cotizacion/fncMostrarRegistro', 'CotizacionController@fncMostrarRegistro');
$router->any('cotizacion/fncEliminarRegistro', 'CotizacionController@fncEliminarRegistro');
$router->any('cotizacion/fncPopulate', 'CotizacionController@fncPopulate');
$router->any('cotizacion/fncPDF/:id', 'CotizacionController@fncPDF');
$router->any('cotizacion', 'CotizacionController@cotizacion');

// Condicion comercial 
$router->any('condicioncomercial/fncGrabarRegistro', 'CondicionComercialController@fncGrabarRegistro');
$router->any('condicioncomercial/fncMostrarRegistro', 'CondicionComercialController@fncMostrarRegistro');
$router->any('condicioncomercial/fncEliminarRegistro', 'CondicionComercialController@fncEliminarRegistro');
$router->any('condicioncomercial/fncPopulate', 'CondicionComercialController@fncPopulate');
$router->any('condicioncomercial', 'CondicionComercialController@condicionComercial');


// Choferes 
$router->any('choferes/fncGrabarRegistro', 'ChoferController@fncGrabarRegistro');
$router->any('choferes/fncMostrarRegistro', 'ChoferController@fncMostrarRegistro');
$router->any('choferes/fncEliminarRegistro', 'ChoferController@fncEliminarRegistro');
$router->any('choferes/fncPopulate', 'ChoferController@fncPopulate');
$router->any('choferes', 'ChoferController@chofer');


// Vehiculos 
$router->any('vehiculos/fncGrabarRegistro', 'VehiculoController@fncGrabarRegistro');
$router->any('vehiculos/fncMostrarRegistro', 'VehiculoController@fncMostrarRegistro');
$router->any('vehiculos/fncEliminarRegistro', 'VehiculoController@fncEliminarRegistro');
$router->any('vehiculos/fncPopulate', 'VehiculoController@fncPopulate');
$router->any('vehiculos', 'VehiculoController@vehiculo');


// Vehiculos 
$router->any('guias/fncGrabarRegistro', 'GuiaController@fncGrabarRegistro');
$router->any('guias/fncMostrarRegistro', 'GuiaController@fncMostrarRegistro');
$router->any('guias/fncEliminarRegistro', 'GuiaController@fncEliminarRegistro');
$router->any('guias/fncPopulate', 'GuiaController@fncPopulate');
$router->any('guia', 'GuiaController@guia');


// Funciones 
$router->any('funciones/fncValidarSession', 'FuncionesController@fncValidarSession');
$router->any('funciones/fncObtenerMensajes', 'FuncionesController@fncObtenerMensajes');
$router->run();
