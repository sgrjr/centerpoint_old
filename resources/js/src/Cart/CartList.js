import React from 'react';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import CartSingle from './CartSingle'
import { Link } from "react-router-dom";
import CircularProgress from '@material-ui/core/CircularProgress';
import AddIcon from '@material-ui/icons/Add'

export default function CartList(props) {

  const {history, viewer, cartSave, cartCheckout, cart, url, createCart, deleteFromCart, deleteCart, selectCart, updateTitleQuantity, updateCartForm, carts} = props

  let items = null

   items = ()=>{

    if(!carts){
      return <Button disabled variant="outlined" style={{width:"100%"}}><CircularProgress color="primary"/>loading cart ...</Button>
    }else{


      return carts.data.map(function(crt,i){

        return (<CartSingle 
          key={i} 
          index={i}
          cart={crt} 
          expanded={crt.REMOTEADDR === cart.selectedCart} 
          deleteCart={deleteCart}
          deleteFromCart={deleteFromCart}
          updateTitleQuantity={updateTitleQuantity}
          updateCartForm={updateCartForm}
          cartSave={cartSave}
          cartCheckout={cartCheckout}
          history={history}
          selectCart={props.selectCart}
          />)
      })

    }
    
  }

  if(cart.pending){
    return <Button disabled variant="outlined" style={{width:"100%"}}><CircularProgress color="primary"/>loading cart ...</Button>
  }else{
      return (<><Button fullWidth={true} onClick={createCart} endIcon={<AddIcon />}>Create New Cart</Button> {items()}</>)
  }

}
