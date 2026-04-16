# Laboratorio-2-Segundo-C-mputo
Lab 2 C2  de Programación Computacional 4

## Integrantes
Juan Ramón Espinal Coto SMSS102323

Diego Martín López Moreno SMSS097824

# Implementación de análisis

El sistema permite la gestión de registros mediante una interfaz web conectada a una base de datos MySQL, aplicando controles de acceso y validación de datos.

---

1. ¿De qué forma manejaste el login de usuarios? Explica con tus palabras porque en tu
página funciona de esa forma.

### 1. Manejo del Login de Usuarios
**Pregunta:** *¿De qué forma manejaste el login de usuarios? Explica con tus palabras por qué en tu página funciona de esa forma.*

| Componente | Implementación | Justificación |
| :--- | :--- | :--- |
| **Autenticación** | Objeto `$conexion` y método `query()`. | Se verifica la existencia del usuario en la tabla `usuarios` de MySQL mediante una consulta directa. |
| **Validación** | Comparación de texto plano (`==`). | Para agilizar las pruebas del laboratorio, el sistema compara la cadena de texto ingresada con la almacenada en la BD. |
| **Estado de sesión** | Uso de la superglobal `$_SESSION`. | Al ser HTTP un protocolo "sin memoria", la sesión permite identificar al usuario validado mientras navega por las distintas pantallas. |
---

Sin embargo. El flujo de autenticación se diseñó para actuar como una barrera de seguridad perimetral. En nuestra implementación, el sistema no solo busca una coincidencia de caracteres, sino que gestiona el ciclo de vida del usuario dentro de la aplicación. Al utilizar la superglobal $_SESSION, logramos que el servidor mantenga un estado de "confianza" con el navegador del cliente; de esta forma, el archivo dashboard.php puede verificar en milisegundos si el usuario pasó por el index.php previamente. Esta arquitectura es fundamental en el desarrollo web moderno, ya que separa la lógica de validación de la lógica de visualización de datos, garantizando que el acceso a la tabla de registros sea exclusivo para el administrador.

2.¿Por qué es necesario para las aplicaciones web utilizar bases de datos en lugar de
variables?

### 2. Bases de Datos vs. Variables
**Pregunta:** *¿Por qué es necesario para las aplicaciones web utilizar bases de datos en lugar de variables?*

| Aspecto | Variables PHP | Base de Datos (MySQL) |
| :--- | :--- | :--- |
| **Persistencia** | Volátiles (se borran al cerrar el navegador). | Permanentes (se guardan en el disco duro). |
| **Alcance** | Solo funcionan para el usuario actual. | Compartidas por todos los usuarios del sistema. |
| **Capacidad** | Limitadas por la memoria del script. | Capaces de gestionar miles de registros estructurados. |

---
La transición de variables locales a una base de datos relacional representa el paso de un software estático a una aplicación dinámica y escalable. Mientras que las variables PHP residen en la memoria RAM y se destruyen al finalizar el ciclo de vida de la solicitud HTTP, la base de datos MySQL escribe la información en almacenamiento físico (HDD/SSD). Para este laboratorio, esto es crucial, ya que permite que los registros ingresados por un usuario sean consultados posteriormente o incluso por otros usuarios autorizados en diferentes sesiones. Sin la persistencia que ofrece el motor de base de datos, cualquier sistema de gestión de información perdería su utilidad al no poder garantizar la integridad y disponibilidad de los datos tras un refresco de página o un reinicio del servidor.


## 3. ¿En qué casos sería mejor utilizar bases de datos para su solución y en cuáles utilizar otro tipo de datos temporales como cookies o sesiones?

### 3. Casos de Uso: BD vs. Datos Temporales
**Pregunta:** *¿En qué casos sería mejor utilizar bases de datos y en cuáles datos temporales (cookies/sesiones)?*

| Método | Cuándo utilizarlo | Ejemplo en este Laboratorio |
| :--- | :--- | :--- |
| **Base de Datos** | Información que debe perdurar en el tiempo y ser consultada después. | El listado de personas (nombre, email, edad). |
| **Sesiones** | Datos sensibles de corto plazo que expiran al cerrar el navegador. | Proteger el acceso al `dashboard.php`. |
| **Cookies** | Datos de personalización que el usuario guarda en su propio equipo. | Opción de "Recordar usuario" en el formulario. |
---
La elección entre almacenamiento permanente y temporal depende estrictamente de la naturaleza de la información. En nuestro proyecto, la base de datos funciona como el "archivo central" donde reside la verdad histórica de los registros, permitiendo realizar consultas ordenadas y almacenamiento masivo. Por el contrario, las sesiones actúan como un mecanismo de control de tráfico: son ligeras, seguras (porque residen en el servidor y no en la PC del usuario) y eficientes para gestionar permisos momentáneos. El uso de cookies quedaría reservado para elementos de conveniencia, como preferencias estéticas, permitiendo así una arquitectura equilibrada donde no saturamos la base de datos con información trivial, ni sobrecargamos la memoria del servidor con datos que deberían ser permanentes.


4. Describa brevemente sus tablas y los tipos de datos utilizados en cada campo;
justifique la elección del tipo de dato para cada uno.

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

La definición de los esquemas para usuarios y registros se realizó bajo criterios de optimización de recursos y prevención de errores. Al utilizar INT para la edad, aseguramos que el motor de base de datos pueda realizar filtros lógicos (como identificar rangos de edad) mucho más rápido que si fuera texto. Por otro lado, la elección de VARCHAR con límites específicos (50 y 100 caracteres) responde a una gestión inteligente del almacenamiento en XAMPP, evitando desperdiciar espacio en el disco mientras se mantiene la flexibilidad para diferentes longitudes de nombres o correos. Finalmente, la implementación de AUTO_INCREMENT en los IDs delega al motor de la base de datos la responsabilidad de la integridad referencial, evitando colisiones de datos y facilitando el mantenimiento futuro del sistema.

Sin embargo, permitio comprobar que el uso de una base de datos relacional es el único método eficaz para que los usuarios creados (como admin) y los datos ingresados en nuestro formulario permanezcan almacenados tras cerrar el navegador. Mediante la conexión establecida con el objeto $conexion, logramos que PHP deje de ser una herramienta de visualización estática y pase a ser un sistema de gestión real, donde la seguridad se apoya en el manejo de sesiones para proteger el acceso al dashboard. En definitiva, el flujo trabajado garantiza que la información se procese, valide y guarde de forma íntegra en el servidor MySQL de XAMPP, cumpliendo con los estándares de desarrollo exigidos en este ciclo.
