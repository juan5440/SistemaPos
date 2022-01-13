<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemporalCompraModel;
use App\Models\ProductosModel;

class TemporalCompra extends BaseController
{
	protected $temporal_compra, $productos;
	protected $reglas;

	public function __construct()
	{
		$this->temporal_compra = new TemporalCompraModel();
		$this->productos = new ProductosModel();
	}


	public function inserta($id_producto, $cantidad, $factura, $proveedor, $id_compra)
	{
		$error = '';

		$producto = $this->productos->where('id', $id_producto)->first();

		if($producto){
			$datosExiste = $this->temporal_compra->porIdProductoCompra($id_producto, $id_compra);

			if($datosExiste) {
				$cantidad = $datosExiste->cantidad + $cantidad;
				$subtotal = $cantidad * $datosExiste->precio;
				$factura = $datosExiste->factura == $factura;
				$proveedor = $datosExiste->proveedor == $proveedor;

				$this->temporal_compra->actualizarProductoCompra($id_producto, $id_compra, $cantidad, $subtotal);
			}else{
				$subtotal = $cantidad * $producto['precio_compra'];

				$this->temporal_compra->save([
					'folio' => $id_compra,
					'factura' => $factura,
					'id_producto' => $id_producto,
					'codigo' => $producto['codigo'],
					'nombre' => $producto['nombre'],
					'proveedor' => $proveedor,
					'precio' => $producto['precio_compra'],
					'cantidad' => $cantidad,
					'subtotal' => $subtotal,
 				]);
			}
		}else{
			$error = 'No Existe el producto';
		}
		$res['total'] = number_format($this->totalProducto($id_compra), 2, '.', ',');
		$res['datos'] = $this->cargaProducto($id_compra);
		$res['error'] = $error;
		echo json_encode($res);

	}


	public function cargaProducto($id_compra){

		$resultado = $this->temporal_compra->porCompra($id_compra);
		$fila = ' ';
		$numFila = 0;

		foreach ($resultado as $row) {
			$numFila++;
			$fila .= "<tr id='fila" . $numFila . "'>";
			$fila .= "<td>" . $numFila . "</td>";
			$fila .= "<td>" . $row['factura'] . "</td>";
			$fila .= "<td>" . $row['codigo'] . "</td>";
			$fila .= "<td>" . $row['nombre'] . "</td>";
			$fila .= "<td>" . $row['proveedor'] . "</td>";
			$fila .= "<td>" . $row['precio'] . "</td>";
			$fila .= "<td>" . $row['cantidad'] . "</td>";
			$fila .= "<td>" . $row['subtotal'] . "</td>";
			$fila .= "<td><a onclick=\"eliminaProducto(" . $row['id_producto'] . ", '" . $id_compra . "')\" class='borrar' ><span  class='fas fa-fw fa-trash'></span></a></td>";
			$fila .= "</tr>";
		}

		return $fila;

	}



	public function totalProducto($id_compra){

		$resultado = $this->temporal_compra->porCompra($id_compra);

		$total = 0;

		foreach ($resultado as $row) {
			$total += $row['subtotal'];
		}

		return $total;

	}

	public function eliminar($id_producto, $id_compra){

		$datosExiste = $this->temporal_compra->porIdProductoCompra($id_producto, $id_compra);
		if($datosExiste){
			if($datosExiste->cantidad > 1){
				$cantidad = $datosExiste->cantidad - 1;
				$subtotal = $cantidad * $datosExiste->precio;
				$this->temporal_compra->actualizarProductoCompra($id_producto, $id_compra, $cantidad, $subtotal);
			}else{
				$this->temporal_compra->eliminarProductoCompra($id_producto, $id_compra);
			}
		}

		$res['total'] = number_format($this->totalProducto($id_compra),2, '.', ',');
		$res['datos'] = $this->cargaProducto($id_compra);
		$res['error'] = '';
		echo json_encode($res);
	}


}

