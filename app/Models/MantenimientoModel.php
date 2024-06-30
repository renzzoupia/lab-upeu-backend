<?php
namespace App\Models;
use CodeIgniter\Model;
class MantenimientoModel extends Model{
    protected $table = 'mantenimiento';
    protected $primaryKey = 'mant_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'mant_inve_id',
        'mant_fechainicio',
        'mant_fechadevolucion',
        'mant_resultado',
        'mant_estado',
        'mant_cantidad'
    ];
    public function getMantenimiento(){
        return $this -> db -> table('mantenimiento m')
        //-> where('e.escu_estado', 1)
        -> join('inventario i', 'i.inve_id = m.mant_inve_id')
        -> join('producto pr', 'pr.prod_id = i.inve_prod_id') // Asegúrate de unir correctamente
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('mantenimiento m')
        -> where('m.mant_id', $id)
        //-> where('e.escu_estado', 1)
        -> join('inventario i', 'i.inve_id = m.mant_inve_id')
        -> join('producto pr', 'pr.prod_id = i.inve_prod_id') // Asegúrate de unir correctamente
        -> get() -> getResultArray();
    }

    public function getInventario(){
        return $this -> db -> table('inventario i')
        -> where('i.inve_id', 1)
        -> get() -> getResultArray();
    }
}