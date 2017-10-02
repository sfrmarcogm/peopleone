### API REST: [API REST en PHP]
#### Autor: Antonio Salazar

En este proyecto se implementa un API REST en PHP

Requerimientos:

PHP: 5.5.x
MySQL 5.0
APache 2.4.x

Información

Se utilizó el Framework CodeIgniter en conjunto con la librería REST para manipular la forma en que CodeIgniter maneja nativamente las peticiones y poder manejar de una mejor manera las llamadas al API. 
Todo esto en su conjunto ofrece una sólida alternativa para la construcción del API.

Para el UI se itilizaron las librerías de Bootstrap+jQuery+Validator para crear el formulario, manejar la validación de campos y tener un formulario responsivo.

Instalación

1. Crear una BD en MySQL con el archivo 'po_catalogo_servicios.sql.zip' que se encuentra en la carpeta principal del proyecto
2. Colocar el proyecto en una carpeta accesible, por ejemplo 'peopleone'
3. Editar el archivo peopleone/application/config/config.php en la línea 26 para apuntar a la carpeta local del servidor donde se encuentra la aplicación, por ejemplo $config['base_url'] = 'http://localhost/peopleone';
3. Editar el archivo peopleone/application/config/database.php para ingresar el nombre de usuario que tendrá los permisos para interactuar con la BD y la contraseña correspondientes (líneas 21 y 22).
4. Dirigirse en el navegador, por ejemplo Chrome, a la ruta del server donde se encuentra el proyecto, siguiende este ejemplo sería http://localhost/peopleone/

Se muestra una UI para realizar pruebas con el API.

Al entrar en la UI del proyecto, se muestra un formulario con las siguientes instrucciones:

API REST Test
Selecciona un elemento de la lista para hacer una operación CRUD.
Un mensaje 'Bad Request' indica que faltan parámetros para la operación indicada.
Un mensaje 'Success' indica que se completó la operación.

Un 'Bad Request' solamente ocurrirá en los campos que no se marcaron a propósito como requeridos.
Un 'Success' será retornado siempre que se complete la operación, aún cuando no regrese datos. 

Ejemplos:

* Si seleccionamos la operación Read y en Item no escribimos nada, obtendremos un 'Bad Request'.
* Si en el caso anterior ingresamos Wired en el campo de Item, obtendremos un 'Success' y en el textarea Resultado la respuesta con em mensaje de error o de succes y los datos.
* Si seleccionamos la operación Delete y no capturamos el ID del item, se nos solicitará completar la información antes de enviar los datos.

Esto se hace a proósito para probar diferentes maneras de configurar la respuesta del API.


Nota: En  http://localhost/peopleone/api/incidencias/ se encuentra el API con las operaciones disponibles.

Las operaciones disponibles son:

* crear: Create
* lista: Read
* editar: Update
* borrar: Delete
* version: adiconal para obtener la versión del API

Pendientes:

Ajustar la seguridad mediante Basic Auth. Actualmente se ha probado para peticiones por herramientas como POSTMAN pero en el UI es distinto.




