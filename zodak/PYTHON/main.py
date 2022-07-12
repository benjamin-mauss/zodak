import face_recognition
import numpy as np
import sys


# loads the face encode from the file /DATABASE/face_encodes/[image_name].npy

image_name = sys.argv[1]

# função LOADS (com S) já passa a string, usar ela para carregar o numpy array do banco de dados
faceid = np.load("DATABASE/face_encodes/"+image_name+".npy", allow_pickle=True)



print(faceid)