# Sistema 

Sistema web para la gestión de órdenes de trabajo/servicio con panel de administración y generación de reportes.

## Requisitos del Sistema
- PHP 8.1+
- MySQL 5.7+
- Composer
- Node.js (npm)
- Laravel 9.x

## Tecnologías Utilizadas
- **Framework**: Laravel
- **Frontend**: AdminLTE 3 (Plantilla Bootstrap)
- **Base de Datos**: MySQL
- **Reportes**: Laravel
- **Autenticación**: Laravel Fortify

## Instalación Paso a Paso

### 1. Clonar Repositorio
```bash
git clone https://github.com/MiltonDanielhch/cafe.git
cd cafe

2. Configuración Inicial
# Instalar dependencias PHP
composer install

# Instalar dependencias Node.js
npm install

# Crear archivo .env
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

3. Configuración de Base de Datos
Modificar en .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base
DB_USERNAME=usuario
DB_PASSWORD=contraseña

# Crear estructura de base de datos
php artisan migrate

4. Migraciones y Seeders
# (Opcional) Cargar datos de prueba
php artisan db:seed

# Crear enlace simbólico para almacenamiento
php artisan storage:link

Ejecución del Proyecto
# Iniciar servidor de desarrollo
php artisan serve

Acceso al Sistema
URL : http://localhost:8000