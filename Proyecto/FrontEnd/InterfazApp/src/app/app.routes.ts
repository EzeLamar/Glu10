import { RouterModule, Routes } from '@angular/router';
import { AboutComponent } from './components/about/about.component';
import { RestaurantesComponent } from './components/restaurantes/restaurantes.component';
import { CalificacionComponent } from './components/calificacion/calificacion.component';
import { LoginComponent } from './components/login/login.component';
import { InfoRestauranteComponent } from './components/info-restaurante/info-restaurante.component';
import { PageErrorComponent } from './components/page-error/page-error.component';

import { AuthGuardService } from './services/auth-guard.service';

const APP_ROUTES: Routes = [
     { path: 'login', component: LoginComponent },
     { path: 'mapa', component:  RestaurantesComponent, canActivate: [ AuthGuardService ] },
     { path: 'about', component:  AboutComponent },
     { path: 'restaurante/:id/info', component:  InfoRestauranteComponent, canActivate: [ AuthGuardService ] },
     { path: 'restaurante/:id/calificar', component:  CalificacionComponent, canActivate: [ AuthGuardService ] },
     { path: 'error', component: PageErrorComponent },
     { path: '**', pathMatch: 'full', redirectTo: 'login' }
];

export const APP_ROUTING = RouterModule.forRoot(APP_ROUTES);
