<?php
class ClientesFacturacion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listado()
    {
        $where = array('activo' => 1);
        $query = $this->db->select('*')->from('clientes_facturacion')->where($where)->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->cliente_facturacion_id = (int) $row->cliente_facturacion_id;
                $row->numero_cliente = (int) $row->numero_cliente;
                $row->regimen_id = (int) $row->regimen_id;
                $row->activo = boolval((int) $row->activo);
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

    public function listado_vw()
    {
        $query = $this->db->select('*')->from('vw_clientes_facturacion')->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->cliente_facturacion_id = (int) $row->cliente_facturacion_id;
                $row->numero_cliente = (int) $row->numero_cliente;
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

    public function desactivar($datos)
    {
        $cliente_facturacion_id = (int)$datos['cliente_facturacion_id'];
        $data_limpia = array(
            'activo' => (int)$datos['activo']
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('cliente_facturacion_id', $cliente_facturacion_id)->set($data_limpia)->update('clientes_facturacion');
        if ($this->db->trans_status() === FALSE) {
            $respuesta = array(
                'error' => true,
                'mensaje' => 'Error en actualizacion',
            );
            $this->db->trans_rollback();
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

    public function get_por_id($id)
    {
        $query = $this->db->select('*')->from('clientes_facturacion')->where('cliente_facturacion_id', $id)->get();
        if ($query->num_rows() >= 0) {
            $registro = $query->row();
            $registro->cliente_facturacion_id = (int) $registro->cliente_facturacion_id;
            $registro->numero_cliente = (int) $registro->numero_cliente;
            $registro->regimen_id = (int) $registro->regimen_id;
            $registro->activo = boolval((int) $registro->activo);
            $respuesta = array(
                'registro' => $registro,
                'error' => false
            );
        } else {
            $respuesta = array(
                'registro' => array(),
                'error' => false
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $cliente_facturacion_id = (int)$datos['cliente_facturacion_id'];
        $numero_cliente = (int)$datos['numero_cliente'];
        $where = array('numero_cliente' => $numero_cliente, 'cliente_facturacion_id !=' => $cliente_facturacion_id);
        $query = $this->db->select('numero_cliente')->from('clientes_facturacion')->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => false,
                'mensaje' => 'Este número de cliente ya está en uso'
            );
            return $respuesta;
        }
        $where = array('cliente_facturacion_id' => $cliente_facturacion_id);
        $query = $this->db->select('uid')->from('clientes_facturacion')->where($where)->get();
        if ($query->num_rows() <= 0) {
            $respuesta = array(
                'registrado' => false,
                'error' => true,
                'mensaje' => 'Error en actualizacion'
            );
            return $respuesta;
        }
        $uid = $query->row()->uid;
        $insercion = ($uid == '');

        $data_limpia_facturacion = array(
            'razons' => $datos['razon_social'],
            'rfc' => $datos['rfc'],
            'calle' => $datos['calle'],
            'numero_exterior' => $datos['numero_ext'],
            'numero_interior' => $datos['numero_int'],
            'colonia' => $datos['colonia'],
            'localidad' => $datos['localidad'],
            'ciudad' => $datos['municipio'],
            'estado' => $datos['estado'],
            'pais' => $datos['pais'],
            'codpos' => $datos['codigo_postal'],
            'email' => $datos['correo1'],
            'regimen' => $datos['regimen'],
            'usocfdi' => $datos['uso_cfdi'],
        );

        $endpoint = $insercion ? '/v1/clients/create' : '/v1/clients/' . $uid . '/update';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => FACTURA_COM_URL . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data_limpia_facturacion),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                FACTURA_COM_F_PLUGIN,
                FACTURA_COM_F_API_KEY,
                FACTURA_COM_F_SECRET_KEY
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        if ($response->status != 'success') {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'registrado' => false,
                'error' => true
            );
            return $respuesta;
        }
        $data_limpia = array(
            'numero_cliente' => $numero_cliente,
            'razon_social' => $datos['razon_social'],
            'tipo_persona' => $datos['tipo'],
            'rfc' => $datos['rfc'],
            'curp' => $datos['curp'],
            'calle' => $datos['calle'],
            'numero_ext' => $datos['numero_ext'],
            'numero_int' => $datos['numero_int'],
            'colonia' => $datos['colonia'],
            'localidad' => $datos['localidad'],
            'municipio' => $datos['municipio'],
            'estado' => $datos['estado'],
            'pais' => $datos['pais'],
            'codigo_postal' => $datos['codigo_postal'],
            'correo1' => $datos['correo1'],
            'correo2' => $datos['correo2'],
            'correo3' => $datos['correo3'],
            'correo4' => $datos['correo4'],
            'correo5' => $datos['correo5'],
            'regimen_id' => $datos['regimen'],
            'uso_cfdi' => $datos['uso_cfdi'],
        );
        if ($insercion) {
            $data_limpia['uid'] = $response->Data->UID;
        }
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('cliente_facturacion_id', $cliente_facturacion_id)->set($data_limpia)->update('clientes_facturacion');
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'registrado' => false,
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Se actualizo el registro',
                'registrado' => true,
                'error' => false
            );
        }
        return $respuesta;
    }
}
