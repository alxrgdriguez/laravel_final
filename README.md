# 📚 Plataforma de Formación Profesional

Este proyecto es una plataforma de formación profesional desarrollada en **Laravel** con un diseño moderno y responsivo. Permite la gestión de cursos, inscripciones, evaluaciones y materiales educativos, diferenciando el acceso según los roles de **administrador, profesor y estudiante**.

## 🚀 Tecnologías Utilizadas
- **Laravel** - Framework PHP para backend.
- **Tailwind CSS** - Para un diseño moderno y responsivo.
- **SweetAlert2** - Librería de JavaScript utilizada para mostrar alertas interactivas (confirmaciones de eliminación, finalización de curso, etc.).
- **MySQL** - Base de datos relacional utilizada.
- **Blade Components** - Usados principalmente en la parte pública para una mejor organización del código.
- **Laravel Policies** - Para asegurar que cada usuario solo pueda acceder a las partes que le corresponden según su rol.
- **Validación de Formularios** - Implementada para evitar errores y datos incorrectos en los inputs.

## 📁 **Estructura del Proyecto**
- **Parte de Administración & Profesores:** Se invirtieron muchas horas en optimizar esta parte para hacerla lo más profesional posible.  
- **Diseño Responsivo:** Adaptado para cualquier dispositivo y con soporte para **modo oscuro y claro**.  
- **Componentes Reutilizables:** En la parte pública se reutilizaron más componentes para una mejor organización. En la parte privada se pudo mejorar en este aspecto, pero por cuestión de tiempo no se priorizó.  
- **Controladores en `App\Http\Controllers\Api`**:  
  - **Razón:** Al iniciar el desarrollo, los controladores fueron colocados en esta carpeta para hacer la API. Luego, se usaron también para la parte web, por lo que hay métodos que manejan ambas cosas.  
  - **Diferenciación:** Se agregaron nombres claros en los métodos para distinguir si son para la API o la web.  

⚠ **Nota:** Cada usuario tiene permisos diferentes, por lo que se recomienda probar cada cuenta para ver las distintas funcionalidades.

## 🔐 **Seguridad Implementada**
- **Laravel Policies**: Se aseguraron las páginas según los roles de usuario.
- **Validaciones de Formularios**: Se controlan posibles entradas erróneas de datos en los formularios.

## 🌐 **Proyecto subido a mi VPS**  
🔗 **[Web del Proyecto](https://alxrgdriguez.comparitiko.dev/login)**  

Si tienes cualquier duda comentamelo. 
