import {MatButtonModule, MatCheckboxModule} from '@angular/material';
import { NgModule } from '@angular/core';
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatProgressBarModule} from '@angular/material/progress-bar';
import { CommonModule } from '@angular/common';
import {MatCardModule} from '@angular/material/card';

@NgModule({
  imports: [CommonModule,
            MatButtonModule, 
            MatCheckboxModule, 
            MatToolbarModule,
            MatProgressBarModule,
            MatCardModule
          ],
  exports: [MatButtonModule, 
            MatCheckboxModule, 
            MatToolbarModule,
            MatProgressBarModule,
            MatCardModule
          ],
})
export class MaterialModule {

}