import { post, del, get } from './api_helper';
export const authLoginUser = (userData) => post('/sign_in', userData);
export const authLogoutUser = () => del('/sign_out');
export const googleLoginUser = (accessToken) =>
  get('web_google_signin', {
    params: accessToken
  });
