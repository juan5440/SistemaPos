<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo;?></h4>
            
            <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
            </div>
            <?php }?>

            <form action="<?php echo base_url();?>/productos/insertar" method="POST" enctype="multipart/form-data" autocomplete="off">
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Codigo</label>
                            <input class="form-control" type="text" name="codigo" id="codigo"
                            autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="nombre"
                            required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Unidad</label>
                            <select class="form-control" id="id_unidad" name="id_unidad" required>
                                <option value="">Seleccionar unidad</option>
                                <?php foreach ($unidades as $unidad) {?>
                                    <option value="<?php echo $unidad['id']; ?>"><?php echo $unidad['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Categorias</label>
                            <select class="form-control" id="id_categoria" name="id_categoria" required>
                                <option value="">Seleccionar categoria</option>
                                <?php foreach ($categorias as $categoria) {?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                                <?php } ?>
                            </select>                       
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Precio Venta</label>
                            <input class="form-control" type="text" name="precio_venta" id="precio_venta"
                             required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Precio Compra</label>
                            <input class="form-control" type="text" name="precio_compra" id="precio_compra"
                            required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Stock Minimo</label>
                            <input class="form-control" type="text" name="stock_minimo" id="stock_minimo"
                             required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Es Inventariable</label>
                            <select class="form-control" id="inventariable" name="inventariable">
                                <option value="">Selecciona</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Existencias</label>
                            <input class="form-control" type="text" name="existencias" id="existencias"
                             required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Inicial</label>
                            <input class="form-control" type="text" name="inicial" id="inicial"
                            required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Cosnto Unitario</label>
                            <input class="form-control" type="text" name="costo_unitario" id="costo_unitario"
                            required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                           <label>Imagen de producto</label>
                           <br>
                           <input type="file" name="img_producto" id="img_producto" accept="image/*">
                           <p class="text-danger">Carga imagen en formato png de 150x150 pixeles</p> 
                        </div>
                    </div>
                </div>


                <a href="<?php echo base_url();?>/productos" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>

        </div>
    </main>