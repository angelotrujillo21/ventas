<!DOCTYPE html>

<html class="no-js h-100" lang="es">



<head>

    <?php extend_view(['admin/common/head'], $data) ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

</head>



<body data-nadmin="<?= $nAdmin ?>">



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

                                                        <button id="btnCrearMV" class="btn btn-gradient-primary btn-rounded btn-icon">

                                                            <i class="fas fa-plus-circle"></i>

                                                        </button>

                                                    </div>



                                                </div>

                                            </div>

                                        </div>





                                        <div id="toolbar" class="btn-group row">

                                            <div class="col-md-12 sin-padding container-buttons-table">

                                                <button id="btnFilter" class="btn btn-gradient-primary-table" type="button" title="Filtrar">

                                                    <i class="fas fa-filter"></i>

                                                </button>

                                            </div>

                                        </div>



                                        <!-- Fin de Fila Cabecera -->



                                        <div class="row my-2">

                                            <div class="col-12">

                                                <table data-toggle="table" id="tblPrincipal" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="false" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">

                                                    <thead>

                                                        <tr>

                                                            <th data-field="sAcciones">Acciones</th>

                                                            <th data-field="sCuentaCorriente" data-sortable="true">Cuenta corriente</th>

                                                            <th data-field="sDescripcion" data-sortable="true">Descripcion </th>

                                                            <th data-field="dFechaRegistro" data-sortable="true">Fecha de registro</th>

                                                            <th data-field="sTipo" data-sortable="true">Tipo</th>

                                                            <th data-field="nMonto" data-sortable="true">Monto</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>



                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div> <span class="font-weight-bold"> Saldo Anterior <span id="sMesesRango"></span> </span> : <span id="nSaldoAnteriorMesCurso"></span> </div>

                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-12">
                                                        <div> <span class="font-weight-bold">Totales Mes Consultado ( <span id="sMesConsultado"></span> ): </span> </div>
                                                    </div>
                                                </div>

                                                <div class="row col-12">

                                                    <div class="col-md-4 mb-2">

                                                        <span title="Ingresos" class="font-weight-bold">Debe</span>

                                                        <span id="nIngresos">0.00</span>

                                                    </div>

                                                    <div class="col-md-4 mb-2">

                                                        <span title="Egresos" class="font-weight-bold">Haber</span>

                                                        <span id="nSalidas">0.00</span>

                                                    </div>

                                                    <div class="col-md-4 mb-2">

                                                        <span class="font-weight-bold">Saldo Actual</span>

                                                        <span id="nSaldoActual">0.00</span>

                                                    </div>

                                                </div>


                                                <div class="row">
                                                    <div class="col-12">
                                                        <div> <span class="font-weight-bold">Saldo Actual Total: </span> <span id="nSaldoActualTotal"></span> </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div> <span class="font-weight-bold"> Grafico Meses</div>
                                                <canvas id="grafica"></canvas>
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



    <div class="modal fade" id="formCEMV" tabindex="-1" role="dialog" aria-labelledby="formCELCCLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <form>

                    <div class="modal-header">

                        <h5 class="modal-title" id="formCELCCLabel">Nuevo Movimiento</h5>

                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                    <div class="modal-body">



                        <div class="row">



                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="nIdCuentaCorriente" class="col-form-label">Cuenta Corriente <span class="text-danger">*</span></label>

                                    <select class="form-control" name="nIdCuentaCorriente" id="nIdCuentaCorriente">

                                        <option value="0">SELECCIONAR</option>

                                        <?php if (fncValidateArray($aryCuentasCorrientes)) : ?>

                                            <?php foreach ($aryCuentasCorrientes as $aryLoop) : ?>

                                                <option value="<?= $aryLoop["nIdCuentaCorriente"] ?>">

                                                    <?= $aryLoop["sBanco"] . " | " . $aryLoop["sTipoCuenta"] . " | " . $aryLoop["sNumero"] ?>

                                                </option>

                                            <?php endforeach ?>

                                        <?php endif ?>

                                    </select>

                                </div>

                            </div>





                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="nTipoMovimiento" class="col-form-label">Tipo de moviento <span class="text-danger">*</span> </label>

                                    <select class="form-control" name="nTipoMovimiento" id="nTipoMovimiento">

                                        <option value="0">SELECCIONAR</option>

                                        <option title="Ingreso" value="1">DEBE</option>

                                        <option title="Salida" value="2">HABER</option>

                                    </select>

                                </div>

                            </div>





                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="nMonto" class="col-form-label">Monto <span class="text-danger">*</span></label>

                                    <input type="number" min="0.00" max="9999999.99" step="0.01" value="0.00" autocomplete="off" class="form-control" name="nMonto" id="nMonto">

                                </div>

                            </div>



                            <div class="col-12 col-md-6">

                                <div class="form-group">

                                    <label for="nEstado" class="col-form-label">Estado</label>

                                    <select class="form-control" name="nEstado" id="nEstado">

                                        <option value="1">ACTIVO</option>

                                        <option value="0">DESACTIVO</option>

                                    </select>

                                </div>

                            </div>



                            <div class="col-12 col-md-12">

                                <div class="form-group">

                                    <label for="sDescripcion" class="col-form-label">Descripcion</label>

                                    <textarea class="form-control" name="sDescripcion" id="sDescripcion"></textarea>

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



                            <div class="col-12 col-md-12">

                                <div class="form-group">

                                    <label for="nIdCuentaCorrienteFilter" class="col-form-label">Cuenta Corriente</label>

                                    <select class="form-control" name="nIdCuentaCorrienteFilter" id="nIdCuentaCorrienteFilter">

                                        <option value="0">SELECCIONAR</option>

                                        <?php if (fncValidateArray($aryCuentasCorrientes)) : ?>

                                            <?php foreach ($aryCuentasCorrientes as $aryLoop) : ?>

                                                <option value="<?= $aryLoop["nIdCuentaCorriente"] ?>">

                                                    <?= $aryLoop["sBanco"] . " | " . $aryLoop["sTipoCuenta"] . " | " . $aryLoop["sNumero"] ?>

                                                </option>

                                            <?php endforeach ?>

                                        <?php endif ?>

                                    </select>

                                </div>

                            </div>







                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label for="nAnhioFilter" class="col-form-label">Año:</label>
                                    <input class="form-control"  type="text" name="nAnhioFilter" id="nAnhioFilter">
                                </div>
                            </div>





                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label for="nMesFilter" class="col-form-label">Mes:</label>
                                    <select class="form-control" name="nMesFilter" id="nMesFilter">
                                        <option value="1">ENERO</option>
                                        <option value="2">FEBRERO</option>
                                        <option value="3">MARZO</option>
                                        <option value="4">ABRIL</option>
                                        <option value="5">MAYO</option>
                                        <option value="6">JUNIO</option>
                                        <option value="7">JULIO</option>
                                        <option value="8">AGOSTO</option>
                                        <option value="9">SEPTIEMBRE</option>
                                        <option value="10">OCTUBRE</option>
                                        <option value="11">NOVIEMBRE</option>
                                        <option value="12">DICIEMBRE</option>
                                    </select>
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
    $(function() {



        fncValidarRol();



        // Formulario Clientes

        $("#btnCrearMV").on('click', function() {

            fncCleanAll();

            $("#formCEMV").find(".modal-title").html('Nueva Movimiento');

            $("#formCEMV").data("nIdRegistro", 0);

            $("#formCEMV").modal("show");

        });



        // Submit del formulario de banco

        $("#formCEMV").find("form").on('submit', function(event) {



            event.preventDefault();



            var nIdRegistro = $("#formCEMV").data("nIdRegistro");

            var nIdCuentaCorriente = $("#nIdCuentaCorriente").val();

            var nTipo = $("#nTipoMovimiento").val();

            var nMonto = $("#nMonto").val();

            var sDescripcion = $("#sDescripcion").val().trim().toUpperCase();

            var nEstado = $("#nEstado").val();



            if (nIdCuentaCorriente == '0') {

                toastr.error('Error. Debe de seleccionar una cuenta corriente.Porfavor verifique');

                return false;

            }



            if (nTipo == '0') {

                toastr.error('Error. Debe de seleccionar un tipo de movimiento.Porfavor verifique');

                return false;

            }



            if (nMonto == '' || isNaN(nMonto) || nMonto <= 0) {

                toastr.error('Error. Debe de ingresar un monto de forma correcta.Porfavor verifique');

                return false;

            }



            var jsnData = {

                nIdRegistro: nIdRegistro,

                nIdCuentaCorriente: nIdCuentaCorriente,

                nTipo: nTipo,

                nMonto: nMonto,

                sDescripcion: sDescripcion,

                nEstado: nEstado,

                nTipoMoneda: '<?= $arySede["nTipoMoneda"] ?>'

            };



            fncGrabarMT(jsnData, function(aryData) {

                if (aryData.success) {

                    fncCleanAll();

                    $("#formCEMV").modal("hide");

                    $("#formFilter").find("form").trigger("submit");

                    toastr.success(aryData.success);

                } else {

                    toastr.error(aryData.error);

                }

            });



        });



    });





    function fncValidarRol() {

        if ($("body").data("nadmin") == 1) {

            // es admin

        } else {

            $("#btnCrearMV").hide();

        }

    }



    // Funciones de la tabla o layout Principal 



    function fncEliminarMT(nIdRegistro) {



        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?',

            function() {



                var jsnData = {

                    nIdRegistro: nIdRegistro

                };



                fncEjecutarEliminar(jsnData, function(aryData) {



                    if (aryData.success) {

                        $("#formFilter").find("form").trigger('submit');

                        toastr.success(aryData.success);

                    } else {

                        toastr.error(aryData.error);

                    }



                });





            });



    }



    function fncMostrarMT(nIdRegistro, sOpcion) {



        $("#formCEMV").data("nIdRegistro", nIdRegistro);

        $("#nSaldoActual").prop("readonly", true);



        var jsnData = {

            nIdRegistro: nIdRegistro

        };



        fncBuscarRegistroCC(jsnData, function(aryResponse) {



            if (aryResponse.success) {



                var aryData = aryResponse.aryData;



                $("#nIdCuentaCorriente").val(aryData.nIdCuentaCorriente);

                $("#nTipoMovimiento").val(aryData.nTipo);

                $("#nMonto").val(aryData.nMonto);

                $("#nEstado").val(aryData.nEstado);

                $("#sDescripcion").val(aryData.sDescripcion);





                if (sOpcion == 'editar') {

                    fncEditForm("#formCEMV", "Editar Movimiento");

                } else {

                    fncViewForm("#formCEMV", "Ver Movimiento");

                }



                $("#formCEMV").modal("show");



            } else {

                toastr.error(aryData.error);

            }

        });



    }



    // Funciones Auxiliares

    function fncCleanAll() {

        fncRemoveDisabled($("#formCEMV").find("form"));

        fncClearInputs($("#formCEMV").find("form"));

    }







    // Llamadas al servidor

    function fncGrabarMT(jsnData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'movimientosTesoreria/fncGrabarMT',

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



    function fncBuscarRegistroCC(jsnData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'movimientosTesoreria/fncMostrarRegistro',

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



    function fncEjecutarEliminar(jsnData, fncCallback) {

        $.ajax({

            type: 'post',

            url: web_root + 'movimientosTesoreria/fncEliminarRegistro',

            data: jsnData,

            dataType: 'json',

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

<script>
    $(function() {



        $("#formFilter").find("form").on('submit', function(event) {



            event.preventDefault();



            var nIdCuentaCorriente = $('#nIdCuentaCorrienteFilter').val();

            var nAnhio = $('#nAnhioFilter').val();

            var nMes = $('#nMesFilter').val();


            if (nIdCuentaCorriente == 0) {

                toastr.error('Error. Debe de seleccionar una cuenta corriente . Por favor verificar.');

                return;

            }



            window.jsnDataFiltro = {

                nIdCuentaCorriente: nIdCuentaCorriente,
                nAnhio: nAnhio,
                nMes: nMes
            };



            fncPopulate(window.jsnDataFiltro, function(aryData) {

                $('#tblPrincipal').bootstrapTable('load', aryData.data);

                $("#nSaldoAnteriorMesCurso").html(aryData.aryDataExtra.nSaldoAnteriorMesCurso);
                $("#sMesesRango").html(aryData.aryDataExtra.sMesesDiff);
                $("#sMesConsultado").html(aryData.aryDataExtra.sMesConsultado);



                $("#nIngresos").html(aryData.aryDataExtra.aryTotalesMesCurso.sIngresos);
                $("#nSalidas").html(aryData.aryDataExtra.aryTotalesMesCurso.sSalidas);
                $("#nSaldoActual").html(aryData.aryDataExtra.aryTotalesMesCurso.sSaldoActual);
                $("#nSaldoActualTotal").html(aryData.aryDataExtra.nSaldoActualTotal);


                $("#formFilter").modal("hide");

                fncDrawChart(aryData.aryDataExtra.aryDataMeses);

                bFilterTable = true;

            });



        });



        $("#btnFilter").on("click", function() {

            $('#nAnhioFilter').val('<?=date("Y")?>');
            $('#nMesFilter').val('<?= intval(date("m"))?>').trigger("change");
            $("#formFilter").modal("show");

        });



    });



    function fncClearFilter() {

        fncClearInputs($("#formFilter").find("form"));

    }



    // Llamadas al servidor

    function fncPopulate(formData, fncCallback) {

        $.ajax({

            type: 'post',

            dataType: 'json',

            url: web_root + 'movimientosTesoreria/fncPopulate',

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

<!-- Grafico -->
<script>
    var chart1;

    function fncCleanControls() {
        if (chart1 != undefined) chart1.destroy();
    }

    function fncDrawChart(aryDataMeses) {

        // console.log(aryDataMeses);
        // return;

        // Las etiquetas son las que van en el eje X. 
        var aryMeses = [];

        //Eje Y 
        var aryIngresos = [];
        var arySalidas = [];
        var arySaldos = [];

        aryDataMeses.forEach(element => {
            aryMeses.push( parseInt(element.nMes) <= 9 ?'0' + element.nMes: element.nMes   );
            aryIngresos.push(parseFloat(element.nIngresos).toFixed(2));
            arySalidas.push(parseFloat(element.nSalidas).toFixed(2));
            arySaldos.push(parseFloat(element.nSaldoActual).toFixed(2));
        });


        // Podemos tener varios conjuntos de datos. Comencemos con uno
        var objIngresos = {
            label: "Ingresos",
            data: aryIngresos, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
            backgroundColor: 'rgba(100, 255, 135, 0.2)', // Color de fondo
            borderColor: 'rgba(100, 255, 135, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        };

        var objSalidas = {
            label: "Salidas",
            data: arySalidas, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
            backgroundColor: 'rgba(255, 74, 74, 0.2)', // Color de fondo
            borderColor: 'rgba(255, 74, 74, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        };

        var objSaldo = {
            label: "Saldo",
            data: arySaldos, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
            borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
        };

        var config = {
            type: 'bar', // Tipo de gráfica
            data: {
                labels: aryMeses,
                datasets: [
                    objIngresos,
                    objSalidas,
                    objSaldo,
                    // Aquí más datos...
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
            }
        }


        var ctx = document.getElementById("grafica").getContext("2d");
        if (chart1 != undefined) chart1.destroy();
        chart1 = new Chart(ctx, config);
    }
</script>


</html>