<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>
            
            <div>
                <p>
                    <a href="<?php echo base_url();?>/productos" class="btn btn-info" >Productos</a>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Unidad</th>
                            <th>Inicial</th>
                            <th>Precio Venta</th>
                            <th>Precio Compra</th>
                            <th>Existencias</th>
                            <th>Costo Unitario</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datos as $dato) { ?>
                            <tr>
                                <td><?php echo $dato['codigo'];?></td>
                                <td><?php echo $dato['nombre'];?></td>
                                <td><?php echo $dato['id_unidad']; ?></td>
                                <td><?php echo $dato['inicial'];?></td>
                                <td><?php echo $dato['precio_venta'];?></td>
                                <td><?php echo $dato['precio_compra'];?></td>
                                <td><?php echo $dato['existencias'];?></td>
                                <td><?php echo $dato['costo_unitario'];?></td>

                                 <td><a href="#" data-href="<?php echo base_url(). '/productos/reingresar/'. $dato['id'];?>" data-toggle="modal" data-target="#modal-confirma" data-placement="top" title="Reingresar Registro"  class="btn btn-success" ><i class="  fas fa-arrow-alt-circle-up"></i></a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Reingresar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea reingresar este registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
        <a class="btn btn-danger btn-ok">Si</a>
      </div>
    </div>
  </div>
</div>