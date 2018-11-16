import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-calificacion',
  templateUrl: './calificacion.component.html',
  styleUrls: ['./calificacion.component.css']
})
export class CalificacionComponent implements OnInit {


  constructor() {
    }

  ngOnInit() {}

  calificar() {
    Int servicio= request.getParameter("servicio");
    Int velocidad= request.getParameter("velocidad");
    Int precio= request.getParameter("precio");
    Int servicio= request.getParameter("limpieza");
    Int calificado=(servicio+velocidad+precio+servicio)/4;
    console.log(calificado);
  }
}
