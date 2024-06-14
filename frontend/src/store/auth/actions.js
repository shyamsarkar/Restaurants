import {
  LOGIN_USER,
  LOGIN_USER_SUCCESS,
  LOGOUT_USER,
  LOGOUT_USER_SUCCESS,
  API_ERROR,
} from './actionTypes';

export const loginUser = (user, navigate) => {
  return {
    type: LOGIN_USER,
    payload: { user, navigate }
  };
};

export const loginUserSuccess = (user) => {
  return {
    type: LOGIN_USER_SUCCESS,
    payload: user
  };
};

export const logoutUser = (navigate) => {
  return {
    type: LOGOUT_USER,
    payload: { navigate }
  };
};

export const logoutUserSuccess = () => {
  return {
    type: LOGOUT_USER_SUCCESS,
    payload: {}
  };
};


export const apiError = (error) => {
  return {
    type: API_ERROR,
    payload: error
  };
};
