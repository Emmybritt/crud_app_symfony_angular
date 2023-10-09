import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  constructor(private _http: HttpClient) {}

  createUser(data: any): Observable<any> {
    return this._http.post('http://localhost:8000/user/create', data);
  }
  updateUser(id: number, data: any): Observable<any> {
    return this._http.put(`http://localhost:8000/user/update/${id}`, data);
  }

  getUserList(): Observable<any> {
    return this._http.get('http://localhost:8000/users');
  }

  deleteUser(id: number | string): Observable<any> {
    return this._http.delete(`http://localhost:8000/user/delete/${id}`);
  }
}
