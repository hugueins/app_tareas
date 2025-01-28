Aplicación de Lista de Tareas en Ionic
Objetivo
Crear una aplicación de lista de tareas en Ionic que implemente navegación, rutas y almacenamiento de datos local.

Requisitos
Navegación y Rutas:
Implementa una estructura de navegación utilizando Angular Router.
La aplicación debe tener las siguientes páginas:
Página de inicio (lista de tareas)
Página de creación/edición de tarea
Página de detalles de tarea
Gestión de Tareas:
Los usuarios deben poder crear, leer, actualizar y eliminar tareas (CRUD).
Cada tarea debe tener un título, descripción y estado (pendiente/completada).
Almacenamiento de Datos:
Utiliza Ionic Preferences para almacenar las tareas localmente.
Implementa un servicio que maneje todas las operaciones de almacenamiento.
Interfaz de Usuario:
Usa componentes de Ionic como ion-list, ion-item, ion-button, etc.
Implementa un ion-fab para añadir nuevas tareas.
Utiliza ion-toast para mostrar mensajes de éxito o error.
Navegación Avanzada:
Usa NavController para la navegación entre la lista de tareas y los detalles de tarea.
Funcionalidades Adicionales:
Añade un indicador de carga (ion-loading) cuando se realizan operaciones de almacenamiento.
Implementa la funcionalidad de búsqueda en la lista de tareas.