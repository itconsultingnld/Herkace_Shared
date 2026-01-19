<?php
class Prefacturas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function generar($datos)
    {
        $dt = datetimeMatamoros();
        $fecha = $dt->format('Y-m-d');
        $hora = $dt->format('H:i:s');
        $query = $this->db->query('select num_prefactura from prefacturas order by num_prefactura desc limit 1');
        if ($query) {
            if ($query->num_rows() > 0) {
                $num_prefactura = $query->row();
                $num_prefactura = $num_prefactura->num_prefactura;
                $consecutivo = (int)substr($num_prefactura, 4);
                $consecutivo++;
            } else {
                $consecutivo = 1000;
            }
        } else {
            $respuesta = array(
                'prefactura_id' => 0,
                'numero' => '',
                'mensaje' => 'Error en insercion.',
                'error' => true
            );
            return $respuesta;
        }

        $numPrefactura = 'RKC-' . $consecutivo;
        $obj = array(
            'num_prefactura' => $numPrefactura,
            'fecha' => $fecha,
            'hora' => $hora,
            'usuario_id' => (int)$datos['usuario_id'],
        );
        $this->db->trans_begin();
        $this->db->insert('prefacturas', $obj);

        if ($this->db->trans_status() === false) {

            $respuesta = array(
                'prefactura_id' => 0,
                'numero' => '',
                'mensaje' => 'Error en insercion.',
                'error' => true
            );
            $this->db->trans_rollback();
        } else {
            $prefactura_id = $this->db->insert_id();
            $this->db->trans_commit();
            $respuesta = array(
                'prefactura_id' => $prefactura_id,
                'num_prefactura' => $numPrefactura,
                'mensaje' => 'Prefactura agregada correctamente',
                'error' => false
            );
        }
        return $respuesta;
    }

    public function modificar($datos)
    {
        $data_limpia = array(
            'cliente_facturacion_id' => (int)$datos['cliente_facturacion_id'],
            'condiciones' => $datos['condiciones'],
            'usuario_id_vendedor' => (int)$datos['usuario_id_vendedor'],
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('prefactura_id', (int)$datos['prefactura_id'])->set($data_limpia)->update('prefacturas');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'error' => true,
                'registrado' => false,
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Prefactura actualizada correctamente',
                'error' => false,
                'registrado' => true,
            );
        }
        return $respuesta;
    }

    public function listado_vw()
    {
        $query = $this->db->select('*')->from('vw_prefacturas')->order_by('num_prefactura', 'desc')->get();
        $registros = array();
        if ($query->num_rows() >= 0) {
            $registros = $query->result();
            foreach ($registros as $row) {
                $row->prefactura_id = (int) $row->prefactura_id;
                $row->cliente_facturacion_id = (int) $row->cliente_facturacion_id;
                $row->usuario_id_vendedor = (int) $row->usuario_id_vendedor;
                $row->facturada = boolval((int) $row->facturada);
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
    public function prefactura_por_id($datos)
    {
        $prefactura_id = (int) $datos['prefactura_id'];
        $query = $this->db->query('select * from prefacturas where prefactura_id = ' . $prefactura_id);
        $resp = $query->row();
        $respuesta = array(
            'datos' => $resp,
            'error' => false
        );
        return $respuesta;
    }

    public function facturar($datos)
    {
        $prefactura_id = (int) $datos['prefactura_id'];
        $params = array($prefactura_id);

        $query_sql = "SELECT * FROM vw_verificaciones_prefactura WHERE prefactura_id = ? AND (estatus = 'APROBADO' OR estatus = 'RECHAZADO')";
        $query = $this->db->query($query_sql, $params);
        $verificaciones_db = $query->result_array();

        $params = array($prefactura_id);

        $query_sql = "SELECT cf.uid, p.condiciones FROM prefacturas p join clientes_facturacion cf on p.cliente_facturacion_id = cf.cliente_facturacion_id WHERE prefactura_id = ?";
        $query = $this->db->query($query_sql, $params);
        $row = $query->row();
        $uid = $row->uid;
        $condiciones = $row->condiciones;

        // $ordenes = array();
        $verificaciones_grupos = array();
        foreach ($verificaciones_db as $key => $item) {
            $group_key = $item['orden'] . '_' . $item['subservicio'] . '_' . $item['precio'];
            $verificaciones_grupos[$group_key][$key] = $item;
            // array_push($ordenes, $item['orden']);
        }

        // $ordenes = array_unique($ordenes, SORT_REGULAR);
        // $ordenes = array_values($ordenes);
        // $stringOrdenes = implode(', ', $ordenes);

        $subtotal = 0;
        $conceptos = array();
        foreach ($verificaciones_grupos as $verificaciones_grupo) {
            $cantidad = 0;
            // $folios = "";
            $folios = array();
            $servicio = '';
            $precio_u = 0;
            $servicio_id = '';

            foreach ($verificaciones_grupo as $verificacion) {
                // $folios .= $verificacion['folio'] . ", ";
                array_push($folios, $verificacion['folio']);
                $cantidad++;
                $servicio = $verificacion['servicio'];
                $precio_u = $verificacion['precio'];
                $servicio_id = $verificacion['servicio_id'];
                $num_orden = $verificacion['orden'];
            }

            $importe = $cantidad * $precio_u;
            $subtotal += $importe;
            // $folios = rtrim($folios, ", ");


            $traslado = array(
                "Base" => number_format($importe, 2),
                "Impuesto" => "002",
                "TipoFactor" => "Tasa",
                "TasaOCuota" => "0.08",
                "Importe" => number_format($importe * 0.08, 2)
            );
            $traslados = array(
                $traslado
            );

            $impuestos = array(
                "Traslados" => $traslados
            );
            $concepto = array(
                "ClaveProdServ" => "78181505",
                "Cantidad" => $cantidad,
                "ClaveUnidad" => "E48",
                "Unidad" => "Unidad de servicio",
                "ValorUnitario" => $precio_u,
                "Descripcion" => $servicio_id . " - " . $servicio . " - " . "\n[ Orden: " . $num_orden . " ]" . "\nFolios: " .  implode(', ', $folios),
                "Impuestos" => $impuestos
            );
            array_push($conceptos, $concepto);
        }

        $receptor = array(
            "UID" => $uid
        );

        $factura = array(
            "Receptor" => $receptor,
            "TipoDocumento" => "factura",
            "Conceptos" => $conceptos,
            "UsoCFDI" => $datos['usoCFDI'],
            "Serie" => 58672,
            "FormaPago" => $datos['formaPago'],
            "MetodoPago" => $datos['metodoPago'],
            "Moneda" => 'MXN',
            "CondicionesDePago" => $condiciones,
            "EnviarCorreo" => false,
        );
        if ($datos['moneda'] == 'USD') {
            $factura["Comentarios"] ="Tipo de cambio: $" . $datos['tipoCambio'] . " MXN" . "\nImporte en dólares: $" . number_format((($subtotal / $datos['tipoCambio']) * 1.08), 2) . " USD";
        }
        // echo json_encode($factura);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => FACTURA_COM_URL . '/v4/cfdi40/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($factura),
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
        if ($response->response != 'success') {
            if (is_object($response->message)) {
                if ($response->message->message == 'CFDI40999 - Error no clasificado.') {
                    $message = $response->message->messageDetail;
                } else {
                    $message = $response->message->message;
                }
            } else {
                $message = $response->message;
            }
            $respuesta = array(
                'mensaje' => $message,
                'registrado' => false,
                'error' => false
            );
            return $respuesta;
        }

        $data_limpia = array(
            'facturada' => 1,
            'uid' => $response->uid,
            'num_factura' => $response->INV->Serie . ' ' . $response->INV->Folio
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('prefactura_id', $prefactura_id)->set($data_limpia)->update('prefacturas');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error en actualizacion',
                'error' => true,
                'registrado' => false,
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Prefactura cerrada y timbrada',
                'error' => false,
                'registrado' => true,
            );
        }
        return $respuesta;
    }

    public function razones_cancelacion($datos)
    {
        $prefactura_id = (int) $datos['prefactura_id'];
        $razones = $datos['razones'];
        $data_limpia = array(
            'razones_cancelacion' => $razones,
            'activo' => 0
        );
        $this->db->trans_begin();
        /* se actualiza la tabla */
        $this->db->where('prefactura_id', $prefactura_id)->set($data_limpia)->update('prefacturas');
        /* verificacion de la transaccion */
        if ($this->db->trans_status() === false) {
            $respuesta = array(
                'mensaje' => 'Error al cancelar',
                'error' => true,
                'registrado' => false,
            );
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $respuesta = array(
                'mensaje' => 'Prefactura cancelada',
                'error' => false,
                'registrado' => true,
            );
        }
        return $respuesta;
    }

    public function obtener_archivo($uid, $tipo)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => FACTURA_COM_URL . '/v4/cfdi40/' . $uid . '/' . $tipo,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                FACTURA_COM_F_PLUGIN,
                FACTURA_COM_F_API_KEY,
                FACTURA_COM_F_SECRET_KEY
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function pdf_factura($datos)
    {
        $uid = $datos['uid'];
        $tipo = 'pdf';
        $response = $this->obtener_archivo($uid, $tipo);
        echo $response;
    }
    public function xml_factura($datos)
    {
        $uid = $datos['uid'];
        $tipo = 'xml';
        $response = $this->obtener_archivo($uid, $tipo);
        echo $response;
    }

    public function enviar_factura($datos)
    {
        $uid = $datos['uid'];
        $cliente_facturacion_id = $datos['cliente_facturacion_id'];
        $correos = array();
        $query = $this->db->query('select * from clientes_facturacion where cliente_facturacion_id = ' . $cliente_facturacion_id);
        if ($query && $query->num_rows() <= 0) {
            $respuesta = array(
                'mensaje' => 'Error al enviar',
                'error' => true,
                'enviado' => false,
            );
            return $respuesta;
        }
        $cliente_fact = $query->row_array();
        for ($i = 1; $i <= 5; $i++) {
            $correo = $cliente_fact['correo' . $i];
            if ($correo != '') {
                array_push($correos, $correo);
            }
        }
        $pdf = $this->obtener_archivo($uid, 'pdf');
        $xml = $this->obtener_archivo($uid, 'xml');
        $rutaPDF = tempnam('C:\\ruta\\Herkace_Shared\\Web\\archivos', 'TMP_');
        $rutaXML = tempnam('C:\\ruta\\Herkace_Shared\\Web\\archivos', 'TMP_');
        file_put_contents($rutaPDF, $pdf);
        file_put_contents($rutaXML, $xml);
        $rutas = array(
            'factura.pdf' => $rutaPDF,
            'factura.xml' => $rutaXML
        );
        $asunto = 'HERKACE - ENVIO DE FACTURA';
        $mensaje = "Buen día.\r\nPor medio del presente correo, se hace llegar su factura en formato PDF Y XML.";
        $this->load->helper('envio_correo');
        $enviado = envio_correo_mensaje($correos, $asunto, $mensaje, $rutas);
        $respuesta = array(
            'error' => !$enviado
        );
        unlink($rutaPDF);
        unlink($rutaXML);
        return $respuesta;
    }
}
