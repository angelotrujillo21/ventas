<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>
</head>

<body data-nvistalogin="1">

    <div class="page-loader">
        <div class="loader-dual-ring"></div>
    </div>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div id="fondo-login" class="content-wrapper d-flex align-items-center auth fondo-login">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                         
                        <div class="auth-form-light text-center p-5">
                            <div class="brand-logo">
                                <img id="logo" class="img img-fluid img-login" src="<?= src('app/app-logo.svg') ?>">
                            </div>
                            <h4>¡Hola! empecemos</h4>
                            <h6 class="font-weight-light">Inicia sesión para continuar.</h6>
                            <form id="form-auth" method="post" action="<?= route('acceso') ?>" class="pt-3">

                                <input type="hidden" name="sURL" id="sURL" value="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">

                                <div class="form-group  ">
                                    <select name="nIdEmpresa" class="form-control form-control-lg" id="nIdEmpresa" required>
                                        <option value="">SELECCIONA EMPRESA</option>
                                        <?php if (fncValidateArray($aryEmpresas)) : ?>
                                            <?php foreach ($aryEmpresas as $aryLopp) : ?>
                                                <option <?= count($aryEmpresas) == 1 ? "selected" : "" ?> value="<?= $aryLopp["nIdEmpresa"] ?>"><?= $aryLopp["sNombre"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="sUsuario" class="form-control form-control-lg" id="sUsuario" placeholder="Usuario" required>
                                </div>

                                <div class="form-group">
                                    <div class="input-group content-password">
                                        <input type="password" placeholder="Clave" class="form-control form-control-lg input-password" name="sClave" id="sClave" aria-label="Password" required>
                                        <div data-visible="true" class="input-group-append btnToggleVisible cursor-pointer">
                                            <span class="input-group-text"> <i style="display: none;" class="far fa-eye icon-view"></i> <i class="far fa-eye-slash icon-slash"></i> </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Ingresar</button>
                                </div>
                            </form>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <a id="btnRecuperar" class="link-registrar" href="javascript:;">¿Olvidaste tu constraseña?</a>
                                </div>

                                <div class="col-12 py-2">
                                    <a id="btnRegistrar" class="btn btn-block btn-outline-primary " href="javascript:;">Registrarse</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>



    <!--Modales -->

    <div class="modal fade" id="formRecuperar" tabindex="-1" role="dialog" aria-labelledby="formRecuperarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-recuperar">
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0 btn-close-recuperar" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">

                                <h4 class="text-center">Recuperar contraseña</h4>
                                <p class="d-block text-center">LLena todos los campos requeridos para poder recuperar tu contraseña</p>

                                <div class="row">

                                    <div id="content-nTipoUsuarioR" class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="nTipoUsuarioR" class="col-form-label">Tipo de usuario:</label>
                                            <select name="nTipoUsuarioR" class="form-control" id="nTipoUsuarioR">
                                                <option value="0">Seleccionar</option>
                                                <option value="1">Dueño de negocio</option>
                                                <option value="2">Empleado</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div id="content-nIdEmpresaR" class="col-md-4 col-12 content-empleado-R">
                                        <div class="form-group">
                                            <label for="nIdEmpresaR" class="col-form-label">Empresa:</label>
                                            <select name="nIdEmpresaR" class="form-control" id="nIdEmpresaR">
                                                <option value="">Seleccionar</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div id="content-nIdSedeR" class="col-md-4 col-12  content-empleado-R">
                                        <div class="form-group">
                                            <label for="nIdSedeR" class="col-form-label">Sede:</label>
                                            <select name="nIdSedeR" class="form-control" id="nIdSedeR">
                                                <option value="">Seleccionar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="content-sCorreoR" class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sCorreoR" class="col-form-label">Correo:</label>
                                            <input type="email" name="sCorreoR" class="form-control" id="sCorreoR" placeholder="">
                                        </div>
                                    </div>

                                </div>



                                <div class="mt-3 text-center">
                                    <button type="submit" class="btn btn-gradient-primary btn-md">Enviar</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="formUsuario" tabindex="-1" role="dialog" aria-labelledby="formUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formUsuarioLabel">Nuevo Usuario</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="sNombreUsuarioS" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="sNombreUsuarioS" autocomplete="off" name="sNombreUsuarioS">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="sApellidosUsuarioS" class="col-form-label">Apellidos:</label>
                                    <input type="text" class="form-control" id="sApellidosUsuarioS" autocomplete="off" name="sApellidosUsuarioS">
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="sEmailUsuarioS" class="col-form-label">Email:</label>
                                    <input type="email" class="form-control" id="sEmailUsuarioS" autocomplete="off" name="sEmailUsuarioS">
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="sLoginUsuarioS" class="col-form-label">Login:</label>
                                    <input type="text" class="form-control" id="sLoginUsuarioS" autocomplete="off" name="sLoginS">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="sClaveUsuarioS" class="col-form-label">Clave:</label>
                                    <input type="text" class="form-control" id="sClaveUsuarioS" autocomplete="off" name="sClaveUsuarioS">
                                </div>
                            </div>


                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="sImageneUsuarioS" class="col-form-label">Imagen:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImageneUsuarioS" accept="image/*" lang="es" name="sImageneUsuarioS">
                                            <label class="custom-file-label" for="sImageneUsuarioS">Elija el archivo</label>
                                        </div>
                                    </div>
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


    <!-- Fin de modales -->


</body>

<?php extend_view(['admin/common/scripts'], $data) ?>


<!-- Login -->
<script>
    $(function() {

        

        $("#form-auth").on('submit', function(event) {

            event.preventDefault();

            var nIdEmpresa     = $("#nIdEmpresa").val();
            var sUsuario       = $("#sUsuario").val();
            var sClave         = $("#sClave").val();

            var jsnData = {
                nIdEmpresa : nIdEmpresa,
                sUsuario   : sUsuario,
                sClave     : sClave,
                sURL       :  window.location.href
            };
             

            accesoAjax(jsnData, function(aryData) {
                if (aryData.success) {
                    
                    toastr.success(aryData.msg);
                    
                    location.reload();

                } else {
                    toastr.error(aryData.msg);
                }
            });

        });

 
    });

   


    // Llamadas al servidor

    function accesoAjax(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'accesoAjax',
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
<!-- Login -->

<!-- Formulario Login -->
<script>
    $(document).ready(function() {
        fncLoadEmpresas();


        $("#nIdEmpresa").on("change", function() {

            if ( $(this).val() == null || $(this).val() == '') {
                $("#logo").attr("src", src('app/app-logo.svg'));
                $("#fondo-login").attr("style", `background-image: linear-gradient( to right, rgba(147, 231, 212, 0.52),rgba(0, 123, 255, 0.73)),url("${src('app/fondo-login-dashboard.jpg' )}") !important;`);
                return false;
            }

            var sImagen = $(this).find("option:selected").data("simagen");
            var sImagenFondoLogin = $(this).find("option:selected").data("simagenfondologin");

            var sImagenLogoGeneralUsuario = $(this).find("option:selected").data("simagenlogogeneralusuario");
            var sImagenFondoLoginUsuario = $(this).find("option:selected").data("simagenfondologinusuario");

            // Si no Carga el de la empresa carga los datos del administrador o dueno si no tiene configurado nada lista todas las empresas 
            // Para el logo 
            if (sImagen.length > 0) {
                $("#logo").attr("src", src('multi/' + sImagen));
            } else if (sImagenLogoGeneralUsuario.length > 0) {
                $("#logo").attr("src", src('multi/' + sImagenLogoGeneralUsuario));
            } else {
                $("#logo").attr("src", src('app/app-logo.svg'));
            }

            // Para el fondo del login
            if (sImagenFondoLogin.length > 0) {
                $("#fondo-login").attr("style", `background-image: linear-gradient( to right, rgba(147, 231, 212, 0.52),rgba(0, 123, 255, 0.73)),url("${src('multi/' + sImagenFondoLogin )}") !important;`);
            } else if (sImagenFondoLoginUsuario.length > 0) {
                $("#fondo-login").attr("style", `background-image: linear-gradient( to right, rgba(147, 231, 212, 0.52),rgba(0, 123, 255, 0.73)),url("${src('multi/' + sImagenFondoLoginUsuario )}") !important;`);
            } else {
                $("#fondo-login").attr("style", `background-image: none;`);
            }
        });

        $("#nIdEmpresa").val(0).trigger("change");

    });

    function fncLoadEmpresas() {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        var nIdEmpresa = urlParams.get('nIdEmpresa');
        var nIdUsuario = urlParams.get('nIdUsuario');

        var jsnData = {
            nIdEmpresa: nIdEmpresa == null ? '' : nIdEmpresa,
            nIdUsuario: nIdUsuario == null ? '' : nIdUsuario,
        };


        fncGetEmpresas(jsnData, (aryData) => {

            if (aryData.success) {

                var aryData = aryData.aryData;

                if (aryData.length > 0) {

                    var sHtml = `<option value="">Empresa</option>`;

                    aryData.forEach(aryElement => {
                        sHtml += `<option data-simagenfondologinusuario="${aryElement.sImagenFondoLoginUsuario}" data-simagenlogogeneralusuario="${aryElement.sImagenLogoGeneralUsuario}"  data-simagen="${aryElement.sImagen}" data-simagenfondologin="${aryElement.sImagenFondoLogin}" ${ aryData.length == 1 ? `selected="selected"` : `` } value="${aryElement.nIdEmpresa}">${aryElement.sNombre}</option>`;
                    });

                    $("#nIdEmpresa").html(sHtml);
                }


                if (aryData.length == 1) {

                    $("#nIdEmpresa").trigger("change");
                    $("#nIdEmpresa,#btnRegistrar").hide();
                }

            } else {

                toastr.error(aryData.error);

            }
        });

    }

    // Funciones Auxliares

    function fncDrawEmpresas(jsnData, sHtmlTag) {

        fncGetEmpresas(jsnData, (aryData) => {

            if (aryData.success) {

                var aryData = aryData.aryData;

                if (aryData.length > 0) {

                    var sHtml = `<option value="">Empresa</option>`;

                    aryData.forEach(aryElement => {
                        sHtml += `<option data-simagen="${aryElement.sImagen}" data-simagenfondologin="${aryElement.sImagenFondoLogin}" ${ aryData.length == 1 ? `selected="selected"` : `` } value="${aryElement.nIdEmpresa}">${aryElement.sNombre}</option>`;
                    });

                    $(sHtmlTag).html(sHtml);
                }


                if (aryData.length == 1) {
                    $(sHtmlTag).trigger("change");
                }

            } else {

                toastr.error(aryData.error);

            }
        });

    }

    function fncDrawSedes(jsnData, sHtmlTag) {

        fncGetSedes(jsnData, (aryData) => {

            if (aryData.success) {

                var aryData = aryData.aryData;

                if (aryData.length > 0) {

                    var sHtml = `<option value="">SEDES</option>`;

                    aryData.forEach(aryElement => {
                        sHtml += `<option ${ aryData.length == 1 ? `selected="selected"` : `` } value="${aryElement.nIdSede}">${aryElement.sNombre}</option>`;
                    });

                    $(sHtmlTag).html(sHtml);

                }

                if (aryData.length == 1) {
                    $(sHtmlTag).trigger("change");
                }

            } else {

                toastr.error(aryData.error);

            }
        });
    }


    // Llamadas al servidor
    function fncGetEmpresas(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'empresas/fncGetEmpresas',
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

    function fncGetSedes(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'sedes/fncGetSedes',
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
<!-- Formulario Login -->


<!-- Registrar Como Dueño del negocio o usuario o admin  -->
<script>
    $(function() {

        // Formulario Negocios 


        $("#btnRegistrar").on('click', function() {
            fncCleanAll();
            $("#formUsuario").find(".modal-title").html('Nuevo Dueño de negocio');
            $("#formUsuario").data("nIdRegistro", 0);
            $("#formUsuario").modal("show");
        });



        $("#formUsuario").find('form').on('submit', function(event) {

            event.preventDefault();

            var nIdRegistro = $("#formUsuario").data("nIdRegistro");
            var sNombre = $("#sNombreUsuarioS").val().trim();
            var sApellidos = $("#sApellidosUsuarioS").val().trim();
            var sEmail = $("#sEmailUsuarioS").val().trim();
            var sLogin = $("#sLoginUsuarioS").val().trim();
            var sClave = $("#sClaveUsuarioS").val().trim();
            var sImagen = $("#sImageneUsuarioS")[0].files[0];
            var nIdRol = 1;
            var nEstado = 1;


            if (sNombre == '') {
                toastr.error('Error. Debe ingresar el nombre del usuario.');
                return false;
            } else if (sApellidos == '') {
                toastr.error('Error. Debe ingresar el apellido del usuario.');
                return false;
            } else if (sEmail == '') {
                toastr.error('Error. Debe ingresar el email del usuario.');
                return false;
            } else if (sLogin == '') {
                toastr.error('Error. Debe ingresar el login del usuario.');
                return false;
            } else if (sClave == '') {
                toastr.error('Error. Debe ingresar la clave del usuario.');
                return false;
            }

            var formData = new FormData();

            formData.append('nIdRegistro', nIdRegistro);
            formData.append('sNombre', sNombre);
            formData.append('sApellidos', sApellidos);
            formData.append('sEmail', sEmail);
            formData.append('sLogin', sLogin);
            formData.append('sClave', sClave);
            formData.append('sImagen', sImagen);
            formData.append('nIdRol', nIdRol);
            formData.append('nEstado', parseInt(nEstado));


            fncGrabarUsuario(formData, function(aryData) {
                if (aryData.success) {

                    fncCleanAll();
                    $("#formUsuario").modal("hide");
                    toastr.success(aryData.success);

                    $("#nTipoUsuario").val(1).trigger("change");

                    $("#sUsuario").val(sLogin);
                    $("#sClave").val(sClave);
                    $("#form-auth").trigger("submit");

                } else {
                    toastr.error(aryData.error);
                }
            });


        });

        // Fin de Formulario Negocios 

    });

    // Funciones de la tabla o layout Principal 


    function fncCleanAll() {
        fncClearInputs($("#formRecuperar").find("form"));
        fncClearInputs($("#formUsuario").find("form"));
    }

    // Funciones Auxiliares


    // Llamadas al servidor

    function fncGrabarUsuario(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'usuarios/fncGrabarUsuario',
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
</script>
<!--  Registrar Como Dueño del negocio o usuario o admin -->



<!-- Recuperar -->
<script>
    $(function() {

        // Formulario Negocios 

        $("#btnRecuperar").on('click', function() {
            fncCleanAll();
            $("#formRecuperar").modal("show");
        });



        $("#nTipoUsuarioR").on("change", function() {

            switch ($(this).val()) {

                case '1':
                    $("#content-sCorreoR").removeClass().addClass("col-12 col-md-8");

                    $(".content-empleado-R").hide();
                    break;

                case '2':
                    $("#content-sCorreoR").removeClass().addClass("col-12 col-md-12");
                    fncDrawEmpresas(null, "#nIdEmpresaR");
                    $(".content-empleado-R").show();
                    break;
            }

            $("#nIdEmpresaR,#nIdSedeR").html("<option>Seleccionar</option>");

        });



        $("#nIdEmpresaR").on("change", function() {


            $("#nIdSedeR").html("<option>Sedes</option>");

            if ($(this).val() == "") {
                return;
            }

            var jsnData = {
                nIdEmpresa: $(this).val()
            };

            fncDrawSedes(jsnData, "#nIdSedeR");

        });



        $("#formRecuperar").find('form').on('submit', function(event) {

            event.preventDefault();

            var nTipoUsuario = $("#nTipoUsuarioR").val().trim();
            var nIdEmpresa = $("#nIdEmpresaR").val().trim();
            var nIdSede = $("#nIdSedeR").val().trim();
            var sCorreo = $("#sCorreoR").val().trim();

            if (nTipoUsuario == '0') {
                toastr.error('Error. Debe seleccionar un tipo de usuario. Porfavor verifique');
                return false;
            }

            if (nTipoUsuario == "2") {

                if (nIdEmpresa == '0' || nIdEmpresa == '') {
                    toastr.error('Error. Debe seleccionar una empresa. Porfavor verifique');
                    return false;
                } else if (nIdSede == '0' || nIdSede == '') {
                    toastr.error('Error. Debe seleccionar una empresa. Porfavor verifique');
                    return false;
                }

            }

            if (sCorreo == '') {
                toastr.error('Error. Debe ingresar el email del usuario.');
                return false;
            }


            var jsnData = {
                nTipoUsuario: nTipoUsuario,
                nIdEmpresa: nIdEmpresa,
                nIdSede: nIdSede,
                sCorreo: sCorreo
            };

            fncRecuperarClave(jsnData, function(aryData) {
                if (aryData.success) {
                    fncCleanAll();
                    $("#formRecuperar").modal("hide");
                    toastr.success(aryData.success);
                } else {
                    //     toastr.error();
                    alert(aryData.error);
                }
            });

        });

        // Fin de Formulario Negocios 

    });

    // Funciones de la tabla o layout Principal 




    // Llamadas al servidor
    function fncRecuperarClave(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'usuarios/fncRecuperarClave',
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
<!-- Usuario -->


</html>