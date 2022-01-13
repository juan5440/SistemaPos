<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\temporalventaModel;
use App\Models\ProductosModel;

class TemporalVenta extends BaseController
{
	protected $temporal_venta, $productos;
	protected $reglas;

	public function __construct()
	{
		$this->temporal_venta = new temporalventaModel();
		$this->productos = new ProductosModel();
	}


	public function inserta($id_producto, $cantidad, $factura, $id_venta) 
	{
		$error = '';

		$producto = $this->productos->where('id', $id_producto)->first();

		if($producto){
			$datosExiste = $this->temporal_venta->porIdProductoVenta($id_producto, $id_venta);

			if($datosExiste) {

				$cantidad = $datosExiste->cantidad + $cantidad;
				$subtotal = $cantidad * $datosExiste->precio;
				$factura = $datosExiste->factura == $factura;

				$this->temporal_venta->actualizarProductoVenta($id_producto, $id_venta, $cantidad, $subtotal);
			}else{
				$subtotal = $cantidad * $producto['precio_venta'];

				$this->temporal_venta->save([
					'folio' => $id_venta,
					'factura' => $factura,
					'id_producto' => $id_producto,
					'codigo' => $producto['codigo'],
					'nombre' => $producto['nombre'],
					'cantidad' => $cantidad,
					'precio' => $producto['precio_venta'],
					'subtotal' => $subtotal
 				]);
			}
		}else{
			$error = 'No Existe el producto';
		}
		$res['total'] = number_format($this->totalProducto($id_venta), 2, '.', ',');
		$res['datos'] = $this->cargaProducto($id_venta);
		$res['error'] = $error;
		echo json_encode($res);

	}


	public function cargaProducto($id_venta){

		$resultado = $this->temporal_venta->porVenta($id_venta);
		$fila = ' ';
		$numFila = 0;

		foreach ($resultado as $row) {
			$numFila++;
			$fila .= "<tr id='fila" . $numFila . "'>";
			$fila .= "<td>" . $numFila . "</td>";
			$fila .= "<td>" . $row['codigo'] . "</td>";
			$fila .= "<td>" . $row['nombre'] . "</td>";
			$fila .= "<td>" . $row['precio'] . "</td>";
			$fila .= "<td>" . $row['cantidad'] . "</td>";
			$fila .= "<td>" . $row['subtotal'] . "</td>";
			$fila .= "<td><a onclick=\"eliminaProducto(" . $row['id_producto'] . ", '" . $id_venta . "')\" class='borrar' ><span  class='fas fa-fw fa-trash'></span></a></td>";
			$fila .= "</tr>";
		}

		return $fila;

	}



	public function totalProducto($id_venta){

		$resultado = $this->temporal_venta->porVenta($id_venta);

		$total = 0;

		foreach ($resultado as $row) {
			$total += $row['subtotal'];
		}

		return $total;

	}

	public function eliminar($id_producto, $id_venta){

		$datosExiste = $this->temporal_venta->porIdProductoVenta($id_producto, $id_venta);
		if($datosExiste){
			if($datosExiste->cantidad > 1){
				$cantidad = $datosExiste->cantidad - 1;
				$subtotal = $cantidad * $datosExiste->precio;
				$this->temporal_venta->actualizarProductoVenta($id_producto, $id_venta, $cantidad, $subtotal);
			}else{
				$this->temporal_venta->eliminarProductoVenta($id_producto, $id_venta);
			}
		}

		$res['total'] = number_format($this->totalProducto($id_venta),2, '.', ',');
		$res['datos'] = $this->cargaProducto($id_venta);
		$res['error'] = '';
		echo json_encode($res);
	}


}

