import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import {Button, Typography} from '@material-ui/core';
import CircularProgress from '@material-ui/core/CircularProgress';
import Dialog from '@material-ui/core/Dialog';
import cartQuery from './cartQuery'
import addTitleToCartQuery from '../Cart/addTitleToCartQuery'
import { Link } from "react-router-dom";

import styles from "../styles"

class AddToCart extends Component{

    componentDidMount(){

      if(this.props.viewer.KEY){
        if(!this.props.viewer.vendor || this.props.viewer.vendor.carts === undefined){
          this.props.cartGet(cartQuery({first:20}))
        }else if(this.props.authenticated && !this.props.viewer || this.props.viewer.vendor.carts.length < 1){
          this.props.cartGet(cartQuery({first:20}))
        }
      }
    }

    componentDidUpdate(prevProps, prevState, snapshot){
      if(this.props.viewer.KEY && this.props.post && prevProps.post !== this.props.post){
        this.sendTitleToCart();
      }
    }
    sendTitleToCart(){
      this.props.addTitleToCart(addTitleToCartQuery({
        REMOTEADDR: this.props.selectedCart,
        ISBN: this.props.title.ISBN,
        QTY: this.props.selectedQuantity
      }));
    }


    render(){ 
      const {authenticated, open, viewer, cart, toggleSimpleCarts, title } = this.props

      if(title === undefined || title.STATUS === undefined || title.STATUS === null){
        return null
      }
      
      const status = title.STATUS.toLowerCase().split(" ")

      if(status.includes('out') && status.includes('of') && status.includes('print')){
        return <button className="outlined outline-disabled">Out of Print!</button>
      }

      if(authenticated){
        if(!viewer.vendor){
          return <div/>
        }else if(cart.pending || cart.addToCartPending){
          return <Button disabled variant="outlined" style={{width:"100%"}}><CircularProgress color="primary"/>updating cart ...</Button>
        }else if(title.STATUS !== "Out of Print"){
          return (<div>
          <button className={styles.addToCartButton} onClick={this.sendTitleToCart.bind(this)} >Add to Cart</button>
         </div>)
       }
      }else{
        return <Button variant="outlined" style={{width:"90%", margin:"25px"}}><Link style={{width:"100%"}} to={"/login?return="+this.props.url}>Login to Order</Link></Button>;
      }
  
    }     
}    

AddToCart.propTypes = {
    title: PropTypes.object,
    carts: PropTypes.array,
    open: PropTypes.bool,
    selectedQuantity: PropTypes.number
  };

const mapStateToProps = (state)=>{
return {
    authenticated: state.viewer && !state.viewer.pending && state.viewer.KEY? true:false,
    cart: state.viewer.cart,
    viewer: state.viewer,
    selectedCart: state.viewer && !state.viewer.pending && state.viewer.cart? state.viewer.cart.selectedCart:false,
    selectedQuantity: state.viewer && state.viewer.cart? state.viewer.cart.selectedQuantity:false,
    open: state.viewer && !state.viewer.pending && state.viewer.cart? state.viewer.cart.open:false,
    post: state.viewer && !state.viewer.pending && state.viewer.cart? state.viewer.cart.post:false
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