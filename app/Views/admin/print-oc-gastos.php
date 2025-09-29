<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin = "<?=$nAdmin?>"
      
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
                                                        <h6><?= $sTitulo ?></h6>
                                                    </div>

                                                    <div class="ml-auto">
                                                        
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row">
                                            <div class="col-12 col-md-6">

                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="nIdOC" class="col-form-label">Orden de compra:</label>
                                                            <select class="form-control" name="nIdOC" id="nIdOC">
                                                                <?php if(fncValidateArray($aryIdOC)): ?>
                                                                    <?php foreach($aryIdOC as $aryLoop):?>
                                                                        <option value="<?= $aryLoop ?>"><?= sp( $aryLoop ) ?></option>
                                                                    <?php endforeach?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="nIdGasto" class="col-form-label">Gasto:</label>
                                                            <select class="form-control" name="nIdGasto" id="nIdGasto">
                                                                <?php if(fncValidateArray($aryIdGasto)): ?>
                                                                    <?php foreach($aryIdGasto as $aryLoop):?>
                                                                        <option value="<?= $aryLoop ?>"><?= sp( $aryLoop ) ?></option>
                                                                    <?php endforeach?>
                                                                <?php endif ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-auto">
                                                        <div class="form-group">
                                                            <label for="nIdGasto" class="col-form-label d-none d-md-block">&nbsp;</label>
                                                            <button id="btnImprimir" class="btn btn-primary" type="button">Imprimir</button>
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

<!-- PRINT ORDEN DE COMPRAS Y GASTOS -->
<script>
      
    $(function() {


        $("#nIdOC,#nIdGasto").select2({
            placeholder : "Seleccionar"
        });

         
 
        $("#btnImprimir").on('click', function() {

            var nIdOC    = $("#nIdOC").find("option:selected").val();
            var nIdGasto = $("#nIdGasto").find("option:selected").val();

            if(nIdOC == 0 || !nIdOC){
                toastr.error('Error. Debe seleccionar una orden de compra . Porfavor verifique');
                return false;
            }  else  if(nIdGasto == 0 || !nIdGasto){
                toastr.error('Error. Debe seleccionar un gasto . Porfavor verifique');
                return false;
            }

            
            fncMsg(1, '¿Estas seguro de generar el PDF?' , 
            function(){
                var sUrl  = web_root + `ordenCompra/fncImprimirOrdenAndGasto/${nIdOC}/${nIdGasto}`;
                fncCleanAll();
                window.open(sUrl, '_blank').focus();
            });


        }); 

      

    });

 


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            //$("#btnCrearCompra").hide();
        }
    }

 


    // Funciones Auxiliares
    window.fncCleanAll = () => {
        $("#nIdOC,#nIdGasto").val(null).trigger("change");
    }

 

  

</script>
<!-- PRINT ORDEN DE COMPRAS Y GASTOS -->
 




</html>