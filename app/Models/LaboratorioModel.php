<?php
namespace App\Models;
use CodeIgniter\Model;
class LaboratorioModel extends Model{
    protected $table = 'laboratorio';
    protected $primaryKey = 'labo_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'labo_nombre',
        'labo_descripcion',
        'labo_estado',
        'labo_escu_id'
    ];
    public function getLaboratorioConEncargado(){
        return $this -> db -> table('laboratorio l')
        -> where('l.labo_estado', 1)
        -> join('escuela e', 'e.escu_id = l.labo_escu_id')
        -> join('usuario_laboratorio ul', 'ul.usla_id = l.labo_id') // Agregando join con escuela
        -> get() -> getResultArray();
    }

    public function getLaboratorio(){
        return $this->db->table('laboratorio l')
            -> where('l.labo_estado', 1)
            ->select('l.labo_id, l.labo_nombre, e.escu_nombre, u.usua_nombrecompleto, ul.usla_periodo_inicio, ul.usla_periodo_fin')
            ->join('escuela e', 'e.escu_id = l.labo_escu_id', 'left')
            ->join('usuario_laboratorio ul', 'ul.usla_labo_id = l.labo_id', 'left')
            ->join('usuario u', 'u.usua_id = ul.usla_usua_id', 'left')
            ->get()->getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('laboratorio l')
        -> where('l.labo_id', $id)
        -> where('l.labo_estado', 1)
        -> join('escuela e', 'e.escu_id = l.labo_escu_id')
        -> get() -> getResultArray();
    }

    public function getEscuela(){
        return $this -> db -> table('escuela e')
        //-> where('e.facu_estado', 1)
        -> get() -> getResultArray();
    }
}