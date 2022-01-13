<?php namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\ventasModel;

class Inicio extends BaseController
{
	protected $productosModel, $ventasModel, $session;

	public function __construct()
	{
		$this->productosModel = new ProductosModel();
		$this->ventasModel = new ventasModel();
		$this->session = session();

	}

	public function index()
	{

		if(!isset($this->session->id_usuario)) { return redirect()->to(base_url()); }
		$total = $this->productosModel->totalProductos();
		$hoy = date('Y-m-d');
		$minimo = $this->productosModel->productosMinimo();
		$totalVentas = $this->ventasModel->totalDia($hoy);
		$datos = ['total' => $total, 'totalVentas' => $totalVentas, 'minimo' => $minimo];

		echo view('header');
		echo view('inicio', $datos);
		echo view('footer');

	}

	//--------------------------------------------------------------------

}
