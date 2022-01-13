<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>

            <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
            </div>
            <?php }?>

            <form action="<?php echo base_url();?>/usuarios/actualizar_password" method="POST" autocomplete="off">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Usuario</label>
                            <input class="form-control" type="text" name="usuario" id="usuario" value="<?php echo $usuario['usuario'];?>" disabled />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="nombre"
                            required value="<?php echo $usuario['nombre'];?>"  />
                        </div>
                    </div>
                </div>

                 <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Contraseña</label>
                            <input class="form-control" type="password" name="password" id="password" required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Confirma Contraseña</label>
                            <input class="form-control" type="password" name="repassword" id="repassword"
                            required  />
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url();?>/usuarios" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>

                <?php if(isset($mensaje)){ ?>
                    <div class="alert alert-success">
                        <?php echo $mensaje; ?>
                    </div>
                <?php }?>
            </form>
            
        </div>
    </main>