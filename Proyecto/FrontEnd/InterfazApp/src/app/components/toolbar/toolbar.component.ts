import { Component, OnInit, ViewChild } from '@angular/core';
// sidenav
import {MatSidenav} from '@angular/material/sidenav';

@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.css']
})
export class ToolbarComponent implements OnInit {

  @ViewChild('sidenav') sidenav: MatSidenav;

  constructor() { }

  ngOnInit() {
  }
  close() {
    this.sidenav.close();
  }
  open() {
    this.sidenav.open();
  }
}