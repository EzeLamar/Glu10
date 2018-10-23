import {MatButtonModule, MatCheckboxModule} from '@angular/material';
import { NgModule } from '@angular/core';
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatProgressBarModule} from '@angular/material/progress-bar';
import { CommonModule } from '@angular/common';
import {MatCardModule} from '@angular/material/card';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {MatDialogModule} from '@angular/material/dialog';
import {MatInputModule} from '@angular/material/input';
import {MatSidenavModule} from '@angular/material/sidenav';
import {MatIconModule} from '@angular/material/icon';

@NgModule({
  imports: [CommonModule,
            MatButtonModule,
            MatCheckboxModule,
            MatToolbarModule,
            MatProgressBarModule,
            MatCardModule,
            MatSnackBarModule,
            MatDialogModule,
            MatInputModule,
            MatSidenavModule,
            MatIconModule
          ],
  exports: [MatButtonModule,
            MatCheckboxModule,
            MatToolbarModule,
            MatProgressBarModule,
            MatCardModule,
            MatSnackBarModule,
            MatDialogModule,
            MatInputModule,
            MatSidenavModule,
            MatIconModule
          ],
})
export class MaterialModule {

}
