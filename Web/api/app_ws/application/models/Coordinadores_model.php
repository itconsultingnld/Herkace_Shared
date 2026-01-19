<?php
class Coordinadores_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function coordinadores()
    {
        $where = array('rol_id' => 2);
        $query = $this->db->select("*")->from("usuarios")->where($where)->get();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->usuario_id = (int) $row->usuario_id;
                $row->activo = boolval((int) $row->activo);
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

    public function coordinador_desactivar($datos)
    {
        $usuario_id = (int)$datos["usuario_id"];
        $data_limpia = array(
            'activo' => (int)$datos["activo"],
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('usuario_id', $usuario_id)->set($data_limpia)->update('usuarios');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $respuesta = array(
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

    public function coordinador_pass($dato, $idusuario)
    {
        $data_device = array(
            'password' => pass_hash($dato['password'])
        );
        $this->db->trans_begin();

        /* se actualiza la tabla */

        $this->db->where('usuario_id', $idusuario)->set($data_device)->update('usuarios');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $respuesta = array(
                'error' => true,
                'mensaje' => 'Error en actualizacion',
            );
            $status = 422;
        } else {
            $this->db->trans_commit();

            $respuesta = array(
                'cambio' => true,
                'error' => false,
                'mensaje' => 'Actualizado correctamente',
            );
            $status = 200;
        }
        return $respuesta;
    }

    public function InsertarCoordinador($datos)
    {
        $usuario = $datos['username'];
        $correo = $datos['correo'];
        $whereCorreo = array('correo' => $correo);
        $where = array('username' => $usuario);
        $queryCorreo = $this->db->select("correo")->from("usuarios")->where($whereCorreo)->get();
        if ($queryCorreo->num_rows() > 0) {
            $respuesta = array(
                'error' => false,
                'mensaje' => 'Este correo ya está en uso'
            );
            return $respuesta;
        }
        $query = $this->db->select("username")->from("usuarios")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'error' => false,
                'mensaje' => 'Este nombre de usuario ya está en uso'
            );
            return $respuesta;
        }
        $data_limpia = array(
            'nombre' => $datos['nombre'],
            'ape_pat' => $datos['ape_pat'],
            'ape_mat' =>  $datos['ape_mat'],
            'correo' => $correo,
            'username' => $usuario,
            'password' => pass_hash($datos['password']),
            'rol_id' => 2
        );
        $this->db->trans_begin();
        $this->db->insert('usuarios', $data_limpia);
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'error' => true,
                'mensaje' => 'Error en insercion.'
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'error' => false,
                'mensaje' => 'Se inserto el registro'
            );
        }
        return $respuesta;
    }

    public function coordinador_por_id($idusuario)
    {
        $query = $this->db->select("*")->from("usuarios")->where('usuario_id', $idusuario)->get();
        if ($query->num_rows() >= 0) {
            $respuesta = array(
                'registro' => $query->row(),
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

    public function actualizar_coordinador($datos,$idusuario)
    {
        $usuario = $datos['username'];
        $correo = $datos['correo'];
        $whereCorreo = array('correo' => $correo, 'usuario_id !=' => $idusuario);
        $queryCorreo = $this->db->select("correo")->from("usuarios")->where($whereCorreo)->get();
        if ($queryCorreo->num_rows() > 0) {
            $respuesta = array(
                'error' => false,
                'mensaje' => 'Este correo ya está en uso'
            );
            return $respuesta;
        }
        $where = array('username' => $usuario, 'usuario_id !=' => $idusuario);
        $query = $this->db->select("username")->from("usuarios")->where($where)->get();
        if ($query->num_rows() > 0) {
            $respuesta = array(
                'error' => false,
                'mensaje' => 'Este nombre de usuario ya está en uso'
            );
            return $respuesta;
        }

        $data_usuario = array(
            'nombre' => $datos['nombre'],
            'ape_pat' => $datos['ape_pat'],
            'ape_mat' => $datos['ape_mat'],
            'correo' => $datos['correo'],
            'username' => $datos['username'],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('usuario_id', $idusuario)->set($data_usuario)->update('usuarios');
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Se actualizo el registro',
                'error' => false
            );
        }
        return $respuesta;
    }
}
