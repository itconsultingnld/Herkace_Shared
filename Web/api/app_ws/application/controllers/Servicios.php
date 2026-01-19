<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Servicios extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado_get()
    {
        $query = $this->db->select("*")->from("servicios")->get();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->servicio_id = (int)$row->servicio_id;
            }
            $this->response($registros, 200);
        } else {
            $this->response(array(), 400);
        }
    }
}
