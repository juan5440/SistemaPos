<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetalleVentaModel;

class DetalleVenta extends BaseController
{
	protected $detalle_venta, $session;
	protected $reglas;

	public function __construct()
	{
		$this->detalle_venta = new DetalleVentaModel();
		$this->session = session();
	}


	public function mostrarVentas(){

		if(!isset($this->session->id_usuario)){ return redirect()->to(base_url()); }

		$datos = $this->detalle_venta->obtenerView();
		$data = ['titulo' => 'Ventas', 'datos' => $datos];

		echo view('header');
		echo view('detalle_venta/detalle_ventas', $data);
		echo view('footer');
	}

	public function eliminados($activo = 0){

		if(!isset($this->session->id_usuario)){ return redirect()->to(base_url()); }

		$roles = $this->roles->where('activo',$activo)->findAll();
		$data = ['titulo' => 'Roles Eliminadas', 'datos' => $roles];

		echo view('header');
		echo view('roles/eliminados', $data);
		echo view('footer');
	}

	public function nuevo()
	{

		if(!isset($this->session->id_usuario)){ return redirect()->to(base_url()); }

		$data = ['titulo' => 'Agregar roles'];
		echo view('header');
		echo view('roles/nuevos', $data);
		echo view('footer');
	}

	public function insertar()
	{
		if ($this->request->getMethod() == "post" && $this->validate($this->reglas)){
			$this->roles->save(['nombre' => $this->request->getPost('nombre'), 'activo' => 1]);
		return redirect()->to(base_url().'/roles');
	}
	else{
		$data = ['titulo' => 'Agregar Roles', 'validation' => $this->validator];
		echo view('header');
		echo view('roles/nuevos', $data);
		echo view('footer');
	}
}

public function editar($id , $valid=null)
{
	if(!isset($this->session->id_usuario)){ return redirect()->to(base_url()); }
	
	$rol = $this->roles->where('id',$id)->first();

	if($valid != null){

		$data = ['titulo' => 'Editar rol', 'datos' => $rol, 'validation' => $valid];
	}else{
		$data = ['titulo' => 'Editar rol', 'datos' => $rol];
	}

	$data = ['titulo' => 'Editar rol', 'datos' => $rol];
	echo view('header');
	echo view('roles/editar', $data);
	echo view('footer');
}

public function actualizar()
{
	if ($this->request->getMethod() == "post" && $this->validate($this->reglas)){
	$this->roles->update($this->request->getPost('id'), ['nombre' => $this->request->getPost('nombre'), 'nombre' => $this->request->getPost('nombre')]);
	return redirect()->to(base_url().'/roles');
	}else{
		return $this->editar($this->request->getPost('id'), $this->validator);
	}
}

public function eliminar($id)
{
	$this->roles->update($id, ['activo' => 0]);
	return redirect()->to(base_url().'/roles');
}

public function reingresar($id)
{
	$this->roles->update($id, ['activo' => 1]);
	return redirect()->to(base_url().'/roles');
}

}

