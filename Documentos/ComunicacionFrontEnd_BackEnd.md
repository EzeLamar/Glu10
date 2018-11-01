# Comunicación entre FrontEnd y  BackEnd

[TOC]

## Consulta Restaurantes para Celiacos en la Ciudad

El **FrontEnd** le envía al **Backend** un pedido con el siguiente parámetro:

```json
{
    "CP": "8000"	//CP de la ciudad que se solicita
}
```

A lo que el **Backend** le responde:

```json
{
    "IDR": "1",							//ID único que representa a un restaurante
    "Nombre": "nombre_Restarurante",	//nombre del restaurante
    "Latitud": "15.3454343",			
    "Longitud": "-30.3425454",
    "Calificacion": "4.6"				//valor entre 0 y 5
}
```

### Consideraciones:

- La calificación será un valor entre 0 y 5.
- Los restaurantes de ejemplo seran tomados en un rango de 300m desde la plaza rivadavia.
- Deben haber 5 restaurantes almacenados en la base de datos con sus correspondientes latitud y longitud.
- La latitud y longitud de un lugar se pueden obtener desde **googlemaps**:
  - presionamos con el mouse un lugar en especifico.
  - copiamos la latitud (primer valor) y longitud (2do valor) desde la **URL**.