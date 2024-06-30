<?php
namespace App\Models;
use CodeIgniter\Model;
class PrestamoModel extends Model{
    protected $table = 'prestamo';
    protected $primaryKey = 'pres_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pres_inve_id',
        'pres_nombre_alumno',
        'pres_cantidad',
        'pres_codigouni_alumno',
        'pres_evidencia',
        'pres_fechasolicitud',
        'pres_fechaentregado',
        'pres_fechadevolucion',
        'pres_fecharealdevolucion',
        'pres_observacion',
        'pres_estado'
    ];

    public function getPrestamo(){
        return $this->db->table('prestamo p')
        ->join('inventario i', 'i.inve_id = p.pres_inve_id')
        //->join('usuario u', 'u.usua_id = p.pres_usua_id')
        ->join('producto pr', 'pr.prod_id = i.inve_prod_id') // Asegúrate de unir correctamente
        ->get()
        ->getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('prestamo p')
        -> where('p.pres_id', $id)
        //-> where('p.pres_estado', 1)
        ->join('inventario i', 'i.inve_id = p.pres_inve_id')
        //->join('usuario u', 'u.usua_id = p.pres_usua_id')
        ->join('producto pr', 'pr.prod_id = i.inve_prod_id')
        -> get() -> getResultArray();
    }

    public function getInventario(){
        return $this -> db -> table('inventario i')
        //-> where('i.inve_estado', 1)
        -> get() -> getResultArray();
    }
    public function getUsuario(){
        return $this -> db -> table('usuario u')
        -> where('u.usua_estado', 1)
        -> get() -> getResultArray();
    }
}