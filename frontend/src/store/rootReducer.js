// src/store/rootReducer.js
import { combineReducers } from 'redux';
import example from './exampleSlice'; // Import your slice reducer
import sideBar from './layout/sideBarReducer';

const rootReducer = combineReducers({
  example,
  sideBar,
});

export default rootReducer;
