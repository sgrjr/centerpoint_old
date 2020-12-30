import React from 'react'
import Accordion from '@material-ui/core/Accordion';
import AccordionSummary from '@material-ui/core/AccordionSummary'
import AccordionDetails from '@material-ui/core/AccordionDetails'
import ExpandMoreIcon from '@material-ui/icons/ExpandMore'
import List from '@material-ui/core/List'
import ListItem from '@material-ui/core/ListItem'
import CartItem from './CartItem'
import CartFooter from './CartFooter'
import Divider from '@material-ui/core/Divider'
import CartHeader from './CartHeader'
import Badge from '@material-ui/core/Badge'

function CartSingle(props) {
  const {cart, deleteCart, deleteFromCart, cartSave, history, updateTitleQuantity, cartCheckout} = props

  const id = 'panel' + cart.INDEX
  const handleChange = panel => (event, newExpanded) => {
    props.setExpanded(newExpanded ? panel : false)
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
      return (<CartItem key={ index } titleIndex={ index } cartIndex={ props.index } {...item} cartSave={cartSave} deleteFromCart={deleteFromCart} cartId={cart.REMOTEADDR} updateTitleQuantity={updateTitleQuantity}/>)
    })
  }

  const totals = getTotals(cart.items)

  return (
    <React.Fragment>
    	<Accordion expanded={props.expanded === id} onChange={handleChange(id)}>
      
        <AccordionSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel1a-content"
          id="panel1a-header"
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
        <CartFooter {...totals} cart={cart} deleteCart={deleteCart} history={history} cartCheckout={cartCheckout}/>
      </Accordion>
    </React.Fragment>
  )
}

export default CartSingle