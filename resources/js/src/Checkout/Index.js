import React from 'react'
import Checkout from './Checkout'
import CheckoutSuccess from './CheckoutSuccess'
import Container from '@mui/material/Container';
import './Index.css'
import invoiceQuery from './invoiceQuery'
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';

import { useLocation, useNavigate, useParams } from "react-router-dom";

export function withRouter( Child ) {
  return ( props ) => {
    const location = useLocation();
    const navigate = useNavigate();
    const params = useParams();
    return <Child { ...props } navigate={ navigate } params={params} location={ location } />;
  }
}

class Index extends React.Component {

    componentDidMount(){
        this.load()
    }
 
    load(){
      const {cartid, invoiceid } = this.props.params

      if(cartid !== undefined){
        this.props.invoiceGet(invoiceQuery({REMOTEADDR: cartid}))
      }else if(invoiceid !== undefined){
        this.props.invoiceGet(invoiceQuery({TRANSNO: invoiceid}))
      }
     
    }

  componentDidUpdate(nextProps) {
    if(nextProps.params.cartid && nextProps.params.cartid !== this.props.cart.checkout.remoteaddr){
      this.load()
    }else if(nextProps.params.innvoiceid && nextProps.params.invoiceid !== this.props.cart.checkout.remoteaddr){
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
    cart: state.viewer.cart
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
      dispatch(actions.cart.CART_UPDATE.creator(cartId))
    }
  }
}

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(Index))
