import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BCM)

Trigger = 2
Echo = 3
buzzer = 4
botonp = 17

GPIO.setup(Trigger, GPIO.OUT)
GPIO.setup(Echo, GPIO.IN)
GPIO.setup(buzzer, GPIO.OUT)
GPIO.setup(botonp, GPIO.IN)

print("Sensor ultrasonico")

try: 
	while True:
		
		GPIO.output(Trigger, False)
		time.sleep(0.5)
		
		GPIO.output(Trigger, True)
		time.sleep(0.00001)
		GPIO.output(Trigger, False)
		inicio=time.time()
		
		while GPIO.input(Echo)==0:
			inicio=time.time()
		
		while GPIO.input(Echo)==1:
			final=time.time()
		
		t_transcurrido=final-inicio
		distancia=t_transcurrido*34000
		
		distancia=distancia/2
		print("Distancia= %.1fcm"%distancia)
		
		if distancia <= 5:
			GPIO.output(buzzer, True)
			time.sleep(0.05)
			GPIO.output(buzzer, False)
			time.sleep(0.05)
			GPIO.output(buzzer, True)
			time.sleep(0.05)
			GPIO.output(buzzer, False)
			time.sleep(0.05)
			GPIO.output(buzzer, True)
			time.sleep(0.05)
			GPIO.output(buzzer, False)

			
		if distancia > 6 and distancia <= 10:
			GPIO.output(buzzer, True)
			time.sleep(0.3)
			GPIO.output(buzzer, False)
			time.sleep(0.3)
			GPIO.output(buzzer, True)
			time.sleep(0.3)
			GPIO.output(buzzer, False)
			
		if distancia > 11 and distancia <= 20:
			GPIO.output(buzzer, True)
			time.sleep(0.5)
			GPIO.output(buzzer, False)
			time.sleep(0.5)
			GPIO.output(buzzer, True)
			time.sleep(1)
			GPIO.output(buzzer, False)
			
		if distancia > 21 and distancia <= 30:
			GPIO.output(buzzer, True)
			time.sleep(1)
			GPIO.output(buzzer, False)
		
		if botonp == 1:
			print("panico")
		
		
	

except KeyboardInterrupt:
	GPIO.cleanup()
