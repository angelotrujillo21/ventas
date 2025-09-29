<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin = "<?=$nAdmin?>"
      data-ntipomoneda= "<?=$arySede["nTipoMoneda"]?>"
      data-ntipoordencompra = <?=$nTipoOrdenCompra?>>

    <div class="page-loader">
        <div class="loader-dual-ring"></div>
    </div>

    <div class="container-fluid">

        <div class="row">

            <?php extend_view(['admin/common/aside'], $data) ?>

            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">

                <?php extend_view(['admin/common/navbar'], $data) ?>

                <div class="main-content-container container-fluid px-2">


                    <div class="container-fluid">
                        <div class="page-header row no-gutters py-4">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                                <div class="card card-small">
                                    <div class="card-body pt-1 pb-5">

                                        <!-- Fila Cabecera -->
                                        <div class="row my-2">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center p-2">

                                                    <div class="flex-center">
                                                        <h5><?= $sTitulo ?></h5>
                                                    </div>

                                                    <div class="ml-auto">
                                                        <button id="btnCrearOC" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div id="toolbar" class="btn-group row">
                                            <div class="col-md-12 sin-padding container-buttons-table">
                                                <button id="btnFilter" class="btn btn-gradient-primary-table" type="button" title="Filtrar">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>

                                         
                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('ordenCompra/fncPopulate?nTipo='.$nTipoOrdenCompra) ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-show-footer="true"  data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sCaja" data-sortable="true">Caja</th>
                                                            <th data-field="nIdOrdenCompraFormat" data-sortable="true">Cod.Orden Compra</th>
                                                            <th data-field="sResponsable" data-sortable="true">Empleado</th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha</th>
                                                            <th data-field="sDescripcion" data-sortable="true">Descripcion</th>
                                                            <th data-field="sDetalle" data-sortable="true">Detalle</th>
                                                            <th data-field="nTotal" data-sortable="true">Total</th>
                                                            <th data-field="sProcesado" data-sortable="true">Procesado</th>
                                                            <th data-field="sEjecutado" data-sortable="true" data-visible="true">Eject/Plan</th>
                                                            <th data-field="sEstado" data-sortable="true">Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
 

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <?php extend_view(['admin/common/descripcion-empresa'], $data) ?>
            </main>
        </div>
    </div>



    <!-- Modales -->

    <div class="modal fade modal-full-screen" id="formOC" tabindex="-1" role="dialog" aria-labelledby="formOCLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="formOCLabel">Nueva Orden de compra</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modal-body-scroll">

                    <div class="row">

                        <div class="col-12 col-md-4 border-right-add-prod">

                            <div class="row">

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="nIdCaja" class="col-form-label">Caja </label>
                                        <select type="text" name="nIdCaja" id="nIdCaja" class="form-control">
                                            <option value="0">Seleccionar</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="sDescripcionOC" class="col-form-label">Descripcion </label>
                                        <input type="text" name="sDescripcionOC" id="sDescripcionOC" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="dFechaOC" class="col-form-label">Fecha </label>
                                        <input type="text" value="<?= date("d/m/Y")?>" name="dFechaOC" id="dFechaOC" class="form-control datepicker">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 d-none">
                                    <div class="form-group">
                                        <label for="nProcesadoOC" class="col-form-label">Procesado </label>
                                        <select name="nProcesadoOC" id="nProcesadoOC" class="form-control">
                                            <option value="0">NO</option>
                                            <option value="1">SI</option>
                                        </select>
                                    </div>
                                </div>

                            
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="nEjecutadoOC" class="col-form-label">Ejct/Plan </label>
                                        <select name="nEjecutadoOC" id="nEjecutadoOC" class="form-control">
                                            <option value="0">Planificado</option>
                                            <option value="1">Ejecutado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="nEjecutadoOC" class="col-form-label">Proveedor </label>
                                        <select name="nIdProveedorCab" class="form-control" id="nIdProveedorCab">
                                            <option value="0">NINGUNO</option>
                                            <?php if (fncValidateArray($aryProveedores)) : ?>
                                                 <?php foreach ($aryProveedores as $aryLoop) : ?>
                                                    <option value="<?= $aryLoop["nIdProveedor"] ?>"><?= strup( $aryLoop["sNombreoRazonSocial"] ) ?> </option>
                                                 <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="nEstadoOC" class="col-form-label">Estado </label>
                                        <select name="nEstadoOC" id="nEstadoOC" class="form-control">
                                            <option value="1">ACTIVO</option>
                                            <option value="0">DESACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                         
                                <form class="col-12 w-100 row no-gutters" id="form-add-producto">

                                    <div class="col-12 text-left mb-2">
                                        <p class="mb-0 font-18">Agregar Producto</p>
                                    </div>

                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">Producto :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <select name="nIdProducto" class="form-control" id="nIdProducto">
                                                    <?php if (fncValidateArray($aryProductos)) : ?>
                                                         <?php foreach ($aryProductos as $aryProducto) : ?>
                                                                <option 
                                                                    data-nidunidadmedida="<?= $aryProducto["nIdUnidadMedida"] ?>"
                                                                    data-simagen="<?= $aryProducto["sImagen"] ?>" 
                                                                    data-nprecio="<?= $aryProducto["nPrecio"] ?>" 
                                                                    value="<?= $aryProducto["nIdProducto"] ?>">
                                                            
                                                                    <?= strup( $aryProducto["sDescripcion"] ) . " - ". $aryProducto["sUnidadMedidaCorto"] ?> 
                                                                
                                                                </option>
                                                         <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-6 mb-2 pr-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">U.Medida :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <select name="nIdUnidadMedida" class="form-control" id="nIdUnidadMedida">
                                                    <?php if (fncValidateArray($aryUnidadMedida)) : ?>
                                                         <?php foreach ($aryUnidadMedida as $aryLoop) : ?>
                                                            <option value="<?= $aryLoop["nIdUnidadMedida"] ?>"><?= strup( $aryLoop["sNombreLargo"] ) ?> </option>
                                                         <?php endforeach ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

 


                                    <div class="col-12 col-md-6 mb-2 pr-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">Precio :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <input type="number" class="form-control" id="nPrecio" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="0.00" autocomplete="off" name="nPrecio">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 bd-highlight">
                                                        <p class="m-0 font-16">Cantidad :</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2">
                                                <input type="number" class="form-control" id="nCantidad" min="0" max="9999999.999999"  lang="en" step="0.000001" value="1" autocomplete="off" name="nCantidad">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2 text-right">
                                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Agregar</button>
                                    </div>

                                </form>

                            </div>

                        </div>

                        <div class="col-12 col-md-8 my-2 px-2">

                            <div class="row no-gutters">

                                <div class="col-12 text-center mb-2">
                                    <h5>Detalles</h5>
                                </div>

                              
                                <div class="col-12">
                                     <div class="table-responsive">
                                         <table id="table-detalle" class="table">
                                             <thead>
                                                 <tr>
                                                     <th class="d-none">IdProducto</th>
                                                     <th>Acciones</th>
                                                     <th>Item</th>
                                                     <th>Producto</th>
                                                     <th>U.Medida</th>
                                                     <th>Precio</th>
                                                     <th>Cantidad</th>
                                                     <th>Total</th>
                                                 </tr>
                                             </thead>
                                             <tbody>

                                             </tbody>
                                             <tfoot>
                                                 <tr>
                                                     <td class="text-right" colspan="6">Subtotal</td>
                                                     <td class="subtotal">0.00</td>
                                                 </tr>
                                                 <tr>
                                                     <td class="text-right" colspan="6">Igv</td>
                                                     <td class="igv">0.00</td>
                                                 </tr>
                                                 <tr>
                                                     <td class="text-right" colspan="6">Total</td>
                                                     <td class="total">0.00</td>
                                                 </tr>
                                             </tfoot>
                                         </table>
                                     </div>
                                </div>
                                

                        
                            </div>
                            
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button id="btnGuardarOC" type="button" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
                </div>

            </div>
        </div>
    </div>


        
    <!-- Modal para Filtros -->
    <div class="modal fade" id="formFilter" tabindex="-1" role="dialog" aria-labelledby="formFilterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formFilterLabel">Filtros</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                    
                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdOrdenCompraFilter" class="col-form-label">Cod.Orden Compra:</label>
                                    <select class="form-control" name="nIdOrdenCompraFilter[]" id="nIdOrdenCompraFilter" multiple>
                                        <?php if(fncValidateArray($aryIdOC)): ?>
                                            <?php foreach($aryIdOC as $aryLoop):?>
                                                <option value="<?= $aryLoop ?>"><?= sp( $aryLoop ) ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdProductoFilter" class="col-form-label">Producto:</label>
                                    <select class="form-control" name="nIdProductoFilter[]" id="nIdProductoFilter" multiple>
                                        <?php if(fncValidateArray($aryProductos)): ?>
                                            <?php foreach($aryProductos as $aryProducto):?>
                                                <option value="<?= $aryProducto["nIdProducto"] ?>"><?= strup( $aryProducto["sDescripcion"] ) ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                          

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nProcesadoFilter" class="col-form-label">Procesados</label>
                                    <select class="form-control" name="nProcesadoFilter" id="nProcesadoFilter">
                                        <option value="">TODOS</option>
                                        <option value="1">PROCESADOS</option>
                                        <option value="0">SIN PROCESAR</option>
                                    </select>
                                </div>
                            </div>

                            
        
                            <div class="col-12 col-md-6">
                               <div class="form-group">
                                   <label for="nEjecutadoFilter" class="col-form-label">Ejecutado / Planificado </label>
                                   <select name="nEjecutadoFilter" id="nEjecutadoFilter" class="form-control">
                                        <option value="">TODOS</option>
                                        <option value="0">Planificado</option>
                                        <option value="1">Ejecutado</option>
                                   </select>
                               </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="dFechaInicio" class="col-form-label">Desde:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaInicio" autocomplete="off" name="dFechaInicio">
                                </div>
                            </div>

                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="dFechaFin" class="col-form-label">Hasta:</label>
                                    <input type="text" class="form-control datepicker" id="dFechaFin" autocomplete="off" name="dFechaFin">
                                </div>
                            </div>
                          

                        </div>
                                        

                    
                    </div>                       
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  
    <!-- Fin de modales -->




    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- Compras -->
<script>
    window.bFilterTable  = false;
    window.jsnDataFiltro = {};

    window.nColIdProducto = 0;
    window.nColUnidadMedida = 4;
    window.nColPrecio = 5;
    window.nColCantidad = 6;
    window.nColTotal = 7;

    $(function() {

        window.fncOcultarAside();

        $("#nIdProducto,#nIdUnidadMedida").select2({
            placeholder : "Seleccionar"
        });

        $("#nIdProveedor").select2();

        $("#nIdProducto,#nIdUnidadMedida").val("").trigger("change");
        
        fncValidarRol();

        $("#btnCrearOC").on('click', function() {
            fncOcultarAside();
            fncCleanOC();
            fncControles(false);
            $("#nProcesadoOC").val(0).trigger("change");
            $("#nIdProducto,#nIdUnidadMedida").val("").trigger("change");
            $("#formOC").find(".modal-title").html('Nueva orden de compra');
            $("#formOC").data("nIdRegistro",0);

            // Obtener las cajas disponibles de hoy
            var jsnData = {dFechaHoraApertura : moment().format("DD/MM/YYYY") , nEstado : 1 };
            fncDrawCajas("#nIdCaja" , jsnData);
            $("#nIdCaja").prop("disabled",false);

            $("#formOC").modal("show");
        }); 

        $("#nIdProducto").on("change",function(){

            var nIdProducto   = $(this).find("option:selected").val();

            if(nIdProducto == 0) {
                $("#nPrecio").val(0);
                $("#nIdUnidadMedida").val(0);
                return false;
            }

            var nPrecio          = $(this).find("option:selected").data("nprecio");
            var nIdUnidadMedida  = $(this).find("option:selected").data("nidunidadmedida");
 
            $("#nPrecio").val(nPrecio);
            $("#nIdUnidadMedida").val(nIdUnidadMedida).trigger("change");

        });

        $('#table').on('refresh.bs.table', function (params) {
            window.bFilterTable = false;
            window.jsnDataFiltro = {};
            fncClearFilter();
        });

        $("#form-add-producto").on('submit', function(event) {

            event.preventDefault();

            var nIdProducto     = $("#nIdProducto").find("option:selected").val();
            var sProducto       = $("#nIdProducto").find("option:selected").text().trim();
            var nIdUnidadMedida = $("#nIdUnidadMedida").find("option:selected").val();
            var sUnidadMedida   = $("#nIdUnidadMedida").find("option:selected").text().trim();

 
            var nCantidad   = $("#nCantidad").val();
            var nPrecio     = $("#nPrecio").val();


            if (nIdProducto == '0' || !nIdProducto ) {
                toastr.error('Error. Debe seleccionar una producto para la venta.');
                return false;
            } else if (nIdUnidadMedida == '0' || !nIdUnidadMedida ) {
                toastr.error('Error. Debe seleccionar una unidad de medida .');
                return false;
            } else if (nCantidad == '' || parseFloat(nCantidad) <= 0.00) {
                toastr.error('Error. Debe ingresar una cantidad.');
                return false;
            } else if (nPrecio == '' || parseFloat(nPrecio) <= 0.00) {
                toastr.error('Error. Debe ingresar un monto.');
                return false;
            }

            var jsnRow = {
                nIdProducto       : nIdProducto,
                sProducto         : sProducto,
                nCantidad         : parseFloat(nCantidad),
                nPrecio           : parseFloat(nPrecio),
                nIdUnidadMedida   : nIdUnidadMedida,
                sUnidadMedida     : sUnidadMedida,
                sTable            : "#table-detalle",
                nItem             : parseInt(($("#table-detalle").find("tbody").find("tr").length) + 1),
                nTotal            : (parseFloat(nCantidad) * parseFloat(nPrecio)).toFixed(2)
            };

            fncAgregarFila(jsnRow, "#table-detalle");
            
            fncCleanAll();
        });

        $("#btnGuardarOC").on("click", function() {

            var nIdRegistro          = $("#formOC").data("nIdRegistro"); 
            var nIdCaja              = $("#nIdCaja").val();
            var sDescripcion         = $("#sDescripcionOC").val();
            var nProcesado           = $("#nProcesadoOC").val();
            var nEstado              = $("#nEstadoOC").val();
            var dFechaOrdenCompra    = $("#dFechaOC").val(); 
            var nIdProveedor         = $("#nIdProveedorCab").val();
            var aryDetalle           = fncGetDataTableCatalogo("#table-detalle");
            var nEjecutado           = $("#nEjecutadoOC").find("option:selected").val();

            var nSubTotal            = $("#table-detalle").find("tfoot").find(".subtotal").html();
            var nIgv                 = $("#table-detalle").find("tfoot").find(".igv").html();
            var nTotal               = $("#table-detalle").find("tfoot").find(".total").html();


            if (aryDetalle.length == 0) {
                toastr.error('Error. Debe ingresar un producto por lo menos para generar una orden de compra.');
                return false;
            } else if(dFechaOrdenCompra == ''){
                toastr.error('Error. Debe ingresar una fecha para la orden de compra.');
                return false;
            }  else if(nIdCaja == '0'){
                toastr.error('Error. Error no ha seleccionado una caja para reaizar la orden de compra. Porfavor verifique o aperture una caja .');
                return false;
            }
            
            var jsnData = {
                nIdRegistro       : nIdRegistro,
                nIdCaja           : nIdCaja,
                sDescripcion      : sDescripcion,
                aryDetalle        : aryDetalle,
                nProcesado        : nProcesado,
                dFechaOrdenCompra : dFechaOrdenCompra,
                nIdProveedor      : nIdProveedor,
                nTipoMoneda       : $("body").data("ntipomoneda"),
                nTipo             : $("body").data("ntipoordencompra"),
                nEstado           : nEstado,
                nEjecutado        : nEjecutado,
                nSubTotal         : nSubTotal == '' ? 0 : nSubTotal,
                nIgv              : nIgv == '' ? 0 : nIgv,
                nTotal            : nTotal == '' ? 0 : nTotal,
            };

            // console.log(jsnData);
            // return;

            fncGrabarOrdenCompra(jsnData, (aryResponse) => {
                if (aryResponse.success) {

                    toastr.success(aryResponse.success);
                    $("#formOC").modal("hide");
                    fncCleanOC();
                    fncRefreshTable();
                
                } else {
                    toastr.error(aryResponse.error);
                }
            });


        });

    });


    window.fncCleanOC = function(){
        fncClearInputs($("#form-add-producto"));

        $("#dFechaOC").val(moment().format('DD/MM/YYYY'));
        $("#table-detalle").find("tbody").html("");
        $("#sDescripcionOC").val("");
        $("#nIdProducto,#nIdUnidadMedida").val("").trigger("change");
        setTimeout(() => {
            fncTotales(null, "#table-detalle", null);
        }, 500);
    }

    window.fncGetDataTableCatalogo = function(sTable) {
        
        var aryData = [];

        $(sTable).find("tbody").find("tr").each(function() {

            var nIdProducto      = $(this).find("td").eq(nColIdProducto).html();
            var nIdUnidadMedida  = $(this).find("td").eq(nColUnidadMedida).data("nidunidadmedida");
            var nIdProveedor     = 0;

            var nPrecio          = $(this).find("td").eq(nColPrecio).find(".precio").val();
            var nCantidad        = $(this).find("td").eq(nColCantidad).find(".cantidad").val();

            aryData.push({
                nIdProducto     : nIdProducto,
                nIdUnidadMedida : nIdUnidadMedida,
                nIdProveedor    : nIdProveedor,
                nPrecio         : nPrecio,
                nCantidad       : nCantidad
            });

        });

        return aryData;
    }

    window.fncAgregarFila = function(jsnRow, sHtmlTag) {

        if ($(sHtmlTag).find("tbody").find("tr").length > 0) {

            var bExist = false;

            $(sHtmlTag).find("tbody").find("tr").each(function() {

                var nIdProducto = $(this).find("td").eq(nColIdProducto).html();

                var nIdUnidadMedida  = $(this).find("td").eq(4).data("nidunidadmedida");
 
                var nPrecioItem   = parseFloat($(this).find("td").eq(nColPrecio).find(".precio").val());
                var nCantidadItem = parseFloat($(this).find("td").eq(nColCantidad).find(".cantidad").val());

                if (
                    jsnRow.nIdProducto == nIdProducto 
                    && nPrecioItem == jsnRow.nPrecio 
                    && nIdUnidadMedida == jsnRow.nIdUnidadMedida
                    ) {

                    bExist = true;

                    var nCantidadNew = nCantidadItem + jsnRow.nCantidad;
                    var nTotalNew    = nCantidadNew * nPrecioItem;

                    $(this).find("td").eq(nColCantidad).find(".cantidad").val(nCantidadNew);
                    $(this).find("td").eq(nColTotal).find("div").html(nTotalNew.toFixed(2));

                }
            });

            if (bExist === false) {
                $(sHtmlTag).find("tbody").append(fncDrawFilaProducto(jsnRow));
            }

        } else {

            $(sHtmlTag).find("tbody").append(fncDrawFilaProducto(jsnRow));

        }

        setTimeout(() => {
            fncTotales(null, "#table-detalle", null);
        }, 500);

    }

    window.fncEliminarItem = function(nIdProducto, sTable, element) {

        fncMsg(1, "¿Estas seguro de eliminar este item?" , 
        function(){

            $(element).parent().parent().parent().remove();

            setTimeout(() => {
                fncTotales(null, sTable, null);
            }, 500);
        
        });

    }

    window.fncDrawFilaProducto = function(jsnData) {
        var sHtml = ``;
        sHtml = `<tr> 
                    <td class="d-none">${jsnData.nIdProducto}</td>
                    <td><div><a href="javascript:;" class="text-danger font-18" onclick="fncEliminarItem(${jsnData.nIdProducto},'${jsnData.sTable}',this);" title="Eliminar"><i class="material-icons">delete</i></a></div></td>
                    <td><div>${jsnData.nItem}</div></td>
                    <td><div>${jsnData.sProducto}</div></td>
                    <td data-nidunidadmedida="${jsnData.nIdUnidadMedida}">${jsnData.sUnidadMedida}</td>
                    <td class="cont-number"><div><input onblur="fncTotales(${jsnData.nIdProducto},'${jsnData.sTable}',event);" onkeyup="fncTotales('${jsnData.sTable}',event);" type="number" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="${jsnData.nPrecio}" autocomplete="off" class="form-control font-12 precio"></div></td>
                    <td class="cont-number"><div><input onblur="fncTotales(${jsnData.nIdProducto},'${jsnData.sTable}',event);" onkeyup="fncTotales('${jsnData.sTable}',event);" type="number" value="${jsnData.nCantidad}" min="1" max="9999999" step="1" autocomplete="off" class="form-control font-12 cantidad"></div></td>
                    <td><div>${fncNf(jsnData.nTotal)}</div></td>
                </tr>`;
        return sHtml;
    }
 

    window.fncRefreshTable = function(){
        if(bFilterTable){
            $("#formFilter").trigger("submit");
        } else {
            $("#table").bootstrapTable('refresh');
        }
    }


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            //$("#btnCrearCompra").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarOC(nIdRegistro) {
       
        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarRegistro( jsnData , function(aryData){

                if(aryData.success){
                    fncRefreshTable();
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });


    }

    function fncMostrarOC(nIdRegistro,sAccion) {
        
        fncCleanAll();
        fncOcultarAside();
        $("#formOC").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarRegistro(jsnData, function(aryResponse){
            
                if (aryResponse.success) {
                    var aryData     = aryResponse.aryData;
                    var aryDetalle  = aryResponse.aryDetalle;


                    // Obtener las cajas disponibles de segun el dia que se creo y no se puede editar
                    var jsnData = {dFechaHoraApertura : aryData.dFechaCreacion};
                    fncDrawCajas("#nIdCaja" , jsnData , aryData.nIdCaja);
                    $("#nIdCaja").prop("disabled",true);

                    $("#sDescripcionOC").val(aryData.sDescripcion);
                    $("#nProcesadoOC").val(aryData.nProcesado);
                    $("#nEstadoOC").val(aryData.nEstado);
                    $("#dFechaOC").val(aryData.dFechaOrdenCompra);

                    
                    if (aryDetalle.length > 0) {

                        aryDetalle.forEach((aryItem, nIndex) => {

                     
                            var jsnRow = {
                                nIdProducto         : aryItem.nIdProducto,
                                sProducto           : aryItem.sProducto,
                                nIdUnidadMedida     : aryItem.nIdUnidadMedida,
                                sUnidadMedida       : aryItem.sUnidadMedida,
                                nCantidad           : parseFloat(aryItem.nCantidad),
                                nPrecio             : parseFloat(aryItem.nPrecio),
                                sTable              : "#table-detalle",
                                nItem               : parseInt((nIndex) + 1),
                                nTotal              : (parseFloat(aryItem.nCantidad) * parseFloat(aryItem.nPrecio)).toFixed(2)
                            };


                            fncAgregarFila(jsnRow, "#table-detalle");

                        });

                    }

                    if (sAccion == 'editar') {
                        $("#formOC").find(".modal-title").html("Editar Orden de compra");
                        fncControles(false);
                    } else {
                        $("#formOC").find(".modal-title").html("Ver Orden de compra");
                        fncControles(true);
                    }


                    $("#formOC").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });
    }

    function fncCambiarEstadoEJOC(nIdRegistro,nNuevoEstado) {

        var sMensaje = nNuevoEstado == 1 ? '¿Esta ud seguro de cambiar el estado de a Ejecutado' : '¿Esta ud seguro de cambiar el estado de a Planificado?';
 

        fncMsg(1, sMensaje , 
        function(){
            
            var jsnData = {nIdRegistro: nIdRegistro, nNuevoEstado: nNuevoEstado};    
            
            fncCambiarEstadoEjecutado(jsnData,(aryData)=>{
                if(aryData.success){
                    toastr.success(aryData.success);
                    fncRefreshTable();
                } else {
                    toastr.error(aryData.error);
                }
            });

        });

      
    }

    window.fncTotales = function(nIdProducto = null, sTable, event = null) {

        var nSubtotal       = 0;
        var nCantidadTotal  = 0;
        var nTotalIgv       = 0;
        var nTotal          = 0;

        if ($(sTable).find("tbody").find("tr").length > 0) {

            $(sTable).find("tbody").find("tr").each(function() {

                var nPrecioItem = $(this).find("td").eq(nColPrecio).find(".precio").val();
                var nCantidad   = $(this).find("td").eq(nColCantidad).find(".cantidad").val();
                var nTotalItem  = parseFloat(nPrecioItem) * parseFloat(nCantidad);

                $(this).find("td").eq(nColTotal).find("div").html(fncNf(nTotalItem));

                // if(event != null && event.type == "blur"){
                //     $(this).find("td").eq(4).find(".precio").val( fncNf(nPrecioItem) );
                // }

                nSubtotal      += nTotalItem;
                nCantidadTotal += parseInt(nCantidad);
            });

            nTotalIgv  = (nSubtotal * parseFloat(nIgv / 100));
            nSubtotal  = nSubtotal - nTotalIgv;
            nTotal     = nSubtotal + nTotalIgv;

            $(sTable).find(".subtotal").html(fncNf(nSubtotal));
            $(sTable).find(".igv").html(fncNf(nTotalIgv));
            $(sTable).find(".total").html(fncNf(nTotal));

        } else {
            $(sTable).find(".subtotal").html(fncNf(0));
            $(sTable).find(".igv").html(fncNf(0));
            $(sTable).find(".total").html(fncNf(0));
        }
    }

    
    window.fncDrawCajas = function(sHtmlTag , jsnData , nIdCaja = null){
        
        fncObtenerCajasDisponibles(jsnData,function(aryData){
            
            let sOptions = ``;
            
            if(aryData.success){
                
                sOptions += `<option value="0">SELECCIONAR</option>`;
                
                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.nIdCaja}">${aryElement.sCaja}</option>`;
                });
            
                $(sHtmlTag).html(sOptions);

                if(nIdCaja != null){
                    $(sHtmlTag).val(nIdCaja);
                }
            }

        });

    }


    window.fncControles = (bFlag) => {
        // bloquear
        if (bFlag) {
            
            $("#sDescripcionOC").attr("disabled", "disabled");
            $("#nProcesadoOC").attr("disabled", "disabled");
            $("#nEjecutadoOC").attr("disabled", "disabled");
            $("#nEstadoOC").attr("disabled", "disabled");
            $("#nIdProveedorCab").attr("disabled", "disabled");
            $("#dFechaOC").attr("disabled", "disabled");

            $("#form-add-producto").hide();
            $("#formOC").find(".modal-footer").hide();

        } else {

            $("#sDescripcionOC").removeAttr("disabled");
            $("#nProcesadoOC").removeAttr("disabled");
            $("#nEjecutadoOC").removeAttr("disabled");
            $("#nEstadoOC").removeAttr("disabled");
            $("#nIdProveedorCab").removeAttr("disabled");
            $("#dFechaOC").removeAttr("disabled");

            $("#form-add-producto").show();
            $("#formOC").find(".modal-footer").show();
        }
    }


    // Funciones Auxiliares
    window.fncCleanAll = () => {
        fncClearInputs($("#form-add-producto"));
        $("#nPrecio").val("0.00");
        $("#nIdProducto").val("").trigger("change");
        $("#nIdProveedor").val("0").trigger("change");
    }

    // Llamadas al servidor

    function fncGrabarOrdenCompra(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ordenCompra/fncGrabarOrdenCompra',
            data: formData,
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }

    function fncEjecutarEliminarRegistro(jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'ordenCompra/fncEliminarOrdenCompra',
            data: jsnData,
            dataType: 'json',
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function( data ) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }

        });
    }

    function fncBuscarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'ordenCompra/fncMostrarOrdenCompra',
            data: jsnData ,
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }
        });
    }

    function fncCambiarEstadoEjecutado(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'ordenCompra/fncCambiarEstadoEjecutado',
            data: jsnData ,
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }
        });
    }

    function fncObtenerCajasDisponibles(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'cajas/fncObtenerCajasDisponibles',
            data: jsnData ,
            beforeSend: function () {
                fncMostrarLoader();
            },
            success: function (data) {
                fncCallback(data);
            },
            complete: function () {
                fncOcultarLoader();
            }
        });
    }


</script>
<!-- Compras -->


<!-- Filtros -->
<script>
    $(function() {
        
 
        $("#nIdProductoFilter,#nIdOrdenCompraFilter").select2({
            placeholder:"TODOS"
        });

       
        // $("#btnExportarExcel").on('click', function() {
        //     fncExportarExcel(window.jsnDataFiltro,function(aryData){
        //         if(aryData.success){
        //             Object.assign(document.createElement('a'), { target: '_blank', href: aryData.sUrl }).click();
        //         } else {
        //             toastr.error(aryData.error);
        //         }
        //     });
        // });

        $("#formFilter").find("form").on('submit', function(event) {

            event.preventDefault();
            
            var aryProductos     = $("#nIdProductoFilter :selected").map(function(nIndex, item) { return $(item).val(); }).get();
            var aryIdsOC         = $("#nIdOrdenCompraFilter :selected").map(function(nIndex, item) { return $(item).val(); }).get();

            var dFechaInicio     = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin        = $('#dFechaFin').datepicker('getDate');
            var nProcesado       = $('#nProcesadoFilter').val();
            var nEjecutado       = $('#nEjecutadoFilter').val();

            

            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de alta y inicio. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }     

            window.jsnDataFiltro  = {
                aryProductos     : aryProductos,
                aryIdsOC         : aryIdsOC,
                dFechaInicio     : $('#dFechaInicio').val(),
                dFechaFin        : $('#dFechaFin').val(),
                nTipo            : $("body").data("ntipoordencompra"),
                nProcesado       : nProcesado,
                nEjecutado       : nEjecutado
            };

            fncFiltrarOC( window.jsnDataFiltro ,function(aryData){
              $('#table').bootstrapTable('load',aryData);
              bFilterTable = true;
              $("#formFilter").modal("hide");
            });    

        });


        $("#btnFilter").on("click",function(){
            $("#formFilter").modal("show");
        });

    });

    function fncClearFilter(){
        fncClearInputs($("#formFilter").find("form"));
        $("#nIdProductoFilter").val([]).trigger("change");
        $("#nIdOrdenCompraFilter").val([]).trigger("change");
        $('#nProcesadoFilter').val("");
     }

    // Llamadas al servidor
    function fncFiltrarOC(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ordenCompra/fncPopulate',
            data: formData,
            beforeSend: function() {
                fncMostrarLoader();
            },
            success: function(data) {
                fncCallback(data);
            },
            complete: function() {
                fncOcultarLoader();
            }
        });
    }
 
   

</script>
<!-- Filtros -->




</html>