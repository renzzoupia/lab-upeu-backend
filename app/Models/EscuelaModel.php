<?php
namespace App\Models;
use CodeIgniter\Model;
class EscuelaModel extends Model{
    protected $table = 'escuela';
    protected $primaryKey = 'escu_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'escu_nombre',
        'escu_descripcion',
        'escu_facu_id'
    ];
    public function getEscuela(){
        return $this -> db -> table('escuela e')
        //-> where('e.escu_estado', 1)
        -> join('facultad f', 'f.facu_id = e.escu_facu_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('escuela e')
        -> where('e.escu_id', $id)
        //-> where('e.escu_estado', 1)
        -> join('facultad f', 'f.facu_id = e.escu_facu_id')
        -> get() -> getResultArray();
    }

    public function getFacultad(){
        return $this -> db -> table('facultad f')
        //-> where('f.facu_estado', 1)
        -> get() -> getResultArray();
    }
}