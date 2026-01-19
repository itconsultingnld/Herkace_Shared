<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

class Administradores extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Administradores_model");
    }
    
    public function listado_get()
    {
        $respuesta = $this->Administradores_model->listado();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }

    public function desactivar_put()
    {
        $respuesta = $this->Administradores_model->desactivar($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function agregar_post()
    {
        $datos = $this->post();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('InsertarAdministrador_post')) {
            $respuesta = $this->Administradores_model->agregar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function modificar_put(){
        $admin_id = (int) $this->uri->segment(3);
        $datos_admin = $this->put();
        $this->form_validation->set_data($datos_admin);
        if ($this->form_validation->run('actualizar_administrador_put')) {
            $respuesta = $this->Administradores_model->modificar($datos_admin, $admin_id);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function excel_post()
    {
        $this->load->helper('excel_administradores');
        excel_administradores();
    }
}
