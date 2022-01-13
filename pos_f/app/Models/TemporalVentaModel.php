<?php

namespace App\Models;
use CodeIgniter\Model;


class temporalventaModel extends Model
{
	protected $table      = 'temporal_venta';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'factura', 'id_producto', 'codigo','nombre', 'cantidad','precio','subtotal'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function porIdProductoVenta($id_producto, $folio){
        $this->select('*');
        $this->where('folio', $folio);
        $this->where('id_producto', $id_producto);
        $datos = $this->get()->getRow();
        return $datos;
    }

    public function porVenta($folio){
        $this->select('*');
        $this->where('folio', $folio);
        $datos = $this->findAll();
        return $datos;
    }

    public function actualizarProductoVenta($id_producto, $folio, $cantidad, $subtotal){
        $this->set('cantidad', $cantidad);
        $this->set('subtotal', $subtotal);
        $this->where('id_producto', $id_producto);
        $this->where('folio', $folio);
        $this->update();

    }

      public function eliminarProductoVenta($id_producto, $folio){
        $this->where('id_producto', $id_producto);
        $this->where('folio', $folio);
        $this->delete();

    }

        public function eliminarVenta($folio){
        $this->where('folio', $folio);
        $this->delete();

    }
}


?>