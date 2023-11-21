import pyodbc 
import datetime


# Funciones #
#####################################################################################
def verificar_comilla(cadena):
    """
    Verifica si una cadena contiene una comilla simple ('), si es así, agrega otra.
    Si no, devuelve la cadena tal cual.
    """
    if "'" in cadena:
        cadena = cadena.replace("'", "''")
    return cadena
######################################################################################


# Conexion a la base de datos #
###########################################################
connection = pyodbc.connect('Driver={SQL Server};'
                      'Server=ELITEBOOK-VICEN\SQLEXPRESS;'
                      'Database=Spot-USM;'
                      'Trusted_Connection=yes;')

cursor = connection.cursor()
###########################################################


# Creacion de tablas  carga del archivo song.csv #
################################################################################################################################################################################################################################################################
cursor.execute("CREATE TABLE repositorio_musica (ID INT IDENTITY(1,1) PRIMARY KEY,position INT, artist_name VARCHAR(92), song_name VARCHAR(92), days INT, top_10 INT, peak_position INT, peak_position_time VARCHAR(92), peak_streams INT, total_streams INT)")
connection.commit()

# Leer el archivo CSV línea por línea e insertar cada registro en la tabla #

with open("song.csv", encoding='utf-8') as f:
    next(f)
    for line in f:
        params = line.strip().split(';') # Separar los campos por coma
        cursor.executemany("INSERT INTO repositorio_musica (position, artist_name, song_name, days, top_10, peak_position, peak_position_time, peak_streams, total_streams) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [params])

cursor.execute("CREATE TABLE reproduccion (ID INT IDENTITY(1,1) PRIMARY KEY, song_name VARCHAR(92),artist_name VARCHAR(92), fecha_reproduccion DATE, cant_reproducciones INT, favorito BIT)")
cursor.execute("CREATE TABLE lista_favoritos (ID INT IDENTITY(1,1) PRIMARY KEY, song_name VARCHAR(92), artist_name VARCHAR(92), fecha_agregada DATE)")

################################################################################################################################################################################################################################################################


# View #
################################################################################################################
cursor.execute("CREATE VIEW Tabla AS SELECT song_name, artist_name FROM [Spot-USM].[dbo].[repositorio_musica]")
################################################################################################################


# Funcion SQL #
#####################################################################################################################################################
cursor.execute("CREATE FUNCTION cambioTipo(@numero INT) RETURNS BIGINT AS BEGIN DECLARE @result BIGINT SELECT @result = @numero RETURN @result END")
#####################################################################################################################################################


# Carga de funciones y  tablas a SQL #
######################################
connection.commit()
######################################


# To Do List # 
###########################################################################################################################################################################################################################################################################
while True:

    # Opciones #
    ##################################################################################
    print("\n               Spot-Usm               \n\n" + 
      "Tus Opciones: \n" + 
      "\t1. Mostrar Reproducción.\n" + 
      "\t2. Ver mis favoritas.\n" + 
      "\t3. Agregar una cancion a favoritas.\n" + 
      "\t4. Sacar una cancion de favoritas.\n" + 
      "\t5. Reproducir una cancion.\n" + 
      "\t6. Buscar una canción en la tabla Reproducción.\n" + 
      "\t7. Escuchadas por primera vez hace: \n" + 
      "\t8. Buscar una cancion por su nombre o por su artista.\n" + 
      "\t9. Ver Top 15 artistas con mayor cantidad total de veces en el top 10.\n" + 
      "\t10. Posición mas alta alcanzada por un artista.\n" + 
      "\t11. Promedio de streams totales de un artista.\n")
    opcion = int(input("Ingrese opcion (0 para salir): "))
    ##################################################################################
    

    # Opción 0 (Salir del programa) #
    #################################
    if opcion == 0:
        connection.commit()
        break
    #################################


    # Opción 1 # 
    ###############################################################################################################################
    if opcion == 1:
        print("---------Canciones reproducidas-----------")
        orden = int(input("Ordenar por:\n"+"\t1. Fecha\n \t2. Cant. de veces reproducida\n Ingrese numero de opcion: "))
        if orden == 1:
            cursor.execute("SELECT * FROM reproduccion ORDER BY fecha_reproduccion DESC")
            resultados = cursor.fetchall()
            if resultados == []:
                print("No hay canciones en la lista de reproduccion")
            else:
                for resultado in resultados:
                    print("Cancion: "+resultado[1]+"  "+"Artista: "+resultado[2]+" "+"Fecha: "+resultado[3])
        else:
            cursor.execute("SELECT * FROM reproduccion ORDER BY cant_reproducciones DESC")
            resultados = cursor.fetchall()
            if resultados == []:
                print("No hay canciones en la lista de reproduccion")
            else:
                for resultado in resultados:
                    print("Cancion: "+resultado[1]+"  "+"Artista: "+resultado[2]+" "+"Cant de reproducciones: "+str(resultado[4]))
    ###############################################################################################################################


    # Opción 2 # 
    ########################################################################################
    elif opcion == 2:
        #Mostrar canciones favoritas
        cursor.execute("SELECT * FROM lista_favoritos")
        fav = cursor.fetchall()
        if fav == []:
            print("No hay canciones en favoritos")
        else:
            for cancion in fav:
                id, nombre, artista, fecha = cancion
                print("Numero: "+str(id)+" Nombre: "+nombre+" "+ artista+" Fecha de agregado: "+ fecha)
    ########################################################################################


    # Opción 3 # 
    #############################################################################################################################################################################################
    elif opcion == 3:
        #Hacer favorita una cancion asumiendo que es la cancion que se está reproduciendo actualmente
        #obtener de la tabla reproduccion, song_name, artist_name
        busqueda_fav = input("Ingrese el nombre de la cancion que desea agregar a favoritos: ")
        cursor.execute(f"SELECT * FROM Tabla WHERE song_name LIKE '%{verificar_comilla(busqueda_fav)}'")
        canciones = cursor.fetchall()
        if canciones == []:
            print("la cancion no existe")
        else:
            if len(canciones) > 1: #si encuentra varias canciones con el mismo nombre
                        print("Hay mas de una cancion con ese nombre.")
                        for cancion in canciones:
                            print("Cancion: "+cancion.song_name+"  "+"Artista: "+cancion.artist_name)
                        opcion_artista = input("Especifique el nombre del artista de la cancion: ")
                        cursor.execute(f"SELECT * FROM Tabla WHERE song_name LIKE '%{verificar_comilla(busqueda_fav)}' AND artist_name LIKE '%{verificar_comilla(opcion_artista)}'")
                        fav = cursor.fetchone()
                        print("Se ha agregado "+fav.song_name+" de "+fav.artist_name+" a favoritos")
                        fecha_agregada = datetime.datetime.now().date().strftime('%Y%m%d')
                        fila = [fav.song_name,fav.artist_name]
                        fila.append(fecha_agregada)
                        cursor.executemany(f"INSERT INTO lista_favoritos (song_name, artist_name, fecha_agregada) VALUES (?, ?, ?)", [fila])
                        #aqui se hace busqueda para ver si la cancion esta en la tabla de reproduccion o no
                        cursor.execute(f"SELECT song_name, artist_name FROM [Spot-USM].[dbo].[reproduccion] WHERE song_name LIKE '%{verificar_comilla(fav.song_name)}' AND artist_name LIKE '%{verificar_comilla(fav.artist_name)}'")
                        lista = cursor.fetchone()
                        if lista:
                            cursor.execute(f"UPDATE reproduccion SET favorito = 1 WHERE song_name LIKE '%{verificar_comilla(fav.song_name)}' AND artist_name LIKE '%{verificar_comilla(fav.artist_name)}'")
            else:
                print("Se ha agregado "+canciones[0].song_name+" de "+canciones[0].artist_name+" a favoritos")
                fecha_agregada = datetime.datetime.now().date().strftime('%Y%m%d')
                fila = [canciones[0].song_name,canciones[0].artist_name]
                fila.append(fecha_agregada)
                cursor.executemany(f"INSERT INTO lista_favoritos (song_name, artist_name, fecha_agregada) VALUES (?, ?, ?)", [fila])
                cursor.execute(f"SELECT song_name, artist_name FROM [Spot-USM].[dbo].[reproduccion] WHERE song_name LIKE '%{verificar_comilla(canciones[0].song_name)}'")
                lista = cursor.fetchone()
                if lista:
                    cursor.execute(f"UPDATE reproduccion SET favorito = 1 WHERE song_name LIKE '%{verificar_comilla(canciones[0].song_name)}'")
    ################################################################################################################################################################################################


    # Opción 4 # 
    ##################################################################################################################################
    elif opcion == 4:
        #Mostrar canciones favoritas
        cursor.execute("SELECT * FROM lista_favoritos")
        fav = cursor.fetchall()
        if fav == []:
            print("No hay canciones favoritas")
        else:
            for cancion in fav:
                id, nombre, artista, fecha = cancion
                #print(cancion)
                print("Numero: "+str(id)+" Nombre: "+nombre+" "+ artista+" Fecha de agregado: "+ fecha)
            buscar = True
            while buscar:
                seleccion = int(input("Seleccione el numero de la cancion que desea eliminar de favoritos: "))
                #Quitar de favorito
                cursor.execute(f"SELECT song_name, artist_name FROM lista_favoritos WHERE ID = '{seleccion}'") #obtener cancion actual viendo la ID de reproduccion mas reciente
                row = cursor.fetchone()
                if row != None:
                    cancion, artista = row
                    cursor.execute(f"UPDATE reproduccion SET favorito=0 WHERE song_name = '{verificar_comilla(cancion)}' AND artist_name = '{verificar_comilla(artista)}'")
                    cursor.execute(f"DELETE FROM lista_favoritos WHERE song_name = '{verificar_comilla(cancion)}' AND artist_name = '{verificar_comilla(artista)}'")
                    print("Cancion eliminada de favoritos correctamente")
                    buscar = False
                else:
                    print("ID invalido")
    ##################################################################################################################################


    # Opción 5 # 
    #######################################################################################################################################################################################################################################################################
    elif opcion == 5:
        nombre_cancion = input("nombre de la cancion: ")
        cursor.execute(f"SELECT * FROM Tabla WHERE song_name LIKE '%{verificar_comilla(nombre_cancion)}'")
        canciones = cursor.fetchall()
        if canciones == []:
            print("No se encontró una cancion con ese nombre.")
        else:
            if len(canciones) > 1: #si encuentra varias canciones con el mismo nombre
                print("Hay mas de una cancion con ese nombre.")
                for cancion in canciones:
                    print("Cancion: "+cancion.song_name+"  "+"Artista: "+cancion.artist_name)
                opcion_artista = input("Especifique el nombre del artista de la cancion: ")
                cursor.execute(f"SELECT * FROM Tabla WHERE song_name LIKE '%{verificar_comilla(nombre_cancion)}' AND artist_name LIKE '%{verificar_comilla(opcion_artista)}'")
                en_reproduccion = cursor.fetchone()
                print("Reproduciendo "+en_reproduccion.song_name+" de "+en_reproduccion.artist_name)
                cursor.execute(f"SELECT song_name, artist_name FROM [Spot-USM].[dbo].[reproduccion] WHERE song_name LIKE '%{verificar_comilla(en_reproduccion.song_name)}' AND artist_name LIKE '%{verificar_comilla(en_reproduccion.artist_name)}'")
                lista = cursor.fetchone()
                if lista != None:
                    cursor.execute(f"UPDATE reproduccion SET fecha_reproduccion = GETDATE(), cant_reproducciones = cant_reproducciones + 1 WHERE song_name LIKE '%{verificar_comilla(en_reproduccion.song_name)}' AND artist_name LIKE '%{verificar_comilla(en_reproduccion.artist_name)}'")
                else:
                    fecha_reproduccion = datetime.datetime.now().date().strftime('%Y%m%d')
                    cursor.execute(f"SELECT song_name, artist_name FROM [Spot-USM].[dbo].[lista_favoritos] WHERE song_name LIKE '%{verificar_comilla(en_reproduccion.song_name)}' AND artist_name LIKE '%{verificar_comilla(en_reproduccion.artist_name)}'")
                    fav = cursor.fetchone()
                    if fav != None:
                        favorito = 1
                    else:
                        favorito = 0
                    cant_reproducciones = 1
                    cursor.execute("INSERT INTO reproduccion (song_name, artist_name, fecha_reproduccion, cant_reproducciones, favorito) VALUES (?,?,?,?,?)", (en_reproduccion.song_name, en_reproduccion.artist_name, fecha_reproduccion, cant_reproducciones, favorito))
            else:
                print("Reproduciendo "+canciones[0].song_name+" de "+canciones[0].artist_name)
                cursor.execute(f"SELECT song_name, artist_name FROM [Spot-USM].[dbo].[reproduccion] WHERE song_name LIKE '%{verificar_comilla(canciones[0].song_name)}'")
                lista = cursor.fetchone()
                if lista != None:
                    cursor.execute(f"UPDATE reproduccion SET fecha_reproduccion = GETDATE(), cant_reproducciones = cant_reproducciones + 1 WHERE song_name LIKE '%{verificar_comilla(canciones[0].song_name)}'")
                else:   
                    fecha_reproduccion = datetime.datetime.now().date().strftime('%Y%m%d')
                    cursor.execute(f"SELECT song_name, artist_name FROM [Spot-USM].[dbo].[lista_favoritos] WHERE song_name LIKE '%{verificar_comilla(canciones[0].song_name)}'")
                    fav = cursor.fetchone()
                    if fav != None:
                        favorito = 1
                    else:
                        favorito = 0
                    cant_reproducciones = 1
                    cursor.execute("INSERT INTO reproduccion (song_name, artist_name, fecha_reproduccion, cant_reproducciones, favorito) VALUES (?,?,?,?,?)", (canciones[0].song_name, canciones[0].artist_name, fecha_reproduccion, cant_reproducciones, favorito))
    #######################################################################################################################################################################################################################################################################


    # Opción 6 # 
    ####################################################################################################################################################################################################
    elif opcion == 6:
        busqueda = input("Ingrese el nombre de la cancion que desea buscar: ")
        cursor.execute(f"SELECT song_name, artist_name, fecha_reproduccion, cant_reproducciones, favorito FROM [Spot-USM].[dbo].[reproduccion] WHERE song_name LIKE '%{verificar_comilla(busqueda)}'")
        lista = cursor.fetchall()
        if lista == []:
            print("No hay una cancion con ese nombre.")
        else:
            print("Resultado de busqueda: ")
            for resultado in lista:
                song_name, artist_name, fecha_reproduccion, cant_reproducciones, favorito = resultado
                print("Nombre: "+ song_name +" "+ "Artista: "+artist_name+" "+ "Fecha: "+ str(fecha_reproduccion)+" "+"Cant veces reproducida: "+ str(cant_reproducciones)+" Favorito: "+str(favorito))
    ####################################################################################################################################################################################################        


    # Opción 7 # 
    #################################################################################################################################################################################################
    elif opcion == 7:
        busqueda = int(input("Ingrese los ultimos X dias: ")) #se asume que el usuario ingresará un numero y no una letra
        fecha = datetime.datetime.now().date().strftime('%Y%m%d')#fecha actual pero en formato str sin guion
        fecha_actual = datetime.datetime.now().date()  # Obtiene la fecha actual en formato año-mes-dia
        inicioRango = (fecha_actual + datetime.timedelta(days=-busqueda)).strftime('%Y%m%d')  # Obtiene el número del día de la fecha que está input días antes de la fecha actual
        cursor.execute(f"SELECT song_name, artist_name, fecha_reproduccion, cant_reproducciones FROM [Spot-USM].[dbo].[reproduccion] WHERE fecha_reproduccion BETWEEN '{inicioRango}' AND '{fecha}'")
        lista = cursor.fetchall()
        print("Resultado de busqueda: ")
        for resultado in lista:
            song_name, artist_name, fecha_reproduccion, cant_reproducciones = resultado
            print("Nombre: "+ song_name +" "+ "Artista: "+artist_name+" "+ "Fecha: "+ str(fecha_reproduccion)+" "+"Cant veces reproducida: "+ str(cant_reproducciones))
    #################################################################################################################################################################################################
    

    # Opción 8 # 
    #############################################################################################################################################
    elif opcion == 8:
        buscar = True
        while buscar:
            print("Buscar: \n"+
                  '\tOpcion 1: Por nombre de cancion \n'+
                  '\tOpcion 2: Por nombre de artista \n'+
                  '\tOpcion 3: Salir de la busqueda')
            
            op = int(input("Ingrese el numero de la opcion elegida: "))

            if op == 1:
                cancion_elegida = input("Nombre de la cancion: ")
                cursor.execute(f"SELECT * FROM Tabla WHERE song_name LIKE '%{verificar_comilla(cancion_elegida)}'")
                canciones = cursor.fetchall()
                if canciones == []:
                    print("No hay canciones con ese nombre")
                else:
                    print("Canciones con el nombre: "+cancion_elegida)
                    for cancion in canciones:
                        print("-"+cancion.song_name+"  |"+"Artista: "+cancion.artist_name)

            elif op == 2:
                nombre_artista = input("Nombre del artista: ")
                cursor.execute(f"SELECT * FROM Tabla WHERE artist_name LIKE '%{verificar_comilla(nombre_artista)}'")
                artista = cursor.fetchall()
                if artista == []:
                    print("No existe ese artista")
                else:
                    print("Canciones de "+nombre_artista+":")
                    for cancion in artista:
                        print("-"+cancion.song_name)

            elif op == 3:
                buscar = False

            else:
                print("No existe tal opcion. Por favor ingrese una opcion valida")
    #############################################################################################################################################


    # Opción 9 # 
    #####################################################################################################################################################
    elif opcion == 9:
        cursor.execute("SELECT TOP 15 artist_name, SUM(top_10) AS total_top_10 FROM repositorio_musica GROUP BY artist_name ORDER BY total_top_10 DESC")
        top = cursor.fetchall()
        print("TOP 15: ")
        for a in top:  
            artista, num = a
            print("Artista: "+artista+" | Cantidad de veces en el Top 10: "+str(num))
    #####################################################################################################################################################


    # Opción 10 # 
    ################################################################################################################################
    elif opcion == 10:
        artista = input("Nombre del artista: ")
        cursor.execute(f"SELECT MIN(peak_position) FROM [Spot-USM].[dbo].[repositorio_musica] WHERE artist_name LIKE '%{verificar_comilla(artista)}'")
        peak_position = cursor.fetchone()
        if peak_position == []:
            print("No existe ese artista")
        else:
            print("La posicion mas alta alcanzada por "+artista+" fue "+str(peak_position[0]))
    ################################################################################################################################


    # Opción 11 # 
    ################################################################################################################################################
    elif opcion == 11:
        artista = input("Nombre del artista: ")
        
        cursor.execute(f"SELECT AVG(dbo.cambioTipo(total_streams)) FROM [Spot-USM].[dbo].[repositorio_musica] WHERE artist_name LIKE '%{verificar_comilla(artista)}'")
        promedio_streams = cursor.fetchone()
        if promedio_streams == []:
            print("No existe ese artista")
        else:
            print("Promedio de streams totales de "+artista+": "+str(promedio_streams[0]))

    else:
        print("Opcion no valida")
    ################################################################################################################################################


###########################################################################################################################################################################################################################################################################


# Enviar instrucciones a la base de datos#
##########################################
connection.commit()
##########################################


# Finalizar conexión #
######################
connection.close()
######################