import pika
import json
import cv2
import numpy as np
import testHold 
import base64

connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.99.100',31693))
channel = connection.channel()

countOn = 0
countOff = 0

channel.queue_declare(queue='videoStream')
def callback(ch, method, properties, body):
    #print(" [x] Received " )
    y = json.loads(body)
    motionCheck(y["image"])

def motionCheck(image):
    global countOn,countOff

    testHold.counter += 1
    nparr = np.fromstring(base64.b64decode(image), np.uint8)
    cvimg = cv2.imdecode(nparr,cv2.IMREAD_COLOR)
  

    if(testHold.prevFrame is None ):
        testHold.prevFrame = cvimg 
    else:
        res = cv2.absdiff(cvimg, testHold.prevFrame)
        res = res.astype(np.uint8)
        percentage = (np.count_nonzero(res) * 100)/ res.size
        #print(percentage)

        if(percentage > 20):
            #motion?
            
            countOn += 1
            if(countOn > 5):
                print("Motion!!!")
                countOff = 0
            else:
                print("Possible motion")
        else:
            countOff += 1
            if(countOff > 5):
                countOn = 0
            print("Nothing")
            


       
        testHold.prevFrame = cvimg





channel.basic_consume(queue='videoStream',
                      auto_ack=True,
                      on_message_callback=callback)

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()