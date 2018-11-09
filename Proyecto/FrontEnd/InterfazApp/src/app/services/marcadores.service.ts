//servicio
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
//comunicacion Server
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
//clase importada
import { Marcador } from "../classes/marcador.class";
//para detectar distancias entre marcadores
import { MapsAPILoader } from '@agm/core';
declare var google;



@Injectable({
  providedIn: 'root'
})
export class MarcadoresService {
  //192.168.1.104
  // ipServerPHP =  "192.168.1.104";
  // baseUrl ="http://"+this.ipServerPHP+"/MIPROYECTO/api";
  baseUrl = "https://localhost:3002"    //<--------- json-server
  marcadoresServer: Marcador[]=[];
  marcadoresRadioPosicion: Marcador[]=[];
  

  RadioMaximo = 3000; 

  constructor(  private http: HttpClient ,
                private mapsAPILoader: MapsAPILoader ) { }
                
  //solicito al servidor que me conteste con lo que haga api/list
  public getAll(): Observable<Marcador[]> {
    return this.http.get(`${this.baseUrl}/read`).pipe(
      map((res) => {
        this.marcadoresServer = res['records'];
        console.log(this.marcadoresServer);
        return this.marcadoresServer;
    }),
    catchError(this.handleError));
  }

  public setMarcadoresCerca(latActual:number, lnActual: number) {
    
    
      const center = new google.maps.LatLng(latActual,lnActual);
      //markers located within 50 km distance from center are included
      this.marcadoresRadioPosicion = this.marcadoresServer.filter(m => {
        const markerLoc = new google.maps.LatLng(m.latitud, m.longitud);
        const  distanceInMts = google.maps.geometry.spherical.computeDistanceBetween(markerLoc, center);
        if (distanceInMts <= this.RadioMaximo) {
          return m;
        }
      });
      console.log("marcadores cerca");
      console.log(this.marcadoresRadioPosicion);
  }
    
  private handleError(error: HttpErrorResponse) {
    console.log(error);
    // return an observable with a user friendly message
    return throwError('Error! something went wrong.');
  }
  
}


