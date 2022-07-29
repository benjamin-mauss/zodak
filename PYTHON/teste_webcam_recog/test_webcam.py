# https://www.youtube.com/watch?v=ojbnqJsC3yY

import cv2
from cv2 import VideoCapture

video = cv2.VideoCapture(-1)
ip = "https://192.168.1.4:8080/video"
video.open(ip)

while True:
    check, img = video.read()
    cv2.imshow("Capturing", img)
    cv2.waitKey(1)