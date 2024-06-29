<?php
namespace App\Models;
use CodeIgniter\Model;
class FacultadModel extends Model{
    protected $table = 'facultad';
    protected $primaryKey = 'facu_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'facu_nombre',
        'facu_descripcion'
    ];

}