import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import CartList from './CartList'
import { withTheme, withStyles } from '@material-ui/core/styles';
import cartQuery from './cartQuery'
import './Cart.css';

const styles = {
  root:{}
};

class Cart extends Component{

    componentDidMount(){
        if(this.props.carts.length <= 0 ){
          this.props.cartGet(cartQuery({first:20}))
        }
    }

    render(){      

      const { cart, carts, classes } = this.props; 

        return (<React.Fragment>
            <CartList 
            carts={carts.data} 
            cart={cart}
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
    carts: state.viewer.vendor? state.viewer.vendor.carts:{data:[]},
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
      deleteFromCart: (vars)=>{
        dispatch(actions.cart.CART_DELETE_TITLE.creator(vars))
      },
      createCart: ()=>{
        dispatch(actions.cart.CART_CREATE.creator())
      },
      deleteCart: (variables)=>{
        dispatch(actions.cart.CART_DELETE.creator(variables))
      },
      updateTitleQuantity: (attributes)=>{
        dispatch(actions.cart.CART_UPDATE_TITLE.creator(attributes))
      }, 
      updateCartForm: (index, key, value)=>{
        dispatch(actions.cart.CART_UPDATE_FORM.creator(index, key, value))
      }, 
      cartCheckout: (cartIndex)=>{
        dispatch(actions.cart.CART_CHECKOUT.creator(cartIndex))
      }, 
      cartSave: (cartId)=>{
        dispatch(actions.cart.CART_UPDATE.creator(cartId))
      }, 
      selectCart: (cartId)=>{
        dispatch(actions.cart.CART_SELECT.creator(cartId))
      }
    }
  }

export default withTheme(connect(mapStateToProps, mapDispatchToProps)(withStyles(styles)(Cart)))