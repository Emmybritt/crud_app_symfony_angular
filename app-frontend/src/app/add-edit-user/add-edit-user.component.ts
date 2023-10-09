import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { UserService } from '../services/user.service';
import { CoreService } from '../core/core.service';

@Component({
  selector: 'app-add-edit-user',
  templateUrl: './add-edit-user.component.html',
  styleUrls: ['./add-edit-user.component.css'],
})
export class AddEditUserComponent implements OnInit {
  userForm: FormGroup;
  genders: { name: string; value: string }[] = [
    { name: 'Male', value: 'male' },
    { name: 'Female', value: 'female' },
    { name: 'Other', value: 'other' },
  ];

  status: { name: string; value: string }[] = [
    { name: 'Low', value: 'low' },
    { name: 'High', value: 'high' },
  ];

  constructor(
    private _fb: FormBuilder,
    private userService: UserService,
    private _dialogRef: MatDialogRef<AddEditUserComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private coreService: CoreService
  ) {
    this.userForm = this._fb.group({
      name: '',
      surname: '',
      gender: '',
      status: '',
      dateOfBirth: '',
    });
  }

  ngOnInit(): void {
    this.userForm.patchValue(this.data);
  }

  onFormSubmit() {
    if (this.userForm.valid) {
      if (this.data) {
        this.userService
          .updateUser(this.data.id, this.userForm.value)
          .subscribe({
            next: (val: any) => {
              this.coreService.openSnackBar('User updated successfully');
              this._dialogRef.close(true);
            },
            error: console.log,
          });
      } else {
        this.userService.createUser(this.userForm.value).subscribe({
          next: (val: any) => {
            this.userService.getUserList();
            this.coreService.openSnackBar('User created successfully');
            this._dialogRef.close(true);
          },
          error: (err) => {
            this.coreService.openSnackBar(err.error.message);
          },
        });
      }
    }
  }
}
