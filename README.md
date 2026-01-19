# Herkace_Shared

Sistema de control de verificaciones.

## IMPORTANTE

Se deben realizar los siguientes cambios antes de utilizarlo:

[Web/api/app_ws/application/config/constants.php](Web/api/app_ws/application/config/constants.php)
- Línea 87: Contiene las claves del API de [factura.com](factura.com). Hay que comentar el bloque de Sandbox y descomentar el de Producción, poniendo las claves de API correctas.

[Web/api/app_ws/application/helpers/envio_correo_helper.php](Web/api/app_ws/application/helpers/envio_correo_helper.php)
- Líneas 22 a 30: Se deben configurar los parámetros de envío de correo, tales como el host, puerto, usuario y contraseña del servidor SMTP que se utilizará para el envío de correos.

[Web/api/app_ws/application/helpers/constantes_helper.php](Web/api/app_ws/application/helpers/constantes_helper.php)
- La función `rutaBase()` debe devolver la ubicación en servidor donde estará alojado el sistema, mientras que `rutaDivisor()` debe devolver el caracter divisor para lasa rutas correspondiente (`/` para Linux y `\\` para Windows).

[Web/api/app_ws/application/helpers/pdf_gah_helper.php](Web/api/app_ws/application/helpers/pdf_gah_helper.php)
- Línea 56: En el bloque `if` se debe cambiar las rutas de ambas imágenes por su ubicación en servidor.

[Web/api/app_ws/application/models/Prefacturas_model.php](Web/api/app_ws/application/models/Prefacturas_model.php)
- 394: "/ruta/de/servidor/archivos"
- 395: "/ruta/de/servidor/archivos"
- Líneas 394 y 395: Se debe cambiar las rutas de ambas imágenes por su ubicación en servidor.

Todos los archivos HTML Y JS
- Se deben cambiar todas las ocurrencias de `http://localhost/Herkace_Shared/Web` por la URL donde se alojará el sistema en producción, ya sea en localhost o en un dominio público.
