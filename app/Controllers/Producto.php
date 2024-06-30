<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProductoModel;
use App\Models\UsuarioModel;
class Producto extends Controller{

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
                    $model = new ProductoModel();
                    $producto = $model -> getProducto();
                    if(!empty($producto)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($producto),
                            "Detalles" => $producto
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
                    $model = new ProductoModel();
                    $producto = $model -> getId($id);
                    //var_dump($producto); die;
                    if(!empty($producto)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $producto
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
                            "prod_nombre" => $request -> getVar("prod_nombre"),
                            "prod_codigoinventario" => $request -> getVar("prod_codigoinventario"),
                            "prod_tipr_id" => $request -> getVar("prod_tipr_id"),
                            "prod_descripcion" => $request -> getVar("prod_descripcion"),
                            "prod_marca" => $request -> getVar("prod_marca"),
                            "prod_modelo" => $request -> getVar("prod_modelo"),
                            "prod_especificaciones" => $request -> getVar("prod_especificaciones"),
                            "prod_ubicacion" => $request -> getVar("prod_ubicacion")
                        );

                        if(!empty($datos)){
                            $validation -> setRules([
                                "prod_nombre" => 'required|string|max_length[255]',
                                "prod_codigoinventario" => 'required|integer',
                                "prod_tipr_id" => 'required|integer',
                                //"prod_descripcion" => 'required|string|max_length[255]',
                                //"prod_marca" => 'required|string|max_length[100]',
                                //"prod_modelo" => 'required|string|max_length[100]',
                                //"prod_especificaciones" => 'required|string|max_length[255]',
                                //"prod_ubicacion" => 'required|string|max_length[255]'
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
                                    "prod_nombre" => $datos["prod_nombre"],
                                    "prod_codigoinventario" => $datos["prod_codigoinventario"],
                                    "prod_tipr_id" => $datos["prod_tipr_id"],
                                    "prod_descripcion" => $datos["prod_descripcion"],
                                    "prod_marca" => $datos["prod_marca"],
                                    "prod_modelo" => $datos["prod_modelo"],
                                    "prod_especificaciones" => $datos["prod_especificaciones"],
                                    "prod_ubicacion" => $datos["prod_ubicacion"]
                                );
                                $model = new ProductoModel();
                                $producto = $model -> insert($datos);
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
                            "prod_nombre" => 'required|string|max_length[255]',
                            "prod_codigoinventario" => 'required|integer',
                            "prod_tipr_id" => 'required|integer',
                            //"prod_descripcion" => 'required|string|max_length[255]',
                            //"prod_marca" => 'required|string|max_length[100]',
                            //"prod_modelo" => 'required|string|max_length[100]',
                            //"prod_especificaciones" => 'required|string|max_length[255]',
                            //"prod_ubicacion" => 'required|string|max_length[255]'
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
                            $model = new ProductoModel();
                            $producto = $model -> find($id);
                            if(is_null($producto)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "prod_nombre" => $datos["prod_nombre"],
                                    "prod_codigoinventario" => $datos["prod_codigoinventario"],
                                    "prod_tipr_id" => $datos["prod_tipr_id"],
                                    "prod_descripcion" => $datos["prod_descripcion"],
                                    "prod_marca" => $datos["prod_marca"],
                                    "prod_modelo" => $datos["prod_modelo"],
                                    "prod_especificaciones" => $datos["prod_especificaciones"],
                                    "prod_ubicacion" => $datos["prod_ubicacion"]
                                );
                                $model = new ProductoModel();
                                $producto = $model -> update($id, $datos);
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
                    $model = new ProductoModel();
                    $producto = $model -> where('prod_estado',1) -> find($id);
                    //var_dump($producto); die;
                    if(!empty($producto)){
                        $datos = array(
                            "prod_estado" => 0
                        );
                        $producto = $model -> update($id, $datos);
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