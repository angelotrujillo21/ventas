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
                                                <table data-toggle="table" id="table" data-url="<?= route('productos/fncPopulateProductoDescomp') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                            <th data-field="sEstado" data-visible="true" data-sortable="true">Estado</th>
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

    <div class="modal fade" id="formPD" tabindex="-1" role="dialog" aria-labelledby="fformEQLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               
                    <div class="modal-header">
                        <h5 class="modal-title" id="fformEQLabel">Nueva Producto Descomp</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">

                        
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sNombre" class="col-form-label">Descripcion:</label>
                                    <input type="text" class="form-control" id="sNombre" name="sNombre"  autocomplete="off">
                                </div>
                            </div>
                
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdProductoPadre" class="col-form-label">Producto Padre: <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="nIdProductoPadre" id="nIdProductoPadre">
                                        <?php if(fncValidateArray($aryProductos)): ?>
                                            <?php foreach($aryProductos as $aryProducto):?>
                                                <option data-sdescripcion="<?= strup( $aryProducto["sDescripcion"] )  . " - " .strup( $aryProducto["sUnidadMedidaCorto"]) ?>" data-nidunidadmedida="<?=$aryProducto["nIdUnidadMedida"]?>" data-nequivalencia="<?=$aryProducto["nEquivalencia"]?>" data-nstockactual ="<?=$aryProducto["nStockActual"]?>" value="<?= $aryProducto["nIdProducto"] ?>"><?= strup( $aryProducto["sDescripcion"] ) . " - " .strup( $aryProducto["sUnidadMedidaCorto"]) ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                                                  
                   

                
                        
                            <div class=" col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nIdProductoHijo" class="col-form-label">Producto equivalente:</label>
                                    <select class="form-control" name="nIdProductoHijo" id="nIdProductoHijo">
                                        <?php if(fncValidateArray($aryProductos)): ?>
                                            <?php foreach($aryProductos as $aryProducto):?>
                                                <option data-sdescripcion="<?= strup( $aryProducto["sDescripcion"] )  . " - " .strup( $aryProducto["sUnidadMedidaCorto"])  ?>"  data-nidunidadmedida="<?=$aryProducto["nIdUnidadMedida"]?>" data-nequivalencia="<?=$aryProducto["nEquivalencia"]?>" data-nstockactual ="<?=$aryProducto["nStockActual"]?>" value="<?= $aryProducto["nIdProducto"] ?>"><?= strup( $aryProducto["sDescripcion"] )  . " - " .strup( $aryProducto["sUnidadMedidaCorto"]) ?></option>
                                            <?php endforeach?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="nDescomp" class="col-form-label">Descompocision:</label>
                                    <input type="number" class="form-control" value="0.00" id="nDescomp" name="nDescomp"  min="0.00" max="9999999.999999"  lang="en" step="0.000001"  autocomplete="off">
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="btnAgregarProd" class="col-form-label d-none d-md-block">&nbsp;</label>
                                    <button id="btnAgregarProd" type="button" class="btn btn-gradient-primary btn-fw">Agregar</button>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">

                                <table id="tblDetalle" class="table table-hover table-condensed">
                                    <thead>
                                      <tr>
                                        <th>Producto Padre</th>
                                        <th>Producto Equivalente</th>
                                        <th>Descomp.</th>
                                        <th>Accion</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>

                            

                            
                       

  

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button id="btnaGuardarD" type="button" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
                    </div>
           
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

        fncValidarRol();

        $("#nIdProductoPadre,#nIdProductoHijo").select2({
            placeholder : "SELECCIONAR"
        });
      
        // Formulario Categorias
        $("#btnCrearEQ").on('click', function() {
            
            fncCleanAll();
            
            $("#formPD").find(".modal-title").html('Nueva descompocision');
            
            $("#formPD").data("nIdRegistro",0);
            
            $("#formPD").modal("show");

        });

        $("#btnaGuardarD").on('click', function(event) {
            
            event.preventDefault();

            var nIdRegistro             = $("#formPD").data("nIdRegistro");
            var sNombre                 = $("#sNombre").val();
            var aryDetalle              = fncGetDataTable ("#tblDetalle");
            var nEstado                 = 1;

            console.log(aryDetalle);

            if(aryDetalle.length == 0){
                toastr.error("Error.Debe de escoger por lo menos un item para la descompocision.Porfavor verifique");
                return;
            }

            
            var jsnData = {
                nIdRegistro          : nIdRegistro,
                sNombre              : sNombre,
                aryDetalle           : aryDetalle,
                nEstado              : nEstado
            };

        
            fncGrabarProductosDescomp(jsnData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formPD").modal("hide");
                    $('#table').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });    
        });


        $("#btnAgregarProd").on("click",function(){
            fncAddProd();
        });
        
        $("#nDescomp").on("keypress",function(e){
            if(e.which == 13) {
                fncAddProd();
            }
        });

        $("#nIdProductoPadre").on("change",function(){

            var nIdProductoPadre     = $(this).find("option:selected").val();
            var nIdUnidadMedidaPadre = $(this).find("option:selected").data("nidunidadmedida");
            var sDescripcionPadre    = $(this).find("option:selected").data("sdescripcion");

            var bExiste = false;

            $("#tblDetalle").find("tbody").find("tr").each(function() {

                var nIdProductoHijo = $(this).find("td").eq(1).data("id");

                if(nIdProductoPadre == nIdProductoHijo){
                    bExiste = true;
                }

            });

            if(bExiste){
                toastr.error("Error.En los detalles de la descompocicion se encuentra el producto Padre.Porfavor verifica");
                return;
            }

            var filas = ``;

            $("#tblDetalle").find("tbody").find("tr").each(function() {
                
                var nIdProductoHijo      = $(this).find("td").eq(1).data("id");
                var nIdUnidadMedidaHijo  = $(this).find("td").eq(1).data("nidunidadmedida");
                var sDescripcionHijo     = $(this).find("td").eq(1).html().trim();
                var nDescomp             = $(this).find("td").eq(2).find(".nDesc").val();

                var jsnData = {
                    sTable               : "#tblDetalle",
                    nIdProductoPadre     : nIdProductoPadre,
                    nIdUnidadMedidaPadre : nIdUnidadMedidaPadre,
                    sDescripcionPadre    : sDescripcionPadre,
                    nIdProductoHijo      : nIdProductoHijo,
                    nIdUnidadMedidaHijo  : nIdUnidadMedidaHijo,
                    sDescripcionHijo     : sDescripcionHijo,
                    nDescomp             : nDescomp,
                };

                filas += fncDrawFilaProducto(jsnData);
            });
            
            $("#tblDetalle").find("tbody").html(filas);

        });
       
    });

    function fncAddProd(){

            var nIdProductoPadre     = $("#nIdProductoPadre").find("option:selected").val();
            var nIdUnidadMedidaPadre = $("#nIdProductoPadre").find("option:selected").data("nidunidadmedida");
            var sDescripcionPadre    = $("#nIdProductoPadre").find("option:selected").data("sdescripcion");

            var nIdProductoHijo     = $("#nIdProductoHijo").find("option:selected").val();
            var nIdUnidadMedidaHijo = $("#nIdProductoHijo").find("option:selected").data("nidunidadmedida");
            var sDescripcionHijo    = $("#nIdProductoHijo").find("option:selected").data("sdescripcion");

            var nDescomp = $("#nDescomp").val();

            if(!nIdProductoPadre  || nIdProductoPadre == 0){
                toastr.error("Error. Debe de seleccionar un producto padre.Porfavor verifique");
                return;
            } else if(!nIdProductoHijo || nIdProductoHijo == 0){
                toastr.error("Error. Debe de seleccionar un producto equivalente o hijo .Porfavor verifique");
                return;
            } else if(nDescomp == '' || nDescomp<= 0.00){
                toastr.error("Error. Debe de ingresar una cantidad de descompicion.Porfavor verifique");
                return;
            } else if(nIdProductoPadre == nIdProductoHijo){
                toastr.error("Error.El producto padre y el prodructo hijo no pueden ser los mismos .Porfavor verifique.");
                return;
            }
 
            var bExist = false;

            $("#tblDetalle").find("tbody").find("tr").each(function() {

                    var nIdProductoHijoItem = $(this).find("td").eq(1).data("id");

                    if (nIdProductoHijoItem == nIdProductoHijo) {
                        bExist = true;
                    }
            });

            if(bExist=== true){
                toastr.error("Error ya agregaste este producto porfavor verifica.");
                return;
            }

            var jsnData = {
                sTable               : "#tblDetalle",
                nIdProductoPadre     : nIdProductoPadre,
                nIdUnidadMedidaPadre : nIdUnidadMedidaPadre,
                sDescripcionPadre    : sDescripcionPadre,
                nIdProductoHijo      : nIdProductoHijo,
                nIdUnidadMedidaHijo  : nIdUnidadMedidaHijo,
                sDescripcionHijo     : sDescripcionHijo,
                nDescomp             : nDescomp,
            };

  
            $(jsnData.sTable).find("tbody").append(fncDrawFilaProducto(jsnData));

            $("#nIdProductoHijo").val("").trigger("change");
            $("#nDescomp").val(0.00);


    }

    window.fncGetDataTable = function(sTable) {
        
        var aryData = [];

        $(sTable).find("tbody").find("tr").each(function() {

            var nIdProductoPadre      = $(this).find("td").eq(0).data("id");
            var nIdUnidadMedidaPadre  =  $(this).find("td").eq(0).data("nidunidadmedida");

            var nIdProductoHijo      = $(this).find("td").eq(1).data("id");
            var nIdUnidadMedidaHijo  = $(this).find("td").eq(1).data("nidunidadmedida");

            var nDescomp          = $(this).find("td").eq(2).find(".nDesc").val();
 
            aryData.push({
                nIdProductoPadre        : nIdProductoPadre,
                nIdUnidadMedidaPadre    : nIdUnidadMedidaPadre,
                nIdProductoHijo         : nIdProductoHijo,
                nIdUnidadMedidaHijo     : nIdUnidadMedidaHijo,
                nDescomp                : nDescomp,
            });

        });

        return aryData;
    }


    window.fncDrawFilaProducto = function(jsnData) {
        var sHtml = ``;
        sHtml = ` <tr>
                    <td data-id="${jsnData.nIdProductoPadre}" data-nidunidadmedida="${jsnData.nIdUnidadMedidaPadre}">${jsnData.sDescripcionPadre}</td>
                    <td data-id="${jsnData.nIdProductoHijo}" data-nidunidadmedida="${jsnData.nIdUnidadMedidaHijo}">${jsnData.sDescripcionHijo}</td>
                    <td><input type="number" min="0.00" max="9999999.999999"  lang="en" step="0.000001"  class="form-control nDesc" value="${jsnData.nDescomp}" /></td>
                    <td><div><a href="javascript:;" class="text-danger font-18" onclick="fncEliminarItem('${jsnData.sTable}',this);" title="Eliminar"><i class="material-icons">delete</i></a></div></td>
                </tr>`;
        return sHtml;
    }
 
   
    window.fncEliminarItem = function(sTable, element) {
        if (confirm("¿Estas seguro de eliminar este item?")) {
            $(element).parent().parent().parent().remove();
        }
    }

    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
             $("#btnCrearEQ").hide();
         }
    }

    // Funciones de la tabla o layout Principal 

    function fncEliminarPD(nIdRegistro) {
     

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             

            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarPD( jsnData , function(aryData){

                if(aryData.success){
                    $('#table').bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });


    }

    function fncMostrarPD (nIdRegistro,sOpcion) {
        
        fncCleanAll();

        $("#formPD").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarRegistroPD(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData         = aryResponse.aryData;
                    var aryDetalle      = aryResponse.aryDetalle;

                    $("#sNombre").val(aryData.sNombre);
                    $("#tblDetalle").find("tbody").html("");

                    var nIdProductoPadre = "";
                    
                    if(aryDetalle.length >0){
                        aryDetalle.forEach(element => {

                            var jsnData = {
                                    sTable               : "#tblDetalle",
                                    nIdProductoPadre     : element.nIdProductoPadre,
                                    nIdProductoHijo      : element.nIdProductoHijo ,
                                    nIdUnidadMedidaPadre : element.nIdUnidadMedidaPadre,
                                    nIdUnidadMedidaHijo  : element.nIdUnidadMedidaHijo,
                                    sDescripcionPadre    : element.sDescripcionPadre + ' - ' + element.sCortoUMPadre,
                                    sDescripcionHijo     : element.sDescripcionHijo + ' - ' + element.sCortoUMHijo,
                                    nDescomp             : element.nDescomp,
                            };
                    
                            $(jsnData.sTable).find("tbody").append(fncDrawFilaProducto(jsnData));
                            nIdProductoPadre = element.nIdProductoPadre; 
                        });
                    }                    

                    $("#nIdProductoPadre").val(nIdProductoPadre).trigger("change");

                    if(sOpcion == 'editar'){
                 

                        fncEditForm("#formPD" , "Ver Descompocision");
                        $("#btnaGuardarD").show();
                        $("#btnAgregarProd").show();
                    } else {
                      
                        fncViewForm("#formPD" , "Ver Descompocision");
                        $("#btnaGuardarD").hide();
                        $("#btnAgregarProd").hide();
                    }

                    $("#formPD").modal("show");
                } else {
                    toastr.error(aryData.error);
                }
        });

    }

   

    // Funciones Auxiliares
    window.fncCleanAll = () => {
        
        fncRemoveDisabledForm("#formPD");
        fncRemoveDisabled("#formPD");

        $("#sNombre").val("");
        $("#tblDetalle").find("tbody").html("");
        $("#nIdProductoPadre,#nIdProductoHijo").val("").trigger("change");
        $("#btnAgregarProd").show();
        $("#btnaGuardarD").show();
    }


    function fncGrabarProductosDescomp(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'productos/fncGrabarProductosDescomp',
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


    function fncBuscarRegistroPD(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'productos/fncMostrarProductoDescomp',
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

    function fncEjecutarEliminarPD ( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'productos/fncEliminarProductoDescom',
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


  
</script>
<!-- EQ -->



 

</html>