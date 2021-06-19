import sys
import pigpio
import RPi.GPIO as GPIO

#RED - GPIO 17
#GREEN - GPIO 22
#BLUE - GPIO 24

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)

#the parameter from the command line - the hex code of the color (without #, stripped in php)
codeColor = sys.argv[1]

#tuple with intensities for each color (RGB)
T = (int(codeColor[0:2],16), int(codeColor[2:4],16), int(codeColor[4:6],16))

#sets the intensity of each channel of the LED strip
pi = pigpio.pi()
pi.set_PWM_dutycycle(17, T[0])
pi.set_PWM_dutycycle(22, T[1])
pi.set_PWM_dutycycle(24, T[2])
pi.stop
