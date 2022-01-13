<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;

class Productos extends BaseController
{
	protected $productos;
	protected $reglas;

	public function __construct()
	{
		$this->productos = new ProductosModel();
		$this->unidades = new UnidadesModel();
		$this->categorias = new CategoriasModel();
		helper(['form']);

		$this->reglas = [
			'codigo' => [ 
				'rules' => 'required|is_unique[productos.codigo]',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'is_unique' => 'El campo {field} debe ser unico.',
				]
			],
			'nombre' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.'
				]
			]
		];
	}

	public function index($activo = 1){

		$productos = $this->productos->where('activo',$activo)->findAll();

		$data = ['titulo' => 'Productos', 'datos' => $productos];

		echo view('header');
		echo view('productos/productos', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0){
		$productos = $this->productos->where('activo',$activo)->findAll();
		$data = ['titulo' => 'Productos Eliminadas', 'datos' => $productos];

		echo view('header');
		echo view('productos/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{
		$unidades = $this->unidades->where('activo', 1)->findAll();
		$categorias = $this->categorias->where('activo', 1)->findAll();
		$data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias];
		echo view('header');
		echo view('productos/nuevos', $data);
		echo view('footer');
	}

	public function insertar()
	{
		if ($this->request->getMethod() == "post" && $this->validate($this->reglas)){
			$this->productos->save([
				'codigo' => $this->request->getPost('codigo'), 
				'nombre' => $this->request->getPost('nombre'),
				'precio_venta' => $this->request->getPost('precio_venta'),
				'precio_compra' => $this->request->getPost('precio_compra'),
				'costo_unitario' => $this->request->getPost('costo_unitario'),
				'existencias' => $this->request->getPost('existencias'),
				'inicial' => $this->request->getPost('inicial'),
				'stock_minimo' => $this->request->getPost('stock_minimo'),
				'id_categoria' => $this->request->getPost('id_categoria'),
				'id_unidad' => $this->request->getPost('id_unidad'),
				'inventariable' => $this->request->getPost('inventariable')]);

			$id = $this->productos->insertID();

			$validacion = $this->validate([
		'img_producto' =>[
			'uploaded[img_producto]',
			'mime_in[img_producto,image/jpg,image/jpeg]',
			'max_size[img_producto, 5096]'
		]
	]);

	if($validacion){

		$ruta_logo = "imagenes/producto/".$id."jpg";

		if(file_exists($ruta_logo)){
			unlink($ruta_logo);
		}

			$img = $this->request->getFile('img_producto');
			$img->move('./imagenes/producto', $id.'.jpg');
	}else{
		echo "ERROR en la validacion",
		exit;
	}

			return redirect()->to(base_url().'/productos');
		}
		else{
			$unidades = $this->unidades->where('activo', 1)->findAll();
			$categorias = $this->categorias->where('activo', 1)->findAll();
			$data = ['titulo' => 'Agregar producto', 'unidades' => $unidades, 'categorias' => $categorias,'validation' => $this->validator];
			echo view('header');
			echo view('productos/nuevos', $data);
			echo view('footer');
		}
	}

	public function editar($id)
	{
		$unidades = $this->unidades->where('activo', 1)->findAll();
		$categorias = $this->categorias->where('activo', 1)->findAll();
		$producto = $this->productos->where('id',$id)->first();
		$data = ['titulo' => 'Editar producto', 'unidades' => $unidades, 'categorias' => $categorias, 'productos' => $producto];

		echo view('header');
		echo view('productos/editar', $data);
		echo view('footer');
	}

	public function actualizar()
	{

		$this->productos->update($this->request->getPost('id'),[
			'codigo' => $this->request->getPost('codigo'), 
			'nombre' => $this->request->getPost('nombre'),
			'precio_venta' => $this->request->getPost('precio_venta'),
			'precio_compra' => $this->request->getPost('precio_compra'),
			'costo_unitario' => $this->request->getPost('costo_unitario'),
			'existencias' => $this->request->getPost('existencias'),
			'inicial' => $this->request->getPost('inicial'),
			'stock_minimo' => $this->request->getPost('stock_minimo'),
			'id_categoria' => $this->request->getPost('id_categoria'),
			'id_unidad' => $this->request->getPost('id_unidad'),
			'inventariable' => $this->request->getPost('inventariable')]);

		return redirect()->to(base_url().'/productos');
	}

	public function eliminar($id)
	{
		$this->productos->update($id, ['activo' => 0]);
		return redirect()->to(base_url().'/productos');
	}

	public function reingresar($id)
	{
		$this->productos->update($id, ['activo' => 1]);
		return redirect()->to(base_url().'/productos');
	}

//funciones para realizar la compra de productos
	public function buscarPorCodigo($codigo){
		$this->productos->select('*');
		$this->productos->where('codigo', $codigo);
		$this->productos->where('activo', 1);
		$datos = $this->productos->get()->getRow();

		$res['existe'] = false;
		$res['datos'] = '';
		$res['error'] = '';

		if($datos){
			$res['datos'] = $datos;
			$res['existe'] = true;
		}else{
			$res['error'] = 'No existe el Producto';
			$res['existe'] = false;
		}
		echo json_encode($res);
	}

	public function autocompleteData(){

		$returnData = array();

		$valor = $this->request->getGet('term');

		$productos = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();
		if(!empty($productos)){
			foreach ($productos as $row) {
				$data['id'] = $row['id'];
				$data['value'] = $row['codigo'];
				$data['label'] = $row['codigo']. ' - '.$row['nombre'];
				array_push($returnData, $data);
			}
		}
		echo json_encode($returnData);
	}
	
//funcion para generar el codigo de barras a revisar mas detenidamente.
	public function generaBarras(){

		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetTopMargin(10, 10, 10);
		$pdf->SetTitle("Codigo de Barras");

		$productos = $this->productos->where('activo', 1)->findAll();
		foreach ($productos as $producto) {
			$codigo = $producto['codigo'];

			$genaraBarcode = new \barcode_genera();

			$genaraBarcode->barcode("b8888.png", "b8888", 20, "horizontal", "codeb8888", true);

			$pdf->Image($codigo . ".png");

		}

		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output('Codigo.pdf', 'I');

	}
	public function mostrarMinimos(){

		echo view('header');
		echo view('productos/ver_minimos');
		echo view('footer');
	}
	

	public function generaMinimosPdf(){

		$pdf = new \FPDF('P', 'mm', 'letter');
		$pdf->AddPage();
		$pdf->SetTopMargin(10, 10, 10);
		$pdf->SetTitle(utf8_decode("Productos con stock mínimo"));
		$pdf->SetFont("Arial", 'B', 10);

		//$pdf->Image("imagenes/logotipo.png", 10, 5, 20);

		$pdf->Cell(0,5, utf8_decode("Reporte de productos con stock mínimo"), 0, 1, 'C');

		$pdf->Ln(10);

		$pdf->Cell(10, 5, 'No', 1, 0, 'L');
		$pdf->Cell(40,5, utf8_decode("Código"), 1, 0, 'C');
		$pdf->Cell(80,5, utf8_decode("Nombre"), 1, 0, 'C');
		$pdf->Cell(30,5, utf8_decode("Existencias"), 1, 0, 'C');
		$pdf->Cell(30,5, utf8_decode("stock mínimo"), 1, 1, 'C');

		$datosProducto = $this->productos->getProductosMinimo();

		$contador = 1;
		foreach ($datosProducto as $producto) {
			$pdf->Cell(10, 5, $contador, 1, 0, 'L');
			$pdf->Cell(40, 5, $producto['codigo'], 1, 0, 'L');
			$pdf->Cell(80, 5, $producto['nombre'], 1, 0, 'L');
			$pdf->Cell(30, 5, $producto['existencias'], 1, 0, 'L');
			$pdf->Cell(30, 5, $producto['stock_minimo'], 1, 0, 'L');
			$contador++;
		}

		$this->response->setHeader('Content-Type', 'application/pdf');
		$pdf->Output('Codigo.pdf', 'I');

	}
}

