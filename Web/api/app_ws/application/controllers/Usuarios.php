<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

class Usuarios extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Usuarios_model");
    }
    
    public function listado_get()
    {
        $respuesta = $this->Usuarios_model->listado();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

}
