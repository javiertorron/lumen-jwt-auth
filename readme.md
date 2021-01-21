# JWT Authentication

## Iniciar el servidor de pruebas
- Copiar el '/.env.example' a '/.env'
- Configurar la conexión a la base de datos en /.env
- Ejecutar en terminal 'php artisan migrate'
- Ejecutar en terminal 'php artisan db:seed --class=UsersTableSeeder'
- Ejecutar en terminal '.\serve.bat' (para Windows) o bien './serve.sh' (para UNIX)

## TODO:
- Petición de validación de tokens
- Token refresh