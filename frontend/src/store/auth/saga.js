
import { call, put, takeEvery } from 'redux-saga/effects';
import { LOGIN_USER, LOGOUT_USER } from './actionTypes';
import { apiError, loginUserSuccess, logoutUserSuccess } from './actions';
import { authLoginUser, authLogoutUser } from '../../helpers/auth_helpers';


function* loginUser({ payload: { user, navigate } }) {
  try {
    const response = yield call(authLoginUser, {
      email: user.email,
      password: user.password
    });
    yield put(loginUserSuccess(response));
    navigate('/dashboard');
  } catch (error) {
    yield put(apiError(error));
  }
}

function* logoutUser({ payload: { navigate } }) {
  try {
    const response = yield call(authLogoutUser);

    yield put(logoutUserSuccess(response));
    navigate('/');
  } catch (error) {
    yield put(apiError(error));
  }
}


function* authSaga() {
  yield takeEvery(LOGIN_USER, loginUser);
  yield takeEvery(LOGOUT_USER, logoutUser);
}

export default authSaga;
