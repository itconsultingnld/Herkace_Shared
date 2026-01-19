<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Ordenes extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model("Ordenes_model");
    }

    public function cliente_to_orden_post()
    {
        $respuesta = $this->Ordenes_model->cliente_to_orden($this->post());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
        
    }

    public function generarNumOrden_post()
    {
        $respuesta = $this->Ordenes_model->generarNumOrden($this->post());
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
        
    }

    /* GET - Listado de Ordenes  */
    public function listado_get()
    {
        $respuesta = $this->Ordenes_model->listado();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }

    public function listado_vw_get()
    {
        $respuesta = $this->Ordenes_model->listado_vw();
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }

    public function listado_vw_filtrado_post()
    {
        $respuesta = $this->Ordenes_model->listado_vw_filtrado($this->post());
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['registros'], 400);
        }
    }

    public function desactivar_put()
    {
        /* Obtiene parámetros */
        $orden = $this->put("orden_id");
        $respuesta = $this->Ordenes_model->desactivar($orden);
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    /* POST - Inserta registro en Tabla Ordenes */
    public function agregar_post()
    {
        $datos_orden = $this->post();
        $this->form_validation->set_data($datos_orden);
        if ($this->form_validation->run('agregar_ordenes_post')) {
            $respuesta = $this->Ordenes_model->agregar($datos_orden);
            if ($respuesta["error"] === false) {
                $this->response($respuesta['mensaje'], 200);
            } else {
                $this->response($respuesta['mensaje'], 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_string(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    /* GET Orden por ID */
    public function orden_por_id_get()
    {
        $idusuario = $this->uri->segment(3);
        $respuesta = $this->Ordenes_model->orden_por_id($idusuario);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }

    /* PUT - Modificar datos en la tabla Clientes */
    public function modificar_put()
    {
        $datos_orden = $this->put();
        $this->form_validation->set_data($datos_orden);
        if ($this->form_validation->run('orden_modificar_put')) {
            $respuesta = $this->Ordenes_model->modificar($datos_orden);
            if ($respuesta["error"] === false) {
                $this->response($respuesta, 200);
            } else {
                $this->response($respuesta, 400);
            }
        } else {
            $this->response($this->form_validation->get_errores_objeto(), "ERROR_VALIDACION_FORMULARIO");
        }
    }

    public function cerrar_put()
    {
        /* Obtiene parámetros */
        $orden = $this->put("orden_id");
        $respuesta = $this->Ordenes_model->cerrar($orden);
        if ($respuesta["error"] === false) {
            $this->response($respuesta, 200);
        } else {
            $this->response($respuesta, 400);
        }
    }

    /* GET - Listado de Clientes por popularidad */
    public function clientes_pop_get()
    {
        $empresa_id = (int)$this->uri->segment(3);
        $respuesta = $this->Clientes_model->clientes_pop($empresa_id);
        if ($respuesta["error"] === false) {
            $this->response($respuesta['registros'], 200);
        } else {
            $this->response($respuesta['mensaje'], 400);
        }
    }

    public function excel_numero_ordenes_post()
    {
        $respuesta = $this->Ordenes_model->listado_vw_filtrado($this->post());
        $nums = '';
        foreach ($respuesta["registros"] as $reg) {
            $nums .= $reg->num_orden . ',';
        }
        $nums = substr($nums, 0, -1);
        $this->load->helper('excel_numero_ordenes');
        excel_numero_ordenes($nums);
    }
}
