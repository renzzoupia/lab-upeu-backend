<?php
namespace App\Models;
use CodeIgniter\Model;
class InventarioModel extends Model{
    protected $table = 'inventario';
    protected $primaryKey = 'inve_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'inve_tipomovimiento',
        'inve_prod_id',
        'inve_cantidad_disponible',
        'inve_labo_id',
        'inve_fecha',
    ];

    public function getInventario(){
        return $this -> db -> table('inventario i')
        //-> where('i.inve_estado', 1)
        -> join('producto pr', 'pr.prod_id = i.inve_prod_id')
        //-> join('usuario u', 'u.usua_id = i.inve_usua_id')
        -> join('laboratorio l', 'l.labo_id = i.inve_labo_id')
        
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('inventario i')
        -> where('i.inve_id', $id)
        //-> where('i.inve_estado', 1)
        -> join('producto pr', 'pr.prod_id = i.inve_prod_id')
        //-> join('usuario u', 'u.usua_id = i.inve_usua_id')
        -> join('laboratorio l', 'l.labo_id = i.inve_labo_id')
        -> get() -> getResultArray();
    }

    public function getProducto(){
        return $this -> db -> table('producto pr')
        -> where('pr.prod_estado', 1)
        -> get() -> getResultArray();
    }
    public function getUsuario(){
        return $this -> db -> table('usuario u')
        -> where('u.usua_estado', 1)
        -> get() -> getResultArray();
    }
    public function getLaboratorio(){
        return $this -> db -> table('laboratorio l')
        -> where('l.labo_estado', 1)
        -> get() -> getResultArray();
    }
}