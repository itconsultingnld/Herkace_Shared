<?php
class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function vistadashboard()
    {
        $query = $this->db->select("*")->from("vw_dashboard")->get();
        if ($query && $query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->Cantidad = (int) $row->Cantidad;
            }
            $respuesta = array(
                'registros' => $registros,
                'error' => false
            );
        } else {
            $respuesta = array(
                'mensaje' => 'Error en datos',
                'error' => true
            );
        }
        return $respuesta;
    }
}
