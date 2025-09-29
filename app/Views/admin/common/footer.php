<!-- Modales Generales -->

<div class="modal fade" id="formUsuarioEdit" tabindex="-1" role="dialog" aria-labelledby="formUsuarioEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="formUsuarioEditLabel">Editar Usuario</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="sNombreUsuarioE" class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" id="sNombreUsuarioE" autocomplete="off" name="sNombreUsuarioE">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="sApellidosUsuarioE" class="col-form-label">Apellidos:</label>
                                <input type="text" class="form-control" id="sApellidosUsuarioE" autocomplete="off" name="sApellidosUsuarioE">
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="sEmailUsuarioE" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="sEmailUsuarioE" autocomplete="off" name="sEmailUsuarioE">
                            </div>
                        </div>


                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="sLoginUsuarioE" class="col-form-label">Login:</label>
                                <input type="text" class="form-control" id="sLoginUsuarioE" autocomplete="off" name="sLoginUsuarioE">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="sClaveUsuarioE" class="col-form-label">Clave:</label>
                                <input type="text" class="form-control" id="sClaveUsuarioE" autocomplete="off" name="sClaveUsuarioE">
                            </div>
                        </div>



                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="sImagenUsuarioE" class="col-form-label">
                                    Imagen Login:
                                    <img src="" class="img-referencial" alt="">
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="sImagenUsuarioE" accept="image/*" lang="es" name="sImagenUsuarioE">
                                        <label class="custom-file-label" for="sImagenUsuarioE">Elija el archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="sImagenLogoGeneral" class="col-form-label">
                                    Imagen Logo General:
                                    <img src="" class="img-referencial" alt="">
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="sImagenLogoGeneral" accept="image/*" lang="es" name="sImagenLogoGeneral">
                                        <label class="custom-file-label" for="sImagenLogoGeneral">Elija el archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="sImagenFondoLogin" class="col-form-label">Fondo Para Login:
                                    <img src="" class="img-referencial" alt="">
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="sImagenFondoLogin" accept="image/*" lang="es" name="sImagenFondoLogin">
                                        <label class="custom-file-label" for="sImagenFondoLogin">Elija el archivo</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="sLinkEmpresas" class="col-form-label">Link Acceso de empresas:</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="sLinkEmpresas" id="sLinkEmpresas" class="form-control">
                                    <div class="input-group-append">
                                        <span id="btnCopyLinkAcceso" class="input-group-text cursor-pointer">
                                            <span class="material-icons">
                                                content_copy
                                            </span>
                                        </span>
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


<div class="modal fade" id="formEmpleadoE" tabindex="-1" role="dialog" aria-labelledby="formEmpleadoELabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="formEmpleadoELabel">Editar Empleado</h5>
                    <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nTipoDocumentoEmpleadoE" class="col-form-label">Tipo Documento <span class="text-danger">*</span> </label>
                                <select class="form-control" name="nTipoDocumentoEmpleadoE" id="nTipoDocumentoEmpleadoE">
                                    <option value="0">SELECCIONAR</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sNumeroDocumentoEmpleadoE" class="col-form-label">Numero de documento <span class="text-danger">*</span> </label>
                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNumeroDocumentoEmpleadoE" id="sNumeroDocumentoEmpleadoE">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sNombreEmpleadoE" class="col-form-label">Nombre <span class="text-danger">*</span> </label>
                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sNombreEmpleadoE" id="sNombreEmpleadoE">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sDireccionEmpleadoE" class="col-form-label">Direccion</label>
                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sDireccionEmpleadoE" id="sDireccionEmpleadoE">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sTelefonoEmpleadoE" class="col-form-label">Telefono</label>
                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sTelefonoEmpleadoE" id="sTelefonoEmpleadoE">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sCorreoEmpleadoE" class="col-form-label">Correo <span class="text-danger">*</span> </label>
                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sCorreoEmpleadoE" id="sCorreoEmpleadoE">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sLoginEmpleadoE" class="col-form-label">Login <span class="text-danger">*</span> </label>
                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sLoginEmpleadoE" id="sLoginEmpleadoE">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sClaveLoginE" class="col-form-label">Clave <span class="text-danger">*</span> </label>
                                <input type="text" autocomplete="off" placeholder="" class="form-control" name="sClaveLoginE" id="sClaveLoginE">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nIdRolEmpleadoE" class="col-form-label">Rol <span class="text-danger">*</span> </label>
                                <select class="form-control" name="nIdRolEmpleadoE" id="nIdRolEmpleadoE">
                                    <option value="0">SELECCIONAR</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Imagen</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="sImagenEmpleadoE" accept="image/*" name="sImagenEmpleadoE" lang="es">
                                        <label class="custom-file-label" for="sImagenEmpleadoE">Selecciona un archivo</label>
                                    </div>
                                </div>
                                <small>Recomendado 128px x 128px</small>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nEstadoEmpleadoE" class="col-form-label">Estado</label>
                                <select class="form-control" name="nEstadoEmpleadoE" id="nEstadoEmpleadoE">
                                    <option value="1">ACTIVO</option>
                                    <option value="0">DESACTIVO</option>
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



<div class="modal fade" id="mdlVerImagen" tabindex="-1" role="dialog" aria-labelledby="mdlVerImagen" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formEmpleadoELabel">Ver Imagen</h5>
                <button type="button" class="btn btn-close btn-gradient-primary btn-rounded p-0" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body ">
                <img id="mdlVerImagenImg" class="d-block" src="" alt="">

            </div>

        </div>
    </div>
</div>

<!-- End Modales Generales -->