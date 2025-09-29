<!DOCTYPE html>
<html class="no-js h-100" lang="es">

<head>
    <?php extend_view(['admin/common/head'], $data) ?>

</head>

<body data-nadmin ="<?=$nAdmin?>">

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
                                                        <button id="btnCrearCategoria" class="btn btn-gradient-primary btn-rounded btn-icon">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin de Fila Cabecera -->

                                        <div class="row my-2">
                                            <div class="col-12">
                                                <table data-toggle="table" id="table" data-url="<?= route('categorias/fncPopulate') ?>" data-toggle="table" data-search="true" data-query-params="queryParams" toolbarAlign="left" data-show-refresh="true" data-pagination="true" data-toolbar="#toolbar" data-buttons-align="left" data-show-columns="true" data-pagination-h-align="left" data-pagination-detail-h-align="right" data-classes="table table-hover table-condensed" data-striped="true" data-buttons-class="gradient-primary-table" data-card-view="false" data-page-size="14" data-sort-name="" data-sort-order="asc">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="sAcciones">Acciones</th>
                                                            <th data-field="sNombre" data-sortable="true">Nombre</th>
                                                            <th data-field="sNombrePadre" data-sortable="true">Cat. Padre</th>
                                                            <th data-field="sImagen" data-sortable="true">Imagen</th>
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

    <div class="modal fade" id="formCategoria" tabindex="-1" role="dialog" aria-labelledby="formCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCategoriaLabel">Nuevo Categoria</h5>
                        <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="sNombre" class="col-form-label">Nombre: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sNombre" autocomplete="off" name="sNombre">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nIdPadre" class="col-form-label">Categoria Padre:</label>
                                    <select class="form-control" name="nIdPadre" id="nIdPadre">
                                        <option value="0">NINGUNA</option>
                                     </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="col-form-label">Imagen:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sImagen" accept="image/*" lang="es" name="sImagen">
                                            <label class="custom-file-label" for="sImagen">Elija el archivo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nEstado" class="col-form-label">Estado:</label>
                                    <select class="form-control" name="nEstado" id="nEstado">
                                        <option value="1">Activo</option>
                                        <option value="0">Desactivo</option>
                                    </select>
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
        
        fncValidarRol();
        fncDrawCategoria("#nIdPadre");

        // Formulario Categorias
        $("#btnCrearCategoria").on('click', function() {
            fncCleanAll();
            fncDrawCategoria("#nIdPadre");
            $("#formCategoria").find(".modal-title").html('Nueva Categoria');
            $("#formCategoria").data("nIdRegistro",0);
            $("#formCategoria").modal("show");
        });

        $("#formCategoria").find('form').on('submit', function(event) {
            
            event.preventDefault();

            var nIdRegistro  = $("#formCategoria").data("nIdRegistro");
            var sNombre      = $("#sNombre").val().trim();
            var sImagen      = $("#sImagen")[0].files[0];
            var nIdPadre     = $("#nIdPadre").val();
            var nEstado      = $("#nEstado").val();

            if(sNombre == ''){
                toastr.error('Error. Debe ingresar el nombre de la categoria.');
                return false;
            } 
            
            var formData = new FormData();
            formData.append('nIdRegistro', nIdRegistro);
            formData.append('sNombre', sNombre);
            formData.append('nIdPadre', nIdPadre);
            formData.append('sImagen',sImagen);
            formData.append('nEstado', parseInt( nEstado ))

            fncGrabarCategoria(formData,function(aryData){
                if(aryData.success){
                    fncCleanAll();
                    $("#formCategoria").modal("hide");
                    $('#table').bootstrapTable('refresh');
                    toastr.success(aryData.success);
                }else{
                    toastr.error(aryData.error);
                }
            });    
        });

 

        

    });

    // Funciones de la tabla o layout Principal 

    function fncEliminarCategoria ( nIdRegistro ) {

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

    function fncMostrarCategoria(nIdRegistro,sOpcion) {
       
        fncCleanAll();
       
        $("#formCategoria").data("nIdRegistro",nIdRegistro);
      
        var jsnData = {
            nIdRegistro: nIdRegistro
        };
     
        fncBuscarRegistro(jsnData, function(aryResponse){
            
                if (aryResponse.success) {
                    var aryData = aryResponse.aryData;

                    $("#sNombre").val(aryData.sNombre);
                    $("#nEstado").val(aryData.nEstado);
                    
                    $("#nIdPadre").find("option").each(function(){
                        $(this).show();
                    });

                    $('#nIdPadre option[value="' + nIdRegistro + '"]').hide();

                    if(aryData.sImagen.length > 0) $("label[for='sImagen']").html(aryData.sImagen);
                    if(sOpcion == 'editar'){
                        fncEditForm("#formCategoria" , "Editar Categoria");
                    } else {
                        fncViewForm("#formCategoria" , "Ver Categoria");
                    }

                    $("#formCategoria").modal("show");
                } else {
                    toastr.error(aryData.error);
                }
        });

    }

    function fncDrawCategoria(sHtmlTag){
        
        var jsnData = {};
        
        fncObtenerArbolCategorias(jsnData,(aryData)=>{
            if(aryData.success){
                
                toastr.success(aryData.success);

                var aryData = aryData.aryData;
                
                var sHtml = `<option value="0">NINGUNA</option>`;

                if(aryData.length >0){

                    aryData.forEach(element => {
                        sHtml += `<option value="${element.nIdCategoria}">${element.sNombre}</option>`;
                    });

                }

                $(sHtmlTag).html(sHtml);

            } else {
                toastr.error(aryData.error);
            }
        });
    }


    function fncValidarRol (){
        if($("body").data("nadmin") == 1){
            // es admin
        } else {
            $("#btnCrearCategoria").hide();
        }
    }


    // Funciones Auxiliares
    function fncCleanAll(){
        fncRemoveDisabled( $("#formCategoria").find("form") );
        fncClearInputs( $("#formCategoria").find("form") );
    }

    // Llamadas al servidor

    function fncGrabarCategoria(formData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root + 'categorias/fncGrabarCategoria',
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

    function fncEjecutarEliminarRegistro ( jsnData , fncCallback ) {    
        $.ajax({
            type: 'post',
            url: web_root + 'categorias/fncEliminarCategoria',
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
            url: web_root +  'categorias/fncMostrarCategoria',
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

    function fncObtenerArbolCategorias(jsnData, fncCallback) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: web_root +  'categorias/fncObtenerArbolCategorias',
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