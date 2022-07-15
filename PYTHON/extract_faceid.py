# given the image's name, extract the faceid and save in the database
import face_recognition
import numpy as np
import sys

PATH = "DATABASE/face_encodes/"
if len(sys.argv) == 2:
    
    image_content = face_recognition.load_image_file(PATH+sys.argv[1])
    
    if image_content is not None:
        face_id = face_recognition.face_encodings(image_content)[0]
        face_id.dump(PATH+sys.argv[1] + ".npy")
else:
    print("Usage: python3 extract_faceid.py <image_name>")
    sys.exit(1)