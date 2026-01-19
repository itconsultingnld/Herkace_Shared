<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Configuracion extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Configuracion_model");
    }

    public function listado_vw_get()
    {
        $respuesta = $this->Configuracion_model->listado_vw();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    /* GET por ID */
    public function obtener_por_id_vw_get()
    {
        $configuracion_id = (int)$this->uri->segment(3);
        $respuesta = $this->Configuracion_model->obtener_por_id_vw($configuracion_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registro'], 200);
        } else {
            $this->response($respuesta['registro'], 400);
        }
    }

    /* PUT - Modificar datos en la tabla */
    public function modificar_put()
    {
        $datos = $this->put();
        $this->form_validation->set_data($datos);
        if ($this->form_validation->run('configuracion_modificar_put')) {
            $respuesta = $this->Configuracion_model->modificar($datos);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }
}
