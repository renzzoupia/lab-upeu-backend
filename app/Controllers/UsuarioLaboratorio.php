<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuarioLaboratorioModel;
use App\Models\UsuarioModel;
class UsuarioLaboratorio extends Controller{

    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuarioModel();
        $registro = $model -> where('usua_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $model = new UsuarioLaboratorioModel();
                    $usuariolaboratorio = $model -> getUsuarioLaboratorio();
                    if(!empty($usuariolaboratorio)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($usuariolaboratorio),
                            "Detalles" => $usuariolaboratorio
                        );
                    }else{
                        $data = array(
                            "Status" => 404,
                            "Total de registros" => 0,
                            "Detalles" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }    
        }
        return json_encode($data, true);

    }

    public function show($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $model = new UsuarioLaboratorioModel();
                    $usuariolaboratorio = $model -> getId($id);
                    //var_dump($curso); die;
                    if(!empty($usuariolaboratorio)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $usuariolaboratorio
                        );
                    }else{
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }    
        }
        return json_encode($data, true);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        //var_dump($registro); die;
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                        $datos = array(
                            "usla_usua_id" => $request -> getVar("usla_usua_id"),
                            "usla_labo_id" => $request -> getVar("usla_labo_id"),
                            "usla_periodo_inicio" => $request -> getVar("usla_periodo_inicio"),
                            "usla_periodo_fin" => $request -> getVar("usla_periodo_fin")
                        );
                        if(!empty($datos)){
                            $validation -> setRules([
                                "usla_usua_id" => 'required|integer',
                                "usla_labo_id" => 'required|integer',
                                "usla_periodo_inicio" => 'required|date',
                                "usla_periodo_fin" => 'required|date'
                            ]);
                            $validation -> withRequest($this -> request) -> run();
                            if($validation -> getErrors()){
                                $errors = $validation -> getErrors();
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => $errors
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "usla_usua_id" => $datos["usla_usua_id"],
                                    "usla_labo_id" => $datos["usla_labo_id"],
                                    "usla_periodo_inicio" => $datos["usla_periodo_inicio"],
                                    "usla_periodo_fin" => $datos["usla_periodo_fin"]
                                );
                                $model = new UsuarioLaboratorioModel();
                                $curso = $model -> insert($datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Registro existoso"
                                );
                                return json_encode($data, true);
                            }
                        }else{
                            $data = array(
                                "Status" => 404,
                                "Detalles" => "Registro con errores"
                            );
                            return json_encode($data, true);
                        }
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }

    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $datos = $this -> request -> getRawInput();
                    if(!empty($datos)){
                        $validation -> setRules([
                            "usla_usua_id" => 'required|integer',
                            "usla_labo_id" => 'required|integer',
                            "usla_periodo_inicio" => 'required|date',
                            "usla_periodo_fin" => 'required|date'
                        ]);
                        $validation -> withRequest($this -> request) -> run();
                        if($validation -> getErrors()){
                            $errors = $validation -> getErrors();
                            $data = array(
                                "Status" => 404,
                                "Detalles" => $errors
                            );
                            return json_encode($data, true);
                        }else{
                            $model = new UsuarioLaboratorioModel();
                            $usuariolaboratorio = $model -> find($id);
                            if(is_null($usuariolaboratorio)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "usla_usua_id" => $datos["usla_usua_id"],
                                    "usla_labo_id" => $datos["usla_labo_id"],
                                    "usla_periodo_inicio" => $datos["usla_periodo_inicio"],
                                    "usla_periodo_fin" => $datos["usla_periodo_fin"]
                                );
                                $model = new UsuarioLaboratorioModel();
                                $usuariolaboratorio = $model -> update($id, $datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Datos actualizados"
                                );
                                return json_encode($data, true);
                            }
                        }
                    }else{
                        $data = array(
                            "Status" => 400,
                            "Detalles" => "Registro con errores"
                        );
                        return json_encode($data, true);
                    }
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }

    public function delete($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $model = new UsuarioLaboratorioModel();
                    $usuariolaboratorio = $model -> find($id);
                    //var_dump($curso); die;
                    if(!empty($usuariolaboratorio)){
                        $datos = array(
                            "usla_estado" => 0
                        );
                        $usuariolaboratorio = $model -> update($id, $datos);
                        $data = array(
                            "Status" => 200, 
                            "Detalles" => "Se ha eliminado el registro"
                        );
                    }else{
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }    
        }
        return json_encode($data, true);
    }
}