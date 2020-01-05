import argparse
import numpy as np
import json
from sklearn import  linear_model

parser = argparse.ArgumentParser('informacion')
parser.add_argument('numero_inicial', metavar='N', type=int)
parser.add_argument('valores')
args = parser.parse_args()
arreglo_json=args.valores
numero_inicial=args.numero_inicial;
datos=json.loads(arreglo_json)
dato_analizada=[]
fecha_analizada=[]
dato_modelo=[]
fecha_modelo=[]
contador=0
control=[]
control_analisis=[]
cantidad=len(datos)
contador_analisis=0;
if(numero_inicial==0 ):
	separacion=int(cantidad*0.9)
	while (contador<cantidad):
		if (contador<separacion):
			dato_modelo.append(datos[contador]['valor'])
			fecha_modelo.append(datos[contador]['fecha'])
			control.append(contador+1)
		else:
			dato_analizada.append(datos[contador]['valor'])
			fecha_analizada.append(datos[contador]['fecha'])	
			control_analisis.append(contador+1)
			contador_analisis=contador_analisis+1;
		contador=contador+1;

else:
	separacion=numero_inicial;
	while (contador<cantidad):
		if (contador<separacion):
			dato_modelo.append(datos[contador]['valor'])
			fecha_modelo.append(datos[contador]['fecha'])
			control.append(contador+1)
		else:
			dato_analizada.append(datos[contador]['valor'])
			fecha_analizada.append(datos[contador]['fecha'])	
			control_analisis.append(contador+1)
			contador_analisis=contador_analisis+1;
		contador=contador+1;
dato_modelo = np.array(dato_modelo, np.float64)

control = np.array([control], np.float64)
control=np.reshape(control,(separacion,1))

control_analisis = np.array([control_analisis], np.float64)
control_analisis=np.reshape(control_analisis,(cantidad-separacion,1))

fecha_analizada=np.array(control,np.dtype(str))



# crear regresión lineal
regr=linear_model.LassoCV(cv=20).fit(control,dato_modelo)


regresion=regr.predict(control_analisis)
arreglo=np.array(regresion).tolist()
php=json.dumps(arreglo)
print(separacion)
print (php)
print (json.dumps(dato_analizada))
