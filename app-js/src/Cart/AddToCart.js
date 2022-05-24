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
      if(this.props.carts.length < 1 && this.props.authenticated){
        this.props.cartGet(cartQuery({perPage:20}))
      }
    }

    componentWillReceiveProps(newProps){
      if(newProps.post && newProps.post !== this.props.post){
        this.sendTitleToCart(newProps);
      }
    }
    sendTitleToCart(props){

      const query = {
        query: `mutation($REMOTEADDR: String!, $ISBN: String!, $QTY: Int!) {
        addtocart(REMOTEADDR: $REMOTEADDR, ISBN: $ISBN, QTY: $QTY){
            user{
              vendor {
                carts{
                  INDEX
                  KEY
                  DATE
                  PO_NUMBER
                  TRANSNO
                  REMOTEADDR
                  details{
                    INDEX
                    PROD_NO
                    TITLE
                    REQUESTED
                    SALEPRICE
                    defaultImage
                  }
                }
              }
            }
          }
      }`,
    variables: {
      REMOTEADDR: props.selectedCart,
      ISBN: props.selectedTitle,
      QTY: props.selectedQuantity
    }
  };

      this.props.addTitleToCart(query);
    }

    selectTitle(){
      if(this.props.carts.length < 1){
        this.props.cartGet(cartQuery({perPage:20}))
      }
      this.props.selectTitle(this.props.title.ISBN)
    }

    render(){ 
      const {authenticated, open, carts, cart, toggleSimpleCarts, title } = this.props
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
          <Button variant="outlined" style={{width:"100%"}} onClick={this.selectTitle.bind(this)} type="button" >Add to Cart</Button>

          <Dialog open={open} onBackdropClick={toggleSimpleCarts}>
            <Button variant="outlined" onClick={toggleSimpleCarts}>X 
            <Typography variant="h1" style={{fontSize:"2rem", textAlign:"center"}}>My Open Carts</Typography>
            <Typography variant="p" >Select the cart below to which you want to add this title. Or, create a new cart.</Typography>
            <img src={title.defaultImage} style={{width:"100px"}} />
            </Button>
            
            <CartList carts={carts} simple={true} {...this.props}/> 
          </Dialog>
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
    selectedCart: PropTypes.string,
    selectedTitle: PropTypes.string,
    selectedQuantity: PropTypes.number
  };

const mapStateToProps = (state)=>{
return {
  authenticated: state.viewer.user.authenticated,
    cart: state.cart,
    carts: state.cart.carts,
    selectedCart: state.cart.selectedCart,
    selectedTitle:state.cart.selectedTitle,
    selectedQuantity:state.cart.selectedQuantity,
    open: state.cart.open,
    post: state.cart.post
     }
}

const mapDispatchToProps = dispatch => {
    return {
      selectCart: (cart) => {
        dispatch(actions.cart.SELECT_CART.creator(cart))
      },
      selectTitle: (title) => {
        dispatch(actions.cart.SELECT_TITLE.creator(title))
      },
      selectTitleQuantity: (qty) => {
        dispatch(actions.cart.SELECT_TITLE_QUANTITY.creator(qty))
      },
      addTitleToCart: (query) => {
        dispatch(actions.cart.POST_TITLE_TO_CART.creator(query))
      },
      cartGet: (query) => {
        dispatch(actions.cart.CART_GET.creator(query))
      },
      toggleSimpleCarts: (query) => {
        dispatch(actions.cart.TOGGLE_SIMPLE_CART.creator(query))
      },
    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(AddToCart)