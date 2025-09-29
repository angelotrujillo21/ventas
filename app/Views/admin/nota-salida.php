<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin="<?=$nAdmin?>" 
      data-ntipomoneda= "<?=$arySede["nTipoMoneda"]?>"
      data-nsalida ="<?=$nSalida?>"
>

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
                                                        <button id="btnCrearMov" class="btn btn-gradient-primary btn-rounded btn-icon">
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
                                                <table data-toggle="table" id="table" data-url="<?= route('movimientos/fncPopulate?nEntradaSalida='.$nSalida) ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="nIdMovimiento" data-sortable="true">Cod. Movimiento</th>
                                                            <th data-field="sResponsable" data-sortable="true">Empleado</th>
                                                            <th data-field="sDescripcion" data-sortable="true">Descripcion</th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha Creacion</th>
                                                            <th data-field="sDetalle" class="text-center" data-sortable="true">Detalle<br><span class="font-13">Producto | Precio | Cantidad</span></th>
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

    <div class="modal fade modal-full-screen" id="formMov" tabindex="-1" role="dialog" aria-labelledby="formMovLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="formMovLabel">Nuevo Nota de ingreso</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modal-body-scroll">

                    <div class="row">

                        <div class="col-12 col-md-4 border-right-add-prod">

                            <div class="row ">

                                <div class="col-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="sDescripcionMov" class="col-form-label">Descripcion  </label>
                                         <input type="text" name="sDescripcionMov" id="sDescripcionMov" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="dFechaMov" class="col-form-label">Fecha Ingreso  </label>
                                         <input type="text" name="dFechaMov"  value="<?= date("d/m/Y") ?>" id="dFechaMov" class="form-control datepicker">
                                    </div>
                                </div>

                                <!-- <div id="content-nTipoMovimiento" class="col-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="nTipoMovimiento" class="col-form-label">Tipo </label>
                                        <select class="form-control" name="nTipoMovimiento" id="nTipoMovimiento">
                                            <option value="0">SELECCIONAR</option>
                                            <?php if (fncValidateArray($aryTipoMovimiento)) : ?>
                                                <?php foreach ($aryTipoMovimiento as $aryLoop) : ?>
                                                    <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                  
                                </div>

                                <div id="content-nIdOrdenCompra" class="col-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="nIdOrdenCompra" class="col-form-label">Orden de Compra </label>
                                        <select class="form-control" name="nIdOrdenCompra" id="nIdOrdenCompra">
                                            <option value="0">NINGUNO</option>
                                        </select>
                                    </div>
                                </div>-->

                            
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
                                                             <option data-nequivalencia="<?= $aryProducto["nEquivalencia"]?>" data-simagen="<?= $aryProducto["sImagen"] ?>" data-nprecio="<?= nf($aryProducto["nPrecioCompra"]) ?>" value="<?= $aryProducto["nIdProducto"] ?>">
                                                               <?= strup( $aryProducto["sDescripcion"] ) . " - " . strup( $aryProducto["sUnidadMedidaCorto"] ) ?> 
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
                                                     <th>Imagen</th>
                                                     <th>Producto</th>
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
                    <button id="btnGuardarMov" type="button" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
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
                                   <label for="aryIdMovimiento" class="col-form-label">Cod.Movimiento</label>
                                   <select class="form-control" name="aryIdMovimiento" id="aryIdMovimiento" multiple>
                                       <option value="">TODOS</option>
                                       <?php if (fncValidateArray($aryIdFilter)) : ?>
                                           <?php foreach ($aryIdFilter as $aryLoop) : ?>
                                               <option value="<?= $aryLoop ?>"><?= sp($aryLoop) ?></option>
                                           <?php endforeach ?>
                                       <?php endif ?>
                                   </select>
                               </div>
                           </div>

                          
                           <div class="col-12 col-md-6">
                               <div class="form-group">
                                   <label for="aryProductos" class="col-form-label">Productos</label>
                                   <select class="form-control" name="aryProductos" id="aryProductos" multiple>
                                       <option value="">TODOS</option>
                                       <?php if (fncValidateArray($aryProductosFilter)) : ?>
                                           <?php foreach ($aryProductosFilter as $aryLoop) : ?>
                                               <option value="<?= $aryLoop["nIdProducto"] ?>"><?= strup($aryLoop["sDescripcion"])  ?></option>
                                           <?php endforeach ?>
                                       <?php endif ?>
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


<!-- Nota salida -->
<script>

    window.bFilterTable = false;
    window.nColPrecio   = 5;
    window.nColCantidad = 6;
    window.nColTotal    = 7;

    $(function() {

        fncOcultarAside();
        // $("#btn-toogle-desktop").trigger("click");

        fncValidarRol();

        $("#nIdProducto").select2({
            templateResult: function (elementProducto) {
                //console.log(elementProducto);
                var option  =  $(elementProducto.element)[0];
                if(typeof option !== "undefined"){
                    var sImagen = option.dataset.simagen;
                    var $span   = $(`<span>${sImagen.length>0 ? `<img width="20px" height="20px" src='${src('multi/'+sImagen)}'/>` : ``} ${elementProducto.text.trim()} </span>`);
                    return $span;
                }
              
            },
            templateSelection: function (elementProducto) {
                var option  = $(elementProducto.element)[0];
                var sImagen = option.dataset.simagen;
                var $span   = $(`<span>${sImagen.length>0 ? `<img width="20px" height="20px" src='${src('multi/'+sImagen)}'/>` : ``} ${elementProducto.text.trim()} </span>`);
                return $span;
            }
        });

 
        $("#btnCrearMov").on('click', function() {
            fncOcultarAside();
            fncCleanMov();
            fncControles(false);
            //$("#nTipoMovimiento").trigger("change");
            $("#formMov").find(".modal-title").html('Nueva nota de salida');
            $("#formMov").data("nIdRegistro", 0);
            $("#formMov").modal("show");
        });

        // Formulario Agregrar producto

        $("#form-add-producto").on('submit', function(event) {

            event.preventDefault();

            var nIdProducto   = $("#nIdProducto").find("option:selected").val();
            var sImagen       = $("#nIdProducto").find("option:selected").data("simagen");
            var nEquivalencia = $("#nIdProducto").find("option:selected").data("nequivalencia");

            var sProducto   = $("#nIdProducto").find("option:selected").text().trim().toUpperCase();
            var nCantidad   = $("#nCantidad").val();
            var nPrecio     = $("#nPrecio").val();


            if (nIdProducto == '0') {
                toastr.error('Error. Debe seleccionar una producto para la venta.');
                return false;
            } else if (nCantidad == '' || parseFloat(nCantidad) <= 0.00) {
                toastr.error('Error. Debe ingresar una cantidad.');
                return false;
            } else if (nPrecio == '' || parseFloat(nPrecio) <= 0.00) {
                toastr.error('Error. Debe ingresar un monto.');
                return false;
            }

            var jsnRow = {
                nIdProducto     : nIdProducto,
                sProducto       : sProducto,
                nCantidad       : parseFloat(nCantidad),
                nPrecio         : parseFloat(nPrecio),
                sImagen         : typeof sImagen !== "undefined" ? sImagen : "", 
                sTable          : "#table-detalle",
                nEquivalencia   : nEquivalencia,
                nConvertir      : 1,
                nItem           : parseInt(($("#table-detalle").find("tbody").find("tr").length) + 1),
                nTotal          : (parseFloat(nCantidad) * parseFloat(nPrecio)).toFixed(2)
            };

            fncAgregarFila(jsnRow, "#table-detalle");
            fncCleanAll();
        });


        $("#btnGuardarMov").on("click", function() {


            var nIdRegistro          = $("#formMov").data("nIdRegistro");
            var sDescripcion         = $("#sDescripcionMov").val();
            var dFechaMovimiento     = $("#dFechaMov").val();

            //var nIdOrdenCompra       = $("#nIdOrdenCompra").val();
            //var nTipoMovimiento      = $("#nTipoMovimiento").val();
            var nIdRegistro          = $("#formMov").data("nIdRegistro");
            var aryDataDetalle       = fncGetDataTableCatalogo("#table-detalle");
         

            // if(nTipoMovimiento == '0'){
            //     toastr.error('Error. Debe ingresar un tipo de movimiento para generar la nota. Porfavor verifique');
            //     return false;
            // } else 

            if (aryDataDetalle.length == 0) {
                toastr.error('Error. Debe ingresar un producto por lo menos para generar la nota de salida. Porfavor verifique');
                return false;
            } 

            var jsnData = {
                nIdRegistro       : nIdRegistro,
                sDescripcion      : sDescripcion,
              // nTipoMovimiento   : nTipoMovimiento,
              // nIdOrdenCompra    : nIdOrdenCompra ,
                aryDataDetalle    : aryDataDetalle,
                dFechaMovimiento  : dFechaMovimiento,
                nEntradaSalida    : $("body").data("nsalida"),
                nTipoMoneda       : $("body").data("ntipomoneda"),
                nEstado           : 1
            };

            // console.log(jsnData);
            // return;
            fncGrabarMovimientoSalida(jsnData, (aryResponse) => {
                if (aryResponse.success) {
                    fncCleanMov();
                    fncRefreshTable();
                    toastr.success(aryResponse.success);
                    $("#formMov").modal("hide");
                } else {
                    toastr.error(aryResponse.error);
                }
            });


        });


        $("#nIdProducto").on("change", function() {

            var nPrecio = $(this).find("option:selected").data("nprecio");
            $("#nPrecio").val(nPrecio);
            setTimeout(() => {
                $("#nCantidad").focus();
            }, 500);

        });

       
        $('#table').on('refresh.bs.table', function (params) {
            window.bFilterTable = false;
            fncClearFilterM();
        });

        
        // $("#nTipoMovimiento").on("change",function(){

        //     var sTipoMovimiento  = $(this).find("option:selected").text().trim();

        //     switch(sTipoMovimiento){
        //         case 'ING. COMPRAS' :
                    
        //             var jsnData = {
        //                 nProcesado : 0
        //             };

        //             fncDrawOC(jsnData,"#nIdOrdenCompra");
                    
        //             $("#content-nIdOrdenCompra").show();
        //         break;
                
        //         case 'ING. PRODUCCION':
        //         case 'ING.OTROS':
        //         default:
        //             $("#nIdOrdenCompra").html(`<option value="0">NINGUNO</option>`);
        //             $("#content-nIdOrdenCompra").hide();
        //         break;

        //     }
        // });

        // $("#nIdOrdenCompra").on("change",function(){
 
        //     var jsnData = {
        //         nIdRegistro: $(this).val()
        //     };

        //     $("#table-detalle").find("tbody").html("");
     
        //     fncBuscarOC(jsnData,(aryResponse) => {

        //         var aryData     = aryResponse.aryData;
        //         var aryDetalle  = aryResponse.aryDetalle;

        //         // $("#sDescripcionMov").val( ($("#sDescripcionMov").val().length > 0 ? ( $("#sDescripcionMov").val() + ' - ' ) : '' ) + aryData.sDescripcion );
                
        //         if (aryDetalle.length > 0) {

        //             aryDetalle.forEach((aryItem, nIndex) => {
                     
        //                 var jsnRow = {
        //                     nIdProducto   : aryItem.nIdProducto,
        //                     sProducto     : aryItem.sProducto,
        //                     sImagen       : aryItem.sImagenProducto, 
        //                     nCantidad     : parseFloat(aryItem.nCantidad),
        //                     nPrecio       : parseFloat(aryItem.nPrecio),
        //                     sTable        : "#table-detalle",
        //                     nEquivalencia : aryItem.nEquivalencia,
        //                     nConvertir    : 1,
        //                     nItem         : parseInt((nIndex) + 1),
        //                     nTotal        : (parseFloat(aryItem.nCantidad) * parseFloat(aryItem.nPrecio)).toFixed(2)
        //                 };

        //                 fncAgregarFila(jsnRow, "#table-detalle");

        //             });

        //         }

        //     });
        // });


    });



    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
         //   $("#btnCrearMov").hide();
        }
    }

    // Funciones de la tabla 

    window.fncEliminarMov = function(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
              
            var jsnData = {
                nIdRegistro: nIdRegistro
            };

            fncEjecutarEliminarRegistro(jsnData, function(aryData) {

                if (aryData.success) {
                    fncRefreshTable();
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }

            });


        });
    }

    window.fncMostrarMov = function(nIdRegistro, sAccion) {
        
        fncCleanMov();
        fncOcultarAside();
        $("#formMov").data("nIdRegistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarMovimiento(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryMov        = aryResponse.aryMovimiento;
                var aryDetalle    = aryResponse.aryDetalle;

                $("#sDescripcionMov").val(aryMov.sDescripcion);
                //$("#nTipoMovimiento").val(aryMov.nTipoMovimiento);
                $("#dFechaMov").val(aryMov.dFechaMovimiento);

                

                if (aryDetalle.length > 0) {

                    aryDetalle.forEach((aryItem, nIndex) => {

                        var jsnRow = {
                            nIdProducto     : aryItem.nIdProducto,
                            sProducto       : aryItem.sProducto,
                            sImagen         : aryItem.sImagenProducto,
                            nCantidad       : parseFloat(aryItem.nCantidad),
                            nPrecio         : parseFloat(aryItem.nPrecio),
                            sTable          : "#table-detalle",
                            nEquivalencia   : aryItem.nConversion > 0 ? 1 : 0,
                            nConvertir      : aryItem.nConversion ,
                            nItem           : parseInt((nIndex) + 1),
                            nTotal          : (parseFloat(aryItem.nCantidad) * parseFloat(aryItem.nPrecio)).toFixed(2)
                        };

                        fncAgregarFila(jsnRow, "#table-detalle");

                    });

                }

                if (sAccion == 'editar') {
                    fncControles(false);
                } else {
                    fncControles(true);
                }

                $("#formMov").find(".modal-title").html((sAccion == 'editar' ? 'Editar' : 'Ver') + ' Nota de ingreso');
                $("#formMov").modal("show");
            } else {
                toastr.error(aryData.error);
            }
        });

    }

    window.fncDrawOC = function(jsnData,sHtmlTag,nIdOrdenCompra){
        
        fncObtenerOC(jsnData, function(aryData) {

            let sOptions = ``;

            if (aryData.success) {

                sOptions += `<option value="0">NINGUNO</option>`;

                aryData.aryData.forEach(aryElement => {
                    sOptions += `<option value="${aryElement.nIdOrdenCompra}">${aryElement.nIdOrdenCompra.padStart(8, "0")}</option>`;
                });

                $(sHtmlTag).html(sOptions);

                if (nIdOrdenCompra != null) {
                    $(sHtmlTag).val(nIdOrdenCompra);
                }
            }

        });
    }
 
    // Funciones Auxiliares

    window.fncGetDataTableCatalogo = function(sTable) {
        
        var aryData = [];

        $(sTable).find("tbody").find("tr").each(function() {

            var nIdProducto     = $(this).find("td").eq(0).html();
            var nPrecio         = $(this).find("td").eq(nColPrecio).find(".precio").val();
            var nCantidad       = $(this).find("td").eq(nColCantidad).find(".cantidad").val();
            var nConvertir      = 0;

            // console.log($(this).find("td").eq(4).find(".equivalencia"));
            // console.log($(this).find("td").eq(4));
            
            aryData.push({
                nIdProducto     : nIdProducto,
                nPrecio         : nPrecio,
                nCantidad       : nCantidad,
                nConvertir      : nConvertir
            });

        });

        return aryData;
    }

    window.fncControles = (bFlag) => {
        // bloquear
        if (bFlag) {
            $("#sDescripcionMov,#nTipoMovimiento").attr("disabled","disabled");
 
            $("#form-add-producto").hide();
            $("#formMov").find(".modal-footer").hide();
        } else {
            $("#sDescripcionMov,#nTipoMovimiento").removeAttr("disabled");
            $("#form-add-producto").show();
            $("#content-efectivo-vuelto").show();
            $("#formMov").find(".modal-footer").show();
        }
    }

    window.fncCleanAll = () => {
        $("#nIdProducto").val("").trigger("change");
        fncClearInputs($("#form-add-producto"));
 
    }

    window.fncCleanMov = () => {

        fncClearInputs($("#form-add-producto"));
        $("#dFechaMov").val(moment().format('DD/MM/YYYY'));
        $("#nTipoMovimiento").val(0);
        $("#sDescripcionMov").val("");

        $("#nIdProducto").val(0).trigger("change");
        $("#table-detalle").find("tbody").html("");
        $("#nPrecio").val("0.00");
        $("#nCantidad").val("1");

        setTimeout(() => {
            fncTotales(null, "#table-detalle", null);
        }, 500);
    }

    window.fncEliminarItem = function(nIdProducto, sTable, element) {
 

        fncMsg(1, "¿Estas seguro de eliminar este item?", 
        function(){
            
            $(element).parent().parent().parent().remove();

            setTimeout(() => {
                fncTotales(null, sTable, null);
            }, 500);

        });

    }

    window.fncTotales = function(nIdProducto = null, sTable, event = null) {

        var nSubtotal = 0;
        var nCantidadTotal = 0;
        var nTotalIgv = 0;
        var nTotal = 0;

        if ($(sTable).find("tbody").find("tr").length > 0) {

            $(sTable).find("tbody").find("tr").each(function() {

                var nPrecioItem = $(this).find("td").eq(nColPrecio).find(".precio").val();
                var nCantidad   = $(this).find("td").eq(nColCantidad).find(".cantidad").val();
                var nTotalItem  = parseFloat(nPrecioItem) * parseFloat(nCantidad);

                $(this).find("td").eq(nColTotal).find("div").html(fncNf(nTotalItem));

                // if(event != null && event.type == "blur"){
                //     $(this).find("td").eq(4).find(".precio").val( fncNf(nPrecioItem) );
                // }

                nSubtotal += nTotalItem;
                nCantidadTotal += parseInt(nCantidad);

            });

            nTotalIgv = (nSubtotal * parseFloat(nIgv / 100));
            nSubtotal = nSubtotal - nTotalIgv;
            nTotal = nSubtotal + nTotalIgv;


            $(sTable).find(".subtotal").html(fncNf(nSubtotal));
            $(sTable).find(".igv").html(fncNf(nTotalIgv));
            $(sTable).find(".total").html(fncNf(nTotal));

            setTimeout(() => {
                if(parseFloat($("#nEfectivo").val())>0){
                    $("#nEfectivo").trigger("blur");
                }
            }, 500);

        } else {
            $(sTable).find(".subtotal").html(fncNf(0));
            $(sTable).find(".igv").html(fncNf(0));
            $(sTable).find(".total").html(fncNf(0));
        }

    }

    window.fncAgregarFila = function(jsnRow, sHtmlTag) {

        if ($(sHtmlTag).find("tbody").find("tr").length > 0) {

            var bExist = false;

            $(sHtmlTag).find("tbody").find("tr").each(function() {

                var nIdProducto = $(this).find("td").eq(0).html();

                var nPrecioItem   = parseFloat($(this).find("td").eq(nColPrecio).find(".precio").val());
                var nCantidadItem = parseFloat($(this).find("td").eq(nColCantidad).find(".cantidad").val());
                console.log(jsnRow);
                if (jsnRow.nIdProducto == nIdProducto && nPrecioItem == jsnRow.nPrecio) {

                    bExist = true;

                    var nCantidadNew = nCantidadItem + jsnRow.nCantidad;
                    var nTotalNew = nCantidadNew * nPrecioItem;

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

    window.fncDrawFilaProducto = function(jsnData) {
        var sHtml = ``;
        sHtml = `<tr> 
                    <td class="d-none">${jsnData.nIdProducto}</td>
                    <td><div><a href="javascript:;" class="text-danger font-18" onclick="fncEliminarItem(${jsnData.nIdProducto},'${jsnData.sTable}',this);" title="Eliminar"><i class="material-icons">delete</i></a></div></td>
                    <td><div>${jsnData.nItem}</div></td>
                    <td><div>${jsnData.sImagen.length >0 ? `<img class="user-avatar rounded-circle mr-2 img-prod" src="${src( 'multi/' + jsnData.sImagen )}" alt="${jsnData.sImagen}">` : `` }</div></td>
                    <td><div>${jsnData.sProducto}</div></td>
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
    

    // Llamadas al servidor

    function fncGrabarMovimientoSalida(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'movimientos/fncGrabarMovimientoSalida',
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

    function fncEjecutarEliminarRegistro(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'movimientos/fncEliminarRegistro',
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

    function fncBuscarMovimiento(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'movimientos/fncMostrarRegistro',
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


    function fncObtenerOC(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'ordenCompra/fncObtenerOC',
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

    function fncBuscarOC(jsnData, fncCallback) {
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


    
</script>
<!-- Nota salida -->


 
 

<!-- Filtros Mantenimiento -->
<script>
    $(function() {

        $("#aryIdMovimiento,#aryProductos").select2({
            placeholder: "TODOS"
        });

        $("#formFilter").find("form").on('submit', function(event) {
            event.preventDefault();

            var aryIdMovimiento    = $("#aryIdMovimiento :selected").map(function(nIndex, item) {return $(item).val();}).get();
            var aryProductos       = $("#aryProductos :selected").map(function(nIndex, item) { return $(item).val();}).get();
            var dFechaInicio       = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin          = $('#dFechaFin').datepicker('getDate');


            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de inicio y fin. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }

            var jsnData = {
                aryIdMovimiento : aryIdMovimiento,
                aryProductos    : aryProductos,
                dFechaInicio    : $('#dFechaInicio').val(),
                dFechaFin       : $('#dFechaFin').val(),
                nEntradaSalida  : $("body").data("nsalida")
            };

            fncPopulate(jsnData, function(aryData) {
                bFilterTable  = true;
                $("#table").bootstrapTable("load", aryData);
                $("#formFilter").modal("hide");
            });

        });

        $("#btnFilter").on("click",function(){
            $("#formFilter").modal("show");
        });

    });

    window.fncClearFilterM = () => {
        
        $("#aryIdMovimiento,#aryProductos").val([]).trigger("change");
        $("#dFechaInicio,#dFechaFin").val("");
 
    }

    // Llamadas al servidor
    function fncPopulate(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'movimientos/fncPopulate',
            data: jsnData,
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
<!-- Filtros Mantenimiento -->


 
</html>