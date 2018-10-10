# Diagramas del Proyecto



[TOC]

## Diagrama de Uso

![diagramaUso](/home/eze/Dropbox/IAP/Proyecto/DiagramaCasosDeUso_celiacos_1.png)

## Diagrama Entidad-Relación

![diagramaER](/home/eze/Dropbox/IAP/Proyecto/DiagramaER_celiacos_1.png)

**Restaurante**(<u>IDR</u>,Nombre,Ubicacion,TieneMenuCel,CalifFinal);

**Usuario**(<u>IDU</u>, Nombre, Apellido, Edad, Email, Passwd, NroTelefono, esCeliaco, tokenFacebook);

**Califico**(<u>IDU</u>,<u>IDR</u>, CalidadServicio, Atencion, Precio, Higiene);

**Ciudad**(<u>CP</u>, Nombre, Poblacion, PoblacionCeliacos);

**estaUbicado**(<u>IDR</u>,<u>CP</u>,<u>Puesto</u>);

**viveEn**(<u>IDU</u>, <u>CP</u>);



### Aclaraciones

1. **TokenFacebook:** este valor se obtiene al loguearse con Auth0 (autenticación por facebook)
2. **Ubiacion:** latitud y longitud (según como lo almacene GoogleMaps)
3. etc, etc



## Diagramas de Secuencia

### Búsqueda de Restaurantes para Celíacos cerca de la ubicación del Usuario.

```mermaid
sequenceDiagram
participant Usuario
participant App
participant DB
Usuario->>App: consultaRestaurantesCerca()
App->>App: consultaCP(Ubicaci贸nActual):CP
App->>DB: solListaRestaurantesCerca(CP)
DB->>DB: filtrarXCP(CP): lista[RID,Ubicacion]
alt hayRestaurantesCeliacos
DB-->>App: retornaListaRestaurants():lista[RID,Ubicacion]
App->>App: filtroXUbicacion(lista[RID,Ubicacion]):lista[RID]
App->>DB: solicitarRestaurantes(lista[RID])
DB-->>App: respuesta():lista[RID,Nombre,direcci贸n,Calificacion]
App-->>Usuario: infoRestaurantesCerca()
else noHayRestaurantesCeliacos
DB-->>App: retornaListaRestaurants():[lista vacia]
App-->>Usuario: mensajeAviso()
end
```



