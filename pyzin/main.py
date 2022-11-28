#! /usr/bin/python3
import datetime
import face_recognition
import numpy as np
# import sys
import mysql.connector
# import time

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

# has the same index of the alunos_turma array
known_face_encodings = []

while row:
    # print("aluno: ", row[1])
    aluno = {
        "id": row[0],
        "nome"  : row[1] ,
        "vezes_detectado": 0
    }
    alunos_turma.append(aluno)
    known_face_encodings.append(np.load("/opt/lampp/htdocs/uploads/faces_encodes/" + str(row[0]) + ".npy", allow_pickle=True))
    
    # alunos_ainda_nao_presentes.append(aluno["id"])
    row = cursor.fetchone()

# print(alunos_turma)
# exit()
# adiciona falta pra todo mundo na tabela presença 
# pra depois dar alter table nos presentes (dentro do while)
# for separado por causa do cursor.execute 
for aluno in alunos_turma:
    cursor.execute("insert IGNORE into presencas (id_aluno, id_horario, present, _data) values (%s, %s, %s, %s)", (aluno["id"], id_horario, 0, now.strftime("%Y-%m-%d")))
cursor.execute("commit")


l = len(alunos_turma)

# Initialize some variables for face recognition
import cv2

video = cv2.VideoCapture()

# ip = "https://192.168.1.4:8080/video"
# video.open(ip)


RES = 1 # 1 to 10
video_capture =   cv2.VideoCapture(0) #  video

c= 0



# while it's not the end of the period 
# or if all the alunos are present
while now < end_time and l != 0:
    c+=1
    # here we make the attendance check by comparing the face encodings of the students with the face encodings of the faces in the camera
    ret, frame = video_capture.read()

    # process once per 10 frames
    if c % 10 ==0:

        # Resize frame of video to 1/4 size for faster face recognition processing
        small_frame = cv2.resize(frame, (0, 0), fx=(10/RES)/10, fy=(10/RES)/10)

        # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
        rgb_small_frame = small_frame[:, :, ::-1]
        
        # Find all the faces and face encodings in the current frame of video
        face_encodings = face_recognition.face_encodings(rgb_small_frame)

        
        for face_encoding in face_encodings:
            face_distances = face_recognition.face_distance(known_face_encodings, face_encoding)
            if len(face_distances) == 0: # avoid some errors, altough it could be better implemented
                continue
            best_match_index = np.argmin(face_distances)
            # print(alunos_turma[best_match_index]["nome"], " - ", face_distances[best_match_index])
            
            if face_distances[best_match_index] < 0.55: # and alunos_turma[best_match_index] in alunos_turma:

                # print(alunos_turma[best_match_index])
                id = alunos_turma[best_match_index]["id"]
                # removing both face and aluno from the list
                alunos_turma.pop(best_match_index)
                known_face_encodings.pop(best_match_index)
                cursor.execute("update presencas set present = 1 where id_aluno = %s and id_horario = %s and _data=%s", (id, id_horario, now.strftime("%Y-%m-%d")))
                cursor.execute("commit")
                
            


    # time stuff
    now = datetime.datetime.now()
    l = len(alunos_turma)
    # print("on loop! - ", l, " - ", now)
print("fimm")




# cursor.close()
cnx.close()
video_capture.release()

