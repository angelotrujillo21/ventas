<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body  data-nadmin="<?=$nAdmin?>">

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
                                                                <h5><?=$sTitulo?></h5>
                                                            </div>

                                                            <div class="ml-auto">
                                                            
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin de Fila Cabecera -->


                                                <div id="toolbar" class="btn-group row">
                                                    <div class="col-md-6 sin-padding container-buttons-table">
                                                        
                                                        <button id="btnFilterG" class="btn btn-gradient-primary-table" type="button" title="Filtros">
                                                            <i class="fas fa-filter"></i>
                                                        </button>

                                                       
                                                    </div>
                                                </div>

                                             

                                                <div class="row my-2">
                                                    <div class="col-12">

                                                        <div id="content-reporte-general" style="display: none;">

                                                            <table  id="tblGeneral" class="table table-hover table-condensed ">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Responsable</th>
                                                                        <th>Total</th>
                                                                    </tr> 
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>TOTAL</td>
                                                                        <td id="nTotalG" class="nTotal">0.00</td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>

                                                        </div>

                                                        <div id="content-reporte-detallado" style="display: none;">

                                                            <div class="table-responsive">
                                                                <table id="tblDetalle" class="table table-hover table-condensed ">
                                                                    <thead>
                                                                        
                                                                        <tr>
                                                                            <th>Cod. Pedido Interno</th>
                                                                            <th>Cod. Pedido </th>
                                                                            <th>Empleado</th>
                                                                            <th>Cliente</th>
                                                                            <th>Fecha Creacion</th>
                                                                            <th>Facturado</th>
                                                                            <th>Detalle<br><span class="font-13">Producto | Precio x Cantidad</span></th>
                                                                            <th>Total Bruto</th>
                                                                            <th>Total Dsct</th>
                                                                            <th>Subtotal</th>
                                                                            <th>Igv</th>
                                                                            <th>Total</th>
                                                                        </tr> 
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="11">TOTAL</td>
                                                                            <td id="nTotalD" class="nTotal">0.00</td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>

                                                            </div>

                                                          


                                                        </div>
                                                        
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

    <!--Filtro para el reporte General -->
    <div class="modal fade" id="formFilterG" tabindex="-1" role="dialog" aria-labelledby="formFilterGLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formFilterGLabel">Filtros</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="aryResponsable" class="col-form-label">Responsable</label>
                                    <select class="form-control" name="aryResponsable" id="aryResponsable" multiple>
                                        <option value="">TODOS</option>
                                        <?php if (fncValidateArray($aryResponsable)) : ?>
                                            <?php foreach ($aryResponsable as $aryLoop) : ?>
                                                <option value="<?= $aryLoop["nIdResponsable"] ?>"><?=  strup( $aryLoop["sResponsable"] )  ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nTipoReporte" class="col-form-label">Tipo</label>
                                    <select class="form-control" name="nTipoReporte" id="nTipoReporte">
                                        <option value="1">RESUMEN</option>
                                        <option value="2">DETALLADO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nFacturado" class="col-form-label">Facturado</label>
                                    <select class="form-control" name="nFacturado" id="nFacturado">
                                        <option value="">TODOS</option>
                                        <option value="1">FACTURADO</option>
                                        <option value="0">SIN FACTURAR</option>
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

 

<!-- R.General -->
<script>

   window.jsnDataRG = null ;

    $(function() {

        // fncOcultarAside();
        // fncValidarRol();


        $("#aryResponsable").select2({
            placeholder: "TODOS"
        });

        $("#formFilterG").find("form").on('submit', function(event) {
            event.preventDefault();

            var aryResponsable    = $("#aryResponsable :selected").map(function(nIndex, item) {return $(item).val();}).get();
            var nTipoReporte      = $("#nTipoReporte").val();
            var dFechaInicio      = $('#dFechaInicio').val() ;
            var dFechaFin         = $('#dFechaFin').val() ;
            var nFacturado         = $('#nFacturado').val() ;

    
            aryResponsable = aryResponsable.length == 0 ? $("#aryResponsable option").map(function(nIndex, item) { if($(item).val() != '' ) { return $(item).val() } ;}).get() : aryResponsable;



            window.jsnDataRG  = {
                nTipoReporte       : nTipoReporte , // General
                aryResponsable     : aryResponsable,
                dFechaInicio       : dFechaInicio,
                dFechaFin          : dFechaFin,
                nFacturado         : nFacturado
            };

            // console.log(jsnData);
            // return;

            if(nTipoReporte == 1){
                $("#content-reporte-general").show();
                $("#content-reporte-detallado").hide();

                fncObtenerReporteResponasbleResumen(jsnDataRG,(aryData)=>{

                    if(aryData.success){

                        var sHtml = ``;
                        var nTotal = 0;
                        console.log(aryData.aryData.length );
                        if(aryData.aryData.length > 0 ){

                            aryData.aryData.forEach(element => {
                                nTotal += parseFloat(element.nTotal);
                                sHtml += 
                                `<tr>
                                    <td>${element.sResponsable}</td>           
                                    <td>${element.nTotal}</td>           
                                </tr>`;
                            });

                             

                        }else {
                            sHtml += 
                                `<tr>
                                    <td colspan="${$("#tblGeneral").find("tr").find("th").length}">No se encontraron resultados</td>           
                                </tr>`;
                        }

                        $("#formFilterG").modal("hide");

                        $("#nTotalG").html(nTotal.toFixed(2));
                        $("#tblGeneral").find("tbody").html(sHtml);

                        toastr.success( aryData.success );
                    } else {
                        toastr.error( aryData.error );
                    }

                });

            } else {
                $("#content-reporte-general").hide();
                $("#content-reporte-detallado").show();

                fncObtenerReporteResponasbleDetalle(jsnDataRG,(aryData)=>{

                    if(aryData.success){

                        var sHtml = ``;
                        var nTotal = 0;

                        if(aryData.aryData.length > 0 ){

                            aryData.aryData.forEach(element => {
                                nTotal += parseFloat(element.nTotal);
                                sHtml += 
                                `<tr>
                                    <td>${element.nIdPedido}</td>
                                    <td>${element.sNumero} </td>
                                    <td>${element.sResponsable} </td>
                                    <td>${element.sCliente} </td>
                                    <td>${element.dFechaCreacion} </td>
                                    <td>${element.sFacturado} </td>
                                    <td>${element.sDetalle} </td>
                                    <td>${element.nTotalBruto} </td>
                                    <td>${element.nDsctTotal} </td>
                                    <td>${element.nSubtotal} </td>
                                    <td>${element.nIgv} </td>
                                    <td>${element.nTotal} </td>
 
                                </tr> `;
                            });

                             

                        }else {
                            sHtml += 
                                `<tr>
                                    <td colspan="${$("#tblDetalle").find("tr").find("th").length}">No se encontraron resultados</td>           
                                </tr>`;
                        }

                        $("#formFilterG").modal("hide");
                        $("#nTotalD").html(nTotal.toFixed(2));
                        $("#tblDetalle").find("tbody").html(sHtml);

                        toastr.success( aryData.success );
                    } else {
                        toastr.error( aryData.error );
                    }

                });

            }

        

        });


        $("#btnFilterG").on("click",function(){
            $("#formFilterG").modal("show");
        });


        
        fncMsg(2, 'Mensaje : Para poder ver los reportes primero debe de realizar un filtro ya sea por resumen o detallado ', ()=>{
            $("#btnFilterG").trigger("click");
        });



    });



    window.fncClearFilterM = () => {
        
        $("#aryIdPedido,#aryProductos,#aryClientes").val([]).trigger("change");
        $("#nFacturado").val("");
        $("#dFechaInicio,#dFechaFin").val("");
 
    }

    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            // no es admin
        }
    }


    // Llamadas al servidor
    function fncObtenerReporteResponasbleResumen(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncObtenerReporteResponasbleResumen',
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

     // Llamadas al servidor
     function fncObtenerReporteResponasbleDetalle(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncObtenerReporteResponasbleDetalle',
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
<!-- R.General -->




</html>