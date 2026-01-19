<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

class TiposUnidades extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("TiposUnidades_model");
    }

    public function listado_get()
    {
        $respuesta = $this->TiposUnidades_model->listado($this->get());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function agregar_post()
    {
        $datos = $this->post();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('tipos_unidades_agregar_post')) {
            $respuesta = $this->TiposUnidades_model->agregar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }
    
    public function modificar_put()
    {
        $datos = $this->put();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('tipos_unidades_modificar_put')) {
            $respuesta = $this->TiposUnidades_model->modificar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function desactivar_put()
    {
        $respuesta = $this->TiposUnidades_model->desactivar($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function excel_tipos_unidades_post()
    {
        $this->load->helper('excel_tipos_unidades');
        excel_tipos_unidades();
    }
}
