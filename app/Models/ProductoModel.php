<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductoModel extends Model{
    protected $table = 'producto';
    protected $primaryKey = 'prod_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'prod_nombre',
        'prod_codigoinventario',
        'prod_tipr_id',
        'prod_estado',
        'prod_descripcion',
        'prod_marca',
        'prod_modelo',
        'prod_especificaciones',
        'prod_ubicacion'
    ];

    public function getProducto(){
        return $this -> db -> table('producto p')
        -> where('p.prod_estado', 1)
        -> join('tipo_producto tp', 'tp.tipr_id = p.prod_tipr_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('producto p')
        -> where('p.prod_id', $id)
        -> where('p.prod_estado', 1)
        -> join('tipo_producto tp', 'tp.tipr_id = p.prod_tipr_id')
        -> get() -> getResultArray();
    }

    public function getTipoProducto(){
        return $this -> db -> table('tipo_producto tp')
        -> where('tp.tipr_estado', 1)
        -> get() -> getResultArray();
    }
}
