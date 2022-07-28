import face_recognition
import numpy as np
import sys
import mysql.connector
from mysql.connector import Error
import time

# conectar com o banco de dados para pegar os dados
# rodar até acabar o perído


try:
    cnx = mysql.connector.CMySQLConnection()
    cnx.connect(host='localhost', user='root', password='', database='zodak')
    if cnx.is_connected():
        db_Info = cnx.get_server_info()
        print("Connected to MySQL Server version ", db_Info)
        cursor = mysql.connector.connection_cext.CMySQLCursor() #
        # cursor = cnx.cursor()
        cursor.execute("select database();")
        record = cursor.fetchone()
        print("You're connected to database: ", record)

except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if cnx.is_connected():
        cursor.close()
        cnx.close()
        print("MySQL connection is closed")
    else:
        print("not even connected")