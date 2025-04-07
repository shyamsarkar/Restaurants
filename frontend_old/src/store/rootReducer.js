// src/store/rootReducer.js
import { combineReducers } from 'redux';
import example from './exampleSlice'; // Import your slice reducer
import sideBar from './layout/sideBarReducer';
import authReducer from './auth/reducer'

const rootReducer = combineReducers({
  example,
  sideBar,
  authReducer,
});

export default rootReducer;
