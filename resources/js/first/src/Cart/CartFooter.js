import React from 'react'
import Button from '../components/Button';
import MuiLink from '@mui/material/Link'
import Typography from '@mui/material/Typography';
import IconPicker from '../components/IconPicker';
import { Link } from 'react-router-dom';

const classes = {
  footer:"cart-footer",
  incentive:"incentive",
  total:"total"
}

let incentiveText = (quantity, goal, tradeTitleShipping) => {
  if (quantity >= goal || tradeTitleShipping) {
    return 'You qualify for free shipping!'
  } else {
    return `Add ${goal - quantity} more books to get free shipping!`
  }
}

class CartItem extends React.Component {

  render(){

  const props = this.props   
  const linkStyle = {
    width:"100%",
    height:"100%",
    color:"inherit"
  } 
let deleteButton = null

if(props.cart.id){
  deleteButton = (<Button
        endIcon={<IconPicker icon="delete" />}
        onClick={()=>{
          if(props.cart.id) props.deleteCart({id:props.cart.id})
        }}
        color="error"
        variant="outlined"
        id="delete-cart"
      >delete cart</Button>)
}
  return (
    <footer className={classes.footer}>

      { //Check if Any titles are in Cart
       (props.quantity > 0  && !props.review)
       ? <Button onClick={(e)=>{
        props.closeDrawer()
         props.navigate('/dashboard/cart/' + props.cart.REMOTEADDR)
       }} variant="contained" color="primary" endIcon={<IconPicker icon="shoppingCartCheckout" />} >Checkout</Button>
       :null
      }
      <Typography className={classes.total}>Cart total: <strong>${props.price.toFixed(2)}</strong></Typography>
      
      {deleteButton}

      <Typography className={classes.incentive}>{incentiveText(props.quantity, 5, props.tradeTitleShipping)}</Typography>
      
    </footer>
  )
}

}

export default CartItem;