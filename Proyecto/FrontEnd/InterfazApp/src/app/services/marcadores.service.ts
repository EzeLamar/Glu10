//servicio
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
//comunicacion Server
import { HttpHeaders, HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
//clase importada
import { Marcador } from "../classes/marcador.class";
//para detectar distancias entre marcadores
import { MapsAPILoader } from '@agm/core';
declare var google;



@Injectable({
  providedIn: 'root'
})
export class MarcadoresService {
  //conexion remota 
  // ipServerPHP =  "192.168.1.102";
  // baseUrl ="https://"+this.ipServerPHP+"/MIPROYECTO/api_proye";
  
  //conexion local json-server
  baseUrl = "https://localhost:3003";

  marcadoresServer: Marcador[]=[];
  marcadoresRadioPosicion: Marcador[]=[];
  latActual= 0;
  lngActual = 0;
  

  

  RadioMaximo = 1500; 

  constructor(  private http: HttpClient ,
                private mapsAPILoader: MapsAPILoader ) { }
                
  //solicito al servidor que me conteste con lo que haga api/list
  public getAll(): Observable<Marcador[]> {
    return this.http.get(`${this.baseUrl}/restaurant/read.php`).pipe(
      map((res) => {
        this.marcadoresServer = res['records'];
        console.log(this.marcadoresServer);
        return this.marcadoresServer;
    }),
    catchError(this.handleError));
  }

  public setMarcadoresCerca(): Marcador[] {
      const center = new google.maps.LatLng(this.latActual,this.lngActual);
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
      return this.marcadoresRadioPosicion;
  }

  public setUbicacionActual(latActual: number, lngActual: number) {
    this.latActual = latActual;
    this.lngActual = lngActual;
  }

  public obtenerMayorIDR(): number{
    let mayor= 0;
    for(let i=0; i<this.marcadoresServer.length; i++){
      let idActual = this.marcadoresServer[i].id;
      if(idActual>mayor)
        mayor = idActual;
    }
    return mayor;
  }
    
  private handleError(error: HttpErrorResponse) {
    console.log(error);
    // return an observable with a user friendly message
    return throwError('Error! something went wrong.');
  }

  //POST
    addMarcador (nuevoMarcador: Marcador): Observable<string> {
      const httpOptions = {
        headers: new HttpHeaders({
          'Content-Type':  'application/json'
          // ,'Authorization': 'my-auth-token'
        })
      };
      console.log(nuevoMarcador);
      return this.http.post<string>(this.baseUrl+"/restaurant/create.php", nuevoMarcador, httpOptions)
        .pipe(
          catchError(this.handleError)
        );
    }
    //buscar el marcador en marcadoresServer y retorna su posición actual.
    //Retorna -1 si no lo encuentra
    private buscarMarcador(id:number): number {
      let encontre = false;
      let pos=0;
      for( pos=0; (pos<this.marcadoresServer.length)&&(!encontre); pos++ )
        if( this.marcadoresServer[pos].id === id )
          encontre = true;
      if(!encontre)
        pos=-1;
      return pos;
    }

    public removeMarcador(idMarcador: number):Observable<string>{

      const httpOptions = {
        headers: new HttpHeaders({
          'Content-Type':  'application/json'
          // ,'Authorization': 'my-auth-token'
        })
      };

      let idAEliminar = {
        id: idMarcador
      };
      console.log("entre al removeMarcador!!");
      return this.http.post<string>(this.baseUrl+"/restaurant/remove.php", idAEliminar, httpOptions)
        .pipe(
          catchError(this.handleError)
        );
    }

    updateMarcador (camposModificados): Observable<string> {

      const httpOptions = {
        headers: new HttpHeaders({
          'Content-Type':  'application/json'
          // ,'Authorization': 'my-auth-token'
        })
      };

      return this.http.post<string>(this.baseUrl+"/restaurant/update.php", camposModificados, httpOptions)
        .pipe(
          catchError(this.handleError)
        );
    }
  
}


