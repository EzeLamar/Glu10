import { Component, OnInit, ViewChild } from '@angular/core';
// sidenav
import {MatSidenav} from '@angular/material/sidenav';
import { Router } from '@angular/router';
// Servicio Autenticacion
import { AuthService } from '../../services/auth.service';
@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.css']
})
export class ToolbarComponent implements OnInit {

  @ViewChild('sidenav') sidenav: MatSidenav;

  perfil: any;

  constructor( private router: Router, private auth0: AuthService ) {
    auth0.handleAuthentication();
  }


  ngOnInit() {
    this.auth0.userChange$.subscribe(userProfile => this.perfil = userProfile);
    // if (this.auth0.userProfile) {
    //   this.profile = this.auth0.userProfile;
    // } else {
    //   this.auth0.getProfile((err, profile) => {
    //     this.profile = profile;
    //   });
    // }
  }
  // For auth service purpose
  login() {
    this.auth0.login();
  }
  logout() {
    this.auth0.logout();
    this.router.navigate(['/login']);
  }
  // For the menu
  close() {
    this.sidenav.close();
  }
  open() {
    this.sidenav.open();
  }

  moverseAMap() {
    this.sidenav.close();
    this.router.navigate(['/mapa']);
  }

  moverseAAbout() {
    this.sidenav.close();
    this.router.navigate(['/about']);
  }
}

