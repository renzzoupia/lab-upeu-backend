<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PrestamoModel;
use App\Models\UsuarioModel;
class Prestamo extends Controller{

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
                    $model = new PrestamoModel();
                    $prestamo = $model -> getPrestamo();
                    if(!empty($prestamo)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($prestamo),
                            "Detalles" => $prestamo
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
                    $model = new PrestamoModel();
                    $prestamo = $model -> getId($id);
                    //var_dump($prestamo); die;
                    if(!empty($prestamo)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $prestamo
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
                            "pres_inve_id" => $request -> getVar("pres_inve_id"),
                            "pres_usua_id" => $request -> getVar("pres_usua_id"),
                            "pres_cantidad" => $request -> getVar("pres_cantidad"),
                            "pres_codigouni_alumno" => $request -> getVar("pres_codigouni_alumno"),
                            "pres_evidencia" => $request -> getFile("pres_evidencia"),
                            "pres_fechasolicitud" => $request -> getVar("pres_fechasolicitud"),
                            "pres_fechaentregado" => $request -> getVar("pres_fechaentregado"),
                            "pres_fechadevolucion" => $request -> getVar("pres_fechadevolucion"),
                            //"pres_fecharealdevolucion" => $request -> getVar("pres_fecharealdevolucion"),
                            //"pres_observacion" => $request -> getVar("pres_observacion"),
                            //"pres_estado" => $request -> getVar("pres_estado")
                        );

                        $logo = $datos['pres_evidencia'];

                        if(!empty($datos)){
                            $validation -> setRules([
                                "pres_inve_id" => 'required|integer',
                                "pres_usua_id" => 'required|integer',
                                "pres_cantidad" => 'required|integer',
                                "pres_codigouni_alumno" => 'required|integer',
                                //"pres_evidencia" => 'required|integer',
                                "pres_fechasolicitud" => 'required|date',
                                "pres_fechaentregado" => 'required|date',
                                "pres_fechadevolucion" => 'required|date',
                                //"pres_fecharealdevolucion" => 'required|date',
                                //"pres_observacion" => 'required|string|max_length[255]',
                                //"pres_estado" => 'required|string|max_length[20]'
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
                                $newName = $logo->getRandomName();
                                $datos = array(
                                    "pres_inve_id" => $datos["pres_inve_id"],
                                    "pres_usua_id" => $datos["pres_usua_id"],
                                    "pres_cantidad" => $datos["pres_cantidad"],
                                    "pres_codigouni_alumno" => $datos["pres_codigouni_alumno"],
                                    "pres_evidencia" => "http://localhost:8080/lab-backend/public/Productos/".$newName,
                                    "pres_fechasolicitud" => $datos["pres_fechasolicitud"],
                                    "pres_fechaentregado" => $datos["pres_fechaentregado"],
                                    "pres_fechadevolucion" => $datos["pres_fechadevolucion"],
                                    //"pres_fecharealdevolucion" => $datos["pres_fecharealdevolucion"],
                                    //"pres_observacion" => $datos["pres_observacion"],
                                    //"pres_estado" => $datos["pres_estado"]
                                );
                                $model = new PrestamoModel();
                                $pres_id = $model -> insert($datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Registro existoso"
                                );
                                //Subir archivo
                                $model2 = new PrestamoModel;
                                //$empresa = $model2->getProducto($empresa2);
                                if($logo->isValid() && !$logo->hasMoved()) {
                                    // Directorio de destino
                                    $uploadPath = './public/Productos';
                        
                                    // Generar un nombre de archivo único
                        
                                    // Mover el archivo al directorio de destino
                                    $logo->move($uploadPath, $newName);
                        
                                    // Enviar una respuesta JSON con la ubicación del archivo
                                    $response = [
                                        'status' => 'success',
                                        'message' => 'Archivo subido correctamente',
                                        'logo$logo_path' => base_url($uploadPath."/".$newName)
                                    ];
                        
                                    $up = $this->response->setJSON($response);
                                } else {
                                    // Si hay un error en la carga del archivo
                                    $response = [
                                        'status' => 'error',
                                        'message' => $logo->getErrorString()
                                    ];
                                  $up =  $this->response->setJSON($response);
                                }
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
    public function update() {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
    
        $id = $request->getVar('id');  // Asegúrate de recibir el ID para actualizar el registro
    
        $datos = [
            "pres_inve_id" => $request->getVar("pres_inve_id"),
            "pres_usua_id" => $request->getVar("pres_usua_id"),
            "pres_cantidad" => $request->getVar("pres_cantidad"),
            "pres_codigouni_alumno" => $request->getVar("pres_codigouni_alumno"),
            "pres_fechasolicitud" => $request->getVar("pres_fechasolicitud"),
            "pres_fechaentregado" => $request->getVar("pres_fechaentregado"),
            "pres_fechadevolucion" => $request->getVar("pres_fechadevolucion"),
            "pres_fecharealdevolucion" => $request->getVar("pres_fecharealdevolucion"),
            "pres_observacion" => $request->getVar("pres_observacion"),
            "pres_estado" => $request->getVar("pres_estado"),
            "pres_evidencia" => $request->getFile("pres_evidencia")
        ];
    
        $validation->setRules([
            "pres_inve_id" => 'required|integer',
            "pres_usua_id" => 'required|integer',
            "pres_cantidad" => 'required|integer',
            "pres_codigouni_alumno" => 'required|integer',
            //"pres_evidencia" => 'required|integer',
            "pres_fechasolicitud" => 'required|date',
            "pres_fechaentregado" => 'required|date',
            "pres_fechadevolucion" => 'required|date',
            //"pres_fecharealdevolucion" => 'required|date',
            //"pres_observacion" => 'required|string|max_length[255]',
            //"pres_estado" => 'required|string|max_length[20]'
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                "Status" => 404,
                "Detalles" => $validation->getErrors()
            ]);
        }
    
        $prestamoModel = new PrestamoModel();
        $prestamoModel->update($id, $datos);
    
        // Manejo de la carga de archivos, si es necesario
        $logo = $datos['pres_evidencia'];
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $newName = $logo->getRandomName();
            $uploadPath = './public/Productos';
            $logo->move($uploadPath, $newName);
            $prestamoModel->update($id, ['pres_evidencia' => base_url($uploadPath . "/" . $newName)]);
        }
    
        return $this->response->setJSON([
            "Status" => 200,
            "Detalles" => "Actualización exitosa"
        ]);
    }
    
       
    /*public function update($id) {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1)->findAll();
    
        foreach ($registro as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['usua_user_secreto'] . ':' . $value['usua_llave_secreta'])) {
                    $datos = [
                        "pres_inve_id" => $request->getVar("pres_inve_id"),
                        "pres_usua_id" => $request->getVar("pres_usua_id"),
                        "pres_cantidad" => $request->getVar("pres_cantidad"),
                        "pres_codigouni_alumno" => $request->getVar("pres_codigouni_alumno"),
                        "pres_evidencia" => $request->getFile("pres_evidencia"),
                        "pres_fechasolicitud" => $request->getVar("pres_fechasolicitud"),
                        "pres_fechaentregado" => $request->getVar("pres_fechaentregado"),
                        "pres_fechadevolucion" => $request->getVar("pres_fechadevolucion")
                    ];
    
                    $validation->setRules([
                        "pres_inve_id" => 'required|integer',
                        "pres_usua_id" => 'required|integer',
                        "pres_cantidad" => 'required|integer',
                        "pres_codigouni_alumno" => 'required|integer',
                        "pres_fechasolicitud" => 'required|date',
                        "pres_fechaentregado" => 'required|date',
                        "pres_fechadevolucion" => 'required|date'
                    ]);
    
                    $validation->withRequest($this->request)->run();
                    if (!$validation->getErrors()) {
                        return $this->response->setJSON([
                            "Status" => 404,
                            "Detalles" => $validation->getErrors()
                        ]);
                    } else {
                        $prestamoModel = new PrestamoModel();
                        $prestamoModel->update($id, $datos);
    
                        $logo2 = $datos['pres_evidencia'];
                        if ($logo2->isValid() && !$logo2->hasMoved()) {
                            $newName = $logo2->getRandomName();
                            $uploadPath = './public/Productos';
                            $logo2->move($uploadPath, $newName);
                            $datos['pres_evidencia'] = base_url($uploadPath . "/" . $newName);
                            $prestamoModel->update($id, ['pres_evidencia' => $datos['pres_evidencia']]);
                        }
    
                        return $this->response->setJSON([
                            "Status" => 200,
                            "Detalles" => "Actualización exitosa"
                        ]);
                    }
                } else {
                    return $this->response->setJSON([
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                ]);
            }
        }
    }
    
    public function update($id) {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1)->findAll();
    
        foreach ($registro as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['usua_user_secreto'] . ':' . $value['usua_llave_secreta'])) {
                    $datos = [
                        "pres_inve_id" => $request->getVar("pres_inve_id"),
                        "pres_usua_id" => $request->getVar("pres_usua_id"),
                        "pres_cantidad" => $request->getVar("pres_cantidad"),
                        "pres_codigouni_alumno" => $request->getVar("pres_codigouni_alumno"),
                        "pres_fechasolicitud" => $request->getVar("pres_fechasolicitud"),
                        "pres_fechaentregado" => $request->getVar("pres_fechaentregado"),
                        "pres_fechadevolucion" => $request->getVar("pres_fechadevolucion"),
                        "pres_evidencia" => $request->getFile("pres_evidencia")
                    ];
    
                    // Capturar el archivo (si existe)
                    $logo = $datos['pres_evidencia'];
    
    
                    if (!empty($datos)) {
                        $validation->setRules([
                            "pres_inve_id" => 'required|integer',
                            "pres_usua_id" => 'required|integer',
                            "pres_cantidad" => 'required|integer',
                            "pres_codigouni_alumno" => 'required|integer',
                            "pres_fechasolicitud" => 'required|valid_date',
                            "pres_fechaentregado" => 'required|valid_date',
                            "pres_fechadevolucion" => 'required|valid_date'
                        ]);
    
                        $validation -> withRequest($this -> request) -> run();
                            if($validation -> getErrors()){
                                $errors = $validation -> getErrors();
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => $errors
                                );
                                return json_encode($data, true);
                        } else {
                            // Procesar el archivo (si se subió)
                            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                                $newName = $logo->getRandomName();
                                $logo->move('./public/Productos', $newName);
                                $datos['pres_evidencia'] = "http://localhost:8080/lab-backend/public/Productos/" . $newName;
                            } else if ($logo && !$logo->isValid()) {
                                $data = [
                                    "Status" => 404,
                                    "Detalles" => $logo->getErrorString()
                                ];
                                return $this->response->setJSON($data);
                            } else {
                                unset($datos['pres_evidencia']);
                            }
    
                            $model = new PrestamoModel();
                            $model->update($id, $datos);
    
                            $data = [
                                "Status" => 200,
                                "Detalles" => "Actualización exitosa"
                            ];
                            return $this->response->setJSON($data);
                        }
                    } else {
                        $data = [
                            "Status" => 404,
                            "Detalles" => "Registro con errores"
                        ];
                        return $this->response->setJSON($data);
                    }
                } else {
                    $data = [
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    ];
                    return $this->response->setJSON($data);
                }
            } else {
                $data = [
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                ];
                return $this->response->setJSON($data);
            }
        }
    }
    public function update($id) {
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
                            "pres_inve_id" => $request -> getVar("pres_inve_id"),
                            "pres_usua_id" => $request -> getVar("pres_usua_id"),
                            "pres_cantidad" => $request -> getVar("pres_cantidad"),
                            "pres_codigouni_alumno" => $request -> getVar("pres_codigouni_alumno"),
                            "pres_evidencia" => $request -> getFile("pres_evidencia"),
                            "pres_fechasolicitud" => $request -> getVar("pres_fechasolicitud"),
                            "pres_fechaentregado" => $request -> getVar("pres_fechaentregado"),
                            "pres_fechadevolucion" => $request -> getVar("pres_fechadevolucion"),
                            //"pres_fecharealdevolucion" => $request -> getVar("pres_fecharealdevolucion"),
                            //"pres_observacion" => $request -> getVar("pres_observacion"),
                            //"pres_estado" => $request -> getVar("pres_estado")
                        );

                        $logo = $datos['pres_evidencia'];

                        if(!empty($datos)){
                            $validation -> setRules([
                                "pres_inve_id" => 'required|integer',
                                "pres_usua_id" => 'required|integer',
                                "pres_cantidad" => 'required|integer',
                                "pres_codigouni_alumno" => 'required|integer',
                                //"pres_evidencia" => 'required|integer',
                                "pres_fechasolicitud" => 'required|date',
                                "pres_fechaentregado" => 'required|date',
                                "pres_fechadevolucion" => 'required|date',
                                //"pres_fecharealdevolucion" => 'required|date',
                                //"pres_observacion" => 'required|string|max_length[255]',
                                //"pres_estado" => 'required|string|max_length[20]'
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
                                $newName = $logo->getRandomName();
                                $datos = array(
                                    "pres_inve_id" => $datos["pres_inve_id"],
                                    "pres_usua_id" => $datos["pres_usua_id"],
                                    "pres_cantidad" => $datos["pres_cantidad"],
                                    "pres_codigouni_alumno" => $datos["pres_codigouni_alumno"],
                                    "pres_evidencia" => "http://localhost:8080/lab-backend/public/Productos/".$newName,
                                    "pres_fechasolicitud" => $datos["pres_fechasolicitud"],
                                    "pres_fechaentregado" => $datos["pres_fechaentregado"],
                                    "pres_fechadevolucion" => $datos["pres_fechadevolucion"],
                                    //"pres_fecharealdevolucion" => $datos["pres_fecharealdevolucion"],
                                    //"pres_observacion" => $datos["pres_observacion"],
                                    //"pres_estado" => $datos["pres_estado"]
                                );
                                $model = new PrestamoModel();
                                $pres_id = $model -> update($id,$datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Registro existoso"
                                );
                                //Subir archivo
                                $model2 = new PrestamoModel;
                                //$empresa = $model2->getProducto($empresa2);
                                if($logo->isValid() && !$logo->hasMoved()) {
                                    // Directorio de destino
                                    $uploadPath = './public/Productos';
                        
                                    // Generar un nombre de archivo único
                        
                                    // Mover el archivo al directorio de destino
                                    $logo->move($uploadPath, $newName);
                        
                                    // Enviar una respuesta JSON con la ubicación del archivo
                                    $response = [
                                        'status' => 'success',
                                        'message' => 'Archivo subido correctamente',
                                        'logo$logo_path' => base_url($uploadPath."/".$newName)
                                    ];
                        
                                    $up = $this->response->setJSON($response);
                                } else {
                                    // Si hay un error en la carga del archivo
                                    $response = [
                                        'status' => 'error',
                                        'message' => $logo->getErrorString()
                                    ];
                                  $up =  $this->response->setJSON($response);
                                }
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
    }*/
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
                    $model = new PrestamoModel();
                    $prestamo = $model -> find($id);
                    //var_dump($prestamo); die;
                    if(!empty($prestamo)){
                        $datos = array(
                            "prod_estado" => 0
                        );
                        $prestamo = $model -> delete($id);
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