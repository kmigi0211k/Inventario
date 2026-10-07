# 📋 Backlog del Producto — Inventario Laravel

> Estructura: **Épica → Feature → Historia de Usuario (HU)**
> Este documento está diseñado para ser subido al repositorio (`docs/BACKLOG.md`) y usado como
> fuente para crear **Issues** y un **Project (Kanban)** en GitHub. Cada HU incluye una etiqueta
> sugerida (`labels`) y su estimación en puntos de historia (SP) para facilitar la creación de Issues.

## Índice de Épicas

| # | Épica | Features | HUs |
|---|-------|----------|-----|
| E1 | [Autenticación y Seguridad](#e1-autenticación-y-seguridad-de-usuarios) | 3 | 6 |
| E2 | [Gestión de Productos e Inventario](#e2-gestión-de-productos-e-inventario) | 3 | 6 |
| E3 | [Carrito y Proceso de Compra](#e3-carrito-y-proceso-de-compra-e-commerce) | 3 | 6 |
| E4 | [Mercado Solidario (Voluntariado)](#e4-mercado-solidario-voluntariado) | 3 | 6 |
| E5 | [Administración y Panel de Control](#e5-administración-y-panel-de-control) | 2 | 4 |
| E6 | [Calidad, CI/CD y Despliegue](#e6-calidad-cicd-y-despliegue) | 2 | 4 |

**Convención de etiquetas (labels) sugeridas en GitHub:**
`epic`, `feature`, `user-story`, `auth`, `products`, `cart`, `orders`, `volunteering`, `admin`, `qa`, `devops`, `sprint-1`, `sprint-2`, `sprint-3`, `sprint-4`

---

## E1: Autenticación y Seguridad de Usuarios
**Objetivo de la épica:** Permitir que los usuarios se registren, inicien sesión y mantengan sus cuentas seguras mediante un esquema de autenticación personalizado basado en `user_name` en lugar de correo electrónico.
`labels: epic, auth`

### F1.1 — Registro e Inicio de Sesión personalizados

#### HU01 — Registro de usuario con nombre de usuario único
**Como** nuevo usuario del sistema
**Quiero** registrarme usando un `user_name` único (máx. 15 caracteres) y una contraseña
**Para** poder acceder a la gestión de productos de forma segura, sin necesidad de un correo electrónico
- **Criterios de aceptación**
  - El sistema valida que `user_name` sea único y obligatorio.
  - No se solicita correo electrónico para el registro.
  - La contraseña debe confirmarse (campo `password_confirmation`).
  - Al registrarse, el usuario queda vinculado a un `person_id` y `role_id` por defecto.
- `labels: user-story, auth, sprint-1` · **SP:** 3

#### HU02 — Inicio de sesión con user_name
**Como** usuario registrado
**Quiero** iniciar sesión con mi `user_name` y contraseña
**Para** acceder a mis herramientas de gestión de productos y compras
- **Criterios de aceptación**
  - Credenciales inválidas muestran un mensaje de error claro.
  - Login exitoso redirige al catálogo/dashboard según el rol.
  - Se actualiza el campo `last_login_at` del usuario al iniciar sesión.
- `labels: user-story, auth, sprint-1` · **SP:** 2

### F1.2 — Seguridad de la cuenta

#### HU03 — Restablecimiento forzado de contraseña
**Como** administrador del sistema
**Quiero** poder marcar la cuenta de un usuario para que deba cambiar su contraseña en el próximo inicio de sesión (`password_needs_reset`)
**Para** reforzar la seguridad ante contraseñas comprometidas o cuentas reactivadas
- **Criterios de aceptación**
  - El administrador puede resetear la contraseña de un usuario desde el panel de administración.
  - Al marcar `password_needs_reset = true`, el usuario es forzado a cambiar su contraseña antes de continuar navegando.
- `labels: user-story, auth, admin, sprint-4` · **SP:** 3

#### HU04 — Registro de última conexión
**Como** administrador
**Quiero** ver la fecha y hora del último inicio de sesión de cada usuario (`last_login_at`)
**Para** monitorear la actividad y detectar cuentas inactivas o sospechosas
- **Criterios de aceptación**
  - El listado de usuarios en el panel admin muestra la columna "Último acceso".
  - El campo se actualiza automáticamente en cada login exitoso.
- `labels: user-story, auth, admin, sprint-4` · **SP:** 2

#### HU05 — Verificación y recuperación de acceso
**Como** usuario registrado
**Quiero** poder verificar mi cuenta y recuperar el acceso si olvido mi contraseña
**Para** no perder el acceso permanente a mi cuenta
- **Criterios de aceptación**
  - Existen flujos de verificación de cuenta y de restablecimiento de contraseña (`Auth/*Controller`).
  - El usuario recibe confirmación visual del resultado de cada acción.
- `labels: user-story, auth, sprint-1` · **SP:** 3

### F1.3 — Gestión de perfil

#### HU06 — Edición de perfil personal
**Como** usuario registrado
**Quiero** cambiar mi nombre de usuario o mi contraseña desde "Mi Perfil"
**Para** mantener mis datos actualizados o reforzar mi seguridad
- **Criterios de aceptación**
  - Los cambios se validan antes de guardarse (unicidad de `user_name`, confirmación de contraseña).
  - Se muestra una confirmación visual tras actualizar con éxito.
  - Se conserva un historial/registro del cambio.
- `labels: user-story, auth, sprint-1` · **SP:** 2

---

## E2: Gestión de Productos e Inventario
**Objetivo de la épica:** Brindar a los administradores un CRUD completo de productos con soporte de imágenes, control de stock y visibilidad del catálogo.
`labels: epic, products`

### F2.1 — CRUD de productos

#### HU07 — Creación de productos con imagen
**Como** administrador de inventario
**Quiero** crear un nuevo producto subiendo una imagen desde mi computadora
**Para** que sea más fácil identificarlo visualmente en la tienda
- **Criterios de aceptación**
  - Permite subir formatos JPEG, PNG, JPG y GIF.
  - Valida que el precio sea un número positivo y el stock un entero no negativo.
  - La imagen se guarda correctamente en el disco público (`storage:link`).
- `labels: user-story, products, sprint-1` · **SP:** 5

#### HU08 — Edición y eliminación de productos
**Como** administrador de inventario
**Quiero** editar o eliminar productos existentes (incluyendo su imagen)
**Para** mantener el catálogo actualizado y libre de artículos obsoletos
- **Criterios de aceptación**
  - El formulario de edición precarga los datos actuales del producto.
  - Al eliminar, se solicita confirmación y se elimina también la imagen asociada.
- `labels: user-story, products, sprint-1` · **SP:** 3

### F2.2 — Catálogo y visualización

#### HU09 — Visualización de inventario con miniaturas
**Como** usuario del sistema
**Quiero** ver una lista elegante de todos los productos con miniaturas de sus fotos
**Para** tener un control visual de mi stock actual
- **Criterios de aceptación**
  - El catálogo es responsivo (Bootstrap 5).
  - Las imágenes se muestran alineadas y con tamaño uniforme.
- `labels: user-story, products, sprint-1` · **SP:** 2

#### HU10 — Detalle y dashboard de producto
**Como** usuario del sistema
**Quiero** ver el detalle completo de un producto y un dashboard general de inventario
**Para** tomar decisiones informadas sobre stock y disponibilidad
- **Criterios de aceptación**
  - La vista de detalle muestra stock, precio, horas requeridas (si aplica) y estado.
  - El dashboard resume métricas clave (total de productos, stock bajo, etc.).
- `labels: user-story, products, sprint-2` · **SP:** 3

### F2.3 — Activación y disponibilidad

#### HU11 — Activar/Desactivar producto
**Como** administrador de inventario
**Quiero** activar o desactivar un producto sin eliminarlo (`is_active`)
**Para** ocultarlo temporalmente del catálogo público sin perder su historial
- **Criterios de aceptación**
  - Un producto inactivo no aparece en el catálogo de compradores.
  - El cambio de estado se refleja de inmediato (toggle) sin recargar toda la página.
- `labels: user-story, products, sprint-3` · **SP:** 2

#### HU12 — Definir horas de voluntariado requeridas por producto
**Como** administrador
**Quiero** definir cuántas horas de voluntariado (`hours_required`) se necesitan para obtener un producto
**Para** habilitar el intercambio de servicio social por productos en el Mercado Solidario
- **Criterios de aceptación**
  - El campo tiene un valor por defecto configurable (ej. 4 horas).
  - El valor es visible en la ficha del producto dentro de "Comunidad".
- `labels: user-story, products, volunteering, sprint-4` · **SP:** 2

---

## E3: Carrito y Proceso de Compra (E-commerce)
**Objetivo de la épica:** Permitir a los compradores armar un pedido, ajustarlo y finalizarlo con descuento automático de stock.
`labels: epic, cart, orders`

### F3.1 — Carrito de compras

#### HU13 — Añadir productos al carrito
**Como** comprador
**Quiero** hacer clic en "Añadir" desde la lista de productos
**Para** ir seleccionando los artículos que deseo comprar
- **Criterios de aceptación**
  - El carrito persiste durante la sesión del usuario.
  - El contador en la barra de navegación se actualiza al instante.
- `labels: user-story, cart, sprint-1` · **SP:** 3

#### HU14 — Gestión de cantidades en el carrito
**Como** comprador
**Quiero** ver el total de mi compra y poder cambiar las cantidades por producto
**Para** ajustar mi pedido antes de finalizar
- **Criterios de aceptación**
  - Las cantidades se actualizan vía AJAX (sin recargar la página).
  - El total se recalcula automáticamente al cambiar cantidades.
  - Es posible quitar un producto del carrito.
- `labels: user-story, cart, sprint-1` · **SP:** 3

### F3.2 — Checkout y órdenes

#### HU15 — Finalización de compra con descuento de inventario
**Como** comprador
**Quiero** confirmar mi pedido desde una pantalla de checkout
**Para** concretar mi compra y que el sistema descuente automáticamente los productos del stock
- **Criterios de aceptación**
  - Se genera un registro de pedido (`Order`) y sus líneas (`OrderItem`) en la base de datos.
  - El stock de cada producto disminuye según la cantidad comprada.
  - Se muestra un resumen final (recibo) tras una compra exitosa (`success`).
  - El carrito se vacía automáticamente al terminar el proceso.
- `labels: user-story, orders, sprint-2` · **SP:** 8

#### HU16 — Validación de stock insuficiente en checkout
**Como** comprador
**Quiero** recibir un aviso claro si algún producto de mi carrito ya no tiene stock suficiente
**Para** corregir mi pedido antes de intentar pagar
- **Criterios de aceptación**
  - El sistema valida el stock disponible antes de procesar la orden.
  - Se muestra un mensaje indicando qué producto(s) no tienen stock suficiente.
- `labels: user-story, orders, sprint-2` · **SP:** 3

### F3.3 — Historial de pedidos

#### HU17 — Historial de mis pedidos
**Como** comprador
**Quiero** ver el historial de mis pedidos anteriores
**Para** hacer seguimiento de mis compras pasadas
- **Criterios de aceptación**
  - Se listan los pedidos del usuario autenticado con fecha, total y estado.
  - Cada pedido puede abrirse para ver el detalle de sus productos.
- `labels: user-story, orders, sprint-2` · **SP:** 3

#### HU18 — Administración de todos los pedidos
**Como** administrador
**Quiero** ver y eliminar cualquier pedido registrado en el sistema
**Para** gestionar incidencias, errores de compra o pedidos de prueba
- **Criterios de aceptación**
  - El administrador visualiza todos los pedidos de todos los usuarios.
  - Puede eliminar un pedido, con confirmación previa.
- `labels: user-story, orders, admin, sprint-2` · **SP:** 3

---

## E4: Mercado Solidario (Voluntariado)
**Objetivo de la épica:** Permitir que miembros de la comunidad obtengan productos a cambio de horas de servicio social, coordinado vía WhatsApp.
`labels: epic, volunteering`

### F4.1 — Postulación al voluntariado

#### HU19 — Registro de voluntariado por producto
**Como** miembro de la comunidad "12 de Octubre"
**Quiero** comprometerme a realizar horas de servicio social por un producto específico
**Para** obtenerlo sin costo monetario y contribuir al barrio
- **Criterios de aceptación**
  - El usuario especifica tipo de ayuda, horas comprometidas, teléfono y detalles.
  - El sistema redirige al usuario a WhatsApp para coordinar con el administrador.
  - Se crea un registro de voluntariado en estado `pending`.
- `labels: user-story, volunteering, sprint-4` · **SP:** 5

#### HU20 — Explorar productos disponibles en la Comunidad
**Como** miembro de la comunidad
**Quiero** ver un listado dedicado ("Comunidad") de productos disponibles por voluntariado
**Para** elegir a qué producto quiero postularme
- **Criterios de aceptación**
  - La vista `comunidad` muestra solo productos activos con sus horas requeridas.
- `labels: user-story, volunteering, sprint-4` · **SP:** 2

### F4.2 — Gestión administrativa del voluntariado

#### HU21 — Panel de administración de solicitudes de voluntariado
**Como** administrador
**Quiero** ver todas las solicitudes de voluntariado con su usuario y producto asociado
**Para** revisarlas y coordinarlas adecuadamente
- **Criterios de aceptación**
  - El listado muestra usuario, producto, tipo de ayuda, horas y estado.
  - Se ordena por más recientes primero.
- `labels: user-story, volunteering, admin, sprint-4` · **SP:** 3

#### HU22 — Aceptar o rechazar solicitudes de voluntariado
**Como** administrador
**Quiero** cambiar el estado de una solicitud entre `pending`, `accepted` o `rejected`
**Para** formalizar el acuerdo de voluntariado con el usuario
- **Criterios de aceptación**
  - El cambio de estado se refleja de inmediato en el panel.
  - Se muestra un mensaje de confirmación con el nuevo estado.
- `labels: user-story, volunteering, admin, sprint-4` · **SP:** 3

#### HU23 — Eliminar solicitudes de voluntariado
**Como** administrador
**Quiero** eliminar una solicitud de voluntariado
**Para** depurar registros duplicados, de prueba o ya finalizados
- **Criterios de aceptación**
  - Se solicita confirmación antes de eliminar.
- `labels: user-story, volunteering, admin, sprint-4` · **SP:** 1

### F4.3 — Seguimiento personal

#### HU24 — Mis solicitudes de voluntariado
**Como** miembro de la comunidad
**Quiero** ver el estado de todas mis postulaciones de voluntariado
**Para** saber si fueron aceptadas, rechazadas o siguen pendientes
- **Criterios de aceptación**
  - Se listan únicamente las solicitudes del usuario autenticado, ordenadas por fecha.
- `labels: user-story, volunteering, sprint-4` · **SP:** 2

---

## E5: Administración y Panel de Control
**Objetivo de la épica:** Dar a los administradores herramientas centralizadas para gestionar usuarios y supervisar la operación del sistema.
`labels: epic, admin`

### F5.1 — Gestión de usuarios

#### HU25 — Listado y administración de usuarios
**Como** administrador
**Quiero** ver un listado de todos los usuarios registrados
**Para** supervisar y gestionar el acceso al sistema
- **Criterios de aceptación**
  - El listado incluye `user_name`, rol y estado de la cuenta.
- `labels: user-story, admin, sprint-3` · **SP:** 3

#### HU26 — Otorgar o revocar permisos de administrador
**Como** administrador
**Quiero** cambiar el rol de un usuario entre estándar y administrador (`toggleAdmin`)
**Para** delegar o restringir el acceso a funciones administrativas
- **Criterios de aceptación**
  - El cambio de rol requiere confirmación.
  - Un administrador no puede revocarse a sí mismo su propio acceso por error (validación de seguridad).
- `labels: user-story, admin, sprint-3` · **SP:** 3

### F5.2 — Supervisión general

#### HU27 — Dashboard general del sistema
**Como** administrador
**Quiero** contar con un panel único con accesos rápidos a productos, pedidos, usuarios y voluntariado
**Para** operar el sistema de forma eficiente sin navegar por múltiples menús
- **Criterios de aceptación**
  - El dashboard muestra indicadores clave (productos activos, pedidos recientes, solicitudes pendientes).
- `labels: user-story, admin, sprint-3` · **SP:** 5

#### HU28 — Restablecer la contraseña de cualquier usuario
**Como** administrador
**Quiero** restablecer la contraseña de un usuario desde el panel de administración
**Para** ayudar a usuarios que perdieron el acceso a su cuenta sin depender de correo electrónico
- **Criterios de aceptación**
  - El sistema genera o solicita una nueva contraseña temporal.
  - Se marca `password_needs_reset` para forzar el cambio en el próximo login.
- `labels: user-story, admin, auth, sprint-4` · **SP:** 3

---

## E6: Calidad, CI/CD y Despliegue
**Objetivo de la épica:** Garantizar la estabilidad del sistema mediante pruebas automatizadas y un flujo de integración/despliegue continuo.
`labels: epic, devops, qa`

### F6.1 — Pruebas automatizadas

#### HU29 — Cobertura de pruebas Feature y Unit
**Como** equipo de desarrollo
**Quiero** contar con pruebas automatizadas de Feature y Unit (`php artisan test`)
**Para** detectar regresiones antes de fusionar cambios al repositorio
- **Criterios de aceptación**
  - Existen pruebas para los flujos críticos: auth, productos, carrito, checkout y voluntariado.
  - Las pruebas corren en un entorno aislado (SQLite en memoria o base de datos de test).
- `labels: user-story, qa, sprint-4` · **SP:** 5

### F6.2 — Integración y despliegue continuo

#### HU30 — Ejecución automática de pruebas en cada push (GitHub Actions)
**Como** equipo de desarrollo
**Quiero** que las pruebas se ejecuten automáticamente en cada `push` a las ramas principales
**Para** evitar que código roto llegue a producción
- **Criterios de aceptación**
  - Existe un workflow en `.github/workflows/` que instala dependencias y corre `php artisan test`.
  - El estado del workflow (pasa/falla) es visible en cada Pull Request.
- `labels: user-story, devops, sprint-4` · **SP:** 3

#### HU31 — Despliegue containerizado
**Como** equipo de desarrollo
**Quiero** empaquetar la aplicación con Docker (`Dockerfile`) y desplegarla mediante `render.yaml`
**Para** tener un entorno de producción reproducible y fácil de escalar
- **Criterios de aceptación**
  - La imagen Docker construye sin errores e incluye `storage:link` y migraciones al iniciar (`start.sh`).
  - El servicio queda accesible públicamente tras el despliegue.
- `labels: user-story, devops, sprint-4` · **SP:** 5

---

## Resumen de estimación (Story Points)

| Épica | SP totales |
|---|---|
| E1 — Autenticación y Seguridad | 15 |
| E2 — Productos e Inventario | 17 |
| E3 — Carrito y Compra | 23 |
| E4 — Mercado Solidario | 16 |
| E5 — Administración | 14 |
| E6 — Calidad y Despliegue | 13 |
| **Total** | **98** |

---
