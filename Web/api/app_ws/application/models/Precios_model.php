<?php
class Precios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado_con_servicios()
    {
        $query = $this->db->select("*")->from("servicios")->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->servicio_id = (int) $row->servicio_id;
                $row->precios = array();
            }
            $query_sub = $this->db->select("*")->from("precios")->where('activo', 1)->get();
            if ($query_sub->num_rows() >= 0) {
                $registros_sub = $query_sub->result();
                foreach ($registros_sub as $row) {
                    $row->servicio_id = (int) $row->servicio_id;
                    $row->precio_id = (int) $row->precio_id;
                    $row->activo = boolval((int) $row->activo);
                    for ($i = 0; $i < count($registros); $i++) {
                        if ($registros[$i]->servicio_id == $row->servicio_id) {
                            array_push($registros[$i]->precios, $row);
                            break;
                        }
                    }
                }
                $respuesta = array(
                    'error' => false,
                    'registros' => $registros,
                );
            } else {
                $respuesta = array(
                    'error' => true,
                    'registros' => $registros,
                );
            }
        } else {
            $respuesta = array(
                'error' => true,
                'registros' => $registros,
            );
        }
        return $respuesta;
    }

    public function agregar($datos)
    {
        $data_limpia = array(
            'servicio_id' => (int)$datos['servicio_id'],
            'nombre' => $datos['nombre'],
            'precio' => $datos['precio'],
        );
        $this->db->trans_begin();
        $this->db->insert('precios', $data_limpia);
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'error' => true,
                'registrado' => false,
                'mensaje' => 'Error en insercion.'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'error' => false,
                'registrado' => true,
                'mensaje' => 'Se inserto el registro'
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $precio_id =(int)$datos['precio_id'];
        $data_limpia = array(
            'nombre' => $datos['nombre'],
            'precio' => $datos['precio'],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('precio_id', $precio_id)->set($data_limpia)->update('precios');
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'error' => true,
                'registrado' => false,
                'mensaje' => 'Error en actualizacion'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'error' => false,
                'registrado' => true,
                'mensaje' => 'Se actualizo el registro'
            );
        }
        return $respuesta;
    }

    public function desactivar($datos)
    {
        $precio_id = (int)$datos["precio_id"];
        $data_limpia = array(
            'activo' => 0,
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('precio_id', $precio_id)->set($data_limpia)->update('precios');
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
