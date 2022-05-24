import React from 'react';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import CartSingle from './CartSingle'
import { Link } from "react-router-dom";
import CircularProgress from '@material-ui/core/CircularProgress';
import AddIcon from '@material-ui/icons/Add'

export default function MyCartList(props) {

  const {authenticated, history, carts, cartSave, cartCheckout, simple, cart, url, createCart, deleteFromCart, deleteCart, updateTitleQuantity, updateCartForm} = props

  const [expanded, setExpanded] = React.useState(undefined);

  let items = null

  if(simple){

    if(carts.length < 1){
      items = ()=> { return "..loading"}
    }else{
      items = ()=>{
        return carts.map(function(crt,i){
          return (<Grid item key={crt.INDEXs} xs={12} style={{margin:"15px 0 15px 0"}}>
        <Button style={{width:"100%"}} color="primary" variant="outlined" onClick={(e)=>{return props.selectCart(crt.REMOTEADDR)}}>add to this cart {crt.REMOTEADDR} - {crt.PO_NUMBER} - (#{crt.details.length} items)</Button>
              </Grid>)
        })
      }
    }

  }else{
   items = ()=>{
      return carts.map(function(crt,i){
        return (<CartSingle 
          key={i} 
          index={i}
          cart={crt} 
          expanded={expanded} 
          setExpanded={setExpanded}
          deleteCart={deleteCart}
          deleteFromCart={deleteFromCart}
          updateTitleQuantity={updateTitleQuantity}
          updateCartForm={updateCartForm}
          cartSave={cartSave}
          cartCheckout={cartCheckout}
          history={history}
          />)
      })
    }
  }

  if(cart.pending){
    return <Button disabled variant="outlined" style={{width:"100%"}}><CircularProgress color="primary"/>loading cart ...</Button>
  }else if(authenticated){
      return (<><Button onClick={createCart} endIcon={<AddIcon />}>Create New Cart</Button> {items()}</>)
  }else{
    return <Button variant="outlined" style={{width:"100%"}}><Link style={{width:"100%"}} to={"/login?return="+url}>Login to Order</Link></Button>
  }

}
