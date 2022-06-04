import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import CartList from './CartList'
import q from '../makeQuery'

class Cart extends Component{

    componentDidMount(){
        if(this.props.carts.length <= 0 ){

         const query = q(`query ($cartsLimit:Int!){
        viewer {
          vendor {
            carts (first:$cartsLimit){
                paginatorInfo{
                    ...PaginatorInfoFragment
                }
                data{
                    ...OrderFragment
                    items{
                       ...OrderItemFragment
                    }
                }
                
              }
            }
          }
        }`, // query string
        ['paginator','order','orderItem'], // fragments
        {"cartsLimit":20} // variables // variables
        )

          this.props.cartGet(query)
        }
    }

    render(){      

      const { cartId, cart, carts, classes } = this.props; 

        return (<React.Fragment>
            <CartList 
            carts={carts.data} 
            cartId={cartId}
            cart={cart}
            {...this.props}
            /> 
            </React.Fragment>    
        )
      }
  
    }    

Cart.propTypes = {
    carts: PropTypes.object
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

export default connect(mapStateToProps, mapDispatchToProps)(Cart)