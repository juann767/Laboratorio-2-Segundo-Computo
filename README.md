# Laboratorio-2-Segundo-C-mputo
Laboratorio 2 de Programación Computacional 4
Realizado por 
Juan Ramón Espinal Coto SMSS102323
Diego Martín López Moreno SMSS097824
# Análisis de Implementación - Laboratorio 2

Este repositorio contiene la solución para el Laboratorio 2 del Segundo Cómputo. El sistema permite la gestión de registros mediante una interfaz web conectada a una base de datos MySQL, aplicando controles de acceso y validación de datos.

---

### 1. Manejo del Login de Usuarios
**Pregunta:** *¿De qué forma manejaste el login de usuarios? Explica con tus palabras por qué en tu página funciona de esa forma.*

| Componente | Implementación | Justificación |
| :--- | :--- | :--- |
| **Autenticación** | Objeto `$conexion` y método `query()`. | Se verifica la existencia del usuario en la tabla `usuarios` de MySQL mediante una consulta directa. |
| **Validación** | Comparación de texto plano (`==`). | Para agilizar las pruebas del laboratorio, el sistema compara la cadena de texto ingresada con la almacenada en la BD. |
| **Estado de sesión** | Uso de la superglobal `$_SESSION`. | Al ser HTTP un protocolo "sin memoria", la sesión permite identificar al usuario validado mientras navega por las distintas pantallas. |

---

### 2. Bases de Datos vs. Variables
**Pregunta:** *¿Por qué es necesario para las aplicaciones web utilizar bases de datos en lugar de variables?*

| Aspecto | Variables PHP | Base de Datos (MySQL) |
| :--- | :--- | :--- |
| **Persistencia** | Volátiles (se borran al cerrar el navegador). | Permanentes (se guardan en el disco duro). |
| **Alcance** | Solo funcionan para el usuario actual. | Compartidas por todos los usuarios del sistema. |
| **Capacidad** | Limitadas por la memoria del script. | Capaces de gestionar miles de registros estructurados. |

---

### 3. Casos de Uso: BD vs. Datos Temporales
**Pregunta:** *¿En qué casos sería mejor utilizar bases de datos y en cuáles datos temporales (cookies/sesiones)?*

| Método | Cuándo utilizarlo | Ejemplo en este Laboratorio |
| :--- | :--- | :--- |
| **Base de Datos** | Información que debe perdurar en el tiempo y ser consultada después. | El listado de personas (nombre, email, edad). |
| **Sesiones** | Datos sensibles de corto plazo que expiran al cerrar el navegador. | Proteger el acceso al `dashboard.php`. |
| **Cookies** | Datos de personalización que el usuario guarda en su propio equipo. | Opción de "Recordar usuario" en el formulario. |

---

### 4. Estructura de Tablas y Tipos de Datos
**Pregunta:** *Describa brevemente sus tablas y los tipos de datos utilizados; justifique la elección.*

#### Tabla: `usuarios` (Control de Acceso)
| Campo | Tipo de Dato | Justificación |
| :--- | :--- | :--- |
| `id` | `INT AUTO_INCREMENT` | Llave primaria para identificar registros de forma única. |
| `username` | `VARCHAR(50)` | Almacena el nombre de usuario optimizando el espacio en disco. |
| `password` | `VARCHAR(255)` | Longitud extendida para permitir el uso futuro de hashes seguros. |

#### Tabla: `registros` (Datos de Negocio)
| Campo | Tipo de Dato | Justificación |
| :--- | :--- | :--- |
| `nombre` | `VARCHAR(100)` | Suficiente longitud para nombres y apellidos completos. |
| `email` | `VARCHAR(100)` | Permite almacenar direcciones de correo con caracteres especiales. |
| `edad` | `INT` | Se usa entero para facilitar validaciones numéricas y ordenamiento. |
