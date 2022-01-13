
<?php 
$id_compra = uniqid();
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

            <form action="<?php echo base_url();?>/compras/guarda" method="POST" id="form_compra" name="form_compra" autocomplete="off">

                <div class="form-group">
                    <div class="row">

                         <div class="col-12 col-sm-3">
                            <label>Factura</label>
                            <input class="form-control" type="text" name="factura" id="factura" />
                        </div>

                        <div class="col-12 col-sm-3">
                             <input type="hidden" name="id_compra" id="id_compra" value="<?php echo $id_compra ?>" />
                            <input type="hidden" name="id_producto" id="id_producto"/>
                            <label>Código</label>

                            <input class="form-control" type="text" name="codigo" id="codigo" placeholder="Escribe el codigo y enter" onkeyup="buscarProducto(event, this, this.value)" autofocus />

                             <label for="codigo" id="resultado_error" style="color: red;"></label>

                        </div>

                        <div class="col-12 col-sm-3">
                            <label>Nombre del producto</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" disabled/>
                        </div>

                        <div class="col-12 col-sm-3">
                            <label>Proveedor</label>
                            <input class="form-control" type="text" name="proveedor" id="proveedor" />
                        </div>

                        
                    </div>
                </div>

                 <div class="form-group">
                    <div class="row">

                         <div class="col-12 col-sm-3">
                            <label>Cantidad</label>
                            <input class="form-control" type="number" name="cantidad" id="cantidad" />
                        </div>

                        <div class="col-12 col-sm-3">
                            <label>Precio de Compra</label>
                            <input class="form-control" type="text" name="precio_compra" id="precio_compra" disabled />
                        </div>

                        <div class="col-12 col-sm-3">
                            <label>Subtotal</label>
                            <input class="form-control" type="text" name="subtotal" id="subtotal" disabled/>
                        </div>

                         <div class="col-12 col-sm-3">
                            <br>
                            <label>&nbsp;</label>
                            <button id="agregar_produto" name="agregar_produto" type="button" class="btn btn-primary" onclick="agregarProducto(id_producto.value, cantidad.value, factura.value, proveedor.value, '<?php echo $id_compra;?>')">Agregar Producto</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos" width="100%">
                        <thead class="thead-dark">
                            <th>#</th>
                            <th>Factura</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>proveedor</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th width="1%"></th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 offset-md-6">
                        <label style="font-weight: bold; font-size: 30px; text-align: center;">Total $</label>
                        <input type="text" name="total" id="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;">
                        <button type="button" id="completa_compra" class="btn btn-success">Completar compra</button>
                    </div>
                </div>
            </form>
            
        </div>
    </main>

    <div class="modal fade" id="AvanzaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="modal-title"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="modal-body"></div>
                <div class="modal-footer clearfix">
                    <button type="button" class="pull-left btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script> 
        $(document).ready(function(){
            $("#completa_compra").click(function(){
                let nFila = $("#tablaProductos tr").length;

                if (nFila < 2) {
                   $('#modalito').modal('show');
                   muestraModal('Aviso', 'Debe agregar un producto para completar la compra.');
                }else{
                    $("#form_compra").submit();
                }
            });
        });

        function muestraModal(titulo, mensaje) {
            $(document).ready(function() {
                $('#modal-title').html('<b>' + titulo + '</b>');
                $('#modal-body').html('<p>' + mensaje + '</p>');
                $('#AvanzaModal').modal('show');
            });     
        }

        function buscarProducto(e, tagCodigo, codigo){
            var enterkey = 13;

            if(codigo != ''){
                if(e.which == enterkey){
                    $.ajax({
                        url: '<?php echo base_url(); ?>/productos/buscarPorCodigo/' + codigo, 
                        dataType: 'json',
                        success: function(resultado){
                            if(resultado == 0){
                                $(tagCodigo).val('');
                            }else{

                                $("#resultado_error").html(resultado.error);

                                if(resultado.existe){
                                    $("#id_producto").val(resultado.datos.id);
                                    $("#nombre").val(resultado.datos.nombre);
                                    $("#cantidad").val(1);
                                    $("#precio_compra").val(resultado.datos.precio_compra);
                                    $("#subtotal").val(resultado.datos.precio_compra);
                                    $("#cantidad").focus();


                                }else{
                                    $("#id_producto").val('');
                                    $("#nombre").val('');
                                    $("#cantidad").val('');
                                    $("#precio_compra").val('');
                                    $("#subtotal").val('');
                                }
                            }
                        }
                    });
                }
            }
        }

         function agregarProducto(id_producto, cantidad, factura, proveedor, id_compra){
            if(id_producto != null && id_producto != 0 && cantidad > 0){
                    $.ajax({
                        url: '<?php echo base_url(); ?>/TemporalCompra/inserta/' + id_producto + "/" + cantidad + "/" + factura + "/" + proveedor + "/" + id_compra , 

                        success: function(resultado){
                            if(resultado == 0){
                               
                            }else{
                                var resultado = JSON.parse(resultado);

                                if(resultado.error ==''){
                                    $("#tablaProductos tbody").empty();
                                    $("#tablaProductos tbody").append(resultado.datos);
                                    $("#total").val(resultado.total);
                                    $("#id_producto").val('');
                                    $("#factura").val('');
                                    $("#codigo").val('');
                                    $("#nombre").val('');
                                    $("#proveedor").val('');
                                    $("#cantidad").val('');
                                    $("#precio_compra").val('');
                                    $("#subtotal").val('');
                                }
                            }
                        }
                    });
                }
            }
        
            function eliminaProducto(id_producto, id_compra){
                $.ajax({
                    url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto +"/"+id_compra, 
                    success: function(resultado){
                        if(resultado == 0){
                            $(tagCodigo).val('');
                        }else{
                            var resultado = JSON.parse(resultado);

                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(resultado.datos);
                            $("#total").val(resultado.total);
                        }
                    }
                });
            }


    </script>