<?php
class MetodosPago_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listado()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FACTURA_COM_URL . "/v3/catalogo/MetodoPago");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            FACTURA_COM_F_PLUGIN,
            FACTURA_COM_F_API_KEY,
            FACTURA_COM_F_SECRET_KEY
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        $respuesta = array(
            'registros' => $response->data,
            'error' => false,
        );

        return $respuesta;
    }
}
