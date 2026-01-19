<?php
class Folios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado_paquete_actual($datos)
    {
        $prefijo = '';
        $tipo_verificacion_id = (int)$datos['tipo_verificacion_id'];
        $tipo_unidad = (int)$datos['tipo_unidad'];
        if ($tipo_verificacion_id == 2) {
            if ($tipo_unidad == 1 || $tipo_unidad == 3) {
                $prefijo = 'M';
            } else{
                $prefijo = 'A';
            }
        }
        $registros = array();
        $fecha_hora = $this->db->query('select fecha, hora from folios where tipo_verificacion_id = ' . $tipo_verificacion_id . ' and disponible = 1 and prefijo = "'.$prefijo.'" group by fecha, hora, tipo_verificacion_id order by fecha, hora limit 1');
        if ($fecha_hora && $fecha_hora->num_rows() >= 1) {
            $res = $fecha_hora->row();
            $where = array('tipo_verificacion_id' => $tipo_verificacion_id, 'disponible' => 1, 'fecha' => $res->fecha, 'hora' => $res->hora, 'prefijo' => $prefijo);
            $folios = $this->db->select('folio_id,concat(prefijo,num_folio) as folio')->from('folios')->where($where)->get();
            if ($folios && $folios->num_rows() >= 0) {
                $registros = $folios->result();
                $respuesta = array(
                    'folios' => $registros,
                    'error' => false
                );
            } else {
                $respuesta = array(
                    'folios' => $registros,
                    'error' => true
                );
            }
        } else {
            $respuesta = array(
                'folios' => $registros,
                'error' => false
            );
        }
        return $respuesta;
    }

    public function listado_vw()
    {
        $query = $this->db->select("*")->from("vw_folios")->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            $respuesta = array(
                'registros' => $registros,
                'error' => false
            );
        } else {
            $respuesta = array(
                'registros' => $registros,
                'error' => true
            );
        }
        return $respuesta;
    }

    public function agregar($datos)
    {
        $desde = (int)$datos['desde'];
        $hasta = (int)$datos['hasta'];
        $prefijo = $datos['prefijo'];
        $tipo_verificacion_id = (int)$datos['tipo_verificacion_id'];
        $where = array('prefijo'=>$prefijo, 'num_folio >='=>$desde,'num_folio <='=>$hasta, 'tipo_verificacion_id'=>$tipo_verificacion_id);
        $query = $this->db->select("folio_id")->from("folios")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'error' => false,
                'registrado' => false,
                'mensaje' => 'Al menos uno de los folios ya se encuentra registrado.'
            );
            return $respuesta;
        }
        $datetime = datetimeMatamoros();
        $sp = "CALL sp_folios_insert (?,?,?,?,?,?,?,@a_success)";
        /* No @ needed.  Codeigniter gets it right either way */
        $params = array(
            'tipo_verificacion_id' => (int)$datos['tipo_verificacion_id'],
            'prefijo' => $datos['prefijo'],
            'desde' => (int)$datos['desde'],
            'hasta' => (int)$datos['hasta'],
            'usuario_id' => (int)$datos['usuario_id'],
            'fecha' => $datetime->format('Y-m-d'),
            'hora' => $datetime->format('H:i:s')
        );
        $query = $this->db->query($sp, $params);
        if ($query && $query->num_rows() >= 0) {
            $row = $query->row();
            $respuesta = array(
                'registrado' => boolval((int)$row->success),
                'success' => (int)$row->success,
                'error' => false
            );
        } else {
            $respuesta = array(
                'registrado' => false,
                'error' => true
            );
        }
        return $respuesta;
    }

    public function desactivar($datos)
    {
        $folio_id = (int)$datos["folio_id"];
        $data_limpia = array(
            'disponible' => 0,
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('folio_id', $folio_id)->set($data_limpia)->update('folios');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $respuesta = array(
                'cambio' => false,
                'error' => true,
                'mensaje' => 'Error en actualizacion',
            );
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'cambio' => true,
                'error' => false,
                'mensaje' => 'Actualizado correctamente',
            );
        }
        return $respuesta;
    }
}
