# JWT Authentication
Este microservicio se encarga del sistema de autenticación de servicios mediante un token JWT. Su propósito no es otro que, dado un usuario y contraseña válidos, genera un Token JWT que contiene los datos básicos del usuario, tales como su username y su id, de forma que cualquier servicio al que se le envíe este token no necesitará cargar estos datos, ahorrando tiempos de carga en todos ellos.

El token JWT se encriptará con la clave de encriptación del sistema, que tienen almacenados todos los servicios
y que sirve para validar la autenticidad del token. En el fichero .env o en las variables de entorno del sistema ha de haber una env var `JWT_PRIVATE_KEY` que ha de ser la misma para todos los servicios, para que estos puedan verificar la validez del token

## Partes del token
userId        - Identificador único del usuario
userName      - Nombre de usuario para entrada
serialization - Objeto del perfil de usuario serializado
expiration    - Timestamp con la fecha final de expiración del token (1 semana tras su expedición o último refresco)
refresh       - Timestamp con la fecha final de refresco, a prtir de la cual el token ya no se puede utilizar por inactividad y hay que pedir otro token.

## Iniciar el servidor de pruebas
- Copiar el `/.env.example` a `/.env`
- Configurar la conexión a la base de datos en /.env
- Ejecutar en terminal `php artisan migrate`
- Ejecutar en terminal `php artisan db:seed --class=UsersTableSeeder`
- Ejecutar en terminal `.\serve.bat` (para Windows) o bien `./serve.sh` (para UNIX)

## TODO:
- Token refresh