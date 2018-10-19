import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';

//serivcio importado
import { MarcadoresService } from "../../services/marcadores.service";


@Component({
  selector: 'app-maps',
  templateUrl: './maps.component.html',
  styleUrls: ['./maps.component.css']
})
export class MapsComponent implements OnInit {

  //para pruebas
  lat: number = -38.71536909404415;
  lng: number = -62.26685779187005;

  //atributos de la clase
  marcadores: Marcador[] = [];
  error = 'todo bien';

  constructor( private marcadorService: MarcadoresService ) { 
    // if(localStorage.getItem('marcadores')){  //si existe
    //   this.marcadores = JSON.parse( localStorage.getItem('marcadores') );
    // } 
    // else{
    //   const nuevoMarcador = new Marcador(this.lat,this.lng );
    //   this.marcadores.push(nuevoMarcador);
    // }
  }

  ngOnInit() {
    console.log(this.error);
    this.obtenerMarcadoresServer();
    console.log(this.error);
    //this.obtenerPrueba();
  }

  agregarMarcador( evento ){
    const coords: { lat: number, lng: number } = evento.coords;

    console.log("lat:"+coords.lat+", long:"+coords.lng);
    const nuevoMarcador = new Marcador(coords.lat, coords.lng);
    nuevoMarcador.nombre = "Hola";
    nuevoMarcador.descripcion= "este es un lugar copado";
    this.marcadores.push(nuevoMarcador);
    
    //this.guardaMarcadores();

  }

  guardaMarcadores(){
    localStorage.setItem('marcadores',JSON.stringify(this.marcadores));
  }

  obtenerMarcadoresServer(): void{
    this.marcadorService.getAll().subscribe(
      ( res: Marcador[] ) => {
        this.marcadores = res;
      },
      ( err ) => {
        this.error= err;   //VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia. 
      }
    );
  }

  obtenerPrueba(): void{
    this.marcadorService.getPrueba().subscribe(
      ( res: string ) => {
        console.log("Component:"+res);
      },
      ( err ) => {
        this.error= err;   //VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia. 
      }
    );
  }
}
