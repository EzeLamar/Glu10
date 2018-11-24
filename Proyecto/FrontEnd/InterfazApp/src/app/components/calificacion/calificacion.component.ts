import { Component, OnInit } from '@angular/core';
import { MarcadoresService } from "../../services/marcadores.service";
import { ActivatedRoute } from "@angular/router";

@Component({
  selector: 'app-calificacion',
  templateUrl: './calificacion.component.html',
  styleUrls: ['./calificacion.component.css']
})
export class CalificacionComponent implements OnInit {


  idActual: number;

  constructor( private marcadoresService: MarcadoresService, 
               private activatedRoute: ActivatedRoute ) {
    this.activatedRoute.params.subscribe( params =>{
      this.idActual = Number(params.id);
    });
  }

  ngOnInit() {}

  calificar() {
    // Int servicio= request.getParameter("servicio");
    // Int velocidad= request.getParameter("velocidad");
    // Int precio= request.getParameter("precio");
    // Int servicio= request.getParameter("limpieza");
    // Int calificado=(servicio+velocidad+precio+servicio)/4;
    // console.log(calificado);

    //valores entre 0-5 (reales)
    let votacion = {
      id: this.idActual,     //lo tomamos de la ruta o path
      calidad: 5,
      velocidad: 3,
      precio: 2.5,
      limpieza : 5
    };
    this.enviarCalificacion( votacion );

  }

  public enviarCalificacion( votacion ){
    this.marcadoresService.calificar( votacion ).subscribe(
      ( res: string ) => {
          //muestra la salida generada por el backend
          console.log(res);
      },
      ( err ) => {
          console.log(err)   // VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia. 
      }
    );
  }
}
