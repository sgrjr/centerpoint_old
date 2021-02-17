import React from 'react';
import PropTypes from 'prop-types'
import './App.scss';
import NavBar from './components/NavBar'
import Footer from './components/Footer'
import Signin from './Auth/Signin'
import Logout from './Auth/Logout'
import AppAlerts from './AppAlerts'
import Dashboard from './Dashboard/Dashboard'
import ProductStore from './ProductStore/ProductStore'
import Cart from './Cart/Cart'
import CartCheckout from './Checkout/Index'
import Admin from './Admin/Index'
import { Provider } from 'react-redux';
import SearchPage from './ProductStore/SearchPage'
import TitlePage from './ProductStore/TitlePage'
import {withStyles, withTheme} from '@material-ui/core/styles'
import {
  BrowserRouter as Router,
  Switch,
  Route
} from "react-router-dom";

const styles = {
  root: {}
}

class App extends React.Component {
  render(){

    const {classes} = this.props
    return (
      
      <Provider store={this.props.store}>
        
        <Router>
    <div id="MainApp" className={classes.root}>
      <NavBar {...this.props}/>
    
      <Switch>
          <Route path="/" exact={true}>
            <ProductStore />
          </Route>  
          <Route path="/dashboard">
            <Dashboard/>
          </Route>
          <Route path="/login">
            <Signin/>
          </Route>
          <Route path="/logout">
            <Logout/>
          </Route>
          <Route path="/cart" exact={true}>
            <Cart />
          </Route>
          <Route path="/cart/:cartid">
            <CartCheckout />
          </Route>

          <Route path="/invoice/:invoiceid">
            <CartCheckout />
          </Route>

          <Route path="/search/:search/:filter">
            <SearchPage />
          </Route>
          <Route path="/isbn/:isbn">
            <TitlePage />
          </Route>
          
          <Route path="/cms">
            <Admin/>
          </Route>

        </Switch>
        <AppAlerts {...this.props}/>
     
    <Footer />
    </div>
      </Router>
      
      </Provider>

  );
}

}

App.propTypes = {
  store: PropTypes.object.isRequired,
  theme: PropTypes.object.isRequired,
  classes: PropTypes.object.isRequired
}

export default withTheme(withStyles(styles)(App))