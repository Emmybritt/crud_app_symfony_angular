export type UsersType = {
  id: number;
  name: string;
  surname: string;
  dateOfBirth?: string;
  gender: string;
  status: 'low' | 'high';
  action: string;
};
