<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuarioModel extends Model{
    protected $table = 'usuario';
    protected $primaryKey = 'usua_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'usua_nombrecompleto',
        'usua_username',
        'usua_clave',
        'usua_estado',
        'usua_role_id',
        'usua_dni',
        'usua_user_secreto',
        'usua_llave_secreta'
    ];

    public function getUsuario(){
        return $this -> db -> table('usuario u')
        -> where('u.usua_estado', 1)
        -> join('roles r', 'r.role_id = u.usua_role_id')
        -> get() -> getResultArray();
    }
    public function getRoles(){
        return $this -> db -> table('roles r')
        -> where('r.role_estado', 1)
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('usuario u')
        -> where('u.usua_id', $id)
        -> where('u.usua_estado', 1)
        -> join('roles r', 'r.role_id = u.usua_role_id')
        -> get() -> getResultArray();
    }
}