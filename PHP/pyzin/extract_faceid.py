# # given a user's id, 
# # it loads the image and saves the face encoding to /opt/lampp/htdocs/uploads/face_encodes/[image_name].npy

import face_recognition
import numpy as np
import sys


PATH = "/opt/lampp/htdocs/uploads/"
if len(sys.argv) == 2:
    faceid = face_recognition.load_image_file(PATH+"faces_imagens/"+sys.argv[1]+".png")
    
    if faceid is not None:
        faceid = face_recognition.face_encodings(faceid)[0]
        faceid.dump(PATH+"faces_encodes/"+sys.argv[1] + ".npy")
        print("1")
    else:
        print("2")
else:
    print("3")
    print("Usage: python3 extract_faceid.py <image_name>")
    sys.exit(1)