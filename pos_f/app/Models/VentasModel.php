<?php

namespace App\Models;
use CodeIgniter\Model;


class ventasModel extends Model
{
	protected $table      = 'ventas';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio','total', 'id_usuario', 'id_caja', 'id_cliente', 'forma_pago', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertaVenta($id_venta, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago){
        $this->insert([
            'folio' => $id_venta,
            'total' => $total,
            'id_usuario' => $id_usuario,
            'id_caja' => $id_caja,
            'id_cliente' => $id_cliente,
            'forma_pago' => $forma_pago
        ]);

        return $this->insertID();
    }

    public function obtener($activo = 1){
        $this->select('ventas.*, u.usuario AS cajero, c.nombre AS cliente');//los datos que quiero obtener
        $this->join('usuarios AS u', 'ventas.id_usuario = u.id');//inner join me trae nombre de usuario
        $this->join('clientes AS c', 'ventas.id_cliente = c.id');//inner join me trae nombre de cliente
        $this->where('ventas.activo', $activo);//todas las ventas activas
        $this->orderBy('ventas.fecha_alta', 'DESC');//se muestre de manera desendente segun fecha
        $datos = $this->findAll();//extraigo la consulta
       // print_r($this->getLastQuery());// para prueva de errores
        return $datos;//obtengo la consulta
    }

     public function totalDia($fecha){
        $this->select("sum(total) AS total");
        $where = "activo = 1 AND DATE(fecha_alta) = '$fecha'";
       return $this->where($where)->first();
    }
}


?>