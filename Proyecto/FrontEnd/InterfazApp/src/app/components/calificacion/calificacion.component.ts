import { Component, OnInit } from '@angular/core';
import { MatSelectModule } from '@angular/material/select';

export interface Food {
  value: string;
  viewValue: string;
}

@Component({
  selector: 'app-calificacion',
  templateUrl: './calificacion.component.html',
  styleUrls: ['./calificacion.component.css']
})
export class CalificacionComponent implements OnInit {

    foods: Food[] = [
      {value: 'steak-0', viewValue: 'Steak'},
      {value: 'pizza-1', viewValue: 'Pizza'},
      {value: 'tacos-2', viewValue: 'Tacos'}
    ];

  ngOnInit() {
  }

}



