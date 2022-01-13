<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>

             <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
            </div>
            <?php }?>
            
            <form action="<?php echo base_url();?>/configuracion/actualizar" method="POST" enctype="multipart/form-data" autocomplete="off">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre de la tienda:</label>
                            <input class="form-control" type="text" name="tienda_nombre" id="tienda_nombre"
                            value="<?php echo $nombre['valor']; ?>" required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>RFC</label>
                            <input class="form-control" type="text" name="tienda_rfc" id="tienda_rfc"
                            value="<?php echo $rfc['valor']; ?>"  required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Teléfono</label>
                            <input class="form-control" type="text" name="tienda_telefono" id="tienda_telefono"
                            value="<?php echo $telefono['valor']; ?>"  required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Correo electrónico</label>
                            <input class="form-control" type="text" name="tienda_email" id="tienda_email"
                            value="<?php echo $email['valor']; ?>"  required />
                        </div>
                    </div>
                </div>

                 <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Dirección</label>
                            <textarea class="form-control" id="tienda_direccion" name="tienda_direccion" required><?php echo $direccion['valor']; ?></textarea>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Leyenda ticket</label>
                            <textarea class="form-control" id="ticket_leyenda" name="ticket_leyenda" required><?php echo $leyenda['valor']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                           <label>Logotipo</label>
                           <br>
                           <img src="<?php echo base_url() . '/imagenes/logotipo.png'; ?>" class="img-responsive" width="200">
                           <br>
                           <input type="file" name="tienda_logo" id="tienda_logo" accept="image/png">
                           <p class="text-danger">Carga imagen en formato png de 150x150 pixeles</p> 
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url();?>/configuracion" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>

        </div>
    </main>

 <!-- Modal -->
<div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar este registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
        <a class="btn btn-danger btn-ok">Si</a>
      </div>
    </div>
  </div>
</div>
