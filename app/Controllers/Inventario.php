<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\InventarioModel;
use App\Models\UsuarioModel;
class Inventario extends Controller{

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
                    $model = new InventarioModel();
                    $inventario = $model -> getInventario();
                    if(!empty($inventario)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($inventario),
                            "Detalles" => $inventario
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
                    $model = new InventarioModel();
                    $inventario = $model -> getId($id);
                    //var_dump($inventario); die;
                    if(!empty($inventario)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $inventario
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
                            "inve_tipomovimiento" => $request -> getVar("inve_tipomovimiento"),
                            "inve_prod_id" => $request -> getVar("inve_prod_id"),
                            "inve_cantidad_disponible" => $request -> getVar("inve_cantidad_disponible"),
                            "inve_labo_id" => $request -> getVar("inve_labo_id"),
                            "inve_fecha" => $request -> getVar("inve_fecha")
                        );

                        if(!empty($datos)){
                            $validation -> setRules([
                                "inve_tipomovimiento" => 'required|string|max_length[30]',
                                "inve_prod_id" => 'required|integer',
                                "inve_cantidad_disponible" => 'required|integer',
                                "inve_labo_id" => 'required|integer',
                                "inve_fecha" => 'required|date'
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
                                    "inve_tipomovimiento" => $datos["inve_tipomovimiento"],
                                    "inve_prod_id" => $datos["inve_prod_id"],
                                    "inve_cantidad_disponible" => $datos["inve_cantidad_disponible"],
                                    "inve_labo_id" => $datos["inve_labo_id"],
                                    "inve_fecha" => $datos["inve_fecha"]
                                );
                                $model = new InventarioModel();
                                $inventario = $model -> insert($datos);
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
                            "inve_tipomovimiento" => 'required|string|max_length[30]',
                            "inve_prod_id" => 'required|integer',
                            "inve_cantidad_disponible" => 'required|integer',
                            "inve_labo_id" => 'required|integer',
                            "inve_fecha" => 'required|date'
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
                            $model = new InventarioModel();
                            $inventario = $model -> find($id);
                            if(is_null($inventario)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "inve_tipomovimiento" => $datos["inve_tipomovimiento"],
                                    "inve_prod_id" => $datos["inve_prod_id"],
                                    "inve_cantidad_disponible" => $datos["inve_cantidad_disponible"],
                                    "inve_labo_id" => $datos["inve_labo_id"],
                                    "inve_fecha" => $datos["inve_fecha"]
                                );
                                $model = new InventarioModel();
                                $inventario = $model -> update($id, $datos);
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
                    $model = new InventarioModel();
                    $inventario = $model -> find($id);
                    //var_dump($inventario); die;
                    if(!empty($inventario)){
                        $datos = array(
                            "prod_estado" => 0
                        );
                        $inventario = $model -> delete($id);
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