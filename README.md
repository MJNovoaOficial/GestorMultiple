# Gestor Multiple

Sistema web de gestión integral desarrollado para centralizar y administrar distintos recursos tecnológicos y operativos de una organización.

Gestor Multiple permite administrar direcciones IP, credenciales, suministros, dispositivos tecnológicos y registros de auditoría desde una única plataforma, incorporando control de acceso, trazabilidad y herramientas de importación y exportación de información.

---

## 📋 Descripción

**Gestor Multiple** nace como una solución para centralizar información que anteriormente podía encontrarse distribuida en diferentes archivos, planillas o sistemas.

El sistema permite gestionar de manera centralizada:

* Direcciones IP y rangos de red.
* Credenciales y contraseñas.
* Suministros e inventario.
* Teléfonos corporativos.
* Notebooks.
* Equipos de radiofrecuencia.
* DVRs.
* Usuarios y permisos.
* Registros de auditoría.
* Alertas de stock.
* Exportación de información a Excel y PDF.

La aplicación cuenta con una interfaz web responsive y está orientada principalmente a la administración y soporte de infraestructura tecnológica.

---

# 🚀 Características principales

## 👥 Gestión de Usuarios

El sistema incorpora administración de usuarios con control de acceso basado en roles y módulos autorizados.

Permite:

* Crear usuarios.
* Editar usuarios.
* Activar y desactivar usuarios.
* Administrar permisos.
* Controlar los módulos disponibles para cada usuario.
* Gestionar contraseñas.
* Recuperar acceso mediante el sistema de recuperación de contraseña.
* Registrar determinadas acciones para efectos de auditoría.

Los permisos permiten controlar qué funcionalidades puede visualizar y utilizar cada usuario dentro de la plataforma.

---

# 🌐 Módulo Gestor IP

El módulo Gestor IP permite administrar las direcciones IP utilizadas por la organización.

## Listado de IPs

Permite visualizar y administrar las direcciones IP registradas en el sistema.

Entre sus funcionalidades se encuentran:

* Visualización de direcciones IP.
* Estado de utilización de cada dirección.
* Asociación de IP con información adicional.
* Búsqueda y filtrado.
* Administración de rangos y subredes.
* Identificación de direcciones disponibles y utilizadas.
* Gestión de información asociada a las direcciones.

## Importar rango IP

Permite generar o incorporar rangos de direcciones IP de manera masiva.

Esta funcionalidad facilita la incorporación de grandes cantidades de direcciones sin necesidad de registrarlas manualmente una por una.

## Exportación

El módulo permite exportar información seleccionada de las direcciones IP.

Las exportaciones permiten seleccionar las columnas que se desean incluir y generar archivos para su posterior utilización o respaldo.

Se contemplan exportaciones en:

* Excel.
* PDF.

---

# 🔐 Módulo Gestor Contraseñas

El Gestor Multiple incorpora un módulo dedicado a la administración segura de credenciales.

## Listado de Contraseñas

Permite visualizar las credenciales almacenadas en el sistema.

Las contraseñas se almacenan utilizando mecanismos de cifrado para evitar que sean guardadas directamente como texto plano en la base de datos.

Entre sus funcionalidades:

* Registro de credenciales.
* Visualización controlada de contraseñas.
* Ocultar y revelar contraseñas.
* Asociación de credenciales a información determinada.
* Control de acceso según permisos del usuario.

## Asignar Contraseña

Permite asociar o asignar credenciales a los elementos correspondientes dentro del sistema.

Esta funcionalidad facilita la administración centralizada de accesos utilizados por el área de soporte y TI.

---

# 📦 Gestión de Suministros

El módulo de suministros permite administrar los insumos utilizados por la organización y controlar sus niveles de inventario.

## Listado de Suministros

Permite visualizar los suministros registrados y consultar información como:

* Marca.
* Modelo de impresora.
* Tipo de suministro.
* Cantidad disponible.
* Stock mínimo.
* Código de barras.

El sistema identifica automáticamente los productos que se encuentran:

* En stock normal.
* Bajo el stock mínimo.
* Sin stock.

## Movimiento por Escáner

Permite registrar movimientos de inventario mediante código de barras.

El usuario puede seleccionar el tipo de movimiento:

* Entrada.
* Salida.

El sistema permite escanear productos y registrar los movimientos correspondientes, facilitando el control de inventario y reduciendo el ingreso manual de información.

## Registrar Suministro

Permite incorporar nuevos suministros al sistema.

Se pueden registrar los datos necesarios para mantener actualizado el inventario.

---

# 💻 Gestión de Dispositivos

El módulo de Gestión de Dispositivos centraliza la información de diferentes tipos de equipamiento tecnológico.

Actualmente contempla:

* Celulares.
* Notebooks.
* Radiofrecuencias.
* DVRs.

---

## 📱 Celulares

Permite administrar teléfonos corporativos entregados o disponibles dentro de la organización.

La información puede incluir:

* Usuario.
* Número telefónico.
* IMEI.
* Marca.
* Modelo.
* Estado.
* Información asociada al equipo.

El módulo incorpora validaciones específicas para números telefónicos y permite importar información mediante Excel.

También se consideran mecanismos para normalizar números telefónicos de Chile.

---

## 💻 Notebooks

Permite administrar el inventario de computadores portátiles.

La información gestionada contempla, entre otros:

* Usuario.
* RUT del usuario.
* Número de serie.
* Marca.
* Modelo.
* Fecha de entrega.
* Valor de compra.
* Condición del equipo.
* Estado.
* Cargo o posición.
* Empresa.

### Estados

Los equipos pueden encontrarse, entre otros, en estados como:

* Disponible.
* Asignado.
* Dado de baja.

Cuando un notebook se encuentra asignado, el sistema valida que la información correspondiente al usuario y la entrega se encuentre registrada.

El módulo también permite exportar información a Excel.

---

## 📡 Radiofrecuencias

Permite administrar equipos de radiofrecuencia utilizados por la organización.

La información gestionada contempla:

* Número.
* Número de serie.
* Dirección MAC.
* Dirección IP.
* Área.
* Sucursal.
* Tipo de dispositivo.
* Estado.
* Observaciones.
* Bloqueo.
* Información de garantía.

### Tipos de dispositivo

El sistema contempla diferentes tipos de equipos, incluyendo:

* Windows.
* Android.
* Celular.

### Estados

Los equipos pueden encontrarse en estados como:

* Operativo.
* En reparación.
* Dado de baja.

El módulo permite realizar búsquedas y filtros, incluyendo la posibilidad de filtrar información por sucursal.

También permite exportar información a Excel.

---

## 📹 DVRs

Permite administrar los DVR utilizados dentro de la infraestructura tecnológica.

La información gestionada contempla:

* Nombre.
* Sucursal.
* Tipo.
* Modelo.
* Megapíxeles.
* Capacidad de almacenamiento.
* Número de serie.
* Dirección IP.
* Contraseña.

Las credenciales asociadas a los DVR se almacenan utilizando cifrado.

El módulo contempla operaciones de:

* Registro.
* Edición.
* Consulta.
* Retiro de equipos.
* Gestión de credenciales.

---

# 📊 Dashboard

El sistema cuenta con un dashboard centralizado que permite visualizar rápidamente información relevante de la plataforma.

Entre los indicadores disponibles se encuentran:

* Cantidad de sucursales.
* Cantidad total de direcciones IP.
* Direcciones IP asignadas.
* Direcciones IP disponibles.
* Usuarios activos.
* Usuarios con credenciales registradas.
* Teléfonos corporativos.
* Notebooks.
* Equipos de radiofrecuencia.
* DVRs.
* Suministros con stock crítico.

El dashboard permite obtener una visión general del estado de los recursos administrados por el sistema.

---

# 📑 Importación y Exportación

Gestor Multiple incorpora herramientas para trabajar con grandes cantidades de información.

## Importación

Algunos módulos permiten importar información mediante archivos Excel.

Las importaciones incorporan validaciones para:

* Datos obligatorios.
* Formatos.
* Registros duplicados.
* Información inválida.
* Normalización de determinados campos.

El sistema informa la cantidad de registros:

* Importados correctamente.
* Omitidos.
* Duplicados.

## Exportación

Los módulos que cuentan con exportación permiten generar información para respaldo, análisis o distribución.

Actualmente se contempla exportación a:

* Excel.
* PDF.

Las exportaciones pueden utilizar configuraciones de columnas seleccionadas por el usuario.

---

# 🔔 Alertas de Inventario

El sistema incorpora un mecanismo de alertas para suministros.

Las alertas permiten informar cuando determinados productos alcanzan niveles críticos de inventario o se encuentran sin stock.

El sistema contempla:

* Alertas de stock crítico.
* Alertas de productos sin stock.
* Envío de notificaciones mediante correo electrónico.
* Control de frecuencia de las alertas para evitar envíos repetitivos innecesarios.

Estas alertas pueden ejecutarse mediante comandos programados de Laravel.

---

# 📝 Auditoría

El módulo de Auditoría permite mantener trazabilidad sobre determinadas operaciones realizadas dentro de la aplicación.

La auditoría permite registrar información relacionada con acciones efectuadas por los usuarios, especialmente aquellas relacionadas con información sensible o credenciales.

Esto permite:

* Identificar quién realizó una acción.
* Mantener trazabilidad.
* Facilitar revisiones administrativas.
* Mejorar el control sobre información sensible.

---

# 🔒 Seguridad

La seguridad es uno de los componentes fundamentales del sistema.

Entre las medidas implementadas se encuentran:

* Autenticación de usuarios.
* Control de acceso mediante roles.
* Autorización por módulos.
* Cifrado de credenciales sensibles.
* Protección de contraseñas.
* Validación de datos de entrada.
* Protección mediante las herramientas de seguridad proporcionadas por Laravel.
* Registro de determinadas acciones mediante auditoría.

Las credenciales sensibles no deben almacenarse como texto plano.

---

# 🏗️ Tecnologías utilizadas

El proyecto está desarrollado utilizando principalmente:

* **Laravel 12**
* **PHP 8.2**
* **Blade**
* **Tailwind CSS**
* **JavaScript**
* **SQL Server**
* **Composer**
* **Node.js / NPM**
* **Laravel Excel / Maatwebsite Excel**

---

# 🗄️ Base de Datos

El sistema utiliza una base de datos relacional para almacenar la información de los diferentes módulos.

La aplicación está preparada para trabajar con **Microsoft SQL Server** en el entorno productivo.

Entre las entidades principales se encuentran aquellas relacionadas con:

* Usuarios.
* Sucursales.
* Direcciones IP.
* Redes.
* Credenciales.
* Suministros.
* Celulares.
* Notebooks.
* Radiofrecuencias.
* DVRs.
* Auditoría.

Las relaciones entre entidades permiten mantener la integridad de la información y evitar duplicación innecesaria de datos.

---

# ⚙️ Instalación

## Requisitos

Antes de instalar el proyecto se requiere disponer de:

* PHP 8.2 o superior.
* Composer.
* Node.js y NPM.
* SQL Server.
* Extensiones PHP necesarias para Laravel y SQL Server.
* Servidor web compatible con PHP.

## Clonar el proyecto

```bash
git clone <URL_DEL_REPOSITORIO>
cd GestorMultiple
```

## Instalar dependencias PHP

```bash
composer install
```

## Instalar dependencias JavaScript

```bash
npm install
```

## Configurar variables de entorno

Copiar el archivo de ejemplo:

```bash
cp .env.example .env
```

Configurar las variables correspondientes a:

* Base de datos.
* Aplicación.
* Correo electrónico.
* Sesiones.
* Otros servicios utilizados por el sistema.

## Generar clave de aplicación

```bash
php artisan key:generate
```

## Ejecutar migraciones

```bash
php artisan migrate
```

## Compilar recursos

```bash
npm run build
```

---

# 🚀 Despliegue en producción

Para actualizar una instalación existente desde el repositorio Git se utiliza el flujo correspondiente al entorno productivo.

Ejemplo:

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm run build
php artisan optimize
```

Después de realizar una actualización se recomienda verificar:

* Estado de la aplicación.
* Conexión con la base de datos.
* Funcionamiento de los módulos.
* Permisos.
* Tareas programadas.
* Envío de correos.
* Logs de Laravel.

---

# 🛠️ Comandos útiles

Limpiar cachés:

```bash
php artisan optimize:clear
```

Optimizar la aplicación:

```bash
php artisan optimize
```

Ejecutar migraciones:

```bash
php artisan migrate
```

Ejecutar migraciones en producción:

```bash
php artisan migrate --force
```

Ejecutar manualmente las alertas de suministros:

```bash
php artisan supplies:alerts
```

---

# 📁 Estructura general

La aplicación sigue la estructura estándar de Laravel.

Las principales áreas del proyecto incluyen:

```text
app/
├── Console/
├── Exports/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Mail/
├── Models/
└── ...

database/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/

routes/
├── web.php
└── ...

public/
storage/
```

---

# 👤 Roles y permisos

El sistema utiliza control de acceso para limitar las funcionalidades disponibles para cada usuario.

Los permisos permiten determinar qué módulos puede utilizar cada usuario, evitando que usuarios sin autorización puedan acceder a información o funciones administrativas.

Esto permite adaptar la plataforma a diferentes perfiles dentro de la organización.

---

# 📌 Estado del proyecto

Gestor Multiple se encuentra en desarrollo activo, incorporando progresivamente nuevos módulos y funcionalidades orientadas a la administración de recursos tecnológicos.

Los módulos actualmente implementados incluyen:

* ✅ Usuarios
* ✅ Gestor IP
* ✅ Gestor de Contraseñas
* ✅ Gestión de Suministros
* ✅ Celulares
* ✅ Notebooks
* ✅ Radiofrecuencias
* ✅ DVRs
* ✅ Auditoría
* ✅ Dashboard
* ✅ Importación Excel
* ✅ Exportación Excel
* ✅ Exportación PDF
* ✅ Alertas de inventario
* ✅ Control de permisos
* ✅ Gestión de credenciales

---

# 📄 Licencia

Este proyecto es de uso interno y se encuentra destinado a la gestión de recursos tecnológicos de la organización.

La distribución, modificación o utilización del código deberá realizarse de acuerdo con las políticas internas correspondientes.

---

# 👨‍💻 Desarrollo

**Gestor Multiple**

Sistema de gestión y administración de recursos tecnológicos.

Desarrollado utilizando tecnologías modernas de desarrollo web y orientado a centralizar las operaciones de administración y soporte TI.
