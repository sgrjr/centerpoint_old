import React from 'react';
import PropTypes from 'prop-types'
import './App.scss';
import NavBar from './components/NavBar'
import Footer from './components/Footer'
import Signin from './Auth/Signin'
import Logout from './Auth/Logout'
import AppAlerts from './AppAlerts'
import Dashboard from './Dashboard/Dashboard'
import DashboardMain from './Dashboard/Main'
import AdminUsers from './Dashboard/AdminUsers'
import AdminUser from './Dashboard/AdminUser'
import AdminTitles from './Dashboard/AdminTitles'

import ProductStore from './ProductStore/ProductStore'
import Cart from './Cart/Cart'
import CartCheckout from './Checkout/Index'
import { Provider } from 'react-redux';
import SearchPage from './ProductStore/SearchPage'
import SearchResults from './ProductStore/SearchPage'
import TitlePage from './ProductStore/TitlePage'
import Promotions from './ProductStore/PromotionsPage'
import {withStyles, withTheme} from '@material-ui/core/styles'
import {
  BrowserRouter as Router,
  Route, Routes
} from "react-router-dom";

const styles = {
  root: {}
}

class App extends React.Component {
  render(){

    const {classes} = this.props
    const generalNavigationBar = <NavBar {...this.props} mainClass=""/>
    const minimalNavigationBar = <NavBar {...this.props} mainClass="minimal-navigation"/>
    
    return (
      
      <Provider store={this.props.store}>
        
        <Router>
    <div id="MainApp" className={classes.root}>
      
        <Routes>
          <Route path="/" exact={true} element={<ProductStore navigation={generalNavigationBar}/>}/> 
          <Route path="/promotions" element={<Promotions navigation={generalNavigationBar}/>}/>
          <Route path="/dashboard" element={<Dashboard navigation={minimalNavigationBar}/>} >
            <Route path="" element={<DashboardMain/>}/>
            <Route path="admin/users" element={<AdminUsers/>}/>
            <Route path="admin/users/:userid" element={<AdminUser/>}/>
             <Route path="admin/titles" element={<AdminTitles/>}/>

            <Route path="cart" exact={true} element={<Cart  navigation={generalNavigationBar}/>}/>
            <Route path="cart/:cartid" element={<CartCheckout navigation={generalNavigationBar}/>}/>
            <Route path="invoice/:invoiceid" element={<CartCheckout navigation={generalNavigationBar}/>}/>

          </Route>

          <Route path="/login" element={<Signin  navigation={generalNavigationBar}/>}/>
          <Route path="/logout" element={<Logout/>}/>
         
          <Route path="/search" element={<SearchPage  navigation={generalNavigationBar}/>}>
            <Route path=":search/:filter" element={<SearchResults navigation={generalNavigationBar}/>}/>
          </Route>
          <Route path="/isbn/:isbn" element={<TitlePage navigation={generalNavigationBar}/>}/>

          <Route path="*" element={<SearchPage navigation={generalNavigationBar}/>}/>

        </Routes>
      
      <AppAlerts/>
     
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