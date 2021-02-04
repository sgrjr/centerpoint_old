import React from 'react'
import Button from '@material-ui/core/Button'
import ChevronRightIcon from '@material-ui/icons/ChevronRight'
import DeleteIcon from '@material-ui/icons/Delete'
import Typography from '@material-ui/core/Typography'
import { makeStyles } from '@material-ui/core/styles'

const useStyles = makeStyles({
  footer: {
    display: 'grid',
    gridTemplateColumns: '1fr auto',
    gridGap: '8px',
    padding: '8px 24px',
    alignItems: 'center'
  },
  incentive: {
    gridColumn: 'span 2',
    fontSize: '.8rem',
    textAlign: 'right'
  },
  total: {
    fontSize: '1rem'
  }
})

let incentiveText = (quantity, goal) => {
  if (quantity < goal) {
    return `Add ${goal - quantity} more books to get free shipping!`
  } else {
    return 'You qualify for free shipping!'
  }
}

function CartItem(props) {
	const classes = useStyles()
  return (
    <footer className={classes.footer}>
      <Button
        variant="contained"
        color="secondary"
        endIcon={<DeleteIcon />}
        onClick={()=>{
          props.deleteCart({REMOTEADDR:props.cart.REMOTEADDR})
        }}
      >delete cart</Button>
      <Typography className={classes.total}>Cart total: <strong>${props.price.toFixed(2)}</strong></Typography>
      <Button
        variant="contained"
        color="primary"
        endIcon={<ChevronRightIcon />}
        disabled={props.quantity > 0 ? false : true}
        onClick={()=>{props.history.push('/cart/' + props.cart.REMOTEADDR) }}
      >Check out</Button>
      <Typography className={classes.incentive}>{incentiveText(props.quantity, 5)}</Typography>
    </footer>
  )
}

export default CartItem