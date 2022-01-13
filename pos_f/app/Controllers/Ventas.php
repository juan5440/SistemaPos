<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ventasModel;
use App\Models\temporalventaModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;

class Ventas extends BaseController
{
	protected $ventas, $temporal_venta, $detalle_venta, $productos, $configuracion,  $session;

	public function __construct()
	{
		$this->ventas = new ventasModel();
		$this->detalle_venta = new DetalleVentaModel();
		$this->productos = new ProductosModel();
		$this->configuracion = new ConfiguracionModel();
		$this->session = session();
		helper(['form']);

	}


	public function index(){
		$datos = $this->ventas->obtener(1);
		$data = ['titulo' => 'Ventas', 'datos' => $datos];

		echo view('header');
		echo view('ventas/ventas', $data);
		echo view('footer');
	}

		public function eliminados(){
		$datos = $this->ventas->obtener(0);
		$data = ['titulo' => 'Ventas eliminadas', 'datos' => $datos];

		echo view('header');
		echo view('ventas/eliminados', $data);
		echo view('footer');
	}




	public function venta()
	{

		if(!isset($this->session->id_usuario)) { return redirect()->to(base_url()); }

		echo view('header');
		echo view('ventas/caja');
		echo view('footer');
	}

	public function inserta()
	{
		$id_venta = $this->request->getPost('id_venta');
		$total = preg_replace('/[\$,]/', '',$this->request->getPost('total'));
		$forma_pago = $this->request->getPost('forma_pago');
		$id_cliente = $this->request->getPost('id_cliente');

		$resultadoId = $this->ventas->insertaVenta($id_venta, $total, $this->session->id_usuario, $this->session->id_caja, $id_cliente, $forma_pago);
		$this->temporal_venta = new temporalventaModel();

		if($resultadoId){

			$resultadoCompra = $this->temporal_venta->porVenta($id_venta);

			foreach ($resultadoCompra as $row) {
				$this->detalle_venta->save([
					'factura' => $row['factura'],
					'id_venta' => $resultadoId,
					'id_producto' => $row['id_producto'],
					'nombre' => $row['nombre'],
					'cantidad' => $row['cantidad'],
					'precio' => $row['precio']
				]);

				$this->productos = new ProductosModel();
				$this->productos->actualizaStock($row['id_producto'], $row['cantidad'], '-');
			}

			$this->temporal_venta->eliminarVenta($id_venta);
		}

		return redirect()->to(base_url()."/ventas/muestraVentaPdf/".$resultadoId);

	}

	function muestraVentaPdf($id_venta){
		$data['id_venta'] = $id_venta;
		echo view('header');
		echo view('ventas/ver_venta_pdf', $data);
		echo view('footer');

	}

	function generaVentaPdf($id_venta){
		$datosVenta = $this->ventas->where('id', $id_venta)->first();
		$detalleVenta = $this->detalle_venta->select('*')->where('id_venta', $id_venta)->findAll();
		$nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
		$direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;


		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetTitle("Venta");
		$pdf->SetFont('Arial', 'B', 10);

		$pdf->Cell(195, 5, "Venta realizada", 0, 1, 'C');
		$pdf->SetFont('Arial', 'B', 9);

		$pdf->image(base_url() . '/imagenes/logo.jpg', 185, 10, 20, 20, 'JPG');
		$pdf->Cell(50, 5, $nombreTienda, 0, 1, 'L');
		$pdf->Cell(20, 5, utf8_decode('Dirección:'), 0, 0, 'L');
		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(50, 5, $direccionTienda, 0, 1, 'L');
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(24, 5, utf8_decode('Fecha y Hora:'), 0, 0, 'L');
		$pdf->SetFont('Arial', '', 9);
		$pdf->Cell(50, 5, $datosVenta['fecha_alta'], 0, 1, 'L');

		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(196, 5, 'Detalle de Venta', 1, 1, 'C', 1);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(10, 5, 'No', 1, 0, 'L');
		$pdf->Cell(15, 5, 'Factura', 1, 0, 'L');
		$pdf->Cell(15, 5, 'Codigo V', 1, 0, 'L');
		$pdf->Cell(36, 5, 'producto', 1, 0, 'L');
		$pdf->Cell(40, 5, 'Nombre', 1, 0, 'L');
		$pdf->Cell(25, 5, 'Precio', 1, 0, 'L');
		$pdf->Cell(25, 5, 'Cantidad', 1, 0, 'L');
		$pdf->Cell(30, 5, 'Importe Venta', 1, 1, 'L');

		$pdf->SetFont('Arial', '', 8);
		$contador = 1;

		foreach ($detalleVenta as $row) {
			$pdf->Cell(10, 5, $contador, 1, 0, 'L');
			$pdf->Cell(15, 5, $row['factura'], 1, 0, 'L');
			$pdf->Cell(15, 5, $row['id_venta'], 1, 0, 'L');
			$pdf->Cell(36, 5, $row['id_producto'], 1, 0, 'L');
			$pdf->Cell(40, 5, $row['nombre'], 1, 0, 'L');
			$pdf->Cell(25, 5, $row['precio'], 1, 0, 'L');
			$pdf->Cell(25, 5, $row['cantidad'], 1, 0, 'L');
			$importe = number_format($row['precio'] * $row['cantidad'], 2, '.', ',');
			$pdf->Cell(30, 5, '$' .$importe, 1, 1, 'R');
			$contador++;
		}
		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(195, 5, 'Total $'. number_format($datosVenta['total'], 2, '.', ','), 0, 1, 'R');


		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output("compra_pdf.pdf", "I");
	}
	
	public function eliminar($id){
		$productos = $this->detalle_venta->where('id_venta', $id)->findAll();

		foreach ($productos as $producto){
			$this->productos->actualizaStock($producto['id_producto'], $producto['cantidad'], '+');
		}
		$this->ventas->update($id, ['activo' => 0]);

		return redirect()->to(base_url(). '/ventas');
	}
}

