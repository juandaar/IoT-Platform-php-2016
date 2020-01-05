import argparse
import numpy as np
import json
from sklearn import datasets, linear_model
import matplotlib.pyplot as plt

parser = argparse.ArgumentParser('informacion')
parser.add_argument('valores')
args = parser.parse_args()
arreglo_json=args.valores
datos=json.loads(arreglo_json)
dato_analizada=[]
fecha_analizada=[]
dato_modelo=[]
fecha_modelo=[]
contador=0
control=[]
cantidad=len(datos)


separacion=int(cantidad/2)
while (contador<cantidad):
	if (contador<separacion):
		dato_modelo.append(datos[contador]['dato'])
		fecha_modelo.append(datos[contador]['fecha'])
		control.append(contador+1)
	else:
		dato_analizada.append(datos[contador]['dato'])
		fecha_analizada.append(datos[contador]['fecha'])	
	contador=contador+1;
dato_modelo = np.array([dato_modelo], np.float64)
dato_modelo=np.reshape(dato_modelo,(separacion,1))
#fecha_modelo = np.array([fecha_modelo], np.dtype(str))
#fecha_modelo=np.reshape(fecha_modelo,(separacion,1))
control = np.array(control, np.float64)
fecha_analizada=np.array(control,np.dtype(str))
dato_analizada = np.array([dato_analizada], np.float64)
dato_analizada=np.reshape(dato_analizada,(separacion,1))

# crear regresión lineal
regr = linear_model.LinearRegression()

#entrenar el model
regr.fit(dato_modelo,control)


regresion=regr.predict(dato_analizada)
arreglo=np.array(regresion).tolist()
php=json.dumps(arreglo)
print (php)
