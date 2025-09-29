<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin = "<?=$nAdmin?>">

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
                                                        <button id="btnCrearCajaDiaria" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                          
                                        <div id="toolbar" class="btn-group row">
                                            <div class="col-md-6 sin-padding container-buttons-table">

                                                <button id="btnFilter" class="btn btn-gradient-primary-table" type="button" title="Filtros">
                                                    <i class="fas fa-filter"></i>
                                                </button>
 
                                            </div>
                                        </div>


                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" data-unique-id="nRow" id="tblPrincipal" data-url="<?= route('cajas/fncPopulateCajaDiaria') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="7" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sCaja" data-sortable="true">Caja</th>
                                                            <th data-field="sEmpleado" data-sortable="true">Empleado</th>
                                                            <th data-field="dFechaHoraApertura" data-sortable="true">Fecha hora apertura</th>
                                                            <th data-field="dFechaCierre" data-sortable="true">Fecha cierre</th>
                                                            <th data-field="nMontoApertura" data-sortable="true">Monto Apertura</th>
                                                            <th data-field="nMontoDeposito" data-sortable="true">Monto Deposito</th>
                                                            <th data-field="nMontoSalidas" data-sortable="true">Monto Salida</th>

                                                            <th data-field="nTotalOCG" data-sortable="true">Gastos/Compras</th>

                                                            <th data-field="nTotalPedidosTarjeta" data-sortable="true" data-visible="false">Tarjeta</th>
                                                            <th data-field="nTotalPedidosTransferencia" data-sortable="true" data-visible="false">Transferencia</th>
                                                            <th data-field="nTotalPedidosEfectivo" data-sortable="true" data-visible="false">Efectivo</th>
                                                            <th data-field="nTotalPedidosYape" data-sortable="true" data-visible="false">Yape</th>


                                                            <th data-field="nTotalPedidosParcial" data-sortable="true" data-visible="false" >Parcial</th>
                                                            <th data-field="nTotalPedidosContado" data-sortable="true" data-visible="false" >Contado</th>

                                                            <th data-field="nTotalPedidos" data-sortable="true">Total ventas</th>
                                                            <th data-field="nSaldoCaja" data-sortable="true">Saldo caja</th>

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

    <div class="modal fade" id="formCECajaDiaria" tabindex="-1" role="dialog" aria-labelledby="formCELoteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCELoteLabel">Nuevo Caja</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="nIdCaja" class="col-form-label">Caja <span class="text-danger">*</span></label>
                                     <select class="form-control" name="nIdCaja" id="nIdCaja">
                                        <option value="0">Seleccionar</option>
                                        <?php if(fncValidateArray($aryCajas)) : ?>
                                            <?php foreach ($aryCajas as $nKey => $aryItem) : ?>
                                                <option data-nidempleado="<?=$aryItem["nIdEmpleado"]?>" value="<?=$aryItem["nIdCaja"]?>"><?=$aryItem["sDescripcion"]?></option>
                                            <?php endforeach  ?>
                                        <?php  endif ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                     <label for="nIdEmpleado" class="col-form-label">Empleado <span class="text-danger">*</span></label>
                                     <select class="form-control" name="nIdEmpleado" id="nIdEmpleado">
                                        <option value="0">Seleccionar</option>
                                        <?php if(fncValidateArray($aryEmpleados)) : ?>
                                            <?php foreach ($aryEmpleados as $nKey => $aryItem) : ?>
                                                <option value="<?=$aryItem["nIdEmpleado"]?>"><?=$aryItem["sNombre"]?></option>
                                            <?php endforeach  ?>
                                        <?php  endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstado" class="col-form-label">Monto Apertura</label>
                                    <input type="number" class="form-control" min="0.00" max="9999999.999999" step="0.000001" name="nMontoApertura" id="nMontoApertura">
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstado" class="col-form-label">Monto Deposito</label>
                                    <input type="number" class="form-control"  min="0.00" max="9999999.999999" step="0.000001" name="nMontoDeposito" id="nMontoDeposito">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="nEstado" class="col-form-label">Monto Salidas</label>
                                    <input type="number" class="form-control"  min="0.00" max="9999999.999999" step="0.000001" name="nMontoSalidas" id="nMontoSalidas">
                                </div>
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

    
    <div class="modal fade" id="formCEReporteCaja" tabindex="-1" role="dialog" aria-labelledby="formCEReporteCajaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCEReporteCajaLabel">Reporte Caja</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12  border-all-light">
                                <div>
                                    <h6 class="mb-1">Caja </h6>
                                    <span id="sCaja"></span>
                                 </div>
                            </div>


                            <div class="col-12 col-md-4  border-all-light">
                                <div>
                                    <h6 class="mb-1">Apertura </h6>
                                    <span id="dFechaHoraApertura"></span>
                                 </div>
                            </div>

                            <div class="col-12 col-md-4  border-all-light">
                                <div>
                                    <h6 class="mb-1">Cierre </h6>
                                    <span id="dFechaCierre"></span>
                                 </div>
                            </div>


                            <div class="col-12 col-md-4  border-all-light">
                                <div>
                                    <h6 class="mb-1">Responsable </h6>
                                    <span id="sEmpleado"></span>
                                 </div>
                            </div>

                         </div>

                        <div class="row text-center my-2">
                            <div class="col-12 col-md-6 border-all-light">
                                <div>
                                    <h6 class="mb-1">Ingresos</h6>
                                    <div id="sIngresos"  class="font-12">
                                        
                                    </div>
                                 </div>
                            </div>

                            <div class="col-12 col-md-6 border-all-light">
                                <div>
                                    <h6 class="mb-1">Egresos</h6>
                                    <div id="sEgresos" class="font-12">
                                        
                                    </div>
                                 </div>
                            </div>
                        </div>

                        <div class="row text-center my-2">
                            <div class="col-4 col-md-4 border-all-light">
                                <div>
                                    <h6 class="mb-1">Saldo Banco</h6>
                                    <div id="sSaldoBanco"  class="font-12">
                                        
                                    </div>
                                 </div>
                            </div>
							<div class="col-4 col-md-4 border-all-light">
                                <div>
                                    <h6 class="mb-1">Saldo Caja</h6>
                                    <div id="sSaldoEfectivo"  class="font-12">
                                        
                                    </div>
                                 </div>
                            </div>
							<div class="col-4 col-md-4 border-all-light">
                                <div>
                                    <h6 class="mb-1">Saldo Total</h6>
                                    <div id="sSaldoCaja"  class="font-12">
                                        
                                    </div>
                                 </div>
                            </div>

                        </div>


                    </div>                       
                    <div class="modal-footer">
                    </div>
               
            </div>
        </div>
    </div>


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

<script>
    window.bFilterTable  = false;
    $(function() {

        fncValidarRol();

        // Formulario Clientes
        $("#btnCrearCajaDiaria").on('click', function() {
            fncCleanAll();
            $("#formCECajaDiaria").find(".modal-title").html('Aperturar Caja');
            $("#formCECajaDiaria").data("nIdRegistro",0);
            $("#formCECajaDiaria").modal("show");
        });

        // Submit del formulario de Cliente
        $("#formCECajaDiaria").find("form").on('submit',function(event){
           
             event.preventDefault();

            var nIdRegistro           = $("#formCECajaDiaria").data("nIdRegistro");
 
            var nIdCaja               = $("#nIdCaja").val();
            var nIdEmpleado           = $("#nIdEmpleado").val();
            var nMontoApertura        = $("#nMontoApertura").val();
            var nMontoDeposito        = $("#nMontoDeposito").val();
            var nMontoSalidas         = $("#nMontoSalidas").val();

 
            if (nIdCaja == '0') {
                toastr.error('Error. Debe seleccionar una caja para aperturar el dia . Porfavor verifique');
                return;
            } else if (nIdEmpleado == '0') {
                toastr.error('Error.Debe seleccionar un empleado encargado de la caja. Porfavor verifique');
                return;
            } 

             var jsnData = {
                nIdRegistro        : nIdRegistro,
                nIdCaja            : nIdCaja,
                nIdEmpleado        : nIdEmpleado, 
                nMontoApertura     : nMontoApertura == '' ? 0 : nMontoApertura,
                nMontoDeposito     : nMontoDeposito == '' ? 0 : nMontoDeposito,
                nMontoSalidas      : nMontoSalidas == '' ? 0 : nMontoSalidas,
                nEstado            : 1
             };

             fncGrabarCajaDiaria(jsnData, function(aryData){
                 if(aryData.success){
                     fncCleanAll();
                     $("#formCECajaDiaria").modal("hide");
                     $("#tblPrincipal").bootstrapTable('refresh');
                     toastr.success(aryData.success);
                 } else {
                     toastr.error(aryData.error);
                 }
             });

        });

        $("#nIdCaja").on("change",function(){

            if($(this).val() == '0'){
                return;
            }
            if($("body").data("nadmin") == 1){
                var nIdEmpleado = $(this).find("option:selected").data("nidempleado");
                $("#nIdEmpleado").val(nIdEmpleado);        
            }
        })

        $('#tblPrincipal').on('refresh.bs.table', function (e) {
            bFilterTable = false;
            fncClearFilterM();
        });
    });


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            //$("#btnCrearCajaDiaria").hide();
        }
    }

    // Funciones de la tabla o layout Principal 

    function fncCambiarEstadoCaja(nIdRegistro , nNuevoEstado) {

        var sMsg = nNuevoEstado == 1 ? 'Esta acción va a aperturar la caja . ¿ Esta seguro de continuar ?' : 'Esta acción va a cerrar la caja . ¿ Esta seguro de continuar ?' ; 
        fncMsg(1, sMsg , function(){

            var jsnData = {
                nIdRegistro : nIdRegistro,
                nEstado     : nNuevoEstado
            };

            fncCambiarEstadoCajaDiaria( jsnData , function(aryData){

                if(aryData.success){
                    if(bFilterTable){
                        $("#formFilter").find("form").trigger("submit");
                    }else{
                        $("#tblPrincipal").bootstrapTable('refresh');

                    }
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });
 
    }

    function fncMostrarCajaDiaria(nIdRegistro , sOpcion ) {

        $( "#formCECajaDiaria" ).data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroCajaDiaria(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryData = aryResponse.aryData;

                    $("#nIdCaja").val(aryData.nIdCaja);
                    $("#nIdEmpleado").val(aryData.nIdEmpleado);
                    $("#nMontoApertura").val(aryData.nMontoApertura);
                    $("#nMontoDeposito").val(aryData.nMontoDeposito);
                    $("#nMontoSalidas").val(aryData.nMontoSalidas);

                    if(sOpcion == 'editar'){
                        fncEditForm("#formCECajaDiaria" , "Editar Caja Diaria");
                    } else {
                        fncViewForm("#formCECajaDiaria" , "Ver Caja Diaria");
                    }

                    $("#formCECajaDiaria").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    function fncEliminarCajaDiaria(nIdRegistro) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             

            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarCajaDiaria( jsnData , function(aryData){

                if(aryData.success){
                    if(bFilterTable){
                        $("#formFilter").find("form").trigger("submit");
                    }else{
                        $("#tblPrincipal").bootstrapTable('refresh');
                    }
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 


        });
 
    }

    function fncReporteCaja(nIdRegistro) {

        var jsnRow = $("#tblPrincipal").bootstrapTable("getRowByUniqueId" , nIdRegistro);
        console.log(jsnRow);

        $("#sCaja").html(jsnRow.sCaja);
        $("#dFechaHoraApertura").html(jsnRow.dFechaHoraApertura);
        $("#dFechaCierre").html( jsnRow.dFechaCierre != ''? jsnRow.dFechaCierre : 'PENDIENTE');
        $("#sEmpleado").html(jsnRow.sEmpleado);

        var nTotalIngresos= parseFloat( jsnRow.nMontoApertura ) +  parseFloat( jsnRow.nMontoDeposito )  +  parseFloat( jsnRow.nTotalPedidos );

        var sIngresos = `
            <div class="row"><div class="col-12 col-md-6">EFECTIVO</div><div class="col-12 col-md-6">${jsnRow.nTotalPedidosEfectivo}</div></div>
            <div class="row"><div class="col-12 col-md-6">TARJETA</div><div class="col-12 col-md-6">${jsnRow.nTotalPedidosTarjeta}</div></div>
            <div class="row"><div class="col-12 col-md-6">TRANSFERENCIA</div><div class="col-12 col-md-6">${jsnRow.nTotalPedidosTransferencia}</div></div>
            <div class="row"><div class="col-12 col-md-6">YAPE</div><div class="col-12 col-md-6">${jsnRow.nTotalPedidosYape}</div></div>
            <div class="row"><div class="col-12 col-md-12"> ******************************** </div> </div>

            <div class="row"><div class="col-12 col-md-6">TOTAL</div><div class="col-12 col-md-6">${jsnRow.nTotalPedidos}</div></div>

            <br>
            <div class="row"><div class="col-12 col-md-6">PARCIALES</div><div class="col-12 col-md-6">${jsnRow.nTotalPedidosParcial}</div></div>
            <div class="row"><div class="col-12 col-md-6">CONTADO </div><div class="col-12 col-md-6">${jsnRow.nTotalPedidosContado}</div></div>
            <div class="row"><div class="col-12 col-md-12"> ******************************** </div> </div>
            <div class="row"><div class="col-12 col-md-6">TOTAL</div><div class="col-12 col-md-6">${jsnRow.nTotalPedidos}</div></div>

            <br>

            <div class="row"><div class="col-12 col-md-6">APERTURA </div><div class="col-12 col-md-6">${jsnRow.nMontoApertura}</div></div>
            <div class="row"><div class="col-12 col-md-6">DEPOSITO </div><div class="col-12 col-md-6">${jsnRow.nMontoDeposito}</div></div>
            <div class="row"><div class="col-12 col-md-6">TOTAL VENTAS </div><div class="col-12 col-md-6">${jsnRow.nTotalPedidos}</div></div>
            <div class="row"><div class="col-12 col-md-12"> ******************************** </div> </div>
            <div class="row"><div class="col-12 col-md-6">TOTAL INGRESOS</div><div class="col-12 col-md-6">${nTotalIngresos.toFixed(2)}</div></div>

        `;


        var nTotalEgresos = parseFloat( jsnRow.nMontoSalidas ) +  parseFloat( jsnRow.nTotalOCG );

        var sEgresos = `
            <div class="row"><div class="col-12 col-md-6">MONTO SALIDA</div><div class="col-12 col-md-6">${jsnRow.nMontoSalidas}</div></div>
            <div class="row"><div class="col-12 col-md-6">GASTOS / COMPRAS </div><div class="col-12 col-md-6">${jsnRow.nTotalOCG}</div></div>
            <div class="row"><div class="col-12 col-md-12"> ******************************** </div> </div>
            <div class="row"><div class="col-12 col-md-6">TOTAL EGRESOS</div><div class="col-12 col-md-6">${nTotalEgresos.toFixed(2)}</div></div>
        `;

        $("#sIngresos").html(sIngresos);
        $("#sEgresos").html(sEgresos);
        $("#sSaldoCaja").html(jsnRow.nSaldoCaja);
    
		// suma totales
		$("#sSaldoBanco").html(parseFloat(jsnRow.nTotalPedidos) - parseFloat(jsnRow.nTotalPedidosEfectivo) );
		$("#sSaldoEfectivo").html(parseFloat(jsnRow.nTotalPedidosEfectivo)+ parseFloat(jsnRow.nMontoApertura ));
		$("#formCEReporteCaja").modal("show");
    }


    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCECajaDiaria").find("form") );
        fncClearInputs( $("#formCECajaDiaria").find("form") );
     }

   

    // Llamadas al servidor


    // Cliente 

    function fncGrabarCajaDiaria(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cajas/fncGrabarCajaDiaria',
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

    function fncBuscarRegistroCajaDiaria(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'cajas/fncMostrarCajaDiaria',
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

    function fncCambiarEstadoCajaDiaria(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'cajas/fncCambiarEstadoCajaDiaria',
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

    function fncEjecutarEliminarCajaDiaria(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'cajas/fncEliminarCajaDiaria',
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


<!-- Filtros  -->
<script>
    $(function() {

   
        $("#formFilter").find("form").on('submit', function(event) {
            event.preventDefault();

            var aryIdCajas        = $("#aryIdCajas").val();
            var dFechaInicio      = $('#dFechaInicio').datepicker('getDate');
            var dFechaFin         = $('#dFechaFin').datepicker('getDate');
  

            if( $("#dFechaInicio").val() == ''){
                toastr.error('Error.Debe de ingresar una fecha de inicio. Por favor verificar.');
                return;
            }

            if( $("#dFechaFin").val() == ''){
                toastr.error('Error.Debe de ingresar una fecha fin. Por favor verificar.');
                return;
            }


            if ((dFechaInicio != null && dFechaFin == null) || (dFechaInicio == null && dFechaFin != null)) {
                toastr.error('Error. Si va a especificar fechas, debe ingresar la de alta y inicio. Por favor verificar.');
                return;
            }

            if (dFechaFin < dFechaInicio) {
                toastr.error('Error. La fecha de fin debe ser mayor o igual que la fecha de inicio. Por favor verificar.');
                return;
            }
         

            var jsnData = {
                aryIdCajas       : aryIdCajas,
                dFechaInicio     : $("#dFechaInicio").val(),
                dFechaFin        : $("#dFechaFin").val(),
             };

             fncPopulateCajaDiaria(jsnData, function(aryData) {
                bFilterTable  = true;
                $("#tblPrincipal").bootstrapTable("load", aryData);
                $("#formFilter").modal("hide");
            });

        });

        $("#btnFilter").on("click",function(){
            $("#formFilter").modal("show");
        });


        // // Cargar por defecto de hoy a 7 dias 
        $("#dFechaInicio").val(moment().day(-5).format('DD/MM/YYYY'));
        $("#dFechaFin").val(moment().format('DD/MM/YYYY'));
        $("#formFilter").find("form").trigger("submit");
    });

    window.fncClearFilterM = () => {
        
         fncClearInputs(  $("#formFilter").find("form") );
  
    }

    // Llamadas al servidor
    function fncPopulateCajaDiaria(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'cajas/fncPopulateCajaDiaria',
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
<!-- Filtros -->

</html>