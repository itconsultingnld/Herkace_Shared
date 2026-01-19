<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

class Tecnicos extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Tecnicos_model");
    }
    /* Get - Listado de usuarios */
    public function tecnicos_get()
    {
        $respuesta = $this->Tecnicos_model->tecnicos();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }

    public function desactivar_tecnico_put()
    {
        /* Obtiene parámetros */
        $respuesta = $this->Tecnicos_model->desactivar_tecnico($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function insertar_tecnico_post()
    {
        $datos_tecnico = $this->post();
        $this->form_validation->set_data($datos_tecnico);
        if ($this->form_validation->run('insertar_tecnico_post')) {
            $respuesta = $this->Tecnicos_model->insertar_tecnico($datos_tecnico);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }
    /* Get - Listado de usuarios por idusuario */
    public function tecnico_por_id_get()
    {
        $tecnico_id = $this->uri->segment(3);
        $respuesta = $this->Tecnicos_model->tecnico_por_id($tecnico_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registro'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }
    /* Put - Actualiza registro en usuarios */
    public function actualizar_tecnico_put()
    {
        $tecnico_id = (int) $this->uri->segment(3);
        $datos_tecnico = $this->put();
        $this->form_validation->set_data($datos_tecnico);
        if ($this->form_validation->run('actualizar_tecnico_put')) {
            $respuesta = $this->Tecnicos_model->actualizar_tecnico($datos_tecnico, $tecnico_id);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_string(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function excel_tecnico_post()
    {
        $this->load->helper('excel_tecnicos');
        excel_tecnico();
    }
}
