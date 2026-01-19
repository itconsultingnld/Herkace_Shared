<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = array(

     /* Admin */

    'InsertarAdministrador_post' => array(
        array('field' => 'nombre', 'label' => 'nombre del coordinador', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'ape_pat', 'label' => 'apellido paterno del coordinador', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'ape_mat', 'label' => 'apellido materno del coordinador', 'rules' => 'trim|min_length[2]'),
        array('field' => 'correo', 'label' => 'correo del coordinador', 'rules' => 'trim|required|valid_email|min_length[6]'),
        array('field' => 'username', 'label' => 'nombre de usuario del coordinador', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'password', 'label' => 'password del coordinador', 'rules' => 'trim|required|min_length[6]'),
    ),
    
    'actualizar_administrador_put' => array(
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'ape_pat', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'ape_mat', 'label' => 'apellido materno ', 'rules' => 'trim|min_length[2]'),
        array('field' => 'correo', 'label' => 'correo', 'rules' => 'trim|required|valid_email|min_length[6]'),
        array('field' => 'username', 'label' => 'nombre de usuario', 'rules' => 'trim|required|min_length[4]'),
    ),

    /* Coordinadores */

    'InsertarCoordinador_post' => array(
        array('field' => 'nombre', 'label' => 'nombre del coordinador', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'ape_pat', 'label' => 'apellido paterno del coordinador', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'ape_mat', 'label' => 'apellido materno del coordinador', 'rules' => 'trim|min_length[2]'),
        array('field' => 'correo', 'label' => 'correo del coordinador', 'rules' => 'trim|required|valid_email|min_length[6]'),
        array('field' => 'username', 'label' => 'nombre de usuario del coordinador', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'password', 'label' => 'password del coordinador', 'rules' => 'trim|required|min_length[6]'),
    ),

    'actualizar_coordinador_put' => array(
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'ape_pat', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'ape_mat', 'label' => 'apellido materno ', 'rules' => 'trim|min_length[2]'),
        array('field' => 'correo', 'label' => 'correo', 'rules' => 'trim|required|valid_email|min_length[6]'),
        array('field' => 'username', 'label' => 'nombre de usuario', 'rules' => 'trim|required|min_length[4]'),
    ),

    /* Clientes */

    'InsertarClientes_post' => array(
        array('field' => 'numero_cliente', 'label' => 'número de cliente', 'rules' => 'trim|required|integer'),
        array('field' => 'nombre', 'label' => 'nombre del cliente', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'tipo_cliente', 'label' => 'tipo de cliente', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'rfc', 'label' => 'RFC', 'rules' => 'trim|required|min_length[12]'),
        array('field' => 'calle', 'label' => 'nombre de la calle', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'colonia', 'label' => 'nombre de la colonia', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'numero', 'label' => 'numero del lugar', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'municipio', 'label' => 'municipio', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'estado', 'label' => 'estado o entidad federativa', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'codigo_postal', 'label' => 'codigo postal', 'rules' => 'trim|required|min_length[1]')
    ),

    'actualizarClientes_put' => array(
        array('field' => 'numero_cliente', 'label' => 'número de cliente', 'rules' => 'trim|required|integer'),
        array('field' => 'nombre', 'label' => 'nombre del cliente', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'tipo_cliente', 'label' => 'tipo de cliente', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'rfc', 'label' => 'RFC', 'rules' => 'trim|required|min_length[12]'),
        array('field' => 'calle', 'label' => 'nombre de la calle', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'colonia', 'label' => 'nombre de la colonia', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'numero', 'label' => 'numero del lugar', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'municipio', 'label' => 'municipio', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'estado', 'label' => 'estado o entidad federativa', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'codigo_postal', 'label' => 'codigo postal', 'rules' => 'trim|required|min_length[1]')
    ),

    /* Técnicos */
    'insertar_tecnico_post' => array(
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'ape_pat', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'ape_mat', 'label' => 'apellido materno', 'rules' => 'trim|min_length[1]'),
        array('field' => 'num_control', 'label' => 'numero de control', 'rules' => 'trim|min_length[2]'),
        array('field' => 'telefono', 'label' => 'telefono', 'rules' => 'trim|required|min_length[12]'),
    ),

    'actualizar_tecnico_put' => array(
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'ape_pat', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'ape_mat', 'label' => 'apellido materno', 'rules' => 'trim|min_length[1]'),
        array('field' => 'num_control', 'label' => 'numero de control', 'rules' => 'trim|min_length[2]'),
        array('field' => 'telefono', 'label' => 'telefono', 'rules' => 'trim|required|min_length[12]'),
    ),
    /* Usuarios Insp */

    'InsertarUsuarioInsp_post' => array(
        array('field' => 'nombreUsuarioInsp', 'label' => 'nombre del usuario inspeccion', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'apePatUsInsp', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'apeMatUsInsp', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'empresaUsuarioInsp', 'label' => 'nombre de la empresa', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'usuario', 'label' => 'nombre de usuario', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'claveAccesoUsInsp', 'label' => 'clave de acceso', 'rules' => 'trim|required|min_length[6]'),
        array('field' => 'empresa_id', 'label' => 'empresa_id', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo', 'label' => 'tipo de usuario inspeccion', 'rules' => 'trim|required'),
    ),

    'actualizarUsuarioInsp_put' => array(
        array('field' => 'nombreUsuarioInsp', 'label' => 'nombre del usuario inspeccion', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'apePatUsInsp', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'apeMatUsInsp', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'empresaUsuarioInsp', 'label' => 'nombre de la empresa', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'usuario', 'label' => 'nombre de usuario', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'tipo', 'label' => 'tipo de usuario inspeccion', 'rules' => 'trim|required')
    ),

    /* Usuarios Notif */

    'InsertarUsuarioNotif_post' => array(
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'apePat', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'apeMat', 'label' => 'apellido materno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'empresa', 'label' => 'nombre de la empresa', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'correo', 'label' => 'correo', 'rules' => 'trim|required|valid_email|min_length[6]'),
        array('field' => 'usuario', 'label' => 'nombre del usuario notificacion', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'claveAcceso', 'label' => 'clave de acceso', 'rules' => 'trim|required|min_length[6]'),
        array('field' => 'empresa_id', 'label' => 'empresa_id', 'rules' => 'trim|required|integer'),
    ),

    'actualizarUsuarioNotif_put' => array(
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'apePat', 'label' => 'apellido paterno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'apeMat', 'label' => 'apellido materno', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'empresa', 'label' => 'nombre de la empresa', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'correo', 'label' => 'correo', 'rules' => 'trim|required|valid_email|min_length[6]'),
        array('field' => 'usuario', 'label' => 'nombre del usuario notificacion', 'rules' => 'trim|required|min_length[4]'),
    ),

    /* MarcasVehiculos */

    'marcas_vehiculos_agregar_post' => array(
        array('field' => 'nombre', 'label' => 'nombre de la marca de vehículo', 'rules' => 'trim|required|min_length[2]'),
    ),
    
    'marcas_vehiculos_modificar_put' => array(
        array('field' => 'marca_vehiculo_id', 'label' => 'marca_vehiculo_id', 'rules' => 'trim|required|integer'),
        array('field' => 'nombre', 'label' => 'nombre de la marca de vehículo', 'rules' => 'trim|required|min_length[2]'),
    ),

    /* TiposUnidades */
    'tipos_unidades_agregar_post' => array(
        array('field' => 'nombre', 'label' => 'nombre del tipo de unidad', 'rules' => 'trim|required|min_length[3]'),
    ),

    'tipos_unidades_modificar_put' => array(
        array('field' => 'tipo_unidad_id', 'label' => 'tipo_unidad_id', 'rules' => 'trim|required|integer'),
        array('field' => 'nombre', 'label' => 'nombre del tipo de unidad', 'rules' => 'trim|required|min_length[3]'),
    ),

     /* TiposServicios */
     'tipos_servicios_agregar_post' => array(
        array('field' => 'nomenclatura', 'label' => 'nomenclatura', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'nombre', 'label' => 'nombre del tipo de unidad', 'rules' => 'trim|required|min_length[3]'),
    ),

    'tipos_servicios_modificar_put' => array(
        array('field' => 'tipo_servicio_id', 'label' => 'tipo_servicio_id', 'rules' => 'trim|required|integer'),
        array('field' => 'nomenclatura', 'label' => 'nomenclatura', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'nombre', 'label' => 'nombre del tipo de servicio', 'rules' => 'trim|required|min_length[3]'),
    ),

    /* TiposVehiculos */
    'tipos_vehiculos_agregar_post' => array(
        array('field' => 'nomenclatura', 'label' => 'nomenclatura', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'nombre', 'label' => 'nombre del tipo de vehículo', 'rules' => 'trim|required|min_length[3]'),
    ),

    'tipos_vehiculos_modificar_put' => array(
        array('field' => 'tipo_vehiculo_id', 'label' => 'tipo_vehiculo_id', 'rules' => 'trim|required|integer'),
        array('field' => 'nomenclatura', 'label' => 'nomenclatura', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'nombre', 'label' => 'nombre del tipo de vehículo', 'rules' => 'trim|required|min_length[3]'),
    ),

    /* Folios */

    'folios_agregar_post' => array(
        array('field' => 'tipo_verificacion_id', 'label' => 'tipo de verificación', 'rules' => 'trim|required|integer'),
        array('field' => 'desde', 'label' => 'folio inicial', 'rules' => 'trim|required|integer'),
        array('field' => 'hasta', 'label' => 'folio final', 'rules' => 'trim|required|integer'),
        array('field' => 'usuario_id', 'label' => 'usuario', 'rules' => 'trim|required|integer'),
    ),

    /* Vehiculos */

    'vehiculos_agregar_post' => array(
        array('field' => 'cliente_id', 'label' => 'cliente', 'rules' => 'trim|required|integer'),
        array('field' => 'num_serie', 'label' => 'número de serie', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'num_placas', 'label' => 'número de placas', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'marca_vehiculo_id', 'label' => 'marca de vehículo', 'rules' => 'trim|required|integer'),
        array('field' => 'modelo', 'label' => 'modelo', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'tarjeta_circ', 'label' => 'tarjeta de circulación', 'rules' => 'trim|required|min_length[7]'),
        array('field' => 'tipo_vehiculo_id', 'label' => 'tipo de vehículo', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo_unidad_id', 'label' => 'tipo de unidad', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo_servicio_id', 'label' => 'tipo de servicio', 'rules' => 'trim|required|integer'),
        array('field' => 'capacidad', 'label' => 'capacidad', 'rules' => 'trim|required|integer'),
        array('field' => 'capacidad_unidad', 'label' => 'unidad de capacidad', 'rules' => 'trim|required'),
    ),
    
    'vehiculos_modificar_put' => array(
        array('field' => 'vehiculo_id', 'label' => 'vehiculo_id', 'rules' => 'trim|required|integer'),
        array('field' => 'cliente_id', 'label' => 'cliente', 'rules' => 'trim|required|integer'),
        array('field' => 'num_serie', 'label' => 'número de serie', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'num_placas', 'label' => 'número de placas', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'marca_vehiculo_id', 'label' => 'marca de vehículo', 'rules' => 'trim|required|integer'),
        array('field' => 'modelo', 'label' => 'modelo', 'rules' => 'trim|required|min_length[2]'),
        array('field' => 'tarjeta_circ', 'label' => 'tarjeta de circulación', 'rules' => 'trim|required|min_length[7]'),
        array('field' => 'tipo_vehiculo_id', 'label' => 'tipo de vehículo', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo_unidad_id', 'label' => 'tipo de unidad', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo_servicio_id', 'label' => 'tipo de servicio', 'rules' => 'trim|required|integer'),
        array('field' => 'capacidad', 'label' => 'capacidad', 'rules' => 'trim|required|integer'),
        array('field' => 'capacidad_unidad', 'label' => 'unidad de capacidad', 'rules' => 'trim|required'),
    ),

    'verificaciones_agregar_post' => array(
        array('field' => 'cliente_id', 'label' => 'cliente', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo_verificacion_id', 'label' => 'ti de verificacion', 'rules' => 'trim|required|integer'),
        array('field' => 'vehiculo_id', 'label' => 'vehiculo', 'rules' => 'trim|required|integer'),
        array('field' => 'folio_id', 'label' => 'certificado', 'rules' => 'trim|required|integer'),
        array('field' => 'fecha', 'label' => 'fecha', 'rules' => 'trim|required'),
        array('field' => 'folio_ant', 'label' => 'folio anterior', 'rules' => 'trim|required'),
        array('field' => 'fecha_ant', 'label' => 'fecha anterior', 'rules' => 'trim|required'),
        array('field' => 'estatus_id', 'label' => 'estatus', 'rules' => 'trim|required|integer'),
        array('field' => 'estatus_unidad', 'label' => 'estatus de la unidad', 'rules' => 'trim|required|integer'),
        array('field' => 'tecnico_id', 'label' => 'tecnico', 'rules' => 'trim|required|integer'),
        array('field' => 'kilometraje', 'label' => 'kilometraje', 'rules' => 'trim|required|integer'),
        array('field' => 'periodo', 'label' => 'periodo', 'rules' => 'trim|required|integer'),
        array('field' => 'hora_inicio', 'label' => 'unidad de capacidad', 'rules' => 'trim|required'),
        array('field' => 'hora_final', 'label' => 'unidad de capacidad', 'rules' => 'trim|required'),
        array('field' => 'imprime_nom', 'label' => 'imprime Nom-EM-167', 'rules' => 'trim|required|integer'),
    ),

    'verificaciones_modificar_put' => array(
        array('field' => 'verificacion_id', 'label' => 'verificacion_id', 'rules' => 'trim|required|integer'),
        array('field' => 'cliente_id', 'label' => 'cliente', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo_verificacion_id', 'label' => 'tipo de verificación', 'rules' => 'trim|required|integer'),
        array('field' => 'tipo_unidad_verificacion_id', 'label' => 'tipo de unidad de verificación', 'rules' => 'trim|required|integer'),
        array('field' => 'vehiculo_id', 'label' => 'vehículo', 'rules' => 'trim|required|integer'),
        array('field' => 'cambio_folio', 'label' => 'cambio de folio', 'rules' => 'trim|required'),
        array('field' => 'fecha', 'label' => 'fecha', 'rules' => 'trim|required'),
        array('field' => 'folio_ant', 'label' => 'folio anterior', 'rules' => 'trim|required'),
        array('field' => 'fecha_ant', 'label' => 'fecha anterior', 'rules' => 'trim|required'),
        array('field' => 'estatus_id', 'label' => 'estatus', 'rules' => 'trim|required|integer'),
        array('field' => 'estatus_unidad', 'label' => 'estatus de la unidad', 'rules' => 'trim|required|integer'),
        array('field' => 'tecnico_id', 'label' => 'técnico', 'rules' => 'trim|required|integer'),
        array('field' => 'kilometraje', 'label' => 'kilometraje', 'rules' => 'trim|required|integer'),
        array('field' => 'periodo', 'label' => 'periodo', 'rules' => 'trim|required|integer'),
        array('field' => 'hora_inicio', 'label' => 'hora inicio', 'rules' => 'trim|required'),
        array('field' => 'hora_final', 'label' => 'hora fin', 'rules' => 'trim|required'),
        array('field' => 'imprime_nom', 'label' => 'imprime Nom-EM-167', 'rules' => 'trim|required|integer'),
    ),

    /* Precios */

    'precios_agregar_post' => array(
        array('field' => 'servicio_id', 'label' => 'servicio', 'rules' => 'trim|required|integer'),
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required'),
        array('field' => 'precio', 'label' => 'precio', 'rules' => 'trim|required'),
    ),

    'precios_modificar_put' => array(
        array('field' => 'precio_id', 'label' => 'precio_id', 'rules' => 'trim|required|integer'),
        array('field' => 'nombre', 'label' => 'nombre', 'rules' => 'trim|required'),
        array('field' => 'precio', 'label' => 'precio', 'rules' => 'trim|required'),
    ),

    /* Órdenes */

    'orden_modificar_put' => array(
        array('field' => 'cliente_id', 'label' => 'cliente_id', 'rules' => 'trim|required|integer'),
        array('field' => 'condiciones', 'label' => 'condiciones', 'rules' => 'trim|required'),
        array('field' => 'usuario_id_vendedor', 'label' => 'usuario_id_vendedor', 'rules' => 'trim|required|integer'),
    ),

    /* Prefacturas */

    'prefacturas_modificar_put' => array(
        array('field' => 'cliente_facturacion_id', 'label' => 'cliente_id', 'rules' => 'trim|required|integer'),
        array('field' => 'condiciones', 'label' => 'condiciones', 'rules' => 'trim|required'),
        array('field' => 'usuario_id_vendedor', 'label' => 'usuario_id_vendedor', 'rules' => 'trim|required|integer'),
    ),

    /* Configuracion */

    'configuracion_modificar_put' => array(
        array('field' => 'configuracion_id', 'label' => 'configuracion_id', 'rules' => 'trim|required|integer'),
        array('field' => 'valor', 'label' => 'valor', 'rules' => 'trim|required'),
    ),

    /* ClientesFacturacion */

    'clientes_facturacion_modificar_put' => array(
        array('field' => 'cliente_facturacion_id', 'label' => 'cliente_facturacion_id', 'rules' => 'trim|required|integer'),
        array('field' => 'numero_cliente', 'label' => 'número de cliente', 'rules' => 'trim|required|integer'),
        array('field' => 'razon_social', 'label' => 'razón social', 'rules' => 'trim|required|min_length[3]'),
        array('field' => 'rfc', 'label' => 'RFC', 'rules' => 'trim|required|min_length[12]'),
        array('field' => 'calle', 'label' => 'nombre de la calle', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'numero_ext', 'label' => 'número exterior', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'colonia', 'label' => 'nombre de la colonia', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'localidad', 'label' => 'localidad', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'municipio', 'label' => 'municipio', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'estado', 'label' => 'estado o entidad federativa', 'rules' => 'trim|required|min_length[4]'),
        array('field' => 'codigo_postal', 'label' => 'codigo postal', 'rules' => 'trim|required|min_length[1]'),
        array('field' => 'correo1', 'label' => 'correo 1', 'rules' => 'trim|required|valid_email|min_length[6]'),
        array('field' => 'regimen', 'label' => 'régimen', 'rules' => 'trim|required|integer'),
        array('field' => 'uso_cfdi', 'label' => 'uso de CFDI', 'rules' => 'trim|required'),
    ),

);

