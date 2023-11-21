Fecha: 15/04/2023
Nombres:
        Francisco Dominguez Rol: 202104520-1
        Vicente Henriquez Rol: 202051507-7

Ejecutar el codigo python, y luego seguir lo escrito en la primera aclaración

Aclaraciones:
-Asumimos que la base de datos Spot-USM ya está creada, por lo que el usuario solo debe ingresar el nombre del servidor donde está creada la bd
-En la opcion 11, en la query que busca el promedio de los streams de las canciones de un artista, utilizamos la funcion CAST de SQl 
para cambiar el tipo de dato INT de total_streams a BIGINT, esto debido a que los numeros utilizados son demasiado grandes para
el tipo de dato INT



librerias:
https://docs.python.org/3/library/datetime.html
https://learn.microsoft.com/en-us/sql/t-sql/functions/getdate-transact-sql?view=sql-server-ver16
https://github.com/mkleehammer/pyodbc/wiki/Row
https://learn.microsoft.com/en-us/sql/t-sql/functions/dateadd-transact-sql?view=sql-server-ver16 #opcion 7 si usaramos full SQL, pero decidimos usar python por que resulta mas corto.
https://learn.microsoft.com/en-us/sql/t-sql/functions/avg-transact-sql?view=sql-server-ver16
