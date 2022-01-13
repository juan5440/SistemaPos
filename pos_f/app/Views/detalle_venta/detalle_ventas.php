<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url();?>/ventas/eliminados" class="btn btn-danger" >Eliminados</a>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Factura</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $dato) { ?>
                            <tr>
                               <?php $contador = 1;?>
                                <td><?php echo $contador;?></td>
                                <td><?php echo $dato['factura'];?></td>
                                <td><?php echo $dato['codigo'];?></td>
                                <td><?php echo $dato['nombre'];?></td>
                                <td><?php echo $dato['cantidad'];?></td>
                                <td><?php echo $dato['precio'];?></td>
                                <td><?php echo $dato['tota'];?></td>4
                                <?php $contador++; ?>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
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
