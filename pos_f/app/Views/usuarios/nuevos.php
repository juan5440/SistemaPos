<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>

            <?php if (isset($validation)){ ?>
            <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
            </div>
            <?php }?>

            <form action="<?php echo base_url();?>/usuarios/insertar" method="POST" autocomplete="off">
               
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Usuario</label>
                            <input class="form-control" type="text" name="usuario" id="usuario"
                            value="<?php echo set_value('usuario') ?>" autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="nombre"
                            value="<?php echo set_value('nombre') ?>"  required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" id="password"
                            value="<?php echo set_value('password') ?>"  required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Repite la contraceña</label>
                            <input class="form-control" type="password" name="repassword" id="repassword"
                            value="<?php echo set_value('repassword') ?>"  required />
                        </div>
                    </div>
                </div>

                   <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Caja</label>
                            <select class="form-control" id="id_caja" name="id_caja" required>
                                <option value="">Seleccionar caja</option>
                                <?php foreach ($cajas as $caja) {?>
                                    <option value="<?php echo $caja['id']; ?>"><?php echo $caja['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Rol</label>
                            <select class="form-control" id="id_rol" name="id_rol" required>
                                <option value="">Seleccionar Rol</option>
                                <?php foreach ($roles as $rol) {?>
                                    <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                                <?php } ?>
                            </select>                       
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url();?>/usuarios" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
            
        </div>
    </main>