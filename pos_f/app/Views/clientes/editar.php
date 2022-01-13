<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>
            
             <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
            </div>
            <?php }?>

            <form action="<?php echo base_url();?>/clientes/actualizar" method="POST" autocomplete="off">
                

                <input type="hidden" value="<?php echo $cliente['id'];?>" id="id" name="id">

                 <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" type="text" value="<?php echo $cliente['nombre'];?>" name="nombre" id="nombre"
                            autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Dirección</label>
                            <input class="form-control" type="text" value="<?php echo $cliente['direccion'];?>" name="direccion" id="direccion"
                             />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Teléfono</label>
                            <input class="form-control" type="tel" value="<?php echo $cliente['telefono'];?>" name="telefono" id="telefono"
                              />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Correo</label>
                            <input class="form-control" type="email" value="<?php echo $cliente['correo'];?>" name="correo" id="correo"
                             />
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url();?>/clientes" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>

        </div>
    </main>