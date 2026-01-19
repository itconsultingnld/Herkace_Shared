<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Dashboard extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Se agregar la conexion a la base de datos a toda la clase */
        $this->load->database();
        $this->load->model('Dashboard_model');
    }

    /* Get - Listado vista dashboard */
    public function vistadashboard_get()
    {
        $respuesta = $this->Dashboard_model->vistadashboard();
        if($respuesta["error"] === false){
            $this->response($respuesta['registros'], 200);
        }else{
            $this->response($respuesta['mensaje'], 400);
        }        
    }
}
