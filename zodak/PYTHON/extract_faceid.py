# given a image's full path, 
# it loads the image and saves the face encoding to DATABASE/face_encodes/[image_name].npy
import face_recognition
import numpy as np
import sys

PATH = "DATABASE/face_encodes/"
if len(sys.argv) == 2:
    faceid = face_recognition.load_image_file(PATH+sys.argv[1])
    
    if faceid is not None:
        faceid = face_recognition.face_encodings(faceid)[0]
        faceid.dump(PATH+sys.argv[1] + ".npy")
else:
    print("Usage: python3 extract_faceid.py <image_name>")
    sys.exit(1)