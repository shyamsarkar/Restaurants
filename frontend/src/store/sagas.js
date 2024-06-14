import { fork } from 'redux-saga/effects';
import AuthSaga from './auth/saga';

export default function* rootSaga() {
  yield fork(AuthSaga);
}
