import { Component, OnInit } from '@angular/core';
import { MarcadoresService } from '../../services/marcadores.service';
import { ActivatedRoute } from '@angular/router';
import {MatSnackBar} from '@angular/material';
// Para Ruteo
import { Router } from '@angular/router';

@Component({
  selector: 'app-calificacion',
  templateUrl: './calificacion.component.html',
  styleUrls: ['./calificacion.component.css']
})
export class CalificacionComponent implements OnInit {

  selectedcalidad: number;
  selectedvelocidad: number;
  selectedprecio: number;
  selectedlimpieza: number;
  idActual: number;
  id: number;

  constructor( private router: Router,
               private marcadoresService: MarcadoresService,
               private snackBar: MatSnackBar,
               private activatedRoute: ActivatedRoute ) {
    this.activatedRoute.params.subscribe( params => {
      this.idActual = Number(params.id);
    });
  }

  ngOnInit() {}

  // para ruteos
  moverseAMapa() {
    this.router.navigate(['/mapa']);
  }

  calificar() {
    //console.log(this.selectedcalidad);
    // valores entre 0-5 (reales)
    let votacion = {
      IDR: Number(this.idActual),     // lo tomamos de la ruta o path
      id: 1,                  // id del usuario
      calidad: Number(this.selectedcalidad),
      velocidad: Number(this.selectedvelocidad),
      precio: Number(this.selectedprecio),
      limpieza : Number(this.selectedlimpieza)
    };
    this.enviarCalificacion( votacion );

  }

  public enviarCalificacion( votacion ) {
    this.marcadoresService.calificar( votacion ).subscribe(
      ( res: string ) => {
          // muestra la salida generada por el backend
          console.log(res);
          this.snackBar.open('Calificación Enviada!', 'Cerrar', { duration: 1000 });
          this.router.navigate(['/mapa']);
      },
      ( err ) => {
          console.log(err);  // VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia.
      }
    );

  }

}

interface respuesta {
  message: string
};