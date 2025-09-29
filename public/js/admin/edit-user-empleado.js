/*  -------------------------------------- USER --------------------------------------  */
$(function() {

    // Form Usuario
    $("#btnEditarUsuarioEmpleado").on('click', function() {

        var nId = $(this).data("nid");

         if ($(this).data("nrol") == 1){
            fncMostrarUsuarioEdit(nId);
        } else {
            
            var jsnData = {
                sCatalogo  : "TIPO_DOCUMENTO_IDENTIDAD"
            };

            fncDrawTipoDocumento(jsnData,"#nTipoDocumentoEmpleadoE" , (bStatus) =>{

                if(bStatus){

                    fncDrawSelectRoles(null,"#nIdRolEmpleadoE",(bStatus) => {

                        if(bStatus){
                            fncMostrarEmpleadoForEdit(nId);

                        }


                    });


                }

            });
            
        
        }
    });



    $("#formUsuarioEdit").find('form').on('submit', function(event) {

        event.preventDefault();

        var nIdRegistro     = $("#formUsuarioEdit").data("nIdRegistro");
        var sNombre         = $("#sNombreUsuarioE").val().trim();
        var sApellidos      = $("#sApellidosUsuarioE").val().trim();
        var sEmail          = $("#sEmailUsuarioE").val().trim();
        var sLogin          = $("#sLoginUsuarioE").val().trim();
        var sClave          = $("#sClaveUsuarioE").val().trim();
        var sImagen         = $("#sImagenUsuarioE")[0].files[0];

        var sImagenLogoGeneral     = $("#sImagenLogoGeneral")[0].files[0];
        var sImagenFondoLogin      = $("#sImagenFondoLogin")[0].files[0];

        var nIdRol          = 1;
        var nEstado         = 1;


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
        formData.append('sCorreo', sEmail);
        formData.append('sLogin', sLogin);
        formData.append('sClave', sClave);
        formData.append('sImagen', sImagen);

        formData.append('sImagenLogoGeneral', sImagenLogoGeneral);
        formData.append('sImagenFondoLogin', sImagenFondoLogin);

        formData.append('nIdRol', nIdRol);
        formData.append('nEstado', parseInt(nEstado));
    

        fncGrabarUsuarioE(formData, function(aryData) {
            if (aryData.success) {
                toastr.success(aryData.success);
                location.reload();
            } else {
                toastr.error(aryData.error);
            }
        });


    });


    $("#btnCopyLinkAcceso").on("click" ,function(){
        

          /* Copy the text inside the text field */
          navigator.clipboard.writeText($("#sLinkEmpresas").val());
          toastr.success("Se copio el link de forma correcta");
    });

});


function fncMostrarUsuarioEdit(nIdRegistro) {

    $("#formUsuarioEdit").data("nIdRegistro",nIdRegistro);
  
    var jsnData = {
        nIdRegistro: nIdRegistro
    };
 
    fncBuscarUsuarioForEdit(jsnData, function(aryResponse){
        
            if (aryResponse.success) {
                var aryData = aryResponse.aryData;

                $("#sNombreUsuarioE").val(aryData.sNombre);
                $("#sApellidosUsuarioE").val(aryData.sApellidos);
                $("#sEmailUsuarioE").val(aryData.sCorreo);

                $("#sLoginUsuarioE").val(aryData.sLogin);
                $("#sClaveUsuarioE").val(aryData.sClave);

                if(aryData.sImagen.length> 0) {
                    $("label[for='sImagenUsuarioE']").eq(0).find("img").show();
                    $("label[for='sImagenUsuarioE']").eq(0).find("img").attr("src",  src('multi/' + aryData.sImagen ) );
                    $("label[for='sImagenUsuarioE']").eq(1).html(aryData.sImagen);
                } 

                
                if(aryData.sImagenLogoGeneral.length > 0) {
                    $("label[for='sImagenLogoGeneral']").eq(0).find("img").show();
                    $("label[for='sImagenLogoGeneral']").eq(0).find("img").attr("src",  src('multi/' + aryData.sImagenLogoGeneral ) );
                    $("label[for='sImagenLogoGeneral']").eq(1).html(aryData.sImagenLogoGeneral);
                }

                if(aryData.sImagenFondoLogin.length > 0) {
                    $("label[for='sImagenFondoLogin']").eq(0).find("img").show();
                    $("label[for='sImagenFondoLogin']").eq(0).find("img").attr("src",  src('multi/' + aryData.sImagenFondoLogin ) );
                    $("label[for='sImagenFondoLogin']").eq(1).html(aryData.sImagenFondoLogin);
                }

                $("#sLinkEmpresas").val(aryResponse.sURLAcceso);
                $("#sLinkEmpresas").attr("readonly" , "readonly");

                $("#formUsuarioEdit").find(".modal-title").html('Editar Usuario');
                $("#formUsuarioEdit").modal("show");

            } else {
                toastr.error(aryData.error);
            }
    });

}

function fncCleanAllEditUserEmpleado(){
    fncClearInputs( $("#formUsuarioEdit").find("form") );
    fncClearInputs( $("#formEmpleadoE").find("form") );
}

// Llamadas al servidor

function fncGrabarUsuarioE(formData, fncCallback) {
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

function fncBuscarUsuarioForEdit(jsnData, fncCallback) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: web_root +  'usuarios/fncMostrarUsuario',
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

/* -------------------------------------- EMPLEADO -------------------------------------- */

$(function() {

  

    // Submit del formulario de Cliente
    $("#formEmpleadoE").find("form").on('submit',function(event){
       
         event.preventDefault();

         var nIdRegistro            = $("#formEmpleadoE").data("nIdRegistro");
         var nTipoDocumento         = $("#nTipoDocumentoEmpleadoE").val()
         var sNumeroDocumento       = $("#sNumeroDocumentoEmpleadoE").val();
         var sNombre                = $("#sNombreEmpleadoE").val();
         var sCorreo                = $("#sCorreoEmpleadoE").val();
         var sDireccion             = $("#sDireccionEmpleadoE").val();
         var sTelefono              = $("#sTelefonoEmpleadoE").val();
         var sLogin                 = $("#sLoginEmpleadoE").val();
         var sClave                 = $("#sClaveLoginE").val();
         var nIdRol                 = $("#nIdRolEmpleadoE").val();
         var sImagen                = $("#sImagenEmpleadoE")[0].files[0];
         var nEstado                = $("#nEstadoEmpleadoE").val();

         if (nTipoDocumento  == '') {
             toastr.error('Error. Seleccione un tipo de documento. Porfavor verifique');
             return;
         }  else if (sNumeroDocumento  == '') {
             toastr.error('Error. Ingrese un numero de documento. Porfavor verifique');
             return;
         }  else if (sNombre  == '') {
             toastr.error('Error. Ingrese un nombre . Porfavor verifique');
             return;
         }  else if (sCorreo  == '') {
             toastr.error('Error. Ingrese un correo. Porfavor verifique');
             return;
         }  else if (sLogin  == '') {
             toastr.error('Error. Ingrese un login para el empleado. Porfavor verifique');
             return;
         }  else if (sClave == '') {
             toastr.error('Error. Ingrese una clave para el empleado. Porfavor verifique');
             return;
         }  else if (nIdRol == '') {
             toastr.error('Error. Seleccione un rol para el empleado. Porfavor verifique');
             return;
         }   


         var formData = new FormData();
        formData.append('nIdRegistro', nIdRegistro);
        formData.append('nTipoDocumento', nTipoDocumento);
        formData.append('sNumeroDocumento', sNumeroDocumento);
        formData.append('sNombre', sNombre);
        formData.append('sDireccion', sDireccion);
        formData.append('sTelefono', sTelefono);
        formData.append('sCorreo', sCorreo);
        formData.append('sLogin', sLogin);
        formData.append('sClave', sClave);
        formData.append('sImagen', sImagen);
        formData.append('nIdRol', nIdRol);
        formData.append('nEstado', nEstado);

    
         fncGrabarEmpleadoForEdit(formData, function(aryData){
             if(aryData.success){
                toastr.success(aryData.success);
                location.reload();
             } else {
                 toastr.error(aryData.error);
             }
         });

    });

    // Eventos tipo documento
    $("#nTipoDocumentoEmpleadoE").change(function() {
         if( $(this).val() > 0 ) {
             fncMaxLengthTypeDocument( $(this).find('option:selected').text().trim().toUpperCase() , "#sNumeroDocumentoEmpleadoE" );
         }
    });

    $("#sNumeroDocumentoEmpleadoE").on('keyup change',function(){
                
        switch( $("#nTipoDocumentoEmpleadoE").find("option:selected").text() ){
                    
            case 'RUC':

                        if( $("#sNumeroDocumentoEmpleadoE").val().length  == 11 ){
                             
                            // Lanzamos el evento
                            var jsnData = {
                                sTipo        : "ruc",
                                sNumeroDoc   : $("#sNumeroDocumentoEmpleadoE").val()
                            };

                            fncBuscarDocument( jsnData ,function(aryData){
                                if(aryData.success){
                                    $("#sNombreEmpleadoE").val(aryData.success.razonSocial);
                                }
                            });

                        }

            break;
            
            case 'DNI':
                        if( $("#sNumeroDocumentoEmpleadoE").val().length  == 7 || $("#sNumeroDocumentoEmpleadoE").val().length  == 8 ){
                            
                            // Lanzamos el evento
                            var jsnData = {
                                sTipo        : "dni",
                                sNumeroDoc   : $("#sNumeroDocumentoEmpleadoE").val()
                            };

                            fncBuscarDocument(jsnData ,function(aryData){
                                if(aryData.success){
                                    $("#sNombreEmpleadoE").val(aryData.success.razonSocial);
                                }
                            });

                        }
            break;

        }
              
                
    });

 
    


});


function fncMostrarEmpleadoForEdit(nIdRegistro , sOpcion = 'editar') {

    $( "#formEmpleadoE" ).data("nIdRegistro",nIdRegistro);
  
    var jsnData = {
        nIdRegistro: nIdRegistro
    };

    fncBuscarRegistroEmpleadoForEdit(jsnData, function(aryResponse){
        
            if (aryResponse.success) {

                var aryData = aryResponse.aryData;

                $("#nTipoDocumentoEmpleadoE").val(aryData.nTipoDocumento);
                $("#sNumeroDocumentoEmpleadoE").val(aryData.sNumeroDocumento);
                $("#sNombreEmpleadoE").val(aryData.sNombre);
                $("#sCorreoEmpleadoE").val(aryData.sCorreo);
                $("#sDireccionEmpleadoE").val(aryData.sDireccion);
                $("#sTelefonoEmpleadoE").val(aryData.sTelefono);
                $("#sLoginEmpleadoE").val(aryData.sLogin);
                $("#sClaveLoginE").val(aryData.sClave);
                $("#nIdRolEmpleadoE").val(aryData.nIdRol);
                $("#nEstadoEmpleadoE").val(aryData.nEstado);

                if(aryData.sImagen.length > 0) $("label[for='sImagenEmpleadoE']").html(aryData.sImagen);

                if(sOpcion == 'editar'){
                    fncEditForm("#formEmpleadoE" , "Editar Empleado");
                } else {
                    fncViewForm("#formEmpleadoE" , "Ver Empleado");
                }

                $("#nIdRolEmpleadoE").parent().parent().hide();
                $("#nEstadoEmpleadoE").parent().parent().hide();

                $("#formEmpleadoE").modal("show");

            } else {
                toastr.error(aryData.error);
            }
    });

}

// Funciones Auxiliares
function fncDrawSelectRoles(jsnData , sHtmlTag , fncCallback){
    fncGetRoles(jsnData , (aryData)=>{
        if(aryData.success){
            var aryData = aryData.aryData;

            var sHtml = `<option value="0">SELECCIONAR</option>`;

            if(aryData.length>0){
            
                aryData.forEach(element => {
                    sHtml += `<option value="${element.nIdRol}">${element.sNombreRol}</option>`;
                });
        
                $(sHtmlTag).html(sHtml);
                fncCallback(true);
            }else{
                $(sHtmlTag).html(sHtml);
        
            }

        }else{
            alert(aryData.error);
        }
    });
}

function fncDrawTipoDocumento(jsnData , sHtmlTag , fncCallback ){

    fncListadoCatalogoTablaForEdit(jsnData , (aryData)=>{
    
        if(aryData.success){
            var aryData = aryData.aryData;

            var sHtml = `<option value="0">SELECCIONAR</option>`;

            if(aryData.length>0){
            
                aryData.forEach(element => {
                    sHtml += `<option value="${element.nIdCatalogoTabla}">${element.sDescripcionCortaItem}</option>`;
                });
        
                $(sHtmlTag).html(sHtml);
            }else{
                $(sHtmlTag).html(sHtml);
        
            }

            fncCallback(true);
        }else{
            alert(aryData.error);
        }
    });
}

// Llamadas al servidor

function fncGrabarEmpleadoForEdit(formData, fncCallback) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: web_root + 'empleados/fncGrabarEmpleado',
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

function fncBuscarRegistroEmpleadoForEdit(jsnData, fncCallback) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: web_root +  'empleados/fncMostrarRegistro',
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


function fncGetRoles( jsnData, fncCallback) {
    $.ajax({
        type: 'post',
        data: jsnData,
        dataType: 'json',
        url: web_root + 'roles/fncGetRoles',
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

function fncListadoCatalogoTablaForEdit(jsnData , fncCallback){

    $.ajax({
        type: 'post',
        data: jsnData,
        dataType: 'json',
        url: web_root + 'catalogoTabla/fncListado',
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