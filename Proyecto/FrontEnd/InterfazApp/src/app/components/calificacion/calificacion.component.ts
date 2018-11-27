import { Component, OnInit } from '@angular/core';
import { MarcadoresService } from '../../services/marcadores.service';
import { ActivatedRoute } from '@angular/router';
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

  constructor( private router: Router,
    private marcadoresService: MarcadoresService,
               private activatedRoute: ActivatedRoute ) {
    this.activatedRoute.params.subscribe( params => {
      this.idActual = Number(params.id);
    });
  }

  ngOnInit() {}

  // para ruteos
  moverseACalificar(id: number) {
    this.router.navigate(['/restaurante', id, 'calificar']);
  }
  moverseAMapa() {
    this.router.navigate(['/mapa']);
  }

  calificar() {
    //console.log(this.selectedcalidad);
    // valores entre 0-5 (reales)
    let votacion = {
      IDR: this.idActual,     // lo tomamos de la ruta o path
      id: 1,                  // id del usuario
      calidad: this.selectedcalidad,
      velocidad: this.selectedvelocidad,
      precio: this.selectedprecio,
      limpieza : this.selectedlimpieza
    };
    this.enviarCalificacion( votacion );

  }

  public enviarCalificacion( votacion ) {
    this.marcadoresService.calificar( votacion ).subscribe(
      ( res: string ) => {
          // muestra la salida generada por el backend
          console.log(res);
      },
      ( err ) => {
          console.log(err);  // VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia.
      }
    );

  }

}
