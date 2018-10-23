//servicio
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
//comunicacion Server
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
//clase importada
import { Marcador } from "../classes/marcador.class";


@Injectable({
  providedIn: 'root'
})
export class MarcadoresService {
  //192.168.1.104
  ipServerPHP =  "192.168.1.104";
  baseUrl ="http://"+this.ipServerPHP+"/MIPROYECTO/api";
  marcadoresServer: Marcador[];
  holaMundo: string;

  constructor( private http: HttpClient ) { }
                
  //solicito al servidor que me conteste con lo que haga api/list
  public getAll(): Observable<Marcador[]> {
    return this.http.get(`${this.baseUrl}_proye/restaurant/read.php`).pipe(
      map((res) => {
        this.marcadoresServer = res['records'];
        return this.marcadoresServer;
    }),
    catchError(this.handleError));
  }

  //solicito al servidor que me conteste con lo que haga api/list
  public getPrueba(): Observable<string> {
    return this.http.get(this.baseUrl+"/holamundo.php").pipe(
      map((res) => {
        this.holaMundo = res['data'];
        console.log("service:"+this.holaMundo);
        return this.holaMundo;
    }),
    catchError(this.handleError));
  }
    
  private handleError(error: HttpErrorResponse) {
    console.log(error);
    // return an observable with a user friendly message
    return throwError('Error! something went wrong.');
  }
  
}


