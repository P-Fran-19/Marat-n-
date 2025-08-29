# Marathon
# 🎭 Cooperativa Teatral EnLasNube - Sistema de Venta de Entradas

Este repositorio contiene el desarrollo de una aplicación web para la **Cooperativa Teatral EnLasNube**, destinada a la gestión y comercialización de entradas de la obra **"Maratón"**.  
El sistema contempla tanto la experiencia del usuario (compra de entradas y acceso a información de la cooperativa) como la administración interna (gestión de compradores y envíos automatizados de información).

---

## 📌 Objetivos del proyecto

- Facilitar la **venta de entradas online** con control de stock y validaciones.
- Brindar un **espacio institucional** donde los usuarios puedan conocer la cooperativa, sus redes sociales y vías de contacto.
- Implementar un **panel de administración seguro** para la gestión de compradores.
- Integrar el sistema con **n8n** para automatizar el envío de correos electrónicos a los clientes.
- Dejar preparado el proyecto para una futura **integración con Mercado Pago**.

---

## ⚙️ Funcionalidades principales

### Sitio público
- Sección informativa sobre la cooperativa y su obra actual.
- Acceso rápido a:
  - Correo electrónico
  - Instagram oficial
  - Mensajería con texto predefinido para solicitudes de información.
- Formulario de compra de entradas con validaciones:
  - Todos los campos obligatorios.
  - Restricción: solo mayores de 18 años.
  - Visualización en tiempo real de disponibilidad.
  - Alerta en caso de stock agotado o intento de sobreventa.

### Panel de administración
- Sección oculta, protegida mediante **usuario y contraseña**.
- Listado completo de compradores registrados.
- Funcionalidades:
  - **Edición** de registros.
  - **Eliminación** de registros.
- Control de seguridad para evitar accesos no autorizados.

### Integraciones
- **n8n:** envío automático de correos electrónicos con los datos de compra.
- **Mercado Pago (API):** configurada para futura activación del pago automático (actualmente deshabilitada por decisión del cliente).

---

## 🛠️ Tecnologías utilizadas

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** (especificar stack real: Node.js / PHP / otro)
- **Base de datos:** (MySQL)
- **Automatización:** [n8n](https://n8n.io/)
- **Pasarela de pago (preparada):** [Mercado Pago](https://www.mercadopago.com.ar/)

---

## 🔒 Seguridad
> [!Important]
> - Autenticación requerida para acceder al panel de administración.
> - Utiliza el protocolo https
> - Validaciones estrictas en el formulario de compra:
  - Datos obligatorios
  - Restricción por edad
  - Control de stock disponible
- Datos de los compradores almacenados en base de datos y gestionados únicamente por administradores autorizados.


