import { LOGIN_USER, LOGIN_USER_SUCCESS, LOGOUT_USER, LOGOUT_USER_SUCCESS, API_ERROR } from './actionTypes';

const initialState = {
  error: '',
  isAuthenticated: false,
  authUser: {}
};

const login = (state = initialState, action) => {
  switch (action.type) {
    case LOGIN_USER:
      return {
        ...state
      };
    case LOGIN_USER_SUCCESS:

      return {
        ...state,
        authUser: {
          ...action.payload.user,
        },
        isAuthenticated: true,
        error: ''
      };
    case LOGOUT_USER:
      return {
        ...state,
        authUser: {},
        isAuthenticated: false
      };
    case LOGOUT_USER_SUCCESS:
      return {
        ...state,
        authUser: {},
        isAuthenticated: false
      };
    case API_ERROR:
      return { ...state, error: action.payload?.response?.data?.message };
    default:
      return state;
  }
};

export default login;
