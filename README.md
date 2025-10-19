Se trata de diseñar el backend de la gestión de la flota, pilotos y mantenimiento de naves del universo Star Wars,
usando Eloquent ORM y relaciones entre modelos. Los datos los puedes sacar de la API: https://swapi.dev/api/
Tendremos planetas que tendrá asociado varias naves. De los planetas nos interesa saber: nombre, período de
rotación, población y clima y de las naves: nombre, modelo, tripulación, pasajeros y clase de nave. Las naves
pertenecen a un planeta y puede tener varios mantenimientos y varios pilotos asociados. De los mantenimientos: id,
idnave, fecha, descripción y coste. De los pilotos tendremos también que guardar información: nombre, altura, año
de nacimiento y género.
Tendremos que gestionar que las naves son pilotadas por pilotos; necesitaremos una tabla pivote que tendrá
información del piloto, de la nave, de la fecha en la que el piloto está asociado y la fecha de fin de asociación.
El cliente necesitará la siguiente información:
- CRUD de naves. Por ahora abierto, pero que luego protegeremos.
- Listado de toda la información almacenada. Listados generales y búsquedas por id.
- Asignar/Desasignar un piloto a una nave. Con control de errores.
- Listar todas las naves que no tienen piloto.
- Listar todos los pilotos asignados a naves (histórico, no tienen por qué estar asignados actualmente).
- Lo mismo que el punto anterior pero solo mostrar los pilotos que actualmente están asociados a naves y
las naves.
- Registrar un mantenimiento.
- Listar mantenimientos puntuales.
- Listar mantenimientos de naves entre dos fechas.
