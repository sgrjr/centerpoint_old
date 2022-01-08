if (module.hot)
  module.hot.accept()

import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
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

const spacing = 15;

const theme = createTheme({
 spacing: spacing,
  typography: {
    useNextVariants: true,
    fontSize:18,
    // Tell Material-UI what's the font-size on the html element is.
    htmlFontSize: 18,
    h3: {
      marginBottom:spacing*2,
      marginTop: spacing*2
    }
  },
  //https://material-ui.com/api/app-bar/#css-api
  overrides:{    
    MuiImageListTileBar : {
      root: {
        background:"inherit",
        color:"inherit"
      },
      title: {
        color:"inherit",
        fontSize: ".7rem"
      },
      titleWrap: {
        color:"inherit"
      },
      subtitle:{
        fontSize: ".7rem"
      }
    },

    MuiIconButton: {
      root: {
        background:"inherit",
        color:"inherit"
      }
    },

    MuiImageList : {
      root : {
        padding: 1.5*spacing,
        '&.titles-list-root': {
          flexWrap: 'nowrap',
          backgroundColor:"rgb(46, 46, 46)",
          color:"white",
        },
        '&.titles-list-root-scroll': {
          flexWrap: 'wrap',
          backgroundColor:"white",
          color:"black",
          overflowY:"visible",
          '&> .view-more-button':{
            display:"none"
          }
        },
        '&> *': {
          margin: spacing,
        }
      }
    },

    MuiImageListItem : {
      root: {
        width:"auto",
        height:"auto"
      },
      tile: {
        overflow:"unset",
        height:"340px"
      },

  },

  MuiGrid : {
    root: {
      '&.titles': {
        display: 'flex',
        justifyContent: 'space-around',
        flexWrap: 'wrap',
        padding: spacing,
        textAlign: "left"
      },
      '&.search-results': {
        borderBottom: "1px dotted #CCC", 
        marginBottom: spacing, 
        paddingBottom: spacing
      },
      '&.title-page': {
        justifyContent: "space-around",
        margin:"auto",
        '& h3': {
          textAlign:"center",
          marginBottom:"30px"
        }
      },
      '&.pending': {
        position: "fixed",
        bottom:"15px"
      },
      '&.view-more-button button': {
        height: "230px",
        fontWeight:900,
        border: "solid 5px white",
        color:"white",
        paddingTop:0,
        '&:hover':{
          color:"black",
          borderColor:"black"
        },
        '&:active':{
          backgroundColor:"white"
        }
      }

    }
  },

  MuiListItemText : {
    root: {
        flex: 1,
        margin:0
    }
  },

  MuiPaper :{
    // Name of the styleSheet
    root: {
      // Name of the 
      
      //Stylized book cover image to look like it has a binder START
      '&.book-cover':{
        width:"173.5px",
        height:"289px",
        boxShadow: "2px 2px 5px rgba(0, 0, 0, 0.3)",
        marginLeft: "auto",
        marginRight: "auto",
        backgroundSize: "cover",

        '& .book-cover-effect': {
          content: "",
          height: "289px",
          width: "25px",
          display: "inline-block",
          background: "linear-gradient(to right, rgba(255, 255, 255, 0.6) 0%, rgba(60, 60, 60, 0.25) 30%, rgba(60, 60, 60, 0.3) 45%, rgba(255, 255, 255, 0.3) 55%, rgba(255, 255, 255, 0.3) 60%, rgba(255, 255, 255, 0) 100%);",
        },
// 5.78 / 3.47 H/W x's 100 for large and x's 50 for original
        '&.book-cover-art-large':{
          height: "578px",
          width: "347px",
        },
        '& .book-cover-effect.book-cover-effect-large':{
          height: "578px",
          width: "65px"
        },

      },
      //Stylized book cover image to look like it has a binder END
    },

},
}
});

const rootReducer = combineReducers({
    admin: adminReducer,
    application: applicationReducer,
    notification: notificationReducer,
    titles: titlesReducer,
    viewer: viewerReducer,
    forms: formsReducer
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
