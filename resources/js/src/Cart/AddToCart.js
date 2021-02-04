import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import {Button, Typography} from '@material-ui/core';
import CircularProgress from '@material-ui/core/CircularProgress';
import Dialog from '@material-ui/core/Dialog';
import CartList from './CartList';
import cartQuery from './cartQuery'
import { Link } from "react-router-dom";

class AddToCart extends Component{

    componentDidMount(){
      if(this.props.viewer.vendor.carts === undefined){
        this.props.cartGet(cartQuery({perPage:20}))
      }else if(this.props.viewer.vendor.carts.length < 1 && this.props.authenticated){
        this.props.cartGet(cartQuery({perPage:20}))
      }
    }

    componentWillReceiveProps(newProps){
      if(newProps.post && newProps.post !== this.props.post){
        this.sendTitleToCart();
      }
    }
    sendTitleToCart(){

      const query = {
        query: `mutation($REMOTEADDR: String!, $ISBN: String!, $QTY: Int!) {
        createCartTitle(REMOTEADDR: $REMOTEADDR, PROD_NO: $ISBN, REQUESTED: $QTY){
          user{
              vendor {
                carts(first:100){
                  paginatorInfo{
                    total
                    count
                  }
                  data{
                    INDEX
                    KEY
                    DATE
                    PO_NUMBER
                    TRANSNO
                    REMOTEADDR
                    items{
                      id
                      INDEX
                      PROD_NO
                      TITLE
                      REQUESTED
                      SALEPRICE
                      coverArt
                    }
                  }
                }
              
            }
          }
        }
      }`,
    variables: {
      REMOTEADDR: this.props.selectedCart,
      ISBN: this.props.title.ISBN,
      QTY: this.props.selectedQuantity
    }
  };

      this.props.addTitleToCart(query);
    }


    render(){ 
      const {authenticated, open, viewer, cart, toggleSimpleCarts, title } = this.props

      if(title === undefined || title.STATUS === undefined || title.STATUS === null){
        return null
      }
      
      const status = title.STATUS.toLowerCase().split(" ")

      if(status.includes('out') && status.includes('of') && status.includes('print')){
        return null
      }

        if(cart.pending){
          return <Button disabled variant="outlined" style={{width:"100%"}}><CircularProgress color="primary"/>loading cart ...</Button>
        }else if(authenticated && title.STATUS !== "Out of Print"){
          return (<div>
          <Button variant="outlined" style={{width:"100%"}} onClick={this.sendTitleToCart.bind(this)} type="button" >Add to Cart</Button>
         </div>)
      }else{
        return <Button variant="outlined" style={{width:"100%"}}><Link style={{width:"100%"}} to={"/login?return="+this.props.url}>Login to Order</Link></Button>;
      }
  
    }     
}    

AddToCart.propTypes = {
    viewerPending: PropTypes.bool,
    title: PropTypes.object,
    carts: PropTypes.array,
    open: PropTypes.bool,
    selectedQuantity: PropTypes.number
  };

const mapStateToProps = (state)=>{
return {
    authenticated: state.viewer.KEY? true:false,
    cart: state.viewer.cart,
    viewer: state.viewer,
    selectedCart: state.viewer.cart.selectedCart,
    selectedQuantity:state.viewer.cart.selectedQuantity,
    open: state.viewer.cart.open,
    post: state.viewer.cart.post
     }
}

const mapDispatchToProps = dispatch => {
    return {
      addTitleToCart: (query) => {
        dispatch(actions.cart.POST_TITLE_TO_CART.creator(query))
      },
      cartGet: (query) => {
        dispatch(actions.cart.CART_GET.creator(query))
      }
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(AddToCart)