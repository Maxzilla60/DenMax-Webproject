import { createStore } from 'redux';

import LayoutReducer from '../layout.reducer';

const store = createStore(LayoutReducer, window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__());
export default store;
