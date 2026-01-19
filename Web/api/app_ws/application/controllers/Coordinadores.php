<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/third_party/jwt/JWT.php';
include APPPATH . '/third_party/jwt/BeforeValidException.php';
include APPPATH . '/third_party/jwt/ExpiredException.php';
include APPPATH . '/third_party/jwt/SignatureInvalidException.php';

class Coordinadores extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Coordinadores_model");
    }
    /* Get - Listado de usuarios */
    public function coordinadores_get()
    {
        $respuesta = $this->Coordinadores_model->coordinadores();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }

    public function coordinador_desactivar_put()
    {
        /* Obtiene parámetros */
        $respuesta = $this->Coordinadores_model->coordinador_desactivar($this->put());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function coordinador_pass_put()
    {
        /* Obtiene parámetros */
        $coordinador_id = $this->put("coordinador_id");
        $respuesta = $this->Coordinadores_model->coordinador_pass($this->put(), $coordinador_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    public function InsertarCoordinador_post()
    {
        $datos_coordinador = $this->post();
        $this->form_validation->set_data($datos_coordinador);
        if ($this->form_validation->run('InsertarCoordinador_post')) {
            $respuesta = $this->Coordinadores_model->InsertarCoordinador($datos_coordinador);
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
    public function coordinador_por_id_get()
    {
        $coordindor_id = $this->uri->segment(3);
        $respuesta = $this->Coordinadores_model->coordinador_por_id($coordindor_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registro'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }
    /* Put - Actualiza registro en usuarios */
    public function actualizar_coordinador_put()
    {
        $coordindor_id = (int) $this->uri->segment(3);
        $datos_coordinador = $this->put();
        $this->form_validation->set_data($datos_coordinador);
        if ($this->form_validation->run('actualizar_coordinador_put')) {
            $respuesta = $this->Coordinadores_model->actualizar_coordinador($datos_coordinador, $coordindor_id);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function excel_coor_post()
    {
        $this->load->helper('excel_coor');
        excel_coor();
    }
}
