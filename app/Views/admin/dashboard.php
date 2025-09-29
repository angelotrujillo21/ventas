<!DOCTYPE html>

<html class="no-js h-100" lang="es">



<head>

    <?php extend_view(['admin/common/head'], $data) ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

</head>



<body data-nadmin = "<?= $nAdmin ?>"  

      data-nidempresa = "<?=$user["nIdEmpresa"]?>"

      data-nidsede = "<?=$user["nIdSede"]?>"

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



                                        <div class="row">

                                            <div class="col-12 py-4">



                                                <form id="formFilter">

                                                    <div class="row border-alll-light">



                                                        <div class="col-12 col-md-2 flex-center">

                                                            <h5><?= $sTitulo ?></h5>



                                                        </div>



                                                 

                                                        



                                                        <div class="col-12 col-md-2">

                                                            <div class="form-group">

                                                                <label for="dFechaInicio" class="col-form-label">Desde:</label>

                                                                <input type="text" class="form-control datepicker" id="dFechaInicio" autocomplete="off" name="dFechaInicio">

                                                            </div>

                                                        </div>





                                                        <div class="col-12 col-md-2">

                                                            <div class="form-group">

                                                                <label for="dFechaFin" class="col-form-label">Hasta:</label>

                                                                <input type="text" class="form-control datepicker" id="dFechaFin" autocomplete="off" name="dFechaFin">

                                                            </div>

                                                        </div>





                                                        <div class="col-12 col-md-1">

                                                            <div class="form-group">

                                                                <label for="" class="col-form-label d-none d-md-block">&nbsp;</label>

                                                                <button class="btn btn-gradient-primary-table" type="submit" title="Filtrar">

                                                                    <i class="fas fa-search"></i>

                                                                </button>

                                                            </div>

                                                        </div>



                                                    </div>

                                                </form>



                                            </div>

                                        </div>





                                        <div class="row">

                                            <div class="col-lg col-md-6 col-sm-6 mb-4">

                                                <div class="stats-small stats-small--1 card card-small">

                                                    <div class="card-body p-0 d-flex">



                                                        <div class="d-flex flex-column m-auto">

                                                            <div class="stats-small__data text-center">

                                                                <span class="stats-small__label text-uppercase" id="sTitleC1">NUEVOS CLIENTES</span>

                                                                <h6 class="stats-small__value count my-3" id="sValorC1">0.00</h6>

                                                            </div>

                                                            <div class="stats-small__data">

                                                                <span id="sValorSubC1" class="stats-small__percentage stats-small__percentage--increase"></span>

                                                            </div>

                                                        </div>

                                                        <canvas height="64" class="blog-overview-stats-small-1 chartjs-render-monitor" width="160"></canvas>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-lg col-md-6 col-sm-6 mb-4">

                                                <div class="stats-small stats-small--1 card card-small">

                                                    <div class="card-body p-0 d-flex">



                                                        <div class="d-flex flex-column m-auto">

                                                            <div class="stats-small__data text-center">

                                                                <span class="stats-small__label text-uppercase" id="sTitleC2">CANTIDAD VENTAS</span>

                                                                <h6 class="stats-small__value count my-3" id="sValorC2"> 0.00</h6>

                                                            </div>

                                                            <!-- <div class="stats-small__data">

                                                                <span class="stats-small__percentage stats-small__percentage--increase"></span>

                                                            </div> -->

                                                        </div>

                                                        <canvas height="64" class="blog-overview-stats-small-2 chartjs-render-monitor" width="160"></canvas>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-lg col-md-4 col-sm-6 mb-4">

                                                <div class="stats-small stats-small--1 card card-small">

                                                    <div class="card-body p-0 d-flex">



                                                        <div class="d-flex flex-column m-auto">

                                                            <div class="stats-small__data text-center">

                                                                <span class="stats-small__label text-uppercase" id="sTitleC3">TOTAL VENTAS</span>

                                                                <h6 class="stats-small__value count my-3" id="sValorC3"> S./ 0.00</h6>

                                                            </div>

                                                            <!-- <div class="stats-small__data">

                                                                <span class="stats-small__percentage stats-small__percentage--increase"></span>

                                                            </div> -->

                                                        </div>

                                                        <canvas height="64" class="blog-overview-stats-small-3 chartjs-render-monitor" width="160"></canvas>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-lg col-md-4 col-sm-6 mb-4">

                                                <div class="stats-small stats-small--1 card card-small">

                                                    <div class="card-body p-0 d-flex">



                                                        <div class="d-flex flex-column m-auto">

                                                            <div class="stats-small__data text-center">

                                                                <span class="stats-small__label text-uppercase" id="sTitleC4">TOTAL ORD.COMPRAS</span>

                                                                <h6 class="stats-small__value count my-3" id="sValorC4"> S./ 0.00</h6>

                                                            </div>

                                                            <!-- <div class="stats-small__data">

                                                                <span class="stats-small__percentage stats-small__percentage--increase"></span>

                                                            </div> -->

                                                        </div>

                                                        <canvas height="64" class="blog-overview-stats-small-4 chartjs-render-monitor" width="160"></canvas>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-lg col-md-4 col-sm-6 mb-4">

                                                <div class="stats-small stats-small--1 card card-small">

                                                    <div class="card-body p-0 d-flex">



                                                        <div class="d-flex flex-column m-auto">

                                                            <div class="stats-small__data text-center">

                                                                <span class="stats-small__label text-uppercase" id="sTitleC5">TOTAL GASTOS</span>

                                                                <h6 class="stats-small__value count my-3" id="sValorC5"> S./ 0.00</h6>

                                                            </div>

                                                            <!-- <div class="stats-small__data">

                                                                <span class="stats-small__percentage stats-small__percentage--increase"></span>

                                                            </div> -->

                                                        </div>

                                                        <canvas height="64" class="blog-overview-stats-small-4 chartjs-render-monitor" width="160"></canvas>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-lg col-md-4 col-sm-6 mb-4">

                                                <div class="stats-small stats-small--1 card card-small">

                                                    <div class="card-body p-0 d-flex">



                                                        <div class="d-flex flex-column m-auto">

                                                            <div class="stats-small__data text-center">

                                                                <span class="stats-small__label text-uppercase" id="sTitleC6">TOTAL ORD.COMPRAS Y GASTOS</span>

                                                                <h6 class="stats-small__value count my-3" id="sValorC6"> S./ 0.00</h6>

                                                            </div>

                                                            <!-- <div class="stats-small__data">

                                                                <span class="stats-small__percentage stats-small__percentage--increase"></span>

                                                            </div> -->

                                                        </div>

                                                        <canvas height="64" class="blog-overview-stats-small-4 chartjs-render-monitor" width="160"></canvas>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-lg col-md-4 col-sm-12 mb-4">

                                                <div class="stats-small stats-small--1 card card-small">

                                                    <div class="card-body p-0 d-flex">



                                                        <div class="d-flex flex-column m-auto">

                                                            <div class="stats-small__data text-center">

                                                                <span class="stats-small__label text-uppercase" id="sTitleC7">DIFERENCIA</span>

                                                                <h6 class="stats-small__value count my-3" id="sValorC7">0.00</h6>

                                                            </div>

                                                            <!-- <div class="stats-small__data">

                                                                <span class="stats-small__percentage stats-small__percentage--increase"></span>

                                                            </div> -->

                                                        </div>

                                                        <canvas height="64" class="blog-overview-stats-small-5 chartjs-render-monitor" width="160"></canvas>

                                                    </div>

                                                </div>

                                            </div>



                                        </div>



                                        <div class="row">



                                            <div class="col-12 col-md-6 mb-4">



                                                <div class="card card-small">

                                                    <div class="card-header border-bottom">

                                                        <h6 class="m-0">Venta Mensual</h6>

                                                    </div>

                                                    <div class="card-body pt-0">

                                                        <div class="chartjs-size-monitor">

                                                            <div class="chartjs-size-monitor-expand">

                                                                <div class=""></div>

                                                            </div>

                                                            <div class="chartjs-size-monitor-shrink">

                                                                <div class=""></div>

                                                            </div>

                                                        </div>



                                                        <canvas id="chartMensual" class="chartjs-render-monitor"></canvas>



                                                        <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">



                                                        </div>



                                                    </div>

                                                </div>



                                            </div>



                                            <div class="col-lg-6 col-md-12 col-sm-12 mb-4">

                                                <div class="card card-small">

                                                    <div class="card-header border-bottom">

                                                        <h6 class="m-0">Categorias</h6>

                                                    </div>

                                                    <div class="card-body pt-2">



                                                        <canvas height="130" style="max-width: 100% !important;" id="chartCategorias"></canvas>



                                                        <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">



                                                        </div>



                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-lg-6 col-md-12 col-sm-12 mb-4">

                                                <div class="card card-small">

                                                    <div class="card-header border-bottom">

                                                        <h6 class="m-0">Productos</h6>

                                                    </div>

                                                    <div class="card-body pt-2">



                                                        <canvas height="130" style="max-width: 100% !important;" id="chartProductos"></canvas>



                                                        <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">



                                                        </div>



                                                    </div>

                                                </div>

                                            </div>



                                            <div class="col-lg-6 col-md-12 col-sm-12 mb-4">

                                                <div class="card card-small">

                                                    <div class="card-header border-bottom">

                                                        <h6 class="m-0">Clientes</h6>

                                                    </div>

                                                    <div class="card-body pt-2">



                                                        <canvas height="130" style="max-width: 100% !important;" id="chartClientes"></canvas>



                                                        <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0 text-center mt-3">



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





                </div>





                <?php extend_view(['admin/common/descripcion-empresa'], $data) ?>

            </main>

        </div>

    </div>







    <!-- Modales -->









    <!-- Fin de modales -->











    <?php extend_view(['admin/common/footer'], $data) ?>



</body>







<?php extend_view(['admin/common/scripts'], $data) ?>



 





<!-- Dashboard --> 

<script>



    window.jsnData = null ;

    window.nMinIdColor = 0;

    window.nMaxIdColor = 14;

    window.aryColors = ["#B5E9F2", "#6ADFB5", "#FEE29F", "#FFA1B5", "#96C8FD" , "#c7f2b5" , "#e7b5f2","#f2b5e2" ,"#f2d3b5","#b5f2bb" ,"#bdb5f2" ,"#f2b5ba" ,"#ff5765" ,"#ffe845" ,"#4572ff" , "#ff4594"];

    

    var chart1,chart2,chart3,chart4;



    $(document).ready(function(){

        fncCleanControls();

        fncValidarRol();





        $("#formFilter").on('submit', function(event) {



            event.preventDefault();





            var dFechaInicio   = $('#dFechaInicio').val();

            var dFechaFin      = $('#dFechaFin').val();



            window.jsnData  = {          

                nIdEmpresa      : $("body").data("nidempresa"),

                nIdSede         : $("body").data("nidsede"),

                dFechaInicio    : dFechaInicio,

                dFechaFin       : dFechaFin,

            };



            fncPopulateDashboard(window.jsnData , function(aryData) {



                if(aryData.success){



                    fncCleanControls();



                    toastr.success(aryData.success);



                    var aryData          = aryData.aryData;



                    var aryDataMeses     = aryData.aryDataMeses;

                    var aryDataCategoria = aryData.aryDataCategoria;

                    var aryDataProducto  = aryData.aryDataProducto;

                    var aryDataCliente   = aryData.aryDataCliente;



                    $("#sValorC1").html(aryData.nTotalNuevosClientes);

                    $("#sValorC2").html(aryData.nCantidadPedidos);

                    $("#sValorC3").html(aryData.nTotalPedidos);

                    $("#sValorC4").html(aryData.nTotalOrdenCompra);

                    $("#sValorC5").html(aryData.nTotalGastos);

                    $("#sValorC6").html(aryData.nOrdenComprasGastos);

                    $("#sValorC7").html(aryData.nDiferencia);





                    $("#sValorSubC1").html(" TOTAL CLIENTES : " + aryData.nTotalClientes);



                    // Venta Mensual 



                    var aryLabel      = [];

                    var aryValores    = [];

                    var aryBackground = [];



                    if(aryDataMeses.length > 0){



                        aryDataMeses.forEach(function (aryItem) {

                            aryLabel.push(fncGetNameMesById(aryItem.sNumeroMes) + ' ' + aryItem.sAnio);

                            aryValores.push(pf(aryItem.nTotal));

                            aryBackground.push(fncGetColor());

                        });



                    }



                    var jsnData = {

                        label       : aryLabel,

                        valores     : aryValores,

                        background  : aryBackground,

                    };



                    fncDrawChart1("chartMensual", "bar", jsnData, "Venta Menual");

                        

                    // Fin de venta Mensual 



                    // Categorias 

                    

                    aryLabel      = [];

                    aryValores    = [];

                    aryBackground = [];



                    if(aryDataCategoria.length > 0){



                        aryDataCategoria.forEach(function (aryItem) {

                            aryLabel.push(aryItem.sCategoria);

                            aryValores.push(pf(aryItem.nTotal));

                            aryBackground.push(fncGetColor());

                        });



                    }



                    var jsnData = {

                        label       : aryLabel,

                        valores     : aryValores,

                        background  : aryBackground,

                    };



                    fncDrawChart2( "chartCategorias", "horizontalBar", jsnData , "Categorias" );



                    // Fin de categorias



                    // Productos 

                       

                    aryLabel      = [];

                    aryValores    = [];

                    aryBackground = [];



                    if(aryDataProducto.length > 0){



                        aryDataProducto.forEach(function (aryItem) {

                            aryLabel.push(aryItem.sProducto);

                            aryValores.push(pf(aryItem.nTotal));

                            aryBackground.push(fncGetColor());

                        });



                    }



                    var jsnData = {

                        label       : aryLabel,

                        valores     : aryValores,

                        background  : aryBackground,

                    };



                    fncDrawChart3( "chartProductos", "horizontalBar", jsnData , " Productos " );



                    // Fin de productos 





                    // Clientes 

                       

                    aryLabel      = [];

                    aryValores    = [];

                    aryBackground = [];



                    if(aryDataCliente.length > 0){



                        aryDataCliente.forEach(function (aryItem) {

                            aryLabel.push(aryItem.sCliente);

                            aryValores.push(pf(aryItem.nTotal));

                            aryBackground.push(fncGetColor());

                        });



                    }



                    var jsnData = {

                        label       : aryLabel,

                        valores     : aryValores,

                        background  : aryBackground,

                    };



                    fncDrawChart4( "chartClientes", "pie", jsnData , "Clientes" );



                    // Fin de Clientes 

 

 



                } else {

                    toastr.error(aryData.error);

                }

            });



        });







    });







    // Funciones Auxiliares





    function fncValidarRol() {

        if ($("body").data("nadmin") == 1) {

            // es admin

        } else {



        }

    }





    function fncCleanControls() {

    

        $("#sValorC1").html("0.00");

        $("#sValorC2").html("0.00");

        $("#sValorC3").html("0.00");

        $("#sValorC4").html("0.00");

        

        if (chart1 != undefined) chart1.destroy();

        if (chart2 != undefined) chart2.destroy();

        if (chart3 != undefined) chart3.destroy();

        if (chart4 != undefined) chart4.destroy();

    

    }





    // Dibujar los graficos ...

    function fncDrawChart1(id, type, info, titleGrafic) {

        var config = {

            // The type of chart we want to create

            type: type,

            // The data for our dataset

            data: {

            labels: info.label,

            datasets: [

                {

                label: titleGrafic,

                backgroundColor: info.background,

                borderColor: info.background,

                data: info.valores,

                fill: false,

                },

            ],

            },

            options: {

            legend: {

                display: true,

            },

            },

        };



        var ctx = document.getElementById(id).getContext("2d");



        if (chart1 != undefined) chart1.destroy();



        chart1 = new Chart(ctx, config);

    }



    function fncDrawChart2(id, type, info, titleGrafic) {

        var config = {

            // The type of chart we want to create

            type: type,

            // The data for our dataset

            data: {

            labels: info.label,

            datasets: [

                {

                label: titleGrafic,

                backgroundColor: info.background,

                borderColor: info.background,

                data: info.valores,

                fill: false,

                },

            ],

            },

            options: {

            legend: {

                display: true,

            },

            },

        };



        var ctx = document.getElementById(id).getContext("2d");



        if (chart2 != undefined) chart2.destroy();



        chart2 = new Chart(ctx, config);

    }



    function fncDrawChart3(id, type, info, titleGrafic) {

        var config = {

            // The type of chart we want to create

            type: type,

            // The data for our dataset

            data: {

            labels: info.label,

            datasets: [

                {

                label: titleGrafic,

                backgroundColor: info.background,

                borderColor: info.background,

                data: info.valores,

                fill: false,

                },

            ],

            },

            options: {

            legend: {

                display: true,

            },

            },

        };



        var ctx = document.getElementById(id).getContext("2d");



        if (chart3 != undefined) chart3.destroy();



        chart3 = new Chart(ctx, config);

    }



    function fncDrawChart4(id, type, info, titleGrafic) {

        var config = {

            // The type of chart we want to create

            type: type,

            // The data for our dataset

            data: {

            labels: info.label,

            datasets: [

                {

                label: titleGrafic,

                backgroundColor: info.background,

                borderColor: info.background,

                data: info.valores,

                fill: false,

                },

            ],

            },

            options: {

            legend: {

                display: true,

            },

            },

        };



        var ctx = document.getElementById(id).getContext("2d");



        if (chart4 != undefined) chart4.destroy();



        chart4 = new Chart(ctx, config);

    }



    function fncGetRandomInt(min, max) {

         return Math.floor(Math.random() * (max - min)) + min;

    }



    function fncGetColor(){ 





        

        // return "hsl(" + 360 * Math.random() + ',' +

        //             (25 + 70 * Math.random()) + '%,' + 

        //             (85 + 10 * Math.random()) + '%)';



        // var rand = Math.floor(Math.random() * 10);

        // return "rgb(" + (215 - rand * 3) + "," + (185 - rand * 5) + "," + (185 - rand * 10) + " )"; 

        

        var randomColor = Math.floor(Math.random()*16777215).toString(16);

        return "#" + randomColor;

    

      //  return '#'+Math.floor(Math.random()*16777215).toString(16);

    }





    // Llamadas al servidor 

    

    function fncPopulateDashboard(formData, fncCallback) {

        $.ajax({

                type: 'post',

                dataType: 'json',

                url: web_root + 'dashboard/fncPopulateDashboard',

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

<!-- Dashboard --> 





</html>