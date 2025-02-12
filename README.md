# Sistema de Monitoreo Inteligente - Aplicación Web

Aplicación web desarrollada en Laravel para consumir la API de monitoreo inteligente de postes de alumbrado público (api_smartlight). Permite visualizar y gestionar postes, sensores, alertas y usuarios de manera eficiente.

## Características Principales
- **Conexión con la API**: Consume los datos proporcionados por la API de monitoreo.
- **Interfaz Intuitiva**: Facilita la visualización y gestión de la información.
- **Gestión de Usuarios**: Permite a los administradores y técnicos acceder a las funcionalidades del sistema.

## Tecnologías Utilizadas
- **Laravel**: Framework PHP para el desarrollo web.
- **Guzzle**: Cliente HTTP para consumir la API.
- **Bootstrap**: Framework CSS para el diseño de la interfaz.

## Funcionalidades Principales
- **Listar Postes**: Muestra todos los postes registrados en el sistema.
- **Crear Sensores**: Permite agregar nuevos sensores a los postes.
- **Ver Alertas**: Visualiza las alertas generadas por fallos en las luminarias.
- **Gestionar Usuarios**: Administra los usuarios del sistema.

## Cómo Usar
1. Clona el repositorio.
2. Instala las dependencias: `composer install`.
3. Configura las variables de entorno en `.env`.
4. Ejecuta el servidor: `php artisan serve`.
