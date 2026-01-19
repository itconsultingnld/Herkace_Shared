<?php
class Verificaciones_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado_agregar_to_orden($cliente_id)
    {
        $params = array($cliente_id);
        $query_sql = "SELECT verificacion_id, folio FROM verificaciones WHERE cliente_id = ? AND orden_id = 0 AND activo = 1 AND estatus_id IN (2, 3) ORDER BY folio";
        $query = $this->db->query($query_sql, $params);
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->verificacion_id = (int) $row->verificacion_id;
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

    public function listado_vw_prefactura_agregar_to()
    {
        $query_sql = 'SELECT * FROM vw_verificaciones_prefactura WHERE prefactura_id = 0 AND orden_cerrada = 1 AND activo = 1 AND estatus_id IN (2, 3)';
        $query = $this->db->query($query_sql);
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->verificacion_id = (int) $row->verificacion_id;
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

    public function listado_vw_prefactura_por_prefactura_id($prefactura_id)
    {
        $params = array($prefactura_id);
        $query_sql = 'SELECT * FROM vw_verificaciones_prefactura WHERE prefactura_id = ?';
        $query = $this->db->query($query_sql, $params);
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->verificacion_id = (int) $row->verificacion_id;
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

    public function listado_vw($filtros)
    {
        unset($filtros["_"]);
        $query = $this->db->select("*")->from("vw_verificaciones")->where($filtros)->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->verificacion_id = (int) $row->verificacion_id;
                $row->orden_id = (int) $row->orden_id;
                $row->vehiculo_id = (int) $row->vehiculo_id;
                $row->periodo = (int) $row->periodo;
                $row->imprime_nom = boolval((int) $row->imprime_nom);
                $row->orden_cerrada = boolval((int) $row->orden_cerrada);
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

    public function listado_vw_prefactura($filtros)
    {
        unset($filtros["_"]);
        $query = $this->db->select("*")->from("vw_verificaciones_prefactura")->where($filtros)->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->verificacion_id = (int) $row->verificacion_id;
                $row->orden_id = (int) $row->orden_id;
                $row->vehiculo_id = (int) $row->vehiculo_id;
                $row->periodo = (int) $row->periodo;
                $row->imprime_nom = boolval((int) $row->imprime_nom);
                $row->orden_cerrada = boolval((int) $row->orden_cerrada);
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

    public function listado_vw_excepto($filtros)
    {
        unset($filtros["_"]);
        $verificacion_id = (int)$filtros['verificacion_id'];
        unset($filtros["verificacion_id"]);
        $filtros['verificacion_id !='] = $verificacion_id;
        $query = $this->db->select("*")->from("vw_verificaciones")->where($filtros)->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->verificacion_id = (int) $row->verificacion_id;
                $row->orden_id = (int) $row->orden_id;
                $row->vehiculo_id = (int) $row->vehiculo_id;
                $row->periodo = (int) $row->periodo;
                $row->imprime_nom = boolval((int) $row->imprime_nom);
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

    public function obtener_folio_ant($datos)
    {
        $vehiculo_id = (int) $datos['vehiculo_id'];
        $tipo_verificacion_id = (int) $datos['tipo_verificacion_id'];
        $where = array('vehiculo_id' => $vehiculo_id, 'tipo_verificacion_id' => $tipo_verificacion_id, 'folio !=' => '');
        $query = $this->db->select("*")->from("verificaciones")->where($where)->order_by("verificacion_id", "DESC")->get();
        if($query->num_rows() > 0) {
            $reg = $query->row();
          
            $respuesta = array(
                'fecha_ant' => $reg->fecha_ant,
                'folio' =>  $reg->folio,
                'error' => false
            );
        } else {
            $respuesta = array(
                'mensaje' => 'Este vehiculo no cuenta con certificado anterior',
                'error' => true
            );
        }
        return $respuesta;
    }

    public function obtener_por_id($verificacion_id)
    {
        $query = $this->db->select("*")->from("verificaciones")->where('verificacion_id', $verificacion_id)->get();
        if ($query->num_rows() >= 0) {
            $registro = $query->row();
            $registro->verificacion_id = (int)$registro->verificacion_id;
            $registro->tipo_verificacion_id = (int)$registro->tipo_verificacion_id;
            $registro->cliente_id = (int)$registro->cliente_id;
            $registro->orden_id = (int)$registro->orden_id;
            $registro->vehiculo_id = (int)$registro->vehiculo_id;
            $registro->tipo_unidad_verificacion_id = (int)$registro->tipo_unidad_verificacion_id;
            $registro->estatus_id = (int)$registro->estatus_id;
            $registro->estatus_unidad = (int)$registro->estatus_unidad;
            $registro->tecnico_id = (int)$registro->tecnico_id;
            $registro->periodo = (int)$registro->periodo;
            $registro->hora_inicio = hora_formato_hm($registro->hora_inicio);
            $registro->hora_final = hora_formato_hm($registro->hora_final);
            $registro->imprime_nom = boolval((int)$registro->imprime_nom);
            $registro->activo = boolval((int)$registro->activo);
            $registro->precio_id = (int)$registro->precio_id;
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

    public function obtener_por_id_vw($verificacion_id)
    {
        $query = $this->db->select("*")->from("vw_verificaciones")->where('verificacion_id', $verificacion_id)->get();
        if ($query->num_rows() >= 0) {
            $registro = $query->row();
            $registro->verificacion_id = (int) $registro->verificacion_id;
            $registro->periodo = (int) $registro->periodo;
            $registro->imprime_nom = boolval((int) $registro->imprime_nom);
            $registro->activo = boolval((int) $registro->activo);
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

    public function listado_vw_filtrado($datos)
    {
        $where = array();
        $fecha_inicial = $datos['fecha_inicial'];
        if ($fecha_inicial != '') {
            $where['fecha >='] = $fecha_inicial;
        }
        $fecha_final = $datos['fecha_final'];
        if ($fecha_final != '') {
            $where['fecha <='] = $fecha_final;
        }
        $num_inicial = $datos['folio_inicial'];
        if ($num_inicial != '') {
            $where['folio >='] = $num_inicial;
        }
        $num_final = $datos['folio_final'];
        if ($num_final != '') {
            $where['folio <='] = $num_final;
        }
        $tipo_verificacion = $datos['tipo_verificacion'];
        if ($tipo_verificacion != '') {
            $where['tipo_verificacion'] = $tipo_verificacion;
        }
        $tipo_unidad_verificacion = $datos['tipo_unidad_verificacion'];
        if ($tipo_unidad_verificacion != '') {
            $where['tipo_unidad_verificacion'] = $tipo_unidad_verificacion;
        }
        $numero_orden = $datos['numero_orden'];
        if ($numero_orden != '') {
            $where['orden LIKE'] = "%$numero_orden%";
        }
        $query = $this->db->select("*")->from("vw_verificaciones")->where($where)->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->orden_id = (int) $row->orden_id;
                $row->orden_cerrada = boolval((int) $row->orden_cerrada);
            }
            $respuesta = array(
                'registros' => $registros,
                'error' => false,
            );
        } else {
            $respuesta = array(
                'registros' => $registros,
                'error' => true,
            );
        }
        return $respuesta;
    }

    public function agregar($datos)
    {
        $data_limpia = array(
            'cliente_id' => (int)$datos['cliente_id'],
            'tipo_verificacion_id' => $datos['tipo_verificacion_id'],
            'tipo_unidad_verificacion_id' => $datos['tipo_unidad_verificacion_id'],
            'folio' =>  $datos['num_folio'],
            'vehiculo_id' => (int)$datos['vehiculo_id'],
            'fecha' => $datos['fecha'],
            'folio_ant' =>  $datos['folio_ant'],
            'fecha_ant' => $datos['fecha_ant'],
            'estatus_id' => $datos['estatus_id'],
            'estatus_unidad' => (int)$datos['estatus_unidad'],
            'tecnico_id' => (int)$datos['tecnico_id'],
            'kilometraje' => (int)$datos['kilometraje'],
            'periodo' => (int)$datos['periodo'],
            'hora_inicio' => $datos['hora_inicio'],
            'hora_final' => $datos['hora_final'],
            'imprime_nom' => (int)$datos['imprime_nom'],
            'orden_id' => $datos['orden_id'],
            'precio_id' => (int)$datos['precio_id'],
            'precio' => $datos['precio'],
        );
        $data_disponible = array(
            'disponible' => 0
        );
        $this->db->trans_begin();
        $this->db->insert('verificaciones', $data_limpia);
        $this->db->where('folio_id', $datos['folio_id'])->set($data_disponible)->update('folios');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'registrado' => false,
                'error' => true,
                'mensaje' => 'Error en insercion.'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'registrado' => true,
                'error' => false,
                'mensaje' => 'Se inserto el registro'
            );
        }
        return $respuesta;
    }
    
    public function autorizar_verificaciones($datos)
    {
        $orden_id = (int) $datos['orden_id'];
        $where = array('orden_id' => $orden_id, 'verif_creada' => 0);
        $query_os = $this->db->select("*")->from("ordenes_servicios")->where($where)->get();
        $queryV = $this->db->select("cliente_id, vehiculo_id")->from("vehiculos")->get();
        $queryP = $this->db->select("precio_id, precio")->from("precios")->get();
        $resultado_os = $query_os->result();
        $resultado_v = $queryV->result();
        $resultado_p = $queryP->result();
        $this->db->trans_begin();
        foreach ($resultado_os as $os) {
            $vehiculo_id = (int) $os->vehiculo_id;
            $orden_servicio_id = (int) $os->orden_servicio_id;
            $cliente_id = 0;
            foreach ($resultado_v as $v) {
                $vehiculo_id_ = (int) $v->vehiculo_id;
                if ($vehiculo_id == $vehiculo_id_) {
                    $cliente_id = (int) $v->cliente_id;
                    break;
                }
            }
            $registros = array(
                'cliente_id' => $cliente_id,
                'vehiculo_id' => $vehiculo_id,
                'tipo_unidad_verificacion_id' => $os->tipo_unidad_verificacion_id,
                'orden_id' => $orden_id,
                'viene_orden_servicio' => 1
            );
            if (boolval((int)$os->ec)) {
                $precio = '';
                $precio_id = (int) $os->precio_id_ec;
                foreach ($resultado_p as $p) {
                    $precio_id_ = (int) $p->precio_id;
                    if ($precio_id == $precio_id_) {
                        $precio = $p->precio;
                        break;
                    }
                }
                $registros['tipo_verificacion_id'] = 4;
                $registros['precio_id'] = $precio_id;
                $registros['precio'] = $precio;
                $this->db->insert('verificaciones', $registros);
            }
            if (boolval((int)$os->fm)) {
                $precio = '';
                $precio_id = (int) $os->precio_id_fm;
                foreach ($resultado_p as $p) {
                    $precio_id_ = (int) $p->precio_id;
                    if ($precio_id == $precio_id_) {
                        $precio = $p->precio;
                        break;
                    }
                }
                $registros['tipo_verificacion_id'] = 2;
                $registros['precio_id'] = $precio_id;
                $registros['precio'] = $precio;
                $this->db->insert('verificaciones', $registros);
            }
            $data_disponible = array(
                'verif_creada' => 1
            );
            $this->db->where('orden_servicio_id', $orden_servicio_id)->set($data_disponible)->update('ordenes_servicios');
        }
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'registrado' => false,
                'error' => true,
                'mensaje' => 'Error al autorizar verificaciones'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'registrado' => true,
                'error' => false,
                'mensaje' => 'Verificaciones autorizadas'
            );
        }
        return $respuesta;
    }

    public function agregar_desde_orden_servicio($datos)
    {
        $orden_servicio_id = (int)$datos['orden_servicio_id'];
        $registro = $this->db->select("*")->from("ordenes_servicios")->where("orden_servicio_id", $orden_servicio_id)->get();
        $res = $registro->row();
        $queryV = $this->db->select("*")->from("vehiculos")->where("vehiculo_id", $res->vehiculo_id)->get();
        $resV = $queryV->row();
        $cliente_id = (int)$resV->cliente_id;
        $data_limpia = array(
            'cliente_id' => $cliente_id,
            'tipo_unidad_verificacion_id' => (int) $res->tipo_unidad_verificacion_id,
            'vehiculo_id' => (int)$res->vehiculo_id,
            'orden_id' => (int) $res->orden_id,
            'viene_orden_servicio' => 1
        );
        $data_disponible = array(
            'verif_creada' => 1
        );
        $this->db->trans_begin();
        if (boolval((int)$res->ec)) {
            $data_limpia['tipo_verificacion_id'] = 4;
            $queryP = $this->db->select("*")->from("precios")->where("precio_id", $res->precio_id_ec)->get();
            $resP = $queryP->row();
            $data_limpia['precio_id'] = (int) $res->precio_id_ec;
            $data_limpia['precio'] = $resP->precio;
            $this->db->insert('verificaciones', $data_limpia);
        }
        if (boolval((int)$res->fm)) {
            $data_limpia['tipo_verificacion_id'] = 2;
            $queryP = $this->db->select("*")->from("precios")->where("precio_id", $res->precio_id_fm)->get();
            $resP = $queryP->row();
            $data_limpia['precio_id'] = (int) $res->precio_id_fm;
            $data_limpia['precio'] = $resP->precio;
            $this->db->insert('verificaciones', $data_limpia);
        }
        $this->db->where('orden_servicio_id', $orden_servicio_id)->set($data_disponible)->update('ordenes_servicios');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'registrado' => false,
                'error' => true,
                'mensaje' => 'Error al agregar verificación'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'registrado' => true,
                'error' => false,
                'mensaje' => 'Verificación agregada exitosamente'
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $verificacion_id = (int)$datos['verificacion_id'];
        $data_limpia = array(
            'cliente_id' => (int)$datos['cliente_id'],
            'tipo_unidad_verificacion_id' => (int)$datos['tipo_unidad_verificacion_id'],
            'vehiculo_id' => (int)$datos['vehiculo_id'],
            'fecha' => $datos['fecha'],
            'folio_ant' =>  $datos['folio_ant'],
            'fecha_ant' => $datos['fecha_ant'],
            'estatus_id' => (int)$datos['estatus_id'],
            'estatus_unidad' => (int)$datos['estatus_unidad'],
            'tecnico_id' => (int)$datos['tecnico_id'],
            'kilometraje' => (int)$datos['kilometraje'],
            'periodo' => (int)$datos['periodo'],
            'hora_inicio' => $datos['hora_inicio'],
            'hora_final' => $datos['hora_final'],
            'imprime_nom' => (int)$datos['imprime_nom'],
            'precio_id' => (int)$datos['precio_id'],
            'precio' => $datos['precio'],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('verificacion_id', $verificacion_id)->set($data_limpia)->update('verificaciones');
        if (filter_var($datos['cambio_folio'], FILTER_VALIDATE_BOOLEAN)) {
            $data_num_folio = array(
                'tipo_verificacion_id' => (int)$datos['tipo_verificacion_id'],
                'folio' =>  $datos['num_folio']
            );
            $this->db->where('verificacion_id', $verificacion_id)->set($data_num_folio)->update('verificaciones');
            $data_disponible = array(
                'disponible' => 0
            );
            $this->db->where('folio_id', (int)$datos['folio_id'])->set($data_disponible)->update('folios');
        }
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

    public function asignar_orden($datos)
    {
        $verificacion_id = (int)$datos['verificacion_id'];
        $data_limpia = array(
            'orden_id' => (int)$datos['orden_id']
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('verificacion_id', $verificacion_id)->set($data_limpia)->update('verificaciones');
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

    public function asignar_prefactura($datos)
    {
        $data_limpia = array(
            'prefactura_id' => (int)$datos['prefactura_id']
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where_in('verificacion_id', $datos['verificaciones'])->set($data_limpia)->update('verificaciones');
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
