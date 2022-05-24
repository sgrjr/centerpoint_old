import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import CartList from './CartList'
import { withTheme, withStyles } from '@material-ui/core/styles';
import cartQuery from './cartQuery'
import { withRouter } from "react-router";

import './Cart.css';

const styles = {
  root:{}
};

class Cart extends Component{

    componentDidMount(){
        if(this.props.carts.length <= 0 ){
          this.props.cartGet(cartQuery({perPage:20}))
        }
    }

    render(){      

      const { authenticated, cart, carts, classes } = this.props; 

        return (<React.Fragment>
            <CartList 
            carts={carts} 
            cart={cart} 
            authenticated={authenticated} 
            url={this.props.match.url}
            {...this.props}
            className={classes.root}
            />   
            </React.Fragment>    
        )
      }
  
    }    

Cart.propTypes = {
    carts: PropTypes.array,
    theme: PropTypes.object.isRequired,
    classes: PropTypes.object.isRequired
  };

const mapStateToProps = (state)=>{
return {
    cart: state.cart,
    carts: state.cart.carts,
    cartscount: state.viewer.user.cartscount,
    authenticated: state.viewer.user.authenticated,
    form: state.forms.title,
    cartFocus: state.cart.cart
     }
}

const mapDispatchToProps = dispatch => {
    return {
      cartGet: (query) => {
        dispatch(actions.cart.CART_GET.creator(query))
      },
      deleteFromCart: (cartId, titleId)=>{
        dispatch(actions.cart.CART_DELETE_TITLE.creator(cartId, titleId))
      },
      createCart: ()=>{
        dispatch(actions.cart.CART_CREATE.creator())
      },
      deleteCart: (cartId)=>{
        dispatch(actions.cart.CART_DELETE.creator(cartId))
      },
      updateTitleQuantity: (cartIndex, titleIndex, cartId, titleId, quantity)=>{
        dispatch(actions.cart.CART_UPDATE_TITLE_QUANTITY.creator(cartIndex, titleIndex, cartId, titleId, quantity))
      }, 
      updateCartForm: (index, key, value)=>{
        dispatch(actions.cart.CART_UPDATE_FORM.creator(index, key, value))
      }, 
      cartCheckout: (cartIndex)=>{
        dispatch(actions.cart.CART_CHECKOUT.creator(cartIndex))
      }, 
      cartSave: (cartId)=>{
        dispatch(actions.cart.CART_SAVE.creator(cartId))
      }
    }
  }

export default withRouter(withTheme(connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Cart))))