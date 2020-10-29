import React from 'react'
import Checkout from './Checkout'
import CheckoutSuccess from './CheckoutSuccess'
import Container from '@material-ui/core/Container'
import './Index.css'
import invoiceQuery from './invoiceQuery'
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import { withRouter } from "react-router";

class Index extends React.Component {

    componentDidMount(){
        this.load()
    }
 
    load(){
     this.props.invoiceGet(invoiceQuery({perPage:20, filters:{REMOTEADDR: this.props.match.params.cartid}}))
    }

  componentDidUpdate(nextProps) {
    if(nextProps.match.params.cartid !== this.props.cart.checkout.remoteaddr){
      this.load()
    }else if(nextProps.cart.checkout.ISCOMPLETE !== this.props.cart.checkout.ISCOMPLETE){
      this.load()
    }
    return nextProps;
  }
  
  render(){

    const complete = () => {return this.props.cart.checkout.data.ISCOMPLETE}

    return (
      <React.Fragment>
        <Container maxWidth="md">

          {!complete() &&
            <Checkout {...this.props} data={this.props.cart.checkout.data} />
          }
          {complete() &&
            <CheckoutSuccess {...this.props} data={this.props.cart.checkout.data}/>
          }

        </Container>
      </React.Fragment>
    )
  }
}

Index.propTypes = {
  carts: PropTypes.array
};

const mapStateToProps = (state)=>{
return {
  cart: state.cart
   }
}

const mapDispatchToProps = dispatch => {
  return {
    invoiceGet: (query) => {
      dispatch(actions.cart.INVOICE_GET.creator(query))
    },
    setIsCompleted:(cart) => {
      dispatch(actions.cart.CART_CHECKOUT.creator(cart))
    },
    updateCheckout: (e)=>{
      dispatch(actions.cart.CHECKOUT_UPDATE.creator(e))
    },
    cartSave: (cartId)=>{
      dispatch(actions.cart.CART_SAVE.creator(cartId))
    }
  }
}

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Index))
