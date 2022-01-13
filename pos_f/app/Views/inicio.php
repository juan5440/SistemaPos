<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

        	<br>

        	<div class="row">
        		<div class="col-4">
        			<div class="card text-white bg-primary">
        				<div class="card-body">
        					<p><?php echo $total;?>  Total de productos</p>
        				</div>
        				<a href="<?php echo base_url()?>/productos" class="card-footer text-white">Ver detalle</a>
        			</div>
        		</div>

        		<div class="col-4">
        			<div class="card text-white bg-success">
        				<div class="card-body">
        					<p> $ <?php echo $totalVentas['total'];?>  Ventas echas en el dia</p>
        				</div>
        				<a href="<?php echo base_url()?>/ventas" class="card-footer text-white">Ver detalle</a>
        			</div>
        		</div>

        		<div class="col-4">
        			<div class="card text-white bg-danger">
        				<div class="card-body">
        					<p><?php echo $minimo;?>  Productos con Stock mínimo</p>
        				</div>
        				<a href="<?php echo base_url()?>/productos/mostrarMinimos" class="card-footer text-white">Ver detalle</a>
        			</div>
        		</div>

        	</div>


        </div>
</main>