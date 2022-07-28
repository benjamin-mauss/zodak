import datetime
import face_recognition
import numpy as np
import sys
import mysql.connector
import time

# conectar com o banco de dados para pegar os dados
# rodar até acabar o perído


cnx = mysql.connector.CMySQLConnection()
cnx.connect(host='localhost', user='root', password='', database='zodak')

if not cnx.is_connected():
    print("error 1, database not connected")
    exit()
    
cursor = mysql.connector.connection_cext.CMySQLCursor(connection=cnx) #
# cursor = cnx.cursor()
cursor.execute("""
                SELECT *
                FROM horarios
                WHERE id = (IF(WEEKDAY(now())+1 = 7,
                                (SELECT id
                                FROM horarios
                                WHERE dia_semana=0
                                    AND (now() BETWEEN inicio AND fim)),
                                (SELECT id
                                FROM horarios
                                WHERE dia_semana=(WEEKDAY(now())+1)
                                    AND (now() BETWEEN inicio AND fim) ))); 
               """)

row = cursor.fetchone()

if row is None:
    print("error 2, o script tá rodando fora do horário")
    exit()
    

id_horario = row[0]
id_turma = row[1]
period_end = row[-1]

end_time = datetime.datetime.now().replace(hour=0, minute=0, second=0, microsecond=0) + period_end
now = datetime.datetime.now()




# get the list of students in the class

cursor.execute("select * from alunos where id_turma = %s", (id_turma,))

alunos_turma = []

row = cursor.fetchone()

# na verdade vou dar remove() nos que já forem encontrados
# e usar o proprio array alunos_turma
# alunos_ainda_nao_presentes = []

while row:
    print("aluno: ", row[1])
    aluno = {
        "id": row[0],
        "nome"  : row[1],
        "face_encode": np.load("/opt/lampp/htdocs/uploads/faces_encodes/" + str(row[0]) + ".npy", allow_pickle=True)
    }
    alunos_turma.append(aluno)
    # alunos_ainda_nao_presentes.append(aluno["id"])
    row = cursor.fetchone()

# print(alunos_turma)
# exit()
# adiciona falta pra todo mundo na tabela presença 
# pra depois dar alter table nos presentes (dentro do while)
# for separado por causa do cursor.execute 
for aluno in alunos_turma:
    cursor.execute("insert into presenca (id_aluno, id_horario, presente, _date) values (%s, %s, %s, %s)", (aluno["id"], id_horario, 0, now.strftime("%Y-%m-%d")))
cursor.execute("commit")



# while it's not the end of the period
while(now < end_time):
    # here we make the attendance check by comparing the face encodings of the students with the face encodings of the faces in the camera
    
    
    print(now)
    
    now = datetime.datetime.now()
print("fimm")




# cursor.close()
cnx.close()


