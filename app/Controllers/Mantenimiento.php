<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\MantenimientoModel;
use App\Models\UsuarioModel;
class Mantenimiento extends Controller{

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
                    $model = new MantenimientoModel();
                    $mantenimiento = $model -> getMantenimiento();
                    if(!empty($mantenimiento)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($mantenimiento),
                            "Detalles" => $mantenimiento
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
                    $model = new MantenimientoModel();
                    $mantenimiento = $model -> getId($id);
                    //var_dump($curso); die;
                    if(!empty($mantenimiento)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $mantenimiento
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
                            "mant_inve_id" => $request -> getVar("mant_inve_id"),
                            "mant_fechainicio" => $request -> getVar("mant_fechainicio"),
                            "mant_fechadevolucion" => $request -> getVar("mant_fechadevolucion"),
                            "mant_resultado" => $request -> getVar("mant_resultado"),
                            "mant_estado" => $request -> getVar("mant_estado"),
                            "mant_cantidad" => $request -> getVar("mant_cantidad")
                        );
                        if(!empty($datos)){
                            $validation -> setRules([
                                "mant_inve_id" => 'required|integer',
                                "mant_fechainicio" => 'required|date',
                                "mant_fechadevolucion" => 'required|date',
                                "mant_cantidad" => 'required|integer'
                                //"mant_resultado" => 'required|string|max_length[255]',
                                //"mant_estado" => 'required|string|max_length[50]'
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
                                    "mant_inve_id" => $datos["mant_inve_id"],
                                    "mant_fechainicio" => $datos["mant_fechainicio"],
                                    "mant_fechadevolucion" => $datos["mant_fechadevolucion"],
                                    "mant_resultado" => $datos["mant_resultado"],
                                    "mant_estado" => $datos["mant_estado"],
                                    "mant_cantidad" => $datos["mant_cantidad"]
                                );
                                $model = new MantenimientoModel();
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
                            "mant_inve_id" => 'required|integer',
                            "mant_fechainicio" => 'required|date',
                            "mant_fechadevolucion" => 'required|date',
                            "mant_resultado" => 'required|string|max_length[255]',
                            "mant_estado" => 'required|string|max_length[50]',
                            "mant_cantidad" => 'required|integer',
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
                            $model = new MantenimientoModel();
                            $mantenimiento = $model -> find($id);
                            if(is_null($mantenimiento)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "mant_inve_id" => $datos["mant_inve_id"],
                                    "mant_fechainicio" => $datos["mant_fechainicio"],
                                    "mant_fechadevolucion" => $datos["mant_fechadevolucion"],
                                    "mant_resultado" => $datos["mant_resultado"],
                                    "mant_estado" => $datos["mant_estado"],
                                    "mant_cantidad" => $datos["mant_cantidad"]
                                );
                                $model = new MantenimientoModel();
                                $mantenimiento = $model -> update($id, $datos);
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
                    $model = new MantenimientoModel();
                    $mantenimiento = $model -> find($id);
                    //var_dump($curso); die;
                    if(!empty($mantenimiento)){
                        /*$datos = array(
                            "clie_estado" => 0
                        );*/
                        $mantenimiento = $model -> delete($id);
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