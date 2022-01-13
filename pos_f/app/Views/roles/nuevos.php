<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>

            <?php if (isset($validation)){ ?>
            <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
            </div>
            <?php }?>

            <form action="<?php echo base_url();?>/roles/insertar" method="POST" autocomplete="off">
               
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Rol de Usuario</label>
                            <input class="form-control" type="text" name="nombre" id="nombre"
                            value  required />
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url();?>/roles" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
            
        </div>
    </main>