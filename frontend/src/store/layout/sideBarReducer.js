import { SHOW_MENU, HIDE_MENU, EXPAND_MENU, COLLAPSE_MENU } from './actionTypes';

const initialState = {
  hideSidebar: false,
  expandSidebar: true,
};

const sideBar = (state = initialState, action) => {
  switch (action.type) {
    case SHOW_MENU:
      return {
        ...state,
        hideSidebar: false
      };
    case HIDE_MENU:
      return {
        ...state,
        hideSidebar: true
      };
    case EXPAND_MENU:
      return {
        ...state,
        expandSidebar: true
      };
    case COLLAPSE_MENU:
      return {
        ...state,
        expandSidebar: false
      };
    default:
      return state;
  }
};

export default sideBar;
