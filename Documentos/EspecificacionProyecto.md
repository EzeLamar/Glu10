# **Proyecto IAP**

Explicación de como sería nuestra presentación del proyecto (primera entrega).

[TOC]

## **Como va a ser la presentación:**

1. Presentación: nos presentamos.
2. Planteamos la problemática: hablamos sobre el problema de los celiácos.
3. Solución que proponemos: una app que muestre info sobre los restaurantes.
4. Características de la aplicación:
   - Mapa que muestra los restaurantes en un rango alrededor del usuario.
   - Permite votar a los usuarios sobre los mejores restaurantes para los celíacos según:
     - Velocidad de atención.
     - Calidad de servicio.
     - Precio de los alimentos.
     - Limpieza del lugar.
     - Muestra publicidad de locales (rotiserias, pizzerias, mercados de comida) que ofrezcan comida para celíacos.
     - Caracteristicas mostradas de los restaurantes:
       - Posee certificación?
       - Ranking de “mejor restaurante del mes”.
       - Calificación según los votos de los usuarios.
       - Características de los Usuarios:
         - Según la frecuencia con la que vote el usuario, se le dará un **rango de confiabilidad**. El peso de sus voto se determinará a partir de este valor.
5. Tecnologías utilizadas para el desarrollo del proyecto:
   1. **Angular** para el Front-end (interfaz).
   2. **Base de Datos** (SQL o NoSQL?) para almacenar la info de los restaurantes y las cuentas de usuarios.
   3. Back-end (PHP y MySQL)
   4. **Ionic:** Framework para generar app equivalente para que la misma sea multiplataforma.
6. Mostramos unas imágenes de como sería la interfaz.
7. Y listo, esperamos los aplausos y ovaciones de nuestro amado publico. :P
8. Preguntas?

 

## **Ideas a analizar:**

- **Restaurantes:**
  - Todos comienzan con 3 de las 5 estrellas, y a medida que reciben los votos sube o baja su calificación.
  - Se tomarán mas en cuenta las notas intermedias (los extremos en menor medida) para la calificación de los restaurantes. Esto está pensado para evitar el fraude entre restuarantes.
- **Usuarios:**
  - Para que un usuario pueda votar debe estar registrado en el sistema con una cuenta de usuario. Debemos analizar que requisistos debe cumplir para registrarse (certificado de celiaco o algo así).
  - Podriamos hacer que se tengan que loguerar con facebook.