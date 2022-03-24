import React from 'react'
import Accordion from '@material-ui/core/Accordion';
import AccordionSummary from '@material-ui/core/AccordionSummary'
import AccordionDetails from '@material-ui/core/AccordionDetails'
import IconPicker from '../components/IconPicker';
import List from '@material-ui/core/List'
import ListItem from '@material-ui/core/ListItem'
import CartItem from './CartItem'
import CartFooter from './CartFooter'
import Divider from '@material-ui/core/Divider'
import CartHeader from './CartHeader'
import Badge from '@material-ui/core/Badge'

function tradeTitleShipping(titles){
  let getsTradeTitleShipping = false

   for(const title of titles) {
      if(title.INVNATURE && title.INVNATURE.includes("CENT")){getsTradeTitleShipping = false; break;}
      if(title.INVNATURE && title.INVNATURE.includes("TRADE")){getsTradeTitleShipping = true}
   }

  return getsTradeTitleShipping
}

function CartSingle(props) {
  const {cart, deleteCart, deleteFromCart, cartSave, history, updateTitleQuantity, cartCheckout, selectCart} = props

  const id = cart.REMOTEADDR

  const handleChange = panel => (event) => {
    props.selectCart(props.cart.REMOTEADDR);
  }
  const getTotals = (array) => {

    let totals = {
      price: 0,
      quantity: 0
    }
    array.forEach((item, index) => { 
      totals.price = totals.price + (item.SALEPRICE * item.REQUESTED)
      totals.quantity = totals.quantity + item.REQUESTED
    })
    return totals
  }
  let list

  if (cart.items.length === 0) {
    list = <ListItem>No items</ListItem>
  } else {
    list = cart.items.map((item, index) => {
      if(item.INDEX) {return (<CartItem key={ index } titleIndex={ index } cartIndex={ props.index } {...item} cartSave={cartSave} deleteFromCart={deleteFromCart} cartId={cart.REMOTEADDR} updateTitleQuantity={updateTitleQuantity}/>)}
    })
  }

  const totals = getTotals(cart.items)

  return (
    <React.Fragment>
    	<Accordion expanded={props.expanded} onChange={handleChange(id)}>
      
        <AccordionSummary
          expandIcon={<IconPicker icon="expand" />}
          aria-controls="panel1a-content"
          id="panel1a-header"
          style={{backgroundColor:"rgba(0, 0, 0, 0.12)"}}
        >
          
          <Badge anchorOrigin={{horizontal:'left', vertical:'top'}} badgeContent={totals.quantity} color="primary">
            <CartHeader index={props.index} cart={cart} cartSave={cartSave} updateCartForm={props.updateCartForm}/>
            </Badge>

        </AccordionSummary>

        <AccordionDetails>
          <List>
            {list}
          </List>
        </AccordionDetails>
        <Divider variant="middle" />
        <CartFooter {...totals} cart={cart} deleteCart={deleteCart} history={history} cartCheckout={cartCheckout} tradeTitleShipping={tradeTitleShipping(cart.items)}/>
      </Accordion>
    </React.Fragment>
  )
}

export default CartSingle