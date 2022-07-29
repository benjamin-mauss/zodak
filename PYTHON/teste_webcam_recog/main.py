import face_recognition
import cv2
import numpy as np
import json
# pip install cmake
# pip install opencv-python

# This is a demo of running face recognition on live video from your webcam. It's a little more complicated than the
# other example, but it includes some basic performance tweaks to make things run a lot faster:
#   1. Process each video frame at 1/4 resolution (though still display it at full resolution)
#   2. Only detect faces in every other frame of video.

# PLEASE NOTE: This example requires OpenCV (the `cv2` library) to be installed only to read from your webcam.
# OpenCV is *not* required to use the face_recognition library. It's only required if you want to run this
# specific demo. If you have trouble installing it, try any of the other demos that don't require it instead.

# Get a reference to webcam #0 (the default one)

video = cv2.VideoCapture()

# ip = "https://192.168.1.4:8080/video"
# video.open(ip)


RES = 1 # 1 to 10
video_capture =   cv2.VideoCapture(0) #  video
# Load a sample picture and learn how to recognize it.
benjamin_face_encoding = np.load("/opt/lampp/htdocs/uploads/faces_encodes/1.npy", allow_pickle=True)

# Load a second sample picture and learn how to recognize it.
kellen_image = face_recognition.load_image_file("/opt/lampp/htdocs/uploads/faces_imagens/7.png")
kellen_face_encoding = face_recognition.face_encodings(kellen_image)[0]


# Load a second sample picture and learn how to recognize it.
vitor_image = face_recognition.load_image_file("/opt/lampp/htdocs/uploads/faces_imagens/5.png")
vitor_face_encoding = face_recognition.face_encodings(vitor_image)[0]

gabriel_image = face_recognition.load_image_file("/opt/lampp/htdocs/uploads/faces_imagens/4.png")
gabriel_face_encoding = face_recognition.face_encodings(gabriel_image)[0]



# Create arrays of known face encodings and their names
known_face_encodings = [
    benjamin_face_encoding, kellen_face_encoding, vitor_face_encoding, gabriel_face_encoding
]


known_face_names = [
    "Benjamin",
    "Kellen",
    "Bizinho",
    "viado"
]

# Initialize some variables
face_locations = []
face_encodings = []
face_names = []


process_this_frame = True
c= 0
presentes = []
while True:
    c+=1
    # Grab a single frame of video

    # Only process every other frame of video to save time

    ret, frame = video_capture.read()

    if c % 10 ==0:

        # Resize frame of video to 1/4 size for faster face recognition processing
        small_frame = cv2.resize(frame, (0, 0), fx=(10/RES)/10, fy=(10/RES)/10)

        # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
        rgb_small_frame = small_frame[:, :, ::-1]
        
        # Find all the faces and face encodings in the current frame of video
        face_encodings = face_recognition.face_encodings(rgb_small_frame)

        face_names = []
        
        for face_encoding in face_encodings:
            face_distances = face_recognition.face_distance(known_face_encodings, face_encoding)
            best_match_index = np.argmin(face_distances)
            name = known_face_names[best_match_index]
            if face_distances[best_match_index] < 0.55 and name not in presentes:
                presentes.append(name) 

    # Display the results
    # Display the resulting image
    print(presentes)

# Release handle to the webcam
video_capture.release()
cv2.destroyAllWindows()