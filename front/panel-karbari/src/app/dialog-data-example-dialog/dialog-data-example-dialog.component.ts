import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA } from '@angular/material';
import { DialogData } from '../toolbar/toolbar.component';

@Component({
  selector: 'app-dialog-data-example-dialog',
  templateUrl: './dialog-data-example-dialog.component.html',
  styleUrls: ['./dialog-data-example-dialog.component.scss']
})
export class DialogDataExampleDialogComponent {

  constructor(@Inject(MAT_DIALOG_DATA) public data: DialogData) { }



}
