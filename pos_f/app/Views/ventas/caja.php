<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid">

			<?php $idVentaTmp = uniqid(); ?>

			<br>

			<form id="from_venta" name="from_venta" class="form-horizontal" method="POST" action="<?php echo base_url(); ?>/ventas/inserta" autocomplete="off">

				<input type="hidden" name="id_venta" id="id_venta" value="<?php echo $idVentaTmp; ?>" >

				<div class="form-group">
					<div class="row">
						<div class="col-sm-4 ">
							<div class="ui-widget">
								<label>Cliente:</label>
								<input type="hidden" id="id_cliente" name="id_cliente" value="1">
								<input type="text" class="form-control" name="cliente" id="cliente" placeholder="Escribe el nombre del cliente" value autocomplete="off" required>
							</div>
						</div>

						<div class="col-sm-4">
                            <label>Factura</label>
                            <input class="form-control" type="text" name="factura" id="factura" />
                        </div>

						<div class="col-sm-4 ">
							<label>Forma de pago:</label>
							<select id="forma_pago" name="forma_pago" class="form-control" required>
								<option>Efectivo</option>
								<option>Credito</option>
								<option>Tranferencia</option>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">

						<div class="col-12 col-sm-3">
							<input type="hidden" name="id_producto" id="id_producto"/>
							<label>Código de barras:</label>

							<input class="form-control" type="text" name="codigo" id="codigo" placeholder="Escribe el codigo y enter" onkeyup="agregarProducto(event, this.value, 1, factura.value, '<?php echo $idVentaTmp; ?>');" autofocus />

						</div>
						<dir class="col-sm-2">
							<label for="codigo" id="resultado_error" style="color: red;"></label>
						</dir>
						<div class="col-12 col-sm-12 col-md-4">
							<label style='font-weight:bold; font-size:30px; text-align:center;'> Total $</label><input type="text" name="total" id="total" size="7" readonly="true" value="0.00" style='font-weight:bold; font-size:30px; text-align:center; border:#E2EBED; background:#ffffff' />
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							<button id="completa_venta" type="button" class="btn btn-success">Completar venta</button>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos" width="100%">
						<thead class="thead-dark">
							<tr>
								<th>#</th>
								<th>Código</th>
								<th>Nombre</th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Total</th>
								<th width='1%'></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</form>
			</div>
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
		
		$( function() {
		$("#cliente").autocomplete({
        	source: "<?php echo base_url(); ?>/clientes/autocompleteData",
			minLength: 3,
        	select: function( event, ui ) {
            	event.preventDefault();
				$("#id_cliente").val(ui.item.id);
				$("#cliente").val(ui.item.value);
        	}
    	});
	} );

		$(document).ready(function(){
			$("#codigo").autocomplete({
				source: "<?php echo base_url(); ?>/productos/autocompleteData",
				minLength: 2,
				focus: function() {
					return false;
				},
				select: function( event, ui ) {
					event.preventDefault();
					$("#codigo").val(ui.item.value);
					setTimeout(
						function() 
						{
							e = jQuery.Event("keypress");	
							e.which = 13;
							agregarProducto(e, ui.item.id, 1, factura.value, '<?php echo $idVentaTmp; ?>');
						}

						)
				}
			});
		} );

	         function agregarProducto(e, id_producto, cantidad, factura, id_venta){
	         	let enterKey = 13;
	         	if (codigo != '') {
	         		if (e.which == enterKey){
            if(id_producto != null && id_producto != 0 && cantidad > 0){
                    $.ajax({
                        url: '<?php echo base_url(); ?>/TemporalVenta/inserta/' + id_producto + "/" + cantidad + "/" + factura + "/" + id_venta , 
                        success: function(resultado){
                            if(resultado == 0){
                               
                            }else{
                                var resultado = JSON.parse(resultado);

                                if(resultado.error ==''){
                                    $("#tablaProductos tbody").empty();
                                    $("#tablaProductos tbody").append(resultado.datos);
                                    $("#total").val(resultado.total);
                                    $("#factura").val('');
                                    $("#id_producto").val('');
                                    $("#codigo").val('');
                                    $("#nombre").val('');
                                    $("#cantidad").val('');
                                    $("#precio_venta").val('');
                                    $("#subtotal").val('');
                                }
                            }
                        }
                    });
                }
            }
        }
    }

    function eliminaProducto(id_producto, id_venta){
                $.ajax({
                    url: '<?php echo base_url(); ?>/TemporalVenta/eliminar/' + id_producto +"/"+id_venta, 
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

            $(function(){
            	$('#completa_venta').click(function(){
            		let nFilas = $("#tablaProductos tr").length;
            		if(nFilas < 2) {
            			$('#modalito').modal('show');
            			muestraModal('Aviso', 'Debe agregar un producto para completar la venta.');
            		}else{
            			$("#from_venta").submit();
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

	</script>