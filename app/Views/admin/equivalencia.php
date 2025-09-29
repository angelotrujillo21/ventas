<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin="<?=$nAdmin?>">

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
                                                        <button id="btnCrearEQ" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('movimientos/fncPopulateEquivalencias') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sProductoPadre" data-sortable="true">Producto Padre</th>
                                                            <th data-field="nCantidadPadre" data-sortable="true">Cantidad Padre</th>
                                                            <th data-field="sProductoHijo" data-sortable="true">Producto Hijo</th>
                                                            <th data-field="nCantidadHijo" data-sortable="true">Cantidad Hijo </th>
                                                            <th data-field="dFechaCreacion" data-sortable="true">Fecha Creacion</th>
                                                            <th data-field="sEstado"  data-visible="false" data-sortable="true">Estado</th>
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

    <div class="modal fade" id="formEQ" tabindex="-1" role="dialog" aria-labelledby="fformEQLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fformEQLabel">Nueva Equivalencia</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">

                        
                
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nIdProductoPadre" class="col-form-label">Producto: <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nIdProductoPadre" id="nIdProductoPadre">
                                        <?php if(fncValidateArray($aryProductosEQ)): ?>
                                            <?php foreach($aryProductosEQ as $aryProducto):?>
                                                <option data-sdescripcion="<?= strup( $aryProducto["sDescripcion"] )?>" data-nidunidadmedida="<?=$aryProducto["nIdUnidadMedida"]?>" data-nequivalencia="<?=$aryProducto["nEquivalencia"]?>" data-nstockactual ="<?=$aryProducto["nStockActual"]?>" value="<?= $aryProducto["nIdProducto"] ?>"><?= strup( $aryProducto["sDescripcion"] ) . " - " .strup( $aryProducto["sUnidadMedidaCorto"]) ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                                                  
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nIdUnidadMedida" class="col-form-label">Unidad de medida: <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nIdUnidadMedida" id="nIdUnidadMedida" disabled>
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryUnidadMedida)): ?>
                                            <?php foreach($aryUnidadMedida as $aryUnidadMed):?>
                                                <option value="<?= $aryUnidadMed["nIdUnidadMedida"] ?>"><?= $aryUnidadMed["sNombreLargo"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>


                        
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="nStockActual" class="col-form-label">Stock Actual:</label>
                                    <input type="number" class="form-control" id="nStockActual" name="nStockActual" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="0.00" autocomplete="off" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="nConvertir" class="col-form-label">Cant. Convertir :</label>
                                    <input type="number" class="form-control" id="nConvertir"  name="nConvertir" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="0.00" autocomplete="off" >
                                </div>
                            </div>
                        
                            <div class="col-md-4 col-12 content-equivalencia">
                                <div class="form-group">
                                    <label for="nIdProductoHijo" class="col-form-label">Producto equivalente:</label>
                                    <select class="form-control" name="nIdProductoHijo" id="nIdProductoHijo">
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryProductos)): ?>
                                            <?php foreach($aryProductos as $aryProducto):?>
                                                <option data-sdescripcion="<?= strup( $aryProducto["sDescripcion"] )?>"  data-nidunidadmedida="<?=$aryProducto["nIdUnidadMedida"]?>" data-nequivalencia="<?=$aryProducto["nEquivalencia"]?>" data-nstockactual ="<?=$aryProducto["nStockActual"]?>" value="<?= $aryProducto["nIdProducto"] ?>"><?= strup( $aryProducto["sDescripcion"] )  . " - " .strup( $aryProducto["sUnidadMedidaCorto"]) ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-4 col-12 content-equivalencia">
                                <div class="form-group">
                                    <label for="nIdUnidadMedidaHijo" class="col-form-label">Unidad Medida Equivalente:</label>
                                    <select class="form-control" name="nIdUnidadMedidaHijo" id="nIdUnidadMedidaHijo" disabled>
                                        <option value="0">SELECCIONAR</option>
                                        <?php if(fncValidateArray($aryUnidadMedida)): ?>
                                            <?php foreach($aryUnidadMedida as $aryUnidadMed):?>
                                                <option value="<?= $aryUnidadMed["nIdUnidadMedida"] ?>"><?= $aryUnidadMed["sNombreLargo"] ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12 content-equivalencia">
                                <div class="form-group">
                                    <label for="nCantidadHijo" class="col-form-label">Cantidad equivalencia:</label>
                                    <input type="number" class="form-control" id="nCantidadHijo" min="0.00" max="9999999.999999"  lang="en" step="0.000001" value="1" autocomplete="off" name="nCantidadHijo" readonly>
                                </div>
                            </div>

                            <div class="col-12">
                                <p class="font-weight-bold" id="sTextEquivalencia"></p>
                            </div>

  

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


     

    <!-- Fin de modales -->





    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>

<!-- EQ -->
<script>

    $(function() {

        //fncOcultarAside();
        fncValidarRol();

        $("#nIdProductoPadre").select2({
            placeholder : "SELECCIONAR"
        });
      
        // Formulario Categorias
        $("#btnCrearEQ").on('click', function() {
            
            fncCleanAll();
            
            $("#formEQ").find(".modal-title").html('Equivalencia');
            
            $("#formEQ").data("nIdRegistro",0);
            
            $("#formEQ").modal("show");

        });

        $("#formEQ").find('form').on('submit', function(event) {
            
            event.preventDefault();

            var nIdRegistro             = $("#formEQ").data("nIdRegistro");
            var nIdProductoPadre        = $("#nIdProductoPadre").val();
            var nEquivalencia           = $("#nIdProductoPadre").find("option:selected").data("nequivalencia");
            var nIdUnidadMedidaPadre    = $("#nIdUnidadMedida").val();
            var nStockActual            = $("#nStockActual").val();
            var nConvertir              = $("#nConvertir").val();
            var nIdProductoHijo         = $("#nIdProductoHijo").val();
            var nIdUnidadMedidaHijo     = $("#nIdUnidadMedidaHijo").val();
            var nCantidadHijo           = $("#nCantidadHijo").val();
            var nEstado                 = 1;
            
            if(nIdProductoPadre == 0 || !nIdProductoPadre){
                toastr.error('Error. Debe ingresar una producto padre.');
                return false;
            } else if(nIdUnidadMedidaPadre == '0' || !nIdUnidadMedidaPadre  ){
                toastr.error('Error. Debe ingresar una  unidad de media para el producto padre.');
                return false;
            } else if(nConvertir == '0'){
                toastr.error('Error. Debe ingresar una cantidad a convertir.');
                return false;
            } else if(nIdProductoHijo == 0 || !nIdProductoHijo){
                toastr.error('Error. Debe ingresar una producto hijo.');
                return false;
            } else if(nIdUnidadMedidaHijo == '0' || !nIdUnidadMedidaHijo  ){
                toastr.error('Error. Debe ingresar una  unidad de media para el producto hijo.');
                return false;
            }  else if(nCantidadHijo <= 0.00 ){
                toastr.error('Error. Debe ingresar una  cantidad para la equivalencia.');
                return false;
            }

            var jsnData = {
                nIdRegistro          : nIdRegistro,
                nIdProductoPadre     : nIdProductoPadre,
                nIdUnidadMedidaPadre : nIdUnidadMedidaPadre,
                nStockActual         : nStockActual,
                nConvertir           : nConvertir,
                nIdProductoHijo      : nIdProductoHijo,
                nIdUnidadMedidaHijo  : nIdUnidadMedidaHijo,
                nCantidadPadre       : 1,
                nCantidadHijo        : nCantidadHijo,
                nEstado              : nEstado
            };

        
            fncProcesarEquivalencia(jsnData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formEQ").modal("hide");
                    $('#table').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });    
        });

        $("#nIdProductoPadre").on("change",function(){
            
            if($(this).val() == 0 || !$(this).val() ) return false;
            
            var nIdUnidadMedida = $(this).find("option:selected").data("nidunidadmedida");
            var nStockActual    = $(this).find("option:selected").data("nstockactual");
            var nEquivalencia   = $(this).find("option:selected").data("nequivalencia");
            
            var jsnData = {
                nIdRegistro : $(this).val()
            };
            
           fncBuscarRegistroProducto(jsnData,(aryResponse)=>{
               
               var aryDataProductoEquivalencia = aryResponse.aryDataProductoEquivalencia;
               var aryData = aryResponse.aryData;

               $("#nStockActual").val(aryData.nStockActual);
               
               if( aryDataProductoEquivalencia != null ){

                   $("#nIdProductoHijo").val(aryDataProductoEquivalencia.nIdProductoHijo).trigger("change");
                   $("#nIdUnidadMedidaHijo").val(aryDataProductoEquivalencia.nIdUnidadMedidaHijo).trigger("change");
                   $("#nCantidadHijo").val(aryDataProductoEquivalencia.nCantidadHijo).trigger("keyup");

               }

           });
            

            $("#nStockActual").val(nStockActual);
            $("#nIdUnidadMedida").val(nIdUnidadMedida).trigger("change");
        });

        $("#nIdProductoHijo").on("change",function(){
         
            if($(this).val() == 0) return false;
            var nIdUnidadMedida = $(this).find("option:selected").data("nidunidadmedida");
            $("#nIdUnidadMedidaHijo").val(nIdUnidadMedida).trigger("change");
            //$("#nCantidadHijo").trigger("keyup");
        });

        $("#nCantidadHijo").on("focus keyup",function(){
          
            $("#sTextEquivalencia").html("");
            var nIdProductoPadre  = $("#nIdProductoPadre").val();

            var sDescripcion  = $("#nIdProductoPadre").find("option:selected").data("sdescripcion").trim();

            var nCantidadHijo = $("#nCantidadHijo").val();

            var nIdUnidadMedidaPadre = $("#nIdUnidadMedida").find("option:selected").val();
            var sUnidadMedidaPadre   = $("#nIdUnidadMedida").find("option:selected").text().trim();

            var nIdProductoHijo  = $("#nIdProductoHijo").find("option:selected").val();
            var sProductoHijo    = $("#nIdProductoHijo").find("option:selected").data("sdescripcion").trim();


            var nIdUnidadMedidaHijo   = $("#nIdUnidadMedidaHijo").find("option:selected").val();
            var sUnidadMedidaHijo     = $("#nIdUnidadMedidaHijo").find("option:selected").text().trim();

            if(sDescripcion == ''){
                toastr.error("Error .Debe de ingresar el nombre o descripcion del producto.Porfavor verifique");
                return;
            } else if(nIdUnidadMedidaPadre == 0){
                toastr.error("Error .Debe de seleccionar una unidad de medida para el producto padre.Porfavor verifique");
                return;
            } else if(nIdProductoHijo == 0){
                toastr.error("Error .Debe de seleccionar un producto hijo.Porfavor verifique");
                return;
            } else if(nIdUnidadMedidaHijo == 0){
                toastr.error("Error .Debe de seleccionar una unidad de medida para el producto hijo.Porfavor verifique");
                return;
            }

            var sTexto = " 1 "+ sUnidadMedidaPadre + " de " + sDescripcion + " equivale  a " + nCantidadHijo +  " " + sUnidadMedidaHijo  + " de " + sProductoHijo;

            $("#sTextEquivalencia").html(sTexto.toUpperCase());
            
        });

       
    });

    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
             $("#btnCrearEQ").hide();
         }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarEQ(nIdRegistro) {


        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             
               
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarRegistro( jsnData , function(aryData){

                if(aryData.success){
                    $('#table').bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 

        });
    }

    function fncMostrarEQ(nIdRegistro,sOpcion) {
        
        fncCleanAll();

        $("#formEQ").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarRegistro(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryResponse              = aryResponse.aryData;
                    var aryDataHM                = aryResponse.aryDataHM;
                    var aryDetalleSalida         = aryResponse.aryDetalleSalida;
                    var aryDetalleEntrada        = aryResponse.aryDetalleEntrada;

                    if(aryDetalleSalida.length >0){
                        aryDetalleSalida.forEach(element => {
                            console.log(element);
                            $("#nIdProductoPadre").val(element.nIdProducto).trigger("change");
                            $("#nConvertir").val(element.nCantidad);
                        });
                    }                    
 
                    if(sOpcion == 'editar'){
                        fncEditForm("#formEQ" , "Ver Equivalencia");
                        $("#nIdUnidadMedida,#nIdProductoHijo,#nIdUnidadMedidaHijo").attr("disabled","disabled");
                    } else {
                        fncViewForm("#formEQ" , "Ver Equivalencia");
                    }

                    $("#formEQ").modal("show");
                } else {
                    toastr.error(aryData.error);
                }
        });

    }

   

    // Funciones Auxiliares
    window.fncCleanAll = () => {

        $("#nIdProductoPadre").val("").trigger("change");
        
        fncClearInputs( $("#formEQ").find("form") );
        fncRemoveDisabled( $("#formEQ").find("form") ); 

        $("#nIdUnidadMedida,#nIdProductoHijo,#nIdUnidadMedidaHijo").attr("disabled","disabled");

    }

        
    function fncDrawProducto(sHtmlTag , nIdProducto = null , bDisabled = false ,bIsSelect2  = false, fncCallback = null){
        
        fncObtenerProductos(null,function(aryData){
            
            let sOptions = ``;
            
            if(aryData.success){
                
                if(bIsSelect2 === false){
                    sOptions += `<option value="0">SELECCIONAR</option>`;
                } 
                
                if( aryData.aryData.length > 0){
                    aryData.aryData.forEach(aryElement => {
                        sOptions += `<option data-nidunidadmedida="${aryElement.nIdUnidadMedida}" value="${aryElement.nIdProducto}">${aryElement.sDescripcion.toUpperCase()}</option>`;
                    });
                }

                $(sHtmlTag).html(sOptions);

                if(nIdProducto != null){
                    $(sHtmlTag).val(nIdProducto);
                }

                if(bDisabled != false){
                    $(sHtmlTag).attr("disabled","disabled");
                }

                if(bIsSelect2 != false){
                    $(sHtmlTag).select2({
                        placeholder : "SELECCIONAR"
                    });
                    setTimeout(() => {
                        $(sHtmlTag).val("").trigger("change"); 
                    }, 200);
                }

                if(fncCallback != null){
                    fncCallback(true);
                }

            }

        });

    }

    // Llamadas al servidor

    function fncProcesarEquivalencia(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'movimientos/fncProcesarEquivalencia',
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

    function fncEjecutarEliminarRegistro ( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'movimientos/fncEliminarEquivalencia',
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

    function fncBuscarRegistroProducto(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'productos/fncMostrarProducto',
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


    function fncBuscarRegistro (jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'movimientos/fncMostrarEquivalencia',
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
 
    function fncObtenerProductos(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'productos/fncObtenerProductos',
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
<!-- EQ -->



 

</html>