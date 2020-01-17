import { Component, OnInit } from '@angular/core';
import {MatDialog, MAT_DIALOG_DATA, MAT_DIALOG_SCROLL_STRATEGY_PROVIDER_FACTORY} from '@angular/material/dialog';
import { DialogDataExampleDialogComponent } from '../dialog-data-example-dialog/dialog-data-example-dialog.component';

export interface DialogData {
  animal: 'panda' | 'unicorn' | 'lion';
}
@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.scss']
})
export class ToolbarComponent  {


  constructor(public dialog: MatDialog) { }

  openDialog() {


   const dialogRef = this.dialog.open(DialogDataExampleDialogComponent, {
      data: {
        animal: 'panda'
      }
    });

   dialogRef.afterClosed().subscribe(result => {
      console.log(`Dialog result: ${result}`);
    });
  }
  }




