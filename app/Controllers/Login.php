<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuarioLaboratorioModel;
class Login extends Controller{
    public function create(){

        $request = \Config\Services::request();
        $headers = $request->getHeaders();
        $model = new UsuarioLaboratorioModel();
        $registro = $model -> where('usua_estado', 1) -> getUsuarioLaboratorio();
        foreach($registro as $key => $value){
            if(array_key_exists('Usuario', $headers) && !empty($headers['Usuario']) && array_key_exists('Contra', $headers) && !empty($headers['Contra'])){
                if($request -> getHeader('Usuario') == 'Usuario: '.$value['usua_username']){
                    if($request -> getHeader('Contra') == 'Contra: '.$value['usua_clave']){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => "Logeado correctamente",
                            "Datos" => $value
                        );
                    return json_encode($data, true);
                    }
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "Contrasena incorrecta"
                        );
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "Usuario incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No ingreso datos"
                );
            }    
        }
        return json_encode($data, true);
    }
}
