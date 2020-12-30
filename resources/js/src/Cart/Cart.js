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

      const { cart, carts, classes } = this.props; 

        return (<React.Fragment>
            <CartList 
            carts={carts.data} 
            cart={cart} 
            url={this.props.match.url}
            {...this.props}
            className={classes.root}
            /> 
            </React.Fragment>    
        )
      }
  
    }    

Cart.propTypes = {
    carts: PropTypes.object,
    theme: PropTypes.object.isRequired,
    classes: PropTypes.object.isRequired
  };

const mapStateToProps = (state)=>{
return {
    cart: state.viewer.cart,
    carts: state.viewer.vendor.carts,
    cartscount: state.viewer.vendor?state.viewer.vendor.cartsCount:0,
    form: state.forms.title,
    cartFocus: state.viewer.cart.cart
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