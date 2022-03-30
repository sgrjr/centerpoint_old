import React from 'react';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import CartSingle from './CartSingle'
import { Link } from "react-router-dom";
import CircularProgress from '@material-ui/core/CircularProgress';
import IconPicker from '../components/IconPicker';

export default function CartList(props) {

  const {history, viewer, cartSave, cartCheckout, cart, createCart, deleteFromCart, deleteCart, selectCart, updateTitleQuantity, updateCartForm, carts} = props

  let items = null

   items = ()=>{

    if(!carts){
      return <Button disabled variant="outlined" style={{width:"100%"}}><CircularProgress color="primary"/>loading cart ...</Button>
    }else if(carts.data.length > 0){
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

    }else{

      let crt = {
        REMOTEADDR: false,
        items: []
      }

      return (<CartSingle 
          index={false}
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
    }
    
  }

  if(cart.pending){
    return <Button disabled variant="outlined" style={{width:"100%"}}><CircularProgress color="primary"/>loading cart ...</Button>
  }else{
      return (<><Button fullWidth={true} onClick={createCart} endIcon={<IconPicker icon="add" />}>Create New Cart</Button> {items()}</>)
  }

}
