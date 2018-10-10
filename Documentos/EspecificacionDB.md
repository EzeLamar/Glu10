#Especificación de las Tablas de a base de datos
[TOC]

##Tablas
Restaurante(++IDR++,Nombre,Ubicacion,TieneMenuCel,CalifFinal)

Usuario(++IDU++, Nombre, Apellido, Edad, Email, Passwd, NroTelefono, esCeliaco, tokenFacebook)

Califico(++IDU++,++IDR++, CalidadServicio, Atencion, Precio, Higiene)

Ciudad(++CP++, Nombre, Poblacion, PoblacionCeliacos)

estaUbicado(++IDR++,++CP++,++Puesto++)

viveEn(++IDU++, ++CP++)

##Aclaraciones
1. **TokenFacebook:** este valor se obtiene al loguearse con Auth0 (autenticación por facebook)
2. **Ubiacion:** latitud y longitud (según como lo almacene GoogleMaps)
3. etc etc
