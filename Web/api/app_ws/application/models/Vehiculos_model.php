<?php
class Vehiculos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado()
    {
        $query = $this->db->select("*")->from("vehiculos")->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->vehiculo_id = (int) $row->vehiculo_id;
                $row->marca_vehiculo_id = (int) $row->marca_vehiculo_id;
                $row->tipo_vehiculo_id = (int) $row->tipo_vehiculo_id;
                $row->tipo_unidad_id = (int) $row->tipo_unidad_id;
                $row->tipo_servicio_id = (int) $row->tipo_servicio_id;
                $row->cliente_id = (int) $row->cliente_id;
                $row->capacidad = (int) $row->capacidad;
                $row->activo = boolval((int) $row->activo);
            }
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

    public function listado_vw()
    {
        $query = $this->db->select("*")->from("vw_vehiculos")->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->vehiculo_id = (int) $row->vehiculo_id;
                $row->capacidad = (int) $row->capacidad;
                $row->activo = boolval((int) $row->activo);
            }
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

    public function obtener_por_id($vehiculo_id)
    {
        $query = $this->db->select("*")->from("vehiculos")->where('vehiculo_id', $vehiculo_id)->get();
        if ($query->num_rows() >= 0) {
            $registro = $query->row();
            $registro->vehiculo_id = (int)$registro->vehiculo_id;
            $registro->cliente_id = (int)$registro->cliente_id;
            $registro->marca_vehiculo_id = (int)$registro->marca_vehiculo_id;
            $registro->tipo_vehiculo_id = (int)$registro->tipo_vehiculo_id;
            $registro->tipo_unidad_id = (int)$registro->tipo_unidad_id;
            $registro->tipo_servicio_id = (int)$registro->tipo_servicio_id;
            $registro->capacidad = (int)$registro->capacidad;
            $registro->anio = (int) $registro->anio;
            $respuesta = array(
                'registro' => $registro,
                'error' => false
            );
        } else {
            $respuesta = array(
                'registro' => array(),
                'error' => true
            );
        }
        return $respuesta;
    }

    public function agregar($datos)
    {
        $data_limpia = array(
            'cliente_id' => (int)$datos['cliente_id'],
            'num_serie' => $datos['num_serie'],
            'num_placas' =>  $datos['num_placas'],
            'marca_vehiculo_id' => (int)$datos['marca_vehiculo_id'],
            'modelo' => $datos['modelo'],
            'tarjeta_circ' => $datos['tarjeta_circ'],
            'tipo_vehiculo_id' => (int)$datos['tipo_vehiculo_id'],
            'tipo_unidad_id' => (int)$datos['tipo_unidad_id'],
            'tipo_servicio_id' => (int)$datos['tipo_servicio_id'],
            'capacidad' => (int)$datos['capacidad'],
            'capacidad_unidad' => $datos['capacidad_unidad'],
            'anio' => (int)$datos['anio']
        );
        $this->db->trans_begin();
        $this->db->insert('vehiculos', $data_limpia);
        $item_id = $this->db->insert_id();
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'registrado' => false,
                'error' => true,
                'id' => 0,
                'mensaje' => 'Error en insercion.'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'registrado' => true,
                'error' => false,
                'id' => $item_id,
                'mensaje' => 'Se inserto el registro'
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $vehiculo_id = (int)$datos['vehiculo_id'];
        $data_limpia = array(
            'cliente_id' => (int)$datos['cliente_id'],
            'num_serie' => $datos['num_serie'],
            'num_placas' =>  $datos['num_placas'],
            'marca_vehiculo_id' => (int)$datos['marca_vehiculo_id'],
            'modelo' => $datos['modelo'],
            'tarjeta_circ' => $datos['tarjeta_circ'],
            'tipo_vehiculo_id' => (int)$datos['tipo_vehiculo_id'],
            'tipo_unidad_id' => (int)$datos['tipo_unidad_id'],
            'tipo_servicio_id' => (int)$datos['tipo_servicio_id'],
            'capacidad' => (int)$datos['capacidad'],
            'capacidad_unidad' => $datos['capacidad_unidad'],
            'anio' => (int)$datos['anio']
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('vehiculo_id', $vehiculo_id)->set($data_limpia)->update('vehiculos');
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
        $vehiculo_id = (int)$datos["vehiculo_id"];
        $data_limpia = array(
            'activo' => (int)$datos["activo"],
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('vehiculo_id', $vehiculo_id)->set($data_limpia)->update('vehiculos');
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
