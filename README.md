# SoundWave Store 🎶

Catálogo web y e-commerce de instrumentos y otros productos musicales construido con Laravel y Filament.

La plataforma cuenta con un frontend público donde los usuarios pueden visualizar los detalles de la empresa, el modelo de negocio, información de contacto, explorar productos disponibles y gestionar por completo sus perfiles (carritos de compra y edición de datos). Además, incluye un panel de administración avanzado para delegar todas las gestiones operativas del sitio.

---

## 🚀 Características Principales

* **Frontend Público Interactivo:** Navegación fluida por catálogo, carrito de compras manual y pasarela conceptual de órdenes.
* **Panel Administrativo Robusto:** Gestión interna optimizada mediante componentes reactivos para el control de inventario y usuarios.
* **Feedback Dinámico:** Experiencia de usuario enriquecida con alertas interactivas y animaciones fluidas.
* **Seguridad Avanzada:** Arquitectura protegida mediante middlewares personalizados y validaciones centralizadas.

---

## 🛠️ Tecnologías Utilizadas (Stack)

![Laravel](https://img.shields.io/badge/Laravel_13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP_8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![FilamentPHP](https://img.shields.io/badge/FilamentPHP-EBB304?style=for-the-badge&logo=laravel&logoColor=black)
![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

* **Backend:** Laravel 13 & PHP 8.4
* **Panel de Administración:** FilamentPHP
* **Base de Datos:** MariaDB
* **Frontend:** Blade nativo de Laravel
* **Librerías de UI & Efectos:** SweetAlert2 (alertas dinámicas) y Animate.css (animaciones del logo)

---

## 📂 Estructura y Arquitectura del Proyecto

El sistema se divide claramente en dos grandes módulos arquitectónicos:

### A. Panel de Administración (`/admin`)
Toda la gestión interna está delegada a **Filament**, el cual facilita el armado de formularios, tablas y vistas mediante componentes reutilizables y reactivos conectados a los modelos:

* **Marcas:** CRUD con visualización general, creación, edición, desactivación (oculta la disponibilidad de la marca al cargar productos) y eliminación restringida (solo posible si no hay productos asociados).
* **Categorías:** CRUD completo con **reasignación automática**: si una categoría se elimina, sus productos asociados pasan automáticamente a la categoría por defecto *"Otros"*.
* **Productos:** CRUD completo con soporte de **Soft Deletes**, permitiendo la restauración de productos eliminados.
* **Usuarios:** Gestión de cuentas registradas mediante un CRUD completo con Soft Deletes y reglas específicas de edición de seguridad.
* **Consultas:** Bandeja de entrada centralizada para los mensajes enviados desde el frontend. Permite visualización, cambio de estado (leído/pendiente) y eliminación.

### B. Sitio Frontend (Público)
Desarrollado con vistas **Blade** tradicionales y controladores optimizados para la experiencia del cliente:

* **Navegación y Vistas:** Controladores encargados de renderizar el inicio, el catálogo completo de productos, detalles de la empresa y la sección de contacto.
* **Autenticación:** Sistema completo de registro y logueo seguro de usuarios.
* **Perfil de Usuario:** Panel privado para el cliente con un controlador dedicado a la actualización de sus datos personales.
* **Carrito de Compras:** Lógica manual implementada para la selección, acumulación, persistencia y gestión de los instrumentos que el usuario desea adquirir.
* **Envío de Consultas:** Controlador especializado en recibir los formularios de contacto y derivarlos en tiempo real a la bandeja de Filament.

---

## 🔒 Lógica de Negocio y Seguridad

* **Middleware de Usuario:** Se implementó un middleware personalizado asociado al modelo `User` para proteger rutas específicas y gestionar de forma estricta los accesos y permisos dentro del flujo de compra y edición de perfil.
* **Form Requests Dedicados:** Las validaciones de datos están centralizadas y completamente aisladas de los controladores utilizando clases `Request` de Laravel. Esto mantiene el código limpio (*Clean Code*) y asegura la integridad en procesos críticos como:
  * Formulario de consultas de contacto.
  * Autenticación (Login y Registro).
  * Actualización de perfil de usuario.

---

## 🎨 Interfaz de Usuario (UI) y Estilos

* **SweetAlert2:** Integrado para proporcionar un feedback interactivo, elegante y amigable al usuario tras realizar acciones clave (ej. confirmación de registro de cuenta, envío exitoso de consultas o alertas del carrito).
* **Animate.css:** Utilizado de forma precisa para añadir dinamismo visual al logo principal de la plataforma, mejorando la identidad visual del sitio.

---

## 💻 Requisitos e Instalación

### Requisitos previos
* PHP >= 8.4
* Composer
* Node.js & NPM
* Servidor MariaDB

### Paso a paso para entorno local

## 🛠️ Instalación
1. Clonar el repositorio:
   ```bash
   git clone https://github.com/tuusuario/soundwave-store.git
   cd soundwave-store
   ```

2. Configurar variables de entorno en `.env` (Copias el `.env.example` y agregas tus datos).
   * ** Ajustes básicos .env **
   * DB_CONNECTION=mariadb
   * DB_HOST=127.0.0.1
   * DB_PORT=3306
   * DB_DATABASE=db_bengochea_aguilar
   * DB_USERNAME=root
   * DB_PASSWORD=
   * APP_URL=http://localhost:8000
   * APP_LOCALE=es
   * APP_FALLBACK_LOCALE=es
   * APP_FAKER_LOCALE=es_AR

3. Instalar Dependencias y generamos clave
    ```bash
    composer install
    npm install
    php artisan key:generate
    ```

4. Ejecutamos migración
```bash
    php artisan migrate:fresh --seed 
```

5. Iniciamos servidor
```bash
    php artisan serve
```
