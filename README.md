# Inventario Laravel - Gestión de Inventario & E-commerce

Este proyecto es una modernización de un sistema CRUD de productos, migrado de PHP nativo a **Laravel 10**, integrando un sistema de autenticación seguro, gestión de imágenes y un carrito de compras funcional.

## 🚀 Características (Sprint 1)

- **⚙️ Autenticación Personalizada**: Implementación de Laravel Breeze adaptado a un esquema de base de datos con `user_name` en lugar de `email`.
- **📦 Gestión de Productos (CRUD)**:
    - Creación, edición, visualización y eliminación de productos.
    - Soporte para **subida de imágenes** reales.
    - Interfaz moderna con **Bootstrap 5** y **Bootstrap Icons**.
- **👤 Mi Perfil**: Gestión de datos de usuario con historial de cambios.


## 🏗️ Estructura del Proyecto

```text
Inventario/
├── app/
│   ├── Http/Controllers/    # Lógica de Negocio (Auth, Product)
│   └── Models/             # Modelos Eloquent (User, Product, Person)
├── database/
│   ├── migrations/         # Esquema de base de datos (E-R)
│   └── seeders/            # Datos iniciales
├── public/
│   ├── storage/            # Enlace simbólico a imágenes
│   └── js/                 # Scripts de AJAX y UI
└── resources/
    ├── views/              # Plantillas Blade (Layouts, Auth, Products)
    └── css/                # Estilos personalizados
```

## 🔒 Lógica de Autenticación (Custom)

A diferencia de las instalaciones estándar de Breeze, este proyecto:
1.  **Elimina el requerimiento de Email**: El registro y login se realizan exclusivamente mediante `user_name`.
2.  **Estado del Usuario**: Cada usuario se crea con un `status` activo por defecto y se vincula a una `person_id` y `role_id` existentes en la arquitectura heredada.

## 🛠️ Stack Tecnológico

- **Framework**: Laravel 10 (PHP 8.1+)
- **Frontend**: Blade, Bootstrap 5, jQuery 3.6
- **Almacenamiento**: Laravel FileSystem (Disco Público)
- **Base de Datos**: MySQL 8.x con migraciones versionadas.

## 📋 Requerimientos de Instalación

1.  **Clonar y Dependencias**:
    ```bash
    git clone https://github.com/kmigi0211k/ProyectoIntegrador.git
    composer install
    npm install
    ```
2.  **Configuración**:
    - Crear un archivo `.env` basado en `.env.example`.
    - Configurar las credenciales de la DB.
3.  **Preparación**:
    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan storage:link
    ```
4.  **Ejecutar**:
    ```bash
    # En desarrollo
    npm run dev
    # En producción
    npm run build
    ```

---
*Para más detalles técnicos, consulte el archivo [arquitectura.md](arquitectura.md).*

---

## 🧪 Pruebas y Despliegue (Sprint 4)

### Ejecución de Pruebas
Para ejecutar las pruebas automatizadas (Feature y Unit tests):
```bash
php artisan test
```

### CI/CD
El proyecto cuenta con un flujo de **GitHub Actions** configurado para ejecutar las pruebas automáticamente en cada `push` a las ramas principales.

## 🔗 Enlaces del Proyecto

- **Repositorio**: [GitHub - Proyecto Integrador](https://github.com/kmigi0211k/ProyectoIntegrador)
- **Documentación**: [User Stories](user_stories.md) | [Arquitectura](arquitectura.md)
- **Producción**: [Enlace de Producción (si aplica)](https://proyectointegrador-prod.com)

---
*Desarrollado para el Proyecto Integrador - Desarrollo de Aplicaciones Web - Sprint 4.*

