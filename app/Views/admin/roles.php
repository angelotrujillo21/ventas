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
                                                        <button id="btnCrearRol" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('roles/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNombreRol" data-sortable="true">Nombre</th>
                                                            <th data-field="sModulos" data-sortable="true">Modulos</th>
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

    <div class="modal fade" id="formRol" tabindex="-1" role="dialog" aria-labelledby="formRolLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="formRolLabel">Nuevo Rol</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                            <div class="row">

                              
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="sNombre" class="col-form-label">Nombre:  <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="sNombreRol" autocomplete="off" name="sNombreRol">
                                    </div>
                                </div>

                                <div class="col-12 my-2">
                                    <p class="m-0">Modulos: <span class="text-danger">*</span>
                                    </p>
                                    <small>D = Submodulo por default , A = Rol de administrador en el submodulo , V = Rol de visitante en el submodulo</small>

                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="row px-3">
                                        <?php if(fncValidateArray($aryDataAllModulos)): ?>
                                            <?php foreach($aryDataAllModulos as $aryModulo): ?>
                                            <div class="form-check  col-12 col-md-6 mb-2">
                                                <label for="check-modulo-<?=$aryModulo["nIdModulo"]?>" style="width: 91%;display: flex;justify-content: space-between;" class="form-check-label">
                                                    <div>
                                                        <input id="check-modulo-<?=$aryModulo["nIdModulo"]?>" name="modulos[]" type="checkbox" class="form-check-input" value="<?=$aryModulo["nIdModulo"]?>">
                                                        <?=$aryModulo["sModulo"]?> 
                                                    </div>
                                                    <div>
                                                        [<span data-toggle="tooltip" data-placement="top" title="Submodulo por default">D</span> -  
                                                         <span data-toggle="tooltip" data-placement="top" title="Rol de administador ">A</span> - 
                                                         <span data-toggle="tooltip" data-placement="top" title="Rol de visitante">V</span>]
                                                    </div>
                                                  
                                                </label>

                                                <div id="content-submodulos-<?=$aryModulo["nIdModulo"]?>" class="content-submodulos row ml-1">
                                                <?php if(fncValidateArray($aryModulo["arySubModulos"])): ?>
                                                    <?php foreach( $aryModulo["arySubModulos"] as $arySubModulo): ?>
                                                        <div class="col-12 row no-gutters <?= $arySubModulo["nIdPadre"] != "0" ? "ml-2" : "" ?>" >

                                                            <div class="col-9">
                                                                <label for="check-submodulo-<?=$arySubModulo["nIdSubModulo"]?>" class="form-check-label">
                                                                    <input 
                                                                     data-surl="<?=$arySubModulo["sUrl"]?>"
                                                                     data-nidpadresubmodulo="<?=$arySubModulo["nIdPadre"]?>"
                                                                     data-nexisterol="<?=$arySubModulo["nExisteRol"]?>" 
                                                                     data-nidpadre="<?=$aryModulo["nIdModulo"]?>" 
                                                                     id="check-submodulo-<?=$arySubModulo["nIdSubModulo"]?>" 
                                                                     name="submodulos[]" 
                                                                     type="checkbox" 
                                                                     class="form-check-input" 
                                                                     value="<?=$arySubModulo["nIdSubModulo"]?>">
                                                                    <?=$arySubModulo["sNombreSubmodulo"]?>                                                            
                                                                </label>
                                                            </div>


                                                            <?php if($arySubModulo["nExisteRol"] == 1): ?>

                                                                <div class="col-1">
                                                                    <label for="radio-submodulo-default-<?=$arySubModulo["nIdSubModulo"]?>" class="form-check-label">
                                                                        <input data-idsubmodulo="<?=$arySubModulo["nIdSubModulo"]?>" type="radio" id="radio-submodulo-default-<?=$arySubModulo["nIdSubModulo"]?>" name="radio-submodulo-rol-default" class="form-check-input" value="1" > 
                                                                        &nbsp;                      
                                                                    </label>
                                                                </div>

                                                                <div class="col-1">
                                                                    <label for="radio-submodulo-admin-<?=$arySubModulo["nIdSubModulo"]?>" class="form-check-label">
                                                                        <input type="radio" id="radio-submodulo-admin-<?=$arySubModulo["nIdSubModulo"]?>" name="radio-submodulo-rol-<?=$arySubModulo["nIdSubModulo"]?>" class="form-check-input" value="1" > 
                                                                        &nbsp;                      
                                                                    </label>
                                                                </div>

                                                                <div class="col-1">
                                                                    <label for="radio-submodulo-visitante-<?=$arySubModulo["nIdSubModulo"]?>" class="form-check-label">
                                                                        <input type="radio" id="radio-submodulo-visitante-<?=$arySubModulo["nIdSubModulo"]?>" name="radio-submodulo-rol-<?=$arySubModulo["nIdSubModulo"]?>" value="2" class="form-check-input">
                                                                        &nbsp;        
                                                                    </label>
                                                                </div>

                                                            <?php endif ?>

                                                        
                                                             
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif ?>    
                                                </div>

                                            </div>
                                            <?php endforeach ?>
                                        <?php endif ?>    
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="sDetalleRol" class="col-form-label">Comentario:</label>
                                        <textarea id="sDetalleRol" class="form-control"  name="sDetalleRol"></textarea>
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

    <?php extend_view(['admin/common/footer'], $data) ?>

</body>



<?php extend_view(['admin/common/scripts'], $data) ?>


<script>
    $(function() {

        fncValidateRol();

        // Formulario Roles
        $("#btnCrearRol").on('click', function() {
            fncCleanAll();
            $("#formRol").find(".modal-title").html('Nuevo Rol');
            $("#formRol").data("nIdRegistro",0);
            $("#formRol").modal("show");
        });

        $("#formRol").find('form').on('submit', function(event) {
            
            event.preventDefault();

            var nIdRegistro         = $("#formRol").data("nIdRegistro");
            var sNombreRol          = $("#sNombreRol").val().trim();
            var sDetalleRol         = $("#sDetalleRol").val().trim();
            var nCheckedModulos     = $('input[name="modulos[]"]:checked').length;

            if(sNombreRol == ''){
                toastr.error('Error. Debe ingresar el nombre del rol.');
                return false;
            } if(nCheckedModulos == 0){
                toastr.error('Error. Debe seleccionar al menos un modulo.');
                return false;
            } 

            if($('input[name="radio-submodulo-rol-default"]:checked').length == 0){
                toastr.error('Error. Por favor debe de seleccionar un rol como default.');
                return false;
            }

            var aryDataRol = [];
            var bExistDefault = false;

            $('input[name="modulos[]"]:checked').each(function(){
                // console.log( $(this).val());
                var nIdModulo = $(this).val();

                var sHtmlTag = "#content-submodulos-" + nIdModulo;

                var arySubModulos = [];
                
               // console.log($(`input[data-nidpadre="${nIdModulo}"]`));

                $(`input[data-nidpadre="${nIdModulo}"]`).each(function(){

                    
                    if($(this).is(':checked')){

                        var nIdSubModulo = $(this).val();

                        var nExisteRol = $(this).data("nexisterol");

                        var sNameRadioRol = "radio-submodulo-rol-"+nIdSubModulo;
                        
                        
                        // Si existe el flag de existe rol evaluamos que puso el usuario en caso de que no exista por default sera administrador 
                        var nRolSubModulo = nExisteRol == 1 ? $('input:radio[name='+sNameRadioRol+']:checked').val() : 1;
                        var nDefault      = $("#radio-submodulo-default-"+$(this).val()).is(':checked') ? 1 : 0;

                        if(nDefault == 1){
                            bExistDefault = true;   
                        }

                        arySubModulos.push({
                            nIdSubModulo  : nIdSubModulo,
                            nRolSubModulo : nRolSubModulo,
                            nDefault      : nDefault  
                        });

                    } 
                 
                });

                aryDataRol.push({
                    nIdModulo     : nIdModulo,
                    arySubModulos : arySubModulos
                });

            });

            if(!bExistDefault){
                toastr.error('Error. Por favor debe de seleccionar un rol como default de los submodulos seleccionados.');
                return false;
            }

          
            var jsnData = {
                nIdRegistro  : nIdRegistro,
                sNombreRol   : sNombreRol,
                aryDataRol   : aryDataRol,
                sDetalleRol  : sDetalleRol
            };

            
            fncGrabarRol(jsnData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formRol").modal("hide");
                    $('#table').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                }else{
                    toastr.error(aryData.error);
                }
            });    
        });

        $('input[name="modulos[]"]').change(function() {

            var nIdModulo = $(this).val();
            var sHtmlTag = "#content-submodulos-" + nIdModulo;

            if($(this).is(':checked')){

                $(`input[data-nidpadre="${nIdModulo}"]`).each(function(){
                    console.log(true);
                    var sNameRadioRol = "radio-submodulo-rol-"+$(this).val();
                    $(this).prop("checked", true);
                    $('input:radio[name='+sNameRadioRol+']').val(['1']);
                });
            
            } else {

                $(`input[data-nidpadre="${nIdModulo}"]`).each(function(){
              
                    var sNameRadioRol     = "radio-submodulo-rol-" + $(this).val();
                    var sNameRadioDefault = "#radio-submodulo-default-"+  $(this).val();
                    
                    $(this).prop("checked", false);
                    
                    $('input:radio[name='+sNameRadioRol+']').val(['']);

                    $(sNameRadioDefault).val(['']);
                });
            }
       
        });

        $('input[name="submodulos[]"]').change(function() {

            var nIdSubModulo = $(this).val();
            var nIdPadre     = $(this).data("nidpadre");
            var sUrl         = $(this).data("surl");

            var nIdPadreSubModulo = $(this).data("nidpadresubmodulo");
            var sNameRadioRol = "radio-submodulo-rol-"+$(this).val();

            if($(this).is(':checked')){

                $("#check-modulo-"+nIdPadre).prop("checked",true);
                $('input:radio[name='+sNameRadioRol+']').val(['1']);


                // Si el submodulo es padre 
                if(sUrl == "#"){
                     $(`input[data-nidpadresubmodulo="${nIdSubModulo}"]`).each(function(){
                        var sNameRadioRolSubItem = "radio-submodulo-rol-"+$(this).val();
                        $('input:radio[name='+sNameRadioRolSubItem+']').val(['1']);
                        $(this).prop("checked",true);
                    });
                }

                // Si el submodulo es hijo 
                if(nIdPadreSubModulo != 0){
                    $("#check-submodulo-" + nIdPadreSubModulo).prop("checked",true);
                }

            } else {

               

                // Si el submodulo es padre 
                if(sUrl == "#"){

                    $(`input[data-nidpadresubmodulo="${nIdSubModulo}"]`).each(function(){
 
                        var sNameRadioRol     = "radio-submodulo-rol-" + $(this).val();
                        var sNameRadioDefault = "#radio-submodulo-default-"+  $(this).val();
                        
                        $(this).prop("checked", false);
                        
                        $('input:radio[name='+sNameRadioRol+']').val(['']);
                        $(sNameRadioDefault).val(['']);

                    });

                }

                // Si el submodulo es hijo
                if(nIdPadreSubModulo != 0){

                    var bExisteUnCheckedSubItem = false;
                    
                    $(`input[data-nidpadresubmodulo='${nIdPadreSubModulo}']`).each(function(){
                        if($(this).is(':checked')){
                            bExisteUnCheckedSubItem = true ;
                        }
                    });

                    if(bExisteUnCheckedSubItem){
                        $("#check-submodulo-"+nIdPadreSubModulo).prop("checked",true);
                    } else {
                        $("#check-submodulo-"+nIdPadreSubModulo).prop("checked",false);
                    }

                }

                setTimeout(() => {

                    // Limpiampsm el radio button
                    $('input:radio[name='+sNameRadioRol+']').val(['']);

                    var bExisteUnChecked = false ; 
                    var sHtmlTag = "#content-submodulos-"+nIdPadre;

                    $(sHtmlTag).find(".col-12").find(".col-9").find("input").each(function(){
                        if($(this).is(':checked')){
                            bExisteUnChecked = true ;
                        }
                    });

                    if(bExisteUnChecked){
                        $("#check-modulo-"+nIdPadre).prop("checked",true);
                    } else {
                        $("#check-modulo-"+nIdPadre).prop("checked",false);
                    }
                    
                }, 100);

              
            
            }

        });

    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarRegistro ( nIdRegistro ) {

        fncMsg(1, 'Esta acción eliminará permanentemente el registro y no podrá deshacerse. ¿ Esta seguro de continuar ?', 
        function(){
             
            var jsnData = {
                nIdRegistro : nIdRegistro
            };

            fncEjecutarEliminarRegistro( jsnData , function(aryData){

                if(aryData.success){
                    $('#table').bootstrapTable('refresh');
                    toastr.success( aryData.success );
                } else {
                    toastr.error( aryData.error );
                }

            }); 

        });
        
    }

    function fncMostrarRegistro(nIdRegistro,sOpcion) {
        
        fncCleanAll();

        $("#formRol").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarRegistro(jsnData, function(aryResponse){
            
                if (aryResponse.success) {

                    var aryDataRol = aryResponse.aryData.aryDataRol;
                    var aryModulos = aryResponse.aryData.aryModulos;

                    $("#sNombreRol").val(aryDataRol.sNombreRol);
                    $("#sDetalleRol").val(aryDataRol.sDetalle);

                    if(aryModulos.length>0){
                        aryModulos.forEach(function(aryItem, nIndex, ary) {
                            
                            $('#check-modulo-' + aryItem.nIdModulo).prop('checked', true);
                            
                            if(aryItem.arySubModulos.length > 0){
                             
                                aryItem.arySubModulos.forEach(function(aryItemSubModulo, nIndexSubModulo) {

                                    $("#check-submodulo-"+aryItemSubModulo.nIdSubModulo).prop('checked', true);

                                    if(aryItemSubModulo.nExisteRol == 1){
                                        var sNameRadioRol = "radio-submodulo-rol-"+aryItemSubModulo.nIdSubModulo;
                                        $('input:radio[name='+sNameRadioRol+']').val([aryItemSubModulo.nRolSubModulo]);
                                    }

                                    if(aryItemSubModulo.nDefault == 1){
                                        $("#radio-submodulo-default-"+aryItemSubModulo.nIdSubModulo).prop('checked', true);
                                    }
                                
                                });

                            }

                        });
                    }

                    if(sOpcion == 'editar'){
                        fncEditForm("#formRol" , "Editar Rol");
                    } else {
                        fncViewForm("#formRol" , "Ver Rol");
                    }

                    $("#formRol").modal("show");

                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    function fncValidateRol(){

        if($("body").data("nadmin") == 1){
            // Si es admin
        } else {
            $("#btnCrearRol").hide();
        }
    }

    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formRol").find("form") );
        fncClearInputs( $("#formRol").find("form") );
    }

    // Llamadas al servidor

    function fncGrabarRol(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'roles/fncGrabarRol',
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

    function fncEjecutarEliminarRegistro ( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'roles/fncEliminarRol',
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

    function fncBuscarRegistro(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'roles/fncMostrarRol',
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
</html>