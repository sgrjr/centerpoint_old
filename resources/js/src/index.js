if (module.hot)
  module.hot.accept()

import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
//import * as serviceWorker from './serviceWorker';
import { createStore, combineReducers, applyMiddleware } from 'redux';
import { createLogger } from 'redux-logger'
import thunkMiddleware from 'redux-thunk'
import { ThemeProvider, createTheme } from '@material-ui/core/styles';
import adminReducer from './reducers/adminReducer';
import applicationReducer from './reducers/applicationReducer';
import titlesReducer from './reducers/titlesReducer';
import notificationReducer from './reducers/notificationReducer';
import viewerReducer from './reducers/viewerReducer';
import formsReducer from './reducers/formsReducer';
import chatsReducer from './reducers/chatsReducer';
import 'lazysizes';

const theme = createTheme();

const rootReducer = combineReducers({
    admin: adminReducer,
    application: applicationReducer,
    notification: notificationReducer,
    titles: titlesReducer,
    viewer: viewerReducer,
    forms: formsReducer,
    chat: chatsReducer
  });

const loggerMiddleware = createLogger()

const store = createStore(
  rootReducer,
  applyMiddleware(
    thunkMiddleware, // lets us dispatch() functions
    loggerMiddleware // neat middleware that logs actions
  )
)

ReactDOM.render(<ThemeProvider theme={theme}><App store={store} /></ThemeProvider>, document.getElementById('app'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
//serviceWorker.unregister();
