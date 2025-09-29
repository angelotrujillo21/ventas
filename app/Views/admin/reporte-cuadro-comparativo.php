<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

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

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <form id="formFilter">                   
                                            <div class="row border-alll-light">

                                            
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="dRangoFechas" class="col-form-label">Rango de fechas:</label>
                                                        <input type="text" class="form-control daterange" id="dRangoFechas" autocomplete="off" name="dRangoFechas">
                                                    </div>
                                                </div>

                                            
                                                <div class="col-12 col-md-1">
                                                    <div class="form-group">
                                                        <label for="" class="col-form-label d-none d-md-block">&nbsp;</label>
                                                        <button id="btnProcesarFiltros" class="btn btn-gradient-primary-table" type="submit" title="Filtrar">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>

                                        <div class="row my-2">
                                            <div class="col-12 offset-0 offset-md-3 col-md-6">
                                                <table class="table table-bordered">

                                                    <tr>
                                                        <td id="sTituloGastos" class="text-center bg-header-table font-weight-bold" colspan="2">
                                                            CUADRO COMPARATIVO
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center bg-header-table font-weight-bold">TOTAL GASTOS</td>
                                                        <td class="text-center" id="nTotalGastos">0.00</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center bg-header-table font-weight-bold">TOTAL PEDIDOS</td>
                                                        <td class="text-center" id="nTotalPedidos">0.00</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center bg-header-table font-weight-bold">DIFERENCIA DE VENTAS</td>
                                                        <td class="text-center" id="nDiferencia">0.00</td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </main>
        </div>
    </div>



    <!-- Modales -->


    <!-- Fin de modales -->





    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>

<!--Reporte cuadro comparativo -->
<script>
    $(function() {
        fncValidarRol();

        $("#formFilter").on('submit', function(event) {

            event.preventDefault();

        
            var dFechaInicio   = $('#dRangoFechas').val() == '' ? null : $('#dRangoFechas').data('daterangepicker').startDate.format('DD/MM/YYYY');
            var dFechaFin      = $('#dRangoFechas').val() == '' ? null : $('#dRangoFechas').data('daterangepicker').endDate.format('DD/MM/YYYY');

            window.jsnDataRG  = {              
                dFechaInicio    : dFechaInicio,
                dFechaFin       : dFechaFin,
            };

            fncPopulate(window.jsnDataRG , function(aryData) {
                bFilterTable  = true;                
                $("#sTituloG").html(aryData.sTitulo);
                $("#tableGeneral").bootstrapTable("load",aryData.aryRowForDT);
            });

        });



    });

    function fncValidarRol() {
        if ($("body").data("nadmin") == 1) {
            // es admin
        } else {

        }
    }

    // Funciones de la tabla o layout Principal 



    // Funciones Auxiliares
    window.fncCleanAll = () => {


    }


    
    function fncCalcularComparacionComprasPedidos(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'pedidos/fncCalcularComparacionComprasPedidos',
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


    // Llamadas al servidor
</script>
<!--Reporte cuadro comparativo -->






</html>