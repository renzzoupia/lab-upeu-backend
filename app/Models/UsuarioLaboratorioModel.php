<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuarioLaboratorioModel extends Model{
    protected $table = 'usuario_laboratorio';
    protected $primaryKey = 'usla_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'usla_usua_id',
        'usla_labo_id',
        'usla_periodo_inicio',
        'usla_periodo_fin',
        'usla_estado'
        
    ];

    public function getUsuarioLaboratorio(){
        return $this -> db -> table('usuario_laboratorio ul')
        -> where('ul.usla_estado', 1)
        -> join('usuario u', 'u.usua_id = ul.usla_usua_id')
        -> join('laboratorio l', 'l.labo_id = ul.usla_labo_id')
        -> join('escuela e', 'e.escu_id = l.labo_escu_id') // Agregando join con escuela
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('usuario_laboratorio ul')
        -> where('ul_estado', 1)
        -> join('usuario u', 'u.usua_id = ul.eusla_escu_id')
        -> join('laboratorio l', 'l.labo_id = ul.usla_labo_id')
        -> join('escuela e', 'e.escu_id = l.labo_escu_id') // Agregando join con escuela
        -> get() -> getResultArray();
    }

    public function getUsuario(){
        return $this -> db -> table('usuario u')
        //-> where('e.escu_estado', 1)
        -> get() -> getResultArray();
    }
    public function getLaboratorio(){
        return $this -> db -> table('laboratorio l')
        -> where('l.labo_estado', 1)
        -> get() -> getResultArray();
    }
}