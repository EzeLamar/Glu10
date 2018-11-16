import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { MapsComponent } from './components/maps/maps.component';

// mapas
import { AgmCoreModule } from '@agm/core';

// Animacion
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

// MaterialDesign
import { MaterialModule } from './material.module';


// Formularios
import { MapaEditarComponent } from './components/maps/mapa-editar.component';
import { ReactiveFormsModule } from '@angular/forms';

//comunicación con el Servidor PHP
import { HttpClientModule } from '@angular/common/http';
import { HttpModule } from '@angular/http';

//servicios
import { AuthService } from './services/auth.service';
import { AuthGuardService } from './services/auth-guard.service';
import { LoginComponent } from './components/login/login.component';

//rutas
import { APP_ROUTING } from './app.routes';
import { FooterComponent } from './components/footer/footer.component';
import { ToolbarComponent } from './components/toolbar/toolbar.component';
import { CalificacionComponent } from './components/calificacion/calificacion.component';
import { RestauranteComponent } from './components/restaurante/restaurante.component';
import { AboutComponent } from './components/about/about.component';
import { RestaurantesComponent } from './components/restaurantes/restaurantes.component';
import { StarRatingComponent } from './components/star-rating/star-rating.component';
import { InfoRestauranteComponent } from './components/info-restaurante/info-restaurante.component';

@NgModule({
  entryComponents: [
    MapaEditarComponent
  ],
  declarations: [
    AppComponent,
    MapsComponent,
    MapaEditarComponent,
    LoginComponent,
    FooterComponent,
    ToolbarComponent,
    CalificacionComponent,
    RestauranteComponent,
    AboutComponent,
    RestaurantesComponent,
    StarRatingComponent,
    InfoRestauranteComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
  //  MatSelectModule,
    APP_ROUTING,
    MaterialModule,
    ReactiveFormsModule,
    HttpClientModule,
    HttpModule,
    AgmCoreModule.forRoot({
      apiKey: 'AIzaSyA-HXVa2jtkGfKtIJwisxgC46RaWqC1xuI',
      libraries: [ 'geometry' ]
    })
  ],
  providers: [
    AuthService,
    AuthGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
