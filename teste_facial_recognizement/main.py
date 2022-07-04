import face_recognition
import numpy as np

barack = face_recognition.load_image_file("barak/1.png")


print(barack)
# barack_2 = face_recognition.load_image_file("barak/2.jpg")

# biden = face_recognition.load_image_file("biden/1.jpg")
# biden_2 = face_recognition.load_image_file("biden/3.png")



# barack_encode = face_recognition.face_encodings(barack)[0]
# barack_encode_2 = face_recognition.face_encodings(barack_2)[0]

# biden_encode = face_recognition.face_encodings(biden)[0]
# biden_encode_2 = face_recognition.face_encodings(biden_2)[0]

# results = face_recognition.compare_faces([barack_encode, barack_encode_2, biden_encode_2], biden_encode)
# print(results)