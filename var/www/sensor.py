import RPi.GPIO as GPIO

#Sensor - GPIO 13

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)

sensor = 13
GPIO.setup(sensor, GPIO.IN)

# 0 - light
# 1 - dark
if not GPIO.input(sensor):
        print "light"
else:
        print "dark"
