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
                                                       
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <form data-nidregistro="<?=$user['nIdSede']?>" data-nidempresa="<?=$user['nIdEmpresa']?>"  id="formCESede">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sNombreSede" class="col-form-label">Nombre</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreSede" id="sNombreSede">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sDireccionSede" class="col-form-label">Direccion</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDireccionSede" id="sDireccionSede">
                                                            </div>
                                                        </div>


                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sTelefonoSede" class="col-form-label">Telefono</label>
                                                                <input type="tel" autocomplete="off" placeholder="" class="form-control" name="sTelefonoSede" id="sTelefonoSede">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sEncargadoSede" class="col-form-label">Encargado</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sEncargadoSede" id="sEncargadoSede">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="nTipoMonedaSede" class="col-form-label">Tipo Moneda</label>
                                                                <select class="form-control" name="nTipoMonedaSede" id="nTipoMonedaSede">
                                                                    <option value="0">SELECCIONAR</option>
                                                                    <?php if (fncValidateArray($aryTipoMoneda)) : ?>
                                                                        <?php foreach ($aryTipoMoneda as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="nTipoTicketSede" class="col-form-label">Tipo Ticket</label>
                                                                <select class="form-control" name="nTipoTicketSede" id="nTipoTicketSede">
                                                                    <option value="0">SELECCIONAR</option>
                                                                    <?php if (fncValidateArray($aryTipoTicket)) : ?>
                                                                        <?php foreach ($aryTipoTicket as $aryLoop) : ?>
                                                                            <option value="<?= $aryLoop["nIdCatalogoTabla"] ?>"><?= $aryLoop["sDescripcionLargaItem"] ?></option>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sDescripcionSede" class="col-form-label">Descripcion</label>
                                                                <input type="text" class="form-control" name="sDescripcionSede" id="sDescripcionSede">  
                                                            </div>
                                                        </div>


                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Imagen</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="sImagenSede" accept="image/*" name="sImagenSede" lang="es">
                                                                        <label class="custom-file-label" for="sImagenSede">Selecciona un archivo</label>
                                                                    </div>
                                                                </div>
                                                                <small>Recomendado 128px x 128px</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="nEstadoSede" class="col-form-label">Estado</label>
                                                                <select class="form-control" name="nEstadoSede" id="nEstadoSede">
                                                                    <option value="1">ACTIVO</option>
                                                                    <option value="0">DESACTIVO</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="nProduccionSUNAT" class="col-form-label">Producción SUNAT</label>
                                                                <select class="form-control" name="nProduccionSUNAT" id="nProduccionSUNAT">
                                                                    <option value="">SELECCIONAR</option>
                                                                    <option value="1">Producción</option>
                                                                    <option value="0">Beta</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sRutaProdSUNAT" class="col-form-label">Ruta Producción SUNAT</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sRutaProdSUNAT" id="sRutaProdSUNAT">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sTokenProdSUNAT" class="col-form-label">Token Producción SUNAT</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sTokenProdSUNAT" id="sTokenProdSUNAT">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sRutaBetaSUNAT" class="col-form-label">Ruta Beta SUNAT</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sRutaBetaSUNAT" id="sRutaBetaSUNAT">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="sTokenBetaSUNAT" class="col-form-label">Token Beta SUNAT</label>
                                                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sTokenBetaSUNAT" id="sTokenBetaSUNAT">
                                                            </div>
                                                        </div>

                                                        <div id="content-button-submit" class="col-12 text-right">
                                                            <button type="submit" class="btn btn-gradient-primary btn-fw btn-submit">Guardar</button>
                                                        </div>

                                                    </div>
                                                </form>
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




<!-- Mi Sede   -->
<script>
    $(function() {
        
        fncMostrarSede($("#formCESede").data("nidregistro"));
        fncValidateRol();

        
        // Submit del formulario de Empreesa
        $("#formCESede").on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro     = $("#formCESede").data("nidregistro");
            var nIdEmpresa      = $("#formCESede").data("nidempresa");

            var sNombre         = $("#sNombreSede").val();
            var sDireccion      = $("#sDireccionSede").val();
            var sTelefono       = $("#sTelefonoSede").val();
            var sEncargado      = $("#sEncargadoSede").val();

            var nTipoMoneda   = $("#nTipoMonedaSede").val();
            var nTipoTicket   = $("#nTipoTicketSede").val();
            var sDescripcion  = $("#sDescripcionSede").val();

            var nProduccionSUNAT = $("#nProduccionSUNAT").val();
            var sRutaProdSUNAT   = $("#sRutaProdSUNAT").val();
            var sTokenProdSUNAT  = $("#sTokenProdSUNAT").val();
            var sRutaBetaSUNAT   = $("#sRutaBetaSUNAT").val();
            var sTokenBetaSUNAT  = $("#sTokenBetaSUNAT").val();

            var sImagen = $("#sImagenSede")[0].files[0];
            var nEstado = $("#nEstadoSede").val();

            if (typeof nIdEmpresa === 'undefined') {
                toastr.error('Error. No se encontro el codigo de empresa . Porfavor verifique o solicite asistencia');
                return;
            } else if (sNombre == '') {
                toastr.error('Error. Ingrese un nombre o razon social. Porfavor verifique');
                return;
            } else if (sDireccion == '') {
                toastr.error('Error. Ingrese una direccion. Porfavor verifique');
                return;
            } else if (sTelefono == '') {
                toastr.error('Error. Ingrese un telefono. Porfavor verifique');
                return;
            } else if (sEncargado == '') {
                toastr.error('Error. Ingrese un encargado. Porfavor verifique');
                return;
            } else if (nTipoMoneda == '0') {
                toastr.error('Error. Seleccione un tipo de moneda. Porfavor verifique');
                return;
            } else if (nTipoTicket == '0') {
                toastr.error('Error. Seleccione un tipo de ticket. Porfavor verifique');
                return;
            } else if (nProduccionSUNAT == '') {
                toastr.error('Error. Seleccione el tipo de producción SUNAT. Porfavor verifique');
                return;
            }


            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('nIdEmpresa', nIdEmpresa);
            formData.append('sNombre', sNombre);
            formData.append('sDireccion', sDireccion);
            formData.append('sEncargado', sEncargado);
            formData.append('nTipoMoneda', nTipoMoneda);
            formData.append('nTipoTicket', nTipoTicket);
            formData.append('sTelefono', sTelefono);
            formData.append('sDescripcion', sDescripcion);
            formData.append('nProduccionSUNAT', nProduccionSUNAT);
            formData.append('sRutaProdSUNAT', sRutaProdSUNAT);
            formData.append('sTokenProdSUNAT', sTokenProdSUNAT);
            formData.append('sRutaBetaSUNAT', sRutaBetaSUNAT);
            formData.append('sTokenBetaSUNAT', sTokenBetaSUNAT);
            formData.append('sImagen', sImagen);
            formData.append('nEstado', nEstado);

            fncGrabarSede(formData, function(aryData) {
                if (aryData.success) {
                    fncMostrarSede($("#formCESede").data("nidregistro"));
                    toastr.success(aryData.success);
                } else {
                    toastr.error(aryData.error);
                }
            });

        });





    });

    // Funciones de la tabla o layout Principal 
    function fncValidateRol(){

        if($("body").data("nadmin") == 1){
            // Si es admin
        } else {
            $("#content-button-submit").hide();
            fncAddDisabledForm("#formCESede");
        }
    }

    function fncMostrarSede(nIdRegistro) {

        $("#formCESede").data("nidregistro", nIdRegistro);

        var jsnData = {
            nIdRegistro: nIdRegistro
        };

        fncBuscarRegistroSede(jsnData, function(aryResponse) {

            if (aryResponse.success) {

                var aryData = aryResponse.aryData;


                $("#sNombreSede").val(aryData.sNombre);
                $("#sDireccionSede").val(aryData.sDireccion);
                $("#sEncargadoSede").val(aryData.sEncargado);
                $("#sTelefonoSede").val(aryData.sTelefono);
                $("#nTipoMonedaSede").val(aryData.nTipoMoneda);
                $("#nTipoTicketSede").val(aryData.nTipoTicket);
                $("#nEstadoSede").val(aryData.nEstado);
                $("#sDescripcionSede").val(aryData.sDescripcion);
                $("#nProduccionSUNAT").val(aryData.nProduccionSUNAT);
                $("#sRutaProdSUNAT").val(aryData.sRutaProdSUNAT);
                $("#sTokenProdSUNAT").val(aryData.sTokenProdSUNAT);
                $("#sRutaBetaSUNAT").val(aryData.sRutaBetaSUNAT);
                $("#sTokenBetaSUNAT").val(aryData.sTokenBetaSUNAT);


                if (aryData.sImagen.length > 0) $("label[for='sImagenSede']").html(aryData.sImagen);

                

            } else {
                toastr.error(aryData.error);
            }
        });

    }

    // Llamadas al servidor


    // Empresas 

    function fncGrabarSede(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'sedes/fncGrabarSede',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
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

    function fncBuscarRegistroSede(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'sedes/fncMostrarRegistro',
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
<!-- Mi Sede  -->



</html>